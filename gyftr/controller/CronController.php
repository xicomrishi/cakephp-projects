<?php
App::import('Core','Validation');
App::uses('CakeEmail', 'Network/Email'); 
App::import('Vendor',array('functions','xml_regex'));
App::import('Controller', array('Mail','Users'));


class CronController extends AppController {    
	 public $uses = array('GiftCategory','GiftBrand','Voucherinfo','Product','BrandProduct','Shops','Order','GroupGift','User','Payment','Points','Basket','Mail');
	 public function beforeFilter() {		
		ini_set("memory_limit","2400M");
		ini_set("max_execution_time","0");
		
	 }
	 
	public function import_data()
	{
		$this->delete_existing_data();
		$gift_cats=$this->get_category_list();
		
		echo '<br>Cron run status: success';die;		
	}
	
	public function delete_existing_data()
	{
		$this->GiftCategory->query('truncate table gyftr_gift_category');
		$this->GiftBrand->query('truncate table gyftr_gift_brands');
		$this->BrandProduct->query('truncate table gyftr_brand_products');	
		$this->Shops->query('truncate table gyftr_shops');
		$this->delete_directory(WWW_ROOT . 'files/BrandImage/');
		$this->delete_directory(WWW_ROOT . 'files/tempFile/');
		
		return;
	}
	
	public function delete_directory($dir)
	{
		if ($handle = opendir($dir))
		{
		$array = array();
		
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
		
					if(is_dir($dir.$file))
					{
						if(!@rmdir($dir.$file)) // Empty directory? Remove it
						{
						$this->delete_directory($dir.$file.'/'); // Not empty? Delete the files inside it
						}
					}
					else
					{
					   @unlink($dir.$file);
					}
				}
			}
			closedir($handle);
		
