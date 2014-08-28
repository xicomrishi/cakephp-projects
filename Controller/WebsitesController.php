<?php

App::uses('AppController', 'Controller');

class WebsitesController extends AppController {

	public $uses = array();
	var $components = array('Facebook.Connect', 'Uploader',
							'Linkedin.Linkedin' => array('key' => '75th4f30vmuudu','secret' => 'CfO0S1vozVFQ59pX'),							
					);
	var $layout = 'default';
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->loginAction = '/w/'.$this->Session->read('Client.website_url');
		$this->Auth->loginRedirect = '/w/'.$this->Session->read('Client.website_url');
		$this->Auth->logoutRedirect = '/w/'.$this->Session->read('Client.website_url');
		$this->Auth->allow(array('domain', 'site_login', 'appointment_contact', 'appointment_upload'));		
	}
	
	function domain($website_url = NULL,  $redirect_type=NULL)
	{
		
		/*Configure::write('debug',2);
		$data['referer'] = $this->request->referer();
		$user_agent = $data['user_agent'] = $this->request->header('User-Agent');
		$this->loadModel('Request');
		$this->Request->save($data);
		
		$reqs = $this->Request->find('all');
		pr($reqs);
		die;*/
		
		
		
		/*$bot = array('Twitterbot', 'TweetmemeBot', 'Google-HTTP-Java-Client', 'Yahoo! Slurp', 'facebookexternalhit', 'PaperLiBot', 'MetaURI');
		$user_agent = $this->request->header('User-Agent');
		
		
		$found = false;
		
		foreach ($bot as $url)
		{
			if (strpos($user_agent, $url) !== FALSE)
			{
				$found = true;
				break;
			}
		}*/
		
		if(empty($website_url))
			$website_url = $this->params['slug'];
		
		
		$browsers = array('Linux', 'Firefox', 'MSIE', 'Android', 'AppleWebKit', 'Ubuntu', 'MetaURI');
		$user_agent = $this->request->header('User-Agent');
		
		
		$found = false;
		
		foreach ($browsers as $url)
		{
			if (strpos($user_agent, $url) !== FALSE)
			{
				$found = true;
				break;
			}
		}
		
		$this->layout = 'default';
		
		$this->loadModel('Admin');
		
		if (empty($website_url) && $this->Session->read('Client.website_url') != '') 
		{
			$website_url = $this->Session->read('Client.website_url');			
		}
		
		if(!empty($website_url))
		{
			$user_data =  $this->Admin->get_user_web_data($website_url);
			
			if (!empty($user_data)) 
			{
				if($found && strpos($user_agent, 'Mozilla') !== FALSE && $user_agent != 'Mozilla/5.0 ()')
				{					
					if(isset($redirect_type) && ($redirect_type == 'facebook' || $redirect_type == 'f'))
					{
						$this->Admin->query("update admins set total_visit=total_visit+1, facebook_visit=facebook_visit+1 where id='".$user_data['Admin']['id']."'");
						
					}
					else if(isset($redirect_type) && ($redirect_type == 'twitter' || $redirect_type == 't'))
					{
						$this->Admin->query("update admins set total_visit=total_visit+1, twitter_visit=twitter_visit+1 where id='".$user_data['Admin']['id']."'");
						
					}
					else
					{
						$this->Admin->query("update admins set total_visit=total_visit+1, other_visit=other_visit+1 where id='".$user_data['Admin']['id']."'");
						
					}
				}
				else 
				{
					$this->Admin->query("update admins set total_visit=total_visit+1, other_visit=other_visit+1 where id='".$user_data['Admin']['id']."'");
				
				}
				$this->Session->write('Client', $user_data['Admin']);
				$this->Session->write('ApplicationType', 'web');
				
				if ( $this->Session->check('is_upload_image') )
				{
					$this->set('is_upload_image',$this->Session->read('is_upload_image'));
					$this->Session->delete('is_upload_image');
				}
				
				
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

	
	
	public function site_login ( $return = 0 )
	{
		if ( !empty($this->request->data) )
		{
			
			if ($this->Auth->login())
			{
				$this->redirect(array('controller'=>'websites', 'action'=>'profile'));
			} 
			else
			{				
				$this->Session->setFlash(__('Password and / or Username do not match'));
				$this->redirect('/w/'.$this->Session->read('Client.website_url'));
			}
		}
		else
		{
			$this->redirect('/w/'.$this->Session->read('Client.website_url'));
		}
	}
	
	function profile()
	{		
		$this->layout = 'public';
		$this->loadModel('User');
		$this->loadModel('UserAppointment');
		
		if ($this->Auth->user() == '')
		{
			$this->redirect(array('controller'=>'domain', 'action'=>'check_auth'));
		}
		 if (!empty($this->request->data))
		{
			//pr($this->request->data); die;
			$this->request->data['User']['id'] = $this->Auth->user('id');
			$appoint = array();
			$appoint[] = $this->request->data['UserAppointment']['first_choice'];
			$appoint[] = $this->request->data['UserAppointment']['second_choice'];
			$appoint[] = $this->request->data['UserAppointment']['third_choice'];
			$choices = array();
			$error = false;
			foreach($appoint as $choice)
			{
				if(isset($choices[0]) && $choices[0]== $choice)
				{
					$error = true;
					break;
				}
				if(isset($choices[1]) && $choices[1]== $choice)
				{
					$error = true;
					break;
				}
				$choices[] = $choice; 
			}
			if($error)
			{
				$this->UserAppointment->invalidate('first_choice','Choices should be different to each other.');
				$this->set('error_message', __('Please choose different appointment date and time'));
				$loggedUser = $this->request->data;
				$this->set(compact('loggedUser'));
			}
			else
			{
				if($user = $this->User->save($this->request->data['User'], false) )
				{
					$this->loadModel('UserAppointment');
					$this->request->data['UserAppointment']['user_id'] = $this->Auth->user('id');
					$this->request->data['UserAppointment']['client_id'] = $this->Session->read('Client.id');				
					
					if ($appointment = $this->UserAppointment->save($this->request->data['UserAppointment']))
					{
						/**Send mail to client for appointment request*/
						$this->loadModel('Admin');
						$client = $this->Admin->find('first',array('conditions' => array('Admin.id' => $appointment['UserAppointment']['client_id'])));
						
						$arr = array();
						$arr['to_email'] = $client['Admin']['email'];
						$arr['email_subject'] = 'You have received an appointment request';
						
						$dashboard_link = '<a href="'.SITE_URL.'admin">Click here</a> to view appointment';
						
						$arr_keys = array('{username}','{dashboard_link}','{site_name}');
						$arr_values = array(ucwords($client['Admin']['first_name'].' '.$client['Admin']['last_name']), $dashboard_link, SITE_NAME);
						$this->send_email(array(SITE_EMAIL => SITE_NAME), SITE_EMAIL, null, $arr, $arr_keys, $arr_values, 'user_appointment_request');
						
						
						/**Send mail to user for appointment confirmation*/
						$arr = array();
						$arr['to_email'] = $user['User']['email'];
						$arr['email_subject'] = 'Appointment request confirmed';
						$arr_keys = array('{username}','{site_name}');
						$arr_values = array(ucwords($user['User']['first_name'].' '.$user['User']['last_name']), SITE_NAME);
						
						$this->send_email(array(SITE_EMAIL => SITE_NAME), SITE_EMAIL, null, $arr, $arr_keys, $arr_values, 'user_appointment_confirmation');
						
						
						$this->flash_new( __('Appointment requested successfully'), 'success-messages' );
						$this->redirect('/w/'.$this->Session->read('Client.website_url'));
					}
				}
			}
		}
	}
	
		
	
	public function login( $type='site' , $id = null )
    {			
		switch($type)
		{
			case 'facebook':
				$this->_auth_facebook();
			break;
			case 'twitter':				
				//$this->_auth_twitter();
			break;
			case 'yahoo':
				$this->redirect(array('controller'=>'Pages', 'action'=>'auth_yahoo'));
			break;
			case 'linkdin':
				$this->_auth_linkdin();
			break;
			case 'google':
				$this->_auth_google();
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
    
	function logout()
	{
		$this->Auth->logout();
		$application_type = $this->Session->read('ApplicationType');
		$client = $this->Session->read('Client');
		if($this->Session->read('LoginType') == 'facebook')
		{
			App::uses('FB', 'Facebook.Lib');
			$Facebook = new FB();			
			
			$logoutUrl = $Facebook->getLogoutUrl(array('next'=>SITE_URL.'domain/check_auth'));         
		
			$Facebook->destroySession();
			$this->Session->destroy();
			
			$this->Session->write('ApplicationType', $application_type);
			$this->Session->write('Client', $client);
			
			$this->redirect($logoutUrl);
		}
		else
		{
			$this->Session->destroy();			
			$this->Session->write('ApplicationType', $application_type);
			$this->Session->write('Client', $client);
			
			$this->redirect(array('controller'=>'domain', 'action'=>'check_auth'));
		}
	}
	
	
	/**
	 * Name : appointment_contact
	 * Created : 19 June 2014	 
	 * Author : Vivek Sharma
	 * Purpose: save contact form details from website main page
	 */ 
	public function appointment_contact()
	{
		if( !empty($this->request->data) )		
		{
			$this->loadModel('UserAppointment');
			$this->loadModel('Admin');
						
			$this->UserAppointment->create();
			$data = $this->UserAppointment->save($this->data);
			
			$client = $this->Admin->find('first',array('conditions'=>array('id'=>$data['UserAppointment']['client_id'])));
			
			$data['UserAppointment']['username'] = $client['Admin']['first_name'];
			$data['UserAppointment']['to_email'] = $client['Admin']['email'];
			$data['UserAppointment']['email_subject'] = 'A contact request is submitted on website';
			
			$arr_keys = array('{name}','{email}','{subject}','{message}','{username}','{site_name}');
			$arr_values = array($data['UserAppointment']['name'],$data['UserAppointment']['email'],$data['UserAppointment']['subject'],
								$data['UserAppointment']['message'],$data['UserAppointment']['username'],SITE_NAME);
								
			$this->send_email(array(SITE_EMAIL => SITE_NAME), SITE_EMAIL, null, $data['UserAppointment'], $arr_keys, $arr_values, 'user_contact_request');
			echo 'success'; die;
		}
	}
	
	
	/**
	 * Name : appointment_upload
	 * Created : 19 June 2014	 
	 * Author : Vivek Sharma
	 * Purpose: save upload form details from website main page
	 */ 
	public function appointment_upload()
	{	//pr($this->data); die;		
		if( !empty($this->request->data) )		
		{
			$this->loadModel('UserAppointment');
			$this->loadModel('Admin');
			$img = '';
			$error = 0;
			if(!empty( $this->request->data['UserAppointment']['image']['name']))
			{
				$image_array = $this->request->data['UserAppointment']['image'];	
				$image_info = pathinfo($image_array['name']);
				$image_new_name = $image_info['filename'].time().'_'.$this->request->data['UserAppointment']['client_id'];
				
				$thumbnails = Thumbnail::slider_thumbs();	
				$params = array('size'=>'500');		
				$this->Uploader->upload($image_array, APPOINTMENTS, $thumbnails, $image_new_name, $params );
			
				if ( $this->Uploader->error )
				{
					echo 'error'; die;					
				}
				else
				{							
					$this->request->data['UserAppointment']['image'] = $this->Uploader->filename;
					$this->request->data['UserAppointment']['name'] = $this->request->data['UserAppointment']['email'] = $this->request->data['UserAppointment']['subject'] = $this->request->data['UserAppointment']['message'] = '';
					$img = dirname(dirname(__FILE__)).DS.'webroot'.DS.'img'.DS.'appointments'.DS.$this->Uploader->filename;
					$this->Uploader->filename = '';
				}
			}
			
			$this->UserAppointment->create();
			$data = $this->UserAppointment->save($this->data);
			
			$client = $this->Admin->find('first',array('conditions'=>array('id'=>$data['UserAppointment']['client_id'])));
			
			$data['UserAppointment']['username'] = $client['Admin']['first_name'];
			$data['UserAppointment']['to_email'] = $client['Admin']['email'];
			$data['UserAppointment']['email_subject'] = 'A document is submitted on website';
			
			$arr_keys = array('{name}','{email}','{subject}','{message}','{username}','{site_name}');
			$arr_values = array($data['UserAppointment']['name'],$data['UserAppointment']['email'],$data['UserAppointment']['subject'],
								$data['UserAppointment']['message'],$data['UserAppointment']['username'],SITE_NAME);
			
			$this->send_email(array(SITE_EMAIL => SITE_NAME), SITE_EMAIL, $img, $data['UserAppointment'], $arr_keys, $arr_values, 'user_appointment_document');
			$this->Session->write('is_upload_image', $data['UserAppointment']['image']);
			$this->redirect($this->referer());
		}
	}
	
	/**
	 * Name : send_email
	 * Created : 19 June 2014	 
	 * Author : Vivek Sharma
	 * Purpose: send email to users
	 */ 
	function send_email($from, $replyto, $attachment = NULL, $arr=NULL,$arr_keys, $arr_values, $template)
	{		
		$this->loadModel('EmailTemplate');
		
		$content = $this->EmailTemplate->find('first',array('conditions'=>array('name'=>$template)));
		
		if(!empty($content))
		{
			$email_content = str_replace($arr_keys, $arr_values, $content['EmailTemplate']['content']);
			
			$email = new CakeEmail('smtp'); 		
			$email->from($from);
			$email->replyTo($replyto);			
			$email->to($arr['to_email']);
			$email->subject($arr['email_subject']);
			$email->emailFormat('html');
			
			if(!empty($attachment))
			{
				$path_parts = pathinfo($attachment);
				$size = getimagesize($attachment);	
				$email->attachments(array(
					$path_parts['basename'] => array(
						'file' => $attachment,
						/*'mimetype' => $size['mime'],
						'contentId' => 'my-unique-id'*/
					)
				));
			}
			
			if ($email->send($email_content)) {
				$res = 'yes';
			} else {
				$res =  $this->Email->smtpError;
			}
		}		
		return $res;		
	}
	
	
}
