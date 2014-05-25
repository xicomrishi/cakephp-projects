<?php

class RechargeController extends AppController {

	public $name = 'Recharge';
	
	public function index()
	{
		$this->redirect('http://recharge.mygyftr.com');	
	}		
	
}