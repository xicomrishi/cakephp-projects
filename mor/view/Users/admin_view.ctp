<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User', true), array('action' => 'edit', $User['User']['user_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User', true), array('action' => 'delete', $User['User']['user_id']), null, sprintf(__('Are you sure you want to delete?', true))); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?> </li>
	</ul>
</div>

<div class="users view">
	<h2><?php echo __('User');?></h2>
	<dl>
	
		<dt>Email</dt><dd>:&nbsp;<?php echo $User['User']['email']; ?></dd>
		<dt>Password</dt><dd>:&nbsp;<?php echo $User['User']['password']; ?></dd>
		<dt>Name</dt><dd>:&nbsp;<?php echo $User['User']['name']; ?></dd>
		
		<dt>Address</dt><dd>:&nbsp;<?php echo $User['User']['address']; ?></dd>
		<dt>Phone</dt><dd>:&nbsp;<?php echo $User['User']['phone']; ?></dd>
		<dt>City</dt><dd>:&nbsp;<?php echo $User['User']['city'];?></dd>		
		<dt>State</dt><dd>:&nbsp;<?php echo $User['User']['state']; ?></dd>
		<dt>Country</dt><dd>:&nbsp;<?php echo $User['Country']['country_name']; ?></dd>
		<dt>Pin</dt><dd>:&nbsp;<?php echo $User['User']['zip_code']; ?></dd>
		<dt>Description</dt><dd>:&nbsp;<?php echo $User['User']['user_description']; ?></dd>
	
		<dt>Added Date</dt><dd>:&nbsp;<?php echo $User['User']['user_added_date']; ?></dd>
		<dt>Modified Date</dt><dd>:&nbsp;<?php echo $User['User']['user_modified_date']; ?></dd>
		<dt>Status</dt><dd>:&nbsp;<?php echo $User['User']['user_status']; ?></dd>
		
		<dt>Last Login Date</dt><dd>:&nbsp;<?php echo $User['User']['last_login_date']; ?></dd>
		<dt>Last Login IP</dt><dd>:&nbsp;<?php echo $User['User']['last_login_ip']; ?></dd>	
	
			
	</dl>
</div>

