<div class="full-width recharges">
<div class="tab">
<ul>
	
	<li><?php
	$class='';
	if(!isset($Filter)){
		$Filter='';
	}
	if($Filter=='' || $Filter=='Success'){
		$class='active';
	}
	echo $this->Html->link('Success Transactions |',
	array('controller' => 'recharges', 'action' => 'index','admin'=>true,
	'?' => array('filter' => 'Success')),array('class'=>$class));	
	?>
	</li>
	
	<li><?php
	$class='';
	
	if($Filter=='Processing'){
		$class='active';
	}
	echo $this->Html->link('Transactions in Process |',
	array('controller' => 'recharges', 'action' => 'index','admin'=>true,
	'?' => array('filter' => 'Processing')),array('class'=>$class));	
	
	?>
	</li>
	
	<li><?php
	$class='';
	if($Filter=='Failed'){
		$class='active';
	}
	echo $this->Html->link('Failed & Incomplete Transactions',
	array('controller' => 'recharges', 'action' => 'index','admin'=>true,
	'?' => array('filter' => 'Failed')),array('class'=>$class));
	?>
	</li>
</ul>

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

if(isset($Filter)){
	$qStringForExp.="&filter={$Filter}";
}

if(isset($service_type)){
	$qStringForExp.="&service_type={$service_type}";
}

?>
<div class="export_trans" style="width:300px;float:right">
<strong>Export Transactions&nbsp;:</strong>&nbsp;
<a target="_blank" style="color:red;" href="<?php echo $this->webroot;?>admin/recharges/export_transactions<?php echo $qStringForExp;?>">Filtered</a>&nbsp;|&nbsp;
<a target="_blank" style="color:red;" href="<?php echo $this->webroot;?>admin/recharges/export_transactions?ac=all">All</a>
</div>


</div>
	
<div class="transaction_search">
	<form name="RechargeSearchFrm" method="get" action="<?php echo $this->webroot;?>admin/recharges/index">
	<span><strong>Transaction / Payment Id :&nbsp;</strong></span>
	<input type="text" name="search_key" value="<?php if(isset($SearchKey)){ echo $SearchKey;}?>"/>
	<input type="hidden" name="filter" value='<?php echo $Filter;?>'/>	
	<input type="submit" class="search" value="Search"/>	
	</form>
	<form name="RechargeFilterFrm" method="get" action="<?php echo $this->webroot;?>admin/recharges/index">
	<span><strong>Filter by Date Range :&nbsp;</strong></span>
	From<input type="text" class="datepicker" name="start_date" value="<?php if(isset($StartDate)){ echo $StartDate;}?>"/>
	To<input type="text" class="datepicker" name="end_date" value="<?php if(isset($EndDate)){ echo $EndDate;}?>"/>
	<input type="hidden" name="filter" value='<?php echo $Filter;?>'/>	
	<input type="submit" class="search" value="Submit"/>	
	</form>

	<form style="wiidth:220px;text-align:right" name="SearchRechargeByService" class="service_filter right" method="get" action="<?php echo $this->webroot;?>admin/recharges/index">
	<span><strong>Filter By :&nbsp;</strong></span>
	<select name="service_type">
	<option value="0" <?php if(isset($service_type) && $service_type=='0'){ echo "selected='selected'";}?>>All</option>
	<option value="1" <?php if(isset($service_type) && $service_type=='1'){ echo "selected='selected'";}?>>Prepaid Mobile</option>
	<option value="2" <?php if(isset($service_type) && $service_type=='2'){ echo "selected='selected'";}?>>DTH</option>
	<option value="3" <?php if(isset($service_type) && $service_type=='3'){ echo "selected='selected'";}?>>Data Card</option>
	<option value="4" <?php if(isset($service_type) && $service_type=='4'){ echo "selected='selected'";}?>>Postpaid Mobile</option>
	<option value="5" <?php if(isset($service_type) && $service_type=='5'){ echo "selected='selected'";}?>>Landline Bill</option>
	<option value="6" <?php if(isset($service_type) && $service_type=='6'){ echo "selected='selected'";}?>>Electricity Bill</option>
	<option value="7" <?php if(isset($service_type) && $service_type=='7'){ echo "selected='selected'";}?>>Gas Bill</option>
	<option value="8" <?php if(isset($service_type) && $service_type=='8'){ echo "selected='selected'";}?>>Insurance Bill</option>
	
	</select>
	<input type="hidden" name="filter" value='<?php echo $Filter;?>'/>	
	<input type="submit" class="search" value="Go"/>	
	</form>
</div>

	
<form name="RechargeStatusFrm" action="<?php echo $this->webroot;?>admin/recharges/change_recharge_status" method="post">

<div class="status">
	<span><strong>Payment Action</strong></span>
	<select name="RechargeStatusAction" style="width:150px;">
	<?php if(isset($RecordStatus)){
	
		foreach($RecordStatus as $rs){?>
			<option value="<?php echo $rs;?>"><?php echo $rs;?></option>
	
		<?php }
	}?>
	</select>					
	<input id="recharge_status_action_btn" type="submit" value="Submit"/>

