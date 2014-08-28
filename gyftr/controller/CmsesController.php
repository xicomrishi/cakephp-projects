<?php
App::uses('AppController', 'Controller');
/**
 * Cmses Controller
 *
 * @property Cmse $Cmse
 */
class CmsesController extends AppController {

/**
 * Helpers
 *
 * @var array
 */

	public $components=array('Access');
	
	function beforeFilter(){
		$this->Access->isValidUser();
		
	}
	
	
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Cmse->recursive = 0;
		$this->set('cmses', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Cmse->id = $id;
		if (!$this->Cmse->exists()) {
			throw new NotFoundException(__('Invalid Page'));
		}
		$this->set('cmse', $this->Cmse->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
	
		if ($this->request->is('post')) {
			$this->Cmse->create();
			if ($this->Cmse->save($this->request->data)) {
				$this->Session->setFlash(__('The page has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.'),'default',array('class'=>'error'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		
		$this->Cmse->id = $id;
		if (!$this->Cmse->exists()) {
			throw new NotFoundException(__('Invalid Page'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Cmse->save($this->request->data)) {
				$this->Session->setFlash(__('The page has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.'),'default',array('class'=>'error'));
			}
		} else {
			$this->request->data = $this->Cmse->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Cmse->id = $id;
		if (!$this->Cmse->exists()) {
			throw new NotFoundException(__('Invalid page'));
		}
		if ($this->Cmse->delete()) {
			$this->Session->setFlash(__('Page deleted'),'default',array('class'=>'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('page was not deleted'),'default',array('class'=>'error'));
		$this->redirect(array('action' => 'index'));
	}
}
