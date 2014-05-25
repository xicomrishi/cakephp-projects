<div class="contents view">
<h2><?php App::uses('Sanitize','Utility');   echo __('Pages'); ?></h2>
	<dl>
		<dt><?php echo __('page_id'); ?></dt>
		<dd>:&nbsp;
			<?php echo h($content['Content']['page_id']); ?>
			
		</dd>
		<dt><?php echo __('Page Title'); ?></dt>
		<dd>:&nbsp;
			<?php echo h($content['Content']['page_title']); ?>
		
		</dd>
		<dt><?php echo __('Page Slug'); ?></dt>
		<dd>:&nbsp;
			<?php echo h($content['Content']['page_slug']); ?>
		
		</dd>
		<dt><?php echo __('Page Sub Title'); ?></dt>
		<dd>:&nbsp;
			<?php echo h($content['Content']['page_sub_title']); ?>
		
		</dd>
		<dt><?php echo __('Page Content'); ?></dt>
		<dd>:&nbsp;
			<?php echo html_entity_decode($content['Content']['page_content']); ?>
		
		</dd>
		
		<dt><?php echo __('Page Status'); ?></dt>
		<dd>:&nbsp;
			<?php echo h($content['Content']['status']); ?>
		
		</dd>
		
		<dt><?php echo __('Page Added Date'); ?></dt>
		<dd>:&nbsp;
			<?php echo h($content['Content']['page_added_date']); ?>
		
		</dd>
		<dt><?php echo __('Page Modified Date'); ?></dt>
		<dd>:&nbsp;
			<?php echo h($content['Content']['page_modified_date']); ?>
		
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Page'), array('action' => 'edit', $content['Content']['page_id'])); ?> </li>
		<!--<li><?php echo $this->Form->postLink(__('Delete Page'), array('action' => 'delete', $content['Content']['page_title']), null, __('Are you sure you want to delete?')); ?> </li> -->
		<li><?php echo $this->Html->link(__('List Pages'), array('action' => 'index')); ?> </li>
		<!-- <li><?php echo $this->Html->link(__('New Page'), array('action' => 'add')); ?> </li> -->
	</ul>
</div>
