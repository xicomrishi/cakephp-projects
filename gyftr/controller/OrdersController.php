<?php


class OrdersController extends AppController {

	public $name = 'Orders';
	public $helpers = array('Form', 'Html','Js' => array('Jquery'));
	public $paginate ='';	
	public $components=array('Session','Access');
	public $uses=array('User','UserRole','BrandProduct','Voucherinfo','Shops','Order','Voucher');

	
	function beforeFilter(){
		parent::beforeFilter();	 
		$this->Access->isValidUser();
		
	}

	function admin_index($id, $order) {
		//($this->request->query);
		//$search=array();
		$search='1=1';
		//Search Criteria start
		if(isset($this->request->query['type'])&& $this->request->query['type']!='')
		{
			$g_type=$this->request->query['type'];			
			$this->set('type', $g_type);
			$search.=" AND Order.type='".$g_type."'";
 		}		
		if(isset($this->request->query['incomplete_deliver'])&& $this->request->query['incomplete_deliver']!='')
		{
			$incomplete_deliver=$this->request->query['incomplete_deliver'];			
			$this->set('incomplete_deliver', $incomplete_deliver);
			$search.=" AND Order.incomplete_deliver='".$incomplete_deliver."'";
 		}
		if(isset($this->request->query['payment_status'])&& $this->request->query['payment_status']!='')
		{
			$payment_status=$this->request->query['payment_status'];			
			$this->set('payment_status', $payment_status);
			$search.=" AND Order.payment_status='".$payment_status."'";
 		}
		if(isset($this->request->query['status'])&& $this->request->query['status']!='')
		{
			$status=$this->request->query['status'];			
			$this->set('status', $status);
			$search.=" AND Order.status='".$status."'";
 		}
		if(isset($this->request->query['from_date'])&& $this->request->query['from_date']!='')
		{
			$from_date=$this->request->query['from_date'];			
			$this->set('from_date', $from_date);
			$search.=" AND Order.created>='".$from_date."'";
 		}
		if(isset($this->request->query['to_date'])&& $this->request->query['to_date']!='')
		{
			$to_date=$this->request->query['to_date'];			
			$this->set('to_date', $to_date);
			$search.=" AND Order.created<='".$to_date." 23:59:59'";
 		}
		if(isset($this->request->query['serch_val'])&& $this->request->query['serch_val']!='')
		{
			$serch_field=$this->request->query['serch_by'];
			$serch_val=$this->request->query['serch_val'];
			$search.=' AND '.$serch_field." like '".$serch_val."%'";
			$this->set('serch_by', $serch_field);
			$this->set('serch_val', $serch_val);
			
		}
		//Search Criteria END
		$this->paginate= array('fields'=>Array('Order.*') ,			
			// 'joins'=>array(
	  //array('table'=>'basket', 'alias'=>'Basket', 'type'=>'left', 'conditions'=>array('Basket.session_id = Order.session_id'),'group'=>'`Order`.`session_id`'),
	  //array('table'=>'brand_products', 'alias'=>'BrandProduct', 'type'=>'inner', 'conditions'=>array('BrandProduct.id = Basket.voucher_id'))
	  	//		),		
			
			'limit' => 20
	  		);
			
			
//print_r($this->paginate);
		if(!isset($id)){$this->set('showuser','1');}
		else
		{
			$search.=' AND Order.from_id='.$id;			
			//$this->paginate['order'] = array('Product.product_name'=>'DESC');
			$users=$this->User->find('first',array('conditions'=>array('id'=>$id),'fields'=>array('id','first_name','last_name')));			
			$this->set('user',$users['User']);	
		}
		$this->paginate['conditions'] =array($search);
		$gyfts = $this->paginate('Order');
		$this->set('gyfts', $gyfts);
			
	}	
	
	
	
	
		
	
}
