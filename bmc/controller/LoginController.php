<?php
App::uses('AppController', 'Controller');
App::import('Controller',array('Mail','Users'));
App::import('Vendor',array('functions'));

class LoginController extends AppController {

	public $components = array('Session','Access');
	public $uses=array('User','Trainer','Company','Industry','Country','Course','Participant','Coursecompany','APresponse','Response');

	public function beforeFilter(){
		$this->layout='login';	
		if ($this->Session->check('Config.language')) {
            Configure::write('Config.language', trim($this->Session->read('Config.language')));
        }	
	}
	
	
	public function admin_index()
	{
			
	}
	
	
	public function index() {
		
	}
	
	
	public function home()
	{
		if(!$this->Session->check('User'))
		{
			$this->redirect('/login/participant_login');	
		}else{
			$role_id=$this->Session->read('User.Participant.Participant.user_role_id');	
			$this->redirect(array('controller'=>'dashboard','action'=>'participant_home',$role_id));	
		}
		
	}
	
	public function admin_verify_login()
	{
		if(!empty($this->data))
		{
			$user=$this->User->findByEmail($this->data['email']);
			if(!empty($user))
			{
				$temp=strchr($user['User']['user_role_id'],'1');
				if(!empty($temp))
				{  
					if(decrypt($user['User']['password'],SALT)==$this->data['password'])
					{
						$this->Session->write('User',$user);
						$this->Session->write('User.type','Admin');	
						if(!$this->Session->check('Config.language'))
						{
							$this->Session->write('Config.language','eng');
							$this->Session->write('Config.language_id','1');
						}
						$this->redirect(array('controller'=>'dashboard','action'=>'admin_index'));	
					}else{
						$this->Session->setFlash(__('Invalid password!'));
						$this->redirect('/admin');	
					}
				}else{
					
					$this->Session->setFlash(__('Invalid username!'));
					$this->redirect('/admin');
				}
			}else{
				
				$this->Session->setFlash(__('Invalid username!'));
				$this->redirect('/admin');
			}	
		}	
	}
	
	public function trainer_login()
	{
		$data=$this->Session->read('Login_tr_data');
		if(!empty($data))
			$this->set('data',$data);
		$this->render('trainer_login');	
	}
	
