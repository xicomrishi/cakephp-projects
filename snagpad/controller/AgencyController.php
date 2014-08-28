<?php
App::import('Vendor', array('functions', 'xtcpdf'));
App::import('Controller', array('Users','Coach'));

//App::import('Vendor','uploadclass');

class AgencyController extends UsersController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session', 'Upload');
    public $uses = array('Client', 'Coach', 'Account', 'Agency','Agencycard', 'Card','Employer');
	public $paginate;

    public function beforeFilter() {		
        parent::beforeFilter();
        if (!$this->Session->check('Account.id')) {
            $this->redirect(SITE_URL);
            exit();
        }
        $this->layout = 'jsb_bg';		
    }

    public function change_pass() {
        if ($this->request->is('ajax')) {
            if (!empty($this->data)) {
                //echo '<pre>';print_r($this->data);die;
                $old_password = md5($this->data['Account']['old_password']);
                $user = $this->Account->findById($this->Session->read('Account.id'));
                if ($user['Account']['password'] != $old_password) {
                    echo 'Old password does not match! Please try again.';
                    $this->autoRender = false;
                } else {
                    $new_password = md5($this->data['Account']['new_password']);
                    $this->Account->id = $user['Account']['id'];
                    $this->Account->saveField('password', $new_password);
                    echo 'Password has been updated';
                    $Mail = new MailController;
                    $Mail->constructClasses();
                    $Mail->sendMail($user['Account']['id'], "change_password", array('PASSWORD' => $this->data['Account']['new_password']));
                    $this->autoRender = false;
                }
            }
        }
		die;
    }

    public function search() {
        $this->layout = 'ajax';		
        if (isset($this->data['cbox'])) {
            $del_id = implode(",", $this->data['cbox']);
            $this->deleteClient($del_id);
        }
        if (isset($this->data['release']) && $this->data['release'] != '') {
            $this->Client->query("update jsb_client set coach_id='0' where id='" . $this->data['release'] . "'");
        }
        if ($this->Session->read('usertype') == '1'){		
            $agency_id = $this->Session->read('Account.id');
	        $conditions['Client.agency_id'] = $agency_id;
		}
        else
            $conditions=array();

        if (count($this->request->data) == 0)
            $this->request->data = $this->passedArgs;
        if (isset($this->data['keyword']) && trim($this->data['keyword']) != '')
          {  $conditions['OR']['Client.name like '] = "%" . $this->data['keyword'] . "%";
		  	$conditions['OR']['Client.email like '] = "%" . $this->data['keyword'] . "%";
		  }
        if (isset($this->data['coach_id']) && $this->data['coach_id'] != '')
            $conditions['Client.coach_id'] = $this->data['coach_id'];

        $this->paginate = array(
            'conditions' => $conditions,
            'joins' => array(
                array(
                    'alias' => 'U',
                    'table' => 'accounts',
                    'type' => 'INNER',
                    'conditions' => '`U`.`id` = `Client`.`account_id`'
                ),
                array(
                    'alias' => 'C',
                    'table' => 'coach',
                    'type' => 'LEFT',
                    'conditions' => '`Client`.`coach_id` = `C`.`account_id`'
                )
            ),
            'fields' => array('Client.*', 'C.name', 'find_in_set(3,U.activate) as active'),
            'limit' => 10,
            'group' => 'Client.id',
            'order' => array(
                'Client.id' => 'desc'
            )
        );
        $clients = $this->paginate('Client');
        $this->set('clients', $clients);
        $this->render('results');
    }

    public function index($num=null) {

        if (!empty($this->data)) {
            $this->layout = 'ajax';
        }
        $this->set('num', $num);
    }

    public function show_add() {
        $this->layout = 'ajax';
        $id = $this->data['id'];
        if ($id != 0) {
            $row = $this->Client->findById($id);
            $this->set('row', $row);
        }
        $this->render('edit');
    }

    public function show_search() {
		if($this->Session->read('usertype')=='1')
		$arr = $this->Coach->findAllByAgencyId($this->Session->read('Account.id'));
		else
        $arr = $this->Coach->find('all');
		
        if (is_array($arr)) {
            $this->set('coaches', $arr);
        }
        $this->layout = 'ajax';
        $this->render('search');
    }

    public function upload($usertype=3) {
        $this->layout = 'popup';
        switch ($usertype) {
            case 3: if ($this->Session->read('usertype') == '1')
                    $arr = $this->Coach->findAllByAgencyId($this->Session->read('Account.id'));
                else
                    $arr = $this->Coach->find('all');
                if (is_array($arr))
                    $this->set('coaches', $arr);

                $this->set("popTitle", "Import Clients");
                break;

            case 2:
                if ($this->Session->read('usertype') == 0) {
                    $arr = $this->Agency->find('all');
                    if (is_array($arr))
                        $this->set('agency', $arr);
                }
                $this->set("popTitle", "Import Coach");
                break;
            case 1: $this->set("popTitle", "Import Agency");
                break;
        }
        $this->set('usertype', $usertype);
        $this->render('show_file');
    }

    function viewClient($id) {
        $this->layout = 'ajax';
        $client = $this->Client->findByAccountId($id);
		if($this->Session->read('usertype')=='1')
        $arr = $this->Coach->findAllByAgencyId($this->Session->read('Account.id'));
		else
		$arr = $this->Coach->find('all');
        if (is_array($arr)) {
            $this->set('coaches', $arr);
        }
        $this->set('client', $client['Client']);
        $this->render('view_client');
    }

    function updateClient($id) {
        $Coach = new CoachController;
     	$Coach->constructClasses();
		$this->layout = 'ajax';
		if($this->data['coach_id']==0)
		{
			$Coach->sendrelease_mail($id);	
		}
        $this->Client->id = $id;
        $this->Client->saveField('coach_id', $this->data['coach_id']);
        $this->autoRender = false;
    }

    function updateCoach($id) {
        $this->layout = 'ajax';
        $this->Coach->id = $id;
        $this->Coach->saveField('agency_id', $this->data['agency_id']);
        $this->autoRender = false;
    }

    public function settings() {
        $this->layout = 'jsb_bg';
        //echo '<pre>';print_r($this->Session->read());die;
        $coachid = $this->Session->read('Agency.Agency.id');
        //echo $clientid;die;
        $this->set('coachid', $coachid);
    }

    public function show_update_cred($type) {
        $this->layout = 'ajax';
        $coachid = $this->data['coachid'];
        $coachinfo = $this->Agency->findById($coachid);

        $this->set('coach', $coachinfo);
        $this->set('agencyid', $coachid);
        if ($type == 0)
            $this->render('show_settings');
        else
            $this->render('change_pass');
    }

    public function settings_details() {

        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
            if (!empty($this->data)) {
                $this->Agency->id = $this->data['Agency']['id'];
                $this->Agency->save($this->data);
                $account_id = $this->Session->read('Account.id');
                $this->Account->id = $account_id;
                $this->Account->saveField('name', $this->data['Agency']['name']);
                $this->Session->write('Agency.Agency.name', $this->data['Agency']['name']);
                echo 'Details has been updated.|' . $this->data['Agency']['name'];
                die;
            }
        }
    }

    public function add_mail_pref() {
        if (!empty($this->data)) {
            $data = array('reminder_mail' => $this->data['Coach']['reminder_mail'], 'card_moved' => $this->data['Coach']['card_moved'], 'login_user' => $this->data['Coach']['login_user'], 'application_deadline' => $this->data['Coach']['application_deadline'], 'interview' => $this->data['Coach']['interview']);
            $this->Coach->id = $this->data['coachid'];
            $this->Coach->save($data);
            echo 'Mail preferences updated successfully.';
            die;
        }
    }

    public function coach_search() {
        $this->layout = 'ajax';
		$flag='';
        if (isset($this->data['cbox'])) {
            $del_id = implode(",", $this->data['cbox']);
			
            $this->Coach->query("delete from jsb_coach where account_id in ($del_id)");
			$flag=$this->Coach->query("update jsb_accounts set activate=replace(activate,'2,',''),usertype=replace(usertype,'2,','') where id in ($del_id)");			
			$flag=$this->Coach->query("update jsb_accounts set activate=replace(activate,',2',''),usertype=replace(usertype,',2','') where id in ($del_id)");			
			$this->Coach->query("update jsb_accounts set activate=replace(activate,'2',''),usertype=replace(usertype,'2','') where id in ($del_id)");			
			$this->Account->query("delete from jsb_accounts where usertype='' AND id in ($del_id)");
			
            $total=$this->Coach->find('count',array('conditions'=>'Coach.agency_id='.$this->Session->read('Account.id')));
			
             $this->Session->write('Agency.Agency.allowed_coach',$total);
             $this->set('total',$total);
             
        }
        if ($this->Session->read('usertype') == 0){
            $agency_id = '0';
			$conditions=array();
	}
        else{
            $agency_id = $this->Session->read('Account.id');
		$conditions['Coach.agency_id'] = $agency_id;	
		}

        if (count($this->request->data) == 0)
            $this->request->data = $this->passedArgs;
			//$limit=$this->data['limit'];
       if(isset($this->data['limit']))
			$limit=intval($this->data['limit']);
		else $limit=10;
		
        if (isset($this->data['keyword']) && trim($this->data['keyword']) != '')
         {   $conditions['OR']['Coach.name like '] = "%" . $this->data['keyword'] . "%";
		 	$conditions['OR']['Coach.email like '] = "%" . $this->data['keyword'] . "%";
		 }

        $this->paginate = array(
            'conditions' => $conditions,
            'joins' => array(
                array(
                    'alias' => 'U',
                    'table' => 'accounts',
                    'type' => 'INNER',
                    'conditions' => '`U`.`id` = `Coach`.`account_id`'
                ),
                array(
                    'alias' => 'C',
                    'table' => 'client',
                    'type' => 'LEFT',
                    'conditions' => '`C`.`coach_id` = `Coach`.`account_id`'
                ),
				array(
                    'alias' => 'A',
                    'table' => 'agency',
                    'type' => 'LEFT',
                    'conditions' => '`Coach`.`agency_id` = `A`.`account_id`'
				
				)
            ),
            'fields' => array('Coach.*', 'count(C.id) as count', 'find_in_set(2,U.activate) as active,A.name'),            
            'group' => 'Coach.id',
            'order' => array(
                'Coach.id' => 'desc'
            )
        );

		if($limit!=0)$this->paginate['limit'] = $limit;
        $coaches = $this->paginate('Coach');
        $this->set('coaches', $coaches);
		$this->set('curlimit', $limit);
        $this->render('coach_results');
    }

    public function coach($num=null) {
        if($this->Session->read('usertype')==1){
       $count=$this->Session->read('Agency.Agency.allowed_coach');
       $total=$this->Coach->find('count',array('conditions'=>'Coach.agency_id='.$this->Session->read('Account.id')));
       $this->set('count',$count);
       $this->set('total',$total);
        }
        $this->render('coach_index');
    }

    public function admin_coach() {
        $this->layout = 'jsb_admin';
        $this->render('coach_index');
    }

    public function admin_index() {
        $this->layout = 'jsb_admin';
        $this->render('index');
    }

    public function show_coachadd() {
        $this->layout = 'ajax';
        $id = $this->data['id'];
        if ($id != 0) {
            $row = $this->Coach->findById($id);
            $this->set('row', $row);
        }
        $this->render('coach_edit');
    }

    public function change_status() {
        $this->layout = 'ajax';
        if ((int) $this->data['status'] == 0)
            $this->Account->query("update jsb_accounts set activate=concat_ws(',',activate,'2') where id='" . $this->data['id'] . "'");
        else
            $this->Account->query("update jsb_accounts set activate=replace(activate,'2','') where id='" . $this->data['id'] . "'");
        die;

        $this->autoRender = false;
    }

    public function show_coachsearch() {
        $this->layout = 'ajax';
        $this->render('coach_search');
    }

    function viewCoach($id) {
        $this->layout = 'ajax';
        $coach = $this->Coach->findByAccountId($id);
		$agencies=$this->Agency->find('all');
		$this->set('agencies',$agencies);
        $this->set('coach', $coach['Coach']);
        $this->render('coach_view');
    }

    public function report($id=null) {
		if(!empty($id)){
			$coach=$this->Coach->find('first',array('conditions'=>array('Coach.account_id'=>$id),'fields'=>array('Coach.id','Coach.reg_date')));	
			$this->set('coach',$coach);
		}
        $this->set('id', $id);
    }

    public function report_mid($id=null, $download=0) {
        if ($download == 1) {
            $this->layout = 'report_pdf';
        }
        else
            $this->layout = 'ajax';
        $report = array();
        if ($id != null)
		{
			$id=explode(',',$id);
            $rows = $this->Client->find('all', array('conditions'=>array('Client.Coach_id'=>$id),'fields'=>array('id', 'account_id', 'name', 'email', 'latest_card_mov_date'),'order'=>'Client.Coach_id'));
		}
        //print_r($rows);
        $i = 1;
        $ids = '0,';
        foreach ($rows as $row)
            $ids.=$row['Client']['id'] . ",";
        $ids = substr($ids, 0, -1);
        $column_status = array('O', 'A', 'S', 'I', 'V', 'J');
        $other = "";
        if ($this->data['from_date'] != '')
            $other.=" and start_date>='" . $this->data['from_date'] . "'";
        if ($this->data['to_date'] != '')
            $other .= " and end_date<='" . $this->data['to_date'] . "'";
        if ($other == "")
            $other = " and end_date='0000-00-00 00:00:00' ";

        $reports[0]['name'] = "Total - All Clients";
        $query = "select count(*) as count, column_status from jsb_card_detail where card_id in (select id from jsb_card where recycle_bin='0' and job_type='A' and client_id in ($ids) )  $other group by column_status";
        $job_a = array();
        $cols = $this->Client->query($query);
        foreach ($cols as $col)
            $job_a[$col['jsb_card_detail']['column_status']] = $col[0]['count'];
        foreach ($column_status as $stat)
            if (!isset($job_a[$stat]))
                $job_a[$stat] = 0;
        $reports[0]['job_a'] = implode("-", $job_a);

        $query = "select count(*) as count, column_status from jsb_card_detail where card_id in (select id from jsb_card where recycle_bin='0' and job_type='B' and client_id in ($ids) )  $other group by column_status";
        $job_b = array();
        $cols = $this->Client->query($query);
        foreach ($cols as $col)
            $job_b[$col['jsb_card_detail']['column_status']] = $col[0]['count'];
        foreach ($column_status as $stat)
            if (!isset($job_b[$stat]))
                $job_b[$stat] = 0;
        $reports[0]['job_b'] = implode("-", $job_b);
        $reports[0]['job_countA'] = $job_a['J'];
        $reports[0]['job_countB'] = $job_b['J'];
        $reports[0]['latest_card_mov_date'] = '';
        $query = "select format(avg(time_to_sec(timediff(now(),CD.start_date)))/(60*60*24),2) as avg from jsb_card_detail CD INNER JOIN jsb_card C ON ( CD.card_id=C.id and C.column_status=CD.column_status and C.recycle_bin='0' ) where C.client_id in ($ids) $other";
        $cols = $this->Client->query($query);
        $reports[0]['avg'] = $cols[0][0]['avg'];

        $job = array();
        $query = "select count(*) as count,column_status from jsb_card_detail where card_id in (select id from jsb_card where recycle_bin='0' and client_id in ($ids))  $other group by column_status";
        $cols = $this->Client->query($query);
        foreach ($cols as $col)
            $job[$col['jsb_card_detail']['column_status']] = $col[0]['count'];
        foreach ($column_status as $stat)
            if (!isset($job[$stat]))
                $job[$stat] = 0;

        $reports[0]['movement'] = $job['O'] . '/' . $job['A'] . ' ' . $job['A'] . '/' . $job['S'] . ' ' . $job['S'] . '/' . $job['I'] . ' ' . $job['I'] . '/' . $job['V'] . ' ' . $job['V'] . '/' . $job['J'];
        $reports[0]['OAI'] = $job['O'] . '-' . $job['A'] . '-' . $job['I'];

        $i = 1;
        foreach ($rows as $row) {
            $ids = $row['Client']['id'];
            $reports[$i]['name'] = $rows[$i - 1]['Client']['name'];
            $reports[$i]['latest_card_mov_date'] = $rows[$i - 1]['Client']['latest_card_mov_date'];
            $query = "select count(*) as count, column_status from jsb_card_detail where card_id in (select id from jsb_card where recycle_bin='0' and job_type='A' and client_id in ($ids) )  $other group by column_status";
            $job_a = array();
            $cols = $this->Client->query($query);
            foreach ($cols as $col)
                $job_a[$col['jsb_card_detail']['column_status']] = $col[0]['count'];
            foreach ($column_status as $stat)
                if (!isset($job_a[$stat]))
                    $job_a[$stat] = 0;
            $reports[$i]['job_a'] = implode("-", $job_a);

            $query = "select count(*) as count, column_status from jsb_card_detail where card_id in (select id from jsb_card where recycle_bin='0' and job_type='B' and client_id in ($ids) )  $other group by column_status";
            $job_b = array();
            $cols = $this->Client->query($query);
            foreach ($cols as $col)
                $job_b[$col['jsb_card_detail']['column_status']] = $col[0]['count'];
            foreach ($column_status as $stat)
                if (!isset($job_b[$stat]))
                    $job_b[$stat] = 0;
            $reports[$i]['job_b'] = implode("-", $job_b);
            $reports[$i]['job_countA'] = $job_a['J'];
            $reports[$i]['job_countB'] = $job_b['J'];
            $query = "select format(avg(time_to_sec(timediff(now(),CD.start_date)))/(60*60*24),2) as avg from jsb_card_detail CD INNER JOIN jsb_card C ON ( CD.card_id=C.id and C.column_status=CD.column_status and C.recycle_bin='0' ) where C.client_id in ($ids) $other";
            $cols = $this->Client->query($query);
            $reports[$i]['avg'] = $cols[0][0]['avg'];

            $job = array();
            $query = "select count(*) as count,column_status from jsb_card_detail where card_id in (select id from jsb_card where recycle_bin='0' and client_id in ($ids))  $other group by column_status";
            $cols = $this->Client->query($query);
            foreach ($cols as $col)
                $job[$col['jsb_card_detail']['column_status']] = $col[0]['count'];
            foreach ($column_status as $stat)
                if (!isset($job[$stat]))
                    $job[$stat] = 0;

            $reports[$i]['movement'] = $job['O'] . '/' . $job['A'] . ' ' . $job['A'] . '/' . $job['S'] . ' ' . $job['S'] . '/' . $job['I'] . ' ' . $job['I'] . '/' . $job['V'] . ' ' . $job['V'] . '/' . $job['J'];
            $reports[$i]['OAI'] = $job['O'] . '-' . $job['A'] . '-' . $job['I'];
            $i++;
        }
		if(count($reports)>1){
		
		$latest='0000-00-00 00:00:00';
		foreach($reports as $re){
			if($re['latest_card_mov_date']>$latest)
				$latest= $re['latest_card_mov_date'];
					
		}
		if($latest!='0000-00-00 00:00:00'){
			$reports[0]['latest_card_mov_date']	=$latest;
		}
		}
        $this->set('rows', $reports);
    }

    public function report_download($id) {
        $this->request->data['from_date'] = $this->passedArgs['f'];
        $this->request->data['to_date'] = $this->passedArgs['t'];
        $tcpdf = new XTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $this->report_mid($id, 1);
        $coach_info = $this->Coach->findByAccountId($id);
        $this->set('username', $coach_info['Coach']['name']);
        $this->set('tcpdf', $tcpdf);
    }

    public function uploadlogo() {
        $this->layout = 'ajax';
        if (!empty($this->data['TR_file']['tmp_name'])) {
            $fileUpload = WWW_ROOT . 'logo' . DS;
            $arr_img = explode(".", $this->data["TR_file"]["name"]);
            $ext = strtolower($arr_img[count($arr_img) - 1]);
            if ($this->data["TR_file"]['error'] == 0 && in_array($ext, array('jpg', 'gif', 'png'))) {
                $fname = removeSpecialChar($this->data['TR_file']['name']);
                $file = time() . "_" . $fname;
                if (upload_my_file($this->data['TR_file']['tmp_name'], $fileUpload . $file)) {
                    $save_path = "thumb_" . $file;
                    create_thumb($fileUpload . $file, 150, $fileUpload . $save_path);
                    echo "success|" . $save_path;
                }
                else
                    echo "error|Try another time";
            }
				else echo "error|Please select jpg,gif,png file type";
        }
        die;
    }
	
	 public function transfer($id=null) {
		if(!empty($id)){
			if ($this->Session->read('usertype') == '1'){		
            $agency_id = $this->Session->read('Account.id');	        
		}
			$coachs=$this->Coach->find('all',array('conditions'=>array('Coach.agency_id'=>$agency_id),'fields'=>array('Coach.id','Coach.account_id','Coach.name')));	
			$this->set('coachs',$coachs);
			
			$Clients=$this->Client->find('all',array('conditions'=>array('Client.coach_id'=>$id),'fields'=>array('Client.id','Client.account_id','Client.name')));	
			$this->set('clients',$client);
		}
        $this->set('id', $id);
    }
	public function transfer_client_lists($id=null)
	{
		if (count($this->request->data) == 0)
            $this->request->data = $this->passedArgs;
		//print_r($this->request->data);
		$this->layout = 'ajax';
		$id=$this->data['id'];
		 $this->paginate = array(
            'conditions' =>array('Client.coach_id'=>$id),           
            'fields' => array('Client.id','Client.account_id','Client.name','Client.email','Client.reg_date'),
            'limit' => 10,           
            'order' => array(
                'Client.id' => 'desc'
            )
        );
        $clients = $this->paginate('Client');			
		$this->set('clients',$clients);
		
	}
	public function transfer_client(){
		$this->layout = 'ajax';
		$coach_id=$this->data['coach'];
		$ids=implode(',',$this->data['id']);
		$total=$this->Client->query("update jsb_client set coach_id=$coach_id where account_id in($ids)");
		echo count($this->data['id']);
		die;
	}
	 public function admin_consultant($num=null) {
		$this->layout = 'jsb_admin';
		$agences=$this->Agency->find('all',array('joins'=>array(array('alias' => 'A',
                    'table' => 'accounts',
                    'type' => 'INNER',
                    'conditions' => array('`A`.`id` = `Agency`.`account_id`','find_in_set(1,A.activate)=2'))),'fields'=>array('Agency.account_id','Agency.title','find_in_set(1,A.activate) as act')));
					
					$this->set('agences',$agences);
	 	$this->render('consultant_index');
    }
	
	 public function consultant($num=null) {
        if($this->Session->read('usertype')==1){
       //$count=$this->Session->read('Agency.Agency.allowed_coach');
       //$total=$this->Employer->find('count',array('conditions'=>'Employer.agency_id='.$this->Session->read('Account.id')));
      // $this->set('count',$count);
       //$this->set('total',$total);
        }
        $this->render('consultant_index');
    }
	
	public function consultant_search()
	{
		
        $this->layout = 'ajax';
		
        if (isset($this->data['cbox'])) {
            $del_id = implode(",", $this->data['cbox']);
			
            $this->Employer->query("delete from jsb_employer where account_id in ($del_id)");
			//$this->Account->query("update jsb_accounts set activate=replace(activate,',4',''),usertype=replace(usertype,',4','') where id in ($del_id)");			
			$this->Account->query("update jsb_accounts set activate=replace(activate,'4',''),usertype=replace(usertype,'4','') where id in ($del_id)");			
			$this->Account->query("delete from jsb_accounts where usertype='' AND id in ($del_id)");			
             $this->set('deleted', 'Consultant(s) deleted Successfully');
			 //Deleting All Cards of consltants
			$this->Account->query("delete from jsb_agency_card where account_id in ($del_id)"); 
        }
        if ($this->Session->read('usertype') == 0){
            $agency_id = '0';
			$conditions=array();
		}
        else{
            $agency_id = $this->Session->read('Account.id');
			$conditions['Employer.agency_id'] = $agency_id;	
		}

        if (count($this->request->data) == 0)
            $this->request->data = $this->passedArgs;
        
        if (isset($this->data['keyword']) && trim($this->data['keyword']) != '')
         {   $conditions['OR']['Employer.name like '] = "%" . $this->data['keyword'] . "%";
		 	$conditions['OR']['Employer.email like '] = "%" . $this->data['keyword'] . "%";
		 }

        $this->paginate = array(
            'conditions' => $conditions,
            'joins' => array(
                array(
                    'alias' => 'U',
                    'table' => 'accounts',
                    'type' => 'INNER',
                    'conditions' => '`U`.`id` = `Employer`.`account_id`'
                ),
				 array(
                    'alias' => 'AC',
                    'table' => 'agency_card',
                    'type' => 'LEFT',
                    'conditions' => array('`Employer`.`account_id` = `AC`.`account_id`','AC.usertype=4')
                )
            ),
            'fields' => array('Employer.*','find_in_set(4,U.activate) as active','count(AC.id) as count'),
            'limit' =>10,           
            'order' => array(
                'Employer.id' => 'desc'
            ),
			'group'=>'Employer.id'
        );


        $employers = $this->paginate('Employer');
        $this->set('employers', $employers);		
        $this->render('consultant_results');
	}

	 public function consultant_change_status() {
        $this->layout = 'ajax';
        if ((int) $this->data['status'] == 0)
		{
            $this->Account->query("update jsb_accounts set activate=concat_ws(',',activate,'4') where id='" . $this->data['id'] . "'");
			$this->Account->query("update jsb_agency_card set status='0' where  account_id ='" . $this->data['id'] . "'");
		}
        else
		{
            $this->Account->query("update jsb_accounts set activate=replace(activate,'4','') where id='" . $this->data['id'] . "'");
			$this->Account->query("update jsb_agency_card set status='1' where  account_id ='" . $this->data['id'] . "'");
		}
        die;

        $this->autoRender = false;
    }
	public function consultant_view_card($account_id=0)
	{
		if(isset($this->passedArgs['page']))
		{
			$this->layout = 'ajax';			
			$account_id=$this->passedArgs['0'];
		}
		else
		{
			$this->layout = 'popup';			
		}
		
		$name=$this->Account->find('first',array('conditions'=>array('id'=>$account_id),'fields'=>array('name')));
		$this->paginate = array(
			'conditions' => array('account_id'=>$account_id),
            'fields' => array('Agencycard.*'),
            'limit' => 10,
             'order' => array(
                'date_added' => 'desc'
            )
        );
        $rows = $this->paginate('Agencycard');		
        $this->set("rows", $rows);
		$title=$name['Account']['name']."'s Card";		
		$this->set('popTitle',$title);
	}
	
}