<?php
App::import('Core','Validation');
App::uses('CakeEmail', 'Network/Email');
App::uses('Vendor', 'functions');

class MailController extends AppController {

    public $components = array('Session');
    public $uses = array('Account', 'Card', 'Mail');

    public function sendMail($toid, $section, $arr=array()) {
        $this->autoRender=false;
        $contents = $this->Mail->findBySection($section);
        
        $account = $this->Account->findById($toid);
        if(is_array($contents) && is_array($account)){
        $arr['TO_NAME'] = $account['Account']['name'];
        $arr['FROM_NAME'] = "The Snagpad Team";
        $arr['EMAIL']=$account['Account']['email'];
		if(!isset($arr['PASSWORD']))
        $arr['PASSWORD']="Password";
        $content = $contents['Mail']['content'];
		
        foreach ($arr as $key => $val)
            $content = str_replace("~~$key~~", $val, $content);
         $content = str_replace('~~SITE_URL~~', SITE_URL, $content);
		// echo '<pre>';print_r($content);
		if(!empty($account['Account']['email'])&&(Validation::email($account['Account']['email'], true)))
		{ 
			$email = new CakeEmail();
			$email->template('default');
			$email->emailFormat('html')->from('support@snagpad.com')->to($account['Account']['email'])->subject($contents['Mail']['subject'])->send($content);
		}
		}
    }

    
    public function admin_index(){
        $this->layout="jsb_admin";
        
    }
     public function show_search() {
        $this->layout = 'ajax';
        $this->render('search');
    }

    public function search() {
        $this->layout = 'ajax';
        if (count($this->request->data) == 0)
            $this->request->data = $this->passedArgs;
        $conditions=array();
          if (isset($this->data['keyword']) && trim($this->data['keyword']) != '')
            $conditions['Mail.subject like '] = "%" . $this->data['keyword'] . "%";
          
      
         $this->paginate = array(
            'conditions' => $conditions,
            'limit' => 10
            
        );
       
        $rows = $this->paginate('Mail');
        $this->set("rows", $rows);
        $this->render('results');
    }
    
    public function show_add(){
        $this->layout = 'ajax';
        $id = $this->data['id'];
        if ($id != 0) {
            $row = $this->Mail->findById($id);
            
            $this->set('content', $row['Mail']);
        }
        
    }
    
    public function save_content(){
        $this->autorender = false;
        $this->request->data['date_modified']=date('Y-m-d H:i:s');
        $conditions['Mail.section']=$this->data['section'];
        if($this->data['id']!='')
            $conditions['Mail.id !=']=$this->data['id'];
         $count=$this->Mail->find('count',array('conditions'=>$conditions));
        if($count!=0)
                echo "Section already exists";
        else{
                if($this->data['id']!='')
                    $this->Mail->create();
                else
                    $this->Mail->id=$this->data['id'];
                $this->Mail->save($this->data);
                
            }
            die;
        }
    


}