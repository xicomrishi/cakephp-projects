<?php
App::uses('String', 'Utility');
?>
<div class="contents full-width">
	<h2><?php echo __('Pages'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('page_title'); ?></th>
			<th><?php echo $this->Paginator->sort('page_slug'); ?></th>
			<th width="50%"><?php echo $this->Paginator->sort('page_content'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
		    <th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($contents as $content): ?>
	<tr>
		<td><?php echo h($content['Content']['page_title']); ?>&nbsp;</td>
		<td><?php echo h($content['Content']['page_slug']); ?>&nbsp;</td>
		<td><?php echo String::truncate(strip_tags($content['Content']['page_content']),200,array('ellipsis' => '...','exact' => true,'html' => false));?>&nbsp;</td>
		<td><?php echo h($content['Content']['status']); ?>&nbsp;</td>
	 <td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $content['Content']['page_id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $content['Content']['page_id'])); ?>
			<!--<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $content['Content']['page_id']), null, __('Are you sure you want to delete?')); ?>-->
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<!--
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Page'), array('action' => 'add')); ?></li>
	</ul>
</div>
  -->
