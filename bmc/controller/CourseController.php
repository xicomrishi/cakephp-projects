<?php
App::import('Vendor',array('functions'));
App::import('Controller',array('Users'));

class CourseController extends AppController {

	public $components = array('Session','Access');
	public $uses=array('User','Trainer','Course','Coursecompany','Company','Participant','Response','APresponse');
	public $paginate=array('limit'=>12);
	public function beforeFilter(){
		$this->layout='default';		
	}	

	public function add_course($tr_id)
	{
		$this->layout='ajax';
		$allcompanies=$this->Company->find('all',array('order'=>array('Company.company ASC')));
		$all_comps=array(); $i=0;
		foreach($allcompanies as $cmp)
		{
			$all_comps[$i]['label']=$cmp['Company']['company'];	
			$i++;
		}		
		$this->set('all_comps',$all_comps);
		$this->set('trainer_id',$tr_id);		
		$this->render('add_course');	
	}
	
	public function index($tr_id)
	{
		$this->Access->checkSession();
		$this->layout='default';
		if(isset($this->data['cbox']))
		{
			$del_id = implode(",", $this->data['cbox']);
            $this->delete_course($del_id);	
		}		
		
		$this->Course->bindModel(array('hasMany' => array('Participant' => array('className' => 'Participant','foreignKey' => 'course_id','conditions'=>array('Participant.participant_status'=>'1')))),false);
		$this->Course->recursive=2;
		$this->Course->primaryKey='course_id';
		$this->paginate['order'] = array('Course.created' => 'desc');
		if($tr_id==0)
		{
			$this->Course->bindModel(array('belongsTo'=>array('Trainer'=>array('className' => 'Trainer','foreignKey' => 'trainer_id'))),false);
			$courses=$this->paginate('Course',array('Course.status !='=>2));
		}else{
			$courses=$this->paginate('Course',array('Course.trainer_id' =>$tr_id,'Course.status !='=>2));
		}
		
		$data=array(); $i=0;
		foreach($courses as $cr)
		{
			$data[$i]['Course']=$cr['Course'];
			$participants=$cr['Participant'];
			$data[$i]['Course']['participant']=count($participants);
			if($tr_id==0)
			{
				$data[$i]['Course']['Trainer']=$cr['Trainer']['User']['first_name'].' '.$cr['Trainer']['User']['last_name'];	
			}
			$survey=0;		
			if(count($participants)>0)
			{
				foreach($participants as $part)
				{
					if($part['status']=='1')
						$survey++;
				}						
				$data[$i]['Course']['response_status']=round((($survey/count($participants))*100),2);
			}else{
				$data[$i]['Course']['response_status']=0;
			}
			$i++;	
		}	
		if($tr_id==0)
		{
			$this->set('is_admin','1');	
		}
		$this->Course->unbindModel(array('hasMany' => array('Participant')));
		$this->Course->primaryKey='id';
		$this->set('trainer_id',$tr_id);
		$this->set('courses',$data);
		$this->render('courses_index');	
	}
	
	public function save_course()
	{
		if(!empty($this->data))
		{
			$data=$this->data;
			$already=array();
			if(isset($data['Course']['id']))
			{
				$this->Course->id=$data['Course']['id'];
				$course=$this->Course->save($data);
				$all_companies=$this->Coursecompany->find('all',array('conditions'=>array('Coursecompany.course_id'=>$data['Course']['id'])));
				foreach($all_companies as $all_c)
				{
					$already[]=strtolower(trim($all_c['Coursecompany']['company']));
				}				
			}else{
				$trainer=$this->Trainer->find('first',array('conditions'=>array('Trainer.id'=>$data['Course']['trainer_id'],'Trainer.status'=>'1')));
				if(!empty($trainer))
				{
					$data['Course']['created']=date("Y-m-d H:i:s");				
					$data['Course']['course_id']='CR'.time();   	
					$this->Course->create();
					$course=$this->Course->save($data);
				}else{
					$this->redirect('/login/invalidSession/trainer');	
				}
			}
			
			$comp_data=$companies=array(); $i=0;				
			foreach($data['company'] as $comp)
			{
				if(!in_array(strtolower(trim($comp['name'])),$already))
				{
					$comp_data[$i]['Coursecompany']['course_id']=$course['Course']['id'];	
					$comp_data[$i]['Coursecompany']['company']=$comp['name'];
					$already[]=strtolower(trim($comp['name']));
					$companies[]=trim($comp['name']);
					$i++;	
				}
			}				
			$this->Coursecompany->create();
			$this->Coursecompany->saveAll($comp_data);
			
			if(!empty($companies))
			{
				$this->update_companies_list($companies,$this->Session->read('User.User.id'));
			}
			echo $data['Course']['trainer_id']; die;	
		}	
	}	
		
