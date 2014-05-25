<div class="service_type form">
<?php echo $this->Form->create('ServiceType'); ?>
	<fieldset>
		<legend><?php echo __('Edit Service Type / Category'); ?></legend>
	<?php
		echo $this->Form->input('service_type');
		echo $this->Form->input('service_status', array('options'=>array('Active'=>'Active','Inactive'=>'Inactive')));
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Service Type / Category'), array('action' => 'list_service_type')); ?></li>
    </ul>
</div>
