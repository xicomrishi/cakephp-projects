<?php
//App::uses('CakeEmail', 'Network/Email');
App::import('Vendor','functions');

class DocsController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
    public $uses = array('Client','Skillslist','Account','University','Major','Minor','Country','State','Industry','Position','Jobtype','Jobfunction','Clientfile','Clientfilehistory');

    public function beforeFilter() {
	if(!$this->Session->check('Client'))
			{
			$this->redirect(SITE_URL.'/users/session_expire');
			//$this->Session->setFlash(__('You are not authorized to acces that page. Please login to  continue.'));
			exit();
			}
		parent::beforeFilter();	
        $this->layout = 'jsb_bg';
    }
	
	public function index($num=null)
	{
		
		if(!empty($this->data))
		{	//echo '<pre>';print_r($this->data);die;
			$this->layout='ajax';
			$clientid=$this->data['clientid'];
			//$files=$this->Clientfile->find('all',array('conditions'=>array('Clientfile.client_id'=>$clientid),'order'=>array('Clientfile.last_modified DESC')));
			$query = "select * from jsb_client_files AS File where client_id='" . $clientid."' order by id desc";
			$files=$this->Clientfile->query($query);
			$path=WWW_ROOT.'files'.DS;
			$this->set('path',$path);
			$this->set('clientid',$clientid);
			$this->set('files',$files);
			$this->render('show_list_docs');
		}
		
		$clientid=$this->Session->read('Client.Client.id');	
		$this->set('clientid',$clientid);
		$this->set('num',$num);
	}
	
	public function show_add_doc()
	{
		$this->layout='ajax';
		$clientid=$this->data['clientid'];
		$clientinfo=$this->Client->findById($clientid);
		$this->set('clientinfo',$clientinfo);
		$this->set('clientid',$clientid);
		
		$this->render('upload_doc');	
		
	}
	
	public function show_search()
	{
		$this->layout='ajax';
		$clientid=$this->data['clientid'];
		$this->set('clientid',$clientid);
		$this->render('search_doc');
	}
	
	public function search_doc()
	{
		$this->layout='ajax';
		$keyword=$this->data['keyword'];
		$clientid=$this->data['clientid'];
		$query = "select * from jsb_client_files AS File where client_id='" . $clientid."'";
		if($keyword==''||$keyword=='Enter Document Name/Tags/Desc')
		{
			$query.= "";
		
		}else{
		 $query.= " and file LIKE '%$keyword%'";
		}
		$files=$this->Clientfile->query($query);
		$path=WWW_ROOT.'files'.DS;
		$this->set('path',$path);
		$this->set('files',$files);
		$this->render('show_list_docs');
		//echo '<pre>';print_r($files);die;	
		
	}	
	
	public function upload_doc()
	{
		//echo '<pre>';print_r($this->data);die;	
		if(!empty($this->data['filename']['tmp_name']))
		{	
			$clientid=$this->data['clientid'];
			$folderpath=WWW_ROOT . 'files' . DS . $clientid;
			if(!is_dir($folderpath)) {
				$folder=mkdir($folderpath,0777);
				mkdir($folderpath,0777);
			}
			
			$fileUpload=WWW_ROOT . 'files' . DS . $clientid . DS ;
			$arr_img=explode(".",$this->data["filename"]["name"]);
			$ext=strtolower($arr_img[count($arr_img)-1]);
			
			if(($ext=="doc")||($ext=="docx") ||($ext=="pdf")||($ext=="txt")||($ext=="jpg"))
			{		//echo '2'; 
					$fname=removeSpecialChar($this->data['filename']['name']);
					$file = time()."_".$fname;
					
				if(upload_my_file($this->data['filename']['tmp_name'],$fileUpload.$file))
				{
					$filename=$this->data['filename']['name'];
					$shared='N';
					//echo $shared;die;
					if(isset($this->data['Clientfile']['shared']))
					{
						$shared='Y';
						}
						
					$data=array('client_id'=>$clientid,'file'=>$file,'filename'=>$filename,'shared'=>'N','last_modified'=>date("Y-m-d H:i:s"),'reg_date'=>date("Y-m-d H:i:s"),'description'=>$this->data['Clientfile']['description'],'tags'=>$this->data['Clientfile']['tags'],'shared'=>$shared);
					$this->Clientfile->create();
					$added_file=$this->Clientfile->save($data);
					//echo '<pre>';print_r($added_file['Clientfile']['id']);die;
					$file_hist_data=array('file_id'=>$added_file['Clientfile']['id'],'filename'=>$filename);
					$this->Clientfilehistory->create();
					$this->Clientfilehistory->save($file_hist_data);
					//echo "success|File has been uploaded successfully.."; 
					$this->redirect(array('controller'=>'docs','action'=>'index',1));
				}	
			}
			else
			{
				$this->redirect(array('controller'=>'docs','action'=>'index',1));
			}
		}
	}
	
	public function edit_doc()
	{
		$this->layout='ajax';
		$fileid=$this->data['fileid'];
		$file=$this->Clientfile->findById($fileid);
		$clientinfo=$this->Client->findById($file['Clientfile']['client_id']);
		$this->set('clientinfo',$clientinfo);
		$this->set('clientid',$file['Clientfile']['client_id']);
		$this->set('file',$file);
		$this->render('document_edit');	
	}
	
	public function edit_upload_doc()
	{
		//echo '<pre>';print_r($this->data);die;
		$clientid=$this->data['clientid'];
		$fileid=$this->data['fileid'];
		if(!empty($this->data['Clientfile']))
		{
			$dat=$this->data;
			$shared='N';
			if(isset($dat['Clientfile']['shared']))
			{
				$shared='Y';
				}
			$save_data=array('tags'=>$dat['Clientfile']['tags'],'description'=>$dat['Clientfile']['description'],'last_modified'=>date("Y-m-d H:i:s"),'shared'=>$shared);
			$this->Clientfile->id=$fileid;
			$this->Clientfile->save($save_data);
			$this->Session->write('Client.upload_success','1');
			
		}
		//echo '<pre>';print_r($dat);die;
		if(!empty($dat['filename']['tmp_name']))
		{
			
			$folderpath=WWW_ROOT . 'files' . DS . $clientid;
			
			$fileUpload=WWW_ROOT . 'files' . DS . $clientid . DS ;
			$arr_img=explode(".",$dat['filename']['name']);
			$ext=strtolower($arr_img[count($arr_img)-1]);
			if(($ext=="doc")||($ext=="docx") ||($ext=="pdf")||($ext=="txt")||($ext=="jpg"))
			{
					$fname=removeSpecialChar($dat['filename']['name']);
					$file = time()."_".$fname;
				if(upload_my_file($dat['filename']['tmp_name'],$fileUpload.$file))
				{
					$filename=$dat['filename']['name'];
					$data=array('client_id'=>$clientid,'file'=>$file,'filename'=>$filename,'shared'=>'N','last_modified'=>date("Y-m-d H:i:s"));
					$this->Clientfile->id=$fileid;
					$added_file=$this->Clientfile->save($data);
					//echo '<pre>';print_r($added_file['Clientfile']['id']);die;
					$file_hist_data=array('file_id'=>$fileid,'filename'=>$filename,'modified_date'=>date("Y-m-d H:i:s"));
					$file_hist=$this->Clientfilehistory->findByFileId($fileid);
					$this->Clientfilehistory->id=$file_hist['Clientfilehistory']['id'];
					$this->Clientfilehistory->save($file_hist_data);
					$this->Session->write('Client.edit_success','1');
					
				}	
			}
			else
			{
				$this->autoRender=false;
			}
		
			
		}
		$this->Session->write('Client.edit_success','1');
		$this->redirect(array('controller'=>'docs','action'=>'index',2));
		
	}
	
	public function delete_file()
	{	
		$cbox=array();
		$cbox=$this->data['cbox'];
		for($i=0;$i<count($cbox);$i++)
		{
			$query= "select file from jsb_client_files where id='".$cbox[$i]."'";
			$result=$this->Clientfile->query($query);
			//$row = mysql_fetch_array($result);
			//@unlink($fileUpload.$row[0]);
			$query1= "delete from jsb_client_files where id='".$cbox[$i]."'";
			$result=$this->Clientfile->query($query1);
			$sql="delete from jsb_client_file_history where file_id='".$cbox[$i]."'";
			$this->Clientfilehistory->query($sql);
			
		}	
			$this->layout='ajax';
			$clientid=$this->Session->read('Client.Client.id');
			$query = "select * from jsb_client_files AS File where client_id='" . $clientid."' order by id desc";
			$files=$this->Clientfile->query($query);
			$path=WWW_ROOT.'files'.DS;
			$this->set('path',$path);
			$this->set('clientid',$clientid);
			$this->set('files',$files);
			$this->render('show_list_docs');
		
		
	} 
		
		
}
	