<?php
class LoginsController extends AppController {

	public $name = 'Logins';
	public $helpers = array('Form', 'Html', 'Js','Session');
	public $layout='login';
	public $uses=array('User','Login','EmailTemplate');
	public $components=array('Core');
	
	public function beforeFilter(){
		parent::beforeFilter();		
		$this->Auth->allow(array('admin_login','admin_logout','admin_forgot_password','index'));
	}
		
	
	function admin_login() {
		
		if($this->request->is('post')){	
			 if($this->Auth->login()){			 
			 	
			 	/*--update access logs--*/
			 	$this->User->validation=null;
			 	$arrData=array('User'=>
					array('last_login_ip'=>$this->request->clientIp(),
					'last_login_date'=>date('Y-m-d H:i:s')
				));
				
				$this->User->id=$this->Auth->user('user_id');
				$this->User->save($arrData,false);
				/*--update access logs--*/				
			 	
			 	$this->redirect(array('controller'=>'home','action' => 'admin_index'));			 	 
			 	 
			 }else{
			 	$this->Session->setFlash(__('Invalid username or password, try again'));
			 }	
			
		}
		
		if($this->Auth->loggedIn()){
			$this->redirect($this->Auth->redirect());	
		}
		 
		$this->set('title_for_layout','My Online Recharge Admin Login');
		
	}	
	
	function admin_logout() {		
		$this->redirect($this->Auth->logout());
	}	
		
		
	function admin_forgot_password(){
		
		$this->layout='ajax';		
		
		$this->Login->set($this->request->data);
		if($this->Login->validates(array('fieldList'=>array('email')))){
		
			$rs=$this->Login->findByEmail($this->request->data['Login']['email']);
			if($rs){
						
				$email=$rs['Login']['email'];								
					
				$name=$rs['Login']['name'];
				$newPass=$this->Core->generatePassword();
				
				$from="info@myonlinerecharge.com";
				$to=$email;
				$subject="Forgot Password Email";
				$content="Your New Password is:".$newPass;
								
				/*-template asssignment if any*/
				$template = $this->EmailTemplate->find('first',
					 array('conditions' => array('template_key'=> 'forgot_password_email',
				  	 'template_status' =>'Active')));
						
				if($template){	
					$arrFind=array('{name}','{password}','{email}');
					$arrReplace=array($name,$newPass,$email);
					
					$from=$template['EmailTemplate']['from_email'];
					$subject=$template['EmailTemplate']['email_subject'];
					$content=str_replace($arrFind, $arrReplace,$template['EmailTemplate']['email_body']);					
				}
				/*-[end]template asssignment*/				
				if($this->sendEmail($to,$from,$subject,$content)){				
						/*--update user password--*/
						$this->User->id=$rs['Login']['user_id'];
						$data=array('User'=>array('password'=>AuthComponent::password($newPass)));
						$this->User->save($data);
						/*--/update user password--*/
						
						echo "<h4 class='success forgot_pass'>New password is sent to your email.";
						echo "</h4>";
				}else{				
					echo "<h4 class='error forgot_pass'>The email could not be sent.Please contact to admin.</h4>";
					die;
				}				
								
			}else{
				echo "<h4 class='error forgot_pass'>User email does not exist</h4>";
			}
		}else{
			echo "<div class='error forgot_pass'>Please enter the email</div>";
		}
		die;
	}
	
	function index(){
		
	}
	
}
