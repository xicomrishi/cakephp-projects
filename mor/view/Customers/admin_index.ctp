<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Customer', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Registered  Customers', true), array('action' => 'index','registered')); ?></li>
		<li><?php echo $this->Html->link(__('Guest Customers', true), array('action' => 'index','guest')); ?></li>
	</ul>
</div>

<div class="customers index">
	<h2><?php if(isset($CustomerType)){
		if($CustomerType=='guest'){
			echo __('Guset Customers');
		}else{
			echo __('Registered Customers');
		}
	}else{
		echo __('All Customers');
	}?></h2>
	
	<div class="inline_search right">
		<form name="CustomerFrm" method="get" action="<?php echo $this->webroot;?>admin/customers/index">
		<span><strong>Customer Name / Email / Phone :&nbsp;</strong></span>
		<input type="text" name="search_key" value="<?php if(isset($SearchKey)){ echo $SearchKey;}?>"/>
		<input type="submit" class="search" value="Search"/>
		</form>
	</div>
	
	<?php if(isset($Customers)){?>

<div class="table_wrap">
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('first_name','Name');?></th>
			<th><?php echo $this->Paginator->sort('customer_type','Type');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('phone');?></th>			
			<th><?php echo $this->Paginator->sort('wallet_current_amount','Wallet Amount(Rs.)');?></th>
			<th><?php echo $this->Paginator->sort('number_of_attempts','Number of Attempts');?></th>
			<th><?php echo $this->Paginator->sort('successful_transactions','Successful Transactions');?></th>			
			<th><?php echo $this->Paginator->sort('customer_status');?></th>			
			<th><?php echo $this->Paginator->sort('last_login_ip');?></th>
			<th><?php echo $this->Paginator->sort('last_login_date');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	
	$i = 0;
	foreach ($Customers as $customer):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $customer['Customer']['name'];		
		?></td>
		<td><?php echo $customer['Customer']['customer_type']; ?></td>
		<td><?php echo $customer['Customer']['email']; ?></td>
	
		<td><?php echo $customer['Customer']['phone']; ?></td>
		<td><?php echo $customer['Customer']['wallet_current_amount']; ?></td>
		<td><?php echo $customer['Customer']['number_of_attempts']; ?></td>
		<td><?php echo $customer['Customer']['successful_transactions']; ?></td>
		<td><?php echo $customer['Customer']['customer_status']; ?></td>
		<td><?php echo $customer['Customer']['last_login_ip']; ?></td>
		<td><?php echo $customer['Customer']['last_login_date']; ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $customer['Customer']['customer_id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $customer['Customer']['customer_id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $customer['Customer']['customer_id']), null, sprintf(__('Are you sure you want to delete?', true))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled prev'));?>
		<?php echo $this->Paginator->numbers();?>
 		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled next'));?>
	</div>
	<?php }else{?>
	<div class="record_not_found error">Records not found.</div>
	<?php }?>
</div>
