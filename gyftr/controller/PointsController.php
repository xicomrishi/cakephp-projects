<?php

class PointsController extends AppController {

	public $name = 'Points';
	public $helpers = array('Form', 'Html','Js' => array('Jquery'));
	public $paginate ='';	
	public $components=array('Session','Access');
	public $uses=array('User','UserRole','Product','Voucherinfo','Shops','Order','Voucher','Points');

	
	function beforeFilter(){
		parent::beforeFilter();	 
		//$this->Access->isValidUser();		
	}

	public function admin_index() {
		
		$this->layout='admin';
		$points=$this->Points->find('all');
		$this->set('points',$points);
	
	}
	
	public function update_def_points()
	{
		$this->layout='ajax';
		$pts=$this->data['def_points'];
		$this->Points->id=1;
		$this->Points->saveField('points',$pts);
		die;	
	}
	
	public function add_points_range()
	{
		$this->layout='ajax';
		$this->render('add_range_form');	
	}
	
	public function save_range_points()
	{
		$this->layout='ajax';
		//echo '<pre>';print_r($this->data);die;
		if(!empty($this->data['point_id']))
			$this->Points->id=$this->data['point_id'];	
		else		
			$this->Points->create();
		$this->Points->save($this->data);
		die;	
	}
	
	public function edit_range($id)
	{
		$this->layout='ajax';
		$range=$this->Points->findById($id);
		$this->set('range',$range);
		$this->render('add_range_form');
	}
	
	public function delete_range($id)
	{
		$this->layout='ajax';
		$this->Points->delete($id);
		die;	
	}
	
}
		