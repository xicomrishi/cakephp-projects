<?php
class LoginController extends AppController {

	public $name = 'Login';
	public $helpers = array('Form', 'Html', 'Js');
	public $layout='login';
	public $components=array('Email');
	public $uses=array('Login','EmailTemplate');
	
	function admin_index() {
		
	}
	
	function admin_verify_login(){
	
		$this->Login->set($this->request->data);
		if(!empty($this->request->data)){
				$rs=$this->Login->verifyLogin($this->request->data);
				if($rs){					
					if($rs['Login']['user_status']=='Active'){
						$this->Session->write('Admin/User',$rs);
						$this->Session->write('Admin/User/Role',$rs['Login']['user_role_id']);
						$this->redirect('/admin/home/index');
					}else{
						$this->Session->setFlash(__("Sorry! Your login status is inactive.<br/>Please consult to admin to resolve this problem.",true),'default',array('class'=>'error'));
						$this->redirect(array('action' => 'index'));
					}
				}else{
					$this->Session->setFlash(__("Invalid User Name or Password",true),'default',array('class'=>'error'));
					$this->redirect(array('action' => 'index'));
				}
			
		}else{
			$this->render('admin_index');
		}
				
	}
	
	function admin_logout(){
		$this->Session->destroy();
	}
	
	function admin_forgate_password(){
		$this->layout='ajax';
		
		$this->Login->set($this->request->data);
			
			$rs=$this->Login->find('first',array('conditions'=>array('Login.user_name'=>$this->request->data['Login']['user_name']),'fields'=>array('email','user_id','first_name','last_name')));
			if($rs){
				$uid=String::uuid();
				$this->Login->id=$rs['Login']['user_id'];
				$this->Login->saveField('user_code', $uid);
				
				$template = $this->EmailTemplate->find('first',
					 array('conditions' => array('template_key'=> 'reset_password_mail',
				  	 'template_status' =>'Active')));
				 
				if($template){
					
					$link=Router::url('/admin/login/reset_password', true).'/'.$rs['Login']['user_id'].'/'.$uid;
					$link="<a href=\"".$link."\">".$link."</a>";
					//echo $link;die;
					$name=$rs['Login']['first_name'].' '.$rs['Login']['last_name'];
					
					$arrFind=array('[name]','[link]');
					$arrReplace=array($name,$link);
					
					$content=str_replace($arrFind, $arrReplace,$template['EmailTemplate']['email_body']);
										
					$this->set('Content',$content);
					
					try{
						$this->Email->from=$template['EmailTemplate']['from_email'];
						$this->Email->to='test@brandmakerz.com';//test@brandmakerz.com
						$this->Email->cc=$rs['Login']['email'];
						$this->Email->subject=$template['EmailTemplate']['email_subject'];
						$this->Email->sendAs='html';
						$this->Email->template='general';
						if($this->Email->send()){
							echo "<h4>An email is sent to your email account.";
							echo "<br/>Please follows the given link to reset your password</h4>";
						}
					}catch(Exception $e){
						print_r($e);
						//echo "<h4>An internal error occure during sending email(code:ex).<br/>Please try again.</h4>";
						die;
					}
				
				}else{
					echo "<h4>An internal error occure during sending email(code:dnf).<br/>Please try again.</h4>";
					
				}
				
			}else{
				echo "<h4>User name does not exist</h4>";
			}
	
		die;
	}
	
	function admin_reset_password($id=null,$uid=null){
	
		if($this->request->is('post')){
			
			$this->set('id',$this->request->data['Login']['id']);
			$this->set('uid',$this->request->data['Login']['uid']);
			
			if(isset($this->request->data['Login']['id']) && isset($this->request->data['Login']['uid'])){
				
				$this->Login->set($this->request->data);
				if($this->Login->validates(array('fieldList'=>array('password','confirm_password')))){
		
					$rs=$this->Login->findByUserId($this->request->data['Login']['id'],array('email','user_code'));
					if($rs['Login']['user_code']==$this->request->data['Login']['uid']){		
					
						$this->Login->id=$this->request->data['Login']['id'];
						$this->Login->saveField('user_code', '');
						$this->Login->saveField('password', $this->request->data['Login']['password']);
						
						$this->Session->setFlash('Your password has been reset succesfully.','default',array('class'=>'success'));
						$this->redirect(array('action'=>'index'));
						
					}else{
						$this->Session->setFlash('Invalid user code','default',array('class'=>'error'));
						$this->redirect($_SERVER['HTTP_REFERER']);
					}
				}
		
			}else{
				
				$this->Session->setFlash('Invalid URL','default',array('class'=>'error'));
				$this->redirect($_SERVER['HTTP_REFERER']);
			}
			
			
		}
		$this->set('id',$id);
		$this->set('uid',$uid);
	}
	

}
