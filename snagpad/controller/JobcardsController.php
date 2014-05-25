<?php
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor',array('linkedin','functions','xmltoarray','facebook'));
App::import('Controller', array('Mail'));
//App::import('Vendor','uploadclass');

class JobcardsController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
    public $uses = array('Client','Skillslist','Account','Jobtype','Jobfunction','Clientfile','Clientfilehistory','Profiletooltip','Card','Carddetail','Opportunity','Country','Jobtype','Jobfunction','Industry','Position','Contact','Cardcolumn','Cardcolext','Note','Cardcontact','Linkedlogin','Mail','Coach');
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
    }
	
	public function profile()
	{
		//$this->Session->write('Client.profile_validate','1');
		
	}
	
	public function profileWizard()
	{
		$clientid=$this->Session->read('clientid');
		
		$first=0;
		$val=$this->Client->findById($clientid);
		//echo $val['Client']['login'];die;
		//print_r($val);die;
		if($val['Client']['login']=='1')
		{
			$first=1;
			//echo $first.'!';
			
		}
		//echo $first;
			$num=1;
			$this->set('clientid',$clientid);
			$this->set('num',$num);
			$this->set("popTitle","Profile");
			$this->set('first',$first);	
			$this->render('index');
	}
	
	public function profileView()
	{
		$clientid=$this->Session->read('clientid');
		$this->set('clientid',$clientid);
		$num=1;
			
			$this->set('num',$num);
			$this->set("popTitle","Profile");
			$this->set('first','2');	
			$this->render('index');
	}
	
	public function index($clientid=null)
	{
		if($clientid==null)
		{
		 $clientid=$this->Session->read('clientid');
		}
		$cardShow=explode('_',$clientid);
		
		//print_r($cardShow);
		if($cardShow[0]=='cardShow')
			{
				$clientid=$this->Session->read('clientid');
				$first='cardShow';
				$num=$cardShow[1];
					
			}
		else
		{
			if($cardShow[0]=='jobkey')
			{
				$clientid=$this->Session->read('clientid');
				$saved_card_id=$this->save_indeed_card($cardShow[1],$clientid);
				$first='cardShow';
				$num=$saved_card_id;								
			}else if($cardShow[0]=='coachclient')
			{
				$clientid=$cardShow[1];
				$cardid=$cardShow[2];
				$first='cardShow';
				$num=$cardid;	
			}			
			else if($clientid=='redirect')				//for redirect and open create jobcard directly
			{
				$clientid=$this->Session->read('clientid');
				$first='9';
				$num=9;				
			}
			else if($clientid=='social')					//for redirect and open social 
			{
				$clientid=$this->Session->read('clientid');
				$first='social';
				$num=9;				
			}
			else if($clientid=='apply')					//for redirect and open social 
			{
				$clientid=$this->Session->read('clientid');
				$first='apply';
				$num=9;				
			}
			else{
				$first='3';
				$num=0;
			}
		}
		$this->set('num',$num);
		$this->set('clientid',$clientid);
		$this->set('first',$first);	
	}
	
	public function save_indeed_card($jobkey,$clientid)
	{
		$url="http://api.indeed.com/ads/apigetjobs?publisher=8774517627820290&jobkeys=$jobkey&v=2";
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
		$resp = curl_exec($ch); //execute post and get results
		curl_close ($ch);
		
		$cards=xml2array($resp);
		$indeed_results=$cards['response']['results']['result'];
		$this->request->data['clientid']=$clientid;
		$this->request->data['company']=$indeed_results['company'];
		$this->request->data['title']=$indeed_results['jobtitle'];
		$this->request->data['url']=$indeed_results['url'];
		$this->request->data['country']=$indeed_results['country'];
		$this->request->data['city']=$indeed_results['city'];
		$this->request->data['state']=$indeed_results['state'];
		$this->request->data['jobkey']=$indeed_results['jobkey'];
		$this->request->data['redirect_to_index']='1';
		$card_id=$this->add_suggested_card();
		return $card_id;				
	}
	
	public function view($card_id)
	{
		$clientid=$this->Session->read('clientid');
		$this->set('clientid',$clientid);
		$num=0; 
		$this->set('card_id',$card_id);
		$this->render('view_jobcards');
	}
	
		
	public function check_exist_card()
	{
		$clientid=$this->data['client_id'];
		$cards_count=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0')));	
		$opp_cards_count=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.column_status'=>'O','Card.recycle_bin'=>'0')));	
		echo $cards_count.'|'.$opp_cards_count; die;
	}
	
	public function index_top_tab()
	{
		$clientid=$this->data['clientid'];
		$this->set('clientid',$clientid);
		$this->layout='ajax';
		$opp=$apply=$setinterview=$interview=$verbal=$job=0;
		$cards=$this->Card->findAllByClientIdAndRecycleBin($clientid,'0');
		foreach($cards as $card)
		{
			if($card['Card']['column_status']=='O'){	$opp++; }
			elseif($card['Card']['column_status']=='A'){	$apply++; }
			elseif($card['Card']['column_status']=='S'){	$setinterview++; }
			elseif($card['Card']['column_status']=='I'){	$interview++; }
			elseif($card['Card']['column_status']=='V'){	$verbal++; }
			elseif($card['Card']['column_status']=='J'){	$job++; }
				
		}
		$count=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$clientid,'Card.column_status'=>'O','Card.recycle_bin'=>'0')));
		$count_opp=count($count);
		//echo $count_opp;die;
		//$count_opp=$this->Card->find('count',array('conditions'=>array('Card.column_status'=>'O','Card.recycle_bin'=>'0')));
		$this->set('count',$count_opp);
		
		$this->set('opp',$opp);
		$this->set('apply',$apply);
		$this->set('setinterview',$setinterview);
		$this->set('interview',$interview);
		$this->set('verbal',$verbal);
		$this->set('job',$job);
		$this->set('cards',$cards);
		$this->render('top_tab');	
	}
	
	public function index_jobcards()
	{	
		//echo '<pre>';print_r($this->Session->read());die;
		$this->layout='ajax';
		$clientid=$this->data['clientid'];
		$this->set('clientid',$clientid);
		
		$cards=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0'),'order'=>'Card.id DESC'));
		
			if(!empty($cards))
			{
				$i=0;
				$t_date=date('Y-m-d H:i:s');
				foreach($cards as $cd)
				{
					$cards[$i]['Card']['show_exclaim']=0;
					if($cd['Card']['latest_card_mov_date']!='0000-00-00 00:00:00')
					{
						$days=$this->check_difference_card_move($t_date,$cd['Card']['latest_card_mov_date']);
						if($days >= 14)
						{
							$cards[$i]['Card']['show_exclaim']=1;
						}
					}else{
								
						$days=$this->check_difference_card_move($t_date,$cd['Card']['reg_date']);
						if($days >= 14)
						{
							$cards[$i]['Card']['show_exclaim']=1;
						}
					}
					
					////Application Pending///
					if(!empty($cd['Card']['application_deadline'])&&((strtotime($cd['Card']['application_deadline'])-strtotime($t_date))>0)&&($cd['Card']['column_status']=='O'))
					{
						$cards[$i]['Card']['show_exclaim']=1;	
					}
					//Client Action Required////
					if($cd['Card']['column_status']=='S'||$cd['Card']['column_status']=='I'||$cd['Card']['column_status']=='V')
					{
						$card_date_diff=strtotime($t_date)-strtotime($cd['Card']['latest_card_mov_date']);
						if($card_date_diff>0&&$card_date_diff<86400)
						{
							$cards[$i]['Card']['show_exclaim']=1;	
						}	
								
					}
					////My Coach Cards///
					if($cd['Card']['type_of_opportunity']=='Coach')
						{
							
							$card_date_diff=strtotime($t_date)-strtotime($cd['Card']['latest_card_mov_date']);
							if($card_date_diff>0&&$card_date_diff<86400)
							{
								$cards[$i]['Card']['show_exclaim']=1;
							}	
								
						}
					
					
					
					$i++;	
				}	
			}
		
		
		$this->set('cards',$cards);
		$this->render('jobcard_index');	
	}
	
	public function check_difference_card_move($t_date,$cd_date)
	{
		$diff=strtotime($t_date)-strtotime($cd_date);
		$days=$diff/(60 * 60 * 24);
		return $days;
	}
	
	public function add_jobcard($is_coach=0)
	{		
		$this->layout='ajax';
		$clientid=$this->data['clientid'];
		$results=$this->get_indeed_jobs($clientid);
		$this->set('is_coach',$is_coach);
		$this->set('job_indeed',$results);
		$this->set('clientid',$clientid);
		$this->render('add_jobcard');		
	}
	
	
	public function get_indeed_jobs($clientid)
	{
		$client_info=$this->Client->findById($clientid);
		$key1="&q=".urlencode(trim($client_info['Client']['job_a_title']));
		$cl_location=urlencode(trim($client_info['Client']['city'].' '.$client_info['Client']['state']));
		$cl_country=$client_info['Client']['country'];
		$key1.="&l=".$cl_location;
		$agent=urlencode($_SERVER['HTTP_USER_AGENT']);
		$ip=$_SERVER['REMOTE_ADDR'];
		$start=rand(0,20);
		$url="http://api.indeed.com/ads/apisearch?publisher=8774517627820290".$key1."&sort=date&radius=100&st=&jt=&start=$start&limit=30&fromage=&filter=&latlong=1&co=$cl_country&chnl=&userip=$ip&useragent=$agent&v=2";
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
		$resp = curl_exec($ch); //execute post and get results
		curl_close ($ch);
		
		$cards=xml2array($resp);
		$indeed_results=$cards['response']['results']['result'];
		$results=array(); $i=0;
		foreach($indeed_results as $key=>$val)
		{
			$already=$this->Card->find("first",array('conditions'=>array('resource_id'=>1,"other_web_job_id"=>$val['jobkey'],"client_id"=>$clientid)));
			if(empty($already))
			{
				if(!empty($val['company']))
				{
					$results[$i]=$val;	
					$i++;
				}
			}
			
		}
		return $results;	
	}
	
	public function add_suggested_card()
	{
		$data=array('client_id'=>$this->data['clientid'],'company_name'=>$this->data['company'],'reg_date'=>date("Y-m-d H:i:s"),'type_of_opportunity'=>'Indeed','position_available'=>$this->data['title'],'job_url'=>$this->data['url'],'country'=>$this->data['country'],'state'=>$this->data['state'],'city'=>$this->data['city'],'resource_id'=>1,'total_points'=>'2.0','other_web_job_id'=>$this->data['jobkey']);	
		
		if(isset($this->data['is_coach_card'])&&$this->data['is_coach_card']=='1')
		{
			 $data['counselor_id']=$this->Session->read('Account.id');
			 $data['added_by']=1;
			 $data['type_of_opportunity']='Coach';	
		}
		
		$this->Card->create();
		$card=$this->Card->save($data);
		$card_detail=array('card_id'=>$card['Card']['id'],'start_date'=>date('Y-m-d H:i:s'));
		
		$this->Carddetail->create();
		$this->Carddetail->save($card_detail);
		
		$card_column=array('card_id'=>$card['Card']['id']);
		$this->Cardcolumn->create();
		$this->Cardcolumn->save($card_column);
		if(isset($this->data['redirect_to_index']))
		{
			return $card['Card']['id'];	
		}
		echo 'success';die;
		
	
	}
	
	public function show_first_add_card()
	{
		
		$this->layout='popup';
		$clientid=$this->Session->read('Client.Client.id');
		$results=$this->get_indeed_jobs($clientid);
		//echo '<pre>';print_r($results);die;
		$this->set('job_indeed',$results);
		$this->set('clientid',$clientid);
		$this->set('popTitle','You have no Snagged Jobs – What would you like to do?');
		$this->render('show_first_add_jobcard');
				
	}
	
	public function show_opp_jobcards()
	{
		$this->layout='popup';
		$clientid=$this->Session->read('Client.Client.id');
		$cards=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$clientid,'Card.column_status'=>'O','Card.recycle_bin'=>'0'),'order'=>array('Card.id DESC')));
		$this->set('cards',$cards);
		$this->set('clientid',$clientid);
		$this->set('popTitle','Jobs you Snagged - Are you ready to apply?');
		$this->render('show_all_opp_jobcard');
	}
	
	public function save_new_card()
	{
		$clientid=$this->data['clientid'];
		/*$opportunity='Advertisement|Friend|Acquaintance|Internet|Head Hunter|Cold Call|Job Coach|Card Pool|Job Posting(Employment Center)|Family Member|Job Bulletin Board (Agency)|Social Media Contact|Face2Face Contact|RSS Card|Facebook|Job Card Plugin|Indeed.com|Linkedin|fairylakejobs.net|www.coolsocialcareers.com|reversemortgagejobsonline.com|dev-hamilton.vicinityjobs.com';*/
		
		$loc_detail=explode('/',$this->data['location']);
		$data=array('client_id'=>$clientid,'company_name'=>$this->data['company_name'],'position_available'=>$this->data['position_available'],'job_url'=>$this->data['job_url'],'country'=>$loc_detail[2],'state'=>$loc_detail[1],'city'=>$loc_detail[0],'reg_date'=>date("Y-m-d H:i:s"),'total_points'=>'2');
		
		if($this->data['is_coach']=='1')
		{
			 $data['counselor_id']=$this->Session->read('Account.id');
			 $data['added_by']=1;
			 $data['total_points']='2.0';
			 $data['type_of_opportunity']='Coach';	
		}
		
		$this->Card->create();
		$card=$this->Card->save($data);
		$card_detail=array('card_id'=>$card['Card']['id'],'start_date'=>date('Y-m-d H:i:s'));
		
		$this->Carddetail->create();
		$this->Carddetail->save($card_detail);
		
		$card_column=array('card_id'=>$card['Card']['id']);
		$this->Cardcolumn->create();
		$this->Cardcolumn->save($card_column);
		
		
		//$this->Client->id=$clientid;
		//$this->Client->saveField('latest_card_mov_date',date('Y-m-d H:i:s'));
		
			
		echo 'Job Card added.';die;	
	}
	
	public function display_card()
	{
		$card_id=$this->data['card_id'];
		$client_id=$this->Session->read('Client.Client.id');
		$all_cards=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$client_id,'Card.recycle_bin'=>'0'),'order'=>array('Card.id DESC')));
		$pos=1;
		foreach($all_cards as $card){
			if($card_id==$card['Card']['id'])
			{
				break;
			}else{ $pos++; }
			
		}
		echo $card_id;die;
		//echo $pos;die;
	}
	
	public function job_details()
	{
		$this->layout='ajax';
		$show_tab=$this->data['show_tab'];
		$card_id=$this->data['cardid'];
		$this->set('cardid',$card_id);
		$this->set('show_tab',$show_tab);
		$this->render('jobcard_details');	
		
	}
	
	public function jobcard_details_first()
	{
		$this->layout='ajax';
		$card_id=$this->data['cardid'];
		$card_info=$this->Card->findById($card_id);
		
		$all_opp=$this->Opportunity->find('all');
		$data=array();	
		foreach($all_opp as $opp)
		{
			$id=$opp['Opportunity']['id'];
			$data[$id]=$opp['Opportunity']['name'];
			
		}
	/*	$intrvw_complete=0;
		$interview_check=$this->Cardchecklist->findByCardIdAndChecklistId($card_id,42);
		if(!empty($interview_check))
			$intrvw_complete=1;
		$this->set('interview_comp',$intrvw_complete);	*/			
		$this->set('data',$data);
		$this->set('card',$card_info);
		$this->set('data',$data);
		$this->render('jobcards_details_first');		
	}
	
	public function update_card()
	{
		//print_r($this->data);
		$data_val=$this->update_card_field($this->data);
		echo $data_val;die;
	}
	
	public function update_card_opportunity()
	{
		$data_val=$this->update_card_field($this->data);
		if($data_val=='A') 
		{echo 'Job A';}else{ echo 'Job B';}
		die;
		
	}
	
	public function update_card_position_level()
	{
		$data_val=$this->update_card_field($this->data);
		$pos_level=$this->Position->findById($data_val);
		echo $pos_level['Position']['position'];
		die;
		
	}
	
	public function update_card_job_function()
	{
		$data_val=$this->update_card_field($this->data);
		$job_func=$this->Jobfunction->findById($data_val);
		echo $job_func['Jobfunction']['job_function'];
		die;
		
	}
	
	public function update_card_industry()
	{
		$data_val=$this->update_card_field($this->data);
		$industry=$this->Industry->findById($data_val);
		echo $industry['Industry']['industry'];
		die;
		
	}
	
	public function update_card_job_type()
	{
		$data_val=$this->update_card_field($this->data);
		$type=$this->Jobtype->findById($data_val);
		echo $type['Jobtype']['job_type'];
		die;
		
	}
	public function update_card_field($data)
	{
		$data_id=$data['id'];
		$data_val=$data['value'];
		$data_arr=explode('|',$data_id);
		$field=$data_arr['0'];
		$card_id=$data_arr['1'];
		
		if($field=='application_deadline'||$field=='interview_date')
		{
			if($data_val==''||$data_val=='NA'||$data_val=='Click to edit...')
			{
				$data_val='0000-00-00';	
			}
		}
		
		$this->Card->id=$card_id;
		$this->Card->saveField($field,$data_val);
		if($field=='application_deadline'||$field=='interview_date')
		{
			if($data_val=='0000-00-00')
			{
				//echo $data_val;die;
				$data_val='Click to edit...';	
			}else{
				$data_val=show_formatted_date($data_val);
			}
		}
		return $data_val;	
		
	}
	
	public function update_card_country()
	{
		$data_val=$this->update_card_field($this->data);
		$country=$this->Country->findByCountryCode($data_val);
		echo $country['Country']['country'];die;
	}
	
	public function update_card_contact()
	{
		$data_val=$this->update_card_field($this->data);
		$contact=$this->Contact->findById($data_val);
		echo $contact['Contact']['email']; die;
	}
	
	public function type_of_opp_list()
	{
		$all_opp=$this->Opportunity->find('all');
		$data=array();	
		foreach($all_opp as $opp)
		{
			$index=$opp['Opportunity']['name'];
			$data[$index]=$opp['Opportunity']['name'];
			
			}
		print json_encode($data); 
		$this->autoRender=false;	
	}
	
	public function show_location()
	{
		$this->layout='ajax';
		$card_id=$this->data['cardid'];	
		$cardinfo=$this->card_info($card_id);
		$country=$this->Country->findByCountryCode($cardinfo['Card']['country']);
		$this->set('country',$country);
		
		$this->render('card_location');
	}
	
	public function card_info($card_id)
	{
		$cardinfo=$this->Card->findById($card_id);
		$card_col_det=$this->Cardcolumn->findByCardId($card_id);
		$this->set('card_col',$card_col_det);
		$this->set('card',$cardinfo);
		return $cardinfo;
	}
	
	public function show_contact()
	{
		$this->layout='ajax';
		$card_id=$this->data['cardid'];	
		$this->Session->write('contact_card_id',$card_id);
		$cardinfo=$this->card_info($card_id);
		$contact=$this->Cardcontact->findAllByCardId($card_id);
		$a_cont=array(); 
		$i=0;
		$a_cont_arr_id=array();
		foreach($contact as $cont)
		{
			$info=$this->Contact->findById($cont['Cardcontact']['contact_id']);
			$a_cont[$i]=$info;
			$a_cont_arr_id[$i]=$info['Contact']['id'];
			$i++;	
		}
		//echo '<pre>';print_r($a_cont_arr_id);die;
		$account_id=$this->Session->read('Account.id');
		$all_contacts=$this->Contact->find('all',array('conditions'=>array('Contact.account_id'=>$account_id),'order'=>array('Contact.id DESC')));
		$this->set('all_contacts',$all_contacts);
		$this->set('contact',$contact);
		$this->set('a_cont',$a_cont);
		$this->set('a_cont_arr_id',$a_cont_arr_id);
		$this->render('card_contact_info');
	}
	
	public function show_card_contact_info()
	{
		$this->layout='ajax';
		$card_id=$this->data['card_id'];	
		$contact_id=$this->data['cont_id'];
		$data=array('card_id'=>$card_id,'contact_id'=>$contact_id);
		$this->Cardcontact->create();
		$this->Cardcontact->save($data);
		//$this->Card->id=$card_id;
		//$this->Card->saveField('contact_id',$contact_id);
		$contact=$this->Contact->findById($contact_id);
		$this->set('contact',$contact);
		$this->render('show_card_contact_info');
	}
	
	public function show_position()
	{
		$this->layout='ajax';
		$card_id=$this->data['cardid'];	
		$cardinfo=$this->card_info($card_id);
		$pos_level=$this->Position->findById($cardinfo['Card']['position_level']);
		$industry=$this->Industry->findById($cardinfo['Card']['industry']);
		$job_func=$this->Jobfunction->findById($cardinfo['Card']['job_function']);
		$job_type=$this->Jobtype->findById($cardinfo['Card']['job_type_o']);
		//$this->set('client',$this->Session->read('Client'));
		$this->set('pos_level',$pos_level);
		$this->set('industry',$industry);
		$this->set('job_func',$job_func);
		$this->set('job_type',$job_type);
		$this->render('card_position_info');
		
	}
	
	public function show_interview()
	{
		$this->layout='ajax';
		$card_id=$this->data['cardid'];	
		$cardinfo=$this->card_info($card_id);
		$job_expectation=$this->Cardcolext->find('all',array('conditions'=>array('card_id'=>$card_id,'checklist_id'=>'22')));
		$pdo=$this->Cardcolext->find('all',array('conditions'=>array('card_id'=>$card_id,'checklist_id'=>'34')));
		$this->set('job_e',$job_expectation);
		$this->set('pdo',$pdo);
		$this->render('card_interview_agenda');
	}
	
	public function all_position_level()
	{
		$all_pos_level=$this->Position->find('all',array('order'=>array('Position.id ASC')));	
		$data=array();	
		foreach($all_pos_level as $pos)
		{
			$index=$pos['Position']['id'];
			$data[$index]=$pos['Position']['position'];
		}
		print json_encode($data); 
		$this->autoRender=false;
	}
	
	public function all_industry()
	{
		$all_industry=$this->Industry->find('all',array('order'=>array('Industry.id ASC')));	
		$data=array();	
		foreach($all_industry as $ind)
		{
			$index=$ind['Industry']['id'];
			$data[$index]=$ind['Industry']['industry'];
		}
		print json_encode($data); 
		$this->autoRender=false;
	}
	public function all_job_function()
	{
		$all_job_func=$this->Jobfunction->find('all',array('order'=>array('Jobfunction.id ASC')));	
		$data=array();	
		foreach($all_job_func as $func)
		{
			$index=$func['Jobfunction']['id'];
			$data[$index]=$func['Jobfunction']['job_function'];
		}
		print json_encode($data); 
		$this->autoRender=false;
	}
	
	public function all_job_type()
	{
		$all_job_type=$this->Jobtype->find('all',array('order'=>array('Jobtype.id ASC')));	
		$data=array();	
		foreach($all_job_type as $type)
		{
			$index=$type['Jobtype']['id'];
			$data[$index]=$type['Jobtype']['job_type'];
		}
		print json_encode($data); 
		$this->autoRender=false;
	}
	
	public function country_list()
	{
		$all_country=$this->Country->find('all',array('order'=>array('Country.country ASC')));	
		$data=array();	
		foreach($all_country as $country)
		{
			$index=$country['Country']['country_code'];
			$data[$index]=$country['Country']['country'];
			
			}
		print json_encode($data); 
		$this->autoRender=false;
	}
	
	public function contact_list()
	{
		$account_id=$this->Session->read('Account.id');
		$all_contact=$this->Contact->find('all',array('conditions'=>array('Contact.account_id'=>$account_id),'order'=>array('Contact.id ASC')));	
		$data=array();	
		foreach($all_contact as $contact)
		{
			$index=$contact['Contact']['id'];
			$data[$index]=$contact['Contact']['email'];
			
			}
		print json_encode($data); 
		$this->autoRender=false;
	}
	
	public function show_add_contact()
	{
		$this->layout='popup';
		$account_id=$this->Session->read('Account.id');
		$card_id=$this->Session->read('contact_card_id');
		$this->set('popTitle','Add New Contact');
		$this->set('card_id',$card_id);
		$this->set('account_id',$account_id);
		$this->render('add_contact');	
	}
	
	
	
	public function save_contact()
	{
		if(!empty($this->data))
		{
							
			$exist_contact=$this->Contact->findAllByAccountIdAndEmail($this->data['Contact']['account_id'],$this->data['Contact']['email']);
			if(empty($exist_contact))
			{
				$data=$this->data;
				$data['Contact']['date_added']=date("Y-m-d H:i:s");
				//$data['Contact']['date_modified']=date("Y-m-d H:i:s");
				$this->Contact->create();
				$contact=$this->Contact->save($data);
				$this->Card->id=$data['cardid'];
				$this->Card->saveField('contact_id',$contact['Contact']['id']);	
				echo $contact['Contact']['id']; die;
			}else{
				echo 'Error'; die;
				
				}
		}
		
	}
	
	public function notes_index()
	{	
		$this->layout='basic_Cardpopup';
		$card_id=$this->data['card_id'];
		$note_type=$this->data['note_type'];
		//echo $note_type;die;
		$card_status=$this->Card->find('first',array('conditions'=>array('Card.id'=>$card_id,''),'fields'=>array('Card.column_status')));
		$this->set('card_id',$card_id);
		$this->set('card_column',$card_status['Card']['column_status']);
		$this->set('note_type',$note_type);
		$this->render('show_card_notes');	
	}
	
	public function get_notes()
	{
		$this->layout='ajax';
		$card=$this->Card->find('first',array('conditions'=>array('Card.id'=>$this->data['card_id']),'fields'=>array('Card.client_id')));
		$flag=0;    //check if client is linked to a coach
		
		
			$client=$this->Client->find('first',array('conditions'=>array('Client.id'=>$card['Card']['client_id']),'fields'=>array('Client.id','Client.coach_id')));
			
			if($client['Client']['coach_id']!=0)
			{
				$flag=1;
			}
		
		$card_id=$this->data['card_id'];
		$column_status=$this->data['column_status'];
		$notes=$this->Note->find('all',array('conditions'=>array('Note.note_id'=>$card_id,'Note.note_type'=>$this->data['note_type']),'order'=>array('Note.id ASC')));
		$this->set('notes',$notes);	
		$this->set('flag',$flag);	
		$this->render('show_existing_notes');
	}
	
	public function save_notes()
	{
		//echo '<pre>';print_r($this->data);die;
		$card_id=$this->data['card_id'];
		$data=array('note_id'=>$card_id,'note'=>addslashes(nl2br($this->data['note_text'])),'note_type'=>$this->data['note_type'],'column_status'=>$this->data['card_column'],'date_added'=>date("Y-m-d H:i:s"));	
		$this->Note->create();
		$note_data=$this->Note->save($data);
		$this->sendnote_mail($note_data,$this->data['note_type']);		
		
		echo 'success';die;	
	}
	
	public function sendnote_mail($note,$typ)
	{
		$Mail = new MailController;
     	$Mail->constructClasses();					
		$card=$this->Card->find('first',array('conditions'=>array('Card.id'=>$note['Note']['note_id']),'fields'=>array('Card.client_id','Card.company_name','Card.position_available')));
		$client=$this->Client->find('first',array('conditions'=>array('Client.id'=>$card['Card']['client_id']),'fields'=>array('Client.account_id','Client.coach_id','Client.name','Client.id')));
		$coach=$this->Coach->find('first',array('conditions'=>array('Coach.account_id'=>$client['Client']['coach_id'])));		
		
			$arr=array();
			if($typ=='1'){
					$arr['COACH_NAME'] = $coach['Coach']['name'];
					$to_id=$client['Client']['account_id'];
					$mail_title="coach_comment_added";
					$query_string = "file=jobcards&action=index&card_id=cardShow_".$note['Note']['note_id'];
  					$s_url = '<a href="'.SITE_URL . '/Pages/display?'.$query_string.'">Click here</a>';
					//$s_url= SITE_URL;
				}else{
					$arr['CLIENT_NAME'] = $client['Client']['name'];
					$to_id=$coach['Coach']['account_id'];
					$mail_title="client_comment_added";
					$query_string = "file=jobcards&action=index&card_id=coachclient_".$client['Client']['id']."_".$note['Note']['note_id']."_";
  					$s_url = '<a href="'.SITE_URL . '/Pages/display?'.$query_string.'">Click here</a>';
				}
			$arr['FOLLOW_URL'] = $s_url;
			$arr['COMPANY_NAME'] = $card['Card']['company_name'];
			$arr['JOB_TITLE'] = $card['Card']['position_available'];
			//echo '<pre>';print_r($arr);die;
            $Mail->sendMail($to_id,$mail_title, $arr);
			return;
		
	}
	
	
	public function attachments_index()
	{
		$this->layout='basic_Cardpopup';
		
		$card_id=$this->data['card_id'];
		$card_files=$this->Card->find('first',array('conditions'=>array('Card.id'=>$card_id),'fields'=>array('Card.client_id','Card.cover_letter','Card.resume')));
		$clientid=$card_files['Card']['client_id'];
		//echo '<pre>';print_r($card_files); die; 
		$resume_details=$cover_details=array();
		if(!empty($card_files['Card']['resume']) && $card_files['Card']['resume']!=0)
		{
			$resume_details=$this->Clientfile->findById($card_files['Card']['resume']);
		}
		if(!empty($card_files['Card']['cover_letter']) && $card_files['Card']['cover_letter']!=0)
		{
			$cover_details=$this->Clientfile->findById($card_files['Card']['cover_letter']);
		}
		//echo '<pre>';print_r($resume_details); die; 
		$path=$this->webroot.'files/'.$clientid.'/';
		$this->set('path',$path);
		$this->set('resume',$resume_details);
		$this->set('cover_letter',$cover_details);
		$this->set('card_id',$card_id);
		$this->set('card_files',$card_files);
		$this->render('show_card_files');		
	}
	
	public function recycle_bin_index()
	{
		$this->layout='jsb_bg';
		$clientid=$this->Session->read('Client.Client.id');
		$card=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'1'),'order'=>array('Card.id DESC')));	
		$this->set('cards',$card);
		$this->render('recycle_bin');
	}
	
	public function delete_card()
	{
		$card_id=$this->data['card_id'];
		$card_col_data=$this->Cardcolumn->findByCardId($card_id);
		$card_col_ext=$this->Cardcolext->findByCardId($card_id);	
		$this->Card->delete($card_id);
		$this->Cardcolumn->delete($card_col_data['Cardcolumn']['id']);
		$this->Cardcolext->deleteAll(array('Cardcolext.card_id'=>$card_id));
		die;
		
	}
	
	public function move_to_recycle()
	{
		$card_id=$this->data['card_id'];
		$clientid=$this->Session->read('Client.Client.id');
		$this->Card->id=$card_id;
		$this->Card->saveField('recycle_bin','1');
		echo $clientid;die;	
	}
	
	public function get_reminder_dates()
	{
		$clientid=$this->Session->read('Client.Client.id');
		
		$sql="SELECT C.interview_date,C.application_deadline,D.employee_start_date,D.expected_date_of_employer_decision,D.hiring_time_end,D.reminder_date,D.desired_start_date,D.expected_response,D.permission_followup FROM jsb_card C INNER JOIN jsb_card_column_detail D on (C.id=D.card_id) WHERE C.recycle_bin='0' AND C.client_id='".$clientid."'";
		//echo $sql;die;
		$card=array();$i=1;$dates=array(); $j=0;
		$data=$this->Card->query($sql);
		
		foreach($data as $dat)
		{
			$card[$i]=array_merge($dat['C'],$dat['D']);
			foreach($card[$i] as $key=>$val)
			{
				if($val!='0000-00-00')
				{
					$val=date('m/d/Y', strtotime($val));
					$dates[$j]=$val;
					$j++;
				}
			}
			$i++;
						
		}
		
		echo json_encode($dates); die;				
	}
	
	public function get_date_data()
	{
		$this->layout='ajax';
		//print_r( basename($_SERVER['SERVER_NAME']));die;
		$clientid=$this->Session->read('Client.Client.id');
		$flag='1';
		$date=$this->data['date'];
		$sql="SELECT C.id FROM jsb_card C INNER JOIN jsb_card_column_detail D on (C.id=D.card_id) WHERE (C.interview_date='$date' OR  C.application_deadline='$date' OR D.employee_start_date='$date' OR D.expected_date_of_employer_decision='$date' OR D.hiring_time_end='$date' OR D.reminder_date='$date' OR D.desired_start_date='$date' OR D.expected_response='$date' OR D.permission_followup='$date') AND C.recycle_bin='0' AND C.client_id='".$clientid."'";
		$card_data=$this->Card->query($sql);
		if(empty($card_data))
		{
			$flag='0';	
		}
		
		//echo $q;die;
		if($flag=='1')
		{
		$i=0;
		foreach($card_data as $card)
		{
			$q="SELECT C.interview_date,C.interview_time,C.application_deadline,D.employee_start_date,D.expected_date_of_employer_decision,D.hiring_time_end,D.reminder_date,D.desired_start_date,D.expected_response,D.permission_followup FROM jsb_card C INNER JOIN jsb_card_column_detail D on (C.id=D.card_id) WHERE C.id='".$card['C']['id']."'";
			$data=$this->Card->query($q);
			$all_data[$i]=array_merge($data['0']['C'],$data['0']['D']);
			//echo '<pre>';print_r($all_data[$i]);die;
			$key[$i]['card']=$card['C']['id'];
			$key[$i]['field']=array_keys($all_data[$i], $date);
			$p=0;
			foreach($key[$i]['field'] as $index=>$field)
			{
				$key[$i]['field'][$p]=$this->get_field_name($card['C']['id'],$field);
				$p++;
			}
			
			$i++;
		}
		
		$this->set('data',$key);
		}
		$this->set('flag',$flag);		
		$full_date=date('l, F d, Y',strtotime($date));
		$this->set('date',$full_date);
		$this->render('calendar_details');
	}
	
	
	public function get_field_name($card_id,$name)
	{
		switch($name)
		{
			case 'interview_date': 	$int_time=$this->Card->find('first',array('conditions'=>array('Card.id'=>$card_id),'fields'=>array('Card.interview_time')));
									$val='Interview at '.$int_time['Card']['interview_time'];
									break;		
			case 'application_deadline': $val='Application Deadline';
									break;		
			case 'employee_start_date': $val='Employee Start Date';
									break;		
			case 'expected_date_of_employer_decision': $val='Expected Decision';
									break;		
			case 'hiring_time_end': $val='Hiring Time End';
									break;		
			case 'reminder_date': $val='Send a thank you note to interviewer(s)';
									break;		
			case 'desired_start_date': $val='Desired Start';
									break;		
			case 'expected_response': $val='Job Offer Response';
									break;		
			case 'permission_followup': $val='Interview Followup';
									break;	
																																																						
			}
			return $val;	
	}
	
	public function show_calender_ico()
	{
		$this->layout='ajax';
		$this->render('display_calendar');	
	}
	
	
	public function client_details_for_coach()
	{
		$this->layout='ajax';
		$clientid=$this->data['clientid'];
		$client_info=$this->Client->find('first',array('conditions'=>array('Client.id'=>$clientid),'fields'=>array('Client.name','Client.reg_date','Client.job_a_title','Client.job_b_criteria')));	
	//	$cards=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.expired'=>'0')));
		$sql="Select max(start_date) as max_date from jsb_card_detail  where card_id in (select id from jsb_card where client_id='".$clientid."' and recycle_bin='0')";
		$latest_date=$this->Carddetail->query($sql);
		$this->set('latest_date',$latest_date['0']['0']['max_date']);
		$this->set('client',$client_info);	
		$this->render('client_details_for_coach');
	}
	
	public function restore_card()
	{
		$card_id=$this->data['cardid'];
		$this->Card->id=$card_id;
		$this->Card->saveField('recycle_bin','0');
		echo ($this->Session->read('Client.Client.id'));die;	
	}
	

	
	public function show_network()
	{
		$this->layout='ajax';
		//$file=WWW_ROOT."/1.png";
		//exec("wkhtmltoimage http://www.indeed.com/viewjob?jk=5956efa7f4118799&qd=et3L6q6tIlxvGvyMv0LZQUx0bie_YcvH9iO68EjFQLKFQaEyWH3s43UIYYMcVwiBOp_AdeVGB4GyC5yuAQ0oF6W2sjZC7pKGvqJKtZY595nqAhSzImzghGm1GoZ7nsAp&atk=17e1t8d050k1h4nu&utm_source=publisher&utm_medium=organic_listings&utm_campaign=affiliate $file");

		$cardid=$this->data['cardid'];
		$card_data=$this->Card->findById($cardid);
		$client=$this->Client->find('first',array('conditions'=>array('Client.id'=>$card_data['Card']['client_id']),'fields'=>array('Client.linkedin_id')));
		if(empty($client['Client']['linkedin_id'])&&empty($client['Client']['profile_id']))
		{
			$this->set('no_connect','1');	
		}
		$company=$card_data['Card']['company_name'];
		//facebook
//		dump($this->Session->read('Client.Client'));
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
		
		//linkedin
		$company=urlencode($card_data['Card']['company_name']);
		 $OBJ_linkedin = new LinkedIn($this->API_CONFIG);
        $OBJ_linkedin->setTokenAccess($this->Session->read('Client.linkedin.access'));
        $this->autoRender = false;
		       // $response = $OBJ_linkedin->profile('~:(id,first-name,last-name,headline,email-address,picture-url,publicProfileUrl)');         
       $search_response = $OBJ_linkedin->searchPeople(":(people:(id,first-name,last-name,picture-url,site-standard-profile-request,headline),num-results)?company-name=$company&count=60&facet=network,R");
	   
	   	$arr=xml2array($search_response['linkedin']);
		//dump($arr);
		$this->set('friends',$arr['people-search']);
		$this->render('network_info');
	}
	
	public function jobcard_details_profile_check()
	{
		$this->layout='basic_Cardpopup';
		$this->render('display_message');
			
	}
	
	
	public function expired_cards()
	{
		$this->layout='jsb_bg';
		$this->render('expired_cards');	
	}
	
	
}