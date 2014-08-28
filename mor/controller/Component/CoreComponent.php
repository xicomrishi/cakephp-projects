<?php
class CoreComponent extends Component  {

	function __construct($collection, $settings){
		$this->Controller = $collection->getController();
	}

	function generatePassword ($length = 10){ 
        // inicializa variables 
        $password = ""; 
        $i = 0; 
        $possible = "0123456789abcdefghijklmnopqrstuvwxyz[]*()=_-+#@!";  
         
        // agrega random 
        while ($i < $length){ 
            $char = substr($possible, mt_rand(0, strlen($possible)-1), 1); 
             
            if (!strstr($password, $char)) {  
                $password .= $char; 
                $i++; 
            } 
        } 
        return $password; 
    } 
    
   
	
}
