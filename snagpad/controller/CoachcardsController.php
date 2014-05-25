<?php

App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'functions');
App::import('Controller', array('Mail'));

//App::import('Vendor','uploadclass');

class CoachcardsController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
    public $uses = array('Client', 'Skillslist', 'Account', 'Jobtype', 'Jobfunction', 'Clientfile', 'Clientfilehistory', 'Profiletooltip', 'Card', 'Carddetail', 'Opportunity', 'Country', 'Jobtype', 'Jobfunction', 'Industry', 'Position', 'Contact', 'Cardcolumn', 'Coachcard','Mail','Coach','State');

    public function beforeFilter() {
        if (!$this->Session->check('Account.id')) {
            $this->redirect(SITE_URL);
            //$this->Session->setFlash(__('You are not authorized to acces that page. Please login to  continue.'));

            exit();
        }
		parent::beforeFilter();
        $this->layout = 'jsb_bg';
    }

    public function index() {
        $coachid = $this->Session->read('Account.id');
        $first = '0';
        $num = 0;
        $this->set('num', $num);
        $this->set('first', $first);
    }

    public function index_jobcards() {
        $this->layout = 'ajax';
        $coach = $this->Session->read('Account.id');
        $cards = $this->Card->find('all', array('conditions' => array('Card.coach_id' => $coachid), 'order' => 'Card.id DESC'));
        //echo '<pre>';print_r($cards);die;
        $this->set('cards', $cards);
        $this->render('jobcard_index');
    }

    public function addCard($id=0) {
        $this->layout='ajax';
       $all_country=$this->Country->query("select * from `jsb_country` as Country order by field(country_code,'CA','US') desc, country_code asc");
        $data = array();
        foreach ($all_country as $country) {
            $index = $country['Country']['country_code'];
            $data[$index] = $country['Country']['country'];
        }
		$US_states=$this->State->findAllByCountryCode('US');
		$CA_states=$this->State->findAllByCountryCode('CA');
        $this->set("countries", $data);
		$this->set('US_states',$US_states);
		$this->set('CA_states',$CA_states);
		
        $account_id = $this->Session->read('Account.id');
        $all_contact = $this->Contact->find('all', array('conditions' => array('Contact.account_id' => $account_id, 'Contact.usertype' => $this->Session->read('usertype')), 'order' => array('Contact.id ASC')));
        $data = array();
        foreach ($all_contact as $contact) {
            $index = $contact['Contact']['id'];
            $data[$index] = $contact['Contact']['email'];
        }
        $this->set("contacts", $data);
        $all_job_type = $this->Jobtype->find('all', array('order' => array('Jobtype.id ASC')));
        $data = array();
        foreach ($all_job_type as $type) {
            $index = $type['Jobtype']['id'];
            $data[$index] = $type['Jobtype']['job_type'];
        }
        $this->set("job_type", $data);
        $all_job_func = $this->Jobfunction->find('all', array('order' => array('Jobfunction.id ASC')));
        $data = array();
        foreach ($all_job_func as $func) {
            $index = $func['Jobfunction']['id'];
            $data[$index] = $func['Jobfunction']['job_function'];
        }
        $this->set("job_function", $data);
        $all_industry = $this->Industry->find('all', array('order' => array('Industry.id ASC')));
        $data = array();
        foreach ($all_industry as $ind) {
            $index = $ind['Industry']['id'];
            $data[$index] = $ind['Industry']['industry'];
        }
        $this->set("industries", $data);
        $all_pos_level = $this->Position->find('all', array('order' => array('Position.id ASC')));
        $data = array();
        foreach ($all_pos_level as $pos) {
            $index = $pos['Position']['id'];
            $data[$index] = $pos['Position']['position'];
        }
        $this->set("position_levels", $data);
        if($id!=0){
            $card=$this->Coachcard->query("select * from jsb_coach_card as Coachcard where id='".$id."'");
			//echo '<pre>';print_r($card);die;
            $this->set("card",$card[0]['Coachcard']);
			
        }
    }

    public function saveCard($id=0) {
        if($this->request->data['state']=="State/Province")
              $this->request->data['state']="";
        if($this->request->data['city']=="City")
                $this->request->data['city']="";
        if($this->request->data['special_instruction']=="Special Instruction")
            $this->request->data['special_instruction']="";
        $this->request->data['date_added']=date("Y-m-d H:i:s");
        
        if($id==0){
        $this->request->data['coach_id'] = $this->Session->read('Account.id');
        $this->Coachcard->create();
        $card = $this->Coachcard->save($this->data);
        }else
        {
            $this->Coachcard->id=$id;
            $data = $this->data;
            $data['Contact']['date_modified'] = date("Y-m-d H:i:s");           
            $this->Coachcard->save($data);
        }
        die;
    }

    public function job_details() {
        $this->layout = 'ajax';
        $card_id = $this->data['cardid'];
        $card_info = $this->Card->findById($card_id);

        $all_opp = $this->Opportunity->find('all');
        $data = array();
        foreach ($all_opp as $opp) {
            $id = $opp['Opportunity']['id'];
            $data[$id] = $opp['Opportunity']['name'];
        }

        $this->set('data', $data);
        $this->set('card', $card_info);
        $this->set('data', $data);
        $this->render('jobcard_details');
    }


    public function show_add_contact() {
        $this->layout = 'basic_popup';
        $account_id = $this->Session->read('Account.id');
        $card_id = $this->Session->read('contact_card_id');
        $this->set('card_id', $card_id);
        $this->set('account_id', $account_id);
        $this->render('add_contact');
    }

    public function save_contact() {
        if (!empty($this->data)) {

            $exist_contact = $this->Contact->findAllByAccountIdAndEmail($this->data['Contact']['account_id'], $this->data['Contact']['email']);
            if (empty($exist_contact)) {
                $data = $this->data;
                $data['Contact']['date_added'] = date("Y-m-d H:i:s");
                $data['Contact']['date_modified'] = date("Y-m-d H:i:s");
                $this->Contact->create();
                $contact = $this->Contact->save($data);
                $this->Card->id = $data['cardid'];
                $this->Card->saveField('contact_id', $contact['Contact']['id']);
                echo $contact['Contact']['id'];
                die;
            } else {
                echo 'Error';
                die;
            }
        }
    }
   	public function show_search()
	{
		$this->layout='ajax';
		$this->render('search');
	}
        
        public function search()
        {
            $this->layout='ajax';
            if(isset($this->data['cbox'])){
           $del_id=implode(",",$this->data['cbox']);
           $this->Coachcard->query("delete from jsb_coach_card where coach_id='".$this->Session->read('Account.id')."' and id in ($del_id)");
           
       }
            $query="Select C.*,count(CD.id) as count_client from jsb_coach_card C LEFT JOIN jsb_card CD ON (CD.counselor_id='".$this->Session->read('Account.id')."' and CD.added_by='1') where C.coach_id='".$this->Session->read('Account.id')."' and C.card_pool='0'";
            if(isset($this->data['keyword']))
            {
                $query.=" and (C.company_name like '%".$this->data['keyword']."%' OR C.position_available like '%".$this->data['keyword']."%') ";
            }
            $query.=" group by C.id order by C.id desc";
            $rows=$this->Coachcard->query($query);
            
            $this->set("rows",$rows);
            $this->render('results');
        }
        
        public function share($id,$usertype=3)
        {
            if($usertype=="3"){
                $query="Select C.id,C.name,C.email,count(CC.id) as count from jsb_client C LEFT JOIN jsb_card CC ON (CC.added_by='1' and CC.counselor_id='".$this->Session->read('Account.id')."' and C.id=CC.client_id  and CC.other_web_job_id='$id') where C.coach_id='".$this->Session->read('Account.id')."' group by C.id ";
            }
            else
            {
                $query="Select C.id,C.name,C.email,count(CC.id) as count from jsb_coach C LEFT JOIN jsb_coach_card CC ON (C.id=CC.coach_id and CC.card_pool_id='$id') where C.account_id!='".$this->Session->read('Account.id')."' and C.agency_id='".$this->Session->read('Coach.Coach.agency_id')."' group by C.id ";
            }
           // echo $this->Session->read('Coach.Coach.agency_id');die;
            $rows=$this->Coachcard->query($query);
			$this->set("rows",$rows);
            $card=$this->Coachcard->findById($id);
            $this->set("card",$card['Coachcard']);
            $this->set("usertype",$usertype);
        }
      
        public function shareCard($id,$usertype){
            $card=$this->Coachcard->findById($id);
            $card=$card['Coachcard'];
            unset($card['id']);
            if($usertype==3)
            {
                foreach($this->data['cbox'] as $val){
                    $data=array('reg_date'=>date("Y-m-d H:i:s"),"client_id"=>$val,"counselor_id"=>$this->Session->read('Account.id'),'added_by'=>1,'other_web_job_id'=>$id,'total_points'=>'2.0','type_of_opportunity'=>'Coach');
                    $data=array_merge($data,$card);
                    $this->Card->create();
                    $this->Card->save($data);
                    $arr=array('card_id'=>$this->Card->id,'total_points'=>'2.0');
                    $this->Cardcolumn->create();
                    $this->Cardcolumn->save($arr);
                    $arr=array('card_id'=>$this->Card->id,'column_status'=>'O','start_date',$data['reg_date']);
                    $this->Carddetail->create();
                    $this->Carddetail->save($arr);
					$this->sendsharedCard_mail($val,$card);
                    $this->Session->setFlash(__('Card has been shared successfully'));
                }
            }else
            {
                foreach($this->data['cbox'] as $val){
                    $card['coach_id']=$val;
                    $card['card_pool_id']=$id;
                    $this->Coachcard->create();
                    $this->Coachcard->save($card);
                }
                $this->Session->setFlash(__('Card has been shared successfully'));
            }
            $this->redirect(SITE_URL.'/Coachcards/index');
        }
		
		public function sendsharedCard_mail($mail_id,$card_data)
		{
			$Mail = new MailController;
     	    $Mail->constructClasses();					
			$client=$this->Client->find('first',array('conditions'=>array('Client.id'=>$mail_id),'fields'=>array('Client.account_id','Client.coach_id')));
			$coach=$this->Coach->find('first',array('conditions'=>array('Coach.account_id'=>$client['Client']['coach_id'])));		
						
			$arr['FOLLOW_URL'] = SITE_URL;
			$arr['COACH_NAME'] = $coach['Coach']['name'];
			$arr['COMPANY_NAME'] = $card_data['company_name'];
			$arr['JOB_TITLE'] = $card_data['position_available'];
            $Mail->sendMail($client['Client']['account_id'], "client_card_added", $arr);
			return;
				
		}

}