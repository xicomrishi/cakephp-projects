


<div class="prof form">
<?php echo $this->Form->create('User',array('type'=>'file','autocomplete'=>'off'));?>
<fieldset>
<legend><?php echo __('Change Password'); ?></legend>

<?php
		
		echo $this->Form->input('password', array('label'=>'Enter Old Password'));
		echo $this->Form->input('new_password', array('label'=>'Enter New Password','type'=>'password'));
		echo $this->Form->input('confirm_password', array('label'=>'Enter Confirm Password','type'=>'password'));	
?>



</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
