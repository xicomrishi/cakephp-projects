<?php

App::import('Vendor',array('functions'));
App::uses('AppController', 'Controller');

class BenchmarkController extends AppController {

	public $components = array('Session','Access');
	public $uses=array('BenchmarkData','Language','Company','Industry','Country','Coursecompany','BenchmarkCourse','Participant','Course','BenchmarkComp','Response','User');

	public function beforeFilter(){
		$this->layout='default';			
	}
	
	public function admin_index($type=0)
	{
		$this->Access->checkAdminSession();	
		
		$this->BenchmarkComp->bindModel(array('belongsTo'=>array('Company'=>array('className'=>'Company','foreignKey'=>'company_id','order'=>array('Company.company ASC')))));
		$data=$this->BenchmarkComp->find('all');
		if($type==1)
		{
			$this->set('data_exist','1');	
		}
		$this->set('data',$data);		
	}
	
	public function admin_overall_data()
	{
		$this->Access->checkAdminSession();
		$arr=array('role'=>0,'country'=>0,'industry'=>0,'year'=>0);
		if(!empty($this->request->query)){
			$q=$this->request->query;
			if(isset($q['role']) && isset($q['country']) && isset($q['industry']) && isset($q['year'])){
				$arr=array('role'=>$q['role'],'country'=>$q['country'],'industry'=>$q['industry'],'year'=>$q['year']);	
				$this->set('custom',$arr);
			}		
		}
		$this->getOverallBenchmarkData($arr);
		$this->render('overall_data_index');	
	}
	
