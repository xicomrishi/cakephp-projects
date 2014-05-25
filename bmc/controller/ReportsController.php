<?php
App::uses('AppController', 'Controller');
App::import('Controller',array('Mail','Users'));
App::import('Vendor',array('functions','xtcpdf'));

class ReportsController extends AppController {

	public $components = array('Session','Access','RequestHandler');
	public $uses=array('User','Trainer','Company','Industry','Country','Course','Participant','Question','Tool','Response','APquestion','APresponse','Coursecompany','BenchmarkCourse','BenchmarkData');

	public function beforeFilter(){
		$this->Access->checkParticipantSession();
		$this->layout='default';	
		ini_set("memory_limit","1200M");
		ini_set("max_execution_time","0");	
	}	
	 
	
	public function index()
	{
			
	}
	
	public function project_management_report($pr_id,$num=0)
	{		
		$ppt=$this->Participant->findById($pr_id);
		if($ppt['Participant']['status']=='1')
		{
			$this->getReport($ppt['Participant']['user_id'],$ppt['Participant']['user_role_id'],$ppt['Participant']['course_id'],$ppt['Participant']['id']);
			$course=$this->Course->findByCourseId($ppt['Participant']['course_id']);
			$user_data=$this->User->findById($ppt['Participant']['user_id']);
			//$benchmark=$this->BenchmarkCourse->find('first',array('conditions'=>array('BenchmarkCourse.course_id'=>$course['Course']['id'])));
			//if(!empty($benchmark))
			//{
				$bench_data=array();
				$bench_group_sql="select sum(num_a) as num_5, sum(num_b) as num_4,sum(num_c) as num_3,sum(num_d) as num_2,sum(num_e) as num_1 from bmc_benchmark_data where role_id='".$ppt['Participant']['user_role_id']."' group by group_id";
				$bench_data['group']=$this->BenchmarkData->query($bench_group_sql);
				
				$bench_company_sql="select sum(num_a) as num_5, sum(num_b) as num_4,sum(num_c) as num_3,sum(num_d) as num_2,sum(num_e) as num_1 from bmc_benchmark_data where company_id='".$user_data['User']['company']."'  group by group_id";
				$bench_data['company']=$this->BenchmarkData->query($bench_company_sql);
				
				$bench_comp_con_sql="select sum(num_a) as num_5, sum(num_b) as num_4,sum(num_c) as num_3,sum(num_d) as num_2,sum(num_e) as num_1 from bmc_benchmark_data where company_id='".$user_data['User']['company']."' and country_id='".$user_data['User']['company_location']."'  group by group_id";
				
				$bench_data['company_country']=$this->BenchmarkData->query($bench_comp_con_sql);
				
				$bench_industry_sql="select sum(num_a) as num_5, sum(num_b) as num_4,sum(num_c) as num_3,sum(num_d) as num_2,sum(num_e) as num_1 from bmc_benchmark_data where industry_id='".$user_data['User']['industry_id']."'  group by group_id";
				$bench_data['industry']=$this->BenchmarkData->query($bench_industry_sql);
				
				$bench_overall_sql="select sum(CAST(trim(num_a) as UNSIGNED)) as num_5, sum(CAST(trim(num_b) as UNSIGNED)) as num_4,sum(CAST(trim(num_c) as UNSIGNED)) as num_3,sum(CAST(trim(num_d) as UNSIGNED)) as num_2,sum(CAST(trim(num_e) as UNSIGNED)) as num_1 from bmc_benchmark_data where 1=1  group by group_id";
				$bench_data['overall']=$this->BenchmarkData->query($bench_overall_sql);
						
				$all_bench=array(); $r=0;
				foreach($bench_data as $ab)
				{					
					
					for($s=0;$s<6;$s++)
					{
						if(!empty($ab))
						{
							if(($ab[$s][0]['num_5']+$ab[$s][0]['num_4']+$ab[$s][0]['num_3']+$ab[$s][0]['num_2']+$ab[$s][0]['num_1'])>0)
							{	$calc=(intval((($ab[$s][0]['num_5']))+intval(($ab[$s][0]['num_4']))+intval(($ab[$s][0]['num_3']))+intval(($ab[$s][0]['num_2']))+intval(($ab[$s][0]['num_1']))))/(intval(($ab[$s][0]['num_5'])+intval($ab[$s][0]['num_4'])+intval($ab[$s][0]['num_3'])+intval($ab[$s][0]['num_2'])+intval($ab[$s][0]['num_1'])));	
							}else{
								$calc=intval((($ab[$s][0]['num_5']))+intval(($ab[$s][0]['num_4']))+intval(($ab[$s][0]['num_3']))+intval(($ab[$s][0]['num_2']))+intval(($ab[$s][0]['num_1'])));	
							}
							$all_bench[$r][$s]['val']=$ab[$s][0];
							$all_bench[$r][$s]['avg']=$calc;
						}else{
							$all_bench[$r][$s]['val']=0;
							$all_bench[$r][$s]['avg']=0;
						}
					}					
					$r++;
										
				}	
				//pr($all_bench);die;	
				$this->set('bench_data',$all_bench);
			//}						
			$this->set('course',$course);	
			$this->set('pr_id',$pr_id);
			$this->set('participant',$ppt);
			$this->set('intro_text',$this->requestAction('/cms/get_cms_content/intro_participant_report/'.$this->Session->read('Config.language_id')));
			if($num==0)
			{	
				$this->layout='default';
				$this->render('project_management_report');
			}else{
				$this->layout='report_pdf';
				$this->render('project_management_report_pdf');	
			}
		}else{
			$this->redirect(array('controller'=>'assessment','action'=>'index',$ppt['Participant']['user_role_id']));	
		}
	}
		
