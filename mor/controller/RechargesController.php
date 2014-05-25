<?php
App::import('Vendor', array('excel-lib/Classes/PHPExcel'));
App::uses('AppController', 'Controller');
App::import('vendor','Rc43');

App::import('Vendor', array('atom-paynetz/config','atom-paynetz/submit'));//atom paynetz

class RechargesController extends AppController {

	public $name = 'Recharges';
	public $helpers = array('Html', 'Form','Js','Session');
	public $components=array('RequestHandler');
	public $uses = array('Recharge','Operator','RechargeType','Customer','EmailTemplate','Wallet');
	
	function beforeFilter(){
		parent::beforeFilter();	
		$this->Auth->allow('get_operator_notes','recharge_form','recharge_now','payment');
		
		$guestCust=$this->Session->read('GuestCustomer');
		if(isset($guestCust)){
			$this->Auth->allow('get_operator_notes','recharge_form','recharge_now','payment',
			'init_recharge','save_and_render_trans','coupon_verification');
		}	
	}
	

	public function admin_index() {		
		
		$arrCond=array('transaction_status'=>'Success','record_status NOT'=>'Trash');
		
		$options=array('Received','Processing');
		
		if(isset($this->request->query['filter'])){			
			$filter=$this->request->query['filter'];		
			if(!empty($filter)){
				
				if($filter=='Failed'){
					$arrCond['transaction_status']=array($filter,'Incomplete','Refund');
				}else{				
					$arrCond['transaction_status']=$filter;
				}
				
				$this->set("Filter",$filter);
			}
			
			/*--set options to change record status--*/
			if($filter=='Success'){
				$options=array('None','Received','Processing','Trash');
			}elseif($filter=='Processing'){
				$options=array('None','Received','Processing','Refunded','Trash');
			}elseif($filter=='Failed'){
				$options=array('None','Refunded','Processing','Trash');
			}
			/*--/set options to change record status--*/	
		}
		$this->set("RecordStatus",$options);			
		
		
		if(isset($this->request->query['search_key'])){	
			$query=$this->request->query['search_key'];			
			if(!empty($query)){
				$arrCond['OR']=array('transaction_id LIKE'=>"%{$query}%",'payment_id LIKE'=>"%{$query}%");
			}	
			$this->set("SearchKey",$query);		
		}
		
		if(isset($this->request->query['start_date']) && isset($this->request->query['end_date'])){
			$this->set('StartDate',$stDate=$this->request->query['start_date']);
			$this->set('EndDate',$endDate=$this->request->query['end_date']);	
			
			if(!empty($stDate) && !empty($endDate)){
				$arrCond['AND']=array('payment_date >='=>$stDate,'payment_date <='=>$endDate);
			}elseif(!empty($stDate)){
				$arrCond['AND']=array('payment_date >='=>$stDate);
			}elseif(!empty($endDate)){
				$arrCond['AND']=array('payment_date <='=>$endDate);
			}
		}
		
		if(isset($this->request->query['service_type'])){	
			$query=$this->request->query['service_type'];			
			if(!empty($query)){
				$arrCond['Recharge.recharge_type']=$query;
			}	
			$this->set("service_type",$query);		
		}
		
		
		$this->paginate = array(
			'conditions'=>$arrCond,
    		'fields'=>array('Recharge.*','Operator.name','Customer.name','Customer.customer_type','RechargeType.recharge_type'),
    		'limit'=>20,
     		'order'=> array('Recharge.id' => 'desc')
		);		
		$rech = $this->paginate('Recharge');
		$this->set('Recharges',$rech);
	}
	
	public function admin_change_recharge_status(){
		
		if ($this->request->is('post')) {
			
			$status=$this->request->data['RechargeStatusAction'];
			$reIds=$this->request->data['RechargeIds'];
					
			if($reIds){
				
				$data=array();				
				$tempData=array();
				foreach($reIds as $rId){
					$tempData['Recharge']['id']=$rId;
					$tempData['Recharge']['record_status']=$status;						 	
					$data[]=$tempData;
				}			
				if($this->Recharge->saveAll($data)){
					$this->Session->setFlash(__('Record(s) updated successfully'),'default',array('class'=>'success'));
				}else{
					$this->Session->setFlash(__('Record(s) was not updated'),'default',array('class'=>'error'));						
				}
			}else{
				$this->Session->setFlash(__('Please select at least one row.'),'default',array('class'=>'error'));				
			}
		}		
		//$this->admin_index();
		$this->redirect($_SERVER['HTTP_REFERER']);		
	}
	
