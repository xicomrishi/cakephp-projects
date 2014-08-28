<?php
class User extends AppModel 
{
	public $useTable = 'users';
	
	var $validate = array (
				'first_name' => array (
					'notEmpty' => array (
						'rule' => 'notEmpty',
						'message' => 'This field is required'
					),
					'minlength' => array (
						'rule' => array ('minLength', '2'),
						'message' => 'First name must be at least 2 characters'
					),
					'maxlength' => array (
						'rule' => array ('maxLength', '100'),
						'message' => 'First name should not be greater than 100 characters'
					)
				),
				'last_name' => array (	
					
					'minlength' => array (
						'allowEmpty' => true,
						'rule' => array ('minLength', '2'),
						'message' => 'Last name must be at least 2 characters'
					),
					'maxlength' => array (
						'rule' => array ('maxLength', '100'),
						'message' => 'Last name should not be greater than 100 characters'
					)
				),
				'username' => array (
						
					'notEmpty' => array (
						'required'=>true,
						'rule' => 'notEmpty',
						'message' => 'This field is required'
					),
					'minlength' => array (
						'rule' => array ('minLength', '6'),
						'message' => 'Username must be at least 6 characters'
					),
					'maxlength' => array (
						'rule' => array ('maxLength', '100'),
						'message' => 'Username should not be greater than 100 characters'
					),
					'isUnique' => array (
						'rule' => 'isUnique',
						'message' => 'Username is already taken'
					)
				),
				'password' => array (
					'notEmpty' => array (
						'rule' => 'notEmpty',
						'message' => 'Password is required'
					),
					'minlength' => array (
						'rule' => array ('minLength', '6'),
						'message' => 'Password must be at least 6 characters'
					),
					'maxlength' => array (
						'rule' => array ('maxLength', '100'),
						'message' => 'Password should not be greater than 100 characters'
					)
				),
				'confirm_password' => array (
					'notEmpty' => array (
						'rule' => 'notEmpty',
						'message' => 'This field is required'
					),
					'matches' => array (
						'rule' => 'matchPassword',
						'message' => 'Passwords do not match'
					)
				),
				'email' => array (
					'notEmpty' => array (
						'rule' => 'notEmpty',
						'message' => 'This field is required'
					),
					'email' => array (
						'rule' => 'email',
						'message' => 'Invalid email provided'
					),
					'maxlength' => array (
						'rule' => array ('maxLength', '255'),
						'message' => 'Email should not be greater than 255 characters'
					),					
					'isUnique' => array (
						'rule' => 'isUnique',
						'on' => 'create',
						'message' => 'Email id is already taken'
					)
				)				
	);
/**
 * if either password or confirm password do not exist, then omit this rule
 * @param type $check
 * @param type $object
 * @return boolean 
 */
    public function matchPassword($check, $object)
    {
		$value = end($check);

		if (!isset($this->data['User']['password']) || !isset($this->data['User']['confirm_password']))
		{
			return true;
		}

		if ($value === $this->data['User']['password'] && $value === $this->data['User']['confirm_password'])
		{
			return true;
		}

		return false;
    }
    
    public function beforeSave($options = array())
    {
		if (isset($this->data['User']['password']))
		{
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
    }
}
