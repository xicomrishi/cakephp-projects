<?php

/**
 * Name : Email Controller
 * Created : 8 Nov 2013
 * Purpose : Default Email controller
 * Author : Prakhar Johri
 */
class EmailsController extends AdminAppController {

	public $name = 'Emails';
	public $uses = array('Email');
	public $components = array('Admin.Uploader');
	public $paginate = array ('limit' => 30);

	public function beforeFilter()
	{
		//pr($this); die('t');
		//Set auth model Admin
		parent::beforeFilter();
		$this->Auth->authenticate = array(
			'Form' => array('userModel' => 'Admin')
		);
		$this->Auth->allow('register', 'cron_feedback_email','track_email','marketing_email_cron');
		
		ini_set("memory_limit","5G");
		ini_set("max_execution_time","0");
	}

	/**
	 * name : manage method
	 * Purpose : Manage all the Email templates
	 * author : Prakhar Johri
	 * Created : 8 Nov 2013
	 */
	public function manage()
	{

		$this->loadModel('EmailTemplate');

		$conditions = array();
		if(isset($this->request->data['option']) && !empty($this->request->data['option']))
		{
			if(!empty($this->request->data['ids']))
			{
				switch($this->request->data['option'])
				{
					case "delete":
						$this->EmailTemplate->deleteAll(array('id' => $this->request->data['ids']));
						$this->Session->setFlash(__('Selected email template deleted sucessfully'));
					break;
					case "active":
						$this->EmailTemplate->updateAll(array('status' => "'active'"), array('id' =>  $this->request->data['ids'] ));
					break;
					case "deactive":
						$this->EmailTemplate->updateAll(array('status' => "'inactive'"), array('id' =>  $this->request->data['ids'] ));
					break;
				}
			}
		}
		if($this->request->is('ajax'))
		{
			$this->layout = 'ajax';
		}

		$this->paginate = array(
				'limit' => 30,
				'order' => array('id' => 'DESC')
		);
		$templates = $this->Paginate('EmailTemplate');

		$this->set('templates',$templates);

	}

	/**
	 * name : add method
	 * Purpose : Add new email template
	 * author : Prakhar Johri
	 * Created : 8 Nov 2013
	 */
	function add($id = NULL)
	{
		$this->loadModel('Admin.EmailTemplate');

		if($this->request->data)
		{
			$data_arr = $this->request->data;
			$data_arr['EmailTemplate']['name'] = $this->data['EmailTemplate']['email_identifier'];
			if(empty($this->request->data['EmailTemplate']['id']))
			{
				$data_arr['EmailTemplate']['email_identifier'] = $this->EmailTemplate->generate_identifier($this->data['EmailTemplate']['email_identifier']);
			}

			$this->EmailTemplate->save($data_arr);

			if(!empty($this->request->data['EmailTemplate']['id']))
			{
				$this->Session->setFlash('Email Template has been updated successfully');
			}
			else
			{
				$this->Session->setFlash('Email Template save successfully');
			}
			$this->redirect('manage');
		}
		if(!empty($id))
		{
			$this->request->data = $this->EmailTemplate->findById($id);
		}
	}

	/**
	 * name : edit method
	 * Purpose :edit email template
	 * author : Prakhar Johri
	 * Created : 8 Nov 2013
	 */
	function edit($id = NULL)
	{
		$this->loadModel('EmailTemplate');
		if($this->request->data)
		{
			$data_arr = $this->request->data;
			$data_arr['EmailTemplate']['name'] = $this->data['EmailTemplate']['email_identifier'];
			unset($data_arr['EmailTemplate']['email_identifier']);
			$this->EmailTemplate->save($data_arr);

			if(!empty($this->request->data['EmailTemplate']['id']))
			{
				$this->Session->setFlash('Email Template has been updated successfully');
			}
			else
			{
				$this->Session->setFlash('Email Template save successfully');
			}
			$this->redirect('manage');

		}
		if(!empty($id))
		{
			$this->request->data = $this->EmailTemplate->findById($id);
		}
	}

