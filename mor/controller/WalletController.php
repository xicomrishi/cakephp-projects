<?php 

class WalletController extends AppController{

	public $helpers = array('Html','Form','Js');
	public $components = array('Session');
	public $uses = array('Wallet');
	
	public function beforeFilter(){
		parent::beforeFilter();	
	}
	
	public function admin_index(){
		
		$arrCond=array();		
		if(isset($this->request->query['filter'])){			
			$filter=$this->request->query['filter'];			
		}		
		
		if(isset($this->request->query['search_key'])){	
			$query=$this->request->query['search_key'];			
			if(!empty($query)){
				$arrCond['OR']=array('transaction_id LIKE'=>"%{$query}%",'payment_id LIKE'=>"%{$query}%",'Customer.customer_id LIKE'=>"%{$query}%");
			}	
			$this->set("SearchKey",$query);		
		}
		
		if(isset($this->request->query['start_date']) && isset($this->request->query['end_date'])){
			$this->set('StartDate',$stDate=$this->request->query['start_date']);
			$this->set('EndDate',$endDate=$this->request->query['end_date']);	
			
			if(!empty($stDate) && !empty($endDate)){
				$arrCond['AND']=array('date >='=>$stDate,'date <='=>$endDate);
			}elseif(!empty($stDate)){
				$arrCond['AND']=array('date >='=>$stDate);
			}elseif(!empty($endDate)){
				$arrCond['AND']=array('date <='=>$endDate);
			}
		}
		
		/*if(isset($this->request->query['service_type'])){	
			$query=$this->request->query['service_type'];			
			if(!empty($query)){
				$arrCond['Recharge.recharge_type']=$query;
			}	
			$this->set("service_type",$query);		
		}*/	
		
		$this->paginate = array(
			'conditions'=>$arrCond,
    		'fields'=>array('Wallet.*','Customer.name','Customer.customer_id'),
    		'limit'=>20,
			'joins'=>array(
				array('table'=>'customers','alias'=>'Customer','type'=>'inner','conditions'=>array('Wallet.customer_id=Customer.customer_id'))
			),
     		'order'=> array('Wallet.id' => 'desc')
		);		
		//pr($this->paginate('Wallet'));die;
		$wallet = $this->paginate('Wallet');		
		$this->set('wallet',$wallet);
	}
	
}