	public function recharge_now(){			
		
		/*--recharge type/ curent tab--*/
		$reType=1;
		if($this->request->query('c_tab')){
			$reType=$this->request->query('c_tab');
		}		
		/*--/recharge type/ curent tab--*/
			
		/*-verify number number and oprator-*/
			
		if($this->request->is("post") && isset($this->request->data)){			
			
			/*--check recharge option enable/disable--*/
			$this->loadModel('Setting');
			$rOption = $this->Setting->findByKey('recharge_option');
		
			if(empty($rOption) || $rOption['Setting']['value']=='Inactive'){
				$this->Session->setFlash(__("We are upgrading our systems. Please try again later",true),'default',array('class'=>'error recharge effect7'),'recharge');
				$this->redirect(array('controller'=>'recharges','action'=>'recharge_now'));
	            die;
			}
			
			/*--/check recharge option enable/disable--*/		
			
			$this->set('ReqData',$this->request->data);
			$this->Recharge->set($this->request->data);
			
			$this->Recharge->resetValidationRule();
			
			$arrToValidate=array();			
			$arrToValidate[]='number';
			$additionalParam='';			
			
			if(!empty($this->request->data['Recharge']['input2'])){
				$arrToValidate[]='account';
				$additionalParam=$this->request->data['Recharge']['account'];
			}
			
			$arrToValidate[]='operator_id';
			$arrToValidate[]='amount';
			$arrToValidate[]='type';
			
				
			if($this->Recharge->validates(array('fieldList'=>$arrToValidate))){
			
				$phNbr=trim($this->request->data['Recharge']['number']);
				$opId=trim($this->request->data['Recharge']['operator_id']);
				$amount=trim($this->request->data['Recharge']['amount']);
				$reType=trim($this->request->data['Recharge']['type']);				
			
				$arrReType=$this->RechargeType->findById($reType,array('recharge_type','service_charge'));
				$reTypeName=$arrReType['RechargeType']['recharge_type'];			
			
				$opName=$this->Operator->findById($opId,array('name'));
				if(!empty($opName)){
					$optName=$opName['Operator']['name'];	
				}			
				
				/*--apply services charges--*/						
				$serviceCharge=floatval($arrReType['RechargeType']['service_charge']);	
				$tamount=$amount+$serviceCharge;
				/*--/ apply services charges--*/				

				$cartData=array('Cart'=>array('Operator'=>$optName,											
								'Number'=>$phNbr,
								'Amount'=>$amount,
								'TotalAmount'=>$tamount,
								'ReType'=>$reTypeName,
								'ServiceCharge'=>$serviceCharge,
								'Account'=>$additionalParam));
								
				$this->Session->write('Cart',$cartData);
				
				$transData=array('TransactionId'=>0,
			  				'OperatorId'=>$opId,											
			   				'RequestMessage'=>null,
							'Session'=>0,
							'PhoneNumber'=>$phNbr,
							'Amount'=>$amount,
							'TotalAmount'=>$tamount,
							'ServiceCharge'=>$serviceCharge,
							'ReType'=>$reType,
							'NbrVerification'=>null,
							'Extra'=>$cartData['Cart']
							);			
				
				try{	
					
					$secKey = file_get_contents('../Vendor/iprivpg/keys/secret.key');
					$pubKey = file_get_contents('../Vendor/iprivpg/keys/pubkeys.key');
					$passwd = CYBERPLAT_PASSWORD;
					
					$sessPrefix=rand(100,300);
					$sess=$sessPrefix.$phNbr.time();
					$sess=substr($sess,-20);
													
					$querString="SD=".CYBERPLAT_SD."\n\rAP=".CYBERPLAT_AP."\n\rOP=".CYBERPLAT_OP."\n\rSESSION=$sess\n\rNUMBER=$phNbr\n\rAMOUNT=$amount\n\rAMOUNT_ALL=$amount\n\rCOMMENT=MOR recharge";
				   
					if(isset($this->request->data['Recharge']['account']) && !empty($this->request->data['Recharge']['account'])){
							
						$account=$this->request->data['Recharge']['account'];
						$querString="SD=".CYBERPLAT_SD."\n\rAP=".CYBERPLAT_AP."\n\rOP=".CYBERPLAT_OP."\n\rSESSION=$sess\n\rNUMBER=$phNbr\n\rACCOUNT=$account\n\rAMOUNT=$amount\n\rAMOUNT_ALL=$amount\n\rCOMMENT=MOR recharge";					
					}
					
					$errCode=null;
					$rsCode=null;			
					
					$signInRes = ipriv_sign($querString, $secKey, $passwd);				
					
					$signInStatus=$signInRes[0];
					if($signInStatus===0){
						$signInMsg=$signInRes[1];
						$verifyRes = ipriv_verify($signInMsg, $pubKey);
						$verifyStatus=$verifyRes[0];							
						
						if($verifyStatus===0){
							
							$url=$this->Operator->findById($opId,array('op_verification_url'));
							$url=$url['Operator']['op_verification_url'];
						
							$phoneVerificationRes=$this->Recharge->getQueryResult($signInMsg,$url);
					
							$errStatus=array();
							$rsStatus=array();
							
							preg_match('/ERROR=(.*)/', $phoneVerificationRes, $errStatus);
							preg_match('/RESULT=(.*)/', $phoneVerificationRes, $rsStatus);
												
							if($errStatus && $errStatus[1]==0 && $rsStatus[1]==0){
							
								$transactionId = array();
								preg_match('/TRANSID=(.*)/', $phoneVerificationRes, $transactionId);
								$transactionId=$transactionId[1];								
								
								$account = array();
								preg_match('/ACCOUNT=(.*)/', $phoneVerificationRes, $account);
								
								if(!empty($account)){
									$account=$account[1];
								}
								
								$transData['TransactionId']=$transactionId;
								$transData['NbrVerification']='success';	
								$transData['RequestMessage']=$signInMsg;
						 		$transData['Session']=$sess;	
								
								$this->Session->write('Transaction',$transData);	
								$this->redirect("/recharges/payment");
								die;
								
							}else{
								$errCode=$errStatus[1];
								$rsCode=$rsStatus[1];
							}													
						}else{
							$errCode=$verifyStatus;
						}
					}else{
						$errCode=$signInStatus;
					}
					
					if($errCode){
						
						$errMsg=$this->Recharge->cpErrors[intval($errCode)];
						if(!$errMsg){
							$errMsg="Invalid request.";
						}
						$this->Session->setFlash(__($errMsg,true),'default',array('class'=>'error recharge effect7'),'recharge');	
					}				
				}catch(Exception $e){echo $e;}
				
			}else{
				$errors = 'Please correct the following validation error(s):<br/>';
				foreach($this->Recharge->validationErrors as $err) {
				    foreach ($err as $k => $v) {
				        $errors .='-'.$v.'<br/>';  
				    }
				}
				$this->Session->setFlash(__($errors,true),'default',array('class'=>'error recharge effect7'),'recharge');
			}
		}		
		
		/*-[end]verify number number and oprator-*/	
		$this->set('title_for_layout','My Online Recharge');
		
		/*--load home page contents--*/
		$this->loadModel('Content');
   		$this->Content->recursive=0;
   		
   		$content=$this->Content->find('all',array('conditions'=>
   		array('page_slug IN'=>array('home_page_more_content','home_page_content'),'status'=>'Publish')));
   		  		
   		if($content){
   			foreach($content as $row){
   				$this->set($row['Content']['page_slug'],$row['Content']);
   			}
   		}   		
		/*--/load home page contents--*/		

   		/*--load recharge form--*/
   		$this->recharge_form($reType);
		$view = new View($this, false);
		$reccForm= $view->render('recharge_form','ajax');
   		$this->set('RechargeForm',$reccForm);
   		/*--load recharge form--*/
	}
	
	
	public function payment(){	
									
		$customer=$this->Auth->user();	
	
		if(!empty($customer)){
			$customer=$this->Customer->findByCustomerId($customer['customer_id']);
			$customer=$customer['Customer'];	
		}
		
		if(!$customer){
			$customer=$this->Session->read('GuestCustomer');
		}		
		
		if(!$customer){	
			$this->redirect(array('controller'=>'customers','action'=>'recharge_auth'));
            die;
				
		}else{						
			
			$this->set('customer',$customer);
	        $trans=$this->Session->read('Transaction');			
			if($trans && $trans['NbrVerification']=='success'){       	
			
				if($this->request->is('post') && !empty($this->request->data)){						   	
					
					if($this->request->data['payment_type']=='my_wallet'){
						if($customer['wallet_current_amount']<$trans['TotalAmount']){
							
							$this->Session->setFlash(__("Wallet does not have sufficient balance.",true),'default',array('class'=>'error recharge effect7'),'recharge');
							$this->redirect(array('controller'=>'recharges','action'=>'recharge_now'));
							die;	
						}	
					}
						
	        		$this->Recharge->create();							   			
	        		$discount=0;
	        		if(isset($trans['Discount']) && isset($trans['CouponId']) && !empty($trans['CouponId'])){
	        			$discount=$trans['Discount'];//if coupon is used	        			
	        		}
					if(isset($trans['CouponCode']) && !empty($trans['CouponCode'])){
	        			$coupon_code=$trans['CouponCode'];//if coupon is used	        			
	        		}else{
						$coupon_code=null;	
					}
	        		
					$arrReDetails=array('Recharge'=>array(   			
						'customer_id'=>$customer['customer_id'],
						'recharge_type'=>$trans['ReType'],
						'number'=>$trans['PhoneNumber'],
						'operator_id'=>$trans['OperatorId'],
						'amount'=>$trans['Amount'],
						'service_charge'=>$trans['ServiceCharge'],
						'discount'=>$discount,
						'total_amount'=>$trans['TotalAmount'],
						'transaction_id'=>$trans['TransactionId'],
						'recharge_session_id'=>$trans['Session'],
						'payment_date'=>date('Y-m-d H:i:s'),
						'customer_ip_address'=>$_SERVER['REMOTE_ADDR'],
						'account_param'=>$trans['Extra']['Account'],
						'coupon_code'=>$coupon_code								
					));
					
					/*--update payment mode--*/
					if($this->request->data['payment_type']=='net_banking'){
						$arrReDetails['Recharge']['payment_mode']='Net Banking';
					}elseif($this->request->data['payment_type']=='debit_card'){
						$arrReDetails['Recharge']['payment_mode']='Debit Card';
					}elseif($this->request->data['payment_type']=='credit_card'){
						$arrReDetails['Recharge']['payment_mode']='Credit Card';
					}else if($this->request->data['payment_type']=='my_wallet'){
						$arrReDetails['Recharge']['payment_mode']='Wallet';
					}
					
					/*--/update payment mode--*/					
					if($insertedData=$this->Recharge->save($arrReDetails)){
												
						/*--update recharge attempt--*/						
						$noa=$this->Customer->findByCustomerId($customer['customer_id'],array('number_of_attempts','wallet_current_amount'));						
											
						$noOfAttempt=(int)$noa['Customer']['number_of_attempts'];
						$noOfAttempt++;
						$this->Customer->id=$customer['customer_id'];						
						$this->Customer->save(array('Customer'=>array('number_of_attempts'=>$noOfAttempt)));						
						/*--/update recharge attempt--*/
						
						$reId=$insertedData['Recharge']['id'];
					
						$trans['RechargeId']=$reId;
						$this->Session->write('Transaction',$trans); 
						
						/*--deduct customer wallet balance if pay from wallet--*/
						if($arrReDetails['Recharge']['payment_mode']=='Wallet'){
							$newWallet = (float)$noa['Customer']['wallet_current_amount']-(float)$insertedData['Recharge']['total_amount'];
							
							$this->Customer->id=$customer['customer_id'];
							$this->Customer->save(array('wallet_current_amount'=>$newWallet));
							
							$reqMsg=$trans['RequestMessage'];
							$sess=$trans['Session'];
							$opId=$trans['OperatorId'];		
										
							$trans['PaymentId']='NA';	
							
							$wallet=array('Wallet'=>array('customer_id'=>$customer['customer_id'],'type'=>'Debit','amount'=>$insertedData['Recharge']['total_amount'],'payment_mode'=>$insertedData['Recharge']['payment_mode'],'refund'=>'No','transaction_id'=>$insertedData['Recharge']['transaction_id'],'date'=>date("Y-m-d H:i:s"),'recharge_id'=>$insertedData['Recharge']['id'],'wallet_current_amount'=>$newWallet));			
					
							$this->Wallet->create();
							$this->Wallet->save($wallet);
									
							$this->Session->write('action','dorecharge');							
							$recharge=$this->do_recharge($reqMsg,$sess,$opId);							
							$this->save_and_render_trans($recharge,$trans);
																					
						}else{
					
							if($this->request->data['payment_type']=='net_banking' || $this->request->data['payment_type']=='debit_card' || $this->request->data['payment_type']=='credit_card'){
								$obPPayment=new ProcessPayment();
								$redirectURL=$obPPayment->requestMerchant(array('Amount'=>$trans['TotalAmount'],'TempTransCode'=>base64_encode($trans['TransactionId'])));
								$this->redirect($redirectURL);
							}else{
								$this->Session->setFlash(__("The selected payment method is not active",true),'default',array('class'=>'error recharge effect7'),'recharge');
								$this->redirect(array('controller'=>'recharges','action'=>'recharge_now'));
								die;
							}
						}
					}else{
	        			$this->Session->setFlash(__("Invalid request",true),'default',array('class'=>'error recharge effect7'),'recharge');
						$this->redirect(array('controller'=>'recharges','action'=>'recharge_now'));
            			die;
	        		}       
	        	}
				
			}else{/*--phone verification status check--*/
				$this->Session->setFlash(__("Invalid request",true),'default',array('class'=>'error recharge effect7'),'recharge');
				$this->redirect(array('controller'=>'recharges','action'=>'recharge_now'));
            	die;
			}        		    	
		}		
		
		/*--set content for the page--*/
		$this->loadModel('Content');
		$content=$this->Content->find('all',array('conditions'=>
   		array('page_slug'=>'payment_page','status'=>'Publish')));
   		if($content){
   			foreach($content as $row){
   				$this->set($row['Content']['page_slug'],$row['Content']);
   			}
   		}  
   		
		$this->loadModel('Setting');
		$cOption = $this->Setting->findByKey('coupon_option');
		$this->set('CouponSetting',$cOption['Setting']['value']);
			
		/*--/set content for the page--*/		
	}

	
	/*--actions for coupon uses--*/
	function coupon_verification(){
		
		$this->layout='ajax';
		$customer=$this->Auth->user();		
		
		if(!$customer){
			$customer=$this->Session->read('GuestCustomer');
		}
		if(!$customer || $customer['customer_id']==''){	
			echo json_encode(array('status'=>0,'message'=>"<p class='error'>Your session has expired. Please login to continue.</p>"));
			die;			
		}

		/*-- check coupon setting by admin--*/
		$this->loadModel('Setting');
		$cOption = $this->Setting->findByKey('coupon_option');
		$this->set('CouponSetting',$cOption['Setting']['value']);
		if(empty($cOption) || $cOption['Setting']['value']=='Inactive'){
			echo json_encode(array('status'=>0,'message'=>"<p class='error'>Coupon facility is currently disabled. Please try after some time.</p>"));
			die;
		}
		
		if(isset($this->request->data['Coupon']['coupon_code']) && !empty($this->request->data['Coupon']['coupon_code'])){
			
			/*---verify guest customer---------*/
			$guest=$this->Session->read('GuestCustomer');
			if(!$guest){
			
			$this->loadModel('Coupon');
			$this->loadModel('CouponUse');
			$coupon=$this->Coupon->findByCouponCodeAndCouponStatus($this->request->data['Coupon']['coupon_code'],'Active');
			
			
			if($coupon){				
				
				$trans=$this->Session->read('Transaction');	
									
				if($trans && $trans['NbrVerification']=='success'){
									
					/*----Check if coupon used earlier against this phone number----*/
					$already=$this->CouponUse->find('all',array('conditions'=>array('CouponUse.coupon_id'=>$coupon['Coupon']['coupon_id'],'Recharge.number'=>$trans['PhoneNumber'])));
					if(count($already)>0){
						echo json_encode(array('status'=>0,'message'=>"<p class='error'>Coupon already used against this number.</p>"));
						die;	
					}
					
					
					/*--coupon validations--*/
					//verify coupon min amount
					if($trans['Amount']<$coupon['Coupon']['min_amount']){
						echo json_encode(array('status'=>0,'message'=>"<p class='error'>Mininmun amount of Rs. {$coupon['Coupon']['min_amount']} is required to apply this Coupon.</p>"));
						die;
					}
					//verify coupon start date
					$now=strtotime(date('Y-m-d'));
					if(!empty($coupon['Coupon']['start_date']) && $coupon['Coupon']['start_date']!="0000-00-00"){
						if(strtotime($coupon['Coupon']['start_date'])>$now){
							echo json_encode(array('status'=>0,'message'=>"<p class='error'>The Coupon can be used from {$coupon['Coupon']['start_date']}.</p>"));
							die;
						}
					}					
					
					//verify coupon end date
					if(!empty($coupon['Coupon']['end_date']) && $coupon['Coupon']['end_date']!="0000-00-00"){
						if(strtotime($coupon['Coupon']['end_date'])<$now){
							echo json_encode(array('status'=>0,'message'=>"<p class='error'>The end date to apply this Coupon was {$coupon['Coupon']['end_date']}.</p>"));
							die;
						}
					}
					
					//verify coupon max usages
					$totalUse=$this->CouponUse->find('all',array('conditions'=>array(
						'CouponUse.coupon_id'=>$coupon['Coupon']['coupon_id']),
					'fields'=>array("COUNT('uses_id') AS total_use")));

					$totalUses=$totalUse[0][0]['total_use'];	
									
					if($coupon['Coupon']['max_uses']<=$totalUses){
						echo json_encode(array('status'=>0,'message'=>"<p class='error'>The maximum uses limit for the Coupon is exceeded.</p>"));
						die;
					}
					
					//verify coupon service type					
					if(!empty($coupon['Coupon']['recharge_type_id'])){
						$arrRType=explode(',', $coupon['Coupon']['recharge_type_id']);
						if(!in_array($trans['OperatorId'], $arrRType)){
							echo json_encode(array('status'=>0,'message'=>"<p class='error'>Invalid Coupon Code for this service type.</p>"));
							die;
						}
					}
					
					//verify either this coupon is appied or not for this transaction					
					if(isset($trans['CouponId']) && !empty($trans['CouponId'])){
						json_encode(array('status'=>0,'message'=>"<p class='error'>A coupon is already used for this transaction.</p>"));
						die;
					}
					/*--/coupon validations--*/				
					
					$couponAmount=$coupon['Coupon']['coupon_price'];
					$totalAmount=$trans['TotalAmount'];
					$totalAmount=floatval($totalAmount-$couponAmount);
					$trans['TotalAmount']=$totalAmount;
					$trans['Discount']=$couponAmount;
					$trans['CouponCode']=$coupon['Coupon']['coupon_code'];
					$trans['CouponId']=$coupon['Coupon']['coupon_id'];
					$this->Session->write('Transaction',$trans);
					//update cart					
					$cart=$this->Session->read('Cart');
					$cart['Cart']['Discount']=$couponAmount;
					$cart['Cart']['TotalAmount']=$totalAmount;
					$this->Session->write('Cart',$cart);
					
					echo json_encode(array('status'=>1,
					'message'=>"<p class='success'>Coupon successfully applied. You are getting a discount of Rs.".$couponAmount." for this transaction</p>",
					'discount'=>$couponAmount,
					'totalAmount'=>$totalAmount));
					die;				
				}					
				
			}else{
				echo json_encode(array('status'=>0,'message'=>"<p class='error'>The given Coupon Code is invalid.</p>"));
				die;
			}
			
			}else{
				echo json_encode(array('status'=>0,'message'=>"<p class='error'>Please register to use recharge coupons.</p>"));
				die;
			}
			
		}else{
			echo json_encode(array('status'=>0,'message'=>"<p class='error'>The field Coupon Code can not be empty.</p>"));
			die;
		}
		die;
	}
	
