<?php

function get_facebook_cookie($app_id, $app_secret) {
    if ($_COOKIE['fbsr_' . $app_id] != '') {
        return get_new_facebook_cookie($app_id, $app_secret);
    } else {
        return get_old_facebook_cookie($app_id, $app_secret);
    }
}

function get_old_facebook_cookie($app_id, $app_secret) {
    $args = array();
    parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
    ksort($args);
    $payload = '';
    foreach ($args as $key => $value) {
        if ($key != 'sig') {
            $payload .= $key . '=' . $value;
        }
    }
    if (md5($payload . $app_secret) != $args['sig']) {
        return array();
    }
    return $args;
}

function get_new_facebook_cookie($app_id, $app_secret) {
    $signed_request = parse_signed_request($_COOKIE['fbsr_' . $app_id], $app_secret);
    // $signed_request should now have most of the old elements
    $signed_request[uid] = $signed_request[user_id]; // for compatibility
    if (!is_null($signed_request)) {
        // the cookie is valid/signed correctly
        // lets change "code" into an "access_token"
        $access_token_response = file_get_contents("https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=&client_secret=$app_secret&code=$signed_request[code]");
        parse_str($access_token_response);
        $signed_request[access_token] = $access_token;
        $signed_request[expires] = time() + $expires;
    }
    return $signed_request;
}

function parse_signed_request($signed_request, $secret) {
    list($encoded_sig, $payload) = explode('.', $signed_request, 2);

    // decode the data
    $sig = base64_url_decode($encoded_sig);
    $data = json_decode(base64_url_decode($payload), true);

    if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
        error_log('Unknown algorithm. Expected HMAC-SHA256');
        return null;
    }

    // check sig
    $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
    if ($sig !== $expected_sig) {
        error_log('Bad Signed JSON signature!');
        return null;
    }

    return $data;
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
}

//to set site hit//////

function returnkey($arr, $pos) {
    while ($temp = current($arr)) {
        if ($temp == $pos)
            return key($arr);
        next($arr);
    }
}

function show_text($var) {

    return stripslashes($var);
}

function site_hits() {

    global $var_user_log;

    $session_id = session_id();





    $ip = $_SERVER['REMOTE_ADDR'];

    $date = date("Y-m-d H:i:s");

    $log_rows = getAnyTableWhereData($var_user_log, "and session_id='$session_id'");

    if (!$log_rows) {



        $sql = "INSERT INTO $var_user_log (user_id,ip,login_time,session_id) VALUES('" . $user_id . "','" . $ip . "','" . $date . "','" . $session_id . "');";

        mysql_query($sql);
    }
}

function executeQuery($query) {
    $result = mysql_query($query);
    if ($row = mysql_fetch_array($result))
        return $row;
    else
        return false;
}

// FUNCTION TO create hidden fields for going back
function hiddenRequestFields($escapeFields=array()) {
    $h = "";
    if (!empty($_POST)) {
        reset($_POST);
        while (list($k, $v) = each($_POST)) {
            if (in_array("$k", $escapeFields))
                continue;
            $h .= "<input type=\"hidden\" name=\"$k\" value=\"$v\">\n";
        }
    }
    if (!empty($_GET)) {
        reset($_GET);
        while (list($k, $v) = each($_GET)) {
            if (in_array("$k", $escapeFields))
                continue;
            $h .= "<input type=\"hidden\" name=\"$k\" value=\"$v\">\n";
        }
    }
    return $h;
}

/*

  the function creates the hidden variables of the data received for post method.
  takes an string(comma seperated) as an parameter which contains name of those variables which we don want to extract on current page.
  Note: there should not be space in between the variable name which are seperated by the comma
 */

function extractHiddenVars($escapeVariables='', $gpr='HTTP_POST_VARS') {
    if ($escapeVariables != '') {
        $escapeVarArray = explode(",", $escapeVariables);
    }
    $hiddenFields = "";
    reset($GLOBALS[$gpr]);
    if (!empty($GLOBALS[$gpr])) {
        while (list($k, $v) = each($GLOBALS[$gpr])) {
            if (count($escapeVarArray) && in_array("$k", $escapeVarArray))
                continue;
            $hiddenFields .= "<input type=\"hidden\" name=\"$k\" value=\"$v\">\n";
        }
    }
    return $hiddenFields;
}

function insertData($table_name) {
    $arr_types = array("TRC_", "TR_", "TN_", "TREF_", "PHR_", "PHN_", "IR_", "IN_", "MR_", "MN_", "TNEF_", "TNC_", "TRFN_", "TNFN_", "TNURL_");
    if (!empty($_POST)) {
        reset($_POST);
        while (list($k, $v) = each($_POST)) {
            for ($p = 0; $p < count($arr_types); $p++) {
                if (stristr($k, $arr_types[$p]) != "") {
                    $k = str_replace($arr_types[$p], "", $k);
                }
            }
            ${strtolower($k)} = $v;
        }
    }
    if (!empty($_GET)) {
        reset($_GET);
        while (list($k, $v) = each($_GET)) {
            for ($p = 0; $p < count($arr_types); $p++) {
                if (stristr($k, $arr_types[$p]) != "") {
                    $k = str_replace($arr_types[$p], "", $k);
                }
            }
            ${strtolower($k)} = $v;
        }
    }
    $query1 = "";
    $query = "";
    $result = mysql_query("show fields from $table_name");
    $query = "insert into $table_name set ";
    while ($a_row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $field = "$a_row[Field]";
        if ($field != 'id') {
            if (isset($$field)) {
                $query.=$field . "=";
                $query.="'" . removeQuotes($$field) . "' , ";
            } else {
                if (isset($GLOBALS["$field"])) {
                    $query.=$field . "=";
                    $query.="'" . removeQuotes($GLOBALS["$field"]) . "' , ";
                }
            }
        }
    }
    $query = substr($query, 0, -2);
    $result = mysql_query($query);
    return $result;
}

//Function to edit data from any table.