	public function verify_trainer_login()
	{
		if(!empty($this->data))
		{
			$user=$this->User->findByEmail($this->data['email']);
			if(!empty($user))
			{
				$temp=strchr($user['User']['user_role_id'],'2');
				if(!empty($temp))
				{  
					if(decrypt($user['User']['password'],SALT)== $this->data['password'])
					{
						$trainer=$this->Trainer->find('first',array('conditions'=>array('Trainer.user_id'=>$user['User']['id'],'Trainer.status'=>1)));
						if(!empty($trainer))
						{
							if($this->data['trainer_id']==$trainer['Trainer']['trainer_id'])
							{								
								$this->Session->delete('Login_tr_data');
								$this->Session->write('User',$user);
								$this->Session->write('User.type','Trainer');
								$this->Session->write('User.Trainer',$trainer);
								$this->User->id=$user['User']['id'];
								$this->User->save(array('last_login_date'=>date("Y-m-d H:i:s"),'last_login_ip'=>$this->request->clientIp()));	
								
								if(!$this->Session->check('Config.language'))
								{
									$this->Session->write('Config.language','eng');
									$this->Session->write('Config.language_id','1');
								}
								$this->redirect(array('controller'=>'dashboard','action'=>'trainer_home'));
							}else{
								
								$this->Session->write('Login_tr_data',$this->data);
								$this->Session->setFlash(__('Invalid Trainer ID!'));
								$this->redirect('/login/trainer_login');	
							}
						}else{
							
							$this->Session->write('Login_tr_data',$this->data);
							$this->Session->setFlash(__('No trainer found!'));
							$this->redirect('/login/trainer_login');
						}
							
					}else{
						
						$this->Session->write('Login_tr_data',$this->data);
						$this->Session->setFlash(__('Invalid password!'));
						$this->redirect('/login/trainer_login');	
					}
				}else{
					
					$this->Session->write('Login_tr_data',$this->data);
					$this->Session->setFlash(__('Invalid username!'));
					$this->redirect('/login/trainer_login');
				}
			}else{
				
				$this->Session->write('Login_tr_data',$this->data);
				$this->Session->setFlash(__('Invalid username!'));
				$this->redirect('/login/trainer_login');
			}		
		}	
	}
	
	
	public function verify_participant_login()
	{
		if(!empty($this->data))
		{
			$user=$this->User->findByEmail($this->data['email']);
			if(!empty($user))
			{
				$temp=strchr($user['User']['user_role_id'],$this->data['user_role_id']);
				if(!empty($temp))
				{  
					if(decrypt($user['User']['password'],SALT)== $this->data['password'])
					{
						$participant=$this->Participant->find('first',array('conditions'=>array('Participant.user_id'=>$user['User']['id'],'course_id'=>$this->data['course_id'],'user_role_id'=>$this->data['user_role_id'],'Participant.participant_status'=>'1')));
						if(!empty($participant))
						{
							$this->Session->delete('Login_data');
							$this->Session->write('User',$user);
							$this->Session->write('User.type','Participant');
							$this->Session->write('User.Participant',$participant);	
							$this->User->id=$user['User']['id'];
							$this->User->save(array('last_login_date'=>date("Y-m-d H:i:s"),'last_login_ip'=>$this->request->clientIp()));
							
							if(!$this->Session->check('Config.language'))
							{
								$this->Session->write('Config.language','eng');
								$this->Session->write('Config.language_id','1');
							}
							$this->redirect(array('controller'=>'dashboard','action'=>'participant_home',$this->data['user_role_id']));
							
						}else{
							
							$this->Session->write('Login_data',$this->data);
							$this->Session->setFlash(__('No user found!'));
							$this->redirect('/login/participant_login');
						}							
					}else{
						
						$this->Session->write('Login_data',$this->data);
						$this->Session->setFlash(__('Invalid password!'));
						$this->redirect('/login/participant_login');	
					}
				}else{
					
					$this->Session->write('Login_data',$this->data);
					$this->Session->setFlash(__('Invalid Role!'));
					$this->redirect('/login/participant_login');
				}
			}else{
				
				$this->Session->write('Login_data',$this->data);
				$this->Session->setFlash(__('Invalid username!'));
				$this->redirect('/login/participant_login');
			}		
		}		
	}
	
	public function forgot_details($type=0)
	{
		if($type==1)
			$this->set('is_participant','1');
		$this->render('forgot_details');	
	}
	