	public function getReport($userid,$role_id,$course_id,$pr_id)
	{		
		$user=$this->User->find('first',array('conditions'=>array('User.id'=>$userid),'fields'=>array('User.*')));
		$language_id=$this->Session->read('Config.language_id');
		//////////####### Section Query #########//////////////
		$section_sql="select avg(trim(R.response)) as avg,P.user_role_id,P.user_role_id,Q.question_key,Q.group_id,Q.question,R.response from bmc_responses R join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' group by P.user_role_id,Q.group_id order by Q.group_id,P.user_role_id";			
		$responses=$this->Response->query($section_sql);		
		
		$sql_section_self="select avg(trim(R.response)) as avg from bmc_responses R join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and P.user_id='".$user['User']['id']."' and Q.tool_id='1' group by Q.group_id order by Q.group_id";
		$self_response=$this->Response->query($sql_section_self);
		
		$group_sql="select avg(trim(R.response)) as avg,P.user_role_id from bmc_responses R join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) join bmc_companies C on (U.company=C.id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' group by Q.group_id order by Q.group_id";		
		$group_response=$this->Response->query($group_sql);
		
		$group_count_sql="select sum(CAST(trim(R.response) AS UNSIGNED)) as sum, P.id, Q.group_id from bmc_responses R left join bmc_questions Q on (Q.id=R.question_id) left join bmc_participant P on (P.id=R.participant_id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."'  group by Q.group_id,P.id";		
		$group_count_response=$this->Response->query($group_count_sql);
		
		$gpc_arr=$cpc_arr=$clc_arr=$ic_arr=$oc_arr=array();
		
		foreach($group_count_response as $gpc)
		{
			if($gpc['0']['sum']<=10)
			{	
				if(!isset($gpc_arr[$gpc['Q']['group_id']]['1']))
								$gpc_arr[$gpc['Q']['group_id']]['1']=0;	
				$gpc_arr[$gpc['Q']['group_id']]['1']+=1;
			}
			if($gpc['0']['sum']>10 && $gpc['0']['sum']<=20)
			{
				if(!isset($gpc_arr[$gpc['Q']['group_id']]['2']))
								$gpc_arr[$gpc['Q']['group_id']]['2']=0;	
				$gpc_arr[$gpc['Q']['group_id']]['2']+=1;			
			}
			if($gpc['0']['sum']>20 && $gpc['0']['sum']<=30)
			{
				if(!isset($gpc_arr[$gpc['Q']['group_id']]['3']))
								$gpc_arr[$gpc['Q']['group_id']]['3']=0;	
				$gpc_arr[$gpc['Q']['group_id']]['3']+=1;			
			}
			if($gpc['0']['sum']>30 && $gpc['0']['sum']<=40)
			{
				if(!isset($gpc_arr[$gpc['Q']['group_id']]['4']))
								$gpc_arr[$gpc['Q']['group_id']]['4']=0;	
				$gpc_arr[$gpc['Q']['group_id']]['4']+=1;			
			}
			if($gpc['0']['sum']>40  && $gpc['0']['sum']<=50)
			{
				if(!isset($gpc_arr[$gpc['Q']['group_id']]['5']))
								$gpc_arr[$gpc['Q']['group_id']]['5']=0;	
				$gpc_arr[$gpc['Q']['group_id']]['5']+=1;			
			}
		}		
				
		$company_sql="select avg(trim(R.response)) as avg,C.company from bmc_responses R join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) join bmc_companies C on (U.company=C.id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' and U.company='".$user['User']['company']."' group by Q.group_id order by Q.group_id";		
		$company_response=$this->Response->query($company_sql);
		
		$company_count_sql="select sum(CAST(trim(R.response) AS UNSIGNED)) as sum, P.id, Q.group_id from bmc_responses R left join bmc_questions Q on (Q.id=R.question_id) left join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) join bmc_companies C on (U.company=C.id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' and U.company='".$user['User']['company']."' group by Q.group_id,P.id";		
		$company_count_response=$this->Response->query($company_count_sql);		
		foreach($company_count_response as $cpc)
		{
			if($cpc['0']['sum']<=10)
			{	
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['1']))
								$cpc_arr[$cpc['Q']['group_id']]['1']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['1']+=1;
			}
			if($cpc['0']['sum']>10 && $cpc['0']['sum']<=20)
			{
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['2']))
								$cpc_arr[$cpc['Q']['group_id']]['2']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['2']+=1;			
			}
			if($cpc['0']['sum']>20 && $cpc['0']['sum']<=30)
			{
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['3']))
								$cpc_arr[$cpc['Q']['group_id']]['3']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['3']+=1;			
			}
			if($cpc['0']['sum']>30 && $cpc['0']['sum']<=40)
			{
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['4']))
								$cpc_arr[$cpc['Q']['group_id']]['4']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['4']+=1;			
			}
			if($cpc['0']['sum']>40  && $cpc['0']['sum']<=50)
			{
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['5']))
								$cpc_arr[$cpc['Q']['group_id']]['5']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['5']+=1;			
			}
		}
		//pr($cpc_arr); die;
		
		$company_location_sql="select avg(trim(R.response)) as avg,C.company,CO.country_name from bmc_responses R join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) join bmc_companies C on (U.company=C.id) join bmc_countries CO on (U.company_location=CO.country_id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' and U.company='".$user['User']['company']."' and U.company_location='".$user['User']['company_location']."' group by Q.group_id order by Q.group_id";		
		$company_location_response=$this->Response->query($company_location_sql);
		
		$company_location_count_sql="select sum(CAST(trim(R.response) AS UNSIGNED)) as sum, P.id, Q.group_id from bmc_responses R left join bmc_questions Q on (Q.id=R.question_id) left join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) join bmc_companies C on (U.company=C.id) join bmc_countries CO on (U.company_location=CO.country_id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' and U.company='".$user['User']['company']."' and U.company_location='".$user['User']['company_location']."' group by Q.group_id,P.id";		
		$company_location_count_response=$this->Response->query($company_location_count_sql);
		foreach($company_location_count_response as $clpc)
		{
			if($clpc['0']['sum']<=10)
			{	
				if(!isset($clc_arr[$clpc['Q']['group_id']]['1']))
								$clc_arr[$clpc['Q']['group_id']]['1']=0;	
				$clc_arr[$clpc['Q']['group_id']]['1']+=1;
			}
			if($clpc['0']['sum']>10 && $clpc['0']['sum']<=20)
			{
				if(!isset($clc_arr[$clpc['Q']['group_id']]['2']))
								$clc_arr[$clpc['Q']['group_id']]['2']=0;	
				$clc_arr[$clpc['Q']['group_id']]['2']+=1;			
			}
			if($clpc['0']['sum']>20 && $clpc['0']['sum']<=30)
			{
				if(!isset($clc_arr[$clpc['Q']['group_id']]['3']))
								$clc_arr[$clpc['Q']['group_id']]['3']=0;	
				$clc_arr[$clpc['Q']['group_id']]['3']+=1;			
			}
			if($clpc['0']['sum']>30 && $clpc['0']['sum']<=40)
			{
				if(!isset($clc_arr[$clpc['Q']['group_id']]['4']))
								$clc_arr[$clpc['Q']['group_id']]['4']=0;	
				$clc_arr[$clpc['Q']['group_id']]['4']+=1;			
			}
			if($clpc['0']['sum']>40  && $clpc['0']['sum']<=50)
			{
				if(!isset($clc_arr[$clpc['Q']['group_id']]['5']))
								$clc_arr[$clpc['Q']['group_id']]['5']=0;	
				$clc_arr[$clpc['Q']['group_id']]['5']+=1;			
			}
		}
		
		
		$industry_sql="select avg(trim(R.response)) as avg,I.industry from bmc_responses R join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) join bmc_industries I on (U.industry_id=I.id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' and U.industry_id='".$user['User']['industry_id']."' group by Q.group_id order by Q.group_id";		
		$industry_response=$this->Response->query($industry_sql);
		
		$industry_count_sql="select sum(CAST(trim(R.response) AS UNSIGNED)) as sum, P.id, Q.group_id from bmc_responses R left join bmc_questions Q on (Q.id=R.question_id) left join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) join bmc_industries I on (U.industry_id=I.id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' and U.industry_id='".$user['User']['industry_id']."' group by Q.group_id,P.id";		
		$industry_count_response=$this->Response->query($industry_count_sql);	
		foreach($industry_count_response as $ipc)
		{
			if($ipc['0']['sum']<=10)
			{	
				if(!isset($ic_arr[$ipc['Q']['group_id']]['1']))
								$ic_arr[$ipc['Q']['group_id']]['1']=0;	
				$ic_arr[$ipc['Q']['group_id']]['1']+=1;
			}
			if($ipc['0']['sum']>10 && $ipc['0']['sum']<=20)
			{
				if(!isset($ic_arr[$ipc['Q']['group_id']]['2']))
								$ic_arr[$ipc['Q']['group_id']]['2']=0;	
				$ic_arr[$ipc['Q']['group_id']]['2']+=1;			
			}
			if($ipc['0']['sum']>20 && $ipc['0']['sum']<=30)
			{
				if(!isset($ic_arr[$ipc['Q']['group_id']]['3']))
								$ic_arr[$ipc['Q']['group_id']]['3']=0;	
				$ic_arr[$ipc['Q']['group_id']]['3']+=1;			
			}
			if($ipc['0']['sum']>30 && $ipc['0']['sum']<=40)
			{
				if(!isset($ic_arr[$ipc['Q']['group_id']]['4']))
								$ic_arr[$ipc['Q']['group_id']]['4']=0;	
				$ic_arr[$ipc['Q']['group_id']]['4']+=1;			
			}
			if($ipc['0']['sum']>40  && $ipc['0']['sum']<=50)
			{
				if(!isset($ic_arr[$ipc['Q']['group_id']]['5']))
								$ic_arr[$ipc['Q']['group_id']]['5']=0;	
				$ic_arr[$ipc['Q']['group_id']]['5']+=1;			
			}
		}
		
		
		$overall_sql="select avg(trim(R.response)) as avg from bmc_responses R join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) where P.status='1' and P.participant_status='1'  and Q.tool_id='1'  group by Q.group_id order by Q.group_id";		
		$overall_response=$this->Response->query($overall_sql);
		
		$overall_count_sql="select sum(CAST(trim(R.response) AS UNSIGNED)) as sum, P.id, Q.group_id from bmc_responses R left join bmc_questions Q on (Q.id=R.question_id) left join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) where P.status='1' and P.participant_status='1' and Q.tool_id='1' group by Q.group_id,P.id";		
		$overall_count_response=$this->Response->query($overall_count_sql);	
		foreach($overall_count_response as $opc)
		{
			if($opc['0']['sum']<=10)
			{	
				if(!isset($oc_arr[$opc['Q']['group_id']]['1']))
								$oc_arr[$opc['Q']['group_id']]['1']=0;	
				$oc_arr[$opc['Q']['group_id']]['1']+=1;
			}
			if($opc['0']['sum']>10 && $opc['0']['sum']<=20)
			{
				if(!isset($oc_arr[$opc['Q']['group_id']]['2']))
								$oc_arr[$opc['Q']['group_id']]['2']=0;	
				$oc_arr[$opc['Q']['group_id']]['2']+=1;			
			}
			if($opc['0']['sum']>20 && $opc['0']['sum']<=30)
			{
				if(!isset($oc_arr[$opc['Q']['group_id']]['3']))
								$oc_arr[$opc['Q']['group_id']]['3']=0;	
				$oc_arr[$opc['Q']['group_id']]['3']+=1;			
			}
			if($opc['0']['sum']>30 && $opc['0']['sum']<=40)
			{
				if(!isset($oc_arr[$opc['Q']['group_id']]['4']))
								$oc_arr[$opc['Q']['group_id']]['4']=0;	
				$oc_arr[$opc['Q']['group_id']]['4']+=1;			
			}
			if($opc['0']['sum']>40  && $opc['0']['sum']<=50)
			{
				if(!isset($oc_arr[$opc['Q']['group_id']]['5']))
								$oc_arr[$opc['Q']['group_id']]['5']=0;	
				$oc_arr[$opc['Q']['group_id']]['5']+=1;			
			}
		}
		
		
			
		$section_data=$question_data=array(); $i=0;
		foreach($responses as $resp)
		{
			$section_data[$resp['Q']['group_id']]['usertype'][$resp['P']['user_role_id']]['avg']=$resp[0]['avg'];			
			$section_data[$resp['Q']['group_id']]['usertype'][6]['avg']=$self_response[$resp['Q']['group_id']-1][0]['avg'];
			$section_data[$resp['Q']['group_id']]['group']['avg']=$group_response[$resp['Q']['group_id']-1][0]['avg'];	
			$section_data[$resp['Q']['group_id']]['group']['count_resp']=$gpc_arr[$resp['Q']['group_id']];	
			$section_data[$resp['Q']['group_id']]['company']['avg']=$company_response[$resp['Q']['group_id']-1][0]['avg'];
			$section_data[$resp['Q']['group_id']]['company']['name']=$company_response[$resp['Q']['group_id']-1]['C']['company'];
			$section_data[$resp['Q']['group_id']]['company']['count_resp']=$cpc_arr[$resp['Q']['group_id']];	
			$section_data[$resp['Q']['group_id']]['company_location']['avg']=$company_location_response[$resp['Q']['group_id']-1][0]['avg'];
			$section_data[$resp['Q']['group_id']]['company_location']['name']=$company_location_response[$resp['Q']['group_id']-1]['C']['company'].' '.$company_location_response[$resp['Q']['group_id']-1]['CO']['country_name'];
			$section_data[$resp['Q']['group_id']]['company_location']['count_resp']=$clc_arr[$resp['Q']['group_id']];				
			$section_data[$resp['Q']['group_id']]['industry']['avg']=$industry_response[$resp['Q']['group_id']-1][0]['avg'];
			$section_data[$resp['Q']['group_id']]['industry']['name']=$industry_response[$resp['Q']['group_id']-1]['I']['industry'];
			$section_data[$resp['Q']['group_id']]['industry']['count_resp']=$ic_arr[$resp['Q']['group_id']];
			$section_data[$resp['Q']['group_id']]['overall']['avg']=$overall_response[$resp['Q']['group_id']-1][0]['avg'];
			$section_data[$resp['Q']['group_id']]['overall']['count_resp']=$oc_arr[$resp['Q']['group_id']];			
		}		
		
		////////////####### Question Query #########//////////////
		
		$question_avg_sql="select avg(trim(R.response)) as avg,Q.question_key,Q.group_id,P.user_role_id from bmc_responses R join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' group by Q.question_key,P.user_role_id order by Q.question_key,P.user_role_id";
		$question_avg_response=$this->Response->query($question_avg_sql);
		
		
		$question_sql="select distinct P.id,Q.question_key,Q.question,Q.group_id,P.user_role_id,R.response,COUNT(R.response) as count from bmc_responses R  join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' group by P.user_role_id,Q.question_key,R.response,Q.group_id order by Q.question_key,P.user_role_id,R.response";		
		$question_response=$this->Response->query($question_sql);
		
		
		$question_overall_avg_sql="select avg(trim(R.response)) as avg,Q.question_key,Q.group_id from bmc_responses R join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' group by Q.question_key order by Q.question_key";
		$question_overall_avg_response=$this->Response->query($question_overall_avg_sql);
		
		
		$question_overall_sql="select Q.question_key,Q.question,Q.group_id,R.response,COUNT(R.response) as count from bmc_responses R  join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' group by Q.question_key,R.response,Q.group_id order by Q.question_key,R.response";		
		$question_overall_response=$this->Response->query($question_overall_sql);
		
		
		$question_self_sql="select R.response as avg,R.comments from bmc_responses R join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and P.id='".$pr_id."' and Q.tool_id='1'";
		$question_self_response=$this->Response->query($question_self_sql);	
		$all_qs=$this->Question->find('all',array('conditions'=>array('Question.language_id'=>$language_id,'role_id'=>$role_id)));	
	
		foreach($question_avg_response as $ques)
		{			
			$question_data[$ques['Q']['group_id']][$ques['Q']['question_key']]['usertype'][$ques['P']['user_role_id']]['avg']=$ques[0]['avg'];
			$question_data[$ques['Q']['group_id']][$ques['Q']['question_key']]['usertype'][6]['avg']=$question_self_response[$ques['Q']['question_key']-1]['R']['avg'];
			$question_data[$ques['Q']['group_id']][$ques['Q']['question_key']]['usertype'][6]['count'][$question_self_response[$ques['Q']['question_key']-1]['R']['avg']]=1;	
			$question_data[$ques['Q']['group_id']][$ques['Q']['question_key']]['usertype'][7]['avg']=$question_overall_avg_response[$ques['Q']['question_key']-1][0]['avg'];
									
		}	
		
		foreach($question_response as $ques)
		{
			if($ques['P']['user_role_id']==$role_id)
			{	$question_data[$ques['Q']['group_id']][$ques['Q']['question_key']]['question']=$all_qs[$ques['Q']['question_key']-1]['Question']['question'];
				$question_data[$ques['Q']['group_id']][$ques['Q']['question_key']]['comments']=$question_self_response[$ques['Q']['question_key']-1]['R']['comments'];
			}					
			$question_data[$ques['Q']['group_id']][$ques['Q']['question_key']]['usertype'][$ques['P']['user_role_id']]['count'][$ques['R']['response']]=$ques[0]['count'];	
								
		}	
		
		foreach($question_overall_response as $qor)
		{
			$question_data[$qor['Q']['group_id']][$qor['Q']['question_key']]['usertype'][7]['count'][$qor['R']['response']]=$qor[0]['count'];		
		}
		
		//pr($question_data); die;
		$this->set('question_data',$question_data);
		$this->set('section_data',$section_data);		
		$this->set('user',$user);
		$this->set('role_id',$role_id);
		return;
	}	
	
	public function getTrainerReport($role_id=3,$course_id,$company='',$company_location='',$industry='',$role='',$country='',$language_id,$year)
	{				
		if(!empty($company))
			$company=" and U.company='".$company."'";
		if(!empty($industry))
			$industry=" and U.industry_id='".$industry."'";
		if(!empty($role))
			$role=" and P.user_role_id='".$role."'";	
		if(!empty($country))
			$country=" and U.country_id='".$country."'";
		if(!empty($company_location))
			$company_location=" and U.company_location='".$company_location."'";	
		if(!empty($year))
			$year=" and R.year='".$year."'";		
					
		//////////####### Section Query #########//////////////
		$section_sql="select avg(trim(R.response)) as avg,P.user_role_id,P.user_role_id,Q.question_key,Q.group_id,Q.question,C.company,C.id from bmc_responses R join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) join bmc_companies C on (U.company=C.id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' ".$company.$industry.$role.$country.$company_location.$year." group by P.user_role_id,Q.group_id order by Q.group_id,P.user_role_id";	
		
		$responses=$this->Response->query($section_sql);
		
		
		if(!empty($responses))
		{	
		
		$dropdown_sql="select C.id,C.company,I.id,I.industry,CO.country_id,CO.country_name from bmc_participant P inner join bmc_users U ON (P.user_id=U.id) inner join bmc_companies C ON (U.company=C.id) inner join bmc_industries I ON (U.industry_id=I.id) inner join bmc_countries CO ON (CO.country_id=U.country_id OR CO.country_id=U.company_location) where P.course_id='".$course_id."'";
		$dropdowns=$this->Response->query($dropdown_sql);
		//pr($dropdowns); die;
		$added_company=$added_industry=$added_countries=$added_cy=$added_ind=$added_co=array(); $i=0; $l=0;
		foreach($dropdowns as $dp)
		{
			if(!in_array($dp['C']['id'],$added_cy))
			{
				$added_company[$l]['id']=$dp['C']['id'];
				$added_company[$l]['name']=$dp['C']['company'];
				$added_cy[]	=$dp['C']['id'];
			}
			if(!in_array($dp['I']['id'],$added_ind))
			{
				$added_industry[$l]['id']=$dp['I']['id'];
				$added_industry[$l]['name']=$dp['I']['industry'];	
				$added_ind[]=$dp['I']['id'];
			}	
			if(!in_array($dp['CO']['country_id'],$added_co))
			{
				$added_countries[$l]['id']=$dp['CO']['country_id'];
				$added_countries[$l]['name']=$dp['CO']['country_name'];	
				$added_co[]=$dp['CO']['country_id'];
			}	
			$l++;
		}
		
		
			
		$section_data=$question_data=array(); $i=0; $l=0;
		foreach($responses as $resp)
		{
			/*if(!in_array($resp['C']['id'],$added_cy))
			{
				$added_company[$l]['id']=$resp['C']['id'];
				$added_company[$l]['name']=$resp['C']['company'];
				$added_cy[]=$resp['C']['id'];
				$l++;
			}*/
			$section_data[$resp['Q']['group_id']]['usertype'][$resp['P']['user_role_id']]['avg']=$resp[0]['avg'];				
		}
			
		//////////####### Question Query #########//////////////
		
		$question_avg_sql="select avg(trim(R.response)) as avg,Q.question_key,Q.group_id,P.user_role_id from bmc_responses R join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' ".$company.$industry.$role.$country.$company_location.$year." group by Q.question_key,P.user_role_id order by Q.question_key,P.user_role_id";
		$question_avg_response=$this->Response->query($question_avg_sql);
		
		
		$question_sql="select Q.question_key,Q.question,Q.group_id,P.user_role_id,R.response,count(R.response) as count from bmc_responses R right join bmc_questions Q on (Q.id=R.question_id) join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) where P.status='1' and P.participant_status='1' and P.course_id='".$course_id."' and Q.tool_id='1' ".$company.$industry.$role.$country.$company_location.$year." group by P.user_role_id,Q.question_key,R.response,Q.group_id order by Q.question_key,P.user_role_id,R.response";
		$question_response=$this->Response->query($question_sql);
		
		foreach($question_avg_response as $ques)
		{			
			$question_data[$ques['Q']['group_id']][$ques['Q']['question_key']]['usertype'][$ques['P']['user_role_id']]['avg']=$ques[0]['avg'];			
		}	
		$all_qs=$this->Question->find('all',array('conditions'=>array('Question.language_id'=>$language_id,'role_id'=>$role_id)));		
		foreach($question_response as $ques)
		{
			$question_data[$ques['Q']['group_id']][$ques['Q']['question_key']]['question']=$all_qs[$ques['Q']['question_key']-1]['Question']['question'];					
			$question_data[$ques['Q']['group_id']][$ques['Q']['question_key']]['usertype'][$ques['P']['user_role_id']]['count'][$ques['R']['response']]=$ques[0]['count'];						
		}
		//echo '<pre>';print_r($question_data); die;	
				
		$section_chart="['Section','Project Manager','Team Member','Manager of Project Managers'],";
		$count=count($section_data);
		$y=$z=1;
		$section_chart_pdf=array();
		$section_chart_pdf[3]=$section_chart_pdf[4]=$section_chart_pdf[5]='';
		foreach($section_data as $secti)
		{
			if($z==1) $sect_name='Planning'; else if($z==2) $sect_name='Organizing & Staffing'; else if($z==3) $sect_name='Directing & Leading'; else if($z==4) $sect_name='Controlling'; else if($z==5) $sect_name='Reporting'; else if($z==6) $sect_name='Risk Management';    
			if($z<$count)
				$comma=',';
			else 
				$comma='';	
			
			for($l=3;$l<6;$l++)
			{
				if(!isset($secti['usertype'][$l]['avg'])) $secti['usertype'][$l]['avg']=0;				
				$section_chart_pdf[$l].=$secti['usertype'][$l]['avg'].$comma;					
			}
			$section_chart.="['".$sect_name."',".$secti['usertype'][3]['avg'].",".$secti['usertype'][4]['avg'].",".$secti['usertype'][5]['avg']."]".$comma;
			$z++;	
		}
		
		$section_chart_link='http://chart.googleapis.com/chart?chxl=0:|Planning|Organizing-Staffing|Directing-Leading|Controlling|Reporting|Risk-Management|1:|0|1|2|3|4|5&chxp=0,1,2,3,4,5,6|1,0,1,2,3,4,5&chxr=0,0,7|1,0,6&chxs=0,676767,10.5,0,lt,676767&chxtc=0,5|1,5&chxt=x,y&chs=700x400&cht=lxy&chco=0000FF,FF0000,FF9900&chds=0,7,0,6,0,7,0,6,0,7,0,7&chd=t:1,2,3,4,5,6|'.$section_chart_pdf[3].'|1,2,3,4,5,6|'.$section_chart_pdf[4].'|1,2,3,4,5,6|'.$section_chart_pdf[5].'&chdl=Project-Manager|Team-member|Manager-of-Project-Managers&chdlp=t&chg=0,17&chls=2|2|2&chma=5,5,5,25&chtt=Overall&chts=000000,17.5';		
		
		//echo $section_chart_link; die;
		$question_chart_pdf=$question_chart_link=$question_chart_text=array();
		
		foreach($question_data as $questi)
		{		
			if($y==1) $chart_title='Planning'; else if($y==2)  $chart_title='Organizing-Staffing'; else if($y==3)  $chart_title='Directing-Leading'; else if($y==4)  $chart_title='Controlling'; if($y==5)  $chart_title='Reporting'; if($y==6)  $chart_title='Risk-Management'; 
			$question_chart_pdf[$y][3]=$question_chart_pdf[$y][4]=$question_chart_pdf[$y][5]='';	
			$question_chart[$y]='';
			$question_chart[$y].="['Section','Project Manager','Team Member','Manager of Project Managers'],";
			$p=1;
			$question_chart_text[$y]='<br><br><br><br><div>';
			foreach($questi as $qkey)
			{	
				$question_chart_text[$y].='Q'.$p.' - '.$qkey['question'].'<br>';
				if($p<10)
					$comma=',';
				else
					$comma='';	
				
				for($l=3;$l<6;$l++)
				{
					if(!isset($qkey['usertype'][$l]['avg'])) $qkey['usertype'][$l]['avg']=0;				
					$question_chart_pdf[$y][$l].=$qkey['usertype'][$l]['avg'].$comma;					
				}
				$question_chart[$y].="['".str_replace('\'','',$qkey['question'])."',".$qkey['usertype'][3]['avg'].",".$qkey['usertype'][4]['avg'].",".$qkey['usertype'][5]['avg']."]".$comma;
				$p++;
			}
			$question_chart_text[$y].='</div>';
			$question_chart_link[$y]='http://chart.googleapis.com/chart?chxl=0:|Q1|Q2|Q3|Q4|Q5|Q6|Q7|Q8|Q9|Q10|1:|0|1|2|3|4|5&chxp=0,1,2,3,4,5,6,7,8,9,10|1,0,1,2,3,4,5&chxr=0,0,11|1,0,6&chxs=0,676767,10.5,0,lt,676767&chxtc=0,5|1,5&chxt=x,y&chs=700x400&cht=lxy&chco=0000FF,FF0000,FF9900&chds=0,11,0,6,0,11,0,6,0,11,0,11&chd=t:1,2,3,4,5,6,7,8,9,10|'.$question_chart_pdf[$y][3].'|1,2,3,4,5,6,7,8,9,10|'.$question_chart_pdf[$y][4].'|1,2,3,4,5,6,7,8,9,10|'.$question_chart_pdf[$y][5].'&chdl=Project-Manager|Team-member|Manager-of-Project-Managers&chdlp=t&chg=0,17&chls=2|2|1&chma=5,5,5,25&chtt='.$chart_title.'&chts=000000,17.5';
			$y++;		
		}	
		//pr($added_company); die;	
		$this->set('added_company',$added_company);
		$this->set('added_industry',$added_industry);
		$this->set('added_countries',$added_countries);
		$this->set('question_data',$question_data);
		$this->set('section_data',$section_data);	
		$this->set('section_chart',$section_chart);	
		$this->set('section_chart_link',$section_chart_link);
		$this->set('question_chart_link',$question_chart_link);
		$this->set('question_chart_text',$question_chart_text);
		$this->set('question_chart',$question_chart);
		
		}else{
			$this->set('is_not_available','1');		
		}
		return;	
	}	
	
	
	public function project_management_trainer_report($course_id,$is_pdf=0,$company='',$industry='',$role='',$country='',$company_location='',$year='')
	{
		$course=$this->Course->findByCourseId($course_id);		
		$benchmark=$this->BenchmarkCourse->find('first',array('conditions'=>array('BenchmarkCourse.course_id'=>$course['Course']['id'])));
		if(!empty($benchmark))
		{
			$bench_data=array();
			$year_sql="";
			if(!empty($year))
			{
				$year_sql=" and year='".$year."'";	
			}
			$bench_group_sql="select sum(num_a) as num_5, sum(num_b) as num_4,sum(num_c) as num_3,sum(num_d) as num_2,sum(num_e) as num_1 from bmc_benchmark_data where role_id='".$benchmark['BenchmarkCourse']['role_id']."' ".$year_sql." group by group_id";
			$bench_data['group']=$this->BenchmarkData->query($bench_group_sql);
			
			$bench_company_sql="select sum(num_a) as num_5, sum(num_b) as num_4,sum(num_c) as num_3,sum(num_d) as num_2,sum(num_e) as num_1 from bmc_benchmark_data where company_id='".$benchmark['BenchmarkCourse']['company_id']."' ".$year_sql."  group by group_id";
			$bench_data['company']=$this->BenchmarkData->query($bench_company_sql);
			
			$bench_industry_sql="select sum(num_a) as num_5, sum(num_b) as num_4,sum(num_c) as num_3,sum(num_d) as num_2,sum(num_e) as num_1 from bmc_benchmark_data where industry_id='".$benchmark['BenchmarkCourse']['industry_id']."' ".$year_sql."  group by group_id";
			$bench_data['industry']=$this->BenchmarkData->query($bench_industry_sql);
			
			$all_bench=array(); $r=0;
			foreach($bench_data as $ab)
			{				
				for($s=0;$s<6;$s++)
				{
					if(($ab[$s][0]['num_5']+$ab[$s][0]['num_4']+$ab[$s][0]['num_3']+$ab[$s][0]['num_2']+$ab[$s][0]['num_1'])>0)
						$calc=(($ab[$s][0]['num_5']*5)+($ab[$s][0]['num_4']*4)+($ab[$s][0]['num_3']*3)+($ab[$s][0]['num_2']*2)+($ab[$s][0]['num_1']))/($ab[$s][0]['num_5']+$ab[$s][0]['num_4']+$ab[$s][0]['num_3']+$ab[$s][0]['num_2']+$ab[$s][0]['num_1']);	
					else
						$calc=(($ab[$s][0]['num_5']*5)+($ab[$s][0]['num_4']*4)+($ab[$s][0]['num_3']*3)+($ab[$s][0]['num_2']*2)+($ab[$s][0]['num_1']));	
					$all_bench[$r][$s]['val']=$ab[$s][0];
					$all_bench[$r][$s]['avg']=$calc;						
				}
				$r++;					
			}
			if($benchmark['BenchmarkCourse']['role_id']=='3') $b_role='Project Manager';
			else if($benchmark['BenchmarkCourse']['role_id']=='4') $b_role='Team Member';
			else if($benchmark['BenchmarkCourse']['role_id']=='5') $b_role='Manager of Project Managers';
			
			$this->set('benchmark_role',$b_role);
			$this->set('benchmark_company',$this->Company->findById($benchmark['BenchmarkCourse']['company_id']));
			$this->set('benchmark_industry',$this->Industry->findById($benchmark['BenchmarkCourse']['industry_id']));
			$this->set('bench_data',$all_bench);
		}
			
		$pdf_link='';
		if(!empty($course))
		{
			$this->set('intro_text',$this->requestAction('/cms/get_cms_content/intro_trainer_report/'.$this->Session->read('Config.language_id')));
			if($is_pdf==0)
				$this->layout='default';
			else
				$this->layout='report_pdf';	
			
			if($is_pdf!=0)
			{
				$company=$this->request->query['company'];	
				$industry=$this->request->query['industry'];
				$country=$this->request->query['country'];
				$role=$this->request->query['role'];
				$year=$this->request->query['year'];
				$company_location=$this->request->query['company_location'];
					
			}else if(!empty($this->data))
			{			
				if(isset($this->data['company']))
					$company=$this->data['company'];	
				if(isset($this->data['industry']))
					$industry=$this->data['industry'];
				if(isset($this->data['country']))
					$country=$this->data['country'];
				if(isset($this->data['role']))
					$role=$this->data['role'];
				if(isset($this->data['company_location']))
					$company_location=$this->data['company_location'];
				if(isset($this->data['year']))
					$year=$this->data['year'];		
			}
				
			$pdf_link='?company='.$company.'&industry='.$industry.'&role='.$role.'&country='.$country.'&company_location='.$company_location.'&year='.$year;						
			$language_id=$this->Session->read('Config.language_id');
			$this->getTrainerReport(3,$course_id,$company,$company_location,$industry,$role,$country,$language_id,$year);		
			
			
			$this->Trainer->bindModel(array('belongsTo' => array('User' => array('className' => 'User','foreignKey' => 'user_id'))),false);
			$trainer=$this->Trainer->findById($course['Course']['trainer_id']);
			
			$this->Company->primaryKey='company';
			$this->Coursecompany->bindModel(array('belongsTo' => array('Company' => array('className' => 'Company','foreignKey' => 'company'))),false);
			$companies=$this->Coursecompany->find('all',array('conditions'=>array('Coursecompany.course_id'=>$course['Course']['id']),'order'=>array('Coursecompany.company ASC')));
			$industries=$this->Industry->find('all',array('order'=>array('Industry.industry ASC')));
			$countries=$this->Country->find('all',array('order'=>array('Country.country_name ASC')));
			
			if(!empty($company))
				$this->set('fi_company',$this->Company->findById($company));			
			if(!empty($company_location))
				$this->set('fi_company_location',$this->Country->findByCountryId($company_location));
			if(!empty($industry))
				$this->set('fi_industry',$this->Industry->findById($industry));
			if(!empty($role))
			{
				if($role=='3') $role='Project Manager';
				if($role=='4') $role='Team Member';
				if($role=='5') $role='Manager of Project Manager';
				$this->set('fi_role',$role);
			}
			if(!empty($country))
				$this->set('fi_country',$this->Country->findByCountryId($country));
			if(!empty($year))
				$this->set('fi_year',$year);	
			
			$start_yr=2010;
			$cur_yr=date('Y');
			$allyears=array();
			for($i=$cur_yr;$i>=$start_yr;$i--)
			{
				$allyears[]=$i;	
			}
			$this->set('allyears',$allyears);
			
			$this->set('countries',$countries);
			$this->set('industries',$industries);
			$this->set('pdf_link',$pdf_link);
			$this->set('companies',$companies);
			$this->set('course',$course);
			$this->set('user',$trainer);
			if($is_pdf==0)
				$this->render('project_management_trainer_report');
			else	
				$this->render('project_management_trainer_report_pdf');	
		}else{
			$this->redirect('/');	
		}
	}
	
	public function project_management_report_redirect($pr_id)
	{
		$this->layout='default';
		$this->set('pr_id',$pr_id);
		$this->render('project_management_report_redirect');	
	}
	
	public function action_plan($pr_id,$is_pdf=0)
	{
		$language_id=$this->Session->read('Config.language_id');
		$this->Course->primaryKey='course_id';
		$this->Participant->recursive=2;
		$this->User->bindModel(array('belongsTo' => array('Company' => array('className' => 'Company','foreignKey' => 'company'))),false);
		$this->Participant->bindModel(array('belongsTo' => array('Course' => array('className' => 'Course','foreignKey' => 'course_id'),'User' => array('className' => 'User','foreignKey' => 'user_id'))),false);
		$participant=$this->Participant->find('first',array('conditions'=>array('Participant.id'=>$pr_id,'Participant.participant_status'=>'1')));		
		if(!empty($participant))
		{
			$questions=$this->APquestion->find('all',array('conditions'=>array('APquestion.language_id'=>$language_id)));
			$this->set('pr_id',$pr_id);
			$this->set('participant',$participant);
			$this->set('questions',$questions);		
			$this->set('intro_text',$this->requestAction('/cms/get_cms_content/action_plan_intro/'.$language_id));
			if($is_pdf==1)
			{
				$this->layout='report_pdf';
				$this->render('action_plan_pdf');	
			}else{
				$this->render('action_plan');
			}
		}else{
			$this->redirect('/');
		}
	}
	
	public function save_action_plan()
	{
		$data=array(); $i=0; $date=date("Y-m-d H:i:s");
		foreach($this->data['APresponse'] as $ind=>$resp)
		{
			foreach($resp as $index=>$ans)
			{
				$data[$i]['participant_id']=$this->data['participant_id'];
				$data[$i]['group_id']=$ind;
				$data[$i]['question_key']=$index;
				$data[$i]['response']=serialize($ans);
				$data[$i]['created']=$date;
				$i++;			
			}	
		}		
		$this->APresponse->create();
		$this->APresponse->saveAll($data);
		$this->Participant->id=$this->data['participant_id'];
		$this->Participant->saveField('action_plan_status','1');			
		$this->redirect(array('action'=>'view_action_plan',$this->data['participant_id']));
	}
	
	public function view_action_plan($pr_id,$is_pdf=0)
	{
		$language_id=$this->Session->read('Config.language_id');
		$data=$this->APresponse->find('all',array('conditions'=>array('APresponse.participant_id'=>$pr_id)));
		$this->Course->primaryKey='course_id';
		$this->Participant->recursive=2;
		$this->User->bindModel(array('belongsTo' => array('Company' => array('className' => 'Company','foreignKey' => 'company'))),false);
		$this->Participant->bindModel(array('belongsTo' => array('Course' => array('className' => 'Course','foreignKey' => 'course_id'),'User' => array('className' => 'User','foreignKey' => 'user_id'))),false);
		$participant=$this->Participant->find('first',array('conditions'=>array('Participant.id'=>$pr_id,'Participant.participant_status'=>'1')));		
		if(!empty($data))
		{
			$this->set('intro_text',$this->requestAction('/cms/get_cms_content/action_plan_intro/'.$this->Session->read('Config.language_id')));
			$questions=$this->APquestion->find('all',array('conditions'=>array('APquestion.language_id'=>$language_id)));
			$response=array();
			foreach($data as $resp)
			{
				$response[$resp['APresponse']['group_id']][$resp['APresponse']['question_key']]=unserialize($resp['APresponse']['response']);
			}			
			$this->set('pr_id',$pr_id);
			$this->set('questions',$questions);
			$this->set('participant',$participant);
			$this->set('response',$response);
			if($is_pdf==1)
			{
				$this->layout='report_pdf';
				$this->render('view_action_plan_pdf');	
			}else{
				$this->render('view_action_plan');
			}
		}else{
			$this->redirect('/reports/action_plan/'.$pr_id);	
		}
	}
	
	
	public function cleanquery()
	{
		$data=$this->Response->find('all',array('conditions'=>array('Response.participant_id IN'=>array('41','33','34','30'))));
		$already=$del_ids=array();
		foreach($data as $dat)
		{
			if(in_array(($dat['Response']['participant_id'].'_'.$dat['Response']['question_id']),$already))
			{
				$del_ids[]=$dat['Response']['id'];		
			}else{
				$already[]=	$dat['Response']['participant_id'].'_'.$dat['Response']['question_id'];
			}
		}
		//pr($del_ids); die;
		foreach($del_ids as $del)
		{
			$this->Response->delete($del);	
		}	
		die;
	}
	
	
}