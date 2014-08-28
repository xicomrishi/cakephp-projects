<?php

App::import('Vendor',array('functions'));
App::uses('AppController', 'Controller');

class QuestionsController extends AppController {


	public $components = array('Session','Access');
	public $uses=array('Question','Language');

	public function beforeFilter(){
		$this->layout='default';
			
	}
	
	
	public function admin_index()
	{
		$this->Access->checkAdminSession();
		$this->Question->bindModel(array('belongsTo' => array('Language' => array('className' => 'Language','foreignKey' => 'language_id'))),false);
		$ques_set=$this->Question->find('all',array('fields'=>array('DISTINCT Question.language_id','Language.*','Question.role_id'),'group'=>array('Question.role_id','Question.language_id')));
		$this->set('ques_set',$ques_set);
	}
	
	
	public function edit_cms_questions($lang_id,$role_id)
	{
		$this->Access->checkAdminSession();
		$questions=$this->Question->find('all',array('conditions'=>array('Question.language_id'=>$lang_id,'Question.role_id'=>$role_id)));
		$data=array(); $i=0;
		foreach($questions as $ques)
		{
			if($ques['Question']['group_id']==1)
				$j=0;
			else if($ques['Question']['group_id']==2)
				$j=1;
			else if($ques['Question']['group_id']==3)
				$j=2;
			else if($ques['Question']['group_id']==4)
				$j=3;
			else if($ques['Question']['group_id']==5)
				$j=4;	
			else if($ques['Question']['group_id']==6)
				$j=5;					
			
			$data[$j]['question'][$i]['id']=$ques['Question']['id'];
			$data[$j]['question'][$i]['question_key']=$ques['Question']['question_key'];
			$data[$j]['question'][$i]['text']=$ques['Question']['question'];			
			$i++;					
		}
		$language=$this->Language->find('all');
		$this->set('role_id',$role_id);
		$this->set('lang_id',$lang_id);
		$this->set('language',$language);
		//pr($data);die;
		$this->set('data',$data);	
	}
	
	public function submit_questions()
	{
		$data=$this->data;
		foreach($data['ques'] as $index=>$dat)
		{
			$this->Question->id=$index;
			$this->Question->save(array('question'=>$dat,'role_id'=>$data['role_id'],'language_id'=>$data['language_id']));	
		}
		$this->redirect(array('action'=>'index','admin'=>true));		
	}
	
	public function add_cms_questions()
	{
		$this->Access->checkAdminSession();	
		$language=$this->Language->find('all');
		$this->set('language',$language);
	}
	
	public function save_questions()
	{
		//pr($this->data); die;
		$this->Access->checkAdminSession();		
		$ques_set=$this->Question->find('all',array('fields'=>array('DISTINCT Question.language_id','Question.role_id'),'group'=>array('Question.role_id','Question.language_id')));
		
		$flag=0;
		foreach($ques_set as $ques)
		{
			if($this->data['language_id']==$ques['Question']['language_id']&&$this->data['role_id']==$ques['Question']['role_id'])
			{
				$flag=1;	
			}	
		}
		if($flag==0)
		{
			$role_id=$this->data['role_id'];
			$language_id=$this->data['language_id'];
			$arr=array(); $j=1;
			foreach($this->data['ques'] as $ind=>$dat)
			{				
				foreach($dat as $qst)
				{
					$arr[$j]['role_id']=$role_id;
					$arr[$j]['language_id']=$language_id;
					$arr[$j]['question_key']=$j;
					$arr[$j]['tool_id']='1';
					$arr[$j]['group_id']=$ind;
					$arr[$j]['question']=$qst;
					$j++;		
				}						
			}
			$this->Question->create();
			$this->Question->saveAll($arr);
		}
		$this->redirect(array('action'=>'index','admin'=>true));	
		
		
	}
		
	
}