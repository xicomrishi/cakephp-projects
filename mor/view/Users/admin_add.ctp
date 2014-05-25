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
	<?php
		$roles=array();
		if(isset($Roles)){
			foreach($Roles as $Rolesx){
				$roles[$Rolesx['UserRole']['user_role_id']]=$Rolesx['UserRole']['user_role_name'];
			}
		}
		echo $this->Form->input('user_role_id', array('label'=>'User Type','options'=>$roles,'style'=>'width:200px'));
		echo $this->Form->input('email', array('label'=>'Email'));
		echo $this->Form->input('password', array('label'=>'Password'));
		echo $this->Form->input('name', array('label'=>'Name'));	
		echo $this->Form->input('user_status', array('options'=>array('Active'=>'Active','Inactive'=>'Inactive')));
		
	?>
	</div>
	<div class="right_sec">
	<?php
		
		echo $this->Form->input('phone');
		echo $this->Form->input('address');
		echo $this->Form->input('city');
		echo $this->Form->input('state');	

		$country=array(0=>'');
		if(isset($Country)){
			foreach($Country as $Countryx){
				$country[$Countryx['Country']['country_id']]=$Countryx['Country']['country_name'];
			}
		}
		echo $this->Form->input('country_id',array('options'=>$country,'style'=>'width:200px'));
		
		
		echo $this->Form->input('zip_code');
		echo $this->Form->input('user_id');?>

	</div>
<?php echo $this->Form->input('user_description');	?>
</fieldset>
<?php echo $this->Form->end(__('Save', true));?>
</div>