	 /**
	 * name : delete method
	 * Purpose :delete email template
	 * author : Prakhar Johri
	 * Created : 8 Nov 2013
	 */
	public function delete($id = null) {

		$this->loadModel('EmailTemplate');
		$this->EmailTemplate->id = $id;
		$data = $this->EmailTemplate->findById($id);
		$email =  $data['EmailTemplate']['email_identifier'];
		$this->EmailTemplate->delete($id);

		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'manage'));
	}

	/**
	 * name : feedback_email method
	 * Purpose :edit email template
	 * author : Deepak Sharma
	 * Created : 12 March 2014
	 */
	function feedback_email($client_id = NULL)
	{
		$this->loadModel('Admin');
		$this->Admin->bindModel(array(
					'hasOne'=>array(
						'AdminClientFeedbackEmail'=>array(
							'className'=>'AdminClientFeedbackEmail',
							'foreignKey'=>'client_id'
						)
					)
				),false
			);

		if($this->request->data)
		{
			$data_arr = $this->request->data;
			//pr($data_arr);die;

			$this->Admin->saveAssociated($data_arr);

			if(!empty($this->request->data['EmailTemplate']['id']))
			{
				$this->Session->setFlash('Email Template has been updated successfully');
			}
			else
			{
				$this->Session->setFlash('Email Template save successfully');
			}
			$this->redirect(array('action'=>'emails', 'action'=>'feedback_email', $this->data['AdminClientFeedbackEmail']['client_id']));

		}
		if(!empty($client_id))
		{
			$this->request->data = $this->Admin->find('first', array(
																'conditions'=>array('Admin.id'=>$client_id),
																'fields'=>array('Admin.feedback_email','Admin.id', 'AdminClientFeedbackEmail.*')
															)
												);
		}
		//pr($this->request->data);die;
	}
	/**
	 * name : marketing_history_email method
	 * Purpose : send marketing email to user who shared the client deal
	 * author : Deepak Sharma
	 * Created : 27 March 2014
	 */
	function marketing_history_email($client_id = NULL)
	{
		//Configure::write('debug', 2);
		$this->loadModel('AdminClientMarketingEmail');

		$conditions = array('OR' =>array(array('is_repeat'=>1, 'type'=>'schedule'), 'type'=>'send'), 'client_id'=>$this->Auth->user('id'));
		if(isset($this->request->data['option']) && !empty($this->request->data['option']))
		{
			if(!empty($this->request->data['ids']))
			{
				switch($this->request->data['option'])
				{
					case "delete":
						$this->EmailTemplate->deleteAll(array('id' => $this->request->data['ids']));
						$this->Session->setFlash(__('Selected email template deleted sucessfully'));
					break;
					case "active":
						$this->EmailTemplate->updateAll(array('status' => "'active'"), array('id' =>  $this->request->data['ids'] ));
					break;
					case "deactive":
						$this->EmailTemplate->updateAll(array('status' => "'inactive'"), array('id' =>  $this->request->data['ids'] ));
					break;
				}
			}
		}
		if($this->request->is('ajax'))
		{
			$this->layout = 'ajax';
		}

		$this->paginate = array(
				'conditions'=>$conditions,
				'limit' => 30,
				'order' => array('id' => 'DESC')
		);
		$marketing_email_history = $this->Paginate('AdminClientMarketingEmail');

		$this->set(compact('marketing_email_history'));
	}
	/**
	 * name : marketing_history_email_view_users method
	 * Purpose : send marketing email to user who shared the client deal
	 * author : Deepak Sharma
	 * Created : 27 March 2014
	 */
	function marketing_history_email_view_users($marketing_email_id = NULL)
	{
		$this->loadModel('AdminClientMarketingEmailUser');

		$conditions = array("admin_client_marketing_email_id"=>$marketing_email_id);
		if(isset($this->request->data['option']) && !empty($this->request->data['option']))
		{
			if(!empty($this->request->data['ids']))
			{
				switch($this->request->data['option'])
				{
					case "delete":
						$this->EmailTemplate->deleteAll(array('id' => $this->request->data['ids']));
						$this->Session->setFlash(__('Selected email template deleted sucessfully'));
					break;
					case "active":
						$this->EmailTemplate->updateAll(array('status' => "'active'"), array('id' =>  $this->request->data['ids'] ));
					break;
					case "deactive":
						$this->EmailTemplate->updateAll(array('status' => "'inactive'"), array('id' =>  $this->request->data['ids'] ));
					break;
				}
			}
		}

		$this->paginate = array(
				'conditions'=>$conditions,
				'limit' => 30,
				'order' => array('id' => 'DESC')
		);
		$marketing_email_history_users = $this->Paginate('AdminClientMarketingEmailUser');
		//pr($marketing_email_history_users);die;
		$this->set(compact('marketing_email_history_users'));
	}
	/**
	 * name : marketing_send_email method
	 * Purpose : send marketing email to user who shared the client deal
	 * author : Deepak Sharma
	 * Created : 18 March 2014
	 * Modified By: Vivek Sharma
	 * Modified on: 5 June, 2014
	 * Comment: Added list of users which are imported through csv,gmail,yahoo
	 */
	function marketing_send_email($client_id = NULL)
	{
		$this->loadModel('AdminClientDealShare');
		
		if(!empty($this->request->data))
		{
			unset($this->request->data['checkall']);
			unset($this->request->data['checkall_imported']);
			if(
				isset($this->request->data['AdminClientMarketingEmail']['schedule_time'])
				&& (
				(($this->request->data['AdminClientMarketingEmail']['schedule_date'] == date('Y-m-d'))
				&& (date('h') >= date("h", strtotime($this->request->data['AdminClientMarketingEmail']['schedule_time'].":00 ".$this->request->data['AdminClientMarketingEmail']['schedule_time_type'])) ))
				|| $this->request->data['AdminClientMarketingEmail']['schedule_date'] < date('Y-m-d')
				)
			)
			{
				$this->Session->setFlash('Schedule time should be only future time.');
			}
			else
			{
				
				$this->loadModel('AdminClientMarketingEmail');
				$this->loadModel('AdminClientMarketingEmailUser');
				//client id is the logged in admin's if\d
				$this->request->data['AdminClientMarketingEmail']['client_id'] = $this->Auth->user('id');
				$getPostedData = $this->request->data;
				$file_error = 0;

				if(!empty($getPostedData['AdminClientMarketingEmail']['file']['name']))
				{
					//if there's an attachement

					//Upload the image
					$image_array = $this->request->data['AdminClientMarketingEmail']['file'];
					$image_info = pathinfo($image_array['name']);
					$image_new_name = substr($image_info['filename'],0,70).'_'.time().'_'.$this->Auth->user('id');
					$thumbnails = false;

					$this->Uploader->upload($image_array, EMAILATTACHMENT, $thumbnails, $image_new_name );

					if ( $this->Uploader->error )
					{
						$error = $this->Uploader->errorMessage;
						$this->Session->setFlash($error);
						$file_error++;
					}
					else
					{
						$this->request->data['AdminClientMarketingEmail']['attachment'] = $this->Uploader->filename;
						unset($this->request->data['AdminClientMarketingEmail']['file']);
						$this->Uploader->filename = '';
					}
				}
				else
				{
					//if no attachment, unset the key
					unset($this->request->data['AdminClientMarketingEmail']['file']);
				}
				if($file_error == 0)
				{
					//if no error occured above, continue

					//Save the email form data in the table
					if($adminemaillast = $this->AdminClientMarketingEmail->save($this->request->data))
					{
						//id of //save email user data but don't set status yet, which shows mail hasn't been sent yetemail data saved
						$last_inserted_id = $adminemaillast['AdminClientMarketingEmail']['id'];
						//$this->AdminClientMarketingEmail->getlastInsertId();
						
						$this->loadModel('User');
						$allusers = array(); $i = 0;
						$operator = '';
							
						if(!empty($this->request->data['AdminClientMarketingEmail']['checkboxes']))
						{
							
							$elements = json_decode($this->request->data['AdminClientMarketingEmail']['checkboxes']);
							
							$allele = array();
							foreach($elements as $ele => $v)
							{
								$allele[] = $ele;
							}
						
							if ( !empty($allele) )
							{
								if( count($allele) > 1 )
								{
									$operator = 'IN';
									
								}
								
								
								$user_info = $this->User->find('all', array(
																	'conditions' => array('User.id '.$operator.' ' => $allele),
																	'fields' => array('User.id','User.first_name','User.last_name','User.email')
																	));
																								
								foreach($user_info as $us)
								{
									$allusers[$i]['admin_client_marketing_email_id'] = $last_inserted_id;
									$allusers[$i]['id'] = $us['User']['id'];
									$allusers[$i]['imported_user_id'] = '';
									$allusers[$i]['first_name'] = $us['User']['first_name'];
									$allusers[$i]['last_name'] = $us['User']['last_name'];
									$allusers[$i]['email'] = $us['User']['email'];
									$allusers[$i]['user_type'] = 'added';		
									$i++;					
								}			
								
							}							
													
						}
						
							
						if(!empty($this->request->data['AdminClientMarketingEmail']['checkboxes_imported']))
						{
							$operator = ''; 
							$elements = json_decode($this->request->data['AdminClientMarketingEmail']['checkboxes_imported']);
							
							$allele = array();
							foreach($elements as $ele => $v)
							{
								$allele[] = $ele;
							}
						
							if ( !empty($allele) )
							{
								if( count($allele) > 1 )
								{
									$operator = 'IN';
									
								}
								
								
								$this->loadModel('ImportedUser');
								$imported_user_info = $this->ImportedUser->find('all', array(
																	'conditions' => array('ImportedUser.id '.$operator.' ' => $allele),
																	'fields' => array('ImportedUser.id','ImportedUser.first_name','ImportedUser.last_name','ImportedUser.email')
																	));
													
								foreach($imported_user_info as $ius)
								{
									$allusers[$i]['admin_client_marketing_email_id'] = $last_inserted_id;
									$allusers[$i]['id'] = '';
									$allusers[$i]['imported_user_id'] = $ius['ImportedUser']['id'];
									$allusers[$i]['first_name'] = $ius['ImportedUser']['first_name'];
									$allusers[$i]['last_name'] = $ius['ImportedUser']['last_name'];
									$allusers[$i]['email'] = $ius['ImportedUser']['email'];
									$allusers[$i]['user_type'] = 'imported';		
									$i++;					
								}
							}		
							
							
						}										
						//pr($allusers);die;
						if(empty($allusers))
						{
							$this->Session->setFlash('Email not sent. No users selected');
							$this->redirect(array('action'=>'marketing_history_email'));							
						}	
						
						
										
						//if send button is clicked, send immediately
						if($this->request->data['AdminClientMarketingEmail']['type'] == 'send')
						{
							$emailUserData = array(); $k = 0;
							
							//run loop on all the users ticked in the form
							foreach($allusers as $user)
							{
								$unique_code = String::uuid().'-'.time();
								
								$emailUserData[$k]['admin_client_marketing_email_id'] = $last_inserted_id;
								$emailUserData[$k]['user_id'] = $user['id'];
								$emailUserData[$k]['imported_user_id'] = $user['imported_user_id'];
								$emailUserData[$k]['user_email'] = $user['email'];
								$emailUserData[$k]['user_type'] = $user['user_type'];
								$emailUserData[$k]['status'] = 'Pending';
								$emailUserData[$k]['tracking_id'] = $unique_code;
								$emailUserData[$k]['track_status'] = 'Pending';
								$emailUserData[$k]['error_text'] = '';
								
								$k++;
							}
							
							$this->AdminClientMarketingEmailUser->create();								
							$this->AdminClientMarketingEmailUser->saveAll($emailUserData);
							
							/*Configure::write('debug',2);
							
							$path = "C:\Program Files (x86)\Parallels\Plesk\Additional\PleskPHP54\php.exe";
							$arg = "C:\Inetpub\vhosts\social-referrals.com\demo.social-referrals.com\app\webroot\cron_dispatecher.php /admin/emails/marketing_email_cron";
							$row = shell_exec("dir D:");
							$row = shell_exec("$path $arg");
								while(list(,$row) = each($output)){
								echo $row, "<BR>\n";
								}
								if($error){
								echo "Error : $error<BR>\n";
								//exit;
								}
							pr($row); die;*/
							
							$this->Session->setFlash('Email(s) processed to send successfully.');
							$this->redirect(array('action'=>'marketing_history_email'));
						}
						//if user didn't click send, save email for each user without setting its status yet.
						else
						{
							$emailUserData = array(); $k = 0;
							
							//run loop for each user ticked
							foreach($allusers as $usr)
							{
								
								$emailUserData[$k]['admin_client_marketing_email_id'] = $last_inserted_id;
								$emailUserData[$k]['user_id'] = $usr['id'];
								$emailUserData[$k]['imported_user_id'] = $usr['imported_user_id'];
								$emailUserData[$k]['user_email'] = $usr['email'];
								$emailUserData[$k]['user_type'] = $usr['user_type'];
								
								$k++;
							}							
							
							//save email user data but don't set status yet, which shows mail hasn't been sent yet
							$this->AdminClientMarketingEmailUser->saveAll($emailUserData);
							$this->Session->setFlash('Email saved sucessfully');

							//redirect user according to the button he clicked
							if($this->request->data['AdminClientMarketingEmail']['type'] == 'schedule')
							{
								$this->redirect(array('action'=>'marketing_schedule_email'));
							}
							else
							{
								$this->redirect(array('action'=>'marketing_draft_email'));
							}
						}

					}
				}
			}
		}

		//get all users ids who have shared a deal,
		//then get their emails from users table
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
				
		$emails = $imported_emails = array();

		foreach($data as $users)
		{
			$emails[$users['User']['id']] = $users['User']['email'];
		}
		
		foreach($imported_user_data as $imp)
		{
			$imported_emails[$imp['ImportedUser']['id']] = $imp['ImportedUser']['email'];
		}
		
		$this->set(compact('emails','imported_emails'));
	}
	
	/**
	 * name : marketing_filter_email method
	 * Purpose : filter emails of deal shared users and imported users
	 * author : Deepak Sharma
	 * Created : 28 March 2014
	 * Modified By: Vivek Sharma
	 * Modified date: 5 June 2014
	 */
	function marketing_filter_email($client_id = NULL)
	{
		$this->layout= '';
		$this->autoRender = false;
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

		$resp = '';
		$emails = $imported_emails = array();
		
		
		if(!empty($_GET) && $this->request->isAjax())
		{
			$conditions = '';
			$filters = $imported_filters = array();
			 
			if($_GET['from_date'] != '' && $_GET['to_date'] != '')
			{
				//$conditions .= 'DATE(AdminClientDealShare.created) >= "'.$_GET['from_date'].'" AND DATE(AdminClientDealShare.created) <="'.$_GET['to_date'].'"  AND';

				$filters[] = array('AdminClientDealShare.created >= ' => $_GET['from_date'].' 00:00:00');
				$filters[] = array('AdminClientDealShare.created <= ' => $_GET['to_date'].' 23:59:59');
										
				$imported_filters[] = array('ImportedUser.created >= ' => $_GET['from_date'].' 00:00:00');
				$imported_filters[] = array('ImportedUser.created <= ' => $_GET['to_date'].' 23:59:59');	

			}
			if($_GET['share_type'] != '')
			{
				//$conditions .= ' AdminClientDealShare.share_type = "'.$_GET['share_type'].'"';
				$filters[] = array('AdminClientDealShare.share_type = ' => $_GET['share_type']);
			}
		//	$conditions = rtrim($conditions, 'AND');
			$filters[] = array('AdminClientDealShare.client_id'=>$this->Auth->user('id'));
			$data = $this->AdminClientDealShare->find('all', array(
								'conditions'=>$filters,
								'group'=>'user_id',
								'fields'=>array('AdminClientDealShare.*', 'User.id', 'User.email')
							)
				);

			foreach($data as $users)
			{
				$emails[$users['User']['id']] = $users['User']['email'];
			}
			
			/**Filter data of imported users*/
						
			if($_GET['imported_share_type'] != '')
			{
			
				$imported_filters[] = array('ImportedUser.type' => $_GET['imported_share_type']);		
			}	
				
				
			$this->loadModel('ImportedUser');
			$imported_filters[] = array('ImportedUser.client_id' => $this->Auth->user('id'));						
			$imported_user_data = $this->ImportedUser->find('all', array(
															'conditions' => $imported_filters,
															'group' => 'email',
															'fields' => array('ImportedUser.id','ImportedUser.email')					
														)		
													);
			foreach($imported_user_data as $imp)
			{
				$imported_emails[$imp['ImportedUser']['id']] = $imp['ImportedUser']['email'];
			}
			
			
			$this->set(compact('imported_emails'));

		}
		$this->set(compact('emails'));
		$this->viewPath = 'Elements'.DS;
		$this->render('market_email_users_list');
	}

	/**
	 * name : marketing_schedule_email method
	 * Purpose : send marketing email to user who shared the client deal
	 * author : Deepak Sharma
	 * Created : 28 March 2014
	 */
	function marketing_schedule_email($client_id = NULL)
	{
		$this->loadModel('AdminClientMarketingEmail');

		$conditions = array('client_id'=>$this->Auth->user('id'), 'type'=>'schedule');
		if(isset($this->request->data['option']) && !empty($this->request->data['option']))
		{
			if(!empty($this->request->data['ids']))
			{
				switch($this->request->data['option'])
				{
					case "delete":
						$this->AdminClientMarketingEmail->bindModel(array(
								'hasMany'=>array(
									'AdminClientMarketingEmailUser'=>array(
										'className'=>'AdminClientMarketingEmailUser',
										'foreignKey'=>'admin_client_marketing_email_id',
										'dependent'=>true
									)
								)
							), false
						);
						$this->AdminClientMarketingEmail->deleteAll(array('id' => $this->request->data['ids']));
						$this->Session->setFlash(__('Selected email template deleted sucessfully'));
					break;
				}
			}
		}
		if($this->request->is('ajax'))
		{
			$this->layout = 'ajax';
		}

		$this->paginate = array(
				'conditions'=>$conditions,
				'limit' => 30,
				'order' => array('id' => 'DESC')
		);
		$marketing_email_history = $this->Paginate('AdminClientMarketingEmail');

		$this->set(compact('marketing_email_history'));
	}

	/**
	 * name : marketing_schedule_edit_email method
	 * Purpose : send marketing email to user who shared the client deal
	 * author : Deepak Sharma
	 * Created : 31 March 2014
	 * Modified By: Vivek Sharma
	 * Modified On: 5 June 2014
	 * Comment: modify to show and save users from imported_users table
	 */
	function marketing_schedule_edit_email($email_id = NULL)
	{
		$this->loadModel('AdminClientMarketingEmail');
		$this->loadModel('AdminClientDealShare');
		$this->loadModel('AdminClientMarketingEmailUser');
		if($this->request->data)
		{
			unset($this->request->data['checkall']);
			unset($this->request->data['checkall_imported']);
			$getPostedData = $this->request->data;
			if(!empty($getPostedData['AdminClientMarketingEmail']['file']['name']))
			{
				$image_array = $this->request->data['AdminClientMarketingEmail']['file'];
				$image_info = pathinfo($image_array['name']);
				$image_new_name = substr($image_info['filename'],0,70).'_'.time().'_'.$this->Auth->user('id');
				$thumbnails = false;

				$this->Uploader->upload($image_array, EMAILATTACHMENT, $thumbnails, $image_new_name );

				if ( $this->Uploader->error )
				{
					$error = $this->Uploader->errorMessage;
					$this->Session->setFlash($error);
					$file_error++;
				}
				else
				{
					$this->request->data['AdminClientMarketingEmail']['attachment'] = $this->Uploader->filename;
					unset($this->request->data['AdminClientMarketingEmail']['file']);
					$this->Uploader->filename = '';
				}
			}
			else
			{
				unset($this->request->data['AdminClientMarketingEmail']['file']);
			}
			if($this->request->data['AdminClientMarketingEmail']['type'] == 'draft')
			{
				$this->request->data['AdminClientMarketingEmail']['schedule_time'] = NULL;
				$this->request->data['AdminClientMarketingEmail']['schedule_time'] = NULL;
			}
			if($this->AdminClientMarketingEmail->save($this->request->data))
			{
				$this->AdminClientMarketingEmailUser->deleteAll(array('admin_client_marketing_email_id'=>$getPostedData['AdminClientMarketingEmail']['id']));
				
				$this->loadModel('User');
				$allusers = array(); $i = 0;
				$operator = '';
				
				if(!empty($this->request->data['AdminClientMarketingEmail']['checkboxes']))
				{
					
					$elements = json_decode($this->request->data['AdminClientMarketingEmail']['checkboxes']);
					
					$allele = array();
					foreach($elements as $ele => $v)
					{
						$allele[] = $ele;
					}
					
					if ( !empty($allele) )
					{
						if( count($allele) > 1 )
						{
							$operator = 'IN';
							
						}
						
						$user_info = $this->User->find('all', array(
															'conditions' => array('User.id '.$operator.' ' => $allele),
															'fields' => array('User.id','User.first_name','User.last_name','User.email')
															));
																					
						foreach($user_info as $us)
						{
							$allusers[$i]['admin_client_marketing_email_id'] = $getPostedData['AdminClientMarketingEmail']['id'];
							$allusers[$i]['id'] = $us['User']['id'];
							$allusers[$i]['imported_user_id'] = '';
							$allusers[$i]['first_name'] = $us['User']['first_name'];
							$allusers[$i]['last_name'] = $us['User']['last_name'];
							$allusers[$i]['email'] = $us['User']['email'];
							$allusers[$i]['user_type'] = 'added';		
							$i++;					
						}	
					}
					
													
				}
				
				
				
				if(!empty($this->request->data['AdminClientMarketingEmail']['checkboxes_imported']))
				{
					$operator = ''; 
					$elements = json_decode($this->request->data['AdminClientMarketingEmail']['checkboxes_imported']);
					
					$allele = array();
					foreach($elements as $ele => $v)
					{
						$allele[] = $ele;
					}
					
					if ( !empty($allele) )
					{
						if( count($allele) > 1 )
						{
							$operator = 'IN';
							
						}
								
						
						$this->loadModel('ImportedUser');
						$imported_user_info = $this->ImportedUser->find('all', array(
															'conditions' => array('ImportedUser.id '.$operator.' ' => $allele),
															'fields' => array('ImportedUser.id','ImportedUser.first_name','ImportedUser.last_name','ImportedUser.email')
															));
													
						foreach($imported_user_info as $ius)
						{
							$allusers[$i]['admin_client_marketing_email_id'] = $getPostedData['AdminClientMarketingEmail']['id'];
							$allusers[$i]['id'] = '';
							$allusers[$i]['imported_user_id'] = $ius['ImportedUser']['id'];
							$allusers[$i]['first_name'] = $ius['ImportedUser']['first_name'];
							$allusers[$i]['last_name'] = $ius['ImportedUser']['last_name'];
							$allusers[$i]['email'] = $ius['ImportedUser']['email'];
							$allusers[$i]['user_type'] = 'imported';		
							$i++;					
						}
					}
					
					
					
				}		
				
				if(empty($allusers))
				{
					$this->Session->setFlash('Email not sent. No users selected');
					$this->redirect(array('action'=>'marketing_history_email'));							
				}	

				//if send button is clicked, send immediately
				if($this->request->data['AdminClientMarketingEmail']['type'] == 'send')
				{
					$emailUserData = array(); $k = 0;
					//run loop on all the users ticked in the form
					foreach($allusers as $user)
					{
						$unique_code = String::uuid().'-'.time();
						
						$emailUserData[$k]['admin_client_marketing_email_id'] = $getPostedData['AdminClientMarketingEmail']['id'];
						$emailUserData[$k]['user_id'] = $user['id'];
						$emailUserData[$k]['imported_user_id'] = $user['imported_user_id'];
						$emailUserData[$k]['user_email'] = $user['email'];
						$emailUserData[$k]['user_type'] = $user['user_type'];
						$emailUserData[$k]['status'] = 'Pending';
						$emailUserData[$k]['tracking_id'] = $unique_code;
						$emailUserData[$k]['track_status'] = 'Pending';
						$emailUserData[$k]['error_text'] = '';
						
						$k++;
					}
					
					$this->AdminClientMarketingEmailUser->create();						
					$this->AdminClientMarketingEmailUser->save($emailUserData);
					
					$this->Session->setFlash('Email(s) processed to send sucessfully');
					$this->redirect(array('action'=>'marketing_history_email'));
				}
				//if user didn't click send, save email for each user without setting its status yet.
				else
				{
					//run loop for each user ticked
					foreach($allusers as $usr)
					{
						
						$emailUserData['admin_client_marketing_email_id'] = $getPostedData['AdminClientMarketingEmail']['id'];
						$emailUserData['user_id'] = $usr['id'];
						$emailUserData['imported_user_id'] = $usr['imported_user_id'];
						$emailUserData['user_email'] = $usr['email'];
						$emailUserData['user_type'] = $usr['user_type'];
						$data[] = $emailUserData;
					}
					
					
					//save email user data but don't set status yet, which shows mail hasn't been sent yet
					$this->AdminClientMarketingEmailUser->saveAll($data);
					$this->Session->setFlash('Email saved sucessfully');

					//redirect user according to the button he clicked
					if($this->request->data['AdminClientMarketingEmail']['type'] == 'schedule')
					{
						$this->redirect(array('action'=>'marketing_schedule_email'));
					}
					else
					{
						$this->redirect(array('action'=>'marketing_draft_email'));
					}
				}

			}
		}
		if(!empty($email_id))
		{
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
													'conditions'=>$conditions,
													'group'=>'user_id',
													'fields'=>array('AdminClientDealShare.*', 'User.id', 'User.email')
												)
									);

			$emails = $imported_emails = array();

			foreach($data as $users)
			{
				$emails[$users['User']['id']] = $users['User']['email'];
			}
			
			$this->loadModel('ImportedUser');						
			$imported_user_data = $this->ImportedUser->find('all', array(
																	'conditions' => array('ImportedUser.client_id' => $this->Auth->user('id')),
																	'group' => 'email',
																	'fields' => array('ImportedUser.id','ImportedUser.email')					
																)		
															);
					
				
			foreach($data as $users)
			{
				$emails[$users['User']['id']] = $users['User']['email'];
			}
			
			foreach($imported_user_data as $imp)
			{
				$imported_emails[$imp['ImportedUser']['id']] = $imp['ImportedUser']['email'];
			}
			
			//pr($imported_emails);die;

			$selectedUsers = $this->AdminClientMarketingEmailUser->find('all', array('conditions'=>array('admin_client_marketing_email_id'=>$email_id), 'fields'=>array('user_id','imported_user_id')));
			
			$selected = array();
						
			if(!empty($selectedUsers))
			{
				foreach($selectedUsers as $select)
				{
					if(!empty($select['AdminClientMarketingEmailUser']['user_id']))
					{
						$selected['users'][] = $select['AdminClientMarketingEmailUser']['user_id'];		
					}else{
						$selected['imported_users'][] = $select['AdminClientMarketingEmailUser']['imported_user_id'];		
					}
				}	
			
			}
			
			
			
			if(!isset($selected['imported_users']))
				$selected['imported_users'] = array();
			
			if(!isset($selected['users']))
				$selected['users'] = array();
			
			
			$this->request->data = $this->AdminClientMarketingEmail->findById($email_id);
			$this->set(compact('emails','imported_emails','selected'));
		}
	}
	/**
	 * name : marketing_send_email method
	 * Purpose : send marketing email to user who shared the client deal
	 * author : Deepak Sharma
	 * Created : 31 March 2014
	 */
	function marketing_schedule_change($email_id = NULL)
	{
		$this->loadModel('AdminClientMarketingEmail');

		if(!empty($this->request->data))
		{

			/*if(
				isset($this->request->data['AdminClientMarketingEmail']['schedule_time'])
				&& (
				(($this->request->data['AdminClientMarketingEmail']['schedule_date'] == date('Y-m-d'))
				&& (date('h') >= $this->request->data['AdminClientMarketingEmail']['schedule_time']) )
				|| $this->request->data['AdminClientMarketingEmail']['schedule_date'] < date('Y-m-d')
				)
			)*/
			if(
				isset($this->request->data['AdminClientMarketingEmail']['schedule_time'])
				&& (
				(($this->request->data['AdminClientMarketingEmail']['schedule_date'] == date('Y-m-d'))
				&& (date('h') >= date("h", strtotime($this->request->data['AdminClientMarketingEmail']['schedule_time'].":00 ".$this->request->data['AdminClientMarketingEmail']['schedule_time_type'])) ))
				|| $this->request->data['AdminClientMarketingEmail']['schedule_date'] < date('Y-m-d')
				)
			)
			{
				$this->Session->setFlash('Schedule time should be only future time.');
			}
			else
				{
				$this->AdminClientMarketingEmail->save($this->request->data);
				$this->Session->setFlash('Schedule updated successfully');
				$this->redirect(array('controller'=>'emails', 'action'=>'marketing_schedule_email'));
			}
		}
		if(!empty($email_id))
		{
			$this->request->data = $this->AdminClientMarketingEmail->read('id, schedule_date, schedule_time, is_repeat', $email_id);
			$this->set(compact('emails', 'selectedUsers'));
		}
	}
	/**
	 * name : marketing_send_email method
	 * Purpose : send marketing email to user who shared the client deal
	 * author : Deepak Sharma
	 * Created : 28 March 2014
	 */
	function marketing_draft_email($client_id = NULL)
	{
		$this->loadModel('AdminClientMarketingEmail');

		$conditions = array('client_id'=>$this->Auth->user('id'), 'type'=>'draft');
		if(isset($this->request->data['option']) && !empty($this->request->data['option']))
		{
			if(!empty($this->request->data['ids']))
			{
				switch($this->request->data['option'])
				{
					case "delete":
						$this->EmailTemplate->deleteAll(array('id' => $this->request->data['ids']));
						$this->Session->setFlash(__('Selected email template deleted sucessfully'));
					break;
					case "active":
						$this->EmailTemplate->updateAll(array('status' => "'active'"), array('id' =>  $this->request->data['ids'] ));
					break;
					case "deactive":
						$this->EmailTemplate->updateAll(array('status' => "'inactive'"), array('id' =>  $this->request->data['ids'] ));
					break;
				}
			}
		}
		if($this->request->is('ajax'))
		{
			$this->layout = 'ajax';
		}

		$this->paginate = array(
				'conditions'=>$conditions,
				'limit' => 30,
				'order' => array('id' => 'DESC')
		);
		$marketing_email_history = $this->Paginate('AdminClientMarketingEmail');

		$this->set(compact('marketing_email_history'));
	}

	/**
	 * name : marketing_draft_edit_email method
	 * Purpose : edit draft email here
	 * author : Deepak Sharma
	 * Created : 1 April 2014
	 * Modified By: Vivek Sharma
	 * Modified On: 5 June 2014
	 * Comment: Add users imported from csv,gmail,yahoo
	 */
	function marketing_draft_edit_email($email_id = NULL)
	{
		$this->loadModel('AdminClientMarketingEmail');
		$this->loadModel('AdminClientDealShare');
		$this->loadModel('AdminClientMarketingEmailUser');
		if($this->request->data)
		{
			unset($this->request->data['checkall']);
			unset($this->request->data['checkall_imported']);
			
			if(
				isset($this->request->data['AdminClientMarketingEmail']['schedule_time'])
				&& (
				(($this->request->data['AdminClientMarketingEmail']['schedule_date'] == date('Y-m-d'))
				&& (date('h') >= date("h", strtotime($this->request->data['AdminClientMarketingEmail']['schedule_time'].":00 ".$this->request->data['AdminClientMarketingEmail']['schedule_time_type'])) ))
				|| $this->request->data['AdminClientMarketingEmail']['schedule_date'] < date('Y-m-d')
				)
			)
			{
				$this->Session->setFlash('Schedule time should be only future time.');
			}
			else
			{
				$getPostedData = $this->request->data;
				$file_error = 0;

				if(!empty($getPostedData['AdminClientMarketingEmail']['file']['name']))
				{
					$image_array = $this->request->data['AdminClientMarketingEmail']['file'];
					$image_info = pathinfo($image_array['name']);
					$image_new_name = substr($image_info['filename'],0,70).'_'.time().'_'.$this->Auth->user('id');
					$thumbnails = false;

					$this->Uploader->upload($image_array, EMAILATTACHMENT, $thumbnails, $image_new_name );

					if ( $this->Uploader->error )
					{
						$error = $this->Uploader->errorMessage;
						$this->Session->setFlash($error);
						$file_error++;
					}
					else
					{
						$this->request->data['AdminClientMarketingEmail']['attachment'] = $this->Uploader->filename;
						unset($this->request->data['AdminClientMarketingEmail']['file']);
						$this->Uploader->filename = '';
					}
				}
				else
				{
					unset($this->request->data['AdminClientMarketingEmail']['file']);
				}
				if($this->request->data['AdminClientMarketingEmail']['type'] == 'draft')
				{
					$this->request->data['AdminClientMarketingEmail']['schedule_time'] = NULL;
					$this->request->data['AdminClientMarketingEmail']['schedule_time'] = NULL;
				}
			
				if($this->AdminClientMarketingEmail->save($this->request->data))
				{
					$this->AdminClientMarketingEmailUser->deleteAll(array('admin_client_marketing_email_id'=>$getPostedData['AdminClientMarketingEmail']['id']));

					$this->loadModel('User');
				$allusers = array(); $i = 0;
				$operator = '';
				
				if(!empty($this->request->data['AdminClientMarketingEmail']['checkboxes']))
				{
					
					$elements = json_decode($this->request->data['AdminClientMarketingEmail']['checkboxes']);
					
					$allele = array();
					foreach($elements as $ele => $v)
					{
						$allele[] = $ele;
					}
					
					if ( !empty($allele) )
					{
						if( count($allele) > 1 )
						{
							$operator = 'IN';						
						}
						
						$user_info = $this->User->find('all', array(
															'conditions' => array('User.id '.$operator.' ' => $allele),
															'fields' => array('User.id','User.first_name','User.last_name','User.email')
															));
																					
						foreach($user_info as $us)
						{
							$allusers[$i]['admin_client_marketing_email_id'] = $getPostedData['AdminClientMarketingEmail']['id'];
							$allusers[$i]['id'] = $us['User']['id'];
							$allusers[$i]['imported_user_id'] = '';
							$allusers[$i]['first_name'] = $us['User']['first_name'];
							$allusers[$i]['last_name'] = $us['User']['last_name'];
							$allusers[$i]['email'] = $us['User']['email'];
							$allusers[$i]['user_type'] = 'added';		
							$i++;					
						}
					}
					
														
				}
				
				
				
				
				if(!empty($this->request->data['AdminClientMarketingEmail']['checkboxes_imported']))
				{
					$operator = ''; 
					$elements = json_decode($this->request->data['AdminClientMarketingEmail']['checkboxes_imported']);
					
					$allele = array();
					foreach($elements as $ele => $v)
					{
						$allele[] = $ele;
					}
				
					if ( !empty($allele) )
					{
						if( count($allele) > 1 )
						{
							$operator = 'IN';
							
						}
						
						$this->loadModel('ImportedUser');
						$imported_user_info = $this->ImportedUser->find('all', array(
															'conditions' => array('ImportedUser.id '.$operator.' ' => $allele),
															'fields' => array('ImportedUser.id','ImportedUser.first_name','ImportedUser.last_name','ImportedUser.email')
															));
													
						foreach($imported_user_info as $ius)
						{
							$allusers[$i]['admin_client_marketing_email_id'] = $getPostedData['AdminClientMarketingEmail']['id'];
							$allusers[$i]['id'] = '';
							$allusers[$i]['imported_user_id'] = $ius['ImportedUser']['id'];
							$allusers[$i]['first_name'] = $ius['ImportedUser']['first_name'];
							$allusers[$i]['last_name'] = $ius['ImportedUser']['last_name'];
							$allusers[$i]['email'] = $ius['ImportedUser']['email'];
							$allusers[$i]['user_type'] = 'imported';		
							$i++;					
						}
					}				
					
				}		
				
				if(empty($allusers))
				{
					$this->Session->setFlash('Email not sent. No users selected');
					$this->redirect(array('action'=>'marketing_history_email'));							
				}		
		
				//if send button is clicked, send immediately
				if($this->request->data['AdminClientMarketingEmail']['type'] == 'send')
				{
					$emailUserData = array(); $k = 0;
						
					//run loop on all the users ticked in the form
					foreach($allusers as $user)
					{
						$unique_code = String::uuid().'-'.time();
												
						$emailUserData[$k]['admin_client_marketing_email_id'] = $getPostedData['AdminClientMarketingEmail']['id'];
						$emailUserData[$k]['user_id'] = $user['id'];
						$emailUserData[$k]['imported_user_id'] = $user['imported_user_id'];
						$emailUserData[$k]['user_email'] = $user['email'];
						$emailUserData[$k]['user_type'] = $user['user_type'];
						$emailUserData[$k]['status'] = 'Pending';
						$emailUserData[$k]['tracking_id'] = $unique_code;
						$emailUserData[$k]['track_status'] = 'Pending';
						$emailUserData[$k]['error_text'] = '';
						
						$k++;						
					}
					
					$this->AdminClientMarketingEmailUser->create();						
					$this->AdminClientMarketingEmailUser->saveAll($emailUserData);
					
					$this->Session->setFlash('Email(s) processed to send successfully.');
					$this->redirect(array('action'=>'marketing_history_email'));
				}
				//if user didn't click send, save email for each user without setting its status yet.
				else
				{
					//run loop for each user ticked
					foreach($allusers as $usr)
					{
						
						$emailUserData['admin_client_marketing_email_id'] = $getPostedData['AdminClientMarketingEmail']['id'];
						$emailUserData['user_id'] = $usr['id'];
						$emailUserData['imported_user_id'] = $usr['imported_user_id'];
						$emailUserData['user_email'] = $usr['email'];
						$emailUserData['user_type'] = $usr['user_type'];
						$data[] = $emailUserData;
					}
					
					
					//save email user data but don't set status yet, which shows mail hasn't been sent yet
					$this->AdminClientMarketingEmailUser->saveAll($data);
					$this->Session->setFlash('Email saved sucessfully');

					//redirect user according to the button he clicked
					if($this->request->data['AdminClientMarketingEmail']['type'] == 'schedule')
					{
						$this->redirect(array('action'=>'marketing_schedule_email'));
					}
					else
					{
						$this->redirect(array('action'=>'marketing_draft_email'));
					}
				}

				}
			}
		}
		if(!empty($email_id))
		{
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
													'conditions'=>$conditions,
													'group'=>'user_id',
													'fields'=>array('AdminClientDealShare.*', 'User.id', 'User.email')
												)
									);

			$emails = $imported_emails = array();

			foreach($data as $users)
			{
				$emails[$users['User']['id']] = $users['User']['email'];
			}
			
			$this->loadModel('ImportedUser');						
			$imported_user_data = $this->ImportedUser->find('all', array(
																	'conditions' => array('ImportedUser.client_id' => $this->Auth->user('id')),
																	'group' => 'email',
																	'fields' => array('ImportedUser.id','ImportedUser.email')					
																)		
															);
					
				
			foreach($data as $users)
			{
				$emails[$users['User']['id']] = $users['User']['email'];
			}
			
			foreach($imported_user_data as $imp)
			{
				$imported_emails[$imp['ImportedUser']['id']] = $imp['ImportedUser']['email'];
			}
			
			//pr($emails);die;

			$selectedUsers = $this->AdminClientMarketingEmailUser->find('all', array('conditions'=>array('admin_client_marketing_email_id'=>$email_id), 'fields'=>array('user_id','imported_user_id')));
			
			$selected = array();
						
			if(!empty($selectedUsers))
			{
				foreach($selectedUsers as $select)
				{
					if(!empty($select['AdminClientMarketingEmailUser']['user_id']))
					{
						$selected['users'][] = $select['AdminClientMarketingEmailUser']['user_id'];		
					}else{
						$selected['imported_users'][] = $select['AdminClientMarketingEmailUser']['imported_user_id'];		
					}
				}	
			
			}
			
			if(!isset($selected['imported_users']))
				$selected['imported_users'] = array();
			
			if(!isset($selected['users']))
				$selected['users'] = array();
			
			
			$this->request->data = $this->AdminClientMarketingEmail->findById($email_id);
			$this->set(compact('emails','imported_emails','selected'));			
		}
	}

	/**
	 * name : marketing_resend_email method
	 * Purpose : resend emails here
	 * author : Deepak Sharma
	 * Created : 1 April 2014
	 */
	function marketing_resend_email($email_id = NULL)
	{
		$this->loadModel('AdminClientMarketingEmail');


		if(!empty($email_id))
		{
						
			$this->AdminClientMarketingEmail->bindModel(array(
					'hasMany'=>array(
						'AdminClientMarketingEmailUser'=>array(
							'className'=>'AdminClientMarketingEmailUser',
							'foreignKey'=>'admin_client_marketing_email_id' 
						)
					)
				),false
			);

			$data = $this->AdminClientMarketingEmail->findById($email_id);
			//pr($data); die;
			if(!empty($data) && !empty($data['AdminClientMarketingEmailUser']))
			{
				$this->loadModel('AdminClientMarketingEmailUser');

				$saveData['AdminClientMarketingEmail']['client_id'] = $data['AdminClientMarketingEmail']['client_id'];
				$saveData['AdminClientMarketingEmail']['type'] = $data['AdminClientMarketingEmail']['type'];
				$saveData['AdminClientMarketingEmail']['from_name'] = $data['AdminClientMarketingEmail']['from_name'];
				$saveData['AdminClientMarketingEmail']['from_email'] = $data['AdminClientMarketingEmail']['from_email'];
				$saveData['AdminClientMarketingEmail']['reply_to'] = $data['AdminClientMarketingEmail']['reply_to'];
				$saveData['AdminClientMarketingEmail']['subject'] = $data['AdminClientMarketingEmail']['subject'];
				$saveData['AdminClientMarketingEmail']['content'] = $data['AdminClientMarketingEmail']['content'];
				$saveData['AdminClientMarketingEmail']['schedule_date'] = NULL;
				$saveData['AdminClientMarketingEmail']['schedule_time'] = NULL;

				if($adminemail = $this->AdminClientMarketingEmail->save($saveData))
				{
					$last_inserted_id = $adminemail['AdminClientMarketingEmail']['id'];
					$from_email = $data['AdminClientMarketingEmail']['from_email'];
					$from_name = $data['AdminClientMarketingEmail']['from_name'];
					$subject = $data['AdminClientMarketingEmail']['subject'];
					$this->loadModel('User');

					foreach($data['AdminClientMarketingEmailUser'] as $user_id)
					{
						if(!empty($user_id['user_id']))
						{
							$user_details = $this->User->read('first_name, last_name, email', $user_id['user_id']);
							$user_details = $user_details['User'];
							$user_details['user_type'] = 'added';
							
						}else{
							
							$this->loadModel('ImportedUser');
							$user_details = $this->ImportedUser->read('first_name, last_name, email', $user_id['imported_user_id']);
							$user_details = $user_details['ImportedUser'];
							$user_details['user_type'] = 'imported';
						}
						

						try
						{
							$email = new CakeEmail('smtp');
							$unique_code = String::uuid().'-'.time();
							$code_array = json_encode(array('unique_args' => array('code' => $unique_code)));
							$email->addHeaders(array('X-SMTPAPI' => $code_array));
							
							$email->from(array($from_email=>$from_name));
							if(isset($data['AdminClientMarketingEmail']['reply_to']) && !empty($data['AdminClientMarketingEmail']['reply_to'])){
								$email->replyTo($data['AdminClientMarketingEmail']['reply_to']);
							}
							$email->to($user_details['email']);
							$email->subject($subject);
							$email->emailFormat('html');

							$msg = $data['AdminClientMarketingEmail']['content'];
							$token = array('{user_first_name}','{user_last_name}' );
							$token_value = array(
													$user_details['first_name'],
													$user_details['last_name'],
												);

							$msg = str_replace($token, $token_value, $msg);

							if ($email->send($msg)) {
								$status = 'sent';
								$error = '';
							}
							else
							{
								$status = 'not sent';
								$error =  $this->Email->smtpError;
							}
						}
						catch(Exception $e)
						{
							$status = 'not sent';
							$error =  $e->getMessage();
						}
						$emailUserData['admin_client_marketing_email_id'] = $last_inserted_id;
						
						if(!empty($user_id['user_id']))
						{
							$emailUserData['user_id'] = $user_id['user_id'];
							$emailUserData['imported_user_id'] = '';
							
						}else{
							
							$emailUserData['user_id'] = '';
							$emailUserData['imported_user_id'] = $user_id['user_id'];
							
						}
						
						$emailUserData['user_email'] = $user_details['email'];
						$emailUserData['status'] = $status;
						$emailUserData['tracking_id'] = $unique_code;
						$emailUserData['track_status'] = $status;
						$emailUserData['error_text'] = $error;
						$this->AdminClientMarketingEmailUser->create();
						$this->AdminClientMarketingEmailUser->save($emailUserData);
					}
					$this->Session->setFlash('Email sent successfully');
					$this->redirect(array('action'=>'marketing_history_email'));
				}
				else
				{
					$this->Session->setFlash('Unable to send emails');
				}
			}
			else
			{
				$this->Session->setFlash('Invalid request');
			}
		}
		else
		{
			$this->Session->setFlash('Invalid request');
		}
		$this->redirect(array('action'=>'marketing_history_email'));
	}

	/**
	 * name : deal_email method
	 * Purpose :edit deal email template
	 * author : Abhishek
	 * Created : 9 April 2014
	 */
	function deal_email($client_id = NULL)
	{
		//pr($this->Session->read('Auth')); die;
		$client_id = $this->Session->read('Auth.User.id');

		$this->loadModel('Admin');
		$this->loadModel('AdminClientDealEmail');

		$this->Admin->bindModel(array(
					'hasOne'=>array(
						'AdminClientDealEmail'=>array(
							'className'=>'AdminClientDealEmail',
							'foreignKey'=>'client_id'
						)
					)
				),false
			);

		if($this->request->data)
		{
			$data_arr = $this->request->data;
			$data_arr['AdminClientDealEmail']['client_id'] = $client_id;
			$this->AdminClientDealEmail->save($data_arr);

			if(!empty($this->request->data['AdminClientDealEmail']['id']))
			{
				$this->Session->setFlash('Email Template has been updated successfully');
			}
			else
			{
				$this->Session->setFlash('Email Template saved successfully');
			}

		}
		if(!empty($client_id))
		{
			$this->request->data = $this->Admin->find('first', array(
																'conditions'=>array('Admin.id'=>$client_id),
																'fields'=>array('Admin.id', 'AdminClientDealEmail.*')
															)
												);
		}
	}

	
	
	/**
	 * name : track_email
	 * Purpose :track and update marketing email status
	 * author : Vivek Sharma
	 * Created : 17 July 2014
	 */
	 public function track_email($data = '')
	 {
	 	$this->loadModel('Temp');
		//$data = $this->request->input('json_decode');
		$data =  file_get_contents("php://input");
		
		if(!empty($data))
		{
			$data = json_decode($data);
			foreach($data as $dat)
			{
				if(isset($dat->code) && !empty($dat->code))
				{
					$this->loadModel('AdminClientMarketingEmailUser');
					$track_event = $this->AdminClientMarketingEmailUser->find('first', array('conditions' => array('tracking_id' => $dat->code)));
					
					if ( !empty($track_event) )
					{
						$error_text = '';
						if ( isset($dat->reason) )
						{
							$error_text = $dat->reason; 
						}
						
						$this->AdminClientMarketingEmailUser->id = $track_event['AdminClientMarketingEmailUser']['id'];
						$this->AdminClientMarketingEmailUser->save(array('track_status' => $dat->event,'error_text' => $error_text));
					}
				}
			}
		}
	
		//$this->Temp->create();
		//$this->Temp->save(array('data' =>  $data));
	 
		die;
	 }
	 
	 
	 /**
	 * name : marketing_email_cron
	 * Purpose :send marketing emails which was queued and saved in database
	 * author : Vivek Sharma
	 * Created : 27 August 2014
	 */
	 public function marketing_email_cron()
	 {
	 	$this->loadModel('AdminClientMarketingEmailUser');
		
		$this->AdminClientMarketingEmailUser->recursive = 2;
		$this->AdminClientMarketingEmailUser->bindModel(array(
															'belongsTo' => array(
																			'AdminClientMarketingEmail' => array(
																											 'className' => 'AdminClientMarketingEmail',
																											 'foreignKey' => 'admin_client_marketing_email_id'	
																											),
																			'User' => array(
																						'className' => 'User',
																						'foreignKey' => 'user_id',
																						'fields' => array('User.first_name',
																											'User.last_name',
																											'User.email')
																					),
																			'ImportedUser' => array(
																						'className' => 'ImportedUser',
																						'foreignKey' => 'imported_user_id',
																						'fields' => array('ImportedUser.first_name',
																										  'ImportedUser.last_name',
																										  'ImportedUser.email')
																				))));
		$data = $this->AdminClientMarketingEmailUser->find('all', array('conditions' => array('AdminClientMarketingEmailUser.status' => 'Pending'))); 
	 	
				
		if ( !empty($data) )
		{
			foreach($data as $dat)
			{
				$from_email = $dat['AdminClientMarketingEmail']['from_email'];
				$from_name = $dat['AdminClientMarketingEmail']['from_name'];
				$subject = $dat['AdminClientMarketingEmail']['subject'];
				
				if ( !empty($dat['AdminClientMarketingEmailUser']['user_id']) )
				{
					$first_name = $dat['User']['first_name'];
					$last_name = $dat['User']['last_name'];
					$user_email = $dat['User']['email'];
				}else{
				
					$first_name = $dat['ImportedUser']['first_name'];
					$last_name = $dat['ImportedUser']['last_name'];
					$user_email = $dat['ImportedUser']['email'];
				}
				
				//Send mail to the user
				try
				{
					$email = new CakeEmail('smtp');
					$email->from(array($from_email=>$from_name));
					if(isset($dat['AdminClientMarketingEmail']['reply_to']) && !empty($dat['AdminClientMarketingEmail']['reply_to'])){
						$email->replyTo($dat['AdminClientMarketingEmail']['reply_to']);
					}
					$unique_code = $dat['AdminClientMarketingEmailUser']['tracking_id'];
					$code_array = json_encode(array('unique_args' => array('code' => $unique_code)));
					$email->addHeaders(array('X-SMTPAPI' => $code_array));
					$email->to($user_email);
					$email->subject($subject);
					$email->emailFormat('html');
				
					//save email user data but don't set status yet, which shows mail hasn't been sent yet	
					$msg = $dat['AdminClientMarketingEmail']['content'];
					$token = array('{user_first_name}','{user_last_name}' );
					
					
					
					$token_value = array( $first_name, $last_name );
					if(!empty($dat['AdminClientMarketingEmail']['attachment']) && file_exists(EMAILATTACHMENT.$dat['AdminClientMarketingEmail']['attachment']))
					{
						$attachment = $dat['AdminClientMarketingEmail']['attachment'];
						$attachment_new = APP.WEBROOT_DIR.DS.'files'.DS.'email_attachment'.DS.$attachment;
				
						$path_parts = pathinfo($attachment_new);
						/*
						$size = getimagesize($attachment_new);*/
						$email->attachments( array(
							$path_parts['basename'] =>  $attachment_new,
								//'mimetype' => $size['mime'],
								//'contentId' => 'my-unique-id'
				
						)
						);
					}
					$msg = str_replace($token, $token_value, $msg);
				
					if ($email->send($msg)) {
						$status = 'sent';
						$error = '';
					}
					else
					{
						$status = 'not sent';
						$error =  $this->Email->smtpError;
					}
				}
				catch(Exception $e)
				{
					$status = 'not sent';
					$error =  $e->getMessage();
				}
				
				$this->AdminClientMarketingEmailUser->id = $dat['AdminClientMarketingEmailUser']['id'];
				$this->AdminClientMarketingEmailUser->save(array('status' => $status, 'error_text' => $error , 'track_status' => $status));
			}	

			echo 'success'; die;
		}
		
	 }

}
