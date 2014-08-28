<?php

App::uses('AppController', 'Controller');

class TabletsController extends AppController {

	public $uses = array();
	public $components = array('Uploader');
	var $layout = 'tablet';
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->loginAction = array(
			'controller' => 'tablets',
			'action' => 'domain', $this->Session->read('Client.tablet_url')
		);
		$this->Auth->loginRedirect = array(
			'controller' => 'tablets',
			'action' => 'domain', $this->Session->read('Client.tablet_url')
		);
		$this->Auth->logoutRedirect = array(
			'controller' => 'tablets',
			'action' => 'domain', $this->Session->read('Client.tablet_url')
		);
		$this->Auth->allow(array('index', 'login', 'api_login',  'domain', 'share_cron', 'google_callback'));
    	$this->Cookie->time = 3600*24; 
	}
	
	public function domain($tablet_url = null)
	{
		App::uses('FB', 'Facebook.Lib');
		$Facebook = new FB();		
		$Facebook->destroySession();		
			
		$this->loadModel('Admin');
		
		if (empty($tablet_url) && $this->Session->read('Client.tablet_url') != '') 
		{
			$tablet_url = $this->Session->read('Client.tablet_url');			
		}
		
		if (empty($tablet_url) && $this->Cookie->read('App.Tablet.Url') != '') 
		{
			$tablet_url = $this->Cookie->read('App.Tablet.Url');			
		}
		
		if(!empty($tablet_url))
		{	
			$user_data = $this->Admin->get_user_tab_data($tablet_url);			
			
			if (!empty($user_data))
			{
				$this->Cookie->write('App.Tablet.Url', $tablet_url);
				$this->Session->write('Client', $user_data['Admin']);
				$this->Session->write('ApplicationType', 'tab');
				$this->set(compact('user_data'));
			}
			else 
			{
				throw new NotFoundException('Invalid url or Your session has been expired');
			}
		}
		else
		{
			throw new NotFoundException('Invalid url or Your session has been expired');
		}	
	}
	
	public function login($id = null)
	{
		$this->loadModel('AdminClientDeal');
		$deal = $this->AdminClientDeal->find('first', array('conditions'=>array('id'=>$id, 'status'=>'active')));
		
		if (!empty($deal))
		{
			$this->Session->write('DealId', $id);			
			$this->set(compact('deal'));
		}
		else 
		{
			throw new NotFoundException('No Deal found for this user.');
		}	
	}
	
	public function api_login()
	{	
		if(isset($this->request->params['ext']) && $this->request->params['ext'] == 'json' && !empty($this->request->data))
		{
			$username = $this->request->data['email'];
			$password = $this->Auth->password($this->request->data['password']);
			
			try
			{
				$this->loadModel('Admin');
				$user_details = $this->Admin->find('first', 
					array(
						'conditions'=>array(
							'OR'=>array('Admin.email'=>$username, 'Admin.username'=>$username),
							'Admin.password'=>$password
						),
						'fields'=>array(
							'tablet_url'
						)
					)
				);
				
				if(!empty($user_details))
				{
					$data['tablet_url'] = SITE_URL.'tablets/domain/'.$user_details['Admin']['tablet_url'];
					$response = array('status'=>'ok', 'Message'=>'', 'data'=>$data);
				}
				else{
					$response = array('status'=>'error', 'Message'=>'Invalid username or password.');
				}
			}
			catch(Exception $e)
			{
				$response = array('status'=>'error', 'data'=>$e->getMessage());
			}			
		}
		else {
			$response = array('status'=>'error', 'Message'=>'Invalid request');
		}
		
		echo json_encode($response);
		exit;
	}
		
	function share($deal_id = null)
	{		
		//Configure::write('debug',2);
		$this->loadModel('AdminClientDeal');
		$this->loadModel('Admin');
		
		if(!empty($this->request->data))
		{
			$this->loadModel('AdminClientDealShare');
			$query = '';
			$user_id = $this->Auth->user('id');
			$current_client_id = $this->Session->read('Client.id');
			$current_deal_id = $this->Session->read('DealId');
			$share_type = $this->Session->read('LoginType');
			//echo $share_type; die;
			$friends = $share_type == 'facebook'?$this->Auth->user('fb_friends'):$this->Auth->user('tw_friends');
			if(empty($friends)) {
				$friends = 0;
			}
			$time_now = date('Y-m-d H:i:s');
			$query .= "($user_id, $current_client_id, $current_deal_id, '$share_type', $friends, 'yes','pending', '$time_now', '$time_now'),";
			
			$query = rtrim($query,",");
			$final_query = "INSERT into admin_client_deal_shares (user_id, client_id, deal_id, share_type, friend_count, is_primary, status, created, modified) VALUES $query"; 
							
			$this->AdminClientDealShare->query($final_query);
			$this->Session->write('share_deal_id', $current_deal_id);
			$this->redirect(array('controller'=>'tablets', 'action'=>'thank_you',$current_deal_id ));
			
		}
		
		$deal = $this->AdminClientDeal->findDealById($deal_id);		
		//pr($deal);
		if(empty($deal))
		{
			throw new NotFoundException('No deal found.');
		}
		$slider_deal = $this->AdminClientDeal->clientAllDeal();	
		//pr($slider_deal);die;
		$client_details = $this->Admin->read('company, facebook_url, twitter_url, tablet_url, website_url, mobile', $this->Session->read('Client.id'));
		$StatusMessage = new StatusMessage();
		
		$fb_message = $StatusMessage->fb_message($client_details['Admin'], $deal);
		$tw_message = $StatusMessage->tw_message($client_details['Admin'], $deal);
		$fb_fanpage_message = $StatusMessage->fb_fanpage_message($this->Auth->user(),$client_details['Admin'], $deal);
		$this->set(compact('deal', 'slider_deal', 'client_details', 'fb_message', 'tw_message'));
	}	
	
	function facebook_fanpage_share($deal=NULL, $get_loggedIn_user=NULL, $fb_fanpage_message=NULL)
	{
		App::uses('FB', 'Facebook.Lib');
		$Facebook = new FB();
		
		$current_access_token = $Facebook->getAccessToken();
		$access_token = 'CAAJQC00Wz3MBAOwGyq8ahT6OkJSnFibCE6JMi6qEP2bqFhFDdjFPTYzZA1x6MuxvC8rKGg6KifZAG3w2SGwLMjijfMq4eNKuPFHttT4Cqr0qWQfHBRhwndNkzobe7ZC5Mx0BnU3Sm16jLqq2kvU213M4xqzWJMeMHnnL0gaWjOTN8q7ZAvYz'/*'CAAH7E39u1FsBAEIkZBD9bn7BC43KyIZC1JlR8UFlglVYryu0xyYAYmSXlN4wROAO8oRZCYjFrQmUJb5FPUBvXgPqZBISCJJnb9NarKRRjRnURTRoeOsYluZB9UGFVmthlvZAuAIa4ljWtrDfZC7o3ZAmQZB5K0n0vGZAXAdxiNuNo3mSEPBYIcO5wCam7JZCQTTx9IZD'*/;
		$params = array('access_token' => $access_token);
		// Fan PAGE ID  
		$fanpage = $deal['Admin']['fb_fanpage_id'];
		
		//Do Not Modify !!!
		$accounts = $Facebook->api('/100004413962444/accounts', 'GET', $params);
		
		foreach($accounts['data'] as $account) 
		{
			if( $account['id'] == $fanpage || $account['name'] == $fanpage )
			{
				$fanpage_token = $account['access_token'];
				$Facebook->setAccessToken($fanpage_token);
				$fanpage_album_name = $get_loggedIn_user['User']['first_name'].'_'.$get_loggedIn_user['User']['last_name'];							
				$fanpage_album_details = array('message'=> 'Powered by https://eyesocialeyes.com/','name'=> $fanpage_album_name);
				
				if(!empty($get_loggedIn_user['User']['image']) && file_exists( PROFILE . $get_loggedIn_user['User']['image']))
				{
					$source_path = PROFILE . $get_loggedIn_user['User']['image'];
				}
				else
				{
					$source_path = DEFAULTIMAGE . '/no_image_available.jpg';
				}
				$fanpage_album = $Facebook->api('/'.$fanpage.'/albums', 'post', $fanpage_album_details);
				$fanpage_album_id = $fanpage_album['id'];
				
				$args = array(
					'message' => $fb_fanpage_message,
					'src' => '@'. $source_path,
					'aid' => $fanpage_album_id,
					'access_token'=>$fanpage_token
				);									    
				
				$Facebook->setFileUploadSupport(true);
				$code = $Facebook->api('/'.$fanpage_album_id.'/photos', 'POST', $args );
				$Facebook->setAccessToken($current_access_token);										
			}
		}
		 return true;
	}
	function thank_you()
	{	
		$this->loadModel('AdminClientDeal');
		
		if (!empty($this->request->data['MultiShare']['ids']) && $this->request->is('Ajax'))
		{
			$deal_ids = $this->request->data['MultiShare']['ids'];
			$user_id = $this->Auth->user('id');
			$share_type = $this->Session->read('LoginType');
			$friends = $this->Session->read('LoginType') == 'facebook'?$this->Auth->user('fb_friends'):$this->Auth->user('tw_friends');
			if(empty($friends)) {
				$friends = 0;
			}
			foreach($deal_ids as $id)
			{
				list($deal_id, $client_id) = explode("-", $id);	
				$time_now = date('Y-m-d H:i:s');
				$query .= "($user_id, $client_id, $deal_id, '$share_type', $friends, 'no','pending', '$time_now', '$time_now'),";
			}
			
			$query = rtrim($query,",");
			$final_query = "INSERT into admin_client_deal_shares (user_id, client_id, deal_id, share_type, friend_count, is_primary, status, created, modified) VALUES $query";  
			$this->loadModel('AdminClientDealShare');
			$this->AdminClientDealShare->query($final_query);
			exit;
		}
		
		$deal_id = $this->Session->read('DealId');
		$login_type = $this->Session->read('LoginType');
		$share_deal_id = $this->Session->read('share_deal_id');
		$deal = $this->AdminClientDeal->findDealById($deal_id);			
		$slider_deal = $this->AdminClientDeal->clientAllDeal();	
		
		$this->set(compact('deal', 'slider_deal', 'login_type', 'share_deal_id'));
	}
	 
	function post_message()
	{
		//Configure::write('debug',2);
		$share_deal_id = $this->Session->read('share_deal_id');		
		
		if(!empty($share_deal_id) && !empty($this->request->data))
		{
			$id = $this->request->data['id'];
			$this->loadModel('AdminClientDealShare');
			$this->AdminClientDealShare->bindModel(array(
					'belongsTo'=>array(
						'Admin'=>array(
							'className'=>'Admin',
							'foreignKey'=>'client_id',
							'fields'=>array(
								'id', 'first_name', 'last_name', 'email', 'company', 'website_url', 'twitter_url', 'tablet_url', 'fb_fanpage_id', 'mobile'
							)
						),
						'AdminClientDeal'=>array(
							'className'=>'AdminClientDeal',
							'foreignKey'=>'deal_id',
							'fields'=>array(
								'title', 'description', 'price', 'image', 'type', 'product'
							)
						),
						'User'=>array(
							'className'=>'User',
							'foreignKey'=>'user_id',
							'fields'=>array(
								'first_name', 'last_name', 'email', 'fb_id', 'fb_access_token', 'fb_friends', 'tw_id', 'tw_screen_name', 'tw_oauth_token',
								'tw_oauth_token_secret', 'tw_friends', 'image'
							)
						)
					)
				)
			);
				
			$share = $this->AdminClientDealShare->find('first', 
												array(
													'conditions'=>array(
														'AdminClientDealShare.status'=>'pending',
														'AdminClientDealShare.deal_id'=>$id,
														'AdminClientDealShare.is_primary'=>'yes',
														'AdminClientDealShare.user_id'=>$this->Auth->user('id')
													)												
												)
											);
			//pr($share); //die;
			if(!empty($share))
			{
				App::uses('FB', 'Facebook.Lib');
				$Facebook = new FB();
				App::import('Vendor', 'twitter/tmhOAuth');
				$StatusMessage = new StatusMessage();
			
				
				$get_loggedIn_user['User'] = $share['User'];	
				
				$deal['AdminClientDeal'] = $share['AdminClientDeal'];
				$deal['Admin'] = $share['Admin'];	
				
				if(!empty($deal))
				{	
					$fb_message = $StatusMessage->fb_message($deal['Admin'], $deal);
					$tw_message = $StatusMessage->tw_message($deal['Admin'], $deal);
					$fb_fanpage_message = $StatusMessage->fb_fanpage_message($share['User'], $deal['Admin'], $deal);
					
					$img = dirname(dirname(__FILE__)).DS.'webroot'.DS.'img'.DS.'deal'.DS.$deal['AdminClientDeal']['image'];
					
					if($share['AdminClientDealShare']['share_type'] == 'facebook')
					{	
						$Facebook->setAccessToken($get_loggedIn_user['User']['fb_access_token']);
						$album_name = $deal['Admin']['company'].'_'.$deal['AdminClientDeal']['title'];							
						$album_details = array('message'=> 'Powered by https://eyesocialeyes.com/','name'=> $album_name);
						$album = $Facebook->api('/'.$get_loggedIn_user['User']['fb_id'].'/albums', 'post', $album_details);
						$album_id = $album['id'];
						
						$msg_body = array(
							'source'=>'@' . $img,
							'message' => $fb_message ,
							'aid' => $album_id,
						);	
						
						$check = $Facebook->api('/'.$album_id.'/photos', 'POST', $msg_body );
						
						if($check)
						{	
							$dealShare['AdminClientDealShare']['id'] = $share['AdminClientDealShare']['id'];							
							$dealShare['AdminClientDealShare']['status'] = 'posted';
							$this->AdminClientDealShare->save($dealShare);
																			
							if(!empty($deal['Admin']['fb_fanpage_id']))
							{
								$this->facebook_fanpage_share($deal, $get_loggedIn_user, $fb_fanpage_message);
							}
							// Send coupon Email to user
							
							$this->coupon_email($img, $deal, $get_loggedIn_user['User']);									
						}
					}
					else if($share['AdminClientDealShare']['share_type'] == 'twitter')
					{	
						$tmhOAuth = new tmhOAuth(array(
							  'consumer_key' => LoginAPI::TWITTER_CONSUMER_KEY,
							  'consumer_secret' => LoginAPI::TWITTER_CONSUMER_SECRET,
							  'token' => $get_loggedIn_user['User']['tw_oauth_token'],
							  'secret' => $get_loggedIn_user['User']['tw_oauth_token_secret']		  
							)
						);								
						// Remove characters from message as twiiter has the limit for characters
						$msg = substr($tw_message, 0, 120);				
						$params = array(
									'media[]' => '@'.$img,
									'status'  => $msg,
									
								  );
						$code = $tmhOAuth->user_request(array(
															'method' => 'POST',
															'url' => $tmhOAuth->url("1.1/statuses/update_with_media"),
															'params' => $params,
															'multipart' => true	
														)
													);
						if($code != 403)
						{	
							$dealShare['AdminClientDealShare']['id'] = $share['AdminClientDealShare']['id'];							
							$dealShare['AdminClientDealShare']['status'] = 'posted';
							$this->AdminClientDealShare->save($dealShare);
									
							if(!empty($deal['Admin']['fb_fanpage_id']))
							{	
								$this->facebook_fanpage_share($deal, $get_loggedIn_user, $fb_fanpage_message);							
							}	
							// Send coupon Email to user
							$this->coupon_email($img, $deal, $get_loggedIn_user['User']);
						}		  
					} 
				}				
			}
			$this->Session->delete('share_deal_id');
		}
		exit;
	}
	function exit_page()
	{
		$this->loadModel('AdminClientDeal');
		$this->loadModel('Setting');
		$login_type = $this->Session->read('LoginType');
		
		$logout_image = $this->Setting->find('first', array(
								'fields'=>'image'
							)
						);
		
		$slider_deal = $this->AdminClientDeal->clientAllDeal();
		
		
		$this->set(compact('logout_image', 'slider_deal', 'login_type'));
	}
	
	function coupon_email($attachment = NULL, $client=NULL, $user=NULL)
	{
		//pr($client); 
		$this->loadModel('AdminClientDealEmail');
		
		$adminClientDeal = $this->AdminClientDealEmail->find('first',array('conditions'=>array('client_id'=>$client['Admin']['id'])));
		//pr($adminClientDeal);
		if(!empty($adminClientDeal))
		{
			$path_parts = pathinfo($attachment);
			$size = getimagesize($attachment);	
			$arr_keys = array('{first_name}','{last_name}','{deal_title}');
			$arr_values = array($user['first_name'],$user['last_name'],$client['AdminClientDeal']['title']);

			$email_content = str_replace($arr_keys, $arr_values, $adminClientDeal['AdminClientDealEmail']['content']);
			
			$email = new CakeEmail('smtp'); 		
			$email->from(array($adminClientDeal['AdminClientDealEmail']['from_email']=>$adminClientDeal['AdminClientDealEmail']['from_name']));
			if(isset($adminClientDeal['AdminClientMarketingEmail']['reply_to']) && !empty($adminClientDeal['AdminClientMarketingEmail']['reply_to']))
			{
				$email->replyTo($adminClientDeal['AdminClientMarketingEmail']['reply_to']);
			}
			$email->to($user['email']);
			$email->subject($adminClientDeal['AdminClientDealEmail']['subject']);
			$email->emailFormat('html');
			$email->attachments(array(
					$path_parts['basename'] => array(
						'file' => $attachment,
						/*'mimetype' => $size['mime'],
						'contentId' => 'my-unique-id'*/
					)
				));
			if ($email->send($email_content)) {
				$res = 'yes';
			} else {
				$res =  $this->Email->smtpError;
			}
		}
		else
		{
			$path_parts = pathinfo($attachment);
			$size = getimagesize($attachment);	
			
			$email = new CakeEmail('smtp'); 		
			$email->from(array('xicomtest10@gmail.com'=>'SocialReferral'));
			$email->to($user['email']);
			$email->subject('Your '.$client['Admin']['company']. ' coupon');
			$email->viewVars(array ('client' => $client, 'user'=> $user));		
			$email->template('share', 'default');
			$email->emailFormat('html');
			$email->attachments(array(
					$path_parts['basename'] => array(
						'file' => $attachment,
						'mimetype' => $size['mime'],
						'contentId' => 'my-unique-id'
					)
				));
			if ($email->send()) {
				$res = 'yes';
			} else {
				$res =  $this->Email->smtpError;
			}
		}
		return $res;
		
	}
	/*
	function coupon_email($attachment = NULL, $client=NULL, $user=NULL)
	{
		$path_parts = pathinfo($attachment);
		$size = getimagesize($attachment);	
		
		$email = new CakeEmail('smtp'); 		
		$email->from(array('xicomtest10@gmail.com'=>'SocialReferral'));
		$email->to($user['email']);
		$email->subject('Your '.$client['Admin']['company']. ' coupon');
		$email->viewVars(array ('client' => $client, 'user'=> $user));		
		$email->template('share', 'default');
		$email->emailFormat('html');
		$email->attachments(array(
				$path_parts['basename'] => array(
					'file' => $attachment,
					'mimetype' => $size['mime'],
					'contentId' => 'my-unique-id'
				)
			));
		
		if ($email->send()) {
			$res = 'yes';
		} else {
			$res =  $this->Email->smtpError;
		}
		return $res;
		
	}*/
	
	function share_cron()
	{	
		set_time_limit(0);	
		$this->loadModel('AdminClientDealShare');
		
		$this->AdminClientDealShare->bindModel(array(
				'belongsTo'=>array(
					'Admin'=>array(
						'className'=>'Admin',
						'foreignKey'=>'client_id',
						'fields'=>array(
							'first_name', 'last_name', 'email', 'company', 'website_url', 'twitter_url', 'tablet_url', 'fb_fanpage_id', 'mobile'
						)
					),
					'AdminClientDeal'=>array(
						'className'=>'AdminClientDeal',
						'foreignKey'=>'deal_id',
						'fields'=>array(
							'title', 'description', 'price', 'image', 'type', 'product'
						)
					),
					'User'=>array(
						'className'=>'User',
						'foreignKey'=>'user_id',
						'fields'=>array(
							'first_name', 'last_name', 'email', 'fb_id', 'fb_access_token', 'fb_friends', 'tw_id', 'tw_screen_name', 'tw_oauth_token',
							'tw_oauth_token_secret', 'tw_friends', 'image'
						)
					)
				)
			)
		);
				
		$share_pending_deals = $this->AdminClientDealShare->find('all', 
											array(
												'conditions'=>array(
													'AdminClientDealShare.status'=>'PENDING'
												)												
											)
										);
		//pr($share_pending_deals);die;
		if(!empty($share_pending_deals))
		{
			App::uses('FB', 'Facebook.Lib');
			$Facebook = new FB();
			App::import('Vendor', 'twitter/tmhOAuth');
			$StatusMessage = new StatusMessage();
		
			foreach($share_pending_deals as $share)
			{
				$get_loggedIn_user['User'] = $share['User'];	
				
				$deal['AdminClientDeal'] = $share['AdminClientDeal'];
				$deal['Admin'] = $share['Admin'];	
				
				if(!empty($deal))
				{	
					$fb_message = $StatusMessage->fb_message($deal['Admin'], $deal);
					$tw_message = $StatusMessage->tw_message($deal['Admin'], $deal);
					$fb_fanpage_message = $StatusMessage->fb_fanpage_message($share['User'], $deal['Admin'], $deal);
					
					//$img = realpath('./img/deal/'.$deal['AdminClientDeal']['image']);
					 $img = dirname(dirname(__FILE__)).DS.'webroot'.DS.'img'.DS.'deal'.DS.$deal['AdminClientDeal']['image'];
					if($share['AdminClientDealShare']['share_type'] == 'facebook')
					{	
						$Facebook->setAccessToken($get_loggedIn_user['User']['fb_access_token']);
						$album_name = $deal['Admin']['company'].'_'.$deal['AdminClientDeal']['title'];							
						$album_details = array('message'=> 'Powered by https://eyesocialeyes.com/','name'=> $album_name);
						$album = $Facebook->api('/'.$get_loggedIn_user['User']['fb_id'].'/albums', 'post', $album_details);
						$album_id = $album['id'];
						
						$msg_body = array(
							'source'=>'@' . $img,
							'message' => $fb_message ,
							'aid' => $album_id,
						);	
						
						$check = $Facebook->api('/'.$album_id.'/photos', 'POST', $msg_body );
						//pr($check);die;
						if($check)
						{	
							$dealShare['AdminClientDealShare']['id'] = $share['AdminClientDealShare']['id'];							
							$dealShare['AdminClientDealShare']['status'] = 'posted';
							$this->AdminClientDealShare->save($dealShare);
																			
							if(!empty($deal['Admin']['fb_fanpage_id']))
							{
								$this->facebook_fanpage_share($deal, $get_loggedIn_user, $fb_fanpage_message);
							}
							// Send coupon Email to user
							$this->coupon_email($img, $deal, $get_loggedIn_user['User']);									
						}
					}
					else if($share['AdminClientDealShare']['share_type'] == 'twitter')
					{	
						$tmhOAuth = new tmhOAuth(array(
							  'consumer_key' => LoginAPI::TWITTER_CONSUMER_KEY,
							  'consumer_secret' => LoginAPI::TWITTER_CONSUMER_SECRET,
							  'token' => $get_loggedIn_user['User']['tw_oauth_token'],
							  'secret' => $get_loggedIn_user['User']['tw_oauth_token_secret']		  
							)
						);								
						// Remove characters from message as twiiter has the limit for characters
						$msg = substr($tw_message, 0, 110);				
						$params = array(
									'media[]' => '@'.$img,
									'status'  => $msg,
									
								  );
						
						$code = $tmhOAuth->user_request(array(
															'method' => 'POST',
															'url' => $tmhOAuth->url("1.1/statuses/update_with_media"),
															'params' => $params,
															'multipart' => true	
														)
													);
					
						if($code != 403)
						{	
							$dealShare['AdminClientDealShare']['id'] = $share['AdminClientDealShare']['id'];							
							$dealShare['AdminClientDealShare']['status'] = 'posted';
							$this->AdminClientDealShare->save($dealShare);
									
							if(!empty($deal['Admin']['fb_fanpage_id']))
							{	
								$this->facebook_fanpage_share($deal, $get_loggedIn_user, $fb_fanpage_message);							
							}	
							// Send coupon Email to user
							$this->coupon_email($img, $deal, $get_loggedIn_user['User']);
						}		  
					} 
				}
			}
		}
		exit();
	}
	
	/**
	 * Will be used as google callback isntead of domain one 
	 */
	function google_callback()
	{		
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
}