function editData($table_name, $fldname, $fldval) {
    $arr_types = array("TRC_", "TR_", "TN_", "TREF_", "PHR_", "PHN_", "IR_", "IN_", "MR_", "MN_", "TNEF_", "TNC_", "TRFN_", "TNFN_", "TNURL_");
    if (!empty($_POST)) {
        reset($_POST);
        while (list($k, $v) = each($_POST)) {



            for ($p = 0; $p < count($arr_types); $p++) {

                if (stristr($k, $arr_types[$p]) != "") {

                    $k = str_replace($arr_types[$p], "", $k);
                }
            }

            ${strtolower($k)} = $v;
        }
    }





    if (!empty($_GET)) {

        reset($_GET);

        while (list($k, $v) = each($_GET)) {



            for ($p = 0; $p < count($arr_types); $p++) {

                if (stristr($k, $arr_types[$p]) != "") {

                    $k = str_replace($arr_types[$p], "", $k);
                }
            }

            ${strtolower($k)} = $v;
        }
    }





    $result = mysql_query("show fields from $table_name");

    $query = "update $table_name set ";

    while ($a_row = mysql_fetch_array($result, MYSQL_ASSOC)) {

        $field = "$a_row[Field]";





        if ($field != $fldname) {

            if (isset($$field)) {



                $query.=$field . "=";

                $query.="'" . removeQuotes($$field) . "' , ";
            } else {

                if (isset($GLOBALS["$field"])) {

                    $query.=$field . "=";

                    $query.="'" . removeQuotes($GLOBALS["$field"]) . "' , ";
                }
            }
        }
    }

    $query = substr($query, 0, -2);

    $query.="where $fldname='$fldval'";

    //echo $query;

    $result = mysql_query($query);

    return $result;
}

//this function is for listing records pagewise

function pagelist($totalrow, $listrow, $links, $extra) {

    $pages = $totalrow / $listrow; //total no of page

    $str = ""; // printing the page

    for ($i = 0; $i < $pages; $i++) {

        $j = $i + 1;



        if ($str == "")
            $str = "<a class=apaging href=\"$links?page=$i&$extra\">$j</a> ";

        else
            $str .= "| <a class=apaging href=\"$links?page=$i&$extra\">$j</a>";
    }

    return $str;
}

function pagelist1($page, $totalrow, $listrow, $links, $extra) {

    $pages = $totalrow / $listrow; //total no of page

    $str = ""; // printing the page

    for ($i = 0; $i < $pages; $i++) {

        $j = $i + 1;

        if ($i == $page) {

            if ($str == "")
                $str = "$j";

            else
                $str .= "| $j";
        }

        else {

            if ($str == "")
                $str = "<a class=apaging href=\"$links?page=$i&$extra\">$j</a> ";

            else
                $str .= "| <a class=apaging href=\"$links?page=$i&$extra\">$j</a>";
        }
    }

    return $str;
}

function display_paging($total_recs, $paging, $page, $func_name="page_list") {

####################admin paging starts ##################

    /*

      echo $total_recs;

      echo "<br>";

      echo $paging;

      echo "<br>";

      echo $page;

      echo "<br>";

     */

    $paging_table = "";

    if ($total_recs > 0) {



        $no_of_page = ceil($total_recs / $paging);

//			print "<span class=content>Page ".($page+1)." of $no_of_page ";

        $paging_table = "<table width=400 border=0 align=right cellpadding=2 cellspacing=0>

                <tr>

                <td class=\"pagingtxt\" align=\"right\"> <br>Paging: ";

        for ($i = 0; $i < $no_of_page; $i++) {

            $j = $i + 1;

            if ($i != $page)
                $paging_table.=" <a href=\"javascript:".$func_name."('$i');\" class=\"apaging\">$j</a> ";

            else
                $paging_table.= $j;

            $paging_table.= " | ";
        }



        $paging_table = substr($paging_table, 0, -2);

        //$paging_table.= "[<font class=content>".$j."</font>]";

        $paging_table.= " </span> </td> </tr>";

        $paging_table.="</table>";
    }

    if (isset($no_of_page) && ($no_of_page <= 1)) {

        $paging_table = "";
    }

    return $paging_table;

#################### paging Ends ##################
}

function user_paging($total_recs, $paging, $page) {

####################admin paging starts ##################

    $paging_table = "";

    if ($total_recs > 0) {



        $no_of_page = ceil($total_recs / $paging);

//			print "<p align=center class=content>Page ".($page+1)." of $no_of_page ";



        for ($i = 0; $i < $no_of_page; $i++) {

            $j = $i + 1;

            if ($j != $page)
                $paging_table.=" <a href=\"javascript:page_list('$j');\" class=\"apaging\">$j</a> ";

            else
                $paging_table.= $j;

            $paging_table.= " | ";
        }

        $paging_table = substr($paging_table, 0, -2);

        $paging_table = "<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">

    <tr>

      <td width=\"50%\" align=\"right\" class=\"pagingtxt\"><div align=\"left\">[Page

          $page of $no_of_page]</div></td>

      <td width=\"50%\" height=\"24\" align=\"right\" class=\"pagingtxt\"> Paging:$paging_table

      </td>

    </tr>

  </table>";



        if (isset($no_of_page) && ($no_of_page <= 1)) {

            $paging_table = "";
        }

        return $paging_table;

#################### paging Ends ##################
    }
}

function getAnyTableWhereData($table, $whereClause) {

    $query = "select * from $table where 1=1 $whereClause";

    $result = mysql_query($query) or die("problem in getAnyTableWhereData" . mysql_error());

    if ($row = mysql_fetch_array($result)) {

        mysql_free_result($result);

        return $row;
    } else {

        return false;
    }
}

function getAnyTableAllData($table, $whereClause) {

    $query = "select * from $table where 1=1 $whereClause";

    $result = mysql_query($query) or die("problem in getAnyTableallData $query" . mysql_error());

    while ($row = mysql_fetch_array($result)) {

        $rows[] = $row;
    }

    return $rows;
}

function my_get_one($query) {

    $res = mysql_query($query);

    if (mysql_num_rows($res) > 0) {

        $row = mysql_fetch_row($res);

        return $row[0];
    }

    else
        return '';
}

function my_get_row($query) {

    $res = mysql_query($query);

    if (mysql_num_rows($res) > 0) {

        $row = mysql_fetch_assoc($res);

        return $row;
    }

    else
        return '';
}

function my_get_all($query) {
    $res = mysql_query($query);
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res))
            $rows[] = $row;
        return $rows;
    }
    else
        return '';
}

function sendMail($to, $subject, $matter, $from, $category='',$header_content='',$cc='') {
	
    $headers = "MIME-Version: 1.0\r\n";

    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

    $headers .= "From:$from \r\n";
	if($cc!='')$headers .= "Cc: $cc" . "\r\n";
	 //$headers .= "Bcc: gautam24into7@gmail.com \r\n";
    if ($category != '')
        $headers.='X-SMTPAPI: {"category": "'.$category.'"}';

    $rows = getAnyTableAllData("jsb_config", " and id<3 order by id asc");
    $matter = $rows[0][2] . $matter . $rows[1][2];
   
  
   
    $matter = str_replace('~~SITE_URL~~', SITE_URL, $matter);
    $matter = str_replace('~~HEADER_CONTENT~~', $header_content, $matter);
	// dump($matter);
//	$to="monalissa1984@gmail.com";
//$to="florin@sendgrid.com";
//dump($to);
//dump($from);

	//die;
    if (mail($to, $subject, $matter, $headers)) {

        return true;
    } else {

        return false;
    }
	
}

