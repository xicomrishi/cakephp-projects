<?php
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor',array('xmltoarray','linkedin'));

class JobsearchController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
    public $uses = array('Jobtype','Jobfunction','Card','Carddetail','Opportunity','Country','Jobtype','Jobfunction','Industry','Position','Cardcolumn','Agencycard','Agencyshared','Client');

    public function beforeFilter() {
		if(!($this->Session->check('Client')||$this->Session->check('Coach')))
			{
			$this->redirect(SITE_URL);
				exit();
			}
			parent::beforeFilter();
		$this->layout = 'cardinfo';
    }
	
	public function index()
	{
		$clientid=$this->Session->read('clientid');
		$this->set('clientid',$clientid);
		$country=array("us"=>"United States","ca"=>"Canada","au"=>"Australia","fr"=>"France","gb"=>"United Kingdom");
		$this->set("country",$country);
		$this->set("default_country",$this->Session->read('Client.Client.indeed_country'));
	}
	
	public function search()
	{
		$this->layout='ajax';$query="";
		if($this->data['job_position']!='')
		{
			$keyword1=$this->data['job_position'];
			$keyword="&q=".$keyword1;
			$key1="&q=".urlencode(trim($keyword1));
			$query.=" and (J.position_available like '%$keyword1%' OR J.company_name like '%$keyword1%')";
			if($this->data['job_location']!='' && $this->data['job_location']!='City, State/Province')
			{	
				$location=urlencode(trim($this->data['job_location']));
				$key1.="&l=".$location;
				$query.=" and (J.city like '%$location%' OR J.state like '%$location%')";
			}
		}
		if($this->Session->check('Client'))
		{
			if($this->data['job_country']!=$this->Session->read('Client.Client.indeed_country')){
					$this->Session->write('Client.Client.indeed_country',$this->data['job_country']);
				}
				$query.=" and J.country='".$this->data['job_country']."'";
		}
		
		$agent=urlencode($_SERVER['HTTP_USER_AGENT']);
		$ip=$_SERVER['REMOTE_ADDR'];
		$start=($this->data['pagenum']-1)*10;
		$url="http://api.indeed.com/ads/apisearch?publisher=8774517627820290".$key1."&sort=date&radius=$_POST[distance]&st=&jt=&start=$start&limit=10&fromage=&filter=&latlong=1&co=$_POST[job_country]&chnl=&userip=$ip&useragent=$agent&v=2";
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
		$resp = curl_exec($ch); //execute post and get results
		curl_close ($ch);
		
		$cards=xml2array($resp);
		$total=$cards['response']['totalresults'];
		$totpage=ceil($total/10);
		$indeed_results=$cards['response']['results']['result'];
		$results=array();
		if($this->Session->check('Client'))
		{
			 $sql="Select J.* from jsb_agency_card J where J.id not in (select other_web_job_id from jsb_card where resourcetype='4' and client_id='".$this->Session->read('Client.Client.id')."') and J.usertype='0'  $query order by J.id desc limit $start,10";
			$cards=$this->Agencycard->query($sql);
			if(is_array($cards) && count($cards)){
				foreach($cards as $card)
				$results[]=array_merge(array('count'=>0,'source_type'=>'snagpad','resource_id'=>4,'jobtitle'=>$card['J']['position_available'],'formattedLocation'=>$card['J']['state'],'company'=>$card['J']['company_name']),$card['J']);
				
			}
		}
		if($this->Session->check('Coach'))
			$usertyp='2';
		else
			$usertyp='1';
		
		foreach($indeed_results as $key=>$val)
		{
			$already=$this->Card->find("first",array('conditions'=>array('resource_id'=>1,"other_web_job_id"=>$val['jobkey'],"client_id"=>$this->Session->read('clientid'))));
		if(is_array($already))
			$count=1;
		else
			$count=0;
			$results[]=array_merge(array('count'=>$count,'source_type'=>'indeed','resource_id'=>'1','id'=>$val['jobkey'],'usertype'=>$usertyp),$val);
		}
		
		if($this->Session->read('Client.linkedin.authorized')=='1')
		{
			 $start=$_POST['pagenum']*10; 
 			 if(trim($this->data['job_position']!=''))
			     $q="keywords=".urlencode(strtolower($_POST['job_position'].' '.strtolower($this->data['job_location'])));
			 if(trim($this->data['job_location'])!='' && $this->data['job_location']!='City, State/Province')
			 	$q.="&distance=".$this->data['distance'];
			     $q.="&location=".urlencode(strtolower($this->data['job_location']));
				 
			 $q.="&country-code=".$this->data['job_country'];
				
 			$url=":(jobs:(id,customer-job-code,active,posting-date,expiration-date,posting-timestamp,expiration-timestamp,company:(id,name),position:(title,location,job-functions,industries,job-type,experience-level),skills-and-experience,description-snippet,description,salary,job-poster:(id,first-name,last-name,headline),referral-bonus,site-job-url,location-description))?".$q."&count=10&start=$start";
 $API_CONFIG = array('appKey' => LINKEDIN_APP_KEY, 'appSecret' => LINKEDIN_APP_SECRET, 'callbackUrl' => NULL);
 $OBJ_linkedin = new LinkedIn($API_CONFIG);
 $OBJ_linkedin->setTokenAccess($this->Session->read('Client.linkedin.access'));

$search_response = $OBJ_linkedin->searchJobs($url);
$arr=xml2array($search_response['linkedin']);
if(is_array($arr))
{
	if(isset($arr['job-search']['jobs']['job'])){
	foreach($arr['job-search']['jobs']['job'] as $key=>$val)
	{
		$already=$this->Card->find("first",array('conditions'=>array('resource_id'=>2,"other_web_job_id"=>$val['id'],"client_id"=>$this->Session->read('clientid'))));
		if(is_array($already))
			$count=1;
		else
			$count=0;
			$results[]=array_merge(array('count'=>$count,'source_type'=>'linkedin','resource_id'=>2,'jobtitle'=>$val['position']['title'],'formattedLocation'=>$val['position']['location']['name']),$val);
	
	}
	}
}


		}
		$this->set('totpage',$totpage);
		$this->set("results",$results);
		$this->set("current_page",$this->data['pagenum']);
		$this->render("result");
	}
	
	public function jobAdd()
	{
        $this->autoRender = false;
		$date=date("Y-m-d h:i:s");
		$this->request->data['position_available']=urldecode($this->request->data['position_available']);
		$this->request->data['company_name']=urldecode($this->request->data['company_name']);
		$this->request->data['job_url']=urldecode($this->request->data['job_url']);
		$this->request->data['city']=urldecode($this->request->data['city']);
		$this->request->data['state']=urldecode($this->request->data['state']);
		$this->request->data['country']=urldecode($this->request->data['country']);
		if($this->request->data['resource_id']=='4'){
			$this->request->data['other_web_job_id'];
			$d=$this->Agencycard->findById($this->request->data['other_web_job_id']);
			unset($d['Agencycard']['id']);
			unset($d['Agencycard']['usertype']);
			$data=$d['Agencycard'];
			$data['client_id']=$this->Session->read('clientid');
		$data['reg_date']=$data['latest_card_mov_date']=$date;
 		$data['total_points']='2.0';
		$data['type_of_opportunity']='Snagpad';

		}
		elseif($this->data['resource_id']=='1')
		{		
			$data=$this->data;
		$data['client_id']=$this->Session->read('clientid');
		$data['reg_date']=$data['latest_card_mov_date']=$date;
 		$data['total_points']='2.0';
		$data['type_of_opportunity']='Indeed';
		}else
		{
			$API_CONFIG = array('appKey' => LINKEDIN_APP_KEY, 'appSecret' => LINKEDIN_APP_SECRET, 'callbackUrl' => NULL);
			 $OBJ_linkedin = new LinkedIn($API_CONFIG);
			 $OBJ_linkedin->setTokenAccess($this->Session->read('Client.linkedin.access'));
			$job=$OBJ_linkedin->job($this->data['other_web_job_id'],":(id,customer-job-code,active,posting-date,expiration-date,posting-timestamp,expiration-timestamp,company:(id,name),position:(title,location,job-functions,industries,job-type,experience-level),skills-and-experience,description-snippet,description,salary,job-poster:(id,first-name,last-name,headline),referral-bonus,site-job-url,location-description)");
			$job=xml2array($job['linkedin']);
					$job=$job['job'];
		$data['client_id']=$this->Session->read('clientid');
		$data['reg_date']=$data['latest_card_mov_date']=$date;
		$data['company_name']=$job['company']['name'];
		$data['position_available']=$job['position']['title'];
		$data['position_info']=$job['description'];	
		$data['resource_id']='2';
		$data['other_web_job_id']=$job['id'];
		$data['application_deadline']=$job['expiration-date']['year']."-".$job['expiration-date']['month']."-".$job['expiration-date']['day'];
$data['address']=$job['position']['location']['name'].", ".$job['position']['location']['country']['code'];
$location=explode(",",$job['location-description']);
 $data['city']=$location[0];
 $data['state']=$location[1];
 $data['job_url']=$job['site-job-url'];
 $data['total_points']='2.0';
 $data['type_of_opportunity']='Linkedin';
	
		}
		//echo '<pre>';print_r($data);die;
        $this->Card->create();
        $this->Card->save($data);
		$card_id=$this->Card->id;
		$data=array('card_id'=>$card_id,"column_status"=>"O","start_date"=>$date);
		$this->Carddetail->create();
		$this->Carddetail->save($data);
		$data=array('card_id'=>$card_id);
		$this->Cardcolumn->create();
		$this->Cardcolumn->save($data);
		
	}
        
        public function agency_card($usertype=3){
            $query="Select C.* from jsb_agency_card where C.agency_id='".$this->Session->read('Client.Client.agency_id')."' and (C.share_all='1' OR (C.id in (select card_id from jsb_agency_shared where usertype='$usertype' and user_id='".$this->Session->read('Account.id')."'))";
        }
		
		public function job_details($id=null)
		{
			$this->layout='popup';
			if(!empty($id))
			{	
			$API_CONFIG = array('appKey' => LINKEDIN_APP_KEY, 'appSecret' => LINKEDIN_APP_SECRET, 'callbackUrl' => NULL);
			 $OBJ_linkedin = new LinkedIn($API_CONFIG);
			 $OBJ_linkedin->setTokenAccess($this->Session->read('Client.linkedin.access'));
			$job=$OBJ_linkedin->job($id,":(id,customer-job-code,active,posting-date,expiration-date,posting-timestamp,expiration-timestamp,company:(id,name),position:(title,location,job-functions,industries,job-type,experience-level),skills-and-experience,description-snippet,description,salary,job-poster:(id,first-name,last-name,headline),referral-bonus,site-job-url,location-description)");
			$job=xml2array($job['linkedin']);
			$job=$job['job'];
			$data['company']=$job['company']['name'];
			$data['position']=$job['position']['title'];
			$data['description']=$job['description'];	
			$location=explode(",",$job['location-description']);
			$data['city']=$location[0];
			$data['state']=$location[1];
			$data['country']=$job['position']['location']['country']['name'];
			$data['job_url']=$job['site-job-url'];
			$data['resource_id']='2';
			
				
			}else{
					$data['country']=$this->data['country'];
					$data['city']=$this->data['city'];
					$data['state']=$this->data['state'];
					$data['position']=$this->data['position'];
					$data['company']=$this->data['company'];
					$data['job_url']=$this->data['job_url'];
					$data['resource_id']='1';
			}
			$this->set('popTitle','Job Details');
			$this->set('data',$data);
			$this->render('job_info');
		}
		
		public function get_all_clients()
		{
			$this->layout='popup';
			$coach_id=$this->Session->read('Account.id');
			$clients=$this->Client->find('all',array('conditions'=>array('Client.coach_id'=>$coach_id,'Client.active'=>'1'),'fields'=>array('Client.id','Client.email','Client.account_id','Client.name')));
			$this->request->data['company']=urldecode($this->request->data['company']);
			$this->request->data['job_url']=urldecode($this->request->data['job_url']);
			$this->request->data['position']=urldecode($this->request->data['position']);
			$this->request->data['city']=urldecode($this->request->data['city']);
			$this->request->data['state']=urldecode($this->request->data['state']);
			$this->request->data['country']=urldecode($this->request->data['country']);
			$data=$this->request->data;
			
			$this->set('clients',$clients);
			$this->set('data',$data);
			$this->set('popTitle','Add Card to Client Pad');
			$this->render('all_clients');
			
		}
		
		public function add_card_all_clients()
		{
			//echo '<pre>';print_r($this->data);die;
			$data=$this->data;
			$date=date("Y-m-d h:i:s");
			$data['coach_id']=$this->Session->read('Account.id');
			$data['counselor_id']=$this->Session->read('Account.id');
			$data['reg_date']=$data['latest_card_mov_date']=$date;
 			$data['total_points']='2.0';
			$data['other_web_job_id']=$data['div_id'];
			$data['type_of_opportunity']='Coach';	
			$data['added_by']='1';	
			foreach ($data['to_users'] as $val) {	
						
				if($val!=0)
				{
						$this->add_new_card($data,$val);						
				}
			 }
			 echo 'success';die;
			
		}
		
		public function add_new_card($data,$val)
		{				
			    $date=date("Y-m-d h:i:s");
			    $data['client_id']=$val;						
				$this->Card->create();
				$card=$this->Card->save($data);
				$card_id=$card['Card']['id'];
				$data=array('card_id'=>$card_id,"column_status"=>"O","start_date"=>$date);
				$this->Carddetail->create();
				$this->Carddetail->save($data);
				$this->Cardcolumn->create();
				$this->Cardcolumn->save($data);
				return;				
		}
	
}