<?php
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor','functions');
//App::import('Vendor','uploadclass');

class ChallengesController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
	public $uses = array('Client','Account','Question','Clientactivityset');

    public function beforeFilter() {
		if(!$this->Session->check('Client'))
			{
			$this->redirect(SITE_URL);
			exit();
			}
		$this->layout = 'jsb_bg';
    }
	
	
	public function index()
	{
		$this->layout='ajax';
		$client_id=$this->Session->read('Client.Client.id');
		//$this->activity_settings();	
		$this->set('client_id',$client_id);
		$this->render('index');
	}
	
	public function activity_settings()
	{
		$this->layout='ajax';
		$client_id=$this->data['client_id'];
		$questions=$this->Question->find('all',array('order'=>array('Question.id ASC')));
		$ques_data=array();
		//$q=array();
		$j=0;
		foreach($questions as $ques)
		{	
			
			$ques_data['answer']=explode('|',$ques['Question']['answer_options']);
			$ques_data['point']=explode('|',$ques['Question']['answer_points']);
		
			$q[$j]['question']=$ques['Question']['question'];
			for($i=0;$i<count($ques_data['answer']);$i++)
			{
				
				$q[$j]['data'][$i]['answer']=$ques_data['answer'][$i];
				$q[$j]['data'][$i]['point']=$ques_data['point'][$i];	
			}	
			$j++;
		}
		//echo '<pre>';print_r($q);die;	
		$answers=$this->Clientactivityset->find('all',array('conditions'=>array('client_id'=>$client_id)));
		$result=array();
		if(is_array($answers) && count($answers)>0)
		{
			foreach($answers as $answer)
			$result[$answer['question_id']]=$answer['answer'];
		}
		$count=count($result);
		
		$this->set('ques',$q);
		$this->render('activity_settings');	
		
	}
	
	public function activity_submit()
	{
			
		
	}
	



}