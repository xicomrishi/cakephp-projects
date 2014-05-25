<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User', true), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?> </li>
	</ul>
</div>

<div class="users view">
	<h2><?php echo __('User');?></h2>
	<dl>
		<dt>User Id: </dt><dd><?php echo $user['User']['id']; ?></dd>
		<dt>Email: </dt><dd><?php echo $user['User']['email']; ?></dd>		
		
		<dt>First Name: </dt><dd><?php echo $user['User']['first_name']; ?></dd>
		<dt>Last Name: </dt><dd><?php echo $user['User']['last_name']; ?></dd>
		<dt>Role: </dt><dd><?php echo $user['UserRole']['user_role_name']; ?></dd>
		<dt>Status: </dt><dd><?php echo $user['User']['user_status']; ?></dd>
	</dl>
</div>

