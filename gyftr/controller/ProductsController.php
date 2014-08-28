<?php
App::import('Vendor',array('functions','xmltoarray','xml_regex'));
class ProductsController extends AppController {

	public $name = 'Products';
	public $helpers = array('Form', 'Html','Js' => array('Jquery'));
	public $paginate = array('limit' => 5);	
	public $components=array('Session','Access');
	public $uses=array('User','UserRole','BrandProduct','Voucherinfo','Shops','Order','Voucher','GiftBrand');

	
	function beforeFilter(){
		parent::beforeFilter();	 
		//$this->Access->isValidUser();
		
	}
	
	public function admin_index()
	{
		$this->layout='admin';
		$products=$this->BrandProduct->find('all');	
		$this->set('showtabs','1');
		$this->set('products',$products);
	}
	
	public function get_product_details()
	{
		$this->layout='ajax';
		$product=$this->BrandProduct->find('first',array('conditions'=>array('BrandProduct.voucher_name'=>$this->data['pr_name'])));
		//echo '<pre>';print_r($product);die;	
		$this->set('showtabs','1');
		$this->set('product',$product);
		$this->render('product_details');
	}
	
	public function get_module($mod)
	{
		$this->layout='ajax';
		$pr_id=$this->data['pr_id'];
		$this->set('pr_id',$pr_id);
		$product=$this->BrandProduct->find('first',array('conditions'=>array('BrandProduct.id'=>$pr_id)));
		$this->set('product',$product);
		if($mod=='shops_li')
		{
			$shops=$this->Shops->find('all',array('conditions'=>array('Shops.brand_product_id'=>$pr_id)));
			$this->set('shops',$shops);	
			$this->render('shops_details');
		}else if($mod=='tnc_li'){
			
			$this->render('product_details');
		}else{
			$brand=$this->GiftBrand->findById($product['BrandProduct']['gift_brand_id']);
			$this->set('brand',$brand);	
			$this->render('voucher_details');
		}
		
	}
	
	public function edit_shop($id,$pr_id)
	{
		$this->layout='ajax';
		$shop=$this->Shops->findById($id);
		$this->set('shop',$shop);
		$this->set('product_id',$pr_id);
		$this->render('edit_shop');
	}
	
	public function save_shop_details()
	{
		$this->layout='ajax';
		$this->Shops->id=$this->data['id'];
		$this->Shops->save($this->data);
		die;	
	}
	
	public function update_tnc($id)
	{
		$this->layout='ajax';
		$this->BrandProduct->id=$id;
		$this->BrandProduct->saveField('product_tnc',$this->data['terms']);	
		die;
	}
	
	public function get_terms($pr_id,$is_loc='')
	{
		$this->layout='ajax';		
		$product=$this->BrandProduct->find('first',array('conditions'=>array('BrandProduct.id'=>$pr_id)));	
		$shops=$this->Shops->find('all',array('conditions'=>array('Shops.brand_product_id'=>$product['BrandProduct']['id']),'order'=>array('Shops.city ASC')));
		$cities = array();
        foreach ($shops as $sh) {
            if (!in_array($sh['Shops']['city'], $cities))
                $cities[] = $sh['Shops']['city'];
        }
		if(!empty($is_loc))
			$this->set('is_loc',$is_loc);
        $this->set('cities', $cities);
		$this->set('product',$product);
		$this->set('shops',$shops);
		$this->render('terms_popup');	
	}
	
	public function voucher_status()
	{
		$this->layout='ajax';
		
		$id=$this->data['voucherid'];
		$id=trim($id);	
		$arr=array();
		//$id="0b1894e5-4023-4c69-8cc4-4f34613ca0de";
		$url="https://pos.vouchagram.com/service/RestServiceImpl.svc/aQueryvoucher?userid=1&VoucherNumber=".$id."&password=".urlencode("fqBCS3PFEgdoJeuL1XnB+A==");
		//echo $url; die;
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
		$resp = curl_exec($ch); //execute post and get results
		curl_close ($ch);
		//echo '<pre>';print_r($resp);die;
		$response=json_decode($resp);
		if(isset($response->AQueryVoucherResult[0]))
			$arr=$response->AQueryVoucherResult[0];
	    
		if(strtolower($arr->ResultType)=="success")
		{
			$product=$this->BrandProduct->findByVoucherNameAndVoucherTypeAndPrice($arr->ProductName,$arr->VoucherType,$arr->Value);
			
			if(!empty($product))
			{
				
				$brand=$this->GiftBrand->find('first',array('conditions'=>array('GiftBrand.id'=>$product['BrandProduct']['gift_brand_id'])));
				$shops=$this->Shops->find('all',array('conditions'=>array('Shops.brand_product_id'=>$product['BrandProduct']['id']),'order'=>array('Shops.city ASC')));
				$cities = array();
				foreach ($shops as $sh) {
					if (!in_array($sh['Shops']['city'], $cities))
						$cities[] = $sh['Shops']['city'];
				}	
				$this->set('cities',$cities);
				$this->set('brand',$brand);
			}
			
			$this->set('data',$arr);	
		}else{
			$this->set('not_found','1');	
		}		
		$this->render('order_status_page');			
	}
	
	public function get_terms_for_voucher()
	{
		$this->layout='ajax';
		$pname=$this->data['pname'];
		$vtype=$this->data['vtype'];
		$value=$this->data['value'];
		$loc=$this->data['loc'];
		$product=$this->BrandProduct->findByVoucherNameAndVoucherTypeAndPrice($pname,$vtype,$value);
		
		if(!empty($product))
		{
			$this->get_terms($product['BrandProduct']['id'],$loc);	
		}else{			
			$this->set('not_found','1');
			$this->render('order_status_page');		
		}
	}
	
	public function get_dealers()
	{
		$this->layout='ajax';
		$dealers=$this->Shops->find('all',array('conditions'=>array('Shops.brand_product_id'=>$this->data['product_id'])));
		$arr=array();
		if(!empty($dealers))
		{
			foreach($dealers as $sh)
			{
				if($sh['Shops']['city']==$this->data['dealer_city'])	
					$arr[]=$sh;
			}
		}
		//echo '<pre>';print_r($arr);die;
		$this->set('dealer',$arr);
		$this->render('dealers_info');
	}
	
	public function save_voucher_details()
	{
		$this->BrandProduct->id=$this->data['product_id'];
		$this->BrandProduct->save($this->data);
		die;	
	}
	
	/*public function admin_add_product()
	{
		$this->render('admin_add_product');	
	}*/
	
}