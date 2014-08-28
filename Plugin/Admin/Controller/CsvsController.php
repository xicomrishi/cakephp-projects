<?php
/**
 * Name : Csvs Controller
 * Created : 30 May 2014
 * Purpose : Csv controller for imports/exports
 * Author : Gaganjot Singh
 */
class CsvsController extends AdminAppController
{
	var $uses = null;
	var $model = null;

	var $emailField = 'email';
	var $firstNameField = 'first_name';
	var $lastNameField = 'last_name';

	public function beforeFilter()
	{
		//Set auth model Admin
		parent::beforeFilter();
		//Dunno wat the hell is this, just copied
		//Not needed IMO
		$this->Auth->authenticate = array(
			'Form' => array('userModel' => 'Admin')
		);
		//$this->Auth->allow('login','hash_password','forget_password');

	}

	/**
	 * Name : import Action, imports csv data
	 */
	public function import()
	{
		App::import('Vendor', 'Admin.parsecsv.lib');
		
		if ( $this->Session->check('imported_csv_contacts') )
		{
			$this->set('imported_contacts', $this->Session->read('imported_csv_contacts'));
			$this->Session->delete('imported_csv_contacts');
		} 
		
		if ($this->request->is('post')) {

			if(!$this->request->data['Csv']['file_name']['error'] || $this->request->data['Csv']['file_name']['type'] != 'text/csv') {
				$fName = $this->request->data['Csv']['file_name']['tmp_name'];

				$csv = new parseCSV();
				//$csv->offset = 2;
				$csv->delimiter = ",";
				$csv->parse($fName);
				//$emails = Hash::combine($csv->data, "{n}.$this->emailField", '{n}');

				$this->loadModel('User');
				$this->loadModel('ImportedUser');
				$oldUsers = array();
				//$oldUsers = $this->User->find('list', array('fields' => array('email', 'id'),'conditions' => array('User.email != ' => '')));
				$oldUsers2 = $this->ImportedUser->find('list', array('conditions' => array('ImportedUser.client_id' => $this->Auth->user('id')),'fields' => array('email', 'id')));
				$oldUsers = Hash::merge($oldUsers, $oldUsers2);
				
				//this array keeps a useremail duplicacy from occurring
				$collection = array();
				$saveData = array('ImportedUser' => array());
				foreach($csv->data as $dKey => $datum) {
					if(!isset($oldUsers[trim($datum[$this->emailField])]) //if email isn't previously present in the db
						&& !in_array($datum[$this->emailField], $collection) //if email isn't repeated in the csv
						&& !empty($datum[$this->emailField])) { //if email field isn't empty in the csv
						//append to save data
						$saveData['ImportedUser'][$dKey] = array(
														'type' => 'csv',
														'client_id' => $this->Auth->user('id'),
														$this->firstNameField => $datum[$this->firstNameField],
														$this->lastNameField => $datum[$this->lastNameField],
														$this->emailField => trim($datum[$this->emailField]),
													);
						$collection[] = $datum[$this->emailField];
					}
				}

				$count_contacts = count($collection);					

				if(empty($saveData['ImportedUser']) || $this->ImportedUser->saveAll($saveData['ImportedUser'], array())) {
					
					$this->Session->write('imported_csv_contacts', $saveData['ImportedUser']);
				
					
					if($count_contacts > 0)
						$this->flash_new( __($count_contacts.' Csv contacts imported successfully.'), 'success-messages' );
					else
						$this->flash_new( __('No Csv contacts imported because either email are invalid or already exists.'), 'error-messages' );
					$this->redirect(array('action'=>'import'));
				} else {
					$this->flash_new( __('Csv import could not be completed, please try again.'), 'error-messages' );
					$this->redirect(array('action'=>'import'));
				}
			} else {
				$this->flash_new( __('There was some error while uploading the document. Please try again.'), 'error-messages' );
				$this->redirect(array('action'=>'import'));
			}
		}
	}

