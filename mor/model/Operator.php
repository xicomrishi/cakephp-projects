<?php
App::uses('AppModel', 'Model');

class Operator extends AppModel {

	var $name = 'Operator';
	public $useTable = 'operators';
	
	
	/* public $hasMany = array(  
            'BetStaticOption' => array(  
                'className' => 'BetStaticOption',  
                'foreignKey' => 'bet_type_id'  
        ));
	     
     public $validate=array('bet_name' => array(
			'required' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter bet name.'				
			)
		),
		'game_types' => array(
			'required' => array(
				'rule' => array('notempty'),
				'message' => 'Please select at least on game associated with this.'				
			)
		)
		);
		*/
		
	function formatOperator($arrData){
		$arrAllData=array();
		if(!empty($arrData)){
			foreach($arrData as $row){
				$arrAllData[$row['Operator']['id']]=$row['Operator']['name'].' '.$this->get_type($row['Operator']['type']);
			}
		}
		return $arrAllData;
	}
	
	function get_type($type=null){
		switch($type){
			case 1: $type='Prepaid'; break;
			case 2: $type='DTH'; break;	
			case 3: $type='Data Card'; break;	
			case 4: $type='Postpaid'; break;	
			case 5: $type='Landline'; break;	
			case 6: $type='Electricity'; break;
			case 7: $type='Gas'; break;
			case 8: $type='Life Insurance'; break;	
		}
		return $type;	
	}	
	
  
}
