<?php
App::import('Vendor', array('functions','GmailOath','reader','excel-lib/Classes/PHPExcel'));
App::import('Controller', array('Mail','Home','Promocode'));
class UsersController extends AppController {

	public $name = 'Users';
	public $helpers = array('Form', 'Html','Js' => array('Jquery'));
	public $paginate = array('limit' => 20);	
	public $components=array('Session','Access');
	public $uses=array('User','UserRole','Points','Order','GroupGift','Userlog','UserPromo','Promocode','BrandProduct','GiftBrand');
	public $Google_API_CONFIG = array('appKey' => Google_KEY, 'appSecret' => Google_SECRET, 'callbackUrl' => 'https://www.mygyftr.com/users/gmail_connect','email_count'=>'500');
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Access->isValidUser();
		
	}

	function admin_index() {
		
		$this->set('users', $this->paginate());			
	}
		
	function admin_view($id = null) {
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true),'default',array('class'=>'error'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	
	}
	
	
	function admin_add() {
		
		$this->set('userRoles',$this->UserRole->findAllUserRoles());
		
		if (!empty($this->request->data)) {
			$this->User->create();
			$this->request->data['User']['user_added_date']=DboSource::expression('now()');
			$this->request->data['User']['password']=md5($this->request->data['User']['password']);
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved',true),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.',true),'default',array('class'=>'error'));
			}
	      
		}
	}

	function admin_edit($id = null) {
		
		$this->set('userRoles',$this->UserRole->findAllUserRoles());
		
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			
			$this->request->data['User']['user_modified_date']=DboSource::expression('now()');
			
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved',true),'default',array('class'=>'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.',true),'default',array('class'=>'error'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->User->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true),'default',array('class'=>'success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true),'default',array('class'=>'error'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function register_user($rg_val=0)
	{
		$username=$this->data['email'];
		$user_exist=$this->User->findByEmail($username);
		if(isset($this->data['rg_val']))
		{
			
			$this->request->data['password']=md5($this->data['password']);
			
			$this->User->id=$user_exist['User']['id'];
			$this->User->save($this->data);	
			$thisuser=$this->User->findById($user_exist['User']['id']);
			$this->Session->write('User',$thisuser);
			echo $this->data['rg_val'];die;
		}else if(isset($this->data['forget_pass'])){
			$this->request->data['password']=md5($this->data['password']);
			
			$this->User->id=$user_exist['User']['id'];
			$this->User->save($this->data);	
			$thisuser=$this->User->findById($user_exist['User']['id']);
			$this->Session->write('User',$thisuser);
			echo 'success';die;
			
		}else if(isset($this->data['fb_login'])){
			$this->request->data['password']=md5($this->data['password']);
			
			$this->User->id=$user_exist['User']['id'];
			$this->User->save($this->data);	
			$thisuser=$this->User->findById($user_exist['User']['id']);
			$this->Session->write('User',$thisuser);
			echo 'success';die;
			
		}else{
			if(empty($user_exist))
			{
				$pass=md5($this->data['password']);
				$points=$this->Points->findById('1');
				
				$data=array('first_name'=>$this->data['first_name'],'last_name'=>$this->data['last_name'],'dob'=>$this->data['dob'],'phone'=>$this->data['phone'],'email'=>$this->data['email'],'password'=>$pass,'user_added_date'=>date("Y-m-d H:i:s"),'points'=>$points['Points']['points'],'gender'=>$this->data['gender']);
				$this->User->create();
				$temp=$this->User->save($data);
				$this->Session->write('User',$temp);
				$PromoCode = new PromocodeController;
				$PromoCode->constructClasses();
				$PromoCode->give_promocode('0',$temp['User']['id'],'3');
				
				///////////////User Registration Mail//////////////////
					
				$promo_discount=$this->Promocode->find('first',array('conditions'=>array('Promocode.promo_type'=>'7'),'fields'=>array('Promocode.discount_type','Promocode.value')));
				$promo_code=$this->UserPromo->find('first',array('conditions'=>array('UserPromo.user_id'=>$temp['User']['id'])));
				$Mail = new MailController;
				$Mail->constructClasses();
				if($promo_discount['Promocode']['discount_type']=='PureValue')
					$discount='Rs. '.$promo_discount['Promocode']['value'];
				else
					$discount=$promo_discount['Promocode']['value'].'%';
					
				$hours=round(((strtotime($promo_code['UserPromo']['valid_upto'])-strtotime(date("Y-m-d H:i:s")))/3600),0);		
				$arr = array();
				$arr['TO_NAME'] = $temp['User']['first_name'].' '.$temp['User']['last_name'];
				$arr['TO_EMAIL'] = $temp['User']['email'];
				$arr['PROMO_CODE'] = $promo_code['UserPromo']['promo_code'];
				$arr['DISCOUNT'] = $discount;
				$arr['USERNAME'] = $temp['User']['email'];
				$arr['HOURS'] = $hours.' ';
				$arr['PASSWORD'] = $this->data['password'];
				$arr['REDEEM'] = '<a href="'.SITE_URL.'">Click here </a>';
				$arr['POINTS'] = $points['Points']['points'];				
				$Mail->sendMail($temp['User']['id'], 'user_registration', $arr);
				if(!empty($temp['User']['phone']))
				{
					$arr['TO_PHONE']=$temp['User']['phone'];
					$Mail->sendSMS($temp['User']['id'], 'user_registration_sms', $arr);	
				}	
				//////////////////////////////////////////////////////
				
				echo 'success';die;		
			}else{
				echo 'user_exist';die;	
			}
		}
	}
	
	
	
	public function login_user()
	{		
		$data=$this->data;
		$user_exist=$this->User->find('first',array('conditions'=>array('User.email'=>$data['email'])));
		if($data['fb_login']=='1')
		{
			$user_fb_exist=$this->User->find('first',array('conditions'=>array('User.fb_email'=>$data['email'])));
			if(!empty($user_exist))
			{
				if($user_exist['User']['user_status']=='Active')
				{
					$this->User->query("update gyftr_users set fb_email='".$data['email']."',fb_id='".$data['user_fb_id']."' where id='".$user_exist['User']['id']."'");
					$this->Session->write('User',$user_exist);
					$this->createUserLog($this->Session->read('User.User.id'));	
					echo 'success';die;
				}else
					echo 'inactive';die; 
			}else if(!empty($user_fb_exist)){
				if($user_exist['User']['user_status']=='Active')
				{
					$this->Session->write('User',$user_fb_exist);
					$this->createUserLog($this->Session->read('User.User.id'));	
					echo 'success';die;
				}else
					echo 'inactive';die; 												
			}else{
				$points=$this->Points->findById('1');
				$new_user=array('first_name'=>$data['user_first_name'],'last_name'=>$data['user_last_name'],'fb_id'=>$data['user_fb_id'],'fb_email'=>$data['email'],'email'=>$this->data['email'],'password'=>md5('password'),'user_added_date'=>date("Y-m-d H:i:s"),'points'=>$points['Points']['points']);	
				$this->User->create();
				$new_details=$this->User->save($new_user);
				$this->Session->write('User',$new_details);
				$this->createUserLog($this->Session->read('User.User.id'));	
				echo 'success';die;
				
			}
		}else{
			if(!empty($user_exist))
			{
				if($user_exist['User']['password']==md5($data['password']))
				{
					if($user_exist['User']['user_status']=='Active')
					{
						$this->Session->write('User',$user_exist);
						$this->createUserLog($this->Session->read('User.User.id'));	
						echo 'success';die;	
					}else
					echo 'inactive';die; 
				}else{
					echo 'password_error';die;
					}
				
			}else{
				echo 'error';die;
			}
			
		}
		
	}
	
	public function createUserLog($userid)
	{
		$data=array();
		$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data['user_id'] = $userid;
        $data['login_time'] = date('Y-m-d H:i:s');
        $this->Userlog->create();
        $this->Userlog->save($data);	
	}
	
	
	public function get_profile($num=0)
	{
		$this->Access->checkUserSession();
		$this->layout='ajax';
		$this->User->recursive=2;
		
		$this->UserPromo->bindModel(array('belongsTo' => array('Promocode' => array('className' => 'Promocode','foreignKey' => 'promo_id'),'Order'=>array('className' => 'Order','foreignKey' => 'order_id','conditions'=>array('Order.status'=>'2','Order.payment_status'=>'0'),'fields'=>array('Order.id','Order.to_name','Order.delivery_time','Order.occasion')))),false);
		$this->User->bindModel(array('hasMany' => array('UserPromo' => array('className' => 'UserPromo','foreignKey' => 'user_id','conditions'=>array('UserPromo.status'=>'Not Used','UserPromo.valid_upto >'=>date("Y-m-d H:i:s"))))),false);
		$user=$this->User->findById($this->Session->read('User.User.id'));
		
		$this->set('user',$user);	
		if($num==1)
		{
			$this->render('show_user_profile');
		}else{
			$this->render('profile');
		}	
	}
	
		
	public function get_edit_profile()
	{
		$this->layout='ajax';
		$user=$this->User->findById($this->Session->read('User.User.id'));
		$this->set('user',$user);
		$this->render('edit_profile');	
	}
	
	public function logout()
	{
		 $date = date('Y-m-d H:i:s');
        $this->Userlog->query("update gyftr_user_log set logout_time='$date' where user_id='" . $this->Session->read('User.User.id') . "' and logout_time='0000-00-00 00:00:00'");
		$this->Session->delete('Gifting');
		$this->Session->delete('User');	
		die;
	}
	
	public function saveProfile()
	{
		$this->layout='ajax';
		if(!empty($this->data))
		{
			$data=$this->data;
			if(!empty($this->data['passwd']))
			{
				$data['password']=md5($data['passwd']);	
			}
		}
		$this->User->id=$this->Session->read('User.User.id');
		$this->User->save($data);
	$user=$this->User->findById($this->Session->read('User.User.id'));
		$this->Session->write('User',$user);
		die;
			
	}
	
	public function createUser($data)
	{
		
		if(isset($data->id))
		{
			$exist=$this->User->find('first',array('conditions'=>array('OR'=>array('User.fb_id'=>$data->id,'User.email'=>$data->email,'User.fb_email'=>$data->email))));			
			if(!empty($exist))
			{	
				if(isset($data->import))
				{
					return '000';	
				}else{
					$this->Session->write('is_registered_user','1');
					$this->Session->write('User',$exist);
					if(empty($exist['User']['fb_id']))
					{
						$this->User->id=$exist['User']['id'];
						$this->User->saveField('fb_id',$data->id);	
						$this->Session->write('User.fb_id',$data->id);
					}
					return $exist['User']['id'];
				}
			}else{
				$id=$this->createNewUser($data);
				if(isset($data->import))
					return '001';
				else	
					return $id;	
			}
		}else if(!empty($data['email']))
		{
			$exist=$this->User->find('first',array('conditions'=>array('User.email'=>$data['email'])));
			if(!empty($exist))
			{	
				$this->Session->write('is_registered_user','1');
				$this->Session->write('User',$exist);
				return $exist['User']['id'];
			}else{
				$id=$this->createNewUser($data);
				return $id;	
			}	
		}		
		
	}
	
	public function createNewUser($data)
	{		
		
		$points=$this->Points->findById('1');
		$uid=String::uuid();
		$status='Active';
		if(isset($data->email))
		{
			if(isset($data->userstatus))
				$status=$data->userstatus;
			$user=array('email'=>$data->email,'password'=>md5('password'),'first_name'=>$data->first_name,'last_name'=>$data->last_name,'fb_id'=>$data->id,'user_status'=>$status,'user_added_date'=>date("Y-m-d H:i:s"),'user_code'=>$uid,'user_role_id'=>'2','points'=>$points['Points']['points']);
		}else{
			$user=array('email'=>$data['email'],'password'=>md5('password'),'first_name'=>$data['name'],'user_status'=>$status,'user_added_date'=>date("Y-m-d H:i:s"),'user_code'=>$uid,'user_role_id'=>'2','points'=>$points['Points']['points']);			
		}
		
		$this->User->create();
		$info=$this->User->save($user);
		
		$PromoCode = new PromocodeController;
		$PromoCode->constructClasses();
		$PromoCode->give_promocode('0',$info['User']['id'],'3');
		
		///////////////User Registration Mail//////////////////
			
		$promo_discount=$this->Promocode->find('first',array('conditions'=>array('Promocode.promo_type'=>'7'),'fields'=>array('Promocode.discount_type','Promocode.value')));
		$promo_code=$this->UserPromo->find('first',array('conditions'=>array('UserPromo.user_id'=>$info['User']['id'])));
		$Mail = new MailController;
		$Mail->constructClasses();
		if($promo_discount['Promocode']['discount_type']=='PureValue')
			$discount='Rs. '.$promo_discount['Promocode']['value'];
		else
			$discount=$promo_discount['Promocode']['value'].'%';
			
		$hours=round(((strtotime($promo_code['UserPromo']['valid_upto'])-strtotime(date("Y-m-d H:i:s")))/3600),0);		
		$arr = array();
		$arr['TO_NAME'] = $info['User']['first_name'].' '.$info['User']['last_name'];
		$arr['TO_EMAIL'] = $info['User']['email'];
		$arr['PROMO_CODE'] = $promo_code['UserPromo']['promo_code'];
		$arr['DISCOUNT'] = $discount;
		$arr['USERNAME'] = $info['User']['email'];
		$arr['HOURS'] = $hours.' ';
		$arr['PASSWORD'] = $this->data['password'];
		$arr['REDEEM'] = '<a href="'.SITE_URL.'">Click here </a>';
		$arr['POINTS'] = $points['Points']['points'];				
		$Mail->sendMail($info['User']['id'], 'user_registration', $arr);
		if(!empty($info['User']['phone']))
		{
			$arr['TO_PHONE']=$info['User']['phone'];
			$Mail->sendSMS($info['User']['id'], 'user_registration_sms', $arr);	
		}	
		
		
		if(!isset($data->import))	
		{	$this->Session->write('User',$info);
			$this->createUserLog($this->Session->read('User.User.id'));	
		}
		
		return $info['User']['id'];		
	}
	
	public function show_import_user()
	{
		$this->layout='ajax';
		$this->render('import_user');	
	}
	
	public function import() {
        $this->autoRender = false;

        if (!empty($this->data['TR_file']['tmp_name'])) {
            $fileUpload = WWW_ROOT . 'tmp' . DS;
            $arr_img = explode(".", $this->data["TR_file"]["name"]);
            $ext = strtolower($arr_img[count($arr_img) - 1]);
            if ($this->data["TR_file"]['error'] == 0 && $ext == 'xls') {// && ($this->data["TR_file"]['type'] == 'application/vnd.ms-excel' || $this->data["TR_file"]['type'] == 'application/x-msexcel')) {
                $fname = removeSpecialChar($this->data['TR_file']['name']);
                $file = time() . "_" . $fname;
                if (upload_my_file($this->data['TR_file']['tmp_name'], $fileUpload . $file)) {
                    $data = new Spreadsheet_Excel_Reader();
                    $data->setOutputEncoding('utf-8');
                    $data->read($fileUpload . $file);
                    $notdone = $done=$already=$invalid=0;
                    for ($sheet = 0; $sheet < count($data->sheets); $sheet++) {
                        for ($row = 2; $row <= $data->sheets[$sheet]['numRows']; $row++) {
                            if (isset($data->sheets[$sheet]['cells'][$row][1]) && $data->sheets[$sheet]['cells'][$row][1] != '' && isset($data->sheets[$sheet]['cells'][$row][2]) && $data->sheets[$sheet]['cells'][$row][2] != '') {

                              //  echo '<pre>';print_r($data->sheets[$sheet]['cells'][$row]);die;
							  
								$newuser=new stdClass;
								$newuser->first_name = $data->sheets[$sheet]['cells'][$row][1];
								$newuser->last_name = $data->sheets[$sheet]['cells'][$row][2];					
								$newuser->phone = $data->sheets[$sheet]['cells'][$row][4];
								$newuser->email = $data->sheets[$sheet]['cells'][$row][3];
								$newuser->reminder = $data->sheets[$sheet]['cells'][$row][5];
								$newuser->import = '1';
								$newuser->userstatus = 'Active';
								$newuser->id = '1';
								
								//echo '<pre>';print_r($newuser);die;	
                                $val=$this->createUser($newuser);
								switch($val)
								{
									case '000': $notdone++;break;
									case '001': $done++;break;
								}
                                unset($newuser->first_name);
								unset($newuser->last_name);
								unset($newuser->phone);
							    unset($newuser->email);
								unset($newuser->import);
                            }
                        }// end for loop for row
                    }// end for loop for sheet
                    @unlink($fileUpload . $file);
					$msg="";
					if($notdone>0)
						$msg.="$notdone users already exist. ";
					if($done>0)
						$msg.="$done users are successfully imported. ";	      
                        echo "success|$msg";
                   		die();
                }
            } else {
                echo "error|Invalid File type. Only xls supported.";
                die();
            }
        }
    }
	
	public function admin_report($userid)
	{
		
		$user=$this->User->findById($userid);	
		$orders=$this->Order->find('all',array('conditions'=>array('from_id'=>$userid)));
		$ordquery='';
		if(!empty($orders))
		{
			$ordid='';
			foreach($orders as $ord)
			{
				$ordid.="'".$ord['Order']['group_gift_id']."',";
			}
			
			$ordid=rtrim($ordid, ",");
			$ordquery="and group_gift_id NOT IN (".$ordid.")";
		}
		$ord_type=array('Me To Me','One To One','Group Gift');
		$data=array(); $i=0;
		$total = $this->Order->find('count', array('conditions' => array('Order.from_id' => $userid)));
		foreach($ord_type as $od)
		{ 
				 $data[$i]['name'] = $od;
				$data[$i]['count'] = $this->Order->find('count', array('conditions' => array('Order.from_id' => $userid, 'Order.type' => $od)));
				$data[$i]['value'] = number_format(($data[$i]['count'] / $total) * 100, 2);
				$i++;	
		}
		
		$sql="select * from gyftr_group_gift_users as GPGIFT where other_user_id='".$userid."' ".$ordquery;
		
		$gpuser=$this->GroupGift->query($sql);
		
		$lastlogin=$this->Userlog->find('first',array('conditions'=>array('Userlog.user_id'=>$userid),'order'=>array('Userlog.id DESC'),'limit'=>'1'));
		$this->set('lastlogin',$lastlogin);
		$this->set('data',$data);
		$this->set('total',$total);
		$this->set('gpgift',$gpuser);
		$this->set('user',$user);
		$this->render('user_report');
	}
	
	
	public function admin_export()
	{
		$users=$this->User->find('all');
		$data=array(); $i=1;
			$data[0][0]='S.No.';
			$data[0][1]='First Name';
			$data[0][2]='Last Name';
			$data[0][3]='Email';
			$data[0][4]='Phone';
			$data[0][5]='Points';
			$data[0][6]='Total Gifts';
		foreach($users as $us)
		{
			$data[$i][0]=$i;
			$data[$i][1]=$us['User']['first_name'];
			$data[$i][2]=$us['User']['last_name'];
			$data[$i][3]=$us['User']['email'];
			$data[$i][4]=$us['User']['phone'];
			$data[$i][5]=$us['User']['points'];
			$data[$i][6]=$this->Order->find('count',array('conditions'=>array('Order.from_id'=>$us['User']['id'])));
			$i++;	
		}
		$filename='UserReports.xls';
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
			}
		}
			
		// Rename sheet
		
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
			
	}
	
	
	public function upload_profile_pic()
	{
		$this->layout='ajax';
		        if (!empty($this->data['TR_file']['tmp_name'])) {
					
            $fileUpload = WWW_ROOT . 'files/ProfileImage' . DS .$this->data['user_id'];
			if(!is_dir($fileUpload))
			{
				mkdir($fileUpload,0777);	
			}
            $arr_img = explode(".", $this->data["TR_file"]["name"]);
            $ext = strtolower($arr_img[count($arr_img) - 1]);
			if($this->data["TR_file"]['size']< 2097152)
			{
            if ($this->data["TR_file"]['error'] == 0 && in_array($ext,array('jpg','gif','png','jpeg'))){
                $fname = removeSpecialChar($this->data['TR_file']['name']);
                $file = time() . "_" . $fname;
                if (upload_my_file($this->data['TR_file']['tmp_name'], $fileUpload .'/'. $file)) {
					$save_path="thumb_".$file;
					$min_save_path="mini_thumb_".$file;
					create_thumb($fileUpload .'/'. $file, 150, $fileUpload.'/'.$save_path);
					create_thumb($fileUpload .'/'. $file, 42, $fileUpload.'/'.$min_save_path);
					$this->User->id=$this->data['user_id'];
					$this->User->saveField('thumb',$file);
					echo "success|".$file;
				}
				else echo "error|Try another time";
			}
				else echo "error|Please select jpg,gif,png file type";
			} else echo "error|Max. allowed file size is 2Mb";
			}
			die;	
	}
	
	public function password_change_popup()
	{
		$this->layout='ajax';
		$this->render('password_change_popup');	
	}
	
	public function update_password()
	{
		$this->User->id=$this->data['userid'];
		$this->User->saveField('password',md5($this->data['passwd']));
		die;	
	}
	
	public function gmail_connect()
	{
		die;
	}
	
	public function setup_GmailOath()
	{
			$oauth =new GmailOath($this->Google_API_CONFIG['appKey'], $this->Google_API_CONFIG['appSecret'], 1, 1, $this->Google_API_CONFIG['callbackUrl']);
			$getcontact=new GmailGetContacts();
			$access_token=$getcontact->get_request_token($oauth, false, true, true);
			$_SESSION['oauth_token']=$access_token['oauth_token'];
			$_SESSION['oauth_token_secret']=$access_token['oauth_token_secret'];
			$oauth_token=$oauth->rfc3986_decode($access_token['oauth_token']);		
			$this->set('oauth_token',$oauth_token);	
			return;	
	}
	
	public function display_forget_password()
	{
		$this->layout='ajax';
		$this->render('display_forget_password');	
	}
	
	public function submit_forget_password()
	{
		$this->layout='ajax';
		$data=$this->data;
		$exist=$this->User->find('first',array('conditions'=>array('User.email'=>$data['email'])));
		if(!empty($exist))
		{
			$Mail = new MailController;
       		$Mail->constructClasses();
			$newpass=$this->generateRandomString();
			
			$url='<a href="'.SITE_URL.'/home/update_forget_pass/'.$exist['User']['id'].'" target="_blank">click&nbsp;here</a>';
			$arr=array();
			$arr['id']=$exist['User']['id'];
			$arr['FIRST_NAME']=$exist['User']['first_name'];
			$arr['FOLLOW_URL']=$url;
			
			$Mail->send_forgetpass_mail($exist['User']['id'],$arr,'forget_password');
			
			die;
		}else{
			echo 'error';die;	
		}	
	}	
	
	
	public function generateRandomString($length = 8) {
   		 return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}
	
	public function update_user_phone($phone,$user_id)
	{
		$this->User->id=$user_id;
		$this->User->saveField('phone',$phone);
		die;	
	}
	
	public function get_user_id()
	{
		echo $this->Session->read('User.User.id'); die;	
	}
	
	public function invalid_session()
	{
		$this->layout='ajax';
		$this->render('invalid_session');	
	}
	
	
	public function thanks()
	{
		$this->layout='default';
		$this->render('thanks_page');	
	}
	
	public function thanks1()
	{
		$this->layout='default';
		$this->render('thanks_page1');	
	}
	
	public function thankyou_register()
	{
		//pr($this->data); die;
		if(!empty($this->data))
		{
			if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
				App::import('Component','Captcha'); //load it
				$this->Captcha = new CaptchaComponent(); //make instance
				$this->Captcha->startup($this); //and do some manually calling
			}
			$cap=$this->Captcha->getVerCode();
			//if($cap==$this->data['captcha'])
			//{
				$user_exist=$this->User->findByEmail($this->data['email']);
				if(empty($user_exist))
				{
					$pass=md5($this->data['password']);
					$points=$this->Points->findById('1');
					
					$data=array('first_name'=>$this->data['first_name'],'last_name'=>$this->data['last_name'],'dob'=>$this->data['dob'],'phone'=>$this->data['phone'],'email'=>$this->data['email'],'password'=>$pass,'user_added_date'=>date("Y-m-d H:i:s"),'points'=>$points['Points']['points'],'gender'=>$this->data['gender'],'user_code'=>'USER');
					$this->User->create();
					$temp=$this->User->save($data);
					
					$vouch=$this->BrandProduct->find('first',array('conditions'=>array('BrandProduct.voucher_name'=>'TGIF INR 250')));
					
					$url='https://catalog.vouchagram.com/EPService.svc/xSendVoucher?BuyerGuid='.MID.'&ProductGuid='.$vouch['BrandProduct']['product_guid'].'&templateid=10&ExternalOrderID=USER_'.$temp['User']['id'].'&Quantity=1&CustomerFName='.urlencode($temp['User']['first_name']).'&CustomerMName=&CustomerLName='.urlencode($temp['User']['last_name']).'&CommunicationMode=B&EmailTo='.$temp['User']['email'].'&EmailCC=&EmailSubject=MyGyFTR&MobileNo='.$temp['User']['phone'].'&Password='.MPass;
				
					$result=simplexml_load_file($url);
										
					///////////////User Registration Mail//////////////////
					/*	
					$Mail = new MailController;
					$Mail->constructClasses();
					
					$this->BrandProduct->bindModel(array('belongsTo'=>array('GiftBrand'=>array('className'=>'GiftBrand','foreignKey'=>'gift_brand_id'))));
					$product=$this->BrandProduct->find('first',array('conditions'=>array('BrandProduct.voucher_name'=>'TGIF INR 250')));
					
					if(!empty($product))
					{		
						$voucher_img='<tr>
							  <td><img src="~~SITE_URL~~/files/BrandImage/'.$product['GiftBrand']['gift_category_id'].'/Product/'.$product['BrandProduct']['product_thumb'].'" alt="" height="70" width="70"></td>
							  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.str_replace("_","'",$product['BrandProduct']['voucher_name']).'</td>
							</tr>';	
						$arr['TO_NAME'] = $temp['User']['first_name'];
						$arr['FROM_NAME'] = 'Mygyftr';
						$arr['TO_EMAIL'] = $temp['User']['email'];
						$arr['SUB_NAME'] = $temp['User']['first_name'];
						$arr['RECIPIENT'] = $temp['User']['first_name'];
																		
						$arr['VOUCHER_DETAILS'] = '<table width="100%" cellspacing="0" cellpadding="5px" border="1" bordercolor="#000000" bordercolordark="#000000">
										<tr>
										  <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; line-height:16px; color:#000000;"><strong>Voucher</strong></td>
										  <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;  line-height:16px; color:#000000;"><strong>Details</strong></td>
										</tr>'.$voucher_img.'</table>';
						
						$Mail->sendMail(1, 'thankyou_gift_mail', $arr,1);	
						if(!empty($temp['User']['phone']))
						{
							$arr['TO_PHONE']=$temp['User']['phone'];
							$Mail->sendSMS($temp['User']['id'], 'thankyou_gift_sms', $arr);	
						}
						//////////////////////////////////////////////////////
												
					}*/
					echo 'success';die;		
				}else{
					echo 'user_exist';die;	
				}
			//}else{
			//	echo 'captcha_error'; die;	
			//}
		}else{
			echo 'user_exist'; die;	
		}
			
	}
	
	
	public function captcha() {
		$this->autoRender = false;
		$this->layout='ajax';
		if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
			
			App::import('Component','Captcha'); //load it
			$this->Captcha = new CaptchaComponent(); //make instance
			$this->Captcha->startup($this); //and do some manually calling
		}
		$width = isset($_GET['width']) ? $_GET['width'] : '140';
		$height = isset($_GET['height']) ? $_GET['height'] : '60';
		$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '6';
		$this->Captcha->create($width, $height, $characters); //options, default are 120, 40, 6.

	}
	
	
	
}