//end of the sendMail function

function sendGeneralMail($section, $userid, $user_type, $arr='', $category='') {

    global $mail_table, $counselor_table, $client_table, $admin_login_table, $agency_table;

    $messageRow = getAnyTableWhereData($mail_table, " and section='$section'");

    if ($messageRow) {

        if ($user_type == 0) {

            $to_user = getAnyTableWhereData($counselor_table, " and id='$userid'");

            $email = $to_user['email'];

            $arr['TO_NAME'] = $to_user['name'];

            $arr['EMAIL'] = $to_user['email'];
        } elseif ($user_type == 1) {

            $to_user = getAnyTableWhereData($client_table, " and id='$userid'");

            $email = $to_user['email'];

            if ($to_user['counselor'] != '0') {
                $counselor = getAnyTableWhereData($counselor_table, " and id='$to_user[counselor]'");

                $arr['COACH_NAME'] = $counselor['name'];

                $arr['FROM_NAME'] = "Your Coach <br>" . $counselor['name'];

                $arr['FROM'] = $counselor['email'];
            }
			if ($to_user['agency_id'] != '0' && (isset($_SESSION['sess_agency_id']) && $_SESSION['sess_agency_id']!='')) {
				$to_agency = getAnyTableWhereData($agency_table, " and id='$to_user[agency_id]'");
				 $arr['FROM_NAME'] = $to_agency['title'];				 
       			$from = $arr['FROM'] = $cc=  $to_agency['email_id'];	
				 // $to_agency['title'];				
				 $fromflag=1;				 
			}

            $arr['EMAIL'] = $to_user['email'];

            $arr['TO_NAME'] = $to_user['name'];
        } 
		elseif($user_type=='4')
		{
			$to_user = getAnyTableWhereData("jsb_employer", " and id='$userid'");
            $arr['EMAIL'] =  $email= $to_user['email'];
            $arr['TO_NAME'] =$to_user['contact_name'];
		}
		else {
            $to_user = getAnyTableWhereData($agency_table, " and id='$userid'");

            $arr['TO_NAME'] = $to_user['title'];

            $email = $arr['EMAIL'] = $to_user['email_id'];
        }



        $subject = $messageRow['subject'];

        $message = $messageRow['content'];

        //if(!isset($arr['FROM'])){
		if(!isset($fromflag))
		{
			$from_user = getAnyTableWhereData($admin_login_table, " and id='1'");
	
			$arr['FROM_NAME'] = "The JSB Team<br/>$from_user[first_name] $from_user[last_name]";
	
			$from = $arr['FROM'] = $from_user['email'];
		}
//	}
        $message = str_replace('~~SITE_URL~~', "<a href='" . SITE_URL . "'>" . SITE_URL . "</a>", $message);
        if (isset($arr['FOLLOW_URL']))
            $message = str_replace('~~FOLLOW_URL~~', "<a href='$arr[FOLLOW_URL]'>Click Here</a>", $message);
        if (count($arr) > 0) {

            foreach ($arr as $key => $val)
                $message = eregi_replace("~~" . $key . "~~", $val, $message);
        }

        if (isset($arr['cron']) && $arr['cron'] == 1)
            echo "$email  $section<br>$mailSubject<br>$message<br>$from<br><Br>";

//dump($arr);die;
//if($section=="login_detail" || $section=="client_added")
//$cc="mahaveer.prasad47@gmail.com";
        sendMail($email, $subject, $message, $arr['FROM'], $category,'',$cc);
    }
}

//Mail Function for text email

function sendtextMail($to, $subject, $matter, $from) {

    $headers = "MIME-Version: 1.0\n";

    $headers .= "X-Priority: 3\n";

    $headers .= "X-Mailer: PHP\n";

    $headers .= "X-Sender: $from\n";

    $headers .= "Return-Path: $from\n";

    $headers .= "From: $from\n";

    if (mail("$to", "$subject", "$matter", "$headers", "-f $from")) {

        return true;
    } else {

        return false;
    }
}

function alternate_row($tdrow, $tdClass1, $tdClass2) {

    if (($tdrow % 2) == 0) {

        $tdClass = $tdClass1;
    } else {

        $tdClass = $tdClass2;
    }



    return $tdClass;
}

function create_thumb($path, $size, $save_path) {
	
    if (file_exists($path)) {
		
        $thumb = new my_thumbnail($path); // generate image_file, set filename to resize
        $thumb->size_width(500);  // set width for thumbnail, or
        $thumb->size_height(500);  // set height for thumbnail, or
        $width = $thumb->img["lebar"];
        $height = $thumb->img["tinggi"];
        if ($width > $size || $height > $size) {
            $size = $size;
        } else {
            $size = $width;
        }
		
        $thumb->size_auto($size);  // set the biggest width or height for thumbnail
        $thumb->jpeg_quality(100);  // [OPTIONAL] set quality for jpeg only (0 - 100) (worst - best), default = 75
        $thumb->save($save_path);  // save your thumbnail to file
    } else {
        return false;
    }
}

/* ---------------------------------------------- */

class my_thumbnail {

    var $img;

    function my_thumbnail($imgfile) {

        //
        //detect image format

        $this->img["format"] = ereg_replace(".*\.(.*)$", "\\1", $imgfile);

        $this->img["format"] = strtoupper($this->img["format"]);

        if ($this->img["format"] == "JPG" || $this->img["format"] == "JPEG") {

            //JPEG



            $this->img["format"] = "JPEG";

            $this->img["src"] = ImageCreateFromJPEG($imgfile);
        } elseif ($this->img["format"] == "PNG") {

            //PNG

            $this->img["format"] = "PNG";

            $this->img["src"] = ImageCreateFromPNG($imgfile);
        } elseif ($this->img["format"] == "GIF") {

            //GIF

            $this->img["format"] = "GIF";

            $this->img["src"] = ImageCreateFromGIF($imgfile);
        } elseif ($this->img["format"] == "WBMP") {

            //WBMP

            $this->img["format"] = "WBMP";

            $this->img["src"] = ImageCreateFromWBMP($imgfile);
        } else {

            //DEFAULT

            echo "error|Not Supported File";

            exit();
        }



        @$this->img["lebar"] = imagesx($this->img["src"]);

        @$this->img["tinggi"] = imagesy($this->img["src"]);



        //default quality jpeg

        $this->img["quality"] = 100;
    }

