<div class="games index">
	<h2><?php echo __('Service Type / Category'); ?></h2>
<?php if($ServiceTypes){  ?>
<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.No.</th>
			<th><?php echo $this->Paginator->sort('ServiceType.service_type','Service Type'); ?></th>
			<th><?php echo $this->Paginator->sort('ServiceType.service_status','Status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
    <?php
	
	$i = 0;
	$j=($this->Paginator->current('ServiceType')-1)*$this->params['paging']['ServiceType']['limit']+1;
	foreach ($ServiceTypes as $category):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}?>	
		<tr <?php echo $class;?>>
		<td><?php echo $j;$j++; ?></td>
      	<td><?php echo $category['ServiceType']['service_type']; ?></td>
		<td><?php echo $category['ServiceType']['service_status']; ?></td>
        <td class="actions">
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit_service_type', $category['ServiceType']['service_type_id'])); ?>
			<?php echo $this->Form->postLink(__('Delete', true), array('action' => 'delete_service_type', $category['ServiceType']['service_type_id']), null, sprintf(__('Are you sure you want to delete?', true))); ?>
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
	<?php }else{?>
		<span>No Record(s) Found.</span>
	<?php }?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Add Service Type / Category'), array('action' => 'add_service_type')); ?></li>
        <li><?php echo $this->Html->link(__('Batck to Coupon List'), array('action' => 'list_coupon')); ?></li>
	</ul>
</div>
