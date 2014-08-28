<?php
/**
 * Common helper for application
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * @Name : CommonHelper class
 * @Author : Neha Sachan
 * @Created : 16 Oct 2013 At 9:56 AM 
 */


/**
 * Common Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 */
App::uses('Helper', 'View');

class CommonHelper extends AppHelper {

	var $helpers = array('Session','Number','Text','Html');
		
/**
 * Name : Neha Sachan
 * Purpose : get email variables 
 * Created On : 16 Oct 2013 At 9:57 AM
 */
 
	public function getEmailVariable()
	{
		return  array(  'EMAIL_FIRST_NAME'						=> '{first_name}',
						'EMAIL_LAST_NAME'						=> '{last_name}', 
						'EMAIL_USERNAME'						=> '{username}', 
						'EMAIL_PASSWORD'						=> '{password}' , 
						'EMAIL' 								=> '{email}' ,
						'EMAIL_DOMAIN' 							=> '{domain}' ,
						'EMAIL_ACTIVATION_LINK' 				=> '{activation_link}', 						
						'EMAIL_ACTIVATION_LINK_SEND_DATE' 		=> '{activation_link_send_date}', 						
						'EMAIL_FORGOT_PASSWORD_LINK' 			=> '{forgot_password_link}', 						
						'EMAIL_FORGOT_PASSWORD_LINK_SEND_DATE'  => '{forgot_password_link_send_date}', 						
						'EMAIL_MESSAGE'							=> '{message}',
						'DOMAIN'								=> '{domain}',
					);
	}
	
	public function getFeedbackEmailVariable()
	{
		return  array(  'EMAIL_FIRST_NAME'						=> '{first_name}',
						'EMAIL_LAST_NAME'						=> '{last_name}', 
						'DEAL_TITLE'								=> '{deal_title}'
					);
	}
	
	public function getDealEmailVariable()
	{
		return  array(  'EMAIL_FIRST_NAME'						=> '{first_name}',
						'EMAIL_LAST_NAME'						=> '{last_name}', 
						'DEAL_TITLE'								=> '{deal_title}'
					);
	}
	
	public function getMarketingEmailVariable()
	{
		return  array(  'EMAIL_FIRST_NAME'						=> '{user_first_name}',
						'EMAIL_LAST_NAME'						=> '{user_last_name}', 						
					);
	}
	
}
