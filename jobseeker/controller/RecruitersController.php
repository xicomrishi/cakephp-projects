<?php
App::import('Vendor',array('functions'));

class RecruitersController extends AppController {

	public $name = 'Recruiters';
	public $helpers = array('Form', 'Html', 'Js','Core','Session');
	public $layout='default';
	public $components=array('Session','Access','Core','Email','Captcha','Image','Upload','RequestHandler');
	public $uses=array('Recruiter','Domain','RecruiterDomain','RecruiterClient','Core','Email','EmailTemplate');

	function beforeFilter(){
		$isAdmin=Configure::read('Routing.prefixes');
		$pos = strpos($_SERVER['REQUEST_URI'], $isAdmin[0]);
		if($pos == true)
		{
			$this->Access->isValidUser();
		}
	}
	function admin_index() {
		
		$this->layout='admin';
		if($this->params['url'])
		{
			$searchQuery=$this->params['url']['admin_search_prof'];

			if($searchQuery!=''){
				$condition=array(
					'Recruiter.completed_status' => 'Yes',
					 'OR' => array(
				array('Recruiter.first_name LIKE' => '%'.trim($searchQuery).'%'),
				array('Recruiter.last_name LIKE' => '%'.trim($searchQuery).'%'),
				array('CONCAT(Recruiter.first_name," ",Recruiter.last_name) LIKE' => '%'.trim($searchQuery).'%'),
				array('Recruiter.current_company LIKE' => '%'.trim($searchQuery).'%'),
				array('Recruiter.current_location LIKE' => '%'.trim($searchQuery).'%')
				)
					
				);
					
			}
			$this->paginate=array('order'=>array('Recruiter.id'=>'DESC'),'conditions'=>$condition,'limit'=>20);
				
		}else{
			$this->paginate=array('order'=>array('Recruiter.id'=>'DESC'),'conditions'=>array('completed_status'=>'Yes'));
		}
//		echo '<pre>';print_r($this->paginate('Recruiter'));die;
		$this->set('Recruiters', $this->paginate('Recruiter'));
	}


/************************************************
 ** Action Name  : admin_unregistered_recruiters
 ** Desc  : gives a list of all those recryites how 
    does not completed his profile.
 ** Developed By : Rajesh Kumar Kanojia
 ** Devloped On : Jan 3rd 2014 
*************************************************/
 
  function admin_unregistered_recruiters()
   {
	   
		$this->layout='admin';
		if($this->params['url'])
		{
			$searchQuery=$this->params['url']['admin_search_prof'];
			if($searchQuery!=''){
				$condition=array(
					'Recruiter.completed_status' => 'No',
					 'OR' => array(
				array('Recruiter.first_name LIKE' => '%'.trim($searchQuery).'%'),
				array('Recruiter.last_name LIKE' => '%'.trim($searchQuery).'%'),
				array('CONCAT(Recruiter.first_name," ",Recruiter.last_name) LIKE' => '%'.trim($searchQuery).'%'),
				)
					
				);
					
			}
			$this->paginate=array('order'=>array('Recruiter.id'=>'DESC'),'conditions'=>$condition,'limit'=>20);
				
		}else{
			$this->paginate=array('order'=>array('Recruiter.id'=>'DESC'),'conditions'=>array('completed_status'=>'No'));
		}
//		echo '<pre>';print_r($this->paginate('Recruiter'));die;
		$this->set('Recruiters', $this->paginate('Recruiter'));
	   
   }
 







	function admin_view($id = null) {
		$this->layout='admin';
		if (!$id) {
			$this->Session->setFlash(__('Invalid Recruiter', true),'default',array('class'=>'error'));
			$this->redirect(array('action' => 'index'));
		}
		$domain=$this->Domain->find('list',array('fields'=>array('id','domain_title')));
		//print_r($domain);die;
		$this->set('Recruiter', $this->Recruiter->read(null, $id));
		$this->set('domain', $domain);

	}
	function admin_account_setting($id=null)
	 {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for recruiter', true),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		 $this->set('setting',$this->Recruiter->findById($id));
//		 $setting = $this->Recruiter->findById($id);
	 }

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for recruiter', true),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Recruiter->delete($id)) {

