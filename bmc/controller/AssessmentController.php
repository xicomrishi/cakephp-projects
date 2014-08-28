<?php
App::uses('AppController', 'Controller');
App::import('Controller',array('Mail','Users'));
App::import('Vendor',array('functions'));

class AssessmentController extends AppController {

	public $components = array('Session','Access');
	public $uses=array('User','Trainer','Company','Industry','Country','Course','Participant','Question','Tool','Response');

	public function beforeFilter(){

		$this->layout='default';		
	}
	
	
	public function index()
	{
			
	}
	
	public function project_management($role_id)
	{
		$this->Access->checkParticipantSession();
		$this->layout='default';
				
		$questions=$this->Question->find('all',array('conditions'=>array('Question.tool_id'=>1,'Question.role_id'=>$role_id,'Question.language_id'=>$this->Session->read('Config.language_id'))));
		
		$data=array(); $i=0;
		foreach($questions as $ques)
		{
			if($ques['Question']['group_id']==1)
				$j=0;
			else if($ques['Question']['group_id']==2)
				$j=1;
			else if($ques['Question']['group_id']==3)
				$j=2;
			else if($ques['Question']['group_id']==4)
				$j=3;
			else if($ques['Question']['group_id']==5)
				$j=4;	
			else if($ques['Question']['group_id']==6)
				$j=5;					
			
			$data[$j]['question'][$i]['id']=$ques['Question']['id'];
			$data[$j]['question'][$i]['question_key']=$ques['Question']['question_key'];
			$data[$j]['question'][$i]['text']=$ques['Question']['question'];			
			$i++;					
		}
	
		$sql="select U.*,P.course_id,C.course_id,C.course_name,C.trainer_id,T.trainer_id,T.user_id from bmc_participant P inner join bmc_courses C on (P.course_id=C.course_id) inner join bmc_trainers T on (C.trainer_id=T.id) inner join bmc_users U on (T.user_id=U.id) where P.id='".$this->Session->read('User.Participant.Participant.id')."'";

		$trainer=$this->Participant->query($sql);		
		$tool=$this->Tool->findByToolTypeAndUserRoleId(1,$role_id);
		
		if($role_id=='3') $action='intro_pm_assessment';
		else if($role_id=='4') $action='intro_tm_assessment';
		else if($role_id=='5') $action='intro_mpm_assessment';
		
		$this->set('intro_text',$this->requestAction('/cms/get_cms_content/'.$action.'/'.$this->Session->read('Config.language_id')));
		$pr_id=$this->Session->read('User.Participant.Participant.id');
		$responses=$this->Response->findAllByParticipantId($pr_id);
		
		if(!empty($responses))
		{
			$this->redirect(array('controller'=>'reports','action'=>'project_management_report',$pr_id));	
		}
		
		$this->set('participant_id',$pr_id);
		$this->set('questions',$questions);
		
		$this->set('tool',$tool);
		$this->set('trainer',$trainer[0]);
		$this->set('data',$data);
		$this->render('project_management');
	}


