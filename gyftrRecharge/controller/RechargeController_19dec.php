<?php
App::import('Vendor', array('functions','excel-lib/Classes/PHPExcel','reader'));
class RechargeController extends AppController {

	public $name = 'Recharge';
	public $helpers = array('Form', 'Html','Js' => array('Jquery'));
	public $paginate ='';
	public $components=array('Session','Access');
	public $uses=array('User','Operator','Recharge','GiftCategory','GiftBrand','RechargeLog','Circle','VoucherLog','Denomination');
	
	function beforeFilter(){
		parent::beforeFilter();							
	}
	
	public function index()
	{
		$ops=$this->Operator->find('all',array('order'=>array('Operator.name ASC')));
		$plans=$this->Denomination->find('all');
		$circles=$this->Circle->find('all',array('order'=>array('Circle.circle ASC')));		
		$this->set('plans',$plans);	
		$this->set('operator',$ops);
		$this->set('circles',$circles);			
	}
	
	public function show_process()
	{
		$this->layout='ajax';
		$num=$this->data['num'];
		$ops=$this->Operator->find('all',array('order'=>array('Operator.name ASC')));
		$this->set('operator',$ops);
		$circles=$this->Circle->find('all',array('order'=>array('Circle.circle ASC')));
		$rel_circles=array('2','3','16','13','23','12','17','8');
		$this->set('rel_circles',$rel_circles);
		$this->set('circles',$circles);
		if($num=='0')
		{			
			$this->render('index_div');		
		}else if($num=='1'){
			$this->render('bill_payments');
		}else if($num=='2')
		{
			$this->render('coming_soon');
		}	
	}
	
