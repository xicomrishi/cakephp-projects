<?php

App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', array('functions','reader'));
App::import('Controller', array('Mail'));
//App::import('Vendor','uploadclass');

class CoachController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session', 'Upload');
    public $uses = array('Client', 'Coach', 'Account', 'Card','Clientfile','Note','Mail');

    public function beforeFilter() {
        if (!$this->Session->check('Account.id')) {
            $this->redirect(SITE_URL);
            exit();
        }
		parent::beforeFilter();
        $this->layout = 'jsb_bg';
    }

    public function search() {
		
        $this->layout = 'ajax';
        if (isset($this->data['cbox'])) {
            $del_id = implode(",", $this->data['cbox']);
            $this->Client->query("delete from jsb_client where coach_id='" . $this->Session->read('Account.id') . "' and id in ($del_id)");
        }
        if (isset($this->data['release']) && $this->data['release'] != '') {
            $this->sendrelease_mail($this->data['release']);
			$this->Client->query("update jsb_client set coach_id='0' where id='" . $this->data['release'] . "'");
			
        }
        $query = "select C.*, case when C.latest_card_mov_date != '0000-00-00 00:00:00' THEN datediff(curdate(),C.latest_card_mov_date) else 10000 END as activetime,format(datediff(curdate(),C.reg_date)/7,2) as diff from jsb_client C where C.coach_id='" . $this->Session->read('Account.id') . "'";
        if (isset($this->data['keyword']) && trim($this->data['keyword']) != '')
            $query.=" and C.name like '%" . $this->data['keyword'] . "%'";
        if (isset($this->data['status_chk'])) {
            if ($this->data['activity'] == 1)
                $query.=" having activetime>5";
            else if ($this->data['activity'] == 2)
                $query.=" having activetime<=5 and activetime>3";
            else
                $query.=" having activetime<=3";
        }
        $clients = $this->Client->query($query);
        $i = 0;
        foreach ($clients as $client) {
            $clients[$i]['tot_a'] = $this->Card->find('count', array('conditions' => array('Card.client_id' => $client['C']['id'], 'Card.recycle_bin' => '0', 'Card.job_type' => 'A')));
            $clients[$i]['tot_b'] = $this->Card->find('count', array('conditions' => array('Card.client_id' => $client['C']['id'], 'Card.recycle_bin' => '0', 'Card.job_type' => 'B')));
            $clients[$i]['col_o'] = $this->Card->find('count', array('conditions' => array('Card.client_id' => $client['C']['id'], 'Card.recycle_bin' => '0', 'Card.column_status' => 'O')));
            $clients[$i]['col_a'] = $this->Card->find('count', array('conditions' => array('Card.client_id' => $client['C']['id'], 'Card.recycle_bin' => '0', 'Card.column_status' => 'A')));
            $clients[$i]['col_s'] = $this->Card->find('count', array('conditions' => array('Card.client_id' => $client['C']['id'], 'Card.recycle_bin' => '0', 'Card.column_status' => 'S')));
            $clients[$i]['col_v'] = $this->Card->find('count', array('conditions' => array('Card.client_id' => $client['C']['id'], 'Card.recycle_bin' => '0', 'Card.column_status' => 'V')));
            $clients[$i]['col_j'] = $this->Card->find('count', array('conditions' => array('Card.client_id' => $client['C']['id'], 'Card.recycle_bin' => '0', 'Card.column_status' => 'J')));
            $clients[$i]['col_i'] = $this->Card->find('count', array('conditions' => array('Card.client_id' => $client['C']['id'], 'Card.recycle_bin' => '0', 'Card.column_status' => 'I')));
            $i++;
        }
		//echo '<pre>';print_r($clients);die;
        $this->set('clients', $clients);
        $this->render('results');
    }

    public function index($num=null) {

        if (!empty($this->data)) {
            $this->layout = 'ajax';
        }
        $this->set('num', $num);
    }
	
	public function sendrelease_mail($clientid)
	{
		$Mail = new MailController;
     	$Mail->constructClasses();					
		$client=$this->Client->find('first',array('conditions'=>array('Client.id'=>$clientid),'fields'=>array('Client.account_id','Client.coach_id')));
		$coach=$this->Coach->find('first',array('conditions'=>array('Coach.account_id'=>$client['Client']['coach_id'])));		
		
			
			$arr['COACH_NAME'] = $coach['Coach']['name'];
			$Mail->sendMail($client['Client']['account_id'], "account_released", $arr);
			return;	
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
        $this->layout = 'ajax';
        $this->render('search');
    }

    public function upload() {
        $this->layout = 'popup';
        $this->set("popTitle", "Import Clients");
        $this->render('show_file');
    }
	
	
	public function settings($tab=null)
	{
		$this->layout='jsb_bg';
		//echo '<pre>';print_r($this->Session->read());die;
		$coachid=$this->Session->read('Coach.Coach.id');	
		$this->set('tab',$tab);
		$this->set('coachid',$coachid);
	}	
	
	public function show_mail_pref()
	{
		$this->layout='ajax';
		$coachid=$this->data['coachid'];
		$coachinfo=$this->Coach->query("SELECT reminder_mail,card_moved,login_user,application_deadline,interview FROM jsb_coach as Coach WHERE id='$coachid'");
		
		$this->set('coach',$coachinfo['0']);
		$this->set('coachid',$coachid);	
		$this->render('mail_pref');
	}
	
	public function show_update_cred()
	{
		$this->layout='ajax';
		$coachid=$this->data['coachid'];
		$coachinfo=$this->Coach->findById($coachid);
		//echo '<pre>';print_r($clientinfo);die;
		$this->set('coach',$coachinfo);
		$this->set('coachid',$coachid);
		$this->render('show_settings');
			
	}
	
	public function settings_details()
	{
		
		$this->layout='ajax';
		if($this->request->is('ajax'))
		{	if(!empty($this->data))
			{	
				
				$this->Coach->id=$this->data['Coach']['id'];
				$this->Coach->save($this->data);
				$account_id=$this->Session->read('Account.id');
				$this->Account->id=$account_id;
				$this->Account->saveField('name',$this->data['Coach']['name']);
				echo 'Details has been updated.|'.$this->data['Coach']['name'];die;
				
			}
		}
				
	}
	
	public function add_mail_pref()
	{
		if(!empty($this->data))
		{	$data=array('reminder_mail'=>$this->data['Coach']['reminder_mail'],'card_moved'=>$this->data['Coach']['card_moved'],'login_user'=>$this->data['Coach']['login_user'],'application_deadline'=>$this->data['Coach']['application_deadline'],'interview'=>$this->data['Coach']['interview']);
			$this->Coach->id=$this->data['coachid'];
			$this->Coach->save($data);
			echo 'Mail preferences updated successfully.'; die;	
		}	
		
	}
	
	public function change_pass()
	{
		if($this->request->is('ajax'))
		{	if(!empty($this->data))
			{	
				//echo '<pre>';print_r($this->data);die;
				$old_password=md5($this->data['Account']['old_password']);
				$coachid=$this->data['Coach']['id'];
				$user=$this->Account->findById($this->Session->read('Account.id'));
				//echo '<pre>';print_r($user);die;
				if($user['Account']['password']!=$old_password)
				{
					echo 'Old password does not match! Please try again.';
					$this->autoRender=false;
					}
				else{
					$new_password=md5($this->data['Account']['new_password']);
					$this->Account->id=$user['Account']['id'];
					$this->Account->saveField('password',$new_password);
					$this->sendupdate_mail($user,$this->data['Account']['new_password']);
					echo 'Password has been updated';
					$this->autoRender=false;
					}
				}
	}		
		
	}
	
	public function sendupdate_mail($acc,$pass)
	{
			$Mail = new MailController;
     	    $Mail->constructClasses();					
			
			
			$arr['EMAIL'] = $acc['Account']['email'];
			$arr['PASSWORD'] = $pass;
			$Mail->sendMail($acc['Account']['id'], "edit_coach", $arr);
			return;	
	}
	
	public function view_shared_files($clientid=null)
	{
		$this->layout='popup';	
		$files=$this->Clientfile->findAllByClientIdAndShared($clientid,'Y');
		$path=$this->webroot.'files/'.$clientid.'/';
		$this->set('files',$files);
		$this->set('popTitle','Shared Files');
		$this->set('path',$path);
		$this->render('display_client_files');
		
	}
	
	public function coach_client_notes($clientid)
	{
		$this->layout='popup';
		$notes=$this->Note->find('all',array('conditions'=>array('note_type'=>'2','Note.note_id'=>$clientid)));
		$this->set('notes',$notes);
		$this->set('clientid',$clientid);
		$this->set('popTitle','View/Add Note');
		$this->render('coach_client_notes');
			
	}
	
	public function save_coach_client_note()
	{
		$this->layout='ajax';
		$clientid=$this->data['clientid'];
		$data=array('note_id'=>$clientid,'note_type'=>'2','note'=>$this->data['note'],'date_added'=>date("Y-m-d H:i:s"));
		$this->Note->create();
		$this->Note->save($data);
		$notes=$this->Note->find('all',array('conditions'=>array('note_type'=>'2','Note.note_id'=>$clientid)));
		$this->set('notes',$notes);
		$this->render('coach_client_notes_existing');
			
	}
	
	

   

}