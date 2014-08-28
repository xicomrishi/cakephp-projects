<?php
App::uses('Component', 'Controller');
class AccessComponent extends Component{
	function __construct($collection, $settings){
		$this->Controller = $collection->getController();
	}
	
	public $components = array('Session');
	
	
	public function checkSession()
	{
		if(!$this->Controller->Session->check('User'))
		{
			$this->Controller->redirect('/login/participant_login');	
		}

	}
	
	public function checkAdminSession()
	{
		if($this->Controller->Session->read('User.type')!='Admin')
		{
			$this->Controller->redirect('/login/invalidSession/admin');	
		}	
	}
	
	public function checkParticipantSession()
	{
		if(!$this->Controller->Session->check('User'))
		{
			$this->Controller->redirect('/login/participant_login');	
		}else{
			if($this->Controller->Session->read('User.type')!='Admin')
			{
				$role=$this->Controller->Session->read('User.Participant.Participant.user_role_id');
				$pr_id=$this->Controller->Session->read('User.Participant.Participant.id');	
				$user_type=$this->Controller->Session->read('User.type');	
				$cont=$this->Controller->params['controller'];
				$act=$this->Controller->params['action'];
				$arg=$this->Controller->params['pass']; 
				if(($cont=='assessment'&&$act=='project_management'))
				{
					if(!($arg[0]==$role))
					{
						$this->Controller->redirect('/assessment/project_management/'.$role);	
					}
				}else if(($cont=='reports'&&$act=='project_management_report'))
				{
					if(!($arg[0]==$pr_id||$user_type=='Trainer'))
					{
						$this->Controller->redirect('/reports/project_management_report/'.$pr_id);	
					}	
				}
			}
		}
	}	
}