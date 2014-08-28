<?php

App::import('Vendor',array('functions'));
App::import('Controller',array('Users'));

class TrainerController extends AppController {

	public $components = array('Session','Access');
	public $uses=array('User','Trainer','Course','Response','APresponse','Participant','Coursecompany');

	public function beforeFilter(){
		$this->layout='default';		
	}
	
	
	public function admin_index($num=0)
	{
		$this->Access->checkAdminSession();
		$this->Trainer->bindModel(
			array('hasMany' => array(
					'Course' => array(
						'className' => 'Course',
						'foreignKey' => 'trainer_id'
					)
				)
			),false
		);
		$this->Trainer->recursive=2;
		$this->paginate=array('conditions'=>array('Trainer.status !='=>2),'order'=>array('User.last_name'=>'ASC','User.first_name'=>'ASC'),'limit'=>20);
		$trainers=$this->paginate('Trainer');	
		//echo '<pre>';print_r($trainers); die;
		$data=array(); $i=0;
		foreach($trainers as $tr)
		{
			$data[$i]['Trainer']=$tr['Trainer'];
			$data[$i]['User']=$tr['User'];
			$data[$i]['Trainer']['courses']=count($tr['Course']);	
			$i++;
		}
		//echo '<pre>';print_r($trainers);die;
		$this->set('trainers',$data);
		$this->Trainer->unbindModel(
       		 array('hasMany' => array('Course'))
   		 );
		if($num==1)
		{	
			$this->layout='ajax';
			$this->set('is_rendered','1');	
		}
	}
	
	public function add_trainer()
	{
		$this->layout='ajax';
		$this->render('add_trainer');	
	}
	
	public function save_trainer()
	{
		if(!empty($this->data))
		{
			if(!empty($this->data['Trainer']['id']))
			{
				$trainer=$this->Trainer->findById($this->data['Trainer']['id']);
				$this->request->data['User']['city']=$this->request->data['User']['country_id']=$this->request->data['User']['industry_id']=$this->request->data['User']['company_url']=$this->request->data['User']['corporate_email']='';
				$this->User->id=$trainer['Trainer']['user_id'];
				$this->User->save($this->data);
				$user=$this->User->findById($trainer['Trainer']['user_id']);
				$this->Session->write('User',$user);
				$this->Session->write('User.type','Trainer');
				$this->Session->write('User.Trainer',$trainer);
				echo $user['User']['first_name'].' '.$user['User']['last_name'];
			}else{
				$User=new UsersController;
				$User->constructClasses();
				$this->request->data['User']['city']=$this->request->data['User']['country_id']=$this->request->data['User']['industry_id']=$this->request->data['User']['company_url']='';
				$msg=$User->createAccount($this->data,2);
				echo $msg;
			}
			die;			
		}	
	}
	
	public function change_status()
	{
		$this->Trainer->id=$this->data['id'];
		$this->Trainer->saveField('status',$this->data['status']);	
		//$sql="update bmc_courses set status=".$this->data['status']." where trainer_id='".$this->data['id']."'";
		//$this->Course->query($sql);
		if($this->data['status']==0) echo 'Activate'; else echo 'Deactivate'; 
		die;
	}
	
	public function delete_trainer($tr_id)
	{
        $trainers = $this->Trainer->query("select id,user_id from bmc_trainers Trainer where id in ($tr_id)");		
        foreach ($trainers as $train) {
			$trainer=$this->Trainer->findById($train['Trainer']['id']);
			//$this->Trainer->id=$train['Trainer']['id'];
			//$this->Trainer->saveField('status',2);
			$this->Trainer->delete($trainer['Trainer']['id']);
			$sql="update bmc_users set user_role_id=replace(user_role_id,'2','') where id='".$trainer['Trainer']['user_id']."'";
			$this->User->query($sql);
			$courses=$this->Course->find('all',array('conditions'=>array('Course.trainer_id'=>$trainer['Trainer']['id'])));
			if(!empty($courses))
			{
				
				foreach($courses as $cr)
				{
					
					$prs=$this->Participant->find('all',array('conditions'=>array('Participant.course_id'=>$cr['Course']['course_id'])));
					if(!empty($prs))
					{
						foreach($prs as $p)
						{
							$res_sql="delete from bmc_responses where `participant_id`='".$p['Participant']['id']."'";
							$this->Response->query($res_sql);
							$ap_sql="delete from bmc_actionplan_response where `participant_id`='".$p['Participant']['id']."'";
							$this->APresponse->query($ap_sql);	
							$parti_sql="delete from bmc_participant where `id`='".$p['Participant']['id']."'";
							$this->Participant->query($parti_sql);
						}
						
					}
					
					$cr_sql="delete from bmc_course_company where `course_id`='".$cr['Course']['id']."'";
					$this->Coursecompany->query($cr_sql);
					$course_sql="delete from bmc_courses where `id`='".$cr['Course']['id']."'";
					$this->Course->query($course_sql);					
				}
				
			}
		}		
		return;	
	}
	
	public function search_trainer()
	{
		if(isset($this->data['cbox']))
		{
			$del_id = implode(",", $this->data['cbox']);
            $this->delete_trainer($del_id);	
		}
		$this->layout='ajax';
		$trainers=$this->Trainer->find('all',array('conditions'=>array('Trainer.status !=' => '2')));
		$data=array(); $i=0;
		foreach($trainers as $tr)
		{
			$data[$i]['Trainer']=$tr['Trainer'];
			$data[$i]['User']=$tr['User'];
			$data[$i]['Trainer']['courses']=$this->Course->find('count',array('conditions'=>array('Course.trainer_id'=>$tr['Trainer']['id'])));	
			$i++;
		}
		//echo '<pre>';print_r($trainers);die;
		//$this->set('trainers',$data);
		//$this->render('trainers_index');
		die;
	}
	
	public function edit_trainer($id)
	{
		$this->layout='ajax';
		$trainer=$this->Trainer->findById($id);
		$this->set('trainer',$trainer);
		$this->render('add_trainer');	
	}
	
	public function view_trainer($id)
	{
		$this->layout='ajax';
		$trainer=$this->Trainer->findById($id);
		$this->set('trainer',$trainer);
		$this->render('view_trainer');	
	}
	
		
}