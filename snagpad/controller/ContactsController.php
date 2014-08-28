<?php
App::import('Core','Validation');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'functions');
App::import('Vendor',array('linkedin','functions','xmltoarray','reader','facebook','GmailOath','JSON','Yahoo','YahooSessionStore','openinviter/openinviter'));


class ContactsController extends AppController {

    public $helpers = array('Html', 'Form', 'Csv');
    public $components = array('Session');
    public $uses = array('Client', 'Skillslist', 'Account', 'University', 'Major', 'Minor', 'Country', 'State', 'Industry', 'Position', 'Jobtype', 'Jobfunction', 'Clientfile', 'Clientfilehistory', 'Contact','Cardcontact','Card','Contactrequest','Mail');
//	public $API_CONFIG = array('appKey' => LINKEDIN_APP_KEY, 'appSecret' => LINKEDIN_APP_SECRET, 'callbackUrl' => NULL);
//public $Google_API_CONFIG = array('appKey' => Google_KEY, 'appSecret' => Google_SECRET, 'callbackUrl' => 'http://localhost:8080/snagpadd/contacts/gmail_connect','email_count'=>'500');
public $Google_API_CONFIG = array('appKey' => Google_KEY, 'appSecret' => Google_SECRET, 'callbackUrl' => 'http://snagpad.com/contacts/gmail_connect','email_count'=>'500');
//public $Google_API_CONFIG = array('appKey' => Google_KEY, 'appSecret' => Google_SECRET, 'callbackUrl' => 'http://sandbox.brandmakerz.com/jsb/contacts/gmail_connect','email_count'=>'500');
public $Yahoo_API_CONFIG = array('appKey' => Yahoo_KEY, 'appSecret' => Yahoo_SECRET,'appDomain'=>Yahoo_DOMAIN,'appId'=>Yahoo_ID,'appUrl'=>SITE_URL);
	


    public function beforeFilter() {
        if (!$this->Session->check('Account.id')) {
            $this->redirect(SITE_URL);
            //$this->Session->setFlash(__('You are not authorized to acces that page. Please login to  continue.'));
            exit();
        }
		parent::beforeFilter();
        $this->layout = 'jsb_bg';
    }

    public function index($num=null) {
        if (!empty($this->data)) {
            $this->layout = 'ajax';
            $id = $this->data['account_id'];
            $contacts = $this->Contact->find('all', array('conditions' => array('Contact.account_id' => $id,'Contact.usertype'=>$this->Session->read('usertype')), 'order' => array('Contact.id DESC')));
            $this->set('contacts', $contacts);
            $this->set('account_id', $id);
            $this->render('list_contacts');
        }
        $id = $this->Session->read('Account.id');
        $this->set('account_id', $id);
        $this->set('num', $num);
    }

    public function export() {
        $this->layout = 'ajax';
        $acc_id = $this->Session->read('Account.id');
        $data = $this->Contact->findAllByAccountIdAndUsertype($acc_id,$this->Session->read('usertype'));
        //echo '<pre>';print_r($data);die;
        //$this->set('orders', $data);
        // $results = $this->ModelName->find('all', array());// set the query function
         $header_row = 'Name' . "\t" . 'Email' . "\t" . 'Phone' . "\t" .'Organization' . "\t" . 'Title' . "\t" . 'Referred by' . "\t" .  ' Frequency of contact ' . "\t" .  'Type of contact' . "\t" . 'Information' . "\t" . 'Address' . "\t" . 'Date Added' .   "\t\n";
        foreach ($data as $dat) {
			
            $header_row.= $dat['Contact']['contact_name'] . "\t" . $dat['Contact']['email'] . "\t " . $dat['Contact']['phone'] . "\t" . $dat['Contact']['organization']. "\t" . $dat['Contact']['title']. "\t" . $dat['Contact']['referred_by']. "\t" . $dat['Contact']['frequency_of_contact']. "\t" . $dat['Contact']['type_of_contact']. "\t" . $dat['Contact']['information']. "\t" . $dat['Contact']['address']. "\t" . $dat['Contact']['date_added'] ." \t \n";
		}
        //echo '<pre>';print_r($header_row);die;
        $filename = "export_" . date("Y.m.d") . ".xls";
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo($header_row);
    }

