<style>
div.index{ border:none; width:98%; }
</style>

<div class="users index">
	<h2><?php echo __('Recharge History');?></h2>
<div id="searchSection">
<form method="post" action="<?php echo $this->webroot; ?>admin/recharge/index" name="RechargeSearchFrm">
<label for="payment_id">Payment ID: </label>
<input id="payment_id" type="text" name="data[paymentId]" />
<input type="submit" value="Search"/>
</form>
</div>

    <form id="rechargeForm" name="rechargeForm" action="<?php echo $this->webroot; ?>recharge/change_recharge_status" method="post" class="form">
	<table cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="6">&nbsp;</th>
        <th colspan="6">&nbsp;</th>
    	<th style="text-align:left" colspan="3"><label>Filter By: </label>
        	<select onchange="filter_by(this.value);" name="RechargeFillter">
            	<option value="" >All</option>
                <option value="Canceled" <?php if(isset($Fillter) && ($Fillter=='Canceled')) echo 'selected'; ?>>Cancelled</option>
                <option value="Captured" <?php if(isset($Fillter) && ($Fillter=='Captured')) echo 'selected'; ?>>Captured</option>
                <option value="Failed" <?php if(isset($Fillter) && ($Fillter=='Failed')) echo 'selected'; ?>>Failed</option>
                <option value="Processing" <?php if(isset($Fillter) && ($Fillter=='Processing')) echo 'selected'; ?>>Processing</option>
                <option value="Refund" <?php if(isset($Fillter) && ($Fillter=='Refund')) echo 'selected'; ?>>Refund</option>
            </select>
        </th>
    </tr>
	<tr>
			<!--<th><input id="all_check" type="checkbox" onclick="select_all_check();"></th>-->
            <th><?php echo $this->Paginator->sort('transaction_id','Trans.ID');?></th>
			<th><?php echo $this->Paginator->sort('payment_id','Payment ID');?></th>
			<th><?php echo $this->Paginator->sort('email','Email');?></th>
			<th><?php echo $this->Paginator->sort('recharge_type','Recharge Type');?></th>
            <th><?php echo $this->Paginator->sort('mobile','Mobile');?></th>
			<th><?php echo $this->Paginator->sort('operator_id','Operator');?></th>
            <th><?php echo $this->Paginator->sort('voucher_code','Voucher');?></th>
            <th><?php echo $this->Paginator->sort('amount_paid','Amount Paid');?></th>
            <th><?php echo $this->Paginator->sort('total_amount','Total Amount');?></th>
			<th><?php echo $this->Paginator->sort('payment_status','Payment Status');?></th> 
            <th><?php echo $this->Paginator->sort('recharge_payment_status','Recharge Status');?></th> 
            <th><?php echo $this->Paginator->sort('recharge_status','Recharge Verif.');?></th>            
			<th><?php echo $this->Paginator->sort('recharge_date','Recharge Date');?></th>
            <th><?php echo $this->Paginator->sort('transaction_status','Trans. Status');?></th>
			
	</tr>
	<?php
	
	$i = 0;
	foreach ($ReHistories as $rech):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr <?php echo $class;?>>
    	<!--<td><input type="checkbox" name="cbox[]" onclick="check(this); uncheck();" class="client_check" /></td>-->
		<td><?php echo $rech['Recharge']['transaction_id']; ?></td>
		<td><?php echo $rech['Recharge']['payment_id']; ?></td>
		<td><?php echo $rech['User']['email']; ?></td>
		<td><?php if($rech['Recharge']['recharge_type']=='1') echo 'Mobile'; else if($rech['Recharge']['recharge_type']=='2') echo 'DTH'; else if($rech['Recharge']['recharge_type']=='3') echo 'Data Card'; ?></td>
        <td><?php echo $rech['Recharge']['mobile']; ?></td>
		<td><?php echo $rech['Operator']['name']; ?></td>
		<td><?php if(!empty($rech['Recharge']['voucher_code'])) echo $rech['Recharge']['voucher_code']; else echo 'N/A'; ?></td>
        <td><?php echo $rech['Recharge']['amount_paid']; ?></td>
        <td><?php echo $rech['Recharge']['total_amount']; ?></td>
        <td><?php if($rech['Recharge']['payment_status']=='0') echo 'Failed'; else if($rech['Recharge']['payment_status']=='1') echo 'Success'; else echo 'N/A'; ?></td>
        <td><?php if($rech['Recharge']['recharge_payment_status']=='0') echo 'Failed'; else if($rech['Recharge']['recharge_payment_status']=='1') echo 'Success'; else echo 'N/A'; ?></td>
        <td><?php if($rech['Recharge']['recharge_status']=='0') echo 'Failed'; else if($rech['Recharge']['recharge_payment_status']=='1') echo 'Success'; else echo 'N/A'; ?></td>
        <td><?php echo show_formatted_datetime($rech['Recharge']['recharge_date']); ?></td>
		<td><?php echo $rech['Recharge']['transaction_status']; ?></td>
		
		</tr>				
<?php endforeach; ?>
	</table>
    </form>	
	
	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 	 |	<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>

<script type="text/javascript">
function filter_by(val)
{
	window.location.href=site_url+"/admin/recharge/index/"+val;		
}
function select_all_check()
{
	alert($('#all_check').is(':checked'));
	if($('#all_check').is(':checked'))
	{
		$('.client_check').each(function(index, element) {       	
			$(this).attr('checked',true);	
     	});	 
	}else{		
		$('.client_check').each(function(index, element) {		     
			$(this).attr('checked',false);		
		});
	}
}
function uncheck()
{	
	if($('#all_check').is(':checked'))
	{
		$('#all_check').attr('checked',false);
	}	
}

function check(el){
	if(el.checked==false)
		$('.checkall').attr('checked',false); 
}
</script>