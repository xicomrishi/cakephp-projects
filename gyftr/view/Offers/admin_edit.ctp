<div class="offers form">
<?php echo $this->Form->create('Offer'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Offer'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('gift_brand_id');
		echo $this->Form->input('brand_product_id');
		echo $this->Form->input('title');
		echo $this->Form->input('discount_type');
		echo $this->Form->input('value');
		echo $this->Form->input('start_date');
		echo $this->Form->input('end_date');
		echo $this->Form->input('image');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Offer.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Offer.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Offers'), array('action' => 'index')); ?></li>
	</ul>
</div>
