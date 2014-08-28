<?php
App::uses('AppController', 'Controller');
App::import('Controller',array('Mail'));
App::import('Vendor',array('functions'));

class UsersController extends AppController {

	public $components = array('Session');
	public $uses=array('User','Trainer','Participant','Language');

	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}
	
	public function createAccount($data,$type,$is_template=0)
	{
		$user=$this->User->findByEmail($data['User']['email']);
		if(empty($user))
		{
			$company='';
			if(isset($data['User']['company']))
				$company=$data['User']['company'];
			$company_loc='';
			if(isset($data['User']['company_location']))
				$company_loc=$data['User']['company_location'];	
			
			$passwd=encrypt(random_password(),SALT);
			$this->User->create();
			$user=$this->User->save(array('first_name'=>$data['User']['first_name'],'last_name'=>$data['User']['last_name'],'phone'=>$data['User']['phone'],'address'=>$data['User']['address'],'email'=>$data['User']['email'],'password'=>$passwd,'city'=>$data['User']['city'],'country_id'=>$data['User']['country_id'],'industry_id'=>$data['User']['industry_id'],'company'=>$company,'company_location'=>$company_loc,'company_url'=>$data['User']['company_url'],'user_added_date'=>date("Y-m-d H:i:s"),'user_role_id'=>''));	
			$user['User']['password']=decrypt($passwd,SALT);			
		}else{
			
			$company='';
			if(isset($data['User']['company']))
				$company=$data['User']['company'];
			
			$company_loc='';
			if(isset($data['User']['company_location']))
				$company_loc=$data['User']['company_location'];		
					
			$this->User->id=$user['User']['id'];
			$this->User->save(array('first_name'=>$data['User']['first_name'],'last_name'=>$data['User']['last_name'],'phone'=>$data['User']['phone'],'address'=>$data['User']['address'],'city'=>$data['User']['city'],'country_id'=>$data['User']['country_id'],'industry_id'=>$data['User']['industry_id'],'company_url'=>$data['User']['company_url'],'company'=>$company,'company_location'=>$company_loc));
			$user['User']['password']=decrypt($user['User']['password'],SALT);
		}
		//echo '<pre>';print_r($user);die;
		switch($type)
		{
			case '2': 	$temp=strchr($user['User']['user_role_id'],'2');
						if(!empty($temp))
						{  
							$return='exist';												
						}else{								
							$this->createTrainer($user); 
							$return='success'; 		
						}						
					  break; 
			case '3': 	$temp=strchr($user['User']['user_role_id'],'3');
						if(!empty($temp))
						{  
							$return=$user['User']['id'];												
						}else{	
														
							$part=$this->createParticipant($user,$data,3,0,$is_template); 
							if($is_template!='0') 
							{
								$return='Added|'.$part;	
							}else{
								$return='success'; 
							}
						}						
					  break;
			case '4': 	$temp=strchr($user['User']['user_role_id'],'4');
						if(!empty($temp))
						{  
							$return=$user['User']['id'];												
						}else{								
							$part=$this->createParticipant($user,$data,4,0,$is_template); 
							if($is_template!='0') 
							{
								$return='Added|'.$part;	
							}else{
								$return='success'; 
							}		
						}						
					  break;
		  	case '5': 	$temp=strchr($user['User']['user_role_id'],'5');
						if(!empty($temp))
						{  
							$return=$user['User']['id'];												
						}else{								
							$part=$this->createParticipant($user,$data,5,0,$is_template); 
							if($is_template!='0') 
							{
								$return='Added|'.$part;	
							}else{
								$return='success'; 
							} 		
						}						
					  break;			  		  	  	
		}
		unset($this->data);		
		return $return; 	
	}
	
	
	public function createParticipant($user,$data,$type,$already=0,$email_template=0)
	{
		
		$user=$this->User->findById($user['User']['id']);
		$user['User']['password']=decrypt($user['User']['password'],SALT);
		$Mail = new MailController;
        $Mail->constructClasses();
		$this->Participant->create();
		$participant=$this->Participant->save(array('user_id'=>$user['User']['id'],'course_id'=>$data['Participant']['course_id'],'user_role_id'=>$type,'created'=>date("Y-m-d H:i:s")));
		if($already==0)
		{
			$sql="update bmc_users set user_role_id=concat_ws(',',user_role_id,".$type.") where id=".$user['User']['id'];
			$this->User->query($sql);
		}
		$arr=array();
		$arr['TO_EMAIL']=$user['User']['email'];
		$arr['TO_NAME']=$user['User']['first_name'].' '.$data['User']['last_name']; ;
		$arr['EMAIL']=$user['User']['email'];
		$arr['PASSWORD']=$user['User']['password']; 
		$arr['COURSE_ID']=$data['Participant']['course_id'];
		
		$locale = Configure::read('Config.language');
		
		if(!empty($locale))
		{
			$language=$this->Language->find('first',array('conditions'=>array('Language.code'=>trim(strtoupper($locale)))));
			$language_id=$language['Language']['id'];	
		}else{
			$language_id='1';	
		}
		if($email_template!='0')
		{
			$template=$email_template.'_'.$language_id;	
		}else{
			$template='participant_added_'.$language_id;	
		}
		
		if($language_id=='2')
			$click_var='Klicken sie hier';
		else
			$click_var='Click here';	
		$arr['FOLLOW_URL']='<a href="'.SITE_URL.'/participant" target="_blank">'.$click_var.'</a>';	
		$Mail->sendMail($user['User']['id'],$template,$arr);
		
		return $participant['Participant']['id'];	
	}	
	
	
	public function createTrainer($data)
	{
		$data=$this->User->findById($data['User']['id']);
		$data['User']['password']=decrypt($data['User']['password'],SALT);
		$Mail = new MailController;
        $Mail->constructClasses();
			
		$this->Trainer->create();
		$trainer=$this->Trainer->save(array('user_id'=>$data['User']['id'],'trainer_id'=>'TR'.time(),'status'=>'1','created'=>date("Y-m-d H:i:s")));
		$sql="update bmc_users set user_role_id=concat_ws(',',user_role_id,'2') where id=".$data['User']['id'];
		$this->User->query($sql);
		$arr=array();
		$arr['TO_EMAIL']=$data['User']['email'];
		$arr['TO_NAME']=$data['User']['first_name'].' '.$data['User']['last_name']; ;
		$arr['EMAIL']=$data['User']['email'];
		$arr['PASSWORD']=$data['User']['password']; 
		$arr['TRAINER_ID']=$trainer['Trainer']['trainer_id'];
		$arr['FOLLOW_URL']='<a href="'.SITE_URL.'/trainer" target="_blank">click here</a>';	
		$Mail->sendMail($data['User']['id'],'trainer_added',$arr);
		return;		
	}

	public function generateRandomString($length = 8,$num=0) {
   		$this->autoRender=false;
		 $string=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		 
		 return $string;
		 
	}
	
	public function edit_settings($id)
	{
		$this->layout='ajax';
		$this->set('user_id',$id);
		$this->render('settings');	
	}
	
	public function save_settings()
	{
		if(!empty($this->data))
		{
			$user=$this->User->findById($this->data['user_id']);
			if(decrypt($user['User']['password'],SALT)==$this->data['old_password'])
			{
				$Mail = new MailController;
       			$Mail->constructClasses();
				$this->User->id=$user['User']['id'];
				$this->User->saveField('password',encrypt($this->data['new_password'],SALT));
				$arr=array();
				$arr['TO_EMAIL']=$user['User']['email'];
				$arr['TO_NAME']=$user['User']['first_name'].' '.$user['User']['last_name']; ;
				$arr['PASSWORD']=$this->data['new_password']; 
				$Mail->sendMail($user['User']['id'],'password_update',$arr);
				die;
			}else{
				echo 'error';die;	
			}
			//echo '<pre>';print_r($this->data);die;	
		}	
	}
	
	public function update_password()
	{
		if(!empty($this->data))
		{
			$Mail = new MailController;
			$Mail->constructClasses();
			$user=$this->User->findById($this->data['user_id']);
			$this->User->id=$user['User']['id'];
			$this->User->saveField('password',encrypt($this->data['new_password'],SALT));
			$arr=array();
			$arr['TO_EMAIL']=$user['User']['email'];
			$arr['TO_NAME']=$user['User']['first_name'].' '.$user['User']['last_name']; ;
			$arr['PASSWORD']=$this->data['new_password']; 
			$Mail->sendMail($user['User']['id'],'password_update',$arr);
			die;	
		}	
	}

	public function logout()
	{
		$user=$this->Session->read('User');
		//echo '<pre>';print_r($user);die;
		$this->Session->delete('User');
		if($user['type']=='Trainer')
			$this->redirect('/trainer');
		else if($user['type']=='Participant')
			$this->redirect('/');
		else		
			$this->redirect('/company');	
	}
	
}