    function size_height($size=100) {

        //height

        $this->img["tinggi_thumb"] = $size;



        @$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"] / $this->img["tinggi"]) * $this->img["lebar"];
    }

    function size_width($size=100) {

        //width

        $this->img["lebar_thumb"] = $size;

        @$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"] / $this->img["lebar"]) * $this->img["tinggi"];
    }

    function size_auto($size=100) {

        //size

        if ($this->img["lebar"] >= $this->img["tinggi"]) {

            $this->img["lebar_thumb"] = $size;

            @$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"] / $this->img["lebar"]) * $this->img["tinggi"];
        } else {

            $this->img["tinggi_thumb"] = $size;

            @$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"] / $this->img["tinggi"]) * $this->img["lebar"];
        }
    }

    function jpeg_quality($quality) {

        //jpeg quality

        $this->img["quality"] = $quality;
    }

    function show() {

        //show thumb

        @Header("Content-Type: image/" . $this->img["format"]);



        /* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function */

        $this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"], $this->img["tinggi_thumb"]);

        imagecopyresampled($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);



        if ($this->img["format"] == "JPG" || $this->img["format"] == "JPEG") {

            //JPEG

            imageJPEG($this->img["des"], "", $this->img["quality"]);
        } elseif ($this->img["format"] == "PNG") {

            //PNG

            imagePNG($this->img["des"]);
        } elseif ($this->img["format"] == "GIF") {

            //GIF

            imageGIF($this->img["des"]);

//			echo "$path";
        } elseif ($this->img["format"] == "WBMP") {

            //WBMP

            imageWBMP($this->img["des"]);
        }
    }

    function save($save="") {

        //save thumb

        if (empty($save))
            $save = strtolower("./thumb." . $this->img["format"]);

        /* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function */

        $this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"], $this->img["tinggi_thumb"]);

        @imagecopyresampled($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);



        if ($this->img["format"] == "JPG" || $this->img["format"] == "JPEG") {

            //JPEG

            imageJPEG($this->img["des"], "$save", $this->img["quality"]);
        } elseif ($this->img["format"] == "PNG") {

            //PNG

            imagePNG($this->img["des"], "$save");
        } elseif ($this->img["format"] == "GIF") {

            //GIF

            imageGIF($this->img["des"], "$save");
        } elseif ($this->img["format"] == "WBMP") {

            //WBMP

            imageWBMP($this->img["des"], "$save");
        }
    }

}

function show_formatted_date($p_date ='') {
    if ($p_date == '0000-00-00 00:00:00' || $p_date == '0000-00-00' || $p_date == '')
        return 'NA';
    else
        return date('M d, Y', strtotime($p_date));
}

function show_formatted_datetime($p_date='') {
    if ($p_date == '0000-00-00 00:00:00' || $p_date == '0000-00-00' || $p_date == '')
        return 'NA';
    else
        return date(' F d, Y h:i A', strtotime($p_date));
}

function userdisplay_paging($total_recs, $paging, $page) {

    $paging_table = "";

    if ($total_recs > 0) {

        $no_of_page = ceil($total_recs / $paging);

        $paging_table = "<table width=400 border=0 align=right cellpadding=2 cellspacing=0><tr><td class=\"pagingtxt\" align=\"right\">";

        for ($i = 0; $i < $no_of_page; $i++) {

            $j = $i + 1;

            if ($i != $page)
                $paging_table.=" <a href=\"javascript:page_list('$i');\" class=\"apaging\">$j</a> ";

            else
                $paging_table.= $j;

            $paging_table.= " | ";
        }

        $paging_table = substr($paging_table, 0, -2);

        $paging_table.= " </td> </tr>";

        $paging_table.="</table>";
    }

    if (isset($no_of_page) && ($no_of_page <= 1)) {

        $paging_table = "";
    }

    return $paging_table;
}

function show_state($Default_state) {

    $STATE_Query = "select * from " . $GLOBALS['states_table'] . " where status=$GLOBALS[GL_active] order by state_name";

    //echo $STATE_Query;

    $STATE_Result = mysql_query($STATE_Query);

    $STATE_String = "";

    while ($STATE_Row = mysql_fetch_array($STATE_Result)) {

        $STATE_String.="<option value='" . $STATE_Row['id'] . "'";



        if ((isset($Default_state)) && ($Default_state != "") && ($Default_state == $STATE_Row['id'])) {

            $STATE_String.=" Selected ";
        }

        $STATE_String.=">" . $STATE_Row['state_name'] . "</option>";
    }

    return $STATE_String;
}

function hiddenFields() {

    $h = "";

    if (!empty($_POST)) {

        reset($_POST);

        while (list($k, $v) = each($_POST)) {

            $h .= "<input type=\"hidden\" name=\"$k\" value=\"$v\">\n";
        }

        echo $h;
    }
}

##### File upload function #####
##Creation Date: 25 July, 2003
##Purpose: Uploading files

function upload_my_file($upload_file, $destination) {



    //move_uploaded_file

    if (move_uploaded_file($upload_file, $destination)) {

        return true;
    } else {

        return false;
    }
}

##### End of File upload function #####
### ============================================================ ###

function monthYearListing_smarty($monthName, $yearName, $month, $year, $startYear, $endYear) {



    $ret = '<select name="' . $monthName . '"><option value="">Month</option>';

    $ct = 0;

    for ($ct = 0; $ct < 12; $ct++) {

        $ret.="<option value='" . ($ct + 1) . "'";

        //if(($ct+1)==date('m'))

        if (($ct + 1) == $month) {

            $ret.=" selected";
        }

        $ret.= ">" . date("M", mktime(0, 0, 0, $ct + 1, 1, 98)) . "</option>";
    }

    $ret.='</select>';



    $ret.=" - ";

    $ret.= '<select name="' . $yearName . '"><option value="">Year</option>';

    $ct = 0;



    if (isset($startYear) && $startYear != "") {
        
    } else {

        $startYear = 1900;
    }



    if (isset($endYear) && $endYear != "") {
        
    } else {

        $endYear = (date('Y') + 20);
    }



    for ($ct = $startYear; $ct <= $endYear; $ct++) {

        $ret.= "<option value='" . ($ct) . "'";

        //if($ct==date('Y'))

        if (trim($ct) == trim($year)) {

            $ret.= " selected";
        }

        $ret.= ">" . $ct . "</option>";
    }

    $ret.= "</select>";

    return $ret;
}

