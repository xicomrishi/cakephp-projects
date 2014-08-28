<div class="cmses form">
<?php echo $this->Form->create('Cmse'); ?>
	<fieldset>
		<legend><?php echo __('Edit Page'); ?></legend>
	<?php
		echo $this->Form->input('page_id');
		echo $this->Form->input('page_title');
		echo $this->Form->input('page_slug');
		echo $this->Form->input('page_sub_title');
		echo $this->Form->input('page_content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Cmse.page_id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Cmse.page_id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Pages'), array('action' => 'index')); ?></li>
	</ul>
</div>
