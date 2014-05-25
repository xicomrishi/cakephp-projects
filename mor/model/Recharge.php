<?php
App::uses('AppModel', 'Model');
App::import('vendor','Rc43');
class Recharge extends AppModel {

	var $name = 'Recharge';
	public $useTable = 'recharges';
	
	public $belongsTo=array(
		'Customer'=>array(
			'className'=>'Customer',
			'foreignKey'=>'customer_id'
		),
		'Operator'=>array(
			'className'=>'Operator',
			'foreignKey'=>'operator_id'
		),
		'RechargeType'=>array(
			'className'=>'RechargeType',
			'foreignKey'=>'recharge_type'
		),
		
	);
	
	public $validateMobile = array(
		
		'number' => array(			
		   	'rule'=> array('phone', '/^\d{10}$/'), 
			'required'=>true,
        	'message'=> 'Please enter a valid 10 digit Phone Number.'				
		),
				
		'operator_id' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select the Operator.'
			)
			
		),		
		'amount' => array(			
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please enter the Amount.'
			),
			'money'=>array(
				'rule' => array('money'),
				'message' => 'Please enter a valid monetary Amount.'
			),
			 'comparison'=>array(
            	'rule' => array('comparison','<',1000),
             	'message' => 'The Amount should be less than 1000.'
             )				
		),
		'type' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select Service Type.'
			)			
		  )
	);
		
    
	
	public $validateDTH = array(
		
		'number' => array(			
		   	'required' =>array(
			   	'rule'=> array('numeric'), 
			   	'message'=> 'Please enter a valid DTH Number.'	
	        ),
        	'length' => array(
            	'rule' => array('between',6,11),
            	'message' => 'Please enter the DTH Number between 6 to 11 digits.',
       		 )
		),		
		
		'operator_id' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select the Operator.'
			)
			
		),	
		
		'amount' => array(			
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please enter the Amount.'
			),
			'money'=>array(
				'rule' => array('money'),
				'message' => 'Please enter a valid monetary Amount.'
			),
			 'comparison'=>array(
            	'rule' => array('comparison','<',1000),
             	'message' => 'The Amount should be less than 1000.'
             )				
		),
		
		'type' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select Service Type.'
			)			
		  )
	);
	
	
	
	public $validateLandlineAirtel = array(
		'number' => array(			
			'last'=> true,
        	'rule'=> array('phone', '/^\d{7,12}$/'), 
        	'message'=> 'Please enter a valid 7 - 12 digit Phone Number.'				
		),		
		'operator_id' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select the Operator.'
			)
			
		),		
		'amount' => array(			
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please enter the Amount.'
			),
			'money'=>array(
				'rule' => array('money'),
				'message' => 'Please enter a valid monetary Amount.'
			),
			 'comparison'=>array(
            	'rule' => array('comparison','<',3000),
             	'message' => 'The Amount should be less than 3000.'
             )				
		),
		'type' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select Service Type.'
			)			
		  )
	);
	
	
	public $validateLandlineMTNL = array(
	
		'number' => array(			
			'last'=> true,
        	'rule'=> array('phone', '/^\d{8}$/'), 
        	'message'=> 'Please enter a valid 8 digit Phone Number.'				
		),	
		'account' => array(			
			'last'=> true,
        	'rule'=> array('phone', '/^\d{10}$/'), 
        	'message'=> 'Please enter a valid 10 digit Account Number.'				
		),		
		'operator_id' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select the Operator.'
			)
			
		),		
		'amount' => array(			
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please enter the Amount.'
			),
			'money'=>array(
				'rule' => array('money'),
				'message' => 'Please enter a valid monetary Amount.'
			),
			 'comparison'=>array(
            	'rule' => array('comparison','<',3000),
             	'message' => 'The Amount should be less than 3000.'
             )				
		),
		'type' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select Service Type.'
			)			
		  )
	);
		
		
	
	public $validateElectricity = array(
		
		'number' => array(			
			'last'=> true,
        	'rule'=> array('phone', '/^\d{9,12}$/'), 
        	'message'=> 'Please enter a valid 9 - 12 digit Phone Number.'				
		),		
		'operator_id' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select the Operator.'
			)
			
		),		
		'amount' => array(			
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please enter the Amount.'
			),
			'money'=>array(
				'rule' => array('money'),
				'message' => 'Please enter a valid monetary Amount.'
			),
			 'comparison'=>array(
            	'rule' => array('comparison','<',30000),
             	'message' => 'The Amount should be less than 30000.'
             )				
		),
		'type' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select Service Type.'
			)			
		  )
	);
		
	
	public $validateElectricityRelince = array(
		
		'number' => array(			
			'last'=> true,
        	'rule'=> array('phone', '/^\d{9,12}$/'), 
        	'message'=> 'Please enter a valid 9 - 12 digit Phone Number.'				
		),		
		'operator_id' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select the Operator.'
			)
			
		),
		'account' => array(			
			'last'=> true,
        	'rule'=> array('phone', '/^\d{2}$/'), 
        	'message'=> 'Please enter a valid 2 digit Cycle Number.'				
		),		
		
		'amount' => array(			
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please enter the Amount.'
			),
			'money'=>array(
				'rule' => array('money'),
				'message' => 'Please enter a valid monetary Amount.'
			),
			 'comparison'=>array(
            	'rule' => array('comparison','<',10000),
             	'message' => 'The Amount should be less than 10000.'
             )				
		),
		'type' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select Service Type.'
			)			
		  )
	);
	
	
	
	public $validateGas = array(
		'number' => array(			
			'last'=> true,
        	'rule'=> array('phone', '/^\d{12}$/'), 
        	'message'=> 'Please enter a valid 12 digit Customer Account Number.'				
		),		
		'operator_id' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select the Operator.'
			)
			
		),		
		'amount' => array(			
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please enter the Amount.'
			),
			'money'=>array(
				'rule' => array('money'),
				'message' => 'Please enter a valid monetary Amount.'
			),
			 'comparison'=>array(
            	'rule' => array('comparison','<',10000),
             	'message' => 'The Amount should be less than 10000.'
             )				
		),
		'type' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select Service Type.'
			)			
		  )
	);
		
	
	public $validateInsurancePremium = array(
		
		'number' => array(			
			'last'=> true,
        	'rule'=> array('phone', '/^\d{8,10}$/'), 
        	'message'=> 'Please enter a valid 8 - 10 digit Policy Number.'				
		),		
		'operator_id' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select the Operator.'
			)
			
		),		
		'account' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please enter the Date of Birth.'
			),
			'date' => array(
            	'rule' => array('date', 'ymd'),
            	'message' => 'You must provide a Date of Birth in YYYY-MM-DD format.',
            	'allowEmpty' => true
       		)
			
		),	
		'amount' => array(			
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please enter the Amount.'
			),
			'money'=>array(
				'rule' => array('money'),
				'message' => 'Please enter a valid monetary Amount.'
			),
			 'comparison'=>array(
            	'rule' => array('comparison','<',20000),
             	'message' => 'The Amount should be less than 20000.'
             )				
		),
		'type' => array(
			'required' =>array(
				'rule'=>'notEmpty',
				'message' => 'Please select Service Type.'
			)			
		  )
	);
		
	
	public function resetValidationRule(){
		
		$rType=1;
		
		if(isset($this->data)){
			$rType=$this->data['Recharge']['type'];
		}
		
		if(!empty($rType)){		
			
			if(in_array($rType,array(1,3,4))){	//set validation rule for mobile
				
				$this->validate=$this->validateMobile;
				
			}elseif(in_array($rType,array(2))){	//set validation rule for dth
				
				$this->validate=$this->validateDTH;
				
			}elseif(in_array($rType,array(5))){	//set validation rule for landline
				
				if(isset($this->data['Recharge']['operator_id']) && $this->data['Recharge']['operator_id']==44){
					
					$this->validate=$this->validateLandlineAirtel;
					
				}elseif(isset($this->data['Recharge']['operator_id']) && $this->data['Recharge']['operator_id']==45){
					
					$this->validate=$this->validateLandlineMTNL;
				}				
				
			}elseif(in_array($rType,array(6))){	//set validation rule for electricity
				
				if(isset($this->data['Recharge']['operator_id']) && $this->data['Recharge']['operator_id']==46){
					$this->validate=$this->validateElectricityRelince;
				}else{
					$this->validate=$this->validateElectricity;
				}
				
			}elseif(in_array($rType,array(7))){
				
				$this->validate=$this->validateGas;
				
			}elseif(in_array($rType,array(8))){	//set validation rule for insurance
				
				$this->validate=$this->validateInsurancePremium;
			}
			
		}else{
			$this->validate=$this->validateMobile;
		}
		
	}
	
	
	public $cpErrors=array(0=>'Successfully completed.',
							1=>'Session with this number already exists.',
							2=>'Invalid Dealer code.',
							3=>'Invalid acceptance outlet code.',
							4=>'Invalid Operator code.',
							5=>'Invalid session code format.',
							6=>'Invalid EDS.',
							7=>'Invalid amount format or amount value is out of admissible range.',
							8=>'Invalid phone number format.',
							9=>'Invalid format of personal account number.',
							10=>'Invalid request message format.',
							11=>'Session with such a number does not exist.',
							12=>'The request is made from an unregistered IP.',
							13=>'The outlet is not registered with the Service Provider.',
							15=>'Payments to the benefit of this operator are not supported by the system.',
							17=>'The phone number does not match the previously entered number.',
							18=>'The payment amount does not match the previously entered amount.',
							19=>'The account (contract) number does not match the previously entered number.',
							20=>'The payment is being completed.',
							21=>'Not enough funds for effecting the payment.',
							22=>'The payment has not been accepted. Funds transfer error.',
							23=>'Invalid phone (account) number.',
							223=>'Not appropriate subscriber contract for top-up',
							24=>'Invalid phone.',
							25=>'Effecting of this type of payments is suspended.',
							26=>'Payments of this Dealer are temporarily blocked',
							27=>'Operations with this account are suspended',
							30=>'General system failure.',
							31=>'Exceeded number of simultaneously processed requests (CyberPlat).',
							32=>'Repeated payment within 60 minutes from the end of payment effecting process
							(CyberPlat).',
							33=>'Exceeded the maximum interval between number verification and payment (24 hours).',
							34=>'Transaction with such number could not be found.',
							35=>'Payment status alteration error.',
							36=>'Invalid payment status.',
							37=>'An attempt of referring to the gateway that is different from the gateway at the previous
							stage.',
							38=>'Invalid date. The effective period of the payment may have expired.',
							39=>'Invalid account number.',
							40=>'The card of the specified value is not registered in the system',
							41=>'Error in saving the payment in the system.',
							42=>' Error in saving the receipt to the database.',
							43=>' Your working session in the system is invalid (the duration of the session may have
							expired), try to re-enter.',
							44=>'The Client cannot operate on this trading server.',
							45=>'No license is available for accepting payments to the benefit of this operator.',
							46=>'Could not complete the erroneous payment.',
							47=>'Time limitation of access rights has been activated.',
							48=>'Error in saving the session data to the database.',
							50=>'Effecting payments in the system is temporarily impossible.',
							51=>'Data are not found in the system.',
							52=>'The Dealer may be blocked. The Dealer’s current status does not allow effecting
							payments.',
							53=>'The Acceptance Outlet may be blocked. The Acceptance Outlet’s current status does not
							allow effecting payments.',
							54=>'The Operator may be blocked. The Operator’s current status does not allow effecting
							payments.',
							55=>'The Dealer Type does not allow effecting payments.',
							56=>'An Acceptance Outlet of another type was expected. This Acceptance Outlet type does
							not allow effecting payments.',
							57=>'An Operator of another type was expected. This Operator type does not allow effecting
							payments.',
							81=>'Exceeded the maximum payment amount.',
							82=>'Daily debit amount has been exceeded.'
			);

	
	function parseEbsResponse($res,$secret_key){
 		
		 $DR = preg_replace("/\s/","+",$res);
	
		 $rc4 = new Crypt_RC4($secret_key);
	 	 $QueryString = base64_decode($DR);
		 $rc4->decrypt($QueryString);
		 $QueryString = split('&',$QueryString);
	
		 $response = array();
		 if($QueryString){
			 foreach($QueryString as $param){
			 	$param = split('=',$param);
				$response[$param[0]] = urldecode($param[1]);
			 }			 
		 }
		 
		 return $response;
	}
	
	function getQueryResult($qs,$url){
		
		$url=$url."?inputmessage=".urlencode($qs);
		$opts = array( 
		  'http'=>array( 
		    'method'=>"GET", 
		    'header'=>array("Content-type: application/x-www-form-urlencoded\r\n") 
		  ) 
		); 
		
		$context = stream_context_create($opts); 	
		$phoneVerificationRes = file_get_contents($url,false,$context);		
		return $phoneVerificationRes;
	}	
	
}
