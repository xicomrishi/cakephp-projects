<?php

App::import('Vendor',array('functions'));
App::uses('AppController', 'Controller');

class CmsController extends AppController {


	public $components = array('Session','Access');
	public $uses=array('Cms','Language');

	public function beforeFilter(){
		$this->layout='default';
			
	}
	
	public function admin_index()
	{
		$this->Access->checkAdminSession();	
		$this->paginate=array('joins'=>array(
									array(
										'alias' => 'Language',
										'table' => 'languages',
										'type' => 'INNER',
										'conditions' => '`Cms`.`language_id` = `Language`.`id`'		
									)
								),
								'fields'=>array('Cms.*','Language.*'));
		
		$cms=$this->paginate('Cms');	
		$this->set('cms',$cms);		
	}
	
	public function add_page()
	{
		$this->Access->checkAdminSession();	
		$languages=$this->Language->find('all');
		$this->set('languages',$languages);	
	}
	
	public function save_cms_page($cms_id=0)
	{
		$this->Access->checkAdminSession();	
		if(!empty($this->data))
		{
			if($cms_id==0)
			{
				$this->data['Cms']['created']=$this->data['Cms']['modified']=date("Y-m-d H:i:s");
				$this->Cms->create();
			}else{
				$this->data['Cms']['modified']=date("Y-m-d H:i:s");
				$this->Cms->id=$cms_id;	
			}
			$this->Cms->save($this->data);
			$this->redirect(array('action'=>'index','admin'=>true));
		}
	}
	
	public function edit_cms_page($cms_id)
	{
		$this->Access->checkAdminSession();	
		$cms=$this->Cms->findById($cms_id);
		$languages=$this->Language->find('all');
		$this->set('cms',$cms);
		$this->set('languages',$languages);	
		$this->render('add_page');	
	}
	
	public function delete_cms_page($cms_id)
	{
		$this->Access->checkAdminSession();	
		$this->Cms->delete($cms_id);
		$this->redirect(array('action'=>'index','admin'=>true));	
	}
	
	public function get_cms_content($page_slug,$lang_id=1)
	{
		$cms=$this->Cms->find('first',array('conditions'=>array('Cms.page_slug'=>$page_slug,'Cms.language_id'=>$lang_id)));
		return $cms['Cms']['content'];	
	}
	
	public function get_language_dropdown()
	{
		$languages=$this->Language->find('all');
		$data='';		
		$data.='<span><select id="language_select">';
		$data.='<option value="">Change Language</option>';
		foreach($languages as $lang)
		{
			$data.='<option value="'.$lang['Language']['id'].'">'.$lang['Language']['name'].'</option>';	
		}
		$data.='</select>';
		$data.='<a href="javascript://" onclick="change_language();">Go</a>';
		echo $data;	
	}
	
	public function change_language($lang_id)
	{
		$language=$this->Language->find('first',array('conditions'=>array('Language.id'=>$lang_id)));
		Configure::write('Config.language', strtolower($language['Language']['code']));
		$this->Session->write('Config.language',strtolower($language['Language']['code']));
		$this->Session->write('Config.language_id',$language['Language']['id']);
		echo 'success'; die;
	}
	
}
