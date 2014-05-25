<?php
App::import('Core','Validation');
App::uses('CakeEmail', 'Network/Email');
App::uses('Vendor', 'functions');

class MailController extends AppController {

	public $components = array('Session');
	public $uses = array('User','Mail');

    public function sendMail($fromid, $section, $arr=array()) {
        $this->autoRender=false;
		//print_r($section.'<br>');
        $contents = $this->Mail->findBySection($section);
        //print_r($contents); die;
        $user = $this->User->findById($fromid);
        if(is_array($contents) && is_array($user)){
        $arr['FROM_NAME'] = $user['User']['first_name'].' '.$user['User']['last_name'];
		$arr['FROM_EMAIL']=$user['User']['email'];
        $content = $contents['Mail']['content'];
		
        foreach ($arr as $key => $val)
            $content = str_replace("~~$key~~", $val, $content);
        
		if(!empty($arr['TO_EMAIL'])&&(Validation::email($arr['TO_EMAIL'], true)))
		{ 
			
			$email = new CakeEmail();
			$email->template('default');
			$email->config('default');
			$email->emailFormat('html')->to($arr['TO_EMAIL'])->subject($contents['Mail']['subject']);
			try{
				if($email->send($content))
					return;
				else
				  return;	
			}catch(Exception $e){
				return;	
			}
		}
		}
		
		return;
    }
	
}