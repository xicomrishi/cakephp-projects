<?php
App::import('Vendor',array('functions'));
class ProfessionalsController extends AppController {

	public $name = 'Professionals';
	public $layout='default';
	public $helpers = array('Form', 'Html', 'Js','Core','Session');
	public $components=array('Session','Access','Core','Email','Captcha','Image','Upload','RequestHandler');
	public $uses=array('Professional','City','Country','Skill','TempProfessional','PreferredLocation','EmailTemplate');


	function beforeFilter(){
		$isAdmin=Configure::read('Routing.prefixes');
		$pos = strpos($_SERVER['REQUEST_URI'], $isAdmin[0]);
		if($pos == true)
		{
			$this->Access->isValidUser();
		}
	}

	/*--admin actions--*/

	function admin_index() {
		$this->layout='admin';
		if($this->params['url'])
		{
				
			$searchQuery=$this->params['url']['admin_search_prof'];

			if($searchQuery!=''){
				$condition=array(
					 'OR' => array(
				array('Professional.first_name LIKE' => '%'.trim($searchQuery).'%'),
				array('Professional.last_name LIKE' => '%'.trim($searchQuery).'%'),
				array('CONCAT(Professional.first_name," ",Professional.last_name) LIKE' => '%'.trim($searchQuery).'%'),
				array('Professional.current_company LIKE' => '%'.trim($searchQuery).'%'),
				array('Professional.current_location LIKE' => '%'.trim($searchQuery).'%')
				)
					
				);
					
			}
			$this->paginate=array('order'=>array('Professional.id'=>'DESC'),'conditions'=>$condition,'limit'=>20);
				
		}else{
			$this->paginate=array('order'=>array('Professional.id'=>'DESC'));
		}

		$this->set('Professionals', $this->paginate('Professional'));
	}
	function admin_unregistered_professionals() {
		$this->layout='admin';
		if($this->params['url'])
		{
				
			$searchQuery=$this->params['url']['admin_search_prof'];

			if($searchQuery!=''){
				$condition=array(
					'TempProfessional.status' => 'Signup Not Completed',
					 'OR' => array(
				array('TempProfessional.first_name LIKE' => '%'.trim($searchQuery).'%'),
				array('TempProfessional.last_name LIKE' => '%'.trim($searchQuery).'%'),
				array('CONCAT(TempProfessional.first_name," ",TempProfessional.last_name) LIKE' => '%'.trim($searchQuery).'%'),
				array('TempProfessional.email LIKE' => '%'.trim($searchQuery).'%')

				)
					
				);
					
			}
			$this->paginate=array('order'=>array('TempProfessional.added_date'=>'DESC'),'conditions'=>$condition,'limit'=>20);
				
		}else{
			$page=$this->paginate=array('TempProfessional'=> array('limit'=>20,
		'conditions' =>array('status' => 'Signup Not Completed'),
		'order'=>array('TempProfessional.added_date'=>'DESC')
			));
		}

		$this->set('TempProfessional', $this->paginate('TempProfessional'));
	}