	public function proceed_to_recharge($num=1)
	{		
		$this->layout='ajax';
		if($num==1)
		{
			$data=$this->data;	
			//pr($data); die;			
			if($data['Recharge']['recharge_type']=='1'||$data['Recharge']['recharge_type']=='4')
			{
				$data['Recharge']['number']=$data['Recharge']['mobile_num'];
				$data['Recharge']['operator_id']=$data['Recharge']['mob_operator'];	
			}else if($data['Recharge']['recharge_type']=='2')
			{
				$data['Recharge']['number']=$data['Recharge']['customer_id'];
				$data['Recharge']['operator_id']=$data['Recharge']['dth_operator'];	
			}else if($data['Recharge']['recharge_type']=='3')
			{
				$data['Recharge']['number']=$data['Recharge']['dc_operator'];
				$data['Recharge']['operator_id']=$data['Recharge']['mob_operator'];	
			}else if($data['Recharge']['recharge_type']=='5')
			{
				$data['Recharge']['operator_id']=$data['Recharge']['electricity_provider'];
				
				if($data['Recharge']['operator_id']=='46'||$data['Recharge']['operator_id']=='47')
					$data['Recharge']['number']=$data['Recharge']['customer_acc_num'];
				else if($data['Recharge']['operator_id']=='45')	
					$data['Recharge']['number']=$data['Recharge']['customer_num'];
				else if($data['Recharge']['operator_id']=='48')	
					$data['Recharge']['number']=$data['Recharge']['customer_ndpl_num'];	
											
			}else if($data['Recharge']['recharge_type']=='6')
			{
				$data['Recharge']['number']=$data['Recharge']['landline_num'];
				$data['Recharge']['operator_id']=$data['Recharge']['landline_operator'];					
			}else if($data['Recharge']['recharge_type']=='7')
			{
				$data['Recharge']['number']=$data['Recharge']['gas_num'];
				$data['Recharge']['operator_id']=$data['Recharge']['gas_provider'];					
			}else if($data['Recharge']['recharge_type']=='8')
			{
				$data['Recharge']['number']=$data['Recharge']['policy_number'];
				$data['Recharge']['operator_id']=$data['Recharge']['policy_provider'];					
			}	
			
			$data['Recharge']['amount']=$data['Recharge']['PlanAmount'];
					
			$session_id=String::uuid();
			$arr=array('number'=>$data['Recharge']['number'],'recharge_type'=>$data['Recharge']['recharge_type'],'voucher_code'=>$data['Recharge']['voucher_code'],'amount'=>$data['Recharge']['amount'],'operator_id'=>$data['Recharge']['operator_id'],'session_id'=>$session_id,'created'=>date("Y-m-d H:i:s"));
			$this->RechargeLog->create();
			$log=$this->RechargeLog->save($arr);
			$data['Recharge']['log_id']=$log['RechargeLog']['id'];	
			$this->set('data',$data);
		}
		if($this->Session->check('RecUser'))
		{		
			$operator=$this->Operator->findById($data['Recharge']['operator_id']);
			$this->set('operator',$operator);	
			$this->RechargeLog->id=$data['Recharge']['log_id'];
			$this->RechargeLog->saveField('user_id',$this->Session->read('RecUser.User.id'));
			$this->set('user_id',$this->Session->read('RecUser.User.id'));							
			$this->render('recharge_summary');
		}else{
			$this->render('user_details');
		}
	}
	
		
	public function validate_voucher_code($num=0)
	{
			
			$code=$this->data['code'];		
			$jobnum=String::uuid();
			//$url="https://pos.vouchagram.com/service/restserviceimpl.svc/BatchConsume?deviceCode=P&merchantUid=".urlencode(MBUID)."&shopCode=".urlencode(MBSHOP)."&voucherNumber=".$code."&Password=".urlencode(MBPass)."&requestjobnumber=".$jobnum;	
			$url="https://pos.vouchagram.com/service/restserviceimpl.svc/QueryVoucher?deviceCode=P&merchantUid=".urlencode(MBUID)."&shopCode=".urlencode(MBSHOP)."&voucherNumber=".$code."&Password=".urlencode(MBPass);
			
			$ch = curl_init($url); 
			curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
			$resp = curl_exec($ch); //execute post and get results
			curl_close ($ch);
			
			$response=json_decode($resp);
			//pr($response); die;
			if(isset($response->vQueryVoucherResult[0]))
			{
				$arr=$response->vQueryVoucherResult[0];	
				if(trim(strtolower($arr->ResultType))=="success")
				{
					if(trim(strtolower($arr->Status))=="valid")										
					{ 
						$msg = 'success|'.$arr->Value.'|'.$arr->VoucherNumber; 
												
					}else if(trim(strtolower($arr->Status))=="consumed"){
						 $msg =  'error|Voucher already consumed'; 
					}else{
						 $msg =  'error|There is some issue. Please try again later';	
					}
				}else {
					 $msg =  'error|'.$arr->ErrorMsg; 
				}
			}else{
				 $msg =  'error|There is some issue. Please try again later'; 
			}
			$msg='success|10.00|1234';
			
			
			if($num==0)
			{	
				echo  $msg;	die;
			}else{
				return $msg;
			}	
				
		//pr($response); die;
		
	}
	
	public function register_user()
	{
		$this->layout='ajax';
		if($this->request->is('post'))
		{
			if(!empty($this->data))
			{
				$data=$this->data;	
					
				$this->set('data',$data);
				$operator=$this->Operator->findById($data['Recharge']['operator_id']);
				$this->set('operator',$operator);
				if($data['Recharge']['is_guest']=='0')
				{
					$user=$this->User->findByEmail($data['User']['email']);
					if(!empty($user))
					{
						$this->set('is_user_exist','1');
						$this->proceed_to_recharge(0);
					}else{
						$arr=array('name'=>$data['User']['name'],'email'=>$data['User']['email'],'password'=>$data['User']['password'],'mobile'=>$data['User']['phone'],'created'=>date("Y-m-d H:i:s"),'last_login_time'=>date("Y-m-d H:i:s"),'last_login_ip'=>$this->request->clientIp());
						$this->User->create();
						$user_data=$this->User->save($arr);
						$this->Session->write('RecUser',$user_data);
						$this->RechargeLog->id=$data['Recharge']['log_id'];
						$this->RechargeLog->saveField('user_id',$user_data['User']['id']);
						$this->set('user_id',$user_data['User']['id']);							
						$this->render('recharge_summary');
					}	
				}else{
					$this->set('user_id','0');	
					$this->render('recharge_summary');
				}	
			}else{
				$this->redirect(array('action'=>'invalidUser'));	
			}	
		}	
	}	
	
