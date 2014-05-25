<?php
App::import('Core','Validation');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', array('functions', 'linkedin', 'xmltoarray', 'reader'));
App::import('Controller', array('Mail','Badges'));

class UsersController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
    public $uses = array('Client', 'Tempuser', 'Account', 'Linkedlogin', 'Coach', 'Friend', 'Agency', 'Adminlogin','Employer','Mail','Contact','Contactrequest');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'default';
    }

   public function NewUser($type=0,$temp=0) {
		if($type!=0)
		{
			$this->set('usertype',$type);
		}
		if(!is_numeric($type)){
			$this->set('success_contact',$type);
			$this->set('success_dup',$temp);
		}
		$this->layout = 'default';
    }

    public function session_expire() {
        $this->layout = 'ajax';
    }

    public function createSession($account_id, $usertype,$form=0) {
        $this->autoRender = false;
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
				  //check ip from share internet
				  {
					$ip=$_SERVER['HTTP_CLIENT_IP'];
				  }
				  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
				  //to check ip is pass from proxy
				  {
					$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
				  }
				  else
				  {
					$ip=$_SERVER['REMOTE_ADDR'];
				  }
        $this->Session->write('Account.id', $account_id);
        $this->Session->write('usertype', $usertype);
        $data['ip_address'] = $ip;
        $data['usertype'] = $usertype;
        $data['account_id'] = $account_id;
        $data['login_time'] = date('Y-m-d H:i:s');
        $this->Userlog->create();
        $this->Userlog->save($data);
		if($usertype==3)
			$this->Client->query("update jsb_client set last_login='".$data['login_time']."' where account_id=".$account_id);
		else if($usertype==2)
			$this->Coach->query("update jsb_coach set last_login='".$data['login_time']."' where account_id=".$account_id);

        switch ($usertype) {
			
            case 3:
				$flag=1;
			$client_info = $this->Client->findByAccountId($account_id);
				if($client_info['Client']['agency_id']!=0 && $flag==1){
					$row=$this->Account->query("select count(*) as count from jsb_accounts where id='".$client_info['Client']['agency_id']."' and find_in_set(1,activate)!=0");
					if($row[0][0]['count']==0){
						$flag=0;
						$msg='Your Agency account is inactive';	
					}
				}
				if($client_info['Client']['coach_id']!=0 && $flag==1){
					$row=$this->Account->query("select count(*) as count from jsb_accounts where id='".$client_info['Client']['coach_id']."' and find_in_set(2,activate)!=0");
					if($row[0][0]['count']==0){
						$msg='Your Coach\' account is inactive';	
						$flag=0;
					}
				}
				if($flag==1){
					$account=$this->Account->findById($account_id);		
					$activate=explode(",",$account['Account']['activate']);
				if(!in_array(3,$activate) || $account['Account']['activate']==""){
					$flag=0;
					if($client_info['Client']['agency_id']==0 && $client_info['Client']['coach_id']==0)
						$msg="Your account needs to be verified, please check your inbox.";
					else
						$msg="Your account is inactive";
				}
				if($flag==1){
		        $this->Session->write('Client', $client_info);
                $this->Session->write('clientid', $client_info['Client']['id']);

                if ($client_info['Client']['linkedin_id'] != '')
                    $this->Session->write('Client.linkedin', unserialize($client_info['Client']['linkedin_token']));
                if ($client_info['Client']['fb_token'] != '')
                    $this->Session->write('fb_token', $client_info['Client']['fb_token']);
				/////////
				$ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));  
		if($ip_data && $ip_data->geoplugin_countryName != null){
			$ipcountry = $ip_data->geoplugin_countryCode;
			$this->Session->write('ipcountry', $ipcountry );
			//$result['city'] = $ip_data->geoplugin_city;
		}
		//$this->Session->write('ipcountry', 'IN');
		//////////
				if($client_info['Client']['login']==1 && $form==1)
					echo 'coach_added_client';										  
				if($client_info['Client']['login']==1 && $form==0)
					{ //echo 'coach_added_client';
					$this->redirect('/info/terms_of_service/1');
					}						
				
				if (!isset($this->data['act']) && $form==0)
				      $this->redirect('/jobcards/profileWizard');
					  
				}
				else{
						if($form==0)
						{	
		                    $this->Session->setFlash($msg);
							$this->redirect('/');
						}else
							echo $msg;
					}
				}
                break;
           case 4: $coach_info = $this->Employer->findByAccountId($account_id);
                $this->Session->write('Employer', $coach_info);
				if($form==0)
                $this->redirect('/');
                break;

            case 2: $coach_info = $this->Coach->findByAccountId($account_id);
                $this->Session->write('Coach', $coach_info);
                break;
            case 1: $agency_info = $this->Agency->findByAccountId($account_id);
                $this->Session->write('Agency', $agency_info);
                break;
        }
    }

 public function upadteSubscriptionAccount($email,$usertype,$plan_due_date) {		
        $this->autoRender = false;		
		$account=$this->Account->findByEmail($email);
		if($usertype=='2')
		 $query = "update jsb_coach set plan_due_date='".$plan_due_date."' where account_id=".$account['Account']['id'];
		 else if($usertype=='1')
		 $query = "update jsb_agency set plan_due_date='".$plan_due_date."' where account_id=".$account['Account']['id'];
		  else if($usertype=='3')
		  {
		 $query = "update jsb_client set plan_due_date='".$plan_due_date."' where account_id=".$account['Account']['id'];
		 @mail('gautam.kumar@i-webservices.com','Plan due date query', "Payment sucess.<br />details are = <pre>".print_r($email , true).print_r($usertype , true).print_r($plan_due_date , true).print_r($account , true).print_r($query , true)."</pre>");
		  }
        $this->Account->query($query);
		//$this->createAccount($this->request->data['usertype']);
		return;
 }
 public function createSubscriptionAccount($datas) {		
        $this->autoRender = false;
		foreach( $datas as $key=>$data)
		{
			$this->request->data[$key]=$data;
		}
		$this->createAccount($this->request->data['usertype']);
		return;
 }
    public function createAccount($usertype=3, $createSession=0, $loop=0) {		
        $this->autoRender = false;
		//print_r($this->data);
		$checkemail=1;
		if($loop=='1' && filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)!=$this->data['email']) 
		$checkemail=0;
		if($checkemail==1){
        $email_exist = $this->Account->findByEmail($this->data['email']);
        if (isset($this->data['coach_id']) && $this->data['coach_id'] == '')
            unset($this->request->data['coach_id']);
        if (isset($this->data['agency_id']) && $this->data['agency_id'] == '')
            unset($this->request->data['agency_id']);
        if (empty($email_exist)) {

            $this->Account->create();
            $hash = sha1($this->request->data['email'] . rand(0, 100));
            $this->request->data['tokenhash'] = $hash;
            $this->request->data['password'] = md5('Password');   // '3'=>Client
            $this->Account->save($this->request->data);
            $this->request->data['account_id'] = $this->Account->id;
            $this->request->data['usertype'] = $usertype;
            $account_id = $this->Account->id;
            unset($this->Account->id);
            switch ($usertype) {
                case 1:$this->createAgency();
                    break;
                case 2: if ($this->Session->read('usertype') == 1)
                        $this->request->data['agency_id'] = $this->Session->read('Account.id');

                    $this->createCoach();
                    break;
                case 3: 
					if ($this->Session->check('Account.id') || $createSession == 1) {					
                        if ($this->Session->read('usertype') == 1)
                            $this->request->data['agency_id'] = $this->Session->read('Account.id');
                        elseif ($this->Session->read('usertype') == '2') {
                            $this->request->data['coach_id'] = $this->Session->read('Account.id');
                            $this->request->data['agency_id'] = $this->Session->read('Coach.Coach.agency_id');
                        }
                        $this->createClient(1);
                    }
                    else
					{
                        $this->createClient(0);
					}
                    break;
                case 4: 
					if($this->Session->check('usertype'))
						$this->createEmployer(1);
					else
						$this->createEmployer(0);
                    break;
            }
            if ($createSession == 1)
                $this->createSession($account_id, $this->request->data['usertype']);
				if($loop==1)
					return 1;
        }
        else {
            switch ($usertype) {
                case 3: $already = $this->Client->findByAccountId($email_exist['Account']['id']);
                    if (empty($already)) {
                        $this->request->data['account_id'] = $email_exist['Account']['id'];
                        if ($this->Session->read('usertype') == 1)
                            $this->request->data['agency_id'] = $this->Session->read('Account.id');
                        elseif ($this->Session->read('usertype') == '2') {
                            $this->request->data['coach_id'] = $this->Session->read('Account.id');
                            $this->request->data['agency_id'] = $this->Session->read('Coach.Coach.agency_id');
                        }
                        $this->request->data['usertype'] = 3;
                        $this->createClient(1);
						if($loop==1)
							return 1;
                    } elseif ($loop == 0) {
                        echo 'Error';
                        die;
                    }
					else{
						$utype=$this->Session->read('usertype');	
						switch($utype){
						case 0: return 0;break;
						case 1: $row=$this->Client->findByAgencyIdAndAccountId($this->Session->read('Account.id'),$email_exist['Account']['id']);
						if(is_array($row))
							return 2;
						else
							return 0;
							break;
						case 2: $row=$this->Client->findByCoachIdAndAccountId($this->Session->read('Account.id'),$email_exist['Account']['id']);
						if(is_array($row))
							return 2;
						else
							return 0;
							break;

						}
					}
					 break;
                case 2:
                    $already = $this->Coach->findByAccountId($email_exist['Account']['id']);
                    if (empty($already)) {
                        $this->request->data['account_id'] = $email_exist['Account']['id'];
                        if ($this->Session->read('usertype') == 1)
                            $this->request->data['agency_id'] = $this->Session->read('Account.id');

                        $this->request->data['usertype'] = 2;
                        $this->createCoach(1);
						return 1;
                    } elseif ($loop == 0) {
                        echo 'Error';
                        die;
                    }
					else{
							$utype=$this->Session->read('usertype');	
						switch($utype){
						case 0: return 0;break;
						case 1: $row=$this->Coach->findByAgencyIdAndAccountId($this->Session->read('Account.id'),$email_exist['Account']['id']);
						if(is_array($row))
							return 2;
						else
							return 0;
							break;
						}
					
					}
					
					 break;
                 case 1:
                    $already = $this->Agency->findByAccountId($email_exist['Account']['id']);
                    if (empty($already)) {
                        $this->request->data['account_id'] = $email_exist['Account']['id'];
                        $this->request->data['usertype'] = 1;
                        $this->createAgency();
						return 1;
                    } elseif ($loop == 0) {
                        echo 'Error';
                        die;
                    } else return 0; 
					break;
                    case 4:
                    $already = $this->Employer->findByAccountId($email_exist['Account']['id']);
                    if (empty($already)) {
                        $this->request->data['account_id'] = $email_exist['Account']['id'];
                        $this->request->data['usertype'] = 4;
					if($this->Session->check('usertype'))
						$this->createEmployer(1);
					else
						$this->createEmployer(0);

						return 1;
                    } elseif ($loop == 0) {
                        echo 'Error';
                        die;
                    } else return 0; break;
            }
            if ($createSession == 1)
                $this->createSession($email_exist['Account']['id'], $usertype);
        }
		}else
		return 3;
    }

    public function createClient($flag,$loop=0) {
        $Mail = new MailController;
        $Mail->constructClasses();
        if ($flag == 1) {
            $account_id = $this->request->data['account_id'];
			$row=$this->Client->findByAccountId($account_id);
			if(!is_array($row)){
            $this->request->data['reg_date'] = date('Y-m-d H:i:s');
            $this->request->data['login'] = '1';
            $client_data = $this->request->data;			
            $this->Client->create();
            $client_info = $this->Client->save($client_data);
            $folderpath = WWW_ROOT . 'files' . DS . $client_info['Client']['id'];
            if (!is_dir($folderpath))
                mkdir($folderpath, 0777);
			if($loop==1)
				return 1;
			}
			elseif($loop==1)
				return 0;
            $Mail->sendMail($this->request->data['account_id'], "client_added");
            $client_data['usertype'] = 3;
            $this->createTempUser($client_data);
            $query = "update jsb_accounts set usertype=concat_ws(',',usertype,'3'),activate=concat_ws(',',activate,'3') where id='$account_id'";
            $this->Account->query($query);
            unset($this->Client->id);
        } else {			
            $arr['FOLLOW_URL'] = SITE_URL . '/users/verify/t:' . $this->request->data['tokenhash'] . '/n:' . $this->request->data['email'] . '/u:3';
			if(isset($this->request->data['plan_taken_date']))
			{
				$arr['FOLLOW_URL'] .='/s:'.$this->request->data['subscription'].'/pt:'.$this->request->data['plan_taken_date'];				
			}
			if(isset($this->request->data['plan_due_date']))
				$arr['FOLLOW_URL'] .='/pd:'.$this->request->data['plan_due_date'];
						
            $Mail->sendMail($this->request->data['account_id'], "client_verify", $arr);
        
		if(isset($this->data['agency_id'])){
		   $account_id = $this->request->data['account_id'];
            $this->request->data['reg_date'] = date('Y-m-d H:i:s');
            $this->request->data['login'] = '1';
            $client_data = $this->request->data;
            $this->Client->create();			
            $client_info = $this->Client->save($client_data);			
			
            $folderpath = WWW_ROOT . 'files' . DS . $client_info['Client']['id'];
            if (!is_dir($folderpath)) {
                mkdir($folderpath, 0777);
            }
		}
		}
    }
	
	    public function createCoach($loop=0) {
        $Mail = new MailController;
        $Mail->constructClasses();
        $account_id = $this->request->data['account_id'];
        $this->request->data['reg_date'] = date('Y-m-d H:i:s');
        $coach_data = $this->request->data;
        $this->Coach->create();
        $client_info = $this->Coach->save($coach_data);
        $Mail->sendMail($this->request->data['account_id'], "coach_added");
        $coach_data['usertype'] = 2;
        $this->createTempUser($coach_data);
        $query = "update jsb_accounts set usertype=concat_ws(',',usertype,'2'),activate=concat_ws(',',activate,'2') where id='$account_id'";
        $this->Account->query($query);
		if($loop==1)
			return 1;
        unset($this->Coach->id);
    }

    public function createAgency($loop=0) {
        $Mail = new MailController;
        $Mail->constructClasses();
        $account_id = $this->request->data['account_id'];
        $this->request->data['reg_date'] = date('Y-m-d H:i:s');
		$this->request->data['plan_taken_date']=$this->request->data['reg_date'];
		$this->request->data['plan_due_date']=date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')+1));
        $agency_data = $this->request->data;
        $this->Agency->create();
        $client_info = $this->Agency->save($agency_data);
        $Mail->sendMail($this->request->data['account_id'], "agency_added");
        $coach_data['usertype'] = 1;
        $this->createTempUser($agency_data);
        $query = "update jsb_accounts set usertype=concat_ws(',',usertype,'1'),activate=concat_ws(',',activate,'1') where id='$account_id'";
        $this->Account->query($query);
		if($loop==1)
			return 1;
        unset($this->Agency->id);
    }
    
    public function createEmployer($flag=1) {
        $Mail = new MailController;
        $Mail->constructClasses();
        $account_id = $this->request->data['account_id'];
        $this->request->data['reg_date'] = date('Y-m-d H:i:s');
        $agency_data = $this->request->data;		
        $this->Employer->create();
        $client_info = $this->Employer->save($agency_data);
		if($flag==1){        	
       		$query = "update jsb_accounts set usertype=concat_ws(',',usertype,'4'), activate=concat_ws(',',activate,'4') where id='$account_id'";
        	$this->Account->query($query);
			$Mail->sendMail($this->request->data['account_id'], "employer_added");
		}else
		{
			$query = "update jsb_accounts set usertype=concat_ws(',',usertype,'4') where id='$account_id'";
       		$this->Account->query($query);
		}
		unset($this->Employer->id);
    }

    public function deleteClient($client_id) {
        $this->layout = 'ajax';
        $clientArr = explode(",", $client_id);		
        $clients = $this->Client->query("select id from jsb_client where account_id in ($client_id)");
        $clientid = '';
        foreach ($clients as $client) {
            $clientid.=$client['jsb_client']['id'] . ",";
            if (is_dir(WWW_ROOT . 'files' . DS . $client['jsb_client']['id']))
			rename(WWW_ROOT . 'files' . DS . $client['jsb_client']['id'], WWW_ROOT . 'files' . DS . $client['jsb_client']['id'].'_deleted_'.date('Y-m-d'));
                    //rrmdir(WWW_ROOT . 'files' . DS . $client['jsb_client']['id']);
        }
       $this->Account->query("update jsb_accounts set activate=replace(activate,',3',''),usertype=replace(usertype,',3','') where id in ($client_id)");
		$this->Account->query("update jsb_accounts set activate=replace(activate,'3',''),usertype=replace(usertype,'3','') where id in ($client_id)"); 
		      
        $this->Account->query("delete from jsb_accounts where usertype='' AND id in ($client_id)");
		
        if ($clientid !== '') {
            $clientid = substr($clientid, 0, -1);
            $this->Client->deleteAll(array('Client.account_id' => $clientArr));
            $this->Client->query("delete from jsb_card where client_id in ($clientid)");			
        }
        $this->autoRender = false;
    }


    public function createTempUser($data) {
		/*
        $tempdata = array('user_id' => $data['account_id'], 'email' => $data['email'], 'name' => $data['name'], "usertype" => $data['usertype']);
        $this->Tempuser->create();
        $this->Tempuser->save($tempdata);
        if ($this->Session->check('Account.id')) {
            switch ($this->Session->read('usertype')) {
                case 0:break;
                case 2: $otherid = $this->Tempuser->findByUserIdAndUsertype($this->Session->read('Coach.Coach.agency_id'), 1);

                    $this->Friend->create();
                    $this->Friend->save(array('toid' => $this->Tempuser->id, 'fromid' => $otherid['Tempuser']['id']));
                    unset($this->Friend->id);
                    $this->Friend->create();
                    $this->Friend->save(array('fromid' => $this->Tempuser->id, 'toid' => $otherid['Tempuser']['id']));
                    unset($this->Friend->id);
                case 1: $otherid = $this->Tempuser->findByUserIdAndUsertype($this->Session->read('Account.id'), $this->Session->read('usertype'));
                    $this->Friend->create();
                    $this->Friend->save(array('toid' => $this->Tempuser->id, 'fromid' => $otherid['Tempuser']['id']));
                    unset($this->Friend->id);
                    $this->Friend->create();
                    $this->Friend->save(array('fromid' => $this->Tempuser->id, 'toid' => $otherid['Tempuser']['id']));
                    unset($this->Friend->id);
                    break;
                default:break;
            }
        }
		*/
    }

    public function signup($type=0,$agency_id=0) {
		if($type!=0)
			$this->set('usertype',$type);
		if($agency_id!=0)
			$this->set('agency_id',$agency_id);
        $this->layout = 'popup';
        $this->set("popTitle", "SIGN UP");
        $this->render('signup');
		
    }

    public function verify() {
        if (!empty($this->passedArgs['n']) && !empty($this->passedArgs['t']) && !empty($this->passedArgs['u'])) {
            $name = $this->passedArgs['n'];
            $tokenhash = $this->passedArgs['t'];
            $usertype = $this->passedArgs['u'];
			
            $results = $this->Account->findByEmail($name);

            $activates = explode(",", $results['Account']['activate']);
            //check if the user is already activated
            if (!in_array($usertype, $activates) && $usertype > 0 && $usertype < 5) {
                if ($results['Account']['tokenhash'] == $tokenhash) {
					
                    $this->request->data['email'] = $results['Account']['email'];
                    $this->request->data['name'] = $results['Account']['name'];
                    $this->request->data['account_id'] = $results['Account']['id'];
					if (isset($this->passedArgs['s'])&& !empty($this->passedArgs['s']))
					 	 $this->request->data['subscription'] = $this->passedArgs['s'];
					if (isset($this->passedArgs['pt'])&& !empty($this->passedArgs['pt']))
					 	 $this->request->data['plan_taken_date'] = $this->passedArgs['pt'];
					if (isset($this->passedArgs['pd'])&& !empty($this->passedArgs['pd']))
					 	 $this->request->data['plan_due_date'] = $this->passedArgs['pd'];					
					
					if($usertype==3)
                    $this->createClient(1);
					else
					$this->createEmployer(1);
                    $this->Session->write('firstTime', '1');
                    $this->createSession($results['Account']['id'], $usertype);
					
                } else {
                    $this->Session->setFlash('Your registration failed please try again');
                    $this->redirect('/users/NewUser');
                }
            } else {
                $this->Session->setFlash('Token has alredy been used');
                $this->redirect('/users/NewUser');
            }
        } else {
            $this->Session->setFlash('Token corrupted. Please re-register');
            $this->redirect('/users/NewUser');
        }
    }
	
	public function verify_contact()
	{
		 if (!empty($this->passedArgs['n']) && !empty($this->passedArgs['t']) && !empty($this->passedArgs['u'])) {
            $name = $this->passedArgs['n'];
            $tokenhash = $this->passedArgs['t'];
            $usertype = $this->passedArgs['u'];
			if(!empty($this->passedArgs['r']))
			{
				$req=$this->passedArgs['r'];	
			}
			if(isset($req))
				{
						$info=$this->Contactrequest->findById($req);
						$account=$this->Account->findById($info['Contactrequest']['from_id']);
						if(!empty($info) && $info['Contactrequest']['accepted']!=1)
						{
							$this->send_accept_mail($info['Contactrequest']['id']);
							$this->Contactrequest->id=$info['Contactrequest']['id'];
							$this->Contactrequest->saveField('accepted',1);												
													
							$client=$this->Client->findByAccountId($account['Account']['id']);
							$Badges = new BadgesController;	
    						$Badges->constructClasses();							
							$Badges->badgesResponceUpdate(19,$client['Client']['id']);
							$this->redirect(SITE_URL.'/users/NewUser/'.$account['Account']['name'].'/1');
							//die;
						}
						
				}
				
			$this->redirect(SITE_URL.'/users/NewUser/'.$account['Account']['name'].'/0');	
					
		 }
		
	}
	
	
	
	public function send_accept_mail($req_id)
	{
		$info=$this->Contactrequest->findById($req_id);
		//$to_user_info=$this->Account->findById($info['Contactrequest']['to_account_id']);
		$from_user=$this->Account->	findById($info['Contactrequest']['from_id']);
		$contents = $this->Mail->findBySection('contact_accept_mail');
		$arr['TO_NAME'] = $from_user['Account']['name'];
		$arr['FROM_NAME'] = "The SnagPad Team";
		$arr['EMAIL']=$from_user['Account']['email'];
				
		$content = $contents['Mail']['content'];
		foreach ($arr as $key => $val)
			$content = str_replace("~~$key~~", $val, $content);
			$content = str_replace('~~SITE_URL~~', SITE_URL, $content);
			$content = str_replace('~~CONTACTNAME~~', $info['Contactrequest']['to_name'], $content);
			
		if(!empty($from_user['Account']['email'])&&(Validation::email($from_user['Account']['email'], true)))
		{ 
			$cakemail = new CakeEmail();
			$cakemail->template('default');
			$cakemail->emailFormat('html')->from('support@snagpad.com')
										   ->to($from_user['Account']['email'])
										   ->subject($contents['Mail']['subject'])
											->send($content);
		}
		//Add to contacts
		$data=array('account_id'=>$info['Contactrequest']['from_id'],'contact_name'=>$info['Contactrequest']['to_name'],'usertype'=>3,'email'=>$info['Contactrequest']['to_email'],'network_contact'=>1);
		 $exist_contact = $this->Contact->findAllByAccountIdAndEmailAndUsertype($data['account_id'], $data['email'],$data['usertype']);
		//print_r($exist_contact);
		$this->Contact->create();
		 if(!empty($exist_contact)) { $this->Contact->id = $exist_contact[0]['Contact']['id'];}
		 else{$data=array('date_added'=>date("Y-m-d H:i:s"));}
		$this->Contact->save($data);
		
		return;
				
	}
	
	public function success_new_contact($name,$flag=1)
	{
		$this->layout='popup';
		$this->set('popTitle','Success');
		if($flag==1)
		{
			$msg="Thank You! You will start to receive weekly updates from ".$name;
		}
		else
			$msg="Sorry! you have already added in job search network of ".$name;
		$this->set('msg',$msg);
		$this->render('net_contact_success');
		
	}

    public function login($type=0) {
	    $this->layout = 'popup';
		$qrystrdata=$this->request->query;
		$this->set("qrystring",$qrystrdata);
	    if ($this->request->is('ajax')) {
			if($type!=0)
				$this->set('usertype',$type);
            if ($this->request->is('post')) {
                $username = $this->data['login_email'];
                $user = $this->Account->findByEmail($username);
                $account_type = explode(",", $user['Account']['usertype']);
                $active = explode(",", $user['Account']['activate']);
                if ((md5($this->data['TR_login_password']) == $user['Account']['password']) && in_array($this->data['usertype'], $account_type)) {
                    if (!in_array($this->data['usertype'], $active)) {
                        $user = '';
                        if ($this->data['usertype'] == '2') {
                            echo 'Your account has been deactivated by your agency.Please contact your agency.';
                        } else {
                            echo 'Your account needs to be verified, please check your inbox.';
                        }
                        die;
                    } else {
						$checksub=$this->checkSubscription($user['Account']['id'], $this->data['usertype']);
						if($checksub)
						{
							echo $checksub; 
							die;
						}
						else
						{
							$this->Session->write('swd',$this->data['TR_login_password']);
							$this->createSession($user['Account']['id'], $this->data['usertype'],1);
							$this->autoRender = false;
						}
                    }
                } else {
                    echo 'Invalid Username or Password!';
                    die;
                }
            }
        } 
		else {
            $this->set("popTitle", "SIGN IN");
        }
    }
 public function checkSubscription($accountid, $usetype)
 {
	 $error="";
	 switch($usetype)
	 {
		/* case 1: 
		 	$data=$this->Agency->findByAccountId($accountid);
			if($data['Agency']['plan_due_date']!='0000-00-00' && $data['Agency']['plan_due_date']<date('Y-m-d') )
			$error= "Your subscription has expired. Please contact to administrator.";
			break;*/
		case 2: 
		 	$data=$this->Coach->findByAccountId($accountid);
			if($data['Coach']['plan_due_date']!='0000-00-00' && $data['Coach']['plan_due_date']<date('Y-m-d') )
			$error= "Your subscription has expired. Please contact to administrator.";
			/*else if($data['Coach']['plan_due_date']!='0000-00-00' && $data['Coach']['plan_due_date']>=date('Y-m-d',strtotime(date("Y-m-d", strtotime(date('Y-m-d'))) . " -3 day")))
			{
			$this->Session->write('subscription_expired',$data['Coach']['plan_due_date']);
			$this->Session->write('subscription_expired_show','1');
			}*/
			break;
		case 3: 
		 	$data=$this->Client->findByAccountId($accountid);
			if($data['Client']['subscription']=='1' && $data['Client']['plan_due_date']<date('Y-m-d') )
				$error= "Your Trial Period has expired. Payment is required to continue. To Pay <a href='".SITE_URL."/Info/pricing/".$accountid."'>Click Here</a>";
			else if($data['Client']['plan_due_date']!='0000-00-00' && $data['Client']['plan_due_date']<date('Y-m-d') )
				$error= "Your subscription has been expired. Please contact to administrator.";
			break;				
	 }
	 return $error;
 }
    public function forgotpass($type=0) {
        $this->layout = 'popup';
		if($type!=0)
			$this->set('usertype',$type);
        $this->set('popTitle', 'Forget Password');
        $this->render('forgot_password');
    }

    public function forgot_pass_mail() {
        if (!empty($this->data)) {
            $mail = $this->data['email'];
            $type = $this->data['type'];
            $user = $this->Account->find('first', array('conditions' => array('Account.email' => $mail)));
            if (!empty($user)) {
                $usertype = explode(',', $user['Account']['usertype']);
                //echo '<pre>';print_r($usertype);die;
                if (in_array($type, $usertype)) {
                    $Mail = new MailController;
                    $Mail->constructClasses();
					$code = mt_rand(100000, 999999);
                   // $resetcode = md5($tempPass);
                    $this->Account->id = $user['Account']['id'];
                    $this->Account->saveField('resetcode', $code);
					$arr['RESET_PASSWORD_URL']="/users/recover/u:".$user['Account']['id']."/n:".$code."/t:".$type;
					$arr['NORESET_PASSWORD_URL']="/users/recover_deny/u:".$user['Account']['id']."/n:".$code;
                    $Mail->sendMail($user['Account']['id'], "change_password",$arr);
                    echo 'success';
                    die;
                } else {
                    echo 'Error';
                    die;
                }
            } else {
                echo 'Error';
                die;
            }
        }
    }
	public function recover()
	{
		$this->layout = 'cms_page';
		$userdetails=$this->passedArgs;		
		$user = $this->Account->find('first', array('conditions' => array('Account.id' => $userdetails['u'],'Account.resetcode'=>$userdetails['n'])));		
		$this->set("user",$user);
		$this->set("type",$userdetails['t']);	
	}
	public function recover_deny()
	{
		$this->layout = 'cms_page';
		$userdetails=$this->passedArgs;		
		$user = $this->Account->find('first', array('conditions' => array('Account.id' => $userdetails['u'])));
		if (!empty($user['Account']['resetcode'])) {		
			$this->Account->id = $userdetails['u'];
        	$this->Account->saveField('resetcode','');
			$this->set("msg","We've recorded that you didn't ask to reset your password. You can use your current password to log into your account, and you don't need to do anything else");
		}
		else
		$this->set("msg","You may have already clicked this link. If so, we've already recorded that you didn't ask to reset your password and you can use your current password to log into your account.");
	}

