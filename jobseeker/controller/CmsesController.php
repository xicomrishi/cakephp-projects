<?php
App::uses('AppController', 'Controller');

class CmsesController extends AppController {


	public $components=array('Access','Email');
	public $uses=array('Cmse','Common');
	
	function beforeFilter(){
		$isAdmin=Configure::read('Routing.prefixes');
		$pos = strpos($_SERVER['REQUEST_URI'], $isAdmin[0]);
	    if($pos == true)
        {
		$this->Access->isValidUser();
		}
		
	}
	

	public function admin_index() {
		$this->Cmse->recursive = 0;
		$this->set('cmses', $this->paginate());
	}

	public function admin_view($id = null) {
		$this->Cmse->id = $id;
		if (!$this->Cmse->exists()) {
			throw new NotFoundException(__('Invalid Page'));
		}
		$this->set('cmse', $this->Cmse->read(null, $id));
	}


	public function admin_add() {
	
		if ($this->request->is('post')) {
			$this->Cmse->create();
			$this->request->data['Cmse']['page_added_date']=date('Y-m-d H:i:s');
			if ($this->Cmse->save($this->request->data)) {
				$this->Session->setFlash(__('The page has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.'),'default',array('class'=>'error'));
			}
		}
	}


	public function admin_edit($id = null) {
		
		$this->Cmse->id = $id;
		if (!$this->Cmse->exists()) {
			throw new NotFoundException(__('Invalid Page'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['Cmse']['page_modified_date']=date('Y-m-d H:i:s');
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
		$this->Session->setFlash(__('Page was not deleted'),'default',array('class'=>'error'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	/*-front end actions-*/
	function page($slug=null) {
		
		$this->set('title_for_layout',$slug);
	
		$this->layout="default";
		$pageContent=$this->Cmse->find('all',array('conditions'=>array('Cmse.page_slug'=>$slug),'recursive'=>0));
		$this->set('PageContent',$pageContent[0]);
	 }
	function contact_us() {
		$this->layout="default";
		$this->set('title_for_layout','contact us');
	
		if ($this->request->is('post') || $this->request->is('put')) {
			//print_r($this->request->data);die;
			$response=$this->contactMail($this->request->data);
			$this->Session->setFlash(__($response,true),'default',array('class'=>'success'));
		$this->redirect('/contacts');
		}
		
	}
	
	function submit_feedback()
	{
		$this->layout="ajax";
		if ($this->request->is('post') || $this->request->is('put')) {
			//print_r($this->request->data);die;
			$response=$this->contactMail($this->request->data);
			echo $response;die;
		
		}	
	}
	
	function contactMail($data=null){
				$toMail=$this->Common->findByKey('contact_us_email',array('fields'=>'value'));
				
				$from=$data['Email'];
				$to=$toMail['Common']['value'];//$email;
				$subject="Contact Form";
				$name='';
				$message='';
				$email=$data['Email'];
				if(isset($data['FirstName']) && isset($data['LastName']))
				{
					$name=$data['FirstName'].' '.$data['LastName'];
				}
				if(isset($data['Message']))
				{
					$message=$data['Message'];
				}
				if(isset($data['Name']))
				{
					$name=$data['Name'];
				}
				if(isset($data['requestType']))
				{
					$subject=$data['requestType'];
				}
				
				$formcontent="<b>Name:</b> $name <br> <b>Email:</b> $email <br> <b>Message:</b> $message" ;
							
				/*-template asssignment if any*/
				
						
												
				try{
					$this->Email->from=$from;
					$this->Email->to=$to;
					$this->Email->subject=$subject;
					$this->Email->sendAs='html';
					
					$this->Email->delivery = 'smtp';
						
					if($this->Email->send($formcontent)){
						return "<h4 class='success'>Thank You for contact us</h4>";
						
					}
				}catch(Exception $e){
					return "<h4 class='error'>The email could not be sent.Please contact to admin.</h4>";
					
				}
	}
	
	/*-[end]front end actions-*/
}
