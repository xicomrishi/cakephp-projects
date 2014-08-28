<?php

App::import('Vendor', array('functions', 'linkedin', 'xmltoarray', 'reader'));

class SnagpluginController extends AppController {

    public $helpers = array('Html', 'Form');
    public $components = array('Session');
    public $uses = array('Client', 'Account', 'Linkedlogin', 'Coach', 'Friend', 'Agency', 'Basket','Card','Carddetail','Cardcolumn','Note');
	
	
    function get_inner_html($node) {
        $innerHTML = '';
        $children = $node->childNodes;
        foreach ($children as $child) {
            $innerHTML .= $child->ownerDocument->saveXML($child);
        }

        return $innerHTML;
    }

    public function index() {
		
        $this->layout = 'plugin';
		//print_r($this->data); die;
        if ($this->Session->check('Client.Client.id') == false)
            $this->render('login');
        else {
            $this->basket();
            $this->layout = 'plugin';
            $this->render('basket');
        }
        //$url = $this->data['url'];
    }

    public function basket() {
        $this->layout = 'ajax';
		
        $str = file_get_contents($this->data['url']);
		
        $htmldoc = new DOMDocument;
        
        libxml_use_internal_errors(true);
        $htmldoc->loadHTML(urldecode($this->data['escaped_content']));
        libxml_clear_errors();
        $inputs = $htmldoc->getElementsByTagName("input");
		
        $arr = array();
        foreach ($inputs as $input) {
            $arr[$input->getAttribute("name")] = urldecode($input->getAttribute("value"));
        };
        $arr['job_detail'] = $this->get_inner_html($htmldoc->getElementById('TrackingJobBody'));
        $arr['job_detail'] = strip_tags(str_replace("<br>", "\n", $arr['job_detail']));
        $pos = strpos($str, "mailto:");
        if ($pos) {
            $pos1 = strpos($str, '"', $pos);
            $pos2 = strpos($str, "?", $pos);
            if ($pos2 < $pos1)
                $pos1 = $pos2;
            $arr['contact_email'] = substr($str, $pos + 7, $pos1 - $pos - 7);
        }
		
        $this->set('arr', $arr);
        $this->set('url', $this->data['url']);
    }

    public function extract_css_urls($text) {
        $urls = array();

        $url_pattern = '(([^\\\\\'", \(\)]*(\\\\.)?)+)';
        $urlfunc_pattern = 'url\(\s*[\'"]?' . $url_pattern . '[\'"]?\s*\)';
        $pattern = '/(' .
                '(@import\s*[\'"]' . $url_pattern . '[\'"])' .
                '|(@import\s*' . $urlfunc_pattern . ')' .
                '|(' . $urlfunc_pattern . ')' . ')/iu';
        if (!preg_match_all($pattern, $text, $matches))
            return $urls;

        foreach ($matches[3] as $match)
            if (!empty($match))
                $urls['import'][] =
                        preg_replace('/\\\\(.)/u', '\\1', $match);
        foreach ($matches[7] as $match)
            if (!empty($match))
                $urls['import'][] =
                        preg_replace('/\\\\(.)/u', '\\1', $match);
        foreach ($matches[11] as $match)
            if (!empty($match))
                $urls['property'][] =
                        preg_replace('/\\\\(.)/u', '\\1', $match);
        return $urls;
    }

    public function add_card() {
        $this->autoRender = false;
        if (isset($this->data['description'])) {
            if ($this->data['description'] != 'Data not found. Enter manually.')
                $this->request->data['position_info'] = $this->data['description'];
        }
        $this->request->data['client_id'] = $this->Session->read('Client.Client.id');
        if (isset($this->data['contact_email'])) {
            if ($this->data['contact_email'] == 'Data not found. Enter manually.')
                $this->data['contact_email'] = '';
            if ($this->data['notes'] == 'Enter your notes about the job opportunity here')
                $this->request->data['notes'] = "";
        }
        $this->request->data['position_available'] = $this->data['job_title'];
        $this->request->data['date_added'] = date("Y-m-d H:i:s");
        //          $count=my_get_one("select count(*) from jsb_basket where client_id='$_POST[token]' and job_url='$_POST[job_url]'")
//            if($count==0){
        $this->Basket->create();
        $this->Basket->save($this->data);
        $id = $this->Basket->id;
		$file=WWW_ROOT."/jobs/".$id.".pdf";
		if(strpos($this->data['job_url'],'jobview.monster')!=false)
		{
			$content=preg_replace('#<script(.*?)>(.*?)</script>#is', '',file_get_contents($this->data['job_url']));
			$content = preg_replace('#<link(.*?)>#is', '', $content);
			$newfile=WWW_ROOT."/jobs/".$id.".html";
			file_put_contents($newfile,$content);
			exec("wkhtmltopdf '".SITE_URL."/jobs/".$id.".html' $file");
			unlink($newfile);
		}
		else
			exec("wkhtmltopdf '".$this->data['job_url']."' $file");
        echo "Card Added";
        die;
    }

    public function transfer() {
        $this->autoRender=false;
        $client_id = $this->Session->read('Client.Client.id');
        $cards = $this->Basket->findAllByClientId($client_id);
        $c_id = "";
		$date=date('Y-m-d H:i:s');
        foreach ($cards as $card_info) {
            $card=$card_info['Basket'];
            $c_id.=$card['id'] . ",";
		    $data['client_id']=$client_id;
	        $data['job_type'] = "C";
    	    $data['type_of_opportunity'] = "Job Card Plugin";
        	$date=$data['start_date'] = $data['reg_date'] = $data['date_allocated'] = $data['latest_card_mov_date'] = $date;
	        $data['resourcetype']=3;
    	    $data['total_points']='2.0';
            $data['company_name'] = $card['company_name'];
            $data['job_url']=$card['job_url'];
            $data['company_name']=$card['company_name'];
            $data['resource_id'] = $card['id'];
            $data['position_info']=$card['description'];
            $data['position_available'] = $card['position_available'];
            $this->Card->create();
            $this->Card->save($data);
            $card_id=$this->Card->id;
             $data = array('card_id' => $card_id, "column_status" => "O", "start_date" => $date);
            $this->Carddetail->create();
            $this->Carddetail->save($data);
            $data = array('card_id' => $card_id, 'total_points' => '2.0');
            $this->Cardcolumn->create();
            $this->Cardcolumn->save($data);
            if ($card['notes'] != '') {
                $data=array('note_id'=>$card_id,'note'=>$card['notes'],'note_type'=>0,'column_status'=>'O','date_added'=>$date);	
		$this->Note->create();
		$this->Note->save($data);
		unset($this->Note->id);
            }
            
            unset($this->Card->id);
            unset($this->Carddetail->id);
            unset($this->Cardcolumn->id);
        }
        if ($c_id != '') {
            $c_id = substr($c_id, 0, -1);
            $this->Basket->query("delete from jsb_basket where id in ($c_id)");
        }
        echo "SUCCESS";die;
    }

    public function delete_card($ids) {
        if (is_dir(WWW_ROOT . '/jobs/'.$id.'.pdf'))
			unlink(WWW_ROOT . '/jobs/'.$id.'.pdf');
        $this->Basket->query("delete from jsb_basket where id='$ids'");
        die;
    }

    public function filled_basket() {
        $cards = $this->Basket->findAllByClientId($this->data['token'], '', 'id desc');
        $this->layout = 'ajax';
        $count = count($cards);
        if (is_array($cards) && count($cards) > 0)
            $count = count($cards);
        else
            $count = 0;
        $this->set('count', $count);
        $this->set('cards', $cards);
    }

}