	function admin_view($id = null) {
		$this->layout='admin';
		if (!$id) {
			$this->Session->setFlash(__('Invalid Professional', true),'default',array('class'=>'error'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('Professional', $this->Professional->read(null, $id));

	}



	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for professional', true),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Professional->delete($id)) {

			$this->Session->setFlash(__('The professional deleted successfully', true),'default',array('class'=>'success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('The professional could not be deleted', true),'default',array('class'=>'error'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_delete_Unregister_professional($id = null) {

		if (!$id) {
			$this->Session->setFlash(__('Invalid id for unregistered professional', true),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'unregistered_professionals'));
		}
		if ($this->TempProfessional->delete($id)) {

			$this->Session->setFlash(__('The unregistered professional deleted successfully', true),'default',array('class'=>'success'));
			$this->redirect(array('action'=>'unregistered_professionals'));
		}
		$this->Session->setFlash(__('The unregistered professional could not be deleted', true),'default',array('class'=>'error'));
		$this->redirect(array('action' => 'unregistered_professionals'));
	}

	/*--[end]admin actions--*/


	/*--public actions--*/
	function signup(){
		
		if(empty($this->request->data)){
			$this->redirect(array('controller'=>'home'));
		}
		/*-- index page form handling--   First phase of registration*/
		if($this->request->is('post') && isset($this->request->data['User']['index_counter'])){				
			$this->request->data['Professional']=$this->request->data['User'];
			unset($this->request->data['User']);
			$tempUser=$this->TempProfessional->findByEmail($this->request->data['User']['email']);		
			if(empty($tempUser)){
				$this->Professional->validate['first_name']=array('rule' => 'notEmpty','message' => 'Please enter the first name.');
				$this->Professional->validate['last_name']= array('rule' => 'notEmpty','message' => 'Please enter the last name.');
				$this->Professional->set($this->request->data);			
				if(!$this->Professional->validates(array('fieldList'=>array('first_name','last_name','email')))){			
				
					$homeError=array();
					$homeError['fname']=$this->request->data['Professional']['first_name'];
					$homeError['lname']=$this->request->data['Professional']['last_name'];
					$homeError['email']=$this->request->data['Professional']['email'];
					$homeError['user_type']=$this->request->data['Professional']['user_type'];
					$errMsg='';
					if(isset($this->Professional->validationErrors['first_name'])){
						$errMsg=$this->Professional->validationErrors['first_name'][0].'<br/>';
					}
					if(isset($this->Professional->validationErrors['last_name'])){
						$errMsg.=$this->Professional->validationErrors['last_name'][0].'<br/>';
					}
					if(isset($this->Professional->validationErrors['email'])){
						$errMsg.=$this->Professional->validationErrors['email'][0];
					}
					
					$homeError['msg']=$errMsg;
					$this->Session->write('homeError',$homeError);
					$this->redirect(array('controller'=>'home','action' => 'index'));
				
				}else {
					$this->TempProfessional->create();
					$arrTempUser=array('TempProfessional'=>array(
						'first_name'=>trim($this->request->data['Professional']['first_name']),
						'last_name'=>trim($this->request->data['Professional']['last_name']),
						'email'=>$this->request->data['Professional']['email'],
						'added_date'=>date('Y-m-d H:i:s')
					));
					$this->TempProfessional->save($arrTempUser,false);
				 }
			}
		}
		$this->set('IndexData',$this->request->data['Professional']);
		/*-- index page form handling--  Second phase of registration*/
		if (($this->request->is('post') || $this->request->is('put')) && isset($this->request->data['Professional']['professional_signup'])) {
			$this->Professional->create();
			$this->Professional->set($this->request->data);
			if(!$this->Professional->validates()){
				$validationErr=true;
			}
			/*--validate captcha--*/
			if(!$this->validateCaptcha($this->request->data['Professional']['captcha_value'])){
				$validationErr=true;
				$captchaError=array('captcha_value'=>array('Please enter the correct numbers / alphabets / word in the captcha'));
			}
			/*--validate files before upload--*/
			try{
				//validate resume doc files
				if(!empty($this->request->data['Professional']['uploaded_resumes']['resume_doc']['name'])){
					$this->Upload->change_allowed_types(array('application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword|application/x-msword|application/vnd.msword|application/vnd.ms-word|application/doc|application/winword|application/word|zz-application/zz-winassoc-doc','application/msword'));
					$this->Upload->validate($this->request->data['Professional']['uploaded_resumes']['resume_doc']);
				}
				//validate resume pdf files
				if(!empty($this->request->data['Professional']['uploaded_resumes']['resume_pdf']['name']) && !empty($this->request->data['Professional']['uploaded_resumes']['resume_pdf']['size'])){
					$this->Upload->change_allowed_types(array('application/pdf'));
					$this->Upload->validate($this->request->data['Professional']['uploaded_resumes']['resume_pdf']);
				}
			}catch(Exception $exp){
				$captchaError=array('uploaded_resumes'=>array($exp->getMessage()));
			}
			/*--[end]validate files before upload--*/
			if($validationErr){
				$arrErrors=array();
				if(isset($this->Professional->validationErrors)){
					$arrErrors=array_merge($arrErrors,$this->Professional->validationErrors);
				}
				if(isset($captchaError)){
					$arrErrors=array_merge($arrErrors,$captchaError);
				}
				if(!empty($this->request->data['Professional']['uploaded_resumes']['resume_doc']['name']) || !empty($this->request->data['Professional']['uploaded_resumes']['resume_pdf']['name'])){
					$this->set('ErrorsResume','1');
				}
				$this->set('Errors',$arrErrors);
			}else{
				$arrProfessionalData=array('Professional'=>array(
						'email'=>$this->request->data['Professional']['email'],
						'password'=>$this->request->data['Professional']['password'],
						'current_company'=>$this->request->data['Professional']['current_company'],
						'company_website'=>$this->request->data['Professional']['company_website'],
						'current_location'=>$this->request->data['Professional']['current_location'],
						'profile_status'=>$this->request->data['Professional']['profile_status'],
						'locations_for_new_op'=>$this->request->data['Professional']['locations_for_new_op'],
						'locations_for_interesting_op'=>$this->request->data['Professional']['locations_for_interesting_op'],
						'do_not_disturb_flag'=>$this->request->data['Professional']['do_not_disturb_flag'],
						'do_not_disturb_year_flag'=>$this->request->data['Professional']['do_not_disturb_year_flag'],
						'do_not_disturb_date'=>date('Y-m-d',strtotime($this->request->data['Professional']['do_not_disturb_date'])),
						'message_for_recruiters'=>$this->request->data['Professional']['message_for_recruiters'],
						'country'=>$this->request->data['Professional']['country'],
						'skills'=>$this->request->data['Professional']['skills'],
						'nationality'=>$this->request->data['Professional']['nationality'],				
						'mode_of_contact'=>$this->request->data['Professional']['mode_of_contact'],
						'ctc_currency'=>$this->request->data['Professional']['ctc_currency'],
						'ctc_cycle'=>$this->request->data['Professional']['ctc_cycle'],
						'immediate_joining_flag'=>$this->request->data['Professional']['immediate_joining_flag'],
						'joining_by_day'=>$this->request->data['Professional']['joining_by_day'],
						'display_to_recruiters'=>$this->request->data['Professional']['display_to_recruiters'],
						'security_clear'=>$this->request->data['Professional']['security_clear'],
						'security_type_specification'=>$this->request->data['Professional']['security_type_specification'],
						'profile_added_date'=>date('Y-m-d H:i:s'),
						'profile_modified_date'=>date('Y-m-d H:i:s')
				));
				if(empty($this->request->data['Professional']['ctc_cycle'])){
					$arrProfessionalData['Professional']['ctc_cycle']='Year';
				}
				$name=explode(" ",$this->request->data['Professional']['name']);
				$firstName=$name[0];
				$lastName=$name[1];
				if(count($name)>2){
					for($i=2;$i<count($name);$i++){
						$lastName.=" ".$name[$i];
					}
				}
				$arrProfessionalData['Professional']['first_name']=$firstName;
				$arrProfessionalData['Professional']['last_name']=$lastName;
				//joining date
				if(!empty($this->request->data['Professional']['joining_by_date'])){
					$arrProfessionalData['Professional']['joining_by_date']=date('Y-m-d',strtotime($this->request->data['Professional']['joining_by_date']));
				}else{
					$arrProfessionalData['Professional']['joining_by_date']='';
				}
				//do not disturb date
				if($this->request->data['Professional']['do_not_disturb_year_flag']==1){
					$dateAfterOneYear=date("Y-m-d",strtotime("+1 year",strtotime(date('Y-m-d'))));
					$arrProfessionalData['Professional']['do_not_disturb_date']=$dateAfterOneYear;
				}
				// convert work exp in months
				$arrProfessionalData['Professional']['work_experience']=$this->request->data['Professional']['work_experience']['month'];
				if(!empty($this->request->data['Professional']['work_experience']['year'])){
					$arrProfessionalData['Professional']['work_experience']=intval($arrProfessionalData['Professional']['work_experience'])+
					(intval($this->request->data['Professional']['work_experience']['year'])*12);
				}
				$phoneNbr=$this->request->data['Professional']['phone_nbr']['number'];
				if(!empty($this->request->data['Professional']['phone_nbr']['code'])){
					$phoneNbr=$this->request->data['Professional']['phone_nbr']['code']."-".$phoneNbr;
				}
				$arrProfessionalData['Professional']['phone_nbr']=$phoneNbr;
				$arrProfessionalData['Professional']['online_profiles']=base64_encode(serialize($this->request->data['Professional']['online_profiles']));
				$res_links=$this->request->data['Professional']['online_resume_links'];
				$resume = array();
				if(empty($res_links['goole_doc']) || ($res_links['goole_doc'] == 'http://')) {
					unset($this->request->data['Professional']['online_resume_links']['goole_doc']);
				}
				if(empty($res_links['visual_cv']) || ($res_links['visual_cv'] == 'http://')) {
					unset($this->request->data['Professional']['online_resume_links']['visual_cv']);
				}
				if(empty($res_links['resume_bucket']) || ($res_links['resume_bucket'] == 'http://')) {
					unset($this->request->data['Professional']['online_resume_links']['resume_bucket']);
				}
				if(empty($res_links['resume_dot']) || ($res_links['resume_dot'] == 'http://')) {
					unset($this->request->data['Professional']['online_resume_links']['resume_dot']);
				}
				if(!empty($res_links['goole_doc']) || !empty($res_links['visual_cv']) || !empty($res_links['resume_bucket']) || !empty($res_links['resume_dot'])){
					$arrProfessionalData['Professional']['online_resume_links']=base64_encode(serialize($this->request->data['Professional']['online_resume_links']));
				}else{
					$arrProfessionalData['Professional']['online_resume_links']='';
				}
				//convert INR currency in Thousands
				if(strtolower($this->request->data['Professional']['ctc_currency'])=='inr'){
					$arrProfessionalData['Professional']['current_ctc']=
					(intval($this->request->data['Professional']['current_ctc']['lacs'])*100000)+(intval($this->request->data['Professional']['current_ctc']['thousands'])*1000);
				}else{
					$arrProfessionalData['Professional']['current_ctc']=$this->request->data['Professional']['current_ctc']['dollar'];
				}
				/*--save professional data--*/
				try{
					/*--upload profile images--*/
					if(!empty($this->request->data['Professional']['profile_photo'])){
						$upload_dir = WWW_ROOT.str_replace("/", DS, "files/temp_professional_images/");
						$uploaddir = $upload_dir.DS;
						$sourcePath=$uploaddir.$this->request->data['Professional']['profile_photo'];
						$dest_dir = WWW_ROOT.str_replace("/", DS, "files/professional_images/");
						$destdir = $dest_dir.DS;
						$destinationPath=$destdir.$this->request->data['Professional']['profile_photo'];
						copy($sourcePath, $destinationPath);
						/*$imgName=$this->Image->upload_image_and_thumbnail($this->request->data['Professional']['profile_photo'],200,205,100,100, "professional_images");*/
						$arrProfessionalData['Professional']['profile_photo']=$this->request->data['Professional']['profile_photo'];
						unlink($sourcePath);
					}else{
						$arrProfessionalData['Professional']['profile_photo']='';
					}
					/*--[end]upload profile images--*/
					$arrUplodedResumes=array();
					/*--upload resume doc files--*/
					if(!empty($this->request->data['Professional']['uploaded_resumes']['resume_doc']['name'])){
						$this->Upload->change_allowed_types(array('application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword|application/x-msword|application/vnd.msword|application/vnd.ms-word|application/doc|application/winword|application/word|zz-application/zz-winassoc-doc','application/msword'));
						$fName=$this->Upload->upload($this->request->data['Professional']['uploaded_resumes']['resume_doc'],"files/professional_docs");
						$arrUplodedResumes['doc']=$fName;
					}else{
						$arrUplodedResumes['doc']='';
					}
					/*--[end]upload resume doc files--*/
					/*--upload resume pdf files--*/
					if(!empty($this->request->data['Professional']['uploaded_resumes']['resume_pdf']['name'])){
						$this->Upload->change_allowed_types(array('application/pdf'));
						$pfName=$this->Upload->upload($this->request->data['Professional']['uploaded_resumes']['resume_pdf'],"files/professional_docs");
						$arrUplodedResumes['pdf']=$pfName;
					}else{
						$arrUplodedResumes['pdf']='';
					}
					/*--[end]upload resume pdf files--*/
					if(!empty($arrUplodedResumes['doc']) || !empty($arrUplodedResumes['pdf']))
					$arrProfessionalData['Professional']['uploaded_resumes']=base64_encode(serialize($arrUplodedResumes));
					else
					$arrProfessionalData['Professional']['uploaded_resumes']='';
				}catch(Exeption $e){
					//echo $e->getMessage();
				}
				/*--save professional data--*/
				$arrProfessionalData['Professional']['password']=md5($this->request->data['Professional']['password']);
				$arrProfessionalData['Professional']['last_login_ip']=$this->request->clientIp();
				$arrProfessionalData['Professional']['last_login_date']=date('Y-m-d H:i:s');
				$transDetail=$this->Professional->save($arrProfessionalData,false);
/*********************    Signup mail           ***********************/					
					$to=$arrProfessionalData['Professional']['email'];
					$name=$arrProfessionalData['Professional']['first_name'].' '.$arrProfessionalData['Professional']['last_name'];;  
					$subject="Successfully account created.";
					$template = $this->EmailTemplate->find('first',
						 array('conditions' => array('template_key'=> 'signup_email',
						 'status' =>'Active')));
					if($template){	
						$arrFind=array('{name}','{email}','{password}');
						$arrReplace=array($name,$to,$this->request->data['Professional']['password']);
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
//						$this->Email->htmlMessage=$content;
						$this->Email->delivery = 'smtp';
						$this->Email->send();
					}catch(Exception $e){
						echo "<h4 class='error forgot_pass'>The email could not be sent.Please contact to admin.</h4>";
						die;
					}

				$tempUserDetails=$this->TempProfessional->findByEmail($this->request->data['Professional']['email']);
				if(count($tempUserDetails)>0){
					$this->TempProfessional->id=$tempUserDetails['TempProfessional']['id'];
					$this->TempProfessional->save(array('status'=>'Signup Completed'));
				}
				if($transDetail){
					$this->Session->write('Professional',$transDetail);
					$this->Session->write('LoginStatus',1);
					$this->Session->setFlash(__('Your profile has been created successfully. Please login.',true),'default',array('class'=>'success'));
					$this->redirect(array('action' => 'profile'));
				}else{
					$this->Session->setFlash(__('The data could not be saved.Please try again.',true),'default',array('class'=>'error'));
				}
					

				/*--[end]save professional data--*/

			}
		}
	}

	function edit_profile(){
		$this->layout='default';
		if(!$this->Session->check('Professional')){
			$this->redirect(array('controller'=>'home'));
		}
		$prof=$this->Session->read('Professional');
		$profDetails=$this->Professional->findById($prof['Professional']['id']);


		//print_r($resume);die;
		$this->set('profDetails',$profDetails);

		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data['Professional'])) {
				
//			echo '<pre>'; print_r($this->request->data);die;
			$this->Professional->id=$prof['Professional']['id'];
			$this->request->data['Professional']['id']=$prof['Professional']['id'];
			$this->Professional->set($this->request->data);
				
			if(!$this->Professional->validates()){
				$validationErr=true;
			}

				
				
			/*--validate files before upload--*/
			try{

				//validate resume doc files
				if(!empty($this->request->data['Professional']['uploaded_resumes']['resume_doc']['name'])){
					$this->Upload->change_allowed_types(array('application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword'));
						
					$this->Upload->validate($this->request->data['Professional']['uploaded_resumes']['resume_doc']);
				}
				//validate resume pdf files
				if(!empty($this->request->data['Professional']['uploaded_resumes']['resume_pdf']['name'])){
					$this->Upload->change_allowed_types(array('application/pdf'));
					$this->Upload->validate($this->request->data['Professional']['uploaded_resumes']['resume_pdf']);
				}
					
			}catch(Exception $exp){
				$captchaError=array('uploaded_resumes'=>array($exp->getMessage()));
			}
			/*--[end]validate files before upload--*/
				
			if($validationErr){

				$arrErrors=array();

				if(isset($this->Professional->validationErrors)){
					$arrErrors=array_merge($arrErrors,$this->Professional->validationErrors);
				}

				if(isset($captchaError)){
					$arrErrors=array_merge($arrErrors,$captchaError);
				}

				$this->set('Errors',$arrErrors);

			}else{
				//print_r($this->request->data);die;
				$arrProfessionalData=array('Professional'=>array(
						'email'=>$this->request->data['Professional']['email'],
						'current_company'=>$this->request->data['Professional']['current_company'],
						'company_website'=>$this->request->data['Professional']['company_website'],
						'current_location'=>$this->request->data['Professional']['current_location'],
						'profile_status'=>$this->request->data['Professional']['profile_status'],
						'locations_for_new_op'=>$this->request->data['Professional']['locations_for_new_op'],
						'locations_for_interesting_op'=>$this->request->data['Professional']['locations_for_interesting_op'],
						'do_not_disturb_flag'=>$this->request->data['Professional']['do_not_disturb_flag'],
						'do_not_disturb_year_flag'=>$this->request->data['Professional']['do_not_disturb_year_flag'],
						'do_not_disturb_date'=>date('Y-m-d',strtotime($this->request->data['Professional']['do_not_disturb_date'])),
						'message_for_recruiters'=>$this->request->data['Professional']['message_for_recruiters'],
						'country'=>$this->request->data['Professional']['country'],
						'skills'=>$this->request->data['Professional']['skills'],
						'nationality'=>$this->request->data['Professional']['nationality'],				
						'mode_of_contact'=>$this->request->data['Professional']['mode_of_contact'],
						'ctc_currency'=>$this->request->data['Professional']['ctc_currency'],
						'ctc_cycle'=>$this->request->data['Professional']['ctc_cycle'],
						'immediate_joining_flag'=>$this->request->data['Professional']['immediate_joining_flag'],
						'joining_by_day'=>$this->request->data['Professional']['joining_by_day'],
						'display_to_recruiters'=>$this->request->data['Professional']['display_to_recruiters'],
						'security_clear'=>$this->request->data['Professional']['security_clear'],
						'security_type_specification'=>$this->request->data['Professional']['security_type_specification'],
						'profile_modified_date'=>date('Y-m-d H:i:s')
				));
					
				if(empty($this->request->data['Professional']['ctc_cycle'])){
					$arrProfessionalData['Professional']['ctc_cycle']='Year';
				}
				$name=explode(" ",$this->request->data['Professional']['name']);
				$firstName=$name[0];
				$lastName=$name[1];
					
				if(count($name)>2){
					for($i=2;$i<count($name);$i++){
						$lastName.=" ".$name[$i];
					}
				}
				$arrProfessionalData['Professional']['first_name']=$firstName;
				$arrProfessionalData['Professional']['last_name']=$lastName;
					
				//joining date
				if(!empty($this->request->data['Professional']['joining_by_date'])){
					$arrProfessionalData['Professional']['joining_by_date']=date('Y-m-d',strtotime($this->request->data['Professional']['joining_by_date']));
				}else{
					$arrProfessionalData['Professional']['joining_by_date']='';
				}
					
					
				//do not disturb date
				if($this->request->data['Professional']['do_not_disturb_year_flag']==1){
					$dateAfterOneYear=date("Y-m-d",strtotime("+1 year",strtotime(date('Y-m-d'))));
					$arrProfessionalData['Professional']['do_not_disturb_date']=$dateAfterOneYear;
				}
				// convert work exp in months
				$arrProfessionalData['Professional']['work_experience']=$this->request->data['Professional']['work_experience']['month'];
				if(!empty($this->request->data['Professional']['work_experience']['year'])){
					$arrProfessionalData['Professional']['work_experience']=intval($arrProfessionalData['Professional']['work_experience'])+
					(intval($this->request->data['Professional']['work_experience']['year'])*12);
				}
					
				$phoneNbr=$this->request->data['Professional']['phone_nbr']['number'];
				if(!empty($this->request->data['Professional']['phone_nbr']['code'])){
					$phoneNbr=$this->request->data['Professional']['phone_nbr']['code']."-".$phoneNbr;
				}
				$arrProfessionalData['Professional']['phone_nbr']=$phoneNbr;
					
				$arrProfessionalData['Professional']['online_profiles']=base64_encode(serialize($this->request->data['Professional']['online_profiles']));
					
					
				$res_links=$this->request->data['Professional']['online_resume_links'];
				if(empty($res_links['goole_doc']) || ($res_links['goole_doc'] == 'http://')) {
					unset($this->request->data['Professional']['online_resume_links']['goole_doc']);
				}
				if(empty($res_links['visual_cv']) || ($res_links['visual_cv'] == 'http://')) {
					unset($this->request->data['Professional']['online_resume_links']['visual_cv']);
				}
				if(empty($res_links['resume_bucket']) || ($res_links['resume_bucket'] == 'http://')) {
					unset($this->request->data['Professional']['online_resume_links']['resume_bucket']);
				}
				if(empty($res_links['resume_dot']) || ($res_links['resume_dot'] == 'http://')) {
					unset($this->request->data['Professional']['online_resume_links']['resume_dot']);
				}
				
				if(!empty($res_links['goole_doc']) || !empty($res_links['visual_cv']) || !empty($res_links['resume_bucket']) || !empty($res_links['resume_dot'])){
					$arrProfessionalData['Professional']['online_resume_links']=base64_encode(serialize($this->request->data['Professional']['online_resume_links']));
				}else{
					$arrProfessionalData['Professional']['online_resume_links']='';
				}
					
				//convert INR currency in Thousands
				if(strtolower($this->request->data['Professional']['ctc_currency'])=='inr'){
					$arrProfessionalData['Professional']['current_ctc']=
					(intval($this->request->data['Professional']['current_ctc']['lacs'])*100000)+(intval($this->request->data['Professional']['current_ctc']['thousands'])*1000);
				}else{
					$arrProfessionalData['Professional']['current_ctc']=$this->request->data['Professional']['current_ctc']['dollar'];
				}



				/*--save professional data--*/
				try{
						
					/*--upload profile images--*/
					 	
					/*if(!empty($this->request->data['Professional']['profile_photo']) && $prof['Professional']['profile_photo']!=$this->request->data['Professional']['profile_photo']){
						$upload_dir = WWW_ROOT.str_replace("/", DS, "files/temp_professional_images/");
						$uploaddir = $upload_dir.DS;
						$sourcePath=$uploaddir.$this->request->data['Professional']['profile_photo'];
						$dest_dir = WWW_ROOT.str_replace("/", DS, "files/professional_images/");
						$destdir = $dest_dir.DS;
						$destinationPath=$destdir.$this->request->data['Professional']['profile_photo'];
						copy($sourcePath, $destinationPath);

						$arrProfessionalData['Professional']['profile_photo']=$this->request->data['Professional']['profile_photo'];
						unlink($sourcePath);
						}else if(empty($this->request->data['Professional']['profile_photo'])){
						$arrProfessionalData['Professional']['profile_photo']='';
						}*/

					/*--[end]upload profile images--*/
					$arrUplodedResumes=array();
						
					/*--upload resume doc files--*/
					$resume=unserialize(base64_decode($prof['Professional']['uploaded_resumes']));
					if(!empty($this->request->data['Professional']['uploaded_resumes']['resume_doc']['name'])){
						$this->Upload->change_allowed_types(array('application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword'));
						$fName=$this->Upload->upload($this->request->data['Professional']['uploaded_resumes']['resume_doc'],"files/professional_docs");
						$arrUplodedResumes['doc']=$fName;

					}else if($resume['doc']!=''){

						$arrUplodedResumes['doc']=$resume['doc'];
					}else{
						$arrUplodedResumes['doc']='';
					}
						
					/*--[end]upload resume doc files--*/
					 	
					/*--upload resume pdf files--*/
					if(!empty($this->request->data['Professional']['uploaded_resumes']['resume_pdf']['name'])){
						$this->Upload->change_allowed_types(array('application/pdf'));
						$pfName=$this->Upload->upload($this->request->data['Professional']['uploaded_resumes']['resume_pdf'],"files/professional_docs");
						$arrUplodedResumes['pdf']=$pfName;

					}else if($resume['pdf']!=''){

						$arrUplodedResumes['pdf']=$resume['pdf'];
					}else{
						$arrUplodedResumes['pdf']='';
					}
					/*--[end]upload resume pdf files--*/
						
					if(!empty($arrUplodedResumes['doc']) || !empty($arrUplodedResumes['pdf']))
					$arrProfessionalData['Professional']['uploaded_resumes']=base64_encode(serialize($arrUplodedResumes));
					else
					$arrProfessionalData['Professional']['uploaded_resumes']='';
						
					$arrProfessionalData['Professional']['uploaded_resumes']=base64_encode(serialize($arrUplodedResumes));

						
				}catch(Exeption $e){
					//echo $e->getMessage();
				}

				/*--save professional data--*/

				$transDetail=$this->Professional->save($arrProfessionalData,false);

				if($transDetail){
					if($this->Session->check('Professional'))
					$this->Session->delete('Professional');
					$this->Session->write('Professional',$transDetail);

						
					$this->Session->setFlash(__('Your profile has been updated successfully.',true),'default',array('class'=>'success'));
					$this->redirect(array('action' => 'profile'));
				}else{
					$this->Session->setFlash(__('The data could not be updated.Please try again.',true),'default',array('class'=>'error'));
				}

			}
		}
	}

	public function professional_settings()
	{

		if(!$this->Session->check('Professional')){
			$this->redirect(array('controller'=>'home'));
		}
		$prof=$this->Session->read('Professional');
		
		if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data['Professional'])) {
			$this->Professional->id=$prof['Professional']['id'];
			$this->Professional->set($this->request->data);
			
			if($this->Professional->validates(array('fieldList'=>array('password','confirm_password')))){
				
				$arrProfData=array('Professional'=>array(
						'password'=>md5($this->request->data['Professional']['password']),
						'profile_modified_date'=>date('Y-m-d H:i:s')
				));
				
			
				if($this->Professional->save($arrProfData,false)){			
					unset($this->request->data['Professional']);
					$this->Session->setFlash(__('<h4>Your password has been changed successfully.</h4>',true),'default',array('class'=>'success'));
				}else{
					$this->Session->setFlash(__('<h4>The data could not be saved.Please try again.</h4>',true),'default',array('class'=>'error'));
				}
			}else{
				$this->Session->setFlash(__('<h4>The data could not be saved.Please try again.</h4>',true),'default',array('class'=>'error'));
		
			}
		}
	}
	
	
	function upload_profile_image(){

		$this->layout='ajax';
		if(!$this->Session->check('Professional')){
			echo "error";die;
		}

		if ($_FILES){

			$upload_dir = WWW_ROOT.str_replace("/", DS, "files/temp_professional_images/");
			$uploaddir = $upload_dir.DS;
			//$uploaddir = $this->webroot.'files/temp_professional_images/';
			$file = $uploaddir ."professional_".basename($_FILES['uploadfile']['name']);
			$file_name= "professional_".$_FILES['uploadfile']['name'];
			$imgName=$this->Image->upload_image_and_thumbnail($_FILES['uploadfile'],500,300,100,100, "temp_professional_images");
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

		if(!$this->Session->check('Professional')){
			echo "error";die;
		}

		if ($this->request->is('post') || $this->request->is('put')){
			$targ_w = 220;
			$targ_h = 250;
			$jpeg_quality = 90;
			$upload_dir = WWW_ROOT.str_replace("/", DS, "files/temp_professional_images/");
			if(isset($_POST['counter']) && $_POST['counter']==2){
				$upload_dir = WWW_ROOT.str_replace("/", DS, "files/temp_professional_images/");
			}
			if(isset($_POST['counter']) && $_POST['counter']==1){
				$upload_dir = WWW_ROOT.str_replace("/", DS, "files/professional_images/");
			}
			$uploaddir = $upload_dir.DS;
			$src =  $uploaddir ."professional_".$_POST['profImageName'];
			$targetFileName="professional_".mt_rand(100000,999999).'_'.$_POST['profImageName'];
			if(isset($_POST['counter']) && $_POST['counter']==2){
				$src =  $uploaddir ."professional_".$_POST['profImageName'];
				$targetFileName="professional_".mt_rand(100000,999999).'_'.$_POST['profImageName'];
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
				$prof=$this->Session->read('Professional');
				$arrProfessionalData=array();
				$this->Professional->id=$prof['Professional']['id'];
				$profilePhoto = $this->Professional->findById($prof['Professional']['id'], array('fields'=>'profile_photo'));
				if(!empty($_POST['profImageName'])){
					if($profilePhoto['Professional']['profile_photo']!=''){
						$this->Image->delete_image($profilePhoto['Professional']['profile_photo'],'professional_images');
					}

					if(isset($_POST['counter']) && $_POST['counter']==2){
						$dest_dir = WWW_ROOT.str_replace("/", DS, "files/professional_images/");
						$destdir = $dest_dir.DS;
						$destinationPath=$destdir.$targetFileName;
						copy($target, $destinationPath);
					}
					$arrProfessionalData['Professional']['profile_photo']=$targetFileName;
				}
				$transDetail=$this->Professional->save($arrProfessionalData,false);
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
			}die;



				
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


	function profile(){
		$this->layout='default';
		 
		if(!$this->Session->check('Professional')){
			$this->redirect(array('controller'=>'home'));
		}
		$prof=$this->Session->read('Professional');

		$profDetails=$this->Professional->findById($prof['Professional']['id']);
		$this->loadModel('ProfessionalTag');
		$tagDetails=$this->ProfessionalTag->find('all',array('conditions'=>array('professional_id'=>$prof['Professional']['id'],'tag_status'=>'Yes'),'order'=>array('created_date'=>'desc')));

		//print_r($tagDetails);die;
		$this->set('profDetails',$profDetails);
		$this->set('tagDetails',$tagDetails);
	}

	function professional_profile($id = null){
		$this->layout='default';
		if(!$this->Session->check('Recruiter')){
			$this->redirect(array('controller'=>'home'));
		}
		$prof=$this->Session->read('Recruiter');
		$this->loadModel('RecruiterFlag');
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
				$arrProfessionalData=array('RecruiterFlag'=>array(
						'recruiter_id'=>$prof['Recruiter']['id'],
						'professional_id'=>$id,
						'flag_type'=>$flagName,
						'flag_details'=>$this->request->data['profFlag']['details'],
						'status'=>1

				));
				if(isset($this->request->data['profFlag']['id']))
				{
					//$this->ProfessionalFlag->id=$this->request->data['profFlag']['id'];
					$arrProfessionalData['RecruiterFlag']['id']=$this->request->data['profFlag']['id'];
				}else{
					$this->RecruiterFlag->create();
					$arrProfessionalData['RecruiterFlag']['date']=date('Y-m-d H:i:s');
				}
				$this->RecruiterFlag->save($arrProfessionalData,false);
				$this->Professional->id=$id;
				$this->Professional->saveField('flag_status',1);

			}else{

				$this->RecruiterFlag->delete($this->request->data['profFlag']['id']);
				$num_professionals = $this->RecruiterFlag->find('count',array("conditions" => array('professional_id'=>$id)));
				if($num_professionals==0)
				{
					$this->Professional->id=$id;
					$this->Professional->saveField('flag_status',0);
				}
			}

		}
		$profDetails=$this->Professional->findById($id);
		$flagDetails=$this->RecruiterFlag->findByProfessionalIdAndRecruiterIdAndStatus($id,$prof['Recruiter']['id'],1);
		$this->loadModel('TrackProfessional');
		$trackDetails=$this->TrackProfessional->find('all',array('fields'=>array('track_event'),'conditions'=>array('professional_id'=>$id,'recruiter_id'=>$prof['Recruiter']['id'])));
		$this->loadModel('ProfessionalTag');
		$tagDetails=$this->ProfessionalTag->find('all',array('conditions'=>array('professional_id'=>$id,'recruiter_id'=>$prof['Recruiter']['id']),'order'=>array('created_date'=>'desc')));
		$trackArray=array();

		if(count($trackDetails)>0)
		{

			foreach($trackDetails as $track)
			{
				$trackArray[]=$track['TrackProfessional']['track_event'];
			}
		}

		$this->set('profDetails',$profDetails);
		$this->set('flagDetails',$flagDetails);
		$this->set('trackArray',$trackArray);
		$this->set('tagDetails',$tagDetails);
	}


	function track_professional_events($id = null,$ops=null){
		$this->layout='ajax';
		if($this->Session->check('Recruiter')){
			$prof=$this->Session->read('Recruiter');
		}else{
			$this->redirect(array('controller'=>'home'));
		}
			
		$eventVal=$this->request->data['eventVal'];
		$this->loadModel('TrackProfessional');
		if($ops=='add')
		{
			$this->TrackProfessional->create();
			$arrProfessionalData=array('TrackProfessional'=>array(
						'professional_id'=>$id,
						'recruiter_id'=>$prof['Recruiter']['id'],
						'track_event'=>$eventVal,
						'prof_notification' => 1,
						'rec_notification' => 1,
						'date'=>date('Y-m-d H:i:s')

			));
			if($this->TrackProfessional->save($arrProfessionalData,false))
			{
				echo "data saved";die;
			}
		}else{
			$trackDetails=$this->TrackProfessional->findByProfessionalIdAndRecruiterIdAndTrackEvent($id,$prof['Recruiter']['id'],$eventVal);
			if(!empty($trackDetails))
			{
				if($this->TrackProfessional->delete($trackDetails['TrackProfessional']['id']))
				{
					echo "data deleted";die;
				}
			}
		}
			
	}

	function manage_tags($id = null,$ops=null){
		$this->layout='ajax';
		if($this->Session->check('Recruiter')){
			$prof=$this->Session->read('Recruiter');
		}else{
			$this->redirect(array('controller'=>'home'));
		}

		$this->loadModel('ProfessionalTag');
		if($ops=='add')
		{
			$tagName=$this->request->data['tagName'];
			$this->ProfessionalTag->create();
			$arrProfessionalData=array('ProfessionalTag'=>array(
						'professional_id'=>$id,
						'recruiter_id'=>$prof['Recruiter']['id'],
						'tag_name'=>$tagName,
						'tag_status'=>'No',
						'created_date'=>date('Y-m-d H:i:s')

			));
			if($this->ProfessionalTag->save($arrProfessionalData,false))
			{
				echo $this->ProfessionalTag->getLastInsertId();die;
			}
		}else if($ops=='edit')
		{
			$tagName=$this->request->data['tagName'];
			$arrProfessionalData=array('ProfessionalTag'=>array(
			 			'id'=>$id,
						'tag_name'=>$tagName,
						'modified_date'=>date('Y-m-d H:i:s')

			));
			if($this->ProfessionalTag->save($arrProfessionalData,false))
			{
				echo "tag edited";die;
			}

		}else{
				
			if($this->ProfessionalTag->delete($id))
			{
				echo "tag deleted";die;
			}
				
		}
			
	}
	function edit_tags($id=null){
		$this->layout='ajax';
		if($this->Session->check('Recruiter')){
			$prof=$this->Session->read('Recruiter');
		}else{
			$this->redirect(array('controller'=>'home'));
		}
			
		$this->loadModel('ProfessionalTag');
		$tagDetails=$this->ProfessionalTag->find('all',array('conditions'=>array('professional_id'=>$id,'recruiter_id'=>$prof['Recruiter']['id']),'order'=>array('created_date'=>'desc')));
		$this->set('tagDetails',$tagDetails);

			
	}

	function update_tag_status($id=null,$tagStatus=null){
		$this->layout='ajax';
			
		$this->loadModel('ProfessionalTag');
		$this->ProfessionalTag->id=$id;
		if($this->ProfessionalTag->save(array('tag_status'=>$tagStatus)))
		{
			echo "Tag status updated";die;
		}



			
	}

	function logout(){

		unset($_SESSION['LoginStatus']);
		unset($_SESSION['Professional']);

		$this->Session->delete('LoginStatus');
		$this->Session->delete('Professional');

		$this->Session->setFlash(__('You have been successfully logged out.',true),
		'default',array('class'=>'logout success'));
		$this->redirect(array('controller'=>'home','action' => 'index'));

	}

	function edit_basic_details(){
		
		$this->layout='ajax';

		if($this->Session->check('Professional')){
			$prof=$this->Session->read('Professional');
		}else{
			echo "error";die;
		}
		/*--format data--*/
		if ($this->request->is('post') || $this->request->is('put')){
			$this->Professional->id=$prof['Professional']['id'];
			$this->request->data['Professional']['id']=$prof['Professional']['id'];
			$this->Professional->set($this->request->data);
				
			if(!$this->Professional->validates()){
				$validationErr=true;
			}
			if($validationErr){

				$arrErrors=array();

				if(isset($this->Professional->validationErrors)){
					$arrErrors=array_merge($arrErrors,$this->Professional->validationErrors);
				}




				echo $arrErrors['email'][0].',error';die;

			}else{
				$arrProfessionalData=array('Professional'=>array(
						'email'=>$this->request->data['Professional']['email'],
						'nationality'=>$this->request->data['Professional']['nationality'],
						'current_company'=>$this->request->data['Professional']['current_company'],
						'company_website'=>$this->request->data['Professional']['company_website'],
						'current_location'=>$this->request->data['Professional']['current_location'],
						'skills'=>$this->request->data['Professional']['skills'],
						'profile_modified_date'=>date('Y-m-d H:i:s')
				));
				$phoneNbr=$this->request->data['Professional']['phone_nbr']['number'];
				if(!empty($this->request->data['Professional']['phone_nbr']['code'])){
					$phoneNbr=$this->request->data['Professional']['phone_nbr']['code']."-".$phoneNbr;
				}
				$arrProfessionalData['Professional']['phone_nbr']=$phoneNbr;
				$this->Country->recursive = -1;

				$response='';

				$loc=$this->request->data['Professional']['current_location'];
				$location=explode(',',$loc);
				$loclength=count($location)-1;
				$results = $this->Country->find('all', array(
				'joins' => array(
				array(
						'table' =>$this->City->tablePrefix.$this->City->table,
						'alias' => 'City',
						'type' => 'LEFT',
						'conditions' => array(
							'City.country = Country.country_id'
							)
							)
							),
				'fields' => array('Country.nationality','Country.currency'),
				'conditions' => array('Country.country' => trim($location[$loclength]))
							));
							if(isset($results[0]['Country']['nationality'])||isset($results[0]['Country']['currency'])){
								$arrProfessionalData['Professional']['nationality']=$results[0]['Country']['nationality'];
								$arrProfessionalData['Professional']['ctc_currency']=$results[0]['Country']['currency'];
							}


							$transDetail=$this->Professional->save($arrProfessionalData,false);
								
								
								
			}
		}
		$profDetail=$this->Professional->findById($prof['Professional']['id']);
		$phone=$profDetail['Professional']['phone_nbr'];
		$arrPhone=explode('-', $phone);
		//print_r($arrPhone);die;
		$profDetail['Professional']['phone_nbr']=array();
		$profDetail['Professional']['phone_nbr']['code']=trim($arrPhone[0]);
		$profDetail['Professional']['phone_nbr']['number']=trim($arrPhone[1]);

		/*--[end]format data--*/

		$this->set('profDetail',$profDetail);
		if($transDetail){
			echo 'Your profile has been updated successfully'.',success';die;
		}
			

	}
	/*function edit_profile_image(){

	$this->layout='ajax';
	$prof=$this->Session->read('Professional');

	if ($_FILES){
		
	$arrProfessionalData=array();
	$this->Professional->id=$prof['Professional']['id'];
	$profilePhoto = $this->Professional->findById($prof['Professional']['id'], array('fields'=>'profile_photo'));
	if(!empty($_FILES['uploadfile']['name'])){
	if($profilePhoto['Professional']['profile_photo']!=''){
	$this->Image->delete_image($profilePhoto['Professional']['profile_photo'],'professional_images');
	}
	$imgName=$this->Image->upload_image_and_thumbnail($_FILES['uploadfile'],200,205,100,100, "professional_images");
	$arrProfessionalData['Professional']['profile_photo']=$imgName;
	}
	$transDetail=$this->Professional->save($arrProfessionalData,false);
	if($transDetail){
	$arrSuccess=array();
	$arrSuccess['success']='success';
	$arrSuccess['filename']=$imgName;
		
	}else{
	$arrSuccess=array();
	$arrSuccess['error']='error';
	}
	echo json_encode($arrSuccess); die;
	}

	}*/
	function delete_profile_image(){
		$this->layout='default';
		$prof=$this->Session->read('Professional');

		if(!$this->Session->check('Professional')){
			$this->redirect(array('controller' => 'home'));
		}

		$this->Professional->id=$prof['Professional']['id'];
		$profilePhoto = $this->Professional->findById($prof['Professional']['id'], array('fields'=>'profile_photo'));
		if($profilePhoto['Professional']['profile_photo']!=''){
			$this->Image->delete_image($profilePhoto['Professional']['profile_photo'],'professional_images');
		}
		$arrProfessionalData=array();
		$arrProfessionalData['Professional']['profile_photo']='';
		$transDetail=$this->Professional->save($arrProfessionalData,false);
		if($transDetail){
			$this->redirect(array('action' => 'profile'));
		}

	}
	function delete_uploaded_image(){
		$this->layout='ajax';
		if($this->request->data['counter']==1){
			$prof=$this->Session->read('Professional');
			$this->Professional->id=$prof['Professional']['id'];
			$profilePhoto = $this->Professional->findById($prof['Professional']['id'], array('fields'=>'profile_photo'));
			if($profilePhoto['Professional']['profile_photo']!=''){
				$this->Image->delete_image($profilePhoto['Professional']['profile_photo'],'professional_images');
			}
			$arrProfessionalData=array();
			$arrProfessionalData['Professional']['profile_photo']='';
			$transDetail=$this->Professional->save($arrProfessionalData,false);
		}else{
			$upload_dir = WWW_ROOT.str_replace("/", DS, "files/temp_professional_images/");
			$uploaddir = $upload_dir.DS;
			unlink($uploaddir."professional_".$this->request->data['profImageName']);
		}
		echo 'success';die;
	}

	function edit_professional_details($field=null){
		$this->layout='ajax';
		$validationErr=false;
		$prof=$this->Session->read('Professional');

		if(!$this->Session->check('Professional')){
			echo "error";die;
		}

		if ($this->request->is('post') || $this->request->is('put')){
			$this->Professional->id=$prof['Professional']['id'];
			$this->Professional->set($this->request->data);
			if(!$this->Professional->validates(array('fieldList' => array($field)))){
				$validationErr=true;
			}
			if($field=='profile_status'){
				if(isset($this->request->data['Professional']['profile_status']) && $this->request->data['Professional']['profile_status']=='IO'){
					if($this->request->data['Professional']['locations_for_interesting_op']==''){
						$validationErr=true;
					}
				}
				if(isset($this->request->data['Professional']['profile_status']) && $this->request->data['Professional']['profile_status']=='NO'){
					if($this->request->data['Professional']['locations_for_new_op']==''){
						$validationErr=true;
					}
				}
				if(isset($this->request->data['Professional']['profile_status']) && $this->request->data['Professional']['profile_status']=='U'){
					if($this->request->data['Professional']['do_not_disturb_year_flag']!=1 && $this->request->data['Professional']['do_not_disturb_date']==''){
						$validationErr=true;
					}
				}
					
			}
			if($validationErr){

				$arrErrors=array('Error'=>'Error');
					
				if(isset($this->Professional->validationErrors)){
					$arrErrors=array_merge($arrErrors,$this->Professional->validationErrors);
				}
				if($field=='profile_status'){
					if(isset($this->request->data['Professional']['profile_status']) && $this->request->data['Professional']['profile_status']=='IO'){
						if($this->request->data['Professional']['locations_for_interesting_op']==''){
							$arrErrors=array_merge($arrErrors,array('profile_status'=>'Please enter locations'));
						}
					}
					if(isset($this->request->data['Professional']['profile_status']) && $this->request->data['Professional']['profile_status']=='NO'){
						if($this->request->data['Professional']['locations_for_new_op']==''){
							$arrErrors=array_merge($arrErrors,array('profile_status'=>'Please enter locations'));
						}
					}
						
					if(isset($this->request->data['Professional']['profile_status']) && $this->request->data['Professional']['profile_status']=='U'){
						if($this->request->data['Professional']['do_not_disturb_year_flag']!=1 && $this->request->data['Professional']['do_not_disturb_date']==''){
							$arrErrors=array_merge($arrErrors,array('profile_status'=>'Please enter do not disturb period'));
						}
					}
				}

				echo json_encode($arrErrors); die;
				//echo $arrErrors['name'][0];die;

			}else{
					
				$arrProfessionalData=array();
				$arrProfessionalData['Professional']['profile_modified_date']=date('Y-m-d H:i:s');
				$arrSuccess=array();
				if($field=='name'){
					if(isset($this->request->data['Professional']['name']) && $this->request->data['Professional']['name']!='')
					{
							
							
						$name=explode(" ",$this->request->data['Professional']['name']);
						$firstName=$name[0];
						$lastName=$name[1];
							
						if(count($name)>2){
							for($i=2;$i<count($name);$i++){
								$lastName.=" ".$name[$i];
							}
						}
						$arrProfessionalData['Professional']['first_name']=$firstName;
						$arrProfessionalData['Professional']['last_name']=$lastName;
						$transDetail=$this->Professional->save($arrProfessionalData,false);
							
						if($transDetail){
							$arrSuccess['Success']='Your name has been updated successfully';
						}
					}
				}
				if($field=='work_experience'){
					$arrProfessionalData['Professional']['work_experience']=$this->request->data['Professional']['work_experience']['month'];
					if(!empty($this->request->data['Professional']['work_experience']['year'])){
						$arrProfessionalData['Professional']['work_experience']=intval($arrProfessionalData['Professional']['work_experience'])+
						(intval($this->request->data['Professional']['work_experience']['year'])*12);
					}
					$transDetail=$this->Professional->save($arrProfessionalData,false);
					if($transDetail){
						$arrSuccess['Success']='Work experience has been updated successfully';
						$expInYear=(int)($arrProfessionalData['Professional']['work_experience']/12);
						$expInMonth=($arrProfessionalData['Professional']['work_experience']%12);
						if($arrProfessionalData['Professional']['work_experience']<2){
							$arrSuccess['value']=$expInMonth;
							$arrSuccess['yearText']='month';
						}
						else if($arrProfessionalData['Professional']['work_experience']<12 && $arrProfessionalData['Professional']['work_experience']>1){
							$arrSuccess['value']=$expInMonth;
							$arrSuccess['yearText']='months';
						}else{
							$arrSuccess['value']=$expInYear.'.'.$expInMonth;
							$arrSuccess['yearText']='yrs';
						}
					}
						
				}
					
				if($field=='current_ctc'){

					if($this->request->data['Professional']['ctc_cycle']!=''){
						$arrProfessionalData['Professional']['ctc_cycle']=$this->request->data['Professional']['ctc_cycle'];
					}else{
						$arrProfessionalData['Professional']['ctc_cycle']='Year';
					}
					if($this->request->data['Professional']['ctc_currency']!=''){
						$arrProfessionalData['Professional']['ctc_currency']=$this->request->data['Professional']['ctc_currency'];
					}else{
						$arrProfessionalData['Professional']['ctc_currency']='INR';
					}
					if(strtolower($this->request->data['Professional']['ctc_currency'])=='inr'){
						$arrProfessionalData['Professional']['current_ctc']=
						(intval($this->request->data['Professional']['current_ctc']['lacs'])*100000)+(intval($this->request->data['Professional']['current_ctc']['thousands'])*1000);
					}else{
						$arrProfessionalData['Professional']['current_ctc']=$this->request->data['Professional']['current_ctc']['dollar'];
					}
					$transDetail=$this->Professional->save($arrProfessionalData,false);
					if($transDetail){
						$arrSuccess['Success']='ctc has been updated successfully';
						$ctc = '';
						if($arrProfessionalData['Professional']['current_ctc'] > 100000)  {
							$inLac  = ($arrProfessionalData['Professional']['current_ctc']/100000);
							$ctc    =   substr($inLac,0,strpos($inLac,'.')); 
							$ctc .= '.';
							$ctc .= ($arrProfessionalData['Professional']['current_ctc']%100000)/1000;
						}
						else {
							$ctc  = $arrProfessionalData['Professional']['current_ctc'];
						}
						$arrSuccess['value']='<strong>'.$ctc.'</strong>';
						if($arrProfessionalData['Professional']['current_ctc']>100000 && strtolower($arrProfessionalData['Professional']['ctc_currency'])=='inr'){
							$roundVal=round(($arrProfessionalData['Professional']['current_ctc']/100000),2);
							if($roundVal>1)
							$arrSuccess['value']='<strong>'.$ctc.'</strong> Lacs';
							else
							$arrSuccess['value']='<strong>'.$ctc.'</strong> Lac';
						}
						$arrSuccess['currency']=strtoupper($arrProfessionalData['Professional']['ctc_currency']);
						//print_r($arrSuccess);die;
						$cycle=$arrProfessionalData['Professional']['ctc_cycle'];
						if($cycle=='Year'){
							$cycleText='annual';
						}else if($cycle=='Month'){
							$cycleText='monthly';
						}else if($cycle=='Week'){
							$cycleText='weekly';
						}else if($cycle=='Day'){
							$cycleText='daily';
						}else{
							$cycleText='hourly';
						}
						$arrSuccess['cycle']=$cycleText;
							
					}
				}
				if($field=='availability'){

					$arrProfessionalData['Professional']['immediate_joining_flag']=$this->request->data['Professional']['immediate_joining_flag'];
					$arrProfessionalData['Professional']['joining_by_day']=$this->request->data['Professional']['joining_by_day'];
					if(!empty($this->request->data['Professional']['joining_by_date'])){
						$arrProfessionalData['Professional']['joining_by_date']=date('Y-m-d',strtotime($this->request->data['Professional']['joining_by_date']));
					}else{
						$arrProfessionalData['Professional']['joining_by_date']='';
					}
					$transDetail=$this->Professional->save($arrProfessionalData,false);
					if($transDetail){
						$arrSuccess['Success']='Availability has been updated successfully';
						if($arrProfessionalData['Professional']['immediate_joining_flag']==1){
							$arrSuccess['value']='Available <strong class="availability">Immediately</strong>';


						}else if(!empty($arrProfessionalData['Professional']['joining_by_date'])){
							$arrSuccess['value']="Available from <strong class='availability'>".date('d M Y',strtotime($arrProfessionalData['Professional']['joining_by_date']))."</strong>";

						}else{
							$arrSuccess['value']="Available in <br/><strong>".$arrProfessionalData['Professional']['joining_by_day']."</strong> days";
						}
						$tackDetails=$this->findTrackDetails($prof['Professional']['id'],'Notice period change');
						if(!empty($tackDetails))
						{

							$content=$prof['Professional']['first_name'].' '.$prof['Professional']['last_name'].' changed own notice period status';
							$this->sendTrackingMail($tackDetails,$prof,$content);
						}
							
					}
				}
				if($field=='profile_status'){

					$arrProfessionalData['Professional']['profile_status']=$this->request->data['Professional']['profile_status'];
					$arrProfessionalData['Professional']['locations_for_new_op']=$this->request->data['Professional']['locations_for_new_op'];
					$arrProfessionalData['Professional']['locations_for_interesting_op']=$this->request->data['Professional']['locations_for_interesting_op'];
					$arrProfessionalData['Professional']['do_not_disturb_flag']=$this->request->data['Professional']['do_not_disturb_flag'];
					$arrProfessionalData['Professional']['do_not_disturb_year_flag']=$this->request->data['Professional']['do_not_disturb_year_flag'];
					$arrProfessionalData['Professional']['do_not_disturb_date']=date('Y-m-d',strtotime($this->request->data['Professional']['do_not_disturb_date']));
					if($this->request->data['Professional']['do_not_disturb_year_flag']==1){
						$dateAfterOneYear=date("Y-m-d",strtotime("+1 year",strtotime(date('Y-m-d'))));
						$arrProfessionalData['Professional']['do_not_disturb_date']=$dateAfterOneYear;
					}
					$transDetail=$this->Professional->save($arrProfessionalData,false);
					if($transDetail){
						$arrSuccess['Success']='Status has been updated successfully';
						$tackDetails=$this->findTrackDetails($prof['Professional']['id'],'Status change');
						if(!empty($tackDetails))
						{

							$content=$prof['Professional']['first_name'].' '.$prof['Professional']['last_name'].' changed own profile status';
							$this->sendTrackingMail($tackDetails,$prof,$content);
						}

					}

				}
				echo json_encode($arrSuccess); die;
					

			}
		}
			
	}


	function recruiter_search() {
		$this->layout='ajax';

		if(!$this->Session->check('Professional')){
			echo "error";die;
		}

		if (count($this->request->data) == 0)
		$this->request->data = $this->passedArgs;
		if(count($this->request->data)==0)
		$this->request->data = $this->request->query;
		$searchQuery=$this->request->data['search_cont'];
		$this->loadModel('Recruiter');
		if($searchQuery!=''){
				
			$condition=array(
					'Recruiter.completed_status' => 'Yes',
					 'OR' => array(
			array('Recruiter.first_name LIKE' => '%'.trim($searchQuery).'%'),
			array('Recruiter.last_name LIKE' => '%'.trim($searchQuery).'%'),
			array('CONCAT(Recruiter.first_name," ",Recruiter.last_name) LIKE' => '%'.trim($searchQuery).'%'),
			array('Recruiter.current_company LIKE' => '%'.trim($searchQuery).'%'),
			array('Recruiter.current_location LIKE' => '%'.trim($searchQuery).'%')
			),
						'Recruiter.status'=>1  
				
			);
				
		}
		if($this->request->data['hiringLoc']){
			$page=$this->paginate=array('Recruiter'=> array(
			'limit'=>10,
			'conditions' =>$condition,
			'order'=>array('Recruiter.geographies'=>'asc')
			));
		}else{
			$page=$this->paginate=Array('Recruiter'=> array(
			'limit'=>10,
			'conditions' =>$condition
			));
		}
			
		$recruiterDetail=$this->paginate('Recruiter');
		//print_r($data1);die;
		$this->loadModel('Domain');
		$domain=$this->Domain->find('list',array('fields'=>array('id','domain_title')));
		if(count($recruiterDetail)>0){
			$this->set('searchData',$recruiterDetail);
			$this->set('domain',$domain);
		}else{
			echo 'No Record Found';die;
		}
			
	}

	/*--[end]ublic actions--*/
	function findPhoneCode() {

		$this->Country->recursive = -1;
		if ($this->request->is('ajax')) {
			$response = Array();
			$this->autoRender = false;
			$results = $this->Country->find('all', array('fields' => array('Country.isd_code'),
	    'conditions' => array('Country.isd_code LIKE ' => $this->request->query['term'] . '%')
			));
			//print_r($results);die;
			foreach($results as $result) {

				$response[] = $result['Country']['isd_code'];

			}
			//print_r($results);die;
			echo json_encode($response); die;
		}
	}

	function findCurrentLocation() {

		$this->City->recursive = -1;
		if ($this->request->is('ajax')) {
			$response = Array();
			$this->autoRender = false;
			$results = $this->City->find('all', array(
	'joins' => array(
			array(
            'table' =>$this->Country->tablePrefix.$this->Country->table,
            'alias' => 'Country',
            'type' => 'LEFT',
            'conditions' => array(
                'Country.country_id = City.country'
                )
                )
                ),
	'fields' => array('City.name','Country.country','City.region'),
    'conditions' => array('City.name LIKE ' =>'%'.$this->request->query['term'] .'%')
                ));
                //print_r($results);die;
                foreach($results as $result) {
                	if($result['City']['region']!=''){
                		$response[] = $result['City']['name'].', '.$result['City']['region'].', '.$result['Country']['country'];
                	}else{
                		$response[] = $result['City']['name'].', '.$result['Country']['country'];
                	}

                }
                //print_r($results);die;
                echo json_encode($response); die;
		}
	}



	function findPreferredLocation() {

		$this->PreferredLocation->recursive = -1;
		//$this->Country->recursive = -1;
		if ($this->request->is('ajax')) {
			$response = Array();
			$this->autoRender = false;
			/*$countryResults = $this->Country->find('all', array('fields' => array('Country.country'),
			 'conditions' => array('Country.country LIKE ' => $this->request->query['term'] . '%')
			 ));
			 $cityResults = $this->City->find('all', array('fields' => array('City.name'),
			 'conditions' => array('City.name LIKE ' => $this->request->query['term'] . '%')
			 ));*/

			$cityResults = $this->PreferredLocation->find('all', array('fields' => array('PreferredLocation.location'),
    'conditions' => array('PreferredLocation.location LIKE ' => $this->request->query['term'] . '%')
			));

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

			echo json_encode($response); die;
		}
	}

	function findGeographies() {

		$this->PreferredLocation->recursive = -1;
		$this->Country->recursive = -1;
		if ($this->request->is('ajax')) {
			$response = Array();
			$this->autoRender = false;
			$countryResults = $this->Country->find('all', array('fields' => array('Country.country'),
    'conditions' => array('Country.country LIKE ' => $this->request->query['term'] . '%')
			));



			foreach($countryResults as $ciresult) {


				$response[] = $ciresult['Country']['country'];

			}
			//print_r($results);die;
			echo json_encode($response); die;
		}
	}

	function findskills() {

		if ($this->request->is('ajax')) {
			$response = Array();
			$this->autoRender = false;
			$skillResults = $this->Skill->find('all', array('fields' => array('Skill.skill_name'),
    'conditions' => array('Skill.skill_name LIKE ' => $this->request->query['term'] . '%')
			));


			//print_r($results);die;
			foreach($skillResults as $result) {


				$response[] = $result['Skill']['skill_name'];

			}

			//print_r($results);die;
			echo json_encode($response); die;
		}
	}

	function detectNationality() {
		
		$this->Country->recursive = -1;
		if ($this->request->is('ajax')) {
			$response='';
			$this->autoRender = false;
			$loc=$this->request->data['location'];
			$location=explode(',',$loc);
			$loclength=count($location)-1;
			$results = $this->Country->find('all', array(
	'joins' => array(
			array(
            'table' =>$this->City->tablePrefix.$this->City->table,
            'alias' => 'City',
            'type' => 'LEFT',
            'conditions' => array(
                'City.country = Country.country_id'
                )
                )
                ),
	'fields' => array('Country.nationality','Country.currency','Country.isd_code'),
    'conditions' => array('Country.country' => trim($location[$loclength]))
                ));
                if(isset($results[0]['Country']['nationality'])|| isset($results[0]['Country']['currency']) || isset($results[0]['Country']['isd_code']))
                $response = $results[0]['Country']['nationality'].','.$results[0]['Country']['currency'].','.$results[0]['Country']['isd_code'];
                echo $response;die;
		}
	}


	public function change_status()
	{
		if(!$this->Session->check('Professional')){
			$this->redirect(array('controller' => 'home'));
		}	
		$this->Professional->id=$this->data['id'];
		$this->Professional->saveField('status',$this->data['status']);
		die;

	}

	/*function get_url_contents() {

	for($i=1;$i<497;$i++){
	$content = file_get_contents('http://localhost/jobseeker-live/app/webroot/files/skill/skill'.$i.'.json');

	$skilldb=json_decode($content, true);
	//print_r($skilldb['tags']);die;
	foreach($skilldb['tags'] as $skill){
	$this->Skill->create();
	$this->Skill->save(array('skill_name'=>$skill['name']),false);
	}
	}print_r('updated');die;


	}*/
	function findTrackDetails($profId=null,$event=null)
	{
		$this->loadModel('TrackProfessional');
		$this->loadModel('Recruiter');

		$trackDetails=$this->TrackProfessional->find('all',array('fields'=>array('Recruiter.first_name','Recruiter.last_name','Recruiter.email','TrackProfessional.track_event'),
						'joins' => array(
		array(
							'table' =>$this->Recruiter->tablePrefix.$this->Recruiter->table,
							'alias' => 'Recruiter',
							'type' => 'LEFT',
							'conditions' => array(
								'Recruiter.id = TrackProfessional.recruiter_id'
								)
								)
								),
						'conditions'=>array('professional_id'=>$profId,
						'OR'=>array(
								array('track_event'=>$event),
								array('track_event'=>'Any profile change')
								)
								),
						'group'=>array('recruiter_id')
								));
								return $trackDetails;
	}

	function sendTrackingMail($trackData=null,$profDetail=null,$contentText=null)
	{
		if(count($trackData)>0)
		{
			foreach($trackData as $track)
			{
				$from="Admin<admin@jobseeker.com>";
				$to=$track['Recruiter']['email'];

				$subject="Profile Update Notification Mail";
				$content="Dear ".$track['Recruiter']['first_name'].' '.$track['Recruiter']['last_name'].',<br/>';
				$content.=$contentText;

				try{
						
					$this->Email->from=$from;
						
					$this->Email->to=$to;
					$this->Email->subject=$subject;
					$this->Email->sendAs='html';
						
					//$this->Email->template='general';
					$this->Email->delivery = 'smtp';
						
					$this->Email->send($content);

						
				}catch(Exception $e){
						
						
				}
			}
				
		}
		return true;
	}
}?>