	/*--/actions for coupon uses--*/
	
	
	/*--actions used for wallet--*/
	public function payment_wallet(){
		$customer=$this->Auth->user();		
		
		if(!empty($customer)){
			$customer=$this->Customer->findByCustomerId($customer['customer_id']);
			$customer=$customer['Customer'];	
		}
		
		if(!$customer){
			$customer=$this->Session->read('GuestCustomer');
		}		
		
		if(!$customer){	
			$this->redirect(array('controller'=>'customers','action'=>'recharge_auth'));
            die;
				
		}else{						
				
			$this->set('customer',$customer);
			if($this->request->is('post') && !empty($this->request->data)){	
				
				if(!empty($this->request->data['wallet_recharge_type']) && !empty($this->request->data['wallet_recharge_amount'])){
					
					/*--update payment mode--*/
					if($this->request->data['wallet_recharge_type']=='net_banking'){
						$this->request->data['wallet_recharge_type']='Net Banking';
					}elseif($this->request->data['wallet_recharge_type']=='debit_card'){
						$this->request->data['wallet_recharge_type']='Debit Card';
					}elseif($this->request->data['wallet_recharge_type']=='credit_card'){
						$this->request->data['wallet_recharge_type']='Credit Card';
					}					
					/*--/update payment mode--*/
					
					$transId=time().$customer['customer_id'];					
					
					$wallet=array('Wallet'=>array('customer_id'=>$customer['customer_id'],'type'=>'Credit','payment_mode'=>$this->request->data['wallet_recharge_type'],'amount'=>$this->request->data['wallet_recharge_amount'],'refund'=>'No','transaction_id'=>$transId,'date'=>date("Y-m-d H:i:s")));
				
					$this->Wallet->create();
					$walletInfo=$this->Wallet->save($wallet);	
					
					$obp=new ProcessPayment();
					$redirectWalletURL=$obp->requestMerchant(array('Amount'=>$this->request->data['wallet_recharge_amount'],'TempTransCode'=>base64_encode($transId),'WalletRechargeId'=>$walletInfo['Wallet']['id']));
					$this->redirect($redirectWalletURL);
				}else{
					$this->Session->setFlash(__("Invalid request",true),'default',array('class'=>'error recharge effect7'),'recharge');
					$this->redirect(array('controller'=>'customers','action'=>'profile'));
            		die;
				}
				
			}else{
				$this->Session->setFlash(__("Invalid request",true),'default',array('class'=>'error recharge effect7'),'recharge');
				$this->redirect(array('controller'=>'customers','action'=>'profile'));
            	die;	
			}
		}
	}
	
