<?php
class Customer extends AppModel {
	public $name = 'Customer';
	public $primaryKey = 'customer_id';
	public $displayField = 'customer_id';
	public $useTable = 'customers'; 
	
	public $belongsTo = array(
			'Country' => array(
				'className' => 'Country',
				'foreignKey' => 'country_id',
				'dependent' => false				
			),
			'State' => array(
				'className' => 'State',
				'foreignKey' => 'state_id',
				'dependent' => false				
			)			
	);
		
	public $hasMany = array(
		'Recharge' => array(
			'className' => 'Recharge',
			'foreignKey' => 'customer_id',
		)		
	);
		
	public $validate = array(		
		'email' =>array(			
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'The field Email ID can not be empty.'				
			),
			'email'=>array('rule' => 'email',
				'message' => 'Invalid Email ID.'
			),			
			'checkUniqueUser' => array (
            	'rule' => 'checkUniqueUser',
           	 	'message' => 'This Email ID already exists.'
       		 )
		),
		'guest_email' =>array(			
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'The field Email ID can not be empty.'				
			),
			'email'=>array('rule' => 'email',
				'message' => 'Invalid Email ID.'
			)
		),
		'old_password' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'The field Old Password can not be empty.'				
			)			
		),
		
		'password' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'The field Password can not be empty.'				
			),
			'length' => array(
                'rule'      => array('between', 6, 40),
                'message'   => 'Your Password must be between 6 and 40 characters.'
             )
		),
		'confirm_password' =>array(
			array('rule' => 'notEmpty',
				'message' => 'The field Confirm Password can not be empty.'
			),
			
			'comparePassword' => array(
				'rule' => 'comparePassword',
				'message' => 'The field Password and Confirm Password should be same.'				
			)
		),		
   		
		'name' => array(
			'rule' => 'notEmpty',
			'message' => 'The field Name can not be empty.',
		)
	);
	
	function comparePassword(){
	
		if($this->data['Customer']['password']!=$this->data['Customer']['confirm_password'])
		{
			return false;
		}		
		return true;				
	}

	function checkUniqueUser() {
		
		$rowCount=$this->find('count', array('conditions' => array('Customer.email' => $this->data['Customer']['email'],'Customer.customer_type'=>'Registered')));
		if($rowCount == 0){
			return true;
		}
	}
	
}
