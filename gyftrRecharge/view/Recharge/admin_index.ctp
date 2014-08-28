<style>
div.index{ border:none; width:98%; }
</style>

<div class="users index">
	<h2><?php echo __('Recharge History');?></h2>
	
	<table cellpadding="0" cellspacing="0">
   
    	<form id="filterForm" name="filterForm" method="get" action="<?php echo $this->webroot; ?>admin/recharge/index">
        
        <tr><th style="text-align:left" colspan="12">Filter Data</th></tr>
        <tr>
       	<th><label>From Date: </label></th>        	
        <th><input type="text" name="from_date" id="from_date"  value="<?php if(isset($from_date)){echo $from_date;}?>"/></th>
        <th><label>To Date: </label></th>
         <th><input type="text" name="to_date" id="to_date"  value="<?php if(isset($to_date)){echo $to_date;}?>"/></th>
         <th><label>Recharge Type: </label></th>
         <th><select name="recharge_type">
            	<option value="" <?php if(isset($recharge_type)&&$recharge_type==""){echo 'selected="selected"';}?>>All</option>
                <option value="1" <?php if(isset($recharge_type)&&$recharge_type=="1"){echo 'selected="selected"';}?>>Mobile Prepaid</option>
                <option value="2" <?php if(isset($recharge_type)&&$recharge_type=="2"){echo 'selected="selected"';}?>>DTH</option>
                <option value="3" <?php if(isset($recharge_type)&&$recharge_type=="3"){echo 'selected="selected"';}?>>Data Card</option>
                <option value="4" <?php if(isset($recharge_type)&&$recharge_type=="4"){echo 'selected="selected"';}?>>Mobile Postpaid</option>
                <option value="5" <?php if(isset($recharge_type)&&$recharge_type=="5"){echo 'selected="selected"';}?>>Electricity Bill Pay</option>
                <option value="6" <?php if(isset($recharge_type)&&$recharge_type=="6"){echo 'selected="selected"';}?>>Landline Bill Pay</option>
                <option value="7" <?php if(isset($recharge_type)&&$recharge_type=="7"){echo 'selected="selected"';}?>>Gas Bill Pay</option>
                <option value="8" <?php if(isset($recharge_type)&&$recharge_type=="8"){echo 'selected="selected"';}?>>Insurance</option>
            </select>
        </th>
        <th>
        	<label>Recharge Status: </label></th>
         <th>   <select name="recharge_payment_status">
            	<option value="" <?php if(isset($recharge_payment_status)&&$recharge_payment_status==""){echo 'selected="selected"';}?>>All</option>
                <option value="1" <?php if(isset($recharge_payment_status)&&$recharge_payment_status=="1"){echo 'selected="selected"';}?>>Success</option>
                <option value="0" <?php if(isset($recharge_payment_status)&&$recharge_payment_status=="0"){echo 'selected="selected"';}?>>Failed</option>
            </select>
        </th>
        <th>
        	<label>Recharge Verif. Status: </label></th>
         <th>   <select name="recharge_status">
            	<option value="" <?php if(isset($recharge_status)&&$recharge_status==""){echo 'selected="selected"';}?>>All</option>
                <option value="1" <?php if(isset($recharge_status)&&$recharge_status=="1"){echo 'selected="selected"';}?>>Success</option>
                <option value="0" <?php if(isset($recharge_status)&&$recharge_status=="0"){echo 'selected="selected"';}?>>Failed</option>
            </select>
        </th>
        </tr>
        <tr>
        <th colspan="12">
        <input type="submit" value="Filter Data" style="float:right"/>
       <div style=" float:right" class="export_div"> <a href="javascript://" style="font-size:14px;" onclick="export_xls();">Export Data</a></div>
        </th>
        </tr>
        <tr style="height:25px;"><td colspan="12"></td></tr>
        
        </form>
    
	<tr>
			
            <th><?php echo $this->Paginator->sort('id','S.No.');?></th>
            <th><?php echo $this->Paginator->sort('recharge_transaction_id','Transaction Id');?></th>
			<th><?php echo $this->Paginator->sort('user_id','User');?></th>
			
			<th><?php echo $this->Paginator->sort('recharge_type','Recharge Type');?></th>
            <th><?php echo $this->Paginator->sort('number','Number');?></th>
			<th><?php echo $this->Paginator->sort('operator_id','Operator');?></th>
            <th><?php echo $this->Paginator->sort('circle_id','Circle');?></th>
            <th><?php echo $this->Paginator->sort('voucher_code','Voucher');?></th>
            <th><?php echo $this->Paginator->sort('amount_from_voucher','Amount');?></th>            
			
            <th><?php echo $this->Paginator->sort('recharge_payment_status','Recharge Status');?></th> 
            <th><?php echo $this->Paginator->sort('recharge_status','Recharge Verif.');?></th>            
			<th><?php echo $this->Paginator->sort('recharge_date','Recharge Date');?></th>
            
			
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
    	
		<td><?php echo $rech['Recharge']['id']; ?></td>
        <td><?php echo $rech['Recharge']['recharge_transaction_id']; ?></td>
		<td><?php if($rech['Recharge']['user_id']=='0') echo 'guest'; else echo $rech['User']['name']; ?></td>
		
		<td><?php if($rech['Recharge']['recharge_type']=='1') echo 'Mobile Prepaid'; else if($rech['Recharge']['recharge_type']=='2') echo 'DTH'; else if($rech['Recharge']['recharge_type']=='3') echo 'Data Card'; else if($rech['Recharge']['recharge_type']=='4') echo 'Mobile Postpaid'; else if($rech['Recharge']['recharge_type']=='5') echo 'Electricity Bill Pay'; else if($rech['Recharge']['recharge_type']=='6') echo 'Landline Bill Pay'; else if($rech['Recharge']['recharge_type']=='7') echo 'Gas Bill Pay'; else if($rech['Recharge']['recharge_type']=='8') echo 'Insurance Bill Pay'; ?></td>
        <td><?php echo $rech['Recharge']['number']; ?></td>
		<td><?php echo $rech['Operator']['name']; ?></td>
        <td><?php if(!empty($rech['Circle']['circle'])) echo $rech['Circle']['circle']; else echo 'N/A'; ?></td>
		<td><?php if(!empty($rech['Recharge']['voucher_code'])) echo $rech['Recharge']['voucher_code']; else echo 'N/A'; ?></td>
        <td><?php echo $rech['Recharge']['amount_from_voucher']; ?></td>
        
        
        <td><?php if($rech['Recharge']['recharge_payment_status']=='0') echo 'Failed'; else if($rech['Recharge']['recharge_payment_status']=='1') echo 'Success'; else echo 'N/A'; ?></td>
        <td><?php if($rech['Recharge']['recharge_status']=='0') echo 'Failed'; else if($rech['Recharge']['recharge_payment_status']=='1') echo 'Success'; else echo 'N/A'; ?></td>
        <td><?php echo show_formatted_datetime($rech['Recharge']['recharge_date']); ?></td>
		
		
		</tr>				
<?php endforeach; ?>
	</table>
    	
	
	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 	 |	<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(e) {	
	var to_day=new Date();
    $('#from_date').datepicker({          
			dateFormat:"yy-mm-dd",
			onSelect: function (dateText, inst){
				 	var rangedate=new Date(dateText);
					$('#to_date').datepicker('option', 'minDate',rangedate);
			}
	 });

 $('#to_date').datepicker({           
			dateFormat:"yy-mm-dd",
			onSelect: function (dateText, inst){
				var date1=$('#from_date').datepicker('getDate');				
				 	var rangedate=new Date(dateText);									
					if(rangedate.getTime()< date1.getTime())
					{
						$('#from_date').val('');
					}					
			 }			 
		   });
});

function export_xls()
{
	$('#filterForm').attr('action','<?php echo $this->webroot; ?>admin/recharge/index/1');
	$('#filterForm').submit();
	$('#filterForm').attr('action','<?php echo $this->webroot; ?>admin/recharge/index');
}
</script>

