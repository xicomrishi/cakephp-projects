<?php
/**
 * Name : Admin Controller
 * Created : 26 Aug 2013
 * Purpose : Default admin users controller
 * Author : Anuj Kumar
 */ 
class UsersController extends AdminAppController
{
	public $name = 'Users';
	public $uses = array('Admin', 'User');
	public $components = array('Admin.Uploader');
		
	public $paginate = array ('limit' => 10);		
		
	public function beforeFilter()
	{
		//Set auth model Admin
		parent::beforeFilter();
		$this->Auth->authenticate = array(
			'Form' => array('userModel' => 'Admin')
		);
		$this->Auth->allow('login','hash_password','forget_password','get_checked_users','check_fb_token');
		
	}	
	
	/**
	 * Name : Dashboard Action, shows default dashbaord to user
	 * Created : 9 Sept 2013	 
	 * Author : Anuj Kumar
	 */ 
	public function dashboard()
	{
		if($this->Auth->user('type') == '2')
		{
			$fb_page_token = $this->Admin->find('first',array('conditions' => array('Admin.id' => $this->Auth->user('id')),
																'fields' => array('fb_page_access_token', 'facebook_id')));
		   if(empty($fb_page_token['Admin']['fb_page_access_token']) || empty($fb_page_token['Admin']['facebook_id']))	
		   {
		   	$this->set('redirect_fb_page_token','1');
		   }else{
		   		$url = "https://graph.facebook.com/me?access_token=".$fb_page_token['Admin']['fb_page_access_token'];
		   		$fb_token_info = file_get_contents($url);
				
				if(empty($fb_token_info))
				{
					$this->get_page_access_token(2);
				}		   	
		   }			
				
		}		
	}
	
	/**
	 * Name : Index
	 * Purpose : Default index function for users. Display  user listing and other filters
	 * Created : 9 Sept 2013	 
	 * Author : Anuj Kumar
	 */ 
	public function index()
	{	
		$this->loadModel('Admin');
		$conditions = array('Admin.type'=>2);
		
		//This section handles multipe delete and change status
		if(isset($this->request->data['option']) && !empty($this->request->data['option']))
		{
			if(!empty($this->request->data['ids']))
			{
				switch($this->request->data['option'])
				{
					case "delete":
						$this->Admin->deleteAll(array('id' => $this->request->data['ids']));					
						$this->flash_new( __('Selected users deleted successfully'), 'success-messages' );
					break;
					case "active":
						$this->Admin->updateAll(array('status' => "'active'"), array('id' =>  $this->request->data['ids'] ));
						$this->flash_new( __('Selected users activated successfully'), 'success-messages' );
					break;
					case "deactive":
						$this->Admin->updateAll(array('status' => "'inactive'"), array('id' =>  $this->request->data['ids'] ));
						$this->flash_new( __('Selected users deactivated successfully'), 'success-messages' );
					break;
				}
			}
			else{
				$this->flash_new( __('Please select user to perform action.'), 'error-messages' );
			}
		}
	
		//This section handles search
		if(isset($_GET['filter']))
		{
			$conditions = array_merge($conditions, array('Admin.'.$_GET['filter'].' Like ' => $_GET['search_keyword'].'%'));
		}	
		
				
		$this->paginate = array(		
					'limit' => 10,
					'conditions' => $conditions,
					'order' => array('Admin.id' => 'desc')					
				);			
		$users = $this->paginate('Admin');
		$this->set('users', $users);		
	}
	
	/**
	 * Name : get_page_access_token
	 * Purpose : Get FB page access token to manage page 
	 * Created : 24 June, 2014
	 * Author : Vivek Sharma
	 */ 
	public function get_page_access_token($num=0)
	{	  
	   if ( empty($_REQUEST['code']) ) {
				
			$redirect_url = SITE_URL.'admin/users/get_page_access_token';
			$dialog_url = 'https://www.facebook.com/dialog/oauth?client_id='.FB_APP_ID.'&client_secret='.FB_APP_SECRET.'&redirect_uri='.$redirect_url.'&scope=read_stream,publish_stream,offline_access,manage_pages';
	
		 	echo("<html><body><script> top.location.href='" . $dialog_url . "'</script></body></html>");
		
	   } else {
	   	
		 		 $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
                    . FB_APP_ID . "&client_secret="
                    . FB_APP_SECRET . "&code=" . $_REQUEST['code'] . "&redirect_uri=" . urlencode(SITE_URL."admin/users/get_page_access_token") ;

	            $access_token = file_get_contents($token_url);	    
				       
				
				$user_info = file_get_contents('https://graph.facebook.com/me?'.$access_token);
				$user_info = json_decode($user_info);
				
				//echo '<pre>'; print_r($user_info); die;
				$permissions = file_get_contents('https://graph.facebook.com/me/permissions?'.$access_token);
			
			
				if ( !empty($permissions) )
				{
					$permissions = json_decode($permissions);
					$permission_data = $permissions->data;
					//	echo '<pre>';print_r($permission_data[0]->publish_stream); die;
				}
					
					
				$all_permissions = array();
				$again = 1;
				
				if ( !empty($permission_data) )
				{
					
					if ( $permission_data[0]->publish_stream == 1 && $permission_data[0]->manage_pages == 1)
					{
						$again = 0;
					}
					
				}
				
				
				//echo $again; die;
				
				//check if user give all required permission or skipped 1 or 2
				if( $again == 1 ) {
				
					$this->redirect(array('action' => 'get_page_access_token'));
				}
				
	            $access = explode('&', $access_token);
	            $access = substr($access[0], 13);				
				$extended_token_url = 'https://graph.facebook.com/oauth/access_token?client_id='.FB_APP_ID.'&client_secret='.FB_APP_SECRET.'&grant_type=fb_exchange_token&fb_exchange_token='.$access;
				
				$response = file_get_contents($extended_token_url);
				$resp = explode('&',$response);
				$resp = explode('=',$resp[0]);
				
				
				if(!empty($resp))
				{
					$dateplus = date('Y-m-d', strtotime('+50 days'));
					
					$this->Admin->id = $this->Auth->user('id');
					$this->Admin->save(array('fb_page_access_token' => $resp[1], 'facebook_id' => $user_info->id, 'fb_token_date' => $dateplus));
				}
				
				if ( $num == 2)
				{
					$this->flash_new( __('Configuration updated for facebook account.'), 'success-messages' );
				}else{
					$this->flash_new( __('Congratulations! You have successfully connected your account with facebook'), 'success-messages' );
				}
				
				
				$this->redirect(array('action' => 'dashboard'));
				
		 }
	}


	/**
	 * Name : Login Action
	 * Created : 26 Aug 2013
	 * Purpose : Default login action used for managing admin login
	 * Author : Anuj Kumar
	 */ 
	public function login()
	{
		if ($this->request->is('post')) 
		{
			if ($this->Auth->login()) 
			{	
				if($this->Auth->user('type') == 1) {
					return $this->redirect($this->Auth->redirectUrl());			
				}
				elseif($this->Auth->user('type') == 2) {
					return $this->redirect(array('controller'=>'users', 'action'=>'dashboard'));	
				}else if($this->Auth->user('type') == 3){					
					
					return $this->redirect(array('controller'=>'users', 'action'=>'subadmin_dashboard'));	
				}
			}
			else 
			{				
				$this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
			}
		}
	}
	
	public function logout()
	{
			$this->Session->delete('is_subadmin_user');
		$this->redirect($this->Auth->logout());
	}
	
