<?php
class LoginController extends AppController {

	public $name = 'Login';
	public $helpers = array('Form', 'Html', 'Js');
	public $layout='login';	
	
	
	function admin_index() {
		
		$this->layout='login';
	}
	
	function admin_verify_login(){	
		
		if(!empty($this->data)){
				
				if($this->data['Login']['user_name']=='admin@mygyftr.com'&&$this->data['Login']['password']=='mygyftr123#'){					
					
						$this->Session->write('RecAdmin','1');						
						$this->redirect('/admin/recharge/index');					
					
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
	

}
