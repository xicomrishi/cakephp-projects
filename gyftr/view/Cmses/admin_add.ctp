<div class="cmses form">
<?php echo $this->Form->create('Cmse'); ?>
	<fieldset>
		<legend><?php echo __('Add Page'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Pages'), array('action' => 'index')); ?></li>
	</ul>
</div>
