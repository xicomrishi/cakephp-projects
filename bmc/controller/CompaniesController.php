<?php

App::import('Vendor',array('functions'));
App::import('Controller',array('Users'));

class CompaniesController extends AppController {

	public $components = array('Session','Access');
	public $uses=array('User','Course','Coursecompany','Company');

	public function beforeFilter(){
		$this->layout='default';
			
	}
	
	public function admin_index()
	{
		$this->Access->checkAdminSession();	
		/*$this->paginate=array('joins'=>array(
										 array(
											'alias' => 'Coursecompany',
											'table' => 'course_company',
											'type' => 'INNER',
											'conditions' => '`Company`.`company` = `Coursecompany`.`company`'
										),
										 array(
											'alias' => 'Course',
											'table' => 'courses',
											'type' => 'INNER',
											'conditions' => '`Course`.`id` = `Coursecompany`.`course_id`'
										),
										array(	'alias' => 'Trainer',
											'table' => 'trainers',
											'type' => 'INNER',
											'conditions' => '`Course`.`trainer_id` = `Trainer`.`id`'										
										),
										array(
											'alias' => 'User',
											'table' => 'users',
											'type' => 'INNER',
											'conditions' => '`Trainer`.`user_id` = `User`.`id`'											
										)),
								'fields'=>array('User.first_name','User.last_name','User.email','Coursecompany.*'),
								'order'=>array('Company.company'=>'ASC')
								);*/
		$this->paginate=array('joins'=>array(
									array(
										'alias' => 'User',
										'table' => 'users',
										'type' => 'INNER',
										'conditions' => '`Company`.`user_id` = `User`.`id`'		
									)
								),
								'fields'=>array('Company.*','User.*'),
								'order'=>array('Company.company'=>'ASC'));						
		$companies=$this->paginate('Company');		
		$this->set('companies',$companies);
		//echo '<pre>';print_r($companies);die;
	}
	
	public function get_companies_list($cr_id)
	{
		$this->layout='ajax';
		$this->paginate=array('joins'=>array(
										 
										array(	
											'alias' => 'Company',
											'table' => 'companies',
											'type' => 'INNER',
											'conditions' => '`Coursecompany`.`company` = `Company`.`company`'										
										),
										array(
											'alias' => 'User',
											'table' => 'users',
											'type' => 'INNER',
											'conditions' => array('`User`.`company` = `Company`.`id`',"`User`.`user_status` = '1'")											
										)),
								'fields'=>array('User.first_name','User.last_name','User.email','Coursecompany.*','Company.id'),
								'conditions'=>array('Coursecompany.course_id'=>$cr_id));
		$data=$this->paginate('Coursecompany');
		$companies=array(); 
		foreach($data as $dat)
		{
			$companies[$dat['Company']['id']]['company_name']=$dat['Coursecompany']['company'];
			$companies[$dat['Company']['id']]['user'][]=$dat['User'];			
		}
		//echo '<pre>';print_r($companies);die;		
		$this->set('companies',$companies);	
		$this->render('companies_list');
	}
	
	public function get_company_courses($comp_id)
	{
		$this->layout='ajax';
		$company=$this->Company->findById($comp_id);
		$comp=$this->Coursecompany->findByCompany($company['Company']['company']);
		if(!empty($comp))
		{
			$this->paginate=array('joins'=>array(										 
											array(	
												'alias' => 'Course',
												'table' => 'courses',
												'type' => 'INNER',
												'conditions' => '`Coursecompany`.`course_id` = `Course`.`id`'										
											),
											array(
												'alias' => 'Trainer',
												'table' => 'trainers',
												'type' => 'INNER',
												'conditions' => array('`Trainer`.`id` = `Course`.`trainer_id`')											
											),
											array(
												'alias' => 'User',
												'table' => 'users',
												'type' => 'INNER',
												'conditions' => array('`User`.`id` = `Trainer`.`user_id`')											
											)),
									'fields'=>array('User.first_name','User.last_name','User.email','Coursecompany.*','Course.*'),
									'conditions'=>array('Coursecompany.company'=>$comp['Coursecompany']['company']));
			$data=$this->paginate('Coursecompany');	
			//echo '<pre>';print_r($data);die;	
			$this->set('data',$data);	
			$this->set('comp_id',$comp_id);	
			$this->set('compcourse_id',$comp['Coursecompany']['id']);	
		}else{
			$this->set('no_found','1');	
		}
		$this->render('company_courses');	
	}
	
	
	
}