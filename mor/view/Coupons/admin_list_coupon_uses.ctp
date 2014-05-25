<div class="games index">
<h2><?php echo __('Coupon Code'); ?> : <?php echo $Coupon['Coupon']['coupon_code'];?>&nbsp;-&nbsp;Rs.&nbsp;<?php echo $Coupon['Coupon']['coupon_price'];?></h2>
<h3><?php echo __('Coupon Uses'); ?></h3>

<?php if($CouponUses){?>
<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Recharge.transaction_id','Tras Id'); ?></th>
			<th><?php echo $this->Paginator->sort('Customer.customer_id','Customer Id'); ?></th>
			<th><?php echo $this->Paginator->sort('Customer.name','Name'); ?></th>			
			<th><?php echo $this->Paginator->sort('Recharge.number','Number'); ?></th>
			<th><?php echo $this->Paginator->sort('Recharge.amount','Recharge Amount'); ?></th>			
            <th><?php echo $this->Paginator->sort('Recharge.recharge_date','Date'); ?></th>
			<th><?php echo $this->Paginator->sort('CouponUse.status','Status'); ?></th>
			
	</tr>
    <?php
	
	$i = 0;
	foreach ($CouponUses as $couponUse):
	
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}?>	
		<tr <?php echo $class;?>>
		 <td><?php echo $couponUse['Recharge']['transaction_id']; ?></td>
		 <td><?php echo $couponUse['Customer']['customer_id']; ?></td>
      	 <td><?php echo $couponUse['Customer']['name']; ?></td>     
		 <td><?php echo $couponUse['Recharge']['number']; ?></td>	 
  		 <td><?php echo $couponUse['Recharge']['amount']; ?></td>
        
        <td><?php if(!empty($couponUse['Recharge']['recharge_date'])){echo date("d M Y",strtotime($couponUse['Recharge']['recharge_date']));}else{ echo 'N/A';} ?></td> 
        <td><?php echo $couponUse['CouponUse']['status'];?></td> 
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
    	<li><?php echo $this->Html->link(__('Back to Coupon List'), array('action' => 'list_coupon')); ?></li>
   	</ul>
</div>
