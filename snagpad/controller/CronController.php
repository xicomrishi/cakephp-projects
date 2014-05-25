<?php
App::import('Core','Validation');
App::uses('CakeEmail', 'Network/Email'); 
App::import('Controller', array('Jobcards','Challenges'));


class CronController extends AppController {    
	 public $uses = array('Account','Client','Contactrequest','Card','Mail','Checklist','Clientfile','Coach','Agencycard');
	 public function beforeFilter() {		
		ini_set("memory_limit","5G");
		ini_set("max_execution_time","0");
		
	 }
    public function SnagCastMail() {
		$this->autoRender = false;
		$this->layout='ajax';
        $contacts = $this->Contactrequest->find('all',array('conditions'=>array('Contactrequest.accepted'=>1)));
		$to_date=date('Y-m-d H:i:s');
		$from_date=date('Y-m-d', strtotime('-7 day', strtotime($to_date)));
		if(!empty($contacts))
		{
			$i=1; $info=array();
			foreach($contacts as $contact)
			{
				$info[$i]['req_id']=$contact['Contactrequest']['id'];
				$info[$i]['from_user']=$this->Account->find('first',array('conditions'=>array('Account.id'=>$contact['Contactrequest']['from_id'])));
				$info[$i]['to_user']['email']=$contact['Contactrequest']['to_email'];
				$info[$i]['to_user']['name']=$contact['Contactrequest']['to_name'];
				$info[$i]['from_user_client']=$this->Client->find('first',array('conditions'=>array('Client.account_id'=>$info[$i]['from_user']['Account']['id']),'fields'=>array('Client.id','Client.account_id','Client.email','Client.job_a_title','Client.job_b_criteria')));
				$info[$i]['cards']=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$info[$i]['from_user_client']['Client']['id'],'Card.recycle_bin'=>0,'Card.expired'=>'0','reg_date >='=>$from_date),'fields'=>array('Card.id','Card.company_name','Card.position_available'),'limit'=>6,'order'=>array('Card.id DESC')));
					$this->sendNetworkMail($info[$i]);
				$i++;	
			}	
			
		}
		//$this->autoRender=false;
		die;
        
    }
	
	
	public function sendNetworkMail($info)
	{
		//echo '<pre>';print_r($info); die;
		$this->autoRender = false;
		//$this->layout='ajax'; 
		
		/* Set up new view that won't enter the ClassRegistry */
		$view = new View($this, false);
		$view->layout='ajax';
		$view->set('data', $info);
		//$view->viewPath = 'elements';
		
		/* Grab output into variable without the view actually outputting! */
		$view_output = $view->element('network_mail');
		
		
		//echo $info['req_id'].'<br>';
		$subject='Support '.$info['from_user']['Account']['name'].'\'s Job Search';
		/*if($info['req_id']=='35')
			{echo '<pre>';print_r($view_output);die;}
		else
			return;*/
		$cakemail = new CakeEmail();
		
		//$cakemail->viewRender();
		$cakemail->template('default');
		
		$cakemail->viewVars(array('weeklycontacts'=>'1'));
		if(!empty($info['to_user']['email'])&&(Validation::email($info['to_user']['email'], true)))
		{
		$cakemail->emailFormat('html')->from($info['from_user']['Account']['email'])
									  ->to($info['to_user']['email'])
									 // ->cc('Cercstaff@gmail.com')
									 // ->bcc('viveksh987@gmail.com')
									  ->subject($subject)
								   	  ->send($view_output);	
		}
		//}
		return;
			//die;						  
	}
	public function DailyDigestMail()
	{
		$this->autoRender = false;
		$this->layout='ajax';	
		$JobCards = new JobcardsController;
        $JobCards->constructClasses();		
			 
		$client_cond = " and C.reminder_mail='1' ";		
		$sp_client_cond=" AND C.id IN(697,1229)";
		//$sp_client_cond=" ";
		$account_join=" INNER JOIN  jsb_accounts A ON(A.id=C.account_id) ";
		$account_cond=" AND A.activate !='' AND A.activate !='0' ";
		//$coach_cond = " and C.counselor in (26)";

$arr_columns_status = array("O" => "Opportunity", "A" => "Applied", "S" => "Set Interview", "I" => "Interview", "V" => "Verbal Job Offer");
$curdate=date("Y-m-d");
//$res = mysql_query("delete from $coach_card_table where application_deadline!='0000-00-00' and datediff(application_deadline,curdate())<0");

$mail_contents = $this->Mail->query("select * from jsb_mail_contents where section in ('challenge_reminder','challenge_new_reminder','client_pai','agency_added_card_client','client_upcoming_interview','client_application_deadline','client_no_card_movement','client_thank_note','client_expected_response','client_interview_follow','client_less_card','counselor_no_card_movement', 'counselor_application_deadline','counselor_upcoming_interview','counselor_pai','counselor_less_card','counselor_not_login','client_card_added','client_no_card_apply','desired_start_date','expected_date_of_employer_decision','client_upcoming_task')");
$mail = array();

foreach ($mail_contents as $content)
{
	//print_r($contents['jsb_mail_contents']);
    $mail[$content['jsb_mail_contents']['section']] = $content['jsb_mail_contents']['content'];
}
########### Jobs You Snagged 2.0 ###########

	 $query = "SELECT CARD.client_id, count(CARD.id) as count from jsb_client C INNER JOIN jsb_card CARD ON (CARD.client_id=C.id) where CARD.recycle_bin='0' and CARD.column_status='O' and C.reminder_mail='1' $client_cond group by CARD.client_id order by C.id ASc,CARD.id DESC"; 
$client_cards = array();
$results =$this->Card->query($query);
foreach($results as $result) {
	$row=$result['CARD'];
	$query_string = "file=jobcards&action=index&card_id=apply";
    $url = SITE_URL . "/Pages/display?$query_string";
    $content="<a href='$url'>".$result[0]['count']."</a>";      
        $data[$row['client_id']]['client_no_card_apply'] = str_replace("~~CONTENT~~", $content, $mail['client_no_card_apply']);       
	
}

########### Application Dued 5.1 ###########
// This is determined when they set up or received a job card from the application deadline field.

 $query = "SELECT CARD.id,CARD.client_id,CARD.company_name,CARD.position_available from jsb_client C INNER JOIN jsb_card CARD ON (CARD.client_id=C.id) where CARD.recycle_bin='0' and CARD.application_deadline!='0000-00-00' and datediff(CARD.application_deadline,curdate())=1 and CARD.column_status='O' and C.reminder_mail='1' $client_cond order by C.id asc"; 
$i = 0;
$client_cards = array();
$results =$this->Card->query($query);
foreach($results as $result) {
	$row=$result['CARD'];
    $client_cards[$i] = $row;
    if ($i != 0 && $client_cards[$i]['client_id'] != $client_cards[$i - 1]['client_id']) {
        $data[$row['client_id']]['client_application_deadline'] = str_replace("~~CONTENT~~", $content, $mail['client_application_deadline']);
        $content = "";
    }elseif($i == 0)
	$content = "";        
    $client_id = $row['client_id'];
    $content.="<br><br/><b>Company Name:</b> $row[company_name]<br>Position Available:$row[position_available]";
    $query_string = "file=jobcards&action=index&card_id=cardShow_$row[id]";
    $url = SITE_URL . "/Pages/display?$query_string";
    $content.="<br/><a href='$url'>Click Here</a>";
    if (!isset($client_cards[$i + 1]) || $client_cards[$i]['client_id'] != $client_cards[$i + 1]['client_id'])
        $data[$row['client_id']]['client_application_deadline'] = str_replace("~~CONTENT~~", $content, $mail['client_application_deadline']);
    $i++;
}
if ($i != 0)
    $data[$client_id]['client_application_deadline'] = str_replace("~~CONTENT~~", $content, $mail['client_application_deadline']);
	
########### Upcoming Interview Reminder 5.2 ###########
$query = "SELECT CARD.client_id, CARD.company_name,CARD.id,CARD.position_available from jsb_client C INNER JOIN jsb_card CARD ON (CARD.client_id=C.id and CARD.recycle_bin='0') and CARD.interview_date!='0000-00-00' and datediff(CARD.interview_date,curdate())=1 and CARD.column_status='S' and C.reminder_mail='1' $client_cond order by C.id asc"; 
$i = 0;
$client_cards = array();
$results =$this->Card->query($query);
//print_r($results);
foreach($results as $result) {
	$row=$result['CARD'];
    $client_cards[$i] = $row;
    if ($i != 0 && $client_cards[$i]['client_id'] != $client_cards[$i - 1]['client_id']) {
        $data[$row['client_id']]['client_upcoming_interview'] = str_replace("~~CONTENT~~", $content, $mail['client_upcoming_interview']);
        $content = "";
    } elseif ($i == 0)
        $content = "";
    $client_id = $row['client_id'];
    $content.="<br><br/><b>Company Name:</b> $row[company_name]<br><b>Position Available:</b>$row[position_available]";
   $query_string = "file=jobcards&action=index&card_id=cardShow_$row[id]";
    $url = SITE_URL . "/Pages/display?$query_string";
    $content.="<br/><a href='$url'>Click Here</a>";
    if (!isset($client_cards[$i + 1]) || $client_cards[$i]['client_id'] != $client_cards[$i + 1]['client_id'])
        $data[$row['client_id']]['client_upcoming_interview'] = str_replace("~~CONTENT~~", $content, $mail['client_upcoming_interview']);
    $i++;
}
if ($i != 0)
    $data[$client_id]['client_upcoming_interview'] = str_replace("~~CONTENT~~", $content, $mail['client_upcoming_interview']);	
	
########### Thank Note Reminder 5.3 ###########
$query = "SELECT CARD.client_id, CARD.company_name,CARD.position_available,CARD.id from jsb_client C INNER JOIN jsb_card CARD ON (CARD.client_id=C.id and CARD.recycle_bin='0') INNER JOIN jsb_card_column_detail CCD ON (CCD.card_id=CARD.id)  WHERE CCD.reminder_date!='0000-00-00' and
datediff(CCD.reminder_date,curdate())=1 and CARD.column_status='I' $client_cond order by C.id asc "; //0.0014
$i = 0;
$client_cards = array();
$results =$this->Card->query($query);
foreach($results as $result) {
	$row=$result['CARD'];
    $client_cards[$i] = $row;
    if ($i != 0 && $client_cards[$i]['client_id'] != $client_cards[$i - 1]['client_id']) {
        $data[$row['client_id']]['client_thank_note'] = str_replace("~~CONTENT~~", $content, $mail['client_thank_note']);
        $content = "";
    } elseif ($i == 0)
        $content = "";
    $client_id = $row['client_id'];
    $content.="<br><br><b>Company Name:</b> $row[company_name]<br>Position Available:$row[position_available]";
   $query_string = "file=jobcards&action=index&card_id=cardShow_$row[id]";
    $url = SITE_URL . "/Pages/display?$query_string";
    $content.="<br/><a href='$url'>Click Here</a>";

    if (!isset($client_cards[$i + 1]) || $client_cards[$i]['client_id'] != $client_cards[$i + 1]['client_id'])
        $data[$row['client_id']]['client_thank_note'] = str_replace("~~CONTENT~~", $content, $mail['client_thank_note']);
    $i++;
}
if ($i != 0)
    $data[$client_id]['client_thank_note'] = str_replace("~~CONTENT~~", $content, $mail['client_thank_note']);
	
########### Identify hiring timeframe (employer decision) 5.4 ###########
 $query = "SELECT CARD.client_id, CARD.company_name,CARD.position_available,CARD.id from jsb_client C INNER JOIN jsb_card CARD ON (CARD.client_id=C.id and CARD.recycle_bin='0') INNER JOIN jsb_card_column_detail CCD ON (CCD.card_id=CARD.id)  WHERE CCD.expected_date_of_employer_decision!='0000-00-00' and
datediff(CCD.expected_date_of_employer_decision,curdate())=1 and CARD.column_status='I' $client_cond order by C.id asc "; //0.0014
$i = 0;
$client_cards = array();
$results =$this->Card->query($query);
foreach($results as $result) {
	$row=$result['CARD'];
    $client_cards[$i] = $row;
    if ($i != 0 && $client_cards[$i]['client_id'] != $client_cards[$i - 1]['client_id']) {
        $data[$row['client_id']]['expected_date_of_employer_decision'] = str_replace("~~CONTENT~~", $content, $mail['expected_date_of_employer_decision']);
        $content = "";
    } elseif ($i == 0)
        $content = "";
    $client_id = $row['client_id'];
    $content.="<br><br><b>Company Name:</b> $row[company_name]<br>Position Available:$row[position_available]";
    $query_string = "file=jobcards&action=index&card_id=cardShow_$row[id]";
    $url = SITE_URL . "/Pages/display?$query_string";
    $content.="<br/><a href='$url'>Click Here</a>";

    if (!isset($client_cards[$i + 1]) || $client_cards[$i]['client_id'] != $client_cards[$i + 1]['client_id'])
        $data[$row['client_id']]['expected_date_of_employer_decision'] = str_replace("~~CONTENT~~", $content, $mail['expected_date_of_employer_decision']);
    $i++;
}
if ($i != 0)
    $data[$client_id]['expected_date_of_employer_decision'] = str_replace("~~CONTENT~~", $content, $mail['expected_date_of_employer_decision']);	
	
	
	
	
	########### Permission follow up  5.5 ###########
 $query = "SELECT CARD.client_id, CARD.company_name,CARD.position_available,CARD.id from jsb_client C INNER JOIN jsb_card CARD ON (CARD.client_id=C.id and CARD.recycle_bin='0') INNER JOIN jsb_card_column_detail CCD ON (CCD.card_id=CARD.id)  WHERE CCD.permission_followup!='0000-00-00' and
datediff(CCD.permission_followup,curdate())=1 and CARD.column_status='I' $client_cond order by C.id asc "; //0.0014
$i = 0;
$client_cards = array();
$results =$this->Card->query($query);
foreach($results as $result) {
	$row=$result['CARD'];
    $client_cards[$i] = $row;
    if ($i != 0 && $client_cards[$i]['client_id'] != $client_cards[$i - 1]['client_id']) {
        $data[$row['client_id']]['client_interview_follow'] = str_replace("~~CONTENT~~", $content, $mail['client_interview_follow']);
        $content = "";
    } elseif ($i == 0)
        $content = "";
    $client_id = $row['client_id'];
    $content.="<br><br><b>Company Name:</b> $row[company_name]<br>Position Available:$row[position_available]";
    $query_string = "file=jobcards&action=index&card_id=cardShow_$row[id]";
    $url = SITE_URL . "/Pages/display?$query_string";
    $content.="<br/><a href='$url'>Click Here</a>";

    if (!isset($client_cards[$i + 1]) || $client_cards[$i]['client_id'] != $client_cards[$i + 1]['client_id'])
        $data[$row['client_id']]['client_interview_follow'] = str_replace("~~CONTENT~~", $content, $mail['client_interview_follow']);
    $i++;
}
if ($i != 0)
    $data[$client_id]['client_interview_follow'] = str_replace("~~CONTENT~~", $content, $mail['client_interview_follow']);
	
		########### Learn desired start date 5.6  ###########
 $query = "SELECT CARD.client_id, CARD.company_name,CARD.position_available,CARD.id from jsb_client C INNER JOIN jsb_card CARD ON (CARD.client_id=C.id and CARD.recycle_bin='0') INNER JOIN jsb_card_column_detail CCD ON (CCD.card_id=CARD.id)  WHERE CCD.desired_start_date!='0000-00-00' and
datediff(CCD.desired_start_date,curdate())=1 and CARD.column_status='V' $client_cond order by C.id asc "; //0.0014
$i = 0;
$client_cards = array();
$results =$this->Card->query($query);
foreach($results as $result) {
	$row=$result['CARD'];
    $client_cards[$i] = $row;
    if ($i != 0 && $client_cards[$i]['client_id'] != $client_cards[$i - 1]['client_id']) {
        $data[$row['client_id']]['desired_start_date'] = str_replace("~~CONTENT~~", $content, $mail['desired_start_date']);
        $content = "";
    } elseif ($i == 0)
        $content = "";
    $client_id = $row['client_id'];
    $content.="<br><br><b>Company Name:</b> $row[company_name]<br>Position Available:$row[position_available]";
    $query_string = "file=jobcards&action=index&card_id=cardShow_$row[id]";
    $url = SITE_URL . "/Pages/display?$query_string";
    $content.="<br/><a href='$url'>Click Here</a>";

    if (!isset($client_cards[$i + 1]) || $client_cards[$i]['client_id'] != $client_cards[$i + 1]['client_id'])
        $data[$row['client_id']]['desired_start_date'] = str_replace("~~CONTENT~~", $content, $mail['desired_start_date']);
    $i++;
}
if ($i != 0)
    $data[$client_id]['desired_start_date'] = str_replace("~~CONTENT~~", $content, $mail['desired_start_date']);
	
	########### Expected date of employer decision 5.7  ###########
 $query = "SELECT CARD.client_id, CARD.company_name,CARD.position_available,CARD.id from jsb_client C INNER JOIN jsb_card CARD ON (CARD.client_id=C.id and CARD.recycle_bin='0') INNER JOIN jsb_card_column_detail CCD ON (CCD.card_id=CARD.id)  WHERE CCD.expected_response!='0000-00-00' and
datediff(CCD.expected_response,curdate())=1 and CARD.column_status='V' $client_cond order by C.id asc "; //0.0014
$i = 0;
$client_cards = array();
$results =$this->Card->query($query);
foreach($results as $result) {
	$row=$result['CARD'];
    $client_cards[$i] = $row;
    if ($i != 0 && $client_cards[$i]['client_id'] != $client_cards[$i - 1]['client_id']) {
        $data[$row['client_id']]['client_expected_response'] = str_replace("~~CONTENT~~", $content, $mail['client_expected_response']);
        $content = "";
    } elseif ($i == 0)
        $content = "";
    $client_id = $row['client_id'];
    $content.="<br><br><b>Company Name:</b> $row[company_name]<br>Position Available: $row[position_available]";
    $query_string = "file=jobcards&action=index&card_id=cardShow_$row[id]";
    $url = SITE_URL . "/Pages/display?$query_string";
    $content.="<br/><a href='$url'>Click Here</a>";

    if (!isset($client_cards[$i + 1]) || $client_cards[$i]['client_id'] != $client_cards[$i + 1]['client_id'])
        $data[$row['client_id']]['client_expected_response'] = str_replace("~~CONTENT~~", $content, $mail['client_expected_response']);
    $i++;
}
if ($i != 0)
    $data[$client_id]['client_expected_response'] = str_replace("~~CONTENT~~", $content, $mail['client_expected_response']);
	
	
	
//print_r($data);die;
########### Client Less Card  ###########
/* $query = "SELECT C.id as client_id, count(CARD.id) as countcard from jsb_client C LEFT JOIN jsb_card CARD ON (CARD.client_id=C.id and CARD.recycle_bin='0') where C.reminder_mail='1' $client_cond group by C.id  having countcard<5";  
$results=$this->Client->query($query);
foreach($results as $row) {
	$query_string = (urlencode("file=add_card.php"));
    $url = SITE_URL . "index.php?q=$query_string";
    $url = "<a href='$url'>Click Here</a>";
    $data[$row['C']['client_id']]['client_less_card'] = str_replace('~~CONTENT~~', $url, $mail['client_less_card']);
}*/



########### Client Task pending 5.8 ###########
 
$query="select Task.id,Task.name,Task.due_date,C.id as client_id,CARD.id as card_id from jsb_client C 
INNER JOIN jsb_card CARD  ON (CARD.client_id=C.id AND CARD.expired='0' and CARD.recycle_bin='0')
INNER JOIN jsb_tasks Task ON (CARD.id=Task.card_id)
where Task.task_status!='1' AND Task.reminder_flag='1' AND datediff(Task.reminder_date,curdate())=0 $client_cond order by C.id";
$results1=$this->Client->query($query);

$query="select Task.id,Task.name,Task.due_date,C.id as client_id from jsb_client C 
INNER JOIN jsb_tasks Task ON (C.id=Task.client_id)
where Task.task_status!='1' AND Task.reminder_flag='1' AND datediff(Task.reminder_date,curdate())=0 $client_cond order by C.id";
$results2=$this->Client->query($query);
$results=array_merge($results1,$results2);
$i = 0;
$client_cards = array();
foreach($results as $result) { 
	$row=array_merge($result['Task'],$result['C']);
    $client_cards[$i] = $row;	
    if ($i != 0 && $client_cards[$i]['client_id'] != $client_cards[$i - 1]['client_id']) {
        $data[$row['client_id']]['client_upcoming_task'] = str_replace("~~CONTENT~~", $content, $mail['client_upcoming_task']);
        $content = "";
    } elseif ($i == 0)
        $content = "";
    $client_id = $row['client_id'];
    $content.="<br><br/><b>Task Name:</b> $row[name]<br><b>Due Date:</b> $row[due_date]";
   
	if(isset($result['CARD']))
		$query_string = "&card_id=cardtask_".$result['CARD']['card_id']."_$row[id]";
	else
		$query_string = "&card_id=task_$row[id]";
    $url = SITE_URL . "/Pages/display?file=jobcards&action=view$query_string";
    $content.="<br/><a href='$url'>Click Here</a>";
    if (!isset($client_cards[$i + 1]) || $client_cards[$i]['client_id'] != $client_cards[$i + 1]['client_id'])
        $data[$row['client_id']]['client_upcoming_task'] = str_replace("~~CONTENT~~", $content, $mail['client_upcoming_task']);
    $i++;
}
if ($i != 0)
    $data[$client_id]['client_upcoming_task'] = str_replace("~~CONTENT~~", $content, $mail['client_upcoming_task']);	
//echo "<pre>";
//print_r($data[$client_id]);die;

########### Client No Card Movement ###########

 $query="select C.id as client_id,C.same_card_days,count(CARD.id) as count from jsb_client C 
INNER JOIN jsb_card CARD  ON (CARD.client_id=C.id)
INNER JOIN jsb_card_detail CDA ON (CARD.id=CDA.card_id)
where C.same_card_days!='0' and CARD.column_status!='J' and CARD.recycle_bin='0' and CDA.end_date='0000-00-00 00:00:00'
and datediff(curdate(),CDA.start_date)>=C.same_card_days and C.reminder_mail='1' and CARD.column_status!=''
$client_cond group by C.id order by C.id";
$i = 0;
$client_cards = array();
$results=$this->Client->query($query);
foreach($results as $row) { 
    $query_string = "file=jobcards&action=index";
    $url = SITE_URL . "/Pages/display?$query_string";
    $content="<a href='$url'>".$row[0]['count']."</a>";
	//$content=str_replace("~~CONTENT~~", $content, $mail['client_no_card_movement']);
    $data[$row['C']['client_id']]['client_no_card_movement'] = $content;

}
########## PAI Status 1.2 ##########
$query = "SELECT C.id,C.count_colS,C.count_colA,C.count_colI,count_colSI,count_colV,count_colJ from jsb_client C where reminder_mail='1' $client_cond order by C.id";  //0.0431 sec
$results=$this->Client->query($query);
foreach($results as $user) {     
   //$pai = $this->getSAI($user['C']['id']);
   $i=$user['C']['count_colI']+$user['C']['count_colV']+$user['C']['count_colJ'];
   $a=$user['C']['count_colA']+$user['C']['count_colSI']+$i;
   $s=$user['C']['count_colS']+$a;
    $pai = $s.'-'.$a.'-'.$i;
	//print_r($mail['client_pai']);
    $data[$user['C']['id']]['client_pai'] = str_replace("~~PAI_STATUS~~",$pai, $mail['client_pai']);
}

#################################### Strat Challenges Section ####################################
 #------------------------------ Challenge reminder  ------------------------------#
 $query = " SELECT C.id, date_add(challenge_date,interval  (select max(week_id) from jsb_challenge_client where client_id=C.id)-1 week ) as start_date, date_add(C.challenge_date,interval (select max(week_id) from jsb_challenge_client where client_id=C.id)*7-1  DAY) as end_date, R.week_id, datediff( curdate( ) , C.challenge_date ) AS daydiff, SUM( CL.points ) AS total, SUM( R.points ) AS achived, SUM( CL.points ) - SUM( R.points ) AS required FROM jsb_challenge CL INNER JOIN jsb_challenge_client R ON ( CL.id = R.challenge_id ) INNER JOIN jsb_client C ON ( C.id = R.client_id ) WHERE C.challenge_date != '0000-00-00' AND C.challenge_survey_status=1 AND week_id = ( SELECT max( week_id ) FROM jsb_challenge_client WHERE client_id = C.id ) $client_cond GROUP BY C.id ORDER BY C.id ASC"; //0.0021

  $results=$this->Client->query($query);
foreach($results as $user) {
	   $point_needed=$user[0]['total'];
	   $point_achieved=$user[0]['achived'];
	   $point_remaining=$user[0]['required'];	
       $data[$user['C']['id']]['i_score']=number_format(($point_achieved / $point_needed) * 100, 2);
	   $data[$user['C']['id']]['challenge_reminder'] = str_replace(array('~~START_DATE~~', '~~END_DATE~~', '~~POINT_NEEDED~~', '~~POINT_ACHIEVED~~', '~~POINT_REMAINING~~'), array(show_formatted_date($user[0]['start_date']), show_formatted_date($user[0]['end_date']), $point_needed, $point_achieved, $point_remaining), $mail['challenge_reminder']);
}
#------------------------------ Challenge Renewal  ------------------------------#
$query = " SELECT C.id, count(R.id) as tot,date_format(C.challenge_date, '%Y-%m-%d' ) AS challenge_date,date_format( R.date_started, '%Y-%m-%d' ) AS start_date, date_format( date_add( R.date_started, INTERVAL 6 DAY ) , '%Y-%m-%d' ) AS end_date, R.week_id, SUM( CL.points ) AS total, SUM( R.points ) AS achived, SUM( CL.points ) - SUM( R.points ) AS required FROM jsb_challenge CL INNER JOIN jsb_challenge_client R ON ( CL.id = R.challenge_id ) INNER JOIN jsb_client C ON ( C.id = R.client_id ) WHERE C.challenge_date != '0000-00-00' AND C.challenge_survey_status=1 AND ((datediff( curdate( ) , C.challenge_date )%28)=0 OR ((datediff( curdate( ) , C.challenge_date )%28)<=2 AND datediff( curdate( ) , C.challenge_survey_date )>28 AND datediff( curdate( ) , C.challenge_survey_date )<31)) GROUP BY R.client_id, R.week_id ORDER BY C.id ASC,R.week_id DESC"; //0.0021

  $results=$this->Client->query($query);    
  $content="";
  $ct=0;
foreach($results as $key=>$user) { 
		if($ct==0) 
		{	
			$week_id=$user['R']['week_id']-4;
			$end_date=$user[0]['end_date'];	
			$newdate = strtotime ( '-4 week' , strtotime ( $end_date ) ) ;
			$start_date = date ( 'Y-m-j' , $newdate );
			$this->Client->query("update jsb_client set challenge_survey_status=0 where id=".$user['C']['id']);				
		}	
			
		if($user['R']['week_id']>=$week_id)
		{
	  		$content.="<br><strong>Statistics for Week ".$user['R']['week_id']." (" .show_formatted_date($user[0]['start_date']). "-" .show_formatted_date($user[0]['end_date']). ")</strong><br>Number of challenges taken from: " . $user[0]['tot'] . "<br>Number of points needed during week: " . $user[0]['total'] . "<br>Number of points achieved during week: " . $user[0]['achived'] . "<br>";
		}
		if(!isset($results[$key+1]['C']['id']) || $results[$key+1]['C']['id']!=$user['C']['id'])
		{
	    	$query_string = "file=Challenges&action=index&card_id=renew";	
			$renew_url =SITE_URL. "/Pages/display?".$query_string;
			$query_string = "file=Challenges&action=index&card_id=cancel";	     
   			$cancel_url =SITE_URL. "/Pages/display?".$query_string;
    		$data[$user['C']['id']]['challenge_new_reminder'] = str_replace(array('~~FROM_DATE~~', '~~TO_DATE~~', '~~RENEW_URL~~', '~~CANCEL_URL~~', '~~CONTENT~~'), array(show_formatted_date($start_date),show_formatted_date($end_date), $renew_url, $cancel_url, $content), $mail['challenge_new_reminder']);			
			$content="";
			$ct=-1;			
		}
		
		$ct++;
	}		
################################### End Challenges Section ######################################
   
//    mysql_query("update $client_table set last_mail_date=curdate() where last_mail_date='0000-00-00' or datediff(curdate(),last_mail_date)>=7");


//Combinding All Mails to user By User
$query = "select C.*, count(F.id) as file  from jsb_client C $account_join Left JOIN jsb_client_files F ON(C.id=F.client_id) where 1 $client_cond $account_cond GROUP BY C.id"; //0360 	
//die;	
$results=$this->Client->query($query);
$p=0; $mail_sent=array(); $all_user=array(); $m=0;
foreach($results as $result) {		
		$client=$result['C'];	
		//echo '<pre>';print_r($data[$client['id']]);die;
		$row = $data[$client['id']];
		$row['client_id']=$client['id'];
		
		$indeed_jobs=$JobCards->get_indeed_jobs($client['id']);		
		if(!empty($indeed_jobs))
		{
			$t=0;
			for($r=0;$r<5;$r++)
			{
				$row['indeed_job'][$r]="<td style='font-size:14px; line-height:16px; font-family:\'Trebuchet MS\', Arial, Helvetica, sans-serif; color:#404040; font-style:italic;'>".$indeed_jobs[$r]['jobtitle']."</td>&nbsp;<td>".$indeed_jobs[$r]['company']."</td>&nbsp;<td><a href='".SITE_URL."/Pages/display?file=jobcards&action=index&card_id=jobkey_".$indeed_jobs[$r]['jobkey']."'><img src='".SITE_URL."/img/create_card.png' alt=''/></a></td>";		
			}	
		}
    	$s_score =$this->getStScore($client['id']);    
    	if (!isset($data[$client['id']]['i_score']))
        	$i_score = 0;
   		else
       		$i_score = $data[$client['id']]['i_score'];
		//$jobType=$this->getJobAB($client['id']);
		$jobType=$client['count_jobA'].':'.$client['count_jobB'];	
		// Profile % start ///	
		//$profile=$this->profilePercent($client['id']);
		
		$profile=$progress=0;
		$progress_stp_val=20; //14.285	
		
	if($client['job_a_title']!=NULL && $client['job_a_title']!='')
		{$progress+=$progress_stp_val; }
	if($client['job_a_skills']!=NULL && $client['job_a_skills']!='')
		{$progress+=$progress_stp_val;}
	if($client['job_b_criteria']!=NULL && $client['job_b_criteria']!='')
		{$progress+=$progress_stp_val; }	
	if($client['state']!= NULL && $client['city']!=NULL && $client['postalcode']!=NULL && $client['state']!='' && $client['city']!='' && $client['postalcode']!='') 
		{ $progress+=$progress_stp_val; }		
	if($result[0]['file']>0)
		{ $progress+=$progress_stp_val;}
	$profile=round($progress,2);	
	// Profile % END ///	
		
		$view = new View($this, false);
		$view->layout='ajax';
		
		$view->set('site_url',SITE_URL);
		$view->set('name',$client['name']);
		$view->set('s_score',$s_score);	
		$view->set('i_score',$i_score);	
		$view->set('jobType',$jobType);	
		$view->set('row',$row);
		
		$query_string = "file=jobcards&action=profileView";
    	$url = SITE_URL . "/Pages/display?$query_string"; 
		$profile_view=$profile."%  <a href='$url' style='color:#0a79a7;text-decoration:none;'> (View Profile)</a>";
		$view->set('profile',$profile_view); 
		
		$query_string = "file=jobcards&action=index&card_id=social";
    	$url = SITE_URL . "/Pages/display?$query_string";   
	
		if(!$client['profile_id'])
			$facebook="<a href='$url'>Connect Facebook (add)</a>";
		else
			$facebook="<a href='$url'>Connect Facebook (added)</a>";
		$view->set('facebook',$facebook);
		if(!$client['linkedin_id'])
			$linkedin="<a href='$url'>Connect Linkedin (add)</a>";
		else
			$linkedin="<a href='$url'>Connect Linkedin (added)</a>";
		$view->set('linkdin',$linkedin);	
		//$view->set('profile',$profile); 
		//$this->set('isdaily','1');
		$view_output = $view->element('daily_digest');		
		//print_r($view_output);
		$subject='Your Job Search Daily Digest';
		$from='admin@snagpad.com';
		$to=$client['email'];
		//$to='narendra.nitm@gmail.com';	
		//$to='gautam.kumar@i-webservices.com';	
		//echo print_r($view_output);die;	
		//$all_user[$p]['to_user']=$to;
		if(!empty($to)&&(Validation::email($to, true)))
		{
			//print_r($view_output);
			$cakemail = new CakeEmail();		
			//$cakemail->viewRender();
			$cakemail->template('default');
			$cakemail->viewVars(array('isdaily'=>'1'));
			$cakemail->emailFormat('html')->from($from)
										  ->to($to)						  							 
										  ->subject($subject)
										  ->send($view_output);
			//echo $to.'<br>';							  
											  
			$mail_sent[$p]=$to;
			$p++;
		}							  
		
		
//print_r($content); 
}


		/*	$cakemail = new CakeEmail();		
			$cakemail->template('default');
			$cakemail->emailFormat('html')->from('support@snagpad.com')
										  ->to('vivek.sharma@i-webservices.com')				  							 
										  ->subject('cron mail sent email ID')
										  ->send($mail_sent);	*/


 // die;

		
}

	function getSAI($clientid){
		$card_SAI_status['O']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.column_status'=>'O')));	
		$card_SAI_status['A']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.column_status'=>array('A','S','I','V','J'))));	
		$card_SAI_status['I']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.column_status'=>array('I','V','J'))));	
		$SAI=$card_SAI_status['O'].'-'.$card_SAI_status['A'].'-'.$card_SAI_status['I'];
		return $SAI;
	}
	function getJobAB($clientid){
		$Job_status['A']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.job_type'=>'A')));	
		$Job_status['B']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.column_status'=>'B')));		
		$Job=$Job_status['A'].':'.$Job_status['B'];
		return $Job;		
	}
	
	 public function getStScore($clientid=null) {

        if(empty($clientid))
        {
        $clientid=$this->Session->read('Client.Client.id');	
        }
      //$clientid=$this->Session->read('Client.Client.id'); 
	  //echo $clientid;die;
	  $count=0;
		$sql="select count(*) as count,`column` from jsb_checklist  as Checklist group by `column`";
		$checkbox=$this->Checklist->query($sql);
		$val=array('O','A','S','I','V','J');
		$arr=array();
		foreach($val as $v)
		{
			$arr[$v]['total_checklist']=0;
			$arr[$v]['total_cards']=0;
				
		}
		
		foreach($checkbox as $check)
		{
			$arr[$check['Checklist']['column']]['total_checklist']=$check['0']['count']+$count-1;
			$count+=$check['0']['count']-1;	
		}
		
		$arr['J']['total_checklist']=$arr['J']['total_checklist']+1;
		$q="select count(*) as count, column_status from jsb_card as Card where client_id ='".$clientid."' and expired='0' and recycle_bin='0' and column_status in ('O','A','S','I','V','J') group by column_status";
		$num_cards=$this->Card->query($q);
		
		
		$tot=0; $card=array();
		foreach($num_cards as $card){
			$arr[$card['Card']['column_status']]['total_cards']=$card['0']['count'];    
			$tot+=$card['0']['count'];
		}
		
		$query="select count(CL.id) as count from jsb_card C INNER JOIN jsb_card_checklist CL ON (C.id=CL.card_id) where C.client_id='".$clientid."' and C.expired='0' and C.recycle_bin='0' and CL.status='1' and CL.checklist_id NOT in ('10','18','29','36','43')";
   		$count=$this->Card->query($query);
   		//echo '<pre>';print_r($count);die;
  		
    	$divide=($arr['O']['total_checklist']*$arr['O']['total_cards'])+
                ($arr['A']['total_checklist']*$arr['A']['total_cards'])+
                ($arr['I']['total_checklist']*$arr['I']['total_cards'])+
                ($arr['S']['total_checklist']*$arr['S']['total_cards'])+($arr['V']['total_checklist']*$arr['V']['total_cards'])
				+($arr['J']['total_checklist']*$arr['J']['total_cards']);
		if($divide==0)
		{
			$score=0;	
		}else{
			$score=((($count['0']['0']['count']*100)/
            (
                ($arr['O']['total_checklist']*$arr['O']['total_cards'])+
                ($arr['A']['total_checklist']*$arr['A']['total_cards'])+
                ($arr['I']['total_checklist']*$arr['I']['total_cards'])+
                ($arr['S']['total_checklist']*$arr['S']['total_cards'])+($arr['V']['total_checklist']*$arr['V']['total_cards'])
				+($arr['J']['total_checklist']*$arr['J']['total_cards'])
				)));
		}
	$final_score=round($score,2);
	
	//print_r($score);
	//die;
    return $final_score;
}
function profilePercent($client_id)
	{	
	$client=$this->Client->findById($client_id);

	$files=$this->Clientfile->find('count',array('fields'=>'Clientfile.id','conditions'=>array('Clientfile.client_id'=>$client_id)));
	//	echo '<pre>';print_r($files);die;
	$step=0; $progress=0; $progress_stp_val=20; //14.285
	if($client['Client']['job_a_title']!=NULL && $client['Client']['job_a_title']!='')
		{	$step++; $progress+=$progress_stp_val; }
	if($client['Client']['job_a_skills']!=NULL && $client['Client']['job_a_skills']!='')
		{ $step++; $progress+=$progress_stp_val; }
	if($client['Client']['job_b_criteria']!=NULL && $client['Client']['job_b_criteria']!='')
		{ $step++; $progress+=$progress_stp_val; }
	/* if($client['Client']['highest_education']!=NULL && $client['Client']['degree_obtained']!=NULL && $client['Client']['highest_education']!='' && $client['Client']['degree_obtained']!='' &&  $client['Client']['highest_education']!=0 && $client['Client']['degree_obtained']!=0) 
	 	{ $step++; $progress+=14.285; }*/
	if($client['Client']['state']!= NULL && $client['Client']['city']!=NULL && $client['Client']['postalcode']!=NULL && $client['Client']['state']!='' && $client['Client']['city']!='' && $client['Client']['postalcode']!='') 
		{ $step++; $progress+=$progress_stp_val; }
	/*if($client['Client']['job_type']!=0 && $client['Client']['job_function']!=0 && $client['Client']['tposition']!=0) 
		{ $step++; $progress+=14.285; }*/		
	if($files>0)
		{ $step++; $progress+=$progress_stp_val; }
		
	 $progress=round($progress,2);
	return $progress;
	}	
	
	
	public function CoachMail(){
		
		
		$this->autoRender = false;
		$this->layout='ajax';
		$coach=$this->Coach->find('all',array('conditions'=>array('Coach.reminder_mail'=>1)));
		//echo '<pre>';print_r($coach);die;
		//$my_coach=$this->Coach->findById('14');
		//echo '<pre>';print_r($my_coach);die;
		//$coach[0]=$my_coach;
		$client=array();
		$t_date=date('Y-m-d H:i:s');
		$i=0;
		$cl_details=array();
		foreach($coach as $ch)
		{
		  if($ch['Coach']['reminder_mail']==1)
		  {
			$clients[$i]['Total_CL']=$this->Client->find('count',array('conditions'=>array('Client.coach_id'=>$ch['Coach']['account_id'])));
			
			$q="SELECT C.id,C.name,C.email,C.latest_card_mov_date,C.job_pref_modified,C.job_a_title,C.job_a_skills,C.job_b_criteria,U.login_time, case when C.latest_card_mov_date != '0000-00-00 00:00:00' THEN datediff(curdate(),C.latest_card_mov_date) else 10000 END as activetime,format(datediff(curdate(),C.reg_date)/7,2) as diff FROM jsb_client C INNER JOIN jsb_user_log U ON (C.account_id=U.account_id and U.id=(SELECT MAX(id) FROM jsb_user_log WHERE jsb_user_log.account_id=C.account_id)) WHERE C.coach_id='".$ch['Coach']['account_id']."'";	
			
			$clients[$i]['CL']=$this->Client->query($q);
			
			$total_S_cards=0;
			$total_A_cards=0;
			$total_I_cards=0;
			$clients[$i]['CH']=$ch;
			$cl_details[$i]['count_login_flag']=0;
			$cl_details[$i]['count_cardmove_flag']=0;
			$cl_details[$i]['count_app_flag']=0;
			$cl_details[$i]['count_intvw_flag']=0;
			$cl_details[$i]['count_clientaction_flag']=0;
			$cl_details[$i]['CD_count_flag']=0;
			$cl_details[$i]['my_coachcard_flag']=0;
			$cl_details[$i]['Total_CH_Cards']=0;
			$cl_details[$i]['active_five']=0;
			$cl_details[$i]['active_three']=0;
			$cl_details[$i]['active']=0;
			$cl_details[$i]['job_pref_update_flag']=0;
			
			if(!empty($clients[$i]['CL']))
			{	
				
				$cl_details[$i]['count_clients']=$clients[$i]['Total_CL'];
				$j=0;
				/////////////Loop to process all Client data////////////////
				foreach($clients[$i]['CL'] as $cl)
				{
					$clients[$i]['CL'][$j]['S_cards']=0;
					$clients[$i]['CL'][$j]['A_cards']=0;
					$clients[$i]['CL'][$j]['I_cards']=0;
					/////////////Client Login////////////////
					if(!empty($cl['U']))
					{
						$diff=strtotime($t_date)-strtotime($cl['U']['login_time']);
						$days=$diff/(60 * 60 * 24);
						if($days >= $clients[$i]['CH']['Coach']['login_user'])
						{
							$clients[$i]['CL'][$j]['login']['name']=$cl['C']['name'];
							$clients[$i]['CL'][$j]['login']['email']=$cl['C']['email'];
							$cl_details[$i]['count_login_flag']=1;
						}	
					}
					/////////////Client Card movement////////////////
					if($cl['C']['latest_card_mov_date']!='0000-00-00 00:00:00')
					{
						$diff=strtotime($t_date)-strtotime($cl['C']['latest_card_mov_date']);
						$days=$diff/(60 * 60 * 24);
						
						if($days >= $clients[$i]['CH']['Coach']['card_moved'])
						{
							$clients[$i]['CL'][$j]['card_move']['id']=$cl['C']['id'];
							$clients[$i]['CL'][$j]['card_move']['name']=$cl['C']['name'];
							$clients[$i]['CL'][$j]['card_move']['email']=$cl['C']['email'];
							$cl_details[$i]['count_cardmove_flag']=1;
						}
					}
					
					/////////////Job Preference Update/////////////////
					if($cl['C']['job_pref_modified']!='0000-00-00 00:00:00'&&!empty($cl['C']['job_pref_modified']))
					{
						$card_date_diff=strtotime($t_date)-strtotime($cl['C']['job_pref_modified']);
						if($card_date_diff>0&&$card_date_diff<=86400)
						{
							$clients[$i]['CL'][$j]['job_pref_update']['cl_id']=$cl['C']['id'];
							$clients[$i]['CL'][$j]['job_pref_update']['cl_name']=$cl['C']['name'];
							$clients[$i]['CL'][$j]['job_pref_update']['job_A']=$cl['C']['job_a_title'];
							$clients[$i]['CL'][$j]['job_pref_update']['job_Skills']=$cl['C']['job_a_skills'];
							$clients[$i]['CL'][$j]['job_pref_update']['job_Criteria']=$cl['C']['job_b_criteria'];
							$cl_details[$i]['job_pref_update_flag']=1;
						}
					}
					
					/////////////Active Client////////////////
					if(isset($cl['0']['activetime']))
					{
						//echo '<pre>';print_r($cl['0']['activetime'].'<br>');
						if($cl['0']['activetime']>5||$cl['0']['activetime']==10000){ $cl_details[$i]['active_five']++; 
						}if($cl['0']['activetime']>3&&$cl['0']['activetime']<5){ $cl_details[$i]['active_three']++;	
						}else if($cl['0']['activetime']<=3){ $cl_details[$i]['active']++;	 }
					}
					
					$clients[$i]['CL'][$j]['CD']=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$cl['C']['id'],'Card.expired'=>'0','Card.recycle_bin'=>'0'),'fields'=>array('Card.id','Card.company_name','Card.interview_date','Card.application_deadline','Card.column_status','Card.latest_card_mov_date','type_of_opportunity')));			
					if(!empty($clients[$i]['CL'][$j]['CD']))
					{
						$clients[$i]['CL'][$j]['CD_CL_id']=$cl['C']['id'];
						$clients[$i]['CL'][$j]['CD_CL_name']=$cl['C']['name'];
						$clients[$i]['CL'][$j]['CD_app_count']=0;
						$clients[$i]['CL'][$j]['CD_intvw_count']=0;
						
						$k=0; $l=0;
						/////////////Loop to process all Card data////////////////
						foreach($clients[$i]['CL'][$j]['CD'] as $cd)
						{
							if($ch['Coach']['application_deadline']==1)
							{
								/////////////Application Pending////////////////
								if(!empty($cd['Card']['application_deadline'])&&((strtotime($cd['Card']['application_deadline'])-strtotime($t_date))>0)&&($cd['Card']['column_status']=='O'))
								{
									$clients[$i]['CL'][$j]['CD_app_count']++;	
									$cl_details[$i]['count_app_flag']=1;
								}
							}
							
							if($ch['Coach']['interview']==1)
							{
								/////////////Upcoming Interview////////////////
								if(!empty($cd['Card']['interview_date'])&&((strtotime($cd['Card']['interview_date']." 00:00:00")-strtotime($t_date))>0))
								{
									$clients[$i]['CL'][$j]['CD_intvw_count']++;	
									$cl_details[$i]['count_intvw_flag']=1;
								}
							}
							
							/////////////Client Action Required////////////////	
							if($cd['Card']['column_status']=='S'||$cd['Card']['column_status']=='I'||$cd['Card']['column_status']=='V')
							{
								$card_date_diff=strtotime($t_date)-strtotime($cd['Card']['latest_card_mov_date']);
								if($card_date_diff>0&&$card_date_diff<86400)
								{
									$cl_details[$i]['count_clientaction_flag']=1;
									$clients[$i]['CL'][$j]['ACT'][$k]['CD_id']=$cd['Card']['id'];
									$clients[$i]['CL'][$j]['ACT'][$k]['CD_comp']=$cd['Card']['company_name'];	
									$clients[$i]['CL'][$j]['ACT'][$k]['CD_col']=$cd['Card']['column_status'];
									$clients[$i]['CL'][$j]['ACT'][$k]['CD_CL']=$cl['C']['name'];
									$k++;
								}	
								
							}
							
							/////////////My Coach Cards/////////////////////
						if($cd['Card']['type_of_opportunity']=='Coach')
						{
							$cl_details[$i]['Total_CH_Cards']++;
							$card_date_diff=strtotime($t_date)-strtotime($cd['Card']['latest_card_mov_date']);
							if($card_date_diff>0&&$card_date_diff<86400)
							{
								$cl_details[$i]['my_coachcard_flag']=1;
								$clients[$i]['CL'][$j]['CH_card'][$l]['CD_id']=$cd['Card']['id'];
								$clients[$i]['CL'][$j]['CH_card'][$l]['CD_comp']=$cd['Card']['company_name'];	
								$clients[$i]['CL'][$j]['CH_card'][$l]['CD_col']=$cd['Card']['column_status'];
								$clients[$i]['CL'][$j]['CH_card'][$l]['CD_CL']=$cl['C']['name'];
								$clients[$i]['CL'][$j]['CH_card'][$l]['CD_CH']=$ch['CH']['Coach']['name'];
								$l++;
							}	
								
						}
						
						/////////////S-A-I///////////////////
						switch($cd['Card']['column_status'])
						{
							case 'O': 	$clients[$i]['CL'][$j]['S_cards']++; $total_S_cards++; break;
							case 'A': 	$clients[$i]['CL'][$j]['A_cards']++; $total_A_cards++; break;
							case 'I': 	$clients[$i]['CL'][$j]['I_cards']++; $total_I_cards++; break;
						}
							
						}	
						
						/////////////Less than 5 Jobcards////////////////	
						if(count($clients[$i]['CL'][$j]['CD'])<5)
						{
							$cl_details[$i]['CD_count_flag']=1;
							$clients[$i]['CL'][$j]['Less_CD']['cl_id']=$cl['C']['id'];
							$clients[$i]['CL'][$j]['Less_CD']['cl_name']=$cl['C']['name'];
						}
						
											
					}
					$j++;
				}
				//die;
				
			}
			
			/////////////Average S-A-I for Coach of all clients///////////////////
			if($clients[$i]['Total_CL']==0)
			{
				$cl_details[$i]['avg_S_cards']=$cl_details[$i]['avg_A_cards']=$cl_details[$i]['avg_I_cards']=0;
			}else{
				$cl_details[$i]['avg_S_cards']=$total_S_cards/$clients[$i]['Total_CL'];
				$cl_details[$i]['avg_A_cards']=$total_A_cards/$clients[$i]['Total_CL'];	
				$cl_details[$i]['avg_I_cards']=$total_I_cards/$clients[$i]['Total_CL'];		
			
			}
		if($cl_details[$i]['count_cardmove_flag']!=0||$cl_details[$i]['count_login_flag']!=0||$cl_details[$i]['count_app_flag']!=0||$cl_details[$i]['count_intvw_flag']!=0)
			{
				$tot_cl=$cl_details[$i]['count_clients']-($cl_details[$i]['active_five']+$cl_details[$i]['active_three']+$cl_details[$i]['active']);
				if($tot_cl!==0)
				{
					$cl_details[$i]['active_five']+=$tot_cl;	
				}
				$this->sendCoachMail($clients[$i],$cl_details[$i]);
			}
			$i++;
			
			}
		}
			echo 'Coach mail sent';
			//echo '<pre>';print_r($cl_details);die;	
		
	}
	
	
	public function sendCoachMail($data,$details){
		
		$this->autoRender = false;
		$view = new View($this, false);
		$view->layout='ajax';
		$view->set('data', $data);
		$view->set('check', $details);
		$view->set('site_url', SITE_URL);
		$view_output = $view->element('coach_notification_mail');
		//echo $view_output;die;
		$subject='SnagPad: Your Daily Client Update';
		
		
		if(!empty($data['CH']['Coach']['email'])&&(Validation::email($data['CH']['Coach']['email'], true)))
		{
		$cakemail = new CakeEmail();
		$cakemail->template('default');
		$cakemail->viewVars(array('coach_notification'=>'1'));
		$cakemail->emailFormat('html')->from('admin@snagpad.com')
									  ->to($data['CH']['Coach']['email'])
									//  ->cc('mahaveer.prasad47@gmail.com')
									 // ->bcc('vivek.sharma@i-webservices.com')
									  ->subject($subject)
								   	  ->send($view_output);	
		}
		return;
			
			
		}
		
		public function oddsMeter(){		
			
			$sql="SELECT CL.name ,C.id, C.total_points, C.column_status ,DATEDIFF(CURDATE(),C.latest_card_mov_date) as days FROM jsb_card C INNER JOIN jsb_client CL ON (CL.id=C.client_id ) WHERE C.expired='0' AND C.recycle_bin='0' having days>9 and C.total_points>0 order by CL.id";
			$cards=$this->Card->query($sql);
			//print_r($cards);
			//die;
			/*
			Penalty per day in Opportunity = .0178% deduction in Odds score total
			Penalty per day in Opportunity = .0356% deduction in Odds score total after 5 days and no movement
			Penalty per day in Opportunity = .078% deduction in Odds score total after 7 days and no movement
			Odds score can go to 0% - not a negative %.
			 
			Penalty per day in Applied = .0178% deduction in Odds score total
			Penalty per day in Applied = .0356% deduction in Odds score total after 5 days and no movement
			Penalty per day in Applied = .078% deduction in Odds score total after 15 days and no movement
			Odds score can go to 0% - not a negative %.
			 
			Penalty per day in Set Interview = .0178% deduction in Odds score total
			Odds score will cap at 5% and won’t go lower.
			 
			Penalty per day in Interview = .0089% deduction in Odds score total
			Odds score will cap at 30% and won’t go lower.
			 
			Penalty per day in Job Offer = .0089% deduction in Odds score total
			Odds score will cap at 75% and won’t go lower.
			 
			Penalty per day in Job Acceptance = .0089% deduction in Odds score total
			Odds score will cap at 98% and won’t go lower.
			*/
			
			foreach($cards as $cardd)
			{
				$card=array_merge($cardd['C'],$cardd['0']);
				//print_r($card); 
				//die;
				if($card['days']>9)
				{
					switch($card['column_status'])
					{
						case "O": 	if($card['days']<15) $tot_points=$card['total_points']-0.0178;
									else if($card['days']<17) $tot_points=$card['total_points']-0.0356;	
									else $tot_points=$card['total_points']-0.78;
									if($tot_points>0)$_tot_points=$tot_points; else $_tot_points=0;								
									break;
						case "A": 	if($card['days']<15) $tot_points=$card['total_points']-0.0178;
									else if($card['days']<25) $tot_points=$card['total_points']-0.0356;	
									else $tot_points=$card['total_points']-0.78;
									if($tot_points>0)$_tot_points=$tot_points; else $_tot_points=0;			
									break;
						case "S":  	$tot_points=$card['total_points']-0.0178;					  
									if($tot_points>5)$_tot_points=$tot_points; else $_tot_points=5;		
									break;
						case "I": 	$tot_points=$card['total_points']-0.0089;					  
									if($tot_points>30)$_tot_points=$tot_points; else $_tot_points=30;		
									break;
						case "V": $tot_points=$card['total_points']-0.0089;					  
									if($tot_points>75)$_tot_points=$tot_points; else $_tot_points=75;		
									break;
						case "J": $tot_points=$card['total_points']-0.0089;					  
									if($tot_points>98)$_tot_points=$tot_points; else $_tot_points=98;		
									break;
					}
					
					$this->Card->query("update jsb_card SET total_points='".$_tot_points."' WHERE id='".$card['id']."'");
					//die;
						
				}	
			}
			die;
		}
	
	
 	public function cardExpire(){
		
		$this->Card->query("update jsb_card SET expired='1' WHERE application_deadline < CURDATE() AND column_status = 'O'");		
		$this->Agencycard->query("update jsb_agency_card SET expired='1' WHERE application_deadline < CURDATE()");
		die;
	}
	
	public function updatecoach()
	{
		$accounts=$this->Coach->query("select jsb_accounts.*, tmp_log.* from jsb_accounts left join (select 
ul.* from (select * from jsb_user_log where usertype=2 order by 
login_time DESC)   as ul group by ul.account_id) as tmp_log on 
(jsb_accounts.id=tmp_log.account_id) where find_in_set(2,activate)!=0");
		 foreach($accounts as $account)
		 {
			 $this->Coach->query("update jsb_coach SET last_login='".$account['tmp_log']['login_time']."' WHERE account_id=".$account['jsb_accounts']['id']);			 
		 }
		 die;
	}
		public function assignChallenge(){
			#------------------------ Asign Challange for 2/3/4... weeks user by user ---------------#
		$Challenges = new ChallengesController;
       	$Challenges->constructClasses();
		$query = "select C.id, FLOOR(datediff(curdate(),challenge_date)/7)+1 as week_id from  jsb_client C where challenge_date!='0000-00-00' and datediff(curdate(),challenge_date)%7=0 and C.challenge_survey_status=1 AND challenge_survey_date!=curdate() order by C.id asc";
		$results=$this->Client->query($query);
		foreach($results as $user) { 		
		 $Challenges->assignChallenge($user['C']['id'], $user[0]['week_id']);
			}
			echo "done";
			die;
		}
		
	public function TrailRenewalMail()
	{
		$this->autoRender = false;
		$this->layout='ajax';		
		$client_cond = " and C.reminder_mail='1' ";		
		$account_join=" INNER JOIN  jsb_accounts A ON(A.id=C.account_id) ";
		$account_cond=" AND A.activate !='' AND A.activate !='0' ";
		
		$curdate=date("Y-m-d");
		$mail_contents = $this->Mail->query("select * from jsb_mail_contents where section in ('client_account_renewal')");
		$mail = array();
		foreach ($mail_contents as $content)
		{	
			$mail[$content['jsb_mail_contents']['section']]['subject'] = $content['jsb_mail_contents']['subject'];		
			$mail[$content['jsb_mail_contents']['section']]['content'] = $content['jsb_mail_contents']['content'];
		}		
		
		$query = "select C.*  from jsb_client C $account_join where 1 $client_cond $account_cond AND  C.subscription='1' AND (DATEDIFF(C.plan_taken_date,'$curdate')='-1'  OR DATEDIFF(C.plan_due_date,'$curdate')='-1') GROUP BY C.id";
		$results=$this->Client->query($query);
		//print_r($results);die;
		$p=0; $mail_sent=array(); $all_user=array(); $m=0;
		
		foreach($results as $client) {
			//$query_string = "file=jobcards&action=index&card_id=social";
			$renew_url = SITE_URL . "/Info/pricing/".$client['C']['account_id'];	
			$view_output = str_replace(array('~~USER_NAME~~', '~~RENEW_URL~~'), array($client['C']['name'],$renew_url), $mail['client_account_renewal']['content']);			
			$subject=$mail['client_account_renewal']['subject'];
			$from='admin@snagpad.com';
			$to=$client['C']['email'];			
			if(!empty($to)&&(Validation::email($to, true)))
			{				
				$cakemail = new CakeEmail();			
				$cakemail->template('default');				
				$cakemail->emailFormat('html')->from($from)
											  ->to($to)						  							 
											  ->subject($subject)
											  ->send($view_output);						  
			
			}							  
		}
		die;
	}
	
}