function generatePassword($length=6) {

    $pstr = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    $password = "";

    while (strlen($password) < $length)
        $password.=$pstr[mt_rand(0, strlen($pstr) - 1)];

    return $password;
}

function display_paging_user($total_recs, $paging, $page, $flag=0) {



#################### paging starts ##################

    $paging_table = "";



    if ($total_recs > 0) {



        $next = $page + 1;

        $prev = $page - 1;



        $no_of_page = ceil($total_recs / $paging);

        $paging_table = "

                                  <td height=\"20\" class=\"greytxtnormal\">

                                    <div align=\"right\">";

        if ($flag == 0)
            $paging_table.="[Pages:";

        if ($prev >= 0) {

            $paging_table.="<a href=\"javascript:page_list('$prev');\"><img src=\"" . SITE_URL . "images/pre.jpg\" alt=\"Previous Page\"  border=\"0\" align=\"absmiddle\"></a>";
        }

        if ($flag == 0) {

            for ($i = 0; $i < $no_of_page; $i++) {

                $j = $i + 1;

                if ($i != $page)
                    $paging_table.=" <a href=\"javascript:page_list('$i');\" class=apaging>$j</a> ";

                else
                    $paging_table.= "[<font class=pagingcurrent>" . $j . "</font>] ";
            }
        }





        if ($next < $no_of_page) {

            $paging_table.="<a href=\"javascript:page_list('$next');\"><img src=\"" . SITE_URL . "images/next.jpg\" alt=\"Next Page\"  border=\"0\" align=\"absmiddle\"></a>";
        }

        if ($flag == 0)
            $paging_table.=" ]</div></td><td class=\"greytxtnormal\">

                                    </td>";
    }

    if (isset($no_of_page) && ($no_of_page <= 1)) {

        $paging_table = "<td>&nbsp;</td><td height=\"20\">&nbsp;</td>";
    }

    return $paging_table;

#################### paging Ends ##################
}

function get_one_value($table_name, $field_name, $mid, $id) {

    $sql_one_value = "select $field_name from $table_name where $mid='$id'";

    $rst_one_value = mysql_query($sql_one_value) or die("Problem here: " . mysql_error());

    $result_one_value = mysql_fetch_array($rst_one_value);

    $result1 = $result_one_value[$field_name];

    return $result1;
}

function rand_function($strLength) {

    $RandString = "";



    while (strlen($RandString) < $strLength) {

        $String = rand(47, 123);

        if (($String > 47 and $String < 58) || ($String > 64 and $String < 91) || ($String > 96 and $String < 121)) {

            $RandString.=chr($String);
        }
    }

    return $RandString;
}

function showPAI($client_id) {

    global $card_table;

    $qry1 = "SELECT COUNT( client_id ) FROM " . $card_table . " WHERE client_id = '" . $client_id . "' AND column_status = 'O' AND recycle_bin='0' and expired='0'";

    $rs1 = mysql_query($qry1);

    $row1 = mysql_fetch_array($rs1);

    $P = $row1[0];

    if (empty($P))
        $P = 0;

    $qry2 = "SELECT COUNT( client_id ) FROM " . $card_table . " WHERE client_id = '" . $client_id . "' AND column_status = 'A' AND recycle_bin='0' and expired='0'";

    $rs2 = mysql_query($qry2);

    $row2 = mysql_fetch_array($rs2);

    $A = $row2[0];

    if (empty($A))
        $A = 0;

    $qry3 = "SELECT COUNT( client_id ) FROM " . $card_table . " WHERE client_id = '" . $client_id . "' AND column_status = 'I' AND recycle_bin='0' and expired='0'";

    $rs3 = mysql_query($qry3);

    $row3 = mysql_fetch_array($rs3);

    $I = $row3[0];

    if (empty($I))
        $I = 0;

    return $P . "-" . $A . "-" . $I;
}

function showCardPosCount($client_id, $mov_status='O') {

    global $card_table;

    switch ($mov_status) {

        case 'A':

            $qry = "SELECT COUNT( client_id ) FROM " . $card_table . " WHERE client_id = '" . $client_id . "' AND column_status = 'A' AND recycle_bin='0' and expired='0'";

            break;

        case 'S':

            $qry = "SELECT COUNT( client_id ) FROM " . $card_table . " WHERE client_id = '" . $client_id . "' AND column_status = 'S' AND recycle_bin='0' AND  expired='0'";

            break;

        case 'I':

            $qry = "SELECT COUNT( client_id ) FROM " . $card_table . " WHERE client_id = '" . $client_id . "' AND column_status = 'I' AND recycle_bin='0' AND  expired='0'";

            break;

        case 'V':

            $qry = "SELECT COUNT( client_id ) FROM " . $card_table . " WHERE client_id = '" . $client_id . "' AND column_status = 'V' AND recycle_bin='0' AND  expired='0'";

            break;

        case 'J':

            $qry = "SELECT COUNT( client_id ) FROM " . $card_table . " WHERE client_id = '" . $client_id . "' AND column_status = 'J' AND recycle_bin='0' AND  expired='0'";

            break;

        default:

            $qry = "SELECT COUNT( client_id ) FROM " . $card_table . " WHERE client_id = '" . $client_id . "' AND column_status = 'O' AND recycle_bin='0' AND  expired='0'";

            break;
    }

    $rs = mysql_query($qry);

    $row = mysql_fetch_array($rs);

    return $row[0];
}

function wraptext($text, $len="") {

    $text = nl2br(stripslashes($text));

    //		$text=str_replace(array('<!--', '-->'), array('&lt;!--', '--&gt;'), $text);

    $text = strip_tags($text);

    $words = explode("<br />", $text, 2);



    $text = $words[0];

    if ($len == "") {

        $count_chars = 100;
    } else {

        $count_chars = $len;
    }

    if (strlen($text) > $count_chars) {

        $str_new = substr($text, 0, $count_chars);

        $str_new.="...";

        return $str_new;
    } else {

        return $text;
    }
}

function removeSpecialChar($image_name) {

    $image_name = str_replace(" ", "", $image_name);

    $image_name = str_replace("(", "", $image_name);

    $image_name = str_replace(")", "", $image_name);

    $image_name = str_replace("{", "", $image_name);

    $image_name = str_replace("}", "", $image_name);

    $image_name = str_replace("[", "", $image_name);

    $image_name = str_replace("]", "", $image_name);

    return $image_name;
}

