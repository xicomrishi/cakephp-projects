<?php
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor','functions');
//App::import('Vendor','uploadclass');

class TestsController extends AppController {
	
	
public function test()
{
	$this->render('test');	
}

}