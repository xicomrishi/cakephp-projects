<?php
App::uses('AppController', 'Controller');
class CronController extends AppController {

	public $name = 'Cron';
	public $uses = array('Recharge','Operator','RechargeType','Customer','EmailTemplate','Wallet');
	
	function beforeFilter(){
		parent::beforeFilter();	
		$this->Auth->allow('save_and_render_trans','verify_pending_transactions');
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
				$arrReplace=array($name,$trans['transaction_id'],$to,0,$trans['amount']);							
				$from=$template['EmailTemplate']['from_email'];
				$subject=$template['EmailTemplate']['email_subject'];
				$content=str_replace($arrFind, $arrReplace,$template['EmailTemplate']['email_body']);					
				$this-> sendEmail($to,$from,$subject,$content);				
					
			}
			/*--/send recharge email--*/
		}
	}
	
	/*---cron task to verify transaction--*/
	function verify_pending_transactions(){
		
		$adminName=constant("ADMIN_DISPLAY_NAME");
		$now=date('Y-m-d H:i:s');
		$content='';
		/*--get all pending transactions--*/
		try{
			$arrCond=array('recharge_payment_status'=>1,'recharge_status'=>0,'transaction_status'=>'Processing','not'=>array('recharge_session_id'=>null));		
			
			$recharges=$this->Recharge->find('all',array('conditions'=>$arrCond,
			'fields'=>array('Recharge.id','Recharge.transaction_id','Recharge.recharge_session_id','Recharge.operator_id','Recharge.recharge_date','Recharge.amount','Recharge.total_amount','Recharge.payment_mode','Recharge.marchant_ref_no','Recharge.customer_id','Recharge.payment_id','Recharge.atom_trans_id','Customer.name','Customer.email','Customer.successful_transactions')));
		
			/*--/get all pending transactions---*/
			if(!empty($recharges)){	
					
				$arrAllData=array();
				$arrAllCusTran=array();
				$successTrans=0;
				$failedTrans=0;
				$inProcessTrans=0;
				
				foreach($recharges as $rs){					
					if(!empty($rs['Recharge']['recharge_session_id'])){					
						
						$arrData=array();
						$arrCustT=array();
						$res=$this->do_recharge_verification($rs['Recharge']);
						
						$arrData['Recharge']['id']=$rs['Recharge']['id'];		
					
						$arrData['Recharge']['recharge_payment_verification_result_code']=$res['recharge_payment_verification_result_code'];
						$arrData['Recharge']['recharge_payment_verification_result_code']=$res['recharge_payment_verification_result_code'];
						$arrData['Recharge']['recharge_status']=$res['recharge_status'];
						
						if($res['recharge_status']==1){						
							$arrData['Recharge']['transaction_status']='Success';
							$this->transaction_email('successful_transaction',$rs['Recharge'],$rs['Customer']);					
							
							$successTrans++;
							/*--update success trans count--*/		
							$succetrans=(int)$rs['Customer']['successful_transactions'];
							$succetrans++;
							$arrCustT['Customer']['customer_id']=$rs['customer_id'];
							$arrCustT['Customer']['successful_transactions']=$succetrans;						
							/*--/update success trans count--*/
							
						}else{
							
							$rs['Recharge']['recharge_date'];
							$rechargeTS=strtotime($rs['Recharge']['recharge_date']);
							$curTS=time();						
							$diffTS=$curTS-$rechargeTS;
							$diffInH=round(($diffTS/3600),0);
							
							if($diffInH>=15){//if transaction is 15 hours old, then marked as failed.
								$arrData['Recharge']['transaction_status']='Refund';
								$this->transaction_email('failed_transaction',$rs['Recharge'],$rs['Customer']);
								$failedTrans++;
								
								/*--Refund amount to customer wallet if transaction failed--*/				
					
								$wallet=array('Wallet'=>array('customer_id'=>$rs['Recharge']['customer_id'],'type'=>'Credit','amount'=>$rs['Recharge']['total_amount'],'payment_mode'=>$rs['Recharge']['payment_mode'],'merchant_ref_no'=>$rs['Recharge']['marchant_ref_no'],'refund'=>'Yes','payment_id'=>$rs['Recharge']['payment_id'],'transaction_id'=>$rs['Recharge']['transaction_id'],'atom_trans_id'=>$rs['Recharge']['atom_trans_id'],'date'=>date("Y-m-d H:i:s"),'recharge_id'=>$rs['Recharge']['id']));
								
								$this->Wallet->create();
								$this->Wallet->save($wallet);
								
								$customerInfo=$this->Customer->findByCustomerId($rs['Recharge']['customer_id']);
								$newWalletAmount=(float)$customerInfo['Customer']['wallet_current_amount']+(float)$rs['Recharge']['total_amount'];
								
								
								$this->Customer->id=$rs['Recharge']['customer_id'];
								$this->Customer->save(array('wallet_current_amount'=>$newWalletAmount));
								/*------\Refund amount to customer wallet if transaction failed-----*/
								
								
							}else{
								$arrData['Recharge']['transaction_status']='Processing';
								//$this->transaction_email('processing_transaction',$rs['Recharge'],$rs['Customer']);	
								$inProcessTrans++;		
							}
						}
						
						$arrAllData[]=$arrData;
						$arrAllCusTran[]=$arrCustT;
						
					}
				}
				
				if(!empty($arrAllData)){
				
					$this->Recharge->saveAll($arrAllData,false);
					$this->Customer->saveAll($arrAllCusTran,false);
				}
				
				$totalProcessedData=count($arrAllData);
				/*--cron message on success--*/
				$content="<strong>Hi {$adminName}</strong>,<br/>&nbsp;&nbsp;&nbsp;";
				$content.="<p>Cron executed successfully for the verification of processing/pending transactions.</p>";	
				$content.="<p>{$totalProcessedData} transaction(s) are processed successfully.</p>";	
				$content.="<p>{$successTrans} transaction(s) are succeed.</p>";	
				$content.="<p>{$failedTrans} transaction(s) are failed.</p>";
				$content.="<p>{$inProcessTrans} transaction(s) are still in process.</p>";
				$content.="<p><strong>Date/Time :</strong>&nbsp;{$now}</p>";	
				$content.="<p><strong>Status :</strong>&nbsp;<span style='color:green'>Success</span></p>";					
				/*--/cron message on success--*/
			}else{
				/*--cron message on success--*/
				$content="<strong>Hi {$adminName}</strong>,<br/>&nbsp;&nbsp;&nbsp;";
				$content.="<p>Cron executed successfully for the verification of processing/pending transactions.</p>";
				$content.="<p>No transaction was pending.</p>";		
				$content.="<p><strong>Date/Time :</strong>&nbsp;{$now}</p>";	
				$content.="<p><strong>Status :</strong>&nbsp;<span style='color:green'>Success</span></p>";					
				/*--/cron message on success--*/
			}
		}catch(Exception $e){
		
			/*--cron message on success--*/
			$content="<strong>Hi {$adminName}</strong>,<br/>&nbsp;&nbsp;&nbsp;";
			$content.="<p>Cron executed successfully for the verification of processing/pending transactions. But some exception are thrown.</p>";	
			$content.="<p><strong>Date/Time :</strong>&nbsp;{$now}</p>";	
			$content.="<p><strong>Status :</strong>&nbsp;<span style='color:red'>Failed</span></p>";					
			/*--/cron message on success--*/
		}
		
		
		/*--cron status email--*/
		$to=constant('ADMIN_EMAIL');
		$from='info@myonlinerecharge.com';
		$subject="Cron notification for verification of processing/ending transactions";
		$content.="<p><strong>Thanks & Regards</strong></p><p>MOR System</p>";						
		$this-> sendEmail($to,$from,$subject,$content);	
		$this-> sendEmail('pksingh.gpj@gmail.com',$from,$subject,$content);	
				
		/*--/cron status email--*/
		echo $content;
		die;
		
	}
	
	private function do_recharge_verification($rs){
		
		$sess=$rs['recharge_session_id'];
		$opId=$rs['operator_id'];
		 
		/*-payment status verification--*/
		try{					
					
			$errCode=0;
			$errStatus = array();
			$arrRes= array('recharge_status'=>0);
	
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

					preg_match('/ERROR=(.*)/', $paymentVerificationRes, $errStatus);

					$rs1Status = array();
					preg_match('/RESULT=(.*)/', $paymentVerificationRes, $rs1Status);

					$arrRes['recharge_payment_verification_error_code']=$errStatus[1];
					$arrRes['recharge_payment_verification_result_code']=$rs1Status[1];
																				
					if($errStatus && $errStatus[1]==0 && $rs1Status[1]==7){

						$arrRes['recharge_status']=1;
					}
				}
			}			
			
		}catch(Exception $e){}
		/*-[end]payment status verification--*/
		return $arrRes;
						
	}
	
	/*---/cron task to verify transaction--*/	
	
}