	/**
	 * Name : Admin Controller
	 * Created : 26 Aug 2013
	 * Purpose : For Admin User registration
	 * Author : Anuj Kumar
	 */
	public function register()
	{	
        if ($this->request->is('post')) {
            $this->Admin->create();
			$this->request->data['Admin']['password'] = AuthComponent::password($this->request->data['Admin']['password']);
            if ($this->Admin->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        }
	}
	
/**
 * Name : Add Action
 * Created : 16 jan 2014
 * Purpose : Default login action used for managing admin login
 * Author : Anuj Kumar
 */
	public function add() 
	{		
		if ($this->request->is('post')) 
		{		
			$this->loadModel('Admin.Admin');
			$this->Admin->set($this->data['Admin']);
			
			if ( isset($this->request->data['Admin']['subadmin_id']) )
			{
				$this->set('subadmin_user',$this->request->data['Admin']['subadmin_id']);
			}
			
			
			if ($this->Admin->validates())
			{
				//pr($this->data);die;
				$this->request->data['Admin']['type'] = 2;
				
				//Get and save latitude and longitude
				
				//$getLAT_LOG = getLnt($this->request->data['Admin']['zip_code']);
				//$this->request->data['Admin']['latitude'] = $getLAT_LOG['lat'];
				//$this->request->data['Admin']['longitude'] = $getLAT_LOG['lng'];
				
						
				
				if(!empty( $this->request->data['Admin']['company_logo']['name']))
				{
					$image_array = $this->request->data['Admin']['company_logo'];
					$image_info = pathinfo($image_array['name']);
					$image_new_name = $image_info['filename'].time();
					$thumbnails = Thumbnail::company_logo_thumbs();
					$params = array('size'=>'500');
					$this->Uploader->upload($image_array, COMPANY , $thumbnails, $image_new_name, $params );
				
					if ( $this->Uploader->error )
					{
						$file_error = $this->Uploader->errorMessage;
						$this->flash_new( $file_error, 'error-messages' ); 	
						$this->request->data['Admin']['company_logo'] = '';					
					}
					else
					{							
						$this->request->data['Admin']['company_logo'] = $this->Uploader->filename;
						$this->Uploader->filename = '';
					}
				}
				
				if ( isset($this->request->data['Admin']['website_image']['name']) && !empty($this->request->data['Admin']['website_image']['name']) )
				{
					
					$image_array = $this->request->data['Admin']['website_image'];
					$image_info = pathinfo($image_array['name']);
					$image_new_name = $image_info['filename'].time();
					$thumbnails = Thumbnail::company_logo_thumbs();
					$params = array('size'=>'500');
					$size_dimensions = array('width'=>20, 'height'=>20);
					$this->Uploader->upload($image_array, COMPANY , $thumbnails, $image_new_name, $params, $size_dimensions );
				
					if ( $this->Uploader->error )
					{
						$file_error = $this->Uploader->errorMessage;
						$this->flash_new( $file_error, 'error-messages' ); 	
						$this->request->data['Admin']['website_image'] = '';	
										
					}
					else
					{							
						$this->request->data['Admin']['website_image'] = $this->Uploader->filename;
						$this->Uploader->filename = '';
					}
					
				}else{
					$this->request->data['Admin']['website_image']='';
				} 
				
				
				if ($admin_data = $this->Admin->save($this->request->data)) 
				{
					$last_user_id = $this->Admin->getlastInsertID();
					
					
					if (!empty($this->request->data['AdminClientSlider']['image']['name']))
					{
						$this->loadModel('AdminClientSlider');
						
						$image_array = $this->request->data['AdminClientSlider']['image'];
						$image_info = pathinfo($image_array['name']);
						$image_new_name = $image_info['filename'].time().'_'.$last_user_id;
						$thumbnails = Thumbnail::slider_thumbs();
						
						//$this->Uploader->upload($image_array, SLIDER, $thumbnails, $image_new_name );
						$this->Uploader->upload($image_array, SLIDER, $thumbnails, $image_new_name, array(), array('width'=>740, 'height'=>300) );
						
						if ( $this->Uploader->error )
						{
							$file_error = $this->Uploader->errorMessage;
							$this->flash_new( 'Slider image Error :'.$file_error, 'error-messages' ); 
							$this->request->data['AdminClientSlider']['image'] = '';					
						}
						else
						{							
							$this->request->data['AdminClientSlider']['image'] = $this->Uploader->filename;
							$this->Uploader->filename = '';
						}						
							
						
						$this->request->data['AdminClientSlider']['user_id'] = $last_user_id;
						
						if(!$this->AdminClientSlider->save($this->request->data['AdminClientSlider']))
						{				 
							$this->flash_new( __('But error occured while uploading slider image'), 'error-messages' );
							
						}
					}
					/*
					$this->loadModel('AdminClientFeedbackEmail');
					$feedback['AdminClientFeedbackEmail']['client_id'] = $last_user_id;
					$feedback['AdminClientFeedbackEmail']['subject'] = 'Feedback';
					$feedback['AdminClientFeedbackEmail']['from_name'] = $this->request->data['Admin']['first_name'];
					$feedback['AdminClientFeedbackEmail']['from_email'] = $this->request->data['Admin']['email'];
					$feedback['AdminClientFeedbackEmail']['reply_to'] = $this->request->data['Admin']['email'];
					$feedback['AdminClientFeedbackEmail']['days'] = 5;
					$feedback['AdminClientFeedbackEmail']['content'] = "Hello {first_name} {last_name} <br/><br/> Thank you for sharing deal {deal_title}";
					$this->AdminClientFeedbackEmail->save($feedback);*/
					
					if ( isset($this->request->data['Admin']['subadmin_id']) )
					{
						$this->loadModel('AdminClient');
						$this->AdminClient->create();
						
						if ( $this->AdminClient->save(array('admin_id' => $this->request->data['Admin']['subadmin_id'], 'client_id' => $last_user_id)) )
						{
							$this->loadModel('Setting');
							$settings = $this->Setting->findByKey('site_setting');
							$setting_data = json_decode($settings['Setting']['value'],true);
							$Setting = $setting_data['Settings'];
								
							/**Send email to super admin*/				
							
							$arr = array();
							$arr['to_email'] = $Setting['from_email'];
							$arr['email_subject'] = 'Sub-admin '.$this->Auth->user('first_name').' '.$this->Auth->user('last_name').' added a new user';
							$arr_keys = array('{USERNAME}','{subadmin}','{EMAIL}','{COMPANY}');
							$arr_values = array(ucwords($admin_data['Admin']['first_name'].' '.$admin_data['Admin']['last_name']), 
													$this->Auth->user('first_name').' '.$this->Auth->user('last_name'),
													$admin_data['Admin']['email'],
													$admin_data['Admin']['company']
													 );
							
							
							
							//echo '<pre>';print_r($Setting); die;
							
							$this->send_email(array($Setting['from_email'] => $Setting['from_name']), $Setting['from_email'], null, $arr, $arr_keys, $arr_values, 'subadmin_add_user');
							
							
						}else{
							$this->flash_new( __('User not saved. Please try again later.'), 'error-messages' );
						}
						
						
						
					}
					
					
					
					$this->flash_new( __('The user has been saved'), 'success-messages' );
					if ( isset($this->request->data['Admin']['subadmin_id']) )
					{
						$this->redirect(array('action' => 'subadmin_dashboard'));	
					}else{
						$this->redirect(array('action' => 'index'));	
					}
					
				} 
				else 
				{
					$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
				}
			}
			else {
				
					$errors = $this->Admin->validationErrors;	
					$this->Session->setFlash(__('The user could not be saved. Please, try again.'));	
						
			}
		}
		$this->loadModel('Country');
		$countries = $this->Country->find('list', array('fields'=>array('name', 'name')));
		$this->loadModel('AdminIcon');
		$icons = $this->AdminIcon->find('all');
		
		$this->set(compact('countries', 'icons'));
	}


	/**
	 * Name : Subadmin Add Action
	 * Created : 28 July 2014
	 * Purpose : add user from subadmin
	 * Author : Vivek Sharma
	 */
	public function subadmin_add_user() 
	{
		$this->loadModel('Country');
		$countries = $this->Country->find('list', array('fields'=>array('name', 'name')));
		$this->loadModel('AdminIcon');
		$icons = $this->AdminIcon->find('all');
		
		$this->set(compact('countries', 'icons'));
		$this->set('subadmin_user',$this->Auth->user('id'));
		$this->render('add');
	}	
	
	
	/**
	 * Name : Edit user action
	 * Created : 9 Sept 2013
	 * Purpose : User edit action.
	 * Author : Anuj Kumar
	 */
	public function edit($id = null) 
	{
		$this->loadModel('Admin.Admin');
		
		if (!$this->Admin->exists($id)) 
		{
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			//Get and save latitude and longitude
				
			//$getLAT_LOG = getLnt($this->request->data['Admin']['zip_code']);
			//$this->request->data['Admin']['latitude'] = $getLAT_LOG['lat'];
			//$this->request->data['Admin']['longitude'] = $getLAT_LOG['lng'];
			
			$flag = 0;
			
			if ( !empty($this->data['Admin']['fb_fanpage_id']) && $this->data['Admin']['fb_fanpage_id'] != 0)
			{
				$accessToken = $this->Admin->find('first', array('conditions' => array('Admin.id' => $this->data['Admin']['id']),
																'fields' => array('Admin.fb_page_access_token')));
																
				$page_info = file_get_contents('https://graph.facebook.com/me/accounts?access_token='.$accessToken['Admin']['fb_page_access_token']);
				
				$page_info = json_decode($page_info);
				
				
				if ( !empty($page_info) )
				{
					foreach($page_info->data as $pages)
					{
						if ( $pages->id == $this->data['Admin']['fb_fanpage_id'])
						{
							$flag = 1;
						}
					}
				}
														
			}
			
			if ($flag == 1 || $this->data['Admin']['fb_fanpage_id'] == 0)
			{
			
				if ( isset($this->request->data['Admin']['website_image']['name']) && !empty($this->request->data['Admin']['website_image']['name']) )
				{
					
					$image_array = $this->request->data['Admin']['website_image'];
					$image_info = pathinfo($image_array['name']);
					$image_new_name = $image_info['filename'].time();
					$thumbnails = Thumbnail::company_logo_thumbs();
					$params = array('size'=>'500');
					$size_dimensions = array('width'=>20, 'height'=>20);
					$this->Uploader->upload($image_array, COMPANY , $thumbnails, $image_new_name, $params, $size_dimensions );
				
					if ( $this->Uploader->error )
					{
						$file_error = $this->Uploader->errorMessage;
						$this->flash_new( $file_error, 'error-messages' ); 	
						$this->request->data['Admin']['website_image'] = '';					
					}
					else
					{							
						$this->request->data['Admin']['website_image'] = $this->Uploader->filename;
						$this->Uploader->filename = '';
					}
					
				}else{
					unset($this->request->data['Admin']['website_image']);
				} 
				
				if ( !empty($this->request->data['Admin']['company_logo']['name']) )
				{
					
					$image_array = $this->request->data['Admin']['company_logo'];
					$image_info = pathinfo($image_array['name']);
					$image_new_name = $image_info['filename'].time();
					$thumbnails = Thumbnail::company_logo_thumbs();
					$params = array('size'=>'500');
					$size_dimensions = array('width'=>20, 'height'=>20);
					$this->Uploader->upload($image_array, COMPANY , $thumbnails, $image_new_name, $params, $size_dimensions );
				
					if ( $this->Uploader->error )
					{
						$file_error = $this->Uploader->errorMessage;
						$this->flash_new( $file_error, 'error-messages' ); 	
						$this->request->data['Admin']['company_logo'] = '';					
					}
					else
					{							
						$this->request->data['Admin']['company_logo'] = $this->Uploader->filename;
						$this->Uploader->filename = '';
					}
					
				}else{
					unset($this->request->data['Admin']['company_logo']);
				} 
				
				
				if ($this->Admin->save($this->request->data)) 
				{
					$this->flash_new( __('The user has been saved'), 'success-messages' ); 
					if($this->Auth->user('type') == 1) {
						$this->redirect(array('action' => 'index'));
					}
					else {
						$this->redirect(array('action' => 'profile', $this->Auth->user('id')));
					}
				} 
				else 
				{
					$this->flash_new(__('The user could not be saved. Please, try again.'), 'success-messages');
				}
			}else{
				$this->flash_new(__('Either you have entered wrong facebook page ID or you are not admin of that facebook page. Please enter valid facebook page ID'), 'error-messages');
				$this->redirect(array('action' => 'edit', $this->Auth->user('id')));
			}
		} 
		else 
		{
			$this->loadModel('Country');
			$countries = $this->Country->find('list', array('fields'=>array('name', 'name')));
			$this->set(compact('countries'));
			$options = array('conditions' => array('Admin.' . $this->User->primaryKey => $id));
			$this->request->data = $this->Admin->find('first', $options);
		}
		
		$this->set('page', 'edit');
		if($this->Auth->user('type') == 1)
		{
			$this->render('edit');
		}
		else
		{
			
			$this->render('edit_user');
		}
		//$this->render('add');
	}


	/**
	 * Name : preview_tablet_edit
	 * Created : 11 June 2014
	 * Purpose : Preview profile
	 * Author : Vivek Sharma
	 */
	public function preview_tablet_edit($color,$bg_color,$font_color,$bg_texture='1') 
	{
		$this->layout = 'ajax';
					
		$this->set('color', $color);
		$this->set('bg_color', $bg_color);
		$this->set('font_color', $font_color);
		$this->set('bg_texture', $bg_texture);
	
		$this->render('preview_tablet');
	}
	
	/**
	 * Name : preview_website_edit
	 * Created : 11 June 2014
	 * Purpose : Preview profile
	 * Author : Vivek Sharma
	 */
	public function preview_website_edit($color,$bg_color,$font_color,$bg_texture='1',$display_form_type = '1') 
	{
		$this->layout = 'ajax';
		
		$this->set('color', $color);
		$this->set('bg_color', $bg_color);
		$this->set('font_color', $font_color);
		$this->set('bg_texture', $bg_texture);
		$this->set('display_form_type', $display_form_type);
		$this->render('preview_website_edit');
	}
	
/**
 * Name : View user action
 * Created : 21 Jan 2014
 * Purpose : User view action.
 * Author : Deepak Sharma
 */
	public function view($id = null) 
	{
		$this->loadModel('Admin.Admin');
		
		if (!$this->Admin->exists($id)) 
		{
			throw new NotFoundException(__('Invalid user'));
		}		
		$options = array('conditions' => array('Admin.' . $this->Admin->primaryKey => $id));
		$user_info = $this->Admin->find('first', $options);
		
		$this->set(compact('user_info'));
		//$this->render('add');
	}
	
/**
 * Name : User website slider
 * Created : 21 Jan 2014
 * Purpose : User slider action.
 * Author : Deepak Sharma
 */
	public function slider($user_id = null) 
	{
		$this->loadModel('Admin.AdminClientSlider');
		
		$this->paginate = array(		
				'limit' => 10,
				'conditions' => array('AdminClientSlider.user_id'=>$user_id),
				'order' => array('AdminClientSlider.id' => 'desc')			
				);		
		$records = $this->paginate('AdminClientSlider');
		
		$this->set(compact('records', 'user_id'));
	}
/**
 * Name : User website slider add new image
 * Created : 21 Jan 2014
 * Purpose : User add new image action.
 * Author : Deepak Sharma
 */
	public function slider_image_add($user_id = null) 
	{
		if ($this->request->data)
		{				
			$this->loadModel('AdminClientSlider');
			
			$image_array = $this->request->data['AdminClientSlider']['image'];
			$user_id = $this->request->data['AdminClientSlider']['user_id'];
			$image_info = pathinfo($image_array['name']);
			$image_new_name = $image_info['filename'].time().'_'.$user_id;
			
			$thumbnails = Thumbnail::slider_thumbs();			
			$this->Uploader->upload($image_array, SLIDER, $thumbnails, $image_new_name, array(), array('width'=>740, 'height'=>300,'max_width'=>1024, 'max_height'=>960) );
		
			if ( $this->Uploader->error )
			{
				$file_error = $this->Uploader->errorMessage;
				$this->flash_new( __('Error occured while uploading image'), 'error-messages' );
				$this->flash_new( $file_error, 'error-messages' ); 						
			}
			else
			{							
				$this->request->data['AdminClientSlider']['image'] = $this->Uploader->filename;
				
				if($this->AdminClientSlider->save($this->request->data))
				{	
					//$this->Session->setFlash(__('The user has been saved'));
					if ( !$this->Uploader->error )
						$this->flash_new( __('Image uploaded successfully.'), 'success-messages' ); 
					$this->redirect(array('action' => 'slider', $user_id));
				}
				else
				{
					//$this->Session->setFlash(__('User added successfully. But error occured while uploading image'));	
					$this->flash_new( __('Data not saved'), 'error-messages' );
					$this->redirect(array('action' => 'slider_add_image'));
				}
			}
			
		}
		$this->set(compact('user_id'));
	}
/**
 * Name : User website slider edit image
 * Created : 21 Jan 2014
 * Purpose : User add new image action.
 * Author : Deepak Sharma
 */
	public function slider_image_edit($image_id = null) 
	{
		$this->loadModel('AdminClientSlider');
		$image = $this->AdminClientSlider->read('', $image_id);
		
		if (empty($image)) 
		{
			throw new NotFoundException(__('Invalid image'));
		}
		if ($this->request->data)
		{				
			$this->loadModel('AdminClientSlider');
			
			$old_image = $this->request->data['AdminClientSlider']['old_image'];
			$image_array = $this->request->data['AdminClientSlider']['slider_image'];
			$user_id = $this->request->data['AdminClientSlider']['user_id'];
			
			if(!empty($image_array['name'])) {
				
				$image_info = pathinfo($image_array['name']);
				$image_new_name = $image_info['filename'].time().'_'.$user_id;
				
				$thumbnails = Thumbnail::slider_thumbs();			
				
				$this->Uploader->upload($image_array, SLIDER, $thumbnails, $image_new_name, array(), array('width'=>740, 'height'=>300,'max_width'=>1024, 'max_height'=>960) );
			
				if ( $this->Uploader->error )
				{
					$file_error = $this->Uploader->errorMessage;
					$this->flash_new( __('Error occured while uploading image'), 'error-messages' );
					$this->flash_new( $file_error, 'error-messages' ); 						
				}
				else
				{							
					$this->request->data['AdminClientSlider']['image'] = $this->Uploader->filename;
					
					if(trim($old_image) !== '' && file_exists(SLIDER.$old_image)) {
						unlink(SLIDER.$old_image);
						unlink(SLIDER.LARGE.$old_image);
						unlink(SLIDER.LARGESLIDER.$old_image);
					}
				}
			}
			
			if($this->AdminClientSlider->save($this->request->data))
			{	
				//$this->Session->setFlash(__('The user has been saved'));
				if ( !$this->Uploader->error )
					$this->flash_new( __('Image uploaded successfully.'), 'success-messages' ); 
				$this->redirect(array('action' => 'slider',$user_id));
			}
			else
			{
				//$this->Session->setFlash(__('User added successfully. But error occured while uploading image'));	
				$this->flash_new( __('Data not saved'), 'error-messages' );
				$this->redirect(array('action' => 'slider_add_image'));
			}
		}
		$this->request->data = $image;
		
	}
	
	/**
	 * Name : User website slider delete image
	 * Created : 29 April 2014
	 * Purpose : User delete slider image action.
	 * Author : Abhishek
	 */
	public function slider_delete($image_id = null)
	{
		$this->loadModel('AdminClientSlider');
		$image = $this->AdminClientSlider->read('', $image_id);
		$user_id = $this->Auth->user('id');
		if (empty($image))
		{
			throw new NotFoundException(__('Invalid image'));
		}
		else if($user_id != $image['AdminClientSlider']['user_id'])
		{
			throw new NotFoundException(__('Invalid Access'));
		}
		else
		{
			$old_image = $image['AdminClientSlider']['image'];
			$this->AdminClientSlider->id = $image_id;
			if($this->AdminClientSlider->delete())
			{
				if(trim($old_image) !== '' && file_exists(SLIDER.$old_image)) {
					unlink(SLIDER.$old_image);
					unlink(SLIDER.LARGE.$old_image);
					unlink(SLIDER.LARGESLIDER.$old_image);
				}
				$this->flash_new( __('Slider Image deleted successfully.'), 'success-messages' );
			}
			else
			{
				$this->flash_new( __('Slider Image not deleted, Please try again'), 'error-messages' );
			}
		}
	$this->redirect(array('action' => 'slider',$user_id));
	}
	
	/**
	 * Name : User website  delete deal
	 * Created : 29 April 2014
	 * Purpose : User delete deal action.
	 * Author : Abhishek
	 */
	public function deal_delete($deal_id = null)
	{
		$this->loadModel('AdminClientDeal');
		$image = $this->AdminClientDeal->read('', $deal_id);
		$user_id = $this->Auth->user('id');
		if (empty($image))
		{
			throw new NotFoundException(__('Invalid deal'));
		}
		else if($user_id != $image['AdminClientDeal']['user_id'])
		{
			throw new NotFoundException(__('Invalid Access'));
		}
		else
		{
			$old_image = $image['AdminClientDeal']['image'];
			$this->AdminClientDeal->id = $deal_id;
			if($this->AdminClientDeal->delete())
			{
				if(trim($old_image) !== '' && file_exists(DEAL.$old_image))
				{
					unlink(DEAL.$old_image);
					unlink(DEAL.LARGE.$old_image);
				}
				$this->flash_new( __('Deal deleted successfully.'), 'success-messages' );
			}
			else
			{
				$this->flash_new( __('Deal not deleted, Please try again'), 'error-messages' );
			}
		}
		$this->redirect(array('action' => 'deals',$user_id));
	}
	
	/**
	 * Name : User website  delete deal
	 * Created : 29 April 2014
	 * Purpose : User delete deal action.
	 * Author : Abhishek
	 */
	public function client_appointment_delete($appointment_id = null)
	{
		$this->loadModel('UserAppointment');
		$image = $this->UserAppointment->read('', $appointment_id);
		$user_id = $this->Auth->user('id');
		if (empty($image))
		{
			throw new NotFoundException(__('Invalid appointment'));
		}/*
		else if($user_id != $image['UserAppointment']['user_id'])
		{
			throw new NotFoundException(__('Invalid Access'));
		}*/
		else
		{
			$this->UserAppointment->id = $appointment_id;
			if($this->UserAppointment->delete())
			{
				if($image['UserAppointment']['contact_type'] == '3')
					$text = 'Document';
				else if($image['UserAppointment']['contact_type'] == '2')
					$text = 'Contact request';
				else
					$text = 'Appointment';
				$this->flash_new( __($text.' deleted successfully.'), 'success-messages' );
			}
			else
			{
				$this->flash_new( __($text.'Appointment not deleted, Please try again'), 'error-messages' );
			}
		}
		$this->redirect($this->referer());
	}
	
	/**
	* Purpose : To create a hash password for admin 
	* Inputs: password
	* Output : Hash Password
	* Author: Prakhar Johri
	* Created On : 31 Oct 2013 
	**/
	public function hash_password()
	{
			
		 if ($this->request->is('post')) 
		 {
           if(!empty($this->request->data['Admin']['password']))
		   {
		 		 $hash_password = AuthComponent::password($this->request->data['Admin']['password']);  	
		   		 $this->Session->setFlash(__('Your hash password is '.$hash_password));
		   }
		   else 
		   {
			   $this->Session->setFlash(__('Password field should not be empty'));
		   }
         }	
	}

	/**
	 * Purpose : For change admin password
	 * Input : 
	 * Created on : 9-Nov-2013
	 * Author : Prakhar
	*/			
	function change_password() 
	{
		$errors = '';
		if(!empty($this->data))
		{
			$old_password = Security::hash(Configure::read('Security.salt').$this->data['Admin']['old_password']);
			
			$new_password = Security::hash(Configure::read('Security.salt').$this->data['Admin']['password']);
			$row = $this->Admin->findById($this->Auth->user('id'));
			if(!empty($row))
			{
				$row = $row['Admin'];
				
				if($row['password'] == $old_password)
				{
					$this->Admin->id = $this->Auth->user('id');
					
					$this->Admin->saveField('password', $new_password);					
					$this->flash_new( __('Password updated successfully'), 'success-messages' );
					$this->redirect($this->referer());
				}
				else
				{					
					$this->flash_new( __('Please enter correct old password'), 'error-messages' );
				}
			}
			else
			{
				$this->flash_new( __('Sorry, not able to change the password'), 'error-messages' );
			}
		}
		$this->set('view_title', 'Change Password');
		$this->set('show_pass_field', true);
		$this->set('errors', $errors);
	}
	
	function suggest_username()
	{
		if($this->request->is('ajax'))
		{
			$response = array();
			if($this->request->is('get'))
			{
				$this->loadModel('Admin');
				$user_name = trim($this->request->query['f_name'].$this->request->query['l_name']);
				$username_count = $this->Admin->find('count', array(
														'conditions'=>array('Admin.username LIKE'=> '%'.$user_name.'%')
													)	
											);
				
				if($username_count == 0)
				{
					$suggestion = $user_name;
				}
				else 
				{
					$suggestion = $user_name.'_'.$username_count;
				}
				$response = array('status'=>'ok', 'data'=>trim($suggestion));
			}
			else 
			{
				$response = array('status'=>'error', 'data'=>'Invalid request');
			}
			echo json_encode($response); die;
		}
		else 
		{
			$this->redirect($this->referer());
		}
	}
	
	function check_username($ad_id='')
	{
		if($this->request->is('ajax'))
		{
			$response = false;
			
			if($this->request->is('get'))
			{
				$this->loadModel('Admin');
				$string = trim($this->request->query['search_string']);
				switch($this->request->query['type'])
				{
					case 'username':						
						$record_count = $this->Admin->find('count', array(
														'conditions'=>array('Admin.username'=>$string,'Admin.id != ' => $this->Auth->user('id'), 'Admin.id !=' => $ad_id)
													)
												);
					break;
					case 'email':						
						$record_count = $this->Admin->find('count', array(
														'conditions'=>array('Admin.email'=>$string,'Admin.id != ' => $this->Auth->user('id'), 'Admin.id !=' => $ad_id)
													)
												);
					break;
					case 'company_name':						
						$record_count = $this->Admin->find('count', array(
														'conditions'=>array('Admin.company'=>$string,'Admin.id != ' => $this->Auth->user('id'), 'Admin.id !=' => $ad_id)
													)
												);
					break;
					case 'website_url':						
						$record_count = $this->Admin->find('count', array(
														'conditions'=>array('Admin.website_url'=>$string,'Admin.id != ' => $this->Auth->user('id'), 'Admin.id !=' => $ad_id)
													)
												);
					break;
					case 'tablet_url':					
						$record_count = $this->Admin->find('count', array(
														'conditions'=>array('Admin.tablet_url'=>$string,'Admin.id != ' => $this->Auth->user('id'), 'Admin.id !=' => $ad_id)
													)
												);
					break;
					default: 
						$record_count = 1;
				}	
				
				if($record_count == 0)
				{
					$response = true;
				}
				
				echo json_encode($response);die;
			}
			else
			{
				echo json_encode($response);die;
			}
			
		}
		else
		{
			$this->redirect($this->referer());
		}
	}
	
/**
 * Name : View profile to client-user
 * Created : 21 Jan 2014
 * Purpose : User view action.
 * Author : Deepak Sharma
 */
	public function profile($id = null) 
	{
		$this->loadModel('Admin.Admin');
		
		if (!$this->Admin->exists($id)) 
		{
			throw new NotFoundException(__('Invalid user'));
		}		
		$options = array('conditions' => array('Admin.' . $this->Admin->primaryKey => $id));
		$user_info = $this->Admin->find('first', $options);
		
		$this->set(compact('user_info'));
		//$this->render('add');
	}
/**
 * Name : Client deals 
 * Created : 23 Jan 2014
 * Purpose : User slider action.
 * Author : Deepak Sharma
 */
	public function deals($user_id = null) 
	{
		$this->loadModel('Admin.AdminClientDeal');
		$this->AdminClientDeal->bindModel(array(
				'belongsTo'=>array(					
					'Admin'=>array(
						'className'=>'Admin',
						'foreignKey'=>'user_id',
						'type'=>'INNER',
						'fields'=>array(
									'id', 'first_name', 'last_name', 'website_url', 'tablet_url','company', 'mobile', 'twitter_url', 'fb_fanpage_id'
									
								)
					)
				)
			)
		);
		$this->paginate = array(		
				'limit' => 10,
				'conditions' => array('AdminClientDeal.user_id'=>$user_id),
				'order' => array('AdminClientDeal.created' => 'desc')			
				);		
		$records = $this->paginate('AdminClientDeal');
		//echo '<pre>'; print_r($records); die;
		$this->set(compact('records', 'user_id'));
	}
/**
 * Name : Client add new deal
 * Created : 23 Jan 2014
 * Purpose : Client can add new deals.
 * Author : Deepak Sharma
 */
	public function deal_add($user_id = null) 
	{
		if ($this->request->data)
		{	//pr($this->data); die;
			$this->loadModel('AdminClientDeal');			
			$user_id = $this->request->data['AdminClientDeal']['user_id'];
			$error = 0;
			if(!empty( $this->request->data['AdminClientDeal']['image']['name']))
			{
				$image_array = $this->request->data['AdminClientDeal']['image'];	
				$image_info = pathinfo($image_array['name']);
				$image_new_name = $image_info['filename'].time().'_'.$user_id;
				
				$thumbnails = Thumbnail::slider_thumbs();	
				$params = array('size'=>'500');		
				$this->Uploader->upload($image_array, DEAL, $thumbnails, $image_new_name, $params );
			
				if ( $this->Uploader->error )
				{
					$error++;
					$file_error = $this->Uploader->errorMessage;					
					$this->flash_new( __('Error occured while uploading image'), 'error-messages' );
					$this->flash_new( $file_error, 'error-messages' ); 						
				}
				else
				{							
					$this->request->data['AdminClientDeal']['image'] = $this->Uploader->filename;
					$this->Uploader->filename = '';
				}
			}
			else
			{
				$this->request->data['AdminClientDeal']['image'] = $this->Uploader->filename;
			}
				
			if(!empty( $this->request->data['AdminClientDeal']['slider_image']['name']))
			{
				$image_array = $this->request->data['AdminClientDeal']['slider_image'];
				$image_info = pathinfo($image_array['name']);
				$image_new_name = $image_info['filename'].time().'_'.$user_id;
				$thumbnails = false;
				
				$this->Uploader->upload($image_array, DEALSLIDER, $thumbnails, $image_new_name );
			
				if ( $this->Uploader->error )
				{
					$error++;
					$file_error = $this->Uploader->errorMessage;
					$this->flash_new( $file_error, 'error-messages' ); 	
					$this->request->data['AdminClientDeal']['slider_image'] = '';					
				}
				else
				{	
					$this->loadModel('AdminIcon');
					$icon['AdminIcon']['user_id'] = $user_id;
					$icon['AdminIcon']['image'] = $this->Uploader->filename;
					$this->AdminIcon->save($icon);
					$this->request->data['AdminClientDeal']['deal_icon'] = $this->AdminIcon->getlastInsertID();
					$this->Uploader->filename = '';
				}	
			}
			else
			{
				$this->request->data['AdminClientDeal']['slider_image'] = '';
			}
			
			if($this->request->data['AdminClientDeal']['is_custom_post_message'] == 0)
			{
				$this->request->data['AdminClientDeal']['fb_post_message'] = '';
				$this->request->data['AdminClientDeal']['tw_post_message'] = '';
				$this->request->data['AdminClientDeal']['fanpage_message'] = '';
			}
			
			if($error == 0 && $this->AdminClientDeal->save($this->request->data))
			{						
				$this->flash_new( __('Deal added successfully.'), 'success-messages' ); 
				$this->redirect(array('action' => 'deals', $user_id));
			}
			else
			{
							
				$this->flash_new( __('Data not saved'), 'error-messages' );					
			}			
		}
		$this->loadModel('AdminIcon');
		$icons = $this->AdminIcon->find('all', array('conditions'=>array('AdminIcon.user_id'=>array(1, $user_id))));
		
		$user = $this->Admin->find('first',array('conditions' => array('Admin.id'=>$user_id),
												 'fields' => array('Admin.company','Admin.mobile','Admin.website_url','Admin.tablet_url',
												 					'Admin.first_name','Admin.last_name','Admin.twitter_url')));
		$this->set(compact('user_id', 'icons', 'user'));
	}
/**
 * Name : Client edit deal
 * Created : 23 Jan 2014
 * Purpose : Client can edit his existing deals here.
 * Author : Deepak Sharma
 */	
	public function deal_edit($deal_id = null) 
	{
		$this->loadModel('AdminClientDeal');
		$deal = $this->AdminClientDeal->read('', $deal_id);
		
		if (empty($deal)) 
		{
			throw new NotFoundException(__('Invalid deal'));
		}
		if ($this->request->data)
		{		
			$user_id = $this->request->data['AdminClientDeal']['user_id'];
			$old_image = $this->request->data['AdminClientDeal']['old_image'];
			$errors = 0;
			if(!empty( $this->request->data['AdminClientDeal']['deal_image']['name']))
			{
				
				$image_array = $this->request->data['AdminClientDeal']['deal_image'];				
						
				$image_info = pathinfo($image_array['name']);
				$image_new_name = $image_info['filename'].time().'_'.$user_id;
				
				$thumbnails = Thumbnail::slider_thumbs();	
				$params = array('size'=>'500');		
				$this->Uploader->upload($image_array, DEAL, $thumbnails, $image_new_name, $params );
			
				if ( $this->Uploader->error )
				{
					$errors++;
					$file_error = $this->Uploader->errorMessage;
					$this->flash_new( __('Error occured while uploading image'), 'error-messages' );
					$this->flash_new( $file_error, 'error-messages' ); 						
				}
				else
				{							
					$this->request->data['AdminClientDeal']['image'] = $this->Uploader->filename;
					$this->Uploader->filename = '';
					
					if(trim($old_image) !== '' && file_exists(DEAL.$old_image)) {
						unlink(DEAL.$old_image);
						unlink(DEAL.LARGE.$old_image);
					}
				}
				
			}
			else
			{
				$this->request->data['AdminClientDeal']['image'] = $old_image;
			}
			
			if(!empty( $this->request->data['AdminClientDeal']['slider_image']['name']))
			{				
				$image_array1 = $this->request->data['AdminClientDeal']['slider_image'];
				$image_info = pathinfo($image_array1['name']);
				$image_new_name = $image_info['filename'].time().'_'.$user_id;
				$thumbnails = false;
				
				$this->Uploader->upload($image_array1, DEALSLIDER, $thumbnails, $image_new_name );
			
				if ( $this->Uploader->error )
				{
					$errors++;
					$file_error = $this->Uploader->errorMessage;
					$this->flash_new( $file_error, 'error-messages' ); 	
					$this->request->data['AdminClientDeal']['slider_image'] = '';					
				}
				else
				{							
					$this->loadModel('AdminIcon');
					$icon['AdminIcon']['user_id'] = $user_id;
					$icon['AdminIcon']['image'] = $this->Uploader->filename;
					$this->AdminIcon->save($icon);
					$this->request->data['AdminClientDeal']['deal_icon'] = $this->AdminIcon->getlastInsertID();
					$this->Uploader->filename = '';
				}	
			}
			
			//pr($this->request->data);die;
			if($errors == 0 && $this->AdminClientDeal->save($this->request->data))
			{					
				$this->flash_new( __('Data updated successfully.'), 'success-messages' ); 
				$this->redirect(array('action' => 'deals', $user_id));
			}
			else
			{
				$this->flash_new( __('Data not saved'), 'error-messages' );
			}
		}
		$this->loadModel('AdminIcon');
		$icons = $this->AdminIcon->find('all', array('conditions'=>array('AdminIcon.user_id'=>array(1, $deal['AdminClientDeal']['user_id']))));
		
		$this->request->data = $deal;	
		
		$admin = $this->Admin->find('first',array('conditions' => array('Admin.id'=>$deal['AdminClientDeal']['user_id']),
												 'fields' => array('Admin.company','Admin.mobile','Admin.website_url','Admin.tablet_url',
												 					'Admin.first_name','Admin.last_name','Admin.twitter_url')));
		
		$record = $deal;
		$record['Admin'] = $admin['Admin'];
		//pr($deal); die;
		
		$this->set(compact('icons','record'));	
	}
/**
 * Name : Client appointments with users(Customers)
 * Created : 24 Jan 2014
 * Purpose : listing of all appointment of client with users(Customers)
 * Author : Deepak Sharma
 */
	public function client_appointments($user_id = null) 
	{
		$this->loadModel('UserAppointment');
		
		$this->UserAppointment->bindModel(
			array(
				'belongsTo'=>array(
					'User'=>array(
						'className'=>'User',
						'foreignKey'=>'user_id',
						'fields'=>array('first_name', 'last_name', 'email')
					)
				)
			)
		);
		$this->paginate = array(		
					'limit' => 10,
					'conditions' => array('UserAppointment.client_id'=>$user_id, 'UserAppointment.contact_type' => '1'),
					'order'	=> array('UserAppointment.created' => 'desc')	
				);		
		$records = $this->paginate('UserAppointment');		
		
		$this->set(compact('records', 'user_id'));
	}

	/**
	 * Name : Client contact request with users(Customers)
	 * Created : 20 June 2014
	 * Purpose : listing of all appointment contact request of client with users(Customers)
	 * Author : Vivek Sharma
	 */
		public function client_contact_requests($user_id = null) 
		{
			$this->loadModel('UserAppointment');
			
			$this->UserAppointment->bindModel(
				array(
					'belongsTo'=>array(
						'User'=>array(
							'className'=>'User',
							'foreignKey'=>'user_id',
							'fields'=>array('first_name', 'last_name', 'email')
						)
					)
				)
			);
			$this->paginate = array(		
						'limit' => 10,
						'conditions' => array('UserAppointment.client_id'=>$user_id, 'UserAppointment.contact_type' => '2'),
						'order' => array('UserAppointment.created' => 'desc')			
					);		
			$records = $this->paginate('UserAppointment');		
			
			$this->set(compact('records', 'user_id'));
		}
		
		
	/**
	 * Name : Client contact respond
	 * Created : 22 July 2014
	 * Purpose : Respons to front end users contact requests
	 * Author : Vivek Sharma 
	 */
		public function client_contact_respond($request_id = null) 
		{
			$this->loadModel('UserAppointment');
			
			if ( !empty($this->data) )
			{
				$request = $this->UserAppointment->findById($this->data['UserAppointment']['request_id']);
				
				$data = $this->data;
				$data['UserAppointment']['contact_type'] = '4';
				$data['UserAppointment']['created'] = date('Y-m-d H:i:s');
				
				$this->UserAppointment->create();
				if ( $appointment = $this->UserAppointment->save($data) )
				{
					/**Send email to user*/				
					$email = new CakeEmail('smtp'); 		
					$email->from($this->Auth->user('email'));
					$email->replyTo($this->Auth->user('email'));			
					$email->to($request['UserAppointment']['email']);
					$email->subject($appointment['UserAppointment']['subject']);
					$email->emailFormat('html');
					
					$email->send($appointment['UserAppointment']['message']);
					
					$this->UserAppointment->id = $request['UserAppointment']['id'];
					$this->UserAppointment->save(array('response_id' => $appointment['UserAppointment']['id']));
					
					$this->flash_new( __('Response sent successfully.'), 'success-messages' ); 
					$this->redirect(array('action' => 'client_contact_requests', $this->Auth->user('id')));
				}
			}
						
			$request = $this->UserAppointment->find('first', array('conditions' => array('UserAppointment.id' => $request_id)));		
			$this->set(compact('request'));
		}

	/**
	 * Name : Client document upload request with users(Customers)
	 * Created : 20 June 2014
	 * Purpose : listing of all appointment document upload request of client with users(Customers)
	 * Author : Vivek Sharma Sharma
	 */
		public function client_document_upload_requests($user_id = null) 
		{
			$this->loadModel('UserAppointment');
			
			$this->UserAppointment->bindModel(
				array(
					'belongsTo'=>array(
						'User'=>array(
							'className'=>'User',
							'foreignKey'=>'user_id',
							'fields'=>array('first_name', 'last_name', 'email')
						)
					)
				)
			);
			$this->paginate = array(		
						'limit' => 10,
						'conditions' => array('UserAppointment.client_id'=>$user_id, 'UserAppointment.contact_type' => '3')			
					);		
			$records = $this->paginate('UserAppointment');		
			
			$this->set(compact('records', 'user_id'));
		}
		
		
/**
 * Name : client_appointment_edit
 * Created : 27 Jan 2014
 * Purpose : Client can edit final appointment date here.
 * Author : Deepak Sharma
 */	
	public function client_appointment_edit($appointment_id = null) 
	{
		$this->loadModel('UserAppointment');
		
		if ($this->request->data)
		{	
			$client_id = $this->request->data['UserAppointment']['client_id'];
			
			if($this->request->data['UserAppointment']['final_date'] == '0')
			{
				$time = $this->request->data['UserAppointment']['other_time']['hour'].':'.
								$this->request->data['UserAppointment']['other_time']['min'].' '.
										strtoupper($this->request->data['UserAppointment']['other_time']['meridian']);
				$this->request->data['UserAppointment']['final_date'] = $this->request->data['UserAppointment']['other_date'].' '.$time;
			}
			
			if($this->UserAppointment->save($this->request->data))
			{
				$this->loadModel('User');
				$user = $this->User->findById($this->request->data['UserAppointment']['user_id']);
				
				/**Send email to user informing final appointment date*/				
				$final_date = $this->request->data['UserAppointment']['final_date'];
				$arr = array();
				$arr['to_email'] = $user['User']['email'];
				$arr['email_subject'] = 'Appointment final date notification';
				$arr_keys = array('{username}','{site_name}','{final_date}');
				$arr_values = array(ucwords($user['User']['first_name'].' '.$user['User']['last_name']), SITE_NAME, $final_date);
				
				$this->send_email(array(SITE_EMAIL => SITE_NAME), SITE_EMAIL, null, $arr, $arr_keys, $arr_values, 'user_appointment_finaldate');
				
				$this->flash_new( __('Appointment Update successfully. An email is sent to user regarding final date'), 'success-messages' ); 
				$this->redirect(array('action' => 'client_appointments', $client_id));
			}
			else
			{
				$this->flash_new( __('Data not saved'), 'error-messages' );
			}
		}
		
		$appointments = $this->UserAppointment->read('', $appointment_id);
		
		if (empty($appointments)) 
		{
			throw new NotFoundException(__('Invalid appointment'));
		}
		$check_field = array('first_choice', 'second_choice', 'third_choice', 'final_date');
		$final_date = array();
	
		foreach($appointments['UserAppointment'] as $key=>$appoint)
		{
			if(in_array($key, $check_field) && !empty($key) && !empty($appoint)) {
			
				$final_date[$appoint] = $appoint;
			}
		}
		
		$final_date[0] = 'Other';
		$this->set(compact('final_date'));
		$this->request->data = $appointments;		
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
	
	
/**
 * Name : Client deals report
 * Created : 12 Feb 2014
 * Purpose : generate the detail of client deals
 * Author : Deepak Sharma
 */
	public function deal_report() 
	{
		$this->loadModel('Admin.AdminClientDeal');
		//This section handles search
		$conditions = '';
		if(isset($_GET['filter']))
		{
			if($_GET['filter'] == 'title')
			{
				$conditions = array('AdminClientDeal.'.$_GET['filter'].' Like' => $_GET['search_keyword'].'%');
			}
			if($_GET['filter'] == 'company')
			{	
				$conditions = array('Admin.'.$_GET['filter'].' Like' => $_GET['search_keyword'].'%');
			}		
			
		}	
		$this->AdminClientDeal->virtualFields = array(
			'total_friend_view'=>'SELECT SUM(AdminClientDealShare.friend_count) from admin_client_deal_shares as AdminClientDealShare where AdminClientDealShare.deal_id = AdminClientDeal.id and AdminClientDealShare.status = "posted"',
			'share'=>'SELECT COUNT(*) from admin_client_deal_shares as AdminClientDealShare where AdminClientDealShare.deal_id = AdminClientDeal.id and AdminClientDealShare.status = "posted"'
		);
		
		$this->AdminClientDeal->bindModel(array(
				'belongsTo'=>array(
					'Admin'=>array(
						'className'=>'Admin',
						'foreignKey'=>'user_id',						
						'fields'=>array(
							'id', 'company'
						),
						'type'=>'INNER',
						
					)
				)
			),
			false
		);
		//pr($conditions);die;
		$this->paginate = array(	
					'conditions'=>$conditions,
					'limit' => 10
				);		
		$records = $this->paginate('AdminClientDeal');
		$this->AdminClientDeal->unbindModel(array('belongsTo'=>array('Admin')));
		$this->set(compact('records'));
	}
/* Name : deal_report_view
 * Created : 12 Feb 2014
 * Purpose : generate the detail of on client specific deal
 * Author : Deepak Sharma
 */
	public function deal_report_view($deal_id = NULL) 
	{
		$this->loadModel('Admin.AdminClientDealShare');
		
		$this->AdminClientDealShare->bindModel(array(
				'belongsTo'=>array(
					'User'=>array(
						'className'=>'User',
						'foreignKey'=>'user_id',
						'fields'=>array(
							'id', 'email', 'first_name', 'last_name'
						),
						'type'=>'INNER'
					)
				)
			)
		);
		$this->paginate = array(
					'conditions'=>array(
						'deal_id'=>$deal_id,
						'AdminClientDealShare.status'=>'posted'
					),
					'limit' => 10
				);		
		$records = $this->paginate('AdminClientDealShare');
		
		$this->set(compact('records'));
	}
	
	/**
 * Name : Client deals report
 * Created : 12 Feb 2014
 * Purpose : generate the detail of client deals
 * Author : Deepak Sharma
 */
	public function deal_report_client() 
	{
		$this->loadModel('Admin.AdminClientDeal');
		//This section handles search
		$conditions = array();
		if(isset($_GET['filter']))
		{
			if($_GET['filter'] == 'title')
			{
				$conditions = array('AdminClientDeal.'.$_GET['filter'].' Like' => $_GET['search_keyword'].'%');
			}
		}	
		$this->AdminClientDeal->virtualFields = array(
			'total_friend_view'=>'SELECT SUM(AdminClientDealShare.friend_count) from admin_client_deal_shares as AdminClientDealShare where AdminClientDealShare.deal_id = AdminClientDeal.id and AdminClientDealShare.status = "posted"',
			'share'=>'SELECT COUNT(*) from admin_client_deal_shares as AdminClientDealShare where AdminClientDealShare.deal_id = AdminClientDeal.id and AdminClientDealShare.status = "posted"'
		);		
		
		
		$this->paginate = array(	
					'conditions'=>array_merge(array('AdminClientDeal.user_id'=>$this->Auth->user('id')), $conditions),
					'limit' => 10
				);		
		$records = $this->paginate('AdminClientDeal');
		
		$this->AdminClientDeal->unbindModel(array('belongsTo'=>array('Admin')));
		$this->set(compact('records'));
	}
	
/* Name : deal_report_view
 * Created : 12 Feb 2014
 * Purpose : generate the detail of on client specific deal
 * Author : Deepak Sharma
 */
	public function deal_report_client_view($deal_id = NULL) 
	{
		$this->loadModel('Admin.AdminClientDealShare');
		
		$this->AdminClientDealShare->bindModel(array(
				'belongsTo'=>array(
					'User'=>array(
						'className'=>'User',
						'foreignKey'=>'user_id',
						'fields'=>array(
							'id', 'email', 'first_name', 'last_name'
						),
						'type'=>'INNER'
					)
				)
			)
		);
		$this->paginate = array(
					'conditions'=>array(
						'deal_id'=>$deal_id,
						'AdminClientDealShare.status'=>'posted'
					),
					'limit' => 10
				);		
		$records = $this->paginate('AdminClientDealShare');
		//pr($records);die;
		$this->set(compact('records'));
	}
	
	/**
 * Name : User website crop slider  image
 * Created : 17 feb 2014
 * Purpose : User crop image action.
 * Author : Deepak Sharma
 */
	public function slider_crop_image($image_id = null) 
	{
		$this->loadModel('AdminClientSlider');
		$this->layout = null;
		$slider_Data = $this->AdminClientSlider->read('image, user_id', $image_id);
	
		if (empty($slider_Data)) 
		{
			throw new NotFoundException(__('Invalid image'));
		}
		if ($this->request->data)
		{				
			if ( !empty($this->request->data['source_file']) )
			{
				$user_id = $this->Auth->user('id');
				$source_path = SLIDER . $this->request->data['source_file'];
				$dest_dir = SLIDER; 
							
				$filedata = array(
					'source_path' => $source_path,
					'dest_dir' => $dest_dir,
					'file_name' => LARGESLIDER.$this->request->data['source_file']
				);
				$file_dimension = array(
					'width' => $this->request->data['w'],
					'height' => $this->request->data['h'],
					'x' => $this->request->data['x'],
					'y' => $this->request->data['y']
				);
				
				$this->Uploader->crop( $filedata, $file_dimension, false , array('remove'=>false) );
				
				if ( $this->Uploader->error )
				{
					$resObj['error'] = $this->Uploader->errorMessage;
				}
				else
				{
					$this->flash_new( __('Image updated successfully.'), 'success-messages' ); 
					$this->redirect(array('action' => 'slider', $this->request->data['user_id']));
				}
			}
			else
			{
				$resObj['error'] = __('ERROR: source file was not exists');
			}
		}	
	
		$this->set(compact('slider_Data'));
		
	}
	
	/**
	 * Purpose : For Forget admin password
	 * Input : 
	 * Created on : 9-Nov-2013
	 * Author : Prakhar
	*/			
	function forget_password() 
	{
		$errors = '';
		$this->loadModel('Setting');
		$settings = $this->Setting->findByKey('site_setting');
		$setting_data = json_decode($settings['Setting']['value'],true);
		$Setting = $setting_data['Settings'];
		if(!empty($this->data))
		{
			$request_email = $this->data['Admin']['username'];
			
			$row = $this->Admin->findByUsername($request_email);
			if(!empty($row))
			{
				$row = $row['Admin'];
				$generate_password = generateRandStr(8);
				
				//Send email with new password
				
				$token = array('{email}','{domain}','{username}','{first_name}','{last_name}','{password}');
				$token_value = array($row['email'],$Setting['from_name'],$row['username'],$row['first_name'],$row['last_name'],$generate_password);
				$this->_send_email($row['email'] , $token, $token_value, 'EMAIL_FORGOTPASSWORD' , $Setting);
						
				//end send mail
				
				$new_password = Security::hash(Configure::read('Security.salt').$generate_password);
				$this->Admin->id = $row['id'];
				$this->Admin->saveField('password', $new_password);					
				$this->flash_new( __('Password sent to your email address. Please check your mail.'), 'success-messages' );
				return $this->redirect(array('controller'=>'users', 'action'=>'login'));	
				
			}
			else
			{
				$this->flash_new( __('Sorry, Please enter the valid username'), 'error-messages' );
			}
		}
		$this->set('view_title', 'Forget Password');
		$this->set('show_pass_field', true);
		$this->set('errors', $errors);
		$this->render('forget_password');
	}
	
/* Name : user_visit_report
 * Created : 28 Feb 2014
 * Purpose : generate the detail of user visits
 * Author : Deepak Sharma
 */
	public function user_visit_report() 
	{
		
		$this->loadModel('Admin');
		$conditions = array('Admin.id !='=>1);		
		
		//This section handles search
		if(isset($_GET['filter']))
		{
			$conditions = array_merge($conditions, array('Admin.'.$_GET['filter'].' Like ' => $_GET['search_keyword'].'%'));
		}	
		$this->paginate = array(		
					'limit' => 10,
					'conditions' => $conditions,
					'fields'=>array('first_name', 'last_name', 'email', 'total_visit', 'facebook_visit', 'twitter_visit', 'other_visit')			
				);			
		$users = $this->paginate('Admin');
		
		$this->set('users', $users);		

	}
	
/* Name : client_user_visit_report
 * Created : 28 Feb 2014
 * Purpose : generate the detail of user visits for specific client
 * Author : Deepak Sharma
 */
	public function client_user_visit_report() 
	{
		
		$this->loadModel('Admin');
			
		$conditions = array(		
					'limit' => 10,
					'conditions' => array('Admin.id'=>$this->Auth->user('id')),
					'fields'=>array('first_name', 'last_name', 'email', 'total_visit', 'facebook_visit', 'twitter_visit', 'other_visit')			
				);			
		$user = $this->Admin->find('first', $conditions);
		
		$this->set('user', $user);		

	}
	
	
	/**
	 * Name : Index
	 * Purpose : index function for subadmin users. Display subadmin user listing and other filters
	 * Created : 6 June 2014	 
	 * Author : Vivek Sharma
	 */ 
	public function subadmin_index()
	{	
		$this->loadModel('Admin');
		$conditions = array('Admin.type'=>3);
		
		//This section handles multipe delete and change status
		if(isset($this->request->data['option']) && !empty($this->request->data['option']))
		{
			if(!empty($this->request->data['ids']))
			{
				switch($this->request->data['option'])
				{
					case "delete":
						$this->Admin->deleteAll(array('id' => $this->request->data['ids']));					
						$this->flash_new( __('Selected users deleted successfully'), 'success-messages' );
					break;
					case "active":
						$this->Admin->updateAll(array('status' => "'active'"), array('id' =>  $this->request->data['ids'] ));
						$this->flash_new( __('Selected sub-admins activated successfully'), 'success-messages' );
					break;
					case "deactive":
						$this->Admin->updateAll(array('status' => "'inactive'"), array('id' =>  $this->request->data['ids'] ));
						$this->flash_new( __('Selected sub-admins deactivated successfully'), 'success-messages' );
					break;
				}
			}
			else{
				$this->flash_new( __('Please select user to perform action.'), 'error-messages' );
			}
		}
	
		//This section handles search
		if(isset($_GET['filter']))
		{
			$conditions = array_merge($conditions, array('Admin.'.$_GET['filter'].' Like ' => $_GET['search_keyword'].'%'));
		}	
		$this->paginate = array(		
					'limit' => 10,
					'conditions' => $conditions,
					'order' => array('Admin.id' => 'desc')					
				);			
		$users = $this->paginate('Admin');
		$this->set('users', $users);		
	}
	
	
/**
 * Name : Sub-admin Add Action
 * Created : 6 june 2014
 * Purpose : Add subadmin users
 * Author : Vivek Sharma
 */
	public function subadmin_add() 
	{		
		if ($this->request->is('post')) 
		{		
			$this->loadModel('Admin.Admin');
			$this->Admin->set($this->data['Admin']);
			if ($this->Admin->validates())
			{
				$this->request->data['Admin']['type'] = 3;	
				
				$password = mt_rand(100000,999999); 
				//$password = 'password';
				
				$this->request->data['Admin']['password'] = $password;
				$this->request->data['Admin']['status'] = 'active';
			
				if ($user = $this->Admin->save($this->request->data)) 
				{
					$last_user_id = $user['Admin']['id'];
					
									
					
					$this->loadModel('EmailTemplate');
					$email_content = $this->EmailTemplate->findByName('subadmin_account_created');
					$content = $email_content['EmailTemplate']['content'];
					
					$content = str_replace(array('{first_name}','{last_name}','{USERNAME}', '{PASSWORD}','{domain}'), array(ucfirst($user['Admin']['first_name']),ucfirst($user['Admin']['last_name']),$user['Admin']['username'],$password,'social-referral.com'),$content);
					$email_content['EmailTemplate']['content'] = $content;
					// pr($email_content);
					//~ die;
					/*$email = new CakeEmail('smtp');
					$email->from(array ($email_content['EmailTemplate']['from_name'] => 'Social Referral'))
					->to($user['Admin']['email'])
					->emailFormat('html')
					->subject($email_content['EmailTemplate']['subject'])
					->send($content);*/		
					
					$email = new CakeEmail('smtp');
					$email->from(array($email_content['EmailTemplate']['from_email'] => 'Social Referral'));
					$email->to($user['Admin']['email']);
					$email->subject($email_content['EmailTemplate']['subject']);
					$email->emailFormat('html');	
					$email->send($content);	
					
					$this->flash_new( __('The subadmin user has been saved'), 'success-messages' );
					$this->redirect(array('action' => 'subadmin_index'));
				} 
				else 
				{
					$this->Session->setFlash(__('The subadmin_user could not be saved. Please, try again.'));
				}
			}
			else {				
				$errors = $this->Admin->validationErrors;				
			}
		}		
		
	}


/**
 * Name : Sub-admin Edit Action
 * Created : 6 june 2014
 * Purpose : Edit subadmin users
 * Author : Vivek Sharma
 */
	public function subadmin_edit($id=null) 
	{		
		if (!empty($this->request->data)) 
		{	
			$this->loadModel('Admin.Admin');
			$this->Admin->set($this->data['Admin']);
			if ($this->Admin->validates())
			{
				
				$this->Admin->id = $this->data['Admin']['id'];
				if ($user = $this->Admin->save($this->request->data)) 
				{	
					
					$this->flash_new( __('The subadmin user has been saved'), 'success-messages' );
					$this->redirect(array('action' => 'subadmin_index'));
				} 
				else 
				{
					$this->Session->setFlash(__('The subadmin_user could not be saved. Please, try again.'));
				}
			}
			else {				
				$errors = $this->Admin->validationErrors;				
			}
		}
		
		$this->request->data = $this->Admin->find('first',array('conditions'=>array('Admin.id'=>$id)));	
	}
	
	/**
	 * Name : Sub admin Dashboard Action, shows default dashbaord to user
	 * Created : 6 June 2014	 
	 * Author : Vivek Sharma
	 */ 
	public function subadmin_dashboard()
	{
		if ($this->Session->check('is_subadmin_user') )
		{
			$subadmin = $this->Session->read('is_subadmin_user');
			
			if ( $this->Auth->login($subadmin) )
			{
				$this->Session->delete('is_subadmin_user');
			} 
		}
		$this->loadModel('AdminClient');		
		
		$conditions = array('AdminClient.admin_id'=>$this->Auth->user('id'));
		
		$this->paginate = array(
							'conditions' => $conditions,
							'joins' => array(
										array(
											'table' => 'admins', 
											'alias' => 'Admin',
											'type' => 'inner',
											'conditions' => array('Admin.id = AdminClient.client_id')
										)	
									),
							'fields' => array('Admin.id','Admin.first_name','Admin.last_name','Admin.username','Admin.email','Admin.company', 'Admin.company_logo')
							
							);
		$allusers = $this->paginate('AdminClient');	
		$this->set('users',$allusers);	
	}
	
	
	/**
	 * Name : Sub admin view_assign users
	 * Created : 6 June 2014	 
	 * Author : Vivek Sharma
	 * Purpose: View assigned users
	 */ 
	public function subadmin_view_assign_users($id=null)
	{
		$this->loadModel('AdminClient');	
		
		$this->paginate = array(
								'conditions' => array('AdminClient.admin_id' => $id),
								'joins' => array(
												array(
													'table' => 'admins', 'alias' => 'Admin', 'conditions' => array('Admin.id=AdminClient.client_id')													
												)
											),
								'fields' => array('Admin.first_name','Admin.last_name','Admin.email','Admin.id','Admin.username')
							);
							
		$users = $this->paginate('AdminClient');	
		$this->set('subadmin_id',$id);
		$this->set('users',$users);
		$this->render('subadmin_view_assign_users');			
		
	}
	
	
	/**
	 * Name : Sub admin assign users
	 * Created : 6 June 2014	 
	 * Author : Vivek Sharma
	 */ 
	public function subadmin_assign_users($id=null)
	{
		$this->loadModel('AdminClient');
		
		$already = $this->AdminClient->find('list',array('conditions'=>array('AdminClient.admin_id'=>$id),
														'fields'=>array('AdminClient.client_id'),
														'recursive'=>0));
		
		
		
		if( $this->request->is('post') && !empty($this->request->data) )
		{
			$save_ids = $this->Session->read('checked_users');
			
			$save_ids = array_keys($save_ids);
			
					
			if(!empty($save_ids))
			{
				$adduser = array(); $i=0;
				foreach($save_ids as $key => $index)
				{
					if ( !in_array($index, $already) )
					{
						$adduser[$i]['admin_id'] = $this->data['AdminClient']['admin_id'];
						$adduser[$i]['client_id'] = $index;
						$i++;
					}	
				}
				
				$this->AdminClient->create();
				$this->AdminClient->saveAll($adduser);
					
			}
			
			$this->Session->delete('checked_users');
			
			$this->flash_new( __('The users has been assigned to subadmin'), 'success-messages' );
			$this->redirect(array('action' => 'subadmin_view_assign_users',$this->data['AdminClient']['admin_id']));
		}
		
		$conditions = array('Admin.type' => 2, 'Admin.status' => 'active');
		
		if(isset($_GET['filter']))
		{
			$conditions = array_merge($conditions, array('Admin.'.$_GET['filter'].' Like ' => $_GET['search_keyword'].'%'));
		}
		
		$assigned = array();
		
		if( !$this->Session->check('checked_users') )
		{
			$this->Session->write('checked_users',array());
			
		}else{
			$assigned = $this->Session->read('checked_users');
		}
		
		
		$keys = array();	
		if ( !empty($assigned) )
		{
			$keys = array_keys($assigned);
		}
		
				
		$this->paginate = array(
							'conditions' => $conditions,
							'fields' => array('Admin.id', 'Admin.email', 'Admin.first_name', 'Admin.last_name', 'Admin.username')
							);			
				
		$allusers = $this->paginate('Admin');									
		
		$this->set('assigned',$keys);		
		$this->set('subadmin_id',$id);
		$this->set('users',$allusers);	
		$this->set('already',$already);
		$this->render('subadmin_assign_user');
	}

	/**
	 * Name : get_checked_users
	 * Created : 11 June 2014	 
	 * Author : Vivek Sharma
	 * Purpose: get checked users from session to list on multiple pages
	 */ 
	public function get_checked_users($is_check=1)
	{
		
		$assigned = array();
		
		$assigned = $this->Session->read('checked_users');
		
		if ( $is_check == '1' )
		{
			if( !empty($this->data['id']) )
			{
				$assigned[$this->data['id']] = 1;
				$this->Session->write('checked_users',$assigned);
			}
			
		}else if($is_check == 0)
		{
			$this->Session->delete('checked_users.'.$this->data['id']);
			
		}		
		echo json_encode($assigned); die;
	}	
	
	
	/**
	 * Name : list_assigned_users
	 * Created : 9 June 2014	 
	 * Author : Vivek Sharma
	 */ 
	public function list_assigned_users()
	{
		$this->loadModel('AdminClient');		
		
		$conditions = array('AdminClient.admin_id'=>$this->Auth->user('id'));
		
		$this->paginate = array(
							'conditions' => $conditions,
							'joins' => array(
										array(
											'table' => 'admins', 
											'alias' => 'Admin',
											'type' => 'inner',
											'conditions' => array('Admin.id = AdminClient.client_id')
										)	
									),
							'fields' => array('Admin.id','Admin.first_name','Admin.last_name','Admin.username','Admin.email')
							
							);
		$allusers = $this->paginate('AdminClient');					
		
		$this->set('users',$allusers);
		$this->render('list_assigned_users');
	}
	
	/**
	 * Name : All Client under sub-admin deals report
	 * Created : 9 June 2014
	 * Purpose : generate the detail of client deals
	 * Author : Vivek Sharma
	 */
	public function deal_report_subadmin() 
	{
		$this->loadModel('Admin.AdminClientDeal');
		//This section handles search
		$conditions = array();
		if(isset($_GET['filter']))
		{
			if($_GET['filter'] == 'title')
			{
				$conditions = array('AdminClientDeal.'.$_GET['filter'].' Like' => $_GET['search_keyword'].'%');
			}
		}	

		$this->loadModel('AdminClient');
		$clients = $this->AdminClient->find('list',array('conditions'=>array('AdminClient.admin_id'=>$this->Auth->user('id')),
														'fields'=>array('AdminClient.client_id'),
														'recursive'=>0));
			
		$no_client_flag = 0;												
		if(count($clients) > 1 )
			$cond = array('AdminClientDeal.user_id IN ' => $clients);
		else if(count($clients) ==  1)
			$cond = array('AdminClientDeal.user_id' => $clients);
		else 
			$no_client_flag = 1;   // Sub-admin has no client under him
			
		$this->AdminClientDeal->virtualFields = array(
			'total_friend_view'=>'SELECT SUM(AdminClientDealShare.friend_count) from admin_client_deal_shares as AdminClientDealShare where AdminClientDealShare.deal_id = AdminClientDeal.id and AdminClientDealShare.status = "posted"',
			'share'=>'SELECT COUNT(*) from admin_client_deal_shares as AdminClientDealShare where AdminClientDealShare.deal_id = AdminClientDeal.id and AdminClientDealShare.status = "posted"'
		);		
		
		if($no_client_flag == 0)
		{
		
			$this->paginate = array(	
						'conditions'=>array_merge($cond, $conditions),
						'limit' => 10
					);		
			$records = $this->paginate('AdminClientDeal');
		
		}else{
			$records = array();
		}
		$this->AdminClientDeal->unbindModel(array('belongsTo'=>array('Admin')));
		$this->set(compact('records'));
		$this->render('deal_report_subadmin');
	}
	

	/* Name : subadmin_user_visit_report
	 * Created : 9 June 2014
	 * Purpose : generate the detail of user visits for all client under sub-admin
	 * Author : Vivek Sharma
	 */
	public function subadmin_user_visit_report() 
	{
		
		$this->loadModel('AdminClient');
		$clients = $this->AdminClient->find('list',array('conditions'=>array('AdminClient.admin_id'=>$this->Auth->user('id')),
														'fields'=>array('AdminClient.client_id'),
														'recursive'=>0));														
		
			
		$no_client_flag = 0;												
		if(count($clients) > 1 )
			$cond = array('Admin.id IN ' => $clients);
		else if(count($clients) ==  1)
			$cond = array('Admin.id' => $clients);
		else 
			$no_client_flag = 1;   // Sub-admin has no client under him
			
			
		if($no_client_flag == 0)
		{
			$this->loadModel('Admin');
				
			$conditions = array(		
						'limit' => 10,
						'conditions' => $cond,
						'fields'=>array('first_name', 'last_name', 'email', 'total_visit', 'facebook_visit', 'twitter_visit', 'other_visit')			
					);			
			$user = $this->Admin->find('all', $conditions);
			
		}else{
			$user = array();
		}
		$this->set('user', $user);
		$this->render('subadmin_user_visit_report');		

	}

	/**
	 * Name : get_admin_dashboard
	 * Created : 25 July 2014	 
	 * Author : Vivek Sharma
	 * Purpose: get admin dashboard for subadmin
	 */ 
	public function get_admin_dashboard($admin_id)
	{
		if ( !empty($admin_id) )
		{
			$this->loadModel('Admin');
			$admin = $this->Admin->findById($admin_id);
			
			$subadmin = $this->Auth->user();
			
			if ( !empty($admin) )
			{
				if($this->Auth->login($admin['Admin']))
				{
					$this->Session->write('is_subadmin_user',$subadmin);
					$this->redirect('/admin/users/dashboard');
				}else{
					$this->flash_new( __('There is some issue. Please contact administrator'), 'error-messages' );
					$this->redirect($this->referer());
				}
								
			}else{
			
				$this->flash_new( __('User not found'), 'error-messages' );
				$this->redirect($this->referer());
			}
			
		}else{
			$this->flash_new( __('Invalid request'), 'error-messages' );
			$this->redirect($this->referer());
		}
	}
	
	/**
	 * Name : check admin fb token
	 * Created : 20 August 2014	 
	 * Author : Vivek Sharma
	 * Purpose: check admin fb token and send email to update their token
	 */ 
	 public function check_fb_token()
	 {
	 	$this->loadModel('Admin');
		$admins = $this->Admin->find('all', array('conditions' => array('fb_token_date <= ' => date('Y-m-d')),
													'fields' => array('Admin.email','Admin.first_name', 'Admin.last_name')));
												
		if ( !empty($admins) )
		{			
			foreach($admins as $ad)
			{
				/**Send email to user*/				
				$arr = array(
							'to_email' => $ad['Admin']['email'],
							'email_subject' => 'Notification to re-connect your facebook account'
						);
						
				$url_link = '<a href="'.SITE_URL.'" target="_blank">'.SITE_URL.'admin</a>';		
				$arr_keys = array('{Username}','{SITE_URL_LINK}','{site_name}');
				$arr_values = array($ad['Admin']['first_name'].' '.$ad['Admin']['last_name'], $url_link, SITE_NAME);
				
				$this->send_email(array(SITE_EMAIL => SITE_NAME), SITE_EMAIL, null, $arr, $arr_keys, $arr_values, 'fb_reconnect');
			}
		}
		die;
	 }
	 
}

?>