    public function show_search() {
        $this->layout = 'ajax';
        $id = $this->data['account_id'];
        $this->set('account_id', $id);
        $this->render('search');
    }

    public function show_add_contact() {
        $this->layout = 'ajax';
        
        $id = $this->data['account_id'];
        $this->set('account_id', $id);
        $this->set('edit', '2');
        $this->render('add_contact');
    }

    public function add_new_contact() {
        
        if (!empty($this->data)) {
            //echo '<pre>';print_r($this->data);die;

            $exist_contact = $this->Contact->findAllByAccountIdAndEmailAndUsertype($this->data['Contact']['account_id'], $this->data['Contact']['email'],$this->Session->read('usertype'));
            //echo '<pre>';print_r($exist_contact);die;
            if (empty($exist_contact)) {
                $data = $this->data;
                $data['Contact']['usertype']=$this->Session->read('usertype');
                $data['Contact']['date_added'] = date("Y-m-d H:i:s");
                $data['Contact']['date_modified'] = '0000-00-00 00:00:00';
				if($data['Contact']['phone']=='Phone'){ $data['Contact']['phone']=='';}
				if($data['Contact']['organization']=='Organization'){ $data['Contact']['organization']=='';}
				if($data['Contact']['title']=='Title'){ $data['Contact']['title']=='';}
				if($data['Contact']['referred_by']=='Referred By'){ $data['Contact']['referred_by']=='';}
				if($data['Contact']['information']=='Information'){ $data['Contact']['information']=='';}
				if($data['Contact']['address']=='Address'){ $data['Contact']['address']=='';}
                $this->Contact->create();
                $this->Contact->save($data);
                echo 'Contact saved successfully';
                die;
            } else {
                echo 'Contact with same email already exist.';
                die;
            }
        }
    }

    public function edit_this_contact() {
        if (!empty($this->data)) {
            $data = $this->data;
            $data['Contact']['date_modified'] = date("Y-m-d H:i:s");
            $this->Contact->id = $data['contactid'];
            $contact=$this->Contact->save($data);
			//echo '<pre>';print_r($contact);die;
			echo '<span class="column1 colour1"><input type="checkbox" name="cbox[]" class="contact_check" onclick="objDelChecked(this); uncheck();" value="'.$data['contactid'].'"><small><a href="javascript://" id="contact_'.$data['contactid'].'" onclick="show_edit_contact('.$data['contactid'].');">'.$contact['Contact']['contact_name'].'</a></small></span>
        <span class="column2 colour2"><a href="mailto:'.$contact['Contact']['email'].'">'.$contact['Contact']['email'].'</a></span>
        <span class="column3 colour3">'.show_formatted_datetime($contact['Contact']['date_added']).'</span>
        <span class="column4 colour3"><a href="javascript://" onclick="view_jobcards('.$data['contactid'].');">View</a></span>';
           
            die;
        }
    }

    public function search_contact() {
        if (!empty($this->data)) { //print_r($this->data); die;
            $this->layout = 'ajax';
            $keyword = $this->data['keyword'];
            $account_id = $this->data['account_id'];
            $query = "select * from jsb_contacts AS Contact where account_id='" . $account_id . "'";
			if($keyword==''||$keyword=='Enter Contact Name')
			{
				$query.= "";
			
			}else{
			 $query.= " and contact_name LIKE '%$keyword%'";
			}
            $query.= " order by id desc";
            $contacts = $this->Contact->query($query);
            $this->set('contacts', $contacts);
            $this->set('account_id', $account_id);
            $this->render('list_contacts');
        }
    }

