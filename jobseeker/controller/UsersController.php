<?php
class UsersController extends AppController {

	public $name = 'Users';
	public $helpers = array('Form', 'Html', 'Js');
	public $paginate = array('limit' =>10);	
	public $components = array('Access');
	public $uses=array('User','UserRole');
	public $layout='admin';
	
	function beforeFilter(){
		$this->Access->isValidUser();
	}

	function beforeRender(){
		$user=$this->Session->read('User');
		
		if($user['Login']['user_role_id']>1 && $this->action!='admin_profile'){
			
			$this->redirect(array('action' => 'admin_profile'));
		}
	}
	
	function admin_profile($id=null) {
		
		$user=$this->Session->read('User');
		
		
		$this->User->id = $user['Login']['id'];
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid User'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['User']['user_modified_date']=date('Y-m-d H:i:s');
			$this->request->data['User']['email']=$user['Login']['email'];
			$this->request->data['User']['user_role_id']=$user['Login']['user_role_id'];
			$this->request->data['User']['user_status']=$user['Login']['user_status'];
			
			if($this->request->data['User']['password']!=$user['Login']['password']){
				$this->request->data['User']['password']=md5($this->request->data['User']['password']);
			}
			
			if($this->User->save($this->request->data,false)) {
				$this->Session->setFlash(__('The user updated successfully',true),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.',true),'default',array('class'=>'error'));
			}
		}

		if(empty($this->request->data)){
			$this->request->data = $this->User->read(null, $this->User->id);
		}	
				
		
		
	}
	
	function admin_index() {		
		$this->set('Users', $this->paginate('User'));
	}
	
	
	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User', true),'default',array('class'=>'error'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	
	}

	function admin_add(){
				
		if (!empty($this->request->data) && $this->request->is('post')) {
			$this->User->create();
			
			$this->request->data['User']['user_added_date']=date('Y-m-d H:i:s');
			$this->request->data['User']['password']=md5($this->request->data['User']['password']);
			
			if($this->User->save($this->request->data)) {
			 	$this->Session->setFlash(__('The user added successfully',true),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
					$this->Session->setFlash(__('The user could not be saved. Please, try again.',true),'default',array('class'=>'error'));
			}
	      
		}
		
		$roles=$this->UserRole->find('all',array('conditions'=>array('status'=>'Active'),'order'=>array('role_name'=>'asc')));
		$this->set('Roles',$roles);
		
		
		
		
		
	}

		
	function admin_edit($id = null) {
	
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid User'));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
			
			$this->request->data['User']['user_modified_date']=date('Y-m-d H:i:s');
			
			$userDBPass=$this->User->findById($id,array('fields'=>'password'));
			$userDBPass=$userDBPass['User']['password'];
			if($userDBPass!=$this->request->data['User']['password']){
				$this->request->data['User']['password']=md5($this->request->data['User']['password']);
			}
			
			if($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user updated successfully',true),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.',true),'default',array('class'=>'error'));
			}
		}
		
		if (empty($this->request->data)) {
			$this->request->data = $this->User->read(null, $id);
		}
	
		$roles=$this->UserRole->find('all',array('conditions'=>array('status'=>'Active'),'order'=>array('role_name'=>'asc')));
		$this->set('Roles',$roles);
		
		
	}

	
	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('The user deleted successfully', true),'default',array('class'=>'success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('The user could not be deleted', true),'default',array('class'=>'error'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	function admin_setting($userId=null){
		if ($this->request->is('post') || $this->request->is('put')) {
		
		$this->User->id=$userId;
		if($this->User->check_user_password($userId,$this->request->data))
		{
			$this->User->set($this->request->data);
			if($this->User->validates(array('fieldList' => array('password','new_password','confirm_password')))){
					
				
			if($this->User->save(array('password'=>md5($this->request->data['User']['new_password'])))){
				$this->Session->setFlash(__('Your password has been changed successfully', true),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'admin_setting'));
			}
			}
			
		}else{
			$this->Session->setFlash(__('Please Enter Correct Old Password', true),'default',array('class'=>'error'));
			
		}
		
	}
	}
	
}
