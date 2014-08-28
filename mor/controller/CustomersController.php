<?php
class CustomersController extends AppController {

	public $name = 'Customers';
	public $helpers = array('Form', 'Html', 'Js','Session','Core');
	public $paginate = array('limit' =>10);	
	public $uses=array('Customer','Country','Recharge','CustomerLogin','Content','EmailTemplate','Wallet');
	public $components=array('Core','Email','RequestHandler');
		
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index','recharge_auth','logout','forgot_password');
	}
	
	function admin_index($cusType=null) {		
		
		$arrCond=array();

		if(isset($this->request->query['search_key'])){				
			$query=$this->request->query['search_key'];
			if(!empty($query) ){
				
				$arrCond['OR']=array('email LIKE'=>"%{$query}%",
				'phone LIKE'=>"%{$query}%",
				"name LIKE"=>"%{$query}%"
				);
				$this->set("SearchKey",$query);			
			}
		}
		
		if(!empty($cusType)){
			$arrCond['customer_type']=ucfirst($cusType);
			$this->set('CustomerType',$cusType);
		}		
		
		$this->paginate = array(
			'conditions'=>$arrCond,
    		'limit'=>20,
     		'order'=> array('Customer.customer_id' => 'desc')			
		);		
		$this->set('Customers', $this->paginate());
	}
	
	
	function admin_view($id = null) {
		$this->Customer->recursive=3;
		if (!$id) {
			$this->Session->setFlash(__('Invalid Customer', true),'default',array('class'=>'error'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Wallet->bindModel(array('belongsTo'=>array('Recharge'=>array('className'=>'Recharge','foreignKey'=>'recharge_id'))));
		$this->Customer->bindModel(array('hasMany'=>array('Wallet'=>array('className'=>'Wallet','foreignKey'=>'customer_id'))));
	
		$this->set('Customer', $this->Customer->read(null, $id));	
	}

	function admin_add(){
				
		if (!empty($this->request->data) && $this->request->is('post')) {
			$this->Customer->create();
			
			$this->request->data['Customer']['customer_added_date']=date('Y-m-d H:i:s');
			$pass=$this->request->data['Customer']['password'];
			$this->request->data['Customer']['password']=AuthComponent::password($pass);
			
			if($this->Customer->save($this->request->data)) {
			 	$this->Session->setFlash(__('The customer added successfully',true),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->request->data['Customer']['password']=$pass;			
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.',true),'default',array('class'=>'error'));
			}	      
		}	
		$country=$this->Country->find('all');
		$this->set('Country',$country);	
	}

		
	function admin_edit($id = null) {
	
		$this->Customer->id = $id;
		if (!$this->Customer->exists()) {
			throw new NotFoundException(__('Invalid Customer'));
		}
		$this->Customer->validator()->remove('password');
		
		if ($this->request->is('post') || $this->request->is('put')) {
			
			$this->request->data['Customer']['customer_modified_date']=date('Y-m-d H:i:s');
			
			$customerDBPass=$this->Customer->findByCustomerId($id,array('fields'=>'password'));
			$customerDBPass=$customerDBPass['Customer']['password'];
			
			$newPass='';
			if(!empty($this->request->data['Customer']['password'])){
				$newPass=$this->request->data['Customer']['password'];
				$this->request->data['Customer']['password']=AuthComponent::password($newPass);
			}else{
				unset($this->request->data['Customer']['password']);
			}
			
			if($this->Customer->save($this->request->data)) {
				$this->Session->setFlash(__('The customer updated successfully',true),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->request->data['Customer']['password']=$newPass;
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.',true),'default',array('class'=>'error'));
			}
		}
		
		if (empty($this->request->data)) {
			$data=$this->Customer->read(null, $id);
			unset($data['Customer']['password']);
			$this->request->data = $data;
		}
	
		$country=$this->Country->find('all');
		$this->set('Country',$country);
	}

	
	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for customer', true),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		
		if ($this->Customer->delete($id,false)) {
			/*-delete all associated records--*/
		
			//delete all associated recharges			
			$this->Recharge->deleteAll(array('Recharge.customer_id'=>$id),false);			
			/*-delete all associated records--*/
			
			$this->Session->setFlash(__('The customer deleted successfully', true),'default',array('class'=>'success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('The customer could not be deleted', true),'default',array('class'=>'error'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	function index() {
	
		if (!empty($this->request->data) && $this->request->is('post')) {			
			
			/*--unset guest session if--*/
			unset($_SESSION['GuestCustomer']);
			$this->Session->delete('GuestCustomer');
			/*--/unset guest session if--*/
			
			
			/*--customer registration--*/		
			if(isset($this->request->data['Customer'])){
				
				$this->Customer->create();			
				$this->request->data['Customer']['customer_added_date']=date('Y-m-d H:i:s');
				
				$this->Customer->set($this->request->data);
				
				if($this->Customer->validates(array('filedList'=>array('email','password','confirm_password','name')))){
				
					$pass=$this->request->data['Customer']['password'];				
					$this->request->data['Customer']['password']=AuthComponent::password($pass);					
					$this->request->data['Customer']['customer_type']='Registered';
					
					/*--check for guest user, if convert it into regestered--*/
					$xcustomer=$this->Customer->findByEmail($this->request->data['Customer']['email']);
					if(!empty($xcustomer) && $xcustomer['Customer']['customer_type']=='Guest'){
						$this->Customer->id=$xcustomer['Customer']['customer_id'];
					}
					/*--/check for guest user, if convert it into regestered--*/
					
					if($this->Customer->save($this->request->data,false)) {
					 	$this->Session->setFlash(__('Your registration process completed successfully.',true),'default',array('class'=>'success register'));
						
					 	/*--logged in after successfull registration--*/
					 	$this->request->data['CustomerLogin']['email']=$this->request->data['Customer']['email'];
					 	$this->request->data['CustomerLogin']['password']=$pass;
					 	
					 	/*--send registration email--*/
					 	
					 	$to=$this->request->data['Customer']['email'];	
					 	$email=$to;							
						$name=$this->request->data['Customer']['name'];
						$from="info@myonlinerecharge.com";
											
						$template = $this->EmailTemplate->find('first',
							 array('conditions' => array('template_key'=> 'succcessful_signup',
						  	 'template_status' =>'Active')));
								
						if($template){	
							$arrFind=array('{name}','{password}','{email}');
							$arrReplace=array($name,$pass,$email);							
							$from=$template['EmailTemplate']['from_email'];
							$subject=$template['EmailTemplate']['email_subject'];
							$content=str_replace($arrFind, $arrReplace,$template['EmailTemplate']['email_body']);					
							$this-> sendEmail($to,$from,$subject,$content);
						}
						/*--/send registration email--*/				 	
					 	
					 	if($this->Auth->login()){			 
			 	
						 	/*--update access logs--*/
						 	$this->Customer->validation=null;
						 	$arrData=array('Customer'=>
								array('last_login_ip'=>$this->request->clientIp(),
								'last_login_date'=>date('Y-m-d H:i:s')
							));
							
							$this->Customer->id=$this->Auth->user('customer_id');
							$this->Customer->save($arrData,false);
							/*--update access logs--*/				
						 	$trans=$this->Session->read('Transaction');			
							if($trans && $trans['NbrVerification']=='success'){//check if he is in recharge process, redirect to payment
								$this->redirect(array('controller'=>'recharges','action' => 'payment'));	
						 		die;
							}else{//redirect to profile	 
						 		$this->redirect(array('controller'=>'customers','action' => 'profile'));	
						 		die;
							}
					 	}
					 	/*--/logged in after successfull registration--*/					 	
					 	
					} else {
						$this->request->data['Customer']['password']=$pass;			
						$this->Session->setFlash(__('The registration process could not be completed. Please try again.',true),'default',array('class'=>'error register'),'register');
					}
				
				}else{
					$this->Session->setFlash(__('The registration process could not be completed. Please correct the below error(s).',true),'default',array('class'=>'error register'),'register');					
				}
			}elseif(isset($this->request->data['CustomerLogin'])){
				 
				if($this->Auth->login()){			 
			 	
				 	/*--update access logs--*/
				 	$this->Customer->validation=null;
				 	$arrData=array('Customer'=>
						array('last_login_ip'=>$this->request->clientIp(),
						'last_login_date'=>date('Y-m-d H:i:s')
					));
					
					$this->Customer->id=$this->Auth->user('customer_id');
					$this->Customer->save($arrData,false);
					/*--update access logs--*/			
				 	
				 	$this->redirect(array('controller'=>'customers','action' => 'profile'));			 	 
				 	 
				 }else{
				 	$this->Session->setFlash(__('Invalid email or password,Please try again.',true),'default',array('class'=>'error register'),'login');
				 }	
			}
	      /*--/customer registration--*/
		}		
	}
	
	
	
	function recharge_auth() {		 
	
		if (!empty($this->request->data) && $this->request->is('post')) {			
			
			/*--customer registration--*/		
	
			if(isset($this->request->data['Customer']) && $this->request->data['Customer']['action']=='guest'){			
								
				$this->Customer->set($this->request->data);				
				
				if($this->Customer->validates(array('filedList'=>array('guest_email','name')))){
					$uuid=String::uuid();
					
					/*--check for existing email id--*/
					$xcustomer=$this->Customer->findByEmail($this->request->data['Customer']['guest_email']);
					$arrGuestData=null;
					
					if(!empty($xcustomer) && $xcustomer['Customer']['customer_type']=='Guest'){
						$arrGuestData=array('Customer'=>
							array('customer_modified_date'=>date('Y-m-d H:i:s'),
								'last_login_ip'=>$this->request->clientIp(),
								'last_login_date'=>date('Y-m-d H:i:s')
							)
						);	
						
						$this->Customer->id=$xcustomer['Customer']['customer_id'];
						
					}elseif(!empty($xcustomer) && $xcustomer['Customer']['customer_type']=='Registered'){
						$this->Session->setFlash(__('Sorry, You are registered user. Please login.',true),'default',array('class'=>'error register'),'guest');
				
					}else{
						$arrGuestData=array('Customer'=>
							array('customer_type'=>'Guest',	
								'password'=>AuthComponent::password($uuid),
								'email'=>$this->request->data['Customer']['guest_email'],
								'customer_added_date'=>date('Y-m-d H:i:s'),
								'last_login_ip'=>$this->request->clientIp(),
								'last_login_date'=>date('Y-m-d H:i:s')
							)
						);
					}

					if(!empty($arrGuestData)){
						
						if($d=$this->Customer->save($arrGuestData,false)) {

							$data=$this->Customer->findByCustomerId($this->Customer->id);
							$this->Session->write('GuestCustomer',$data['Customer']);							
							$this->redirect(array('controller'=>'recharges','action' => 'payment'));
							die;
													
						} else {						
							$this->Session->setFlash(__('The guest signup could not be completed. Please try again.',true),'default',array('class'=>'error register'),'guest');
						}
					}
				
				}else{					
					$this->Session->setFlash(__('The guest signup could not be completed. Please correct the below error(s).',true),'default',array('class'=>'error register'),'guest');					
				}
				
			}elseif(isset($this->request->data['Customer']) && $this->request->data['Customer']['action']=='login'){
			
				if($this->Auth->login()){	

				 	/*--update access logs--*/
				 	$this->Customer->validation=null;
				 	$arrData=array('Customer'=>
						array('last_login_ip'=>$this->request->clientIp(),
						'last_login_date'=>date('Y-m-d H:i:s')
					));
					
					$this->Customer->id=$this->Auth->user('customer_id');
					$this->Customer->save($arrData,false);
					/*--update access logs--*/	

						
					/*--unset guest session if--*/
					unset($_SESSION['GuestCustomer']);
					$this->Session->delete('GuestCustomer');
					/*--/unset guest session if--*/
		
				 	
				    $this->redirect(array('controller'=>'recharges','action' => 'payment'));
				 	 
				 }else{				
				 	$this->Session->setFlash(__('Invalid email or password,Please try again.',true),'default',array('class'=>'error register'),'login');
				 }	
			}
	      /*--/customer registration--*/		
		}		
		
		$content=$this->Content->find('all',array('conditions'=>
   		array('page_slug'=>'guest_signup_page','status'=>'Publish')));
   		if($content){
   			foreach($content as $row){
   				$this->set($row['Content']['page_slug'],$row['Content']);
   			}
   		}	
	}
	
	
	function edit_profile() {
		$this->layout='ajax';
	
		if (!empty($this->request->data) && $this->RequestHandler->isAjax()) {
		
			$customer=$this->Auth->user();
			$this->Customer->id=$customer['customer_id'];		
				
			if($this->request->data['Customer']['name']=='Name')$this->request->data['Customer']['name']='';
			if($this->request->data['Customer']['phone']=='Mobile No')$this->request->data['Customer']['phone']='';
			if($this->request->data['Customer']['address']=='Area')$this->request->data['Customer']['address']='';
			if($this->request->data['Customer']['city']=='City')$this->request->data['Customer']['city']='';
					
			$data=array('Customer'=>array('name'=>$this->request->data['Customer']['name'],
				'phone'=>$this->request->data['Customer']['phone'],
				'address'=>$this->request->data['Customer']['address'],
				'city'=>$this->request->data['Customer']['city'],
				'state_id'=>$this->request->data['Customer']['state'],
				'customer_modified_date'=>date('Y-m-d H:i:s')));
				
			$this->Customer->set($data);
			
			if($this->Customer->validates(array('filedList'=>array('name')))){				
				
				if($this->Customer->save($data,false)) {
					echo "<div class='success'>Your profile updated successfully.</div>";				 	
				} else {							
					echo "<div class='error'>The data could not be saved. Please try again.</div>";
				}
			
			}else{
				$validateErr=$this->Customer->validationErrors;
				$strErr='';
				if(!empty($validateErr)){
					foreach($validateErr as $err){
						$strErr.=$err[0].'<br/>';
					}
				}
				echo "<div class='error'>Please correct the below error(s):<br/>{$strErr}</div>";				
			}		
		}
		die;		
	}
	
	function change_password() {
		$this->layout='ajax';
	
		if (!empty($this->request->data) && $this->RequestHandler->isAjax()) {
		
			$customer=$this->Auth->user();
			$this->Customer->id=$customer['customer_id'];		
				
			if($this->request->data['Customer']['old_password']=='Old Password')$this->request->data['Customer']['old_password']='';
			if($this->request->data['Customer']['password']=='New Password')$this->request->data['Customer']['password']='';
			if($this->request->data['Customer']['confirm_password']=='CConfirm Password')$this->request->data['Customer']['confirm_password']='';

			$this->Customer->set($this->request->data);
			
			if($this->Customer->validates(array('filedList'=>array('old_password','password','confirm_password')))){			
								
				/*--verify old password--*/
				$pass=$this->Auth->password($this->request->data['Customer']['old_password']);
				$customerDB=$this->Customer->findByCustomerIdAndPassword($this->Customer->id,$pass);
				/*--/verify old password--*/
						
				if(!empty($customerDB)){	
					
					$newPass=$this->Auth->password($this->request->data['Customer']['password']);
					$data=array('Customer'=>array('password'=>$newPass,
				'customer_modified_date'=>date('Y-m-d H:i:s')));
				
					if($this->Customer->save($data,false)) {
						echo "<div class='success'>Your password changed successfully.</div>";				 	
					} else {
								
						echo "<div class='error'>The password could not be changed. Please try again.</div>";
					}
				}else{
						echo "<div class='error'>Invalid old password.</div>";
			
				}
			}else{
				$validateErr=$this->Customer->validationErrors;
				$strErr='';
				if(!empty($validateErr)){
					foreach($validateErr as $err){
						$strErr.=$err[0].'<br/>';
					}
				}
				echo "<div class='error'>Please correct the below error(s):<br/>{$strErr}</div>";				
			}	
		}		
		die;		
	}
	
	function forgot_password(){
		
		$this->layout='ajax';		
		$this->Customer->set($this->request->data);
		$this->Customer->validate = array('email' =>array('required' => array('rule' => array('notEmpty'))));
		
		if($this->Customer->validates(array('fieldList'=>array('email')))){
		
			$rs=$this->Customer->findByEmail($this->request->data['Customer']['email']);
			if($rs){
						
				$email=$rs['Customer']['email'];				
				$name=$rs['Customer']['name'];
				$newPass=$this->Core->generatePassword();
				
				$from="info@myonlinerecharge.com";
				$to=$email;
				$subject="Forgot Password Email";
				$content="Your New Password is:".$newPass;
								
				/*-template asssignment if any*/
				$template = $this->EmailTemplate->find('first',
					 array('conditions' => array('template_key'=> 'forgot_password_email',
				  	 'template_status' =>'Active')));
						
				if($template){	
					$arrFind=array('{name}','{password}','{email}');
					$arrReplace=array($name,$newPass,$email);
					
					$from=$template['EmailTemplate']['from_email'];
					$subject=$template['EmailTemplate']['email_subject'];
					$content=str_replace($arrFind, $arrReplace,$template['EmailTemplate']['email_body']);					
					
				}
					
				if($this-> sendEmail($to,$from,$subject,$content)){
					/*--update user password--*/
					$this->Customer->id=$rs['Customer']['customer_id'];
					$data=array('Customer'=>array('password'=>AuthComponent::password($newPass)));
					$this->Customer->save($data);
					/*--/update user password--*/
					
					echo "<h4 class='success forgot_pass'>New password is sent to your email.";
					echo "</h4>";
				}else{				
					echo "<h4 class='error forgot_pass'>The email could not be sent.Please contact to administrator.</h4>";
					die;
				}								
								
			}else{
				echo "<h4 class='error forgot_pass'>Email does not exist.</h4>";
			}
		}else{
			echo "<div class='error forgot_pass'>Please enter the valid Email.</div>";
		}
		die;
	}
	
	function profile($tab=null){
		
		$this->layout = ($this->request->is("ajax")) ? "ajax" : "default";
	
		$customer=$this->Auth->user();
		$this->set('Customer',$this->Customer->findByCustomerId($customer['customer_id']));
			
		
		/*--load recharge history--*/
		$this->paginate = array(
			'conditions'=>array('Recharge.customer_id'=>$customer['customer_id']),
    		'fields'=>array('Recharge.*','Operator.name','RechargeType.recharge_type'),
    		'limit'=>4,
     		'order'=> array('Recharge.id' => 'desc')
		);
		
		$this->set('Recharges',$this->paginate('Recharge'));
		if($this->request->is("ajax")){
			$this->render('ajax_transaction_list');
		}
		
		/*--/load recharge history--*/
		
		/*--load state--*/
		$this->loadModel('State');
		$this->set('States',$this->State->find('all'));
		
		/*--/load state--*/		
		
		/*--load cms for profile page--*/  	
		$content=$this->Content->find('all',array('conditions'=>
   		array('page_slug'=>array('profile_home_content','what_is_my_wallet','how_to_add_fund'),'status'=>'Publish')));
   		if($content){
   			foreach($content as $row){
   				$this->set($row['Content']['page_slug'],$row['Content']);
   			}
   		} 
   		/*--/load cms for profile page--*/ 
		
		$this->set('tab',$tab); 	
				
	}
	
	public function get_my_wallet(){
		
		$this->layout='ajax';
		$customer=$this->Auth->user();
		$this->set('Customer',$this->Customer->findByCustomerId($customer['customer_id']));
		
		$this->paginate = array(
				'conditions'=>array('Wallet.customer_id'=>$customer['customer_id']),
				'fields'=>array('Wallet.*','Recharge.*'),
				'limit'=>4,
				'order'=> array('Wallet.id' => 'desc'),
				'joins'=>array(
					array(
						'table'=>'recharges','alias'=>'Recharge','type'=>'left','conditions'=>array('Wallet.recharge_id=Recharge.id')
					)
				)
			);
		
		$arr=$this->paginate('Wallet');
		$this->set('arr',$arr);
		$this->render('my_wallet_transactions');		
	}
	
	function logout(){
		
		unset($_SESSION['GuestCustomer']);		
		$this->Session->delete('GuestCustomer');
		unset($_SESSION['Cart']);	
		$this->Session->delete('Cart');			
		
		$this->Session->setFlash(__('You have logged out successfully.',true),'default',array('class'=>'success logout'));
		$this->redirect($this->Auth->logout());
	}
		
}
