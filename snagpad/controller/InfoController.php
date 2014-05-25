<?php 
App::import('Core','Validation');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', array('functions','xml_regex'));
App::import('Controller', array('Mail','Users'));
class InfoController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');	
    public $uses = array('Content','Account','Message','Agency','Employer','Agencycards','Onetmodel','Skillslist','Jobtask','Jobfamily','Contactrequest','Card','Carddetail','Cardcolumn','Contact','Cardcontact');
	

    public function why_snagpad() {
        $this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('why_snagpad');
        $this->set('content',$content['Content']);
        $this->render('cms_content');
    //    $this->render('why_snagpad');
    }

    public function terms_of_service($val=0) {
        $this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('terms_of_service');
		if($val==1)
		{
			$this->set('accept_terms','1');	
		}
        $this->set('content',$content['Content']);
        $this->render('cms_content');
      //  $this->render('terms_of_service');
    }

    public function online_training() {
        $this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('online_training');
        $this->set('content',$content['Content']);
        $this->render('cms_content');
        //$this->render('online_training');
    }
	
	public function index($page_url){

		if(!function_exists($this->$page_url)){
			$this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl($page_url);
        $this->set('content',$content['Content']);
        $this->render('cms_content');
		}
		else{
		$this->$page_url();
		$this->autorender=false;
		}
	}

    public function scd_course() {
        $this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('scd_course');
        $this->set('content',$content['Content']);
        $this->render('cms_content');
        
    }
	
	public function ebook() {
        $this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('ebook');
        $this->set('content',$content['Content']);
        $this->render('cms_content');
        
    }

    public function scd_manage() {
        $this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('scd_manage');
        $this->set('content',$content['Content']);
        $this->render('cms_content');
        
    }

    public function cjs_toolkit() {
        $this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('cjs_toolkit');
        $this->set('content',$content['Content']);
        $this->render('cms_content');
        
    }

    public function assist_job_seeker($tab='job_search_professional') {
        $this->layout = 'cms_page';
        $contents=$this->Content->findAllByPageUrl(array('outplacement','higher_education','job_search_professional'));
        $this->set('contents',$contents);
        $this->set('default',$tab);
        $this->render('tab_info');
      //  $this->render('assist_job_seeker');
    }
	
	public function outplacement(){
		$this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('outplacement');
        $this->set('content',$content['Content']);
        $this->render('cms_content');
		
	}
	public function pricing($account_id=0){
		$this->loadModel('Subscription');
		$this->layout = 'cms_page';
		if(intval($account_id)>0)
		{
			$this->set('account_id',$account_id);
			//$client=$this->Client->find('first'
			$condition=array('active'=>1,'subscription_for'=>'3','id !='=>'1');
		}
		else
			$condition=array('active'=>1);
        $datas=$this->Subscription->find('all',array('conditions'=>$condition,'order'=>"CASE subscription_for WHEN '1' THEN 4 ELSE subscription_for END ASC, ID ASC"));
					
        $this->set('datas',$datas);		
        $this->render('pricing');		
	}
	public function checkaccount(){
		$this->loadModel('Client');
		$this->layout = 'ajax';
		$this->autoRender=false;
		Configure::write('debug',2);		
		if(isset($this->data['account_id']) && $this->data['account_id']!='')
			$condition=array('email'=>$this->data['email'],'FIND_IN_SET('.$this->data['usertype'].', usertype)', 'id !='.$this->data['account_id']);
		else
			$condition=array('email'=>$this->data['email'],'FIND_IN_SET('.$this->data['usertype'].', usertype)');
			
        $account=$this->Account->find('first',array('conditions'=>$condition,'fields'=>array('id')));
				
       	if(count($account['Account']['id'])==0)
			echo "";	
		else
		{
			//echo "Email address already registered, Please use other valid email address.";	
			//die;
			//echo $account['Account']['id'];	
			if(intval($account['Account']['id'])>0 && $this->data['usertype']==3 && !isset($this->data['user_trail']))
			{
				$alredyClient=$this->Client->find('count',array('conditions'=>array('subscription'=>1,'account_id '=>$account['Account']['id'])));
			if($alredyClient)
				echo $account['Account']['id'];						
			}
			else
				echo "Email address already registered, Please use other valid email address.";		
			
		}			
	}
	public function shoping_cart($alias=null,$account_id=0){
		if($alias==null)
		{
			//$this->Session->setFlash('Wrong selection.');
			$this->redirect(SITE_URL.'/info/pricing');
		}
		else
		{
		$this->loadModel('Subscription');
		$this->loadModel('Client');
		$this->layout = 'cms_page';			
        $data=$this->Subscription->find('first',array('conditions'=>array('active'=>1,'alias'=>$alias)));
		if($data)
		{
			if(intval($account_id)>0)
			{
				if($data['Subscription']['subscription_for']==3)
				$client=$this->Client->find('first',array('conditions'=>array('subscription'=>1,'account_id'=>$account_id),'fields'=>array('name','email','account_id')));
			if($client)
				$this->set('client',$client['Client']);
			}
			
        	$this->set('data',$data);
			$this->set('alias',$alias);
		}
		else
			$this->Session->setFlash('Wrong selection.');			
        
		}
		$this->render('shoping_cart');	
	}
	/*public function test(){ 
		$this->autoRender=false;
		$Users = new UsersController;	
    	$Users->constructClasses();	
		$acdata['email']='viveksh987@gmail.com';
		$acdata['usertype']=2;
		$date = "20:35:45 Feb 07, 2013 PST";
		echo date('m',strtotime($date));
		$acdata['plan_due_date']=date('Y-m-d',mktime(0,0,0,date('m',strtotime($date))+1,date('d',strtotime($date)),date('Y',strtotime($date))));
		print_r($acdata['plan_due_date']);
$newdate = strtotime ( '1 year' , strtotime ( $date ) ) ;
$newdate = date ( 'Y-m-j' , $newdate );

echo $newdate;
		//$Users->upadteSubscriptionAccount($acdata['email'],$acdata['usertype'],$acdata['plan_due_date']);					
	}*/
	public function payments(){  
		$this->autoRender=false;
		CakeLog::config('payment', array('engine' => 'FileLog','file' => 'payment.log'));		
		$paypal_email = 'admin@snagpad.com';
		//$paypal_email = 'gautam.mailme82@gmail.com';
		$adminemail='gautam.kumar@i-webservices.com';
		$return_url = SITE_URL.'/info/success';
		$cancel_url = SITE_URL.'/info/cancel';
		$notify_url = SITE_URL.'/info/payments';
		$this->loadModel('Payment');
		$this->loadModel('PaymentHistory');
		$this->loadModel('PaymentFail');
		$this->loadModel('Subscription');	
		$querystring='';		
		
		if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){			
			
			// Firstly Append paypal account to querystring
			$querystring .= "?business=".urlencode($paypal_email)."&";	
			//loop for posted values and append to querystring
			$datas=$this->data;	
			$payment=$this->Payment->find('first',array('conditions'=>array('email'=>$this->data['email'],'usertype'=>$this->data['usertype'],'item_number'=>$this->data['item_number'])));
			
			if(!$payment)
			{		
				$this->Payment->create();
				$payment=$this->Payment->save($datas);	
			}
			else
			{
				$this->Payment->create();
				$this->Payment->id=$payment['Payment']['id'];				
				$this->Payment->save($datas);				
			}
			
			$this->request->data['custom']=$this->data['email'].'||'.$payment['Payment']['id'];
			// Append paypal return addresses
			$this->request->data['invoice']=str_pad($payment['Payment']['id'],4,0,STR_PAD_LEFT);		
			
			foreach($this->data as $key => $value){
				$value = urlencode(stripslashes($value));
				$querystring .= "$key=$value&";
			}			
			$querystring .= "return=".urlencode(stripslashes($return_url))."&";
			$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
			$querystring .= "notify_url=".urlencode(stripslashes($notify_url));	
			// Redirect to paypal IPN
			header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
			exit();
	}		
	else
	{		
	// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
			$req .= "&$key=$value";
		}	
		// assign posted variables to local variables
		
		$data['item_number'] 		= $_POST['item_number'];
		$data['subscr_id']			= $_POST['subscr_id'];
		//$data['transaction_subject'] 		= $_POST['transaction_subject'];
				
		$paymenthistoty['payment_status'] =trim($_POST['payment_status']);
		if(isset($_POST['txn_type']))
		$paymenthistoty['txn_type']=$data['txn_type']=$data['payment_status']=trim($_POST['txn_type']);
		else // refund case
		$paymenthistoty['txn_type']=$data['txn_type']=$data['payment_status']=trim($_POST['reason_code']);
		
		$paymenthistoty['txn_id']		= $_POST['txn_id'];
		$paymenthistoty['amount3']		= $_POST['amount3'];
		$paymenthistoty['mc_amount3']	= $_POST['mc_amount3'];
		$paymenthistoty['period3']		= $_POST['period3'];
		$paymenthistoty['currency']		= $_POST['mc_currency'];		
		$paymenthistoty['ipn_track_id'] = $_POST['ipn_track_id'];
		$paymenthistoty['payer_id']		=  $_POST['payer_id'];		
		$paymenthistoty['payment_gross']=$_POST['payment_gross'];
		if(isset($_POST['subscr_date']))
			$date=$_POST['subscr_date'];
		else $date=$_POST['payment_date'];		
		
		$paymenthistoty['date']=$data['date']=date("Y-m-d H:i:s",strtotime($date));		
		
		$custom						=explode('||',$_POST['custom']);		
		$data['id'] 				=intval("$_POST[invoice]");
		
		// post back to PayPal system to validate
		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";		
		$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);	
		 @mail($adminemail, "PAYPAL Details notification", "Notification Response<br />data = <pre>".print_r($_POST, true)."</pre>");	
		if (!$fp) {
		// HTTP ERROR
		     @mail($adminemail, "PAYPAL INVALID", "Invalid Response<br />data = <pre>".print_r($_POST, true)."</pre>");
			} else {	
			fputs ($fp, $header . $req);
			while (!feof($fp)) {
				$res = fgets ($fp, 1024);
				if (strcmp($res, "VERIFIED") == 0) {
				// Validate payment 
					$payments=$this->Payment->find('first',array('conditions'=>array('id'=>$data['id'])));				
					// PAYMENT VALIDATED & VERIFIED!
					if($payments){			
													
						$this->Payment->id=$data['id'];
						$sucpayment=$this->Payment->save($data);
						$paymenthistoty['payment_id']=$data['id'];												
						if($sucpayment){ // Payment has been made & successfully inserted into the Database										
							$itemnumber=$this->Subscription->findByItemNumber($data['item_number']);							
							$acdata['email']=$payments['Payment']['email'];
							$acdata['usertype']=$payments['Payment']['usertype'];
							$acdata['name']=$payments['Payment']['first_name'].' '.$payments['Payment']['last_name'];			
							$Users = new UsersController;	
    						$Users->constructClasses();		
							if($data['txn_type']=='subscr_signup' || $data['txn_type']=='web_accept' ) // First Time Plan Taken
							{
								@mail($adminemail,$data['txn_type'], "Sign UP.<br />details are = <pre>".print_r($_POST, true)."</pre>");	
								if($paymenthistoty['payment_status']=='Completed')
								{
								$lastday=date('Y-m-d',mktime(0,0,0,date('m'),date('d')-15,date('Y')));
								$this->PaymentFail->deleteAll(array('PaymentFail.payment_id'=>$paymenthistoty['payment_id'],'PaymentFail.date_added >='=>$lastday));
								}							
								$Paymentcheck=$this->PaymentHistory->find('count',array('conditions'=>array('payment_id'=>$paymenthistoty['payment_id'],'txn_type'=>$paymenthistoty['txn_type'])));
								if($Paymentcheck=='0')
								{		
									@mail($adminemail,$data['txn_type'], "Sign UP suscess and account created<br />details are = <pre>".print_r($_POST, true)."</pre>");			
									$this->PaymentHistory->create();
									$this->PaymentHistory->save($paymenthistoty);														
									$acdata['subscription']=$itemnumber['Subscription']['id'];	
									$acdata['plan_taken_date']=date("Y-m-d");
							if(isset($_POST['mc_amount1']))
							{
								$acdata['plan_due_date']=date("Y-m-d");  //1 Day Trail Period
							}
							else
							{
							if($itemnumber['Subscription']['subscription_type']=='1') //Monthly
							$acdata['plan_due_date']=date('Y-m-d',mktime(0,0,0,date('m',strtotime($date))+1,date('d',strtotime($date)),date('Y',strtotime($date))));
							else if($itemnumber['Subscription']['subscription_type']=='2') //Yearly
							$acdata['plan_due_date']=date('Y-m-d',mktime(0,0,0,date('m',strtotime($date)),date('d',strtotime($date)),date('Y',strtotime($date))+1));
							else
								$acdata['plan_due_date']='0000-00-00';  //Life time	
							}
								if(intval($payments['Payment']['account_id'])>=1)
									$Users->upadteSubscriptionAccount($acdata['email'],$acdata['usertype'],$acdata['plan_due_date']);		//Renew account									
								else
									$Users->createSubscriptionAccount($acdata); // creating account.	
								}
							}
							else if($data['txn_type']=='subscr_eot') // End of subscr
							{
								@mail($adminemail,$data['txn_type'], "Subscription End.<br />details are = <pre>".print_r($_POST, true)."</pre>");
								$Paymentcheck=$this->PaymentHistory->find('count',array('conditions'=>array('payment_id'=>$paymenthistoty['payment_id'],'txn_type'=>$paymenthistoty['txn_type'],'txn_id'=>$paymenthistoty['txn_id'])));
								if($Paymentcheck=='0')
								{
								$this->PaymentHistory->create();
								$this->PaymentHistory->save($paymenthistoty);	
								$acdata['plan_due_date']=date("Y-m-d");
								$Users->upadteSubscriptionAccount($acdata['email'],$acdata['usertype'],$acdata['plan_due_date']);
								}
							}
							else if($data['txn_type']=='subscr_cancel') // Cancel Plan
							{
								@mail($adminemail,'Subscription Cancel',$acdata['name']."(".$acdata['email'].")"." is cancel his subscription. details are = <pre>".print_r($payments['Payment'], true)."</pre>");
							}
							else if($data['txn_type']=='subscr_payment') // repayment Plan
							{
								if($paymenthistoty['payment_status']=='Completed')
								{
								$lastday=date('Y-m-d',mktime(0,0,0,date('m'),date('d')-15,date('Y')));
								$this->PaymentFail->deleteAll(array('PaymentFail.payment_id'=>$paymenthistoty['payment_id'],'PaymentFail.date_added >='=>$lastday));
								}
								else
								{
									$paymentFail['payment_id']=$paymenthistoty['payment_id'];
									$paymentFail['date_added']=date('Y-m-d');
									$paymentFail['fail_data']=serialize($_POST);
									$this->PaymentFail->create();
									$this->PaymentFail->save($paymentFail);
								}
							if($itemnumber['Subscription']['subscription_type']=='1')
							$acdata['plan_due_date']=date('Y-m-d',mktime(0,0,0,date('m',strtotime($date))+1,date('d',strtotime($date)),date('Y',strtotime($date))));
							else
							$acdata['plan_due_date']=date('Y-m-d',mktime(0,0,0,date('m',strtotime($date)),date('d',strtotime($date)),date('Y',strtotime($date))+1));
							
							$Users->upadteSubscriptionAccount($acdata['email'],$acdata['usertype'],$acdata['plan_due_date']);
							@mail($adminemail,$data['payment_status'], "Payment sucess.<br />details are = <pre>".print_r($_POST, true)."</pre>");	
								$Paymentcheck=$this->PaymentHistory->find('count',array('conditions'=>array('payment_id'=>$paymenthistoty['payment_id'],'payment_status'=>$paymenthistoty['payment_status'],'txn_type'=>$paymenthistoty['txn_type'],'txn_id'=>$paymenthistoty['txn_id'])));
								if($Paymentcheck=='0')
								{	
								$this->PaymentHistory->create();
								$this->PaymentHistory->save($paymenthistoty);							
								}								
							}
							else if($data['txn_type']=='refund') // refund
							{
								@mail($adminemail,$data['txn_type'], "Refunded.<br />details are = <pre>".print_r($_POST, true)."</pre>");
								$Paymentcheck=$this->PaymentHistory->find('count',array('conditions'=>array('payment_id'=>$paymenthistoty['payment_id'],'txn_type'=>$paymenthistoty['txn_type'],'txn_id'=>$paymenthistoty['txn_id'])));
								if($Paymentcheck=='0')
								{
								$this->PaymentHistory->create();
								$this->PaymentHistory->save($paymenthistoty);	
								$acdata['plan_due_date']=date("Y-m-d");
								$Users->upadteSubscriptionAccount($acdata['email'],$acdata['usertype'],$acdata['plan_due_date']);
								}

							}
							else
							{
								 
								//$Paymentcheck=$this->PaymentFail->find('count',array('conditions'=>array('payment_id'=>$paymenthistoty['payment_id'],'payment_status'=>$paymenthistoty['payment_status'],'txn_type'=>$paymenthistoty['txn_type'],'txn_id'=>$paymenthistoty['txn_id'])));
								//if($Paymentcheck=='0')
								//{	
									
									$paymentFail['payment_id']=$paymenthistoty['payment_id'];
									$paymentFail['date_added']=date('Y-m-d');
									$paymentFail['fail_data']=serialize($_POST);
									$this->PaymentFail->create();
									$this->PaymentFail->save($paymentFail);	
								//}
								@mail($adminemail,$data['payment_status'], "Payment failed, Please look this matter.<br />details are = <pre>".print_r($_POST, true)."</pre>");
								//@mail('admin@snagpad.com',$data['payment_status'], "Payment failed, Please look this matter.<br />details are = <pre>".print_r($_POST, true)."</pre>");
								@mail($custom[0],'SnagPad '.$data['payment_status'], "Your SnagPad subscription payment is failed, so your SnagPad account will suspended / closed. Please follow up/update your PayPal account and contact to admin@snagpad.com to continue to SnagPad account.");														
							}				
							
							}
							else{ // Error inserting into DB
						// E-mail admin or alert user
						@mail($adminemail, "Payment Done but not inserted in DB", "<br />details = <pre>".print_r($_POST, true)."</pre>");	}												
						}							
						else{ // Error inserting into DB
						// E-mail admin or alert user
						@mail($adminemail, "Wrong data return from paypal", "<br />details = <pre>".print_r($_POST, true)."</pre>");			
				
				}
			
			}else if (strcmp ($res, "INVALID") == 0) {			
				// PAYMENT INVALID & INVESTIGATE MANUALY! 
				// E-mail admin or alert user
				
				@mail($adminemail, "PAYMENT INVALID", "Invalid Response<br />data = <pre>".print_r($_POST, true)."</pre>");
			}		
		}		
	fclose ($fp);
	}	
	}
	}
	public function cancel(){
		$this->layout = 'cms_page';	
		$suc_msg='Your transection has been cancel.';
		$this->set('title','Cancel');
		$this->set('suc_msg',$suc_msg);
		 $this->render('success');
	}
	public function trailAccount(){
		//Configure::write('debug',2);
		$this->layout = 'cms_page';	
		$this->loadModel('Subscription');
		$Users = new UsersController;	
    	$Users->constructClasses();
		$acdata=$this->data;
		$acdata['name']=$this->data['first_name'].' '.$this->data['last_name'];			
		$acdata['plan_taken_date']=date("Y-m-d");
		$acdata['plan_due_date']=date("Y-m-d");	
		$itemnumber=$this->Subscription->findByItemNumber($this->data['item_number']);	
		$acdata['subscription']=$itemnumber['Subscription']['id'];
		//print_r($acdata);		
		$Users->createSubscriptionAccount($acdata);		
		$suc_msg='Your Trial account has been successfully created and your account details have been sent to your email address.';
		$this->set('suc_msg',$suc_msg);
		$this->set('title','Success');
		$this->render('success');	
	}
	public function success(){		
		$this->layout = 'cms_page';			
		$suc_msg='Your transaction has been successfully completed and your account details have been sent to your email address.';
		$this->set('suc_msg',$suc_msg);
		$this->set('title','Success');
		 $this->render('success');	
       // die;	
	}
	public function our_company(){
		$this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('our_company');
        $this->set('content',$content['Content']);
		$this->set('tab','0');
        $this->render('cms_content');		
	}
	public function how_it_works(){
		$this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('how_it_works');
        $this->set('content',$content['Content']);
		$this->set('tab','0');
        $this->render('cms_content');		
	}
	public function what_is_snagpad(){
		$this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('what_is_snagpad');
        $this->set('content',$content['Content']);
		$this->set('tab','0');
        $this->render('cms_content');		
	}
	
	
	public function higher_education(){
		$this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('higher_education');
        $this->set('content',$content['Content']);
        $this->render('cms_content');
		
	}
	
	public function coach_help_page(){
		$this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('coach_help_page');
        $this->set('content',$content['Content']);
        $this->render('cms_content');
		
	}
	
	public function agency_help_page(){
		$this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('agency_help_page');
        $this->set('content',$content['Content']);
        $this->render('cms_content');
		
	}
	
	public function job_search_professional(){
		$this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('job_search_professional');
        $this->set('content',$content['Content']);
        $this->render('cms_content');	
	}

    public function contact_us() {
        $this->layout = 'cms_page';
        $this->render('contact_us');
    }

    public function contact_us_submit() {
		//echo '<pre>';print_r($this->data);die;
        //$ms = 'A new contact us form submitted on site';
        $ms="<table><tr><td>";
        $ms.="First Name : " . $this->data['firstname'];
		$ms.="</td></tr><tr><td>";		   
		$ms.="\n Last Name : " . $this->data['lastname'];
		$ms.="</td></tr><tr><td>";
		$ms.="\n Title : " . $this->data['title'];
		$ms.="</td></tr><tr><td>";
        $ms.="\n Email : " . $this->data['email'];
		$ms.="</td></tr><tr><td>";
        $ms.="\n Business Phone : " . $this->data['phone'];
		$ms.="</td></tr><tr><td>";
		$ms.="\n Organization Name : " . $this->data['organization'];
		$ms.="</td></tr><tr><td>";
        $ms.="\n Comment : ". $this->data['message'];
		$ms.="</td></tr></table>";

       // $ms = wordwrap($ms, 70);
        //send mail
        $email = new CakeEmail();
        $email->emailFormat('html')
                ->from($this->data['email'])
                ->to('support@snagpad.com')
                ->subject('A new contact us form submitted on site')
                ->send($ms);

        die;
    }

	public function cookbook()
	{
		$this->layout = 'cms_page';
		$this->set('popTitle','cookbook');
		$this->set('Title','Get Your "Job Search CookBook"');
		$this->set('cookbook',1);
		$this->render('demo');
	}
	public function showmenow()
	{
		$this->layout = 'cms_page';
		$this->set('popTitle','SHOW ME SNAGPAD');
		$this->render('demo');
	}
	public function demo()
	{
		if($this->request->is('ajax'))
		{
			$this->layout='popup';
			$this->set('isajax',1);
		}
		else
			 $this->layout = 'cms_page';
		$this->set('popTitle','SHOW ME SNAGPAD');
	}
	 public function demo_submit() {
		$msext='';
		if(isset($this->data['cookbookrequest']))
		{
			$subject='Request for SnagPad Cookbook';
			$msext.="\n Send me the Job Search Cookbook : " ;
			if(isset($this->data['cookbook']))$msext.='Yes ' ;
			else $msext.='No';
		}
		else
		{
			$subject='Request for SnagPad Demonstration';
			$msext.="\n I would like a demo of snagpad : " ;
			if(isset($this->data['demo']))$msext.='Yes ' ;
			else $msext.='No';
		}
		$ms="<table><tr><td>";
        $ms.="First Name : " . $this->data['firstname'];
		$ms.="</td></tr><tr><td>";		   
		$ms.="\n Last Name : " . $this->data['lastname'];
		$ms.="</td></tr><tr><td>";
		$ms.="\n Title : " . $this->data['title'];
		$ms.="</td></tr><tr><td>";
        $ms.="\n Email : " . $this->data['email'];
		$ms.="</td></tr><tr><td>";
        $ms.="\n Business Phone : " . $this->data['phone'];
		$ms.="</td></tr><tr><td>";
		$ms.="\n Organization Name : " . $this->data['organization'];
		$ms.="</td></tr><tr><td>";		
		$ms.=$msext;			
		$ms.="</td></tr><tr><td>";
		$ms.="\n Have someone contact me : " ;
		if(isset($this->data['contact_me']))$ms.='Yes ' ;
		else $ms.='No';
		$ms.="</td></tr><tr><td>";
		$ms.="\n Comments : ".$this->data['demoforyou'] ;		
		//$ms.="</td></tr><tr><td>";
		//$ms.="\n I would like a job seeker account: : " ;
		//if(isset($this->data['jobseeker']))$ms.='Yes ' ;
		//else $ms.='No';
		$ms.="</td></tr></table>";
		//print_r($ms);die;

       //if(!empty($this->data['email'])&&(Validation::email($this->data['email'], true)))
		//{
        $email = new CakeEmail();
        $email->emailFormat('html')
                ->from($this->data['email'])
               	->to('support@snagpad.com')
				//->cc('mahabir.prasad@i-webservices.com')
				//->bcc('gautam.kumar@i-webservices.com')										
                ->subject($subject)
                ->send($ms);
		//}
		//else
			//echo "error";
        die;
    }
	public function sample()
	{
		if($this->request->is('ajax'))
		{
			$this->layout='popup';
			$this->set('isajax',1);
		}
		else
			 $this->layout = 'cms_page';
		$this->set('popTitle','Sample SnagPad Screen Shots');
	}
    public function faq() {
        $this->layout = 'cms_page';
        $content=$this->Content->findByPageUrl('faq');
        $this->set('content',$content['Content']);
        $this->render('cms_content');
    }

   public function addtoservices() {
        $this->layout = 'cms_page';
       // $content=$this->Content->findByPageUrl('addtoservices');
        //$this->set('content',$content['Content']);
       // $this->render('cms_content');
       
        $this->render('addtoservices');
    }

	public function addtovalidatexml()
	{
		$this->layout = 'ajax';
		//http://www.fairylakejobs.net/php/job.php?template=xmldata.ect&id=2799892
//"http://www.fairylakejobs.net/php/job.php?template=xmldata.ect&id=".$job_id.""

if($this->data['type']==0)
{
$xmlurl=$this->data['xmlurl'];
$shortxmlurl=explode("&id=",$xmlurl);
//print_r($shortxmlurl);
	$ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $xmlurl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
   $data = curl_exec($ch);
$xml =  "<job>".$data."</job>";
   
//print_r($xml);

  $news_items = element_set('job', $xml);
// echo element_attributes('Job posting url',$xml); 
 foreach($news_items as $item) {		

  $company_name = value_in('Company Name', $item,false);
  $position_title = value_in('Position title', $item,false);    
  $job_posting_url = value_in('Job posting url', $item,false); 
  if($company_name  && $position_title && $job_posting_url)
  {
	  $app_arr=$this->Content->query("select application_id from jsb_xml_client where xml_url='".$shortxmlurl['0']."'");
	 if(count($app_arr)>0)
	  $app_id=$app_arr[0]['jsb_xml_client']['application_id'];
	  if(!isset($app_id))
	  {
	  	$app_id=time();
		$insertXmlClient = "insert into jsb_xml_client (application_id,xml_url) values ('".$app_id."','".$shortxmlurl['0']."')";
		$this->Content->query($insertXmlClient);
	  }
	  echo $app_id;	 
	 // echo $success;
  }
 	
  else
  	echo 0;
 }
}
else if($this->data['type']==1)
{
	$app_id=$this->data['application_id'];
	$btntext=$this->data['buttontext'];
	$afterbtntext=$this->data['afterbuttontext'];
	$bg_color=$this->data['background_color'];
	$color=$this->data['color'];
	$over_color=$this->data['overcolor'];
	$help_text=$this->data['help_text'];
	$updateXmlClient = "update jsb_xml_client set button_text='".$btntext."', afterbutton_text='".$afterbtntext."', background_color='".$bg_color."', color='".$color."', over_color='".$over_color."', help_text='".$help_text."' where application_id =".$app_id;
	$this->Content->query($updateXmlClient);
		
	$success='Include this
<script type="text/javascript" src="'.SITE_URL.'/js/jsb_addtodashboard.js"></script>
And use this function
<script type="text/javascript">addtosnagpaddashboard("id","App_id");</script>
Where your App_id is ( '.$app_id.' ) and id is your job id.';
echo $success;
}
	
die;
		
	}
    public function addtodashboard()
	{
		$this->layout = 'ajax';
		//echo "11";
		$job_id=$this->data['jobid'];
		$app_id=$this->data['applicationid'];
		$this->set('job_id',$job_id);
		$this->set('app_id',$app_id);
		$appdetail=$this->Content->query("select * from jsb_xml_client where application_id=".$app_id." ");
		//print_r($appdetail);
		$this->set("appdetail",$appdetail[0]['jsb_xml_client']);
		$other_web_job_id=$job_id."|".$app_id;
		$total=$this->Card->find('count',array('conditions'=>array('Card.other_web_job_id'=>$other_web_job_id,'Card.recycle_bin'=>'0')));	
		//print_r($total);
		 $this->set("count", $total);
		if( $this->Session->check('Account.id') && $this->Session->read('clientid') && $this->Session->read('usertype')=='3')
		{
			$isAlready=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$this->Session->read('clientid'),'Card.other_web_job_id'=>$other_web_job_id,'Card.recycle_bin'=>'0','Card.expired'=>'0')));		
		 $this->set("isAlready", $isAlready);
		}
		else
		{
			$this->set("isAlready",'0'); 
		}
		$this->render('addtodashboard');
	}
	
	public function jobpostinglogin()
	{
		$this->layout = 'addtodashboard';
		$this->data=$this->request->query;
		$this->set("jobid",$this->data['jobid']);
		$this->set("app_id",$this->data['app_id']);
		$appdetail=$this->Content->query("select * from jsb_xml_client where application_id=".$this->data['app_id']." ");
		
		$this->set("appdetail",$appdetail[0]['jsb_xml_client']);
$other_web_job_id=$this->data['jobid']."|".$this->data['app_id'];
	}
	public function addjobposting()
	{
		$this->layout = 'ajax';
		$job_id=$this->data['jobid'];
		$app_id=$this->data['app_id'];
		$other_web_job_id=$job_id."|".$app_id;
		$clientid=$this->Session->read('clientid');
		$appdetail=$this->Content->query("select xml_url from jsb_xml_client where application_id=".$app_id." ");		
		$xml_url=$appdetail[0]['jsb_xml_client']['xml_url'];
		$ch = curl_init();
  		$timeout = 5;
  		curl_setopt($ch, CURLOPT_URL, $xml_url."&id=".$job_id);
  		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
   		$data = curl_exec($ch);
		$xml =  "<job>".$data."</job>";
  		$news_items = element_set('job', $xml);
		$typeofopportunity=explode('//',$xml_url);
		if(count($typeofopportunity)>1)
			$typeofopportunity=explode('/',$typeofopportunity[1]);
 foreach($news_items as $item) {	
	$loop1 = "job";
   $data = array(
   			'type_of_opportunity'=>$typeofopportunity[0],
            'company_name' => value_in('Company Name', $item),
            'position_available' =>value_in('Position title', $item),
            'country' => value_in('Country', $item),
			'province' => value_in('Province', $item),
			'city' =>value_in('City', $item),
			'location'=>value_in('location',$item),
			'salary'=>value_in('salary',$item),
            'job_url' =>value_in('Job posting url', $item),
			'position_info'=>strip_tags(str_replace(array('<![CDATA[',']]>','<br>'),array('','','\n'),value_in('position_info',$item))),
			'other_web_job_id'=>$other_web_job_id,
			'client_id'=>$clientid,
			'total_points'=>'2.0',			
			'reg_date'=>date("Y-m-d H:i:s")
			
			);
		$isAlready=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.other_web_job_id'=>$other_web_job_id,'Card.recycle_bin'=>'0','Card.expired'=>'0')));			
		if($isAlready==0)
		{
		$this->Card->create();
		$card=$this->Card->save($data);
		$card_detail=array('card_id'=>$card['Card']['id'],'start_date'=>date('Y-m-d H:i:s'));
		
		$this->Carddetail->create();
		$this->Carddetail->save($card_detail);
		
		$card_column=array('card_id'=>$card['Card']['id']);
		$this->Cardcolumn->create();
		$this->Cardcolumn->save($card_column);		
		}
 }
 echo $total=$this->Card->find('count',array('conditions'=>array('Card.other_web_job_id'=>$other_web_job_id,'Card.recycle_bin'=>'0')));		
		die;
	}
	
    public function admin_index(){
		 if (!$this->Session->check('Account.id') || $this->Session->read('usertype')!=0) {
            $this->redirect(SITE_URL.'/admin');
            exit();
        }
        $this->layout="jsb_admin";
        
    }
     public function show_search() {
        $this->layout = 'ajax';
        $this->render('search');
    }

    public function search() {
        $this->layout = 'ajax';
        if (count($this->request->data) == 0)
            $this->request->data = $this->passedArgs;
        $conditions=array();
          if (isset($this->data['keyword']) && trim($this->data['keyword']) != '')
            $conditions['Content.title like '] = "%" . $this->data['keyword'] . "%";
          
      
         $this->paginate = array(
            'conditions' => $conditions,
            'limit' => 10,
            'order' => array(
                'date_modified' => 'desc'
            )
        );
       
        $rows = $this->paginate('Content');
        $this->set("rows", $rows);
        $this->render('results');
    }
    
    public function show_add(){
        $this->layout = 'ajax';
        $id = $this->data['id'];
        if ($id != 0) {
            $row = $this->Content->findById($id);
            
            $this->set('content', $row['Content']);
        }
        
    }
    public function admin_upload_pdf(){
		
		$this->layout='ajax';
		  if (!empty($this->data['TR_file']['tmp_name'])) {
            $fileUpload = WWW_ROOT . 'ebook' . DS;
            $arr_img = explode(".", $this->data["TR_file"]["name"]);
            $ext = strtolower($arr_img[count($arr_img) - 1]);
            if ($this->data["TR_file"]['error'] == 0 && in_array($ext,array('pdf'))){
				
                 $file = removeSpecialChar(str_replace(" ", "_",$this->data['TR_file']['name']));
               // $file = time "_" . $fname;
			   @unlink($fileUpload . $file);
                if (upload_my_file($this->data['TR_file']['tmp_name'], $fileUpload . $file)) {
					//$save_path="thumb_".$file;
					
					//create_thumb($fileUpload . $file, 150, $fileUpload.$save_path);
					echo "success|".$file;
				}
				else echo "error|Try another time";
			}
				else echo "error|Please select pdf file type";
			}
			else
				echo "error|file can't be transfer, Try another time";
			die;
	}
    public function save_content(){
        $this->autorender = false;
        $this->request->data['date_modified']=date('Y-m-d H:i:s');
        $conditions['Content.page_url']=$this->data['page_url'];
        if($this->data['id']!='')
            $conditions['Content.id !=']=$this->data['id'];
         $count=$this->Content->find('count',array('conditions'=>$conditions));
        if($count!=0)
                echo "URL already exists";
        else{
                if($this->data['id']!='')
                    $this->Content->create();
                else
                    $this->Content->id=$this->data['id'];
                $this->Content->save($this->data);
                
            }
            die;
        }
		
		public function network_contact_reply()
	{
		$this->layout='cms_page';
		$to_acc_id=$this->passedArgs['a'];
		$msg=$this->passedArgs['m'];
		$from_user=$this->passedArgs['f'];
		$card_id=$this->passedArgs['c'];
		$req_id=$this->passedArgs['r'];
		$to_user=$this->Account->find('first',array('conditions'=>array('Account.id'=>$to_acc_id),'fields'=>array('Account.name','Account.id')));
		$cards=$this->Card->find('first',array('conditions'=>array('Card.id'=>$card_id),'fields'=>array('Card.company_name')));
		//$this->set('from_id',$from_id);
		$this->set('to_user',$to_user);
		$this->set('from_user',$from_user);
		$this->set('msg',$msg);
		$this->set('req_id',$req_id);
		$this->set('company',$cards['Card']['company_name']);
		$this->set('card_id',$card_id);
		$this->render('network_contact_reply');
							
	}
	
	public function network_contact_reply_submit()
	{
		//echo '<pre>';print_r($this->data);die;
		
		$msg=$this->data['msg'];
		$req_id=$this->data['req_id'];
		$to_user_id=$this->data['to_user_id'];
		$url =SITE_URL."/Pages/display?file=Jobcards&action=index&card_id=cardShow_".$this->data['card_id'];
		$text_msg_data=$this->data['text_msg'].'<br><br>'.
							'Company Name: '.$this->data['company_name'].'<br>';
							if($msg==1||$msg==4||$msg==5){ $text_msg_data.='Contact Name : '.$this->data['contact_name'].'<br>'; }	
							if($msg==1||$msg==4||$msg==5){ $text_msg_data.='Contact Email : '.$this->data['contact_email'].'<br>'.'Contact Phone : '.$this->data['phone'].'<br>'; }	
							if($msg==2){ $text_msg_data.='Contact Website : '.$this->data['company_website'].'<br>'; } 
							if($msg==1||$msg==2){ $text_msg_data.="Comment : ";}
							if($msg==3){ $text_msg_data.='Tip : ';}
							if($msg==1||$msg==2||$msg==3){ $text_msg_data.=nl2br($this->data['message']); }
		
		if($msg==1||$msg==4||$msg==5){ $text_msg_data.='<br><a href="'.$url.'">View Card</a>';}
		
		$net_user=$this->Contactrequest->findById($req_id);
		$acc_user=$this->Account->findById($to_user_id);
		
		$contactdata['contact_name']=$this->data['contact_name'];
		$contactdata['email']=trim($this->data['contact_email']);
		$contactdata['phone']=trim($this->data['phone']);
		$contactdata['account_id']=$acc_user['Account']['id'];
		$contactdata['date_added']=date('Y-m-d H:i:s');
		if($contactdata['email']!='' || $contactdata['phone']!='' ){
		if($contactdata['email']!='')
			$contects=$this->Contact->find('first',array('conditions'=>array('email'=>$contactdata['email']),'fields'=>array('Contact.id')));
		if(empty($contects))		
			$contects=$this->Contact->save($contactdata);
		
		$cardcontact['card_id']=$this->data['card_id'];
		$cardcontact['contact_id']=$contects['Contact']['id'];
		$cardcontectcount=$this->Cardcontact->find('count',array('conditions'=>array('contact_id'=>$contects['Contact']['id'],'card_id'=>$this->data['card_id']),'fields'=>array('Contact.id')));	
		if($cardcontectcount==0)
			$this->Cardcontact->save($cardcontact);
		}
		$subject='SnagPad: Reply from SnagCast Contact';
		if(!empty($acc_user['Account']['email'])&&(Validation::email($acc_user['Account']['email'], true)))
		{
			$cakemail = new CakeEmail();
			$cakemail->template('default');
			$cakemail->emailFormat('html')->from($net_user['Contactrequest']['to_email'])
										  ->to($acc_user['Account']['email'])
										  ->subject($subject)
										  ->send($text_msg_data);						
		}
		die;
		
	}
	/*public function view_agency(){
					$this->layout = 'cms_page';
		$this->set('its_agency','1');	
		$title=$this->params['slug'];
		$agency=$this->Agency->findByTitle($title);
		if(is_array($agency))
			$this->set('agency',$agency['Agency']);
		else
			$this->set('agency',$agency['Agency']);
			$this->render('view_agency');
	}*/
	public function view_agency(){
		$this->layout = 'cms_page';
		$this->set('its_agency','1');	
		$title=$this->params['slug'];
		if($title=='cacee')
		{
			$this->cacee();					
		}
		else if($title=='nawdp')
		{
			$this->nawdp();					
		}
		else 
		{
		$this->set('cms_agency','1');
		$agency=$this->Agency->findByTitle($title);
		if(is_array($agency))
			$this->set('agency',$agency['Agency']);	
		$this->render('view_agency');        
		}
	}
	public function cacee()
	{
		$this->layout = 'cms_page';
		$content=$this->Content->findByPageUrl('cacee');
       	$this->set('content',$content['Content']);		
        $this->render('cms_content');	
	}
	public function nawdp()
	{
		$this->layout = 'cms_page';
		$content=$this->Content->findByPageUrl('nawdp');
       	$this->set('content',$content['Content']);		
        $this->render('cms_content');	
	}
	
	public function job_summary($onet_code)
	{
		$this->layout='cms_page';
		//$onet_code='11-1011.00';
		$sql="select C.element_name,C.description from jsb_content_model_reference C inner join work_values V ON (V.element_id=C.element_id) where V.onetsoc_code like '".$onet_code."%'";	
		$work_values=$this->Onetmodel->query($sql);
		$this->set('work_values',$work_values);
		$sql="select C.element_name,C.description from jsb_content_model_reference C inner join work_styles V ON (V.element_id=C.element_id) where V.onetsoc_code like '".$onet_code."%'";		
		$work_styles=$this->Onetmodel->query($sql);
		$this->set('work_styles',$work_styles);
	
		$sql="select distinct Skillslist.id,Skillslist.skill,Skillslist.description,Skillslist.type,Skillslist.element_id,J.onetsoc_code,J.not_relevant from jsb_job_skills J inner join jsb_skillslist Skillslist ON (Skillslist.element_id=J.element_id) where J.onetsoc_code='".$onet_code."' and J.data_value>='2.80' and J.not_relevant!='Y' order by Skillslist.skill";
		$skills=$this->Skillslist->query($sql);
		$this->set('skills',$skills);
		$task=$this->Jobtask->query("select task from jsb_task_statements as Task where onetsoc_code='$onet_code' and task_type='core'");
		$this->set('task',$task);
		$job=$this->Jobfamily->find('first',array('conditions'=>array('Jobfamily.onetsoc_code'=>$onet_code)));
		$this->set('job',$job);
		$this->render('job_summary');
		//echo '<pre>';print_r($work_styles);die;
			
	}
	

}