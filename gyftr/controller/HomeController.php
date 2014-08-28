<?php

App::import('Lib', array('Facebook/facebook'));
App::import('Vendor', array('functions', 'xml_regex'));
App::import('Controller', array('Users', 'Mail','Cron','Promocode'));

class HomeController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session','Access');
    public $uses = array('GiftCategory', 'GiftBrand', 'BrandProduct', 'Voucher', 'User', 'Order', 'Product', 'GroupGift', 'Voucherinfo', 'PropUser', 'Basket', 'Shops', 'Mail','Payment','UserPromo','Promocode','Points','Offer','VoucherLog');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index($id=0,$pay_param=0) {
      
		if(!empty($this->data))
		{			
			if($pay_param=='success')
			{				
				if($this->Session->check('hash_sequence'))
				{					
					$this->request->data=$this->data;
					$txn=$this->data['txnid'];
					if($this->Session->read('txn_id')==$txn)
					{					
						$this->Session->delete('txn_id');				
						$this->update_after_payment(1);
					}else{
						$this->Session->delete('txn_id');
						$this->redirect(SITE_URL);
					}
				}else{					
					$this->redirect(SITE_URL);	
				}					
			}else{
					$hash=$this->Session->read('hash_sequence');					
					$this->request->data=$this->data;
					$this->update_after_payment($hash);	
			}			
		}
		$qrydata = $this->request->query;
		if(isset($qrydata['url']))
			unset($qrydata['url']);
		
        if (!empty($qrydata)&&!isset($this->data['mihpayid'])) {
            	
            $reqid = '';
            if (!array_key_exists('req_gpuser_id', $qrydata)) {
                if (isset($qrydata['request_ids'])) {
                    $reqid = $this->get_req_id($qrydata['request_ids']);
                    $req_gpuser_id = '0';
                }
            } else {
                $reqid = $qrydata['request_id'];
                $req_gpuser_id = $qrydata['req_gpuser_id'];
            }
            $this->redirect(array('controller' => 'home', 'action' => 'user_index', $reqid, $req_gpuser_id));
        }  
		
        $this->Session->delete('Gifting');       
        $this->set('show_terms_id', $id);       
    }
	
	public function gift_type()
	{
		$this->set('gift_type','1');
		$this->set('show_terms_id','0');
		$this->render('index');	
	}
	
	public function update_after_payment($hash=0)
	{ 
		if($hash==0)
		{			
			$this->redirect(SITE_URL);
		}else{
			$this->Session->delete('hash_sequence');
			$data=$this->data;
		if(strtolower($data['status'])=='success'||strtolower($data['status'])=='pending')
		{
			$arr=array('user_id'=>$data['udf2'],'order_id'=>$data['udf1'],'payment_type'=>1,'gpuser_id'=>$data['udf3'],'payUID'=>$data['mihpayid'],'mode'=>$data['mode'],'txnid'=>$data['txnid'],'pg_type'=>$data['PG_TYPE'],'bank_ref_num'=>$data['bank_ref_num'],'value'=>$data['amount'],'created_date'=>date("Y-m-d H:i:s"),'user_ip'=>$_SERVER['REMOTE_ADDR']);
			$this->Payment->create();
			$paid=$this->Payment->save($arr);
			
			$order=$this->Order->findById($paid['Payment']['order_id']);			
			$new_paid=$order['Order']['amount_paid']+$paid['Payment']['value'];			
			$paystatus=0; $status=2;
			
			if($new_paid >= $order['Order']['total_amount'])
			{
				$paystatus=1; $status=0;	
			}
			$this->Order->id=$paid['Payment']['order_id'];
			$this->Order->save(array('amount_paid'=>$new_paid,'payment_status'=>$paystatus,'status'=>$status));			
			$last_paid=0;
			if($paystatus==1)
			{
				$last_paid=1;	
			}
			if($data['udf3']!=0)
			{
				$gpuser=$this->GroupGift->findById($paid['Payment']['gpuser_id']);
				$this->GroupGift->id=$gpuser['GroupGift']['id'];				
				$this->GroupGift->save(array('contri_amount_paid'=>($gpuser['GroupGift']['contri_amount_paid']+$paid['Payment']['value']),'last_paid'=>$last_paid));				
			}
			$user_data=$this->User->findById($data['udf2']);			
			
			$total_transact=$user_data['User']['total_transaction']+$paid['Payment']['value'];
			$this->User->id=$user_data['User']['id'];
			$this->User->saveField('total_transaction',$total_transact);
			$PromoCode = new PromocodeController;
           	$PromoCode->constructClasses();
			$PromoCode->give_promocode('0',$user_data['User']['id'],'2');
			$code=$PromoCode->give_promocode('0',$user_data['User']['id'],'4');		//Payment
			$this->sendPaymentRecivedMail($user_data['User']['id'],$paid['Payment']['value'],$paid['Payment']['order_id'],$code);
			$this->set('order_id',$paid['Payment']['order_id']);			
							
		}else{
				$this->set('isPayError','1');				
		}		
		$this->set('redirectFromPay','1');		
		$this->render('index');	
		}
		unset($this->request->data);
		
	}
	
	
	public function sendPaymentRecivedMail($user_id,$pay_amount,$ord_id,$code)
	{		
		$Mail = new MailController;
        $Mail->constructClasses();
		$arr = array();
		$user=$this->User->findById($user_id);	
		$order=$this->Order->findById($ord_id);
		$promo_discount=$this->Promocode->find('first',array('conditions'=>array('Promocode.promo_type'=>'9'),'fields'=>array('Promocode.discount_type','Promocode.value')));
		if(!empty($promo_discount))
		{
		if($promo_discount['Promocode']['discount_type']=='PureValue')
				$discount='Rs. '.$promo_discount['Promocode']['value'];
			else
				$discount=$promo_discount['Promocode']['value'].'%';
		}else{
			$discount='25%';	
		}
				
			
		$arr['TO_NAME'] = $user['User']['first_name'].' '.$user['User']['last_name'];
		$arr['SUB_NAME'] = $user['User']['first_name'].' '.$user['User']['last_name'];
		$arr['TO_EMAIL'] = $user['User']['email'];
		$arr['PROMO_CODE'] = $code;
		$arr['DISCOUNT'] = $discount;
		$arr['OCCASION'] = $order['Order']['occasion'];
		$arr['RECIPIENT'] = $order['Order']['to_name'];
		$arr['INITIATOR'] = $order['Order']['from_name'];
		$arr['DISCOUNT'] = $discount;		
		$arr['HOURS'] = '72 ';
		if($order['Order']['group_gift_id']!=0&&$order['Order']['group_gift_id']!='')
		{
			$arr['SET_UP_BY'] = ' which was set up by '.$arr['INITIATOR'];	
		}else{
			$arr['SET_UP_BY'] = '.';	
		}
		$arr['REDEEM'] = '<a href="'.SITE_URL.'">Click here </a>';
		$arr['AMOUNT'] = $pay_amount;				
		$Mail->sendMail($user['User']['id'], 'payment_received_mail', $arr);
		return; 
	}
	
	
    public function get_req_id($qrydata) {
        $temp = explode(',', $qrydata);
        $num = count($temp);
        $num = $num - 1;       
        return $temp[$num];
    }

    public function user_index($reqid, $req_gpuser_id) {
        $this->Session->write('reqid', $reqid);
        if ($req_gpuser_id == 0)
            $this->getfb();
        else
            $this->redirect(array('controller' => 'home', 'action' => 'connect_gpuser', $reqid, $req_gpuser_id));       		
    }

    public function getfb() {
        if (empty($_REQUEST['code'])) {
            $dialog_url = "http://graph.facebook.com/oauth/authorize?client_id="
                    . FB_APPID . "&redirect_uri=" . urlencode(SITE_URL . "/home/getfb") . "&display=touch&scope=email,read_mailbox,publish_stream,user_location,offline_access";
            echo("<html><body><script> top.location.href='" . $dialog_url . "'</script></body></html>");
        } else {

            $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
                    . FB_APPID . "&client_secret="
                    . FB_APPSECRET . "&code=" . $_REQUEST['code'] . "&redirect_uri=" . urlencode(SITE_URL . "/home/getfb") . "&display=touch";

            $access_token = file_get_contents($token_url);
            $graph_url = "https://graph.facebook.com/me?" . $access_token;

            $user = json_decode(file_get_contents($graph_url));
            $reqid = $this->Session->read('reqid');
            $request_content = json_decode(file_get_contents("https://graph.facebook.com/$reqid?$access_token"), TRUE);
            $this->Session->write('gpuser_fb_data', $user);
           
            $this->redirect(array('controller' => 'home', 'action' => 'connect_gpuser', $request_content['data'], '0'));
        }
    }

    public function connect_gpuser($reqdata, $type, $other_user_id=0,$gpuser_id=0) {      //type=user return from fb=>0 or email=>gpuser_id //other_user_id!=0 => function accessed from profile page 
	
	$user_id = $this->Session->read('User.User.id');
	$user_data=$this->User->findById($user_id);
	 $is_register=0;
	if($gpuser_id==0)
	{       
		if ($other_user_id == 0) {
            $User = new UsersController;
            $User->constructClasses();
           			
            if ($type != 0) {
                $gpuser = $this->GroupGift->findById($type);
                $fr = $gpuser['GroupGift'];
            } else {
                $fr = $this->Session->read('gpuser_fb_data');				
            }
            $id = $User->createUser($fr);
			
			if($this->Session->check('is_registered_user'))   //to check if user already exist in system for redirection to register page
			{
				 $is_register=1;
				 $this->Session->delete('is_registered_user');	
			}else{
				 $is_register=0;
			}
            $user_data = $this->User->findById($id);
            if ($type == 0) {
                $gpuser = $this->GroupGift->find('first', array('conditions' => array('GroupGift.group_gift_id' => $reqdata, 'GroupGift.fb_id' => $user_data['User']['fb_id'])));
            }
            	
            $this->GroupGift->id = $gpuser['GroupGift']['id'];
            $this->GroupGift->saveField('other_user_id', $user_data['User']['id']);
			
        } else {
			$sql='update gyftr_group_gift_users set other_user_id="'.$other_user_id.'" where email="'.$user_data['User']['email'].'" and group_gift_id="'.$reqdata.'"';
			$this->GroupGift->query($sql);			
            $gpuser = $this->GroupGift->find('first', array('conditions' => array('GroupGift.other_user_id' => $other_user_id, 'GroupGift.group_gift_id' => $reqdata)));
        }
		$group = $this->GroupGift->find('all', array('conditions' => array('GroupGift.group_gift_id' => $gpuser['GroupGift']['group_gift_id'])));
        $order = $this->Order->findById($gpuser['GroupGift']['order_id']);
	}else{
		$gpgift_id=$this->GroupGift->find('first',array('conditions'=>array('GroupGift.id'=>$gpuser_id)));
		$group = $this->GroupGift->find('all', array('conditions' => array('GroupGift.group_gift_id' => $gpgift_id['GroupGift']['group_gift_id'])));
       
        $order = $this->Order->findById($gpgift_id['GroupGift']['order_id']);
		
	}

        $this->Session->write('User',$user_data);
        $startedbyUser = $this->User->findById($order['Order']['from_id']);
        $this->get_basket_details($order['Order']['id']);
        $this->set('group', $group);
        $this->set('order', $order);
        $this->set('type', $type);
        $this->set('user', $user_data);
        $this->set('startedbyUser', $startedbyUser);
			
		if(empty($user_data['User']['last_name'])||empty($user_data['User']['phone'])||empty($user_data['User']['email'])||empty($user_data['User']['dob']))
			$is_register=0;
			
        if ($other_user_id != 0) {
            $this->render('show_gpuser_contributed_in');
        } else {
			if($is_register==1)
            {	$this->render('gpusers_status_page');
			}else{	
				$this->set('is_register','1');
				$this->render('index');
			}
        }
    }

    public function admin_index() {
        $this->layout = 'admin';
    }

    public function get_category_list() {
        $arr = $this->GiftCategory->find('all', array('conditions' => array('GiftCategory.status' => '1')));
        return $arr;
    }

    public function get_category_product($id=0) {
        if ($id == '000') {
            $arr = $this->GiftBrand->find('all', array('conditions' => array('GiftBrand.active' => '1')));
        } else {
            $arr = $this->GiftBrand->find('all', array('conditions' => array('GiftBrand.gift_category_id' => $id, 'GiftBrand.active' => '1')));
        }
        return $arr;
    }

    public function get_product_details($id=0) {		

		$arr = $this->BrandProduct->find('all', array('conditions' => array('BrandProduct.gift_brand_id' => $id,'BrandProduct.available_qty >'=>0)));
		$offers=$this->Offer->find('all',array('conditions'=>array('Offer.start_date <='=>date("Y-m-d"),'Offer.end_date >='=>date("Y-m-d"),'Offer.status'=>'Active')));
		$off_prod_ids=$off_brand_ids=array();
		if(!empty($offers))
		{			
			foreach($offers as $off)
			{
				if(!empty($off['Offer']['brand_product_id']))
					$off_prod_ids[]=$off['Offer']['brand_product_id'];
				else	
					$off_brand_ids[]=$off['Offer']['gift_brand_id'];
			}
		}		
		
		$all_flag=0;
		if(in_array($id,$off_brand_ids))
			$all_flag=1;		
		
		$prod_array=array(); $i=0;
		foreach($arr as $ar)
		{
			$temp=$this->Basket->find('count',array('conditions'=>array('Basket.product_guid'=>$ar['BrandProduct']['product_guid'])));
			//if(($ar['BrandProduct']['available_qty']-$temp)>0)
			//{
				$prod_array[$i]=$ar;
				if($all_flag==1)
				{
					$value=$this->get_discounted_value($ar['BrandProduct']['gift_brand_id'],1,$ar['BrandProduct']['price']);
						
				}else if(in_array($ar['BrandProduct']['id'],$off_prod_ids)){
					$value=$this->get_discounted_value($ar['BrandProduct']['id'],2,$ar['BrandProduct']['price']);	
				}else{
					$value=$ar['BrandProduct']['price'];
				}
				$prod_array[$i]['BrandProduct']['price']=$value;
				$i++;	
			//}	
		}
		
        return $prod_array;
    }
	
	public function get_discounted_value($id,$type,$price)
	{
		if($type==1)
		{
			$offer=$this->Offer->find('first',array('conditions'=>array('Offer.gift_brand_id'=>$id,'Offer.start_date <='=>date("Y-m-d"),'Offer.end_date >='=>date("Y-m-d"),'Offer.status'=>'Active')));		
		}else{
			$offer=$this->Offer->find('first',array('conditions'=>array('Offer.brand_product_id'=>$id,'Offer.start_date <='=>date("Y-m-d"),'Offer.end_date >='=>date("Y-m-d"),'Offer.status'=>'Active')));
		}	
		if(!empty($offer))
		{
			if($offer['Offer']['discount_type']=='PureValue')
			{
				$newprice=$price-$offer['Offer']['value'];	
			}else{
				$newprice=$price-(($offer['Offer']['value']/100)*$price);
			}
		}else{
			$newprice=$price;	
		}
		return $newprice;
	}

    public function get_page($page) {
        $this->layout = 'ajax';
        $session_step = $this->data['session_step'];
       
        if ($session_step != '0') {
            $this->createGiftSession($session_step);
            if ($session_step == 'meTome' || $session_step == 'one_to_one' || $session_step == 'group_gift' || $session_step == 'me_to_me') {
                $gift_cat = $this->get_category_list();                
                $this->set('gift_cat', $gift_cat);
            }
        }
		if($page=='display_login')
		{
			$this->Session->delete('User');		
		}       
        $this->render($page);
    }

    public function createGiftSession($step) {
        switch ($step) {
            case 'start': $this->Session->delete("Gifting");
                $this->Session->delete('Gifting.type');
                $this->Session->write('Gifting.start', '1');
                $this->Session->write('current_step', 'type');
                break;
            case 'meTome': 
                $this->Session->write('Gifting.select_product', 'me_to_me');
                $this->Session->write('Gifting.type', 'me_to_me');
                $this->Session->write('current_step', 'select_product');
                break;
            case 'one_to_one':  
                $this->Session->write('Gifting.select_product', 'one_to_one');
                $this->Session->write('Gifting.type', 'one_to_one');
                $this->Session->write('current_step', 'select_product');

                break;
            case 'group_gift': 
                $this->Session->write('Gifting.select_product', 'group_gift');
                $this->Session->write('Gifting.type', 'group_gift');
                $this->Session->write('current_step', 'select_product');
                break;
        }
        return;
    }


    public function get_brand_products($brand_id, $brand_name, $cat_id) {

        $this->layout = 'ajax';
        $product = $this->get_product_details($brand_id);       
        $this->set('product', $product);
        $this->set('cat_id', $cat_id);
        $this->set('brand_name', $brand_name);
        $this->render('display_brand_products');
    }

    public function add_product_to_basket($pr_id=0,$price=0) {
        $this->layout = 'ajax';
        if ($pr_id != 0) {
            $product = $this->BrandProduct->findById($pr_id);
            $arr_pr = $product['BrandProduct'];
            if($price!=0)
				$arr_pr['price']=$price;
			$arr_pr['qty'] = '1';			
			
            if (!$this->Session->check('Gifting.basket')) {
                $this->Session->write('Gifting.basket.0', $arr_pr);
            } else {
                $exist = $this->Session->read('Gifting.basket');
				$flag=$i=0;
				foreach($exist as $ex)
				{
					if($ex['id']==$arr_pr['id'])
					{	$exist[$i]['qty']+=1;
						$flag=1; //break;						
					}
					$i++;  		
				}				
				$arr=array();
				if($flag==0)
					$arr[count($exist) + 1] = $arr_pr;
				
                $data = array_merge((array) $arr, (array) $exist);				
                $this->Session->write('Gifting.basket', $data);
            }
        }
        $this->set_basket_value();
        $this->render('display_basket');
    }

    public function set_basket_value() {
        $products = $this->Session->read('Gifting.basket');
        
        $total = 0;
        $already = $newprod_details = array();
        $flag = 0; //No Products selected	
        if (!empty($products)) {
            $i = 0;
            foreach ($products as $pr) {
                $newprod_details[$i] = $pr;
                $cat_id = $this->GiftBrand->find('first', array('conditions' => array('GiftBrand.id' => $pr['gift_brand_id'])));
                $category = $this->GiftCategory->find('first', array('conditions' => array('GiftCategory.id' => $cat_id['GiftBrand']['gift_category_id'])));
                $newprod_details[$i]['cat_id'] = $cat_id['GiftBrand']['gift_category_id'];
                $newprod_details[$i]['cat_name'] = $category['GiftCategory']['name'];
                $newprod_details[$i]['brand_id'] = $pr['gift_brand_id'];
                $newprod_details[$i]['brand_name'] = $cat_id['GiftBrand']['name'];
                $newprod_details[$i]['brand_thumb'] = $cat_id['GiftBrand']['thumb'];
                $qty = $pr['qty'];
                $price = $pr['price'];
                $discount = $pr['discount'];
                $newprod_details[$i]['price_discount'] = $price - (($discount / 100) * $price);
                $newprod_details[$i]['discount_sub_total'] = $qty * $newprod_details[$i]['price_discount'];
                $newprod_details[$i]['sub_total'] = $qty * $price;
                $total+=$newprod_details[$i]['discount_sub_total'];
                $i++;
            }
            
            $this->Session->write('Gifting.basket', $newprod_details);
            $this->Session->write('Gifting.total_basket_value', $total);
            $last_selected_details = array('cat_id' => $newprod_details[0]['cat_id'], 'cat_name' => $newprod_details[0]['cat_name'], 'brand_id' => $newprod_details[0]['brand_id'], 'brand_name' => $newprod_details[0]['brand_name'], 'brand_thumb' => $newprod_details[0]['brand_thumb']);
            $this->set('last', $last_selected_details);
            $flag = 1; //Products added in basket
        } else {
            $this->Session->write('Gifting.total_basket_value', '0');
        }
        $this->set('items', $newprod_details);
        $this->set('flag', $flag);
        $this->set('total_price', $total);        
        return;
    }

    public function add_product_qty($num, $pr_id, $qty) {
        $this->layout = 'ajax';
        $qty = abs($qty);
        $qty = round($qty, 0);
        if ($qty > 20)
            $qty = 20;
        if ($qty == 0)
            $qty = 1;
        $all_products = $this->Session->read('Gifting.basket');
        $i = 0;
        foreach ($all_products as $prod) {
            if ($i == $num) {
				$old_qty=$all_products[$i]['qty'];
				if($old_qty>$qty)
				{
					$action='0';     // add qty to table
					$new_qty=$old_qty-$qty;
				}else{
					$action='1';     // subtract qty from table
					$new_qty=$qty-$old_qty;  
				}				
                $all_products[$i]['qty'] = $qty;
            }
            $i++;
        }
        $this->Session->write('Gifting.basket', $all_products);
        $this->set_basket_value();
        $this->render('display_basket');
    }

    public function remove_item($num, $pr_id) {
        $this->layout = 'ajax';
        $all_products = $this->Session->read('Gifting.basket');
        $rem_products = array();
        $i = 0;
       
        foreach ($all_products as $prod) {
            
            if ($i != $num) {
                $rem_products[$i] = $prod;
            }else{
				$new_qty=$prod['qty'];				
			}
            $i++;
        }
        $this->Session->write('Gifting.basket', $rem_products);       
        $this->set_basket_value();
        if (empty($rem_products)) {
            $this->set('basket_empty', '1');
        }
        $this->render('display_basket');
    }

    public function get_voucher($id) {
        $this->layout = 'ajax';
        $this->Product->recursive = 2;
        $voucher = $this->Product->find('first', array('conditions' => array('Product.product_id' => $id)));
        $product = $this->get_product_details($id);
        
        $this->Session->write('Gifting.Voucher_details', $product);
        $this->Session->write('Gifting.Voucher_details_api', $voucher);
        $this->set('voucher', $voucher);
        $this->set('vouch_id', $id);
        $this->set('product', $product);        
        $this->render('display_voucher');
    }

    public function get_delivery() {
        $this->layout = 'ajax';       
        $this->Session->write('Gifting.select_product', '1');
        $this->Session->write('current_step', 'delivery');

        $arr = array();
        $arr[0]['name'] = 'Birthday';
        $arr[0]['value'] = 'Birthday';
        $arr[1]['name'] = 'Graduation';
        $arr[1]['value'] = 'Graduation';
        $arr[2]['name'] = 'Thank You';
        $arr[2]['value'] = 'Thank You';
        $arr[3]['name'] = 'Farewell';
        $arr[3]['value'] = 'Farewell';
        $arr[4]['name'] = 'Wedding';
        $arr[4]['value'] = 'Wedding';
        $arr[5]['name'] = 'Anniversary';
        $arr[5]['value'] = 'Anniversary';
        $arr[6]['name'] = 'Baby Shower';
        $arr[6]['value'] = 'Baby Shower';
        $this->set('arr', $arr);
       
        $this->render('display_delivery');
    }

    public function delivery_details() {
        $this->layout = 'ajax';
        $occasion = $this->data['occasion'];
        if ($this->data['occasion'] == 'other')
            $occasion = $this->data['other_occasion'];
        $this->Session->write('Gifting.delivery_details.occasion', $occasion);
        $this->Session->write('Gifting.delivery_details.delivery_time', $this->data['delivery_time']);
		
        $this->Session->write('Gifting.delivery_details.incomplete_deliver', $this->data['incomplete_deliver']);
        
        if ($this->Session->check('User') || ($this->Session->read('Gifting.type') == 'group_gift')) {
            if ($this->Session->read('Gifting.type') != 'group_gift')
                $this->get_one_to_one_summary();
            else
                $this->get_chip_in_page();
        }
        else {
            $this->get_one_to_one_summary();
		}
    }

    public function get_fb_details() {
        
        $facebook = new Facebook(array(
                    'appId' => FB_APPID,
                    'secret' => FB_APPSECRET,
                    'cookie' => false
                ));

        $facebook->setAccessToken($this->Session->read('fb_' . $facebook->getAppId() . '_access_token'));
        $user = $facebook->getUser();

        if ($user) {
            try {
                $this->Session->write('fb_access_token', $facebook->getAccessToken());
                $user_profile = $facebook->api('/me');
                $this->Session->write('user_fb', $user_profile);                
                print_r(json_encode($user_profile));
                die;
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        } else {
            $this->set('login', $facebook->getLoginUrl(
                            array(
                                "scope" => "email",
                                "redirect_uri" => SITE_URL)));
        }
    }

    public function get_cat_brands($cat_id, $cat_name) {
        $this->layout = 'ajax';
        $gift_cat = $this->get_category_list();
        $gift_brand = $this->get_category_product($cat_id);
        
        $this->set('cat_name', $cat_name);
        $this->set('cat_id', $cat_id);
        $this->set('gift_cat', $gift_cat);
        $this->set('gift_brand', $gift_brand);
        $this->render('display_gift_brands');
    }
	
	public function get_one_to_one_summary()
	{
		$this->Access->checkGiftingSession();
		$this->layout='ajax';
        $user_data = $this->Session->read('User');	
		$order = $this->Session->read('Gifting');
		
        $basket = array();
        $p = 0;
        $total_amount = 0;
		$available_flag=1;
        foreach ($order['basket'] as $bask) {
			$available=$this->BrandProduct->findById($bask['id']);
			$temp=$this->Basket->find('count',array('conditions'=>array('Basket.product_guid'=>$available['BrandProduct']['product_guid'])));
			if($bask['qty'] > ($available['BrandProduct']['available_qty']-$temp))
				$available_flag=0;
            $basket[$p]['details'] = $bask;			
            $p++;
        }
		$available_flag=1;   //Available quantity check not used now 
        $total_amount = $this->Session->read('Gifting.total_basket_value');
        if($order['type']=='me_to_me')
		{
			$order['friend_name']=$user_data['User']['first_name'].' '.$user_data['User']['last_name'];
			$this->Session->write('Gifting.friend_name',$user_data['User']['first_name'].' '.$user_data['User']['last_name']);
			$this->Session->write('Gifting.friend_email',$user_data['User']['email']);
			$this->Session->write('Gifting.friend_phone',$user_data['User']['phone']);	
		}      
        $this->set('available_flag', $available_flag);
		$this->set('basket', $basket);
        $this->set('total_amount', $total_amount);
        $this->set('order', $order);
        
		$this->set('user', $user_data);
		
		$this->render('one_to_one_summary');
	}
	
	
    public function get_status_page() {
        $this->layout = 'ajax';
        if (!$this->Session->check('frnd_gpuser')) {
		 if ($this->Session->check('User')) {
			//if ($this->Session->check('Gifting')) {
			//$this->Access->checkGiftingSession();
            $data = $this->Session->read('Gifting');
			$us_id=$this->Session->read('User.User.id');
            $user_data = $this->User->findById($us_id);
            $this->set('user', $user_data);
            if (!empty($data)&&(isset($data['delivery_details']))&&(!empty($user_data['User']['phone']))) {
                
                if ($this->Session->read('Gifting.type') != 'group_gift') {
                    $to = array();
                    if ($data['type'] == 'me_to_me') {
                        $to = $user_data;
                        $g_type = 'Me To Me';
                    } else if ($data['type'] == 'one_to_one') {
                        $to['User']['id'] = $to['User']['email'] = $to['User']['phone'] = null;
                        $to['User']['first_name'] = $this->Session->read('Gifting.friend_name');
						$to['User']['last_name']='';
						$to['User']['email'] = $this->Session->read('Gifting.friend_email');
						$to['User']['phone'] = $this->Session->read('Gifting.friend_phone');
                        $g_type = 'One To One';
                    }
                    
                    $session_id = String::uuid();
                    $basket = $this->Session->read('Gifting.basket');
                    $total_amount = $this->Session->read('Gifting.total_basket_value');
					
					foreach ($basket as $bask) {
						
                        $details = array('session_id' => $session_id, 'voucher_id' => $bask['id'],'product_guid'=>$bask['product_guid'], 'quantity' => $bask['qty'], 'total_value' => $bask['sub_total']);
                        $this->Basket->create();
                        $this->Basket->save($details);                       
                    }
					
                    $order = array('session_id' => $session_id, 'type' => $g_type, 'from_id' => $user_data['User']['id'], 'from_name' => $user_data['User']['first_name'] . ' ' . $user_data['User']['last_name'], 'to_id' => $to['User']['id'], 'to_name' => $to['User']['first_name'].' '.$to['User']['last_name'], 'to_email' => $to['User']['email'], 'to_phone' => $to['User']['phone'], 'occasion' => $data['delivery_details']['occasion'], 'delivery_time' => date('Y-m-d H:i:s',strtotime($data['delivery_details']['delivery_time'])), 'incomplete_deliver' => $data['delivery_details']['incomplete_deliver'], 'total_amount' => $total_amount, 'created' => date("Y-m-d H:i:s"));
                   
                    $this->Order->create();
					$fieldList = array('fieldList' =>array_keys($order));
                    $order_data = $this->Order->save($order,$fieldList);
					if(!empty($order_data))
					{                    
						$this->get_basket_details($order_data['Order']['id']);
						$PromoCode = new PromocodeController;
           				$PromoCode->constructClasses();
						$PromoCode->give_promocode($order_data['Order']['id'],$user_data['User']['id'],'1');
						$this->set('total_amount', $total_amount);
						$this->set('user', $user_data);
						$this->set('order', $order_data);
						$this->set('success_setup_gift', '1');
						$this->render('status_page');
					}else{
						echo '9';die;	
					}
                } else {
                    $this->go_group_gyft();
                }
            } else {
                if ($this->Session->check('Gifting.type'))
                 {   
				 	echo '9';
				 }else{
                    echo 9;
				 }
                die;
            }
			
			/*}else{
				$this->redirect(array('controller'=>'users','action'=>'invalid_session'));	
			}*/
		  }else{
				$this->render('display_login');  
			}
        }else {
            echo 'gpuser';
            die;
        }
       
    }

    public function user_pic() {
        $this->layout = 'ajax';
        $user = $this->User->findById($this->Session->read('User.User.id'));		
       		
        if (!empty($user['User']['thumb'])) {
            echo '<li><a href="javascript://" onClick="display_profile();" class="facebook"><img src="' . SITE_URL . '/files/ProfileImage/' . $user['User']['id'] . '/mini_thumb_' . $user['User']['thumb'] . '" alt="" title="' . $user['User']['first_name'] . '"/></a></li><li><a href="javascript://" onClick="display_profile();">'.$user['User']['first_name'].'</a></li><li><a href="javascript://" onClick="logout();" class="color">Logout</a></li><li><a href="'.SITE_URL.'" class="color">Home</a></li>';
        } else if (!empty($user['User']['fb_id']) && ($user['User']['fb_id'] != 0)) {
            echo '<li><a href="javascript://" onClick="display_profile();" class="facebook"><img src="https://graph.facebook.com/' . $user['User']['fb_id'] . '/picture" alt="" title="' . $user['User']['first_name'] . '" height="39" width="42"/></a></li><li><a href="javascript://" onClick="display_profile();">'.$user['User']['first_name'].'</a></li><li><a href="javascript://" onClick="logout();" class="color">Logout</a></li><li><a href="'.SITE_URL.'" class="color">Home</a></li>';
        } else {
            echo '<li><a href="javascript://" onClick="display_profile();" class="facebook"><img src="' . SITE_URL . '/img/facebook_profile_pic.jpg" alt="" title="' . $user['User']['first_name'] . '"/></a></li><li><a href="javascript://" onClick="display_profile();">'.$user['User']['first_name'].'</a></li><li><a href="javascript://" onClick="logout();" class="color">Logout</a></li><li><a href="'.SITE_URL.'" class="color">Home</a></li>';
        }
		
        die;
    }

    public function get_friends($step, $status_step,$call=0) {
        $this->layout = 'ajax';
        $this->set('status_step', $status_step);
        $facebook = new Facebook(array(
                    'appId' => FB_APPID,
                    'secret' => FB_APPSECRET,
                    'cookie' => false
                ));

        $facebook->setAccessToken($this->Session->read('fb_' . $facebook->getAppId() . '_access_token'));
        $user = $facebook->getUser();
        if ($user) {
            $this->Session->write('fb_access_token', $facebook->getAccessToken());
            $user_profile = $facebook->api('/me');
            $friends = $facebook->api('/me/friends?fields=id,first_name,last_name,picture');
            $this->set('friends', $friends['data']);
            $user_data = $this->User->findByFbIdOrEmail($user,$user_profile['email']);
          
            if ($step == 1) {
                $datfrnds = array();
                if (!empty($friends['data'])) {
                    foreach ($friends['data'] as $fan) {
                        $datfrnds[] = $fan['first_name'];
                    }
                }
                $this->set('datfrnds', $datfrnds);
				if($call==0)
                	$this->render('friend_list');
				else
					$this->render('chipin_friend_list');	
            } else if ($step == 2) {
                $fdat = array();
                $k = 0;
               
                foreach ($friends['data'] as $fr) {
                    $fdat[$k]['label'] = $fr['first_name'] . ' ' . $fr['last_name'];
                    $fdat[$k]['value'] = $fr['id'];
                    
                    $k++;
                }
                $temp = json_encode($fdat);
                $this->set('userid', $this->Session->read('User.User.id'));
                echo $temp;
                die;
             
            } else {

                die;
            }
        }
       
    }

    public function set_session($id=0) {
        $user = $this->User->findById($id);
        if (!empty($user)) {
            $this->Session->write('User', $user);
            $this->createUserLog($this->Session->read('User.User.id'));
        }
        $this->Session->write('Gifting.' . $this->data['dat'], $this->data['value']);
        if(isset($this->data['type']))
		{
		if ($this->data['type'] == '2')
            $this->Session->write('Gifting.friend_email', $this->data['email']);
			$this->Session->write('Gifting.friend_phone', $this->data['phone']);
		}
		if($this->data['type'] == '1')
		{
			$this->Session->write('Gifting.friend_email','');
			$this->Session->write('Gifting.friend_phone','');
		}
        die;
    }

    public function get_chip_in_page() {
        $this->layout = 'ajax';
        $this->Session->write('Gifting.group_gift_num', '0');
        if ($this->Session->check('Gifting.group_gift.friends')) {
            $friends = $this->Session->read('Gifting.group_gift.friends');
            
            $this->set('is_friends', '1');
            $this->set('friends', $friends);
        }       
        $this->render('chip_in_page');
    }

    public function add_chip_in($type) {                   ///$type=1 => manual  $type=2 =>FB 
        $this->layout = 'ajax';
        $newfrnd = $this->data;
        $exist = $this->Session->read('Gifting.group_gift.friends');
        $num = count($this->Session->read('Gifting.group_gift.friends'));
        $arr = $this->get_array_of_frnd_list($exist, $newfrnd, $num, $type);
        $data = array_merge((array) $arr, (array) $exist);
        $this->Session->write('Gifting.group_gift.friends', $data);

        $name = '';
        foreach ($data as $dat)
            $name.=$dat['name'] . ',';
        unset($this->request->data);
        echo $name;
        die;
    }

    public function get_array_of_frnd_list($exist, $newfrnd, $num) {
        $added_email = $added_fb = array();
        if (!empty($exist)) {
            foreach ($exist as $ex) {
                $added_fb[] = $ex['fb_id'];
                $added_email[] = $ex['email'];
            }
        }
        $num+=1;
       
        $arr = array();
        foreach ($newfrnd as $new) {
            if (!empty($new['frnd_email'])) {
                if (!in_array($new['frnd_email'], $added_email)) {
                    $arr[$num]['fb_id'] = '';
                    $arr[$num]['name'] = $new['frnd_name'];
                    $arr[$num]['email'] = $new['frnd_email'];
                    if (isset($new['expected_contri'])) {
                        $arr[$num]['contri_amount_expected'] = $new['expected_contri'];
                    }
					 if (isset($new['frnd_phone'])) {
                        $arr[$num]['phone'] = $new['frnd_phone'];
                    }
                    $num++;
                }
            } else {
                if (!in_array($new['fb_id'], $added_fb)) {
                    $arr[$num]['name'] = $new['frnd_name'];
                    $arr[$num]['fb_id'] = $new['fb_id'];
                    $arr[$num]['email'] = '';
                    if (isset($new['expected_contri'])) {
                        $arr[$num]['contri_amount_expected'] = $new['expected_contri'];
                    }
						 if (isset($new['frnd_phone'])) {
                        $arr[$num]['phone'] = $new['frnd_phone'];
                    }
                    $num++;
                }
            }
        }
        return $arr;
    }

    public function addto_contri_member($ord) {
        $this->layout = 'ajax';
        $newfrnd = $this->data;
        $order = $this->Order->find('first', array('conditions' => array('Order.id' => $ord)));
        $group = $this->GroupGift->find('all', array('conditions' => array('GroupGift.order_id' => $order['Order']['id'])));
		$eq=$group[0]['GroupGift']['contri_amount_expected'];
        $i = 0;
        $exist = array();
        foreach ($group as $gp) {
            $exist[$i]['fb_id'] = $gp['GroupGift']['fb_id'];
            $exist[$i]['name'] = $gp['GroupGift']['name'];
            $exist[$i]['email'] = $gp['GroupGift']['email'];
            $i++;
        }
        $num = count($exist);        
        $friends = array();
        $j = 0;
        foreach ($newfrnd['frnd'] as $fn) {
            $friends[$j]['frnd_email'] = $friends[$j]['fb_id'] = '';
            $friends[$j]['frnd_name'] = $fn['name'];
            if (isset($fn['email']))
                $friends[$j]['frnd_email'] = $fn['email'];
            if (isset($fn['fid'])) {
                $fid = explode('_', $fn['fid']);
                $friends[$j]['fb_id'] = $fid[1];
            }
            if ($order['Order']['contri_type'] == '0') {
                $friends[$j]['expected_contri'] = $eq;
            }
            $j++;
        }
        
        $arr = $this->get_array_of_frnd_list($exist, $friends, $num);
		
        $email_user = $fb_user = '';
        $j = 0;
        foreach ($arr as $key => $ar) {
            if (!empty($ar['fb_id']))
                $fb_user.=$ar['fb_id'] . ',';

            $arr[$key]['order_id'] = $order['Order']['id'];
            $arr[$key]['initiator_id'] = $order['Order']['from_id'];
            $arr[$key]['group_gift_id'] = $order['Order']['group_gift_id'];
        }
        
        foreach ($arr as $ar_data) {
            $this->GroupGift->create();
            $gp_user = $this->GroupGift->save($ar_data);
            if (!empty($ar_data['email']) && ($ar_data['email'] != $this->Session->read('User.User.email')&&$ar_data['other_user_id']!=$this->Session->read('User.User.id')))
                $this->send_email_invite_gpuser($gp_user['GroupGift']['id']);
        }
		
        $fb_user = substr($fb_user, 0, -1);
        $this->set('fb_user', $fb_user);
        $this->set('order', $order);
        $this->set('uid', $order['Order']['group_gift_id']);
        $this->render('send_message_friends');
    }

    public function add_selected_friends($id, $status_step) {
        $this->layout = 'ajax';
        $user = $this->User->findById($id);
        if (!empty($user)) {
            $this->Session->write('User', $user);
            $this->createUserLog($this->Session->read('User.User.id'));
        }
        $data = $this->data;
        $arr = array();
        $i = 0;
        foreach ($data['values'] as $dat) {
            if (!empty($dat)) {
                $temp = explode('_', $dat);
                $arr[$i]['fb_id'] = $temp[0];
                $arr[$i]['frnd_name'] = $temp[1];
                $arr[$i]['frnd_email'] = '';
                $i++;
            }
        }
        $this->request->data = $arr;
        if ($status_step == 1) {
            $this->add_chip_in(2);
            die;
        } else {
            $this->layout = 'ajax';
            $this->addto_contri_member($status_step, 2);
            $this->render('initiator_status_page');
        }
        
    }

    public function update_friend_list() {
        $this->layout = 'ajax';
        $data = $this->Session->read('Gifting.group_gift.friends');
       
        $name = '';
        for ($i = 0; $i < 8; $i++) {
            if (isset($data[$i])) {
                if (!empty($data[$i]['fb_id'])) {
                    $name.='<li><a href="javascript://"><img src="http://graph.facebook.com/' . $data[$i]['fb_id'] . '/picture" width="55" height="55" title="' . $data[$i]['name'] . '" alt=""/></a></li>';
                } else {
                    $name.='<li><a href="javascript://"><img src="' . SITE_URL . '/img/facebook_profile_pic.jpg" width="55" height="55" title="' . $data[$i]['name'] . '" alt=""/></a></li>';
                }
            }
            $i++;
        }
        $name.='<li><a href="javascript://"><img src="' . SITE_URL . '/img/friend_slide_arr1.jpg" alt=""/></a></li><li><a href="javascript://"><img src="' . SITE_URL . '/img/friend_slide_arr2.jpg" alt=""/></a></li>';
        echo $name;
        die;
    }

    public function edit_status_page($id) {
        $this->layout = 'ajax';
        $order = $this->Order->findById($id);
        $this->set('order', $order);
        $this->render('edit_status_page');
    }

    public function update_status_page() {
        $this->layout = 'ajax';
        
        $id = $this->data['order_id'];
		$to_name=str_replace(';','',$this->data['to_name']);
		$to_email=str_replace(';','',$this->data['to_email']);
		$to_phone=str_replace(';','',$this->data['to_phone']);
		
        $sql = "update gyftr_order_detail set to_name='" . $to_name . "',to_email='" . $to_email . "',to_phone='" . $to_phone . "' where id='" . $id . "'";
        $this->Order->query($sql);
        echo $to_name . '|' . $to_email . '|' . $to_phone;
        
        die;
    }

    public function add_chipin_popup($ordid) {
        $this->layout = 'ajax';
        $order = $this->Order->findById($ordid);
        $flag = 1;
        if ($order['Order']['payment_status'] == 1)
            $flag = 0;

        $this->set('ordid', $ordid);
        $this->set('flag', $flag);
        $this->render('add_chipin_popup');
    }

    public function get_decide_contri() {
        $this->layout = 'ajax';
        $friends = $this->Session->read('Gifting.group_gift.friends');
        $total = $this->Session->read('Gifting.total_basket_value');
        $count = count($friends);
        $equal = round(($total / $count), 0);
		if($equal*$count<$total)
		{
			$equal=$equal+1;	
		}
        $this->set('total', $total);
        $this->set('friends', $friends);
        $this->set('count', $count);
        $this->set('equal', $equal);
       
        $this->render('decide_contri_page');
    }

    public function get_contri_type($typ) {      //$typ = 1 =>Equal 2=>Each decide 3=>I decide
        $this->layout = 'ajax';
        
        $info = $this->Session->read('Gifting');
        $data = array();
        $data['to_name'] = $info['friend_name'];
        $data['total_amount'] = $info['total_basket_value'];
        $this->set('contri_type', $typ);
        $data['contri'] = round($data['total_amount'] / count($info['group_gift']['friends']), 2);
        $data['friends'] = $info;
       
        $this->set('data', $data);
        $this->render('display_contri');
    }

    public function confirm_contri() {  //$typ = 1 =>Equal 2=>Each decide 3=>I decide
		$this->Access->checkGiftingSession();
        $this->layout = 'ajax';
        $data = $this->data;
       
        $typ = $data['contri_type'];
        $user = array();
        $this->Session->write('Gifting.group_gift.contri_type', $typ);   //$typ = 1 =>Equal 2=>Each decide 3=>I decide	
        $friends = $this->Session->read('Gifting.group_gift.friends');
        if ($this->Session->check('User')) {
            $user['fb_id'] = $this->Session->read('User.User.fb_id');
            $user['name'] = $this->Session->read('User.User.first_name');
        } else {
            $user['fb_id'] = 'You';
            $user['name'] = 'You';
        }
        $arr = array();
        $i = 0;
        if ($typ == 0) {
            foreach ($friends as $ind => $dat) {
                $arr[$ind]['fb_id'] = $dat['fb_id'];
                $arr[$ind]['name'] = $dat['name'];
                $arr[$ind]['email'] = $dat['email'];
				if(isset($dat['phone']))
				{
					 $arr[$ind]['phone'] = $dat['phone'];	
				}
                $arr[$ind]['contri_exp'] = $data['equal_contri'];
            }
        } else if ($typ == 1) {
            foreach ($friends as $ind => $dat) {
                $arr[$ind]['fb_id'] = $dat['fb_id'];
                $arr[$ind]['name'] = $dat['name'];
                $arr[$ind]['email'] = $dat['email'];
				if(isset($dat['phone']))
				{
					 $arr[$ind]['phone'] = $dat['phone'];	
				}
                $arr[$ind]['contri_exp'] = '';               
            }
        } else {
            $k = 0;
            foreach ($friends as $ind => $dat) {

                $arr[$ind]['fb_id'] = $dat['fb_id'];
                $arr[$ind]['name'] = $dat['name'];
                $arr[$ind]['email'] = $dat['email'];
				if(isset($dat['phone']))
				{
					 $arr[$ind]['phone'] = $dat['phone'];	
				}
                $arr[$ind]['contri_exp'] = $data['fr_' . $k];
                $k++;
            }
        }
        $this->Session->write('Gifting.group_gift.friends', $arr);
        	
        $order = $this->Session->read('Gifting');
        $basket = array();
        $p = 0;
        $total_amount = 0;
		$available_flag=1;
        foreach ($order['basket'] as $bask) {
            $available=$this->BrandProduct->findById($bask['id']);
			$temp=$this->Basket->find('count',array('conditions'=>array('Basket.product_guid'=>$available['BrandProduct']['product_guid'])));
			if($bask['qty'] > ($available['BrandProduct']['available_qty']-$temp))
				$available_flag=0;
			$basket[$p]['details'] = $bask;
			
            $p++;
        }
		$available_flag=1;   //Available quantity check not used now 
        $total_amount = $this->Session->read('Gifting.total_basket_value');
        $tot['total'] = 0;
        foreach ($order['group_gift']['friends'] as $fr)
            $tot['total']+=$fr['contri_exp'];

        $tot['balance'] = round(($total_amount - $tot['total']), 2);
        $this->set('basket', $basket);
		$this->set('available_flag', $available_flag);
        $this->set('total_amount', $total_amount);
        $this->set('total', $tot);
        $this->set('order', $order);
        $this->render('summary_page');
    }

    public function edit_giftsummary_page() {
		$this->Access->checkGiftingSession();
        $this->layout = 'ajax';
        $order = $this->Session->read('Gifting');
        $this->set('order', $order);
        $this->render('edit_giftsummary_page');
    }

    public function update_giftsummary_page($email=0, $phone=0) {
		$this->Access->checkGiftingSession();
        if ($email == 0 && $phone == 0) {
			$this->Session->write('Gifting.friend_name', $this->data['to_name']);
            $this->Session->write('Gifting.friend_email', $this->data['to_email']);
            $this->Session->write('Gifting.friend_phone', $this->data['to_phone']);
            echo $this->data['to_name'] . '|' . $this->data['to_email'] . '|' . $this->data['to_phone'];
        } else {
			if($email!='undefined')
          	  $this->Session->write('Gifting.friend_email', $email);
			if($phone!='undefined')  
            $this->Session->write('Gifting.friend_phone', $phone);
        }
        die;
    }

    public function edit_summary_page($name, $num) {
		$this->Access->checkGiftingSession();
        $this->layout = 'ajax';
        $friends = $this->Session->read('Gifting.group_gift.friends');
        $fr = $friends[$num];
       
        $this->set('fr', $fr);
        $this->set('num', $num);
        $this->render('edit_summary_page');
    }

    public function update_gpsummary($num) {
		$this->Access->checkGiftingSession();
        $this->Session->write('Gifting.group_gift.friends.' . $num, $this->data);
        echo $this->data['name'] . '|' . $this->data['email'] . '|' . $this->data['phone'];
        die;
    }

    public function go_group_gyft() {
        $this->layout = 'ajax';
        $User = new UsersController;
        $User->constructClasses();
        if ($this->Session->check('User')) {			
            if ($this->Session->check('Gifting')) {
			$user_data=$this->User->findById($this->Session->read('User.User.id'));
            $data = $this->Session->read('Gifting');			
            $group_user = $to = array();

            $to['User']['id'] = $to['User']['email'] = $to['User']['phone'] = null;
            $to['User']['first_name'] = $data['friend_name'];
            $to['User']['email'] = $data['friend_email'];
            $to['User']['phone'] = $data['friend_phone'];
            $g_type = 'Group Gift';

            $session_id = String::uuid();
            $basket = $this->Session->read('Gifting.basket');			
            $total_amount = $this->Session->read('Gifting.total_basket_value');
			
            foreach ($basket as $bask) {				
					
					$details = array('session_id' => $session_id, 'voucher_id' => $bask['id'],'product_guid'=>$bask['product_guid'],'quantity' => $bask['qty'], 'total_value' => $bask['sub_total']);
					$this->Basket->create();
					$this->Basket->save($details);
					
            }
			
            $order = array('session_id' => $session_id, 'type' => $g_type, 'from_id' => $user_data['User']['id'], 'from_name' => $user_data['User']['first_name'] . ' ' . $user_data['User']['last_name'], 'to_id' => $to['User']['id'], 'to_name' => $to['User']['first_name'], 'to_email' => $to['User']['email'], 'to_phone' => $to['User']['phone'], 'occasion' => $data['delivery_details']['occasion'], 'delivery_time' => date('Y-m-d H:i:s',strtotime($data['delivery_details']['delivery_time'])), 'incomplete_deliver' => $data['delivery_details']['incomplete_deliver'], 'contri_type' => $data['group_gift']['contri_type'], 'total_amount' => $total_amount, 'created' => date("Y-m-d H:i:s"));
            $this->Order->create();
            $order_data = $this->Order->save($order);
           
            $uid = String::uuid();
			$emails=array();
			
            foreach ($data['group_gift']['friends'] as $fr) {
              
					$phone = $other_user_id='';
					if (isset($fr['phone']))
						$phone = $fr['phone'];
					if ($fr['fb_id'] == 'You')
					 {   $fr['fb_id'] = $user_data['User']['fb_id'];
						$phone=	$user_data['User']['phone'];
					 }
					if ($fr['email'] == 'You')
					 {   $fr['email'] = $user_data['User']['email'];
						 $phone=	$user_data['User']['phone'];	
					 }
					if ($fr['name'] == 'You')
						$fr['name'] = $user_data['User']['first_name'] . ' ' . $user_data['User']['last_name'];
					
					if(!empty($user_data['User']['fb_id']))
					{
						if($fr['fb_id'] == $user_data['User']['fb_id'])	
						{	$phone=$user_data['User']['phone'];
							$other_user_id=$user_data['User']['id'];
						}
					}else{
						if($fr['email'] == $user_data['User']['email'])	
						{	$phone=$user_data['User']['phone'];
							$other_user_id=$user_data['User']['id'];
						}
					}
					
					if(!empty($fr['fb_id']))
					{
						$user_exist=$this->User->find('first',array('conditions'=>array('User.fb_id'=>$fr['fb_id'])));	
					}else if(!empty($fr['email']))
					{
						$user_exist=$this->User->find('first',array('conditions'=>array('User.email'=>$fr['email'])));	
					}					
					
					if(!empty($user_exist))
					{
						$other_user_id=$user_exist['User']['id'];	
					}
						
			  if(empty($fr['email'])||!in_array($fr['email'],$emails))
				{
					$arr = array('order_id' => $order_data['Order']['id'], 'group_gift_id' => $uid, 'initiator_id' => $user_data['User']['id'], 'fb_id' => $fr['fb_id'], 'email' => $fr['email'], 'phone' => $phone, 'name' => $fr['name'], 'contri_amount_expected' => $fr['contri_exp'],'other_user_id'=>$other_user_id);
					
					
					$this->GroupGift->create();
					$this->GroupGift->save($arr);
					if(!empty($fr['email']))
						$emails[]=$fr['email'];
				}
            }
			
            $this->Order->id = $order_data['Order']['id'];
            $this->Order->saveField('group_gift_id', $uid);
            $order['group_gift_id'] = $uid;
            $details = $this->Order->findById($order_data['Order']['id']);
            $group = $this->GroupGift->find('all', array('conditions' => array('GroupGift.group_gift_id' => $details['Order']['group_gift_id'])));
            $gp_user = array();
            $i = 0;
            $fb_user = '';
            	
            foreach ($group as $gp) {
                
                $gp_user[$i]['det'] = $gp['GroupGift'];
               
                if (!empty($gp['GroupGift']['fb_id']) && ($gp['GroupGift']['fb_id'] != 'You')) {
                    $fb_user.=$gp['GroupGift']['fb_id'] . ',';
                }

                if (!empty($gp['GroupGift']['email']))
                    $this->send_email_invite_gpuser($gp['GroupGift']['id']);

                $i++;
            }
			$PromoCode = new PromocodeController;
           	$PromoCode->constructClasses();
			$PromoCode->give_promocode($order_data['Order']['id'],$user_data['User']['id'],'1');
			
            $fb_user = substr($fb_user, 0, -1);
            $this->set('fb_user', $fb_user);
            $this->set('order', $details);
            $this->set('group', $gp_user);
            $this->set('uid', $uid);
            $this->set('user', $user_data);
            $this->Session->write('Gifting.group_gift.completion', '0');
            $this->render('send_message_friends');
			}else{
				$this->redirect(array('controller'=>'users','action'=>'invalid_session'));	
			}
        }else {
            $this->set('popup_login', '1');
            $this->render('display_login');
        }
    }

    public function update_group_gift($uid) {
        $this->layout = 'ajax';
        $reqid = $this->data['reqid'];
        $fb_user_ids = $this->data['fb_user'];
        $fb_user = explode(',', $fb_user_ids);
       
        foreach ($fb_user as $fbid) {
            $sql = "update gyftr_group_gift_users set req_id='" . $reqid . "' where group_gift_id='" . $uid . "' and fb_id='" . $fbid . "'";
            $this->GroupGift->query($sql);
        }
        $order = $this->Order->find('first', array('conditions' => array('Order.group_gift_id' => $uid)));
        echo $order['Order']['id'];
        die;
    }   

    public function get_final_summary($order_id) {
		$this->Access->checkUserSession();
        $this->layout = 'ajax';
		$userId=$this->Session->read('User.User.id');
        $userdata = $this->User->findById($userId);
        $group = $this->Session->read('Gifting.group_gift.friends');
        
        $group = $this->GroupGift->find('all', array('conditions' => array('GroupGift.order_id' => $order_id)));
        $order = $this->Order->find('first', array('conditions' => array('Order.id' => $order_id)));
        
        $this->get_basket_details($order['Order']['id']);
        $i = 0;
        $gp_user = array();
        foreach ($group as $gp) {
            $gp_user[$i]['det'] = $gp['GroupGift'];
            if (!empty($gp['GroupGift']['other_user_id'])) {
                $gp_user[$i]['user'] = $this->User->findById($gp['GroupGift']['other_user_id']);
            } else {
                $gp_user[$i]['user']['User']['id'] = $gp_user[$i]['user']['User']['last_name'] = $gp_user[$i]['user']['User']['email'] = $gp_user[$i]['user']['User']['phone'] = '';
                $gp_user[$i]['user']['User']['first_name'] = $gp['GroupGift']['name'];
            }
            $i++;
        }

        $this->set('user', $userdata);
        $this->set('order', $order);
        $this->set('group', $gp_user);

        if ($this->Session->read('Gifting.group_gift.completion') == '0') {
            $this->set('success_setup_gift', '1');
            $this->Session->write('Gifting.group_gift.completion', '1');
        }
        $this->render('initiator_status_page');
    }

    public function get_basket_details($order_id) {
        $order = $this->Order->find('first', array('conditions' => array('Order.id' => $order_id), 'fields' => array('Order.session_id')));
        $basket_details = $this->Basket->find('all', array('conditions' => array('Basket.session_id' => $order['Order']['session_id'])));
        $basket = array();
        $i = 0;
        foreach ($basket_details as $bask) {
            $basket[$i]['details'] = $bask['Basket'];
            $basket[$i]['voucher'] = $this->BrandProduct->find('first', array('conditions' => array('BrandProduct.id' => $bask['Basket']['voucher_id'])));
            $i++;
        }

        $this->set('basket', $basket);
        return;
    }

    public function set_variables_statuspage($order_id) {
        $this->layout = 'ajax';
        $order = $this->Order->findById($order_id);
        if ($order['Order']['from_id'] == $this->Session->read('User.User.id')) {
            $this->get_basket_details($order_id);
            
            if ($order['Order']['group_gift_id'] != 0) {
                $group = $this->GroupGift->find('all', array('conditions' => array('GroupGift.order_id' => $order_id)));
                $i = 0;
                $gp_user = array();
                foreach ($group as $gp) {
                    $gp_user[$i]['det'] = $gp['GroupGift'];
                    if (!empty($gp['GroupGift']['other_user_id'])) {
                        $gp_user[$i]['user'] = $this->User->findById($gp['GroupGift']['other_user_id']);
                    } else {
                        $gp_user[$i]['user']['User']['id'] = $gp_user[$i]['user']['User']['last_name'] = $gp_user[$i]['user']['User']['email'] = $gp_user[$i]['user']['User']['phone'] = '';
                        $gp_user[$i]['user']['User']['first_name'] = $gp['GroupGift']['name'];
                    }
                    $i++;
                }
                $proposed_users = $this->PropUser->find('all', array('conditions' => array('PropUser.order_id' => $order_id, 'status' => '0')));
                $popuser = array();
                $j = 0;

                foreach ($proposed_users as $pop) {
                    $popuser[$j]['det'] = $pop;
                    $this->User->recursive = -1;
                    $popuser[$j]['fromInfo'] = $this->User->findById($pop['PropUser']['from_id']);
                    $j++;
                }
                $this->set('popuser', $popuser);
                $this->set('group', $gp_user);
            }
            $userdata = $this->User->findById($order['Order']['from_id']);
            
            $this->set('user', $userdata);
            $this->set('order', $order);
            if ($order['Order']['group_gift_id'] != 0)
                return 1;
            else
                return 0;
        }else {
            return 2;
        }
    }

    public function view_order_details($order_id,$payvar=0,$gpuser_id=0) {
        $this->layout = 'ajax';
		if($payvar!=0)
		{
			$this->set('payvar',$payvar);	
		}
        $val = $this->set_variables_statuspage($order_id);
        if ($val == 1)
        {   
		$this->Access->checkUserSession();
		 $this->render('initiator_status_page');
		
		}else if ($val == 0)
         {  
		 	$this->Access->checkUserSession();
		 	 $this->render('status_page');
		 
		 }else {
            $order = $this->Order->findById($order_id);			
            $this->connect_gpuser($order['Order']['group_gift_id'], '1', $this->Session->read('User.User.id'),$gpuser_id);
        }
    }
	
	public function decrement_quantity($pr_id,$qty,$action=1)
	{	
			if($action==1)
				$sql="update gyftr_brand_products set available_qty=available_qty-".$qty." where id=".$pr_id;
			else
			   	$sql="update gyftr_brand_products set available_qty=available_qty+".$qty." where id=".$pr_id;			
			$this->BrandProduct->query($sql);	
		
		return;
	}

    public function update_group_contri_amount($order_id) {
        $this->layout = 'ajax';
        $order = $this->Order->findById($order_id);
        $group = $this->GroupGift->find('all', array('conditions' => array('GroupGift.group_gift_id' => $order['Order']['group_gift_id'])));

        $amount_left = $order['Order']['total_amount'] - $order['Order']['amount_paid'];
        
        $count = 0;
        foreach ($group as $gp) {
            if (empty($gp['GroupGift']['contri_amount_paid']))
                $count++;
        }
        $share = round(($amount_left / $count), 2);       
        if ($share > 0) {
            foreach ($group as $gp) {
                if (empty($gp['GroupGift']['contri_amount_paid'])) {
                    $this->GroupGift->id = $gp['GroupGift']['id'];
                    $this->GroupGift->saveField('contri_amount_expected', $share);
                    unset($this->GroupGift->id);
                }
            }
        }
        return;
    }

    public function edit_groupgift_user($id) {
        $this->layout = 'ajax';
        $user = $this->GroupGift->findById($id);
        $order = $this->Order->find('first', array('conditions' => array('Order.id' => $user['GroupGift']['order_id'])));
        $amount_left = $order['Order']['total_amount'] - $order['Order']['amount_paid'];
        $this->set('max_contri_allowed', $amount_left);
        $this->set('user', $user);
        $this->render('edit_gpgift_user');
    }

    public function update_gpusers() {
        $data = $this->data;
       
        $this->GroupGift->id = $data['gp_id'];
		if(empty($data['phone']))
		{
			unset($data['phone']);	
		}
        $this->GroupGift->save($data);
        echo $data['ord_id'];
        die;
    }

    public function setup_success_msg($order_id) {
        $this->send_giftsetup_mail_sms($order_id);	
		
		echo '<div id="form_section" style="margin:0 0 5px 0; padding:0%; width:99%; text-align:center; min-height:288px;"><span class="select_dele" style="text-align:left;">/ / <strong>Congratulations</strong></span><div style="margin:30px 0 0; width:100%; text-align:center"><img style="float:none" src="'.$this->webroot.'img/form_left_bg.png" alt=""/></div><div style="padding:10px  0 0 0;color:#090;">Your Gift has been setup successfully.</div></div>';
        die;
    }
	
	  public function payment_success_msg($ord_id=0) {
		  $order=$this->Order->findById($ord_id);
		  $deliver='';		  
		 
		 if(($order['Order']['status']!=1))
		  { 
			if($order['Order']['incomplete_deliver']==1||$order['Order']['payment_status']==1||$order['Order']['amount_paid']-$order['Order']['total_amount']>=0)
			{
				if($order['Order']['delivery_time']<date("Y-m-d H:i:s"))
				{
					$cron = new CronController;
        			$cron->constructClasses();	
					$resp=$cron->crontest($ord_id);
					if($resp=='success')
					{
						$deliver='<div style="display:block; padding:10px 0; width:99%; text-align:center;">Your Gyft has been delivered successfully.</div>';	
					}else if($resp=='notif')
					{
						$deliver='';	
					}
				}else{
				
				}
			}	  
		  }
        echo '<div id="form_section" style="margin:0 0 5px 0; padding:0%; width:99%; text-align:center; min-height:288px;"><span class="select_dele" style="text-align:left;">/ / <strong>Congratulations</strong></span><div id="payment_success"><div style="margin:30px 0 0; width:100%; text-align:center"><img style="float:none" src="/img/form_left_bg.png" alt=""/></div><div style="padding:10px  0 0 0;color:#090;">You have made a contribution in Gyft.</div>'.$deliver.'</div></div>';
        die;
    }

    public function add_propose_popup($ord) {
       
        $this->layout = 'ajax';
        $userid = $this->Session->read('User.User.id');
        $order = $this->Order->findById($ord);
        $flag = 1;
        if ($order['Order']['payment_status'] != 0)
            $flag = 0;
        $this->set('order_id', $ord);
        $this->set('flag', $flag);
        $this->set('userid', $userid);
        
        $this->render('add_propose_popup');
    }

    public function propose_contri_member() {
        $data = $this->data;
		
        $count = 0;
      foreach ($data['puser'] as $p) {
		  
            $info[$count] = array('order_id' => $this->data['order_id'], 'from_id' => $this->data['userid'], 'name' => $p['frnd_name'], 'email' => $p['frnd_email'], 'phone' => $p['frnd_phone'],'status'=>0);
         
            $count++;
        }
		
		 $this->PropUser->create();
         $this->PropUser->saveAll($info);
        $this->send_propose_user_notif_mail($data['userid'], $data['order_id'], $count);
        echo $data['order_id'];
        die;
    }

    public function confirm_prop_user($prop_id) {
        $this->layout = 'ajax';
        $prop = $this->PropUser->findById($prop_id);
        $order = $this->Order->find('first', array('conditions' => array('Order.id' => $prop['PropUser']['order_id'])));
        $amount_left = $order['Order']['total_amount'] - $order['Order']['amount_paid'];
		if($order['Order']['contri_type']==0)
		{
			$others=$this->GroupGift->find('first',array('conditions'=>array('GroupGift.order_id'=>$order['Order']['id'])));
			$equal=$others['GroupGift']['contri_amount_expected'];
			$this->set('equal',$equal);	
		}
        $this->set('max_contri_allowed', $amount_left);
        $this->set('prop', $prop);
		$this->set('order', $order);
        $this->render('confirm_prop_user');
    }

    public function accept_prop_user() {
        $data = $this->data;
		if(!isset($data['contri_expected']))
		{
			$data['contri_expected']='';	
		}
        $order = $this->Order->findById($data['order_id']);
        $already_gpuser = $this->GroupGift->find('first', array('conditions' => array('GroupGift.order_id' => $data['order_id'], 'GroupGift.email' => $data['email'], 'GroupGift.group_gift_id' => $order['Order']['group_gift_id'])));
        if (empty($already_gpuser)) {
            $exist = $this->User->find('first', array('conditions' => array('OR' => array('User.email' => $data['email'], 'User.fb_email' => $data['email']))));
            $other_user_id = '';
            if (!empty($exist))
                $other_user_id = $exist['User']['id'];
            $details = array('order_id' => $data['order_id'], 'group_gift_id' => $order['Order']['group_gift_id'], 'initiator_id' => $order['Order']['from_id'], 'other_user_id' => $other_user_id, 'contri_amount_expected' => $data['contri_expected'], 'email' => $data['email'], 'name' => $data['name'], 'phone' => $data['phone']);
            $this->GroupGift->create();
            $info = $this->GroupGift->save($details);

            $this->PropUser->id = $data['prop_id'];
            $this->PropUser->saveField('status', '1');
            $this->send_email_invite_gpuser($info['GroupGift']['id']);
            echo $data['order_id'];
        }else {
            echo 'already';
        }
        die;
    }

    public function save_chipin_frnds() {
        $data = $this->data;
       
        $user = $this->Session->read('User');
        $friends = array();
        $i = 0;		
        
        if (!empty($user)) {
            $friends[$i]['frnd_name'] = $user['User']['first_name'];
            $friends[$i]['frnd_email'] = $user['User']['email'];
			$friends[$i]['frnd_phone'] = $user['User']['phone'];
            $friends[$i]['fb_id'] = $user['User']['fb_id'];
        } else {
            $friends[$i]['frnd_name'] = $friends[$i]['frnd_email'] = $friends[$i]['fb_id'] =$friends[$i]['frnd_phone']= 'You';
        }

        $exist = $this->Session->read('Gifting.group_gift.friends');
        $num = count($this->Session->read('Gifting.group_gift.friends'));
        $arr = $this->get_array_of_frnd_list($exist, $friends, $num);
        $data = array_merge((array) $arr, (array) $exist);
        
        $this->Session->write('Gifting.group_gift.friends', $data);
		$this->layout='ajax';
		$this->set('frnds_count',count($data));
		$this->set('data',$data);
		die;
    }	
	
	public function update_chip_list($call=0)
	{
       $data=array();
	   	if($call==1)
		{	
			$data['frnd'][0]['name']=$this->data['name'];
			$data['frnd'][0]['email']=$this->data['email'];
		}else{
			
		$data = $this->data;	
		}
      	
        $user = $this->Session->read('User');
        $friends = array();
        $i = 0;		
        
		foreach ($data['frnd'] as $fn) {
            if(isset($fn['email']))
			{
				if($fn['email']!=$user['User']['email'])
				{
					$friends[$i]['frnd_email'] = $friends[$i]['fb_id'] = '';
					$friends[$i]['frnd_name'] = $fn['name'];
					if (isset($fn['email']))
						$friends[$i]['frnd_email'] = $fn['email'];
					if (isset($fn['fid'])) {
						$fid = explode('_', $fn['fid']);
						$friends[$i]['fb_id'] = $fid[1];
					}
					$i++;
				}
			}else if(isset($fn['fid']))
			{
				$fid = explode('_', $fn['fid']);
				$fn['fb_id']=$fid[1];
				if($fn['fb_id']!=$user['User']['fb_id'])
				{
					$friends[$i]['frnd_email'] = $friends[$i]['fb_id'] = '';
					$friends[$i]['frnd_name'] = $fn['name'];
					if (isset($fn['email']))
						$friends[$i]['frnd_email'] = $fn['email'];
					if (isset($fn['fid'])) {
						$fid = explode('_', $fn['fid']);
						$friends[$i]['fb_id'] = $fid[1];
					}
					$i++;
				}
			}
		}        
        $exist = $this->Session->read('Gifting.group_gift.friends');
        $num = count($this->Session->read('Gifting.group_gift.friends'));
        $arr = $this->get_array_of_frnd_list($exist, $friends, $num);
        $data = array_merge((array) $arr, (array) $exist);
        
        $this->Session->write('Gifting.group_gift.friends', $data);
		$this->layout='ajax';
		$this->set('frnds_count',count($data));
		$this->set('data',$data);
		$this->render('chip_list');        
	}	

    public function setUserSession($id) {
        $user = $this->User->findById($id);
        $this->Session->write('User', $user);
        $this->createUserLog($this->Session->read('User.User.id'));
        die;
    }

    public function createUserLog($userid) {
        $data = array();
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data['user_id'] = $userid;
        $data['login_time'] = date('Y-m-d H:i:s');
        $this->Userlog->create();
        $this->Userlog->save($data);
    }

    public function add_chipin_contri_frnds() {
        $data = $this->data;
        $friends = array();
        $i = 0;
        foreach ($data['frnd'] as $fn) {
            $friends[$i]['frnd_email'] = $friends[$i]['fb_id'] = '';
            $friends[$i]['frnd_name'] = $fn['name'];
            if (isset($fn['email']))
                $friends[$i]['frnd_email'] = $fn['email'];
            if (isset($fn['fid']))
                $friends[$i]['fb_id'] = $fn['fid'];
            $i++;
        }        
    }

    public function decline_prop_user($prop_id) {
        $this->PropUser->delete($prop_id);
        echo 'Proposed contributor declined';
        die;
    }

    public function display_product_details($pr_id,$price) {
		
        $this->layout = 'ajax';
        $product = $this->BrandProduct->find('first', array('conditions' => array('BrandProduct.id' => $pr_id)));
        $brand = $this->GiftBrand->find('first', array('conditions' => array('GiftBrand.id' => $product['BrandProduct']['gift_brand_id'])));
        $shops = $this->Shops->find('all', array('conditions' => array('Shops.brand_product_id' => $pr_id),'order'=>array('Shops.city ASC')));
        $cities = array();
        foreach ($shops as $sh) {
            if (!in_array($sh['Shops']['city'], $cities))
                $cities[] = $sh['Shops']['city'];
        }
		if($price!=$product['BrandProduct']['price'])
		{
			$this->set('discounted_value',$price);	
		}
        $this->set('cities', $cities);
        $this->set('shops', $shops);
        $this->set('product', $product);
        $this->set('brand', $brand);
        $this->render('display_product_details');
    }

    public function update_recipient_details($ord_id, $email, $phone) {
        $this->Order->id = $ord_id;
        $data = array();
        if (!empty($email) && ($email != 'undefined'))
            $data['to_email'] = $email;
        if (!empty($phone) && ($phone != 'undefined'))
            $data['to_phone'] = $phone;
        $this->Order->save($data);
        die;
    }

    public function send_reminder($gpuser_id) {
        $this->layout = 'ajax';
        $gpuser = $this->GroupGift->find('first', array('conditions' => array('GroupGift.id' => $gpuser_id)));
        if (!empty($gpuser['GroupGift']['fb_id'])) {
            $order = $this->Order->findById($gpuser['GroupGift']['order_id']);
            $this->set('uid', $gpuser['GroupGift']['req_id']);
            $this->set('fb_user', $gpuser['GroupGift']['fb_id']);
            $this->set('order', $order);
            $this->render('send_message_friends');
        } else {
            $this->display_send_reminder_mail($gpuser_id);
        }
    }
	
	public function send_giftsetup_mail_sms($ord_id)
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
			$imgs=explode('_',$bask['BrandProduct']['product_thumb']);
			unset($imgs[0]);
			$images=implode('_',$imgs);
			$voucher_img.='<tr>
                          <td><img src="~~SITE_URL~~/files/BrandImage/'.$bask['BrandProduct']['GiftBrand']['gift_category_id'].'/Product/'.$bask['BrandProduct']['product_thumb'].'" alt="" height="70" width="70"></td>
                          <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.str_replace("_","'",$bask['BrandProduct']['voucher_name']).'</td>
                        </tr>';
			}
		}
		$fellow='';
		$arr['FELLOW_GYFTRS']='';
		if($order['Order']['group_gift_id']!=0)
		{
			$gpusers=$this->GroupGift->find('all',array('conditions'=>array('GroupGift.order_id'=>$order['Order']['id'])));
			
			foreach($gpusers as $gp)
			{
				if($gp['GroupGift']['other_user_id']!=$order['User']['id'])
				{
					if(!empty($gp['GroupGift']['email'])) $email=$gp['GroupGift']['email']; else $email='N/A';
					if(!empty($gp['GroupGift']['phone'])) $phone=$gp['GroupGift']['phone']; else $phone='N/A';
					if(empty($gp['GroupGift']['contri_amount_expected'])) 
						$gp['GroupGift']['contri_amount_expected']='N/A';
					else
						$gp['GroupGift']['contri_amount_expected']=	$gp['GroupGift']['contri_amount_expected'].'/-';
					$fellow.='<tr>
							  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.$gp['GroupGift']['name'].'</td>
							  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.$email.'</td>
							  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.$phone.'</td>
							  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.$gp['GroupGift']['contri_amount_expected'].'</td>
							</tr>';	
				}
			}	
		}
		
		$arr['TO_NAME'] = $order['User']['first_name'].' '.$order['User']['last_name'];
		$arr['TO_EMAIL'] = $order['User']['email'];
		$arr['SUBJECT_NAME'] = $order['Order']['to_name'];
		$arr['RECIPIENT'] = $order['Order']['to_name'];
		$arr['MY_POINTS'] = $order['User']['points'];
		$arr['DATE'] = show_formatted_datetime($order['Order']['delivery_time']);
		$arr['VOUCHER_DETAILS'] = '<table width="100%" cellspacing="0" cellpadding="5px" border="1" bordercolor="#000000" bordercolordark="#000000">
                        <tr>
                          <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;"><strong>Voucher</strong></td>
                          <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;"><strong>Details</strong></td>
                        </tr>'.$voucher_img.'</table>';
		if($order['Order']['group_gift_id']!=0)
		{				
			$arr['FELLOW_GYFTRS'] =	'<tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">A Bit about your fellow gyfters…</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><table width="100%" cellspacing="0" cellpadding="5px" border="1" bordercolor="#000000" bordercolordark="#000000">
                        <tr>
                          <td width="25%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;"><strong>Name</strong></td>
                          <td width="25%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;"><strong>Email</strong></td>
                          <td width="25%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;"><strong>Phone Number</strong></td>
                          <td width="25%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;"><strong>Amount</strong></td>
                        </tr>'.$fellow.'</table></td>
                  </tr>';			
		}
		$Mail->sendMail($order['User']['id'], 'gift_setup_mail', $arr,1);
		if(!empty($order['User']['phone']))
		{
			$arr['TO_PHONE']=$order['User']['phone'];
			$Mail->sendSMS($order['User']['id'], 'gift_setup_sms', $arr);	
		}	
	}


    public function send_email_invite_gpuser($gpuser_id) {
        $Mail = new MailController;
        $Mail->constructClasses();
        $arr = array();
        $gpuser = $this->GroupGift->findById($gpuser_id);
		$points=$this->Points->findById('1');
		$this->Order->recursive=3;
		$this->Order->primaryKey='session_id';
		$this->Basket->primaryKey='product_guid';
		$this->BrandProduct->bindModel(array('belongsTo'=>array('GiftBrand'=>array('className'=>'GiftBrand','foreignKey'=>'gift_brand_id'))));
		$this->Basket->bindModel(array('hasOne' => array('BrandProduct' => array('className' => 'BrandProduct','foreignKey' => 'product_guid','fields'=>array('BrandProduct.product_guid','BrandProduct.gift_brand_id','BrandProduct.product_name','BrandProduct.voucher_name','BrandProduct.price','BrandProduct.product_thumb')))),false);
		
		$this->Order->bindModel(array('hasMany' => array('Basket' => array('className' => 'Basket','foreignKey' => 'session_id')),
									  'belongsTo'=>array('User'=>array('className'=>'User','foreignKey'=>'from_id'))),false);
		
        $order = $this->Order->find('first', array('conditions' => array('Order.id' => $gpuser['GroupGift']['order_id'])));
        $req_id = String::uuid();
        $from_id = $this->Session->read('User.User.id');
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
			//if($gp['GroupGift']['other_user_id']!=$order['User']['id'])
			//{				
				$fellow.=' <tr>
                          <td width="60" align="left"><img src="cid:bullet" alt=""></td>
                          <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.$gp['GroupGift']['name'].'</td>
                        </tr>';	
			//}
		}
		if($gpuser['GroupGift']['email']!=$this->Session->read('User.User.email'))
		{
			$url = "<a href='" . SITE_URL . "/home/index?request_id=" . $req_id . "&req_gpuser_id=" . $gpuser_id . "'>click here</a>";
			$arr['TO_NAME'] = $gpuser['GroupGift']['name'];
			$arr['TO_EMAIL'] = $gpuser['GroupGift']['email'];
			 $arr['TO_PHONE']=$gpuser['GroupGift']['phone'];
			$arr['URL'] = $url;
			$arr['SUBJECT_NAME'] = $order['Order']['to_name'];
			$arr['RECIPIENT'] = $order['Order']['to_name'];
			$arr['OCCASION'] = $order['Order']['occasion'];
			$arr['POINTS'] = $points['Points']['points'];	
			$arr['FELLOW_GYFTRS'] =	' <td><table width="100%" cellpadding="0" cellspacing="0" border="0">'.$fellow.'</table></td>';
			$arr['VOUCHER_DETAILS'] = '<table width="100%" cellspacing="0" cellpadding="5px" border="1" bordercolor="#000000" bordercolordark="#000000">
                        <tr>
                          <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;  line-height:16px; color:#000000;"><strong>Voucher</strong></td>
                          <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;  line-height:16px; color:#000000;"><strong>Details</strong></td>
                        </tr>'.$voucher_img.'</table>';	  
			$Mail->sendMail($from_id, 'groupgift_invitation_mail', $arr,1);
			if(!empty($gpuser['GroupGift']['phone']))
				$this->sendInviteSMS($gpuser['GroupGift']['phone'], 'groupgift_invitation_sms', $arr);
			$this->GroupGift->id = $gpuser_id;
			$this->GroupGift->saveField('req_id', $req_id);
		}
        return;
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

    public function send_propose_user_notif_mail($fromid, $orderid, $count) {
        $Mail = new MailController;
        $Mail->constructClasses();
        $arr = array();
        $order = $this->Order->findById($orderid);
        $to_user = $this->User->findById($order['Order']['from_id']);
        $arr['TO_NAME'] = $to_user['User']['first_name'];
        $arr['TO_EMAIL'] = $to_user['User']['email'];
        $arr['FRIEND_NAME'] = $order['Order']['to_name'];
        $arr['OCCASSION'] = $order['Order']['occasion'];
        $arr['COUNT'] = $count;
        $arr['FOLLOW_URL'] = "<a href='" . SITE_URL . "'>click here</a>";
        $Mail->sendMail($fromid, 'prop_user_notif_mail', $arr);
        return;
    }

    public function display_send_reminder_mail($gpuser_id) {
       
        $Mail = new MailController;
        $Mail->constructClasses();
        $arr = array();
        $gpuser = $this->GroupGift->findById($gpuser_id);
		$points=$this->Points->findById('1');
		$this->Order->recursive=3;
		$this->Order->primaryKey='session_id';
		$this->Basket->primaryKey='product_guid';
		$this->BrandProduct->bindModel(array('belongsTo'=>array('GiftBrand'=>array('className'=>'GiftBrand','foreignKey'=>'gift_brand_id'))));
		$this->Basket->bindModel(array('hasOne' => array('BrandProduct' => array('className' => 'BrandProduct','foreignKey' => 'product_guid','fields'=>array('BrandProduct.product_guid','BrandProduct.gift_brand_id','BrandProduct.product_name','BrandProduct.voucher_name','BrandProduct.price','BrandProduct.product_thumb')))),false);
		
		$this->Order->bindModel(array('hasMany' => array('Basket' => array('className' => 'Basket','foreignKey' => 'session_id')),
									  'belongsTo'=>array('User'=>array('className'=>'User','foreignKey'=>'from_id'))),false);
		
        $order = $this->Order->find('first', array('conditions' => array('Order.id' => $gpuser['GroupGift']['order_id'])));
        $req_id = String::uuid();
        $from_id = $this->Session->read('User.User.id');
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
			//if($gp['GroupGift']['other_user_id']!=$order['User']['id'])
			//{				
				$fellow.=' <tr>
                          <td width="60" align="left"><img src="cid:bullet" alt=""></td>
                          <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#000000;">'.$gp['GroupGift']['name'].'</td>
                        </tr>';	
			//}
		}
		if($gpuser['GroupGift']['email']!=$this->Session->read('User.User.email'))
		{
			$url = "<a href='" . SITE_URL . "/home/index?request_id=" . $req_id . "&req_gpuser_id=" . $gpuser_id . "'>click here</a>";
			$arr['TO_NAME'] = $gpuser['GroupGift']['name'];
			$arr['TO_EMAIL'] = $gpuser['GroupGift']['email'];
			 $arr['TO_PHONE']=$gpuser['GroupGift']['phone'];
			$arr['URL'] = $url;
			$arr['SUBJECT_NAME'] = $gpuser['GroupGift']['name'];
			$arr['SUB_FROM_NAME'] = $order['Order']['from_name'];
			$arr['RECIPIENT'] = $order['Order']['to_name'];
			$arr['OCCASION'] = $order['Order']['occasion'];
			$arr['DATE'] = show_formatted_datetime($order['Order']['delivery_time']);
			$arr['POINTS'] = $points['Points']['points'];	
			$arr['FELLOW_GYFTRS'] =	' <td><table width="100%" cellpadding="0" cellspacing="0" border="0">'.$fellow.'</table></td>';
			$arr['VOUCHER_DETAILS'] = '<table width="100%" cellspacing="0" cellpadding="5px" border="1" bordercolor="#000000" bordercolordark="#000000">
                        <tr>
                          <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;  line-height:16px; color:#000000;"><strong>Voucher</strong></td>
                          <td width="50%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold;  line-height:16px; color:#000000;"><strong>Details</strong></td>
                        </tr>'.$voucher_img.'</table>';	  
			$Mail->sendMail($from_id, 'reminder_mail', $arr,1);
			if(!empty($gpuser['GroupGift']['phone']))
				$this->sendInviteSMS($gpuser['GroupGift']['phone'], 'reminder_sms', $arr);
			$this->GroupGift->id = $gpuser_id;
			$this->GroupGift->saveField('req_id', $req_id);
		}
        echo '<div id="form_section" style="margin:0 0 5px 0; padding:0%; width:99%; text-align:center;"><span class="select_dele" style="text-align:left;">/ / <strong>Congratulations</strong></span><div style="margin:30px 0 0; width:100%; text-align:center"><img style="float:none" src="'.$this->webroot.'img/form_left_bg.png" alt=""/></div><div style="padding:10px  0 0 0;color:#090;">A reminder has been sent to your friend.</div></div>';
        die;
    
    }

    public function send_reminder_mail() {
        $Mail = new MailController;
        $Mail->constructClasses();
        $arr = array();
        $message = nl2br($this->data['message']);
        $message.="<br><a href='" . SITE_URL . "/home/index?request_id=" . $this->data['req_id'] . "&req_gpuser_id=" . $this->data['gpuserid'] . "'>click here</a> to contribute";
        $from_id = $this->Session->read('User.User.id');
        $arr['message'] = $message;
        $arr['subject'] = 'Reminder for contributing in group gift';
        $Mail->sendContentMail($from_id, $this->data['to_email'], $arr);
        echo $this->data['orderid'];
        die;
    }

    public function get_google_friends($step=0) {
        $data = $this->data;
        
        $fr_data = '';
        
        if (isset($data['resp']['feed']['entry'])) {
            $fr_data = $data['resp']['feed']['entry'];
        }

        $gm_fr = array();
        $i = 0;
        $fdat = array();
        foreach ($fr_data as $fr) {
            if (isset($fr['gd$email']) && (!empty($fr['gd$email'])) && isset($fr['title']['$t']) && (!empty($fr['title']['$t']))) {
                if (isset($fr['gd$email'][0]['address'])) { {

                        $gm_fr[$i]['email'] = $fr['gd$email'][0]['address'];                       
                        $gm_fr[$i]['name'] = $fr['title']['$t'];
                         if ($step != 0) {
                            $string = str_replace(array('"', '\'', '.', ';', ':'), '', $fr['title']['$t']);
                            $fdat[$i]['label'] = $string;
                            $fdat[$i]['value'] = $fr['gd$email'][0]['address'];
                        }
                        $i++;
                    }
                }
            }
        }       	
        $this->Session->write('Google.contacts', $gm_fr);      
        if ($step == 0) {
            die;
        } else {
            $temp = json_encode($fdat);            
            $this->set('userid', $this->Session->read('User.User.id'));
            echo $temp;
            die;
        }
    }

    public function show_google_friends($call=0) {
        $this->layout = 'ajax';
        $gm_friends = $this->Session->read('Google.contacts');
        
        $datfrnds = array();
        foreach ($gm_friends as $gm) {
            if (!empty($gm['name'])) {
                $string = str_replace(array('"', '\''), '', $gm['name']);
                $datfrnds[] = $string;
            }
        }
        $this->set('gm_friends', $gm_friends);
        $this->set('datfrnds', $datfrnds);
		if($call==0)
       	 $this->render('friend_list');
		else
			$this->render('chipin_friend_list'); 
    }
	
	public function get_cms($cmspage)
	{
		$this->layout='ajax';
		if($cmspage=='cancellation')
		{
			$this->render('display_cancellation');	
		}else if($cmspage=='privacy')
		{
			$this->render('display_privacy');
		}else if($cmspage=='contactus')
		{
			$this->render('contactus');
		}else if($cmspage=='tnc')
		{
			$this->render('display_tnc');
		}	
	}
	
		
	public function register_redirect($userid=0)
	{
		$this->layout='ajax';
		if($userid==0)
		{
			$id=$this->Session->read('User.User.id');
			$qrydata = $this->referer();			
			
			$qrydata=explode("/",$qrydata);			
			if($qrydata[count($qrydata)-2]!='update_forget_pass')
			{			
				if(end($qrydata)==0)
				{				
					$gpuser=$qrydata[count($qrydata)-2];	
				}else{
					$gpuser=end($qrydata);
				}
				
				$order_id=$this->GroupGift->find('first',array('conditions'=>array('GroupGift.id'=>$gpuser),'fields'=>array('GroupGift.order_id')));
				$this->set('order_id',$order_id['GroupGift']['order_id']);
			}else{
				$this->set('forget_pass','1');	
			}
		}else{
			$id=$userid;
			$this->set('incomplete_register',1);
		}
		$rg_val=$this->User->findById($id);
		
		$this->set('rg_val',$rg_val);
		$this->Session->delete('User');
		$this->render('register');	
	}
	
	public function gift_not_available()
	{
		$this->layout='ajax';
		echo '<div id="form_section" style="margin:0 0 5px 0; padding:0 1%;"><span class="select_dele">/ / <strong> Oops!</strong></span><div style="margin-top:150px; text-align:center;">Gifts that you have selected are not available currently! Please go back and try again</div>';	
		die;
	}
	
	public function update_forget_pass($id=0)
	{		
		if($id!=0)
		{
			$user=$this->User->findById($id);
			if(!empty($user))
			{
			$is_register=1;	
			$newpass=$this->generateRandomString();
			$this->User->id=$id;
			$this->User->saveField('password',md5($newpass));
			$this->Session->write('User',$user);
			if(empty($user['User']['last_name'])||empty($user['User']['phone'])||empty($user['User']['email'])||empty($user['User']['dob']))
				$is_register=0;	
			if($is_register==0)
			{
				$this->layout='default';
				$this->set('is_register','1');
				$this->render('index');	
			}else{				
				$this->redirect(SITE_URL);	
			}	
			
			}else{
				$this->redirect(SITE_URL);	
			}
		}	
	}
	
	public function generateRandomString($length = 8) {
   		 return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}
	
	public function check_profile_details()
	{
		$user=$this->User->findById($this->Session->read('User.User.id'));
		$is_register=1;
		if(empty($user['User']['last_name'])||empty($user['User']['phone'])||empty($user['User']['email'])||empty($user['User']['dob']))
				$is_register=0;	
		if($is_register==0)
		{
			$this->set('fb_login','1');
			$this->register_redirect($user['User']['id']);	
		}else{
			echo 1;die;	
		}			
	}
	
	
	
	public function use_promo_code()
	{
		
		$this->UserPromo->bindModel(array('belongsTo' => array('Promocode' => array('className' => 'Promocode','foreignKey' => 'promo_id'))));	
		$promo=$this->UserPromo->find('first',array('conditions'=>array('UserPromo.promo_code'=>$this->data['promo_code'],'UserPromo.user_id'=>$this->data['user_id'],'UserPromo.status'=>'Not Used','UserPromo.valid_upto >'=>date("Y-m-d H:i:s"))));
		if(!empty($promo))
		{
			$this->Order->recursive=2;
			$this->Order->primaryKey='session_id';
			$this->Basket->primaryKey='product_guid';
			$this->Basket->bindModel(array('hasOne' => array('BrandProduct' => array('className' => 'BrandProduct','foreignKey' => 'product_guid','fields'=>array('BrandProduct.product_guid','BrandProduct.gift_brand_id','BrandProduct.product_name','BrandProduct.voucher_name','BrandProduct.price')))),false);
			$this->Order->bindModel(array('hasMany' => array('Basket' => array('className' => 'Basket','foreignKey' => 'session_id'))),false);
			$order=$this->Order->findById($this->data['order_id']);
			
			$this->Order->primaryKey='id';
			$this->Order->unbindModel(array('hasMany' => array('Basket')));
			$this->Basket->unbindModel(array('hasOne' => array('BrandProduct')));
			if(empty($order['Order']['promo_code']))
			{
				if(($promo['UserPromo']['order_id']==$order['Order']['id'])||($promo['UserPromo']['order_id']==0))
				{
					$msg=array();
					switch($promo['Promocode']['promo_type'])
					{
						case 1: if($promo['Promocode']['discount_type']=='PureValue')			//Basket Amount
								{
									$discount=$promo['Promocode']['value'];
									$newamount=$order['Order']['total_amount']-$discount;
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$discount;
									$msg['type']=1;
								}else{
									$discount=percentage($promo['Promocode']['value'],$order['Order']['total_amount'],0);
									$newamount=$order['Order']['total_amount']-$discount;
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$promo['Promocode']['value'];	
									$msg['type']=2;
								}								
								break;
						case 2: foreach($order['Basket'] as $bask)								//Brand
								{
									if($bask['BrandProduct']['gift_brand_id']==$promo['Promocode']['brand_id'])
										$product_val=$bask['BrandProduct']['price'];	
								}					
								if($promo['Promocode']['discount_type']=='PureValue')
								{
									$discount=$promo['Promocode']['value'];
									$newamount=$order['Order']['total_amount']-$discount;
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$discount;
									$msg['type']=1;
								}else{
									$discount=percentage($promo['Promocode']['value'],$product_val,0);
									$newamount=$order['Order']['total_amount']-$discount;
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$promo['Promocode']['value'];	
									$msg['type']=2;
								}								
								break;
						case 3: foreach($order['Basket'] as $bask)								//Voucher
								{
									if($bask['BrandProduct']['id']==$promo['Promocode']['product_id'])
										$product_val=$bask['BrandProduct']['price'];	
								}					
								if($promo['Promocode']['discount_type']=='PureValue')
								{
									$discount=$promo['Promocode']['value'];
									$newamount=$order['Order']['total_amount']-$discount;
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$discount;
									$msg['type']=1;
								}else{
									$discount=percentage($promo['Promocode']['value'],$product_val,0);
									$newamount=$order['Order']['total_amount']-$discount;
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$promo['Promocode']['value'];	
									$msg['type']=2;
								}								
								break;
						case 4: if($promo['Promocode']['discount_type']=='PureValue')					//Transaction Amount
								{
									$discount=$promo['Promocode']['value'];
									$newamount=$order['Order']['total_amount']-$discount;
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$discount;
									$msg['type']=1;
								}else{
									$discount=percentage($promo['Promocode']['value'],$order['Order']['total_amount'],0);
									$newamount=$order['Order']['total_amount']-$discount;
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$promo['Promocode']['value'];	
									$msg['type']=2;
								}
								$this->User->id=$this->data['user_id'];
								$this->User->saveField('transaction_promo',$promo['Promocode']['value']);								
								break;
						case 5: if($promo['Promocode']['discount_type']=='PureValue')					//Season
								{
									$discount=$promo['Promocode']['value'];
									$newamount=$order['Order']['total_amount']-$discount;
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$discount;
									$msg['type']=1;
								}else{
									$discount=percentage($promo['Promocode']['value'],$order['Order']['total_amount'],0);
									$newamount=$order['Order']['total_amount']-$discount;									
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$promo['Promocode']['value'];	
									$msg['type']=2;
								}								
								break;	
						case 6: if($promo['Promocode']['discount_type']=='PureValue')  			//Occasion
								{
									$discount=$promo['Promocode']['value'];
									$newamount=$order['Order']['total_amount']-$discount;
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$discount;
									$msg['type']=1;
								}else{
									$discount=percentage($promo['Promocode']['value'],$order['Order']['total_amount'],0);
									$newamount=$order['Order']['total_amount']-$discount;									
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$promo['Promocode']['value'];	
									$msg['type']=2;
								}								
								break;	
						case 7: if($promo['Promocode']['discount_type']=='PureValue')				//On Registration	
								{
									$discount=$promo['Promocode']['value'];
									$newamount=$order['Order']['total_amount']-$discount;
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$discount;
									$msg['type']=1;
								}else{
									$discount=percentage($promo['Promocode']['value'],$order['Order']['total_amount'],0);
									$newamount=$order['Order']['total_amount']-$discount;									
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$promo['Promocode']['value'];	
									$msg['type']=2;
								}								
								break;
						case 8: if($promo['Promocode']['discount_type']=='PureValue')				//gifting type
								{
									$discount=$promo['Promocode']['value'];
									$newamount=$order['Order']['total_amount']-$discount;
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$discount;
									$msg['type']=1;
								}else{
									$discount=percentage($promo['Promocode']['value'],$order['Order']['total_amount'],0);
									$newamount=$order['Order']['total_amount']-$discount;									
									$arr=array('promo_code'=>$promo['UserPromo']['id'],'total_amount'=>$newamount);
									$msg['val']=$promo['Promocode']['value'];	
									$msg['type']=2;
								}								
								break;																
					}
					$this->Order->id=$order['Order']['id'];
					$this->Order->save($arr);
					$this->UserPromo->id=$promo['UserPromo']['id'];
					$this->UserPromo->saveField('status','Used');
					
					$this->set('promocode','2');
					$this->set('msg',$msg);
				}else{
					$this->set('promocode','1');
				}					
			}else{
				$this->set('promocode','1');
			}
		}else{
			$this->set('promocode','1');	
		}
		
		$this->view_order_details($this->data['order_id']);
	}
	
	public function success_promo_discount($msg,$tp)
	{
		if($tp==2) 
			$msg=$msg. '%';
		else 
			$msg='Rs. '.$msg;	 
		echo '<div id="form_section" style="margin:0 0 5px 0; padding:0%; width:99%; text-align:center; min-height:288px;"><span class="select_dele" style="text-align:left;">/ / <strong>Congratulations</strong></span><div style="margin:30px 0 0; width:100%; text-align:center"><img style="float:none" src="'.$this->webroot.'img/form_left_bg.png" alt=""/></div><div style="padding:10px  0 0 0;color:#090;">You\'ve used promo code to avail discount of '.$msg.'</div></div>';
        die;	
	}
	
	
	public function redeem_voucher_code($code,$order_id,$user_id)
	{
		$msg=array();
		if(!empty($code))
		{
			$fchar=substr($code,0,1);
			if(strtolower($fchar)!='m')
			{
				$url="https://pos.vouchagram.com/service/restserviceimpl.svc/BatchConsume?deviceCode=P&merchantUid=".urlencode(MBUID)."&shopCode=".urlencode(MBSHOP)."&voucherNumber=".$code."&Password=".urlencode(MBPass)."&requestjobnumber=".$order_id;	
				//echo $url;
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
						$this->VoucherLog->create();
						$this->VoucherLog->save(array('code'=>$voucher->VOUCHERNUMBER,'order_id'=>$order_id,'user_id'=>$user_id,'status'=>1,'created'=>date("Y-m-d H:i:s")));
						$msg=array('result'=>'success','voucher_value'=>$voucher->VALUE,'voucher_code'=>$voucher->VOUCHERNUMBER,'text'=>'');					
												
					}else{
						$msg=array('result'=>'error','voucher_value'=>'','voucher_code'=>'','text'=>$arr->ErrorMsg);	
					}
				}else{
					$msg=array('result'=>'error','voucher_value'=>'','voucher_code'=>'','text'=>'There is some issue. Please try again later');	
				}
			}else{
				$msg=array('result'=>'error','voucher_value'=>'','voucher_code'=>'','text'=>'Invalid Voucher Code');
			}
		}else{
			$msg=array('result'=>'error','voucher_value'=>'','voucher_code'=>'','text'=>'Invalid Voucher Code');
		}
		return $msg;
			
	}
	
	
	public function use_voucher_code()
	{
		$msg=$this->redeem_voucher_code(trim($this->data['voucher_code']),$this->data['order_id'],$this->data['user_id']);
		if(!empty($msg))
		{
			/*$msg['result']='success';
			$msg['voucher_code']=123;
			$msg['voucher_value']=10;*/
			if($msg['result']=='success')
			{
				$order=$this->Order->find('first',array('conditions'=>array('Order.id'=>$this->data['order_id'])));
				$amount_paid=$order['Order']['amount_paid']+intval($msg['voucher_value']);
				$data=array('amount_paid'=>$amount_paid,'voucher_code'=>$msg['voucher_code'],'voucher_value'=>$msg['voucher_value']);
				if(($order['Order']['total_amount']-$amount_paid)<=0)
				{
					$data['payment_status']=1;
					$this->set('payment_success',1);	
				}
				$this->Order->id=$order['Order']['id'];
				$this->Order->save($data);
				
			}else{
				
				$this->set('vouchercode',1);
				$this->set('vouchererror',$msg['text']);
			}
		}else{
			$this->set('vouchercode',1);
			$this->set('vouchererror','There is some issue. Please try again later');			
		}
		$this->view_order_details($this->data['order_id']);				
	}
	
	
	
	
	

}