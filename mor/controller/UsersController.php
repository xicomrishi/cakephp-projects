<?php
class UsersController extends AppController {

	public $name = 'Users';
	public $helpers = array('Form', 'Html', 'Js','Session');
	public $paginate = array('limit' =>10);	
	public $uses=array('User','UserRole','Country');
	
	function beforeFilter(){
		parent::beforeFilter();
		
		$userRoleId=$this->Auth->user('user_role_id');
		if((int)$userRoleId>1){
			 $this->Auth->deny(array('index','admin_view', 'admin_add', 'admin_edit','admin_delete'));
  
		}
	}
	

	function admin_profile() {

		$this->layout='admin';
			
		$userId=$this->Auth->user('user_id');		
		$this->User->id = $userId;
		$this->User->validator()->remove('password');
		
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid User'));
		}
		if ($this->request->is('post') || $this->request->is('put')){
			
			$this->request->data['User']['user_modified_date']=date('Y-m-d H:i:s');
			
			unset($this->request->data['User']['email']);
			unset($this->request->data['User']['user_role_id']);
			unset($this->request->data['User']['user_status']);
			
			if(!empty($this->request->data['User']['password'])){
				$newPass=$this->request->data['User']['password'];
				$this->request->data['User']['password']=AuthComponent::password($newPass);
			}else{
				unset($this->request->data['User']['password']);
			}
			
			if($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user updated successfully',true),'default',array('class'=>'success'));
				$this->redirect(array('controller'=>'home','action' => 'index'));
			} else {
				$this->request->data['User']['password']=$newPass;
				$this->Session->setFlash(__('The user could not be saved. Please, try again.',true),'default',array('class'=>'error'));
			}
		}

		if(empty($this->request->data)){
			$data=$this->User->read(null, $this->User->id);
			$data['User']['password']='';
			$this->request->data=$data;
		}	
				
		$country=$this->Country->find('all');
		$this->set('Country',$country);
		
	}
	
	function admin_index() {		
		$this->set('Users', $this->paginate());
	}
	
	
	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User', true),'default',array('class'=>'error'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('User', $this->User->read(null, $id));
	
	}

	function admin_add(){
				
		if (!empty($this->request->data) && $this->request->is('post')) {
			$this->User->create();
			
			$this->request->data['User']['user_added_date']=date('Y-m-d H:i:s');
			$pass=$this->request->data['User']['password'];
			$this->request->data['User']['password']=AuthComponent::password($pass);
			
			if($this->User->save($this->request->data)) {
			 	$this->Session->setFlash(__('The user added successfully',true),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->request->data['User']['password']=$pass;
				$this->Session->setFlash(__('The user could not be saved. Please, try again.',true),'default',array('class'=>'error'));
			}
	      
		}
		
		$roles=$this->UserRole->find('all',array('conditions'=>array('user_role_status'=>'Active'),'order'=>array('user_role_name'=>'asc')));
		$this->set('Roles',$roles);
		
		$country=$this->Country->find('all');
		$this->set('Country',$country);
	
	}

		
	function admin_edit($id = null) {
	
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid User'));
		}
		$this->User->validator()->remove('password');
		
		if ($this->request->is('post') || $this->request->is('put')) {
			
				
			$adminCount=$this->User->find('count',array('conditions'=>array('User.user_role_id'=>1)));
			if($adminCount<=1 && $this->request->data['User']['user_role_id']!=1){
				$this->Session->setFlash(__('At least on administrator is required.', true),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index'));
				die;
			}
			
			$this->request->data['User']['user_modified_date']=date('Y-m-d H:i:s');

			$newPass='';
			if(!empty($this->request->data['User']['password'])){
				$newPass=$this->request->data['User']['password'];
				$this->request->data['User']['password']=AuthComponent::password($newPass);
			}else{
				unset($this->request->data['User']['password']);
			}
			
			if($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user updated successfully',true),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->request->data['User']['password']=$newPass;
				$this->Session->setFlash(__('The user could not be saved. Please, try again.',true),'default',array('class'=>'error'));
			}
		}
		
		if (empty($this->request->data)) {
			$data=$this->User->read(null, $id);
			unset($data['User']['password']);
			$this->request->data = $data;
		}
	
		$roles=$this->UserRole->find('all',array('conditions'=>array('user_role_status'=>'Active'),'order'=>array('user_role_name'=>'asc')));
		$this->set('Roles',$roles);
		
		$country=$this->Country->find('all');
		$this->set('Country',$country);
	}

	
	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
			die;
		}
		
		$admins=$this->User->find('all',array('conditions'=>array('User.user_role_id'=>1)));
		
		if(count($admins)<=1 && $id==$admins[0]['User']['user_id']){
			$this->Session->setFlash(__('At least on administrator is required.', true),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
			die;
		}
		
		
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('The user deleted successfully', true),'default',array('class'=>'success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('The user could not be deleted', true),'default',array('class'=>'error'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	/*function index() {
	
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
		
	}*/
	
}