public function reset_password()
{
	$arr['password']=md5($this->data['Account']['new_password']);	
	$arr['resetcode']='';
	$this->Account->id=$this->data['Account']['id'];
	$this->Account->save($arr);
	echo 'Password has been updated';
	//$this->Session->write('swd',$this->data['Account']['new_password']);
   // $this->createSession($user['Account']['id'], $this->data['Account']['type'],1);
	$this->autoRender=false;
}
    public function fblogin($redirect=null,$agency_id=0) {	
		
        if (empty($_REQUEST['code'])) {
            $dialog_url = "http://graph.facebook.com/oauth/authorize?client_id="
                    . FB_APPID . "&redirect_uri=" . urlencode(SITE_URL . "/users/fblogin?agency_id=".$agency_id) . "&scope=email,read_stream,publish_stream,user_work_history,friends_work_history,user_location,friends_location,user_education_history,offline_access,friends_education_history";

            echo("<html><body><script> top.location.href='" . $dialog_url . "'</script></body></html>");
        } else {
			
			$agency_id=$_REQUEST['agency_id'];
			
            $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
                    . FB_APPID . "&client_secret="
                    . FB_APPSECRET . "&code=" . $_REQUEST['code'] . "&redirect_uri=" . urlencode(SITE_URL . "/users/fblogin?agency_id=".$agency_id) ;

            $access_token = file_get_contents($token_url);
            $graph_url = "https://graph.facebook.com/me?" . $access_token;

            $user = json_decode(file_get_contents($graph_url));
			
            $access = explode('&', $access_token);
            $access = substr($access[0], 13);
            $profileid = $user->id;
			//print_r($agency_id);
			//print_r($user->email);die;	
            $arr = $this->Client->find('first', array('conditions' => array('OR' => array('Client.fb_email' => $user->email, 'Client.email' => $user->email, 'Client.linkedin_email' => $user->email)), 'fields' => array('Client.id', 'Client.account_id', 'Client.email')));
            $this->Session->write('fb_token', $access);
            if ($this->Session->check('Client.Client')) {
                $already_fb = $this->Client->find('first', array('conditions' => array('Client.id' => $this->Session->read('Client.Client.id')), 'fields' => array('Client.fb_email', 'Client.profile_id')));
                //echo '<pre>';print_r($already_fb);die;
                $ch = $this->check_exist_id($user->email);
				
                if ($ch != '1') {
                    $this->Client->query('update jsb_client set profile_id="' . $profileid . '",fb_token="' . $access . '",fb_email="' . $user->email . '" where id="' . $this->Session->read('Client.Client.id') . '"');
					$this->redirect(array('controller'=>'jobcards','action'=>'profileWizard'));
                } else {
                    //echo 'user_exist';die;
                    $this->redirect(array('controller' => 'jobcards', 'action' => 'user_exist_error'));
                }
            } elseif (!empty($arr)) {

                $this->Client->query('update jsb_client set profile_id="' . $profileid . '",fb_token="' . $access . '",fb_email="' . $user->email . '" where id="' . $arr['Client']['id'] . '"');
                $this->createSession($arr['Client']['account_id'], 3);
            } else {

                $date = date('Y-m-d H:i:s');
                $data = array('profile_id' => $profileid, 'name' => $user->name, 'email' => $user->email, 'fb_email' => $user->email, 'usertype' => 3, 'reg_date' => $date, 'date_allocated' => $date,'agency_id'=>$agency_id);
                if (isset($user->location)) {
                    $location = $user->location->name;
                    $city = explode(", ", $location);
                    $data['city'] = $city[0];
                    $data['country'] = $city[1];
                }
                $this->request->data = $data;
				//print_r($this->data); die;
               $this->createAccount('3', 1);
            }
        }
    }

    public function check_exist_id($email) {
        $temp = $this->Client->find('first', array('conditions' => array('OR' => array('Client.email' => $email, 'Client.fb_email' => $email)), 'fields' => array('Client.id')));


        $flag = 0;

        if (!empty($temp) && ($temp['Client']['id'] != $this->Session->read('clientid'))) {
            $flag = 1;
        }
        return $flag;
    }

    public function user_exist_error() {
         $this->layout = 'popup';
        $clientid = $this->Session->read('Client.Client.id');
        $client = $this->Client->findById($clientid);
        $this->set('client', $client);
        $this->set('popTitle', 'Social id linking');
        $this->render('user_exist_error');
    }

    public function linked() {
        $this->layout = 'popup';
        $this->set("popTitle", "Enter Email to attach your Linkedin Profile");
    }

    public function linked_mail() {
        //mail body
        $this->autoRender = false;

        $this->Client->query("update jsb_linked_login set email='" . $this->data['email'] . "',linkedin_token='" . serialize($this->Session->read('Client.linkedin')) . "' where rand_key='" . $this->Session->read('rand_key') . "'");
        // $ms = 'Your login ID is: ' . $client['Account']['email'];
        //$ms.='<br>';
        //$ms.='Your password is: Password';
        //$ms.='<br>';
        $ms = 'Click on the link below to confirm your email ';
        $ms.='http://localhost/jsb/users/confirm/t:' . $this->Session->read('rand_key') . '/n:' . $this->data['email'] . '';
        $ms = wordwrap($ms, 70);
        $this->Session->write('linksubmit', 1);
        //send mail
        $email = new CakeEmail();
        $email->emailFormat('html')
                ->from('support@snagpad.com')
                ->to($this->data['email'])
                ->subject('Confirm Registration for SnagPad.')
                ->send($ms);
    }

    public function confirm() {
        // $rand_key = $this->passedArgs['n'];
        $rand_key = $this->passedArgs['t'];
        $data = $this->Linkedlogin->findByRandKey($rand_key);
        $data = $data['Linkedlogin'];
        $this->autoRender = false;
        //  $this->Linkedlogin->query("delete from jsb_linked_login where rand_key='$rand_key'");

        if (is_array($data) && count($data) > 0) {
            $row = $this->Client->findByEmail($data['email']);
            $row = $row['Client'];
            if (is_array($row)) {
                $sql = "update jsb_client set linkedin_id='$data[linkedin_id]',linkedin_token='$data[linkedin_token]' where id='$row[id]'";

                $this->Client->query($sql);
                $this->createSession($row['account_id'], 3);
            } else {
                $this->request->data['name'] = $data['name'];
                $this->request->data['email'] = $data['email'];
                $this->request->data['linkedin_id'] = $data['linkedin_id'];
                $this->request->data['linkedin_token'] = $data['linkedin_token'];
                $this->request->data['password'] = md5('Password');
                $this->request->data['date_added'] = date('Y-m-d H:i:s');
                $this->request->data['usertype'] = $this->request->data['activate'] = '3';
                //echo "<pre>";print_r($this->request->data);die;
                $this->createAccount('3', 1);
            }
        }
        else
            $this->redirect('/users/login');
    }

    public function logout() {
        $date = date('Y-m-d H:i:s');
        $this->Userlog->query("update jsb_user_log set logout_time='$date' where account_id='" . $this->Session->read('Account.id') . "' and usertype='" . $this->Session->read('usertype') . "' and logout_time='0000-00-00 00:00:00'");
        if ($this->Session->check('Client')) {
            $this->Session->delete('Client');
            $this->Session->delete('clientid');
        }
		 if ($this->Session->check('Employer')) {
            $this->Session->delete('Employer');
        }
		if ($this->Session->check('Coach'))
            $this->Session->delete('Coach');
        $this->Session->delete('Account');
		        $this->Session->delete('usertype');
        if ($this->Session->check('rand_key'))
            $this->Session->delete('rand_key');
		if ($this->Session->check('Message'))
            $this->Session->delete('Message');	
        if ($this->Session->check('linksubmit'))
            $this->Session->delete('linksubmit');
        if (!isset($this->data['act']))
            $this->redirect('/');
        else
            $this->redirect('/Snagplugin');
    }

    public function import($usertype) {
        $this->autoRender = false;

        if (!empty($this->data['TR_file']['tmp_name'])) {
            $fileUpload = WWW_ROOT . 'tmp' . DS;
            $arr_img = explode(".", $this->data["TR_file"]["name"]);
            $ext = strtolower($arr_img[count($arr_img) - 1]);
            if ($this->data["TR_file"]['error'] == 0 && $ext == 'xls') {// && ($this->data["TR_file"]['type'] == 'application/vnd.ms-excel' || $this->data["TR_file"]['type'] == 'application/x-msexcel')) {
                $fname = removeSpecialChar($this->data['TR_file']['name']);
                $file = time() . "_" . $fname;
                if (upload_my_file($this->data['TR_file']['tmp_name'], $fileUpload . $file)) {
                    $data = new Spreadsheet_Excel_Reader();
                    $data->setOutputEncoding('utf-8');
                    $data->read($fileUpload . $file);
                    $notdone = $done=$already=$invalid=0;
                    for ($sheet = 0; $sheet < count($data->sheets); $sheet++) {
                        for ($row = 2; $row <= $data->sheets[$sheet]['numRows']; $row++) {
                            if (isset($data->sheets[$sheet]['cells'][$row][1]) && $data->sheets[$sheet]['cells'][$row][1] != '' && isset($data->sheets[$sheet]['cells'][$row][2]) && $data->sheets[$sheet]['cells'][$row][2] != '') {

                                $this->request->data['name'] = $data->sheets[$sheet]['cells'][$row][1];
                                $this->request->data['email'] = $data->sheets[$sheet]['cells'][$row][2];

                                $val=$this->createAccount($usertype, 0,1 );
								switch($val)
								{
									case 0: $notdone++;break;
									case 1: $done++;break;
									case 2: $already++;break;
									case 3: $invalid++;break;
								}
                                unset($this->request->data['name']);
                                unset($this->request->data['email']);
                            }
                        }// end for loop for row
                    }// end for loop for sheet
                    @unlink($fileUpload . $file);
					$msg="";
					$utype=$this->Session->read('usertype');
                    if ($usertype == '3') {
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
                    } else if ($usertype == '2') {
						if($done>0)
							$msg.=" $done Coach(es) have been imported successfully.";
						if($notdone>0)
							$msg.=" $notdone Coach(es) already exist into system";
							
						if($utype==1 && $already>0)
								$msg.=" $already Coach(es) already under your agency";
						if($utype==2 && $already>0)								
								$msg.=" $already Coach(es) already under you";
						if($invalid>0)
							$msg.=" $invalid Emails were invalid so not imported into system";
						
                        echo "success|$msg";
                    }
                    die();
                }
            } else {
                echo "error|Invalid File type. Only xls supported.";
                die();
            }
        }
    }

 public function plugin_pop() {
        $this->layout = 'popup';
        $clientid = $this->Session->read('Client.Client.id');
        $client = $this->Client->findById($clientid);
        $this->set('client', $client);
        $this->set('popTitle', 'JOB CARD PLUGIN');
        $this->render('plugin_pop');
    }
	
    public function social_pop() {
        $this->layout = 'popup';
        $clientid = $this->Session->read('Client.Client.id');
        $client = $this->Client->findById($clientid);
        $this->set('client', $client);
        $this->set('popTitle', 'Social');
        $this->render('social_pop');
    }

	public function moodle_login(){
		if(isset($this->params['url']['id'])) 
    		$this->set('display',$this->params['url']['id']);
		$this->layout = 'popup';
		$acc_id=$this->Session->read('Account.id');
		$acc=$this->Account->findById($acc_id);
		$this->set('acc',$acc);
		$this->set('popTitle', 'Learning');
        $this->render('moodle_login');
		
	}
	public function coach_moodle_login(){
		if(isset($this->params['url']['id'])) 
    		$this->set('display',$this->params['url']['id']);
		$this->layout = 'popup';
		//$acc_id=$this->Session->read('Account.id');
		//$acc=$this->Account->findById($acc_id);
		//print_r($this->Session->read());
		$this->set('password',$this->Session->read('swd'));
		$this->set('username',$this->Session->read('Coach.Coach.email'));
		$this->set('popTitle', 'Learning');
        $this->render('coach_moodle_login');
		
	}

}