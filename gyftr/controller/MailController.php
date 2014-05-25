<?php
App::import('Core','Validation');
App::uses('CakeEmail', 'Network/Email');
App::uses('Vendor', 'functions');

class MailController extends AppController {

    public $components = array('Session');
    public $uses = array('User','Mail');

    public function sendMail($fromid, $section, $arr=array(),$template=0) {
		
        $this->autoRender=false;
        $contents = $this->Mail->findBySection($section);
        
        $user = $this->User->findById($fromid);
        if(is_array($contents) && is_array($user)){
        $arr['FROM_NAME'] = $user['User']['first_name'].' '.$user['User']['last_name'];
		$arr['FROM_EMAIL']=$user['User']['email'];
		
        $content = $contents['Mail']['content'];
		
        foreach ($arr as $key => $val)
            $content = str_replace("~~$key~~", $val, $content);
			
        $content = str_replace("~~SITE_URL~~", SITE_URL, $content);
		if(!isset($arr['SUBJECT_NAME']))
			$contents['Mail']['subject']=str_replace("~~SUB_NAME~~", $arr['TO_NAME'], $contents['Mail']['subject']);
		else
			$contents['Mail']['subject']=str_replace("~~SUB_NAME~~", $arr['SUBJECT_NAME'], $contents['Mail']['subject']);
		
		if(isset($arr['OCCASION']))
		{
			$contents['Mail']['subject']=str_replace("~~OCCASION~~", $arr['OCCASION'], $contents['Mail']['subject']);	
		}
		if(isset($arr['SUB_FROM_NAME']))
		{
			$contents['Mail']['subject']=str_replace("~~SUB_FROM_NAME~~", $arr['SUB_FROM_NAME'], $contents['Mail']['subject']);	
		}
		if(!empty($arr['TO_EMAIL'])&&(Validation::email($arr['TO_EMAIL'], true)))
		{ 
			
			$email = new CakeEmail();
			if($template==0)
				$email->template('default');
			else
				$email->template('new_default');	
			$email->config('default');
			$email->attachments(array(
				'logo.jpg' => array(
					'file' => WWW_ROOT.'img/mygyfter_logo.jpg',
					'mimetype' => 'image/jpeg',
					'contentId' => 'mygyftr_logo'
				),
				'bullet.jpg' => array(
					'file' => WWW_ROOT.'img/bullet.jpg',
					'mimetype' => 'image/jpeg',
					'contentId' => 'bullet'
				)	
			));
			$email->emailFormat('html')->to($arr['TO_EMAIL'])->subject($contents['Mail']['subject']);
			try {
			if($email->send($content))
			{
				//echo '1';die;	
				return;
			}else{
				//echo 2;die;
				return;	
			}
			}catch ( Exception $e ) {
				//echo 3;die;	
				return;
  			  // Failure, with exception
			}
		}
		}
		return;
    }
	
	public function sendContentMail($fromid,$to_email,$arr)
	{
		 $this->autoRender=false;
		 $user = $this->User->findById($fromid);
		 if(!empty($to_email)&&(Validation::email($to_email, true)))
		 { 
			$email = new CakeEmail();
			$email->template('default');
			$email->config('default');
			$email->emailFormat('html')->to($to_email)->subject($arr['subject'])->send($arr['message']);
		 }	
		 return;
	}
	
	public function send_forgetpass_mail($userid,$arr,$section)
	{
		$this->autoRender=false;
        $contents = $this->Mail->findBySection($section);
        
        $user = $this->User->findById($userid);
        if(is_array($contents) && is_array($user)){
        $arr['TO_NAME'] = $user['User']['first_name'].' '.$user['User']['last_name'];
		$arr['FROM_EMAIL']='support@mygyftr.com';
		$arr['FROM_NAME']='MyGyFtr Team';
		//if(!isset($arr['PASSWORD']))
        //$arr['PASSWORD']="Password";
        $content = $contents['Mail']['content'];
		
        foreach ($arr as $key => $val)
            $content = str_replace("~~$key~~", $val, $content);
        // $content = str_replace('~~SITE_URL~~', SITE_URL, $content);
		//print_r($content);die;
		if(!empty($user['User']['email'])&&(Validation::email($user['User']['email'], true)))
		{ 
			//echo 'cake'; die;
			$email = new CakeEmail();
			$email->template('default');
			$email->config('default');
			$email->attachments(array(
				'logo.jpg' => array(
					'file' => WWW_ROOT.'img/mygyfter_logo.jpg',
					'mimetype' => 'image/jpeg',
					'contentId' => 'mygyftr_logo'
				)	
			));
			$email->emailFormat('html')->to($user['User']['email'])->subject($contents['Mail']['subject'])->send($content);
		}
		}
		return;	
	}
	
	public function sendSMS($fromid, $section, $arr=array())
	{
		 $this->autoRender=false;
        $contents = $this->Mail->findBySection($section);
        
        $user = $this->User->findById($fromid);
        if(is_array($contents) && is_array($user)){
        $arr['FROM_NAME'] = $user['User']['first_name'].' '.$user['User']['last_name'];
		$arr['FROM_EMAIL']=$user['User']['email'];
        $content = $contents['Mail']['content'];
		
        foreach ($arr as $key => $val)
            $content = str_replace("~~$key~~", $val, $content);
		if(!empty($arr['TO_PHONE']))
		{ 
			$url="http://bulkpush.mytoday.com/BulkSms/SingleMsgApi?feedid=".urlencode('338500')."&username=".urlencode('9818015215')."&password=".urlencode('pjttw')."&To=".urlencode($arr['TO_PHONE'])."&Text=".urlencode($content)."&time=&senderid=";
		//echo $url;die;
		$ch = curl_init();	
		curl_setopt($ch, CURLOPT_POST, 0);		
		curl_setopt($ch,CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
		$result=curl_exec($ch);		
		curl_close($ch);	
		}
		}
		return;	
	}
	
	
}