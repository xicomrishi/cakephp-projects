<?php
//App::import($type = 'Vendor', 'DOMPDF', true, array(), 'dompdf_config.inc.php', false);
App::uses('File', 'Utility');
class CouponsController extends AppController{	
	
	public $name = "Coupons";
	public $helpers = array('Form', 'Html','Js' => array('Jquery'),'Session');
	public $paginate = array('limit' =>10);
	public $components = array('Email','RequestHandler');
	public $uses = array('Coupon','CouponUse','RechargeType','Operator');
	
	function beforeFilter(){
		parent::beforeFilter();
	}	
	
	/*--actions for admin  service type--*/
	public function admin_list_service_type() {
		$this->set('RechargeTypes',$this->paginate('RechargeType'));
		
	}		
		
	/*--actions for admin coupons--*/
	
	public function admin_list_coupon() {
		
		$arrCond=array();

		if(isset($this->request->query['search_key'])){				
			$query=$this->request->query['search_key'];
			if(!empty($query) ){				
				$arrCond['OR']=array('coupon_code LIKE'=>"%{$query}%",
				'coupon_price LIKE'=>"%{$query}%"
				);
				$this->set("SearchKey",$query);			
			}
		}
		$this->Coupon->recursive=1;
		
		$this->paginate = array(
			'conditions'=>$arrCond,
    		'limit'=>20,
     		'order'=> array('Coupon.coupon_id' => 'desc')
			
		);
		
		//$rType=$this->RechargeType->find('all',array('fields'=>array('recharge_type','id')));
		//$rType=$this->RechargeType->formatRechargeType($rType);
		//$this->set('RechargeTypes',$rType);
		
		$rType=$this->Operator->find('all',array('fields'=>array('name','type','id')));
		$rType=$this->Operator->formatOperator($rType);
		$this->set('RechargeTypes',$rType);
		
		$this->set('Coupons',$this->paginate('Coupon'));
		
	}
	
	public function admin_add_coupon(){
		
		$rType=$this->Operator->find('all',array('fields'=>array('name','type','id')));
		$rType=$this->Operator->formatOperator($rType);
		
		$this->set('RechargeTypes', $rType);
		
		if ($this->request->is('post') || $this->request->is('put')) {					
		
			$this->Coupon->create();
			$this->request->data['Coupon']['coupon_added_date']=date('Y-m-d H:i:s');
			
			if(!empty($this->request->data['Coupon']['recharge_type_id'])){
				$this->request->data['Coupon']['recharge_type_id']=implode(',', $this->request->data['Coupon']['recharge_type_id']);
			}
			
			if ($this->Coupon->save($this->request->data)) {
				$this->Session->setFlash(__('The coupon has been saved.'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'list_coupon'));
			} else {
				$this->Session->setFlash(__('The coupon could not be saved. Please, try again.'),'default',array('class'=>'error'));
			}
		}
	}	
	
	public function admin_edit_coupon($id=null){
		
		$rType=$this->Operator->find('all',array('fields'=>array('name','type','id')));
		$rType=$this->Operator->formatOperator($rType);
		
		$this->set('RechargeTypes', $rType);
		
		$this->Coupon->id = $id;
		
		if (!$this->Coupon->exists()) {
				$this->Session->setFlash(__('Invalid coupon.'),'default',array('class'=>'error'));
				$this->redirect(array('action' => 'list_coupon'));		
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {			
			
			if(!empty($this->request->data['Coupon']['recharge_type_id'])){
				$this->request->data['Coupon']['recharge_type_id']=implode(',', $this->request->data['Coupon']['recharge_type_id']);
			}
			if ($this->Coupon->save($this->request->data)) {				
				$this->request->data['Coupon']['coupon_modified_date']=date('Y-m-d H:i:s');
				$this->Session->setFlash(__('The Coupon has been saved'),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'list_coupon'));
				
			} else {
				$this->Session->setFlash(__('The Coupon could not be saved. Please, try again.'),'default',array('class'=>'error'));
			}
		} 
		
		if(empty($this->request->data)){
			$this->request->data=$this->Coupon->read(null, $id);
		}
		
	}
	
	public function admin_delete_coupon($id=null){

		$this->Coupon->id = $id;
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$this->Coupon->exists()) {
			$this->Session->setFlash(__('Invalid coupon id'),'default',array('class'=>'error'));
			$this->redirect(array('action' => 'list_coupon'));
			die;
		}
		
		if ($this->Coupon->delete()) {
			/*--delete all associated coupon codes--*/
			$this->CouponCode->deleteAll(array('coupon_id'=>$id));
			/*--/delete all associated coupon codes--*/
			
			$this->Session->setFlash(__('Coupon deleted.'),'default',array('class'=>'success'));
			$this->redirect(array('action' => 'list_coupon'));
		}
		$this->Session->setFlash(__('Coupon was not deleted.'),'default',array('class'=>'error'));
		$this->redirect(array('action' => 'list_coupon'));
		die;
		
	}
	
	/*--/actions for admin  coupons--*/
	
	/*--actions for admin  coupon uses--*/
	

	public function admin_list_coupon_uses($couponId=null) {
		
		if(!$data=$this->Coupon->findByCouponId($couponId)){
			$this->Session->setFlash(__('Invalid coupon id.'),'default',array('class'=>'error'));
			$this->redirect(array('action' => 'list_coupon'));
			die;
		}
		if(!empty($couponId)){
			$this->CouponUse->recursive=3;
			$this->paginate=array(
				'conditions'=>array('CouponUse.coupon_id'=>$couponId),
				'limit'=>50,
				'order'=>array('coupon_id'=>'desc'),
				'fields'=>array('Recharge.number,Recharge.amount,Recharge.recharge_status',
				'Recharge.transaction_id','Recharge.transaction_id','Recharge.recharge_date',
				'Customer.customer_id','Customer.name','Recharge.transaction_status')
			);
			$this->set('Coupon',$this->Coupon->findByCouponId($couponId));
			$this->set('CouponUses',$this->paginate('CouponUse'));
		}			
		
	}	
	/*--/actions for admin  coupon uses--*/
	
	
	
}