	public function project_management_testing($role_id)
	{
		$this->layout='default';
		$questions=$this->Question->find('all',array('conditions'=>array('Question.tool_id'=>1,'Question.role_id'=>$role_id,'Question.language_id'=>$this->Session->read('Config.language_id'))));
		
		$data=array(); $i=0;
		foreach($questions as $ques)
		{
			if($ques['Question']['group_id']==1)
				$j=0;
			else if($ques['Question']['group_id']==2)
				$j=1;
			else if($ques['Question']['group_id']==3)
				$j=2;
			else if($ques['Question']['group_id']==4)
				$j=3;
			else if($ques['Question']['group_id']==5)
				$j=4;	
			else if($ques['Question']['group_id']==6)
				$j=5;					
			
			$data[$j]['question'][$i]['id']=$ques['Question']['id'];
			$data[$j]['question'][$i]['question_key']=$ques['Question']['question_key'];
			$data[$j]['question'][$i]['text']=$ques['Question']['question'];			
			$i++;					
		}
	
		$sql="select U.*,P.course_id,C.course_id,C.course_name,C.trainer_id,T.trainer_id,T.user_id from bmc_participant P inner join bmc_courses C on (P.course_id=C.course_id) inner join bmc_trainers T on (C.trainer_id=T.id) inner join bmc_users U on (T.user_id=U.id) where P.id='".$this->Session->read('User.Participant.Participant.id')."'";

		$trainer=$this->Participant->query($sql);		
		$tool=$this->Tool->findByToolTypeAndUserRoleId(1,$role_id);
		
		if($role_id=='3') $action='intro_pm_assessment';
		else if($role_id=='4') $action='intro_tm_assessment';
		else if($role_id=='5') $action='intro_mpm_assessment';
		
		$this->set('intro_text',$this->requestAction('/cms/get_cms_content/'.$action.'/'.$this->Session->read('Config.language_id')));
		$pr_id=$this->Session->read('User.Participant.Participant.id');
		$responses=$this->Response->findAllByParticipantId($pr_id);
		//pr($responses); die;
		if(!empty($responses))
		{
			$this->set('is_response','1');
			$this->set('responses',$responses);
			//$this->redirect(array('controller'=>'reports','action'=>'project_management_report',$pr_id));	
		}
		
		$this->set('participant_id',$pr_id);
		$this->set('questions',$questions);
		
		$this->set('tool',$tool);
		$this->set('trainer',$trainer[0]);
		$this->set('data',$data);
		$this->render('project_management');
	}
	
	
	public function submit_assessment($is_ajax=0)
	{		
		if(!empty($this->data))
		{
			$data=$this->data;
			$response=$already=array(); $i=0;
			$year=date("Y");			
			
			foreach($data as $index=>$group)
			{				
				if(!in_array($index,$already))    //to restrict multiple entries insertion for same participant
				{
					foreach($group as $resp)
					{						
						$num=$resp['check'];
						$participant=$response[$i]['participant_id']=$resp['participant_id'];
						$response[$i]['tool_id']=$resp['tool_id'];					
						$response[$i]['question_id']=$resp['qid'];
						$response[$i]['question_key']=$resp['qkey'];
						$response[$i]['response']=$num;
						$comments='';
						if($resp['inp'][$num]!='Comments')
							$comments=$resp['inp'][$num];
						$response[$i]['comments']=$comments;
						$response[$i]['year']=$year;
						$i++;	
					}
					$already[]=$index;
				}
			}
			
			$ppt=$this->Participant->find('first',array('conditions'=>array('Participant.id'=>$participant)));
			if($ppt['Participant']['status']=='0' && $ppt['Participant']['participant_status']=='1')
			{			
				$this->Response->create();
				$this->Response->saveAll($response);
				$this->Participant->id=$participant;
				$this->Participant->save(array('status'=>'1','survey_completion'=>date("Y-m-d H:i:s")));	
			}
			if($is_ajax==1)
			{
				echo $participant; die;
			}else{	
				$this->redirect(array('controller'=>'reports','action'=>'project_management_report_redirect',$participant));
			}
		
		}				
	}
	
	public function project_management_edit($role_id)
	{
		$this->Access->checkParticipantSession();
		$this->layout='default';
		$questions=$this->Question->find('all',array('conditions'=>array('Question.tool_id'=>1,'Question.role_id'=>$role_id,'Question.language_id'=>$this->Session->read('Config.language_id'))));
		
		$data=array(); $i=0;
		foreach($questions as $ques)
		{
			if($ques['Question']['group_id']==1)
				$j=0;
			else if($ques['Question']['group_id']==2)
				$j=1;
			else if($ques['Question']['group_id']==3)
				$j=2;
			else if($ques['Question']['group_id']==4)
				$j=3;
			else if($ques['Question']['group_id']==5)
				$j=4;	
			else if($ques['Question']['group_id']==6)
				$j=5;					
			
			$data[$j]['question'][$i]['id']=$ques['Question']['id'];
			$data[$j]['question'][$i]['question_key']=$ques['Question']['question_key'];
			$data[$j]['question'][$i]['text']=$ques['Question']['question'];			
			$i++;					
		}
	
		$sql="select U.*,P.course_id,C.course_id,C.course_name,C.trainer_id,T.trainer_id,T.user_id from bmc_participant P inner join bmc_courses C on (P.course_id=C.course_id) inner join bmc_trainers T on (C.trainer_id=T.id) inner join bmc_users U on (T.user_id=U.id) where P.id='".$this->Session->read('User.Participant.Participant.id')."'";

		$trainer=$this->Participant->query($sql);		
		$tool=$this->Tool->findByToolTypeAndUserRoleId(1,$role_id);
		
		if($role_id=='3') $action='intro_pm_assessment';
		else if($role_id=='4') $action='intro_tm_assessment';
		else if($role_id=='5') $action='intro_mpm_assessment';
		
		$this->set('intro_text',$this->requestAction('/cms/get_cms_content/'.$action.'/'.$this->Session->read('Config.language_id')));
		$pr_id=$this->Session->read('User.Participant.Participant.id');
		$responses=$this->Response->findAllByParticipantId($pr_id);
		//pr($responses); die;
		if(!empty($responses))
		{
			$this->set('is_response','1');
			$this->set('responses',$responses);
			//$this->redirect(array('controller'=>'reports','action'=>'project_management_report',$pr_id));	
		}
		
		$this->set('participant_id',$pr_id);
		$this->set('questions',$questions);
		
		$this->set('tool',$tool);
		$this->set('trainer',$trainer[0]);
		$this->set('data',$data);
		$this->render('project_management_edit');
	}
	
