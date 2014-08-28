<?php
App::import('Core','Validation');
App::import('Vendor', array('functions'));
App::uses('CakeEmail', 'Network/Email');

class MessageController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
    public $uses = array('Client', 'Coach', 'Message','Contact','Account');

    public function beforeFilter() {
		
        if (!$this->Session->check('Account.id')) {
            $this->redirect(SITE_URL);
            exit();
        }
		parent::beforeFilter();
        $this->layout = 'jsb_bg';
    }

    public function index($num=null) {

        if (!empty($this->data)) {
            $this->layout = 'ajax';
        }
		$msgShow=explode('_',$num);
		if($msgShow[0]=='message')
		{
			$this->set('msg_open','1');	
			$this->set('num',$msgShow[1]);
		}else{
			$this->set('num', $num);
		}
		
        
    }

    public function compose($group_id=0, $to_id=0) {
        $this->layout = 'ajax';
        if ($this->Session->read('usertype') == '2') {
            if ($to_id == 0) {
                $arr = array();
                $clients = $this->Client->find('all', array('conditions' => array('coach_id' => $this->Session->read('Account.id')), 'order_by' => 'name', 'fields' => array('id', 'name', 'email','account_id')));

                foreach ($clients as $client)
                    $arr[$client['Client']['account_id']] = $client['Client']['name'];
                $this->set('clients', $arr);
            } else {
                $client = $this->Client->findByAccountId($to_id);
                $this->set('to_name', $client['Client']['name']);
                $this->set('to_userid', $to_id);
            }
            $this->set('to_usertype', 3);
            $this->set('to_title', 'Client');
        } else {
			if($to_id==0)
				$to_id=$this->Session->read('Client.Client.coach_id');
				if($to_id==0){
					$this->set('no_coach', '1');	
				}
			/*if($to_id==0)
			{
				 $arr = array();
				$ac_id=$this->Session->read('Account.id');
				$clients=$this->Contact->find('all',array('conditions'=>array('Contact.account_id'=>$ac_id)));
				//echo '<pre>';print_r($clients);die;
				foreach ($clients as $client)
                 {   $arr[$client['Contact']['id']] = $client['Contact']['contact_name']; }
				// echo '<pre>';print_r($arr);die;
                $this->set('clients', $arr);
				$this->set('no_coach', '1');*/
			//}else{	
          		$client = $this->Coach->findByAccountId($to_id);
			   
				$this->set('to_name', $client['Coach']['name']);
			//}
			$this->set('to_userid', $to_id);
            $this->set('to_usertype', 2);
            $this->set('to_title', 'Coach');
        }
		if($group_id!=0)
		{
				$mail=$this->Message->findById($group_id);

				if($mail['Message']['from_usertype']==3){
					$name=$this->Client->findByAccountId($mail['message']['from_userid']);
					$name=$name['Client']['name'];
				}
				else{
					$name=$this->Coach->findByAccountId($mail['Message']['from_userid']);
					$name=$name['Coach']['name'];
				}
				$message="\n\n\n\n On ".show_formatted_datetime($mail['Message']['send_date']).", $name write \n--------------------\n".$mail['Message']['message'];
				$subject="Re: ".$mail['Message']['subject'];
				$this->set('subject',$subject);
				$this->set('message',$message);
		}

        $this->render('mail_compose');
    }

    function sendMessage($to, $from, $from_type, $subject, $msg, $group_id=0, $attachment='', $filename='') {
		
		$this->autoRender=false;
		$this->layout="ajax";
		$msg=$this->Message->findById($msg);
        //global $siteName, $mail, $message_table;
        if ($from_type == 3) {
            if ($group_id == 0)
                $msg1 = "Your client -- " . ucfirst($from['name']) . " -- has sent you a message.";
            else
                $msg1 = "Your client -- " . ucfirst($from['name']) . " -- has replied to your message.";
        }
        else {
            if ($group_id == 0)
                $msg1 = "Your coach -- " . ucfirst($from['name']) . " -- has sent you a message. ";
            else
                $msg1 = "Your coach -- " . ucfirst($from['name']) . " --  has replied to your message.";
        }
   
        $matter = "Dear " . ucfirst($to['name']) . ",<br><br>" . $msg1 . "<br><br>" . nl2br($msg['Message']['message']) . "<br /><br />To reply to this message <a href=".SITE_URL."/Pages/display?file=message&action=index&msgid=".'message_'.$msg['Message']['id'].">click here</a>.<br /><br />Regards<br />The SnagPad Team";
	
        $email = new CakeEmail();
	$attachedFilePath = WWW_ROOT . 'attachments/' ;
		
        if ($attachment != '')	{
		     $email->attachments(array($filename => $attachedFilePath.$attachment));  // optional name
		}
			
		if(!empty($to['email'])&&(Validation::email($to['email'], true)))
		{
       	 $email->emailFormat('html')->from('support@snagpad.com')->to($to['email'])->subject($subject)->send($matter);
		}
	
    }

    function compose_submit() {
        $this->autorender = false;
        $this->layout = 'ajax';
        if ($this->data['group_id'] == 0) {
            $group_id = $this->Message->find('first', array('fields' => array('MAX(id) as id')));
            $this->request->data['group_id'] = (int) $group_id['0']['id'] + 1;
        }
		$this->request->data['send_date']=date('Y-m-d H:i:s');
		$this->request->data['file']='';
		$this->request->data['filename']='';
        $multiple_id = $this->Message->find('first', array('fields' => array('MAX(id) as id')));
        $this->request->data['multiple_message_id'] = (int) $multiple_id['0']['id'] + 1;
        if ($_FILES['attachment']['name']!='') {
            $fileUpload = WWW_ROOT . 'attachments' . DS;
            $arr_img = explode(".", $_FILES["attachment"]["name"]);
            $ext = strtolower($arr_img[count($arr_img) - 1]);
            if (($ext != "exe")) {
                $fname = removeSpecialChar($_FILES['attachment']['name']);
                $file = time() . "_" . $fname;
                if (upload_my_file($_FILES['attachment']['tmp_name'], $fileUpload . $file)) {
                    $this->request->data['file'] = $_FILES['attachment']['name'];
                    $this->request->data['filename'] = $file;
                }
                else
                    echo "upload failed";
            }
            else
                echo "upload failed";
        }
		if($this->Session->read('usertype')=="3")
			$from=array('name'=>$this->Session->read('Client.Client.name'),"email"=>$this->Session->read('Client.Client.email'));
		else
			$from=array('name'=>$this->Session->read('Coach.Coach.name'),"email"=>$this->Session->read('Coach.Coach.email'));
        if (isset($this->data['to_users'])) {

            foreach ($this->data['to_users'] as $val) {
				if($val!=0)
				{
					$this->request->data['to_userid'] = $val;
					$this->Message->create();
	
					$msg_data=$this->Message->save($this->data);
					
					$to_data=$this->Client->findByAccountId($val);
					$to=array("name"=>$to_data['Client']['name'],"email"=>$to_data['Client']['email']);
					$this->sendMessage($to, $from, $this->Session->read('usertype'), $this->data['subject'], $msg_data['Message']['id'], $group_id=0, $this->data['filename'], $this->data['file']);
					unset($this->Message->id);
				}
            }
        } else {

            $this->Message->create();
            $msg_data=$this->Message->save($this->data);
			
			$to_data=$this->Account->findById($this->data['to_userid']);
			$to=array("name"=>$to_data['Account']['name'],"email"=>$to_data['Account']['email']);
			$this->sendMessage($to, $from, $this->Session->read('usertype'), $this->data['subject'], $msg_data['Message']['id'], $group_id=0, $this->data['filename'], $this->data['file']);
			
        }
		$this->redirect(SITE_URL.'/message/index/2');
    }

    public function show_search($type) {
        $this->layout = 'ajax';
        $this->set('type', $type);
        $this->render('search');
    }

    function search($type) {
        $this->layout = 'ajax';
        $where="";
        if(isset($this->data['cbox'])){
            $ids=implode(",",$this->data['cbox']);
         if($type==0)
             $this->Message->query("update jsb_message set inbox_del=1 where id in ($ids)");
         else
		 {	
		  if($type == 1 && $this->Session->read('usertype')==2){
			 $this->Message->query("update jsb_message set sent_del=1 where multiple_message_id in ($ids)");
			 }
			 else
             $this->Message->query("update jsb_message set sent_del=1 where id in ($ids)");
		 }
        }
		if($this->Session->read('usertype')=='2')
		
            $table="jsb_client";
        else
            $table="jsb_coach";
        if ($type == 0)
        {
            $usertype='from_userid';
            $where = " and to_userid=".$this->Session->read('Account.id')." and to_usertype=". $this->Session->read('usertype')." and inbox_del=0";
        }
        else
        {
            $usertype='to_userid';
               $where = " and from_userid=".$this->Session->read('Account.id')." and from_usertype=". $this->Session->read('usertype')." and sent_del=0";
        }
        
        
        if ($this->data['keyword'] != '')
            $where.= " and (subject like '%" . $this->data['keyword'] . "%' OR message like '%". $this->data['keyword']. "%')";
        
       $query="select M.*,group_concat(' ',CA.name) as name from jsb_message M INNER JOIN $table CA ON (M.$usertype=CA.account_id) where 1 $where group by M.multiple_message_id order by M.id desc";
        $mails=$this->Message->query($query);
     //   print_r($mails);
//        $mails = $this->Message->find('all', array('conditions' => $conditions, "order_by" => 'id desc'));
        $this->set('mails', $mails);
        $this->set('type', $type);
        $this->render('results');
    }
	
	public function view_mail($id,$type){
		$this->layout='ajax';
		 if ($type == 0)
        {
            $usertype='from_userid';
            $where = " and to_userid=".$this->Session->read('Account.id')." and to_usertype=". $this->Session->read('usertype')." and inbox_del=0";
        }
        else
        {
            $usertype='to_userid';
               $where = " and from_userid=".$this->Session->read('Account.id')." and from_usertype=". $this->Session->read('usertype')." and sent_del=0";
        }
        if($this->Session->read('usertype')=='2')
            $table="jsb_client";
        else
            $table="jsb_coach";

			  if($type == 1 && $this->Session->read('usertype')==2)
		        $query="select M.*,group_concat(' ',CA.name) as name from jsb_message M INNER JOIN $table CA ON (M.$usertype=CA.account_id) where multiple_message_id='$id' $where group by multiple_message_id";
			else
		        $query="select M.*,group_concat(' ',CA.name) as name from jsb_message M INNER JOIN $table CA ON (M.$usertype=CA.account_id) where M.id=$id $where";

			$mail=$this->Message->query($query);
$mail=$mail[0];
			if($mail['M']['to_userid']==$this->Session->read('Account.id') && $mail['M']['to_usertype']==$this->Session->read('usertype') && $mail['M']['read_flag']=='0'){
				$this->Message->query("update jsb_message set read_flag='1' where id='$id'");
				$count=$this->Message->find('first',array('conditions'=>array('to_usertype'=>$this->Session->read('usertype'),"to_userid"=>$this->Session->read('userid'),'read_flag'=>0,'inbox_del'=>0),'fields'=>array('count(*) as count')));
				$this->set('count',$count[0]['count']);
			}
			$this->set('type',$type);
			$this->set('mail',$mail);
			  	
	}
	
	public function message_count()
	{
		$id=$this->Session->read('Account.id');
		$count=$this->Message->find('count',array('conditions'=>array('Message.to_userid'=>$id,'Message.read_flag'=>0,'Message.to_usertype'=>$this->Session->read('usertype'))));
		echo $count;die;	
	}
	

}