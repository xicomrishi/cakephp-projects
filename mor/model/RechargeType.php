<?php
class RechargeType extends AppModel {
	public $name = 'RechargeType';
	public $useTable = 'recharge_types';
	
	public $validate = array(		
		'service_charge' => array(
			'numeric'=>array(
				'rule' => array('numeric'),
				'message' => "Please enter a valid monetary number",
				'required'=>false
			)
		));
		
		
	function formatRechargeType($arrData){
		$arrAllData=array();
		if(!empty($arrData)){
			foreach($arrData as $row){
				$arrAllData[$row['RechargeType']['id']]=$row['RechargeType']['recharge_type'];
			}
		}
		return $arrAllData;
	}
	
}
