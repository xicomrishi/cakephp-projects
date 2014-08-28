<?php  
class FlashHelper extends AppHelper 
{ 
  var $helpers = array( 'Session' ); 
  
  function show() 
  { 
    // Get the messages from the session 
    $messages = $this->Session->read( 'messages' ); 
    $html = ''; 
     
    // Add a div for each message using the type as the class 
    if(!empty($messages))
    {
		foreach ($messages as $type => $msgs) 
		{ 
		  $html .="<div class='$type'>";
		  foreach ($msgs as $msg) 
		  { 
			if (!empty($msg)) { 
			 $html .= "<p>$msg</p>"; 
			}         
		  } 
		  $html .= "</div>"; 
		} 
		
	}  
     
    // Clear the messages array from the session 
    $this->Session->del( 'messages' );
         
    return $this->output( $html ); 
  } 
   
} 
?>