	public function getOverallBenchmarkData($arr,$is_ajax=0)
	{
		$conditions=array();
		$company_sql=$role_sql=$country_sql=$year_sql=$industry_sql='';
		
		if(isset($arr['company_id']))
			{
			if($arr['company_id']!=0){ 
				$conditions=array('BenchmarkData.company_id'=>$arr['company_id']);
				$company_sql=" and C.id='".$arr['company_id']."' ";			
			}
		}
		if($arr['role']!=0){ 
			$conditions=array('BenchmarkData.role_id'=>$arr['role']);
			$role_sql=" and P.user_role_id='".$arr['role']."' ";			
		}
		if($arr['country']!=0){
			$conditions['BenchmarkData.country_id']=$arr['country'];
			$country_sql=" and U.company_location='".$arr['country']."' ";
		}
		if($arr['industry']!=0){
			$conditions['BenchmarkData.industry_id']=$arr['industry'];
			$industry_sql=" and U.industry_id='".$arr['industry']."' ";
		}
		if($arr['year']!=0){
			$conditions['BenchmarkData.year']=$arr['year'];	
			$year_sql=" and R.year='".$arr['year']."' ";	
		}
		
		$avail_country_sql="select C.country_id,C.country_name from bmc_users U left join bmc_countries C ON (U.country_id=C.country_id) left join bmc_benchmark_data BD ON (BD.country_id=C.country_id) group by C.country_id order by C.country_name";
		$avail_country=$this->User->query($avail_country_sql);
		
		$avail_industry_sql="select I.id,I.industry from bmc_users U left join bmc_industries I ON (U.industry_id=I.id) left join bmc_benchmark_data BD ON (BD.industry_id=I.id) group by I.id order by I.industry";
		$avail_industry=$this->User->query($avail_industry_sql);
		
		$avail_year=array();
		$start_yr=date('Y');
		for($i=$start_yr;$i>=2005;--$i){
			$avail_year[]=$i;	
		}
		
		$this->set('avail_country',$avail_country);
		$this->set('avail_industry',$avail_industry);
		$this->set('avail_year',$avail_year);		
				
		$bdata=$this->BenchmarkData->find('all',array('conditions'=>$conditions));	
		
		$result=array();		
		if(!empty($bdata)){
			foreach($bdata as $dat){
				$dat['BenchmarkData']['group_id']=$dat['BenchmarkData']['group_id']-1;
				
				if(!isset($result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_a']))
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_a']=0;
				if(!isset($result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_b']))
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_b']=0;
				if(!isset($result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_c']))
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_c']=0;
				if(!isset($result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_d']))
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_d']=0;
				if(!isset($result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_e']))
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_e']=0;				
				
				
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_a']+=$dat['BenchmarkData']['num_a'];
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_b']+=$dat['BenchmarkData']['num_b'];
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_c']+=$dat['BenchmarkData']['num_c'];
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_d']+=$dat['BenchmarkData']['num_d'];
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_e']+=$dat['BenchmarkData']['num_e'];	
			}
		}
		
		$bdata=$result;		
		
		$system_count_sql="select sum(CAST(trim(R.response) AS UNSIGNED)) as sum, P.id, Q.group_id from bmc_responses R inner join bmc_questions Q on (Q.id=R.question_id) inner join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) join bmc_companies C on (U.company=C.id) where P.status='1' and P.participant_status='1' and Q.tool_id='1' ".$company_sql.$role_sql.$industry_sql.$year_sql.$country_sql." group by Q.group_id,P.id";	

		$system_count_response=$this->Response->query($system_count_sql);
		
		$cpc_arr=array();
		foreach($system_count_response as $cpc)
		{
			if($cpc['0']['sum']<=10)
			{	
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['5']))
								$cpc_arr[$cpc['Q']['group_id']]['5']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['5']+=1;
			}
			if($cpc['0']['sum']>10 && $cpc['0']['sum']<=20)
			{
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['4']))
								$cpc_arr[$cpc['Q']['group_id']]['4']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['4']+=1;			
			}
			if($cpc['0']['sum']>20 && $cpc['0']['sum']<=30)
			{
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['3']))
								$cpc_arr[$cpc['Q']['group_id']]['3']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['3']+=1;			
			}
			if($cpc['0']['sum']>30 && $cpc['0']['sum']<=40)
			{
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['2']))
								$cpc_arr[$cpc['Q']['group_id']]['2']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['2']+=1;			
			}
			if($cpc['0']['sum']>40  && $cpc['0']['sum']<=50)
			{
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['1']))
								$cpc_arr[$cpc['Q']['group_id']]['1']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['1']+=1;			
			}
		}
		
		$sysdata=$cpc_arr;
		
		$all=array();
		if(!empty($bdata) || !empty($sysdata))
		{		
			for($i=1;$i<7;$i++)
			{
				for($j=1;$j<6;$j++)
				{
					if(!isset($sysdata[$i][$j])) $sysdata[$i][$j]=0;	
						
					if($j==1)	$str='num_a';
					if($j==2)	$str='num_b';
					if($j==3)	$str='num_c';
					if($j==4)	$str='num_d';
					if($j==5)	$str='num_e';
					if(!isset($bdata[$i-1]['BenchmarkData'][$str])) $bdata[$i-1]['BenchmarkData'][$str]=0;
							
					$all[$i][$j]=$sysdata[$i][$j]+intval($bdata[$i-1]['BenchmarkData'][$str]);	
				}	
			}
		}		
		
		if(!empty($all))
			{
				$section_chart="['Section','A: Very Proficient','B: Proficient','C: Moderately Proficient','D: Low Proficiency','E: Lack of proficiency'],";
				for($i=1;$i<7;$i++)
				{
					if($i==1) $sect='Planning'; if($i==2) $sect='Organizing & Staffing'; if($i==3) $sect='Directing & Leading';	if($i==4) $sect='Controlling'; if($i==5) $sect='Reporting'; if($i==6) $sect='Risk Management';					
					$j=0;
					$comma=",";
					if($i==6)
						$comma="";
					
					$section_chart.="['".$sect."',".intval($all[$i][1]).",".intval($all[$i][2]).",".intval($all[$i][3]).",".intval($all[$i][4]).",".intval($all[$i][5])."]".$comma;
				}
				$this->set('section_chart',$section_chart);
			}
			
			$avg=array();
			if(!empty($all))
			{
				$avgChart="['Section','Project Manager','Team Member','Manager of Project Managers'],";
				for($l=1;$l<7;$l++)
				{
					if($l==1) $point='Planning'; if($l==2) $point='Organizing & Staffing'; if($l==3) $point='Directing & Leading';	if($l==4) $point='Controlling'; if($l==5) $point='Reporting'; if($l==6) $point='Risk Management';	
					
					for($k=3;$k<6;$k++)
					{
						if(isset($all[$k][$l]) && !empty($all[$k][$l]))
						{
							$avg[$l][$k]=round((($all[$k][$l][1]+$all[$k][$l][2]+$all[$k][$l][3]+$all[$k][$l][4]+$all[$k][$l][5])/5),2);
								
						}else{
							$avg[$l][$k]=0;	
						}
					}
					$comma=",";
						if($l==6)
							$comma="";		
					$avgChart.="['".$point."',".$avg[$l][3].",".$avg[$l][4].",".$avg[$l][5]."]".$comma;
				}						
				$this->set('avgChart',$avgChart);
			}
		//pr($all); die;	
		$this->set('data',$all);
		return;			
			
	}
	
	
	public function get_company_specific_data()    // Showed under Company tab in admin
	{
		$this->layout='ajax';
		$this->request->data['company_id']=$this->data['company_id'];	
		$this->request->data['role']=0;	
		$this->request->data['industry']=0;	
		$this->request->data['country']=0;	
		$this->request->data['year']=0;	
		
		$this->getOverallBenchmarkData($this->request->data);
		$company=$this->Company->findById($this->data['company_id']);
		$this->set('company_id',$this->data['company_id']);
		$this->set('company',$company);
		$this->render('companies_graphs_view');
	}
	
