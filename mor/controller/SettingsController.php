<?php
class SettingsController extends AppController {

	public $name = 'Settings';
	public $helpers = array('Form', 'Html', 'Js','Session');
	public $paginate = array('limit' => 10);	
	public $uses=array('Content','Recharge','Operator','RechargeType','Setting');	
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow(array('index'));		
	}	
	
	function admin_service_charge() {
		$this->layout='admin';			
		
		$rechargeTypes = $this->RechargeType->find('all');
		$this->set('RechargeTypes',$rechargeTypes);
		
		if($this->request->is('post') || $this->request->is('put')){
			$arrData=array();
			
			$data=$this->request->data;			
			$this->set('ReqData',$data);			
			
			if($data){
				
				$err='';
				foreach($rechargeTypes as $rtype){
					
					$this->RechargeType->set(array('RechargeType'=>array('service_charge'=>$data['ServiceCharge'][$rtype['RechargeType']['id']])));
					
					if($this->RechargeType->validates(array('filedList'=>array('service_charge')))){
						$arrData[]=array('RechargeType'=>array('id'=>$rtype['RechargeType']['id'],
					'service_charge'=>$data['ServiceCharge'][$rtype['RechargeType']['id']]));
					}else{
						$err.='-'.$this->RechargeType->validationErrors['service_charge'][0]." for {$rtype['RechargeType']['recharge_type']}<br/>";
					}
				}
				
				if(empty($err)){
					
					if($this->RechargeType->saveAll($arrData)){
						
						$this->Session->setFlash(__('The service charges saved successfully.'),'default',array('class'=>'success'));
						$this->redirect(array('action'=>'service_charge'));die;
						
					}else{
						
						$this->Session->setFlash(__('The service charge could not be saved.'),'default',array('class'=>'error'));
						$this->redirect(array('action'=>'service_charge'));die;
					}
				}else{					
					
					$this->Session->setFlash(__("Validation error occur.Please correct the below error(s).<br/>{$err}"),'default',array('class'=>'error'));
					
				}
			}
		}
	}
	
	function admin_settings() {
		$this->layout='admin';		
		
		$rOption = $this->Setting->findByKey('recharge_option');
		$this->set('Settings',$rOption);
		
	}
	
	function admin_change_recharge_option() {
		$this->layout='ajax';			
		
		$rOption = $this->Setting->findByKey('recharge_option');
		
		$arrData=array('Setting'=>array('key'=>'recharge_option',
			 'value'=>$this->request->data['Setting']['recharge_option']));
		if($rOption){
			 $this->Setting->id=$rOption['Setting']['id'];		 
			
		} 
		$this->Setting->save($arrData,false);
		echo "<div class='success'>Setting saved successfully</div>";
		die;
	}
}
