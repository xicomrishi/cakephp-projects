<?php
App::uses('AppController', 'Controller');

class ContentsController extends AppController {
	
	public $name = 'Contents';
	public $helpers = array('Form', 'Html', 'Js','Core','Session');
	public $paginate = array('limit' =>10);	

	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('page');
	}
	
	public function admin_index() {
		$this->Content->recursive = 0;
		$this->set('contents', $this->paginate());
	}

	public function admin_view($id = null) {
		$this->Content->id = $id;
		if (!$this->Content->exists()) {
			throw new NotFoundException(__('Invalid Page'));
		}
		$this->set('content', $this->Content->read(null, $id));
	}


	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Content->create();
			$this->request->data['Content']['page_added_date']=date('Y-m-d H:i:s');
			if ($this->Content->save($this->request->data)) {
				$this->Session->setFlash(__('The page has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.'),'default',array('class'=>'error'));
			}
		}
	}


	public function admin_edit($id = null) {
		$this->Content->id = $id;
		if (!$this->Content->exists()) {
			throw new NotFoundException(__('Invalid Page'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['Content']['page_modified_date']=date('Y-m-d H:i:s');
			if ($this->Content->save($this->request->data)) {
				$this->Session->setFlash(__('The page has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.'),'default',array('class'=>'error'));
			}
		} else {
			$this->request->data = $this->Content->read(null, $id);
		}
	}


	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Content->id = $id;
		if (!$this->Content->exists()) {
			throw new NotFoundException(__('Invalid page'));
		}
		if ($this->Content->delete()) {
			$this->Session->setFlash(__('Page deleted'),'default',array('class'=>'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Page was not deleted'),'default',array('class'=>'error'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	/*-front end actions-*/	
	public function page($slug=null){
			
		$this->layout='default';
		$this->Content->recursive=0;   		
   		$content=$this->Content->find('first',array('conditions'=>array('page_slug'=>$slug,'status'=>'Publish')));
   		$this->set('Content',$content);		
   		
	}
	
	/*-[end]front end actions-*/
}
