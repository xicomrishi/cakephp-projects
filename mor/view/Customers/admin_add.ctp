<div class="actions">
	<h3><?php  echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Customers', true), array('action' => 'index'));?></li>
	</ul>
</div>


<div class="customers form">
<?php echo $this->Form->create('Customer',array('type'=>'file'));?>
<fieldset>
<legend><?php echo __('Add Customer'); ?></legend>
	<div class="left_sec">
	<?php
		echo $this->Form->input('email', array('label'=>'Email'));
		echo $this->Form->input('password', array('label'=>'Password'));
		echo $this->Form->input('name', array('label'=>'Name'));
	
		echo $this->Form->input('phone');
		echo $this->Form->input('customer_status', array('label'=>'Status','options'=>array('Active'=>'Active','Inactive'=>'Inactive')));
		
	?></div>
	
	<div class="right_sec">
	<?php 
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
		echo $this->Form->input('customer_id');?>
	</div>
</fieldset>
<?php echo $this->Form->end(__('Save', true));?>
</div>