	public function import_yahoo($return = null) {
		if(isset($return)) {
			
			if ( $this->Session->check('imported_yahoo_contacts') )
			{
				$this->set('imported_contacts', $this->Session->read('imported_yahoo_contacts'));
				$this->Session->delete('imported_yahoo_contacts');
			} 	
				
			//return;
		}
		// App::import('Vendor', 'Admin/yahoo_api');
		// App::import('Vendor', 'Admin/yahoo_api');
		// require_once('Admin/yahoo_api/globals.php');
		require_once(APP . 'Plugin' . DS . 'Admin' . DS . 'Vendor' . DS . 'yahoo_api' . DS . 'globals.php');
		require_once(APP . 'Plugin' . DS . 'Admin' . DS . 'Vendor' . DS . 'yahoo_api' . DS . 'oauth_helper.php');

		$callback = YAHOO_CALLBACK_URL;
		// Get the request token using HTTP GET and HMAC-SHA1 signature
		$retarr = get_request_token(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $callback, false, true, true);
		
		if (! empty($retarr)){
			list($info, $headers, $body, $body_parsed) = $retarr;
			if ($info['http_code'] == 200 && !empty($body)) {
				$_SESSION['request_token']= $body_parsed['oauth_token'];
				$_SESSION['request_token_secret']= $body_parsed['oauth_token_secret'];
				$_SESSION['oauth_verifier'] = $body_parsed['oauth_token'];
				$this->set('return', true);
				$this->set('url', urldecode($body_parsed['xoauth_request_auth_url']));
			} else {
				$this->set('return', false);
				$this->flash_new( __('Contacts import could not be completed, please try again.'), 'error-messages' );
			}
		} else {
			$this->set('return', false);
			$this->flash_new( __('Contacts import could not be completed, please try again.'), 'error-messages' );
		}
	}

	public function import_yahoo_callback() {
		require_once(APP . 'Plugin' . DS . 'Admin' . DS . 'Vendor' . DS . 'yahoo_api' . DS . 'globals.php');
		require_once(APP . 'Plugin' . DS . 'Admin' . DS . 'Vendor' . DS . 'yahoo_api' . DS . 'oauth_helper.php');
		// Fill in the next 3 variables.
		$request_token = $_SESSION['request_token'];
		$request_token_secret = $_SESSION['request_token_secret'];
		$oauth_verifier = $_GET['oauth_verifier'];
		// Get the access token using HTTP GET and HMAC-SHA1 signature
		$retarr = get_access_token_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $request_token, $request_token_secret, $oauth_verifier, false, true, true);

