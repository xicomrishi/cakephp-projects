<?php
App::uses('AppController', 'Controller');
class CommonController extends AppController {

	public $name = 'Common';
	public $helpers = array('Form', 'Html', 'Js');
	public $paginate = array('limit' =>10);	
	public $components = array('Access','Captcha','Email');
	public $uses=array('State','Country','City','Common','Professional','Recruiter','ProfessionalFlag','RecruiterFlag');

	
	function beforeFilter(){
		$isAdmin=Configure::read('Routing.prefixes');
		$pos = strpos($_SERVER['REQUEST_URI'], $isAdmin[0]);
	    if($pos == true)
        {
			$this->Access->isValidUser();
		}
	}
	
	/*public function get_states()
	{
		$this->layout='ajax';
		$id=$this->request->data['id'];
		$this->State->recursive=-1;
		$data=$this->State->find('all',array('conditions'=>array('country_id'=>$id)));
		
		$resp='<option value="0"></option>';
		foreach($data as $dat)
		{
			$resp.='<option value="'.$dat['State']['state_id'].'">'.$dat['State']['state_name'].'</option>';	
		}
		echo $resp;die;
	}
	
	public function get_cities()
	{
		$this->layout='ajax';
		$sId=$this->request->data['state_id'];
		$cId=$this->request->data['country_id'];
		$this->State->recursive=-1;
		$data=$this->City->find('all',array('conditions'=>array('country_id'=>$cId,'state_id'=>$sId)));
		
		$resp='<option value="0"></option>';
		foreach($data as $dat)
		{
			$resp.='<option value="'.$dat['City']['id'].'">'.$dat['City']['name'].'</option>';	
		}
		echo $resp;die;
	}*/
	
	function captcha_image() 
    { 
        $this->Captcha->image(); 
    } 
     
    function captcha_audio() 
    { 
        $this->Captcha->audio(); 
    } 
	function admin_setting(){
		
		$this->set('Settings',$this->Common->formattedSettingData());
	}
	
	function contact_us_email(){
		$this->layout='ajax';
		$this->Common->create();
		$data=array('Common');
		//print_r($this->request->data);die;
		if(($this->request->data['Common']['contact_us_email_id'])){
			$this->Common->id=$this->request->data['Common']['contact_us_email_id'];
			$data['Common']['modified_date'] = date('Y-m-d H:i:s');
		}else{
			$data['Common']['added_date'] =date('Y-m-d H:i:s');
		}
		if(!empty($this->request->data['Common']['contact_us_email_value'])){
			$data['Common']['key']=$this->request->data['Common']['contact_us_email_key'];
			$data['Common']['value']=$this->request->data['Common']['contact_us_email_value'];
			 
			if ($this->Common->save($data)){
				echo(__('<span class="success">The default value has been saved.</span>'));
			}
		}else{
			echo(__('<span class="error">Please enter a value.</span>'));
		}
		die;
	}
	
	function footer_copyright(){
		$this->layout='ajax';
		$this->Common->create();
		$data=array('Common');
		
		if(($this->request->data['Common']['footer_copyright_id'])){
			$this->Common->id=$this->request->data['Common']['footer_copyright_id'];
			$data['Common']['modified_date'] = date('Y-m-d H:i:s');
			//print_r($this->request->data);die;
		}else{
			$data['Common']['added_date'] = date('Y-m-d H:i:s');
		}
		if(!empty($this->request->data['Common']['footer_copyright_value'])){
			$data['Common']['key']=$this->request->data['Common']['footer_copyright_key'];
			$data['Common']['value']=$this->request->data['Common']['footer_copyright_value'];
			 
			if ($this->Common->save($data)){
				echo(__('<span class="success">The default value has been saved.</span>'));
			}
		}else{
			echo(__('<span class="error">Please enter a value.</span>'));
		}
		die;
	}
	function getFooter()
	{
		$footerText=$this->Common->findByKey('footer_copyright',array('fields'=>'value'));
		if(!empty($footerText['Common']['value'])){
			return $footerText['Common']['value'];
		}else{
			return false;	
		}
	}
	