			$this->Session->setFlash(__('The recruiter deleted successfully', true),'default',array('class'=>'success'));
			$this->redirect($this->referer());
//			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('The recruiter could not be deleted', true),'default',array('class'=>'error'));
			$this->redirect($this->referer());
//		$this->redirect(array('action' => 'index'));
	}

	function signup(){

		if(empty($this->request->data)){
			$this->redirect(array('controller'=>'home'));
		}
		$domain=$this->Domain->find('list',array('fields'=>array('id','domain_title')));
		/*-- index page form handling--*/
		if($this->request->is('post') && isset($this->request->data['User']['index_counter'])){
			$this->request->data['Recruiter']=$this->request->data['User'];
			unset($this->request->data['User']);
			$recruiterData=$this->Recruiter->find('first',array('conditions'=>array('email'=>$this->request->data['Recruiter']['email'],'completed_status'=>'No'),'fields'=>array('id')));
			if(empty($recruiterData)){					
				$this->Recruiter->validate['first_name']=array('rule' => 'notEmpty','message' => 'Please enter the first name.');
				$this->Recruiter->validate['last_name']= array('rule' => 'notEmpty','message' => 'Please enter the last name.');
				$this->Recruiter->set($this->request->data);			
				if(!$this->Recruiter->validates(array('fieldList'=>array('first_name','last_name','email')))){			
					$homeError=array();
					$homeError['fname']=$this->request->data['Recruiter']['first_name'];
					$homeError['lname']=$this->request->data['Recruiter']['last_name'];
					$homeError['email']=$this->request->data['Recruiter']['email'];
					$homeError['user_type']=$this->request->data['Recruiter']['user_type'];
					$errMsg='';
					if(isset($this->Recruiter->validationErrors['first_name'])){
						$errMsg=$this->Recruiter->validationErrors['first_name'][0].'<br/>';
					}
					if(isset($this->Recruiter->validationErrors['last_name'])){
						$errMsg.=$this->Recruiter->validationErrors['last_name'][0].'<br/>';
					}
					if(isset($this->Recruiter->validationErrors['email'])){
						$errMsg.=$this->Recruiter->validationErrors['email'][0];
					}
					$homeError['msg']=$errMsg;
					$this->Session->write('homeError',$homeError);
					$this->redirect(array('controller'=>'home','action' => 'index'));
				}else{
				
					$this->Recruiter->create();
					$newPass=$this->Core->generatePassword();
					$arrTempUser=array('Recruiter'=>array(
							'first_name'=>trim($this->request->data['Recruiter']['first_name']),
							'last_name'=>trim($this->request->data['Recruiter']['last_name']),
							'email'=>$this->request->data['Recruiter']['email'],
							'password'=>md5($newPass),
							'completed_status'=>'No',
							'profile_added_date'=>date('Y-m-d H:i:s')
					));
					$recruiterData=$this->Recruiter->save($arrTempUser,false);
						
				}
			}
		
			$recruiterClient=$this->RecruiterClient->find('all',array('conditions'=>array('recruiter_id'=>$recruiterData['Recruiter']['id'])));
		
		}
		/*-- /index page form handling--*/
		
		
		if (($this->request->is('post') || $this->request->is('put')) && isset($this->request->data['Recruiter']['recruiter_signup'])) {
			$recruiterClient=$this->RecruiterClient->find('all',array('conditions'=>array('recruiter_id'=>$this->request->data['Recruiter']['id'])));
			$validationError=false;
			$this->Recruiter->id=$this->request->data['Recruiter']['id'];
			$this->Recruiter->set($this->request->data);
			if(!$this->Recruiter->validates()){
				$validationError=true;
			}

			/*--validate captcha--*/
			if(!$this->validateCaptcha($this->request->data['Recruiter']['captcha_value'])){
					
				$validationError=true;
				$captchaError=array('captcha_value'=>array('Please enter the correct numbers / alphabets / word in the captcha'));
			}
			/*--[end]validate captcha--*/
				
			if($validationError){
				$arrErrors=array();
				if(isset($this->Recruiter->validationErrors)){
					$arrErrors=array_merge($arrErrors,$this->Recruiter->validationErrors);
				}
				if(isset($captchaError)){
					$arrErrors=array_merge($arrErrors,$captchaError);
				}
				$this->set('Errors',$arrErrors);

			}else{
				//print_r($this->request->data);die;
				$arrProfessionalData=array('Recruiter'=>array(
						'email'=>$this->request->data['Recruiter']['email'],
						'password'=>$this->request->data['Recruiter']['password'],
						'current_company'=>$this->request->data['Recruiter']['current_company'],
						'company_website'=>$this->request->data['Recruiter']['company_website'],
						'current_location'=>$this->request->data['Recruiter']['current_location'],
						'current_designation'=>$this->request->data['Recruiter']['current_designation'],
						'current_role'=>$this->request->data['Recruiter']['current_role'],
						'skills'=>$this->request->data['Recruiter']['skills'],
						'roles'=>$this->request->data['Recruiter']['roles'],	
						'geographies'=>$this->request->data['Recruiter']['geographies'],
						'type_of_companies'=>$this->request->data['Recruiter']['type_of_companies'],
						'terms_acceptance_flag'=>$this->request->data['Recruiter']['terms_acceptance_flag'],
						'completed_status'=>'Yes',		
						'profile_modified_date'=>date('Y-m-d H:i:s')
				));
					
				$name=explode(" ",$this->request->data['Recruiter']['name']);
				$firstName=$name[0];
				$lastName=$name[1];
					
				if(count($name)>2){
					for($i=2;$i<count($name);$i++){
						$lastName.=" ".$name[$i];
					}
				}
				$arrProfessionalData['Recruiter']['first_name']=$firstName;
				$arrProfessionalData['Recruiter']['last_name']=$lastName;
				if(!empty($this->request->data['Recruiter']['otherComp']) && empty($this->request->data['Recruiter']['type_of_companies'])){
					$arrProfessionalData['Recruiter']['type_of_companies']=$this->request->data['Recruiter']['otherComp'];
				}
				if(!empty($this->request->data['Recruiter']['type_of_companies']) && !empty($this->request->data['Recruiter']['otherComp'])){
					$arrProfessionalData['Recruiter']['type_of_companies']=$this->request->data['Recruiter']['type_of_companies'].','.$this->request->data['Recruiter']['otherComp'];
				}
				$arrProfessionalData['Recruiter']['type_of_companies']=rtrim($arrProfessionalData['Recruiter']['type_of_companies'],',');
				if(!empty($this->request->data['RecruiterDomain'])){
					foreach($this->request->data['RecruiterDomain']['domain_id'] as $domain){
						$this->RecruiterDomain->create();
						if($domain!=15){
							$this->RecruiterDomain->save(array('recruiter_id'=>$this->request->data['Recruiter']['id'],'domain_id'=>$domain));
						}else{
							$this->RecruiterDomain->save(array('recruiter_id'=>$this->request->data['Recruiter']['id'],'domain_id'=>$domain,'other_domain'=>$this->request->data['RecruiterDomain']['other_domain']));
						}
							
					}
				}
					
				// convert work exp in months
				$arrProfessionalData['Recruiter']['recruiting_experience']=$this->request->data['Recruiter']['recruiting_experience']['month'];
				if(!empty($this->request->data['Recruiter']['recruiting_experience']['year'])){
					$arrProfessionalData['Recruiter']['recruiting_experience']=intval($arrProfessionalData['Recruiter']['recruiting_experience'])+
					(intval($this->request->data['Recruiter']['recruiting_experience']['year'])*12);
				}
					
				$phoneNbr=$this->request->data['Recruiter']['phone_nbr']['number'];
				if(!empty($this->request->data['Recruiter']['phone_nbr']['code'])){
					$phoneNbr=$this->request->data['Recruiter']['phone_nbr']['code']."-".$phoneNbr;
				}
				$arrProfessionalData['Recruiter']['phone_nbr']=$phoneNbr;
				$arrProfessionalData['Recruiter']['online_profiles']=base64_encode(serialize($this->request->data['Recruiter']['online_profiles']));
					
				/*--save professional data--*/
				try{
						
					/*--upload profile images--*/
						
					if(!empty($this->request->data['Recruiter']['profile_photo'])){
						$upload_dir = WWW_ROOT.str_replace("/", DS, "files/temp_recruiter_images/");
						$uploaddir = $upload_dir.DS;
						$sourcePath=$uploaddir.$this->request->data['Recruiter']['profile_photo'];
						$dest_dir = WWW_ROOT.str_replace("/", DS, "files/recruiter_images/");
						$destdir = $dest_dir.DS;
						$destinationPath=$destdir.$this->request->data['Recruiter']['profile_photo'];
						copy($sourcePath, $destinationPath);
						/*$imgName=$this->Image->upload_image_and_thumbnail($this->request->data['Professional']['profile_photo'],200,205,100,100, "professional_images");*/
						$arrProfessionalData['Recruiter']['profile_photo']=$this->request->data['Recruiter']['profile_photo'];
						unlink($sourcePath);
					}else{
						$arrProfessionalData['Recruiter']['profile_photo']='';
					}
				}catch(Exeption $e){
					//echo $e->getMessage();
				}
				/*--save professional data--*/

				$arrProfessionalData['Recruiter']['password']=md5($this->request->data['Recruiter']['password']);
				$arrProfessionalData['Recruiter']['last_login_ip']=$this->request->clientIp();
				$arrProfessionalData['Recruiter']['last_login_date']=date('Y-m-d H:i:s');
				$transDetail=$this->Recruiter->save($arrProfessionalData,false);
/*********************    Signup mail           ***********************/					
					$to=$arrProfessionalData['Recruiter']['email'];
					$name=$arrProfessionalData['Recruiter']['first_name'].' '.$arrProfessionalData['Recruiter']['last_name'];;  
					$subject="Successfully account created.";
					$template = $this->EmailTemplate->find('first',
						 array('conditions' => array('template_key'=> 'signup_email',
						 'status' =>'Active')));
					if($template){	
						$arrFind=array('{name}','{email}','{password}');
						$arrReplace=array($name,$to,$this->request->data['Recruiter']['password']);
						$from=$template['EmailTemplate']['from_email'];
						$subject=$template['EmailTemplate']['email_subject'];
						$content=str_replace($arrFind, $arrReplace,$template['EmailTemplate']['email_body']);
					}
					/*-[end]template asssignment*/				
					$this->set('Content',$content);
					try{
						$this->Email->from='admin@jobseeker.com';
						$this->Email->to=$to;
						$this->Email->subject=$subject;
						$this->Email->sendAs='html';
						$this->Email->template='default';
						$this->Email->delivery = 'smtp';
						$this->Email->send();
					}catch(Exception $e){
						echo "<h4 class='error forgot_pass'>The email could not be sent.Please contact to admin.</h4>";
						die;
					}
				if($transDetail){
						
					$this->Session->write('Recruiter',$transDetail);
					$this->Session->write('LoginStatus',1);
					$this->Session->setFlash(__('Your profile has been created successfully. Please login.',true),'default',array('class'=>'success'));
					$this->redirect(array('action' => 'profile'));
				}else{
					$this->Session->setFlash(__('The data could not be saved.Please try again.',true),'default',array('class'=>'error'));
				}
				/*--[end]save professional data--*/
			}
		}
		$this->set('IndexData',$this->request->data['Recruiter']);
		$this->set('recruiterId',$recruiterData['Recruiter']['id']);
		$this->set('recruiterClient',$recruiterClient);
		$this->set('domain',$domain);

	}

	function profile(){
		$this->layout='default';
		if(!$this->Session->check('Recruiter')){
			$this->redirect(array('controller'=>'home'));
		}
		$prof=$this->Session->read('Recruiter');

		$this->Recruiter->recursive=2;
		$this->RecruiterDomain->bindModel(array('belongsTo'=>array('Domain'=>array('className'=>'Domain','foreignKey'=>'domain_id'))));
		$profDetails=$this->Recruiter->findById($prof['Recruiter']['id']);
		$domains='';
		$otherDomain='';
		$reclients=array();
		if(!empty($profDetails['RecruiterDomain']))
		{
			foreach($profDetails['RecruiterDomain'] as $redom)
			{
				if(!empty($redom['other_domain']))   {
					$otherDomain=$redom['other_domain'];
				}
				$domains.=$redom['Domain']['domain_title'].', ';
			}
			$domains=substr(trim($domains),0,-1);
		}
		if(!empty($profDetails['RecruiterClient']))
		{
			foreach($profDetails['RecruiterClient'] as $recl)
			{
				if($recl['type_of_hire']=='Direct'||$recl['type_of_hire']=='')
				{
					$reclients['direct'][]=$recl;
				}else{
					$reclients['indirect'][]=$recl;
				}
			}
		}
		$this->set('reclients',$reclients);
		$this->set('domains',$domains);
		$this->set('otherDomain',$otherDomain);
		$this->set('profDetails',$profDetails);
	}

	function recruiter_profile($id = null){
		 
		$this->layout='default';

		if(!$this->Session->check('Professional')){
			$this->redirect(array('controller'=>'home'));
		}else{
			$prof=$this->Session->read('Professional');
		}

		$this->loadModel('ProfessionalFlag');
		//print_r($this->request->data);die;
		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data['profFlag'])) {
				
			$flagName='';
			if(!empty($this->request->data['profFlag']['FlagType']))
			{
				foreach($this->request->data['profFlag']['FlagType'] as $flagType)
				{
					$flagName.=$flagType.',';
				}
				$flagName=rtrim($flagName,',');
			}

			if($flagName!='')
			{

				$arrProfessionalData=array('ProfessionalFlag'=>array(
						'professional_id'=>$prof['Professional']['id'],
						'recruiter_id'=>$id,
						'flag_type'=>$flagName,
						'flag_details'=>$this->request->data['profFlag']['details'],
						'status'=>1

				));
				if(isset($this->request->data['profFlag']['id']))
				{
					//$this->ProfessionalFlag->id=$this->request->data['profFlag']['id'];
					$arrProfessionalData['ProfessionalFlag']['id']=$this->request->data['profFlag']['id'];
				}else{
					$this->ProfessionalFlag->create();
					$arrProfessionalData['ProfessionalFlag']['date']=date('Y-m-d H:i:s');
				}

				$this->ProfessionalFlag->save($arrProfessionalData,false);

				$this->Recruiter->id=$id;
				$this->Recruiter->saveField('flag_status',1);

			}else{

				$this->ProfessionalFlag->delete($this->request->data['profFlag']['id']);
				$num_recruiters = $this->ProfessionalFlag->find('count',array("conditions" => array('recruiter_id'=>$id)));
				if($num_recruiters==0)
				{
					$this->Recruiter->id=$id;
					$this->Recruiter->saveField('flag_status',0);
				}
			}

		}
		$this->Recruiter->recursive=2;
		$this->RecruiterDomain->bindModel(array('belongsTo'=>array('Domain'=>array('className'=>'Domain','foreignKey'=>'domain_id'))));
		$profDetails=$this->Recruiter->findById($id);
		//pr($profDetails); die;
		$domains='';
		$reclients=array();
		if(!empty($profDetails['RecruiterDomain']))
		{
			foreach($profDetails['RecruiterDomain'] as $redom)
			{
				$domains.=$redom['Domain']['domain_title'].', ';
			}
			$domains=substr(trim($domains),0,-1);
		}
		if(!empty($profDetails['RecruiterClient']))
		{
			foreach($profDetails['RecruiterClient'] as $recl)
			{
				if($recl['type_of_hire']=='Direct'||$recl['type_of_hire']=='')
				{
					$reclients['direct'][]=$recl;
				}else{
					$reclients['indirect'][]=$recl;
				}
			}
		}

		//pr($reclients); die;
		$flagDetails=$this->ProfessionalFlag->findByProfessionalIdAndRecruiterIdAndStatus($prof['Professional']['id'],$id,1);

		$this->set('reclients',$reclients);
		$this->set('domains',$domains);
		$this->set('profDetails',$profDetails);
		$this->set('flagDetails',$flagDetails);
	}




	public function edit_profile()
	{

		if(!$this->Session->check('Recruiter')){
			$this->redirect(array('controller'=>'home'));
		}

		$domain=$this->Domain->find('list',array('fields'=>array('id','domain_title')));
		$recDetails=$this->Recruiter->findById($this->Session->read('Recruiter.Recruiter.id'));

		if(!empty($recDetails))
		{
			$recDomain=array(); $j=0;
			if(!empty($recDetails['RecruiterDomain']))
			{
				foreach($recDetails['RecruiterDomain'] as $dom)
				{
					$recDomain[]=$dom['domain_id'];
					if(!empty($dom['other_domain']))   {
					  $others=$dom['other_domain'];
					}
					else
					$others;
				}
			}
			$recCompany=array(); $otherComp='';
			if(!empty($recDetails['Recruiter']['type_of_companies']))
			{
				$allComp=explode(',',$recDetails['Recruiter']['type_of_companies']);
				$checkComp=array('Startup','Product Development','Services based','CMMI_5','CMMI_3','Onsite','Fortune_100','Fortune_500','Fortune_1000');

				foreach($allComp as $tempComp)
				{
					if(!empty($tempComp))
					{
						$recCompany[]=$tempComp;

						if(!in_array(trim($tempComp),$checkComp))
						{		$otherComp=$tempComp;	 }
					}

				}
			}
			$this->set('others',$others);
			$this->set('otherComp',$otherComp);
			$this->set('recCompany',$recCompany);
			$this->set('IndexData',$recDetails);
			$this->set('recDomain',$recDomain);
			$this->set('domain',$domain);
		}else{
			$this->redirect(array('controller' => 'home'));
		}


		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data['Recruiter'])) {
//			echo '<pre>'; print_r($this->request->data); die;
			$recruiterClient=$this->RecruiterClient->find('all',array('conditions'=>array('recruiter_id'=>$this->request->data['Recruiter']['id'])));
			$validationError=false;
			$this->Recruiter->id=$this->request->data['Recruiter']['id'];
			$this->Recruiter->set($this->request->data);
			if(!$this->Recruiter->validates()){
				$validationError=true;
			}

				
			if($validationError){
				$arrErrors=array();
				if(isset($this->Recruiter->validationErrors)){
					$arrErrors=array_merge($arrErrors,$this->Recruiter->validationErrors);
				}
				if(isset($captchaError)){
					$arrErrors=array_merge($arrErrors,$captchaError);
				}
				$this->set('Errors',$arrErrors);

			}else{
				$arrProfessionalData=array('Recruiter'=>array(
						'email'=>$this->request->data['Recruiter']['email'],
						'current_company'=>$this->request->data['Recruiter']['current_company'],
						'company_website'=>$this->request->data['Recruiter']['company_website'],
						'current_location'=>$this->request->data['Recruiter']['current_location'],
						'current_designation'=>$this->request->data['Recruiter']['current_designation'],
						'current_role'=>$this->request->data['Recruiter']['current_role'],
						'skills'=>$this->request->data['Recruiter']['skills'],
						'roles'=>$this->request->data['Recruiter']['roles'],	
						'geographies'=> trim($this->request->data['Recruiter']['geographies']),
						'type_of_companies'=>$this->request->data['Recruiter']['type_of_companies'],
						'profile_modified_date'=>date('Y-m-d H:i:s')
				));
					
				$name=explode(" ",$this->request->data['Recruiter']['name']);
				$firstName=$name[0];
				$lastName=$name[1];
					
				if(count($name)>2){
					for($i=2;$i<count($name);$i++){
						$lastName.=" ".$name[$i];
					}
				}
				$arrProfessionalData['Recruiter']['first_name']=$firstName;
				$arrProfessionalData['Recruiter']['last_name']=$lastName;
				if(!empty($this->request->data['Recruiter']['otherComp']) && empty($this->request->data['Recruiter']['type_of_companies'])){
					$arrProfessionalData['Recruiter']['type_of_companies']=$this->request->data['Recruiter']['otherComp'];
				}
				if(!empty($this->request->data['Recruiter']['type_of_companies']) && !empty($this->request->data['Recruiter']['otherComp'])){
					$arrProfessionalData['Recruiter']['type_of_companies']=$this->request->data['Recruiter']['type_of_companies'].','.$this->request->data['Recruiter']['otherComp'];
				}
				$arrProfessionalData['Recruiter']['type_of_companies']=rtrim($arrProfessionalData['Recruiter']['type_of_companies'],',');
				$this->RecruiterDomain->deleteAll(array('RecruiterDomain.recruiter_id'=>$this->request->data['Recruiter']['id']),false);
				if(!empty($this->request->data['RecruiterDomain'])){
					foreach($this->request->data['RecruiterDomain']['domain_id'] as $domain){
							
						$this->RecruiterDomain->create();
						if($domain!=15){
							$this->RecruiterDomain->save(array('recruiter_id'=>$this->request->data['Recruiter']['id'],'domain_id'=>$domain));
						}else{
							$this->RecruiterDomain->save(array('recruiter_id'=>$this->request->data['Recruiter']['id'],'domain_id'=>$domain,'other_domain'=>$this->request->data['RecruiterDomain']['other_domain']));
						}
							
					}
				}
					
				// convert work exp in months
				$arrProfessionalData['Recruiter']['recruiting_experience']=$this->request->data['Recruiter']['recruiting_experience']['month'];
				if(!empty($this->request->data['Recruiter']['recruiting_experience']['year'])){
					$arrProfessionalData['Recruiter']['recruiting_experience']=intval($arrProfessionalData['Recruiter']['recruiting_experience'])+
					(intval($this->request->data['Recruiter']['recruiting_experience']['year'])*12);
				}
					
				$phoneNbr=$this->request->data['Recruiter']['phone_nbr']['number'];
				if(!empty($this->request->data['Recruiter']['phone_nbr']['code'])){
					$phoneNbr=$this->request->data['Recruiter']['phone_nbr']['code']."-".$phoneNbr;
				}
				$arrProfessionalData['Recruiter']['phone_nbr']=$phoneNbr;
					
				$arrProfessionalData['Recruiter']['online_profiles']=base64_encode(serialize($this->request->data['Recruiter']['online_profiles']));
							
				$transDetail=$this->Recruiter->save($arrProfessionalData,false);
				if($transDetail){
						
					$this->Session->write('Recruiter',$transDetail);
					$this->Session->write('LoginStatus',1);
					$this->Session->setFlash(__('Your profile has been updated successfully.',true),'default',array('class'=>'success'));
					$this->redirect(array('action' => 'profile'));
				}else{
					$this->Session->setFlash(__('The data could not be saved.Please try again.',true),'default',array('class'=>'error'));
				}
				/*--[end]save professional data--*/
			}
		}


	}

	
	
	public function recruiter_settings()
	{

		if(!$this->Session->check('Recruiter')){
			$this->redirect(array('controller'=>'home'));
		}
		$rec=$this->Session->read('Recruiter');
		
		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data['Recruiter'])) {
			$this->Recruiter->id=$rec['Recruiter']['id'];
			$this->Recruiter->set($this->request->data);
			
			if($this->Recruiter->validates(array('fieldList'=>array('password','confirm_password')))){
				
				$arrRecData=array('Recruiter'=>array(
						'password'=>md5($this->request->data['Recruiter']['password']),
						'profile_modified_date'=>date('Y-m-d H:i:s')
				));
				
			
				if($this->Recruiter->save($arrRecData,false)){			
					unset($this->request->data['Recruiter']);
					$this->Session->setFlash(__('<h4>Your password has been changed successfully.</h4>',true),'default',array('class'=>'success'));
				}else{
					$this->Session->setFlash(__('<h4>The data could not be saved.Please try again.</h4>',true),'default',array('class'=>'error'));
				}
			}else{
				$this->Session->setFlash(__('<h4>The data could not be saved.Please try again.</h4>',true),'default',array('class'=>'error'));
		
			}
		}
	}
	

	public function edit_basic_details()
	{
		$this->layout='ajax';
			
		if($this->request->is('post'))
		{
			$this->Recruiter->id=$this->data['Recruiter']['id'];
			$this->Recruiter->set($this->request->data);
				
			if(!$this->Recruiter->validates()){
				$validationErr=true;
			}
			if($validationErr){
				$arrErrors=array();
				if(isset($this->Recruiter->validationErrors)){
					$arrErrors=array_merge($arrErrors,$this->Recruiter->validationErrors);
				}
				echo $arrErrors['email'][0].',error';die;

			}else{
				$arrProfessionalData=array('Recruiter'=>array(
						'email'=>$this->request->data['Recruiter']['email'],
						'current_company'=>$this->request->data['Recruiter']['current_company'],
						'company_website'=>$this->request->data['Recruiter']['company_website'],
						'current_location'=>$this->request->data['Recruiter']['current_location'],
						'profile_modified_date'=>date('Y-m-d H:i:s')
				));
				$phoneNbr=$this->request->data['Recruiter']['phone_nbr']['number'];
				if(!empty($this->request->data['Recruiter']['phone_nbr']['code'])){
					$phoneNbr=$this->request->data['Recruiter']['phone_nbr']['code']."-".$phoneNbr;
				}
				$arrProfessionalData['Recruiter']['phone_nbr']=$phoneNbr;
					
				$transDetail=$this->Recruiter->save($arrProfessionalData,false);
					
			}
		}
		$recruiter=$this->Session->read('Recruiter');
		if(!empty($recruiter))
		{
			$profDetail=$this->Recruiter->findById($recruiter['Recruiter']['id']);
			$phone=$profDetail['Recruiter']['phone_nbr'];
			$arrPhone=explode('-', $phone);
			//print_r($arrPhone);die;
			$profDetail['Recruiter']['phone_nbr']=array();
			$profDetail['Recruiter']['phone_nbr']['code']=trim($arrPhone[0]);
			$profDetail['Recruiter']['phone_nbr']['number']=trim($arrPhone[1]);
				
			/*--[end]format data--*/
			$this->set('profDetail',$profDetail);
			if($transDetail){
				echo 'Your profile has been updated successfully'.',success';die;
			}
		}else{
			$this->redirect('/logins/invalid_session');
		}

	}


	function edit_recruiter_details($field=null){

		$this->layout='ajax';
		$validationErr=false;
		
		if(!$this->Session->check('Recruiter')){
			$this->redirect(array('controller'=>'home'));
		}
		$prof=$this->Session->read('Recruiter');
		

		if ($this->request->is('post') || $this->request->is('put')){
			$this->Recruiter->id=$prof['Recruiter']['id'];
			$this->Recruiter->set($this->request->data);
			if(!$this->Recruiter->validates(array('fieldList' => array($field)))){
				$validationErr=true;
			}

			if($validationErr){
				$arrErrors=array('Error'=>'Error');
				if(isset($this->Recruiter->validationErrors)){
					$arrErrors=array_merge($arrErrors,$this->Recruiter->validationErrors);
				}
				echo json_encode($arrErrors); die;

			}else{
					
				$arrProfessionalData=array();
				$arrProfessionalData['Recruiter']['profile_modified_date']=date('Y-m-d H:i:s');
				$arrSuccess=array();
				if($field=='name'){
					if(isset($this->request->data['Recruiter']['name']) && $this->request->data['Recruiter']['name']!='')
					{
							
						$name=explode(" ",$this->request->data['Recruiter']['name']);
						$firstName=$name[0];
						$lastName=$name[1];
							
						if(count($name)>2){
							for($i=2;$i<count($name);$i++){
								$lastName.=" ".$name[$i];
							}
						}
						$arrProfessionalData['Recruiter']['first_name']=$firstName;
						$arrProfessionalData['Recruiter']['last_name']=$lastName;
						$transDetail=$this->Recruiter->save($arrProfessionalData,false);
							
						if($transDetail){
							$arrSuccess['first_name']=$transDetail['Recruiter']['first_name'];
							$arrSuccess['Success']='Your name has been updated successfully';
							$this->Session->write('Recruiter.first_name',$transDetail['Recruiter']['first_name']);
							$this->Session->write('Recruiter.last_name',$transDetail['Recruiter']['last_name']);
						}
					}
				}
				if($field=='work_experience'){
					$arrProfessionalData['Recruiter']['recruiting_experience']=$this->request->data['Recruiter']['work_experience']['month'];
					if(!empty($this->request->data['Recruiter']['work_experience']['year'])){
						$arrProfessionalData['Recruiter']['recruiting_experience']=intval($arrProfessionalData['Recruiter']['recruiting_experience'])+
						(intval($this->request->data['Recruiter']['work_experience']['year'])*12);
					}
					$transDetail=$this->Recruiter->save($arrProfessionalData,false);
					if($transDetail){
						$arrSuccess['Success']='Work experience has been updated successfully';
						$expInYear=(int)($arrProfessionalData['Recruiter']['recruiting_experience']/12);
						$expInMonth=($arrProfessionalData['Recruiter']['recruiting_experience']%12);
						if($arrProfessionalData['Recruiter']['recruiting_experience']<2){
							$arrSuccess['value']=$expInMonth;
							$arrSuccess['yearText']='month';
						}
						else if($arrProfessionalData['Recruiter']['recruiting_experience']<12 && $arrProfessionalData['Recruiter']['recruiting_experience']>1){
							$arrSuccess['value']=$expInMonth;
							$arrSuccess['yearText']='months';
						}else{
							$arrSuccess['value']=$expInYear.'.'.$expInMonth;
							$arrSuccess['yearText']='yrs';
						}
					}
						
				}
				if($field=='hiring_roles')
				{
					$arrProfessionalData['Recruiter']['roles']==$this->request->data['Recruiter']['roles'];
					$transDetail=$this->Recruiter->save($arrProfessionalData,false);
					if($transDetail)
					$arrSuccess['Success']='Roles has been updated successfully';
					$arrSuccess['roleList']=$transDetail['Recruiter']['roles'];
					$arrSuccess['roleNum']=0; $arrSuccess['roleText']='roles';
					if(!empty($transDetail['Recruiter']['roles']))
					{
						$arrSuccess['roleNum']=count(explode(',',$transDetail['Recruiter']['roles']));
						if($arrSuccess['roleNum']==1)
						$arrSuccess['roleText']='role';
					}
						
				}
				echo json_encode($arrSuccess); die;
			}
		}
			
	}


	function logout(){

		unset($_SESSION['LoginStatus']);
		unset($_SESSION['Recruiter']);

		$this->Session->delete('LoginStatus');
		$this->Session->delete('Recruiter');

		$this->Session->setFlash(__('You have been successfully logged out.',true),
		'default',array('class'=>'logout success'));
		$this->redirect(array('controller'=>'home','action' => 'index'));

	}

	function delete_profile_image(){
		$this->layout='default';
		if(!$this->Session->check('Recruiter')){
			$this->redirect(array('controller'=>'home'));
		}
		
		$prof=$this->Session->read('Recruiter');
		$this->Recruiter->id=$prof['Recruiter']['id'];
		$profilePhoto = $this->Recruiter->findById($prof['Recruiter']['id'], array('fields'=>'profile_photo'));
		if($profilePhoto['Recruiter']['profile_photo']!=''){
			$this->Image->delete_image($profilePhoto['Recruiter']['profile_photo'],'recruiter_images');
		}
		$arrProfessionalData=array();
		$arrProfessionalData['Recruiter']['profile_photo']='';
		$transDetail=$this->Recruiter->save($arrProfessionalData,false);
		if($transDetail){
			$this->redirect(array('action' => 'profile'));
		}

	}
	function delete_uploaded_image(){
		$this->layout='ajax';
		
		if(!$this->Session->check('Recruiter')){
			echo "error";die;
		}
		if($this->request->data['counter']==1){
			$prof=$this->Session->read('Recruiter');
			$this->Recruiter->id=$prof['Recruiter']['id'];
			$profilePhoto = $this->Recruiter->findById($prof['Recruiter']['id'], array('fields'=>'profile_photo'));
			if($profilePhoto['Recruiter']['profile_photo']!=''){
				$this->Image->delete_image($profilePhoto['Recruiter']['profile_photo'],'recruiter_images');
			}
			$arrProfessionalData=array();
			$arrProfessionalData['Recruiter']['profile_photo']='';
			$transDetail=$this->Recruiter->save($arrProfessionalData,false);
		}else{
			$upload_dir = WWW_ROOT.str_replace("/", DS, "files/temp_recruiter_images/");
			$uploaddir = $upload_dir.DS;
			unlink($uploaddir."recruiter_".$this->request->data['profImageName']);
		}
		echo 'success';die;
	}


	function upload_profile_image(){

		$this->layout='ajax';


		if ($_FILES){

			$upload_dir = WWW_ROOT.str_replace("/", DS, "files/temp_recruiter_images/");
			$uploaddir = $upload_dir.DS;
			//$uploaddir = $this->webroot.'files/temp_professional_images/';
			$file = $uploaddir ."recruiter_".basename($_FILES['uploadfile']['name']);
			$file_name= "recruiter_".$_FILES['uploadfile']['name'];
			$imgName=$this->Image->upload_image_and_thumbnail($_FILES['uploadfile'],500,300,100,100, "temp_recruiter_images");
			if($imgName!=''){
				echo "success";
			} else {
				echo "error";
			}
				
			die;
		}

	}
	function crop_profile_image($page=null){
		$this->layout='ajax';

		if ($this->request->is('post') || $this->request->is('put')){
			$targ_w = 220;
			$targ_h = 250;
			$jpeg_quality = 90;
			$upload_dir = WWW_ROOT.str_replace("/", DS, "files/temp_recruiter_images/");
			if(isset($_POST['counter']) && $_POST['counter']==2){
				$upload_dir = WWW_ROOT.str_replace("/", DS, "files/temp_recruiter_images/");
			}
			if(isset($_POST['counter']) && $_POST['counter']==1){
				$upload_dir = WWW_ROOT.str_replace("/", DS, "files/recruiter_images/");
			}
			$uploaddir = $upload_dir.DS;
			$src =  $uploaddir ."recruiter_".$_POST['profImageName'];
			$targetFileName="recruiter_".mt_rand(100000,999999).'_'.$_POST['profImageName'];
			if(isset($_POST['counter']) && $_POST['counter']==2){
				$src =  $uploaddir ."recruiter_".$_POST['profImageName'];
				$targetFileName="recruiter_".mt_rand(100000,999999).'_'.$_POST['profImageName'];
			}
			if(isset($_POST['counter']) && $_POST['counter']==1){
				$src =  $uploaddir.$_POST['profImageName'];
				$targetFileName=mt_rand(100000,999999).'_'.$_POST['profImageName'];
			}
			$target =  $uploaddir.$targetFileName;
			//$img_r = imagecreatefromjpeg($src);
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
			$ext = strtolower(substr(basename($_POST['profImageName']), strrpos(basename($_POST['profImageName']), ".") + 1));
			$img_r = "";
			if($ext == "png"){
				$img_r = imagecreatefrompng($src);
			}elseif($ext == "jpg" || $ext == "jpeg"){
				$img_r = imagecreatefromjpeg($src);
			}elseif($ext == "gif"){
				$img_r = imagecreatefromgif($src);
			}

			imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
			$targ_w,$targ_h,$_POST['w'],$_POST['h']);
			$result='';
			if($ext == "png" || $ext == "PNG"){
				$result=imagepng($dst_r,$target,0);
			}elseif($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG"){
				$result=imagejpeg($dst_r,$target,$jpeg_quality);
			}elseif($ext == "gif" || $ext == "GIF"){
				$result=imagegif($dst_r,$target);
			}
			if(trim($page)=='profile'){
				$prof=$this->Session->read('Recruiter');
				$arrProfessionalData=array();
				$this->Recruiter->id=$prof['Recruiter']['id'];
				$profilePhoto = $this->Recruiter->findById($prof['Recruiter']['id'], array('fields'=>'profile_photo'));
				if(!empty($_POST['profImageName'])){
					if($profilePhoto['Recruiter']['profile_photo']!=''){
						$this->Image->delete_image($profilePhoto['Recruiter']['profile_photo'],'recruiter_images');
					}

					if(isset($_POST['counter']) && $_POST['counter']==2){
						$dest_dir = WWW_ROOT.str_replace("/", DS, "files/recruiter_images/");
						$destdir = $dest_dir.DS;
						$destinationPath=$destdir.$targetFileName;
						copy($target, $destinationPath);
					}
					$arrProfessionalData['Recruiter']['profile_photo']=$targetFileName;
				}
				$transDetail=$this->Recruiter->save($arrProfessionalData,false);
				unlink($src);
				if(isset($_POST['counter']) && $_POST['counter']==2){
					unlink($target);
				}
				if($transDetail){
					echo 'success';die;
				}
			}
				
			if($result!=''){
				unlink($src);
				echo $targetFileName;
			}
			die;

		}
	}
	function validateCaptcha($val, $params){
		$caseInsensitive = true;
		// print_r($val);
		/* if ($caseInsensitive) {
		 $val = strtoupper($val);
		 } */
		//print_r($val);
		 
		//php-captcha.inc.php
		if(!defined('CAPTCHA_SESSION_ID'))
		define('CAPTCHA_SESSION_ID', 'php_captcha');
		 
		if (!empty($_SESSION[CAPTCHA_SESSION_ID]) && $val == $_SESSION[CAPTCHA_SESSION_ID]) {
			// clear to prevent re-use
			unset($_SESSION[CAPTCHA_SESSION_ID]);

			return true;
		}

		return false;
	}
	function add_client_lists(){
		$this->layout='ajax';

		/*--format data--*/
		if ($this->request->is('post') || $this->request->is('put')){
				
			if(!empty($this->request->data) && !empty($this->request->data['id'])){

				$arrSuccess=array();
				$arrProfessionalData=array('RecruiterClient'=>array(
						'recruiter_id'=>$this->request->data['id'],
						'company_name'=>$this->request->data['comp_name'],
						'company_website'=>$this->request->data['comp_website'],
						'type_of_hire'=>$this->request->data['hire_type'],
						'candidate_placed'=>$this->request->data['candidate'],
						'client_added_date'=>date('Y-m-d H:i:s'),
						'client_modified_date'=>date('Y-m-d H:i:s')
				));
				$this->RecruiterClient->create();
				$transDetail=$this->RecruiterClient->save($arrProfessionalData,false);
				if($transDetail){
					$arrSuccess['Success']='Client has been added successfully';
					$arrSuccess['company']=$arrProfessionalData['RecruiterClient']['company_name'];
					$arrSuccess['type_of_hire']=$arrProfessionalData['RecruiterClient']['type_of_hire'];
					$arrSuccess['candidate']=$arrProfessionalData['RecruiterClient']['candidate_placed'];
				}
				echo json_encode($arrSuccess);
			}
				
		}
		die;

	}