	public function login_user()
	{
		$this->layout='ajax';
		if(!empty($this->data))
		{
			$data=$this->data;
			
			$operator=$this->Operator->findById($data['Recharge']['operator_id']);
			$this->set('operator',$operator);
			if($data['Recharge']['is_guest']=='0')
			{
				$this->set('data',$data);
				$user_data=$this->User->find('first',array('conditions'=>array('User.email'=>$this->data['User']['email'],'password'=>$this->data['User']['password'])));					
				if(!empty($user_data))
				{
					$this->User->id=$user_data['User']['id'];
					$this->User->save(array('last_login_time'=>date("Y-m-d H:i:s"),'last_login_ip'=>$this->request->clientIp()));
					$this->Session->write('RecUser',$user_data);
					$this->RechargeLog->id=$data['Recharge']['log_id'];
					$this->RechargeLog->saveField('user_id',$user_data['User']['id']);
					$this->set('user_id',$user_data['User']['id']);							
					$this->render('recharge_summary');	
				}else{
					$this->set('login_failed','1');
					$this->proceed_to_recharge(0);	
				}
			}else{
				$this->set('data',$data);
				$this->set('user_id','0');	
				$this->render('recharge_summary');
			}
		}	
	}
	
	
	public function verify_recharge()
	{		
		$data=$this->data;
		$this->request->data['code']=$data['Recharge']['voucher_code'];
		$validate=$this->validate_voucher_code(1);
		
		$split=explode("|",$validate);
		
		if($split[0]!='error')
		{
					
		$operator=$this->Operator->findById($data['Recharge']['operator_id']);
		$this->set('operator',$operator);
		$this->set('user_id',$data['User']['id']);
		
		$this->layout='ajax';			
		/*-verify mobile number and oprator-*/
		if($this->request->is("post") && isset($this->request->data)){			
			$logData=$this->RechargeLog->findById($data['Recharge']['log_id']);
			$this->request->data['Recharge']['amount']=trim($logData['RechargeLog']['amount']);
			
			$this->set('RechargeFrm', $this->request->data);					
				try{
					if($data['Recharge']['operator_id']=='34'||$data['Recharge']['operator_id']=='35'||$data['Recharge']['operator_id']=='36'||$data['Recharge']['operator_id']=='49'||$data['Recharge']['operator_id']=='54')
					{
						$secKey = file_get_contents('../Vendor/airtel/secret.key');
						$pubKey = file_get_contents('../Vendor/airtel/pubkeys.key');
						$passwd = CYBERPLAT_PASSWORD_airtel;
					}else{
						$secKey = file_get_contents('../Vendor/iprivg/keys/secret.key');
						$pubKey = file_get_contents('../Vendor/iprivg/keys/pubkeys.key');
						$passwd = CYBERPLAT_PASSWORD;	
					}
					
					if($data['Recharge']['operator_id']=='49')
						$phNbr=trim($this->request->data['Recharge']['std_code']).trim($this->request->data['Recharge']['number']);
					else	
						$phNbr=trim($this->request->data['Recharge']['number']);
					$opId=trim($this->request->data['Recharge']['operator_id']);					
					
					$amount=number_format(trim($this->request->data['Recharge']['amount']),2);
					$reType=trim($this->request->data['Recharge']['recharge_type']);
					
					$sessPrefix=substr($phNbr,0,10);
					$sess=$sessPrefix.strtotime(date('Y-m-d  H:i:s'));
					
					$circle_id=null;
					if(isset($data['Recharge']['circle_id']))
						$circle_id=$data['Recharge']['circle_id'];
						
					$cycle_no=$customer_acc_number=$dob=$others=null;	
					if($data['Recharge']['operator_id']=='45')
					{	$others="\nACCOUNT=".$data['Recharge']['cycle_number'];
						$cycle_no=$data['Recharge']['cycle_number'];
					}
						
					if($data['Recharge']['operator_id']=='50')
					{	$others="\nACCOUNT=".$data['Recharge']['customer_acc_number'];
						$customer_acc_number=$data['Recharge']['customer_acc_number'];
					}
					
					if($data['Recharge']['recharge_type']=='8')
					{	$others="\n\rACCOUNT=".$data['Recharge']['date_of_birth'];
						$dob=$data['Recharge']['date_of_birth'];
					}																
					
					if($data['Recharge']['operator_id']=='34'||$data['Recharge']['operator_id']=='35'||$data['Recharge']['operator_id']=='36'||$data['Recharge']['operator_id']=='49'||$data['Recharge']['operator_id']=='54')
					{			
						$querString="SD=".CYBERPLAT_SD_airtel."\nAP=".CYBERPLAT_AP_airtel."\nOP=".CYBERPLAT_OP_airtel."\n\rSESSION=$sess\nNUMBER=$phNbr\nAMOUNT=$amount\nAMOUNT_ALL=$amount\nCOMMENT=MyGyFTR recharge".$others;
					}else{
						$querString="SD=".CYBERPLAT_SD."\n\rAP=".CYBERPLAT_AP."\nOP=".CYBERPLAT_OP."\nSESSION=$sess\nNUMBER=$phNbr\nAMOUNT=$amount\nAMOUNT_ALL=$amount\nCOMMENT=MyGyFTR recharge".$others;	
					}
					
					$errCode=null;
					$rsCode=null;
					
					$signInRes = ipriv_sign($querString, $secKey, $passwd);					
					pr($signInRes); 
					$signInStatus=$signInRes[0];
					if($signInStatus===0){
						$signInMsg=$signInRes[1];
						$verifyRes = ipriv_verify($signInMsg, $pubKey);
						pr($signInMsg);
						$verifyStatus=$verifyRes[0];
						
						if($verifyStatus===0){
							
							$url=$this->Operator->findById($opId,array('op_verification_url'));
							
							$url=$url['Operator']['op_verification_url'];
							
							$phoneVerificationRes=$this->Recharge->getQueryResult($signInMsg,$url);
							pr($phoneVerificationRes);  die;
							//pr($data);
							$errStatus=array();
							$rsStatus=array();
							
							preg_match('/ERROR=(.*)/', $phoneVerificationRes, $errStatus);
							preg_match('/RESULT=(.*)/', $phoneVerificationRes, $rsStatus);
												
							if($errStatus && $errStatus[1]==0 && $rsStatus[1]==0){
							
								$transactionId = array();
								preg_match('/TRANSID=(.*)/', $phoneVerificationRes, $transactionId);
								$transactionId=$transactionId[1];								
								//pr($transactionId); die;
								$verificationRes=array('Recharge'=>array('log_id'=>$data['Recharge']['log_id'],
														'user_id'=>$data['User']['id'],
														'recharge_type'=>$reType,
														'number'=>$phNbr,
														'circle_id'=>$circle_id,
														'cycle_number'=>$cycle_no,
														'customer_acc_number'=>$customer_acc_number,
														'date_of_birth'=>$dob,
														'operator_id'=>$opId,
														'amount_from_voucher'=>$amount,
														'amount'=>$amount,
														'voucher_code'=>$data['Recharge']['voucher_code'],
														'recharge_transaction_id'=>$transactionId,
										  				'recharge_session_id'=>$sess,											
										   				'RequestMessage'=>$signInMsg														
														));
								//$this->proceed_to_recharge_payment($verificationRes);					
								
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
						$this->set("RechargeStatus","Error:-".$errMsg);
						$this->set('data',$data);		
						$this->render('recharge_summary');				
					}				
				}catch(Exception $e){echo $e;}			
		}
		
		/*-[end]verify mobile number and oprator-*/		
		}else{
			$this->layout='ajax';
			$this->set('error_msg',$split[1]);			
			$this->render('recharge_error');	
		}
		
	}
	
	public function consume_voucher($code)
	{
		if(!empty($code))
		{
			$jobnum=String::uuid();
			$url="https://pos.vouchagram.com/service/restserviceimpl.svc/BatchConsume?deviceCode=P&merchantUid=".urlencode(MBUID)."&shopCode=".urlencode(MBSHOP)."&voucherNumber=".$code."&Password=".urlencode(MBPass)."&requestjobnumber=".$jobnum;	
			$ch = curl_init($url); 
			curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
			$resp = curl_exec($ch); //execute post and get results
			curl_close ($ch);
			
			$response=json_decode($resp);
			//pr($response); die;
			if(isset($response->vBatchConsumeResult[0]))
			{
				$arr=$response->vBatchConsumeResult[0];	
				if(strtolower($arr->ResultType)=="success")
				{
					$voucher=$arr->VOUCHERACTION[0];					
					$msg='success|'.$voucher->VALUE.'|'.$voucher->VOUCHERNUMBER; 
						
				}else{
					$msg='error|'.$arr->Message; 	
				}
			}else{
				$msg='error|There is some issue. Please try again later'; 	
			}	
		}else{
			$msg='error|Invalid Voucher Code';	
		}
		return $msg;	
	}
	
		
	public function cancel_voucher($code)
	{
		if(!empty($code))
		{
			$jobnum=String::uuid();
			$url="https://pos.vouchagram.com/service/restserviceimpl.svc/Cancel?deviceCode=P&merchantUid=".urlencode(MBUID)."&shopCode=".urlencode(MBSHOP)."&voucherNumber=".$code."&Password=".urlencode(MBPass);	
			$ch = curl_init($url); 
			curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
			$resp = curl_exec($ch); //execute post and get results
			curl_close ($ch);
			
			$response=json_decode($resp);
			pr($response); die;
			if(isset($response->vCancelResult[0]))
			{
				$arr=$response->vCancelResult[0];	
				if(strtolower($arr->ResultType)=="success")
				{
					$msg='success|'.$arr->Message; 
						
				}else{
					$msg='error|'.$arr->Message; 	
				}
			}else{
				$msg='error|There is some issue. Please try again later'; 	
			}
		}
		return $msg;	
	}
	
	
	public function proceed_to_recharge_payment($arrReDetails)
	{
		$this->layout='ajax';
		$consume=$this->consume_voucher($arrReDetails['Recharge']['voucher_code']);
		$split=explode("|",$consume);
		if($split[0]=='success')
		{
			$this->VoucherLog->create();
			$voucherlog=$this->VoucherLog->save(array('code'=>$arrReDetails['Recharge']['voucher_code'],'message'=>'success','created'=>date("Y-m-d H:i:s")));
		try{
				$errCode=0;
				$url=$this->Operator->findById($arrReDetails['Recharge']['operator_id'],array('op_payment_url'));
				$url=$url['Operator']['op_payment_url'];
				$reqMsg=$arrReDetails['Recharge']['RequestMessage'];
				
				$phoneRechargeRes=$this->Recharge->getQueryResult($reqMsg,$url);
				//pr($phoneRechargeRes);	
				$errStatus = array();
				preg_match('/ERROR=(.*)/', $phoneRechargeRes, $errStatus);
								
				$rsStatus = array();
				preg_match('/RESULT=(.*)/', $phoneRechargeRes, $rsStatus);
									
				$arrReDetails['Recharge']['recharge_payment_error_code']=$errStatus[1];
				$arrReDetails['Recharge']['recharge_payment_result_code']=$rsStatus[1];
				$sess=$arrReDetails['Recharge']['recharge_session_id'];	
				$arrReDetails['Recharge']['recharge_date']=date('Y-m-d H:i:s');
				$arrReDetails['Recharge']['user_ip_address']=$this->request->clientIp();				
				//pr($errStatus);				
				
				if($errStatus && $errStatus[1]==0 && $rsStatus[1]==0){
					
					$arrReDetails['Recharge']['recharge_payment_status']=1;
					/*-payment status verification--*/
					if($arrReDetails['Recharge']['operator_id']=='34'||$arrReDetails['Recharge']['operator_id']=='35'||$arrReDetails['Recharge']['operator_id']=='36'||$arrReDetails['Recharge']['operator_id']=='49'||$arrReDetails['Recharge']['operator_id']=='54')
					{
						$secKey = file_get_contents('../Vendor/airtel/secret.key');
						$pubKey = file_get_contents('../Vendor/airtel/pubkeys.key');
						$passwd = CYBERPLAT_PASSWORD_airtel;
					}else{
						$secKey = file_get_contents('../Vendor/iprivg/keys/secret.key');
						$pubKey = file_get_contents('../Vendor/iprivg/keys/pubkeys.key');
						$passwd = CYBERPLAT_PASSWORD;
					}
					
					$querString="SESSION=$sess";
					$rsCode=null;
						
					$signInRes = ipriv_sign($querString, $secKey, $passwd);

					$signInStatus=$signInRes[0];
					//pr($signInStatus);	
					if($signInStatus===0){						
							$signInMsg=$signInRes[1];						
						
							$verifyRes = ipriv_verify($signInMsg, $pubKey);
							$verifyStatus=$verifyRes[0];
							//pr($verifyStatus);	
							if($verifyStatus===0){
								
								$url=$this->Operator->findById($arrReDetails['Recharge']['operator_id'],array('op_payment_status_url'));
								$url=$url['Operator']['op_payment_status_url'];
	
								$paymentVerificationRes=$this->Recharge->getQueryResult($signInMsg,$url);
								
								$errStatus_2 = array();
								preg_match('/ERROR=(.*)/', $paymentVerificationRes, $errStatus_2);
	
								$rsStatus_2 = array();
								preg_match('/RESULT=(.*)/', $paymentVerificationRes, $rsStatus_2);
	
								$arrReDetails['Recharge']['recharge_payment_verification_error_code']=$errStatus_2[1];
								$arrReDetails['Recharge']['recharge_payment_verification_result_code']=$rsStatus_2[1];							
								//pr($errStatus_2);
								//pr($rsStatus_2);
								if(trim($errStatus_2[1])=='0' && trim($rsStatus_2[1])=='7'){								
									$arrReDetails['Recharge']['recharge_status']='1';
									$success_code=0;						
									
								}else{
									$errCode=$errStatus_2[1];
									$success_code=1;								
								}
							}						
					}
					/*-[end]payment status verification--*/
				}else{
					$errCode=$errStatus[1];
					
				}			
					
			}catch(Exception $e){echo $e;}
				
			/*-[end]phone recharge-*/	
			$this->Recharge->create();
			$recharge=$this->Recharge->save($arrReDetails);				
			if(isset($success_code) && $success_code==0){
				
				$this->RechargeLog->id=$arrReDetails['Recharge']['log_id'];
				$this->RechargeLog->saveField('recharge_status','success');	
				$this->VoucherLog->id=$voucherlog['VoucherLog']['id'];				
				$this->VoucherLog->save(array('recharge_id'=>$recharge['Recharge']['id'],'status'=>'1','message'=>'success','created'=>date("Y-m-d H:i:s")));
				$operator=$this->Operator->findById($arrReDetails['Recharge']['operator_id']);
				$this->set('data',$arrReDetails);
				$this->set('operator',$operator);		
				$this->render('recharge_success');
				
			}else{
				//pr($errCode);
				if($errCode==000)
						$errMsg='There is some issue. Please try again later.';
				else{		
					$errMsg=$this->Recharge->cpErrors[intval($errCode)];
					if(!$errMsg)
							$errMsg="Invalid request.";				
				}				
				$cancel=$this->cancel_voucher($arrReDetails['Recharge']['voucher_code']);
				$clsplit=explode("|",$cancel);
				if($clsplit[0]=="success")
				{
					$this->VoucherLog->create();
					$this->VoucherLog->save(array('code'=>$arrReDetails['Recharge']['voucher_code'],'recharge_id'=>$recharge['Recharge']['id'],'status'=>'0','message'=>$clsplit[1],'created'=>date("Y-m-d H:i:s")));	
				}
				$this->RechargeLog->id=$arrReDetails['Recharge']['log_id'];
				$this->RechargeLog->saveField('recharge_status','failed');
				
				$this->set("RechargeStatus","Error:".$errMsg);
				$this->set('data',$arrReDetails);		
				$this->render('recharge_summary');							
			}
			
		}else{
			$this->layout='ajax';
			$this->set('data',$arrReDetails);
			$this->set('error_msg',$split[1]);
			$this->render('recharge_error');
		}
						
	}
	
	
	public function update_user()
	{
		$user='Welcome ';
		if($this->Session->check('RecUser'))
		{
			$user.=$this->Session->read('RecUser.User.name').', ';
			$user.='<a href="'.$this->webroot.'recharge/logout">Logout</a>';
		}else{
			$user.='guest!';	
		}	
		echo $user; die;
	}
	
	public function logout()
	{
		$this->Session->destroy();
		$this->redirect(array('action'=>'index'));	
	}
	
	public function back_to_index()
	{
		$this->layout='ajax';
		$ops=$this->Operator->find('all',array('order'=>array('Operator.name ASC')));
		$plans=$this->Denomination->find('all');
		foreach($plans as $pl)
		{
			$allpl[]=$pl['Denomination']['operator_id'];	
		}
		if(in_array($this->data['Recharge']['operator_id'],$allpl))
		{
			$this->set('is_plan',$this->data['Recharge']['operator_id']);	
			$this->set('plan_circle',$this->data['Recharge']['plan_circle']);	
		}	
		
		$this->set('plans',$plans);
		$this->set('operator',$ops);
		$circles=$this->Circle->find('all',array('order'=>array('Circle.circle ASC')));	
		$rel_circles=array('2','3','16','13','23','12','17','8');
		$this->set('rel_circles',$rel_circles);	
		$this->set('circles',$circles);
		$this->set('setdata',$this->data);
		//pr($this->data); 
		if($this->data['Recharge']['recharge_type']=='4'||$this->data['Recharge']['recharge_type']=='5'||$this->data['Recharge']['recharge_type']=='6'||$this->data['Recharge']['recharge_type']=='7'||$this->data['Recharge']['recharge_type']=='8')
			$this->render('bill_payments');
		else	
			$this->render('index_div');	
	}
	
	
	public function admin_index($num=0)
	{
		$this->layout='admin';
		if(!$this->Session->check('RecAdmin'))
		{
			$this->redirect(array('controller'=>'login','action'=>'index','admin'=>true));	
		}else{			
				$search='1=1';
				if(isset($this->request->query['from_date'])&& $this->request->query['from_date']!='')
				{
					$from_date=$this->request->query['from_date'];			
					$this->set('from_date', $from_date);
					$search.=" AND Recharge.recharge_date>='".$from_date." 00:00:00'";
				}
				if(isset($this->request->query['to_date'])&& $this->request->query['to_date']!='')
				{
					$to_date=$this->request->query['to_date'];			
					$this->set('to_date', $to_date);
					$search.=" AND Recharge.recharge_date<='".$to_date." 23:59:59'";
				}
				if(isset($this->request->query['recharge_type'])&& $this->request->query['recharge_type']!='')
				{
					$recharge_type=$this->request->query['recharge_type'];			
					$this->set('recharge_type', $recharge_type);
					$search.=" AND Recharge.recharge_type ='".$recharge_type."'";
				}
				if(isset($this->request->query['recharge_status'])&& $this->request->query['recharge_status']!='')
				{
					$recharge_status=$this->request->query['recharge_status'];			
					$this->set('recharge_status', $recharge_status);
					$search.=" AND Recharge.recharge_status ='".$recharge_status."'";
				}
				if(isset($this->request->query['recharge_payment_status'])&& $this->request->query['recharge_payment_status']!='')
				{
					$recharge_payment_status=$this->request->query['recharge_payment_status'];			
					$this->set('recharge_payment_status', $recharge_payment_status);
					$search.=" AND Recharge.recharge_payment_status ='".$recharge_payment_status."'";
				}					
									
				$this->Recharge->bindModel(array('belongsTo'=>array('User'=>array('className'=>'User','foreignKey'=>'user_id'),
																	'Operator'=>array('className'=>'Operator','foreignKey'=>'operator_id'))));
				
				if($num=='1')
				{
					$rechHistory=$this->Recharge->find('all',array('conditions'=>$search));
					//pr($rechHistory); die;
					$this->export($rechHistory);	
				}else{
					$this->paginate['conditions']=array($search);																	
					$rechHistory = $this->paginate('Recharge');		
					$this->set('ReHistories',$rechHistory);	
				}
						
		}
	}
	
	
	public function get_categories()
	{
		$this->GiftCategory->bindModel(array('hasMany' => array('GiftBrand' => array('className' => 'GiftBrand','foreignKey' => 'gift_category_id'))),false);
		$cats=$this->GiftCategory->find('all',array('conditions'=>array('GiftCategory.status'=>'1')));
		$data=''; $i=0; $style=$class=''; 
		foreach($cats as $ct)
		{
			if($i>4)
			{	
				$style='style="display:none;"';
				$class='hidden_cats';
			}
			$data.='<div class="sections '.$class.'" '.$style.'><ul><li class="first">'.$ct['GiftCategory']['name'].': </li>';
			foreach($ct['GiftBrand'] as $ind=>$gb)
			{
				if(end(array_keys($ct['GiftBrand']))==$ind) $class='last'; else $class='';
				$data.='<li class="'.$class.'"><a href="http://www.mygyftr.com/'.str_replace(' ','-',$gb['name']).'">'.str_replace('_','\'',$gb['name']).'</a></li>';	
			}	
			$data.='</ul></div>';			
			$i++;
		}
		$data.='<div class="more_cats"><a href="javascript://" onclick="show_hidden_cats();">More</a></div>';
		echo $data;
	}
	
	public function export($rechHistory)
	{		
			$this->autoRender=false;			
				
			$data=array(); $i=1;
			$data[0][0]='S.No.';
			$data[0][1]='User';
			$data[0][2]='Recharge Type';
			$data[0][3]='Number';
			$data[0][4]='Operator';
			$data[0][5]='Voucher';
			$data[0][6]='Amount';
			$data[0][7]='Recharge Status';
			$data[0][8]='Recharge Verif.';
			$data[0][9]='Date';
				
			foreach($rechHistory as $rech)
			{				
				if($rech['Recharge']['user_id']=='0') $user='guest'; else $user=$rech['User']['name'];
				if($rech['Recharge']['recharge_type']=='1') $re_type='Mobile Prepaid'; else if($rech['Recharge']['recharge_type']=='2') $re_type='DTH'; else if($rech['Recharge']['recharge_type']=='3') $re_type='Data Card'; else if($rech['Recharge']['recharge_type']=='4') $re_type='Mobile Postpaid'; else if($rech['Recharge']['recharge_type']=='5') $re_type='Electricity Bill Pay';else if($rech['Recharge']['recharge_type']=='6') $re_type='Landline Bill Pay';else if($rech['Recharge']['recharge_type']=='7') $re_type='Gas Bill Pay';else if($rech['Recharge']['recharge_type']=='8') $re_type='Insurance Bill Pay';
				if($rech['Recharge']['recharge_payment_status']=='0') $re_pay_status='failed'; else $re_pay_status='success';
				if($rech['Recharge']['recharge_status']=='0') $re_status='failed'; else $re_status='success';
				
				$data[$i][0]=$i;
				$data[$i][1]=$user;
				$data[$i][2]=$re_type;
				$data[$i][3]=$rech['Recharge']['number'];
				$data[$i][4]=$rech['Operator']['name'];
				$data[$i][5]=$rech['Recharge']['voucher_code'];
				$data[$i][6]=$rech['Recharge']['amount_from_voucher'];
				$data[$i][7]=$re_pay_status;
				$data[$i][8]=$re_status;
				$data[$i][9]=show_formatted_datetime($rech['Recharge']['recharge_date']);
				
				$i++;	
			}
			//pr($data);die;
			$filename='Reports.xls';
			$objPHPExcel = new PHPExcel();	
			$objPHPExcel->getProperties()->setCreator("myGyftr");
		
			$col=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
			
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
			
			$objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:J1")->applyFromArray(array("font" => array( "bold" => true)));
				
			// Rename sheet			
			$objPHPExcel->setActiveSheetIndex(0);
			
			// Redirect output to a client’s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');			
								
		
	}
	
	
	
	
}
