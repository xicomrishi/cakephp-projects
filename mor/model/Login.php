<?php
class Login extends AppModel {
	var $name = 'Login';
	var $primaryKey = 'user_id';
	var $useTable="users";
	var $validate = array(
	
	'email' =>array(
			array('rule' => 'notEmpty',
				'message' => 'Please enter the email'
			),
			array('rule' => 'email',
				'message' => 'Please enter the valid email.'
			)
		),

	'password' => 
		array(
			'rule' => 'notEmpty',
			'message' => 'Please enter the password.' 
		)
	);

}