		if (! empty($retarr)) {
			list($info, $headers, $body, $body_parsed) = $retarr;
			if ($info['http_code'] == 200 && !empty($body)) {
				// Fill in the next 3 variables.
				$guid = $body_parsed['xoauth_yahoo_guid'];
				$access_token = rfc3986_decode($body_parsed['oauth_token']) ;
				$access_token_secret = $body_parsed['oauth_token_secret'];

				// Call Contact API
				$retarrs = callcontact_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $guid, $access_token, $access_token_secret, false, true);
				//AFTER YAHOO API HAS RETURNED THE DATA

				$this->loadModel('User');
				$this->loadModel('ImportedUser');
				$oldUsers = array();
				//$oldUsers = $this->User->find('list', array('fields' => array('email', 'id')));
				$oldUsers2 = $this->ImportedUser->find('list', array('conditions' => array('ImportedUser.client_id' => $this->Auth->user('id')),'fields' => array('email', 'id')));
				$oldUsers = array_merge($oldUsers, $oldUsers2);

				//this array keeps a useremail duplicacy from occurring
				$collection = $all_collection = array();
				$count_exist = 0;
				$saveData = array('ImportedUser' => array());
				
				foreach($retarrs['contacts']['contact'] as $cKey => $contact) {
					$fields = $contact['fields'];

					if(isset($fields[0])) { //if 0 key is set
						if($fields[0]['type'] == 'email') { //if 0 key has email
							$email = trim($fields[0]['value']);

							$firstName = 'User';
							$lastName = '';
							if(isset($fields[1])) { //if 1 key is set
								if($fields[1]['type'] == 'name') { //if 1 key has name
									if(is_array($fields[1]['value'])) {
										$firstName = $fields[1]['value']['givenName'];
										$lastName = $fields[1]['value']['familyName'];
									}
								}
							}

							if(isset($fields[2])) { //if 2 key is set
								if($fields[2]['type'] == 'name') { //if 1 key has name
									if(is_array($fields[2]['value'])) {
										$firstName = $fields[2]['value']['givenName'];
										$lastName = $fields[2]['value']['familyName'];
									}
								}
							}
						} else {
							if(isset($fields[1])) {
								if($fields[1]['type'] == 'email') {
									$email = trim($fields[1]['value']);

									$firstName = 'User';
									$lastName = '';

									if($fields[0]['type'] == 'nickname') { //if 1 key has name
										$firstName = $fields[0]['value'];
									}
								}
							}
						}
						
						
						
						if(isset($email) && !empty($email)) {
														
							if(!isset($oldUsers[trim($email)]) //if email isn't previously present in the db
								&& !in_array($email, $collection)) { //if email isn't repeated in the list
									//append to save data
									$saveData['ImportedUser'][$cKey] = array(
																	'type' => 'yahoo',
																	'first_name' => $firstName,
																	'last_name' => $lastName,
																	'email' => $email,
																	'client_id' => $this->Auth->user('id'),
																);
									$collection[] = $email;
								}else{
									$count_exist++;
								}
							
						}
					}
				}
				
				$count_contacts = count($collection);
				
				
					
				if(empty($saveData['ImportedUser']) || $this->ImportedUser->saveAll($saveData['ImportedUser'], array())) {
					
					$this->Session->write('imported_yahoo_contacts', $saveData['ImportedUser']);
					
					$not_imported_msg = '';
					
					if ( $count_exist > 0)
						$not_imported_msg = $count_exist.' contacts was not imported beacause their email already exist in system.';
					
					$this->flash_new( __($count_contacts.' Contacts imported successfully. '.$not_imported_msg), 'success-messages' );
					$this->redirect(array('action'=>'import_yahoo', 1));
				} else {
					$this->flash_new( __('Contacts import could not be completed, please try again.'), 'error-messages' );
					$this->redirect(array('action'=>'import_yahoo', 1));
				}
			} else {
				$this->flash_new( __('Contacts import could not be completed, please try again.'), 'error-messages' );
				$this->redirect(array('action'=>'import_yahoo', 1));
			}
		}
	}

	public function import_google($return = null) {
		if(isset($return)) {
			
			if ( $this->Session->check('imported_gmail_contacts') )
			{
				$this->set('imported_contacts', $this->Session->read('imported_gmail_contacts'));
				$this->Session->delete('imported_gmail_contacts');
			} 
			
			//return;
		}
		require_once(APP . 'Plugin' . DS . 'Admin' . DS . 'Vendor' . DS . 'google-api-php-client' . DS . 'src' . DS . 'Google_Client.php');

		$client = new Google_Client();
		$client->setApplicationName('Google Contacts PHP Sample');
		$client->setScopes("http://www.google.com/m8/feeds/");
		// Documentation: http://code.google.com/apis/gdata/docs/2.0/basics.html
		// Visit https://code.google.com/apis/console?api=contacts to generate your
		// oauth2_client_id, oauth2_client_secret, and register your oauth2_redirect_uri.

		$client->setClientId(OAUTH_client_id);
		$client->setClientSecret(OAUTH_client_secret);
		$client->setRedirectUri(OAUTH_redirect_uri);
		$client->setDeveloperKey(OAUTH_developer_key);

		if (isset($_GET['code'])) {
			$client->authenticate();
		}

		if ($client->getAccessToken()) {

			//AFTER GOOGLE RETURNS
			$req = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/default/full/?max-results=10000&alt=json");
			$val = $client->getIo()->authenticatedRequest($req);
			$json = json_decode($val->getResponseBody(), 1);
			
			$this->loadModel('User');
			$this->loadModel('ImportedUser');
			$oldUsers = array();
			//$oldUsers = $this->User->find('list', array('fields' => array('email', 'id')));
			$oldUsers2 = $this->ImportedUser->find('list', array('conditions' => array('ImportedUser.client_id' => $this->Auth->user('id')),'fields' => array('email', 'id')));
			$oldUsers = array_merge($oldUsers, $oldUsers2);

			//this array keeps a useremail duplicacy from occurring
			$collection = array(); $count_exist = 0;
			$saveData = array('ImportedUser' => array());

			foreach($json['feed']['entry'] as $cKey => $contact) {
				$firstName = !empty($contact['title']['$t']) ? $contact['title']['$t'] : 'User';
				$lastName = '';
				$email = trim($contact['gd$email'][0]['address']);

				if(isset($email) && !empty($email)) {
					if(!isset($oldUsers[trim($email)]) //if email isn't previously present in the db
						&& !in_array($email, $collection)) { //if email isn't repeated in the list
						//append to save data
						$saveData['ImportedUser'][$cKey] = array(
														'type' => 'google',
														'first_name' => $firstName,
														'last_name' => $lastName,
														'email' => $email,
														'client_id' => $this->Auth->user('id'),
													);
						$collection[] = $email;
					}else{
						$count_exist++;
					}
				}
			}
			
			$count_contacts = count($collection);
			
			if(empty($saveData['ImportedUser']) || $this->ImportedUser->saveAll($saveData['ImportedUser'], array())) {
				
				$this->Session->write('imported_gmail_contacts', $saveData['ImportedUser']);
				
				$not_imported_msg = '';
					
					if ( $count_exist > 0)
						$not_imported_msg = $count_exist.' contacts was not imported beacause their email already exist in system.';
				
				$this->flash_new( __($count_contacts.' Contacts imported successfully. '.$not_imported_msg), 'success-messages' );
				$this->redirect(array('action'=>'import_google', 1));
			} else {
				$this->flash_new( __('Contacts import could not be completed, please try again.'), 'error-messages' );
				$this->redirect(array('action'=>'import_google', 1));
			}

		} else {
			$auth = $client->createAuthUrl();
		}

		if (isset($auth)) {
			
			
			$this->set('return', true);
			$this->set('url', $auth);
		}
	}
	
	/**
	 * Name : user_groups
	 * Created : 25 July 2014	 
	 * Author : Vivek Sharma
	 * Purpose: group imported users
	 */ 
	 public function users_group()
	 {
	 	$this->loadModel('ImportedUser');
	 	$users = $this->ImportedUser->find('all', array('conditions' => array('ImportedUser.client_id' => $this->Auth->user('id'))));
		
		
		$groups = array();
		$default = array();
		
		foreach($users as $us)
		{
			if ( !in_array($us['ImportedUser']['group'],$groups) )
				$groups[] = $us['ImportedUser']['group'];
			
			if ( empty($us['Imported']['group']) )
			{
				$default[] = $us; 
			}
				
		}
		
		$this->set('default', $default);
		$this->set('groups', $groups);
		$this->render('users_group');
	 }

	public function get_imported_users_list()
	{
		$this->layout = 'ajax';
		$this->loadModel('AdminClientDealShare');
		
		$this->AdminClientDealShare->bindModel(array(
					'belongsTo'=>array(
						'User'=>array(
							'className'=>'User',
							'foreignKey'=>'user_id',
							'type'=>'INNER'
						)
					)
				),false
			);
		$conditions = array('AdminClientDealShare.client_id'=>$this->Auth->user('id'));

		$data = $this->AdminClientDealShare->find('all', array(
												'conditions' => $conditions,
												'group'=>'user_id',
												'fields'=>array('User.id', 'User.email')
											)
								);
		
		$this->loadModel('ImportedUser');						
		$imported_user_data = $this->ImportedUser->find('all', array(
																'conditions' => array('ImportedUser.client_id' => $this->Auth->user('id')),
																'group' => 'email',
																'fields' => array('ImportedUser.id','ImportedUser.email')					
															)		
														);
				
	 $imported_emails = array();

		
		
		foreach($imported_user_data as $imp)
		{
			$imported_emails[$imp['ImportedUser']['id']] = $imp['ImportedUser']['email'];
		}
		
		
		$this->set(compact('imported_emails'));
		$this->render('imported_users_list');
	}
	 
	
}
?>