//------------------------------------------------------------------------------------

function getDecode($password) {

    include_once("crypto_class.php");

    $key = getKey();

    $objCrypt = new CRYPTO($key);

    $pass = $objCrypt->decrypt($password);

    return $pass;
}

function setEncode($password) {

    include_once("crypto_class.php");

    $key = getKey();

    $objCrypt = new CRYPTO($key);

    $pass = $objCrypt->encrypt($password);

    return $pass;
}

function VideocreateFlvAndThumb($source, $flv_destination, $thumb_destination, $bit_rate, $default_video_width, $default_video_height) {
    global $demos_image_folder, $video_thumb_width, $video_thumb_height, $ext, $max_video_file_size, $video_bitrate, $video_width, $video_height;
    if ($source != "" && $flv_destination != "") {
        echo exec("ffmpeg -i $source -ar 22050 -ab 32 -f flv -s " . $video_width . "x" . $video_height . " $flv_destination"); //         umask(0000);
        chmod($flv_destination, 0777);
    }
    // creating thumbnails of uploaded movie file
    if ($flv_destination != "" && $thumb_destination != "") {
        $thumb_source = $flv_destination;
        echo exec("ffmpeg -itsoffset -4 -i $thumb_source -vcodec mjpeg -vframes 1 -an -f rawvideo -s " . $video_thumb_width . "x" . $video_thumb_height . " $thumb_destination"); // ffmpeg is installed on the root directory
        umask(0000);
        chmod($thumb_destination, 0777);
    }
}

// end of function

function getHiddenValue() {

    $hflds = "";

    if (!empty($_POST)) {

        reset($_POST);

        $arr = array("lastfld", "hidetime", "msg", "err", "conf");

        while (list($k, $v) = each($_POST)) {

            ${$k} = $v;

            if (is_array($v)) {

                $v = implode(",", $v);

                if (!in_array($k, $arr))
                    $hflds .= '<input type="hidden" name="' . $k . '" value="' . htmlentities(str_replace("&amp;", "&", $v), ENT_QUOTES) . '">';
            }

            else {

                if (!in_array($k, $arr))
                    $hflds .= '<input type="hidden" name="' . $k . '" value="' . htmlentities(str_replace("&amp;", "&", $v), ENT_QUOTES) . '">';
            }
        }
    }

    return $hflds;
}

function removeQuotes($strToChange) {

    if (!get_magic_quotes_gpc()) {

        $strToChange = str_replace("'", "&#039;", $strToChange);

        $strToChange = str_replace("\"", "&quot;", $strToChange);

        $strToChange = str_replace("\\", "&#92;", $strToChange);

        $strToChange = str_replace("&amp;", "&", $strToChange);

        return $strToChange;
    } else {

        $strToChange = str_replace("&acirc;", "&#039;", $strToChange);

        return $strToChange;
    }
}

function dump($arr) {

    echo "<pre>";

    print_r($arr);

    echo "</pre>";
}

function clean($str) {

    return stripslashes($str);
}

function clean_text($str) {

    return nl2br(stripslashes($str));
}

function updateFB() {
    global $client_table, $host, $data_user, $data_pass;
    $profileid = my_get_one("select profile_id from $client_table where id='$_SESSION[user_id]'");
    if ($profileid != '0') {
        $user = getAnyTableWhereData($client_table, " and id='$_SESSION[user_id]'");
        mysql_connect("localhost", "jsb_fb_developer", "jsb_fb_developer123321");
        mysql_select_db("jsb_fb");

        foreach ($user as $key => $col) {
            if ($key != 'id')
                $_POST[$key] = $col;
        }
        editData("fb_profiles", " profile_id ", $profileid);
    }
    $link = mysql_connect($host, $data_user, $data_pass) or die(mysql_error());
    mysql_select_db($db, $link);
}