/*	function professional_search_old() {
		$this->layout='ajax';
		if(!$this->Session->check('Recruiter')){
			echo "error";die;
		}
		
		
		if (count($this->request->data) == 0)
		  $this->request->data = $this->passedArgs;
		if(count($this->request->data)==0)
		  $this->request->data = $this->request->query;

		$searchQuery=$this->request->data['search_prof'];
		$this->loadModel('Professional');
		if($searchQuery!=''){
			$condition=array('AND'=>array(
					 'OR' => array(
			array('Professional.first_name LIKE' => '%'.trim($searchQuery).'%'),
			array('Professional.last_name LIKE' => '%'.trim($searchQuery).'%'),
			array('CONCAT(Professional.first_name," ",Professional.last_name) LIKE' => '%'.trim($searchQuery).'%'),
			array('Professional.current_company LIKE' => '%'.trim($searchQuery).'%'),
			array('Professional.current_location LIKE' => '%'.trim($searchQuery).'%')
			),'Professional.status'=>1)
			);
				
		}
		$other=array();
		if(isset($this->request->data['icons']))
		{
			$icons=$this->request->data['icons'];
			$oval=null; $flag=0;
			foreach($icons as $key=>$ics)
			{
				if($ics=='1')
				{	$oval=$key;
				$flag=1;
				}
			}
			if($flag==1)
			{
				switch($oval)
				{
					case '1': $other['AND']=array('Professional.profile_status' => 'NO');	break;
					case '2': $other['AND']=array('Professional.profile_status' => 'IN');	break;
					case '3': $other['AND']=array('Professional.profile_status' => 'U');	break;
					case '4': $other['AND']=array('AND'=>array('Professional.uploaded_resumes  != ' => '','Professional.online_resume_links  != ' => ''));	break;
					case '5': $other['AND']=array('Professional.security_clear' => 'Yes');	break;
					case '6': $other['AND']=array('Professional.security_clear' => 'Yes');	break;
					case '7': $other['AND']=array('Professional.phone_nbr !=' => '');	break;
				}
				$mix=array_merge($condition['AND'],$other['AND']);
				$mixconditions=array('AND'=>$mix);
			}else{
				$mixconditions=$condition;
			}
		}

		if($this->request->data['experience'] && $this->request->data['currentLoc']){			
			$page=$this->paginate=array('Professional'=> array(
			'limit'=>10,
			'conditions' =>$mixconditions,
			'order'=>array(
				'Professional.work_experience'=>$this->request->data['expOrder'],
				'Professional.current_location'=>'asc'
				)
				));
		}else if($this->request->data['experience'])	{
			$range = explode('-',trim($this->request->data['expRange']));
			if(count($range)>1)   {
			    $other['AND']=array('Professional.work_experience BETWEEN ? AND ?' => $range);
			}
			elseif($range[0] == '281')  {
			    $other['AND']=array('Professional.work_experience > ' => $range[0]);
			}
			else  {
			    $other['AND']=array('Professional.work_experience > ' => 0);
			}
			$mix=array_merge($condition['AND'],$other['AND']);
			$mixconditions=array('AND'=>$mix);
//			print_r($mixconditions); die;

			$page=$this->paginate=array('Professional'=> array(
			'limit'=>10,
			'conditions' =>$mixconditions
//			'order'=>array('Professional.work_experience'=>$this->request->data['expOrder'])
			));
		}else if($this->request->data['currentLoc']){
			$page=$this->paginate=array('Professional'=> array(
			'limit'=>10,
			'conditions' =>$mixconditions,
			'order'=>array('Professional.current_location'=>'asc')
			));
		}else{
			$page=$this->paginate=Array('Professional'=> array(
			'limit'=>10,
			'conditions' =>$mixconditions
			));
		}
		$profDetail=$this->paginate('Professional');
		//print_r($profDetail);
		if(count($profDetail)>0){
			$this->set('searchData',$profDetail);
			$this->set('filterBy',$oval);
				
		}else{
			echo 'No Record Found';die;
		}
			
	}*/

	function professional_search() {
		$this->layout='ajax';
		if(!$this->Session->check('Recruiter')){
			echo "error";die;
		}
//		  echo '<pre>'; print_r($this->request->data); die;
			if (count($this->request->data) == 0)
			  $this->request->data = $this->passedArgs;
			if(count($this->request->data)==0)
			  $this->request->data = $this->request->query;
	
			$searchQuery=$this->request->data['search_prof'];
			$this->loadModel('Professional');
			if($searchQuery!=''){
				$searchQuery = explode(',',$searchQuery);
				$condition = array();
				foreach($searchQuery as $query) {
					if(empty($query)) {
						continue;
					}
					$cond[]=array('OR' => array(
														array('Professional.first_name LIKE' => trim($query)),
														array('Professional.last_name LIKE' => trim($query)),
														array('CONCAT(Professional.first_name," ",Professional.last_name) LIKE' => trim($query)),
														array('Professional.current_company LIKE' => trim($query)),
														array('Professional.current_location LIKE' => trim($query)),
														array('Professional.current_location LIKE' => trim($query).',%'),
														array('Professional.current_location LIKE' => '%, '.trim($query)),
														array('Professional.current_location LIKE' => '%, '.trim($query).',%'),
														array('Professional.locations_for_interesting_op LIKE' => trim($query)),
														array('Professional.locations_for_interesting_op LIKE' => trim($query).',%'),
														array('Professional.locations_for_interesting_op LIKE' => '%, '.trim($query)),
														array('Professional.locations_for_interesting_op LIKE' => '%, '.trim($query).',%'),
														array("Professional.skills LIKE " => trim($query)),
														array("Professional.skills LIKE " => trim($query).',%'),
														array("Professional.skills LIKE " => '%, '.trim($query)),
														array("Professional.skills LIKE " => '%, '.trim($query).',%'),
										   )
					       );
				}
			}
			$condition['OR'] = $cond;
			//echo '<pre>'; print_r($condition); die;
			$condition['AND']['Professional.status']=1;
			if(isset($this->request->data['status_icons'])){
				$condition['AND']['AND']['OR'][]=array('Professional.profile_status ' => 'X');
				$status=$this->request->data['status_icons'];
				$profile=array();
				foreach($status as $key=>$ics)
				{
					if(!empty($ics)) {
						switch($key)
						{
							case '1': $condition['AND']['AND']['OR'][]=array('Professional.profile_status ' => 'NO');break;
							case '2': $condition['AND']['AND']['OR'][]=array('Professional.profile_status ' => 'IO');break;
							case '3': $condition['AND']['AND']['OR'][]=array('Professional.profile_status ' => 'U');break;
						}
					}
				}
			}
			if(!empty($this->request->data['status_resume'])){
				$condition['AND'][]=array('AND'=>array('Professional.uploaded_resumes  != ' => '','Professional.online_resume_links  != ' => ''));
			}
			if(!empty($this->request->data['status_security'])){
				$condition['AND'][]=array('Professional.security_clear' => 'Yes');
			}
			if(!empty($this->request->data['status_phone'])){
				$condition['AND'][]=array('Professional.mode_of_contact ' => 'Phone');
			}
			if(!empty($this->request->data['experience']))	{
				$range = explode('-',trim($this->request->data['experience']));
				if(is_numeric($range[0]) && is_numeric($range[1]))   {
					$condition['AND'][]=array('Professional.work_experience BETWEEN ? AND ?' => $range);
				}
				elseif(is_numeric($range[0]) && !is_numeric($range[1]))  {
					$condition['AND'][]=array('Professional.work_experience > ' => trim($range[0]));
				}
				elseif(!is_numeric($range[0]) && is_numeric($range[1])) {
					$condition['AND'][]=array('Professional.work_experience < ' => trim($range[1]));
				}				
				unset($range);
			}
			//pr($this->request->data['availability']);die;
			if(!empty($this->request->data['availability'])) {
			  $range = explode('-',$this->request->data['availability']);
			  	
			  if(count($range) > 1) {
				   $dateRange = array(date('Y-m-d 00:00:00',strtotime("+".$range[0]." day")),date('Y-m-d 00:00:00',strtotime("+".$range[1]." day")));
				   $condition['AND'][]['OR'] = array('Professional.joining_by_day BETWEEN ? AND ?' => $range,'Professional.joining_by_date BETWEEN ? AND ?' => $dateRange);
			  }
			  else if($range[0] == 61) {
				   $condition['AND'][]['OR'] = array('Professional.joining_by_day >' => $range[0],'Professional.joining_by_date >' => date('Y-m-d 00:00:00',strtotime("+60 day")));
			  }
			}
			
			$preLoc = array();
			if(!empty($this->request->data['preferred'])) {
				foreach($this->request->data['preferred'] as $pre) {
					$preLoc[] = array('OR'=>array('Professional.locations_for_new_op LIKE' => '%'.$pre.'%',													
												  'Professional.locations_for_interesting_op LIKE' => '%'.$pre.'%'));
				}
			}
			$currLoc = array();

			if(!empty($this->request->data['current'])) {
				foreach($this->request->data['current'] as $curr) {
					$currLoc[] = 'Professional.current_location LIKE "%'.$curr.'%"';
				}
			}
			

			$condition['AND'][]['OR'] = array_merge($preLoc,$currLoc);
			$limit = $this->request->data['dataRange'];

			$this->paginate=array(
					   'conditions'=>$condition,
					   'limit'=>$limit,
					   'fields'=>array('Professional.id','Professional.first_name','Professional.last_name','Professional.profile_status','Professional.security_clear','Professional.joining_by_date','Professional.joining_by_day','Professional.immediate_joining_flag','Professional.current_company','Professional.company_website','Professional.current_location','Professional.work_experience','Professional.skills','Professional.locations_for_interesting_op','Professional.locations_for_new_op','Professional.profile_photo','Professional.online_profiles','Professional.online_profiles','Professional.uploaded_resumes','Professional.online_resume_links')
			);
			
			
			$profDetail=$this->paginate('Professional');
			$count = $this->Professional->find('count',array('conditions'=>$condition,'fields'=>array('Professional.id')));

			if(count($profDetail)>0){
				$this->set('formData',$this->request->data);
				$this->set('searchData',$profDetail);
				$this->set('filterBy',$oval);
				$this->set('totalFilter',$count);
				$this->set('listRange',$this->request->data['dataRange']);
				
			}else{
				echo 'No Record Found';die;
			}
//		}
			
	}
 
	public function change_status()
	{
		if(!$this->Session->check('Recruiter')){
			$this->redirect(array('controller'=>'home'));	
		}
		$this->Recruiter->id=$this->request->data['id'];
		$this->Recruiter->saveField('status',$this->request->data['status']);
		die;
			
	}

	public function admin_rec_change_status()
	{
		$this->Recruiter->id=$this->request->data['id'];
		if($this->request->data['field'] == 'flag_search')
		    $this->Recruiter->saveField('flag_search',$this->request->data['status']);
		else
  		   	$this->Recruiter->saveField('status',$this->request->data['status']);
		die;
			
	}

  public function location_autocomplete()
    {
        $this->layout='ajax';
		$this->loadModel('PreferredLocation');
		$this->PreferredLocation->recursive = -1;
			$response = Array();
			$cityResults = $this->PreferredLocation->find('all', array('fields' => array('PreferredLocation.location'),
    'conditions' => array('PreferredLocation.location LIKE ' => $this->request->query['term'] . '%')
			));
			$this->loadModel('Country');
			$this->Country->recursive=0;
			$countries=$this->Country->find('all',array('fields' => array('Country.country'),
								'conditions' => array('Country.country LIKE ' => $this->request->query['term'] . '%') ));
			$i=1;
			foreach($countries as $cntry)
			{
				$response[$i]=$cntry['Country']['country'];
				$i++;
			}


			foreach($cityResults as $ciresult) {


				$response[$i] = $ciresult['PreferredLocation']['location'];
				$i++;

			}
			echo json_encode($response);
			die;
	}

   

}