	public function init_wallet_recharge(){
		
		$customer=$this->Auth->user();		
		if(!$customer){
			$customer=$this->Session->read('GuestCustomer');
		}
		
		if(!$customer || $customer['customer_id']==''){	
			$this->Session->setFlash(__("Your session has expired. Please login to continue.",true),'default',array('class'=>'error recharge effect7'),'recharge');
			$this->redirect(array('controller'=>'customers','action'=>'recharge_auth'));
            die;
			
		}	
		
		if(isset($_POST['udf9']) && !empty($_POST['udf9']) && isset($_POST['f_code']) && $_POST['f_code']=="Ok"){
			
			
			$data=explode("|",$_POST['udf9']);
			if(isset($data[1]) && !empty($data[1])){
				
				$wallet=$this->Wallet->findById($data[1]);
				if(!empty($wallet) && $data[0]==base64_encode($wallet['Wallet']['transaction_id'])){
					
					$customer=$this->Customer->findByCustomerId($wallet['Wallet']['customer_id']);
					$newWallet = (float)$customer['Customer']['wallet_current_amount']+(float)$_POST['amt'];
					
					/*-- update wallet transaction entries--*/
					$this->Wallet->id=$wallet['Wallet']['id'];
					$this->Wallet->save(array('payment_id'=>$_POST['bank_txn'],'merchant_ref_no'=>$_POST['mer_txn'],'atom_trans_id'=>$_POST['mmp_txn'],'wallet_current_amount'=>$newWallet));
		
					/*--add payment_log to db--*/
					$this->loadModel('TransactionLog');
					$arrLogData=array('TransactionLog'=>array('key'=>'payment_log','value'=>serialize($_POST),'wallet_transaction_id'=>$wallet['Wallet']['id']));
					$this->TransactionLog->save($arrLogData);
					/*--/add payment_log to db--*/					
					
					$this->Customer->id=$customer['Customer']['customer_id'];
					$this->Customer->save(array('wallet_current_amount'=>((float)$customer['Customer']['wallet_current_amount']+(float)$wallet['Wallet']['amount'])));
					$this->Session->setFlash(__("Funds were successfully added to your wallet.",true),'default',array('class'=>'success effect7'));
					$this->redirect(array('controller'=>'customers','action'=>'profile'));
					
				}else{
					$flag=1;					
				}
			}else{
				$flag=1;	
			}
		}else{
			$flag=1;	
		}
		
		if(isset($flag)){
			
			if(isset($_POST['amt'])){
				$data=explode("|",$_POST['udf9']);
				if(isset($data[1]) && !empty($data[1])){
				
					$wallet=$this->Wallet->findById($data[1]);
					$customer=$this->Customer->findByCustomerId($customer['customer_id']);
					$newWallet = (float)$customer['Customer']['wallet_current_amount'];
					
					/*-- update wallet transaction entries--*/
					$this->Wallet->id=$wallet['Wallet']['id'];
					$this->Wallet->save(array('merchant_ref_no'=>$_POST['mer_txn'],'atom_trans_id'=>$_POST['mmp_txn'],'wallet_current_amount'=>$newWallet));
				}
			}
			
			//destroy guest customer Session
			$this->Session->delete('GuestCustomer');
			unset($_SESSION['GuestCustomer']);
			$this->Session->setFlash(__("Invalid request.",true),'default',array('class'=>'error recharge effect7'));
			$this->redirect(array('controller'=>'recharges','action'=>'recharge_now'));
			die;				
		}
	}
	/*--actions used for wallet--*/
	
	
	public function init_recharge(){		
			
		$customer=$this->Auth->user();		
		if(!$customer){
			$customer=$this->Session->read('GuestCustomer');
		}
		
		if(!$customer || $customer['customer_id']==''){	
			$this->Session->setFlash(__("Your session has expired. Please login to continue.",true),'default',array('class'=>'error recharge effect7'),'recharge');
			$this->redirect(array('controller'=>'customers','action'=>'recharge_auth'));
            die;
			
		}		
			/*--payment return for Atom Paynetz--*/
			$trans=$this->Session->read('Transaction');	
			$reqMsg=$trans['RequestMessage'];
			$sess=$trans['Session'];
			$opId=$trans['OperatorId'];
			$this->Session->delete('Transaction');	
			unset($_SESSION['Transaction']);
			
			if($trans && isset($_POST['f_code']) && $_POST['udf9']==base64_encode($trans['TransactionId']) && $trans['RechargeId']) {
								
				/*--add payment_log to db--*/
				$this->loadModel('TransactionLog');
				$arrLogData=array('TransactionLog'=>array('key'=>'payment_log','value'=>serialize($_POST),'recharge_id'=>$trans['RechargeId']));
				$this->TransactionLog->save($arrLogData);
				/*--/add payment_log to db--*/
				
				$nbrVerifiction=$trans['NbrVerification'];	
				$rechargeId= $trans['RechargeId'];
				$this->Recharge->id=$rechargeId;
				
				if($_POST['f_code']=="Ok" && $nbrVerifiction=='success'){
				
					/*-- update payment--*/
					 $arrPayments=array('Recharge'=>array(
						'atom_trans_id'=>$_POST['mmp_txn'],
						'marchant_ref_no'=>$_POST['mer_txn'],
						'payment_id'=>$_POST['bank_txn'],
						'payment_status'=>1			
					));
					
					$this->Recharge->id=$trans['RechargeId'];
					$this->Recharge->save($arrPayments,false);
					/*-- /update payment--*/
					
					/*--do recharge--*/
					$trans['PaymentId']=$_POST['bank_txn'];
					
					$this->Session->write('action','dorecharge');			
					$recharge=$this->do_recharge($reqMsg,$sess,$opId);
					$this->save_and_render_trans($recharge,$trans);
					/*--/do recharge--*/				
					
					
				}else{
					//destroy guest customer Session	
	
					/*-- update payment--*/
					 $arrPayments=array('Recharge'=>array(
						'atom_trans_id'=>$_POST['mmp_txn'],
						'marchant_ref_no'=>$_POST['mer_txn'],
						'payment_id'=>$_POST['bank_txn'],
						'payment_status'=>0,
						'transaction_status'=>'Failed'	
					));
					
					$this->Recharge->id=$trans['RechargeId'];
					$this->Recharge->save($arrPayments,false);
					/*-- /update payment--*/
					
					$this->transaction_email('payment_gateway_failed',$trans,$customer);//send failed transaction error.				
					
					$this->Session->delete('GuestCustomer');
					unset($_SESSION['GuestCustomer']);
					$this->Session->setFlash(__("Your Payment was not successful. Please try again.",true),'default',array('class'=>'error recharge effect7'));
					$this->redirect(array('controller'=>'recharges','action'=>'recharge_now'));
					die;
				}
			}else{
					//destroy guest customer Session
					$this->Session->delete('GuestCustomer');
					unset($_SESSION['GuestCustomer']);
					$this->Session->setFlash(__("Invalid request.",true),'default',array('class'=>'error recharge effect7'));
					$this->redirect(array('controller'=>'recharges','action'=>'recharge_now'));
					die;
			}		
		/*--payment return for Atom Paynetz--*/
		
	}
	