</div>

<div class="table_wrap">
<table cellspacing="0" cellpadding="0">
	 <tr>
    	<th><input type="checkbox" name="RechargeStatus" id="recharge_status"/></th>
		<th><?php echo $this->Paginator->sort('Recharge.transaction_id','Trans.Id');?></th>
		<th><?php echo $this->Paginator->sort('Recharge.atom_trans_id','Atom Trans Id');?></th>
       	<th><?php echo $this->Paginator->sort('Recharge.payment_id','Payment Id');?></th>  
       	<th><?php echo $this->Paginator->sort('Recharge.marchant_ref_no','Marchant Ref No');?></th>      	
        <th><?php echo $this->Paginator->sort('Recharge.customer_id','Customer Id');?></th>
       	<th><?php echo $this->Paginator->sort('Customer.name','Customer Name');?></th>
        <th><?php echo $this->Paginator->sort('Customer.customer_type','Customer Type');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.recharge_circle','Circle');?></th>    
      
       	<th><?php echo $this->Paginator->sort('Recharge.recharge_type','Recharge Type');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.number','Number.');?></th>
        <th><?php echo $this->Paginator->sort('Operator.name','Operator Name');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.amount','Amount');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.service_charge','Service Charge');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.discount','Discount');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.total_amount','Total Amount');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.account_param','Account# / Cycle# / DOB');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.payment_status','Payment Status');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.transaction_status','Recharge Status');?></th>  
        <th><?php echo $this->Paginator->sort('Recharge.payment_date','Recharge Date');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.payment_mode','Payment Mode');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.record_status','Payment Action');?></th>
   
    </tr>

	<?php if($Recharges){?>
  
	<?php
	$i = 0;
	foreach ($Recharges as $recharge){
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	  
	?>
	<tr <?php echo $class;?>>
		<td><input type="checkbox" name="RechargeIds[]" value="<?php echo $recharge['Recharge']['id']; ?>"/>
		</td>
        <td><?php if($recharge['Recharge']['transaction_id']){echo $recharge['Recharge']['transaction_id'];}else{echo "N/A";} ?></td>
        <td><?php if($recharge['Recharge']['atom_trans_id']){echo $recharge['Recharge']['atom_trans_id'];}else{echo "N/A";} ?></td>
        <td><?php if($recharge['Recharge']['payment_id']){echo $recharge['Recharge']['payment_id'];}else{echo "N/A";} ?></td>
        <td><?php if($recharge['Recharge']['marchant_ref_no']){echo $recharge['Recharge']['marchant_ref_no'];}else{echo "N/A";} ?></td>
        <td><?php if($recharge['Recharge']['customer_id']){echo $recharge['Recharge']['customer_id'];}else{echo "N/A";} ?></td>
        <td><?php echo $recharge['Customer']['name']; ?></td>
        <td><?php echo $recharge['Customer']['customer_type']; ?></td>
        <td><?php echo $recharge['Recharge']['recharge_circle']; ?></td>     
       
        <td><?php echo $recharge['RechargeType']['recharge_type'];  ?></td>
        <td><?php echo $recharge['Recharge']['number']; ?></td>
        <td><?php echo $recharge['Operator']['name']; ?></td>
        <td><?php echo $recharge['Recharge']['amount']; ?></td>
        <td><?php echo $recharge['Recharge']['service_charge']; ?></td>
        <td><?php echo $recharge['Recharge']['discount']; ?></td>
        <td><?php echo $recharge['Recharge']['total_amount']; ?></td> 
        <td><?php echo $recharge['Recharge']['account_param']; ?></td>
        <td><?php $paystatus=$recharge['Recharge']['payment_status'];
       		if($paystatus==1){echo 'Success';}else{echo 'Failed';}; 
        ?></td>
        <td><?php echo $recharge['Recharge']['transaction_status'];?></td>
        <td><?php echo $recharge['Recharge']['payment_date']; ?></td>
        <td><?php echo $recharge['Recharge']['payment_mode']; ?></td>
        <td><?php echo $recharge['Recharge']['record_status']; ?></td>
    </tr>
 	<?php }
  }?>   
  
</table>
</div>
</form>

<?php if($Recharges){?>
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

<script type="text/javascript">
jQuery(function(){

	
	jQuery("#recharge_status").click(function(){
		if(jQuery(this).is(":checked")){
		
			jQuery("input[name='RechargeIds[]']").attr("checked","checked");
		}else{
			jQuery("input[name='RechargeIds[]']").removeAttr("checked");
		}
	});

	jQuery("#recharge_status_action_btn").click(function(){
		
		if(!(jQuery("input[name='RechargeIds[]']").is(':checked'))){
			alert("Please select a row(s).");
			return false;
		}

		if(confirm("Are you sure to perform this action?")){
			return true;
		}else{
			return false;
		}
		
	});

	jQuery(".datepicker").datepicker();
	
});

function redirectTo(opt){
	
	location.href="<?php echo $this->webroot;?>admin/recharges/index/"+opt;
	
}



</script>