			@rmdir($dir);
		}
		return;
	}

	
	public function get_category_list()
	{
		$url="https://catalog.vouchagram.com/EPService.svc/xCategoryList?buyerGUID=".MID."&password=".MPass;
		//echo $url;die;
		$resp=simplexml_load_file($url);
		$arr=array();
		$temp = element_set('CategoryList',$resp[0]);
		for($i=0;$i<count($temp);$i++)
		{
			$arr[$i]['id']=value_in('CategoryId',$temp[$i],true);
			$arr[$i]['name']=value_in('CategoryName',$temp[$i],true);	
		}
		//echo '<pre>';print_r($resp);die;
		foreach($arr as $ar)
		{
			
			$exist=$this->GiftCategory->find('first',array('conditions'=>array('GiftCategory.cat_id'=>$ar['id']),'fields'=>array('GiftCategory.id')));
			if(!empty($exist))
			{
				$sql="update gyftr_gift_category set name='".$ar['name']."' where id='".$exist['GiftCategory']['id']."'";
				$this->GiftCategory->query($sql);	
				$this->get_category_product($ar['id'],$exist['GiftCategory']['id']);
			}else{
				$data=array('cat_id'=>$ar['id'],'name'=>$ar['name'],'status'=>'1');
				$this->GiftCategory->create();
				$info=$this->GiftCategory->save($data);	
				//echo 'cat_<br>';
				$this->get_category_product($ar['id'],$info['GiftCategory']['id']);
			}
		}		
		return $arr;		
	}
	
	
	public function get_category_product($cat_id,$id)
	{
		$arr=array();
		$url="https://catalog.vouchagram.com/EPService.svc/xCategoryProduct?buyerGUID=".MID."&password=".MPass."&catalogcategoryguid=".$cat_id;
		
		$resp=simplexml_load_file($url);
		$brand=element_set('Merchant',$resp[0],false);
		$i=0;
		//pr($brand); die;
		foreach($brand as $bd)
		{			
			$cat_product=element_set('Product',$bd,false);
			if(!empty($cat_product))
			{
				$j=0;
				//pr($cat_product);
				
				foreach($cat_product as $cp)
				{
					$arr[$i]['product'][$j]['pid']=value_in('ProductGuid',$cp,true);
					$arr[$i]['product'][$j]['pname']=value_in('ProductName',$cp,true);	
					$arr[$i]['product'][$j]['bimage']=value_in('BrandImagePath',$cp,true);
						
					$this->get_product_details($arr[$i]['product'][$j],$id);				
					$j++;
				}
				
				
			}
			
			$i++;
			
		}
	//echo '<pre>';print_r($arr);
		//	echo '<br><br>';
	//die;
		return $arr;		
	}
	
	public function brand_entry_in_db($mycat_id,$details)
	{

		$exist=$this->GiftBrand->find('first',array('conditions'=>array('GiftBrand.name'=>$details['mname'],'gift_category_id'=>$mycat_id),'fields'=>array('GiftBrand.id','GiftBrand.gift_category_id')));
		
		if(!empty($exist))
		{
			$img_name=$this->save_image($details['mimage'],'BrandImage',$exist['GiftBrand']['gift_category_id']);
			$sql="update gyftr_gift_brands set thumb='"."brandthumb_".$img_name."' where id='".$exist['GiftBrand']['id']."'";
			$this->GiftCategory->query($sql);
			$br_id=$exist['GiftBrand']['id'];
				
		}else{
			$data=array('gift_category_id'=>$mycat_id,'name'=>$details['mname'],'active'=>'1');
			$this->GiftBrand->create();
			$info=$this->GiftBrand->save($data);
			if(!is_dir(WWW_ROOT . 'files' . DS . 'BrandImage')) {
				mkdir(WWW_ROOT . 'files' . DS . 'BrandImage',0777);
			}
			$folderpath=WWW_ROOT . 'files' . DS . 'BrandImage' . DS . $mycat_id;
			if(!is_dir($folderpath)) {
				mkdir($folderpath,0777);
			}
			$img_name=$this->save_image($details['mimage'],'BrandImage',$mycat_id);
			
			$this->GiftBrand->id=$info['GiftBrand']['id'];
			$this->GiftBrand->saveField('thumb','brandthumb_'.$img_name);
			$br_id=$info['GiftBrand']['id'];			
		}
		return $br_id;			
	}
	
	public function save_image($url,$type,$id)
	{
		$path_parts=pathinfo($url);
		$filename=$path_parts['basename'];
		$fileUpload = WWW_ROOT . 'files' . DS ;
		if(!is_dir($fileUpload.'tempFile')) {
				mkdir($fileUpload.'tempFile',0777);
		}
		$imagecontent = DownloadImageFromUrl($url);
		if(!empty($imagecontent))
		{
		$savefile = fopen($fileUpload.'tempFile/'.$filename, 'w');
		fwrite($savefile, $imagecontent);
		fclose($savefile); 
		if($type=='BrandImage')
		{
			$save_path='BrandImage'. DS .$id. DS . 'brandthumb_'.$filename;
		}else{
			$destination=$fileUpload.'BrandImage'. DS .$id . 'image_' .$filename;
			move_uploaded_file($fileUpload.'tempFile/'.$filename,$destination);
			$save_path='BrandImage'. DS .$id. DS . 'Product' . DS . 'productthumb_'.$filename;	
		}		
		
		create_thumb($fileUpload.'tempFile/'. $filename, 120, $fileUpload.$save_path);
		}else{
			$filename='';	
		}
		return $filename;
		
	}
	
	public function mtest($pr_id)
	{
		$url="https://catalog.vouchagram.com/EPService.svc/xProduct?buyerGUID=".MID."&password=".MPass."&productguid=".$pr_id;
		echo $url;
		$arr=array();
		$resp=simplexml_load_file($url);
		$arr['result']=value_in('ResultType',$resp[0],true);
		pr(strtolower($arr['result'])); die;
		die;	
	}
	
	public function get_product_details($product,$mycat_id)
	{
		
		if(!is_dir(WWW_ROOT . 'files' . DS . 'BrandImage')) {
				mkdir(WWW_ROOT . 'files' . DS . 'BrandImage',0777);
			}
			$folderpath=WWW_ROOT . 'files' . DS . 'BrandImage' . DS . $mycat_id;
			if(!is_dir($folderpath)) {
				mkdir($folderpath,0777);
		}
		
 
		$brandexist=$this->GiftBrand->findByNameAndGiftCategoryId(str_replace("'","_",$product['pname']),$mycat_id);
		if(empty($brandexist))
		{
			$imgname=$this->save_image($product['bimage'],'BrandImage',$mycat_id);
			$brand=array('gift_category_id'=>$mycat_id,'name'=>str_replace("'","_",$product['pname']),'thumb'=>'brandthumb_'.$imgname,'active'=>'1');
			$this->GiftBrand->create();
			$giftbrand=$this->GiftBrand->save($brand);	
		}else{
			//echo '<pre>';print_r($brandexist);
			$giftbrand=$brandexist;	
		}
		
		
		
		$arr=array();
		
		$url="https://catalog.vouchagram.com/EPService.svc/xProduct?buyerGUID=".MID."&password=".MPass."&productguid=".$product['pid'];
		$resp=simplexml_load_file($url);
		
				
		$arr['pimage']=value_in('ProductImagePath',$resp[0],true);		
		$folderpath=WWW_ROOT . 'files' . DS . 'BrandImage' . DS . $mycat_id . DS . 'Product' ;
		if(!is_dir($folderpath)) {
			mkdir($folderpath,0777);
		}
		$imgname=$this->save_image($arr['pimage'],'Product',$mycat_id);
		
		$arr['product_image']='image_'.$imgname;
		$arr['product_thumb']='productthumb_'.$imgname;
		$arr['gift_brand_id']=$giftbrand['GiftBrand']['id'];
		$arr['product_guid']=value_in('ProductGuid',$resp[0],true);
		$arr['product_name']=str_replace("'","_",value_in('ProductName',$resp[0],true));
		
		$arr['expiry_date']=value_in('ProductExpirydate',$resp[0],true);
		$arr['available_qty']=value_in('AvailableQuantity',$resp[0],true);
		$arr['price']=value_in('Price',$resp[0],true);
		$arr['voucher_type']=value_in('VoucherType',$resp[0],true);
		$arr['voucher_name']=str_replace("'","_",value_in('VoucherName',$resp[0],true));
		$arr['voucher_expiry']=value_in('Voucherexpirydate',$resp[0],true);
		$arr['cancelrule']=value_in('CancelationRule',$resp[0],true);
		$arr['product_tnc']=value_in('ProductTnC',$resp[0],true);
		$arr['active']='1';	
		
		//echo '<br><br>'; 			
		if(!empty($arr['product_guid']))
		{
		$shop=array();
		/*if(!empty($exist))
		{
			///////////////////
			//////////////////	
		}else{*/
			
			$this->BrandProduct->create();
			$info=$this->BrandProduct->save($arr);
			$temp_shops=element_set('Shop',$resp[0],false);
			if(!empty($temp_shops))
			{
			$i=0;
			foreach($temp_shops as $tmp)
			{
				$shop[$i]['brand_product_id']=$info['BrandProduct']['id'];
				$shop[$i]['shop_guid']=value_in('ShopGuid',$tmp,true);
				$shop[$i]['name']=value_in('ShopName',$tmp,true);
				$shop[$i]['address']=str_replace("\xC2\x96","",value_in('Address',$tmp,true));
				$shop[$i]['city']=value_in('City',$tmp,true);
				$shop[$i]['state']=value_in('State',$tmp,true);
				$shop[$i]['phone']=value_in('ContactPhone',$tmp,true);
				if($shop[$i]['brand_product_id']!=81)
				{
					$this->Shops->create();
					$this->Shops->save($shop[$i]);
				
				$i++;
				}
			}
			}
					
		//}
		}
		return;
		
	}
	
	
	public function smstest()
	{
		$url="http://bulkpush.mytoday.com/BulkSms/SingleMsgApi?feedid=".urlencode('338500')."&username=".urlencode('9818015215')."&password=".urlencode('pjttw')."&To=".urlencode('919711950715')."&Text=".urlencode('Hello check 2350')."&time=200812110950&senderid=testSenderID";
		
		$ch = curl_init();	
		curl_setopt($ch, CURLOPT_POST, 0);		
		curl_setopt($ch,CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
		$result=curl_exec($ch);		
		curl_close($ch);		
		echo $result;die;	
	}
	
	public function emailtest()
	{
		$email = new CakeEmail();
			$email->template('default');
			$email->config('default');
			$email->emailFormat('html')->to('vivek.ece07@gmail.com')->subject('123')->send('456');
			echo 1;die;	
	}
	
	
	
	public function crontest($id=0)
	{
		
		$gifts_orders=array();
		if($id==0)
		{
		$sql="select O.* from gyftr_order_detail O where unix_timestamp(O.delivery_time) between unix_timestamp(DATE_SUB(NOW(),INTERVAL 299 SECOND)) and unix_timestamp(DATE_ADD(NOW(),INTERVAL 2 SECOND)) and O.status!=3 and O.status!=1";
		}else{
			$sql="select O.* from gyftr_order_detail O where O.id='".$id."'";
		}
        $data=$this->Order->query($sql);
		
		$order=array(); $i=0;
		foreach($data as $dat)
		{
			$order[$i]=$dat['O'];
			$order[$i]['voucher']=$order[$i]['qty']='';
			$q="select V.product_guid,V.id,B.quantity from gyftr_brand_products V inner join gyftr_basket B ON (B.product_guid=V.product_guid) where B.session_id='".$dat['O']['session_id']."' GROUP BY V.product_guid";
			$vouch=$this->BrandProduct->query($q);
			
			$last=count($vouch); 
			$m=1;		
			foreach($vouch as $vch)
			{
				if($m==$last){
               		 $order[$i]['voucher'].=$vch['V']['product_guid'];	
					 $order[$i]['qty'].=$vch['B']['quantity'];	
                }else{
					$order[$i]['voucher'].=$vch['V']['product_guid'].',';	
                	 $order[$i]['qty'].=$vch['B']['quantity'].',';
                }				
				$m++;
			}
			$i++;			
		}
		
		foreach($order as $ord)
		{
			if(($ord['payment_status']=='1'||$ord['incomplete_deliver']=='1')&&$ord['status']!=1)
			{
				if(($ord['incomplete_deliver']=='1')&&($ord['total_amount']-$ord['amount_paid']>0))
				{
					if($ord['amount_paid']>0)
					{
						$respond=$this->sendIncompleteNotif($ord);
						if($id!=0)
						{
							if($respond=='notif_error')
							{
								return 'notif';	
							}	
						}
					}
									
				}else{
				
				$to_phone='';
				if(!empty($ord['to_email']))
				{
					$mode='E';
					if(!empty($ord['to_phone']))
					{
						$mode='B';	
						$to_phone=$ord['to_phone'];
					}
				}else{
					if(!empty($ord['to_phone']))
					{	$mode='S';	
						$to_phone=$ord['to_phone'];
					}
				}
				$url='https://catalog.vouchagram.com/EPService.svc/xSendVoucher?BuyerGuid='.MID.'&ProductGuid='.$ord['voucher'].'&templateid=10&ExternalOrderID='.$ord['session_id'].'&Quantity='.$ord['qty'].'&CustomerFName='.urlencode($ord['to_name']).'&CustomerMName=&CustomerLName=&CommunicationMode='.$mode.'&EmailTo='.$ord['to_email'].'&EmailCC=&EmailSubject=MyGyFTR&MobileNo='.$to_phone.'&Password='.MPass;
				
				$result=simplexml_load_file($url);
				
				$value=value_in('ResultType',$result,true);
				
				if(strtolower($value)=='success')
				{
					
					if($mode=='E') $deliver_mode='0';
					if($mode=='S') $deliver_mode='1';
					if($mode=='B') $deliver_mode='2';
					$this->Order->id=$ord['id'];
					$this->Order->save(array('status'=>1,'delivered_on'=>$deliver_mode));
					$gifts_orders[]=$ord['id'];			
				}else{
					if($id!=0)
						return 'error';
					else	
						echo '2';die;
					}		
				}
			}
		}
		
		if(!empty($gifts_orders))
		{
			foreach($gifts_orders as $go)
			{
				$this->send_gift_received_mail($go);	
			}	
		}
		
		if($id!=0)
		{
			return 'success';	
		}else{
		echo '1';die;
		}
		
	}
	
	public function send_gift_received_mail($ord_id)			
	{
		$Mail = new MailController;
      	$Mail->constructClasses();		
		$arr = array();
		$this->Order->recursive=3;
		$this->Order->primaryKey='session_id';
		$this->Basket->primaryKey='product_guid';
		$this->BrandProduct->bindModel(array('belongsTo'=>array('GiftBrand'=>array('className'=>'GiftBrand','foreignKey'=>'gift_brand_id'))));
		$this->Basket->bindModel(array('hasOne' => array('BrandProduct' => array('className' => 'BrandProduct','foreignKey' => 'product_guid','fields'=>array('BrandProduct.product_guid','BrandProduct.gift_brand_id','BrandProduct.product_name','BrandProduct.voucher_name','BrandProduct.price','BrandProduct.product_thumb')))),false);
		
		$this->Order->bindModel(array('hasMany' => array('Basket' => array('className' => 'Basket','foreignKey' => 'session_id')),
									  'belongsTo'=>array('User'=>array('className'=>'User','foreignKey'=>'from_id'))),false);
		$order=$this->Order->findById($ord_id);
		$voucher_img='';
		foreach($order['Basket'] as $bask)
		{
			for($z=0;$z<$bask['quantity'];$z++)
			{
			$voucher_img.='<tr>
                          <td><img src="~~SITE_URL~~/files/BrandImage/'.$bask['BrandProduct']['GiftBrand']['gift_category_id'].'/Product/'.$bask['BrandProduct']['product_thumb'].'" alt="" height="70" width="70"></td>
                          <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.str_replace("_","'",$bask['BrandProduct']['voucher_name']).'</td>
                        </tr>';	
			}
		}
		$fellow=$gyftrs='';
		$arr['FELLOW_GYFTRS']='';
		if($order['Order']['group_gift_id']!=0)
		{
			$gpusers=$this->GroupGift->find('all',array('conditions'=>array('GroupGift.order_id'=>$order['Order']['id'])));			
			foreach($gpusers as $gp)
			{
				$gyftrs.=$gp['GroupGift']['name'].',';
				if($gp['GroupGift']['other_user_id']!=$order['User']['id'])
				{
					
					if(!empty($gp['GroupGift']['email'])) $email=$gp['GroupGift']['email']; else $email='N/A';
					if(!empty($gp['GroupGift']['phone'])) $phone=$gp['GroupGift']['phone']; else $phone='N/A';
					$fellow.='<tr>
                          <td width="60" align="left"><img src="cid:bullet" alt=""></td>
                          <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.$gp['GroupGift']['name'].'</td>
                        </tr>';	
				}
			}	
		}else{
			$gyftrs.=$order['Order']['from_name'];
		}
		$arr['TO_NAME'] = $order['Order']['to_name'];
                $arr['FROM_NAME'] = $order['Order']['from_name'];
		$arr['TO_EMAIL'] = $order['Order']['to_email'];
		$arr['SUB_NAME'] = $order['Order']['to_name'];
		$arr['RECIPIENT'] = $order['Order']['to_name'];
		$arr['GYFTRS'] = $gyftrs;
		$arr['OCCASION'] = $order['Order']['occasion'];
		$arr['MY_POINTS'] = $order['User']['points'];
		$arr['DATE'] = show_formatted_datetime($order['Order']['delivery_time']);
		
		$arr['VOUCHER_DETAILS'] = '<table width="100%" cellspacing="0" cellpadding="5px" border="1" bordercolor="#000000" bordercolordark="#000000">
                        <tr>
                          <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; line-height:16px; color:#000000;"><strong>Voucher</strong></td>
                          <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;  line-height:16px; color:#000000;"><strong>Details</strong></td>
                        </tr>'.$voucher_img.'</table>';
		if($order['Order']['group_gift_id']!=0)
		{				
			$arr['FELLOW_GYFTRS'] =	'<tr><td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; line-height:16px; color:#000000; ">People who wanted to be part of the contribution: </td></tr><tr><td><table width="100%" cellpadding="0" cellspacing="0" border="0">'.$fellow.'</table></td></tr>';		
		}
		$Mail->sendMail($order['Order']['from_id'], 'gift_received_mail', $arr,1);
		
		if(!empty($order['Order']['to_phone']))
		{
			$arr['TO_PHONE']=$order['Order']['to_phone'];
			$Mail->sendSMS($order['User']['id'], 'gift_received_sms', $arr);	
		}	
		return;
	}
	
	public function sendsuccessMail($userid,$delivery_time)
	{
		$Mail = new MailController;
      	$Mail->constructClasses();
		$user=$this->User->findById($userid);
		$arr=array();
		$arr['TO_NAME'] = $user['User']['first_name'].' '.$user['User']['last_name'];
		$arr['TO_EMAIL'] = $user['User']['email'];
		$arr['FROM_NAME'] = 'MyGyFTR Team';
		$arr['DATE'] = $delivery_time;
		$Mail->sendMail($user['User']['id'], 'gift_delivered_mail', $arr);
		if(!empty($user['User']['phone']))
		{
			$arr['TO_PHONE']=$user['User']['phone'];
			$Mail->sendSMS($user['User']['id'], 'gift_delivered_sms', $arr);	
		}
		return;
	}
	
	
	
	
	public function returnPoints($userId,$points,$ordId,$gpuserId)
	{
		$points=round($points,0);		
		if($gpuserId!=0)
		{
			$q="update gyftr_group_gift_users G set G.contri_amount_paid=cast(G.contri_amount_paid as UNSIGNED)-".$points." where id=".$gpuserId;
			$this->GroupGift->query($q);	
		}
		$sql="update gyftr_users set points=cast(points as UNSIGNED)+".$points." where id='".$userId."'";
		$this->User->query($sql);
		return;	
	}
	
	public function Incomplete()
	{
		
		$sql="select O.* from gyftr_order_detail O where unix_timestamp(O.delivery_time)< unix_timestamp(NOW()) and O.status!=3 and O.status!=1";
		
        $data=$this->Order->query($sql);
		
		$order=array(); $i=0;
		foreach($data as $dat)
		{
			$order[$i]=$dat['O'];
			$order[$i]['voucher']=$order[$i]['qty']='';
			$q="select V.product_guid,V.id,B.quantity from gyftr_brand_products V inner join gyftr_basket B ON (B.product_guid=V.product_guid) where B.session_id='".$dat['O']['session_id']."' GROUP BY V.product_guid";
			$vouch=$this->BrandProduct->query($q);
			
			$last=count($vouch); 
			$m=1;		
			foreach($vouch as $vch)
			{
				if($m==$last){
               		 $order[$i]['voucher'].=$vch['V']['product_guid'];	
					 $order[$i]['qty'].=$vch['B']['quantity'];	
                }else{
					$order[$i]['voucher'].=$vch['V']['product_guid'].',';	
                	 $order[$i]['qty'].=$vch['B']['quantity'].',';
                }				
				$m++;
			}
			$i++;			
		}
		
		foreach($order as $ord)
		{
			if(($ord['payment_status']=='1'||$ord['incomplete_deliver']=='1')&&$ord['status']!=1)
			{
				if(($ord['incomplete_deliver']=='1')&&($ord['total_amount']-$ord['amount_paid']>0))
				{
					$this->sendIncompleteNotif($ord);														
				}
			}
		}
		die;
	}
	
	public function sendIncompleteNotif($ord)
	{
		$return='notif_error';
		if($ord['type']!='Me To Me')
		{			
		$date=date("Y-m-d H:i:s");
		$uid=String::uuid();	
		if($ord['group_gift_id']==0)
		{			
			$this->Order->query("update gyftr_order_detail set group_gift_id='".$uid."',type='Group Gift' where id=".$ord['id']);
			$ini_user=$this->User->findById($ord['from_id']);
			$newgp=array('order_id'=>$ord['id'],'group_gift_id'=>$uid,'initiator_id'=>$ord['from_id'],'email'=>$ini_user['User']['email'],'name'=>$ini_user['User']['first_name'].' '.$ini_user['User']['last_name'],'phone'=>$ini_user['User']['phone'],'other_user_id'=>$ini_user['User']['id'],'contri_amount_expected'=>$ord['total_amount']-$ord['amount_paid']);
			$this->GroupGift->create();
			$this->GroupGift->save($newgp);
		}
		
			$Mail = new MailController;
			$Mail->constructClasses();
			$q="select * from gyftr_group_gift_users as GP where order_id='".$ord['id']."' and group_gift_id='".$ord['group_gift_id']."' and email='".$ord['to_email']."'";		
			$group=$this->GroupGift->query($q);
			
			/****Rejection flag set indicates that after 168hrs, expired gift cron will change the status of this gift to "expired". Check function below  remove_expired_gift ****/
			$this->Order->query("update gyftr_order_detail set rejection_flag=1 where id='".$ord['id']."'");
			$req_id=String::uuid();
			if(!empty($group[0]['GP']))
			{
				$this->GroupGift->query("update gyftr_group_gift_users set contri_amount_expected=".$ord['total_amount']-$ord['amount_paid'].",req_id=".$req_id." where id=".$group[0]['GP']['id']);
				$gpuser_id=$group[0]['GP']['id'];	
			}else{
				$fr=array('name'=>$ord['to_name'],'email'=>$ord['to_email']);
				$User = new UsersController;
           		 $User->constructClasses();
				$user_id=$User->createUser($fr);
				$req_id=String::uuid();
				$gp=array('order_id'=>$ord['id'],'group_gift_id'=>$uid,'req_id'=>$req_id,'initiator_id'=>$ord['from_id'],'email'=>$ord['to_email'],'name'=>$ord['to_name'],'phone'=>$ord['to_phone'],'other_user_id'=>$user_id,'contri_amount_expected'=>$ord['total_amount']-$ord['amount_paid']);
				$this->GroupGift->create();
				$group=$this->GroupGift->save($gp);
				$gpuser_id=$group['GroupGift']['id'];
			}		
			
			
			//////////////////////////////Mail//////////////////////////////
			$this->Order->recursive=3;
			$this->Order->primaryKey='session_id';
			$this->Basket->primaryKey='product_guid';
			$this->BrandProduct->bindModel(array('belongsTo'=>array('GiftBrand'=>array('className'=>'GiftBrand','foreignKey'=>'gift_brand_id'))));
			$this->Basket->bindModel(array('hasOne' => array('BrandProduct' => array('className' => 'BrandProduct','foreignKey' => 'product_guid','fields'=>array('BrandProduct.product_guid','BrandProduct.gift_brand_id','BrandProduct.product_name','BrandProduct.voucher_name','BrandProduct.price','BrandProduct.product_thumb')))),false);
			
			$this->Order->bindModel(array('hasMany' => array('Basket' => array('className' => 'Basket','foreignKey' => 'session_id')),
										  'belongsTo'=>array('User'=>array('className'=>'User','foreignKey'=>'from_id'))),false);
			$order=$this->Order->findById($ord['id']);
			$voucher_img='';
			foreach($order['Basket'] as $bask)
			{				
				for($z=0;$z<$bask['quantity'];$z++)
		    	{
				$voucher_img.='<tr>
							  <td><img src="~~SITE_URL~~/files/BrandImage/'.$bask['BrandProduct']['GiftBrand']['gift_category_id'].'/Product/'.$bask['BrandProduct']['product_thumb'].'" alt="" height="70" width="70"></td>
							  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.str_replace("_","'",$bask['BrandProduct']['voucher_name']).'</td>
							</tr>';	
				}
			}
			$fellow=$gyftrs='';
			$arr['FELLOW_GYFTRS']='';
			if($order['Order']['group_gift_id']!=0)
			{
				$gpusers=$this->GroupGift->find('all',array('conditions'=>array('GroupGift.order_id'=>$order['Order']['id'])));			
				foreach($gpusers as $gp)
				{
					$gyftrs.=$gp['GroupGift']['name'].',';
					if($gp['GroupGift']['other_user_id']!=$order['User']['id'])
					{						
						if(!empty($gp['GroupGift']['email'])) $email=$gp['GroupGift']['email']; else $email='N/A';
						if(!empty($gp['GroupGift']['phone'])) $phone=$gp['GroupGift']['phone']; else $phone='N/A';
						$fellow.='<tr>
                          <td width="60" align="left"><img src="cid:bullet" alt=""></td>
                          <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.$gp['GroupGift']['name'].'</td>
                        </tr>';
					}
				}	
			}
			$arr = array();				
			
			$url = "<a href='" . SITE_URL . "/home/index?request_id=" . $req_id . "&req_gpuser_id=" . $gpuser_id . "'>click here</a>";
			$arr['FOLLOW_URL'] = $url;
			$arr['TO_NAME'] = $order['Order']['to_name'];
			$arr['TO_EMAIL'] = $order['Order']['to_email'];
			$arr['FROM_NAME'] = $order['Order']['from_name'];
			$arr['SUB_NAME'] = $order['Order']['to_name'];
			$arr['RECIPIENT'] = $order['Order']['to_name'];
			$arr['GYFTRS'] = $gyftrs;
			$arr['OCCASION'] = $order['Order']['occasion'];
			$arr['MY_POINTS'] = $order['User']['points'];
			$arr['DATE'] = show_formatted_datetime($order['Order']['delivery_time']);
			
			$arr['VOUCHER_DETAILS'] = '<table width="100%" cellspacing="0" cellpadding="5px" border="1" bordercolor="#000000" bordercolordark="#000000">
							<tr>
							  <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;  line-height:16px; color:#000000;"><strong>Voucher</strong></td>
							  <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;  line-height:16px; color:#000000;"><strong>Details</strong></td>
							</tr>'.$voucher_img.'</table>';
			if($order['Order']['group_gift_id']!=0)
			{				
				$arr['FELLOW_GYFTRS'] =	'<td><table width="100%" cellpadding="0" cellspacing="0" border="0">'.$fellow.'</table></td>';			
			}
					
			$Mail->sendMail($order['User']['id'], 'gift_incomplete_mail', $arr,1);
			if(!empty($order['Order']['to_phone']))
			{
				$arr['TO_PHONE']=$order['Order']['to_phone'];
				$Mail->sendSMS($order['User']['id'], 'gift_incomplete_sms', $arr);	
			}
			$return='notif_success';	
		
		}		
		return $return;	
	}
	
	public function remove_expired_gifts()
	{		
		$q="select O.* from gyftr_order_detail O where DATE_ADD(O.delivery_time,INTERVAL 168 HOUR) < NOW() and cast(O.total_amount as UNSIGNED) > cast(O.amount_paid as UNSIGNED) and O.status!=1 and O.status!=3";	
		$orders=$this->Order->query($q);
		
		foreach($orders as $ord)
		{
			if($ord['O']['incomplete_deliver']==0||$ord['O']['rejection_flag']==1)
			{
				
				$this->giveback_points($ord['O']['id']);
				
				$sql="update gyftr_order_detail set status='3' where id=".$ord['O']['id'];
				$this->Order->query($sql);	
				
			}
		}
		die;
	}
	
	public function return_vouchers($session_id)
	{
		$basket=$this->Basket->find('all',array('conditions'=>array('Basket.session_id'=>$session_id)));
		foreach($basket as $bask)
		{
			$sql="update gyftr_brand_products P set P.available_qty=cast(P.available_qty as UNSIGNED)+".$bask['Basket']['quantity']." where P.product_guid='".$bask['Basket']['product_guid']."'";
			$this->BrandProduct->query($sql);	
		}
		return;	
	}
	
	public function giveback_points($ordid=0)
	{
		if($ordid==0)
		{
			$sql="select O.* from gyftr_order_detail O where O.delivery_time < NOW() and cast(O.amount_paid as UNSIGNED) > cast(O.total_amount as UNSIGNED) and O.status=1";
		}else{
			$sql="select O.* from gyftr_order_detail O where O.id=".$ordid;	
		}
		
		$order=$this->Order->query($sql);
		
		$data=array(); $i=0;
		foreach($order as $ord)
		{						
				if($ord['O']['group_gift_id']==0)
				{
					if($ordid==0)
					{	
						$return_point=$ord['O']['amount_paid']-$ord['O']['total_amount'];
					}else{
					  	$return_point=$ord['O']['amount_paid'];						
					}
					
						$this->returnPoints($ord['O']['from_id'],$return_point,$ord['O']['id'],0);	
				}else{									
					$gpusers=$this->GroupGift->find('all',array('conditions'=>array('GroupGift.order_id'=>$ord['O']['id'])));
							
					if($ordid==0)
					{	
						$total_left_contri=$ord['O']['amount_paid']-$ord['O']['total_amount'];
					}else{
					  	$total_left_contri=$ord['O']['amount_paid'];						
					}
					
					if($total_left_contri>0)
					{
						foreach($gpusers as $gp)
						{
							if($ordid==0)
							{
								if($gp['GroupGift']['last_paid']==1)
									{
									$this->returnPoints($gp['GroupGift']['other_user_id'],$total_left_contri,$ord['O']['id'],$gp['GroupGift']['id']);
									}	
							}else{
								$total_left_contri=$total_left_contri-$gp['GroupGift']['contri_amount_paid'];
								$this->returnPoints($gp['GroupGift']['other_user_id'],$gp['GroupGift']['contri_amount_paid'],$ord['O']['id'],$gp['GroupGift']['id']);
							}
						}
					}
					
				}
				
					if($ord['O']['status']=='1')
					{
						$sql="update gyftr_order_detail set amount_paid='".$ord['O']['total_amount']."' where id='".$ord['O']['id']."'";
					}else{
						$sql="update gyftr_order_detail set amount_paid='0',payment_status='2' where id='".$ord['O']['id']."'";
					}
					$this->Order->query($sql);
					
		} 
		
		if($ordid==0)
		{
			die;	
		}else{
			return;	
			}
		
	}
	
	
	public function transaction_loyalty()
	{
		$sql="select U.* from gyftr_users U where U.total_transaction>0";
		$users=$this->User->query($sql);
		if(!empty($users))
		{
			$ranges=$this->Points->find('all',array('conditions'=>array('Points.range !=' =>'default'),'order'=>array('Points.id ASC')));
			
			foreach($users as $us)
			{
				if(($us['U']['total_transaction']-$us['U']['points_till_loyalty'])>0)
				{					
					if($us['U']['total_transaction']>0&&$us['U']['total_transaction']<=intval($ranges[0]['Points']['range']))	
						$percent=$ranges[0]['Points']['points'];
					else if($us['U']['total_transaction']>intval($ranges[0]['Points']['range'])&&$us['U']['total_transaction']<=intval($ranges[1]['Points']['range']))	
						$percent=$ranges[1]['Points']['points'];	
					else if($us['U']['total_transaction']>intval($ranges[1]['Points']['range']))
						$percent=$ranges[2]['Points']['points'];	
					else 
						$percent=0;
					
					if($percent!=0)
					{
						$Mail = new MailController;
						$Mail->constructClasses();	
						$percent=round(($percent/100)*$us['U']['total_transaction'],0);	
						if($percent==0)
							$percent=0;	
						$points=$us['U']['points']+$percent;				
						$this->User->id=$us['U']['id'];
						$this->User->save(array('loyalty_date'=>date("Y-m-d H:i:s"),'points_till_loyalty'=>$us['U']['total_transaction'],'points'=>$points));	
						$arr=array();
						$arr['TO_NAME'] = $us['U']['first_name'].' '.$us['U']['last_name'];
						$arr['TO_EMAIL'] = $us['U']['email'];
						$arr['FROM_NAME'] = 'MyGyFTR Team';
						$arr['POINTS'] = $percent;
						if($percent>0)
							$Mail->sendMail($us['U']['id'], 'loyalty_points_mail', $arr);
					}
				}	
			}
							
		}
		die;
	}
	
	
	public function not_paid_notif()
	{
		$date=date("Y-m-d H:i:s");
		$this->Order->recursive=3;
		$this->Order->primaryKey='session_id';
		$this->Basket->primaryKey='product_guid';
		$this->BrandProduct->bindModel(array('belongsTo'=>array('GiftBrand'=>array('className'=>'GiftBrand','foreignKey'=>'gift_brand_id'))));
		$this->Basket->bindModel(array('hasOne' => array('BrandProduct' => array('className' => 'BrandProduct','foreignKey' => 'product_guid','fields'=>array('BrandProduct.product_guid','BrandProduct.gift_brand_id','BrandProduct.product_name','BrandProduct.voucher_name','BrandProduct.price','BrandProduct.product_thumb')))),false);
		
		$this->Order->bindModel(array('hasMany' => array('Basket' => array('className' => 'Basket','foreignKey' => 'session_id')),
									  'belongsTo'=>array('User'=>array('className'=>'User','foreignKey'=>'from_id'))),false);
		$orders=$this->Order->find('all',array('conditions'=>array('Order.status'=>'2','Order.group_gift_id !='=>'0','Order.delivery_time >'=>$date)));		
		
		
		$interval=array();
		$interval['month'][0]=date("Y-m-d H:i:s",(strtotime($date)+2592000));   // 1month - 1month+1 day
		$interval['month'][1]=date("Y-m-d H:i:s",(strtotime($date)+2678400));
		$interval['seven_days'][0]=date("Y-m-d H:i:s",(strtotime($date)+604800)); //7 days- 8days
		$interval['seven_days'][1]=date("Y-m-d H:i:s",(strtotime($date)+691200));
		$interval['three_days'][0]=date("Y-m-d H:i:s",(strtotime($date)+259200)); //3days - 4days
		$interval['three_days'][1]=date("Y-m-d H:i:s",(strtotime($date)+345600));
		$interval['one_days'][0]=date("Y-m-d H:i:s",(strtotime($date)+86400));  //1day-2day
		$interval['one_days'][1]=date("Y-m-d H:i:s",(strtotime($date)+172800));
		$interval['six_hours'][0]=date("Y-m-d H:i:s",(strtotime($date)+21600)); //6 hrs - 1day
		$interval['six_hours'][1]=date("Y-m-d H:i:s",(strtotime($date)+86400));
		
		$all_orders=$time_orders=array();
		$i=$j=$k=$l=$m=0;
		foreach($orders as $ord)
		{
			if(intval($ord['Order']['total_amount'])>intval($ord['Order']['amount_paid']))
			{
				if($ord['Order']['delivery_time']>$interval['month'][0] && $ord['Order']['delivery_time']<$interval['month'][1] && $ord['Order']['contri_notif']==0)
				{
					$all_orders[]=$ord;
					$time_orders['1'][$i]=$ord['Order']['id'];
					$i++;
					
				}else if($ord['Order']['delivery_time']>$interval['seven_days'][0] && $ord['Order']['delivery_time']<$interval['seven_days'][1] && $ord['Order']['contri_notif']<2)
				{
					$all_orders[]=$ord;
					$time_orders['2'][$j]=$ord['Order']['id'];
					$j++;
					
				}else if($ord['Order']['delivery_time']>$interval['three_days'][0] && $ord['Order']['delivery_time']<$interval['three_days'][1] && $ord['Order']['contri_notif']<3)
				{
					$all_orders[]=$ord;
					$time_orders['3'][$k]=$ord['Order']['id'];
					$k++;
						
				}else if($ord['Order']['delivery_time']>$interval['one_days'][0] && $ord['Order']['delivery_time']<$interval['one_days'][1] && $ord['Order']['contri_notif']<4)
				{
					$all_orders[]=$ord;
					$time_orders['4'][$l]=$ord['Order']['id'];
					$l++;	
					
				}else if($ord['Order']['delivery_time']>$interval['six_hours'][0] && $ord['Order']['delivery_time']<$interval['six_hours'][1] && $ord['Order']['contri_notif']<5)
				{
					$all_orders[]=$ord;
					$time_orders['5'][$m]=$ord['Order']['id'];	
					$m++;
				}
			}
				
		}
		
		//echo '<pre>';print_r($all_orders);die;
		
		$Mail = new MailController;
        $Mail->constructClasses();
        $arr = array();
		
		foreach($all_orders as $order)
		{
			$from_id = $order['Order']['from_id'];
			$voucher_img='';
			foreach($order['Basket'] as $bask)
			{
				for($z=0;$z<$bask['quantity'];$z++)
				{
				$voucher_img.='<tr>
							  <td><img src="~~SITE_URL~~/files/BrandImage/'.$bask['BrandProduct']['GiftBrand']['gift_category_id'].'/Product/'.$bask['BrandProduct']['product_thumb'].'" alt="" height="70" width="70"></td>
							  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.str_replace("_","'",$bask['BrandProduct']['voucher_name']).'</td>
							</tr>';	
				}
			}
			$gpusers=$this->GroupGift->find('all',array('conditions'=>array('GroupGift.order_id'=>$order['Order']['id'])));
			
			$fellow='';
			foreach($gpusers as $gp)
			{
				
					$fellow.=' <tr>
							  <td width="60" align="left"><img src="cid:bullet" alt=""></td>
							  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.$gp['GroupGift']['name'].'</td>
							</tr>';	
				
			}
			
			foreach($gpusers as $gpuser)
			{			
				if($gpuser['GroupGift']['other_user_id']!=$order['Order']['from_id'])
				{
					if(!empty($gpuser['GroupGift']['contri_amount_paid'])||$gpuser['GroupGift']['contri_amount_paid']==0)
					{
						$arr['TO_NAME'] = $gpuser['GroupGift']['name'];
						$arr['TO_EMAIL'] = $gpuser['GroupGift']['email'];
						$arr['TO_PHONE']=$gpuser['GroupGift']['phone'];
						$arr['FROM_NAME']=$order['Order']['from_name'];
						$arr['SUBJECT_NAME'] = $order['Order']['to_name'];
						$arr['RECIPIENT'] = $order['Order']['to_name'];
						$arr['OCCASION'] = $order['Order']['occasion'];
						$arr['MY_POINTS'] = $order['User']['points'];	
						$arr['DATE'] = show_formatted_datetime($order['Order']['delivery_time']);
						$arr['FELLOW_GYFTRS'] =	' <td><table width="100%" cellpadding="0" cellspacing="0" border="0">'.$fellow.'</table></td>';
						$arr['VOUCHER_DETAILS'] = '<table width="100%" cellspacing="0" cellpadding="5px" border="1" bordercolor="#000000" bordercolordark="#000000">
									<tr>
									  <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;  line-height:16px; color:#000000;"><strong>Voucher</strong></td>
									  <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;  line-height:16px; color:#000000;"><strong>Details</strong></td>
									</tr>'.$voucher_img.'</table>';	  
						$Mail->sendMail($from_id, 'reminder_service_mail', $arr,1);
						if(!empty($gpuser['GroupGift']['phone']))
							$this->sendInviteSMS($gpuser['GroupGift']['phone'], 'reminder_service_sms', $arr);
						
					}
				}
			}
		}
		
		for($p=1;$p<6;$p++)
		{
			if(isset($time_orders[$p]))
			{
				$sql="update gyftr_order_detail set contri_notif='".$p."' where id IN (".implode(',',$time_orders[$p]).")";
				$this->Order->query($sql);
			}
		}
		
		die;
		
	}
	
	
	public function sendInviteSMS($phone, $section, $arr=array())
	{
		 $this->autoRender=false;
        $contents = $this->Mail->findBySection($section);
        if(is_array($contents)){
       
        $content = $contents['Mail']['content'];
		
        foreach ($arr as $key => $val)
            $content = str_replace("~~$key~~", $val, $content);
		if(!empty($arr['TO_PHONE']))
		{ 
			$url="http://bulkpush.mytoday.com/BulkSms/SingleMsgApi?feedid=".urlencode('338500')."&username=".urlencode('9818015215')."&password=".urlencode('pjttw')."&To=".urlencode($arr['TO_PHONE'])."&Text=".urlencode($content)."&time=&senderid=";
		//echo $url; die;	
	
		$ch = curl_init();	
		curl_setopt($ch, CURLOPT_POST, 0);		
		curl_setopt($ch,CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
		$result=curl_exec($ch);	
			
		curl_close($ch);	
		}
		}
		return;	
	}
	
	
	public function delete_corrupt_orders()
	{
		$this->Order->primaryKey='session_id';
		$this->Order->bindModel(array('hasMany' => array('Basket' => array('className' => 'Basket','foreignKey' => 'session_id'))),false);
		$orders=$this->Order->find('all',array('conditions'=>array('OR'=>array('Order.to_name'=>'','Order.to_email'=>'','Order.to_phone'=>'','Order.delivery_time'=>''))));	
		//pr($orders); die;
		$this->Order->primaryKey='id';
		foreach($orders as $ord)
		{
			if($ord['Order']['group_gift_id']!='0')
			{
				$group=$this->GroupGift->find('all',array('conditions'=>array('GroupGift.group_gift_id'=>$ord['Order']['group_gift_id'])));
				if(!empty($group))
				{
					foreach($group as $gp)
					{
						$this->GroupGift->delete($gp['GroupGift']['id']);	
					}
				}
			}
			if(!empty($ord['Basket']))
			{
				foreach($ord['Basket'] as $bask)
				{
					$this->Basket->delete($bask['id']);
				}
			}
			
			$this->Order->delete($ord['Order']['id']);
		}
		
		echo 'success'; die;
		
	}
	
	
	
	public function sample()     ///Test function....Not used/////
	{			
		$date=date("Y-m-d H:i:s");
		echo date("Y-m-d H:i:s",(strtotime($date)+300)).'<br>';
		echo  $date;
		die;
	}
	
		
	 
	 
	 
}