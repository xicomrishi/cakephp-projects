<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index'));?></li>
	</ul>
</div>


<div class="users form">
<?php echo $this->Form->create('User',array('type'=>'file'));?>
<fieldset>
<legend><?php echo __('Add User'); ?></legend>
<div class="left_sec">
<h4><label>Login Info:</label></h4>
<?php
		$roles=array();
		if(isset($Roles)){
			foreach($Roles as $Rolesx){
				$roles[$Rolesx['UserRole']['id']]=$Rolesx['UserRole']['role_name'];
			}
		}
		echo $this->Form->input('user_role_id', array('label'=>'User Type','options'=>$roles));
		echo $this->Form->input('email', array('label'=>'Email'));
		echo $this->Form->input('password', array('label'=>'Password'));
		echo $this->Form->input('first_name', array('label'=>'First Name'));
		echo $this->Form->input('last_name', array('label'=>'Last Name'));	
		echo $this->Form->input('status', array('options'=>array('Active'=>'Active','Inactive'=>'Inactive')));
		
?>
</div>
<div class="right_sec">
<h4><label>Contact Info:</label></h4>
<?php
		
		echo $this->Form->input('address');
		echo $this->Form->input('phone');
		echo $this->Form->input('city');
		echo $this->Form->input('country');
		echo $this->Form->input('state');
		echo $this->Form->input('zip');
		echo $this->Form->input('id');?>

</div>
<?php echo $this->Form->input('description',array('type' => 'textarea','style="resize:none"'));	?>
</fieldset>
<?php echo $this->Form->end(__('Save', true));?>
</div>
