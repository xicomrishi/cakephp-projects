 <?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow( 'auth_yahoo', 'yahoo_callback', 'cron_feedback_email', 'test', 'yah_callback', 'yah_auth','cron_schedule_email', 'cron_test', 'redirecting');
	}	
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
	
	public function auth_yahoo($type = null)
	{	
		//require_once '../Vendor/yahooauth/lib/Yahoo/YahooOAuthApplication.class.php';
		
		App::import('Vendor', 'yahooauth/Yahoo');		
		$url =  YahooSession::createAuthorizationUrl(LoginAPI::YAHOO_CONSUMER_KEY, LoginAPI::YAHOO_CONSUMER_SECRET, LoginAPI::YAHOO_APP_CALLBACK_URL);
		
		$this->redirect($url);
	}
	
	function yahoo_callback()
	{
		App::import('Vendor', 'yahooauth/Yahoo');
		
		$session = YahooSession::requireSession(LoginAPI::YAHOO_CONSUMER_KEY, LoginAPI::YAHOO_CONSUMER_SECRET, LoginAPI::YAHOO_APP_ID);
		
		if ( $session )
		{
			$user = $session->getSessionedUser();  
			$profile = $user->getProfile();
			//echo '<pre>';print_r($profile); die;
			$primary_email = '';
			foreach ($profile->emails as $email)
			{
				if ( isset($email->primary) && $email->primary == 1)
				{
					$primary_email = $email->handle;
				}
			}			
					
			//Email id exists or not
			if( !empty($primary_email))
			{
				$this->loadModel('User');
				$exists_user = $this->User->findByEmail($primary_email);
				
				$application_type = $this->Session->read('ApplicationType');
				$deal_id = $this->Session->read('DealId');
				
				if ( $this->Auth->user('id') )
				{				
					$this->User->id = $this->Auth->user('id');
					$this->User->saveField('yahoo_id', $profile->guid);
					
					$this->Session->write('LoginType', 'yahoo');	
					
					$this->redirect( array( 'controller' => 'websites', 'action' => 'profile' ) );
				}
				else
				{
					$image = '';
					
					$data = array(
								'first_name'=> $profile->nickname,
								'last_name' => '',
								'username'  => $profile->nickname,
								'email' => $primary_email,
								'yahoo_id' => $profile->guid,
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
						$data['password'] 		= 	$this->Auth->password( $profile->nickname.$profile->guid );						
				
		echo __FILE__;
		die;		$data['status'] 		= 	UserDeinedStatus::Active ;						
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
						$this->Session->write('LoginType', 'yahoo');	
							
						$this->redirect( array( 'controller' => 'websites', 'action' => 'profile' ) );
					}
					else
					{
						// Redirect
						$this->flash_new( __('Unable Login with yahoo. Please try again'), 'error-messages' );		
						$this->redirect(array('controller'=>'domain', 'action'=>'check_auth'));						
					}
				}								
			}
			else
			{						
				// Redirect	
				$this->flash_new( __('Request can not be completed'), 'error-messages' );			
				$this->redirect(array('controller'=>'domain', 'action'=>'check_auth'));
			}			
		}
	}

	function cron_feedback_email()
	{
		set_time_limit(0);
		$this->loadModel('Admin');
		$this->Admin->bindModel(array(
				'hasMany'=>array(
					'AdminClientDealShare'=>array(
						'className'=>'AdminClientDealShare',
						'foreignKey'=>'client_id',
						'conditions'=>array('AdminClientDealShare.status'=>'posted', 'AdminClientDealShare.feedback_email'=>0),
						'fields'=>array('id', 'user_id', 'deal_id', 'created')
					)
				)				
			)
		);
		$this->loadModel('AdminClientDealShare');
		$this->AdminClientDealShare->bindModel(array(				
				'belongsTo'=>array(
					'User'=>array(
						'className'=>'User',
						'foreignKey'=>'user_id',
						'fields'=>array('first_name', 'last_name', 'email')
					),
					'AdminClientDeal'=>array(
						'className'=>'AdminClientDeal',
						'foreignKey'=>'deal_id',
						'fields'=>array('title')
					)
				)
			)
		);
		$clients = $this->Admin->find('all', array(
												'conditions'=>array('Admin.feedback_email'=>'yes'),
												'fields'=>array('id', 'first_name', 'last_name'),
												'recursive'=>'2'
											)
									);								
		//pr($clients);die;
		if(!empty($clients))
		{
			foreach($clients as $client)
			{
				$this->loadModel('AdminClientFeedbackEmail');
				$email_template = $this->AdminClientFeedbackEmail->findByClientId($client['Admin']['id']);
				if(!empty($client['AdminClientDealShare']))
				{
					foreach($client['AdminClientDealShare'] as $deal)
					{						
						$check_date = date('Y-m-d', strtotime($deal['created']. '+ '.$email_template['AdminClientFeedbackEmail']['days'].' days'));
						$current_date = date('Y-m-d'); 
						if(!empty($deal['User']['email']) && filter_var($deal['User']['email'], FILTER_VALIDATE_EMAIL) && $check_date < $current_date)
						{
							$from_email  = $email_template['AdminClientFeedbackEmail']['from_email'];
		
							$from_name  =  $email_template['AdminClientFeedbackEmail']['from_name'];
							
							$subject = str_replace('{deal_title}', $deal['AdminClientDeal']['title'], $email_template['AdminClientFeedbackEmail']['subject']);
							
							$msg = $email_template['AdminClientFeedbackEmail']['content'];
							$token = array('{first_name}','{last_name}','{deal_title}' );
							$token_value = array(
													$deal['User']['first_name'],
													$deal['User']['last_name'],
													$deal['AdminClientDeal']['title'],													
												);
							$msg = str_replace($token, $token_value, $msg);
							$email = new CakeEmail('smtp'); 
							$email->from(array($from_email=>$from_name));
							if(isset($email_template['AdminClientMarketingEmail']['reply_to']) && !empty($email_template['AdminClientMarketingEmail']['reply_to']))
							{
								$email->replyTo($email_template['AdminClientMarketingEmail']['reply_to']);
							}
							$email->to($deal['User']['email']);
							$email->subject($subject);
							$email->emailFormat('html');
							//pr($email);die;
							if ($email->send($msg)) {
								$this->AdminClientDealShare->query("Update admin_client_deal_shares set feedback_email=1 where admin_client_deal_shares.id={$deal['id']}");
							} else {
								return  $this->Email->smtpError;
							}
						}
					}
				}
			}
		}	
		exit();
	}
	
	
	function test()
	{
		
		$url = 'https://api.sendgrid.com/';
		$user = 'eyesocialeyes';
		$pass = 'xicom123';

		$params = array(
			'api_user'  => $user,
			'api_key'   => $pass,
			'to'        => 'deepak.sharma@xicom.biz',
			'subject'   => 'testing from curl',
			'html'      => 'testing body',
			'text'      => 'testing body',
			'from'      => 'example@sendgrid.com',
		  );


		$request =  $url.'api/mail.send.json';

		// Generate curl request
		$session = curl_init($request);
		// Tell curl to use HTTP POST
		curl_setopt ($session, CURLOPT_POST, true);
		// Tell curl that this is the body of the POST
		curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
		// Tell curl not to return headers, but do return the response
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		// obtain response
		$response = curl_exec($session);
		curl_close($session);

		// print everything out
		print_r($response);die;

	}
	
	/**
	 * Purpose : FOR CALLBACK USING YAHOO
	 * Input : 
	 * Created on : 8 April, 2014
	 * Author : Abhishek Agrawal
	*/
	public function yah_callback()
	{
		App::import('Vendor', 'Yahoo/lib/OAuth/OAuth');	

		App::import('Vendor', 'Yahoo/lib/Yahoo/YahooOAuthApplication');	
	
		$oauthapp = new YahooOAuthApplication(LoginApi::YAHOO_CONSUMER_KEY, LoginApi::YAHOO_CONSUMER_SECRET, LoginApi::YAHOO_APP_ID, LoginApi::YAHOO_APP_CALLBACK_URL);
		
			if($this->request->query('openid_oauth_request_token') == null)
			{
				// Redirect
				$this->flash_new( __('Unable to Login with yahoo. Please try again'), 'error-messages' );		
				$this->redirect(array('controller'=>'domain', 'action'=>'check_auth'));						
			}
			
			$request_token = new YahooOAuthRequestToken($this->request->query('openid_oauth_request_token'), '');

			$this->Session->write('yahoo_oauth_request_token', $request_token->to_string());
			
			// exchange request token for access token
			$oauthapp->token = $oauthapp->getAccessToken($request_token);
			// store access token for later
			$this->Session->write('yahoo_oauth_access_token', $oauthapp->token->to_string());
		
	
		if( $this->Session->check('yahoo_oauth_access_token') )
		{
			// restore access token from session
	//	$oauthapp->token = YahooOAuthAccessToken::from_string($this->Session->read('yahoo_oauth_access_token'));
			
			// fetch latest user data
			$profile  = $oauthapp->getProfile();
			
				$primary_email = '';
			
			
			if ( isset($profile->profile->emails->handle) )
			{
				$primary_email = $profile->profile->emails->handle;
			}else{
				foreach ($profile->profile->emails as $email)
				{	
					if ( isset($email->primary) && $email->primary == 1)
					{
						$primary_email = $email->handle;
						break;
					} else if ( isset($email->handle) )
					{
						
						$primary_email = $email->handle;
					}
				}	
			}
			
				
			
			//Email id exists or not
			if( !empty($primary_email))
			{
				$this->loadModel('User');
				$exists_user = $this->User->findByEmail($primary_email);
				
				if ( $this->Auth->user('id') )
				{
					$this->User->id = $this->Auth->user('id');
					$this->User->saveField('yahoo_id', $profile->profile->guid);
					
					$this->Session->write('LoginType', 'yahoo');	
					
					$this->redirect( array( 'controller' => 'websites', 'action' => 'profile' ) );
				}
				else
				{
					$image = '';
					
					$data = array(
								'first_name'=> $profile->profile->nickname,
								'last_name' => '',
								'username'  => $profile->profile->nickname,
								'email' => $primary_email,
								'yahoo_id' => $profile->profile->guid,
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
						$data['password'] 		= 	$this->Auth->password( $profile->profile->nickname.$profile->profile->guid );						
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
						$this->Session->write('LoginType', 'yahoo');	
							
						$this->redirect( array( 'controller' => 'websites', 'action' => 'profile' ) );
					}
					else
					{
						// Redirect
						$this->flash_new( __('Unable Login with yahoo. Please try again'), 'error-messages' );		
						$this->redirect(array('controller'=>'domain', 'action'=>'check_auth'));						
					}
				}								
			}
			else
			{				
				// Redirect	
				$this->flash_new( __('Request can not be completed'), 'error-messages' );			
				$this->redirect(array('controller'=>'domain', 'action'=>'check_auth'));
			}		
			
		}
		else
		{				
			// Redirect	
			$this->flash_new( __('Please login to access this area'), 'error-messages' );			
			$this->redirect(array('controller'=>'domain', 'action'=>'check_auth'));
		}	
	}
	
	/**
	 * Purpose : FOR USER AUTH USING YAHOO
	 * Input : 
	 * Created on : 8 April, 2014
	 * Author : Abhishek Agrawal
	*/
	public function yah_auth()
	{
		
		App::import('Vendor', 'Yahoo/lib/OAuth/OAuth');	
		App::import('Vendor', 'Yahoo/lib/Yahoo/YahooOAuthApplication');		
		//$url =  YahooSession::createAuthorizationUrl(LoginAPI::YAHOO_CONSUMER_KEY, LoginAPI::YAHOO_CONSUMER_SECRET, LoginAPI::YAHOO_APP_CALLBACK_URL);
		
		$oauthapp = new YahooOAuthApplication(LoginApi::YAHOO_CONSUMER_KEY, LoginApi::YAHOO_CONSUMER_SECRET, LoginApi::YAHOO_APP_ID, LoginApi::YAHOO_APP_CALLBACK_URL);
		$url = $oauthapp->getOpenIDUrl($oauthapp->callback_url);
		$this->redirect($url);
	}
	
	
	/**
	 * Purpose: Scheduled mail cron - 1Hour
	 * Modified By: Vivek Sharma
	 * Modified On: 5 June 2014
	 * Comment: modified to add users imported from csv,gmail,yahoo 
	 */
	public function cron_schedule_email()
	{
		set_time_limit(0);
		$this->loadModel('AdminClientMarketingEmailUser');
		$this->loadModel('AdminClientMarketingEmail');
		
		$this->AdminClientMarketingEmailUser->bindModel(array('belongsTo'=>array('User'=>array(
																					'fields'=>array('id','email', 'first_name', 'last_name')
																					),
																				'ImportedUser'=>array(
																					'className'=>'ImportedUser',
																					'foreignKey'=>'imported_user_id',
																					'fields'=>array('id','email', 'first_name', 'last_name')
																				)
																			)
															),false);
															
		$this->AdminClientMarketingEmail->bindModel(array('hasMany'=>array('AdminClientMarketingEmailUser'=>array(
							'conditions'=>array('status != ' =>'sent')
						)
						)),false);
		
						
		$conditions = array('AdminClientMarketingEmail.schedule_date != '=>'','AdminClientMarketingEmail.type'=>'schedule','AdminClientMarketingEmail.schedule_date <= '=>date('Y-m-d'),'AdminClientMarketingEmail.schedule_time <= '.intval(date('h')), 'AdminClientMarketingEmail.schedule_time_type'=>date('A'));
		
		$email_schedules = $this->AdminClientMarketingEmail->find('all',array('conditions'=>$conditions,'recursive'=>2));
		
			
		//echo date('Y-m-d');
		//new DateTime (date('Y-m-d'))
	/*	$log = $this->AdminClientMarketingEmail->getDataSource()->getLog(false, false);
		debug($log);
		pr($conditions); pr($email_schedules); die;*/
		if(!empty($email_schedules))
		{
			
			foreach($email_schedules as $email_send)
			{
				$from_email = $email_send['AdminClientMarketingEmail']['from_email'];
				$from_name = $email_send['AdminClientMarketingEmail']['from_name'];
				$subject = $email_send['AdminClientMarketingEmail']['subject'];
				if(!empty($email_send['AdminClientMarketingEmailUser']))
				{
					
					foreach($email_send['AdminClientMarketingEmailUser'] as $email_user)
					{
						
						$user_info = array();
						
						if(!empty($email_user['user_id']))
						{
							$user_info = $email_user['User'];
						}else{
							$user_info = $email_user['ImportedUser'];
						}
						
						$unique_code = String::uuid().'-'.time();
						
						try
						{
							$email = new CakeEmail('smtp'); 
							$email->from(array($from_email=>$from_name));
							if(isset($email_send['AdminClientMarketingEmail']['reply_to']) && !empty($email_send['AdminClientMarketingEmail']['reply_to']))
							{
								$email->replyTo($email_send['AdminClientMarketingEmail']['reply_to']);
							}
							$email->to($email_user['user_email']);
							$email->subject($subject);
							$email->emailFormat('html');
							
							$msg = $email_send['AdminClientMarketingEmail']['content'];
							$token = array('{user_first_name}','{user_last_name}' );
							$token_value = array(
													$user_info['first_name'],
													$user_info['last_name'],																								
												);
							if(isset($email_send['AdminClientMarketingEmail']['attachment']) && file_exists(EMAILATTACHMENT.$email_send['AdminClientMarketingEmail']['attachment']))
							{
								$attachment = $email_send['AdminClientMarketingEmail']['attachment'];
								$attachment_new = APP.WEBROOT_DIR.DS.'files'.DS.'email_attachment'.DS.$attachment;
								
								$path_parts = pathinfo($attachment_new);
								$email->attachments(array(
									$path_parts['basename'] =>  $attachment_new,
									
								));
							}
							$msg = str_replace($token, $token_value, $msg);
							
							$code_array = json_encode(array('unique_args' => array('code' => $unique_code)));
							$email->addHeaders(array('X-SMTPAPI' => $code_array));
							if ($email->send($msg)) {
								$status = 'sent';
								$error = '';
							} 
							else 
							{
								$status = 'not sent';
								$error =  $this->Email->smtpError;
							}
							$status='sent';
							$error='';
						}
						catch(Exception $e)
						{
							$status = 'not sent';
							$error =  $e->getMessage();
						}
						$emailUserData['admin_client_marketing_email_id'] = $email_send['AdminClientMarketingEmail']['id'];
						
						if(!empty($email_user['user_id']))
						{
							$emailUserData['user_id'] = $email_user['User']['id'];
							$emailUserData['imported_user_id'] = '';
						
						}else{
							
							$emailUserData['user_id'] = '';
							$emailUserData['imported_user_id'] = $email_user['ImportedUser']['id'];
						}
						
						$emailUserData['user_email'] = $email_user['user_email'];						
						$emailUserData['status'] = $status;
						$emailUserData['tracking_id'] = $unique_code;
						$emailUserData['track_status'] = $status;
						$emailUserData['error_text'] = $error;
						
						
						$this->AdminClientMarketingEmailUser->create();
						$this->AdminClientMarketingEmailUser->save($emailUserData);
						
					}
				}
				
				if($email_send['AdminClientMarketingEmail']['is_repeat']!=1)
				{
					$this->AdminClientMarketingEmail->id = $email_send['AdminClientMarketingEmail']['id'];
					$this->AdminClientMarketingEmail->saveField('type','send');

				}
				else{
					
					$date = new DateTime($email_send['AdminClientMarketingEmail']['schedule_date']);
					$interval = new DateInterval('P1M');

					$date->add($interval);

					$this->AdminClientMarketingEmail->id = $email_send['AdminClientMarketingEmail']['id'];
					$this->AdminClientMarketingEmail->saveField('schedule_date', $date->format('Y-m-d'));
				}
			
			}

		}
		exit();
	}
	
	function cron_test()
	{
		$email = new CakeEmail('smtp'); 
		$email->from(array('admin@socialreferer.com'=>'social referers'));
			$email->replyTo('xyz@xicom.biz');
		$email->to("abhishek@xicom.biz");
		$email->subject('Subject');
		$email->emailFormat('html');
		$email->send('<br>HI<p></p>ABhishek</p><p>Testing Cron Mail</p>');
		die('asd');
	}
	
	function redirecting() {
		$this->redirect('http://www.eyesocialeyes.com');
	}
}
