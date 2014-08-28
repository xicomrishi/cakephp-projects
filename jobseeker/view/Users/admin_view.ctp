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
	<table style="width:400px" cellpadding="0" cellspacing="0">
	
		<tr><td colspan="2">Personal Details</td></tr>
		<tr><td>User Id</td><td><?php echo $user['User']['id']; ?></td></tr>
		<tr><td>Email</td><td><?php echo $user['User']['email']; ?></td></tr>
		<tr><td>Password</td><td><?php echo $user['User']['password']; ?></td></tr>
		<tr><td>First Name</td><td><?php echo $user['User']['first_name']; ?></td></tr>
		<tr><td>Last Name</td><td><?php echo $user['User']['last_name']; ?></td></tr>
	
		<!--<tr><td colspan="2">Contact Details</td></tr>-->
		<tr><td>Address</td><td><?php echo $user['User']['address']; ?></td></tr>
		<tr><td>Phone</td><td><?php echo $user['User']['phone']; ?></td></tr>
		<tr><td>City</td><td><?php echo $user['User']['city'];?></td></tr>		
		<tr><td>State</td><td><?php echo $user['User']['state']; ?></td></tr>
		<tr><td>Country</td><td><?php echo $user['User']['country']; ?></td></tr>
		<tr><td>Pin</td><td><?php echo $user['User']['zip']; ?></td></tr>
	
			
	</table>
</div>