	public function project_management_edit_action(){
		
		$this->Access->checkParticipantSession();
			if($this->request->data){
				$data=$this->request->data;
				$response=$already=array(); $i=0;
				$year=date("Y");
				foreach($data as $index=>$group){				
				if(!in_array($index,$already)){    //to restrict multiple entries insertion for same participant
				
					foreach($group as $resp){						
							$num=$resp['check'];
							$response[$i]['id']=$resp['id'];
							$participant=$response[$i]['participant_id']=$resp['participant_id'];
							$response[$i]['tool_id']=$resp['tool_id'];					
							$response[$i]['question_id']=$resp['qid'];
							$response[$i]['question_key']=$resp['qkey'];
							$response[$i]['response']=$num;
							$comments='';
							if($resp['inp'][$num]!='Comments'){
								$comments=$resp['inp'][$num];
							}
							$response[$i]['comments']=$comments;
							$response[$i]['year']=$year;
							$i++;	
						}
							$already[]=$index;
					}
				}
				$ppt=$this->Participant->find('first',array('conditions'=>array('Participant.id'=>$participant)));
				if($this->Response->saveAll($response)){
					$this->Participant->id=$participant;
					$this->Participant->save(array('status'=>'1','survey_completion'=>date("Y-m-d H:i:s")));
					$this->redirect(array('controller'=>'reports','action'=>'project_management_report_redirect',$participant));
				}else{
					$this->Session->setFlash(__('An Internal error occurred please try again.'),'default',array('class'=>'error'));
					$this->redirect(array('controller'=>'dashboard','action'=>'participant_home',$ppt['Participant']['user_role_id']));					
				}
				
			}
		
		die;
	}
	
	
	public function participant_assessment($cr_id)
	{
		$course=$this->Course->find('first',array('conditions'=>array('Course.course_id'=>$cr_id,'Course.status'=>'1')));
		if(!empty($course))
		{
			$this->set('course',$course);
			$this->render('direct_assessment_page');
		}else{
			echo 'Requested Group Not found. Please try again';	
		}
	}
	
	public function participant_assessment_questions($role_id,$cr_id,$trainer_id)
	{
		$this->layout='ajax';
		$language_id=$this->Session->read('Config.language_id');
		if(empty($language_id))
			$language_id=1;		
		$questions=$this->Question->find('all',array('conditions'=>array('Question.tool_id'=>1,'Question.role_id'=>$role_id,'Question.language_id'=>$language_id)));
		
		$data=array(); $i=0;
		foreach($questions as $ques)
		{
			if($ques['Question']['group_id']==1)
				$j=0;
			else if($ques['Question']['group_id']==2)
				$j=1;
			else if($ques['Question']['group_id']==3)
				$j=2;
			else if($ques['Question']['group_id']==4)
				$j=3;
			else if($ques['Question']['group_id']==5)
				$j=4;	
			else if($ques['Question']['group_id']==6)
				$j=5;					
			
			$data[$j]['question'][$i]['id']=$ques['Question']['id'];
			$data[$j]['question'][$i]['question_key']=$ques['Question']['question_key'];
			$data[$j]['question'][$i]['text']=$ques['Question']['question'];			
			$i++;					
		}
	
		$trainer=$this->Trainer->findById($trainer_id);		
		$tool=$this->Tool->findByToolTypeAndUserRoleId(1,$role_id);
		
		if($role_id=='3') $action='intro_pm_assessment';
		else if($role_id=='4') $action='intro_tm_assessment';
		else if($role_id=='5') $action='intro_mpm_assessment';
		
		$this->set('intro_text',$this->requestAction('/cms/get_cms_content/'.$action.'/'.$this->Session->read('Config.language_id')));
		
		

		$this->set('questions',$questions);
		$this->set('role_id',$role_id);
		$this->set('course_id',$cr_id);
		$this->set('tool',$tool);
		$this->set('trainer',$trainer);
		$this->set('data',$data);
		$this->render('participant_assessment_questions');
	}

	
}