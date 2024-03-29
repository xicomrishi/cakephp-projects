<div class="offers index">
	<h2><?php echo __('Offers'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>			
			<th><?php echo $this->Paginator->sort('image'); ?></th>
            <th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('discount_type'); ?></th>
			<th><?php echo $this->Paginator->sort('value'); ?></th>
			<th><?php echo $this->Paginator->sort('start_date'); ?></th>
			<th><?php echo $this->Paginator->sort('end_date'); ?></th>	
			
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($offers as $offer): ?>
	<tr>
		<td><?php echo h($offer['Offer']['id']); ?>&nbsp;</td>		
		<td><img src="<?php echo $this->webroot; ?>files/Offers/<?php echo $offer['Offer']['image']; ?>" height="80" width="80"></td>
        <td><?php echo h($offer['Offer']['title']); ?>&nbsp;</td>
		<td><?php echo h($offer['Offer']['discount_type']); ?>&nbsp;</td>
		<td><?php echo h($offer['Offer']['value']); ?>&nbsp;</td>
		<td><?php echo h($offer['Offer']['start_date']); ?>&nbsp;</td>
		<td><?php echo h($offer['Offer']['end_date']); ?>&nbsp;</td>		
		<td class="actions">
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $offer['Offer']['id']), null, __('Are you sure you want to delete # %s?', $offer['Offer']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('Create New Offer'), array('action' => 'add')); ?></li>
	</ul>
</div>
<?php echo $this->Js->writeBuffer();?>