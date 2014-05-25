<?php
App::uses('AppController', 'Controller');

class EmailTemplatesController extends AppController {

	public $components=array('Access');
	public $layout='admin';
	
	function beforeFilter(){
		$this->Access->isValidUser();
		
	}

	public function admin_index() {
		$this->EmailTemplate->recursive = 0;
		$this->set('EmailTemplate', $this->paginate());
	}

	public function admin_view($id = null) {
		$this->EmailTemplate->id = $id;
		if (!$this->EmailTemplate->exists()) {
			throw new NotFoundException(__('Invalid Page'));
		}
		$this->set('EmailTemplate', $this->EmailTemplate->read(null, $id));
	}

	public function admin_add() {
	
		if ($this->request->is('post')) {
			$this->EmailTemplate->create();
			$this->request->data['EmailTemplate']['template_added_date']=date('Y-m-d H:i:s');
			if ($this->EmailTemplate->save($this->request->data)) {
				$this->Session->setFlash(__('The email template has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The email template could not be saved. Please, try again.'),'default',array('class'=>'error'));
			}
		}
	}


	public function admin_edit($id = null) {
		
		$this->EmailTemplate->id = $id;
		if (!$this->EmailTemplate->exists()) {
			throw new NotFoundException(__('Invalid Template'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['EmailTemplate']['template_modified_date']=date('Y-m-d H:i:s');
			if ($this->EmailTemplate->save($this->request->data)) {
				$this->Session->setFlash(__('The template has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The template could not be saved. Please, try again.'),'default',array('class'=>'error'));
			}
		} else {
			$this->request->data = $this->EmailTemplate->read(null, $id);
		}
	}

	public function admin_delete($id = null) {
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->EmailTemplate->id = $id;
		if (!$this->EmailTemplate->exists()) {
			throw new NotFoundException(__('Invalid Template'));
		}
		if ($this->EmailTemplate->delete()) {
			$this->Session->setFlash(__('Template deleted'),'default',array('class'=>'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Template was not deleted'),'default',array('class'=>'error'));
		$this->redirect(array('action' => 'index'));
	}
}
