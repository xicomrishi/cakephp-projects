<?php

class CronController extends AppController {    
	 public $uses = array('GiftCategory','GiftBrand');
	 public function beforeFilter() {		
		ini_set("memory_limit","2400M");
		ini_set("max_execution_time","0");
		
	 }
	 
	public function import_data()
	{
		//$this->delete_existing_data();
		$gift_cats=$this->get_category_list();
		
		echo '<br>Cron run status: success';die;		
	}
	
	public function delete_existing_data()
	{
		$this->GiftCategory->query('truncate table gyftr_gift_category');
		$this->GiftBrand->query('truncate table gyftr_gift_brands');		
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
		
		foreach($arr as $ar)
		{		
			$data=array('cat_id'=>$ar['id'],'name'=>$ar['name'],'status'=>'1');
			$this->GiftCategory->create();
			$info=$this->GiftCategory->save($data);				
			$this->get_category_product($ar['id'],$info['GiftCategory']['id']);			
		}		
		return $arr;		
	}
	
	
	public function get_category_product($cat_id,$id)
	{
		$arr=array();
		$url="https://catalog.vouchagram.com/EPService.svc/xCategoryProduct?buyerGUID=".MID."&password=".MPass."&catalogcategoryguid=".$cat_id;
		echo $url; die;
		$resp=simplexml_load_file($url);
		$brand=element_set('Merchant',$resp[0],false);
		$i=0;
		
		foreach($brand as $bd)
		{			
			$cat_product=element_set('Product',$bd,false);
			if(!empty($cat_product))
			{
				$j=0;
				foreach($cat_product as $cp)
				{
					$arr[$i]['product'][$j]['pname']=value_in('ProductName',$cp,true);					
					$j++;
				}
			}			
			$i++;
		}		
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
	
 
	 
}