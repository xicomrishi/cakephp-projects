<?php

App::import('Vendor',array('functions'));
App::uses('AppController', 'Controller');

class TestController extends AppController {


	public $components = array('Session','Access');
	public $uses=array('Test');
	

	public function beforeFilter(){
		$this->layout='default';			
	}
	
	public function index()
	{
		$vals=$this->paginate('Test');	
		$this->set('vals',$vals);
	}
	
	public function insert()
	{
		for($i=0;$i<50;$i++)
		{
			$this->Test->create();
			$this->Test->save(array('val'=>$i));	
		}
		die;			
	}
	
	public function add()
	{
		if($this->request->is('post'))
		{
			$this->Test->set($this->data);
			if($this->Test->validates())
			{
				if(!empty($this->data['Test']['image']['tmp_name']))
				{
					$file=time().'_'.$this->data['Test']['image']['name'];
					if(move_uploaded_file($this->data['Test']['image']['tmp_name'],WWW_ROOT.'/'.$file))
					{
						$this->Test->create();
						$this->Test->save($this->data);	
					}
					echo '1'; die;						
				}
			}else{
				$error=$this->Test->validationErrors;
				pr($error); die;	
			}
		}
	}
	
	
}