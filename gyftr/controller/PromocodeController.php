<?php
App::import('Vendor', array('functions','excel-lib/Classes/PHPExcel'));
class PromocodeController extends AppController {

	public $name = 'Promocode';
	public $helpers = array('Form', 'Html','Js' => array('Jquery'));
	public $components=array('Session','Access');
	public $uses=array('Promocode','GiftBrand','BrandProduct','Basket','Order','UserPromo','User','GenericPromoCode');

	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Access->isValidUser();	
		$this->layout='admin';					
	}

	
	public function admin_index($promo_type=1)
	{		
		switch($promo_type)
		{
			case 1: $promo_name='Basket Amount'; break;	
			case 2: $promo_name='Brand'; 
				
				$this->Promocode->bindModel(array('belongsTo' => array('GiftBrand' => array('className' => 'GiftBrand','foreignKey' => 'brand_id'))),false);
					break;	
			case 3: $promo_name='Voucher'; 
				$this->Promocode->bindModel(array('belongsTo' => array('BrandProduct' => array('className' => 'BrandProduct','foreignKey' => 'product_id'))),false);
			break;	
			case 4: $promo_name='Transaction Amount'; break;	
			case 5: $promo_name='Season'; break;	
			case 6: $promo_name='Occasion'; break;	
			case 7: $promo_name='Registration'; break;	
			case 8: $promo_name='Gifting Type'; break;
			case 9: $promo_name='Payment'; break;
			case 10: $promo_name='General'; 
						$this->Promocode->bindModel(array('belongsTo' => array('GiftBrand' => array('className' => 'GiftBrand','foreignKey' => 'brand_id'))),false);
						break;	
		}
		
		$this->paginate=array('conditions'=>array('Promocode.promo_type'=>$promo_type));
		$promo=$this->paginate('Promocode');
		
		$this->Promocode->unbindModel(array('belongsTo' => array('GiftBrand')));
		$this->Promocode->unbindModel(array('belongsTo' => array('BrandProduct')));
		$this->set('promo_name',$promo_name);
		$this->set('promo_type',$promo_type);
		$this->set('promo',$promo);
	}
	
	public function admin_add_promocode()
	{		
		if(!empty($this->data))
		{
			if($this->data['Promocode']['promo_type']==10)
			{
				$data=$this->data;
				//pr($data); die;
				
				if($data['GenericPromoCode']['no_of_times']==0)
					$data['GenericPromoCode']['no_of_times']=50000;
				
				$arr=array('promo_type'=>$data['Promocode']['promo_type'],'brand_id'=>$data['Promocode']['brand_id'],'discount_type'=>$data['Promocode']['discount_type'],'value'=>$data['Promocode']['value'],'start_date'=>$data['Promocode']['start_date'],'end_date'=>$data['Promocode']['end_date'],'no_of_times'=>$data['GenericPromoCode']['no_of_times'],'created'=>date("Y-m-d H:i:s"),'status'=>'Active','valid_for'=>'');
				//pr($arr); die;
				$this->Promocode->create();
				$promo=$this->Promocode->save($arr);
				$arr['promocode_id']=$promo['Promocode']['id'];
				$arr['valid_for']=$data['Promocode']['end_date'].' 23:59:59';
				
				
				if($data['Promocode']['general_promo_type']==1)   // Multiple Codes
				{
					$this->generate_promo_code($arr,$data['GenericPromoCode']['no_of_codes']);				
					
				}else{								//Single Generic code
					//$arr['no_of_times']=0;
					$this->generate_promo_code($arr,1);	
				}
				$this->redirect(array('controller'=>'promocode','action'=>'generated_promo_code',$arr['promocode_id'],'admin'=>true));
				
						
			}else{
				
				$this->request->data['Promocode']['status']='Active';
				$this->request->data['Promocode']['created']=date("Y-m-d H:i:s");
				
				$this->Promocode->create();
				if($this->Promocode->save($this->data))
				{
					$this->Session->setFlash(__('New Promo Code added successfully.'));
				}else{
					$this->Session->setFlash(__('Error occurred. Promo code not added!'));	
				}
				$this->redirect(array('action'=>'index','admin'=>true));		
			}
			
		}else{
			$this->GiftBrand->bindModel(array('belongsTo' => array('GiftCategory' => array('className' => 'GiftCategory','foreignKey' => 'gift_category_id'))),false);
			$brands=$this->GiftBrand->find('all',array('group'=>array('GiftBrand.name'),'fields'=>array('GiftBrand.id','GiftBrand.name','GiftBrand.gift_category_id','GiftCategory.*')));
			$products=$this->BrandProduct->find('all',array('group'=>array('BrandProduct.product_guid'),'fields'=>array('BrandProduct.id','BrandProduct.voucher_name','BrandProduct.product_guid'),'order'=>array('BrandProduct.product_name ASC')));
			
			$this->set('brands',$brands);
			$this->set('products',$products);
		}
	}
	
	
	public function admin_generated_promo_code($promo_id)
	{
		$codes=$this->GenericPromoCode->find('all',array('conditions'=>array('GenericPromoCode.promocode_id'=>$promo_id)));
		$promo=$this->Promocode->findById($promo_id);
		if(!empty($codes))
		{
			$brand=$this->GiftBrand->find('first',array('conditions'=>array('GiftBrand.id'=>$codes[0]['GenericPromoCode']['brand_id'])));
			$this->set('brand',$brand);	
		}
		$this->set('codes',$codes);
		$this->set('promo',$promo);
		$this->render('admin_generated_promo_code');	
	}
	
	
	public function generate_promo_code($arr,$num)
	{
		$data=array();
		$brand=$this->getpromo_initials($arr['brand_id']);
		for($i=0;$i<$num;$i++)
		{
			$data[$i]=$arr;
			$data[$i]['promo_code']=$brand.$this->generateRandomString(8);			
		}
		$this->GenericPromoCode->create();
		$this->GenericPromoCode->saveAll($data);	
		return;
	}
	
	public function getpromo_initials($id)
	{
		$brand=$this->GiftBrand->findById($id);
		$chars=substr($brand['GiftBrand']['name'],0,3);
		return strtoupper($chars);	
	}
	
	
	public function admin_export_promo_codes($promo_id)
	{
		$this->autoRender=false;	
		$codes=$this->GenericPromoCode->find('all',array('conditions'=>array('GenericPromoCode.promocode_id'=>$promo_id)));
		$brand=$this->GiftBrand->find('first',array('conditions'=>array('GiftBrand.id'=>$codes[0]['GenericPromoCode']['brand_id'])));
		$data=array(); $i=1;
			$data[0][0]='S.No.';
			$data[0][1]='Promo Code';
			$data[0][2]='Brand';
			$data[0][3]='Discount Value';
			$data[0][4]='Discount Type';
			$data[0][5]='Valid Till';
		foreach($codes as $us)
		{
			$data[$i][0]=$i;
			$data[$i][1]=$us['GenericPromoCode']['promo_code'];
			$data[$i][2]=$brand['GiftBrand']['name'];
			$data[$i][3]=$us['GenericPromoCode']['value'];
			$data[$i][4]=$us['GenericPromoCode']['discount_type'];
			$data[$i][5]=show_formatted_datetime($us['GenericPromoCode']['end_date']);
			$i++;	
		}
		$filename='PromoCodes.xls';
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
		
		$objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:F1")->applyFromArray(array("font" => array( "bold" => true)));			
		$objPHPExcel->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	
	}
	
	
	public function admin_delete_promocode($id=null)
	{
		$this->Promocode->id = $id;
		if (!$this->Promocode->exists()) {
			throw new NotFoundException(__('Invalid contest'));
		}
		if($this->Promocode->delete($id))
		{		
			$this->GenericPromoCode->deleteAll(array('GenericPromoCode.promocode_id' => $id),false);
			$this->Session->setFlash(__('Promo Code deleted'));
		}else{
			$this->Session->setFlash(__('Promo Code was not deleted'));
		}
		$this->redirect(array('action' => 'index','admin'=>true));	
	}
	
	public function admin_status_promocode($id,$status)
	{
		$this->Promocode->id = $id;
		if (!$this->Promocode->exists()) {
			throw new NotFoundException(__('Invalid contest'));
		}
		$this->Promocode->saveField('status',$status);	
		$this->redirect(array('action' => 'index','admin'=>true));	
	}
	
	public function admin_test()
	{
		$ord_id=1; $user_id=19; $type=1;
		$date=date("Y-m-d");
		$this->Order->recursive=2;
		$this->Order->primaryKey='session_id';
		$this->Basket->primaryKey='product_guid';
		$this->Basket->bindModel(array('hasOne' => array('BrandProduct' => array('className' => 'BrandProduct','foreignKey' => 'product_guid','fields'=>array('BrandProduct.product_guid','BrandProduct.gift_brand_id','BrandProduct.product_name','BrandProduct.voucher_name','BrandProduct.price')))),false);
		
		$this->Order->bindModel(array('hasMany' => array('Basket' => array('className' => 'Basket','foreignKey' => 'session_id')),
									  'belongsTo'=>array('User'=>array('className'=>'User','foreignKey'=>'from_id'))),false);
									  
		$order=$this->Order->find('first',array('conditions'=>array('Order.id'=>$ord_id)));
		$brands=$products=$apply=array(); 
		foreach($order['Basket'] as $bask)
		{			
			$products[]=$bask['BrandProduct']['product_guid'];	
			if(!in_array($bask['BrandProduct']['gift_brand_id'],$brands))
				$brands[]=$bask['BrandProduct']['gift_brand_id']; 			
		}
		
		if($type==1)   //Other than transaction, Registration
		{
			$promo=$this->Promocode->find('all',array('conditions'=>array('Promocode.status'=>'Active','Promocode.start_date <='=>date("Y-m-d"),'Promocode.end_date >'=>date("Y-m-d"))));
		}else if($type==2)			//Transaction
		{
			$promo=$this->Promocode->find('all',array('conditions'=>array('Promocode.status'=>'Active','Promocode.start_date <='=>date("Y-m-d"),'Promocode.end_date >'=>date("Y-m-d"),'Promocode.promo_type'=>4)));	
		}else if($type==3)     // On Registration
		{
			$promo=$this->Promocode->find('all',array('conditions'=>array('Promocode.status'=>'Active','Promocode.start_date <='=>date("Y-m-d"),'Promocode.end_date >'=>date("Y-m-d"),'Promocode.promo_type'=>7)));		
		}
		
		$i=0;
		foreach($promo as $pr)
		{
			switch($pr['Promocode']['promo_type'])
			{
				case 1: if($order['Order']['total_amount']>$pr['Promocode']['basket_amount'])		//Basket Amount
						{
							$apply[$i]['promo_id']=$pr['Promocode']['id'];
							$apply[$i]['user_id']=$user_id;
							$apply[$i]['order_id']=$order['Order']['id'];
							$apply[$i]['promo_code']='BA'.$user_id.$this->generateRandomString(5);	
							$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
							$apply[$i]['created']=date("Y-m-d H:i:s");
							$i++;
						}	
						break;
				case 2: if(in_array($pr['Promocode']['brand_id'],$brands))							//Brand
						{
							$apply[$i]['promo_id']=$pr['Promocode']['id'];
							$apply[$i]['user_id']=$user_id;
							$apply[$i]['order_id']=$order['Order']['id'];
							$apply[$i]['promo_code']='BR'.$user_id.$this->generateRandomString(5);	
							$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
							$apply[$i]['created']=date("Y-m-d H:i:s");
							$i++;
						}
						break;
				case 3: if(in_array($pr['Promocode']['product_id'],$products))						//Voucher
						{
							$apply[$i]['promo_id']=$pr['Promocode']['id'];
							$apply[$i]['user_id']=$user_id;
							$apply[$i]['order_id']=$order['Order']['id'];
							$apply[$i]['promo_code']='VR'.$user_id.$this->generateRandomString(5);	
							$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
							$apply[$i]['created']=date("Y-m-d H:i:s");
							$i++;	
						}
						break;
				case 4: if($order['User']['transaction_promo'] < $pr['Promocode']['transaction_amount'])	//Transaction Amount
						{
							$apply[$i]['promo_id']=$pr['Promocode']['id'];
							$apply[$i]['user_id']=$user_id;
							$apply[$i]['order_id']=0;
							$apply[$i]['promo_code']='TA'.$user_id.$this->generateRandomString(5);	
							$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
							$apply[$i]['created']=date("Y-m-d H:i:s");
							$i++;		
						}
						break;	
				case 5:		$apply[$i]['promo_id']=$pr['Promocode']['id'];							//Season
							$apply[$i]['user_id']=$user_id;
							$apply[$i]['order_id']=0;
							$apply[$i]['promo_code']='SN'.$user_id.$this->generateRandomString(5);	
							$apply[$i]['valid_upto']=$pr['Promocode']['end_date'].' 23:59:59';
							$apply[$i]['created']=date("Y-m-d H:i:s");
							$i++;	 
							break; 													
				case 6: if(strtolower(trim($order['Order']['occasion']))==strtolower(trim($pr['Promocode']['basket_amount'])))		//Occasion
						{
							$apply[$i]['promo_id']=$pr['Promocode']['id'];
							$apply[$i]['user_id']=$user_id;
							$apply[$i]['order_id']=$order['Order']['id'];
							$apply[$i]['promo_code']='OC'.$user_id.$this->generateRandomString(5);	
							$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
							$apply[$i]['created']=date("Y-m-d H:i:s");
							$i++;			
						}	
						break;
				case 7: 	$apply[$i]['promo_id']=$pr['Promocode']['id']; 							//On Registration	
							$apply[$i]['user_id']=$user_id;
							$apply[$i]['order_id']=0;
							$apply[$i]['promo_code']='OR'.$user_id.$this->generateRandomString(5);	
							$apply[$i]['valid_upto']=$pr['Promocode']['end_date'].' 23:59:59';
							$apply[$i]['created']=date("Y-m-d H:i:s");
							$i++;	
							break;																		
				case 8: if(trim($order['Order']['type'])==trim($pr['Promocode']['basket_amount']))		//gifting type
						{
							$apply[$i]['promo_id']=$pr['Promocode']['id'];
							$apply[$i]['user_id']=$user_id;
							$apply[$i]['order_id']=$order['Order']['id'];
							$apply[$i]['promo_code']='GT'.$user_id.$this->generateRandomString(5);	
							$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
							$apply[$i]['created']=date("Y-m-d H:i:s");
							$i++;	
						}	
						break;
						
				case 9: 	$apply[$i]['promo_id']=$pr['Promocode']['id']; 							//On Payment	
							$apply[$i]['user_id']=$user_id;
							$apply[$i]['order_id']=0;
							$apply[$i]['promo_code']='OR'.$user_id.$this->generateRandomString(5);	
							$apply[$i]['valid_upto']=$pr['Promocode']['end_date'].' 23:59:59';
							$apply[$i]['created']=date("Y-m-d H:i:s");
							$i++;	
							break;										
									
			}
		}
			
		$this->UserPromo->create();
		$this->UserPromo->saveAll($apply);
		die;	
	}
	
	
	public function generateRandomString($length = 5) {
   		 return substr(str_shuffle("23456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ"), 0, $length);
	}
	
	
	public function give_promocode($ord_id,$user_id,$type)    // type = 1 order related promo// 2= transaction related 3= User Registrstion //4=payment
	{
		$date=date("Y-m-d");
		$user=$this->User->findById($user_id);
		if($type==1)
		{
			$this->Order->recursive=2;
			$this->Order->primaryKey='session_id';
			$this->Basket->primaryKey='product_guid';
			$this->Basket->bindModel(array('hasOne' => array('BrandProduct' => array('className' => 'BrandProduct','foreignKey' => 'product_guid','fields'=>array('BrandProduct.product_guid','BrandProduct.gift_brand_id','BrandProduct.product_name','BrandProduct.voucher_name','BrandProduct.price')))),false);
			
			$this->Order->bindModel(array('hasMany' => array('Basket' => array('className' => 'Basket','foreignKey' => 'session_id')),
										  'belongsTo'=>array('User'=>array('className'=>'User','foreignKey'=>'from_id'))),false);
										  
			$order=$this->Order->find('first',array('conditions'=>array('Order.id'=>$ord_id)));
			$brands=$products=$apply=array(); 
			foreach($order['Basket'] as $bask)
			{			
				$products[]=$bask['BrandProduct']['product_guid'];	
				if(!in_array($bask['BrandProduct']['gift_brand_id'],$brands))
					$brands[]=$bask['BrandProduct']['gift_brand_id']; 			
			}
		}
		
		
		if($type==1)   //Other than transaction, Registration, Payment
		{
			$promo=$this->Promocode->find('all',array('conditions'=>array('Promocode.status'=>'Active','Promocode.start_date <='=>date("Y-m-d"),'Promocode.end_date >'=>date("Y-m-d"),'NOT'=>array('Promocode.promo_type'=>array('4','7','9')))));
		}else if($type==2)			//Transaction
		{
			$promo=$this->Promocode->find('all',array('conditions'=>array('Promocode.status'=>'Active','Promocode.start_date <='=>date("Y-m-d"),'Promocode.end_date >'=>date("Y-m-d"),'Promocode.promo_type'=>4)));	
		}else if($type==3)     // On Registration
		{
			$promo=$this->Promocode->find('all',array('conditions'=>array('Promocode.status'=>'Active','Promocode.start_date <='=>date("Y-m-d"),'Promocode.end_date >'=>date("Y-m-d"),'Promocode.promo_type'=>7)));		
		}else if($type==4)			// On Payment
		{
			$promo=$this->Promocode->find('all',array('conditions'=>array('Promocode.status'=>'Active','Promocode.start_date <='=>date("Y-m-d"),'Promocode.end_date >'=>date("Y-m-d"),'Promocode.promo_type'=>9)));		
		}
		
		$i=0; $code='';
		if(!empty($promo))
		{
		foreach($promo as $pr)
		{
			
			switch(intval($pr['Promocode']['promo_type']))
			{
				case '1': 	if(intval($order['Order']['total_amount'])>=$pr['Promocode']['basket_amount'])		//Basket Amount
							{								
								$apply[$i]['promo_id']=$pr['Promocode']['id'];
								$apply[$i]['user_id']=$user_id;
								$apply[$i]['order_id']=$order['Order']['id'];
								$apply[$i]['promo_code']='BA'.$user_id.$this->generateRandomString(5);	
								$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
								$apply[$i]['created']=date("Y-m-d H:i:s");								
								$i++;
							}	
							break;
				case '2': if(in_array($pr['Promocode']['brand_id'],$brands))							//Brand
							{
								$apply[$i]['promo_id']=$pr['Promocode']['id'];
								$apply[$i]['user_id']=$user_id;
								$apply[$i]['order_id']=$order['Order']['id'];
								$apply[$i]['promo_code']='BR'.$user_id.$this->generateRandomString(5);	
								$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
								$apply[$i]['created']=date("Y-m-d H:i:s");
								$i++;
							}
							break;
				case '3': if(in_array($pr['Promocode']['product_id'],$products))						//Voucher
							{
								$apply[$i]['promo_id']=$pr['Promocode']['id'];
								$apply[$i]['user_id']=$user_id;
								$apply[$i]['order_id']=$order['Order']['id'];
								$apply[$i]['promo_code']='VR'.$user_id.$this->generateRandomString(5);	
								$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
								$apply[$i]['created']=date("Y-m-d H:i:s");
								$i++;	
							}
							break;
				case '4': 	if(intval($user['User']['total_transaction']) > $pr['Promocode']['transaction_amount'])			//Transaction Amount
							{
								if($order['User']['transaction_promo'] < $pr['Promocode']['transaction_amount'])	//check if promo already given
								{
									$apply[$i]['promo_id']=$pr['Promocode']['id'];
									$apply[$i]['user_id']=$user_id;
									$apply[$i]['order_id']=0;
									$apply[$i]['promo_code']='TA'.$user_id.$this->generateRandomString(5);	
									$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
									$apply[$i]['created']=date("Y-m-d H:i:s");
									$i++;		
								}
							}
							break;	
				case '5':	$apply[$i]['promo_id']=$pr['Promocode']['id'];							//Season
							$apply[$i]['user_id']=$user_id;
							$apply[$i]['order_id']=0;
							$apply[$i]['promo_code']='SN'.$user_id.$this->generateRandomString(5);	
							$apply[$i]['valid_upto']=$pr['Promocode']['end_date'].' 23:59:59';
							$apply[$i]['created']=date("Y-m-d H:i:s");
							$i++;	 
							break; 													
				case '6': if(strtolower(trim($order['Order']['occasion']))==strtolower(trim($pr['Promocode']['basket_amount'])))		//Occasion
							{
								$apply[$i]['promo_id']=$pr['Promocode']['id'];
								$apply[$i]['user_id']=$user_id;
								$apply[$i]['order_id']=$order['Order']['id'];
								$apply[$i]['promo_code']='OC'.$user_id.$this->generateRandomString(5);	
								$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
								$apply[$i]['created']=date("Y-m-d H:i:s");
								$i++;			
							}	
							break;
				case '7': 	$apply[$i]['promo_id']=$pr['Promocode']['id']; 							//On Registration	
							$apply[$i]['user_id']=$user_id;
							$apply[$i]['order_id']=0;
							$apply[$i]['promo_code']='OR'.$user_id.$this->generateRandomString(5);	
							$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
							$apply[$i]['created']=date("Y-m-d H:i:s");
							$i++;	
							break;																		
				case '8': if(trim($order['Order']['type'])==trim($pr['Promocode']['gifting_type']))		//gifting type
							{
								$apply[$i]['promo_id']=$pr['Promocode']['id'];
								$apply[$i]['user_id']=$user_id;
								$apply[$i]['order_id']=$order['Order']['id'];
								$apply[$i]['promo_code']='GT'.$user_id.$this->generateRandomString(5);	
								$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
								$apply[$i]['created']=date("Y-m-d H:i:s");
								$i++;	
							}	
							break;	
				case '9': 	$apply[$i]['promo_id']=$pr['Promocode']['id']; 							//On Payment	
							$apply[$i]['user_id']=$user_id;
							$apply[$i]['order_id']=0;
							$apply[$i]['promo_code']='OR'.$user_id.$this->generateRandomString(5);	
							$apply[$i]['valid_upto']=date("Y-m-d",strtotime($date."+".$pr['Promocode']['valid_for']." days")).' 23:59:59';
							$apply[$i]['created']=date("Y-m-d H:i:s");
							$code=$apply[$i]['promo_code'];
							$i++;	
							break;					
									
			}
		}		
				
			if(!empty($apply))
			{
				$this->UserPromo->create();
				$this->UserPromo->saveAll($apply);
			}
		}
		return $code;	
	}
	
	public function admin_test2()
	{
		$temp='2013-08-22 23:59:59';
		$date=date("Y-m-d H:i:s");
		$hours=(strtotime($temp)-strtotime(date("Y-m-d H:i:s")))/3600/24;			
		pr($hours); die;
	}
	
}