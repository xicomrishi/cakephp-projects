<?php
App::uses('String', 'Utility');
?>
<div class="cmses index">
	<h2><?php echo __('Pages'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('page_id'); ?></th>
			<th><?php echo $this->Paginator->sort('page_title'); ?></th>
			<th><?php echo $this->Paginator->sort('page_slug'); ?></th>
			<th><?php echo $this->Paginator->sort('page_content'); ?></th>
		    <th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($cmses as $cmse): ?>
	<tr>
		<td><?php echo h($cmse['Cmse']['page_id']); ?>&nbsp;</td>
		<td><?php echo h($cmse['Cmse']['page_title']); ?>&nbsp;</td>
		<td><?php echo h($cmse['Cmse']['page_slug']); ?>&nbsp;</td>
		<td><?php echo wordwrap(substr($cmse['Cmse']['page_content'],0,100),30,'<br/>',true);?>&nbsp;</td>
	 <td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $cmse['Cmse']['page_id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cmse['Cmse']['page_id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $cmse['Cmse']['page_id']), null, __('Are you sure you want to delete # %s?', $cmse['Cmse']['page_id'])); ?>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Page'), array('action' => 'add')); ?></li>
	</ul>
</div>
