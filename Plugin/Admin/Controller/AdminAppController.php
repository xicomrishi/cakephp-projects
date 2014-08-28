<?php

App::uses('AppController', 'Controller');

class AdminAppController extends AppController {
	public $theme = 'Admin';
	public $components = array(
		'Auth' => array(
			'loginAction' => array(
				'controller' => 'users',
				'action' => 'login',
				'plugin' => 'admin'
			),
			'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'users', 'action' => 'login')
		)
	);

	public function beforeFilter()
	{			
		parent::beforeFilter();

		if($this->Auth->user('id') != '' && $this->Auth->user('type') == 2)
		{
			$this->_checkAuth();
			
			
		}else if($this->Auth->user('type') == 3)
		{
			$this->_checkSubAdminAuth();	
		}
	}

	function _checkAuth()
    {
		$allowed_url = array ('users/dashboard', 'users/profile', 'users/appointment',  'users/slider_delete',
							  'users/client_appointment_delete', 'users/deal_delete', 'users/edit', 'users/slider', 'users/slider_image_add',
							  'users/slider_image_edit', 'users/logout', 'users/deals', 'users/deal_add', 'users/deal_edit',
							  'users/client_appointments', 'users/client_appointment_edit', 'users/deal_report_client', 'users/deal_report_client_view',
							  'users/change_password', 'users/check_username', 'users/client_user_visit_report', 'users/slider_crop_image',
							  'emails/feedback_email', 'emails/deal_email', 'emails/marketing_send_email',  'emails/marketing_filter_email',
							  'emails/marketing_history_email', 'emails/marketing_history_email_view_users',
							  'emails/marketing_schedule_email', 'emails/marketing_draft_email', 'emails/marketing_schedule_edit_email',
							  'emails/marketing_schedule_change', 'emails/marketing_draft_edit_email', 'emails/marketing_resend_email',

							  'csvs/import', 'csvs/import_yahoo', 'csvs/import_yahoo_callback', 'csvs/import_google','users/get_checked_users',
							  'users/preview_tablet_edit', 'users/preview_website_edit','users/client_contact_requests','users/client_document_upload_requests',
							  'users/get_page_access_token', 'coupons/index', 'coupons/add', 'coupons/edit', 'coupons/delete', 'coupons/view',
							  'coupons/rewards','coupons/redeem_coupon','users/client_contact_respond','users/subadmin_dashboard','csvs/get_imported_users_list',
							  'emails/marketing_email_cron'
		);
		
		$cur_page = $this->params['controller'] . '/' . $this->params['action'];

		if (!in_array($cur_page, $allowed_url))
		{
			$this->flash_new( __('Access denied'), 'error-messages' );			
			$this->redirect(array('controller'=>'users', 'action'=>'dashboard'));
		}
    }

	function _checkSubAdminAuth()
    {
		$allowed_url = array ('users/subadmin_dashboard', 'users/list_assigned_users', 'users/deal_report_subadmin',  'users/subadmin_user_visit_report',
							  'users/deal_report_client_view', 'users/change_password','users/logout','users/get_admin_dashboard','users/add','users/subadmin_add_user',
							  'users/send_email','users/check_username','users/suggest_username'
		);
		$cur_page = $this->params['controller'] . '/' . $this->params['action'];
		
		if (!in_array($cur_page, $allowed_url))
		{
			$this->flash_new( __('Access denied'), 'error-messages' );
			$this->redirect(array('controller'=>'users', 'action'=>'subadmin_dashboard'));
		}
    }

    function _send_email($to_email, $token, $token_value, $template_indetifier ,$Setting)
	{

		if(!filter_var($to_email, FILTER_VALIDATE_EMAIL))
		{
			return false;
		}

		$this->loadModel('EmailTemplate');
		$template = $this->EmailTemplate->findByEmailIdentifier($template_indetifier);
		if (empty($template))
		{
			return false;
		}

		$template = $template['EmailTemplate'];

		$from_email  = str_replace('{from_email}',$Setting['from_email'] , $template['from_email'] ? $template['from_email'] : SITE_EMAIL) ;

		$from_name  =  str_replace('{from_name}',$Setting['from_name'] , $template['from_name']);

		$subject = str_replace('{domain}',$Setting['domain'] ,$template['subject']);

		$msg = $template['content'];

		$msg = str_replace($token, $token_value, $msg);
		$email = new CakeEmail('smtp');
		$email->from($Setting['from_email']);
		$email->to($to_email);
		$email->subject($subject);
		$email->emailFormat('html');

		if ($email->send($msg)) {
			return true;
		} else {
			return  $this->Email->smtpError;
		}

	}
}
