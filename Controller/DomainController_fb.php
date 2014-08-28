<?php

App::uses('AppController', 'Controller');


class DomainController extends AppController {

	public $uses = array();
	var $components = array('Facebook.Connect', 'Uploader',
		'Linkedin.Linkedin' => array('key' => '75th4f30vmuudu','secret' => 'CfO0S1vozVFQ59pX')
	);
	
	public function beforeFilter()
	{		
		parent::beforeFilter();
		$this->Auth->allow('login', 'linkdin_cancel', 'facebook_callback', 'twitter_callback', 'register', 'check_auth', 'require_email', 'linkedIn_callback', 'LinkedinLogin', 'google_callback', 'yahoo_callback');
	}	
	
	function check_auth($argu = null)
	{
		if ($argu == 'tab')
		{
			$this->redirect('/'.$this->Session->read('Client.tablet_url'));
			//$this->redirect( array( 'controller' => 'tablets', 'action'=>'domain', $this->Session->read('Client.tablet_url')));		
		}
		else
		{
			$this->redirect( '/w/'.$this->Session->read('Client.website_url'));	
		}
	}		
		
	public function login( $type='site' , $app_type = null )
    {
    	//pr($app_type); die;
		$this->Session->write('ApplicationType', 'tab');		
		switch($type)
		{
			case 'facebook':
				$this->_auth_facebook($app_type);
			break;
			case 'twitter':
				if($app_type == 'tab' ) { 
					$this->redirect(array('controller'=>'domain', 'action'=>'require_email'));
				}
				else {
					$this->_auth_twitter($app_type);
				}
			break;
			case 'yahoo':
				$this->redirect(array('controller'=>'pages', 'action'=>'yah_auth'));
			break;
			case 'linkdin':
				$this->_auth_linkdin($app_type);
			break;
			case 'google':
				$this->_auth_google($app_type);
			break;
			case 'site':
				if ( $this->Auth->user() )
				{
					$this->redirect($this->Auth->redirect());
				}
				if( $this->request->data )
				{
					echo $this->site_login();
					exit;
				}
			break;			
		}
		$title_for_layout = __('Login');
		$this->set( compact('title_for_layout') );		
    }    
    
	function logout($app_type = 'web')
	{
		$this->Auth->logout();
		
		$application_type = $this->Session->read('ApplicationType');
		$client = $this->Session->read('Client');
		
		if($this->Session->read('LoginType') == 'facebook')
		{
			App::uses('FB', 'Facebook.Lib');
			$Facebook = new FB();			
			
			
			if($app_type == 'tab')
			{
				$logoutUrl = $Facebook->getLogoutUrl(array('next'=>SITE_URL.$client['tablet_url'], 'access_token'=>$Facebook->getAccessToken()));       
			}
			else
			{ 
				$logoutUrl = $Facebook->getLogoutUrl(array('next'=>SITE_URL.'w/'.$client['website_url'], 'access_token'=>$Facebook->getAccessToken()));       
			}			  
			
			if ( $this->Session->check('coupon_location_good') )
			{
				$coupon_location_good = 1;
			}
			
			
			//$Facebook->destroySession();
			//setcookie('fbs_'.$Facebook->getAppId(), '', time()-100, '/', SITE_URL);
			
			App::uses('FB', 'Facebook.Lib');
			$Facebook = new FB();		
			$Facebook->destroySession();
			$this->Session->destroy();		
			//$this->Cookie->delete('App');
			
						
			if ( isset($coupon_location_good) )
			{
				$this->Session->write('coupon_location_good',1);
			}
			
			$this->Session->write('ApplicationType', $application_type);
			$this->Session->write('Client', $client);
			
			$this->redirect($logoutUrl);
		}
		else
		{
			//$this->Session->destroy();			
			$this->Session->write('ApplicationType', $application_type);
			$this->Session->write('Client', $client);
			
			if($app_type == 'tab') {
				$this->redirect('/'.$client['tablet_url']);
			}
			else {
				//$this->Session->destroy();
				
				$this->redirect('/w/'.$client['website_url']);
			}
		}
	}
    
