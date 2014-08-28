<?php
require_once '../../src/Google_Client.php';

$client = new Google_Client();
$client->setApplicationName('Google Contacts PHP Sample');
$client->setScopes("http://www.google.com/m8/feeds/");
// Documentation: http://code.google.com/apis/gdata/docs/2.0/basics.html
// Visit https://code.google.com/apis/console?api=contacts to generate your
// oauth2_client_id, oauth2_client_secret, and register your oauth2_redirect_uri.
 $client_id = '1078072336097-3nacqe71i4evup59lug81fek83pqcq1g.apps.googleusercontent.com';
 $client_secret = '4vv8xi4cRU0GaK4ltarKG9Hi';
 $redirect_uri = 'http://localhost/google-api-php-client/examples/contacts/simple.php';

 $client->setClientId($client_id);
 $client->setClientSecret($client_secret);
 $client->setRedirectUri($redirect_uri);
 $client->setDeveloperKey('AIzaSyB4TJVnTFFO-CdkMT5LaqUY6YnABmiCcR0');

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
 $client->setAccessToken($_SESSION['token']);
}

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['token']);
  $client->revokeToken();
}

if ($client->getAccessToken()) {
	$token = json_decode($client->getAccessToken());
						 
						 
 	$auth_pass = $token->access_token;
	


	//Get Email of User ------------------------------------
	// You are now logged in
	// We need the users email address for later use. We can get that here.
	$emails = array();
	
	$req = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/default/full");
    //$req->setRequestHeaders(array('GData-Version'=> '3.0','content-type'=>'application/atom+xml; charset=UTF-8; type=feed'));
	
	$val = $client->getIo()->authenticatedRequest($req);

	  // The contacts api only returns XML responses.
	$xml = new \SimpleXMLElement($val->getResponseBody());
        $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
        $result = $xml->xpath('//gd:email');
		$ff = $xml->xpath('//gd:title');
 
 pr($xml);
        foreach($result as $title)
        {
                $emails[] = $title->attributes()->address;
        }
        pr($emails);
	unset($xml); // clean-up

  // The access token may have been updated lazily.
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $auth = $client->createAuthUrl();
}

if (isset($auth)) {
    print "<a class=login href='$auth'>Connect Me!</a>";
  } else {
    print "<a class=logout href='?logout'>Logout</a>";
}
