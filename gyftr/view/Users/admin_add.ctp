<?php 
//App::import('Component', 'DataComponent');
//$dataComponent = new DataComponent();
?>
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
	

<?php
		echo $this->Form->input('email', array('label'=>'Email'));
		echo $this->Form->input('password', array('label'=>'Password'));
		
		echo $this->Form->input('first_name', array('label'=>'First Name'));
		echo $this->Form->input('last_name', array('label'=>'Last Name'));
		echo $this->Form->input('user_status',array('options'=>array('Active'=>'Active','Inactive'=>'Inactive')));
		echo $this->Form->input('user_role_id',array('options'=>$userRoles));
		
?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>

</div>
