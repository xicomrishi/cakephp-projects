<?php

class PaymentController extends AppController {

	public $name = 'Payment';
	public $helpers = array('Form', 'Html','Js' => array('Jquery'));	
	public $components=array('Session','Access');
	public $uses=array('User','Order','Voucher','Points','GroupGift','Payment','BrandProduct');

	
	function beforeFilter(){
		parent::beforeFilter();	 
		//$this->Access->isValidUser();		
	}

	public function make_payment($ord_id,$userid,$typ)			//$typ=0 =>one to one or me to me   1=>group gift
	{
		$this->layout='ajax';
		$user=$this->User->findById($userid);
		$order=$this->Order->findById($ord_id);
		$this->set('user',$user);
		$this->set('order',$order);
		if($typ==1)
		{
			$gpusers=$this->GroupGift->find('all',array('conditions'=>array('GroupGift.group_gift_id'=>$order['Order']['group_gift_id'])));
			foreach($gpusers as $gp)
			{
				if($gp['GroupGift']['email']==$this->Session->read('User.User.email'))
				{
					$user_det=$gp;	
				}	
			}
			$this->set('my_gp',$user_det);
			$this->render('payment_option_groupgift');
		}else{
		
		$this->render('payment_option');
		}
	}
	
	public function redeem_points($rdp,$ord_id,$userid,$type)     //type=0 one to ont, me to me  type=1=>group gift
	{
		$order=$this->Order->findById($ord_id);
		$user=$this->User->findById($userid);
		//$rem_points=$user['User']['points']-$order['Order']['total_amount'];
		$rem_points=$user['User']['points']-$rdp;
		$this->User->id=$userid;
		$this->User->saveField('points',$rem_points);
		$left_points=($order['Order']['total_amount']-$order['Order']['amount_paid'])-$rdp;
				
		$payment_status=1;	
		if($left_points>0)
		{
			$payment_status=0;	
		}
		
		$gift_status=2;
		if($left_points<=0)
		{
			$gift_status=0;	
		}
				
		$sql="update gyftr_order_detail set amount_paid=amount_paid+'".$rdp."', payment_status='".$payment_status."', status='".$gift_status."' where id='".$ord_id."'";
		$this->Order->query($sql);
		$paydetails=array('user_id'=>$userid,'order_id'=>$ord_id,'payment_type'=>'0','value'=>$rdp,'created_date'=>date('Y-m-d H:i:s'),'user_ip'=>$_SERVER['REMOTE_ADDR']);
		$this->Payment->create();
		$this->Payment->save($paydetails);
		if($order['Order']['type']=='Group Gift')
		{
			$gpuser=$this->GroupGift->find('first',array('conditions'=>array('GroupGift.order_id'=>$order['Order']['id'],'GroupGift.other_user_id'=>$this->Session->read('User.User.id'))));
			
			$last_paid=0;
			if($payment_status==1)
			{
				$last_paid=1;	
			}
			$data=array('contri_amount_paid'=>$gpuser['GroupGift']['contri_amount_paid']+$rdp,'points_redeemed'=>'1','last_paid'=>$last_paid);
			$this->GroupGift->id=$gpuser['GroupGift']['id'];
			$this->GroupGift->save($data);
		}
		die;
	}
	
	public function admin_index()
	{
		$this->layout='admin';
		
		$payments=$this->paginate('Payment',array('joins'=>array('table'=>'users', 'alias'=>'User', 'type'=>'inner', 'conditions'=>array('User.id = Payment.user_id'))));
		
		echo '<pre>';print_r($payments);die;	
			
	}
	
	
	public function show_payment_proceed($ord_id,$userid,$payamount)
	{
		$this->layout='ajax';
		$order=$this->Order->findById($ord_id);
		$user=$this->User->findById($userid);
		$gpuser_id=0;
		if($order['Order']['group_gift_id']!=0)
		{
			$gpgift=$this->GroupGift->find('first',array('conditions'=>array('GroupGift.group_gift_id'=>$order['Order']['group_gift_id'],'other_user_id'=>$userid)));	
			
			$gpuser_id=$gpgift['GroupGift']['id'];
		}
		$sql="select voucher_name,product_name,voucher_type,price from gyftr_brand_products as BrandProduct where id in (select voucher_id from gyftr_basket B inner join gyftr_order_detail O ON (O.session_id=B.session_id) where O.id='".$ord_id."')";
		$products=$this->BrandProduct->query($sql);
		$pr_info='';
		foreach($products as $pr)
		{
			$pr_info.=$pr['BrandProduct']['voucher_name'];	
		}
		$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		$this->Session->write('txn_id',$txnid);
		$hashSequence=PayMID.'|'.$txnid.'|'.$payamount.'|'.$pr_info.'|'.$user['User']['first_name'].'|'.$user['User']['email'].'|'.$order['Order']['id'].'|'.$user['User']['id'].'|'.$gpuser_id.'||||||||'.PaySALT;
		
		$hash = strtolower(hash('sha512', $hashSequence));
		$this->Session->write('hash_sequence',$hash);
		$this->set('hash',$hash);
		$this->set('gpuser_id',$gpuser_id);
		$this->set('txnid',$txnid);
		$this->set('order',$order);
		$this->set('user',$user);
		$this->set('products',$products);
		$this->set('payamount',$payamount);
		$this->render('show_payment_proceed');	
	}
	
	
}