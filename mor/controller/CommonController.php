<?php
class CommonController extends AppController {

	public $name = 'Common';
	public $helpers = array('Form', 'Html', 'Js','Session');
	public $paginate = array('limit' =>10);	
	public $uses=array('User','UserRole','Country');
	
	function beforeFilter(){
		parent::beforeFilter();
	}
	
		
}
