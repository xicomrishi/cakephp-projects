<?php

//App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'functions');

class AdminController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
    public $uses = array('Adminlogin','Agency');

    public function beforeFilter() {
        if (!$this->Session->check('Admin')) {
            $this->redirect(SITE_URL);
            //$this->Session->setFlash(__('You are not authorized to acces that page. Please login to  continue.'));
            exit();
        }
        $this->layout = 'jsb_bg';
    }

    public function index() 
	{
		$agency=$this->Agency->find('all');
		
		$this->set('agency',$agency);
		
				
	}
	
	  public function show_search() {
        $this->layout = 'ajax';
        $this->render('search');
    }
	
	public function show_add_agency()
	{
		$this->layout = 'ajax';
        $this->render('add_agency');	
	}
	
	public function get_all_agency()
	{
		$this->layout = 'ajax';
		$agency=$this->Agency->find('all');
		$this->set('agency',$agency);
		$this->render('results');
	}
	
	
	
	
}