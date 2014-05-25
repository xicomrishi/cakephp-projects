<?php
class HomeController extends AppController {

	public $name = 'Home';
	public $helpers = array('Form', 'Html', 'Js','Core','Session');
	public $paginate = array('limit' => 10);	
	public $uses=array('Content','Recharge','Operator');	
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow(array('index','contact_us'));		
	}	
	
	function admin_index() {
		$this->layout='admin';
		$this->set('title_for_layout','Dashboard');
		
		$arrCond=array('record_status NOT'=>'Trash');
		$this->paginate = array(
			'conditions'=>$arrCond,
    		'fields'=>array('Recharge.*','Operator.name','Customer.name','RechargeType.recharge_type'),
    		'limit'=>5,
     		'order'=> array('Recharge.id' => 'desc')
		);
		
		
		$rech = $this->paginate('Recharge');
		$this->set('Recharges',$rech);
	}
	
	function index() {
		$this->set('title_for_layout','My Online Recharge');			
			
   	}
   	
	function contact_us(){
		
		$this->layout='ajax';		
		if(!empty($this->request->data) && $this->request->is('ajax')){
			
			$from=$this->request->data['Contact']['email'];	
			$msg=strip_tags($this->request->data['Contact']['message']);
			$phone=strip_tags($this->request->data['Contact']['phone']);	
			$name=strip_tags($this->request->data['Contact']['name']);							
		
			
			$validationError='';
			if(empty($from)){
				$validationError.="<span class='error'>The filed Email can not be empty.</span><br/>";
			}else{			
				if(!filter_var($from, FILTER_VALIDATE_EMAIL)){
					$validationError.="<span class='error'>The filed Email is not a valid ID.</span><br/>";
					
				}
			}	
			if(empty($msg)){
				$validationError.="<span class='error'>The filed Message can not be empty.</span><br/>";
			}

			if(!empty($validationError)){
				echo $validationError;
				die;
			}
			
				
			$to="pappu.singh@i-webservices.com";
			if(@constant('SUPPORT_EMAIL')){
				$to=@constant('SUPPORT_EMAIL');
			}
			$subject="Need support?";
			$content="Following query generated from the site:<br/>";
			$content.="Name:{$name}<br/>";	
			$content.="Email:{$from}<br/>";	
			$content.="Phone:{$phone}<br/>";	
			$content.="Message:{$msg}";				
		
			/*-[end]template asssignment*/				
			if($this->sendEmail($to,$from,$subject,$content)){				
				
				echo "<span class='success'>Your message sent successfully.</span>";
			
			}else{				
				echo "<span class='error'>Email could not be sent.Please try again.</span>";
			
			}				
			die;
		}
	}
	
}
