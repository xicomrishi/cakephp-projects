<?php
App::uses('AppController', 'Controller');
App::import('Vendor',array('functions'));
class DashboardController extends AppController {

	public $components = array('Session');
	public $uses=array('User','Trainer','Participant','Cms','Response');

	public function beforeFilter(){
		$this->layout='default';	
	}
	
	
	public function admin_index()
	{
		$this->set('intro_text',$this->requestAction('/cms/get_cms_content/admin_dashboard'));
	}
	
	public function trainer_home()
	{		
		if(!$this->Session->check('User'))
			$this->redirect('/login/trainer_login');
		else{	
			$this->set('trainer_id',$this->Session->read('User.Trainer.Trainer.id'));
			$this->set('intro_text',$this->requestAction('/cms/get_cms_content/trainer_dashboard'));	
		}
	}
	
	public function participant_home($role_id=0,$num=0)
	{		
		if(!$this->Session->check('User')||$role_id==0)
			$this->redirect('/');
		else{
			$part_id=$this->Session->read('User.Participant.Participant.id');
			$part=$this->Participant->findById($part_id);
			$language_id=$this->Session->read('Config.language_id');
			$intro_text=$this->Cms->find('first',array('conditions'=>array('Cms.page_slug'=>'participant_dashboard','language_id'=>$language_id)));
			$responses=$this->Response->findAllByParticipantId($part_id);
			
				$this->set('intro_text',$intro_text['Cms']['content']);
				$this->set('role_id',$role_id);
				if(!empty($responses)){
					$this->set('resp',1);
				}
				$this->render('participant_home');
				
			
		}
	}
	
	
	
}