	public function delete_course($cr_id,$tr_id=0,$flag=0)
	{        
		$courses = $this->Course->query("select id,course_id from bmc_courses Course where id in ($cr_id)");
				
		foreach ($courses as $cors) {			
			$prs=$this->Participant->find('all',array('conditions'=>array('Participant.course_id'=>$cors['Course']['course_id'])));
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
			$cr_sql="delete from bmc_course_company where `course_id`='".$cors['Course']['id']."'";
			$this->Coursecompany->query($cr_sql);
			$course_sql="delete from bmc_courses where `id`='".$cors['Course']['id']."'";
			$this->Course->query($course_sql);					
		}				
		
		if($flag==0)
		{	
			return;
		}else{
			$this->redirect(array('action'=>'index',$tr_id));
		}
	}
	
	public function update_companies_list($companies,$user_id)
	{
		$exist=$this->Company->find('all');
		$already=array();
		if(!empty($exist))
		{
			foreach($exist as $ex)
			{
				$already[]=strtolower(trim($ex['Company']['company']));	
			}
		}
		$i=0; $data=array();
		foreach($companies as $comp)
		{
			if(!in_array(strtolower(trim($comp)),$already))
			{
				$data[$i]['company']=$comp;
				$data[$i]['user_id']=$user_id;
				$i++;
			}	
		}
		if(!empty($data))
		{
			$this->Company->create();
			$this->Company->saveAll($data);	
		}
		return;
	}
	
	public function edit_course($cr_id)
	{
		$this->layout='ajax';
		$course=$this->Course->findById($cr_id);
		if(!empty($course))
		{
			$company=$this->Coursecompany->findAllByCourseId($cr_id);
			$allcompanies=$this->Company->find('all',array('order'=>array('Company.company ASC')));
			$all_comps=array(); $i=0;
			foreach($allcompanies as $cmp)
			{
				$all_comps[$i]['label']=$cmp['Company']['company'];	
				$i++;
			}
			$this->set('all_comps',$all_comps);
			$this->set('trainer_id',$course['Course']['trainer_id']);
			$this->set('course',$course);
			$this->set('company',$company);
			$this->render('add_course');	
		}	
	}
	
	public function accountability($cr_id,$comp_id=0)
	{
		$this->layout='ajax';
		$user=$this->Session->read('User');		
		$course=$this->Course->findById($cr_id);
		if(!empty($course))
		{			
			$sql="select P.*,U.*,C.* from bmc_participant P join bmc_users U on (P.user_id=U.id) join bmc_companies C on (U.company=C.id) where P.course_id='".$course['Course']['course_id']."' and P.participant_status='1'";
			$participants=$this->Participant->query($sql);			
			if($comp_id==0)
			{
				$companies=$this->Company->find('all',array('order'=>array('Company.company ASC')));
				$this->set('companies',$companies);
				$this->set('trainer_id',$course['Course']['id']);
			}else{
				$this->set('comp_id',$comp_id);	
			}
			
			$this->set('user',$user);			
			$this->set('course',$course);
			$this->set('participants',$participants);
			$this->render('accountability_report');
		}	
	}
	
	public function remove_participant($pr_id,$cr_id)
	{
		$this->layout='ajax';
		$this->Participant->id=$pr_id;
		$this->Participant->saveField('participant_status','0');
		$this->accountability($cr_id);	
	}
	
	public function remove_assessment($pr_id,$cr_id)
	{
		$this->layout='ajax';
		if(!empty($pr_id))
		{
			$this->Response->deleteAll(array('Response.participant_id'=>$pr_id));
			$this->Participant->id=$pr_id;
			$this->Participant->save(array('status'=>'0','survey_completion'=>''));
		}
		$this->accountability($cr_id);	
	}
				
}