    public function delete_contact() {
        //print_r($this->data); die;
		$snagcast=$this->data['network'];
        $cbox = array();
        $cbox = $this->data['cbox'];
        for ($i = 0; $i < count($cbox); $i++) {
			 $contacts = $this->Contact->find('first', array('conditions' => array('Contact.id' => $cbox[$i])));
			if($contacts['Contact']['network_contact']==1 || $snagcast)
			{
			$query1 = "delete from jsb_social_contact_request where to_email='" . $contacts['Contact']['email'] . "'";
             $this->Contactrequest->query($query1);
			}
            $query1 = "delete from jsb_contacts where id='" . $cbox[$i] . "'";
            $result = $this->Contact->query($query1);
			$this->Cardcontact->deleteAll(array('Cardcontact.contact_id'=>$cbox[$i]),false);
        }
        $this->layout = 'ajax';
        $id = $this->Session->read('Account.id');
		if($snagcast)
		{
		$condition=array('Contact.account_id' => $id,'network_contact'=>1);
		$this->set('networkdel','1');
		}
		else
		$condition=array('Contact.account_id' => $id);
		
        $contacts = $this->Contact->find('all', array('conditions' => $condition, 'order' => array('Contact.id DESC')));
        $this->set('contacts', $contacts);
        $this->set('account_id', $id);		
        $this->render('list_contacts');
    }
   	public function contact_count(){
	$contact_count=$this->Contact->find('count',array('conditions'=>array('Contact.account_id' => $this->Session->read('Account.id'),'network_contact'=>1)));
	echo $contact_count; die;
}
    public function edit_contact() {
        if (!empty($this->data)) {
            $this->layout = 'ajax';
            $contact_id = $this->data['contact_id'];
            $contact_info = $this->Contact->findById($contact_id);
            $this->set('contact', $contact_info['Contact']);
            $this->set('account_id', $contact_info['Contact']['account_id']);
            $this->set('edit', '1');
            $this->set('contactid', $contact_id);
            $this->render('add_contact');
        }
    }
	
	public function invite_contact()
	{
		$this->layout='ajax';
		$account_id=$this->Session->read('Account.id');
		$already=$this->Contactrequest->find('all',array('conditions'=>array('Contactrequest.from_id'=>$account_id)));
		$existing=array();
		if(!empty($already))
		{
			foreach($already as $al)
			{
				$existing[]=$al['Contactrequest']['profile_id'];	
			}	
		}
		
		//facebook
		if($this->Session->read('Client.Client.profile_id')!=''){
			$facebook = new Facebook(array('appId'  =>FB_APPID,'secret' => FB_APPSECRET,'cookie' => true));
				   
			$facebook->setAccessToken($this->Session->read('fb_token'));
			
			$fql = "SELECT uid,name,work,has_added_app FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='".$this->Session->read('Client.Client.profile_id')."')"; 
							$friends = $facebook->api(array('method' => 'fql.query','query' => $fql));
			if(is_array($friends) && count($friends)>0)
			{
			if(!isset($friends['error_code'])){
				$matched=array();
				
				
				foreach($friends as $friend)
				{
						if(in_array($friend['uid'],$existing))
							{
								$friend['exist']=1;	
							}else{
								$friend['exist']=0;	
							}
							$matched[]=$friend;
			
				}
			
				//if(count($matched)>0)
					$this->set('fb_friends',$matched);
			}
			}


		}
		
		//linkedin
		$arr=array();
		 $OBJ_linkedin = new LinkedIn($this->API_CONFIG);
        $OBJ_linkedin->setTokenAccess($this->Session->read('Client.linkedin.access'));
        $this->autoRender = false;
		        $response = $OBJ_linkedin->profile('~:(id,first-name,last-name,headline,email-address,picture-url,publicProfileUrl)');         
       $search_response = $OBJ_linkedin->searchPeople(":(people:(id,first-name,last-name,picture-url,site-standard-profile-request,headline),num-results)?count=100&facet=network,R");
	  
	   	$arr=xml2array($search_response['linkedin']);
		// echo '<pre>';print_r($arr);die;
	     $show_fnd=array();
		 $friends=$arr['people-search']['people']['person']; 
			foreach($friends as $frnd){
				if(!in_array($frnd['id'],$existing))
				{
					$friend['exist']=1;	
					}else{
					$friend['exist']=0;	
					}
				$show_fnd[]=$frnd;
			}
		//dump($arr);
		$this->set('friends',$show_fnd);
		$this->render('list_social_contacts');  
		//$this->render('list_social_contacts_test');
		
	}
	
	
	public function send_invite($email=NULL,$id=0,$name=NULL)
	{
		$this->layout='popup';
		
		$account=$this->Account->findById($this->Session->read('Account.id'));
		$client=$this->Client->find('first',array('conditions'=>array('Client.account_id'=>$account['Account']['id']),'fields'=>array('Client.job_a_title','Client.job_b_criteria','Client.id')));
		$contents = $this->Mail->findBySection('client_invite');
		
		$arr['TO_NAME'] = $name;
		$arr['FROM_NAME'] = $account['Account']['name'];
		//$arr['FOLLOW_URL'] = SITE_URL . '/users/verify/t:' . $hash . '/n:' . $to_email .'/r:'. $req['Contactrequest']['id'].'/u:3';
		//$url=SITE_URL . '/users/verify/t:' . $hash . '/n:' . $to_email .'/r:'. $req['Contactrequest']['id'].'/u:3';
		$content = $contents['Mail']['content'];
		foreach ($arr as $key => $val)
					$content = str_replace("~~$key~~", $val, $content);
					 $content = str_replace('~~SITE_URL~~', SITE_URL, $content);
					 $content = str_replace('~~FROM_NAME~~', $arr['FROM_NAME'], $content);
					 $content = str_replace('~~JOBA~~', $client['Client']['job_a_title'], $content);
					 $content = str_replace('~~JOBB~~', $client['Client']['job_b_criteria'], $content);
		
		if($id=='0')
		{
			$this->set('con_email','1');
		}
		$this->set('email',$email);	
		$this->set('name',$name);		
		$this->set('id',$id);
		
		$this->set('content',$content);
		$this->set('popTitle','Invite Contact');
		$this->render('connection_message');	
		
	}
	