	public function show_section_data()
	{
		$this->layout='ajax';
		$num=$this->data['num'];
		if($num=='1')					//Admin Data
		{
			$this->BenchmarkComp->bindModel(array('belongsTo'=>array('Company'=>array('className'=>'Company','foreignKey'=>'company_id','order'=>array('Company.company ASC')))));
			$data=$this->BenchmarkComp->find('all');
			
		}else if($num=='2')				//System Generated Data
		{
			$sql="select distinct Company.company,Company.id,C.country_id from bmc_responses R inner join bmc_participant P ON (R.participant_id=P.id) inner join bmc_users U ON (P.user_id=U.id) inner join bmc_companies Company ON (U.company=Company.id) inner join bmc_countries C ON (U.company_location=C.country_id) group by Company.id order by Company.company";
			$data=$this->Response->query($sql);
			
		}else{							//Aggregate Data
			
			$bsql="select distinct Company.company,Company.id from bmc_benchmark_data BD inner join bmc_companies Company ON (BD.company_id=Company.id) inner join bmc_industries I ON (BD.industry_id=I.id) group by BD.company_id order by Company.company";
			$bdata=$this->BenchmarkData->query($bsql);
								
			$allcomp=$allind=$allcont=$allrole=$data=array();
								
			$sql="select distinct Company.company,Company.id from bmc_responses R inner join bmc_participant P ON (R.participant_id=P.id) inner join bmc_users U ON (P.user_id=U.id) inner join bmc_companies Company ON (U.company=Company.id) inner join bmc_industries I ON (U.industry_id=I.id) inner join bmc_countries C ON (U.company_location=C.country_id) group by Company.id order by Company.company";
			$sysComp=$this->Response->query($sql);			
			
			$mergeArr=array_merge($bdata,$sysComp);
			foreach($mergeArr as $scom)
			{
				if(!in_array($scom['Company']['id'],$allcomp))
				{				
					$data[]=$scom;	
					$allcomp[]=	$scom['Company']['id'];						
				}	
			}		
		}	
		$this->set('num',$num);
		$this->set('data',$data);
		$this->render('show_section_data');
	}
	
	
	public function aggregateCompany_data()
	{
		$this->layout='ajax';
		$comp_id=$this->data['cid'];
		$sql="select Company.company,Company.id,I.id,I.industry,C.country_id,C.country_name,P.user_role_id,R.year from bmc_responses R inner join bmc_participant P ON (R.participant_id=P.id) inner join bmc_users U ON (P.user_id=U.id) inner join bmc_companies Company ON (U.company=Company.id) inner join bmc_industries I ON (U.industry_id=I.id) inner join bmc_countries C ON (U.company_location=C.country_id) where U.company='".$comp_id."' group by R.participant_id";	
		$alldata=$this->Response->query($sql);
		
		$bsql="select Company.company,Company.id,I.id,I.industry,C.country_id,C.country_name,BD.role_id,BD.year from bmc_benchmark_data BD inner join bmc_companies Company ON (BD.company_id=Company.id) inner join bmc_industries I ON (BD.industry_id=I.id) left join bmc_countries C ON (BD.country_id=C.country_id) where BD.company_id='".$comp_id."' group by BD.company_id,I.id,BD.role_id,BD.year";
		$bdata=$this->BenchmarkData->query($bsql);
		
		$mergeArr=array();
		$start_yr=2013;
		if(!empty($alldata))
		{
			foreach($alldata as $adat)
			{
				if(!empty($bdata))
				{
					foreach($bdata as $bd)
					{				
						$mergeArr[]=$bd;
						if(!empty($bd['BD']['year']) && ($bd['BD']['year']<$start_yr))
						{
							$start_yr=$bd['BD']['year'];	
						}					
					}
					$mergeArr[]=$adat;
					if(!empty($adat['R']['year']) && ($adat['R']['year']<$start_yr))
					{
						$start_yr=$adat['R']['year'];	
					}	
				}else{
					$mergeArr[]=$adat;	
					if(!empty($adat['R']['year']) && ($adat['R']['year']<$start_yr))
					{
						$start_yr=$adat['R']['year'];	
					}
				}
			}
		}else{
			foreach($bdata as $bd)
			{
				$mergeArr[]=$bd;
				if(!empty($bd['BD']['year']) && ($bd['BD']['year']<$start_yr))
				{
					$start_yr=$bd['BD']['year'];	
				}	
			}			
		}
								
		$countries=$industries=$already_comp=$already_ind=array(); $i=$j=0;	
		foreach($mergeArr as $dat)
		{
			if(!in_array($dat['C']['country_id'],$already_comp))
			{		
				if(!empty($dat['C']['country_id']))
				{
					$countries[$i]['C']=$dat['C'];
					$already_comp[]=$dat['C']['country_id'];
					$i++;
				}
			}
			if(!in_array($dat['I']['id'],$already_ind))
			{		
				$industries[$j]['I']=$dat['I'];
				$already_ind[]=$dat['I']['id'];
				$j++;
			}							
		}		
		$cur_yr=date('Y');
		$allyears=array();
		for($i=$cur_yr;$i>=$start_yr;$i--)
		{
			$allyears[]=$i;	
		}
		$this->set('allyears',$allyears);
		$this->set('countries',$countries);
		$this->set('industries',$industries);
		$this->set('data',$mergeArr[0]);
		$this->set('sysData',2);
		$this->set('company_id',$comp_id);
		$this->render('company_data_layout');		
	}
	