function checkChallenge($flag=1) {
    global $card_table, $card_detail_table, $client_table;
    if ($_SESSION['user_type'] == "client") {
	$challenge_date=my_get_one("select challenge_date from $client_table where id='$_SESSION[user_id]'");
	if($challenge_date!='0000-00-00'){
		$max=my_get_one("select max(week_id) from jsb_challenge_client where client_id='$_SESSION[user_id]'");
		$sql = "Select CL.challenge_id,date_add('$challenge_date', interval $max-1 week) as start_date,date_add('$challenge_date',interval $max week) as end_date, datediff(curdate(),date_add('$challenge_date',interval $max week)) as diff from jsb_challenge_client CL INNER JOIN jsb_challenge C ON (C.id=CL.challenge_id) where CL.client_id='$_SESSION[user_id]' and CL.status='0' and CL.week_id='$max' and C.c_type='P'";
        $row = my_get_row($sql);
        if (is_array($row) && count($row) > 0 && $row['diff']<=0) {
            $challenge = my_get_row("select * from jsb_challenge where id='$row[challenge_id]'");
            if (!in_array($challenge_id, array(58, 35))) {
                $fields = my_get_all("select * from jsb_challenge_detail where challenge_id='$row[challenge_id]'");
                $q = " and C.client_id='$_SESSION[user_id]'";
                foreach ($fields as $field)
                    if ($field['field_name'] != 'C.type_of_opportunity')
                        $q.=" and $field[field_name]='$field[field_value]'";
                    else
                        $q.=" and $field[field_name] in ($field[field_value])";
                switch ($challenge['id']) {
                    case 9:
                        $date = my_get_one("Select date_add('$row[date_started]', interval 4 day)");
                        $q.=" and CD.start_date<='$date'";
                        break;
                    case 10:
                        $date = my_get_one("Select date_add('$row[date_started]', interval 5 day)");
                        $q.=" and CD.start_date<='$date'";
                        break;
                }

                //echo "select count(C.id) from $card_table 	 C INNER JOIN $card_detail_table CD ON (CD.card_id=C.id) where CD.start_date>='$row[date_started]' $q";
				if($challenge['id']!='57'){
//				echo "select count(C.id) from $card_table 	 C INNER JOIN $card_detail_table CD ON (CD.card_id=C.id) where CD.start_date>='$row[start_date]' and CD.start_date<'$row[end_date]' $q";
                $count = my_get_one("select count(C.id) from $card_table 	 C INNER JOIN $card_detail_table CD ON (CD.card_id=C.id) where CD.start_date>='$row[start_date]' and CD.start_date<'$row[end_date]' $q");
				}
				else
				{
	$query="SELECT count( C.id ) as cd, date_format( CD.start_date, '%Y-%m-%d' ) as daily_date FROM $card_table C INNER JOIN $card_detail_table CD ON ( CD.card_id = C.id ) WHERE CD.start_date >= '$row[start_date]' and CD.end_date<'$row[end_date]' $q
GROUP BY date_format( CD.start_date, '%Y-%m-%d' )";
$rows=my_get_all($query);
if(is_array($rows) && count($rows)>0)
$count=count($rows);
else
$count=0;
//					$query= "select count(C.id) from $card_table C INNER JOIN $card_detail_table CD ON (CD.card_id=C.id) where CD.start_date>='$row[start_date]' $q and start_date in ()";
				}
                if ($count >= $challenge['num']) {
                    $_POST['date_completed'] = date("Y-m-d H:i:s");
                    $sql = "update jsb_challenge_client set date_completed='$_POST[date_completed]',duration=time_to_sec(timediff('$_POST[date_completed]',date_started)),status='1' where client_id='$_SESSION[user_id]' and challenge_id='$row[challenge_id]'";
                    mysql_query($sql) or die(mysql_error());
                    mysql_query("update $client_table set 	total_point=total_point+$challenge[points] where id='$_SESSION[user_id]'");
					if($flag==0)
						return $challenge['id'];
					else
                    echo "<script type='text/javascript'>document.location.href='my-challenge.php?challenge_id=$row[challenge_id]';</script>";
			
                    die;
                }
            }
        }
    }
}
}
function assignChallenge($client_id,$week_id=1,$tot=0) {
global $client_table,$card_table;
    $rows=my_get_all("select id from jsb_challenge where c_repeat='0'");
	$ids="";
	$priority=array(1=>1,2,9,57,10,19,27,29,30,33,35,58,3,4,61);
	$applied=array(19,20,27);
	    $client_a= my_get_one("SELECT COUNT( client_id ) FROM " . $card_table . " WHERE client_id = '$client_id' AND column_status = 'A' AND recycle_bin='0' and expired='0'");
	$interview=array(28,60);
	$client_i=my_get_one("SELECT COUNT( client_id ) FROM " . $card_table . " WHERE client_id = '$client_id' AND column_status = 'I' AND recycle_bin='0' and expired='0'");
	foreach($rows as $row)
		$ids=$row['id'].",";
	$ids=substr($row['id'],0,-1);
	$already=array();
	if($week_id=='1')
	{
		mysql_query("delete from jsb_challenge_client where client_id='$client_id'");
		mysql_query("delete from jsb_challenge_form_response where client_id='$client_id'");
		mysql_query("update $client_table set challenge_date=curdate() where id='$client_id'");
	}
	else
	{
		$already=my_get_one("select group_concat(challenge_id) from jsb_challenge_client where challenge_id in ($ids)");
	}
	$id=$priority[$week_id];
	if($tot==0)
		$tot=my_get_one("select required_point from $client_table where id='$client_id'");

	$point=my_get_one("select points from jsb_challenge where id='$id'");
	$arr[]=$id;
	$tot-=$point;
	$challenges=my_get_all("select * from jsb_challenge where c_type='F' order by rand()");
	foreach($challenges as $challenge)
	{
		if($challenge['points']<=$tot && !in_array($challenge['id'],$already) && !in_array($challenge['id'],$arr) )
		{
			if(($client_i==0 && in_array($challenge['id'],$interview)) || ($client_a=='0' && in_array($challenge['id'],$applied)))
				continue;
			$arr[]=$challenge['id'];
			$tot-=$challenge['points'];
		}
		if($tot==0)
			break;
	}
	$_POST['date_started']=date("Y-m-d H:i:s");
	$_POST['client_id']=$client_id;
	$_POST['week_id']=$week_id;
	$_POST['status']=0;
	foreach($arr as $val)
	{
		if($val!='0'){
		$_POST['challenge_id']=$val;
		insertData("jsb_challenge_client");
		}
	}	

}

function showStep($current,$step)
	{
		$content='<ul class="job_paging">';
		for($i=1;$i<=7;$i++){
			if($i==$current)
				$content.="<li class='active'><a href='javascript://'>$i</a></li>";
			else if($i<=$step)
				$content.="<li><a href='javascript://' onclick=\"displayLightbox('frmBack','profile-step$i.php','div_splash');if (IsCalendarVisible) { hideCalendar();  }\"> $i</a></li>";
			else
				$content.="<li><a href='javascript://'>$i</a></li>";
		}
		//for(;$i<=7;$i++)
			//$content.="<li><a href='javascript://'>$i</a></li>";
        $content.='</ul>';
		return $content;
	}
function findStep($client_id)
{
	global $client_table;	
	$client=my_get_row("SELECT * FROM $client_table where id=".$client_id); 
	
	if($client['job_type']!=0 && $client['job_function']!=0 && $client['tposition']!=0 && $client['dob']!= NULL && $client['gender']!=NULL  && $client['state']!= NULL && $client['city']!=NULL && $client['postalcode']!=NULL && $client['dob']!='' && $client['gender']!='' && $client['state']!='' && $client['city']!='' && $client['postalcode']!='' && $client['highest_education']!=NULL && $client['degree_obtained']!=NULL && $client['highest_education']!='' && $client['degree_obtained']!='' &&  $client['highest_education']!=0 && $client['degree_obtained']!=0  && $client['job_b_criteria']!=NULL && $client['job_b_criteria']!='' && $client['job_a_skills']!=NULL && $client['job_a_skills']!='' && $client['job_a_title']!=NULL && $client['job_a_title']!='' ) 
		$step=7; 	
	else if($client['dob']!= NULL && $client['gender']!=NULL  && $client['state']!= NULL && $client['city']!=NULL && $client['postalcode']!=NULL && $client['dob']!='' && $client['gender']!='' && $client['state']!='' && $client['city']!='' && $client['postalcode']!='' && $client['highest_education']!=NULL && $client['degree_obtained']!=NULL && $client['highest_education']!='' && $client['degree_obtained']!='' &&  $client['highest_education']!=0 && $client['degree_obtained']!=0 && $client['job_b_criteria']!=NULL && $client['job_b_criteria']!='' && $client['job_a_skills']!=NULL && $client['job_a_skills']!='' && $client['job_a_title']!=NULL && $client['job_a_title']!='') 
		$step=6;
	else if($client['highest_education']!=NULL && $client['degree_obtained']!=NULL && $client['highest_education']!='' && $client['degree_obtained']!='' &&  $client['highest_education']!=0 && $client['degree_obtained']!=0 && $client['job_b_criteria']!=NULL && $client['job_b_criteria']!='' && $client['job_a_skills']!=NULL && $client['job_a_skills']!='' && $client['job_a_title']!=NULL && $client['job_a_title']!='') 
		$step=5;
	else if($client['job_b_criteria']!=NULL && $client['job_b_criteria']!=''  && $client['job_a_skills']!=NULL && $client['job_a_skills']!='' && $client['job_a_title']!=NULL && $client['job_a_title']!='' )
		$step=4;
	else if($client['job_a_skills']!=NULL && $client['job_a_skills']!='' && $client['job_a_title']!=NULL && $client['job_a_title']!='')
		$step=3;
	else if($client['job_a_title']!=NULL && $client['job_a_title']!='')
		$step=2; 
	else
		$step=1;
	return $step;
}