	public function submit_forgot_details($type)
	{
		$return_url='/login/forgot_details';
		if($type!=2)
			$return_url='/login/forgot_details/1';
		if(!empty($this->data))
		{
			if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
				App::import('Component','Captcha'); //load it
				$this->Captcha = new CaptchaComponent(); //make instance
				$this->Captcha->startup($this); //and do some manually calling
			}
			$cap=$this->Captcha->getVerCode();
			if($cap==$this->data['captcha'])
			{
				$user=$this->User->find('first',array('conditions'=>array('User.email'=>$this->data['email'])));
				if(!empty($user))
				{
					if($type==3)
						$type=$this->data['user_role_id'];
					$temp=strchr($user['User']['user_role_id'],$type);
					if(!empty($temp))
					{
						$Mail = new MailController;
        				$Mail->constructClasses();
						$pass=encrypt(random_password(),SALT);
						$this->User->id=$user['User']['id'];
						$this->User->saveField('password',$pass);
						$flag=0;
						if($type==2)
						{	
							$trainer=$this->Trainer->find('first',array('conditions'=>array('Trainer.user_id'=>$user['User']['id'])));
							if(!empty($trainer))
									$flag=1;
						}else{ 
							$participant=$this->Participant->find('first',array('conditions'=>array('user_id'=>$user['User']['id'],'course_id'=>$this->data['course_id'],'user_role_id'=>$this->data['user_role_id'])));
							if(!empty($participant))
									$flag=1;	
						}							
						if($flag==1)
						{		
							$arr=array();
							$arr['TO_EMAIL']=$user['User']['email'];
							$arr['TO_NAME']=$user['User']['first_name'].' '.$user['User']['last_name']; ;
							$arr['EMAIL']=$user['User']['email'];
							$arr['PASSWORD']=decrypt($pass,SALT); 
							if($type==2)
								$arr['TRAINER_ID']='Trainer ID: '.$trainer['Trainer']['trainer_id'];
							else
								$arr['TRAINER_ID']='';			
							$Mail->sendMail($user['User']['id'],'forgot_password',$arr);							
							$this->Session->setFlash(__('Login details sent to your Email ID'));	
							$this->redirect($return_url);
							
						}else{
							$this->Session->setFlash(__('No user found!'));	
							$this->redirect($return_url);
						}
					}else{
						$this->Session->setFlash(__('No user found!'));	
						$this->redirect($return_url);
					}
				}else{
					$this->Session->setFlash(__('No user found!'));	
					$this->redirect($return_url);	
				}	
			}else{
				$this->Session->setFlash(__('Wrong security code entered!'));	
				$this->redirect($return_url);
			}
		}else{
			$this->redirect($return_url);
		}	
	}
	
	 public function captcha()	{
		$this->autoRender = false;
		$this->layout='ajax';
		if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
			
			App::import('Component','Captcha'); //load it
			$this->Captcha = new CaptchaComponent(); //make instance
			$this->Captcha->startup($this); //and do some manually calling
		}
		$width = isset($_GET['width']) ? $_GET['width'] : '140';
		$height = isset($_GET['height']) ? $_GET['height'] : '60';
		$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '6';
		$this->Captcha->create($width, $height, $characters); //options, default are 120, 40, 6.

	}
	  
	  
	  public function reload_captcha()   {
	    App::import('Component','Captcha'); //load it
	    $this->Captcha = new CaptchaComponent(); //make instance
	    $this->Captcha->startup($this); //and do some manually calling
	    $this->layout='ajax';
	    Configure::write('debug',2);
	   $this->render('reload_captcha');
	}
	
	public function generateRandomString($length = 8) {
   		 return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}
	
	
	public function participant_register($num=0)
	{
		$this->layout='login';
		$countries=$this->Country->find('all',array('order'=>array('Country.country_name ASC')));
		$industries=$this->Industry->find('all',array('order'=>array('Industry.industry ASC')));
		$companies=$this->Company->find('all',array('order'=>array('Company.company ASC')));
		$all_comps=array(); $i=0;
		foreach($companies as $cmp)
		{
			$all_comps[$i]['label']=$cmp['Company']['company'];	
			$i++;
		}
		$this->set('all_comps',$all_comps);
		$this->set('companies',$companies);
		$this->set('industries',$industries);
		$this->set('countries',$countries);
		$this->set('num',$num);
		$this->render('participant_register');	
	}
	
	
	public function direct_participant_register($role_id,$course_id,$num=0)
	{
		$this->layout='ajax';
		$course=$this->Course->findById($course_id);
		if(!empty($course) && $course['Course']['status']=='1')
		{
			$countries=$this->Country->find('all',array('order'=>array('Country.country_name ASC')));
			$industries=$this->Industry->find('all',array('order'=>array('Industry.industry ASC')));
			$companies=$this->Company->find('all',array('order'=>array('Company.company ASC')));
			$all_comps=array(); $i=0;
			foreach($companies as $cmp)
			{
				$all_comps[$i]['label']=$cmp['Company']['company'];	
				$i++;
			}
			
			if($role_id=='3') $role_text = 'Project Manager';
			else if($role_id=='4') $role_text = 'Team Member';
			else $role_text = 'Manager of Project Managers';
			
			$this->set('role_id',$role_id);
			$this->set('role_text',$role_text);
			$this->set('course',$course);
			$this->set('all_comps',$all_comps);
			$this->set('companies',$companies);
			$this->set('industries',$industries);
			$this->set('countries',$countries);
			$this->set('num',$num);
			$this->render('direct_participant_register');
		}else{
			echo 'Course has been deleted.';	
		}
	}
	
	
	public function save_participant_register()
	{
		if(!empty($this->data))
		{
			if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
				App::import('Component','Captcha'); //load it
				$this->Captcha = new CaptchaComponent(); //make instance
				$this->Captcha->startup($this); //and do some manually calling
			}
			$cap=$this->Captcha->getVerCode();
			
			if($this->data['Participant']['captcha']==$cap)
			{
			$courses=$this->Course->findByCourseId($this->data['Participant']['course_id']);
			if(!empty($courses))
			{
				$User=new UsersController;
				$User->constructClasses();
				$this->request->data['User']['address']='';
				$companies=$this->Company->find('all');
				$already=array();
				foreach($companies as $ex)
				{
					$already[]=strtolower(trim($ex['Company']['company']));	
				}
				if(!in_array(strtolower(trim($this->data['User']['company'])),$already))
				{
					$this->Company->create();
					$comp_data=$this->Company->save(array('company'=>$this->data['User']['company']));	
					$this->Coursecompany->create();
					$this->Coursecompany->save(array('course_id'=>$courses['Course']['id'],'company'=>$this->data['User']['company']));
					$this->request->data['User']['company']=$comp_data['Company']['id'];
				}else{
					$is_course_comp=$this->Coursecompany->find('first',array('conditions'=>array('Coursecompany.course_id'=>$courses['Course']['id'],'Coursecompany.company'=>$this->data['User']['company'])));
					if(empty($is_course_comp))
					{
						$this->Coursecompany->create();
						$this->Coursecompany->save(array('course_id'=>$courses['Course']['id'],'company'=>$this->data['User']['company']));	
					}
					$comp_data=$this->Company->findByCompany($this->data['User']['company']);	
					$this->request->data['User']['company']=$comp_data['Company']['id'];
				}
				
				$msg=$User->createAccount($this->data,$this->data['User']['user_role_id']);	
				if($msg!='success')
				{
					$part_course=$this->Participant->findByUserIdAndCourseId($msg,$courses['Course']['course_id']);
					if(!empty($part_course))
					{
						$this->Session->setFlash(__('Account already exist with this email ID'));	
						$this->redirect(array('controller'=>'login','action'=>'participant_register'));	
					}else{
						$user=$this->User->findById($msg);
						$data=array(); 
						$data['Participant']['course_id']=$courses['Course']['course_id'];
						$user['User']['password']=decrypt($user['User']['password'],SALT);
						$User->createParticipant($user,$data,$this->data['User']['user_role_id'],1);
							
						$this->redirect(array('controller'=>'login','action'=>'participant_register',1));	
					}
				}else{	
					$this->redirect(array('controller'=>'login','action'=>'participant_register',1));
				}				
			}else{
				$this->Session->setFlash(__('No course found with this Course ID.'));	
				$this->redirect(array('controller'=>'login','action'=>'participant_register'));	
			}
			}else{
				
				$this->Session->setFlash(__('Invalid captcha code. Please try again.'));	
				$this->redirect(array('controller'=>'login','action'=>'participant_register'));		
			}
		}	
	}
	
	
	public function save_direct_participant_register()
	{
		if(!empty($this->data))
		{
			if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
				App::import('Component','Captcha'); //load it
				$this->Captcha = new CaptchaComponent(); //make instance
				$this->Captcha->startup($this); //and do some manually calling
			}
			$cap=$this->Captcha->getVerCode();
			
			if($this->data['Participant']['captcha']==$cap)
			{
			$courses=$this->Course->findByCourseId($this->data['Participant']['course_id']);
			if(!empty($courses))
			{
				$User=new UsersController;
				$User->constructClasses();
				$this->request->data['User']['address']='';
				$companies=$this->Company->find('all');
				$already=array();
				foreach($companies as $ex)
				{
					$already[]=strtolower(trim($ex['Company']['company']));	
				}
				if(!in_array(strtolower(trim($this->data['User']['company'])),$already))
				{
					$this->Company->create();
					$comp_data=$this->Company->save(array('company'=>$this->data['User']['company']));	
					$this->Coursecompany->create();
					$this->Coursecompany->save(array('course_id'=>$courses['Course']['id'],'company'=>$this->data['User']['company']));
					$this->request->data['User']['company']=$comp_data['Company']['id'];
				}else{
					$is_course_comp=$this->Coursecompany->find('first',array('conditions'=>array('Coursecompany.course_id'=>$courses['Course']['id'],'Coursecompany.company'=>$this->data['User']['company'])));
					if(empty($is_course_comp))
					{
						$this->Coursecompany->create();
						$this->Coursecompany->save(array('course_id'=>$courses['Course']['id'],'company'=>$this->data['User']['company']));	
					}
					$comp_data=$this->Company->findByCompany($this->data['User']['company']);	
					$this->request->data['User']['company']=$comp_data['Company']['id'];
				}
				
				$template='participant_added_direct';
				
				$msg=$User->createAccount($this->data,$this->data['User']['user_role_id'],$template);	
				if($msg!='success')
				{
					$exp=explode("|",$msg);
					
					if($exp[0]=='Added')
					{
						echo 'success|Thank you for completing Assessment survey of Project Management.<br><br>You will receive an email with a link to the assessment login and password details to view assessment report.|'.$exp[1];
						
					}else{
						$part_course=$this->Participant->findByUserIdAndCourseId($msg,$courses['Course']['course_id']);
						if(!empty($part_course))
						{							
							echo 'error|Account already exist with this email ID';
						}else{
							
							$user=$this->User->findById($msg);
							$data=array(); 
							$data['Participant']['course_id']=$courses['Course']['course_id'];
							$user['User']['password']=decrypt($user['User']['password'],SALT);
							$part=$User->createParticipant($user,$data,$this->data['User']['user_role_id'],1,'participant_added_direct');
							
							echo 'success|Thank you for completing Assessment survey of Project Management.<br><br>You will receive an email with a link to the assessment login and password details to view assessment report.|'.$part;	
							
						}
					}
				}else{	
					echo 'success|Thank you for completing Assessment survey of Project Management.<br><br>You will receive an email with a link to the assessment login and password details to view assessment report.|'.$part;	
				}				
			}else{
				echo 'error|No course found with this Course ID.';
			}
			}else{
				echo 'error|Invalid captcha code. Please try again.';	
			}
		}	
		die;
	}
	
	public function participant_login()
	{
		$this->layout='login';
		$data=$this->Session->read('Login_data');
		if(!empty($data))
			$this->set('data',$data);
			
		$this->render('participant_login');	
	}
	
	public function invalidSession($page)
	{
		$this->layout='login';
		if($page=='admin')
			$redirect='/admin/login/index';
		if($page=='trainer')
			$redirect='/trainer';	
		$this->set('page',$page);
		$this->render('invalid_session');	
	}
	
	
	public function please_wait_message($type)
	{
		$this->layout='ajax';
		if($type=='1')
			$msg='<img src="'.$this->webroot.'img/hourglass.gif" alt="..."/><br>Please wait<br>saving the assessment<br>';	
		$this->set('msg',$msg);	
		$this->render('please_wait_message');		
	}
	
	
	public function test()
	{
		$te='zaXPzbeaptWn4Ouu';
		$temp=decrypt($te,SALT);
		echo $temp; die;
		//echo $temp.'<br>'.decrypt($temp,SALT);die;
	}
	
	
	public function cron()
	{
		$sql='delete from bmc_responses where `participant_id` IN (1,5,6,7,14,18,25)';
		$this->Response->query($sql);
		
		$sql_sec='delete from bmc_actionplan_response where `participant_id` IN (1,5,6,7,14,18,25)';
		$this->APresponse->query($sql_sec);
		
		die;	
	}
	
	public function updatePass()
	{
		$sql="select * from bmc_users U where U.id in (9,10,11,12,13,14,15,16,17,18,19)";
		$users=$this->User->query($sql);
		foreach($users as $us)
		{
			$pass=encrypt($us['U']['password'],SALT);
			$this->User->id=$us['U']['id'];
			$this->User->saveField('password',$pass);
		}
		
		echo '<pre>'; print_r($users); die;
			
	}
	
	
}