<?php
class HomesController extends AppController {

	public $name = 'Homes';
	public $helpers = array('Session','Form', 'Html', 'Js');
	public $paginate = array('limit' => 10);	
	public $uses=array('Cmse');
	public $components=array('Session','Core');
	
	function index() {
		
		$this->layout="home";
		$this->set('title_for_layout','Professionals/Recruiters Login');		
		
	}
	
}?>