	public function save_and_render_trans($recharge,$trans){			
		
		$customer=$this->Auth->user();		
		if(!$customer){
			$customer=$this->Session->read('GuestCustomer');
		}
		
		if(!$customer || $customer['customer_id']==''){	
			$this->Session->setFlash(__("Your session has expired. Please login to continue.",true),'default',array('class'=>'error recharge effect7'),'recharge');
			$this->redirect(array('controller'=>'customers','action'=>'recharge_auth'));
            die;			
		}
		
		$action=$this->Session->read('action');
		
		$this->Session->delete('action');
		unset($_SESSION['action']);
		
		if($customer && $action=='savetransaction'){		
		
			$arrRes=array('Recharge'=>
					array('recharge_payment_error_code'=>$recharge['recharge_payment_error_code'],
						'recharge_payment_result_code'=>$recharge['recharge_payment_result_code'],
						'recharge_payment_status'=>$recharge['recharge_payment_status'],
						'recharge_payment_verification_error_code'=>$recharge['recharge_payment_verification_error_code'],
						'recharge_payment_verification_result_code'=>$recharge['recharge_payment_verification_result_code'],
						'recharge_status'=>$recharge['recharge_status'],
						'response_code'=>$recharge['response_code'],
						'recharge_date'=>$recharge['recharge_date']
				));			
				
			if($recharge['recharge_payment_status']==1 && $recharge['recharge_status']==1 && $recharge['response_code']==0){
			   $this->Session->setFlash(__("Congratulations! Your transaction was successfully processed.",true),'default',array('class'=>'success effect7'));
				/*--save discount or coupon uses details--*/					
				if(isset($trans['Discount']) && isset($trans['CouponId']) && !empty($trans['CouponId'])){
					$arrCouponData=array('CouponUse'=>array('coupon_id'=>$trans['CouponId'],
					'customer_id'=>$customer['customer_id'],
					'recharge_id'=>$trans['RechargeId']));
					$this->loadModel('CouponUse');
					$this->CouponUse->create();
					$this->CouponUse->save($arrCouponData);
				
				}/*--/save discount or coupon uses details--*/	
				
				$this->transaction_email('successful_transaction',$trans,$customer);
				$trans['TransactionStatus']='success';
				
				$this->set('Transaction',$trans);	
				$arrRes['Recharge']['transaction_status']='Success';	
				
				/*--update success trans count--*/						
				$succet=$this->Customer->findByCustomerId($customer['customer_id'],array('successful_transactions','wallet_current_amount'));				
				
				$succetrans=(int)$succet['Customer']['successful_transactions'];
				$succetrans++;
				$this->Customer->id=$customer['customer_id'];						
				$this->Customer->save(array('Customer'=>array('successful_transactions'=>$succetrans)));						
				/*--/update success trans count--*/
						
			}elseif($recharge['recharge_payment_status']==1 && $recharge['recharge_status']==0 && $recharge['response_code']==0){
				$this->Session->setFlash(__("Your transaction is being processed.  We will send you an email as soon as it is successfully completed.",true),'default',array('class'=>'success effect7'));
				
				/*--save discount or coupon uses details--*/					
				if(isset($trans['Discount']) && isset($trans['CouponId']) && !empty($trans['CouponId'])){
					$arrCouponData=array('CouponUse'=>array('coupon_id'=>$trans['CouponId'],
					'customer_id'=>$customer['customer_id'],
					'recharge_id'=>$trans['RechargeId']));
					$this->loadModel('CouponUse');
					$this->CouponUse->create();
					$this->CouponUse->save($arrCouponData);
				
				}/*--/save discount or coupon uses details--*/				
				
				$this->transaction_email('processing_transaction',$trans,$customer);
				
				$trans['TransactionStatus']='processing';
				$this->set('Transaction',$trans);	
				$arrRes['Recharge']['transaction_status']='Processing';				
			      					
			}else{
				
				$trans['TransactionStatus']='failed';
				$this->set('Transaction',$trans);
				$arrRes['Recharge']['transaction_status']='Refund';
							
				
				/*--Refund amount to customer wallet if transaction failed--*/	
				$rechargeInfo=$this->Recharge->findById($trans['RechargeId']);
				
				$customerInfo=$this->Customer->findByCustomerId($rechargeInfo['Recharge']['customer_id']);
				$newWalletAmount=(float)$customerInfo['Customer']['wallet_current_amount']+(float)$rechargeInfo['Recharge']['total_amount'];			
					
				$wallet=array('Wallet'=>array('customer_id'=>$rechargeInfo['Recharge']['customer_id'],'type'=>'Credit','amount'=>$rechargeInfo['Recharge']['total_amount'],'payment_mode'=>$rechargeInfo['Recharge']['payment_mode'],'merchant_ref_no'=>$rechargeInfo['Recharge']['marchant_ref_no'],'refund'=>'Yes','payment_id'=>$rechargeInfo['Recharge']['payment_id'],'transaction_id'=>$rechargeInfo['Recharge']['transaction_id'],'atom_trans_id'=>$rechargeInfo['Recharge']['atom_trans_id'],'date'=>date("Y-m-d H:i:s"),'recharge_id'=>$trans['RechargeId'],'wallet_current_amount'=>$newWalletAmount));
				
				$this->Wallet->create();
				$this->Wallet->save($wallet);				
				
				/*------\Refund amount to customer wallet if transaction failed-----*/
				
				$this->Customer->id=$rechargeInfo['Recharge']['customer_id'];
				$this->Customer->save(array('wallet_current_amount'=>$newWalletAmount));
								
				$errMsg="Your transaction failed.  We regret the inconvenience.  Please check your email for refund details.";
							
				$this->Session->setFlash(__($errMsg,true),'default',array('class'=>'error effect7'));
				$this->transaction_email('failed_transaction',$trans,$customer);							
			}		
			
			$this->Recharge->id=$trans['RechargeId'];
			$this->Recharge->save($arrRes,false);//save transaction		
			
			/*--set content for the page--*/
			$this->loadModel('Content');
			$content=$this->Content->find('all',array('conditions'=>
	   		array('page_slug'=>'recharge_history_page','status'=>'Publish')));
	   		if($content){
	   			foreach($content as $row){
	   				$this->set($row['Content']['page_slug'],$row['Content']);
	   			}
	   		}
				   		
	   		//destroy guest customer Session
	   		$this->Session->delete('GuestCustomer');
	   		unset($_SESSION['GuestCustomer']);   		
			
			/*--/set content for the page--*/
			$this->render('recharge_history');		
		}				
	}
	
