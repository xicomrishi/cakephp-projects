<?php
class Coupon extends AppModel {
	public $name = 'Coupon';
	public $primaryKey = 'coupon_id';
	
	public $belongsTo = array(
         'RechargeType' => array( 
             'className' => 'RechargeType', 
             'foreignKey' => 'recharge_type_id',
			 'counterCache' => true 
    ));

    public $hasMany = array(
         'CouponUse' => array( 
             'className' => 'CouponUse', 
             'foreignKey' => 'coupon_id',
       ));
        
	public $validate = array(
		'coupon_code' => array(
			
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter coupon code.'				
			),
			'unique'=>array(
				'rule' => array('isUnique'),
				'message' => 'This coupon already exist.'	
			)
		),
		'coupon_price' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter coupon price.'				
			),
			'numeric'=>array(
				'rule' => array('numeric'),
				'message' => 'Please enter a valid monetary amount.'
			)
		),
		'min_amount' => array(			
			'numeric'=>array(
				'rule' => array('numeric'),
				'message' => 'Please enter a valid monetary amount.',
				'allowEmpty'=>true
			)
		),
		'max_uses' => array(			
			'numeric'=>array(
				'rule' => '/^[0-9]{0,5}$/i',
				'message' => 'Please enter a valid integer number.',
				'allowEmpty'=>true
			)
		),
		'start_date'=>array(
			'rule'=>array('date'),
			'message'=>array('Please enter the valid start date.'),
			'allowEmpty'=>true
		),
		'end_date'=>array(
			'rule'=>array('date'),
			'message'=>array('Please enter the valid end date.'),
			'allowEmpty'=>true
		)
	);	
	
}
