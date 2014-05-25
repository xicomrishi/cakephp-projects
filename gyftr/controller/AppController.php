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
		public $uses = array('Userlog');
		public function beforeFilter()
		{			
			if($this->Session->check('User'))
			{
				$date=date('Y-m-d H:i:s');
				$this->Userlog->query("update gyftr_user_log set last_action_time='".$date."' where user_id='".$this->Session->read('User.User.id')."' and logout_time=''");	
			}
			
			/*if($this->Cookie->check('gifting_'.$_SERVER['REMOTE_ADDR']))
			{
				$session=$this->Session->read();
				$this->Cookie->write('gifting_'.$_SERVER['REMOTE_ADDR'],$session);	
			}else{
				$this->Cookie->name = 'gifting_'.$_SERVER['REMOTE_ADDR'];
				$this->Cookie->time = 3600;  // or '1 hour'
				$this->Cookie->path = '/bakers/preferences/';
				$this->Cookie->domain = 'example.com';
				$this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
				
			}*/
			
					
		}
}
