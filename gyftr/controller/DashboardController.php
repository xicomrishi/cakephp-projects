<?php
App::import('Lib',array('Facebook/facebook'));
App::import('Vendor',array('functions'));
class  DashboardController  extends AppController {

	public $helpers = array('Html', 'Form');
	public $components = array('Session','Access');
	public $uses = array('Order','GiftCategory','GiftBrand','BrandProduct','Basket','GroupGift');
	
	public function index($num=0)
	{
		$this->layout='ajax';
		$user=$this->Session->read('User');
		if($num!=2)
		{
			$orders=$this->Order->find('all',array('conditions'=>array('Order.from_id'=>$user['User']['id']),'order'=>array('Order.created DESC')));	
			$data=array(); $i=0;
			foreach($orders as $order)
			{
				$data[$i]['order']=$order;
				if($order['Order']['group_gift_id']!=0)
				{
					$get_gp=$this->GroupGift->find('all',array('conditions'=>array('GroupGift.order_id'=>$order['Order']['id'])));
					$data[$i]['order']['Order']['contri']=0;
					foreach($get_gp as $get)
					{
						if($get['GroupGift']['other_user_id']==$this->Session->read('User.User.id'))
						{	
							if(!empty($get['GroupGift']['contri_amount_paid']))
								$data[$i]['order']['Order']['contri']=$get['GroupGift']['contri_amount_paid'];					
						}
					}	
				}else{
					$data[$i]['order']['Order']['contri']=$order['Order']['amount_paid'];
				}
				$i++;
			}
			//echo '<pre>';print_r($data);die;
			$this->set('data',$data);
			if($num==1)
			{
				$this->render('show_user_gifts');	
			}
		}else{
			
			$orders=$this->Order->find('all',array('conditions'=>array('Order.from_id'=>$user['User']['id']),'order'=>array('Order.created DESC')));
			$format=array(); $j=0;
			foreach($orders as $ord)
			{
				$format[$j]['order']=$ord;
				if($ord['Order']['group_gift_id']!=0)
				{				
				$get_gp=$this->GroupGift->find('all',array('conditions'=>array('GroupGift.order_id'=>$ord['Order']['id'])));
				$format[$j]['order']['Order']['contri']=0;
				foreach($get_gp as $get)
				{
					if($get['GroupGift']['other_user_id']==$this->Session->read('User.User.id'))
					{	
						if(!empty($get['GroupGift']['contri_amount_paid']))
							$format[$j]['order']['Order']['contri']=$get['GroupGift']['contri_amount_paid'];					
					}
				}
				}else{
					$format[$j]['order']['Order']['contri']=$ord['Order']['amount_paid'];
				}
				
				$j++;	
			}		
			$gpuser=$this->GroupGift->find('all',array('conditions'=>array('GroupGift.other_user_id'=>$user['User']['id']),'order'=>array('GroupGift.order_id DESC')));
			
			$data=array(); $i=0;
			foreach($gpuser as $gp)
			{				
				$data[$i]['order']=$this->Order->find('first',array('conditions'=>array('Order.id'=>$gp['GroupGift']['order_id'])));	
				$i++;
			}
			//echo '<pre>';print_r($format);die;
			$all_data=array_merge($format,$data);
			//echo '<pre>';print_r($all_data);die;
			$final=array(); $k=0; $exist=array();
			foreach($all_data as $all)
			{
				if(!in_array($all['order']['Order']['id'],$exist))
				{	$final[$k]=$all;	
					$exist[]=$all['order']['Order']['id'];
				}
				$k++;	
			}
			//echo '<pre>';print_r($final);die;
			$this->set('data',$final);
			$this->render('show_user_gifts');	
		}
	}	
	

}