	public function show_contact_network($acc_id)
	{
		$this->layout='jsb_bg';
		//$acc_id=$this->data['account_id'];
		$contacts=$this->Contact->find('all',array('conditions'=>array('Contact.account_id'=>$acc_id,'Contact.network_contact'=>1)));
		$this->set('contacts',$contacts);
		$this->set('network','1');
		$this->render('list_contacts');	
	}
	
	public function snagcast_index()
	{
		$this->layout='ajax';
		$oauth =new GmailOath($this->Google_API_CONFIG['appKey'], $this->Google_API_CONFIG['appSecret'], 1, 1, $this->Google_API_CONFIG['callbackUrl']);
		$getcontact=new GmailGetContacts();
		$access_token=$getcontact->get_request_token($oauth, false, true, true);
		$_SESSION['oauth_token']=$access_token['oauth_token'];
		$_SESSION['oauth_token_secret']=$access_token['oauth_token_secret'];
		$oauth_token=$oauth->rfc3986_decode($access_token['oauth_token']);		
		$this->set('oauth_token',$oauth_token);
		
		
		 YahooSession::clearSession();
		
		$hasSession = YahooSession::hasSession($this->Yahoo_API_CONFIG['appKey'],$this->Yahoo_API_CONFIG['appSecret'] ,$this->Yahoo_API_CONFIG['appId']);
		//echo '<pre>';print_r($hasSession);die;
		if($hasSession == FALSE) {
		$callback = SITE_URL.'/contacts/yahoo_connect';	
		$auth_url = YahooSession::createAuthorizationUrl($this->Yahoo_API_CONFIG['appKey'], $this->Yahoo_API_CONFIG['appSecret'], $callback);	
		
		}else{
			
			$auth_url=SITE_URL.'/contacts/yahoo_connect';
			}
			$this->set('auth_url',$auth_url);			
		$this->render('snagcast_index');	
	}
	
	
	public function snagcast_info()
	{
		$this->layout='popup';
		$this->set('popTitle','What is SnagCast ?');
		$this->render('snagcast_info');
	}
	
