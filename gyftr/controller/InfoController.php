<?php
App::uses('Sanitize', 'Utility');
App::import('Vendor', array('functions'));
class InfoController extends AppController {

	public $name = 'Info';
	public $helpers = array('Form', 'Html','Js' => array('Jquery'));	
	public $components=array('Session');
	public $uses=array('User','Order','Voucher','Points','GiftBrand','GroupGift','Shops','BrandProduct','Cmse','GiftCategory','Offer','Promocode');
	
	public function view_brand_terms($brname=null)
	{
		$this->layout='default';
		$temp=$this->params['slug'];
		if(empty($temp)){
			$temp=$brname;	
		}
		$temp=Sanitize::clean($temp, array('encode' => false));	
		
		if(strtolower($temp)=='ccd')		
			$this->redirect('https://shop.cafecoffeeday.com/');
			
		/*-----Custom keywords for brands as per client requirement-----*/
		if(strtolower($temp)=='dominos' || strtolower($temp)=='dominos-online' || strtolower($temp)=='domino\'s-pizza-online' || strtolower($temp)=='dominos-tnc')
			$temp='domino_s-pizza-online';
		if(strtolower($temp)=='bms')
			$temp='book-my-show';
		if(strtolower($temp)=='jack-jones')
			$temp='jack-&-jones';
		if(strtolower($temp)=='vero-moda')
			$temp='veromoda';
		if(strtolower($temp)=='rubys-bar-grill')
			$temp='ruby_s-bar-&-grill';
		if(strtolower($temp)=='dibella')
			$temp='di-bella';					
			
		///////////////////////////////////////////////////////////////////////		
			
		$sql="select G.* from gyftr_gift_brands G where LOWER(REPLACE(REPLACE(G.name,' ','-'),'_','\'')) LIKE '%".$temp."%'";		
		$brand=$this->GiftBrand->query($sql);		
		if(!empty($brand))
		{
			$product=$this->BrandProduct->find('first',array('conditions'=>array('BrandProduct.gift_brand_id'=>$brand[0]['G']['id'])));
			$shops=$this->Shops->find('all',array('conditions'=>array('Shops.brand_product_id'=>$product['BrandProduct']['id']),'order'=>array('Shops.city ASC')));
			$cities = array();
       		foreach ($shops as $sh) {
            if (!in_array($sh['Shops']['city'], $cities))
                $cities[] = $sh['Shops']['city'];
        	}
			
			$this->set('brand',$brand[0]['G']['name']);
        	$this->set('cities', $cities);
			$this->set('product',$product);
			$this->set('shops',$shops);			
			$this->render('tnc_page');		
		}else{
			$this->redirect(SITE_URL);	
		}
	}
	
	public function cms_page($page)
	{
		$content=$this->Cmse->findByPageSlug($page);
		//print_r($content);die;			
		$this->set('content',$content);
		$this->render('cms_page');
	}
	
	public function get_brands_logo()
	{
		 $data='';
		 foreach(glob(WWW_ROOT.'files/Logos/*.*') as $filename){
    		
			 $data.='<li><a href="javascript://"><img src="'.$this->webroot.'files/Logos/'.basename($filename).'" alt="'.basename($filename,'.jpg').'"></a></li>';
		 }
		echo $data;		
	}
	
	public function get_categories()
	{
		$this->GiftCategory->bindModel(array('hasMany' => array('GiftBrand' => array('className' => 'GiftBrand','foreignKey' => 'gift_category_id'))),false);
		$cats=$this->GiftCategory->find('all',array('conditions'=>array('GiftCategory.status'=>'1')));
		$data=''; $i=0; $style=$class=''; 
		foreach($cats as $ct)
		{
			if($i>4)
			{	
				$style='style="display:none;"';
				$class='hidden_cats';
			}
			$data.='<div class="sections '.$class.'" '.$style.'><ul><li class="first">'.$ct['GiftCategory']['name'].': </li>';
			foreach($ct['GiftBrand'] as $ind=>$gb)
			{
				if(end(array_keys($ct['GiftBrand']))==$ind) $class='last'; else $class='';
				$data.='<li class="'.$class.'"><a href="'.$this->webroot.str_replace(' ','-',$gb['name']).'">'.str_replace('_','\'',$gb['name']).'</a></li>';	
			}	
			$data.='</ul></div>';
			
			$i++;
		}
		$data.='<div class="more_cats"><a href="javascript://" onclick="show_hidden_cats();">More</a></div>';
		echo $data;
	}
	
