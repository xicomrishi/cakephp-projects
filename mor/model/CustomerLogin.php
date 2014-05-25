<?php
class CustomerLogin extends AppModel {
	public $name = 'Customer';
	public $primaryKey = 'customer_id';
	public $useTable="customers";
	
	public $validate = array(	
	'email' =>array(
			array('rule' => 'notEmpty',
				'message' => 'Please enter the email'
			),
			array('rule' => 'email',
				'message' => 'Invalid email.'
			)
		),

	'password' => 
		array(
			'rule' => 'notEmpty',
			'message' => 'Please enter the password.' 
		)
	);

}