	private function transaction_email($templateKey,$trans,$customer){		
				 	
	 	$to=$customer['email'];								
		$name=$customer['name'];
		$from="info@myonlinerecharge.com";
		if($templateKey){				

			$template = $this->EmailTemplate->find('first',
				 array('conditions' => array('template_key'=> $templateKey,
			  	 'template_status' =>'Active')));
					
			if($template){	
				$arrFind=array('{name}','{transaction_id}','{email}','{wallet_amount}','{payment_amount}');
				$arrReplace=array($name,$trans['TransactionId'],$to,0,$trans['Amount']);							
				$from=$template['EmailTemplate']['from_email'];
				$subject=$template['EmailTemplate']['email_subject'];
				$content=str_replace($arrFind, $arrReplace,$template['EmailTemplate']['email_body']);					
				$this-> sendEmail($to,$from,$subject,$content);				
					
			}
			/*--/send recharge email--*/
		}
	}
	
	
	private function do_recharge($reqMsg,$sess,$opId) {

		$customer=$this->Auth->user();		
		if(!$customer){
			$customer=$this->Session->read('GuestCustomer');
		}	
			
		$arrRes=array(
			'recharge_payment_error_code'=>0,
			'recharge_payment_result_code'=>0,
			'recharge_payment_status'=>0,
			'recharge_payment_verification_error_code'=>0,
			'recharge_payment_verification_result_code'=>0,
			'recharge_status'=>0,
			'response_code'=>0,
			'recharge_date'=>date('Y-m-d H:i:s')	
		);					
		
		$action=$this->Session->read('action');
		$this->Session->delete('action');
		unset($_SESSION['action']);
		
		if($customer && $action=='dorecharge'){			
		
			//set next action
			$this->Session->write('action','savetransaction');
			
			/*- number recharge-*/			
			$errCode=0;
			$errStatus = array();
			try{					
				$url=$this->Operator->findById($opId,array('op_payment_url'));
				$url=$url['Operator']['op_payment_url'];

				$phoneRechargeRes=$this->Recharge->getQueryResult($reqMsg,$url);					
				
				preg_match('/ERROR=(.*)/', $phoneRechargeRes, $errStatus);
					
				$rsStatus = array();
				preg_match('/RESULT=(.*)/', $phoneRechargeRes, $rsStatus);
					
				$arrRes['recharge_payment_error_code']=$errStatus[1];
				$arrRes['recharge_payment_result_code']=$rsStatus[1];
					
				if($errStatus && $errStatus[1]==0 && $rsStatus[1]==0){

					$arrRes['recharge_payment_status']=1;

					/*-payment status verification--*/

					$secKey = file_get_contents('../Vendor/iprivpg/keys/secret.key');
					$pubKey = file_get_contents('../Vendor/iprivpg/keys/pubkeys.key');
					$passwd = CYBERPLAT_PASSWORD;

					$querString="SESSION=$sess";

					$rsCode=null;
						
					$signInRes = ipriv_sign($querString, $secKey, $passwd);

					$signInStatus=$signInRes[0];
					if($signInStatus===0){
							
						$signInMsg=$signInRes[1];
						$verifyRes = ipriv_verify($signInMsg, $pubKey);
						$verifyStatus=$verifyRes[0];
							
						if($verifyStatus===0){

							$url=$this->Operator->findById($opId,array('op_payment_status_url'));
							$url=$url['Operator']['op_payment_status_url'];

							$paymentVerificationRes=$this->Recharge->getQueryResult($signInMsg,$url);

							$errStatus = array();
							preg_match('/ERROR=(.*)/', $paymentVerificationRes, $errStatus);

							$rs1Status = array();
							preg_match('/RESULT=(.*)/', $paymentVerificationRes, $rs1Status);

							$arrRes['recharge_payment_verification_error_code']=$errStatus[1];
							$arrRes['recharge_payment_verification_result_code']=$rs1Status[1];
																						
							if($errStatus && $errStatus[1]==0 && $rs1Status[1]==7){

								$arrRes['recharge_status']=1;
							}else{
								$errCode=$errStatus[1];
							}
						}
					}
					/*-[end]payment status verification--*/				
				}else{
					$errCode=$errStatus[1];
				}					
			}catch(Exception $e){echo $e;}
				
			/*-/number recharge-*/
			$arrRes['response_code']=$errCode;
		}		
		return $arrRes;
	}
	

