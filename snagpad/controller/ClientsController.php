<?php
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor','functions');
//App::import('Vendor','uploadclass');

class ClientsController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session','Upload');
    public $uses = array('Client','Skillslist','Account','University','Major','Minor','Country','State','Industry','Position','Jobtype','Jobfunction','Clientfile','Clientfilehistory','Profiletooltip','Jobfamily','Skillvalues','Jobskills');

    public function beforeFilter() {
		parent::beforeFilter(); 
		if(!$this->Session->check('Client'))
			{
			$this->redirect(SITE_URL.'/users/session_expire');
			//$this->Session->setFlash(__('You are not authorized to acces that page. Please login to  continue.'));
			
			exit();
			}
		parent::beforeFilter();	
		$this->createdir();	
        $this->layout = 'cardinfo';
    }
	
		
	public function createdir()
	{
		$clientid=$this->Session->read('Client.Client.id');
		 $folderpath=WWW_ROOT . 'files' . DS . $clientid;
		if(!is_dir($folderpath)) {
				//$folder=mkdir($folderpath,0777);
				mkdir($folderpath,0777);
			}
		}
	
	public function dashboard()
	{
		$this->layout = 'cardinfo';
	}
	
	public function index()
	{
	
	}


	public function handler()
	{
		$this->layout = 'none';
		
		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		switch ($_SERVER['REQUEST_METHOD']) {
		    case 'OPTIONS':
		        break;
		    case 'HEAD':
		    case 'GET':
		        $this->Upload->get();
		        break;
		    case 'POST':
		        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
		            $this->Upload->delete();
		        } else {
		            $this->Upload->post();
					//$this->Upload->get();
		        }
		        break;
		    case 'DELETE':
		        $this->Upload->delete();
		        break;
		    default:
		        header('HTTP/1.1 405 Method Not Allowed');
		}		
	}
	
	/*public function abc()
	{
		$upload_handler = new UploadHandler();
		die;
		//echo '<pre>';print_r($this->data);die;
		}*/
	
	
	
	public function profile_setup()
	{
		$this->layout='basic_popup';
		$client_info=$this->Session->read('Client');
		
		$this->Client->id=$client_info['Client']['id'];
		$this->Client->saveField('login','0');
		$tooltip=$this->Profiletooltip->find('all');
		$this->set('tip',$tooltip);
		//echo '<pre>';print_r($tooltip);die;
		$this->set('clientid',$client_info['Client']['id']);
		
		$this->render('profile_start');	
	}	
	
	public function findstep($clientid)
	{	
		//echo $clientid;die;
		$client=$this->Client->findById($clientid);
		//echo '<pre>';print_r($client);die;
		if($client['Client']['job_type']!=0 && $client['Client']['job_function']!=0 && $client['Client']['tposition']!=0 && $client['Client']['state']!= NULL && $client['Client']['city']!=NULL && $client['Client']['postalcode']!=NULL && $client['Client']['state']!='' && $client['Client']['city']!='' && $client['Client']['postalcode']!='' && $client['Client']['highest_education']!=NULL && $client['Client']['degree_obtained']!=NULL && $client['Client']['highest_education']!='' && $client['Client']['degree_obtained']!='' &&  $client['Client']['highest_education']!=0 && $client['Client']['degree_obtained']!=0  && $client['Client']['job_b_criteria']!=NULL && $client['Client']['job_b_criteria']!='' && $client['Client']['job_a_skills']!=NULL && $client['Client']['job_a_skills']!='' && $client['Client']['job_a_values']!=NULL && $client['Client']['job_a_values']!='' && $client['Client']['job_a_title']!=NULL && $client['Client']['job_a_title']!='' ) 
	{	$step=7;  	
	}else if($client['Client']['state']!= NULL && $client['Client']['city']!=NULL && $client['Client']['postalcode']!=NULL && $client['Client']['state']!='' && $client['Client']['city']!='' && $client['Client']['postalcode']!='' && $client['Client']['highest_education']!=NULL && $client['Client']['degree_obtained']!=NULL && $client['Client']['highest_education']!='' && $client['Client']['degree_obtained']!='' &&  $client['Client']['highest_education']!=0 && $client['Client']['degree_obtained']!=0 && $client['Client']['job_b_criteria']!=NULL && $client['Client']['job_b_criteria']!='' && $client['Client']['job_a_skills']!=NULL && $client['Client']['job_a_skills']!='' && $client['Client']['job_a_values']!=NULL && $client['Client']['job_a_values']!='' && $client['Client']['job_a_title']!=NULL && $client['Client']['job_a_title']!='') 
	{	$step=6; 
	}else if($client['Client']['highest_education']!=NULL && $client['Client']['degree_obtained']!=NULL && $client['Client']['highest_education']!='' && $client['Client']['degree_obtained']!='' &&  $client['Client']['highest_education']!=0 && $client['Client']['degree_obtained']!=0 && $client['Client']['job_b_criteria']!=NULL && $client['Client']['job_b_criteria']!='' && $client['Client']['job_a_skills']!=NULL && $client['Client']['job_a_skills']!='' && $client['Client']['job_a_values']!=NULL && $client['Client']['job_a_values']!='' && $client['Client']['job_a_title']!=NULL && $client['Client']['job_a_title']!='') 
	{	$step=5; 
	}else if($client['Client']['job_b_criteria']!=NULL && $client['Client']['job_b_criteria']!=''  && $client['Client']['job_a_skills']!=NULL && $client['Client']['job_a_skills']!='' && $client['Client']['job_a_values']!=NULL && $client['Client']['job_a_values']!='' && $client['Client']['job_a_title']!=NULL && $client['Client']['job_a_title']!='' )
	{	$step=4;
	}else if($client['Client']['job_a_skills']!=NULL && $client['Client']['job_a_skills']!='' && $client['Client']['job_a_values']!=NULL && $client['Client']['job_a_values']!='' && $client['Client']['job_a_title']!=NULL && $client['Client']['job_a_title']!='')
	{	$step=3;
	}else if($client['Client']['job_a_title']!=NULL && $client['Client']['job_a_title']!='')
	{	$step=2; 
	}else
		{	$step=1; //echo $client['Client']['job_a_title']; die;	
		}	
	return $step;		
}
	
	
	function progressPercent($client_id)
	{
	$client_table='jsb_client';
	$client_files_table='jsb_client_files';	
	$client=$this->Client->findById($client_id);

	$files=$this->Clientfile->find('count',array('fields'=>'Clientfile.id','conditions'=>array('Clientfile.client_id'=>$client_id)));
	//	echo '<pre>';print_r($files);die;
	$step=0; $progress=0;
	if($client['Client']['job_a_title']!=NULL && $client['Client']['job_a_title']!='')
		{	$step++; $progress+=14.285; }
	if($client['Client']['job_a_skills']!=NULL && $client['Client']['job_a_skills']!='')
		{ $step++; $progress+=14.285; }
	if($client['Client']['job_b_criteria']!=NULL && $client['Client']['job_b_criteria']!='')
		{ $step++; $progress+=14.285; }
	 if($client['Client']['highest_education']!=NULL && $client['Client']['degree_obtained']!=NULL && $client['Client']['highest_education']!='' && $client['Client']['degree_obtained']!='' &&  $client['Client']['highest_education']!=0 && $client['Client']['degree_obtained']!=0) 
	 	{ $step++; $progress+=14.285; }
	if($client['Client']['state']!= NULL && $client['Client']['city']!=NULL && $client['Client']['postalcode']!=NULL && $client['Client']['state']!='' && $client['Client']['city']!='' && $client['Client']['postalcode']!='') 
		{ $step++; $progress+=14.285; }
	if($client['Client']['job_type']!=0 && $client['Client']['job_function']!=0 && $client['Client']['tposition']!=0) 
		{ $step++; $progress+=14.285; }
		
	if($files>0)
		{ $step++; $progress+=14.285; }
		
	 $progress=round($progress,2);	
	$this->set('progress',$progress);
	}
	
	public function show_skip_button($current,$step)
	{
			$skip=0;
				if($step>$current)
				{
					$skip=1;
				}
				$this->set('skip',$skip);
		
	}
	
	public function profile_start_step1()
	{
			$this->Session->delete('firstTime');
			$this->layout='popup';
			$clientid=$this->Session->read('Client.Client.id');
			$step=$this->findstep($clientid);
			$this->Session->write('Client.P_step',$step);
			$this->progressPercent($clientid);
			$this->set('step',$step);
			$this->set('clientid',$clientid);
			$this->set("popTitle","PROFILE WIZARD");		
			$this->render('profile_start_step1');
	}		
	
		
	public function profile_step1()
	{
		$this->Session->delete('firstTime');
		if(!empty($this->data))
		{
			if(isset($this->data['cl_id']))
			{
				$this->show_profile1($this->data['cl_id']);
				
			}else{
					$clientid=$this->data['clientid'];
					$job_a_title=$this->data['Client']['job_a_title'];
					$d=date("Y-m-d H:i:s");
					$query="UPDATE jsb_client SET job_a_title='$job_a_title',job_pref_modified='$d',job_a_skills='',job_a_values='' WHERE id='$clientid'";
					$this->Client->query($query); 
					$this->show_profile2($clientid);
				}
			
		}else{
				$this->layout='ajax';
				$this->Session->write('Client.profile_step','1');
				$client_info=$this->Session->read('Client');
				$step=$this->findstep($client_info['Client']['id']);
				$this->Session->write('Client.P_step',$step);
				$this->show_skip_button('1',$step);	
				$this->progressPercent($client_info['Client']['id']);				
				$this->request->data=$this->Client->read(null,$client_info['Client']['id']);				
				$job_data=$this->Jobfamily->find('all');
				$jobs=array();
				foreach($job_data as $j)
					$jobs[]=$j['Jobfamily']['title'];
				//echo '<pre>';print_r($jobs);die;	
				$this->set('jobs',$jobs);	
				$this->set('job_a_title',$this->request->data['Client']['job_a_title']);
				$this->set('clientid',$client_info['Client']['id']);
				//$this->set("popTitle","PROFILE WIZARD");		
				$this->render('profile_step1');
				//$this->autoRender=false;
			}
	}	
	
	public function show_profile1($clientid)
	{
		$this->layout='ajax';
		$this->Session->write('Client.profile_step','1');
		$step=$this->findstep($clientid);
		$this->Session->write('Client.P_step',$step);	
		$this->show_skip_button('1',$step);	
		$this->progressPercent($clientid);
		
		$this->request->data=$this->Client->read(null,$clientid);
		$job_data=$this->Jobfamily->find('all');
		$jobs=array();
		foreach($job_data as $j)
			$jobs[]=$j['Jobfamily']['title'];
		//echo '<pre>';print_r($jobs);die;	
		$this->set('jobs',$jobs);
		$this->set('job_a_title',$this->request->data['Client']['job_a_title']);
		$this->set('clientid',$clientid);
		$this->render('profile_step1');	
	}
	
	public function show_profile2($clientid)
	{
		$this->layout='ajax';
		$this->Session->write('Client.profile_step','2');
		$data_exist=$this->Client->find('first',array('conditions'=>array('Client.id'=>$clientid),'fields'=>array('Client.job_a_title','Client.job_a_skills','Client.job_a_values')));		
		$onet_code=$this->Jobfamily->query("select * from jsb_job_family as Jobfamily where title='".$data_exist['Client']['job_a_title']."'");		
		if(!empty($onet_code))
		{
		$sql="select distinct Skillslist.id,Skillslist.skill,Skillslist.description,Skillslist.type,Skillslist.element_id,J.onetsoc_code,J.not_relevant from jsb_job_skills J inner join jsb_skillslist Skillslist ON (Skillslist.element_id=J.element_id) where J.onetsoc_code='".$onet_code[0]['Jobfamily']['onetsoc_code']."' and J.data_value>='2.80' and J.not_relevant!='Y' order by Skillslist.skill";
	//echo $sql;die;
		$skills=$this->Skillslist->query($sql);
		$this->set('onet_job_A',$onet_code[0]['Jobfamily']['onetsoc_code']);
		}else{
			$this->set('custom_job_A','1');
			$skills=$this->Skillslist->find('all',array('conditions'=>array('Skillslist.type'=>4)));
			
		}
		
		$skill_exist['text']=explode('|',$data_exist['Client']['job_a_skills']);
		$skill_exist['val']=explode('|',$data_exist['Client']['job_a_values']);
		unset($skill_exist['text'][count($skill_exist['text']) - 1]);
		unset($skill_exist['val'][count($skill_exist['val']) - 1]);
	//	echo '<pre>';print_r($skills);die;
		$dat=array(); $arr=array(); $temp=array(); $extra=array();
		
		foreach($skills as $sk)
			$temp[]=$sk['Skillslist']['skill'];	
		
		$i=0;
		//echo '<pre>';print_r($skill_exist);die;
		if(!empty($skill_exist['val']))
		{
			foreach($skill_exist['text'] as $key=>$index)
			{
				$dat[]=$index;
				foreach($skill_exist['val'] as $key1=>$ind_val)
				{					
					if(!in_array($index,$temp))
					{	$extra['ex'.$i]['text']=$index;
						$extra['ex'.$i]['val']=$ind_val;
										
					}
					if($key1==$key)
						$arr[$index]=$ind_val;
				}				
				$i++;
			}
		}else{
			foreach($skill_exist['text'] as $key=>$index)
			{
				$dat[]=$index;
				if(!in_array($index,$temp))
				{	$extra['ex'.$i]['text']=$index;
					$extra['ex'.$i]['val']=0;	
					$i++;			
				}
				$arr[$index]=0;	
					
			}
		
		}
		if(empty($skills))
		{
			$this->set('custom_job_A','1');
			$skills=$this->Skillslist->find('all',array('conditions'=>array('Skillslist.type'=>4)));
		}
		/*if($this->Session->read('Client.Client.id')=='9')
		{
			echo '<pre>';print_r($extra);die;	
		}*/
		$step=$this->findstep($clientid);
		$this->Session->write('Client.P_step',$step);
		$this->show_skip_button('2',$step);	
		$this->progressPercent($clientid);
		$this->set('clientid',$clientid);
		$this->set('exist',$dat);
		$this->set('arr',$arr);
		$this->set('extra',$extra);
		$this->set('data',$skill_exist);
		$this->set('skills',$skills);
		$this->render('profile_step2');		
		
	}
	
	
	public function profile_step2()
	{
		if($this->request->is('ajax'))
		{	
			if(!empty($this->data))
			{	
				if(isset($this->data['cl_id']))
				{
					$this->show_profile2($this->data['cl_id']);
				}else{						
						//echo '<pre>';print_r($this->data);die;
						$clientid=$this->data['clientid'];
						$data_check=$data_val=null;
						if(isset($this->data['skill_check'])) 
						{
							foreach($this->data['skill_check'] as $sk)
							{
								if(!empty($sk['check']))
								{
									$data_check.=$sk['check'].'|';
									$data_val.=$sk['val'].'|';
								}
							}	
						}									
						$d=date("Y-m-d H:i:s");
						$q="UPDATE jsb_client SET job_a_skills='$data_check',job_a_values='$data_val',job_pref_modified='$d' WHERE id='$clientid'";
						$this->Client->query($q); 
						$this->show_profile3($clientid);
					}				
			}
		}
	}
	
	public function show_profile3($clientid)
	{
		$this->layout='ajax';
		$this->Session->write('Client.profile_step','3');
		$criterias=array(0=>"Location",1=>"Money",2=>"Make Contacts",3=>"Gain experience",4=>"Career Ladder",5=>"Ideal Organization");
		$criteria_exist=$this->Client->query("SELECT job_b_criteria FROM jsb_client AS Client WHERE id='$clientid'");
		$extra_cr=array();
		$added_cr=array();
		//echo '<pre>';print_r($criteria_exist);die;
		if(!empty($criteria_exist))
		{
			$added_cr=explode('|',$criteria_exist['0']['Client']['job_b_criteria']);
			$extra_cr=array();
			foreach($added_cr as $cr)
			{
				if(!in_array($cr,$criterias))
				{
					$extra_cr[]=$cr;
				}
			}
			unset($extra_cr[count($extra_cr) - 1]);
		}
		//echo '<pre>';print_r($extra_cr);die;
		$step=$this->findstep($clientid);
		$this->Session->write('Client.P_step',$step);
		$this->show_skip_button('3',$step);	
		$this->progressPercent($clientid);
		$this->set('extra_cr',$extra_cr);
		$this->set('added_cr',$added_cr);
		$this->set('clientid',$clientid);
		$this->set('criterias',$criterias);
		$this->render('profile_step3');		
	}
	
	public function profile_step3()
	{
		if($this->request->is('ajax'))
		{	
			if(!empty($this->data))
			{	
				if(isset($this->data['cl_id']))
				{
					$this->show_profile3($this->data['cl_id']);
				}else{
						$data_inp_cr=$this->data['Criteria'];
						$clientid=$this->data['clientid'];				
						$values=null;
						$data_check=array();
						if(isset($this->data['cr_check'])) 
						{
							$data_check=$this->data['cr_check']; 
							foreach($data_check as $check)
							{	$values.=$check.'|'; 
								}					
						}					
						foreach($data_inp_cr as $crit)
						{ 	if(!in_array($crit,$data_check))
								if(!empty($crit)){
									$values.=$crit.'|'; }
							}
						$d=date("Y-m-d H:i:s");
						$q="UPDATE jsb_client SET job_b_criteria='$values',job_pref_modified='$d' WHERE id='$clientid'";
						$this->Client->query($q);
						//$this->Client->id=$clientid;
						//$this->Client->saveField('job_b_criteria',$values);
						$this->show_profile4($clientid);
					}
			}
		}
	}
	
	public function show_profile4($clientid)
	{
		$this->layout='ajax';
		$this->Session->write('Client.profile_step','4');
		$var_education=array(1=>"In School Now","Elementary","High School","Vocational Education","Technical College","Undergraduate","Masters","Doctorate");	
		$var_degree_type=array(1=>"Grade 10","Grade 11","Grade 12","Vocational College Year 1","Vocational College Year 2","Vocation College Year 3","Technical College Year 1","Technical College Year 2","Technical College Year 3","Undergraduate year 1","Undergraduate Year 2","Undergraduate Year 3","Undergraduate Year 4","Masters Year 1","Masters Final Year","Doctorate ABD","Doctorate Final Year");
		$exist_data=$this->Client->query("SELECT highest_education,degree_type,degree_obtained,college,major,minor FROM jsb_client AS Client WHERE id='$clientid'");
		if(empty($exist_data))
		{
			$exist_data['0']['Client']=null;	
		}
		$university=$this->University->query("SELECT * FROM jsb_university as University ORDER BY name ASC");
		$majors=$this->Major->query("SELECT * FROM jsb_major as Major ORDER BY major ASC");
		$minors=$this->Minor->query("SELECT * FROM jsb_minor as Minor ORDER BY minor ASC");
		
		//$majors=sort($majors['Major']);
		//$minors=sort($minors['Minor']);
		//echo '<pre>';print_r($university);die;
		$step=$this->findstep($clientid);
		$this->Session->write('Client.P_step',$step);
		$this->show_skip_button('4',$step);	
		$this->progressPercent($clientid);
		$this->set('university',$university);
		$this->set('majors',$majors);
		$this->set('minors',$minors);
		$this->set('exist_data',$exist_data['0']['Client']);
		$this->set('clientid',$clientid);
		$this->set('var_education',$var_education);
		$this->set('var_degree_type',$var_degree_type);				
		$this->render('profile_step4');	
	}
	
	
	public function profile_step4()
	{
		if($this->request->is('ajax'))
		{	
			if(!empty($this->data))
			{	
				if(isset($this->data['cl_id']))
				{
					$this->show_profile4($this->data['cl_id']);
				
				}else{
					
					$clientid=$this->data['clientid'];
					$this->Client->id=$clientid;
					$this->Client->save($this->data);	
					$this->show_profile5($clientid);
				}
				
			}
		}
	}
	
	public function show_profile5($clientid)
	{
		$this->layout='ajax';
		$this->Session->write('Client.profile_step','5');
		$exist_data=$this->Client->query("SELECT gender,dob,country,state,city,postalcode FROM jsb_client AS Client WHERE id='$clientid'");
		if(empty($exist_data))
		{
			$exist_data['0']['Client']=null;
		}
		$var_gender=array("Female","Male");
		$countries=$this->Country->find('all');
		$US_states=$this->State->findAllByCountryCode('US');
		$CA_states=$this->State->findAllByCountryCode('CA');
		
		$step=$this->findstep($clientid);
		$this->Session->write('Client.P_step',$step);
		$this->show_skip_button('5',$step);	
		$this->progressPercent($clientid);
		$this->set('US_states',$US_states);
		$this->set('CA_states',$CA_states);
		$this->set('exist_data',$exist_data['0']['Client']);
		$this->set('clientid',$clientid);
		$this->set('var_gender',$var_gender);
		$this->set('countries',$countries);		
		$this->render('profile_step5');	
	}
	
	public function profile_step5()
	{
		if($this->request->is('ajax'))
		{	
			if(!empty($this->data))
			{	
				if(isset($this->data['cl_id']))
				{
					$this->show_profile5($this->data['cl_id']);
				
				}else{
					
					$clientid=$this->data['clientid'];
					$this->Client->id=$clientid;
					$this->Client->save($this->data);
					$this->show_profile6($clientid);	
				}
				
			}
		}
		
	}
	
	public function show_profile6($clientid)
	{
		$this->layout='ajax';
		$this->Session->write('Client.profile_step','6');
		$industries=$this->Industry->find('all');
		$var_position=$this->Position->find('all');
		$job_types=$this->Jobtype->find('all');
		$job_functions=$this->Jobfunction->find('all');
		$exist_data=$this->Client->query("SELECT industry,industry2,industry3,tposition,job_type,job_function FROM jsb_client AS Client WHERE id='$clientid'");
		if(empty($exist_data))
		{
			$exist_data['0']['Client']=null;
		}
		$step=$this->findstep($clientid);
		$this->Session->write('Client.P_step',$step);
		$this->show_skip_button('6',$step);	
		$this->progressPercent($clientid);
		$this->set('industries',$industries);
		$this->set('var_position',$var_position);
		$this->set('job_types',$job_types);
		$this->set('job_functions',$job_functions);
		$this->set('clientid',$clientid);
		$this->set('exist_data',$exist_data['0']['Client']);
		$this->render('profile_step6');			
	}
	
	public function profile_step6()
	{
		if($this->request->is('ajax'))
		{	
			if(!empty($this->data))
			{	
				if(isset($this->data['cl_id']))
				{
					$this->show_profile6($this->data['cl_id']);
				
				}else{
							
					$clientid=$this->data['clientid'];
					$this->Client->id=$clientid;
					$this->Client->save($this->data);
					$this->show_profile7($clientid);
				}
				
			}
		}
	}
	
	public function show_profile7($clientid)
	{
		$this->layout='ajax';
		$this->Session->write('Client.profile_step','7');
		$file=$this->Clientfile->findAllByClientId($clientid);
		$step=$this->findstep($clientid);
		$this->Session->write('Client.P_step',$step);
		$this->show_skip_button('7',$step);	
		$this->progressPercent($clientid);
		$this->set('clientid',$clientid);
		$this->set('file',count($file));
		$this->render('profile_step7');
					
	}
	
	public function profile_step7()
	{
		$clientid=$this->data['cl_id'];
		$this->show_profile7($clientid);			
	}
	
	public function show_file_upload()   /////////////////////////////////
	{	//$fileUpload="uploaded_files/";
		$clientid=$this->Session->read('Client.Client.id');
		
		if(!empty($this->data['TR_file']['tmp_name']))
		{			
			$folderpath=WWW_ROOT . 'files' . DS . $clientid;
			if(!is_dir($folderpath)) {
				$folder=mkdir($folderpath,0777);
				mkdir($folderpath,0777);
			}
			$fileUpload=WWW_ROOT . 'files' . DS . $clientid . DS ;
			$arr_img=explode(".",$this->data["TR_file"]["name"]);
			$ext=strtolower($arr_img[count($arr_img)-1]);
			if(($ext=="doc")||($ext=="docx")||($ext=="pdf")||($ext=="txt"))
			{
					$fname=removeSpecialChar($this->data['TR_file']['name']);
					$file = time()."_".$fname;
				if(upload_my_file($this->data['TR_file']['tmp_name'],$fileUpload.$file))
				{
					$filename=$this->data['TR_file']['name'];
					
					$data=array('client_id'=>$clientid,'file'=>$file,'filename'=>$filename,'shared'=>'N','last_modified'=>date("Y-m-d H:i:s"),'reg_date'=>date("Y-m-d H:i:s"));
					$this->Clientfile->create();
					$added_file=$this->Clientfile->save($data);
					//echo '<pre>';print_r($added_file['Clientfile']['id']);die;
					$file_hist_data=array('file_id'=>$added_file['Clientfile']['id'],'filename'=>$filename);
					$this->Clientfilehistory->create();
					$this->Clientfilehistory->save($file_hist_data);
					echo "success|File has been uploaded successfully";die();
				}	
			}
			else
			{
				echo "error|Only PDF/Doc/Docx/txt files are allowed.";die();
			}
		}

	}
		
	public function profile_file_list()
	{
		$clientid=$this->data['clientid'];
		$files=$this->Clientfile->query("SELECT id,filename,last_modified FROM jsb_client_files AS Client WHERE client_id='$clientid'");
		//echo '<pre>';print_r($files); die;
		 $i=1; 
		 foreach($files as $file) 
		 {
			echo "<div class='rowdd'>";
			echo "<div class='inputdd'>".$i.".</div>";
			echo "<label>".wraptext($file['Client']['filename'],30)."<br/>";
			echo "<span class='uploadeDatev'><strong>Uploaded Date : </strong>".show_formatted_date($file['Client']['last_modified']);
			echo "</span></label>";
			echo "</div>";
			$i++; 
		} 
		$this->set('files',$files);
		//echo '1';
		die;
		}	
	
	public function list_state()
	{	$country=$this->data['country'];
		if($country=='US')
		{	$state_st=$this->State->findAllByCountryCode('US');
			}else{
			$state_st=$this->State->findAllByCountryCode('CA');
			}			
			echo "<select name='data[Client][state]' id='tr_state' class='selectbox'>";
			echo "<option value='0'>Select State/Province</option>";
			foreach($state_st as $st)
			{ ?>
				<option value="<?php echo $st['State']['state'];?>"><?php echo $st['State']['state'];?></option>
             <?php    }
			echo "</select>";
			$this->autoRender=false;		
	}
	
	
	
	public function add_major_mail()
	{		
		$this->add_request_mail('Major',$this->data['name']);
		echo "A mail has been sent to admin for your request."; die;
	}
	public function add_minor_mail()
	{	
		$this->add_request_mail('Minor',$this->data['name']);
		echo "A mail has been sent to admin for your request."; die;
	}
	public function add_college_mail()
	{
		$this->add_request_mail('College',$this->data['name']);					
		echo "A mail has been sent to admin for your request."; die;
	}
	
	public function add_request_mail($type,$name)
	{
					$clientid=$this->Session->read('Client.Client.id');
					$client=$this->Client->findById($clientid);
					if($type=='Major'){
							$sub='Request for addition of new Major in Profile Wizard';
						}else if($type=='Minor'){
							$sub='Request for addition of new Minor in Profile Wizard';
					}else{
						$sub='Request for addition of new College in Profile Wizard';	
					}
					$ms=$type.': '.$name;
					
				  //send mail
					$email = new CakeEmail();
					$email->emailFormat('html')
						  ->from($client['Client']['email'])
						  ->to('support@snagpad.com')
					      ->subject($sub)
						  ->send($ms);
					return;	  
		
	}
		
	public function settings_details()
	{
		
		$this->layout='ajax';
		if($this->request->is('ajax'))
		{	if(!empty($this->data))
			{	
				$this->Client->id=$this->data['Client']['id'];
				$this->Client->save($this->data);
				$account_id=$this->Session->read('Account.id');
				$this->Account->id=$account_id;
				$this->Account->saveField('name',$this->data['Client']['name']);
				echo 'Details has been updated.|'.$this->data['Client']['name'];die;
				
			}
		}
				
	}
	
	public function settings($tab=null)
	{
		$this->layout='jsb_bg';
		$clientid=$this->Session->read('Client.Client.id');	
		
		$this->set('tab',$tab);
		$this->set('clientid',$clientid);
	}	
	
	public function show_mail_pref()
	{
		$this->layout='ajax';
		$clientid=$this->data['clientid'];
		$clientinfo=$this->Client->query("SELECT same_card_days,reminder_weekly_mail,reminder_mail FROM jsb_client as Client WHERE id='$clientid'");
		
		$this->set('client',$clientinfo['0']);
		$this->set('clientid',$clientid);	
		$this->render('mail_pref');
	}
	
	public function show_update_cred()
	{
		$this->layout='ajax';
		$clientid=$this->data['clientid'];
		$clientinfo=$this->Client->findById($clientid);
		//echo '<pre>';print_r($clientinfo);die;
		$this->set('client',$clientinfo);
		$this->set('clientid',$clientid);
		$this->render('show_settings');
			
	}
	
	public function add_mail_pref()
	{
		if(!empty($this->data))
		{	$data=$this->data;
			$this->Client->id=$data['clientid'];
			$check_days=0;
			if(isset($data['same_card_days']))
			{
			$check_days=1;	
			}
			$data['same_card_days']=$check_days;
			$this->Client->save($data);
			echo 'Mail preferences updated successfully.'; die;	
		}	
		
	}
	
	public function change_pass()
	{
		if($this->request->is('ajax'))
		{	if(!empty($this->data))
			{	
				$old_password=md5($this->data['Account']['old_password']);
				$clientid=$this->data['Client']['id'];
				$accnt_id=$this->Client->query("SELECT account_id FROM jsb_client AS Client WHERE id='".$clientid."'");
				$user=$this->Account->findById($accnt_id['0']['Client']['account_id']);
				if($user['Account']['password']!=$old_password)
				{
					echo 'Old password does not match! Please try again.';
					$this->autoRender=false;
					}
				else{
					$new_password=md5($this->data['Account']['new_password']);
					$this->Account->id=$user['Account']['id'];
					$this->Account->saveField('password',$new_password);
					echo 'Password has been updated';
					$this->autoRender=false;
					}
				}
	}		
		
	}
	
	public function autosuggest_jobtitle()
	{
		$data=$this->request->query;
		$input=$data['input'];
		$len = strlen($input);
		if($len)
		{
			$rows=$this->Jobfamily->query("select title from jsb_job_family as Jobfamily where UCASE(title) like UCASE('$input%')");
			foreach($rows as $job)
			$job_titles[]=$job['Jobfamily']['title'];
			for ($i=0;$i<count($job_titles);$i++)
			{
				if (strtolower(substr(utf8_decode($job_titles[$i]),0,$len)) == $input)
					$aResults[] = array( "id"=>($i+1) ,"value"=>addslashes(htmlspecialchars(utf8_encode($job_titles[$i]))), "info"=>"" );				
			}
		}	
		if (isset($_REQUEST['json']))
		{
			header("Content-Type: application/json");
			echo "{\"results\": [";
			$arr = array();
			for ($i=0;$i<count($aResults);$i++)
			{
				$arr[] = "{\"id\": \"".$aResults[$i]['id']."\", \"value\": \"".$aResults[$i]['value']."\", \"info\": \"\"}";	
			}
			echo implode(", ", $arr);
			echo "]}";
		}
		else
		{
			header("Content-Type: text/xml");
			echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
			for ($i=0;$i<count($aResults);$i++)
			{
				echo "<rs id=\"".$aResults[$i]['id']."\" info=\"\">".$aResults[$i]['value']."</rs>";
			}
			echo "</results>";
		}
		//echo '<pre>';print_r($rows);die;
		die;
	}
	

}