<?php 
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor','functions');
//App::import('Vendor','uploadclass');

class ChallengesController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
	public $uses = array('Client','Account','Card','Question','Clientactivitysetting','Challenge','Challengeclient','Challengedetail','Challengeformresponse','Clientfile');

    public function beforeFilter() {
		parent::beforeFilter();
		if(!$this->Session->check('Account.id'))
			{
			$this->redirect(SITE_URL);
			exit();
			}
		$this->layout = 'jsb_bg';
    }
	
	
	public function index($id=0)
	{
		if($this->Session->read('usertype')==3)
			$client_id=$this->Session->read('Client.Client.id');
		else
			$client_id=$id;
		//$this->activity_settings();
		if($id==='start')
			$this->set('setting','start');
		else if($id==='ch_progress')
			$this->set('setting','ch_progress');
		
			
		$this->set('usertype',$this->Session->read('usertype'));
		$this->set('client_id',$client_id);
		$this->render('index');
	}
	
	public function activity_settings()
	{
		
		$this->layout='ajax';
		$client_id=$this->data['client_id'];
		$questions=$this->Question->find('all',array('order'=>array('Question.id ASC')));
		//print_r($questions);
		//die;
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
		$answers=$this->Clientactivitysetting->find('all',array('conditions'=>array('client_id'=>$client_id)));
		//echo '<pre>';print_r($answers);	
		$result=array();
		if(is_array($answers) && count($answers)>0)
		{
			foreach($answers as $answer)
				$result[$answer['Clientactivitysetting']['question_id']]=$answer['Clientactivitysetting']['answer'];
		}
		//$count=count($result);		
		$rows=$this->Client->query("Select datediff(curdate(),challenge_date) as diff,challenge_date from jsb_client where id='$client_id'");			
		//print_r($q);die;
		$this->set('ques',$q);
		$this->set('ans',$result);
		$this->set('a_dective',$rows);
		//$sum=50;	
		//$this->assignChallenge($client_id,1,$sum);	
		$this->render('activity_settings');	
		
	}
	
	public function activity_submit()
	{
			//$this->layout='ajax';
			$client_id=$this->data['client_id'];
			$date=date("Y-m-d H:i:s");
			$sum=0;
			$counts=$this->Clientactivitysetting->find('count',array('conditions'=>array('client_id'=>$client_id)));
			if (!empty($this->data)) {
				$i=1;
				foreach($this->data as $data)
				{
					if($counts==0)
					{
						$clintres=array();
						$clintres['client_id']=$client_id;
						$clintres['date_added']=$date;					
						$clintres['question_id']=$i;
						$clintres['answer']=$data['ques_'.$i];
						$this->Clientactivitysetting->create();
						$this->Clientactivitysetting->save($clintres);
					}
					else
					{
					$this->Clientactivitysetting->query("update jsb_client_activity_setting set answer='".$data['ques_'.$i]."',date_added='$date' where question_id='$i' and client_id='$client_id'");
						
					}
					$sum+=$data['ques_'.$i];
					$i++;
				}
			}			
			$clientup=array();
			$clientup['challenge_date']=$date;
			$clientup['required_point']=$sum;
			$clientup['total_point']=0;	
			$this->Client->id=$client_id;
			$this->Client->save($clientup);	
			$this->assignChallenge($client_id,1,$sum);			
			$this->render('activity_settings');	
	}
	public function checkChallenge($flag=1){	
		//$client_id=$this->data['clientid'];
		$client_id=2;
	$challenge_date_table=$this->Client->query("select challenge_date from jsb_client as Client where id='$client_id'");
	$challenge_date=$challenge_date_table[0]['Client']['challenge_date'];	
	if($challenge_date!='0000-00-00'){
		$max_table=$this->Challengeclient->query("select max(week_id) as max from jsb_challenge_client where client_id='$client_id'");
		//print_r($max_table);
	$max=$max_table[0][0]['max'];	
	$sql = "Select CL.challenge_id,date_add('$challenge_date', interval $max-1 week) as start_date, date_add('$challenge_date',interval $max week) as end_date, datediff(curdate(),date_add('$challenge_date',interval $max week)) as diff from jsb_challenge_client CL INNER JOIN jsb_challenge C ON (C.id=CL.challenge_id) where CL.client_id='$client_id' and CL.status='0' and CL.week_id='$max' and C.c_type='P'";
        $row_table =$this->Challengeclient->query($sql);
		$row=array_merge($row_table[0]['CL'],$row_table[0][0]);
		//print_r($row);
		//die;
		$challenge_id=$row['challenge_id'];
		if (is_array($row) && count($row) > 0 && $row['diff']<=0) {
            $challenge_table =$this->Challenge->query("select * from jsb_challenge where id='$row[challenge_id]'");
			$challenge=$challenge_table[0]['jsb_challenge'];
			if (!in_array($challenge_id, array(58, 35))) {
                $fields=$this->Challengedetail->query("select * from jsb_challenge_detail where challenge_id='$row[challenge_id]'");				
                $q = " and C.client_id='$client_id'";
                foreach ($fields as $field_arr)
				{
					$field=$field_arr['jsb_challenge_detail'];
                    if ($field['field_name'] != 'C.type_of_opportunity')
                        $q.=" and $field[field_name]='$field[field_value]'";
                    else
                        $q.=" and $field[field_name] in ($field[field_value])";
				}
				
                switch ($challenge_id) {
                    case 9:
                        $date = $this->Challengedetail->query("Select date_add('$row[start_date]', interval 4 day) as date");
						$q.=" and CD.start_date<='".$date[0][0]['date']."'";
                        break;
                    case 10:
                        $date = $this->Challengedetail->query("Select date_add('$row[start_date]', interval 5 day) as date");
						$q.=" and CD.start_date<='".$date[0][0]['date']."'";
                        break;
                }

				if($challenge_id!='57'){
			//echo "select count(C.id) as count from jsb_card C INNER JOIN jsb_card_detail CD ON (CD.card_id=C.id) where CD.start_date>='$row[start_date]' and CD.start_date<'$row[end_date]' $q";
                $count_table = $this->Card->query("select count(C.id) as count from jsb_card C INNER JOIN jsb_card_detail CD ON (CD.card_id=C.id) where CD.start_date>='$row[start_date]' and CD.start_date<'$row[end_date]' $q");
				$count=$count_table[0][0]['count'];
				}
				else
				{
	 $query="SELECT count( C.id ) as count, date_format( CD.start_date, '%Y-%m-%d' ) as daily_date FROM jsb_card C INNER JOIN jsb_card_detail CD ON ( CD.card_id = C.id ) WHERE CD.start_date >= '$row[start_date]' and CD.end_date<'$row[end_date]' $q
GROUP BY date_format( CD.start_date, '%Y-%m-%d' )";
$rows= $this->Card->query($query);
//print_r($rows);
if(is_array($rows) && count($rows)>0)
$count=count($rows);
else
$count=0;

				}
				//$check=0;
				//echo $count;
				//echo $challenge['num'];
				//die;
                if ($count >= $challenge['num']) {
                    $curr_date = date("Y-m-d H:i:s");
                    $sql = "update jsb_challenge_client set date_completed='$curr_date',duration=time_to_sec(timediff('$curr_date',date_started)),points=$challenge[points],status='1' where client_id='$client_id' and challenge_id='$row[challenge_id]'";
					$this->Challengeclient->query($sql);
                   // mysql_query($sql) or die(mysql_error());
                    $this->Client->query("update jsb_client set 	total_point=total_point+$challenge[points] where id='$client_id'");	
					//$check=1;		
                   
                }
            }
        }
		//echo $challenge['num'].'  ';
		//echo $count.'  ';
		//echo $check;    
	 die;
	}

	}
	function assignChallenge($client_id,$week_id=1,$tot=0) {
		$date=date("Y-m-d H:i:s");
    	$ids="";
		$priority=array(1=>1,2,9,57,10,19,27,29,30,33,35,58,3,4,61);
		$applied=array(19,20,27);
	    $client_a= $this->Card->find('count',array('conditions'=>array('client_id'=>$client_id,'column_status' => 'A','recycle_bin'=>'0','expired'=>'0')));
		$interview=array(28,60);
		$client_i=$this->Card->find('count',array('conditions'=>array('client_id'=>$client_id,'column_status' => 'I','recycle_bin'=>'0','expired'=>'0')));	
		$rows=$this->Challenge->query("select id from jsb_challenge where c_repeat='0'");		
		foreach($rows as $row)
			$ids.=$row['jsb_challenge']['id'].",";
		$ids=substr($ids,0,-1);
		//echo $ids;die;
	
	$already=array();
	if($week_id=='1')
	{
		$this->Challengeclient->query("delete from jsb_challenge_client where client_id='$client_id'");
		$this->Challengeformresponse->query("delete from jsb_challenge_form_response where client_id='$client_id'");
		$this->Client->query("update jsb_client set challenge_date='$date' where id='$client_id'");
	}
	else
	{
		$alreadys=$this->Challengeclient->query("select group_concat(challenge_id) as ch_id from jsb_challenge_client where challenge_id in ($ids) and client_id=$client_id");
		foreach($alreadys as $all)
			$already[]=$all[0]['ch_id'];
	}
	//print_r($priority);
	$id=$priority[$week_id];
	//print_r($id);
	
	if($tot==0)
	{
		$tots=$this->Client->query("select required_point from jsb_client where id='$client_id'");
		$tot=$tots['jsb_client']['required_point'];
	}
	
	$points=$this->Challenge->query("select points from jsb_challenge where id='$id'");
	$arr[]=$id;
	$tot-=$points[0]['jsb_challenge']['points'];
	
	$challenges=$this->Challenge->query("select id, points from jsb_challenge where c_type='F' order by rand()");
	foreach($challenges as $challenge)
	{		
		//print_r($challenge);	
		if($challenge['jsb_challenge']['points']<=$tot && !in_array($challenge['jsb_challenge']['id'],$already) && !in_array($challenge['jsb_challenge']['id'],$arr) )
		{
			if(($client_i==0 && in_array($challenge['jsb_challenge']['id'],$interview)) || ($client_a=='0' && in_array($challenge['jsb_challenge']['id'],$applied)))
				continue;
			$arr[]=$challenge['jsb_challenge']['id'];
			$tot-=$challenge['jsb_challenge']['points'];
		}
		if($tot==0)
			break;	
	}
	//die;
	foreach($arr as $val)
	{
		if($val!='0'){
			$clientChallenge=array();	
			$clientChallenge['date_started']=$date;
			$clientChallenge['client_id']=$client_id;
			$clientChallenge['week_id']=$week_id;
			$clientChallenge['status']=0;		
			$clientChallenge['challenge_id']=$val;
			$this->Challengeclient->create();
			$this->Challengeclient->save($clientChallenge);
		}
	}	
}
	public function my_challenge(){
		$this->layout='ajax';
		$client_id=$this->data['client_id'];
		$totalRow=$this->Challengeclient->find('count',array('conditions'=>array('client_id'=>$client_id)));
		
if($totalRow>0){
	$max=$this->Challengeclient->find('first',array('conditions'=>array('client_id'=>$client_id),'fields' => array('MAX(Challengeclient.week_id) AS week_id')));
	$week=$max[0]['week_id'];
	//$sql= "select date_add(challenge_date,interval $week week) as ch_date ,date_add(challenge_date,interval  $week-1 week ) as newdate from jsb_client where id='$client_id'";
		  $date=$this->Client->query("select date_add(challenge_date,interval $week week) as ch_date ,date_add(challenge_date,interval  $week-1 week ) as newdate from jsb_client Where id='$client_id'");
		  
	$ctype="";
	if(isset($this->data['challenge_id']))
	{		
		if($this->data['challenge_id']=='ch_progress')
		{
			$this->request->data['challenge_id']=0;
			$ctype=" and C.c_type='P'";
			$this->set('ch_progress','1');
		}
		if($this->data['challenge_id']>0)
		{
			$clientpoint=$this->Client->query("select required_point-total_point as required From jsb_client where id='$client_id'");
			$this->set('client_point',$clientpoint[0][0]['required']);
		}
		//echo $this->data['challenge_id'];die;
		$this->set('showChallenge',$this->data['challenge_id']);
	}	  
		  
	$query="select C.id,C.title,C.points,C.c_type,CC.id as client_challenge_id, CC.week_id, CC.date_completed,CC.points,CC.status from jsb_challenge C INNER JOIN jsb_challenge_client CC ON (C.id=CC.challenge_id) where CC.client_id='$client_id' ".$ctype." order by CC.id DESC";	
$challenges=$this->Challenge->query($query);

	$this->set('max',$week);
	$this->set('challenges',$challenges);	
	$this->set('date',$date);

	}
	
	//print_r($totalRow);
	$this->set('client_id',$client_id);
	$this->set('usertype',$this->Session->read('usertype'));
	
	$this->set('totalRow',$totalRow);
	//echo '<pre>';print_r($totalRow);die;
	}
	public function form()
	{
		$this->layout='ajax';
		$status="";
		$challenge_id=$this->data['challenge_id'];
		if($this->data['status']==1){$status="disabled";}
		$challenge=$this->Challenge->find('all',array('conditions'=>array('id'=>$challenge_id)));
		$fields=$this->Challengedetail->find('all',array('conditions'=>array('challenge_id'=>$challenge_id)));
		$values=$this->Challengeformresponse->find('all',array('conditions'=>array('client_challenge_id'=>$challenge_id)));	
$i=1;
$data=array();
foreach($values as $valuetable)
{
	$value=$valuetable['Challengeformresponse'];
if(!isset($data[$value['field_id']]))
	$data[$value['field_id']][$i]=$value['field_value'];
else
$data[$value['field_id']][]=$value['field_value'];
}

if($challenge_id==72)
{
$query="SELECT C.name,C.id as client_id, CARD.id, CARD.company_name,CARD.position_available from jsb_client C INNER JOIN jsb_card CARD ON (CARD.client_id=C.id and CARD.recycle_bin='0') INNER JOIN jsb_card_column_detail CCD ON (CCD.card_id=CARD.id)  WHERE (CCD.reminder_date='0000-00-00' or CCD.reminder_date='') and CARD.column_status='I' and CARD.client_id=$userid" ;
//$cards=$this->Client->query($query);
}
	$this->set('data',$data);
	$this->set('status',$status);	
	$this->set('challenge',$challenge);	
	$this->set('fields',$fields);
		
	}
	
	public function form_submit()
	{
		//print_r($this->data);die;
		//$this->layout='ajax';
		//print_r($this->data);die;
		$challenge_id=$this->data['challenge_id'];
		$client_id=$this->data['client_id'];
		$num=$this->data['num'];
		$point=$this->data['point'];
		$fields=$this->Challengedetail->find('all',array('conditions'=>array('challenge_id'=>$challenge_id)));	
		$this->Challengeformresponse->query("delete from jsb_challenge_form_response where client_id='$client_id' AND client_challenge_id='$challenge_id'");
		foreach($fields as $fieldtable)
		{
			$field=$fieldtable['Challengedetail']; 
			for($i=1;$i<=$num;$i++)
			{
				$response=array();
				$response['client_id']=$client_id;
				$response['client_challenge_id']=$challenge_id;
				$response['field_id']=$field['id'];
				if(isset($this->data['field_'.$field['id']][$i]))
					$response['field_value']=$this->data['field_'.$field['id']][$i];
				else
					$response['field_value']=$this->data['file_select'];
				$this->Challengeformresponse->create();
				$this->Challengeformresponse->save($response);			
			}
		}
		$curdate=date("Y-m-d H:i:s");
$this->Challengeclient->query("update jsb_challenge_client set date_completed='$curdate' , status='1' , duration=time_to_sec(timediff('$curdate',date_started)), points=$point where client_id='$client_id' and challenge_id='$challenge_id'");
$this->Client->query("update jsb_client set total_point=total_point+$point where id='$client_id'");
echo $challenge_id;
//$this->set('challenge_id',$challenge_id);
	die;		
	}
	public function profile_file_list()
	{
		//$this->layout='ajax';
		$clientid=$this->data['client_id'];
		$challengeid=$this->data['challenge_id'];
		$fieldid=$this->data['field_id'];
		$status=$this->data['status'];
		$files=$this->Clientfile->query("SELECT id,filename,last_modified,file FROM jsb_client_files AS Client WHERE client_id='$clientid'");
		//echo '<pre>';print_r($files); die;
		$data=$this->Challengeformresponse->find('all',array('conditions'=>array('client_challenge_id'=>$challengeid,'field_id'=>$fieldid,'client_id'=>$clientid),'field'=>array('field_value')));	
		//print_r($data);die;
//$saved=$already[0][''];
		if(isset($data)&& count($data)>0)
			$already=$data[0]['Challengeformresponse']['field_value'];
		$path=$this->webroot.'files/';
		$i=1; 
		$typ='radio'; 
		$nam='file_select';		 
		 
		 foreach($files as $file) 
		 {
			echo "<div class='rowdd'>";
			echo "<div class='inputdd' >".$i.".</div>";
			if(isset($already))
			{
			echo "<input type='".$typ."' class='radio' name='".$nam."' value='".$file['Client']['id']."' disabled='disabled' ";
			if($already==$file['Client']['id'])
				echo "checked='checked'";
			echo ">";
			}
			else
			{
			echo "<input type='".$typ."' class='radio' name='".$nam."' value='".$file['Client']['id']."'";
			if($status) echo "disabled='disabled'";
			echo ">";
			}
			echo '<div class="file"><a href="'.$path.$clientid.'/'.$file['Client']['file'].'" target="_blank">'.wraptext($file['Client']['filename'],30).'</a></div>';			
			echo "</span></div>";
			echo "</div>";
			$i++; 
		} 
		$this->set('files',$files);
		//echo '1';
		die;
	}
