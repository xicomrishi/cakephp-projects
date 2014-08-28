<?php

/**
 * Name : CMS Controller
 * Created : 8 Nov 2013
 * Purpose : Default CMS controller
 * Author : Prakhar Johri
 */ 
class CmsController extends AdminAppController
{
	public $name = 'Cms';
	public $uses = array('Cms');
	
	public $paginate = array ('limit' => 10);		
		
	public function beforeFilter()
	{
		//Set auth model Admin
		parent::beforeFilter();
		$this->Auth->authenticate = array(
			'Form' => array('userModel' => 'Admin')
		);
		$this->Auth->allow('register');
	}	
			
	/**
	 * Name : Index
	 * Purpose : Default index function for CMS Pages. Display  CMS page listing and other filters
	 * Created : 8 Nov 2013	 
	 * Author : Prakhar Johri
	 */ 
	public function index()
	{	
		//This section handles multipe delete and change status
		if(isset($this->request->data['option']) && !empty($this->request->data['option']))
		{
			if(!empty($this->request->data['ids']))
			{
				switch($this->request->data['option'])
				{
					case "delete":
						$this->Cms->deleteAll(array('id' => $this->request->data['ids']));
						$this->Session->setFlash(__('Selected users deleted sucessfully'));
					break;
					case "active":
						$this->Cms->updateAll(array('status' => "'active'"), array('id' =>  $this->request->data['ids'] ));
					break;
					case "deactive":
						$this->Cms->updateAll(array('status' => "'inactive'"), array('id' =>  $this->request->data['ids'] ));
					break;
				}
			}
		}
	
		//This section handles search
		if(isset($_GET['filter']))
		{
			$this->paginate = array(		
					'limit' => 10,
					'conditions' => array('Cms.'.$_GET['filter'].' Like ' => $_GET['search_keyword'].'%'),					
					);			
			
		}				
		$cms = $this->paginate('Cms');
		$this->set('cms', $cms);		
	}
		
	/**
	 * Name : Add Action
	 * Created : 8 Nov 2013
	 * Purpose : For add new CMS Pages
	 * Author : Prakhar Johri
	 */
	public function add() 
	{
		if ($this->request->is('post')) 
		{
			$this->Cms->create();			
			if ($this->Cms->save($this->request->data)) 
			{
				$this->Session->setFlash(__('The Cms has been saved'));
				$this->redirect(array('action' => 'index'));
			} 
			else 
			{
				$this->Session->setFlash(__('The Cms could not be saved. Please, try again.'));
			}
		}
	}
	
	/**
	 * Name : Edit user action
	 * Created :8 Nov 2013
	 * Purpose : For edit CMS page
	 * Author : Prakhar Johri
	 */
	public function edit($id = null) 
	{		
		if (!$this->Cms->exists($id)) 
		{
			throw new NotFoundException(__('Invalid Cms'));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->Cms->save($this->request->data)) 
			{
				$this->Session->setFlash(__('Cms page is saved'));
				$this->redirect(array('action' => 'index'));
			} 
			else 
			{
				$this->Session->setFlash(__('Error saving page, please check again.'));
			}
		} 
		else 
		{
			$options = array('conditions' => array('Cms.' . $this->Cms->primaryKey => $id));
			$this->request->data = $this->Cms->find('first', $options);
		}
		$this->set('page', 'edit');
		$this->render('add');
	}
}

?>