	public function get_bottom_page()
	{		
		$page=$this->data['page'];		
		$this->layout='ajax';
		$this->render('bottom_content_'.$page);	
	}
	
	public function get_discount_offers($count=3)
	{
		$offer=$this->Offer->find('all',array('conditions'=>array('Offer.status'=>'Active','Offer.start_date <='=>date("Y-m-d"),'Offer.end_date >='=>date("Y-m-d"))));	
		$data='';
		if(!empty($offer))
		{
		$data.='<div class="inner_container">
   		<h3>best <span>brands</span> best <span>offers</span></h3>
            <div class="wrapper"><div class="brand_container"><div class="brand_inner_cont">';
		if(!empty($offer))
		{	
			$i=0; $num=1;
			$date=date("Y-m-d");
			foreach($offer as $off)
			{
				if($date>=$off['Offer']['start_date']&&$date<=$off['Offer']['end_date'])
				{
					$cl='';
					if($i%$count==0&&$i!=0)
					{	$data.='</div><div class="brand_inner_cont">';
						//$num++; 
					}			
					if($num%3==0&&$num!=0)
						$cl='last_cont';			
					if($off['Offer']['discount_type']=='PureValue')
						$discount='Rs. '.$off['Offer']['value'];
					else
						$discount=$off['Offer']['value'].'%';	
					
					$data.='<div class="discount_cont '.$cl.'"><a href="javascript://"><img src="'.$this->webroot.'files/Offers/'.$off['Offer']['image'].'" alt="Offers"/></a><span class="detail">'.$off['Offer']['title'].'</span><span class="offer">get '.$discount.' off</span><span class="add_card" onclick="$(\'html, body\').animate({scrollTop: \'0px\'}, 600);return nextStep(\'step-2\',\'start\');">add to cart</span></div>';	
					$i++; $num++;
				}
			}				
		}
		$data.='</div></div><div class="brand_paging">
                 <ul class="paging_bottom_home">';
	
		$data.='</ul></div>';
		if($count==3)
			$data.='<div class="more_cats"><a href="'.$this->webroot.'offers">View all</a></div>';
		$data.='</div></div>';
		}
		echo $data;
	}
	
	public function get_promo_codes()
	{
		$promo=$this->Promocode->find('all',array('conditions'=>array('Promocode.status'=>'Active','Promocode.start_date <='=>date("Y-m-d"),'Promocode.end_date >'=>date("Y-m-d"))));
		$data='';
		if(!empty($promo))
		{
			
		$data.='<div class="scroll-pane horizontal-only">
                    	<div class="offer_percent" style="width:4000px;">';
		$i=1;
		foreach($promo as $pr)
		{
			if($pr['Promocode']['promo_type']!=7&&$pr['Promocode']['promo_type']!=9)
			{
			if($pr['Promocode']['discount_type']=='PureValue')
				$discount='Rs.'.$pr['Promocode']['value'];
			else
				$discount=$pr['Promocode']['value'].'%';			
			
			$data.='<div class="common_box middle">
                        	<span class="header">'.$discount.' off</span>
                        	<h3>'.$this->generateRandomString(7).'</h3>
                        	<div class="inner">
                        		<span class="valid"><strong>Valid Till :</strong> '.show_formatted_date($pr['Promocode']['end_date']).'</span>
                            	<p>'.$pr['Promocode']['description'].'</p>
                            	
                        	</div>
                    	</div>';
			$i++;
			}			
		}
			$data.=' </div></div>';
		
		}
		echo $data;
	}
	
	public function bottom_section_page($page)
	{
			$this->set('page',$page);
			$this->render('bottom_section_page');
	}

	public function generateRandomString($length = 5) {
   		 return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}
	
	public function get_default_bottom()
	{
		$this->layout='ajax';
		$this->render('bottom_section_default');	
	}
	
	public function get_bottom_page_ajax($page)
	{
		$this->layout='ajax';
		$this->render('ajax/bottom_content_'.$page);
	}
	