    function require_email()
    {		
		$this->layout = 'tablet';
		
		$user_data = array();
		$user_data['Admin'] = $this->Session->read('Client');
		
		$this->set('user_data',$user_data);
		
		if (!empty($this->request->data) && !empty($this->request->data['User']['email']))
		{			
			if(!filter_var($this->request->data['User']['email'], FILTER_VALIDATE_EMAIL))
			{
				$this->flash_new( __('Invalid email. Please enter a valid email address'), 'error-messages' );
			}
			else
			{
				$this->Session->write('twitter_email', $this->request->data['User']['email']);
				$this->_auth_twitter("tab");
			}
		}
		
	}
	
    function facebook_callback($ac_token=null, $redirect = 'web')
	{
		//$redirect = !empty($_REQUEST['redirect'])?$_REQUEST['redirect']:'web';
		if(isset($_REQUEST['error']))
		{
			if(!empty($redirect) && $redirect == 'tab')
			{			
				$this->redirect( array( 'controller' => 'tablets', 'action' => 'login', $this->Session->read('DealId') ) );
			}
			else
			{
				$this->redirect( array( 'controller' => 'websites', 'action' => 'login' ) );
			}
		}	

		
		
		$deal_id = $this->Session->read('DealId');
		App::uses('FB', 'Facebook.Lib');
		$Facebook = new FB();
		try {
				if ( empty($ac_token) || trim($ac_token) == '')
				{
					$this->redirect(array('controller' => 'tablets', 'action' => 'login',$deal_id));					
				}
				$fb_access_token = $ac_token;
				$Facebook->setAccessToken($ac_token);
				$user = $Facebook->getUser();
				$fb_data = $Facebook->api('/me');
				
				
				
				
				$permissions = $Facebook->api("/me/permissions");
			
				
			if( !array_key_exists('publish_stream', $permissions['data'][0]) ) {
				
				if(isset($fb_data['email']))
					$this->Session->write('fb_user_email', $fb_data['email']);	
					$this->redirect(array('controller' => 'tablets', 'action' => 'exit_page', '1'));
				//$this->_auth_facebook($redirect);
			}
		
			$this->loadModel('User');
			
			if( !empty($fb_data))
			{
				try {
					//Email id exists or not
					if( !empty($fb_data['email']))
					{
						$fb_page_id = $this->Session->read('Client.fb_fanpage_id');
						
						if(!empty($fb_page_id))
						{
							$likes = $Facebook->api('/me/likes/'.$fb_page_id, 'GET');
							$this->log($likes);
							if ( isset($likes['data']) && !empty($likes['data']) )
							{
								$this->Session->write('already_liked','1');
							}
						}
						
						
						
						$exists_user = $this->User->findByEmail($fb_data['email']);
						
						$application_type = $this->Session->read('ApplicationType');
						
						
						if ( $this->Auth->user('id') )
						{
							$this->User->id = $this->Auth->user('id');
							$this->User->saveField('fb_id', $fb_data['id']);
							$this->User->saveField('fb_access_token', $fb_access_token);
							
							$this->Session->write('LoginType', 'facebook');	
							
							if(!empty($redirect) && $redirect == 'tab')
							{			
								$this->redirect( array( 'controller' => 'tablets', 'action' => 'share', $deal_id ) );
							}
							else
							{
								$this->redirect( array( 'controller' => 'websites', 'action' => 'profile' ) );
							}
						}
						else
						{
								$check_img = false;
								if(isset($exists_user['User']['image']) && !empty($exists_user['User']['image']))
								{
									$check_img = true;
								}
								
								if (empty($exists_user) || $check_img)
								{
									$fb_other_data = $Facebook->api('/me?fields=friends.limit(5000).fields(id),picture.width(9999).height(9999)');
									$image = '';
									if($fb_other_data['picture']['data']['is_silhouette'] == false)
									{
										$fb_img = $fb_other_data['picture']['data']['url'];
										$file_name = 'fb_'.$fb_data['id'].'.jpg';
										$source_path = PROFILE . $file_name;
										if($this->write_file($source_path, $fb_img))
										{
											$image = $file_name;
										}	
									}
									$data = array(
											'first_name'=> ( isset($fb_data['first_name']) ) ? $fb_data['first_name'] : $fb_data['name'],
											'last_name' => ( isset($fb_data['last_name']) ) ? $fb_data['last_name'] : '',
											'username'  => ( isset($fb_data['username']) ) ? $fb_data['username'] : '',
											'email' => $fb_data['email'],
											'fb_id' => $fb_data['id'],
											'fb_access_token' => $fb_access_token,
											'fb_friends'=> isset($fb_other_data['friends']['data'])? count($fb_other_data['friends']['data']):0,
											'image'=> $image
										); 
									}
									else
									{
										$fb_other_data = $Facebook->api('/me?fields=friends.limit(5000).fields(id)');
										$data = array(
												'first_name'=> ( isset($fb_data['first_name']) ) ? $fb_data['first_name'] : $fb_data['name'],
												'last_name' => ( isset($fb_data['last_name']) ) ? $fb_data['last_name'] : '',
												'username'  => ( isset($fb_data['username']) ) ? $fb_data['username'] : '',
												'fb_id' => $fb_data['id'],
												'fb_access_token' => $fb_access_token,
												'fb_friends'=> isset($fb_other_data['friends']['data'])? count($fb_other_data['friends']['data']):0,
											); 
									}
										
								if ( !empty($exists_user) )
								{
									$data['id'] = $exists_user['User']['id'] ;
									$this->User->validate = array();
									$user = $this->User->save($data);
								}
								else
								{									
									$data['password'] 		= 	$this->Auth->password( $fb_data['first_name'].$fb_data['id'] );						
									$data['status'] 		= 	UserDeinedStatus::Active ;						
									$this->User->validate = array();
									$user = $this->User->save($data);	
								}
								
								// For autologin functionality we have to add data on Cake::Request then only auth component works
								
								if ( !empty($exists_user['User']['id']) )
								{
									// if user already registered with facebook email id
									$this->Auth->login( $exists_user['User'] );
								}
								else
								{
									$this->Auth->login($user['User']);
								}
								
								if ( $this->Auth->login() )
								{	
									$this->Session->write('LoginType', 'facebook');	
										
									if(!empty($redirect) && $redirect == 'tab')
									{			
										$this->redirect( array( 'controller' => 'tablets', 'action' => 'share', $deal_id ) );
									}
									else
									{
										$this->redirect( array( 'controller' => 'websites', 'action' => 'profile' ) );
									}
								}
								else
								{
									// Redirect
									$this->flash_new( __('Unable Login with facebook. Please try again'), 'error-messages' );		
									$this->redirect(array('controller' => 'tablets', 'action' => 'login',$deal_id));				
								}
							}
						}
						else
						{
							// Redirect	
							$this->flash_new( __('request can not be completed'), 'error-messages' );			
							//$this->check_auth($redirect);
							$this->redirect(array('controller' => 'tablets', 'action' => 'login',$deal_id));	
						}
				  }
				  catch (FacebookApiException $e) {
					// Redirect	
							//$Facebook->destroySession();
							//$this->Session->destroy();
					$this->flash_new( __('In-valid request '), 'error-messages' );
					//$this->check_auth($redirect);
					$this->redirect(array('controller' => 'tablets', 'action' => 'login',$deal_id));	
				  }
				
			}
			else
			{
				// Redirect	
				$this->flash_new( __('In-valid request '), 'error-messages' );
				//$this->check_auth($redirect);
				$this->redirect(array('controller' => 'tablets', 'action' => 'login',$deal_id));	
			}
		}
		catch (Exception $e)
		{
			// Redirect	
			
							//$Facebook->destroySession();
							//$this->Session->destroy();
			$this->flash_new( __('In-valid request '), 'error-messages' );
			//$this->check_auth($redirect);
			$this->redirect(array('controller' => 'tablets', 'action' => 'login',$deal_id));	
		}
	}
	