function progressPercent($client_id)
{
	global $client_table,$client_files_table;	
	$client=my_get_row("SELECT * FROM $client_table where id=".$client_id); 
	$files=my_get_one("SELECT count(id) FROM $client_files_table where client_id=".$client_id); 
	$step=0;
	if($client['job_a_title']!=NULL && $client['job_a_title']!='')
		$step++;
	if($client['job_a_skills']!=NULL && $client['job_a_skills']!='')
		$step++;
	if($client['job_b_criteria']!=NULL && $client['job_b_criteria']!='')
		$step++;
	 if($client['highest_education']!=NULL && $client['degree_obtained']!=NULL && $client['highest_education']!='' && $client['degree_obtained']!='' &&  $client['highest_education']!=0 && $client['degree_obtained']!=0) 
	 	$step++;
	if($client['dob']!= NULL && $client['gender']!=NULL && $client['gender']!=NULL && $client['state']!= NULL && $client['city']!=NULL && $client['postalcode']!=NULL && $client['dob']!='' && $client['gender']!='' && $client['gender']!='' && $client['state']!='' && $client['city']!='' && $client['postalcode']!='') 
		$step++;
	if($client['job_type']!=0 && $client['job_function']!=0 && $client['tposition']!=0) 
		$step++; 
	if($files>0)
		$step++;
	 $progress=round(($step*100/7),2);	
	return $progress;
}

function progressMeter($client_id)
{
	
	 $progress=progressPercent($client_id);
	$content='<div class="profileProgress"><div style="float: left; width: 125px;">You have completed </div><div class="lineBar">
        <div class="hoverGraph" style="width:'.$progress.'px"></div>
        <div class="lineBarText">'.$progress.'%</div>
    </div>  of your profile.</div> ';
	return $content;
}

function getStScore($client_id){
    global $checklist_table,$card_table,$card_checklist_table;
    $checkbox=my_get_all("select count(*) as count,`column` from $checklist_table group by `column`");$count=0;
    foreach($checkbox as $check){
        $arr[$check['column']]['total_checklist']=$check['count']+$count-1;
        $count+=$check['count']-1;
    }
    $arr['J']['total_checklist']=$arr['J']['total_checklist']+1;
    $num_cards=my_get_all("select count(*) as count, column_status from $card_table where client_id ='$client_id' and expired='0' and recycle_bin='0' and column_status in ('O','A','S','I','V','J') group by column_status ");
    $tot=0;
    foreach($num_cards as $card){
    $arr[$card['column_status']]['total_cards']=$card['count'];    
    $tot+=$card['count'];
    }
  //  $checklist_done=my_get_all("select count(CL.id) as count,C.column_status from $card_table C INNER JOIN $card_checklist_table CL ON (C.id=CL.card_id) INNER JOIN $checklist_table CH ON (CL.checklist_id=CH.id) where C.client_id='$client_id' and C.expired='0' and C.recycle_bin='0' group by C.id order by field(CH.column,'O','A','S','I','V','J')");
    $count=my_get_one("select count(CL.id) as count from $card_table C INNER JOIN $card_checklist_table CL ON (C.id=CL.card_id) where C.client_id='$client_id' and C.expired='0' and C.recycle_bin='0' and CL.status='1'");
    /*foreach($checklist_done as $checklist)
       $arr[$checklist['column_status']]['checked']+=$checklist['count'];
    */
    
    /*$score=number_format(((
           (($arr['O']['checked']*$arr['O']['total_cards'])/($arr['O']['total_checklist']*$arr['O']['total_cards']))+ 
           (($arr['A']['checked']*$arr['A']['total_cards'])/($arr['A']['total_checklist']*$arr['A']['total_cards']))+
           (($arr['S']['checked']*$arr['S']['total_cards'])/($arr['S']['total_checklist']*$arr['S']['total_cards']))+
           (($arr['I']['checked']*$arr['I']['total_cards'])/($arr['I']['total_checklist']*$arr['I']['total_cards']))+ 
           (($arr['V']['checked']*$arr['V']['total_cards'])/($arr['V']['total_checklist']*$arr['V']['total_cards']))+
           (($arr['J']['checked']*$arr['J']['total_cards'])/($arr['J']['total_checklist']*$arr['J']['total_cards']))))*100/
           ($tot),2);
     */
    $score=number_format((($count*100)/
            (
                ($arr['O']['total_checklist']*$arr['O']['total_cards'])+
                ($arr['A']['total_checklist']*$arr['A']['total_cards'])+
                ($arr['I']['total_checklist']*$arr['I']['total_cards'])+
                ($arr['S']['total_checklist']*$arr['S']['total_cards'])+($arr['V']['total_checklist']*$arr['V']['total_cards'])+($arr['J']['total_checklist']*$arr['J']['total_cards']))),2);
    return $score;
}
function showMessage($id="err"){
 if($_SESSION['msg']!='')
 {
     echo "<script type='text/javascript'>showMsg(\"$_SESSION[msg]\",'$id');</script>";
     $_SESSION['msg']="";    
 }
  
}
function Location($url){
    header("Location: $url");
    die;
}
function PostValues($hflds,$url)
{
    $str = "<html><body>";
    $str.='<form name="f1" action="'.$url.'" method="post">';
    $str.=$hflds;
    $str.='</form>';
    $str.='<script language="javascript" type="text/javascript">document.f1.submit();</script>';
    $str.='</body></html>';
    echo $str;

}
function rrmdir($dir) { 
  foreach(glob($dir . '/*') as $file) { 
    if(is_dir($file)) rrmdir($file); else unlink($file); 
  } rmdir($dir); 
}
