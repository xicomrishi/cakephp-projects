<?php
App::import('Vendor','functions');
App::uses('Component', 'Controller');
/*
 * jQuery File Upload Plugin PHP Class 5.9.2
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

class UploadComponent extends Component
{
     public $components = array('Session');
	  public $uses = array('Client','Clientfile','Clientfilehistory');
	protected $options;
    

    function __construct( ComponentCollection $collection, $options = null ) {

        $this->UploadModel = ClassRegistry::init('Clientfile');
		$this->UploadModelHist = ClassRegistry::init('Clientfilehistory');
		
        $this->options = array(
            'script_url' => Router::url('/', true).'clients/handler',
            'upload_dir' => WWW_ROOT.'files/',
            'upload_url' => $this->getFullUrl().'/files/',
            'param_name' => 'files',
            // Set the following option to 'POST', if your server does not support
            // DELETE requests. This is a parameter sent to the client:
            'delete_type' => 'DELETE',
            // The php.ini settings upload_max_filesize and post_max_size
            // take precedence over the following max_file_size setting:
            'max_file_size' => null,
            'min_file_size' => 1,
            'accept_file_types' => '/.+$/i', // For only accept images use this: ([^\s]+(\.(?i)(jpg|png|gif|bmp))$)
            'max_number_of_files' => null,
            // Set the following option to false to enable resumable uploads:
            'discard_aborted_uploads' => true,
            // Set to true to rotate images based on EXIF meta data, if available:
            'orient_image' => false,
            'image_versions' => array(
                // Uncomment the following version to restrict the size of
                // uploaded images. You can also add additional versions with
                // their own upload directories:
                /*
                'large' => array(
                    'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/files/',
                    'upload_url' => $this->getFullUrl().'/files/',
                    'max_width' => 1920,
                    'max_height' => 1200,
                    'jpeg_quality' => 95
                ),
                */
                // 'thumbnail' => array(
                //     'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/thumbnails/',
                //     'upload_url' => $this->getFullUrl().'/thumbnails/',
                //     'max_width' => 80,
                //     'max_height' => 80
                // )
            )
        );
        if ($options) {
            $this->options = array_replace_recursive($this->options, $options);
        }
    }

    public function getFullUrl() {
      	return
    		(isset($_SERVER['HTTPS']) ? 'https://' : 'http://').
    		(isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
    		(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
    		(isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 ||
    		$_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
    		substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }
    
    protected function set_file_delete_url($file) {
        $file->delete_url = $this->options['script_url']
            .'?file='.rawurlencode($file->name);
        $file->delete_type = $this->options['delete_type'];
        if ($file->delete_type !== 'DELETE') {
            $file->delete_url .= '&_method=DELETE';
        }
    }
    
    protected function get_file_object($file_name) {
		$clientid=$_SESSION['clientid'];
        $file_path = $this->options['upload_dir'].$clientid.'/'.$file_name;
        if (is_file($file_path) && $file_name[0] !== '.') {
            $file = new stdClass();
            $file->name = $file_name;
            $file->size = filesize($file_path);
            $file->url = $this->options['upload_url'].$clientid.'/'.rawurlencode($file->name);
            foreach($this->options['image_versions'] as $version => $options) {
                if (is_file($options['upload_dir'].$file_name)) {
                    $file->{$version.'_url'} = $options['upload_url']
                        .rawurlencode($file->name);
                }
            }
            $this->set_file_delete_url($file);
            return $file;
        }
        return null;
    }
    
    protected function get_file_objects() {
		$clientid=$_SESSION['clientid'];
		$dir=$this->options['upload_dir'].$clientid.'/';
		//echo $dir;die;
		
		//print_r(array_map(array($this, 'get_file_object'),scandir($dir))); die;
        $files= array_values(array_filter(array_map(
            array($this, 'get_file_object'),
            scandir($dir)
        )));
		foreach($files as $file){
		$nam=$file->name;
		$data_file=$this->UploadModel->findByClientIdAndFile($clientid,$nam);
		$file->name=$data_file['Clientfile']['filename'];
		}
		return ($files);
		
    }

    protected function create_scaled_image($file_name, $options) {
        $file_path = $this->options['upload_dir'].$file_name;
        $new_file_path = $options['upload_dir'].$file_name;
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $scale = min(
            $options['max_width'] / $img_width,
            $options['max_height'] / $img_height
        );
        if ($scale >= 1) {
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;
        $new_img = @imagecreatetruecolor($new_width, $new_height);
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                $image_quality = isset($options['jpeg_quality']) ?
                    $options['jpeg_quality'] : 75;
                break;
            case 'gif':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                $image_quality = null;
                break;
            case 'png':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                $image_quality = isset($options['png_quality']) ?
                    $options['png_quality'] : 9;
                break;
            default:
                $src_img = null;
        }
        $success = $src_img && @imagecopyresampled(
            $new_img,
            $src_img,
            0, 0, 0, 0,
            $new_width,
            $new_height,
            $img_width,
            $img_height
        ) && $write_image($new_img, $new_file_path, $image_quality);
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($src_img);
        @imagedestroy($new_img);
        return $success;
    }
    
    protected function has_error($uploaded_file, $file, $error) {
        if ($error) {
            return $error;
        }
        if (!preg_match($this->options['accept_file_types'], $file->name)) {
            return 'acceptFileTypes';
        }
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            $file_size = filesize($uploaded_file);
        } else {
            $file_size = $_SERVER['CONTENT_LENGTH'];
        }
        if ($this->options['max_file_size'] && (
                $file_size > $this->options['max_file_size'] ||
                $file->size > $this->options['max_file_size'])
            ) {
            return 'maxFileSize';
        }
        if ($this->options['min_file_size'] &&
            $file_size < $this->options['min_file_size']) {
            return 'minFileSize';
        }
        if (is_int($this->options['max_number_of_files']) && (
                count($this->get_file_objects()) >= $this->options['max_number_of_files'])
            ) {
            return 'maxNumberOfFiles';
        }
        return $error;
    }

    protected function upcount_name_callback($matches) {
        $index = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        $ext = isset($matches[2]) ? $matches[2] : '';
        return ' ('.$index.')'.$ext;
    }

    protected function upcount_name($name) {
        return preg_replace_callback(
            '/(?:(?: \(([\d]+)\))?(\.[^.]+))?$/',
            array($this, 'upcount_name_callback'),
            $name,
            1
        );
    }
    
    protected function trim_file_name($name, $type) {
        // Remove path information and dots around the filename, to prevent uploading
        // into different directories or replacing hidden system files.
        // Also remove control characters and spaces (\x00..\x20) around the filename:
        $file_name = trim(basename(stripslashes($name)), ".\x00..\x20");
        // Add missing file extension for known image types:
        if (strpos($file_name, '.') === false &&
            preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
            $file_name .= '.'.$matches[1];
        }
        if ($this->options['discard_aborted_uploads']) {
            while(is_file($this->options['upload_dir'].$file_name)) {
                $file_name = $this->upcount_name($file_name);
            }
        }
        return $file_name;
    }

    protected function orient_image($file_path) {
      	$exif = @exif_read_data($file_path);
        if ($exif === false) {
            return false;
        }
      	$orientation = intval(@$exif['Orientation']);
      	if (!in_array($orientation, array(3, 6, 8))) { 
      	    return false;
      	}
      	$image = @imagecreatefromjpeg($file_path);
      	switch ($orientation) {
        	  case 3:
          	    $image = @imagerotate($image, 180, 0);
          	    break;
        	  case 6:
          	    $image = @imagerotate($image, 270, 0);
          	    break;
        	  case 8:
          	    $image = @imagerotate($image, 90, 0);
          	    break;
          	default:
          	    return false;
      	}
      	$success = imagejpeg($image, $file_path);
      	// Free up memory (imagedestroy does not delete files):
      	@imagedestroy($image);
      	return $success;
    }
    
    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error) {
		$clientid=$_SESSION['clientid'];
		
        $file = new stdClass();
        $file->name = $this->trim_file_name($name, $type);
        $file->size = intval($size);
        $file->type = $type;
        $error = $this->has_error($uploaded_file, $file, $error);
        if (!$error && $file->name) {
			$folderpath=$this->options['upload_dir'].$clientid;
           
			/*if(!is_dir($folderpath)) {
				$folder=mkdir($folderpath,0777);
				mkdir($folderpath,0777);
			}*/
				$fname=removeSpecialChar($file->name);
					$file_new_name = time()."_".$fname;
					 $file_path = $folderpath.'/'.$file_new_name;
							
            $append_file = !$this->options['discard_aborted_uploads'] &&
                is_file($file_path) && $file->size > filesize($file_path);
            clearstatcache();
           if ($uploaded_file && is_uploaded_file($uploaded_file)) {
				
					$filename=$fname;
					
					$data=array('client_id'=>$clientid,'file'=>$file_new_name,'filename'=>$filename,'shared'=>'N','last_modified'=>date("Y-m-d H:i:s"),'reg_date'=>date("Y-m-d H:i:s"));
					//$this->Clientfile->create();
					$added_file=$this->UploadModel->save($data);
					//echo '<pre>';print_r($added_file['Clientfile']['id']);die;
					$file_hist_data=array('file_id'=>$added_file['Clientfile']['id'],'filename'=>$filename);
					//$this->Clientfilehistory->create();
					$this->UploadModelHist->save($file_hist_data);
					
				
			/*if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                // multipart/formdata uploads (POST method uploads)

                // File information to save on database
                $data = array(
                    'Upload' => array(
                        'name' => $name,
                        'size' => $size
                    )
                );
				

                // Save on database
                $this->UploadModel->save( $data );
*/

                if ($append_file) {
                    file_put_contents(
                        $file_path,
                        fopen($uploaded_file, 'r'),
                        FILE_APPEND
                    );
                } else {
                    move_uploaded_file($uploaded_file, $file_path);
                }
            }else{
                // Non-multipart uploads (PUT method support)
                file_put_contents(
                    $file_path,
                    fopen('php://input', 'r'),
                    $append_file ? FILE_APPEND : 0
                );
            }
			//echo filesize($file_path);die;
           // $file_size = filesize($file_path);
           /* if ($file_size === $file->size) {
            	if ($this->options['orient_image']) {
            		$this->orient_image($file_path);
            	}
                $file->url = $this->options['upload_url'].$clientid.'/'.rawurlencode($file->name);
                foreach($this->options['image_versions'] as $version => $options) {
                    if ($this->create_scaled_image($file->name, $options)) {
                        if ($this->options['upload_dir'] !== $options['upload_dir']) {
                            $file->{$version.'_url'} = $options['upload_url'].$clientid.'/'
                                .rawurlencode($file->name);
                        } else {
                            clearstatcache();
                            $file_size = filesize($file_path);
                        }
                    }
                }
            } else if ($this->options['discard_aborted_uploads']) {
                unlink($file_path);
                $file->error = 'abort';
            }*/
			$file->name=$file_new_name;
            //$file->size = $file_size;
			//print_r($file);die;
            $this->set_file_delete_url($file);
        } else {
            $file->error = $error;
        }
        return $file;
    }
    
    public function get() {
		$clientid=$_SESSION['clientid'];
        $file_name = isset($_REQUEST['file']) ?
            basename(stripslashes($_REQUEST['file'])) : null;
        if ($file_name) {
            $info = $this->get_file_object($file_name);
			
        } else {
			//$info=$this->UploadModel->find('all');
			//$temp=array();
			//forea
           $info = $this->get_file_objects();
			
        }
        header('Content-type: application/json');
        echo json_encode($info);
    }
	
	public function query_db($clienid) {
			$uploads_array = array();
			$data=$this->UploadModel->query("SELECT * FROM jsb_client_files AS Clientfile WHERE client_id='$clientid'");
			$select_result = $data;
			while($query_results = mysql_fetch_object($select_result))
				{   
					$file = new stdClass();
					$file->id = $query_results->id;
					$file->name = $query_results->file_name;
					$file->size = $query_results->file_size;
					$file->type = $query_results->file_type;
					$file->url = "http://files.domain.com/".$query_results->file_name;
					$file->thumbnail_url = "http://thumbnails.domain.com/".$query_results->file_name;
					$file->delete_url = "";
					$file->delete_type = "DELETE";
					array_push($uploads_array,$file);
				}
			return $uploads_array;
		}

    
    public function post() {
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            return $this->delete();
        }
        $upload = isset($_FILES[$this->options['param_name']]) ?
            $_FILES[$this->options['param_name']] : null;
        $info = array();
        if ($upload && is_array($upload['tmp_name'])) {
            // param_name is an array identifier like "files[]",
            // $_FILES is a multi-dimensional array:
            foreach ($upload['tmp_name'] as $index => $value) {
                $info[] = $this->handle_file_upload(
                    $upload['tmp_name'][$index],
                    isset($_SERVER['HTTP_X_FILE_NAME']) ?
                        $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index],
                    isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                        $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index],
                    isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                        $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index],
                    $upload['error'][$index]
                );
            }
			//print_r($info); die;
        } elseif ($upload || isset($_SERVER['HTTP_X_FILE_NAME'])) {
            // param_name is a single object identifier like "file",
            // $_FILES is a one-dimensional array:
            $info[] = $this->handle_file_upload(
                isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
                isset($_SERVER['HTTP_X_FILE_NAME']) ?
                    $_SERVER['HTTP_X_FILE_NAME'] : (isset($upload['name']) ?
                        $upload['name'] : null),
                isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                    $_SERVER['HTTP_X_FILE_SIZE'] : (isset($upload['size']) ?
                        $upload['size'] : null),
                isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                    $_SERVER['HTTP_X_FILE_TYPE'] : (isset($upload['type']) ?
                        $upload['type'] : null),
                isset($upload['error']) ? $upload['error'] : null
            );
        }
        header('Vary: Accept');
		//$info=$this->get();
		//print_r($info);die;
        $json = json_encode($info);
        $redirect = isset($_REQUEST['redirect']) ?
            stripslashes($_REQUEST['redirect']) : null;
        if ($redirect) {
            header('Location: '.sprintf($redirect, rawurlencode($json)));
            return;
        }
        if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        echo $json;
    }
    
    public function delete() {
        $file_name = isset($_REQUEST['file']) ?
            basename(stripslashes($_REQUEST['file'])) : null;
			$clientid=$_SESSION['clientid'];
        $file_path = $this->options['upload_dir'].$clientid.'/'.$file_name;
       // $file_path = $this->options['upload_dir'].$file_name;
        $success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
        if ($success) {

            ## Delete file from database
            $aux = $this->UploadModel->findByName( $file_name );
            $this->UploadModel->delete( $aux['Upload']['id'] );


            foreach($this->options['image_versions'] as $version => $options) {
                $file = $options['upload_dir'].$file_name;
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        header('Content-type: application/json');
        echo json_encode($success);
    }

}
