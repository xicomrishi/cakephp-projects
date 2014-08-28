<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<div class="users index">
	<h2><?php echo __('Users');?></h2>
	<?php if(isset($Users)){?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('user_role_id');?></th>
			<th><?php echo $this->Paginator->sort('user_status');?></th>
			<th><?php echo $this->Paginator->sort('last_login_ip');?></th>
			<th><?php echo $this->Paginator->sort('last_login_date');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	
	$i = 0;
	foreach ($Users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $user['User']['name']; ?></td>
		<td><?php echo $user['User']['email']; ?></td>
		<td><?php echo $user['UserRole']['user_role_name']; ?></td>
		<td><?php echo $user['User']['user_status']; ?></td>
		<td><?php echo $user['User']['last_login_ip']; ?></td>
		<td><?php echo $user['User']['last_login_date']; ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $user['User']['user_id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $user['User']['user_id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $user['User']['user_id']), null, sprintf(__('Are you sure you want to delete?', true))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled prev'));?>
	 <?php echo $this->Paginator->numbers();?>
 	 <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled next'));?>
	</div>
	<?php }else{?>
	<div class="record_not_found error">Records not found.</div>
	<?php }?>
</div>
