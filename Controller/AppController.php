<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
  
	public $components = array('Cookie', 'Session', 'Email',
							'Auth' => array(								
								'fields' => array(
									'username' => array('username', 'email'),
									'password' => 'password'
								),
								'authenticate' => array(
									'Form' => array(
										'fields' => array(
											'username' => 'email',
											'email'=>'email',
											'password'=>'password'
										)
									)
								)	
							)							
						);
		
	public $helpers = array('Session');

	function beforeFilter()
	{
		if(defined('CRON_DISPATCHER')){
			//echo '<pre>'; print_r($this->request); die;
		}
		$user = $this->Auth->user();		
		
		if(strtolower($this->params['plugin']) != 'admin' && isset($user['type']))
		{
			$this->redirect(array('controller'=>'users', 'action'=>'dashboard', 'plugin'=>'admin'));
		}
	}

	function afterFilter()
	{
		
	    if ($this->response->statusCode() == '404')
	    {		
			if ( $this->Session->read('Client.tablet_url') != '') 
			{
				$tablet_url = $this->Session->read('Client.tablet_url');			
			}
			else if ( $this->Cookie->read('App.Tablet.Url') != '') 
			{
				$tablet_url = $this->Cookie->read('App.Tablet.Url');			
			}
			
			if(isset($tablet_url) && !empty($tablet_url))
			{ 
		       $this->redirect('/'.$tablet_url);
			}/*else{
				
				
					$this->redirect(array('controller' => 'tablets', 'action' => 'pagenotfound','404') );
			}*/
	    }
	}

/* 
* Add a message to the messages array in the session like this: 
* $this->flash( 'You are logged in.', 'success' ); 
*/  

	function flash_new( $message, $class = 'status' ) 
	{ 
		$old = $this->Session->read('messages'); 
		$old[$class][] = $message; 
		$this->Session->write( 'messages', $old ); 
	} 
	
	function _setErrorLayout() 
	{  
		if ($this->name == 'CakeError' && strpos($this->params->url, 'admin') === false) 
		{  
			$this->layout = 'error';  
		}    
	}              

	function beforeRender () 
	{  
		if ( strtolower($this->params['plugin']) != 'admin')		
		{			
			$this->_setErrorLayout();
		}
		
		$loggedInUser = '';
			
		$user = $this->Auth->user();
		//pr($user);die;
		if($user != '' && !isset($user['type']))
		{
			$this->loadModel('User');
			$loggedInUser = $this->User->findById($user['id']);
		}
		
		$this->set(compact('loggedInUser'));
	}
	
	function _send_email($to_email, $token, $token_value, $template_indetifier ,$Setting)
	{
		
		if(!filter_var($to_email, FILTER_VALIDATE_EMAIL))
		{
			return false;
		}
		
		$this->loadModel('EmailTemplate');
		$template = $this->EmailTemplate->findByEmailIdentifier($template_indetifier);
		if (empty($template))
		{
			return false;
		}
				
		$template = $template['EmailTemplate'];
		
		$from_email  = str_replace('{from_email}',$Setting['from_email'] , $template['from_email'] ? $template['from_email'] : SITE_EMAIL) ;
		
		$from_name  =  str_replace('{from_name}',$Setting['from_name'] , $template['from_name']);
		
		$subject = str_replace('{domain}',$Setting['domain'] ,$template['subject']);
		
		$msg = $template['content'];
		
		$msg = str_replace($token, $token_value, $msg);
		$email = new CakeEmail('smtp'); 
		$email->from(array('mike@eyesocialeyes.com'=>'Social-Referral'));
		$email->to($to_email);
		$email->subject($subject);
		$email->emailFormat('html');
		
		if ($email->send($msg)) {
			return true;
		} else {
			return  $this->Email->smtpError;
		}
		
	}
		
	public function _auth_facebook($type = null)
	{
		
		App::uses('FB', 'Facebook.Lib');
		$Facebook = new FB();
		
		$fbPermissions = 'publish_actions,read_friendlists,email,user_likes';
		$login_url = $Facebook->getLoginUrl(array( 'scope'=>$fbPermissions, 'redirect_uri'=>SITE_URL.'domain/facebook_callback?redirect='.$type));
		//echo $login_url; die;
		$this->redirect($login_url);
			
		/*$redirect_url = SITE_URL.'domain/facebook_callback?redirect='.$type;
		$dialog_url = 'https://www.facebook.com/dialog/oauth?client_id='.FB_APP_ID.'&client_secret='.FB_APP_SECRET.'&redirect_uri='.$redirect_url.'&scope=read_stream,publish_stream,manage_friendlists,email';
	
		 	echo("<html><body><script> top.location.href='" . $dialog_url . "'</script></body></html>");	*/
	}
	
	public function _auth_twitter($type = null)
	{
		if ( $this->Session->read('twitter_email') != '' || $type == 'web')
		{
			App::import('Vendor', 'twitteroauth/twitteroauth');	
			
			$connection = new TwitterOAuth( LoginApi::TWITTER_CONSUMER_KEY , LoginAPI::TWITTER_CONSUMER_SECRET );
			$request_token = $connection->getRequestToken(SITE_URL.'domain/twitter_callback?redirect='.$type);
			
			$this->Session->write('twitter_oauth_token',$request_token['oauth_token']);
			$this->Session->write('twitter_oauth_token_secret',$request_token['oauth_token_secret']);
			
			$url = $connection->getAuthorizeURL($request_token['oauth_token']);
			
			$this->redirect($url);
		}
		else
		{
			$this->redirect(array('controller'=>'domain', 'action'=> 'require_email'));
		}
	}
	public function _auth_google($type = null)
	{			
		App::import('Vendor', 'Google/src/Google_Client');
		App::import('Vendor', 'Google/src/contrib/Google_Oauth2Service');
		
		$client = new Google_Client();
		$client->setApplicationName("Google UserInfo PHP Starter Application");
		
		$client->setClientId(LoginApi::GOOGLE_CLIENT_ID);
		$client->setClientSecret(LoginApi::GOOGLE_CLIENT_SECRET);
		$client->setRedirectUri(LoginApi::GOOGLE_CALLBACK_URL);
		$client->setDeveloperKey(LoginApi::GOOGLE_DEVELOPER_KEY);
		$client->setState($type);
		$oauth2 = new Google_Oauth2Service($client);		
		$authUrl = $client->createAuthUrl();
		//pr($authUrl);die;
		$this->redirect($authUrl);
	}
	function get_loggedIn_user()
	{
		$this->loadModel('User');
		return $this->User->findById($this->Auth->user('id'));
	}
}
