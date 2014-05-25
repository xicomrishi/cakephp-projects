<?php
class CouponUse extends AppModel{
	
	public $name="CouponUse";
	public $primaryKey="uses_id";
	
	public $belongsTo=array(
		'Coupon'=>array(
			'className'=>'Coupon',
			'foreignKey'=>'coupon_id'
		),
		'Recharge'=>array(
			'className'=>'Recharge',
			'foreignKey'=>'recharge_id'
		),
		'Customer'=>array(
			'className'=>'Customer',
			'foreignKey'=>'customer_id'
		)
		
	);

}