public function getItScore()
	{
	//$id=$this->data['client_id'];
	$client_id=$this->Session->read('Client.Client.id');
	$challenge_date_table=$this->Client->query("select challenge_date from jsb_client as Client where id='$client_id'");
	$challenge_date=$challenge_date_table[0]['Client']['challenge_date'];	
	if($challenge_date!='0000-00-00'){
		$max_table=$this->Challengeclient->query("select max(week_id) as max from jsb_challenge_client where client_id='$client_id'");
		//print_r($max_table);
	$max=$max_table[0][0]['max'];
		
		$max_table=$this->Challengeclient->query("select sum(c.points) as required_point,sum(cc.points) as total_point from jsb_challenge c INNER JOIN jsb_challenge_client cc on(c.id=cc.challenge_id) where cc.client_id='$client_id' AND cc.week_id='$max'");			
			$point_needed =$max_table[0][0]['required_point'];
			$point_achieved=$max_table[0][0]['total_point'];
			$i_score = number_format(($point_achieved / $point_needed) * 100, 2);
			$img=$this->check_final_score($i_score);
	}
	else
	{
		$i_score=0;
		$img=1;
	}
	echo $i_score.'|'.$img;
	die;	
	}
public function check_final_score($score)
	{
		if($score<=5) { return '1'; }
		else if($score>5&&$score<=10) { return '2'; }
		elseif($score>10&&$score<=15) { return '3'; }
		elseif($score>15&&$score<=20) { return '4'; }
		elseif($score>20&&$score<=25) { return '5'; }
		elseif($score>25&&$score<=30) { return '6'; }
		elseif($score>30&&$score<=35) { return '7'; }
		elseif($score>35&&$score<=40) { return '8'; }
		elseif($score>40&&$score<=45) { return '9'; }
		elseif($score>45&&$score<=50) { return '10'; }
		elseif($score>50&&$score<=55) { return '11'; }
		elseif($score>55&&$score<=60) { return '12'; }
		elseif($score>60&&$score<=65) { return '13'; }
		elseif($score>65&&$score<=70) { return '14'; }
		elseif($score>70&&$score<=75) { return '15'; }
		elseif($score>75&&$score<=80) { return '16'; }
		elseif($score>80&&$score<=85) { return '17'; }
		elseif($score>85&&$score<=90) { return '18'; }		
		else { return '19'; }			
	}
	
	public function challenge_points($client_id)
	{		
		$totalRow=$this->Challengeclient->find('all',array('conditions'=>array('client_id'=>$client_id,'status'=>1)));
		$start_ch=0;
		$q="Select C.challenge_date, CASE WHEN C.challenge_date!='0000-00-00' THEN datediff(curdate(),C.challenge_date)  ELSE 10000  END as diff from jsb_client C where C.id='$client_id'";
		$rows=$this->Client->query($q);	
		if(($rows[0][0]['diff']==10000)||($rows[0][0]['diff']>=28))
			$start_ch=1;
	    if($totalRow>0){
			$max=$this->Challengeclient->find('first',array('conditions'=>array('client_id'=>$client_id),'fields' => array('MAX(Challengeclient.week_id) AS week_id')));
			$week=$max[0]['week_id'];  
			$query="select C.id,C.title,C.points,C.c_type,CC.id as client_challenge_id, CC.week_id, CC.date_completed,CC.points,CC.status from jsb_challenge C INNER JOIN jsb_challenge_client CC ON (C.id=CC.challenge_id) where CC.client_id='$client_id' and CC.week_id='$week' order by CC.id DESC";		
			$challenges=$this->Challenge->query($query);
			$week_points_req=$points_ach=$total_points=0; 
			foreach($challenges as $ch)
			{
				$total_points+=$ch['C']['points'];
				$points_ach+=$ch['CC']['points'];
				$week_points_req+=($ch['C']['points']);					
			}
			
		}
		echo $week_points_req.'|'.$points_ach.'|'.($total_points-$points_ach).'|'.$start_ch;die;
	}
	
}