	public function systemCompany_data()
	{
		$this->layout='ajax';
		$comp_id=$this->data['cid'];
		$sql="select distinct Company.company,Company.id,I.id,I.industry,C.country_id,C.country_name from bmc_responses R inner join bmc_participant P ON (R.participant_id=P.id) inner join bmc_users U ON (P.user_id=U.id) inner join bmc_companies Company ON (U.company=Company.id) inner join bmc_industries I ON (U.industry_id=I.id) inner join bmc_countries C ON (U.company_location=C.country_id) where U.company='".$comp_id."' group by R.participant_id";
		$alldata=$this->Response->query($sql);
		$countries=$industries=$already_comp=$already_ind=array(); $i=$j=0;	
		foreach($alldata as $dat)
		{
			if(!in_array($dat['C']['country_id'],$already_comp))
			{		
				$countries[$i]['C']=$dat['C'];
				$already_comp[]=$dat['C']['country_id'];
				$i++;
			}
			if(!in_array($dat['I']['id'],$already_ind))
			{		
				$industries[$j]['I']=$dat['I'];
				$already_ind[]=$dat['I']['id'];
				$j++;
			}							
		}
		$start_yr=2013;
		$cur_yr=date('Y');
		$allyears=array();
		for($i=$cur_yr;$i>=$start_yr;$i--)
		{
			$allyears[]=$i;	
		}
		$this->set('allyears',$allyears);
		$this->set('countries',$countries);
		$this->set('industries',$industries);
		$this->set('data',$alldata[0]);
		$this->set('sysData',1);
		$this->set('company_id',$comp_id);
		$this->render('company_data_layout');
	}
	
	
	public function get_company_data()
	{
		$this->layout='ajax';
		$id=$this->data['id'];
		
		$this->BenchmarkComp->bindModel(array('belongsTo'=>array('Company'=>array('className'=>'Company','foreignKey'=>'company_id')),
											  'hasMany'=>array('BenchmarkData'=>array('className'=>'BenchmarkData','foreignKey'=>'benchmark_companies_id'))));
		$bc_data=$this->BenchmarkComp->find('first',array('conditions'=>array('BenchmarkComp.id'=>$id)));
		
		$f_keys=array(); 
		$f_keys['c_ids']=$f_keys['i_ids']=array();
		foreach($bc_data['BenchmarkData'] as $bcdat)
		{
			if(!empty($bcdat['country_id']))
			{
				if(!in_array($bcdat['country_id'],$f_keys['c_ids']))
						$f_keys['c_ids'][]=$bcdat['country_id'];
			}			
			if(!in_array($bcdat['industry_id'],$f_keys['i_ids']))
						$f_keys['i_ids'][]=$bcdat['industry_id'];
		}		
		
		if(!empty($f_keys['c_ids']))
		{
			$cntry_cond="country_id IN (". implode(',', array_map('intval', $f_keys['c_ids'])) .")";			
		}else{
			$cntry_cond=null;
		}
		
		if(!empty($f_keys['i_ids']))
		{
			$ind_cond="id IN (". implode(',', array_map('intval', $f_keys['i_ids'])) .")";			
		}else{
			$ind_cond="1=1";
		}		
				
		if(!empty($cntry_cond))
		{
			$country_sql="select C.* from bmc_countries C where ".$cntry_cond." order by country_name";
			$countries=$this->Country->query($country_sql);
		}else{
			$countries=null;	
		}
		
		$start_yr=2005;
		$cur_yr=date('Y');
		$allyears=array();
		for($i=$cur_yr;$i>=$start_yr;$i--)
		{
			$allyears[]=$i;	
		}
		$this->set('allyears',$allyears);
		$industry_sql="select I.* from bmc_industries I where ".$ind_cond;
		$industries=$this->Industry->query($industry_sql);
		
		$this->set('data',$bc_data);		
		$this->set('countries',$countries);
		$this->set('industries',$industries);
		$this->render('company_data_layout');
	}
	
	
	public function show_specific_data()
	{
		$this->layout='ajax';
		if($this->data['section']=='0')
		{
			if($this->data['num']!='2')
			{
				$data=$this->getBenchmarkData($this->data);				
				$this->set('comp_id',$this->data['comp_id']);
				$this->set('data',$data);
				if($this->data['num']=='0')
					$this->render('view_specific_data');
				else
					$this->render('edit_specific_data');	
			}else{
				if(isset($this->data['year']) && !empty($this->data['year']))
				{
					$years=$this->data['year'];
				}else{
					$years=0;
				}
				$this->delete_benchmark_data($this->data['role'],$this->data['comp_id'],$this->data['cntry'],$this->data['ind'],$years);
			}
		}else if($this->data['section']=='1'){
			$this->layout='ajax';
			if(!empty($this->data['ind']) && !empty($this->data['cntry']) && !empty($this->data['year']) && !empty($this->data['role']))
			{	$data=$this->getSystemData($this->data);
				$this->set('sysData',1);
			}else{
				$data=array();	
			}
			
			$this->set('data',$data);
			$this->set('comp_id',$this->data['comp_id']);
			$this->render('view_custom_specific_data');			
		}else if($this->data['section']=='2')
		{
			$this->layout='ajax';
			
			if($this->data['ind']!='' && $this->data['cntry']!='' && $this->data['role']!='')
			{	
				if($this->data['role']=='000') $role_text='All Roles';
				if($this->data['role']=='3') $role_text='Project Manager';
				if($this->data['role']=='4') $role_text='Team Member';
				if($this->data['role']=='5') $role_text='Manager of Project Managers';
				$this->set('role_text',$role_text);
				
				$data=$this->getAggregateData($this->data);
				$this->request->data['role']='3';
				$avgData[3]=$this->getAggregateData($this->data);
				$this->request->data['role']='4';
				$avgData[4]=$this->getAggregateData($this->data);
				$this->request->data['role']='5';
				$avgData[5]=$this->getAggregateData($this->data);
				$this->set('sysData',1);
			}else{				
				$data=array();	
			}
			
			if(!empty($data))
			{
				$section_chart="['Section','A: Very Proficient','B: Proficient','C: Moderately Proficient','D: Low Proficiency','E: Lack of proficiency'],";
				for($i=1;$i<7;$i++)
				{
					if($i==1) $sect='Planning'; if($i==2) $sect='Organizing & Staffing'; if($i==3) $sect='Directing & Leading';	if($i==4) $sect='Controlling'; if($i==5) $sect='Reporting'; if($i==6) $sect='Risk Management';					
					$j=0;
					$comma=",";
					if($i==6)
						$comma="";
					
					$section_chart.="['".$sect."',".intval($data[$i][1]).",".intval($data[$i][2]).",".intval($data[$i][3]).",".intval($data[$i][4]).",".intval($data[$i][5])."]".$comma;
				}
				$this->set('section_chart',$section_chart);
			}
			
			$avg=array();
			if(!empty($data))
			{
				$avgChart="['Section','Project Manager','Team Member','Manager of Project Managers'],";
				for($l=1;$l<7;$l++)
				{
					if($l==1) $point='Planning'; if($l==2) $point='Organizing & Staffing'; if($l==3) $point='Directing & Leading';	if($l==4) $point='Controlling'; if($l==5) $point='Reporting'; if($l==6) $point='Risk Management';	
					
					for($k=3;$k<6;$k++)
					{
						if(isset($avgData[$k][$l]) && !empty($avgData[$k][$l]))
						{
							$avg[$l][$k]=round((($avgData[$k][$l][1]+$avgData[$k][$l][2]+$avgData[$k][$l][3]+$avgData[$k][$l][4]+$avgData[$k][$l][5])/5),2);
								
						}else{
							$avg[$l][$k]=0;	
						}
					}
					$comma=",";
						if($l==6)
							$comma="";		
					$avgChart.="['".$point."',".$avg[$l][3].",".$avg[$l][4].",".$avg[$l][5]."]".$comma;
				}	
							
				$this->set('avgChart',$avgChart);
			}
			
			$this->set('data',$data);
			$this->set('comp_id',$this->data['comp_id']);
			$this->render('view_custom_specific_data');		
		}
	}
	
	
	public function getAggregateData($arr)
	{
		$bdata=$this->getBenchmarkData($arr,1);
		$sysdata=$this->getSystemData($arr);
		
		$arr=array();
		if(!empty($bdata) || !empty($sysdata))
		{		
			for($i=1;$i<7;$i++)
			{
				for($j=1;$j<6;$j++)
				{
					if(!isset($sysdata[$i][$j])) $sysdata[$i][$j]=0;	
						
					if($j==1)	$str='num_a';
					if($j==2)	$str='num_b';
					if($j==3)	$str='num_c';
					if($j==4)	$str='num_d';
					if($j==5)	$str='num_e';
					if(!isset($bdata[$i-1]['BenchmarkData'][$str])) $bdata[$i-1]['BenchmarkData'][$str]=0;
							
					$arr[$i][$j]=$sysdata[$i][$j]+intval($bdata[$i-1]['BenchmarkData'][$str]);	
				}	
			}
		}
		return $arr;	
	}
	
