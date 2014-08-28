<?php

/**
 * Name : Coupons Controller
 * Created : 2 July 2014
 * Purpose : Coupon controller
 * Author : Vivek Sharma
 */
class CouponsController extends AdminAppController {

	public $name = 'Coupons';
	public $uses = array('Coupon');
	public $components = array('Admin.Uploader');
	public $paginate = array ('limit' => 30);

	public function beforeFilter()
	{
		//Set auth model Admin
		parent::beforeFilter();
		$this->Auth->authenticate = array(
			'Form' => array('userModel' => 'Admin')
		);
		
	}

	/**
	 * name : index
	 * Purpose : list all coupons
	 * author : Vivek Sharma
	 * Created : 2 July 2014
	 */
	public function index()
	{
		$this->loadModel('Coupon');
																				
		$this->Coupon->bindModel(array('belongsTo' => array('AdminClientDeal' => array('className' => 'AdminClientDeal', 'foreignKey' => 'deal_id',
																						'fields' => array('AdminClientDeal.title')))));
		$this->paginate['conditions'] = array('Coupon.client_id' => $this->Auth->user('id'));		
		$this->paginate['order'] = array('Coupon.created' => 'desc');
		$coupons = $this->paginate('Coupon');
		
		$this->set('coupons', $coupons);	
	}
	
	/**
	 * name : add
	 * Purpose : add new coupons
	 * author : Vivek Sharma
	 * Created : 2 July 2014
	 */
	public function add()
	{
		if ( !empty($this->data) )
		{
			$exist = $this->Coupon->find('first',array('conditions' => array('Coupon.deal_id' => $this->data['Coupon']['deal_id'], 'Coupon.status' => 'Active')));
			
			$is_inactive_msg = '';
			if ( !empty($exist) )
			{
				$is_inactive_msg = ' A coupon for this deal already active so status of this coupon is changed to Inactive.';
				$this->request->data['Coupon']['status'] = 'Inactive';
			}
			
			if(!empty( $this->request->data['Coupon']['image']['name']))
				{
					$image_array = $this->request->data['Coupon']['image'];
					$image_info = pathinfo($image_array['name']);
					$image_new_name = $image_info['filename'].time().'_'.$this->Auth->user('id');
					$thumbnails = Thumbnail::user_profile_thumbs();
					$params = array('size'=>'500');
					$this->Uploader->upload($image_array, COUPON , $thumbnails, $image_new_name, $params );
				
					if ( $this->Uploader->error )
					{
						$file_error = $this->Uploader->errorMessage;
						$this->flash_new( $file_error, 'error-messages' ); 	
						$this->request->data['Coupon']['image'] = '';					
					}
					else
					{							
						$this->request->data['Coupon']['image'] = $this->Uploader->filename;
						$this->Uploader->filename = '';
					}
				}			
			
			$this->request->data['Coupon']['coupon_code'] = strtoupper(substr($this->Auth->user('company'),0,4).generateRandStr(4)); 
				
			$this->Coupon->create();
					
			if( $this->Coupon->save($this->data) )
			{
				$this->Session->setFlash(__('Coupon saved successfully.'.$is_inactive_msg));
				$this->redirect(array('action'=>'index'));
			}else{
				$this->Session->setFlash(__('Error saving coupon. Please try again later'));
				$this->redirect($this->referer());
			}
		}	

		$this->loadModel('AdminClientDeal');
		$deals = $this->AdminClientDeal->find('list', array('conditions' => array('AdminClientDeal.user_id' => $this->Auth->user('id'),
																				  'AdminClientDeal.status' => 'active'),
															'fields' => array('id','title')));
		$this->set('deals', $deals);
		$this->set('client_id', $this->Auth->user('id'));
		
	}