	public function brand_page($brname=null){
		
		$this->layout='brandpage';
		$brand=$this->params['slug'];
		if(empty($brand)){
			$brand=$brname;
		}
		
		$brand=Sanitize::clean($brand, array('encode' => false));	
		
		if(strtolower($brand)=='dominos' || strtolower($brand)=='dominos-online' || strtolower($brand)=='domino\'s-pizza-online' || strtolower($brand)=='domino'){
			$brand='domino_s-pizza-online';
			$render='dominos';	
		}else if(strtolower($brand)=='bata'){
			$brand=$render='bata';
		}else if(strtolower($brand)=='bookmyshow'){
			$brand='book-my-show---winpin-code';
			$render='bookmyshow';
		}
			
		$sql="select G.* from gyftr_gift_brands G where LOWER(REPLACE(REPLACE(G.name,' ','-'),'_','\'')) LIKE '%".$brand."%'";		
		
		$giftbrand=$this->GiftBrand->query($sql);
		
		if(!empty($giftbrand)){
			
			$allbrands=$this->GiftBrand->find('all');
						
			$this->Offer->recursive=2;			
			$this->Offer->primaryKey='gift_brand_id';
			$this->Offer->bindModel(array('hasMany'=>array('BrandProduct'=>array('className'=>'BrandProduct','foreignKey'=>'gift_brand_id'))));
			$offers=$this->Offer->find('all',array('conditions'=>array('Offer.status'=>'Active','Offer.start_date <='=>date("Y-m-d"),'Offer.end_date >='=>date("Y-m-d"),'Offer.gift_brand_id'=>$giftbrand[0]['G']['id'])));
			
			$allcount=$dealcount=0;
			$alloffers=$already_products=array(); $i=0;
			if(!empty($offers)){
				foreach($offers as $off){
					if(!empty($off['BrandProduct'])){
						foreach($off['BrandProduct'] as $brp){
							$alloffers[$i]=$brp;
							$alloffers[$i]['offer']=$off['Offer'];
							if($off['Offer']['discount_type']=='PureValue'){
								
								$alloffers[$i]['offer_price']='Rs. '.intval($brp['price'])-intval($off['Offer']['value']);
							}else{								
								$newprice=$brp['price']-(($off['Offer']['value']/100)*$brp['price']);
								$alloffers[$i]['offer_price']='Rs. '.$newprice;
							}
							$alloffers[$i]['display_in']=1;  //Display in Best Deals Tab
							$already_products[]=$brp['id'];
							$i++;	
						}
					}					
				}	
			}
			
			$dealcount=$i;			
			$products=$this->BrandProduct->find('all',array('conditions'=>array('BrandProduct.gift_brand_id'=>$giftbrand[0]['G']['id']),'order'=>array('cast(BrandProduct.price as UNSIGNED) ASC')));
			
			if(!empty($products)){
				
				$shops=$this->Shops->find('all',array('conditions'=>array('Shops.brand_product_id'=>$products[0]['BrandProduct']['id']),'order'=>array('Shops.city ASC')));
				$cities = array();
				foreach ($shops as $sh) {
				if (!in_array($sh['Shops']['city'], $cities))
					$cities[] = $sh['Shops']['city'];
				}
				$this->set('product_id', $products[0]['BrandProduct']['id']);
				$this->set('cities', $cities);	
			}
			
			$allproducts=array(); 
			foreach($products as $pr){
				if(!in_array($pr['BrandProduct']['id'],$already_products)){
					$alloffers[$i]=$pr['BrandProduct'];					
					$i++;
				}
			}
			
			$this->set('allcount',$i);
			$this->set('dealcount',$dealcount);
			$this->set('alloffers',$alloffers);		
			$this->set('allbrands',$allbrands);
			$this->set('allproducts',$allproducts);
			$this->render($render);		
		}else{
			$this->redirect('/');	
		}
	}
	
	public function check_voucher($code=null){
		
		$this->layout='ajax';
		$id=trim($code);	
		$arr=array();
		
		$url="https://pos.vouchagram.com/service/RestServiceImpl.svc/aQueryvoucher?userid=1&VoucherNumber=".$id."&password=".urlencode("fqBCS3PFEgdoJeuL1XnB+A==");
		
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
		$resp = curl_exec($ch); //execute post and get results
		curl_close ($ch);
		
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
		$this->render('voucher_status_popup');			
	}
	
	public function get_outlets($city=null,$pr_id=null){
		if(!empty($city) && !empty($pr_id)){
			$city=str_replace('_',' ',$city);
			$this->layout='ajax';
			$dealers=$this->Shops->find('all',array('conditions'=>array('Shops.brand_product_id'=>$pr_id)));
			$arr=array();
			if(!empty($dealers))
			{
				foreach($dealers as $sh)
				{
					if($sh['Shops']['city']==$city)	
						$arr[]=$sh;
				}
			}
			
			$this->set('dealer',$arr);
			$this->render('dealers_info');
		}else{
			echo 'No Vouchers Available'; die;
		}	
	}
	
}