<?php
class EmailTemplate extends AdminAppModel 
{
	public $useTable = 'email_templates';
	
	/**
	 * Name : generate_identifier
	 * Created : 18 Nov 2013
	 * Purpose : To generate unique key for the email templates
	 * Author : Prakhar Johri
	 */
	function generate_identifier($template_name)
	{
		$total_records = $this->find('count',array('conditions'=>array('name'=>$template_name)));
		if($total_records)
		{
			$new_template_name = str_replace(" ","_",$template_name);
			$new_template_name .= $total_records;
		}
		else
		{
			$new_template_name = str_replace(" ","_",$template_name);
		}
		
		return $new_template_name;
	} 
}
