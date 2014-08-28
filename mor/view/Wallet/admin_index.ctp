<?php 
$qStringForExp='?ac=f';
if(isset($SearchKey)){
	$qStringForExp.="&search_key={$SearchKey}";
}

if(isset($StartDate)){
	$qStringForExp.="&start_date={$StartDate}";
}

if(isset($EndDate)){
	$qStringForExp.="&end_date={$EndDate}";
}


?>

<div class="transaction_search">
	<form name="WalletSearchFrm" method="get" action="<?php echo $this->webroot;?>admin/wallet/index">
	<span><strong>Transaction / Payment ID / Customer ID :&nbsp;</strong></span>
	<input type="text" name="search_key" value="<?php if(isset($SearchKey)){ echo $SearchKey;}?>"/>
	
	<input type="submit" class="search" value="Search"/>	
	</form>
	<form name="WalletFilterFrm" method="get" action="<?php echo $this->webroot;?>admin/wallet/index">
	<span><strong>Filter by Date Range :&nbsp;</strong></span>
	From<input type="text" class="datepicker" name="start_date" value="<?php if(isset($StartDate)){ echo $StartDate;}?>"/>
	To<input type="text" class="datepicker" name="end_date" value="<?php if(isset($EndDate)){ echo $EndDate;}?>"/>
		
	<input type="submit" class="search" value="Submit"/>	
	</form>
</div>    

<div class="table_wrap">
<table cellspacing="0" cellpadding="0">
	 <tr>
		<th><?php echo $this->Paginator->sort('Wallet.id','ID');?></th>
		<th><?php echo $this->Paginator->sort('Customer.customer_id','Customer ID');?></th>
        <th><?php echo $this->Paginator->sort('Customer.name','Customer Name');?></th>
       	<th><?php echo $this->Paginator->sort('Wallet.type','Transaction Type');?></th>  
       	<th><?php echo $this->Paginator->sort('Wallet.payment_mode','Payment Mode');?></th>      	
        <th><?php echo $this->Paginator->sort('Wallet.amount','Amount');?></th>
       	<th><?php echo $this->Paginator->sort('Wallet.refund','Refund');?></th>
        <th><?php echo $this->Paginator->sort('Wallet.payment_id','Payment ID');?></th>
        <th><?php echo $this->Paginator->sort('Wallet.transaction_id','Transaction ID');?></th> 
        <th><?php echo $this->Paginator->sort('Wallet.wallet_current_amount','Updated Wallet Amount');?></th>
        <th><?php echo $this->Paginator->sort('Wallet.date','Date');?></th>   
    </tr>

	<?php if($wallet){?>
  
	<?php
	$i = 0;
	foreach ($wallet as $wt){
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	  
	?>
	<tr <?php echo $class;?>>
		
        <td><?php echo $wt['Wallet']['id']; ?></td>
        <td><?php if($wt['Customer']['customer_id']){echo $wt['Customer']['customer_id'];}else{echo "-";} ?></td>
        <td><?php if($wt['Customer']['name']){echo $wt['Customer']['name'];}else{echo "-";} ?></td>
        <td><?php echo $wt['Wallet']['type']; ?></td>
        <td><?php if($wt['Wallet']['payment_mode']){echo $wt['Wallet']['payment_mode'];}else{echo "-";} ?></td>
        <td><?php if($wt['Wallet']['amount']){echo $wt['Wallet']['amount'];}else{echo "-";} ?></td>
        <td><?php if($wt['Wallet']['refund']=="Yes"){echo $wt['Wallet']['refund'];}else{echo "-";} ?></td>
        <td><?php if($wt['Wallet']['payment_id']){echo $wt['Wallet']['payment_id'];}else{echo "-";} ?></td>
        <td><?php if($wt['Wallet']['transaction_id']){echo $wt['Wallet']['transaction_id'];}else{echo "-";} ?></td>      
        <td><?php if($wt['Wallet']['wallet_current_amount']){echo $wt['Wallet']['wallet_current_amount'];}else{echo "-";} ?></td> 
        <td><?php echo $wt['Wallet']['date']; ?></td>
    </tr>
 	<?php }
  }?>   
  
</table>
</div>

<?php if($wallet){?>
<div class="paging">
	<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled prev'));?>
	 <?php echo $this->Paginator->numbers();?>
 	 <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled next'));?>
</div>
 <?php 
}else{
	echo "<span class='not_found'>No transaction found.</span>";
} ?>
</div>