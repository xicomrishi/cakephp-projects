<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?></li>
        <li><a href="javascript://" onclick="show_import_user();">Import Users</a></li>
        <li><?php echo $this->Html->link('Export Users',array('controller'=>'users','action'=>'export'));?></li>
	</ul>
</div>

<div class="users index">
	<h2><?php echo __('Users');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th align="left"><?php echo $this->Paginator->sort('id','S.No.');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('first_name');?></th>
			<th><?php echo $this->Paginator->sort('last_name');?></th>
            <th><?php echo $this->Paginator->sort('points');?></th>
			<th><?php echo $this->Paginator->sort('user_role_name','Role');?></th>
			<th><?php echo $this->Paginator->sort('user_status','Status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	
	$i = 0;
	foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr <?php echo $class;?>>
		<td><?php echo $user['User']['id']; ?></td>
		<td><?php echo $user['User']['email']; ?></td>
		<td><?php echo $user['User']['first_name']; ?></td>
		<td><?php echo $user['User']['last_name']; ?></td>
        <td><?php echo $user['User']['points']; ?></td>
		<td><?php echo $user['UserRole']['user_role_name']; ?></td>
		<td><?php echo $user['User']['user_status']; ?></td>
		
		<td class="actions">
			<?php //echo $this->Html->link(__('View', true), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
            <?php echo $this->Html->link(__('View Order', true), array('controller' =>'orders','action' => 'index', $user['User']['id'])); ?>
            <?php echo $this->Html->link(__('Reports', true), array('controller' =>'users','action' => 'report', $user['User']['id'])); ?>

				
		</td>
		</tr>				
<?php endforeach; ?>
	</table>
	
	<div id="user_details_container"></div>
	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 	 |	<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>

<script type="text/javascript">
function show_import_user()
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '450',
				'type'				: 'ajax',
				'height'            : '300',
				'href'          	: site_url+'/users/show_import_user/'
			}
		);		
}
</script>