	public function email_connect()
	{
		$this->layout='ajax';
		$inviter = new openinviter();
		$oi_services=$inviter->getPlugins();	
		
		$inviter->startPlugin($this->data['email_provider']);
		$internal=$inviter->getInternalError();
		$inviter->login($this->data['username'],$this->data['password']);
		$contacts = $inviter->getMyContacts();
		//echo '<pre>';print_r($contacts);die;
		$this->set('contacts',$contacts);
		$this->set('con_email','1');
		
		$this->render('list_email_contacts');
		
	}
	
	
	public function show_get_email()
	{
		$this->layout='popup';
		$this->set('popTitle','Import Contacts');
		$this->render('show_get_email');	
	} 
	
	
	public function gmail_connect()
	{
		//echo $_SESSION['oauth_token_secret'];die;
		$contacts_raw=$this->Session->read('contacts_raw');		
		if(!$contacts_raw){
		$oauth =new GmailOath($this->Google_API_CONFIG['appKey'], $this->Google_API_CONFIG['appSecret'], 1, 1, $this->Google_API_CONFIG['callbackUrl']);
		$getcontact_access=new GmailGetContacts();
		$request_token=$oauth->rfc3986_decode($_GET['oauth_token']);
		
		$request_token_secret=$oauth->rfc3986_decode($_SESSION['oauth_token_secret']);
		$oauth_verifier= $oauth->rfc3986_decode($_GET['oauth_verifier']);
		$contact_access = $getcontact_access->get_access_token($oauth,$request_token, $request_token_secret,$oauth_verifier, false, true, true);
		$access_token=$oauth->rfc3986_decode($contact_access['oauth_token']);
		$access_token_secret=$oauth->rfc3986_decode($contact_access['oauth_token_secret']);
		$contacts= $getcontact_access->GetContacts($oauth, $access_token, $access_token_secret, false, true,$this->Google_API_CONFIG['email_count']);
		$this->Session->write("contacts_raw",$contacts_raw);
		}
		$all_contacts=array();
		$already=$this->Contactrequest->find('all',array('conditions'=>array('Contactrequest.from_id'=>$this->Session->read('Account.id'))));
		//echo $this->Session->read('Account.id');
		//print_r($contacts);
		$existing=array();
		if(!empty($already))
		{
			foreach($already as $al)
			{
				$existing[]=$al['Contactrequest']['to_email'];	
			}	
		}
		//echo '<pre>';print_r($existing);
		//Email Contacts
		$i=0;
		foreach($contacts as $k => $a)
		{
		$final = end($contacts[$k]);
		//echo '<pre>';print_r($final);die;
		foreach($final as $email)
		{
			if(in_array($email["address"],$existing))
			{
				$all_contacts[$i]['exist']=1;
				$all_contacts[$i]['email']=$email["address"];
			}else{
				$all_contacts[$i]['exist']=0;
				$all_contacts[$i]['email']=$email["address"];
				}
				$i++;
		//echo $email["address"] ."<br />";
		}
		}
		
		$this->set('contacts',$all_contacts);
		$this->set('contacts_from','Gmail');
		//$temocon=$this->Session->read('contacts');
		//if(!$temocon)$this->Session->write("contacts",$all_contacts);
		$this->render('list_email_contacts');
	}
	
public function yahoo_connect()
 {
 
   //echo '1'; 
   $session = YahooSession::requireSession($this->Yahoo_API_CONFIG['appKey'],$this->Yahoo_API_CONFIG['appSecret'] ,$this->Yahoo_API_CONFIG['appId']);
   
   $user = $session->getSessionedUser();
   //echo '<pre>';print_r($user);die;
   //$query = sprintf("select * from social.contacts(%s,%s) where guid='%s';");  
   //$contacts = $session->query($query);    
   $contacts = $user->getContacts(0, 10);   
   $already=$this->Contactrequest->find('all',array('conditions'=>array('Contactrequest.from_id'=>$this->Session->read('Account.id'))));
   $existing=array();
   if(!empty($already))
   {
    foreach($already as $al)
    {
     $existing[]=$al['Contactrequest']['to_email']; 
    } 
   }   
   
   //echo '<pre>';print_r($contacts);die;
   $all_emails=$all_contacts=array(); $i=0;
   foreach ($contacts->contacts->contact as $contact)
   {
    foreach ($contact->fields as $field)
    {
     if ($field->type == "email")
     {
      if(in_array($field->value,$existing))
      { $all_contacts[$i]['exist'] =1;
       $all_contacts[$i]['email']=$field->value;
      }else{
       $all_contacts[$i]['exist']=0;
       $all_contacts[$i]['email']=$field->value;
      } 
      $i++;      
     }
    }
   }
   //$_GET['data'] will be equal to "abc" at this page.
  $this->set('contacts',$all_contacts); 
  $this->set('contacts_from','Yahoo');
  $this->render('list_email_contacts');
  //echo '<pre>';print_r($emails);die;
  //$emails array has the email addresses of all the contacts.
  
 }
 public function hotmail()
 {
 }
public function hotmail_contact()
 {
	 $this->layout='ajax';
	 $already=$this->Contactrequest->find('all',array('conditions'=>array('Contactrequest.from_id'=>$this->Session->read('Account.id'))));
   $existing=array();
   if(!empty($already))
   {
    foreach($already as $al)
    {
     $existing[]=$al['Contactrequest']['to_email']; 
    } 
   }   
  
   $all_emails=$all_contacts=array(); $i=0;
	
	$datas=$this->data;
	
	foreach ($datas as $contact)
   {
	   if($contact['emails']['preferred']!='')
	   {
		$all_contacts[$i]['email']=$contact['emails']['preferred'];
		$all_contacts[$i]['name']=$contact['name'];
		if(in_array($contact['emails']['preferred'],$existing)) 
			$all_contacts[$i]['exist'] =1;
		else
			$all_contacts[$i]['exist'] =0;
		$i++;
	   }
   }
	 $this->set('contacts',$all_contacts);   
 }
 
 
	public function view_jobcards($con_id)
	{
		$this->layout='popup';
		$c_ids=$this->Cardcontact->findAllByContactId($con_id);	
		if(!empty($c_ids))
		{	$i=0;
			foreach($c_ids as $cid)
			{
				$card[$i]=$this->Card->find('first',array('conditions'=>array('Card.id'=>$cid['Cardcontact']['card_id'],'Card.recycle_bin'=>'0','Card.expired'=>'0'),'fields'=>array('Card.id','Card.company_name','Card.position_available','Card.reg_date','Card.column_status')));	
				$i++;
			}	
		}
		$data=array();
		foreach($card as $cd)
		{
			if(isset($cd['Card']))
			{
				$data[]=$cd;	
			}	
		}
		$this->set('popTitle','Jobcards');
		$this->set('cards',$data);
		$this->render('jobcards_contacts');
		//echo '<pre>';print_r($data);die;
	}
	public function invite_by_email()
	{
		$this->layout='popup';
		$this->set('popTitle','Invite Contact');
		$this->render('invite_by_email');
	}
	public function invite_by_bulk_email()
	{
		$this->layout='popup';
		$this->set('popTitle','Invite Contact');
		//$this->render('invite_by_email');
	}
	
