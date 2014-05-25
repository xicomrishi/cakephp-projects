<?php

App::import('Vendor', array('functions', 'xtcpdf'));
App::import('Controller', 'Users');

//App::import('Vendor','uploadclass');

class EmployerController extends UsersController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session', 'Upload');
    public $uses = array('Client', 'Account', 'Card','Employer');

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->Session->check('Account.id')) {
            $this->redirect(SITE_URL);
            exit();
        }
        $this->layout = 'jsb_bg';
    }

    public function search() {
        $this->layout = 'ajax';
        if (isset($this->data['cbox'])) {
            $del_id = implode(",", $this->data['cbox']);
            $clients = $this->Employer->query("select id from jsb_employer where account_id in ($del_id)");
        $clientid = '';
        foreach ($clients as $client) 
            $clientid.=$client['jsb_employer']['id'] . ",";           
        $this->Employer->query("update jsb_accounts set activate=replace(activate,'4',''),usertype=replace(usertype,'4','') where id in ($del_id)");
        $this->Employer->query("delete from jsb_accounts where ISNULL(usertype)=TRUE");
        if ($clientid !== '') {
            $clientid = substr($clientid, 0, -1);
            $this->Employer->deleteAll(array('Employer.account_id' => $this->data['cbox']));
            //$this->Client->query("delete from jsb_card where client_id in ($clientid)");
        }
        }
      
        if (count($this->request->data) == 0)
            $this->request->data = $this->passedArgs;
        $conditions=array();
        if (isset($this->data['keyword']) && trim($this->data['keyword']) != '')
            $conditions['Employer.name like '] = "%" . $this->data['keyword'] . "%";
        $this->paginate = array(
            'conditions' => $conditions,
            'joins' => array(
                array(
                    'alias' => 'U',
                    'table' => 'accounts',
                    'type' => 'INNER',
                    'conditions' => '`U`.`id` = `Employer`.`account_id`'
                )
            ),
            'fields' => array('Employer.*', 'find_in_set(4,U.activate) as active'),
            'limit' => 5,
            'group' => 'Employer.id',
            'order' => array(
                'Employer.id' => 'desc'
            )
        );
        $clients = $this->paginate('Employer');
        $this->set('rows', $clients);
        $this->render('results');
    }

    public function index($num=null) {

        if (!empty($this->data)) {
            $this->layout = 'ajax';
        }
        $this->set('num', $num);
    }

    
    public function show_add() {
        $this->layout = 'ajax';
        $id = $this->data['id'];
        if ($id != 0) {
            $row = $this->Employer->findByAccountId($id);
            $this->set('row', $row['Employer']);
        }
        
    }

    
    public function admin_index() {
        $this->layout = 'jsb_admin';
        
    }

    public function change_status() {
        $this->layout = 'ajax';
        if ((int) $this->data['status'] == 0)
            $this->Account->query("update jsb_accounts set activate=concat_ws(',',activate,'4') where id='" . $this->data['id'] . "'");
        else
            $this->Account->query("update jsb_accounts set activate=replace(activate,'4','') where id='" . $this->data['id'] . "'");
        die;

        $this->autoRender = false;
    }

    public function show_search() {
        $this->layout = 'ajax';
        $this->render('search');
    }

    
    public function uploadlogo() {
        $this->layout = 'ajax';
        if (!empty($this->data['TR_file']['tmp_name'])) {
            $fileUpload = WWW_ROOT . 'logo' . DS;
            $arr_img = explode(".", $this->data["TR_file"]["name"]);
            $ext = strtolower($arr_img[count($arr_img) - 1]);
            if ($this->data["TR_file"]['error'] == 0 && in_array($ext, array('jpg', 'gif', 'png'))) {
                $fname = removeSpecialChar($this->data['TR_file']['name']);
                $file = time() . "_" . $fname;
                if (upload_my_file($this->data['TR_file']['tmp_name'], $fileUpload . $file)) {
                    $save_path = "thumb_" . $file;
                    create_thumb($fileUpload . $file, 150, $fileUpload . $save_path);
                    echo "success|" . $save_path;
                }
                else
                    "failed|Try another time";
            }
        }
        die;
    }

    public function savedata($id){
        $this->autorender=false;
        $this->Employer->id=$id;
        $this->Employer->save($this->data);
        die;
    }
}