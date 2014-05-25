<?php

App::import('Vendor', array('functions', 'xtcpdf'));

//App::import('Vendor','uploadclass');

class ReportsController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session', 'RequestHandler');
    public $uses = array('Client', 'Card', 'Opportunity', 'Checklist', 'Cardchecklist', 'Carddetail','Contact','Account');

    public function beforeFilter() {
        if (!$this->Session->check('Account.id')) {
            $this->redirect(SITE_URL . '/users/session_expire');
            //$this->Session->setFlash(__('You are not authorized to acces that page. Please login to  continue.'));
            exit();
        }
		parent::beforeFilter();
        $this->layout = 'reports_bg';
    }

    public function index($clientid=null) {
        if (empty($clientid)) {
            $clientid = $this->Session->read('Client.Client.id');
        }


        $total = $this->Card->find('count', array('conditions' => array('Card.client_id' => $clientid, 'Card.recycle_bin' => '0')));
        $opps = $this->Opportunity->find('all', array('order' => array('Opportunity.id ASC')));
        $data = array();
        $i = 0;
        foreach ($opps as $op) {
            $data[$i]['name'] = $op['Opportunity']['name'];
            $data[$i]['count'] = $this->Card->find('count', array('conditions' => array('Card.client_id' => $clientid, 'Card.recycle_bin' => '0', 'Card.type_of_opportunity' => $op['Opportunity']['name'])));
            $data[$i]['value'] = number_format(($data[$i]['count'] / $total) * 100, 2);
            $i++;
        }

        $card_SAI_status['O'] = $this->Card->find('count', array('conditions' => array('Card.client_id' => $clientid, 'Card.recycle_bin' => '0', 'Card.column_status' => 'O')));
        $card_SAI_status['A'] = $this->Card->find('count', array('conditions' => array('Card.client_id' => $clientid, 'Card.recycle_bin' => '0', 'Card.column_status' => 'A')));
        $card_SAI_status['I'] = $this->Card->find('count', array('conditions' => array('Card.client_id' => $clientid, 'Card.recycle_bin' => '0', 'Card.column_status' => 'I')));

        //echo '<pre>';print_r($data);die;
        $this->set('data', $data);
        $this->set('card_SAI_status', $card_SAI_status);
        $this->set('tot', $total);
        $this->set('clientid', $clientid);
        $this->render('index');
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
  		
    	$score=((($count['0']['0']['count']*100)/
            (
                ($arr['O']['total_checklist']*$arr['O']['total_cards'])+
                ($arr['A']['total_checklist']*$arr['A']['total_cards'])+
                ($arr['I']['total_checklist']*$arr['I']['total_cards'])+
                ($arr['S']['total_checklist']*$arr['S']['total_cards'])+($arr['V']['total_checklist']*$arr['V']['total_cards'])
				+($arr['J']['total_checklist']*$arr['J']['total_cards'])
				)));
	$final_score=round($score,2);		
  		$img=$this->check_final_score($final_score);
		
		///////////S-A-I status
		$img=$this->check_final_score($score);
        	$card_SAI_status['O']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.column_status'=>'O')));	
		$card_SAI_status['A']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.column_status'=>'A')));	
		$card_SAI_status['I']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.column_status'=>'I')));	
		$SAI=$card_SAI_status['O'].'-'.$card_SAI_status['A'].'-'.$card_SAI_status['I'];
		
		echo $final_score.'|'.$img.'|'.$SAI;die;
		
    }
	
	
	
	public function check_final_score($score)
	{
		if($score>0&&$score<=5) { return '1'; }
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
		elseif($score>90&&$score<=95) { return '19'; }
		elseif($score==0) { return '1'; }
		else { return '19'; }
				
			
	}

    public function job_search_history() {
      $this->layout='ajax';
		$clientid=$this->data['clientid'];
		$username=$this->Client->find('first',array('conditions'=>array('Client.id'=>$clientid),'fields'=>array('Client.name','Client.reg_date')));
		$cards=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$clientid,'Card.column_status !='=>'O','Card.recycle_bin'=>'0','Card.expired'=>'0'),'order'=>array('Card.id DESC')));
		$i=0; $card_data=array();
		foreach($cards as $card)
		{
			$card_data[$i]=$card;
			$card_data[$i]['applied_date']=$this->Cardchecklist->findByCardIdAndChecklistId($card['Card']['id'],'10');		
			$sql="SELECT contact_name FROM jsb_contacts as Contact WHERE id in (SELECT contact_id FROM jsb_card_contact WHERE card_id='".$card['Card']['id']."')";
			$card_data[$i]['contact']=$this->Contact->query($sql);
			$i++;
		}
		//echo '<pre>';print_r($card_data);die;
		$this->set('clientid',$clientid);
		$this->set('cards',$card_data);
		$this->set('client',$username);
		$this->set('username',$username['Client']['name']);
		$this->render('job_search_history_index');
    }

    public function job_history_for_date() {
		
		$this->layout='ajax';
		$data_date['to_date']=$this->data['to_date'];
		$data_date['from']=$this->data['from'];
		if(empty($data_date['to_date'])){ $data_date['to_date']='2025-11-01';}
		if(empty($data_date['from'])){ $data_date['from']='2011-11-01';}
		$to=strtotime($data_date['to_date']);
		$from=strtotime($data_date['from']);
		$clientid=$this->data['clientid'];
		//echo $to;die;
		$cards=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$clientid,'Card.column_status !='=>'O','Card.recycle_bin'=>'0','Card.expired'=>'0'),'order'=>array('Card.id DESC')));
		$i=0; $card_data=array(); $cd_data=array();
		foreach($cards as $card)
		{
			$cd_data[$i]=$card;
			$cd_data[$i]['applied_date']=$this->Cardchecklist->findByCardIdAndChecklistId($card['Card']['id'],'10');
			$sql="SELECT contact_name FROM jsb_contacts as Contact WHERE id in (SELECT contact_id FROM jsb_card_contact WHERE card_id='".$card['Card']['id']."')";
			$card_data[$i]['contact']=$this->Contact->query($sql);		
			$i++;	
		}
		//echo '<pre>';print_r($cd_data);die;
		foreach($cd_data as $cad)
		{
			$date=date('Y-m-d',strtotime($cad['applied_date']['Cardchecklist']['date_added']));
			$date=strtotime($date);
			//echo $to.'<br>'.$date.'<br>'.$from;die;
			if($date>=$from && $date<$to)
			{
				$card_data[]=$cad;
				
			}else if($date==$from)
			{
				$card_data[]=$cad;
				}	
		}
		//echo '<pre>';print_r($card_data);die;
		$this->set('clientid',$clientid);
		$this->set('cards',$card_data);
		$this->render('job_search_history_details');
		
		
	}

    public function job_search_activity() {
		$clientid=$this->data['clientid'];
		$client_info=$this->Client->find('first',array('conditions'=>array('Client.id'=>$clientid),'fields'=>array('Client.name','Client.reg_date','Client.job_a_title','Client.job_b_criteria')));	
		$cards=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.expired'=>'0')));
		$sql="Select max(start_date) as max_date from jsb_card_detail  where card_id in (select id from jsb_card where client_id='".$clientid."' and recycle_bin='0')";
		$latest_date=$this->Carddetail->query($sql);
		$job_A['count']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.job_type'=>'A')));
		
		$q="select format(avg(time_to_sec(timediff(now(),CD.start_date)))/(60*60*24),2) as avg from jsb_card_detail CD INNER JOIN jsb_card C ON ( CD.card_id=C.id and C.column_status=CD.column_status and C.recycle_bin='0' and C.client_id='".$clientid."' and C.job_type='A')";
		$avg_job_A=$this->Carddetail->query($q);
		$job_A['avg_time']=$avg_job_A['0']['0']['avg'];
		
		$job_B['count']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.job_type'=>'B')));
		
		$qr="select format(avg(time_to_sec(timediff(now(),CD.start_date)))/(60*60*24),2) as avg from jsb_card_detail CD INNER JOIN jsb_card C ON ( CD.card_id=C.id and C.column_status=CD.column_status and C.recycle_bin='0' and C.client_id='".$clientid."' and C.job_type='B')";
		$avg_job_B=$this->Carddetail->query($qr);
		$job_B['avg_time']=$avg_job_B['0']['0']['avg'];
		
		$card_SAI_status['O']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.column_status'=>'O')));	
		$card_SAI_status['A']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.column_status'=>'A')));	
		$card_SAI_status['I']=$this->Card->find('count',array('conditions'=>array('Card.client_id'=>$clientid,'Card.recycle_bin'=>'0','Card.column_status'=>'I')));	
		
		//echo '<pre>';print_r($job_B);die;
		
		$this->set('latest_date',$latest_date['0']['0']['max_date']);
		$this->set('client',$client_info);
		$this->set('job_A',$job_A);
		$this->set('card_SAI_status',$card_SAI_status);
		$this->set('job_B',$job_B);
		$this->set('cards',$cards);
		$this->set('clientid',$clientid);
		$this->render('job_search_activity_index');
		
		
		//echo '<pre>';print_r($client_info);die;
		
		
	}

   public function job_activity_for_date()
	{
		$this->layout='ajax';
		$from_date=date('Y-m-d H:i:s',strtotime($this->data['from']));
		$to_date=date('Y-m-d H:i:s',strtotime($this->data['to']));
		$clientid=$this->data['clientid'];
		//echo $from_date.'<br>'.$to_date;die;
		$stat=array('O','A','I');
		foreach($stat as $st)
		{
			$sql="SELECT COUNT( card_id ) as count FROM jsb_card_detail WHERE card_id in (select id from jsb_card where client_id = '".$clientid."') and column_status = '".$st."' AND start_date>='".$from_date."' And end_date<='".$to_date."'";
		$data[$st]=$this->Carddetail->query($sql);
		}
		
		echo $data['O']['0']['0']['count'].'-'.$data['A']['0']['0']['count'].'-'.$data['I']['0']['0']['count'];die;
							
	}
    public function movement_card() {
		$this->layout='ajax';
		$clientid=$this->data['clientid'];
		$sql="select CD.*,C.company_name from jsb_card_detail CD INNER JOIN jsb_card C ON (CD.card_id = C.id  and C.client_id='".$clientid."')";
		$data=$this->Carddetail->query($sql);
		
		
		$this->set('data',$data);
		$this->render('display_card_movement');
		
		
			
	}

    public function view($clientid=null) {
       
		$this->layout='report_pdf'; 
		$accoutn_id=$this->Session->read('Account.id');
		$username=$this->Account->findById($accoutn_id);
		$client=$this->Client->find('first',array('conditions'=>array('Client.id'=>$clientid),'fields'=>array('Client.name')));
		$from='2006-11-01';
		$to='2020-12-01';
		$display_from_date='NA'; $display_to_date='NA';
		 if (!empty($this->passedArgs['f']))
		 {
			$from=$this->passedArgs['f'];
			$display_from_date=show_formatted_date($from);	
			
		 }
		 if(!empty($this->passedArgs['t'])) {
           $to=$this->passedArgs['t'];	
		   $display_to_date=show_formatted_date($to);	 
		  }
		
		$from=strtotime($from);
		$to=strtotime($to);
		//echo $from.'<br>'.$to;die;
        $tcpdf = new XTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$cards=$this->Card->find('all',array('conditions'=>array('Card.client_id'=>$clientid,'Card.column_status !='=>'O'),'order'=>array('Card.id DESC')));
		$i=0; $card_data=array(); $cd_data=array();
		foreach($cards as $card)
		{
			$cd_data[$i]=$card;
			$cd_data[$i]['applied_date']=$this->Cardchecklist->findByCardIdAndChecklistId($card['Card']['id'],'10');	
			$sql="SELECT contact_name FROM jsb_contacts as Contact WHERE id in (SELECT contact_id FROM jsb_card_contact WHERE card_id='".$card['Card']['id']."')";
			$cd_data[$i]['contact']=$this->Contact->query($sql);		
			$i++;	
		}
		foreach($cd_data as $cad)
		{
			$date=strtotime($cad['applied_date']['Cardchecklist']['date_added']);
			if($date>=$from&&$date<$to)
			{
				$card_data[]=$cad;	
			}	
		}
		$this->set('display_date',$display_from_date.' - '.$display_to_date);
		$this->set('username',$client['Client']['name']);
		$this->set('cards',$card_data);
		$this->set('tcpdf',$tcpdf);
		$this->render('view');
	
	
	}

    public function coachReport(){
        
    }
    
}