	public function list_invited_contacts()
	{
		$this->layout='ajax';
		$acc_id=$this->Session->read('Account.id');
		$contacts=$this->Contact->find('all',array('conditions'=>array('Contact.account_id'=>$acc_id,'Contact.network_contact'=>'1')));
		$this->set('contacts',$contacts);
		$this->render('list_contacts');	
	}
	
	public function send_message()
	{
			//echo '<pre>';print_r($this->data);die;
			$this->layout='ajax';
			$account=$this->Account->findById($this->Session->read('Account.id'));
			
		$data=array('from_id'=>$account['Account']['id'],'to_name'=>$this->data['to_name'],'to_email'=>$this->data['to_email'],'req_date'=>date("Y-m-d H:i:s"));
		$this->request->data['msg']=$this->data['message'];
		$val=$this->createRequestContact($data,$account);
		if($val==1)
		{
		echo 'success';die;
		}
		else{
			echo 'exist';die;
		}
		/*
			$client=$this->Client->find('first',array('conditions'=>array('Client.account_id'=>$account['Account']['id']),'fields'=>array('Client.job_a_title','Client.job_b_criteria','Client.id')));
			$contents = $this->Mail->findBySection('client_invite');
			$content = nl2br($this->data['message']);
			$to_email=$this->data['email'];
			
			$account_exist=$this->Client->find('first',array('conditions'=>array('OR'=>array('Client.email'=>$to_email,'Client.fb_email'=>$to_email,'Client.linkedin_email'=>$to_email))));
			if(empty($account_exist))
			{ 
			   if(is_array($contents) && is_array($account)){
				$hash = sha1($this->request->data['email'] . rand(0, 100));
				//$acc_data=array('name'=>$this->data['name'],'email'=>$to_email,'password'=>md5('Password'),'usertype'=>'3','tokenhash'=>$hash);
				//$this->Account->create();
				//$new_acc=$this->Account->save($acc_data);
				
				$data=array('from_id'=>$account['Account']['id'],'profile_id'=>$this->data['profile_id'],'to_email'=>$to_email,'req_date'=>date("Y-m-d H:i:s"),'to_name'=>$this->data['name']);
				$this->Contactrequest->create();
				$req=$this->Contactrequest->save($data);
				
				
				$arr['TO_NAME'] = $this->data['name'];
				$arr['FROM_NAME'] = $account['Account']['name'];
				$arr['EMAIL']=$to_email;
				$url = SITE_URL . '/users/verify_contact/t:' . $hash . '/n:' . $to_email .'/r:'. $req['Contactrequest']['id'].'/u:3';
				
				if(!empty($to_email)&&(Validation::email($to_email, true)))
				{ 
					$email = new CakeEmail();
					$email->template('default');
					$email->viewVars(array('goto_url'=>$url));
					$email->emailFormat('html')->from($account['Account']['email'])
											   ->to($to_email)
											   ->subject($contents['Mail']['subject'])
											   ->send($content);
				}
				echo 'success';die;
				}
		  
			}else{
				echo 'error_exist';die;
			}*/
	}
		
