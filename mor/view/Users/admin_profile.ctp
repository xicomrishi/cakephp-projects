<div class="actions">
	<h3><?php echo __('Profile'); ?></h3>
</div>

<div class="users form">
<?php echo $this->Form->create('User');?>
<fieldset>
<legend><?php echo __('Edit Profile'); ?></legend>

<div class="left_sec">
<h3>Login Info:</h3>
<?php
		echo $this->Form->input('email',array('disabled'=>'disabled'));
		echo $this->Form->input('password',array('label'=>'New Password','autocomplete'=>'off'));
		echo $this->Form->input('name');
		//echo $this->Form->input('user_status', array('options'=>array('Active'=>'Active','Inactive'=>'Inactive')));
		echo $this->Form->input('phone');	
		
	?>
	</div>
<div class="right_sec">
<h3>Contact Info:</h3>
<?php
		echo $this->Form->input('address');
		echo $this->Form->input('city');		
		echo $this->Form->input('state');	
		
		$country=array();
		if(isset($Country)){
			foreach($Country as $Countryx){
				$country[$Countryx['Country']['country_id']]=$Countryx['Country']['country_name'];
			}
		}
		echo $this->Form->input('country_id',array('options'=>$country,'selected'=>$this->Form->value("country_id"),
		'style'=>'width:200px'));		
		
		echo $this->Form->input('zip_code');
		echo $this->Form->input('user_id',array('type'=>'hidden'));?>

</div>
		
	<?php echo $this->Form->input('user_description',array('style'=>'width:185px'));?>


</fieldset>
<?php echo $this->Form->end(__('Save', true));?>
</div>