	function sendFlagMailToRecruiters()
	{
		$this->Recruiter->recursive=3;
		$this->Recruiter->unBindModel(array('hasMany' => array('RecruiterClient', 'RecruiterDomain')));
		$this->ProfessionalFlag->bindModel(array('belongsTo'=>array('Professional'=>array('className'=>'Professional','foreignKey'=>'professional_id','dependent' => true,'fields'=>array('Professional.id,Professional.first_name,Professional.last_name,Professional.email')))));
		
		$this->Recruiter->bindModel(array('hasMany'=>array('ProfessionalFlag'=>array('className'=>'ProfessionalFlag','foreignKey'=>'recruiter_id'))));
		$recruitDetails=$this->Recruiter->find('all',array('fields'=>array('Recruiter.id,Recruiter.first_name,Recruiter.last_name,Recruiter.email'),'conditions'=>array('Recruiter.flag_status'=>1)));
		//echo '<pre>';
		//print_r($recruitDetails);die;
		if(count($recruitDetails)>0)
		{
			foreach($recruitDetails as $recruiter)
			{
				$from="Admin<admin@jobseeker.com>";
				$to=$recruiter['Recruiter']['email'];
				$subject="Flag Notification Mail";
				$content="Following are the notification details:<br/>";
				$content.='<table><tr><th>Name</th><th>Email</th><th>Notification</th></tr>';
				$contentInner='';
				foreach($recruiter['ProfessionalFlag'] as $flagInfo)
				{
					$contentInner.='<tr><td>'.$flagInfo['Professional']['first_name'].' '.$flagInfo['Professional']['last_name'].'</td>';
					$contentInner.='<td>'.$flagInfo['Professional']['email'].'</td>';
					$contentInner.='<td>'.$flagInfo['flag_type'].'</td></tr>';
				}
				$content.=$contentInner.'</table>';
				try{
					
					$this->Email->from=$from;
					
					$this->Email->to=$to;
					$this->Email->subject=$subject;
					$this->Email->sendAs='html';
					
					//$this->Email->template='general';
					$this->Email->delivery = 'smtp';
					
					if($this->Email->send($content)){
						echo "<h4 class='success'>Flag Notification Mail send to recruiters";
						echo "</h4>";die;
					}
				}catch(Exception $e){
					echo "<h4 class='error'>The email could not be sent.Please contact to admin.</h4>";
					die;
				}
			}
		}
				
							
	
	
	}
	
	
	function sendFlagMailToProfessionals()
	{
		$this->Professional->recursive=3;
		$this->Recruiter->unBindModel(array('hasMany' => array('RecruiterClient', 'RecruiterDomain')));
		$this->RecruiterFlag->bindModel(array('belongsTo'=>array('Recruiter'=>array('className'=>'Recruiter','foreignKey'=>'recruiter_id','dependent' => true,'fields'=>array('Recruiter.id,Recruiter.first_name,Recruiter.last_name,Recruiter.email')))));
		
		$this->Professional->bindModel(array('hasMany'=>array('RecruiterFlag'=>array('className'=>'RecruiterFlag','foreignKey'=>'professional_id'))));
		$profDetails=$this->Professional->find('all',array('fields'=>array('Professional.id,Professional.first_name,Professional.last_name,Professional.email'),'conditions'=>array('Professional.flag_status'=>1)));
		//echo '<pre>';
		//print_r($profDetails);die;
		if(count($profDetails)>0)
		{
			foreach($profDetails as $professional)
			{
				$from="Admin<admin@jobseeker.com>";
				$to=$professional['Professional']['email'];
				$subject="Flag Notification Mail";
				$content="Following are the notification details:<br/>";
				$content.='<table><tr><th>Name</th><th>Email</th><th>Notification</th></tr>';
				$contentInner='';
				foreach($professional['RecruiterFlag'] as $flagInfo)
				{
					$contentInner.='<tr><td>'.$flagInfo['Recruiter']['first_name'].' '.$flagInfo['Recruiter']['last_name'].'</td>';
					$contentInner.='<td>'.$flagInfo['Recruiter']['email'].'</td>';
					$contentInner.='<td>'.$flagInfo['flag_type'].'</td></tr>';
				}
				$content.=$contentInner.'</table>';
				try{
					
					$this->Email->from=$from;
					
					$this->Email->to=$to;
					$this->Email->subject=$subject;
					$this->Email->sendAs='html';
					
					//$this->Email->template='general';
					$this->Email->delivery = 'smtp';
					
					if($this->Email->send($content)){
						echo "<h4 class='success'>Flag Notification Mail send to professionals";
						echo "</h4>";die;
					}
				}catch(Exception $e){
					echo "<h4 class='error'>The email could not be sent.Please contact to admin.</h4>";
					die;
				}
			}
		}
				
	}
        	
}