	/**
	 * name : edit
	 * Purpose : edit coupons
	 * author : Vivek Sharma
	 * Created : 2 July 2014
	 */
	public function edit($id)
	{
		if ( !empty($this->data) )
		{
			$exist = $this->Coupon->find('first',array('conditions' => array('Coupon.id != ' => $this->data['Coupon']['id'],'Coupon.deal_id ' => $this->data['Coupon']['deal_id'], 'Coupon.status' => 'Active')));
			
			$is_inactive_msg = '';
			if ( !empty($exist) )
			{
				$is_inactive_msg = ' A coupon for this deal already active so status of this coupon is changed to Inactive.';
				$this->request->data['Coupon']['status'] = 'Inactive';
			}
			
			$this->Coupon->id = $this->data['Coupon']['id'];
			if(!empty( $this->request->data['Coupon']['image']['name']))
			{
				$image_array = $this->request->data['Coupon']['image'];
				$image_info = pathinfo($image_array['name']);
				$image_new_name = $image_info['filename'].time().'_'.$this->Auth->user('id');
				$thumbnails = Thumbnail::user_profile_thumbs();
				$params = array('size'=>'500');
				$this->Uploader->upload($image_array, COUPON , $thumbnails, $image_new_name, $params );
			
				if ( $this->Uploader->error )
				{
					$file_error = $this->Uploader->errorMessage;
					$this->flash_new( $file_error, 'error-messages' ); 	
					$this->request->data['Coupon']['image'] = '';					
				}
				else
				{							
					$this->request->data['Coupon']['image'] = $this->Uploader->filename;
					$this->Uploader->filename = '';
				}
			}else{
				unset($this->request->data['Coupon']['image']);
			}

			if ( empty($exist['Coupon']['coupon_code']) )
			{
				$this->request->data['Coupon']['coupon_code'] = strtoupper(substr($this->Auth->user('company'),0,4).generateRandStr(4)); 
			}			
			
			if( $this->Coupon->save($this->data) )
			{
				$this->Session->setFlash(__('Coupon updated successfully.'.$is_inactive_msg));
			
			}else{
				
				$this->Session->setFlash(__('There is some issue. Please try again later. '));
			
			}
			$this->redirect(array('action' => 'index'));
			
				
		}

		$this->loadModel('AdminClientDeal');
		$deals = $this->AdminClientDeal->find('list', array('conditions' => array('AdminClientDeal.user_id' => $this->Auth->user('id'),
																				  'AdminClientDeal.status' => 'active'),
															'fields' => array('id','title')));
		$this->set('deals', $deals);
			
		$coupon = $this->Coupon->find('first', array('conditions' => array('Coupon.id' => $id)));
		$this->request->data = $coupon;
		
	}
	
	
	/**
	 * name : view
	 * Purpose : view coupon
	 * author : Vivek Sharma
	 * Created : 2 July 2014
	 */
	public function view($id)
	{
		$this->Coupon->bindModel(array('belongsTo' => array('AdminClientDeal' => array('className' => 'AdminClientDeal', 'foreignKey' => 'deal_id',
																						'fields' => array('AdminClientDeal.title')))));
		
		$coupon = $this->Coupon->find('first', array('conditions' => array('Coupon.id' => $id)));
		$this->set('coupon', $coupon);
		
	}	
	
	/**
	 * name : delete
	 * Purpose : delete coupons
	 * author : Vivek Sharma
	 * Created : 2 July 2014
	 */
	public function delete($id)
	{
		if ( !empty($id) )
		{
			$this->Coupon->id = $id;
			if ( $this->Coupon->delete($id) )
			{
				$this->Session->setFlash(__('Coupon deleted successfully.'));
			}
			
		} 
		$this->redirect(array('action' => 'index'));
		
	}	
	
	/**
	 * name : rewards
	 * Purpose : display list of users who got coupon
	 * author : Vivek Sharma
	 * Created : 3 July 2014
	 */
	public function rewards()
	{
		$client_id = $this->Auth->user('id');
		
		$this->loadModel('UserCoupon');
		$this->loadmodel('Coupon');
		
		$this->UserCoupon->recursive = 2;
		$this->Coupon->bindModel(array('belongsTo' => array('AdminClientDeal' => array('className' => 'AdminClientDeal','foreignKey' => 'deal_id',
																					'fields' => array('AdminClientDeal.title')))));
																					
		$user_conditions = array();																			
		$this->UserCoupon->bindModel(array('belongsTo' => array('User' => array('className' => 'User', 'foreignKey' => 'user_id',
																				'fields' => array('User.email', 'User.first_name', 'User.last_name')),
																	'Coupon' => array('className' => 'Coupon', 'foreignKey' => 'coupon_id'))));
		
		$conditions = array('UserCoupon.client_id' => $this->Auth->user('id'));
 		
 		 		
 		$this->paginate = array('conditions' => $conditions,'order' => array('UserCoupon.created' => 'desc'));
		
		$rewards = $this->paginate('UserCoupon');
		
		$this->set('users',$rewards);
		$this->render('rewards');
		
	}
	
	/**
	 * name : redeem_coupon
	 * Purpose : update coupon status
	 * author : Vivek Sharma
	 * Created : 18 July 2014
	 */
	 public function redeem_coupon($id)
	 {
	 	if ( $id )
		{
			$this->loadModel('UserCoupon');
			$coupon = $this->UserCoupon->findById($id);
			if ( !empty($coupon) )
			{
				$this->UserCoupon->id = $id;
				$this->UserCoupon->save(array('status' => 'used', 'redeemed_on' => date('Y-m-d H:i:s')));
				
				$this->Session->setFlash(__('Coupon redeemed successfully.'));
				
			}else{
				$this->Session->setFlash(__('Coupon not found.'));
			}
		}else{
			$this->Session->setFlash(__('Invalid request'));
		}
		$this->redirect($this->referer()); 
	}
	
	
}	
