<?php

App::import('Vendor',array('functions'));
App::import('Controller',array('Users'));

class ParticipantController extends AppController {

	public $components = array('Session');
	public $uses=array('User','Participant','Country','Company','Industry','Course');

	public function beforeFilter(){
		$this->layout='default';		
	}
	
	
	public function edit_participant($id)
	{
		$this->layout='ajax';
		$participant=$this->Participant->findById($id);
		$user=$this->User->findById($participant['Participant']['user_id']);
		$countries=$this->Country->find('all',array('order'=>array('Country.country_name ASC')));
		$industries=$this->Industry->find('all');
		$companies=$this->Company->find('all');
		
		$this->set('companies',$companies);
		$this->set('industries',$industries);
		$this->set('countries',$countries);
		$this->set('participant',$participant);
		$this->set('user',$user);
		$this->render('edit_participant');	
	}
	
	public function update_participant()
	{
		if(!empty($this->data))
		{
			$this->User->id=$this->data['User']['id'];
			$this->User->save($this->data);
			$this->Session->write('User.User.first_name',$this->data['User']['first_name']);
			$this->Session->write('User.User.last_name',$this->data['User']['last_name']);
			echo $this->data['User']['first_name'].' '.$this->data['User']['last_name'];
			die;	
		}	
	}
	
	public function view_participant($id,$comp_id=0)
	{
		$this->layout='ajax';
		$sql="select U.*,C.company,P.course_id,I.industry,CO.country_name,P.user_role_id from ".$this->Participant->tablePrefix.$this->Participant->table." P inner join ".$this->User->tablePrefix.$this->User->table." U ON (P.user_id=U.id) inner join ".$this->Company->tablePrefix.$this->Company->table." C ON (U.company=C.id) inner join ".$this->Industry->tablePrefix.$this->Industry->table." I ON (U.industry_id=I.id) inner join ".$this->Country->tablePrefix.$this->Country->table." CO ON (U.country_id=CO.country_id) where P.id='".$id."'";
		$participant=$this->Participant->query($sql);
		//echo '<pre>';print_r($participant);die;
		
		$course=$this->Course->findByCourseId($participant[0]['P']['course_id']);
		if($comp_id!=0)
		{			
			$this->set('comp_id',$comp_id);		
		}
		$this->set('user',$participant);
		$this->set('course',$course);
		$this->render('view_participant');	
	}
	
	
}