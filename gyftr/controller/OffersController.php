<?php
App::uses('AppController', 'Controller');
App::import('Vendor', array('functions'));
class OffersController extends AppController {
	
	public $helpers = array('Form', 'Html','Js' => array('Jquery'));
	public $components=array('Session','Access');
	public $uses=array('Offer','GiftBrand','BrandProduct','Basket','Order','UserPromo','User','GiftCategory');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Access->isValidUser();	
		$this->layout='admin';					
	}
	
	public function admin_index() {
		
		$this->set('offers', $this->paginate('Offer'));
	}


	public function admin_add() {
		if ($this->request->is('post')) {
			
			if(!empty($this->data))
			{
				$data=$this->data;
				if($data['Offer']['offer_type']=='1')
					$data['Offer']['brand_product_id']='';
				else
					$data['Offer']['gift_brand_id']='';			
			}
			$error_msg='';
			if(!empty($data['Offer']['image']))
			{
				if(!empty($data['Offer']['image']['tmp_name']))
				{
					if($data['Offer']['image']['size']<2097152)    // max. 2MB size allowed
					{
						$arr_img = explode(".", $data['Offer']["image"]["name"]);
						$ext = strtolower($arr_img[count($arr_img) - 1]);
						
						if ($data['Offer']["image"]['error'] == 0 && in_array($ext,array('jpg','gif','png','jpeg'))){
							if(!is_dir(WWW_ROOT . 'files' . DS . 'Offers')) {
								mkdir(WWW_ROOT . 'files' . DS . 'Offers',0777);
							}
							$folder=WWW_ROOT.'files/Offers';
							$fname = removeSpecialChar($data['Offer']["image"]['name']);
							$file = time() . "_" . $fname;
							upload_my_file($data['Offer']["image"]['tmp_name'], $folder .'/'. $file);
							$data['Offer']['image']=$file;
						}else{								
							$error_msg='Image was not uploaded: Invalid extension (Only jpg,jpeg,gif,png files are allowed)';
							$data['Offer']['image']='';	
						}								
					}else{
						$error_msg='Image was not uploaded: Image size exceeds max. limit (Max. 2Mb upload size)';	
						$data['Offer']['image']='';
					}
				}
			}
			
			$this->Offer->create();
			if ($this->Offer->save($data)) {
				$this->Session->setFlash(__('The offer has been saved'.$error_msg));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The offer could not be saved. Please, try again.'.$error_msg));
			}
		}else{
			
			$giftcat=$this->GiftCategory->find('all');
			$data=array(); $i=0;
			foreach($giftcat as $gcat)
			{
				$data[$i]['category']=$gcat['GiftCategory'];
				$data[$i]['brands']=$this->GiftBrand->find('all',array('conditions'=>array('GiftBrand.gift_category_id'=>$gcat['GiftCategory']['id'])));
				
				if(!empty($data[$i]['brands']))
				{
					$j=0;
					foreach($data[$i]['brands'] as $br)
					{
						$allbrands[]=$br;
						$data[$i]['brands'][$j]['products']=$this->BrandProduct->find('all',array('conditions'=>array('BrandProduct.gift_brand_id'=>$br['GiftBrand']['id'])));
						if(!empty($data[$i]['brands'][$j]['products']))
						{
							foreach($data[$i]['brands'][$j]['products'] as $pr)
							{
								$pr['BrandProduct']['gift_category_id']=$gcat['GiftCategory']['id'];
								$allproducts[]=$pr;	
							}	
						}
						
						//$allproducts[]=$data[$i]['brands'][$j]['products'];
						$j++;
					}
				}
				$i++;	
			}
			//pr($allproducts); die;
			
/*			$this->GiftBrand->bindModel(array('belongsTo' => array('GiftCategory' => array('className' => 'GiftCategory','foreignKey' => 'gift_category_id'))),false);
			$brands=$this->GiftBrand->find('all',array('group'=>array('GiftBrand.name'),'fields'=>array('GiftBrand.id','GiftBrand.name','GiftBrand.gift_category_id','GiftCategory.*')));
			$products=$this->BrandProduct->find('all',array('group'=>array('BrandProduct.product_guid'),'fields'=>array('BrandProduct.id','BrandProduct.gift_brand_id','BrandProduct.voucher_name','BrandProduct.product_guid'),'order'=>array('BrandProduct.product_name ASC')));*/
			
			$this->set('giftcat',$giftcat);
			$this->set('allbrands',$allbrands);
			$this->set('allproducts',$allproducts);
			/*$this->set('brands',$brands);
			$this->set('products',$products);*/	
		}
	}




	public function admin_delete($id = null) {
		$this->Offer->id = $id;
		if (!$this->Offer->exists()) {
			throw new NotFoundException(__('Invalid offer'));
		}else{
			$offer=$this->Offer->findById($id);
			
			if ($this->Offer->delete()) {
				unlink(WWW_ROOT.'files/Offers/'.$offer['Offer']['image']);
				$this->Session->setFlash(__('Offer deleted'));
				$this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Offer was not deleted'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
