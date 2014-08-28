<?php

/****************************************
**  Class Name : CronsController
**  Desc :  This class helps in to run crons job 
    like sending mails to professinals and recruites on a specific time.
**  Developed By : Rajesh Kumar Kanojia
**  Developed On : Jan 9 2014
*****************************************/


class CronsController extends AppController    {

   public $name = 'Crons';
   public $uses = array('TrackProfessional','Recruiter','Professional');
   public $components=array('Email');
// $layout = ;

   function professional_email()
    {
		$range = array(date('Y-m-d H:i:s',strtotime("-1 days")),date('Y-m-d H:i:s'));

        $record = $this->TrackProfessional->find('all',array(
		        'fields' => array('Recruiter.first_name,Recruiter.last_name,TrackProfessional.date,TrackProfessional.track_event,Professional.email,Professional.id'),
		        'conditions' => array(
				                     array('TrackProfessional.date BETWEEN ? AND ? ' => $range),
									 array('TrackProfessional.prof_notification' => 1)
								),
				'joins' => array(
				      array(
					     'table' => 'recruiters',
						 'alias' => 'Recruiter',
						 'type'  => 'INNER',
						 'conditions' => array(
						       'Recruiter.id = TrackProfessional.recruiter_id'
						  )
					  ),  
				      array(
					     'table' => 'professionals',
						 'alias' => 'Professional',
						 'type'  => 'INNER',
						 'conditions' => array(
						       'Professional.id = TrackProfessional.professional_id'
						  )						 
					  ) 
				)
		));
		
		$professionalLog = array();
		foreach($record as $r)   {
		  $str = $r['Recruiter']['first_name'].' '.$r['Recruiter']['last_name'].' track you on '.$r['TrackProfessional']['track_event'].' event at '.$r['TrackProfessional']['date'];
		 $index = $r['Professional']['id'];
		 if(!array_key_exists($r['Professional']['id'],$professionalLog))   {
		    $professionalLog[$index] = array(0=>$str);
			$professionalLog[$index]['email'] = $r['Professional']['email'];
		 }
		 else   {
		    $professionalLog[$index][] = $str;
 		 }
		}
		foreach($professionalLog as $p)   {
			try  {
					$this->Email->from = 'admin@jobseeker.com';
					$this->Email->to = $p['email'];
					$this->Email->subject = 'Activity performed on your account in last 24 Hours.';
					$this->Email->sendAs = 'html';
//					$this->Email->delivery = 'smtp';
					unset($p['email']);
					$message = implode('<br>',$p);
//					$this->Email->template =  name of the .ctp file to be render.
                    $this->set('Message',$message);
					unset($message);
					if($this->Email->send())  {
						$this->TrackProfessional->updateAll(
						        array('TrackProfessional.prof_notification' => 0),
								array('TrackProfessional.date BETWEEN ? AND ?' => $range)
						);
	    				echo '<pre>Mail send successfully.'; die;
					}
			}
			catch(Exception $e)   {
				echo '<pre>Mail can\'t be send.'; die;
			}
		}
	}  

   function recruiter_email()
    {
		$range = array(date('Y-m-d H:i:s',strtotime("-10 days")),date('Y-m-d H:i:s'));

        $record = $this->TrackProfessional->find('all',array(
		        'fields' => array('Professional.first_name,Professional.last_name,TrackProfessional.date,TrackProfessional.track_event,Recruiter.email,Recruiter.id'),
		        'conditions' => array(
				                     array('TrackProfessional.date BETWEEN ? AND ? ' => $range),
									 array('TrackProfessional.rec_notification' => 1)
								),
				'joins' => array(
				      array(
					     'table' => 'recruiters',
						 'alias' => 'Recruiter',
						 'type'  => 'INNER',
						 'conditions' => array(
						       'Recruiter.id = TrackProfessional.recruiter_id'
						  )
					  ),  
				      array(
					     'table' => 'professionals',
						 'alias' => 'Professional',
						 'type'  => 'INNER',
						 'conditions' => array(
						       'Professional.id = TrackProfessional.professional_id'
						  )						 
					  ) 
				)
		));
		
		$professionalLog = array();
		foreach($record as $r)   {
		  $str = $r['Professional']['first_name'].' '.$r['Professional']['last_name'].' track you on '.$r['TrackProfessional']['track_event'].' event at '.$r['TrackProfessional']['date'];
		 $index = $r['Recruiter']['id'];
		 if(!array_key_exists($r['Recruiter']['id'],$professionalLog))   {
		    $professionalLog[$index] = array(0=>$str);
			$professionalLog[$index]['email'] = $r['Recruiter']['email'];
		 }
		 else   {
		    $professionalLog[$index][] = $str;
 		 }
		}
//		echo '<pre>'; print_r($professionalLog); die;
		foreach($professionalLog as $p)   {
			try  {
					$this->Email->from = 'admin@jobseeker.com';
					$this->Email->to = $p['email'];
					$this->Email->subject = 'Professional Tracking list in last 10 days.';
					$this->Email->sendAs = 'html';
//					$this->Email->delivery = 'smtp';
					unset($p['email']);
					$message = implode('<br>',$p);
//					$this->Email->template =  name of the .ctp file to be render.
                    $this->set('Message',$message);
					unset($message);
					if($this->Email->send())  {
						$this->TrackProfessional->updateAll(
						        array('TrackProfessional.rec_notification' => 0),
								array('TrackProfessional.date BETWEEN ? AND ?' => $range)
						);
					echo '<pre>Mail send successfully to all Recruiters.'; die;	
					}
			}
			catch(Exception $e)   {
				echo '<pre>Mail can\'t be send.'; die;
			}
		}
		
	}  



}

?>