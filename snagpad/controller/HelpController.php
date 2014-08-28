<?php
//App::uses('CakeEmail', 'Network/Email');
App::import('Vendor','functions');

class HelpController extends AppController {
	
 public $helpers = array('Html', 'Form','Csv');
    public $components = array('Session');
    public $uses = array('Client','Skillslist','Account','University','Major','Minor','Country','State','Industry','Position','Jobtype','Jobfunction','Clientfile','Clientfilehistory','Contact','Helpfaqcat','Helpfaq');

    public function beforeFilter() {
	/*if(!$this->Session->check('Client'))
			{
			$this->redirect(SITE_URL.'/users/session_expire');
			//$this->Session->setFlash(__('You are not authorized to acces that page. Please login to  continue.'));
			exit();
			}*/
        //$this->layout = 'jsb_bg';
    } 
		
	public function index()
	{
		$this->layout='popup';
		$this->set("popTitle","HELP");
		$query = "select * from jsb_faq_cat AS Helpfaqcat where 1=1 and active='1' and id in (select distinct category from jsb_faq where active='1') order by orderby asc";
		$categories=$this->Helpfaqcat->query($query);
		$faqs=array();
		foreach($categories as $cat)
		{
			$sql="select * from jsb_faq AS Helpfaq where 1=1 and active='1' and category='".$cat['Helpfaqcat']['id']."' and active='1' order by orderby";
			$faqs[]=$this->Helpfaq->query($sql);
		}
		//echo '<pre>';print_r($faqs);die;
		$this->set('faqs',$faqs);
		$this->set('categories',$categories);
		
	}	

}