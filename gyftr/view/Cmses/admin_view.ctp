<div class="cmses view">
<h2><?php  echo __('Pages'); ?></h2>
	<dl>
		<dt><?php echo __('page_id'); ?></dt>
		<dd>
			<?php echo h($cmse['Cmse']['page_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Page Title'); ?></dt>
		<dd>
			<?php echo h($cmse['Cmse']['page_title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Page Slug'); ?></dt>
		<dd>
			<?php echo h($cmse['Cmse']['page_slug']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Page Sub Title'); ?></dt>
		<dd>
			<?php echo h($cmse['Cmse']['page_sub_title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Page Content'); ?></dt>
		<dd>
			<?php echo h($cmse['Cmse']['page_content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Page Added Date'); ?></dt>
		<dd>
			<?php echo h($cmse['Cmse']['page_added_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Page Modified Date'); ?></dt>
		<dd>
			<?php echo h($cmse['Cmse']['page_modified_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Page'), array('action' => 'edit', $cmse['Cmse']['page_id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Page'), array('action' => 'delete', $cmse['Cmse']['page_id']), null, __('Are you sure you want to delete # %s?', $cmse['Cmse']['page_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Pages'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Page'), array('action' => 'add')); ?> </li>
	</ul>
</div>