	public function getBenchmarkData($arr,$flag=0)
	{
		$type=$arr['type'];				
		if($type=='1')
		{
			$cntry=null;						
		}else if($type=='3')
		{
			$cntry=$arr['cntry'];								
		}
		$conditions=array('BenchmarkData.company_id'=>$arr['comp_id']);
		
		if($arr['role']!='000')
			$conditions['BenchmarkData.role_id']=$arr['role'];
		if($cntry!='000')
			$conditions['BenchmarkData.country_id']=$cntry;
		if($arr['year']!='000')
			$conditions['BenchmarkData.year']=$arr['year'];	
		//if($flag!=1)
		//{
			if($arr['year']=='999')
			{
				$conditions['BenchmarkData.year']='';	
			}	
		//}			
		if($arr['ind']!=000)
			$conditions['BenchmarkData.industry_id']=$arr['ind'];	
														
		$data=$this->BenchmarkData->find('all',array('conditions'=>$conditions));	
		
		$result=array();		
		if(!empty($data)){
			foreach($data as $dat){
				$dat['BenchmarkData']['group_id']=$dat['BenchmarkData']['group_id']-1;
				
				if(!isset($result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_a']))
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_a']=0;
				if(!isset($result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_b']))
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_b']=0;
				if(!isset($result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_c']))
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_c']=0;
				if(!isset($result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_d']))
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_d']=0;
				if(!isset($result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_e']))
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_e']=0;				
				
				
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_a']+=$dat['BenchmarkData']['num_a'];
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_b']+=$dat['BenchmarkData']['num_b'];
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_c']+=$dat['BenchmarkData']['num_c'];
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_d']+=$dat['BenchmarkData']['num_d'];
					$result[$dat['BenchmarkData']['group_id']]['BenchmarkData']['num_e']+=$dat['BenchmarkData']['num_e'];	
				
				//pr($dat['BenchmarkData']['num_a']); 
			}
		}
		//pr($result); die;	
		return $data;	
	}
	
	public function getSystemData($arr)
	{
		$country=$year=$industry=$role='';
		
		if($arr['role']!='000')
				$country=" and P.user_role_id='".$arr['role']."' ";
		if($arr['cntry']!='000')
				$country=" and U.company_location='".$arr['cntry']."' ";
		if($arr['year']!='000')
				$year=" and R.year='".$arr['year']."' ";
		if($arr['ind']!=000)
				$industry=" and U.industry_id='".$arr['ind']."' ";		
		
		$company_count_sql="select sum(CAST(trim(R.response) AS UNSIGNED)) as sum, P.id, Q.group_id from bmc_responses R inner join bmc_questions Q on (Q.id=R.question_id) inner join bmc_participant P on (P.id=R.participant_id) join bmc_users U on (P.user_id=U.id) join bmc_companies C on (U.company=C.id) where P.status='1' and P.participant_status='1' and Q.tool_id='1' and U.company='".$arr['comp_id']."' ".$role.$industry.$year.$country." group by Q.group_id,P.id";	
			
		$company_count_response=$this->Response->query($company_count_sql);
		
		$cpc_arr=array();
		foreach($company_count_response as $cpc)
		{
			if($cpc['0']['sum']<=10)
			{	
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['5']))
								$cpc_arr[$cpc['Q']['group_id']]['5']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['5']+=1;
			}
			if($cpc['0']['sum']>10 && $cpc['0']['sum']<=20)
			{
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['4']))
								$cpc_arr[$cpc['Q']['group_id']]['4']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['4']+=1;			
			}
			if($cpc['0']['sum']>20 && $cpc['0']['sum']<=30)
			{
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['3']))
								$cpc_arr[$cpc['Q']['group_id']]['3']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['3']+=1;			
			}
			if($cpc['0']['sum']>30 && $cpc['0']['sum']<=40)
			{
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['2']))
								$cpc_arr[$cpc['Q']['group_id']]['2']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['2']+=1;			
			}
			if($cpc['0']['sum']>40  && $cpc['0']['sum']<=50)
			{
				if(!isset($cpc_arr[$cpc['Q']['group_id']]['1']))
								$cpc_arr[$cpc['Q']['group_id']]['1']=0;	
				$cpc_arr[$cpc['Q']['group_id']]['1']+=1;			
			}
		}
		return $cpc_arr;		
	}
	
		
	public function add_benchmark_data($comp_id)
	{
		$this->layout='ajax';
		$already=$this->BenchmarkData->find('all',array('conditions'=>array('BenchmarkData.company_id'=>$comp_id),'fields'=>array('BenchmarkData.country_id','BenchmarkData.industry_id'),'group'=>array('BenchmarkData.country_id','BenchmarkData.industry_id')));
		
		if($comp_id!='000')
			$company=$this->Company->find('first',array('conditions'=>array('Company.id'=>$comp_id)));
		else 
			$company='';	
		$al_cntry=$al_inds=array();
		if(!empty($already))
		{
			foreach($already as $al)
			{
				if(!in_array($al['BenchmarkData']['country_id'],$al_cntry))
						$al_cntry[]=$al['BenchmarkData']['country_id'];	
						
				if(!in_array($al['BenchmarkData']['industry_id'],$al_inds))
						$al_inds[]=$al['BenchmarkData']['industry_id'];			
			}	
		}
		if(!empty($al_cntry))
		{
			$cntry_cond="1=1";		
		}else{
			$cntry_cond="1=1";
		}
		
		$cntry_sql="select Country.* from bmc_countries as Country where ".$cntry_cond." order by country_name";
		$countries=$this->Country->query($cntry_sql);
		
		$industries=$this->Industry->find('all',array('order'=>array('Industry.industry ASC')));		
		$companies=$this->Company->find('all',array('order'=>array('Company.company ASC')));
		
		$all_comps=array(); $i=0;
		foreach($companies as $cmp)
		{
			$all_comps[$i]['label']=$cmp['Company']['company'];	
			$i++;
		}
		$all_industry=array(); $j=0;
		foreach($industries as $ind)
		{
			$all_industry[$j]['label']=$ind['Industry']['industry'];	
			$j++;
		}
		$start_yr=2005;
		$cur_yr=date('Y');
		$allyears=array();
		for($i=$cur_yr;$i>=$start_yr;$i--)
		{
			$allyears[]=$i;	
		}
		$this->set('allyears',$allyears);	
		$this->set('all_industry',$all_industry);
		$this->set('all_comps',$all_comps);
		$this->set('company',$company);
		$this->set('countries',$countries);
		$this->set('industries',$industries);
		$this->render('add_benchmark_data');
	}
	
	public function save_benchmark_data()
	{
		$companies=$this->Company->find('all');		
		$already=$ind_already=array();
		foreach($companies as $ex)
		{
			$already[]=strtolower(trim($ex['Company']['company']));	
		}
		if(!in_array(strtolower(trim($this->data['BenchmarkData']['company'])),$already))
		{
			$this->Company->create();
			$comp_data=$this->Company->save(array('company'=>$this->data['BenchmarkData']['company']));				
		}else{
			$comp_data=$this->Company->findByCompany($this->data['BenchmarkData']['company']);	
		}		
		
		$ind_data=$this->Industry->findByIndustry($this->data['BenchmarkData']['industry']);	
		if(empty($ind_data))
		{
			$this->Industry->create();
			$ind_data=$this->Industry->save(array('industry'=>$this->data['BenchmarkData']['industry']));
		}	
		
		$country=$this->data['BenchmarkData']['country_id'];
		
		if(!empty($country))
		{
			$conditions=array('BenchmarkData.role_id'=>$this->data['BenchmarkData']['role_id'],'BenchmarkData.company_id'=>$comp_data['Company']['id'],'BenchmarkData.country_id'=>$country,'BenchmarkData.industry_id'=>$ind_data['Industry']['id']);
			
		}else{
			$conditions=array('BenchmarkData.role_id'=>$this->data['BenchmarkData']['role_id'],'BenchmarkData.company_id'=>$comp_data['Company']['id'],'BenchmarkData.country_id'=>'','BenchmarkData.industry_id'=>$ind_data['Industry']['id']);			
		}
		
		if(isset($this->data['BenchmarkData']['year']) && !empty($this->data['BenchmarkData']['year']))
		{
			$conditions['BenchmarkData.year']=$this->data['BenchmarkData']['year'];	
		}
		
		$exist=$this->BenchmarkData->find('all',array('conditions'=>$conditions));
			
		$data=array(); $i=0;
		if(empty($exist))
		{
			$benchComps=$this->BenchmarkComp->find('first',array('conditions'=>array('BenchmarkComp.company_id'=>$comp_data['Company']['id'])));
			$msg='Added General Data';
			if(!empty($country))
			{
				$cntry_data=$this->Country->findByCountryId($country);
				$msg=$cntry_data['Country']['country_name'].' data added';	
			}
			if(empty($benchComps))
			{
				$this->BenchmarkComp->create();
				$benchComps=$this->BenchmarkComp->save(array('company_id'=>$comp_data['Company']['id'],'date_modified'=>date("Y-m-d H:i:s"),'last_update'=>$msg));					
			}else{				
				$this->BenchmarkComp->id=$benchComps['BenchmarkComp']['id'];
				$this->BenchmarkComp->save(array('date_modified'=>date("Y-m-d H:i:s"),'last_update'=>$msg));
			}
			
			foreach($this->data['val'] as $index=>$val)
			{
				if(empty($val['num_a'])) $val['num_a']=0;
				if(empty($val['num_b'])) $val['num_b']=0;
				if(empty($val['num_c'])) $val['num_c']=0;
				if(empty($val['num_d'])) $val['num_d']=0;
				if(empty($val['num_e'])) $val['num_e']=0;								
					
				$data[$i]['benchmark_companies_id']=$benchComps['BenchmarkComp']['id'];
				$data[$i]['role_id']=$this->data['BenchmarkData']['role_id'];
				$data[$i]['year']=$this->data['BenchmarkData']['year'];
				$data[$i]['company_id']=$comp_data['Company']['id'];
				$data[$i]['country_id']=$country;
				$data[$i]['industry_id']=$ind_data['Industry']['id'];
				$data[$i]['group_id']=$index;
				$data[$i]['num_a']=$val['num_a'];
				$data[$i]['num_b']=$val['num_b'];
				$data[$i]['num_c']=$val['num_c'];
				$data[$i]['num_d']=$val['num_d'];
				$data[$i]['num_e']=$val['num_e'];
				$i++;				
			}
		}
		if(!empty($data))
		{
			$this->BenchmarkData->create();
			$this->BenchmarkData->saveAll($data);			
		}
		if(!empty($data))
		{
			$this->redirect(array('action'=>'index','admin'=>true));
		}else{
			$this->redirect(array('action'=>'index','1','admin'=>true));
		}
			
	}
	
	public function update_benchmark_data()
	{
		foreach($this->data['val'] as $data)
		{
			$this->BenchmarkData->id=$data['id'];
			$this->BenchmarkData->save(array('num_a'=>$data['num_a'],'num_b'=>$data['num_b'],'num_c'=>$data['num_c'],'num_d'=>$data['num_d'],'num_e'=>$data['num_e']));	
		}
		$sql="update bmc_benchmark_companies set last_update='Edited', date_modified='".date('Y-m-d H:i:s')."' where company_id='".$this->data['comp_id']."'";
		$this->BenchmarkComp->query($sql);
		echo $this->data['comp_id']; die;
	}
	
	public function delete_benchmark_data($role_id,$company_id,$country_id,$industry_id,$year)
	{
		if($country_id==0)
			$country_id=null;
			
		if($year!=0)	
		{	
			$this->BenchmarkData->deleteAll(array('BenchmarkData.role_id'=>$role_id,'BenchmarkData.company_id'=>$company_id,'BenchmarkData.country_id'=>$country_id,'BenchmarkData.industry_id'=>$industry_id,'BenchmarkData.year'=>$year));
		}else{
			$this->BenchmarkData->deleteAll(array('BenchmarkData.role_id'=>$role_id,'BenchmarkData.company_id'=>$company_id,'BenchmarkData.country_id'=>$country_id,'BenchmarkData.industry_id'=>$industry_id));	
		}
		$exist=$this->BenchmarkData->find('all',array('conditions'=>array('BenchmarkData.company_id'=>$company_id)));
		if(!empty($exist))
		{
			$msg='Deleted some data';
			if(!empty($country_id))
			{
				$country=$this->Country->findByCountryId($country_id);
				$msg=$country['Country']['country_name'].' data deleted';	
			}
			$sql="update bmc_benchmark_companies set last_update='".$msg."', date_modified='".date('Y-m-d H:i:s')."' where company_id='".$company_id."'";
			$this->BenchmarkComp->query($sql);	
		}else{
			$this->BenchmarkComp->deleteAll(array('BenchmarkComp.company_id'=>$company_id));	
		}	
		$this->redirect(array('action'=>'index','admin'=>true));
	}
	
	
	
}