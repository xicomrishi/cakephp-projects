<?php

App::uses('Admin.AdminAppModel', 'Model');
/**
* Coupon Model
*
* @project Social Referral
* @since 1 July 2014
* @author Vivek Sharma
*/
class Coupon extends AdminAppModel 
{
	public $useTable = 'admin_coupons';
	var $validate = array (
				'no_of_share' => array (
					'notEmpty' => array (
						'rule' => 'notEmpty',
						'message' => 'This field is required'
					)
				),
				'image' => array (
					'notEmpty' => array (
						'rule' => 'notEmpty',
						'message' => 'This field is required'
					)
				),
				'title' => array (
					'notEmpty' => array (
						'rule' => 'notEmpty',
						'message' => 'This field is required'
					)
				),
				'description' => array (
					'notEmpty' => array (
						'rule' => 'notEmpty',
						'message' => 'This field is required'
					)
				),
				'valid_for' => array (
					'notEmpty' => array (
						'rule' => 'notEmpty',
						'message' => 'This field is required'
					)
				)
				
	);
	
}