	public function send_invite_email()
	{
		$email_id=$this->data['to_email'];
		$message=$this->data['message'];
		
		/*
		$acc=$this->Session->read('Account.id');
		$exist=$this->Contact->find('first',array('conditions'=>array('Contact.account_id'=>$acc,'Contact.email'=>$email_id)));
		if(!empty($exist))
		{
		$details=$this->Account->findById($acc);
		$message.='<br><a href="'.SITE_URL.'">Click here</a> to accept invitation.';
		if(($email_id)&&(Validation::email($email_id, true)))
		{
			$email = new CakeEmail();
			$email->template('default');
			$email->emailFormat('html')->from($details['Account']['email'])->to($email_id)->subject('Invitation to connect to SnagPad')->send($message);
		}
		
		$data=array('account_id'=>$acc,'contact_name'=>$this->data['to_name'],'usertype'=>'3','email'=>$email_id,'network_contact'=>'1','date_added'=>date("Y-m-d H:i:s"));
		$this->Contact->create();
		$this->Contact->save($data);
		echo 'success';die;
		}
		else{
			echo 'exist';die;
		}
		*/
		$acc=$this->Session->read('Account.id');
		$account=$this->Account->findById($acc);
		$data=array('from_id'=>$acc,'to_name'=>$this->data['to_name'],'to_email'=>$email_id,'req_date'=>date("Y-m-d H:i:s"));
		$val=$this->createRequestContact($data,$account);
		if($val==1)
		{
		echo 'success';die;
		}
		else{
			echo 'exist';die;
		}
			
	}
	