	function get_operators(){
		
		$this->layout='ajax';
		$rType=$this->request->data('type');
				
		$operators=$this->Operator->find('all',array('conditions'=>array('type'=>$rType,'status'=>1),'order'=>array('Operator.name'=>'asc')));
		$opt='';
		if($operators){
			foreach($operators as $op){
				$opt.="<option value='". $op['Operator']['id']."'>". $op['Operator']['name']."</option>";
			}
		}
		echo $opt;
		die;
	}
	
	/*--excel export--*/
	function admin_export_transactions($cond=null){
		ini_set ( 'memory_limit', '2500M' );
		$this->autoRender=false;
		
		$arrHead=array('id','customer_id','customer_name','recharge_type','number','marchant_ref_no','operator_name','payment_mode',
		'payment_id','transaction_id','amount','service_charge','discount','total_amount','payment_status','payment_date',
		'recharge_session_id','recharge_status','recharge_payment_status','recharge_payment_error_code','recharge_payment_result_code',
		'recharge_payment_verification_error_code','recharge_payment_verification_result_code','recharge_date','transaction_status',
		'record_status','customer_ip_address','recharge_circle','account_param','atom_trans_id');
		
		$dataHead =array_map('ucwords',str_replace('_', ' ', $arrHead));		
		
		$data=array($dataHead);

		$i=1;		
		$arrData=array();
		
		/*--find data--*/
		
		$action=$this->request->query['ac'];
		if(!empty($action) && $action=='f'){
			
			$arrCond=array('transaction_status'=>'Success','record_status NOT'=>'Trash');		
			
			if(isset($this->request->query['filter'])){	
						
				$filter=$this->request->query['filter'];		
				if(!empty($filter)){					
					if($filter=='Failed'){
						$arrCond['transaction_status']=array($filter,'Incomplete','Refund');
					}else{				
						$arrCond['transaction_status']=$filter;
					}
				}
			}		
		
			if(isset($this->request->query['search_key'])){	
				$query=$this->request->query['search_key'];			
				if(!empty($query)){
					$arrCond['OR']=array('transaction_id LIKE'=>"%{$query}%",'payment_id LIKE'=>"%{$query}%");
				}			
			}
		
			if(isset($this->request->query['start_date']) && isset($this->request->query['end_date'])){
				$stDate=$this->request->query['start_date'];
				$endDate=$this->request->query['end_date'];
				if(!empty($stDate) && !empty($endDate)){
					$arrCond['AND']=array('payment_date >='=>$stDate,'payment_date <='=>$endDate);
				}elseif(!empty($stDate)){
					$arrCond['AND']=array('payment_date >='=>$stDate);
				}elseif(!empty($endDate)){
					$arrCond['AND']=array('payment_date <='=>$endDate);
				}
			}
		
			if(isset($this->request->query['service_type'])){	
				$query=$this->request->query['service_type'];			
				if(!empty($query)){
					$arrCond['Recharge.recharge_type']=$query;
				}	
			}
			
			$arrData=$this->Recharge->find('all',array('conditions'=>$arrCond,
	    		'fields'=>array('Recharge.*','Operator.name','Customer.name','Customer.customer_type','RechargeType.recharge_type'),
				'order'=> array('Recharge.id' => 'desc')
	    		));
	  		
		}else{
			$arrData=$this->Recharge->find('all');
		}
	
		if($arrData){
			foreach($arrData as $rs)
			{					
				$data[$i][0]=$rs['Recharge']['id'];
				$data[$i][1]=$rs['Recharge']['customer_id'];
				$data[$i][2]=$rs['Customer']['name'];
				$data[$i][3]=$rs['RechargeType']['recharge_type'];
				$data[$i][4]=$rs['Recharge']['number'];
				$data[$i][5]=$rs['Recharge']['marchant_ref_no'];
				$data[$i][6]=$rs['Operator']['name'];
				$data[$i][7]=$rs['Recharge']['payment_mode'];
				$data[$i][8]=$rs['Recharge']['payment_id'];
				$data[$i][9]=$rs['Recharge']['transaction_id'];
				$data[$i][10]=$rs['Recharge']['amount'];
				$data[$i][11]=$rs['Recharge']['service_charge'];
				$data[$i][12]=$rs['Recharge']['discount'];
				$data[$i][13]=$rs['Recharge']['total_amount'];
				$data[$i][14]=$rs['Recharge']['payment_status'];
				$data[$i][15]=$rs['Recharge']['payment_date'];
				$data[$i][16]=$rs['Recharge']['recharge_session_id'];
				$data[$i][17]=$rs['Recharge']['recharge_status'];
				$data[$i][18]=$rs['Recharge']['recharge_payment_status'];
				$data[$i][19]=$rs['Recharge']['recharge_payment_error_code'];
				$data[$i][20]=$rs['Recharge']['recharge_payment_result_code'];
				$data[$i][21]=$rs['Recharge']['recharge_payment_verification_error_code'];
				$data[$i][22]=$rs['Recharge']['recharge_payment_verification_result_code'];
				$data[$i][23]=$rs['Recharge']['recharge_date'];
				$data[$i][24]=$rs['Recharge']['transaction_status'];
				$data[$i][25]=$rs['Recharge']['record_status'];
				$data[$i][26]=$rs['Recharge']['customer_ip_address'];
				$data[$i][27]=$rs['Recharge']['recharge_circle'];
				$data[$i][28]=$rs['Recharge']['account_param'];	
				$data[$i][29]=$rs['Recharge']['atom_trans_id'];					
				$i++;
			}
		}
		
		$ts=strtotime(date('Y-m-d'));
		$filename="recharges{$ts}.xls";
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("mor");

		$col=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE");

		// Add some data
		foreach($data as $key1=>$val1)
		{
			foreach($val1 as $key2=>$val2)
			{
				$keyval=$key1+1;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col[$key2].$keyval,$val2);
				$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($col[$key2])->setAutoSize(true);
			}
		}

