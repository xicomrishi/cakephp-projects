<?php 

App::uses('AppController','Controller');

/**
 * Json Controller
 *
 * Purpose : Manage webservice
 * @project Social Referral
 * @since 11 August 2014
 * @author : Vivek Sharma
 */
class JsonController extends AppController {
	
	public $name = 'json';
	
	public function beforeFilter(){
		
		$this->Auth->allow();
		//$token = 'xicom';
		$token = $this->request->data['token'];
		if ( $token != 'xicom' || !empty($this->request->data) )
		{
			echo json_encode(array('status' => 'error','Message' => 'invalid request')); exit;
		}		
	}
	
	
	/**
	 * Method Name : ApiLogin
	 * Author Name : Vivek Sharma
	 * Date : 11 August 2014
	 * Description : validate username & password & send admin data/deals
	 */
	public function ApiLogin()
	{
		if(isset($this->request->data['username']) && isset($this->request->data['password']) 
														&& !empty($this->request->data['username'])
														&& !empty($this->request->data['password']))
		{
			$username = $this->request->data['username'];
			$password = $this->Auth->password($this->request->data['password']);
			
			try
			{	
				$this->loadModel('Admin');
				$user_details = $this->Admin->find('first', 
					array(
						'conditions'=>array(
							'Admin.username'=>$username,
							'Admin.password'=>$password
						),
						'fields'=>array(
							'tablet_url',
							'company'
							
						)
					)
				);
				
				if ( !empty($user_details) )
				{
					$admin_data = $this->Admin->get_user_tab_data($user_details['Admin']['tablet_url']);
					if ( !empty($admin_data) )
					{
						$deal_data = array();
						
						if ( !empty($admin_data['AdminClientDeal']) )
						{
							$i = 0;
							foreach($admin_data['AdminClientDeal'] as $deal)
							{
								if(!empty($deal['AdminIcon']['image']) && file_exists(DEALSLIDER.$deal['AdminIcon']['image'])) 
								{
									if($deal['type'] == 1)
									{
										$txt = 'Get '.$deal['price'].'% off '.$deal['product'];
									}
									else if($deal['type'] == 2)
									{
										$txt = 'Get $'.$deal['price'].' off '.$deal['product'];
									}
									else if($deal['type'] == 3)
									{
										$txt = 'Buy One Get One Free '.$deal['product'];
									}
									else
									{
										$txt = $deal['product'];
									}	
										
									$deal_data[$i]['id'] = $deal['id'];
									$deal_data[$i]['type'] = $deal['type'];
									$deal_data[$i]['title'] = $deal['title'];
									$deal_data[$i]['icon'] = DEALSLIDERURL.$deal['AdminIcon']['image'];
									$deal_data[$i]['text'] = $txt;
									/*$deal_data[$i]['description'] = $deal['description'];
									$deal_data[$i]['disclaimer'] = $deal['disclaimer'];
									$deal_data[$i]['price'] = $deal['price'];
									$deal_data[$i]['fb_post_message'] = $deal['fb_post_message'];
									$deal_data[$i]['tw_post_message'] = $deal['tw_post_message'];
									$deal_data[$i]['fanpage_message'] = $deal['fanpage_message'];*/
									$i++;
								}
							}	
						}
						
						$data = array(
										'client' => array(
												'id' => $admin_data['Admin']['id'],									
												'company' => $admin_data['Admin']['company'],
												'company_logo' => SITE_URL.'company/'.$admin_data['Admin']['company_logo'],
												'latitude' => $admin_data['Admin']['latitude'],
												'longitude' => $admin_data['Admin']['longitude'],
												'tablet_url' => $admin_data['Admin']['tablet_url'],
												'website_url' => $admin_data['Admin']['website_url'],
												'facebook_url' => $admin_data['Admin']['facebook_url'],
												'twitter_url' => $admin_data['Admin']['twitter_url'],
												'fb_fanpage_id' => $admin_data['Admin']['fb_fanpage_id'],
												'fb_page_access_token' => $admin_data['Admin']['fb_page_access_token'],
												'bg_color' => $admin_data['Admin']['bg_color'],
												'font_color' => $admin_data['Admin']['font_color'],
												'bg_texture' => SITE_URL.'textures/texture_'.$admin_data['Admin']['bg_texture'],
												'main_page_text_1' => $admin_data['Admin']['main_page_text_1'],
												'main_page_text_2' => $admin_data['Admin']['main_page_text_2'],
												'login_page_text_1' => $admin_data['Admin']['login_page_text_1'],
										),
										'deals' => $deal_data
								);
						
							$response = array('status'=>'ok', 'Message'=>'', 'data'=>$data);
						
					}else{
						$response = array('status'=>'error', 'Message'=>'Invalid client.');
					}
					
				}else{
						
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
	
	
	/**
	 * Method Name : UserDetails
	 * Author Name : Vivek Sharma
	 * Date : 11 August 2014
	 * Description : get front end user id
	 */
	 public function UserDetails()
	 {
	 	if ( isset($this->request->data['LoginType']) && !empty($this->request->data['LoginType']) )
		{
			$request = $this->request->data;
			$response = array();
			
			$this->loadModel('User');
			$exist_user = $this->user->findByEmail($request['email']);
			
			if ( $request['LoginType'] == 'facebook' )	
			{
				$user_data = array(
										'first_name' => $request['first_name'],
										'last_name' => $request['last_name'],
										'username' => $request['username'],
										'fb_id' => $request['fb_id'],
										'fb_access_token' => $request['fb_access_token'],
										'fb_friends' => $request['fb_friends'],
										'image' => $request['image']
								);
								
				if ( !empty($exist_user) )
				{
					if ( !empty($exist_user['User']['image']) )
					{
						unset($user_data['image']);
					
					}else{
						
						$fb_img = $user_data['image'];
						$file_name = 'fb_'.$user_data['fb_id'].'.jpg';
						$source_path = PROFILE . $file_name;
						if($this->write_file($source_path, $fb_img))
						{
							$user_data['image'] = $file_name;
						}	
					}					
					
					$this->User->id = $exist_user['User']['id'];
					$this->User->save($user_data);
					
					$user = $exist_user['User'];
					
				}else{
					
					$fb_img = $user_data['image'];
					$file_name = 'fb_'.$user_data['fb_id'].'.jpg';
					$source_path = PROFILE . $file_name;
					if($this->write_file($source_path, $fb_img))
					{
						$user_data['image'] = $file_name;
					}

					$user_data['password'] = $this->Auth->password( $request['first_name'].$request['fb_id'] );						
					$user_data['status'] = UserDeinedStatus::Active;	
					
					$this->User->create();
					$user_details = $this->User->save($user_data);	
					
					$user = $user_details['User'];
				
				}	
			
			}else if ( $request['LoginType'] == 'twitter' )
			{
					$user_data = array(
										'first_name' => $request['first_name'],
										'last_name' => $request['last_name'],
										'username' => $request['username'],
										'tw_id' => $request['tw_id'],
										'tw_oauth_token' => $request['tw_oauth_token'],
										'tw_oauth_token_secret' => $request['tw_oauth_token_secret'],
										'tw_screen_name' => $request['tw_screen_name'],
										'tw_friends' => $request['tw_friends'],
										'image' => $request['image']										
								);			
					
					
					$this->User->id = $exist_user['User']['id'];
					$this->User->save($user_data);
					
				
					if ( !empty($exist_user) )
					{
						if ( !empty($exist_user['User']['image']) )
						{
							unset($user_data['image']);
						
						}else{
								
							$tw_image = str_replace('_normal', '', $user_data['image']);
							$file_name = 'tw_'.$user_data['tw_id'].'.jpg';
							$source_path = PROFILE . $file_name;
							if($this->write_file($source_path, $tw_image))
							{
								$user_data['image'] = $file_name;
							}
						}						
						
						$this->User->id = $exist_user['User']['id'];
						$this->User->save($user_data);
						
						$user = $exist_user['User'];
						
						
					}else{
						
						$tw_image = str_replace('_normal', '', $user_data['image']);
						$file_name = 'tw_'.$user_data['tw_id'].'.jpg';
						$source_path = PROFILE . $file_name;
						if($this->write_file($source_path, $tw_image))
						{
							$user_data['image'] = $file_name;
						}
						
						$user_data['password'] = $this->Auth->password( $request['first_name'].$request['fb_id'] );						
						$user_data['status'] = UserDeinedStatus::Active;	
						
						$this->User->create();
						$user_details = $this->User->save($user_data);	
						
						$user = $user_details['User'];
						
					}
			}
			
			$this->loadModel('Admin');
			$admin = $this->Admin->findById($request['client_id']);	
			
			$this->loadModel('AdminClientDeal');
			$deal = $this->AdminClientDeal->findDealById($request['deal_id']);		
			
			$this->Session->write('Client.id',$admin['Admin']['id']);
			$this->Session->write('Client.latitude',$admin['Admin']['latitude']);
			$this->Session->write('Client.longitude',$admin['Admin']['longitude']);

			$slider_deal = $this->AdminClientDeal->clientAllDeal();	
			$StatusMessage = new StatusMessage();
			
			$fb_message = $StatusMessage->fb_message($user, $admin['Admin'], $deal);
			$tw_message = $StatusMessage->tw_message($user, $admin['Admin'], $deal);
			$fb_fanpage_message = $StatusMessage->fb_fanpage_message($user, $admin['Admin'], $deal);
			
			
			$this->loadModel('Coupon');		
			$available_coupon = $this->Coupon->find('first', array('conditions' => array('Coupon.client_id' => $admin['Admin']['id'], 
																					'Coupon.deal_id' => $deal['AdminClientDeal']['id'], 
																					'Coupon.status' => 'Active')));	
			
			$show_stars = $share_count = 0;
			
			if ( !empty($available_coupon) )
			{
				$show_stars = $available_coupon['Coupon']['no_of_share'];
				
				$this->loadModel('AdminClientDealShare');
				$share_count = $this->AdminClientDealShare->find('count', array('conditions' => array(
																					'AdminClientDealShare.user_id' => $user['id'],
																					'AdminClientDealShare.client_id' => $admin['Admin']['id'],
																					'AdminClientDealShare.deal_id' => $deal['AdminClientDeal']['id'],
																					'used_for_coupon' => 'No',
																					'coupon_location' => 'Valid')));
			}
			
			
			$deal_data = array(
							'title' => $deal['AdminClientDeal']['title'],
							'description' => $deal['AdminClientDeal']['description'],
							'disclaimer' => $deal['AdminClientDeal']['disclaimer'],
							'image' => DEALURL.$deal['AdminClientDeal']['image'],
							'fb_post_message' => $fb_message,
							'tw_post_message' => $tw_message,
							'fb_fanpage_message' => $fb_fanpage_message
						);
									
			
			$data = array(
						'UserId' => $user['id'],
						'first_name' => $user['first_name'],
						'last_name' => $user['last_name'],
						'show_start' => $show_stars,
						'share_count' => $share_count,
						'deal_data' => $deal_data,
						'local_deals' => $slider_deal						
					);
					
			$response = array('status' => 'ok', 'Message' => '', 'data' => $data);
					
		}else{
			$response = array('status' => 'error', 'Message' => 'Invalid request');
		} 
		
		echo json_encode($response); exit;
	 }
	
	
	
	/**
	 * Method Name : DealShared
	 * Author Name : Vivek Sharma
	 * Date : 11 August 2014
	 * Description : save data after deal share and give coupon details
	 */
	 public function DealShared()
	 {
	 	if ( isset($this->request->data['deal_id']) && !empty($this->request->data['deal_id']) )
		{
			$request = $this->request->data;
			
			$this->loadModel('AdminClientDealShare');
			$query = '';
			$user_id = $request['user_id'];
			
			$current_client_id = $request['client_id'];
			$current_deal_id = $request['deal_id'];
			$share_type = $request['LoginType'];
			$tablet_url = $request['tablet_url'];
			
			$coupon_location = $request['coupon_location_valid'];
			
			/*Coupon check code*/
			$this->loadModel('UserCoupon');
			$user_coupons = $this->UserCoupon->find('first', array('conditions' => array(
																	'UserCoupon.user_id' => $user_id, 
																	'UserCoupon.client_id' => $current_client_id,																	
																	'UserCoupon.valid_till > ' => date('Y-m-d H:i:s'),
																	'UserCoupon.status' => 'not used'
																	)
															)
												);
			
			if ( !empty($user_coupons) )
			{
				$coupon_location = 'Invalid';	
			}
			
			$friends = $share_type == 'facebook'?$request['fb_friends']:$request['tw_friends'];
			if(empty($friends)) {
				$friends = 0;
			}
			$time_now = date('Y-m-d H:i:s');
			$query .= "($user_id, $current_client_id, $current_deal_id, '$share_type', $friends, 'yes','pending', '".$coupon_location."', '$time_now', '$time_now'),";
			
			$query = rtrim($query,",");
			$final_query = "INSERT into admin_client_deal_shares (user_id, client_id, deal_id, share_type, friend_count, is_primary, status, coupon_location, created, modified) VALUES $query"; 
			
			$this->loadModel('AdminClientDealShare');						
			$this->AdminClientDealShare->query($final_query);
			
			
			/*Coupon check code*/
			
			$this->loadModel('Coupon');																			
			$available_coupon = $this->Coupon->find('first', array('conditions' => array('Coupon.client_id' => $current_client_id, 
																					'Coupon.deal_id' => $current_deal_id, 
																					'Coupon.status' => 'Active')));	
																					
			$show_stars = $share_count = 0;
																					
			if ( !empty($available_coupon) )
			{
				$show_stars = $available_coupon['Coupon']['no_of_share'];	
				
				$this->loadModel('AdminClientDealShare');
				$share_count = $this->AdminClientDealShare->find('count', array('conditions' => array(
																						'AdminClientDealShare.user_id' => $user_id,
																						'AdminClientDealShare.client_id' => $current_client_id,
																						'AdminClientDealShare.deal_id' => $current_deal_id,
																						'used_for_coupon' => 'No',
																						'coupon_location' => 'Valid')));
				
			}																			
																					
			
			$display_coupon = $coupon = $generated_coupon = 0;
			
			if($coupon_location == 'Valid')
			{
				if ( !empty($user_coupons) )
				{
					$this->loadModel('Coupon');
					$coupon = $this->Coupon->find('first', array('conditions' => array('Coupon.id' => $user_coupons['UserCoupon']['coupon_id'],'Coupon.deal_id' => $current_deal_id)));
					
					if ( !empty($coupon) )
					{
						$display_coupon = 1;
						
						$generated_coupon = $user_coupons;	
					}					
					
				}else{					
							
					$this->loadModel('Coupon');
					
					$flag = 0;  
					$available_coupon = $this->Coupon->find('first', array('conditions' => array('Coupon.client_id' => $client_id, 
																						'Coupon.deal_id' => $current_deal_id, 
																						'Coupon.status' => 'Active')));	
				
					if ( !empty($available_coupon) )
					{
						/*Check if any coupon was redeemed in last 24 hours. Only 1 coupon will be generated per day.*/
						$last_redeemed =  $this->UserCoupon->find('first', array('conditions' => array(
																			'UserCoupon.user_id' => $user_id, 
																			'UserCoupon.client_id' => $current_client_id,
																			'UserCoupon.status' => 'used'
																			),
																			'order' => array('UserCoupon.redeemed_on' => 'desc')
																	)
														);
						$go_flag = 0;								
						if ( !empty($last_redeemed) )
						{
							$diff = strtotime(date('Y-m-d H:i:s')) - strtotime($last_redeemed['UserCoupon']['redeemed_on']);
							if (  $diff < 86400 )
								$go_flag = 1;
						}
						
						if ( $go_flag == 0)
						{
							$coupon = $available_coupon;
							if ( $share_count >= $coupon['Coupon']['no_of_share'])
							{				
							
								$query = "update admin_client_deal_shares set used_for_coupon = 'Yes' 
														where user_id = '".$user_id."' and 
																client_id = '".$current_client_id."' and 
																deal_id = '".$current_deal_id."' and
																used_for_coupon = 'No' and coupon_location = 'Valid' LIMIT ".$coupon['Coupon']['no_of_share'];
								
								$this->AdminClientDealShare->query($query);
								
								$cur_date = date('Y-m-d H:i:s');
								$validity = date('Y-m-d H:i:s',strtotime($cur_date) + $coupon['Coupon']['valid_for']*60*60);
								
								$code = strtoupper(substr($tablet_url,0,4).$this->Auth->user('id').generateRandStr(4));
								
								
													  
							
								
								$arr = array('user_id' => $user_id,
											 'client_id' => $current_client_id,
											 'coupon_id' => $coupon['Coupon']['id'],
											 'code' => $code,
											 'created' => date('Y-m-d H:i:s'),
											 'status' => 'not used',
											 'valid_till' => $validity);
								
								$this->loadModel('UserCoupon');
								$this->UserCoupon->create();
								$coupon_details = $this->UserCoupon->save($arr);			 
								
								/*Generate QR Code*/
								App::import('Vendor',array('phpqrcode/qrlib'));
						
								$tempDir = QRCODES;
								$fileName = 'coupon_'.$coupon_details['UserCoupon']['id'].'.png';
								$codeContents = SITE_URL.'tablets/redeem_coupon/'.$code;
								QRcode::png($codeContents, $tempDir.$fileName, QR_ECLEVEL_L, 6, 7);
								
								$this->UserCoupon->id = $coupon_details['UserCoupon']['id'];
								$user_coupon_details = $this->UserCoupon->save(array('qr_image' => $fileName));
								
								$coupon_details['UserCoupon']['qr_image'] = $fileName;
								
								$display_coupon = 1;						
								$generated_coupon = $coupon_details;					
								
							}
						 }
						
					  }																
					
					
					}	
				}

				if ( $coupon != 0)
				{
					$coupon['Coupon']['image'] = SITE_URL.'img/coupons/'.$coupon['Coupon']['image'];
				}
				
				if ( $generated_coupon != 0)
				{
					$generated_coupon['UserCoupon']['qr_image'] = SITE_URL.'img/QRcodes/'.$generated_coupon['UserCoupon']['qr_image'];
				}
				
				$data = array(
							'show_stars' => $show_stars,
							'share_count' => $share_count,
							'display_coupon' => $display_coupon,
							'coupon' => $coupon,
							'generated_coupon' => $generated_coupon
						);
						
				$response = array('status' => 'ok', 'Message' => '', 'data' => $data);
				
			}else{
				$response = array('status' => 'error','Message' => 'Invalid request');
			}
			echo json_encode($response); exit;
	 }
	 

	
	public function test_request()
	{
		$this->request->data['username'] = 'deepaksharma';
		$this->request->data['password'] = '123456';
		$response = $this->ApiLogin();
		pr($response); die;
	}
	
	
	
	
}


?>