	public function import()
	{
        $this->autoRender = false;
		
        if (!empty($this->data['TR_file']['tmp_name'])) {
            $fileUpload = WWW_ROOT . 'tmp' . DS;
            $arr_img = explode(".", $this->data["TR_file"]["name"]);
            $ext = strtolower($arr_img[count($arr_img) - 1]);
            if ($this->data["TR_file"]['error'] == 0 && $ext == 'xls')
			 {
                $fname = removeSpecialChar($this->data['TR_file']['name']);
                $file = time() . "_" . $fname;
                if (upload_my_file($this->data['TR_file']['tmp_name'], $fileUpload . $file)) {
                    $data = new Spreadsheet_Excel_Reader();
                    $data->setOutputEncoding('utf-8');
                    $data->read($fileUpload . $file);
                    $notdone = $done=$already=$invalid=0;					
					$acc=$this->Session->read('Account.id');
					$account=$this->Account->findById($acc);
					
					$contents = $this->Mail->findBySection('client_invite');		
					$arr['FROM_NAME'] = $account['Account']['name'];		
					$content = $contents['Mail']['content'];						
					$content = str_replace('~~FROM_NAME~~', $arr['FROM_NAME'], $content);
					$this->request->data['msg']=$content;
					 
					 		
                    for ($sheet = 0; $sheet < count($data->sheets); $sheet++) {						
                        for ($row = 2; $row <= $data->sheets[$sheet]['numRows']; $row++) {
							
                            if (isset($data->sheets[$sheet]['cells'][$row][1]) && $data->sheets[$sheet]['cells'][$row][1] != '' && isset($data->sheets[$sheet]['cells'][$row][2]) && $data->sheets[$sheet]['cells'][$row][2] != '') {$ct++;
								
						
                                $name = $data->sheets[$sheet]['cells'][$row][1];
                                $email_id = $data->sheets[$sheet]['cells'][$row][2];
                               
								$data1=array('from_id'=>$acc,'to_name'=>$name,'to_email'=>$email_id,'req_date'=>date("Y-m-d H:i:s"));				
								
								$val=$this->createRequestContact($data1,$account);								
								
								switch($val)
								{
									case 0: $notdone++;break;
									case 1: $done++;break;
									case 2: $already++;break;
									case 3: $invalid++;break;
								}
                              	unset($name);
								unset($email_id);
                                unset($data1);
								
                           }
                        }// end for loop for row
                    }// end for loop for sheet
                    @unlink($fileUpload . $file);
					$msg="";
					
						if($done>0)
							$msg.=" $done Client(s) have been imported successfully.";
						if($notdone>0)
							$msg.=" $notdone Client(s) already exist into system";
							
						if($utype==1 && $already>0)
								$msg.=" $already Client(s) already under your agency";
						if($utype==2 && $already>0)								
								$msg.=" $already Client(s) already under you";
						if($invalid>0)
							$msg.=" $invalid Emails were invalid so not imported into system";
								
                        echo "success|$msg";                   
                    die();
                }
            } else {
                echo "error|Invalid File type. Only xls supported.";
                die();
            }
        }
		}
	
	function createRequestContact($data,$account)
	{
		//print_r($account['Account']['id']);
		$flag=0;
		$to_email=$data['to_email'];
		$content=nl2br($this->data['msg']);
		$account_exist=$this->Client->find('first',array('conditions'=>array('OR'=>array('Client.email'=>$to_email,'Client.fb_email'=>$to_email,'Client.linkedin_email'=>$to_email))));
		
		if(!empty($account_exist))
		{
			$data['to_account_id']=$account_exist['Client']['id'];
			if($account_exist['Client']['profile_id']!=NULL)
			$data['profile_id']=$account_exist['Client']['profile_id'];
			else
			$data['profile_id']=0;
		}
		
		$check=$this->Contactrequest->find('first',array('conditions'=>array('to_email'=>$to_email,'from_id'=>$account['Account']['id'])));	
		
		if(empty($check))
		{
			$this->Contactrequest->create();
			$this->Contactrequest->save($data);
			$req_id=$this->Contactrequest->id;
			 unset($this->Contactrequest->id);
			 $flag=1;
		}
		else
		{
			$flag=0;
			
		}
		if(empty($check))
		{
			$hash = sha1($to_email. rand(0, 100));
			$arr['TO_NAME'] = $data['to_name'];
			$arr['FROM_NAME'] = $account['Account']['name'];
			$arr['EMAIL']=$to_email;
			
			if($req_id && is_array($account_exist)){
				$contents = $this->Mail->findBySection('client_invite');
				$url = SITE_URL . '/users/verify_contact/t:' . $hash . '/n:' . $to_email .'/r:'. $req_id.'/u:3';
			}
			else
			{
				$contents = $this->Mail->findBySection('client_invite');
				$url = SITE_URL . '/users/verify_contact/t:' . $hash . '/n:' . $to_email .'/r:'. $req_id.'/u:3';
			}
			
						
				if(!empty($to_email)&&(Validation::email($to_email, true)))
				{ 
					$email = new CakeEmail();
					$email->template('default');
					$email->viewVars(array('goto_url'=>$url));
					$email->emailFormat('html')->from($account['Account']['email'])
											   ->to($to_email)
											   ->subject($contents['Mail']['subject'])
											   ->send($content);
				}	
		  	//$flag=0;
			}
			//else
				//$flag=2;
			return $flag;
	}
		

}