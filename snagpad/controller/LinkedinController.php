<?php

App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', array('linkedin', 'functions'));
App::import('Controller', array('Users'));

class LinkedinController extends UsersController {

    var $components = array('Session');
    public $uses = array('Client', 'CARD', 'Account', 'Tempuser', 'Friend');
    public $API_CONFIG = array('appKey' => LINKEDIN_APP_KEY, 'appSecret' => LINKEDIN_APP_SECRET, 'callbackUrl' => NULL);

    public function auth() {
        $this->autoRender = false;
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }
        $this->Session->write('referral_url', SITE_URL . "/jobcards/index");
        define('PORT_HTTP', '80');
        define('PORT_HTTP_SSL', '443');
        $this->API_CONFIG['callbackUrl'] = $protocol . '://' . $_SERVER['SERVER_NAME'] . ((($_SERVER['SERVER_PORT'] != PORT_HTTP) || ($_SERVER['SERVER_PORT'] != PORT_HTTP_SSL)) ? ':' . $_SERVER['SERVER_PORT'] : '') . '/linkedin/auth' . '?' . LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
        $OBJ_linkedin = new LinkedIn($this->API_CONFIG);
        // $this->Session->write('referral_url', $this->referer());
        // check for response from LinkedIn
        $_GET[LINKEDIN::_GET_RESPONSE] = (isset($_GET[LINKEDIN::_GET_RESPONSE])) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';
        if (!$_GET[LINKEDIN::_GET_RESPONSE]) {
            // LinkedIn hasn't sent us a response, the user is initiating the connection
            // send a request for a LinkedIn access token
            $response = $OBJ_linkedin->retrieveTokenRequest();

            if ($response['success'] === TRUE) {
                // store the request token
                $this->Session->write('Client.linkedin.request', $response['linkedin']);
                // redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
                $this->redirect(LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token']);
            } else {
                $this->redirect($this->Session->read('referral_url'));
            }
        } else {
            // LinkedIn has sent a response, user has granted permission, take the temp access token, the user's secret and the verifier to request the user's real secret key
            $response = $OBJ_linkedin->retrieveTokenAccess($this->Session->read('Client.linkedin.request.oauth_token'), $this->Session->read('Client.linkedin.request.oauth_token_secret'), $_GET['oauth_verifier']);
            if ($response['success'] === TRUE) {
                $response['linkedin']['oauth_verifier'] = $_GET['oauth_verifier'];
                // the request went through without an error, gather user's 'access' tokens
                $this->Session->write('Client.linkedin.access', $response['linkedin']);
                // set the user as authorized for future quick reference
                $this->Session->write('Client.linkedin.authorized', TRUE);

                // redirect the user back to the demo page
                $this->checkProfile();
            } else {
                //$this->redirect('/');
                // bad token access
                echo "Access token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
            }
        }
    }

    public function checkProfile() {
        $profile = $this->getProfile();
        $email = "email-address";
        $profile['linkedin']->$email;
		
		 $client_info=$this->Client->find('first',array('conditions'=>array('OR'=>array('Client.linkedin_email'=>$profile['linkedin']->$email,'Client.email'=>$profile['linkedin']->$email,'Client.fb_email'=>$profile['linkedin']->$email)),'fields'=>array('Client.id','Client.account_id','Client.email')));
		 //echo '<pre>';print_r($client_info);die;
		 
      // $client_info = $this->Client->find('first', array('fields'=>array('Client.id','Client.account_id'),'conditions' => array('OR'=>array('Client.email' => $profile['linkedin']->$email,'Client.linkedin_id'=>$profile['linkedin']->id))));
       
        if(is_array($client_info) && count($client_info)>0)       
            $count=1;
        else
            $count=0;
        if ($this->Session->check('clientid')) {
						
			$already_linkedin=$this->Client->find('first',array('conditions'=>array('Client.id'=>$this->Session->read('clientid')),'fields'=>array('Client.linkedin_email','Client.linkedin_id')));
				//echo '<pre>';print_r($already_fb);die;
			    $ch=$this->check_exist_id($profile['linkedin']->$email);
				if($ch!='1')
				{
               		 $sql = "update jsb_client set linkedin_id='" . $profile['linkedin']->id . "',linkedin_token='" . serialize($this->Session->read('Client.linkedin')) . "',linkedin_email='".$profile['linkedin']->$email."' where id='" . $this->Session->read('clientid') . "'";
                $this->Client->query($sql);
				}else{
					//echo 'user_exist';die;
					$this->redirect(array('controller'=>'users','action'=>'user_exist_error'));
				}
				
            $this->redirect($this->Session->read('referral_url'));
        }elseif(!empty($client_info)){
				 $sql = "update jsb_client set linkedin_id='" . $profile['linkedin']->id . "',linkedin_token='" . serialize($this->Session->read('Client.linkedin')) . "',linkedin_email='".$profile['linkedin']->$email."'   where id='" . $client_info['Client']['id'] . "'";
                $this->Client->query($sql);
                $this->createSession($client_info['Client']['account_id'], 3);
                $this->Session->write('Client.Client.linkedin_id', $profile['linkedin']->id);
                $this->redirect(array('controller' => 'jobcards', 'action' => 'profileWizard'));
			
            } else {

                $first = "first-name";
                $last = "last-name";
                $email = 'email-address';
                $this->request->data['email'] = $profile['linkedin']->$email;
                $this->request->data['name'] = $profile['linkedin']->$first . " " . $profile['linkedin']->$last;
                $this->request->data['linkedin_id'] = $profile['linkedin']->id;
				$this->request->data['linkedin_email'] = $profile['linkedin']->$email;
                $this->request->data['linkedin_token'] = serialize($this->Session->read('Client.linkedin'));
                $this->request->data['password'] = md5('Password');
                $this->request->data['date_added'] = date('Y-m-d H:i:s');
                $this->request->data['usertype'] = $this->request->data['activate'] = '3';
                $this->createAccount(3, 1, 0);
                $this->Session->write('Client.Client.linkedin_id', $profile['linkedin']->id);
                $this->redirect(array('controller' => 'jobcards', 'action' => 'profileWizard'));
            }
       
    }
	
	
	public function check_exist_id($email)
	{
		
		$temp=$this->Client->find('first',array('conditions'=>array('OR'=>array('Client.email'=>$email,'Client.linkedin_email'=>$email)),'fields'=>array('Client.id')));
		$flag=0;
		
		if(!empty($temp)&&($temp['Client']['id']!=$this->Session->read('clientid')))
			{ $flag=1; }
		return $flag;	
	}

    public function getprofile() {
        $OBJ_linkedin = new LinkedIn($this->API_CONFIG);

        $OBJ_linkedin->setTokenAccess($this->Session->read('Client.linkedin.access'));
        $this->autoRender = false;
        $response = $OBJ_linkedin->profile('~:(id,first-name,last-name,headline,picture-url,publicProfileUrl,email-address)');
        if ($response['success'] === TRUE) {
            $response['linkedin'] = new SimpleXMLElement($response['linkedin']);

            return $response;
        } else
            return array();
    }

    public function searchJob($url) {
        $OBJ_linkedin = new LinkedIn($this->API_CONFIG);
        $OBJ_linkedin->setTokenAccess($this->Session->read('Client.linkedin.access'));
        return $OBJ_linkedin->searchJobs($url);
    }

}
