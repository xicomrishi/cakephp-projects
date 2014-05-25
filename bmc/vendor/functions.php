<?php 
function show_formatted_date($p_date ='') {
    if ($p_date == '0000-00-00 00:00:00' || $p_date == '0000-00-00' || $p_date == '')
        return 'NA';
    else
        return date('d F Y', strtotime($p_date));
}

function show_formatted_datetime($p_date='') {
    if ($p_date == '0000-00-00 00:00:00' || $p_date == '0000-00-00' || $p_date == '')
        return 'NA';
    else
        return date(' F d, Y h:i A', strtotime($p_date));
}

function random_password($length = 8)
{
    $password = "";
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
    $maxlength = strlen($possible);
    if ($length > $maxlength) {
            $length = $maxlength;
	}
    $i = 0;
    while ($i < $length) {
    $char = substr($possible, mt_rand(0, $maxlength-1), 1);
    if (!strstr($password, $char)) {
  
            $password .= $char;            
            $i++;
	}
}
return $password;
}

   
function encrypt($string, $key) {
    $result = '';
    for($i = 0; $i < strlen($string); $i++) {
    	$char = substr($string, $i, 1);
    	$keychar = substr($key, ($i % strlen($key))-1, 1);
    	$char = chr(ord($char) + ord($keychar));
    	$result .= $char;
    }
    return base64_encode($result);
}

function decrypt($string, $key) {
    $result = '';
    $string = base64_decode($string);

    for($i = 0; $i < strlen($string); $i++) {
    	$char = substr($string, $i, 1);
    	$keychar = substr($key, ($i % strlen($key))-1, 1);
    	$char = chr(ord($char) - ord($keychar));
    	$result .= $char;
    }
    return $result;
}


?>