	function twitter_callback()
	{	
		$redirect = !empty($_REQUEST['redirect'])?$_REQUEST['redirect']:'web';
		
		if(isset($_REQUEST['denied']))
		{
			if(!empty($redirect) && $redirect == 'tab')
			{			
				$this->redirect( array( 'controller' => 'tablets', 'action' => 'login', $this->Session->read('DealId') ) );
			}
			else
			{
				$this->redirect( array( 'controller' => 'websites', 'action' => 'login' ) );
			}
		}
		
		App::import('Vendor', 'twitteroauth/twitteroauth');
		$twitter_oauth_token = $this->Session->read('twitter_oauth_token');
		$twitter_oauth_token_secret = $this->Session->read('twitter_oauth_token_secret');
		$connection = new TwitterOAuth(LoginApi::TWITTER_CONSUMER_KEY, LoginApi::TWITTER_CONSUMER_SECRET, $twitter_oauth_token , $twitter_oauth_token_secret);
							
		$tw_data = $connection->getAccessToken($_REQUEST['oauth_verifier']);	
		
		$this->Auth->logout();
		
		if ( !empty($tw_data['user_id']) )
		{				
			
			$this->loadModel('User');	
			$exists_user = $this->User->findByEmail($this->Session->read('twitter_email'));			
			
			$application_type = $this->Session->read('ApplicationType');
			$deal_id = $this->Session->read('DealId');
					
			$tw_user_json = $connection->get('account/verify_credentials');				
		
			if(!empty($tw_user_json->profile_image_url))
			{
				$tw_image = str_replace('_normal', '', $tw_user_json->profile_image_url);
				$file_name = 'tw_'.$tw_data['user_id'].'.jpg';
				$source_path = PROFILE . $file_name;
				if($this->write_file($source_path, $tw_image))
				{
					$image = $file_name;
				}
			}
			else
			{
				$image = '';
			}
			
			$data = array(
						'first_name' => $tw_user_json->name,
						'last_name' => '',
						'username' => $tw_data['screen_name'],
						'tw_id'=>$tw_data['user_id'],
						'tw_oauth_token'=>$tw_data['oauth_token'],
						'tw_oauth_token_secret'=> $tw_data['oauth_token_secret'],
						'tw_screen_name'=> $tw_data['screen_name'],
						'tw_friends'=> $tw_user_json->followers_count,
						'image'=>$image						
					);  
					
			if ( $exists_user )
			{
				$data['id'] = $exists_user['User']['id'] ;
				$this->User->validate = array();
				$user = $this->User->save($data);
			}
			else
			{	
				if(!empty($redirect) && $redirect == 'tab')
				{		
					$data['email'] = $this->Session->read('twitter_email');									
				}
				$data['password'] = $this->Auth->password( $tw_data['screen_name'].$tw_data['user_id']);
				$data['status'] 		= 	UserDeinedStatus::Active ;
				
				$this->User->validate = array();
				$user = $this->User->save($data);
				
			}
			
			// For autologin functionality we have to add data on Cake::Request then only auth component works
			
			if ( !empty($exists_user['User']['id']) )
			{					
				$this->Auth->login( $exists_user['User'] );
			}
			else
			{
				$this->Auth->login($user['User']);
			}
			
			if ( $this->Auth->login() )
			{	
				$this->Session->write('LoginType', 'twitter');
					
				// delete user email id enter for login with twitter				
				$this->Session->delete('twitter_email');
				
				
				/*check if user already followed clients twitter page*/
				$followers = $connection->get('followers/ids', array('screen_name' => $this->Session->read('Client.twitter_url'),'count' => 5000));
				
						
				if ( !empty($followers) )
				{
					if ( isset($followers->ids) && !empty($followers->ids) )
					{
						foreach($followers->ids as $id)
						{
							if ( $id == $this->Auth->user('tw_id') )
							{
								$this->Session->write('already_liked','1');
								break;
							}
						}
					} 
				}
				
				if($redirect == 'tab')
				{				
					$this->redirect( array( 'controller' => 'tablets', 'action' => 'share', $deal_id) );
				}
				else
				{
					$this->redirect( array( 'controller' => 'websites', 'action' => 'profile' ) );
				}
			}
			else
			{
				// Redirect
				$this->flash_new( __('Unable Login with twitter. Please try again'), 'error-messages' );
				$this->check_auth($redirect);
			}			
		}
	}
	
