<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	    public $components = array('Session');
		public $uses = array('Userlog','Contact','Message','Account');
		public function beforeFilter()
		{
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
            $this->layout = 'admin_default';
        } 

			if($this->Session->check('Account.id')){
				$date=date('Y-m-d H:i:s');
				$this->Userlog->query('update jsb_user_log set last_action_time="'.$date.'" where account_id="'.$this->Session->read('Account.id').'" and usertype="'.$this->Session->read('usertype').'" and logout_time="0000-00-00 00:00:00"');
				
				$this->Account->query('update jsb_accounts set lastactivity="'.strtotime($date).'" where id="'.$this->Session->read('Account.id').'"');
				
			$contact_count=$this->Contact->find('count',array('conditions'=>array('Contact.account_id' => $this->Session->read('Account.id'),'network_contact'=>1)));
			$this->set('contact_count',$contact_count);
			
			$count=$this->Message->find('count',array('conditions'=>array('Message.to_userid'=>$this->Session->read('Account.id'),'Message.read_flag'=>0,'Message.to_usertype'=>$this->Session->read('usertype'))));
			$this->set('message_count',$count);	
			}
		}
}
