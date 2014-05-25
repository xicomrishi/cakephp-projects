<?php
class LoginsController extends AppController {

	public $name = 'Logins';
	public $helpers = array('Form', 'Html', 'Js');
	public $layout='login';
	public $uses=array('User','Login','EmailTemplate','Professional','Recruiter');
	public $components=array('Core','Email');
		
	function admin_index(){}
	
	function admin_verify_login(){
		
		if(!empty($this->request->data)){
			
			$rs=$this->Login->verifyLogin($this->request->data);
			if($rs){
				
				$this->Session->write('User',$rs);
				$this->Session->write('LoginStatus',1);
				
				/*-save last login details-*/
				$arrData=array('User'=>
					array('last_login_ip'=>$this->request->clientIp(),
					'last_login_date'=>date('Y-m-d H:i:s')
					));
				
				
				$this->User->validation=null;
				$this->User->id=$rs['Login']['id'];
				$this->User->save($arrData,false);
				//print_r($rs['Login']['id']);die;
				/*-[end]save last login details-*/				
				
				$this->redirect('/admin/users/index');
			}else{
				$this->Session->setFlash("Invalid Email or Password");
				$this->redirect(array('action' => 'index'));
			}
		}
	}
	
	function admin_logout(){
		$this->Session->destroy();
		unset($_SESSION['LoginStatus']);
	}
	
	function user_verify_login(){
		if(!empty($this->request->data)){
			
			$rs=$this->Professional->verifyLogin($this->request->data);
			
			
			if($rs){	
				$userType='Professional';
			}else{
				$rs=$this->Recruiter->verifyLogin($this->request->data);		
				$userType='Recruiter';
			}
						
			if($rs){
				
				/*--unset session of esxiting logged in user--*/
				if(isset($_SESSION['Professional'])){
					unset($_SESSION['Professional']);		
				}elseif(isset($_SESSION['Recruiter'])){
					unset($_SESSION['Recruiter']);		
				}
				/*--/unset session of esxiting logged in user--*/
				
//				pr($userType); die;
				$this->Session->write($userType,$rs);
				$this->Session->write('LoginStatus',1);
				
				
				/*-save last login details-*/
				$arrData=array($userType=>
					array('last_login_ip'=>$this->request->clientIp(),
					'last_login_date'=>date('Y-m-d H:i:s')
					));
				
				
				$this->$userType->validation=null;
				$this->$userType->id=$rs[$userType]['id'];
				$this->$userType->save($arrData,false);
				//print_r($rs['Login']['id']);die;
				/*-[end]save last login details-*/				
				if($userType=='Professional') $controller='professionals'; else  $controller='recruiters';
				
				$this->redirect(array('controller'=>$controller,'action' => 'profile'));
			}else{
				$loginerror=array();
				$loginerror['email']=$this->request->data['Login']['email'];
				$loginerror['msg']='Invalid Email or Password';
				$this->Session->write('login_error',$loginerror);
				
				$this->redirect(array('controller'=>'home','action' => 'index'));
			}
		}
		
	}
	
	function admin_forgate_password(){
		
		$this->layout='ajax';		
		$this->Login->set($this->request->data);
		if($this->Login->validates(array('fieldList'=>array('email')))){
			$rs=$this->Login->findByEmail($this->request->data['Login']['email']);
			if($rs){
				$email=$rs['Login']['email'];								
				$name=$rs['Login']['first_name'].' '.$rs['Login']['last_name'];
				$newPass=$this->Core->generatePassword();
				$from="admin@jobseeker.com";
				$to=$email;//$email;
				$subject="Forgate Password Mail";
				$content="Your New Password is:".$newPass;
				$this->Login->id=$rs['Login']['id'];
				$this->Login->saveField('password', md5($newPass));					
				/*-template asssignment if any*/
				$template = $this->EmailTemplate->find('first',
					 array('conditions' => array('template_key'=> 'forget_password_email',
				  	 'status' =>'Active')));
				if($template){	
					$arrFind=array('{name}','{password}');
					$arrReplace=array($name,$newPass);
					$from=$template['EmailTemplate']['from_email'];
					$subject=$template['EmailTemplate']['email_subject'];
					$content=str_replace($arrFind, $arrReplace,$template['EmailTemplate']['email_body']);
				}
				/*-[end]template asssignment*/				
				$this->set('Content',$content);
				try{
					$this->Email->from=$from;
					$this->Email->to=$to;
					$this->Email->subject=$subject;
					$this->Email->sendAs='html';
					$this->Email->template='general';
					$this->Email->delivery = 'smtp';
					if($this->Email->send()){
						echo "<h4 class='success forgot_pass'>New password is sent to your email.";
						echo "</h4>";
					}
				}catch(Exception $e){
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
	
	function forget_password(){
		$this->layout='ajax';
		$this->Login->set($this->request->data);
		if($this->Login->validates(array('fieldList'=>array('email')))){
			$rs=$this->Professional->findByEmail($this->request->data['Login']['email']);
			if(!empty($rs)){	
				$userType='Professional';
			}else{
				$rs=$this->Recruiter->findByEmailAndCompletedStatus($this->request->data['Login']['email'],'Yes');
				$userType='Recruiter';
			}
			if(!empty($rs)){
				$email=$rs[$userType]['email'];								
				$name=$rs[$userType]['first_name'].' '.$rs[$userType]['last_name'];
				$newPass=$this->Core->generatePassword();
				$from="admin@jobseeker.com";
				$to=$email;
				$subject="Forget Password Mail";
				$content="Your New Password is:".$newPass;
				$this->$userType->id=$rs[$userType]['id'];
				$this->$userType->saveField('password', md5($newPass));					
				/*-template asssignment if any*/
				$template = $this->EmailTemplate->find('first',
					 array('conditions' => array('template_key'=> 'forget_password_email',
				  	 'status' =>'Active')));
				if($template){	
					$arrFind=array('{name}','{password}');
					$arrReplace=array($name,$newPass);
					$from=$template['EmailTemplate']['from_email'];
					$subject=$template['EmailTemplate']['email_subject'];
					$content=str_replace($arrFind, $arrReplace,$template['EmailTemplate']['email_body']);
				}
				/*-[end]template asssignment*/				
				$this->set('Content',$content);
				try{
					$this->Email->from="admin@jobseeker.com";
					$this->Email->to=$to;
					$this->Email->subject=$subject;
					$this->Email->sendAs='html';
					$this->Email->template='general';
					$this->Email->delivery ='smtp';
					if($this->Email->send()){
						echo "<h4 class='success forgot_pass'>New password is sent to your email.";
						echo "</h4>";
					}
				}catch(Exception $e){
					print_r($email);
//					echo "<h4 class='error forgot_pass'>The email could not be sent.Please contact to admin.</h4>";
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
	
	/*public function invalid_session()
	{
			
	}*/
	
	
}
