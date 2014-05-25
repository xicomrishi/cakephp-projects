<div class="games index">
<h2><?php echo __('Coupons'); ?></h2>
<div class="inline_search right">
	<form name="CustomerFrm" method="get" action="<?php echo $this->webroot;?>admin/coupons/list_coupon">
	<span><strong>Coupon Code / Price:&nbsp;</strong></span>
	<input type="text" name="search_key" value="<?php if(isset($SearchKey)){ echo $SearchKey;}?>"/>
	<input type="submit" class="search" value="Search"/>
	</form>
</div>
<?php if($Coupons){?>
<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Coupon.coupon_code','Coupon Code'); ?></th>
			<th><?php echo $this->Paginator->sort('Coupon.coupon_description','Description'); ?></th>
            <th><?php echo $this->Paginator->sort('Coupon.coupon_price','Coupon Price(Rs.)'); ?></th>
            <th><?php echo $this->Paginator->sort('Coupon.min_amount','Min Amount'); ?></th>
            <th><?php echo $this->Paginator->sort('Coupon.max_uses','Max Uses'); ?></th>
            <th><?php echo $this->Paginator->sort('Coupon.recharge_type_id','Service Type/Category'); ?></th>
			<th width="80px"><?php echo $this->Paginator->sort('Coupon.start_date','Valid From'); ?></th>
			<th width="80px"><?php echo $this->Paginator->sort('Coupon.end_date','Valid To'); ?></th>
			<th><?php echo $this->Paginator->sort('Coupon.coupon_status','Status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
    <?php
	
	$i = 0;
	foreach ($Coupons as $coupon):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}?>	
		<tr <?php echo $class;?>>
	    <td><?php echo $coupon['Coupon']['coupon_code']; ?></td>
        <td><?php echo $coupon['Coupon']['coupon_description']; ?></td>
        <td><?php echo $coupon['Coupon']['coupon_price']; ?></td>
        <td><?php echo $coupon['Coupon']['min_amount']; ?></td> 
        <td><?php echo $coupon['Coupon']['max_uses']; ?></td>
        <td><?php 
        $allType=explode(",",$coupon['Coupon']['recharge_type_id']); 
		$types='';
	
        if(!empty($allType)){        
        	foreach($allType as $typeId){
        		if(!empty($typeId))
        	  	$types.=$RechargeTypes[$typeId].', ';
        	}
        	$types=trim($types,', ');
        	echo $types;
        }
        
        ?></td> 
        
        <td><?php if(!empty($coupon['Coupon']['start_date'])){echo date("d M Y",strtotime($coupon['Coupon']['start_date']));}else{ echo 'N/A';} ?></td> 
        <td><?php if(!empty($coupon['Coupon']['end_date'])){echo date("d M Y",strtotime($coupon['Coupon']['end_date']));}else{ echo 'N/A';} ?></td> 
        <td><?php echo $coupon['Coupon']['coupon_status']; ?></td> 
        
        <td class="actions">
		     <?php echo $this->Html->link(__('Coupon Uses ('.count($coupon['CouponUse']).')', true), array('action' => 'list_coupon_uses', $coupon['Coupon']['coupon_id'])); ?> 
    		<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit_coupon', $coupon['Coupon']['coupon_id'])); ?>
			<?php echo $this->Form->postLink(__('Delete', true), array('action' => 'delete_coupon', $coupon['Coupon']['coupon_id']), null, sprintf(__('Are you sure you want to delete ?', true))); ?>
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
    	<li><?php echo $this->Html->link(__('Add New Coupon'), array('action' => 'add_coupon')); ?></li>
    	<li><?php echo $this->Html->link(__('Service Type / Category'), array('action' => 'list_service_type')); ?></li>
     
	</ul>
</div>
