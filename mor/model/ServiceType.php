<?php
class ServiceType extends AppModel {

	public $name = 'ServiceType';
	public $primaryKey = 'service_type_id';
	
	public $hasMany=array(
		'Coupon'=>array(
			'className'=>'Coupon',
			'foreignKey'=>'service_type_id'
		)
	);
	
	public $validate = array(
		'service_type' => array(
			'required' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter the service type.'				
			)
		)
	);
	
	
}
