<?php

//App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'functions');
App::import('Controller', array('Users','Mail'));
class SuperController extends UsersController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
    public $uses = array('Agency','Account');

    public function beforeFilter() {
				parent::beforeFilter();
        if (!$this->Session->check('Account.id') || $this->Session->read('usertype')!=0) {
            $this->redirect(SITE_URL);
            exit();
        }
		$this->layout='jsb_admin';

    }

    public function admin_index() 
	{

	}
	
	  public function admin_show_search() {
        $this->layout = 'ajax';
        $this->render('admin_search');
    }
	
	public function admin_show_add_agency($id){
		$this->layout = 'ajax';
		if($id!=0){
			$agency=$this->Agency->findByAccountId($id);
			$this->set('agency',$agency['Agency']);
		}
        $this->render('admin_add_agency');	
	}
	
	public function admin_get_all_agency()
	{
		$this->layout = 'ajax';
		 if (isset($this->data['cbox'])) {
            $del_id = implode(",", $this->data['cbox']);
            $this->Agency->query("delete from jsb_agency where account_id in ($del_id)");
			$this->Agency->query("delete from jsb_card where client_id in (select id from jsb_client where agency_id in ($del_id))");
			$this->Agency->query("delete from jsb_client where agency_id in ($del_id)");
			$this->Agency->query("delete from jsb_coach where agency_id in ($del_id)");
			$this->Agency->query("delete from jsb_accounts where id in ($del_id)");		
        }

		if(count($this->request->data)==0)
			$this->request->data=$this->passedArgs;
		$conditions=array();	
		if(isset($this->request->data['keyword']) && $this->request->data['keyword']!='' && $this->request->data['keyword']!='Enter Agency Name or Email')
		{	 $conditions['OR']['Agency.name LIKE']='%'.$this->request->data['keyword'].'%';
			$conditions['OR']['Agency.email LIKE']='%'.$this->request->data['keyword'].'%';
		}
 	  	$this->paginate = array('conditions' => $conditions, 'limit' => 10, 'fields' => array('Agency.*', 'find_in_set(1,U.activate) as active'),'order'=>array('U.id'=>'DESC'),
		  'joins' => array(
                array(
                    'alias' => 'U',
                    'table' => 'accounts',
                    'type' => 'INNER',
                    'conditions' => '`U`.`id` = `Agency`.`account_id`'
					
                ))
          
		);
 	    $agency = $this->paginate('Agency');
		$this->set('agency',$agency);
		$this->render('admin_results');
	}
	
	public function admin_uploadlogo(){
		
		$this->layout='ajax';
		        if (!empty($this->data['TR_file']['tmp_name'])) {
            $fileUpload = WWW_ROOT . 'logo' . DS;
            $arr_img = explode(".", $this->data["TR_file"]["name"]);
            $ext = strtolower($arr_img[count($arr_img) - 1]);
            if ($this->data["TR_file"]['error'] == 0 && in_array($ext,array('jpg','gif','png'))){
                $fname = removeSpecialChar($this->data['TR_file']['name']);
                $file = time() . "_" . $fname;
                if (upload_my_file($this->data['TR_file']['tmp_name'], $fileUpload . $file)) {
					$save_path="thumb_".$file;
					
					create_thumb($fileUpload . $file, 150, $fileUpload.$save_path);
					echo "success|".$file;
				}
				else echo "error|Try another time";
			}
				else echo "error|Please select jpg,gif,png file type";
			}
			die;
	}
	
	public function save_agency(){
		$this->layout='ajax';
		if($this->data['id']==''){
			$arr=$this->Agency->findByTitle($this->data['title']);
			if(is_array($arr)){
				echo "Title already taken. It must be unique";
				die;
			}else{
				$arr=$this->Agency->findByEmail($this->data['email']);
				if(is_array($arr)){
				echo "Title already taken. It must be unique";
				die;				
				}
				else
					$this->createAccount(1);
				}
			}
			else{
				$this->Agency->id=$this->data['id'];
				$this->Agency->save($this->data);
			}
				die;
		}

	public function admin_upgrade_subscription($id){
		$this->layout='ajax';
		$this->Agency->query("update jsb_agency set plan_taken_date=date_add(plan_taken_date,interval 1 year),plan_due_date=date_add(plan_due_date,interval 1 year) where account_id='".$id."'");
		die;
	}
	
	public function admin_change_status() {
        $this->layout = 'ajax';
        if ((int) $this->data['status'] == 0)
            $this->Agency->query("update jsb_accounts set activate=concat_ws(',',activate,'1') where id='" . $this->data['id'] . "'");
        else{
            $this->Agency->query("update jsb_accounts set activate=replace(activate,'1','') where id='" . $this->data['id'] . "'");
			$agency_id=$this->data['id'];
			$this->Agency->query("update jsb_coach set agency_id='0' where agency_id='$agency_id'");
			$this->Agency->query("update jsb_client set agency_id='0' where agency_id='$agency_id'");
			}
        die;

        
    }
	
	public function deleteAgency(){
		$this->layout='ajax';
			
	}
	
	public function admin_logout(){
        $date = date('Y-m-d H:i:s');
        $this->Userlog->query("update jsb_user_log set logout_time='$date' where account_id='" . $this->Session->read('Account.id') . "' and usertype='" . $this->Session->read('usertype') . "' and logout_time='0000-00-00 00:00:00'");
        $this->Session->delete('Account');
        if (!isset($this->data['act']))
            $this->redirect('/admin');

	}
	public function admin_settings()
	{
	}	
public function change_pass()
	{
		if($this->request->is('ajax'))
		{	if(!empty($this->data))
			{	
			
				$old_password=md5($this->data['Account']['old_password']);
				$user=$this->Account->findById($this->Session->read('Account.id'));
				
				if($user['Account']['password']!=$old_password)
				{
					echo 'Old password does not match! Please try again.';
					$this->autoRender=false;
					}
				else{
					$new_password=md5($this->data['Account']['new_password']);
					$this->Account->query("UPDATE jsb_accounts SET password='".$new_password."' WHERE id='".$user['Account']['id']."'");
					
					echo 'Password has been updated';
					$Mail = new MailController;
        			$Mail->constructClasses();
        		    $Mail->sendMail($user['Account']['id'], "change_password",array('PASSWORD'=>$this->data['Account']['new_password']));
					$this->autoRender=false;
					}
				}
	}		
		
	}
	
}