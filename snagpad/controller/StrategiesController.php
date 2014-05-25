<?php
App::import('Core','Validation');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor',array('linkedin','functions','xmltoarray','facebook'));
App::import('Controller', array('Message'));
//App::import('Vendor','uploadclass');

class StrategiesController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
    public $uses = array('Client','Skillslist','Account','Jobtype','Jobfunction','Clientfile','Clientfilehistory','Profiletooltip','Card','Carddetail','Opportunity','Country','Jobtype','Jobfunction','Industry','Position','Contact','Checklist','Config','Cardchecklist','Cardcolumn','Cardcolext');
	 public $API_CONFIG = array('appKey' => LINKEDIN_APP_KEY, 'appSecret' => LINKEDIN_APP_SECRET, 'callbackUrl' => NULL);

    public function beforeFilter() {
		if(!$this->Session->check('Account.id'))
			{
			$this->redirect(SITE_URL.'/users/session_expire');
			//$this->Session->setFlash(__('You are not authorized to acces that page. Please login to  continue.'));
			
			exit();
			}
		parent::beforeFilter();	
		$this->layout = 'cardinfo';
		if($this->Session->read('usertype')=='3')
			$this->set('disabled','');
		else
			$this->set('disabled','disabled');
    }
	
	public function checklist($card_id=null,$column=null,$client_id=null)
	{
			$this->layout='ajax';
			if(isset($this->data['card_id'])){
				$card_id=$this->data['card_id'];
			}
			if(isset($this->data['column']))
			{
				$column=$this->data['column'];
			}
			if($client_id==null)
				$client_id=$this->Session->read('Client.Client.id');
			$glob_column=array("O"=>"Opportunity","A"=>"Applied","S"=>"Set Interview","I"=>"Interview","V"=>"Verbal Job Offer","J"=>"Job");
			//echo $card_id;die;
			$card_info=$this->Card->findById($card_id);
			//print_r($card_info); die;
			$column_status=$card_info['Card']['column_status'];
			switch($column)
			{
				case 'O': $current_column='Opportunity Column';  
						  $newCol='A';
						  $c_col='O';
						  $col_name['name']="Opportunity Column Checklist"; 	
						  $col_name['title']='Strategies for the Opportunity Column';
						  $goal='Move Job Card to Applied Phase.';	
						  $move_button_text='Yes, I am ready to apply for the job';
						  $move_action='apply_job';
						  $i=1;
						  break;
				case 'A': $current_column='Applied Column'; 
						  $newCol='S';  
						 $c_col='A';
						  $col_name['name']="Applied Column Checklist"; 	
						  $col_name['title']='Strategies for the Applied Column';	
						   $goal='Get a date set for an interview.';
						   $move_button_text='Yes, I have set a date for an interview';
						  $move_action='set_interview';	
						    $i=2;
						  break;
				case 'S': $current_column='Set Interview Column'; 
							$newCol='I';
							$c_col='S';
							 $col_name['name']="Set Interview Checklist"; 	
						  $col_name['title']='Strategies for the Set Interview Column';	
						   $goal='Prepare for the interview.';
						    $move_button_text='Yes, I have attended the interview';
						   $move_action='interview';	
						   $i=3;
						  break;
				case 'I': $current_column='Interview Column'; 
							$newCol='V';
							$c_col='I';
							 $col_name['name']="Interview Checklist"; 	
						  $col_name['title']='Strategies for the Interview Column';	
						   $goal='Obtain a second interview or job offer.';	
						    $move_button_text='Yes, I got a job offer';
						   $move_action='verbal_job_offer';	
						   $i=4;
						  break;
				case 'V': $current_column='Verbal Job Offer Column'; 
							$newCol='J';
							$c_col='V';
							 $col_name['name']="Verbal Job Offer Checklist"; 	
						  $col_name['title']='Strategies for the Verbal Job Offer Column';	
						   $goal='Accept or decline this job offer.';	
						     $move_button_text='Yes, I accepted the job offer';
						   $move_action='job';	
						   $i=5;
						  break;
				case 'J': $current_column='Job Column'; 
							$newCol='C';
							$c_col='J';
							 $col_name['name']="Job Checklist"; 	
						  $col_name['title']='Strategies for the Job Column';	
						   $goal='Use SnagPad as your ongoing career management tool.';
						    $move_button_text='Yes, I accepted the job offer';
						   $move_action='job';		
						   $i=6;
						  break;
				
			}
			
			
			
			$column_name=$card_info['Card']['column_status'];
			$k=0;
			foreach($glob_column as $key=>$val)
			{
				if($key==$column_name)
					break;
				else
				$k++;
			}
					
				$this->description($col_name['name']);
				$sql="SELECT CH.*,CCH.status FROM jsb_checklist CH LEFT JOIN jsb_card_checklist CCH ON (CH.id=CCH.checklist_id AND CCH.card_id='".$card_id."') where CH.column='".$column."' ORDER BY CH.orderby";
				$checklists=$this->Checklist->query($sql); 
			
			//echo $current_column;echo '<br>';echo $column_name;die;
			$show_button=0;
			if($column==$column_name)
			{
				$show_button=1;	
			}
			
			
			//$client_id=$this->Session->read('Client.Client.id');			
			//echo '<pre>';print_r($checklists);die;
			$this->set('client_id',$client_id);
			$this->set('show_button',$show_button);
			$this->set('newCol',$newCol);
			$this->set('goal',$goal);
			$this->set('checklists',$checklists);
			$this->set('i',$i);
			$this->set('k',$k);
			$this->set('move_button_text',$move_button_text);
			$this->set('move_action',$move_action);
			$this->set('c_col',$c_col);
			$this->set('card_id',$card_id);
			$this->set('card',$card_info);
			$this->set('current_column',$current_column);		
			$this->render('strategy_index');	
			//$this->render('strat_content_data');
		
	}
	
	public function check_for_card_move()
	{
		$card_id=$this->data['card_id'];
		$col=$this->data['column'];
		$card=$this->Card->findById($card_id);
		$clientid=$this->Session->read('Client.Client.id');
		$prof_complete=$this->Client->findById($clientid);
		//echo '<pre>';print_r($prof_complete);die;
		if($card['Card']['job_type']=='A'){
			
			if($prof_complete['Client']['job_a_title']=='')
			{
				echo 'Error';die;
			}
			//die;
		}else if($card['Card']['job_type']=='B'){
			if($prof_complete['Client']['job_a_skills']==''&&$prof_complete['Client']['job_b_criteria']=='')
			{
				echo 'Error';die;
			}
			
		}
		switch($col)
		{
			case 'O':$newCol='A'; $newcol_val=2;  $check_val='10';
			break;	
			case 'A':$newCol='S'; $newcol_val=3;  $check_val='43';
			break;	
			case 'S':$newCol='I'; $newcol_val=4;  $check_val='18';
			break;	
			case 'I':$newCol='V'; $newcol_val=5;  $check_val='29';
			break;	
			case 'V':$newCol='J' ;$newcol_val=6;  $check_val='36';
			break;	
						
		}
		
		$card_detail_data=array('card_id'=>$card_id,'checklist_id'=>$check_val,'date_added'=>date("Y-m-d H:i;s"));
		$this->Cardchecklist->create();
		$this->Cardchecklist->save($card_detail_data);
		$flag=0;	
		
		switch($card['Card']['column_status'])
		{
			case 'O':$val=1;;
			break;	
			case 'A':$val=2;
			break;	
			case 'S':$val=3;
			break;	
			case 'I':$val=4;
			break;	
			case 'V':$val=5;
			break;	
			case 'J':$val=6;
			break;	
						
		}
		$check_id=$this->Checklist->findByColumn($col);
		$res=$this->Cardchecklist->findByCardIdAndChecklistId($card_id,$check_id['Checklist']['id']);
		if(!empty($res))
		{
			$flag=1;   // Checklist complete....move to next column
		}
		$card_already_move='0';	
		if($val>$newcol_val)
		{
			$card_already_move='1';	
		}	
		if(!empty($card['Card']['job_url']))
		{
			$job_url=1;	
		}else{ $job_url=0; }	
		$data=$flag.'|'.$col.'|'.$newCol.'|'.$card_already_move.'|'.$job_url;	
		echo $data;die;	
		
	}
	
	public function apply_job()
	{
		$this->layout='basic_Cardpopup';
		$card_id=$this->data['card_id'];
		$card=$this->Card->find('first',array('fields'=>array('column_status'),'conditions'=>array('Card.id'=>$card_id)));
		$clientid=$this->Session->read('Client.Client.id');
		$this->set('clientid',$clientid);
		$this->set('card_id',$card_id);
		$this->set('col',$card['Card']['column_status']);
		$this->render('show_apply');
	}
	
	public function set_interview()
	{
		$this->layout='basic_Cardpopup';
		$card_id=$this->data['card_id'];
		$card=$this->Card->find('first',array('fields'=>array('column_status'),'conditions'=>array('Card.id'=>$card_id)));
		$clientid=$this->Session->read('Client.Client.id');
		$this->set('card_id',$card_id);
		$this->set('clientid',$clientid);
		$this->set('col',$card['Card']['column_status']);
		$this->render('show_apply');
	}
	
	public function update_card_column()
	{
		$card_id=$this->data['card_id'];
		$status=$this->data['new_status'];
		$card=$this->Card->findById($card_id);
		switch($status)
		{
			case "A": $total_points=$card['Card']['total_points']+5.0; break;
			case "S": $total_points=20.0; break;
			case "I": $total_points=40.0; break;
			case "V": $total_points=85.0; break;
			case "J": $total_points=100.0; break;	
			
		}
		$data=array('column_status'=>$status,'total_points'=>$total_points,'latest_card_mov_date'=>date("Y-m-d H:i:s"));
		$this->Card->id=$card_id;
		$this->Card->save($data);
		
		$this->Client->id=$card['Card']['client_id'];
		$this->Client->saveField('latest_card_mov_date',date("Y-m-d H:i:s"));
		
		$sql="UPDATE jsb_card_detail SET column_status='".$status."' WHERE card_id='".$card_id."'";
		$this->Carddetail->query($sql);
		//$this->checklist($card_id);
		$pos=$this->get_card_row($card_id);
		
		echo $card_id.'|'.$status;die;
	}
	
	public function get_card_row($card_id=null)
	{
		$client_id=$this->Session->read('Client.Client.id');
		$all_cards=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$client_id,'recycle_bin'=>'0'),'order'=>array('Card.id DESC')));
		$pos=1;
		foreach($all_cards as $card){
			if($card_id==$card['Card']['id'])
			{
				break;
			}else{ $pos++; }
			
		}	
		return $card_id;
	}
	
	public function get_card_row_for_strat()
	{
		$card_id=$this->data['card_id'];
		$card_col=$this->Card->find('first',array('conditions'=>array('Card.id'=>$card_id),'fields'=>array('Card.column_status')));
		$pos=$this->get_card_row($card_id);
		echo $card_id.'|'.$card_col['Card']['column_status'];die;	
	}
	
	public function get_card_row_info()
	{
		$card_id=$this->data['card_id'];
		$pos=$this->get_card_row($card_id);
		echo $card_id;die;	
	}
	
	public function description($name)
	{
		$desc=$this->Config->findByName($name);
		$this->set('description',$desc);
		return;	
	}
	
	public function show_skill()
	{
		$this->layout='ajax';
		$checklist_id=$this->data['check_id'];
		$card_id=$this->data['card_id'];
		
		switch($checklist_id)
		{
			case '1': 
				$this->select_jobtype($card_id);
			break;	
			case '2': $this->select_skill_level($card_id);
			break;	
			case '3': $this->select_source_of_job($card_id);
			break;	
			case '4': $this->find_referral($card_id);  /////
			break;
			case '5': $this->select_industry($card_id);
			break;	
			case '6': $this->contact_employer($card_id);
			break;	
			case '7': $this->hiring_cycle($card_id);
			break;
			case '8': $this->resume($card_id);		
			break;	
			case '9': $this->cover_letter($card_id);		
			break;	
			case '42': $this->set_interview_date($card_id);
			break;	
			case '11': $this->research_org($card_id);
			break;	
			case '12': $this->study_network($card_id);  //////
			break;	
			case '13': $this->risk_factor($card_id);
			break;	
			case '14': $this->interview_agenda($card_id);
			break;	
			case '15': $this->salary($card_id);
			break;	
			case '16': $this->wear($card_id);
			break;	
			case '17': $this->interview_location($card_id); 
			break;
			case '19': $this->reporter_name($card_id);
			break;
			case '20': $this->process_understand($card_id);
			break;
			case '21': $this->job_fitness($card_id);
			break;
			case '22': $this->job_expectation($card_id);
			break;
			case '23': $this->job_promotion($card_id);
			break;
			case '24': $this->reminder_date($card_id);
			break;
			case '25': $this->hiring_time_frame($card_id);
			break;
			case '26': $this->review_question($card_id);
			break;
			case '27': $this->permission_followup($card_id);
			break;
			case '28': $this->ask_job($card_id);
			break;
			case '30': $this->evl_salary($card_id);
			break;
			case '31': $this->desired_start_date($card_id);
			break;
			case '32': $this->expected_response($card_id);
			break;
			case '33': $this->job_type_verify($card_id);
			break;
			case '34': $this->prof_dev_op($card_id);
			break;
			case '35': $this->determine_job($card_id);
			break;
			case '37': $this->job_expectation_manager($card_id);
			break;
			case '38': $this->key_individual($card_id);
			break;
			case '39': $this->co_worker($card_id);
			break;
			case '40': $this->goal($card_id);
			break;
			case '41': $this->top_social_networker($card_id);
			break;
			
			
			
		}	
		
		
		
	}
	
	public function select_jobtype($card_id)
	{
	$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('job_type');
		$card=$this->getCard_details($card_id);
		$skills=array();
		$criteria=array();
		//$clientid=$this->Session->read('Client.Client.id');
		$clientid=$card['Card']['client_id'];
		$client_data=$this->Client->findById($clientid);
		$skill_exist['text']=explode('|',$client_data['Client']['job_a_skills']);
		$skill_exist['val']=explode('|',$client_data['Client']['job_a_values']);
		unset($skill_exist['text'][count($skill_exist['text']) - 1]);
		unset($skill_exist['val'][count($skill_exist['val']) - 1]);
		//echo '<pre>';print_r($skill_exist);die;
		$arr=array();
		
		if(!empty($skill_exist['val']))
		{
			foreach($skill_exist['text'] as $key=>$index)
			{
				foreach($skill_exist['val'] as $key1=>$ind_val)
				{
					if($key1==$key)
					{	$arr[$key]['text']=$index;
						$arr[$key]['val']=$ind_val;
					}
				}
			}
		}else{
			foreach($skill_exist['text'] as $key=>$index)
			{
				$arr[$key]['text']=$index;
				$arr[$key]['val']=0;
			}
		}
		
		//echo '<pre>';print_r($arr);die;
		
		$criteria=explode('|',$client_data['Client']['job_b_criteria']);		
		unset($criteria[count($criteria) - 1]);
		
		$exist_skills=explode('|',$card['Card']['job_a_skills']);
		$exist_criteria=explode('|',$card['Card']['job_b_criteria']);
		
		$this->set('exist_skills',$exist_skills);
		$this->set('exist_criteria',$exist_criteria);
		$this->set('skills',$arr);
		$this->set('criteria',$criteria);
		$this->set('flag','1');
		$this->set('job_a',$client_data['Client']['job_a_title']);
		$this->set('card',$card);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->render('show_jobtype');	
		
	}
	
	public function select_skill_level($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('skills_assessment');
		$card_detail=$this->getCard_column_details($card_id);
		
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('slider_val',$card_detail['Cardcolumn']['skills_assessment']);
		$this->set('field','skills_assessment');
		$this->set('action','save_skill_level');
		$this->set('min','1');
		$this->set('max','5');
		$this->set('inc','1');
		
		$this->set('card_id',$card_id);
		$this->render('show_slider');	
	}
	
	public function select_source_of_job($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('type_of_opportunity');
		$card=$this->getCard_details($card_id);
		$opportunity=$this->Opportunity->find('all',array('order'=>array('Opportunity.id ASC')));
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('opportunity',$opportunity);
		$this->set('card_id',$card_id);
		$this->render('show_source_of_job');
			
	}
	
	public function find_referral($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('referrals');
		$card=$this->getCard_details($card_id);
		$client=$this->Client->find('first',array('conditions'=>array('Client.id'=>$card['Card']['client_id']),'fields'=>array('Client.linkedin_id')));
		if(empty($client['Client']['linkedin_id']))
		{
			$this->set('no_connect','1');	
		}
		$company=$card['Card']['company_name'];
		if($this->Session->read('Client.Client.profile_id')!=''){
			$facebook = new Facebook(array('appId'  =>FB_APPID,'secret' => FB_APPSECRET,'cookie' => true));
			$words=explode(" ",$company);
			$newwords=array();
			foreach($words as $word)
				if(trim($word)==$word)
					$newwords[]=strtolower($word);
			$words=$newwords;		   
			$facebook->setAccessToken($this->Session->read('fb_token'));
			
			$fql = "SELECT uid,name,work,has_added_app FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='".$this->Session->read('Client.Client.profile_id')."')"; 
							$friends = $facebook->api(array('method' => 'fql.query','query' => $fql));
			if(is_array($friends) && count($friends)>0)
			{
			if(!isset($friends['error_code'])){
				$matched=array();
				foreach($friends as $friend)
				{
					$match=0;
					if(count($friend['work'])>0)
					{
						foreach($friend['work'] as $work)
						{
							$f_company=explode(" ",$work['employer']['name']);
							$f_words=array();
							foreach($f_company as $word)
								if(trim($word)==$word)
									$f_words[]=strtolower($word);
							foreach($f_words as $f_word)
							if(in_array($f_word,$words))
							{
								$match=1;
								break;
							}
						}	
					if($match==1)
						$matched[]=$friend;
			
					}
				}
			
				if(count($matched)>0)
					$this->set('fb_friends',$matched);
			}
			}
			
			
		}
		$company=urlencode($card['Card']['company_name']);
		$OBJ_linkedin = new LinkedIn($this->API_CONFIG);
        $OBJ_linkedin->setTokenAccess($this->Session->read('Client.linkedin.access'));
        $this->autoRender = false;
		        $response = $OBJ_linkedin->profile('~:(id,first-name,last-name,headline,email-address,picture-url,publicProfileUrl)');         
       $search_response = $OBJ_linkedin->searchPeople(":(people:(id,first-name,last-name,picture-url,site-standard-profile-request,headline),num-results)?company-name=$company&count=60&facet=network,R");
	   
	   	$arr=xml2array($search_response['linkedin']);
		//echo '<pre>';print_r($arr);die;
		if(isset($arr['people-search']['people']['person']))
		{ $f_num=1; }else{ $f_num=0; }
		$this->set('friends',$arr['people-search']);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('flag',$f_num);
		$this->set('card_id',$card_id);
		$this->render('show_network_connection');
	}
	
	public function study_network($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('study_network');
		$card=$this->getCard_details($card_id);
		$client=$this->Client->find('first',array('conditions'=>array('Client.id'=>$card['Card']['client_id']),'fields'=>array('Client.linkedin_id')));
		if(empty($client['Client']['linkedin_id']))
		{
			$this->set('no_connect','1');	
		}
		$company=$card['Card']['company_name'];
		if($this->Session->read('Client.Client.profile_id')!=''){
			$facebook = new Facebook(array('appId'  =>FB_APPID,'secret' => FB_APPSECRET,'cookie' => true));
			$words=explode(" ",$company);
			$newwords=array();
			foreach($words as $word)
				if(trim($word)==$word)
					$newwords[]=strtolower($word);
			$words=$newwords;		   
			$facebook->setAccessToken($this->Session->read('fb_token'));
			
			$fql = "SELECT uid,name,work,has_added_app FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='".$this->Session->read('Client.Client.profile_id')."')"; 
							$friends = $facebook->api(array('method' => 'fql.query','query' => $fql));
			if(is_array($friends) && count($friends)>0)
			{
			if(!isset($friends['error_code'])){
				$matched=array();
				foreach($friends as $friend)
				{
					$match=0;
					if(count($friend['work'])>0)
					{
						foreach($friend['work'] as $work)
						{
							$f_company=explode(" ",$work['employer']['name']);
							$f_words=array();
							foreach($f_company as $word)
								if(trim($word)==$word)
									$f_words[]=strtolower($word);
							foreach($f_words as $f_word)
							if(in_array($f_word,$words))
							{
								$match=1;
								break;
							}
						}	
					if($match==1)
						$matched[]=$friend;
			
					}
				}
			
				if(count($matched)>0)
					$this->set('fb_friends',$matched);
			}
			}
			
			
		}
		$company=urlencode($card['Card']['company_name']);
		$OBJ_linkedin = new LinkedIn($this->API_CONFIG);
        $OBJ_linkedin->setTokenAccess($this->Session->read('Client.linkedin.access'));
        $this->autoRender = false;
		        $response = $OBJ_linkedin->profile('~:(id,first-name,last-name,headline,email-address,picture-url,publicProfileUrl)');         
       $search_response = $OBJ_linkedin->searchPeople(":(people:(id,first-name,last-name,picture-url,site-standard-profile-request,headline),num-results)?company-name=$company&count=30&facet=network,R");
	   
	   	$arr=xml2array($search_response['linkedin']);
		if(!empty($arr['people-search']))
		{ $f_num=1; }else{ $f_num=0; }
		$this->set('flag',$f_num);
		$this->set('friends',$arr['people-search']);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->render('show_network_connection');
	}
	
	
	
	public function select_industry($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('industry');
		$industry=$this->Industry->find('all',array('order'=>array('Industry.id ASC')));
		$card=$this->getCard_details($card_id);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('industry',$industry);
		$this->set('card_id',$card_id);
		$this->render('show_industry');
			
	}
	
	public function contact_employer($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('employer');
		$card=$this->Card->find('first',array('fields'=>array('company_name'),'conditions'=>array('Card.id'=>$card_id)));
		//$company=);
		
		$url='http://www.google.com/search?q='.urlencode($card['Card']['company_name']);
		$this->set('submit_button_text','Contact the Employer in Google');
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('url',$url);
		$this->set('action','save_contact_employer');
		$this->set('card_id',$card_id);
		$this->render('show_contact_employer');
	}
	
	public function hiring_cycle($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('job_first_posted_date');
		$card=$this->Card->find('first',array('fields'=>array('reg_date'),'conditions'=>array('Card.id'=>$card_id)));
		$card_detail=$this->getCard_column_details($card_id);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('card',$card);
		$this->render('show_hiring_cycle');
	}
	
	public function resume($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('resume');
		$clientid=$this->Session->read('Client.Client.id');	
		$this->set('check',$check);
		$this->set('field','resume');
		$this->set('action','save_resume');
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('clientid',$clientid);
		$this->set('card_id',$card_id);
		$this->render('show_file');
	}
	
	public function cover_letter($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('cover_letter');
		$clientid=$this->Session->read('Client.Client.id');	
		$this->set('check',$check);
		$this->set('field','cover_letter');
		$this->set('action','save_cover_letter');
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('clientid',$clientid);
		$this->set('card_id',$card_id);
		$this->render('show_file');
	}
	
	public function set_interview_date($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('interview');	
		$card=$this->getCard_details($card_id);
		$time_val=$card['Card']['interview_time'];	
		//echo $time_val;die;
		if(!empty($time_val)&&$time_val!='NULL'){
				$t_temp=explode(':',$time_val);
				$t_temp_min=explode(' ',$t_temp[1]);
				$this->set('hour',$t_temp[0]);
				$this->set('min',$t_temp_min[0]);
				$this->set('merid',$t_temp_min[1]);
				
			}
		$this->set('time_val',$time_val);	
		
		$this->set('date_val',date('m-d-Y',strtotime($card['Card']['interview_date'])));
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->render('show_set_interview_date');
	}
	
	public function research_org($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('research_x');	
		$card=$this->Card->find('first',array('fields'=>array('company_name'),'conditions'=>array('Card.id'=>$card_id)));
			
		$url='http://www.google.com/search?q='.urlencode($card['Card']['company_name']);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('submit_button_text','Research the Organization in Google');
		$this->set('url',$url);
		$this->set('action','save_research_org');
		$this->set('card_id',$card_id);
		$this->render('show_contact_employer');
	}
	
	public function risk_factor($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('risk_factor');	
		$card_detail=$this->getCard_column_details($card_id);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','risk_factor');
		$this->set('caption','Risk Factor');
		$this->set('error','Risk Factor');
		$this->set('action','save_risk_factor');
		$this->set('flag','1');
		$this->render('show_textarea_type');
	}
	
	public function interview_agenda($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('interview_agenda');	
		$card_detail=$this->getCard_column_details($card_id);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','interview_agenda');
		$this->set('caption','Information required to determine if this is the right job');
		$this->set('error','Interview Agenda');
		$this->set('action','save_interview_agenda');
		$this->set('flag','2');
		$this->render('show_textarea_type');
	}
	
	public function salary($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('salary');	
		$card=$this->getCard_details($card_id);
		$this->set("popTitle",$check['Checklist']['title']);
		$downloadButton='Research salary range';
		$url='http://www.salary.com/category/salary/';
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','salary');
		$this->set('caption','I know the average salary');
		$this->set('action','save_salary');
		$this->set('downloadButton','Research salary range');
		$this->set('url',$url);
		$this->set('flag','1');
		$this->render('show_textbox_type');	
	}
	
	public function wear($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('wear');	
		$path=$this->webroot.'files/admin/Dress for Success 1.1.doc';
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('action','save_wear');
		$this->set('action_button_text','DOWNLOAD PDF');
		$this->set('flag','1');
		$this->set('card_id',$card_id);
		$this->set('path',$path);
		$this->render('show_download');	
		
	}
	
	public function interview_location($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('interview_location');	
		$card_detail=$this->getCard_column_details($card_id);
		$interview_loc=explode('||',$card_detail['Cardcolumn']['interview_location']);
		$this->set('int_location',$interview_loc);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->render('show_map');	
	}
	
	public function reporter_name($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('reporter_name');	
		$card_detail=$this->getCard_column_details($card_id);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','reporter_name');
		$this->set('caption','Reporter details');
		$this->set('flag','2');
		$this->set('action','save_reporter_name');
		$this->render('show_textbox_type');			
	}
	
	public function process_understand($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('process_understand');	
		$card_detail=$this->getCard_column_details($card_id);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','process_understand');
		$this->set('caption',' Indicate the number and type of interviews that will be required for this position. Will there be a follow-up interview, panel, written test, etc.?');
		$this->set('action','save_process_understand');
		$this->set('flag','3');
		$this->set('error','Process Understand Details');
		$this->render('show_textarea_type');
	}
	
	public function job_fitness($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('job_fitness');
		$card_detail=$this->getCard_column_details($card_id);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('slider_val',$card_detail['Cardcolumn']['job_fitness']);
		$this->set('check',$check);
		$this->set('field','job_fitness');
		$this->set('action','save_job_fitness');
		$this->set('min','1');
		$this->set('max','5');
		$this->set('inc','1');
		$this->set('card_id',$card_id);
		$this->render('show_slider');	
	}
	
	public function job_expectation($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('job_expectation_1|job_expectation_2|job_expectation_3');	
		$values_text=$this->getCard_textbox_values($card_id,$check['Checklist']['id']);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','job_expectation');
		$this->set('caption','Job Expectation');
		$this->set('flag','3');
		$this->set('action','save_job_expectation');
		$this->render('show_textbox_type');		
	}
	
	public function job_promotion($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('job_promotion');	
		$card_detail=$this->getCard_column_details($card_id);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','job_promotion');
		$this->set('caption','List the greatest opportunity for a job promotion and how long it will take for you to be eligible.');
		$this->set('action','save_job_promotion');
		$this->set('error','Opportunity for Job Promotion');
		$this->set('flag','4');
		$this->render('show_textarea_type');
		
	}
	
	public function reminder_date($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('reminder_date');	
		$card_detail=$this->getCard_column_details($card_id);
		$this->set('date_val',$card_detail['Cardcolumn']['reminder_date']);
		$this->set("popTitle",$check['Checklist']['title']);	
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','reminder_date');
		$this->set('flag','1');
		$this->set('action','save_reminder_date');
		$this->render('show_calender_date');
	}
	
	public function hiring_time_frame($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('expected_date_of_employer_decision');	
		$card_detail=$this->getCard_column_details($card_id);
		$this->set('date_val',$card_detail['Cardcolumn']['expected_date_of_employer_decision']);
		$this->set("popTitle",$check['Checklist']['title']);	
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','expected_date_of_employer_decision');
		$this->set('flag','2');
		$this->set('action','save_hiring_time_frame');
		$this->render('show_calender_date');
	}
	
	public function review_question($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('review_question');	
		$this->set("popTitle",$check['Checklist']['title']);	
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->render('show_review_question');
	}
	
	public function permission_followup($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('permission_followup');
		$card_info=$this->Cardcolumn->find('first',array('fields'=>array('expected_date_of_employer_decision'),'conditions'=>array('Cardcolumn.card_id'=>$card_id)));	
		$card_detail=$this->getCard_column_details($card_id);
		$this->set('date_val',$card_detail['Cardcolumn']['permission_followup']);
		$this->set("popTitle",$check['Checklist']['title']);	
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','permission_followup');
		$this->set('saved_data',$card_info['Cardcolumn']['expected_date_of_employer_decision']);
		
		$this->set('flag','3');
		$this->set('action','save_permission_followup');
		$this->render('show_calender_date');
	}
	
	public function ask_job($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('ask_job');
		$card_detail=$this->getCard_column_details($card_id);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('slider_val',$card_detail['Cardcolumn']['ask_job']);
		$this->set('check',$check);
		$this->set('field','ask_job');
		$this->set('action','save_ask_job');
		$this->set('min','0');
		$this->set('max','100');
		$this->set('inc','10');
		$this->set('card_id',$card_id);
		$this->render('show_slider');
	}
	
	public function evl_salary($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('evl_salary');
		$card_detail=$this->getCard_column_details($card_id);	
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','evl_salary');
		$this->set('caption','Evaluate Salary');
		$this->set('flag','4');
		$this->set('action','save_evl_salary');
		$this->render('show_textbox_type');		
	}
	
	public function desired_start_date($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('desired_start_date');
		$card_detail=$this->getCard_column_details($card_id);
		$this->set('date_val',$card_detail['Cardcolumn']['desired_start_date']);
		$this->set("popTitle",$check['Checklist']['title']);	
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','desired_start_date');
			
		$this->set('flag','4');
		$this->set('action','save_desired_start_date');
		$this->render('show_calender_date');
	}
	
	public function expected_response($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('expected_response');
		$card_detail=$this->getCard_column_details($card_id);
		$this->set('date_val',$card_detail['Cardcolumn']['expected_response']);
		$this->set("popTitle",$check['Checklist']['title']);	
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','expected_response');
			
		$this->set('flag','5');
		$this->set('action','save_expected_response');
		$this->render('show_calender_date');
	}
	
	public function job_type_verify($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('job_type_verify');
		$card=$this->getCard_details($card_id);
		$skills=array();
		$criteria=array();
		//$clientid=$this->Session->read('Client.Client.id');
		$clientid=$card['Card']['client_id'];
		$client_data=$this->Client->findById($clientid);
		$skill_exist['text']=explode('|',$client_data['Client']['job_a_skills']);
		$skill_exist['val']=explode('|',$client_data['Client']['job_a_values']);
		unset($skill_exist['text'][count($skill_exist['text']) - 1]);
		unset($skill_exist['val'][count($skill_exist['val']) - 1]);
		//echo '<pre>';print_r($skill_exist);die;
		$arr=array();
		
		if(!empty($skill_exist['val']))
		{
			foreach($skill_exist['text'] as $key=>$index)
			{
				foreach($skill_exist['val'] as $key1=>$ind_val)
				{
					if($key1==$key)
					{	$arr[$key]['text']=$index;
						$arr[$key]['val']=$ind_val;
					}
				}
			}
		}else{
			foreach($skill_exist['text'] as $key=>$index)
			{
				$arr[$key]['text']=$index;
				$arr[$key]['val']=0;
			}
		}
		
		//echo '<pre>';print_r($arr);die;
		
		$criteria=explode('|',$client_data['Client']['job_b_criteria']);		
		unset($criteria[count($criteria) - 1]);
		
		$exist_skills=explode('|',$card['Card']['job_a_skills']);
		$exist_criteria=explode('|',$card['Card']['job_b_criteria']);
		
		$this->set('exist_skills',$exist_skills);
		$this->set('exist_criteria',$exist_criteria);
		$this->set('skills',$arr);
		$this->set('criteria',$criteria);
		$this->set('job_a',$client_data['Client']['job_a_title']);
		$this->set('card',$card);
		$this->set('flag','2');
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->render('show_jobtype');	
		
	}
	
	public function prof_dev_op($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('professional_development_opportunity_1|professional_development_opportunity_2|professional_development_opportunity_3');	
		$values_text=$this->getCard_textbox_values($card_id,$check['Checklist']['id']);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','professional_developement');
		$this->set('caption','List the top 3 professional development opportunities you have identified.');
		$this->set('flag','5');
		$this->set('action','save_prof_dev_op');
		$this->render('show_textbox_type');		
		
	}
	
	public function determine_job($card_id)
	{
		$check=$this->Checklist->findByCField('determine_job');
		$this->entry_in_cardchecklist($card_id,$check['Checklist']['id']);
		//$this->checklist($card_id);
		//die;
	}
	
	public function job_expectation_manager($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('job_expectation_with_manager_1|job_expectation_with_manager_2|job_expectation_with_manager_3');	
		$values_text=$this->getCard_textbox_values($card_id,$check['Checklist']['id']);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','job_expectation_manager');
		$this->set('caption','List the top 3 expectations with the manager for this position.');
		$this->set('flag','3');
		$this->set('action','save_job_expectation');
		$this->render('show_textbox_type');	
			
	}
	public function key_individual($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('key_individual_1|key_individual_2|key_individual_3');	
		$values_text=$this->getCard_textbox_values($card_id,$check['Checklist']['id']);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','key_individual');
		$this->set('caption','List the top 3 individuals in the organization.');
		$this->set('flag','6');
		$this->set('action','save_key_individual');
		$this->render('show_textbox_type');	
			
	}
	
	public function co_worker($card_id)
	{
		
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('co_worker_1|co_worker_2|co_worker_3');	
		$values_text=$this->getCard_textbox_values($card_id,$check['Checklist']['id']);
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','key_individual');
		$this->set('caption','3 Coworkers that I have introduced myself to');
		$this->set('flag','7');
		$this->set('action','save_co_worker');
		$this->render('show_textbox_type');	
	}
	
	public function goal($card_id)
	{
		
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('goal_1|goal_2|goal_3');
		$values_text=$this->getCard_textbox_values($card_id,$check['Checklist']['id']);	
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('card_id',$card_id);
		$this->set('field','key_individual');
		$this->set('caption','Congratulations on your new job! Although this is a result of your hard work, it does not stop here, regardless of whether it is your Job A or Job B. In order to keep moving forward with your career, it is important to set goals. In the fields provided below, set three goals for 30, 60 and 90 days from now. An email will be sent out to ask you if you have accomplished each of the goals.');
		$this->set('flag','8');
		$this->set('action','save_goal');
		$this->render('show_textbox_type');	
	}
	
	public function top_social_networker($card_id)
	{
		$this->layout='basic_Cardpopup';
		$check=$this->Checklist->findByCField('top_social_networker');	
		$path=SITE_URL.'/info/online_training';
		$this->set("popTitle",$check['Checklist']['title']);
		$this->set('check',$check);
		$this->set('action','save_top_social_networker');
		$this->set('action_button_text','I want to become a Top Social Networker');
		$this->set('flag','2');
		$this->set('card_id',$card_id);
		$this->set('path',$path);
		$this->render('show_download');	
	}
	
	public function save_points($card_id,$check_id)
	{
		$check_points=$this->Checklist->find('first',array('fields'=>array('Checklist.points'),'conditions'=>array('Checklist.id'=>$check_id)));
		$already=$this->Cardchecklist->find('first',array('conditions'=>array('Cardchecklist.card_id'=>$card_id,'Cardchecklist.checklist_id'=>$check_id)));
		
		//echo '<pre>';print_r($already);die;
		if(empty($already))
		{
		$all_points=$this->Card->find('first',array('fields'=>array('Card.total_points'),'conditions'=>array('Card.id'=>$card_id)));
			if($all_points['Card']['total_points']!='100.00')
			{
				$points=$all_points['Card']['total_points']+$check_points['Checklist']['points'];
				//echo $points;die;
				$this->Card->id=$card_id;
				$this->Card->saveField('total_points',$points);	
			}
		}
		return;
	}
	
	
	public function save_jobtype()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$data=array();
		
		
		$data['Card']['job_a_skills']=null;
		$data['Card']['job_b_criteria']=null;
		$data['Card']['job_type']='A';
		if($this->data['cbox']=='B')
		{
			$data['Card']['job_type']='B';	
		}
		//print_r($this->data); die;
		if(isset($this->data['skbox']))
		{
			$skills=$this->data['skbox'];
			foreach($skills as $sk)
			{
				$data['Card']['job_a_skills'].=$sk.'|';
			}
			
		}
		if(isset($this->data['crbox']))
		{
			$criteria=$this->data['crbox'];
			foreach($criteria as $cr)
			{
				$data['Card']['job_b_criteria'].=$cr.'|';
			}
		}
		//$data['Card']['column_status']=='A';
		$this->Card->id=$card_id;
		$this->Card->save($data);
		
		$this->entry_in_cardchecklist($card_id,$check_id);
		
					
	}
	
	public function save_skill_level()
	{
		//print_r($this->data);die;
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		//$data=array('card_id'=>$card_id,=>);
		$sql="UPDATE jsb_card_column_detail SET skills_assessment='".$this->data['skills_assessment']."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
		
	}
	
	public function save_source_of_job()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$this->Card->id=$card_id;
		$this->Card->saveField('type_of_opportunity',$this->data['type_of_op']);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_industry()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$this->Card->id=$card_id;
		$this->Card->saveField('industry',$this->data['industry']);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_contact_employer()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_hiringcycle()
	{
		//print_r($this->data);die;
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		
		$sql="UPDATE jsb_card_column_detail SET job_first_posted_date='".date('Y-m-d',strtotime(str_replace('-', '/', $this->data['Cardcolumn']['job_first_posted_date'])))."',employee_start_date='".date('Y-m-d',strtotime(str_replace('-', '/', $this->data['Cardcolumn']['employee_start_date'])))."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_resume()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$sql="UPDATE jsb_card SET resume='".$this->data['resume']."' WHERE id='".$card_id."'";
		$this->Card->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
		
	}
	
	public function save_cover_letter()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$sql="UPDATE jsb_card SET cover_letter='".$this->data['cover_letter']."' WHERE id='".$card_id."'";
		$this->Card->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
		
	}
	
	public function save_set_interview_date()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$dat = str_replace('-', '/', $this->data['interview_date']);
		$int_time=$this->data['Card']['interview_time_hour']['hour'].':'.$this->data['Card']['interview_time_minute']['min'].' '.$this->data['Card']['interview_time_meridian']['meridian'];
		//print_r($int_time);die;
		$data=array('interview_date'=>date('Y-m-d',strtotime($dat)),'interview_time'=>$int_time,'interview_type'=>$this->data['interview_type']);
		$this->Card->id=$card_id;
		$this->Card->save($data);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
		
	}
	
	public function save_research_org()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_risk_factor()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$data=addslashes($this->data['risk_factor']);
		$sql="UPDATE jsb_card_column_detail SET risk_factor='".$data."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_interview_agenda()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$data=addslashes($this->data['interview_agenda']);
		$sql="UPDATE jsb_card_column_detail SET interview_agenda='".$data."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_salary()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$this->Card->id=$card_id;
		$this->Card->saveField('salary',$this->data['salary']);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_wear()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_interview_location()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$sql="UPDATE jsb_card_column_detail SET interview_location='".$this->data['interview_location']."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
		
	}
	
	public function save_reporter_name()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$sql="UPDATE jsb_card_column_detail SET reporter_name='".$this->data['reporter_name']."',reporter_title='".$this->data['reporter_title']."',email='".$this->data['email']."',phone_no='".$this->data['phone_no']."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		
		$account_id=$this->Session->read('Account.id');
		$contact_data=array('account_id'=>$account_id,'contact_name'=>$this->data['reporter_name'],'email'=>$this->data['email'],'phone'=>$this->data['phone_no'],'title'=>$this->data['reporter_title'],'date_added'=>date("Y-m-d H:i:s"));
		$this->Contact->create();
		$this->Contact->save($contact_data);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_process_understand()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$data=addslashes($this->data['process_understand']);
		$sql="UPDATE jsb_card_column_detail SET process_understand='".$data."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_job_fitness()
	{
		//print_r($this->data);die;
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		//$data=array('card_id'=>$card_id,=>);
		$sql="UPDATE jsb_card_column_detail SET job_fitness='".$this->data['job_fitness']."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
		
	}
	
	public function save_job_expectation()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$job_e=$this->data['job_e'];
		$this->delete_entry_textbox($card_id,$check_id);
		foreach($job_e as $job)
		{
			if(!empty($job))
			{
				$data=array('card_id'=>$card_id,'checklist_id'=>$check_id,'text_value'=>$job);
				$this->Cardcolext->create();
				$this->	Cardcolext->save($data);
			}
		}
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_job_promotion()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$data=addslashes($this->data['job_promotion']);
		$sql="UPDATE jsb_card_column_detail SET job_promotion='".$data."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
		
	}
	
	public function save_reminder_date()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$sql="UPDATE jsb_card_column_detail SET reminder_date='".date('Y-m-d',strtotime(str_replace('-', '/',$this->data['reminder_date'])))."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_hiring_time_frame()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$sql="UPDATE jsb_card_column_detail SET expected_date_of_employer_decision='".date('Y-m-d',strtotime(str_replace('-', '/', $this->data['expected_date_of_employer_decision'])))."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_review_question()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_permission_followup()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$sql="UPDATE jsb_card_column_detail SET permission_followup='".date('Y-m-d',strtotime(str_replace('-', '/', $this->data['permission_followup'])))."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_ask_job()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$sql="UPDATE jsb_card_column_detail SET ask_job='".$this->data['ask_job']."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_evl_salary()
	{
		//print_r($this->data);die;
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$benefits='No';
		$benefit_data='';
		if($this->data['benefits']=='Yes')
		{
			$benefits='Yes';	
			$benefit_data=$this->data['benefit_details'];
		}
		
		
		$sql="UPDATE jsb_card_column_detail SET salary_offered='".$this->data['salary_offered']."',benefit_details='".$benefit_data."',vacation_time='".$this->data['vacation_time']."',benefits='".$benefits."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_desired_start_date()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$sql="UPDATE jsb_card_column_detail SET desired_start_date='".date('Y-m-d',strtotime(str_replace('-', '/', $this->data['desired_start_date'])))."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
	
		
	}
	public function save_expected_response()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$sql="UPDATE jsb_card_column_detail SET expected_response='".date('Y-m-d',strtotime(str_replace('-', '/', $this->data['expected_response'])))."' WHERE card_id='".$card_id."'";
		$this->Cardcolumn->query($sql);
		$this->entry_in_cardchecklist($card_id,$check_id);
		
		
	}
	
	public function save_prof_dev_op()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$prof_dev_op=$this->data['pdo'];
		$this->delete_entry_textbox($card_id,$check_id);
		foreach($prof_dev_op as $pdo)
		{
			if(!empty($pdo))
			{
				$data=array('card_id'=>$card_id,'checklist_id'=>$check_id,'text_value'=>$pdo);
				$this->Cardcolext->create();
				$this->	Cardcolext->save($data);
			}
		}
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_key_individual()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$key_i=$this->data['key'];
		$this->delete_entry_textbox($card_id,$check_id);
		foreach($key_i as $key)
		{
			if(!empty($key))
			{
				$data=array('card_id'=>$card_id,'checklist_id'=>$check_id,'text_value'=>$key);
				$this->Cardcolext->create();
				$this->	Cardcolext->save($data);
			}
		}
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_co_worker()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$co_worker=$this->data['co_worker'];
		$this->delete_entry_textbox($card_id,$check_id);
		foreach($co_worker as $co)
		{
			if(!empty($co))
			{
				$data=array('card_id'=>$card_id,'checklist_id'=>$check_id,'text_value'=>$co);
				$this->Cardcolext->create();
				$this->	Cardcolext->save($data);
			}
		}
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_goal()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$goals=$this->data['goal'];
		$this->delete_entry_textbox($card_id,$check_id);
		//echo '<pre>';print_r($goals);die;
		foreach($goals as $go)
		{
			if(!empty($go))
			{
				$data=array('card_id'=>$card_id,'checklist_id'=>$check_id,'text_value'=>$go);
				$this->Cardcolext->create();
				$this->	Cardcolext->save($data);
			}
		}
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
	
	public function save_top_social_networker()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$this->entry_in_cardchecklist($card_id,$check_id);
		
	}
		
	public function entry_in_cardchecklist($card_id,$check_id)
	{
		$this->save_points($card_id,$check_id);
		$card_check_data=array('card_id'=>$card_id,'checklist_id'=>$check_id,'date_added'=>date("Y-m-d H:i:s"));
		$ch_exist=$this->Cardchecklist->findByCardIdAndChecklistId($card_id,$check_id);
		if(!empty($ch_exist))
		{
			$this->Cardchecklist->id=$ch_exist['Cardchecklist']['id'];	
		}else{
			$this->Cardchecklist->create();
			}
		
		$this->Cardchecklist->save($card_check_data);
		
		
		$column_status=$this->Checklist->findById($check_id);
		
		echo $check_id; die;
		//$this->checklist($card_id,$column_status['Checklist']['column']);
		return;
	}
	
	
	public function profile_file_list($num=0)
	{
		$clientid=$this->Session->read('clientid');
		$files=$this->Clientfile->query("SELECT id,filename,last_modified,file FROM jsb_client_files AS Client WHERE client_id='$clientid'");
		//echo '<pre>';print_r($files); die;
		$path=$this->webroot.'files/';
		 $i=1; 
		 if($num=='1'){ 
			 $typ='checkbox'; 
		 	 $nam='file_select[]';
		 }else{ 
			 $typ='radio'; 
			 $nam='file_select';
		 }
		 
		 foreach($files as $file) 
		 {
			echo "<div class='rowdd' style='width:214px; float:left; padding:0 0 6px 0'>";
			echo "<div class='inputdd' style='float:left;width:auto !important;'>".$i.".</div>";
			echo "<input type='".$typ."' style='float:left;width:auto !important;' class='radio' name='".$nam."' value='".$file['Client']['id']."'>";
			echo '<div class="file" style="float:left; width:165px !important; word-wrap:break-word;"><a href="'.$path.$clientid.'/'.$file['Client']['file'].'" target="_blank">'.wraptext($file['Client']['filename'],30).'</a></div>';
			//echo '<div class="file"><a href="'.$path.$clientid.'/'.$file['Client']['file'].'" target="_blank">'.wraptext($file['Client']['filename'],30).'</a></div>';
			//echo "<div class='file'>".wraptext($file['Client']['filename'],30)."<br/>";
			//echo "<span class='uploadeDatev'><strong>Uploaded Date : </strong>".show_formatted_date($file['Client']['last_modified']);
			echo "</span></div>";
			echo "</div>";
			$i++; 
		} 
		$this->set('files',$files);
		//echo '1';
		die;
	}
	
	public function getCard_details($card_id)
	{
		$card=$this->Card->findById($card_id);
		$this->set('card',$card);
		return $card;
	}
	
	public function getCard_column_details($card_id)
	{
		$card_detail=$this->Cardcolumn->findByCardId($card_id);
		$this->set('card_detail',$card_detail);
		return $card_detail;
	}
	
	public function getCard_textbox_values($card_id,$ch_id)
	{
		$values=$this->Cardcolext->findAllByCardIdAndChecklistId($card_id,$ch_id);
		$i=1;
		foreach($values as $val){
			$text_val=$val['Cardcolext']['text_value'];
			$this->set('text_val_'.$i,$text_val);
			$i++;
			}
		return $values;		
	}
	
	public function delete_entry_textbox($card_id,$ch_id)
	{
		$this->Cardcolext->deleteAll(array('Cardcolext.card_id'=>$card_id,'Cardcolext.checklist_id'=>$ch_id));
		return;
	}
	
	public function get_bar_meter_percent()
	{
		$cardid=$this->data['card_id'];
		$points=$this->Card->findById($cardid);
		echo $points['Card']['total_points'];die;
		
	}
	
	public function apply_directly($card_id)
	{
		
			$this->layout='popup';
			$card=$this->Card->findById($card_id);
			$this->set('card_id',$card_id);
			$this->set('card',$card);
			$this->set('name',$this->Session->read('Client.Client.name'));
			$this->set('popTitle','Send your resume directly to the employer');
			$this->render('apply_directly');	
		
	}
	
	public function send_resume_directly()
	{
			
			$clientid=$this->Session->read('clientid');
			$id=$this->Session->read('Account.id');
			$account=$this->Account->findById($id);
			$file=array();
			$email = new CakeEmail();
			if(!empty($this->data['resume']))
			{
				$res=explode(',',$this->data['resume']);
				$attachedFilePath = WWW_ROOT . 'files/'.$clientid.'/' ;
				$i=0; $arr=array();
				foreach($res as $re)
				{
					$file[$i]=$this->Clientfile->findById($re);
					$arr[$file[$i]['Clientfile']['filename']]=$attachedFilePath.$file[$i]['Clientfile']['file'];
					$i++;
				}
				
			}
			$ms=nl2br($this->data['message']);
			if(!empty($this->data['resume']))
			{
				$email->attachments($arr);
			}
			if(!empty($this->data['to_email'])&&(Validation::email($this->data['to_email'], true)))
			{
				$email->emailFormat('html')
					  ->from($account['Account']['email'])
					  ->to($this->data['to_email'])
					  ->subject('Resume')
					  ->send($ms);
			}
			echo 'success';die;			
		
	}
	
	public function contact_connection($card_id,$check_id)
	{
		$this->layout='popup';
		$ids=$this->data['id'];
		$name=$this->data['name'];
		$card=$this->Card->findById($card_id);
		$i=1; $data=array();
		
		foreach($ids as $index=>$id)
		{
			$data[$i]['id']=$id;
			$data[$i]['title']=$name[$index];	
			$i++;
		}
		
		$this->set('data',$data);
		$this->set('card',$card);
		$this->set('check_id',$check_id);
		$this->set('popTitle','Enter your message here');
		$this->render('connection_message');	
	}
	
	public function send_message()
	{
		
		  $id=explode(',',$this->data['to_id']);
			 unset($id[count($id) - 1]);
		 $message=$this->data['message'];
		
			 $OBJ_linkedin = new LinkedIn($this->API_CONFIG);
			 $OBJ_linkedin->setTokenAccess($this->Session->read('Client.linkedin.access'));
			
			
			if(!empty($id))
			{
				foreach($id as $conn)
				{
					$response = $OBJ_linkedin->message($conn, "Request for Job Reference", $message, 0); 	
				}	
			}
		
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$this->entry_in_cardchecklist($card_id,$check_id);
		die;
		
	}
	
	public function move_con_checklist()
	{
		$card_id=$this->data['card_id'];
		$check_id=$this->data['check_id'];
		$this->entry_in_cardchecklist($card_id,$check_id);
	}
	
	
	public function show_video()
	{
		$this->layout='popupvideo';
		$strategy_id=$this->data['id'];
		$strategy_video=$this->Checklist->findById($strategy_id);		
		$this->set('popTitle',$strategy_video['Checklist']['title']);
		$this->set('video_url',$strategy_video['Checklist']['video']);
		//die;
	}
	
	
	
	
	
	
}