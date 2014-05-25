<?php
class ConfigController extends AppController {

	public $name = 'Config';
	public $helpers = array('Form', 'Html', 'Js');
	public $uses=array('Config');
	
	
	public function admin_index() {
		$this->layout='admin';
		if(!empty($this->data))
		{
			$exist=$this->Config->find('first',array('conditions'=>array('Config.voucher_value'=>$this->data['Config']['voucher_value'])));
			$this->Config->id=$exist['Config']['id'];
			$this->Config->saveField('display_value',$this->data['Config']['display_value']);
			$this->Session->setFlash(__("Voucher usable value has been updated",true),'default',array('class'=>'success'));
			$this->redirect(array('action' => 'index','admin'=>true));
		}
		
		$data=$this->Config->find('first',array('conditions'=>array('Config.voucher_value'=>400)));
		$this->set('data',$data);
		
	}
	
	
}