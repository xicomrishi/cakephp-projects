<?php

App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'functions');

//App::import('Vendor','uploadclass');

class AgencycardsController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
    public $uses = array('Client', 'Account', 'Card', 'Carddetail','Country', 'Contact', 'Cardcolumn', 'Coachcard', 'Agency', 'Agencycard', 'Agencyshared','Cardcontact','Jobtype','Jobfunction','Industry','Position','State','Coach');

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
        $cards = $this->Agencycard->find('all', array('conditions' => array('Agencycard.agency_id' => $coachid), 'order' => 'Card.id DESC'));
        //echo '<pre>';print_r($cards);die;
        $this->set('cards', $cards);
        $this->render('jobcard_index');
    }

    public function addCard($id=0) {
        $this->layout = 'ajax';
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
        if ($id != 0) {
            $card = $this->Agencycard->findById($id);
            $this->set("card", $card['Agencycard']);
        }
    }

    public function saveCard($id=0) {
        if($this->Session->read('usertype')==0)
            $this->request->data['is_admin']=1;
        else
            $this->request->data['is_admin']=0;
        if ($this->request->data['state'] == "State/Province")
            $this->request->data['state'] = "";
        if ($this->request->data['city'] == "City")
            $this->request->data['city'] = "";
        if ($this->request->data['job_requirement'] == "Job Requirement")
            $this->request->data['job_requirement'] = "";
        if ($this->request->data['how_to_apply'] == "How to Apply")
            $this->request->data['how_to_apply'] = '';
        if ($this->request->data['information'] == "Contact Information")
            $this->request->data['information'] = "";
        if ($this->request->data['contact_name'] == 'Contact Name')
            $this->request->data['contact_name'] = '';
        if ($this->request->data['email'] == 'Contact Email')
            $this->request->data['email'] = '';
        if ($this->request->data['phone'] == 'Contact Phone')
            $this->request->data['phone'] = '';
        if ($this->request->data['address'] == 'Contact Address')
            $this->request->data['address'] = '';
        if ($this->request->data['salary'] == 'Salary')
            $this->request->data['salary'] = '';
        if ($this->request->data['job_description'] == 'Job Description')
            $this->request->data['job_description'] = '';




        if ($id == 0) {
            $this->request->data['date_added'] = date("Y-m-d H:i:s");
            $this->request->data['agency_id'] = $this->Session->read('Account.id');
            $this->Agencycard->create();
            $card = $this->Agencycard->save($this->data);
            $card_id=$this->Agencycard->id;
            if($this->data['coach_ids']!=''){
                $ids=substr($this->data['coach_ids'],0,-1);
                $ids=explode(",",$ids);
                foreach($ids as $id){
                     $data = array('user_id' => $id, "card_id" => $card_id, "usertype" => 2, 'mail_flag' => 0);
            $this->Agencyshared->create();
            $this->Agencyshared->save($data);
            unset($this->Agencyshared->id);
                }
            }
            if($this->data['client_ids']!=''){
                $ids=substr($this->data['client_ids'],0,-1);
                $ids=explode(",",$ids);
                foreach($ids as $id){
                     $data = array('user_id' => $id, "card_id" => $card_id, "usertype" => 3, 'mail_flag' => 0);
            $this->Agencyshared->create();
            $this->Agencyshared->save($data);
            unset($this->Agencyshared->id);
                }
            }
           
        } else {
            $this->Agencycard->id = $id;
            $data = $this->data;
            $data['date_modified'] = date("Y-m-d H:i:s");
            $this->Agencycard->save($data);
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

    public function show_search() {
        $this->layout = 'ajax';
        $this->render('search');
    }

    public function search() {
        $this->layout = 'ajax';
        if (isset($this->data['cbox'])) {
            $del_id = implode(",", $this->data['cbox']);
            $this->Coachcard->query("delete from jsb_agency_card where agency_id='" . $this->Session->read('Account.id') . "' and id in ($del_id)");
        }
        $query = "Select C.*,count(CD.id) as count_client from jsb_agency_card C LEFT JOIN jsb_card CD ON (CD.counselor_id='" . $this->Session->read('Account.id') . "' and CD.added_by='1') where C.agency_id='" . $this->Session->read('Account.id') . "' ";
        if (isset($this->data['keyword'])) {
            $query.=" and (C.company_name like '%" . $this->data['keyword'] . "%' OR C.position_available like '%" . $this->data['keyword'] . "%') ";
        }
        $query.=" group by C.id order by C.id desc";
        $rows = $this->Coachcard->query($query);

        $this->set("rows", $rows);
        $this->render('results');
    }

    public function share($id, $usertype=3) {
        $card = $this->Agencycard->findById($id);

        $rows = array();
        if ($card['Agencycard']['share_all'] == '0') {
            if ($usertype == "3") {
                $query = "select C.name, C.email,C.id,C.account_id from jsb_client C where C.id not in (select client_id from jsb_card A where A.other_web_job_id='$id' and resourcetype='1') and C.agency_id='" . $this->Session->read('Account.id') . "' and C.account_id not in (Select user_id from jsb_agency_shared where usertype='3' and card_id='$id') group by C.id";
            } else {
                $query = "select C.name, C.email,C.id,C.account_id from jsb_coach C where C.account_id not in (select coach_id from jsb_coach_card A where A.agency_card_id='$id') and C.agency_id='" . $this->Session->read('Account.id') . "' and C.account_id not in (Select user_id from jsb_agency_shared where usertype='2' and card_id='$id') group by C.id";
            }


            $rows = $this->Agencycard->query($query);
        }
        $this->set("rows", $rows);
        $this->set("card", $card['Agencycard']);
        $this->set("usertype", $usertype);
    }

    public function shareCard($id, $usertype) {
        foreach ($this->data['cbox'] as $val) {
            $data = array('user_id' => $val, "card_id" => $id, "usertype" => $usertype, 'mail_flag' => 0);
            $this->Agencyshared->create();
            $this->Agencyshared->save($data);
            unset($this->Agencyshared->id);
        }
        $this->Session->setFlash(__('Card has been shared successfully'));

        $this->redirect(SITE_URL . '/cards/index');
    }
    
    public function share_card(){
        $this->layout="popup";
        $coaches=$this->Coach->findAllByAgencyId($this->Session->read('Account.id'));
        $clients=$this->Client->findAllByAgencyId($this->Session->read('Account.id'));
        $this->set('coaches',$coaches);
        $this->set('clients',$clients);
        $this->set('popTitle','Share Card');
    }

    public function job_bulletin() {
        
    }

    public function job_bulletin_mid() {
        $usertype = $this->Session->read('usertype');
        $this->layout = 'ajax';
        $query = "Select C.* from jsb_agency_card C where 1 and (C.share_all='1' OR (C.id in (select card_id from jsb_agency_shared where usertype='$usertype' and user_id='" . $this->Session->read('Account.id') . "')))";
        
        if ($usertype == 3)
            $query.=" and C.id not in (select other_web_job_id from jsb_card where client_id='" . $this->Session->read('Acccount.id') . "' and resourcetype='1') and C.agency_id='" . $this->Session->read('Client.Client.agency_id') . "' ";
        else
            $query.=" and C.id not in (Select agency_card_id from jsb_coach_card where coach_id='" . $this->Session->read('Account.id') . "') and C.agency_id='" . $this->Session->read('Coach.Coach.agency_id') . "'";
        if ($this->data['keywords'] != '' && $this->data['keywords'] != 'Keywords') {
            $query.=" and (C.company_name like '%" . $this->data['keywords'] . "%' OR C.position_available like '%" . $this->data['keywords'] . "%')";
        }
       
        $cards = $this->Agencycard->query($query);
        
        $this->set('cards', $cards);
    }

    function add_card($id) {
        $this->layout = "ajax";
        $this->autoRender = false;
        $card = $this->Agencycard->findById($id);
        $card = $card['Agencycard'];
        $contact_id = 0;
        if ($card['email'] != '') {
            $count = $this->Contact->findByEmailAndUsertype($card['email'], $this->Session->read('usertype'));
            if (is_array($count) && count($count) > 0) {
                $contact_id = $count['Contact']['id'];
            } else {
                $this->Contact->create();
                $data = array('account_id'=>$this->Session->read('Account.id'),'usertype' => $this->Session->read('usertype'), 'date_added' => date('Y-m-d H:i:s'), 'contact_name' => $card['contact_name'], 'email' => $card['email'], 'phone' => $card['phone'], 'address' => $card['address'], 'information' => $card['information']);
                $this->Contact->save($data);
                $contact_id = $this->Contact->id;
            }
        }
        $data = $card;
        unset($data['id']);
        $date=date('Y-m-d H:i:s');
        $data['date_added']=$date;
        if ($this->Session->read('usertype') == 3) {
            $data['added_by'] = '2';
            $data['client_id']=$this->Session->read('Client.Client.id');
            $data['resourcetype'] = 1;
            $data['other_web_job_id'] = $card['id'];
            $data['total_points'] = '2.0';
			$data['type_of_opportunity'] = 'Job Bulletin';
            $data['contact_id'] = $contact_id;
            
            $data['reg_date']=$data['latest_card_mov_date']=$date;
            $this->Card->create();
            $this->Card->save($data);
            $card_id = $this->Card->id;
            if($data['contact_id']!=0){
                $data=array('card_id' => $card_id, "contact_id" => $contact_id);
                $this->Cardcontact->create();
                $this->Cardcontact->save($data);
            }
            $data = array('card_id' => $card_id, "column_status" => "O", "start_date" => $date);
            $this->Carddetail->create();
            $this->Carddetail->save($data);
            $data = array('card_id' => $card_id, 'total_points' => '2.0');
            $this->Cardcolumn->create();
            $this->Cardcolumn->save($data);
        } else {
            $data['coach_id']=$this->Session->read('Account.id');
            $data['agency_card_id']=$card['id'];
            $this->Coachcard->create();
            $this->Coachcard->save($data);
        }
    }
	public function list_state()
	{	
	$country=$this->data['country'];
		
			$state_st=$this->State->findAllByCountryCode($country);
			echo "<label class='pad'>State/Province</label><select name='state' id='tr_state'>";
			foreach($state_st as $st)
			{ ?>
				<option value="<?php echo $st['State']['state'];?>"><?php echo $st['State']['state'];?></option>
             <?php    }
			echo "</select>";		
			$this->autoRender=false;	
			
		
	}
        
        public function admin_index(){
            $this->layout="jsb_admin";
            $this->index();
            $this->render('index');
        }
    
}