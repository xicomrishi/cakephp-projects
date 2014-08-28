<?php
/**
 * Name : Setting Controller
 * Created : 10 Nov 2013
 * Purpose : Default Setting controller
 * Author : Prakhar Johri
 */ 
class SettingsController extends AdminAppController
{
	public $name = 'Settings';
	public $uses = array('Settings');
	public $components = array('Uploader');

	public $paginate = array ('limit' => 10);		
		
	public function beforeFilter()
	{
		//Set auth model Admin
		parent::beforeFilter();
		$this->Auth->authenticate = array(
			'Form' => array('userModel' => 'Admin')
		);
		$this->Auth->allow('register');
	}	
			
	/**
	* Purpose : basic site settings 
	* Inputs: id , data inpost
	* Output : data save message
	* Author: Prakhar Johri
	* Created On : 8 Nov 2013
	**/
	public function site_setting() 
	{				
		if ($this->request->is('post') || $this->request->is('put')) 
		{
			$data = $this->request->data;
			$value = json_encode($this->request->data);
			$data_arr['value'] = $value;
			$data_arr['id'] = $data['Settings']['id'];
			
			if ($this->Settings->save($data_arr)) 
			{
				if(isset($this->request->data['Settings']['image']['name']) && !empty($this->request->data['Settings']['image']['name']))
				{
					$image_array = $this->request->data['Settings']['image'];
					$image_info = pathinfo($image_array['name']);
					$image_new_name = $image_info['filename'].time();
					$thumbnails = false;
					
					$this->Uploader->upload($image_array, SETTINGS, $thumbnails, $image_new_name );
				
					if ( $this->Uploader->error )
					{
						$file_error = $this->Uploader->errorMessage;
						$this->flash_new( $file_error, 'error-messages' ); 
					}
					else
					{	
						$this->Settings->id = $data['Settings']['id'];
						$this->Settings->saveField('image', $this->Uploader->filename);
					}
				}
				
				$this->Session->setFlash(__('Settings page is saved'));
				$this->redirect(array('action' => 'site_setting'));
			} 
			else 
			{
				$this->Session->setFlash(__('Error saving page, please check again.'));
			}
		} 
		else 
		{
			$settings = $this->Settings->findByKey('site_setting');	
			$setting_data = json_decode($settings['Settings']['value'],true);			
			$setting_data['Settings']['image'] = $settings['Settings']['image'];
	 
			$this->request->data = $setting_data;
		}
		$this->set('page', 'edit');
		$this->render('add');
	}
}

?>
