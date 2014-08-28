<?php
class AccessComponent extends Component  {

	public $components = array('Session');
	
	function __construct($collection, $settings){
		$this->Controller = $collection->getController();
	}
	function isValidUser(){
		
		$isAdmin=Configure::read('Routing.prefixes');
		$pos = strpos($_SERVER['REQUEST_URI'], $isAdmin[0]);
	    if($pos == true)
        {
        	
            $this->Controller->layout='admin';

            $isValidUser=$this->Controller->Session->read('Admin/User');
            
            $curUserRole=$this->Controller->Session->read('Admin/User/Role');
            $prmittedRols=array(1,2);
			
            if(!$isValidUser || !in_array($curUserRole,$prmittedRols)){
				$this->Controller->Session->setFlash("Access Denied!");
				$this->Controller->redirect('/admin/login/index');
				$this->Controller->set('title_for_layout', 'User');
			}
            
        }else{
        	 $this->Controller->layout='default';
        }
	}
	
	function checkUserSession()
	{
		if(!$this->Controller->Session->check('User'))
		{
			$this->Controller->redirect('/users/invalid_session');	
		}
	}
	
	function checkGiftingSession()
	{
		if(!$this->Controller->Session->check('Gifting'))
		{
			$this->Controller->redirect('/users/invalid_session');	
		}
	}

}