		$objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:AD1")->applyFromArray(array("font" => array( "bold" => true)));
		$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		// Rename sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		die;
	}
	/*--/excel export--*/
	
	function recharge_form($reType=1){
	
		if(isset($this->request->data) && !empty($this->request->data['Recharge']['type'])){
			$reType=$this->request->data['Recharge']['type'];
			$this->set('ReqData',$this->request->data);
		}
		
		if($this->request->is('ajax')){
			$this->layout='ajax';
		}    
		
        $operators=$this->Operator->find('all',array('conditions'=>array('type'=>$reType,'status'=>1),'order'=>array('Operator.name'=>'asc')));
		$this->set('Operators', $operators);
	
		$operators=$this->RechargeType->findById($reType);
		$this->set('RechargeType', $operators);	
	}
	
	function get_recharge_form($reType=1){
	
		if(isset($this->request->data) && !empty($this->request->data['Recharge']['type'])){
			$reType=$this->request->data['Recharge']['type'];
			$this->set('ReqData',$this->request->data);
		}
		
		if($this->request->is('ajax')){
			$this->layout='ajax';
		}    
		
        $operators=$this->Operator->find('all',array('conditions'=>array('type'=>$reType,'status'=>1),'order'=>array('Operator.name'=>'asc')));
		$this->set('Operators', $operators);
	
		$operators=$this->RechargeType->findById($reType);
		$this->set('RechargeType', $operators);    
      
		$view = new View($this, false);
		$reccForm= $view->render('recharge_form','ajax');
		return $reccForm;
		die;
		
	}
	
	function get_operator_notes($opId=0){	
		if($this->request->is('ajax')){
			$this->layout='ajax';
		}  
        $notes=$this->Operator->findById($opId,array('op_notes'));
		if(!empty($notes)){
			echo $notes['Operator']['op_notes'];
		}
		die;	
	}
	
		
	
	
}