	function write_file($path, $file_url)
	{
		$ch = curl_init ($file_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$raw=curl_exec($ch);
		
		if(curl_errno($ch))
		{
			echo 'error:' . curl_error($ch);die;
		}
		curl_close ($ch);
		
		$fp = fopen($path,'wb');
		fwrite($fp, $raw);
		fclose($fp);
		 
		return true;
	}
	
	
	function register()
	{
		$this->layout = 'public';
		
		if(!empty($this->request->data))
		{
			$this->loadModel('User');
			$this->User->set($this->data['User']);
			if ($this->User->validates(array('fieldList' =>array('email', 'password', 'first_name', 'last_name'))))
			{
				$this->User->create();
				$data = $errors = $this->request->data['User'];
				$data['status'] = 'active';
				
				if($userSaved = $this->User->save($data, false))
				{
					$this->loadModel('Setting');
					$settings = $this->Setting->findByKey('site_setting');
					$setting_data = json_decode($settings['Setting']['value'],true);
					$Setting = $setting_data['Settings'];
					
					$token = array('{first_name}','{last_name}','{email}', '{domain}' );
					$token_value = array(
											$this->request->data['User']['first_name'],
											$this->request->data['User']['last_name'],
											$this->request->data['User']['email'],
											$Setting['domain'] 
										);
					
					$this->_send_email($this->request->data['User']['email'] , $token, $token_value, 'EMAIL_REGISTER' , $Setting);
					$this->Auth->login($userSaved['User']);
					if($this->Auth->user())
					{
						$this->redirect(array('controller'=>'websites', 'action'=>'profile'));
					}
					else
					{
						$this->redirect(SITE_URL.'w/'.$this->Session->read('Client.website_url'));
					}
				}
				else
				{
					$errors = $this->User->validationErrors;
				}
			}
			else
			{
				$errors = $this->User->validationErrors;				
			}
		}
	}
	
	function google_callback()
	{
		if(isset($_REQUEST['error']))
		{
			// Redirect
			$this->flash_new( __('You need to allow to login with google. Please try again'), 'error-messages' );		
			$this->check_auth();	
		}
		App::import('Vendor', 'Google/src/Google_Client');
		App::import('Vendor', 'Google/src/contrib/Google_Oauth2Service');
	
		$client = new Google_Client();
		$client->setApplicationName("Google UserInfo PHP Starter Application");
		
		$client->setClientId(LoginApi::GOOGLE_CLIENT_ID);
		$client->setClientSecret(LoginApi::GOOGLE_CLIENT_SECRET);
		$client->setRedirectUri(LoginApi::GOOGLE_CALLBACK_URL);
		$client->setDeveloperKey(LoginApi::GOOGLE_DEVELOPER_KEY);
		$oauth2 = new Google_Oauth2Service($client);	
		
		$acess_token = $client->authenticate($_GET['code']);
		$client->setAccessToken($acess_token);	
		
		$user = $oauth2->userinfo->get();
		
		if ( $user )
		{		
			//Email id exists or not
			if( !empty($user['email']))
			{
				$this->loadModel('User');
				$exists_user = $this->User->findByEmail($user['email']);
				
				$application_type = $this->Session->read('ApplicationType');
				$deal_id = $this->Session->read('DealId');
				
				if ( $this->Auth->user('id') )
				{				
					$this->User->id = $this->Auth->user('id');
					$this->User->saveField('google_id', $user['id']);
					
					$this->Session->write('LoginType', 'google');	
					
					$this->redirect( array( 'controller' => 'websites', 'action' => 'profile' ) );
				}
				else
				{
					$image = '';
					
					$data = array(
								'first_name'=> $user['given_name'],
								'last_name' => $user['family_name'],
								'username'  => $user['given_name'].$user['family_name'],
								'email' => $user['email'],
								'google_id' => $user['id'],
								'image'=> $image
							); 
							
					if ( $exists_user )
					{
						$data['id'] = $exists_user['User']['id'] ;
						$this->User->validate = array();
						$user = $this->User->save($data);
					}
					else
					{									
						$data['password'] 		= 	$this->Auth->password( $user['given_name'].$user['id'] );						
						$data['status'] 		= 	UserDeinedStatus::Active ;						
						$this->User->validate = array();
						$user = $this->User->save($data);	
					}
					
					// For autologin functionality we have to add data on Cake::Request then only auth component works					
					if ( !empty($exists_user['User']['id']) )
					{
						$this->Auth->login( $exists_user['User'] );
					}
					else
					{
						$this->Auth->login($user['User']);
					}
					
					if ( $this->Auth->login() )
					{	
						$this->Session->write('LoginType', 'google');	
							
						$this->redirect( array( 'controller' => 'websites', 'action' => 'profile' ) );
					}
					else
					{
						// Redirect
						$this->flash_new( __('Unable Login with google. Please try again'), 'error-messages' );		
						$this->check_auth();						
					}
				}								
			}
			else
			{						
				// Redirect	
				$this->flash_new( __('Request can not be completed'), 'error-messages' );			
				$this->check_auth();
			}			
		}
		
	}	
	
	function linkedIn_callback()
	{
		
		if($this->request->query('oauth_problem'))
		{			
			$this->flash_new( __('Linkedin Login cancelled'), 'error-messages' );
			$this->redirect(array('controller'=>'domain','action'=>'check_auth'));
		}
		else
		{
			$this->Linkedin->authorize( array('action'=>'LinkedinLogin'));
		}
	}
	
	function LinkedinLogin($app_type = 'web')
	{		
		//pr($this->Session->read());die;
		if(!$this->Linkedin->isConnected()) {
			$this->Linkedin->connect( array('action'=>'linkedIn_callback?redirect=$app_type'));
		}
		$linkedinProfile = $this->Linkedin->call('people/~',
														array(
																'id',
																'picture-url',
																'first-name', 'last-name','email-address', 'summary', 'specialties', 'associations', 'honors', 'interests', 'twitter-accounts',
																'positions' => array('title', 'summary', 'start-date', 'end-date', 'is-current', 'company'),
																'educations',
																'certifications',
																'skills' => array('id', 'skill', 'proficiency', 'years'),
																'recommendations-received',
																'main-address',
																'phone-numbers',
																'location:(name)',
																'public-profile-url',
																
														));
		$this->loadModel('User');
		
		if( !empty($linkedinProfile))
		{			
			//Email id exists or not
			if( !empty($linkedinProfile['person']['email-address']))
			{
				$exists_user = $this->User->findByEmail($linkedinProfile['person']['email-address']);
				
				$application_type = $this->Session->read('ApplicationType');
				$deal_id = $this->Session->read('DealId');
				
				if ( $this->Auth->user('id') )
				{				
					$this->User->id = $this->Auth->user('id');
					$this->User->saveField('linkd_id', $linkedinProfile['person']['id']);
					
					$this->Session->write('LoginType', 'linkdin');	
					
					$this->redirect( array( 'controller' => 'websites', 'action' => 'profile' ) );
				}
				else
				{
					$image = '';
					
					$data = array(
								'first_name'=> $linkedinProfile['person']['first-name'],
								'last_name' => $linkedinProfile['person']['last-name'],
								'username'  => $linkedinProfile['person']['first-name'].$linkedinProfile['person']['id'],
								'email' => $linkedinProfile['person']['email-address'],
								'linkd_id' => $linkedinProfile['person']['id'],
								'image'=> $image
							); 
							
					if ( $exists_user )
					{
						$data['id'] = $exists_user['User']['id'] ;
						$this->User->validate = array();
						$user = $this->User->save($data);
					}
					else
					{									
						$data['password'] 		= 	$this->Auth->password( $linkedinProfile['person']['first-name'].$linkedinProfile['person']['id'] );						
						$data['status'] 		= 	UserDeinedStatus::Active ;						
						$this->User->validate = array();
						$user = $this->User->save($data);	
					}
					
					// For autologin functionality we have to add data on Cake::Request then only auth component works
					
					if ( !empty($exists_user['User']['id']) )
					{
						// if user already registered with facebook email id
						$this->Auth->login( $exists_user['User'] );
					}
					else
					{
						$this->Auth->login($user['User']);
					}
					
					if ( $this->Auth->login() )
					{	
						$this->Session->write('LoginType', 'linkdin');	
							
						$this->redirect( array( 'controller' => 'websites', 'action' => 'profile' ) );
					}
					else
					{
						// Redirect
						$this->flash_new( __('Unable Login with LinkedIn. Please try again'), 'error-messages' );		
						$this->check_auth($app_type);				
					}
				}								
			}
			else
			{						
				// Redirect	
				$this->flash_new( __('Request can not be completed'), 'error-messages' );			
				$this->check_auth($app_type);
			}
		}
		else
		{	
			// Redirect	
			$this->flash_new( __('In-valid request '), 'error-messages' );		
			$this->check_auth($app_type);
		}
	}
	
	public function linkdin_cancel()
	{
		$this->check_auth('web');
	}
	
}
