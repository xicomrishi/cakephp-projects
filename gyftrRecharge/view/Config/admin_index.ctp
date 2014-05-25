<div class="users form">
<?php echo $this->Form->create('Config',array('type'=>'file'));?>
	<fieldset>
		<legend><?php echo __('Configuration'); ?></legend>
	
    


<?php
		
		$vouchers = array('400' => '400');
		echo $this->Form->input('voucher_value',array('options'=>$vouchers,'label'=>'Select Voucher'));
		
?>
    <div class="input">
    <label>Current Value: </label>&nbsp;&nbsp;<strong><?php echo $data['Config']['display_value']; ?></strong></div>
<?php		
		echo $this->Form->input('display_value', array('label'=>'Usable Value'));		
?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>

</div>
