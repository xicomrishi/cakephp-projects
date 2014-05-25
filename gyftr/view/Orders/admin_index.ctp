<div class="users">
<div id="searchSection">
<?php $url=$this->webroot.'admin/orders/index';
if(!isset($showuser)){ $url.='/'.$user['id']; } ?>
<form id="productSearch" name="productSearch" method="GET" action="<?php echo $url ?>" onsubmit="return search_product();">
	<div style="float:left; width:100%">
    <label style="padding:10px 10px 0 0; font-size:14px;line-height:16px; width:auto !important;">Search By </label>
    <table cellpadding="0" cellspacing="0">    
    <tr>
    <td><span class="serch_label">Incomplete Deliver</span></td>
    <td>
    <select name="incomplete_deliver">
    <option value="" <?php if(isset($incomplete_deliver)&&$incomplete_deliver==""){echo 'selected="selected"';}?> >All</option>
    <option value="0" <?php if(isset($incomplete_deliver)&&$incomplete_deliver=="0"){echo 'selected="selected"';}?> >No</option>
    <option value="1" <?php if(isset($incomplete_deliver)&&$incomplete_deliver=="1"){echo 'selected="selected"';}?> >Yes</option>
    </select>
    </td> 
    <td><span class="serch_label">Payment Status</span></td>
    <td>
    <select name="payment_status">
    <option value="" <?php if(isset($payment_status)&&$payment_status==""){echo 'selected="selected"';}?> >All</option>
    <option value="0" <?php if(isset($payment_status)&&$payment_status=="0"){echo 'selected="selected"';}?> >Pending</option>
    <option value="1" <?php if(isset($payment_status)&&$payment_status=="1"){echo 'selected="selected"';}?> >Paid</option>
    <option value="2" <?php if(isset($payment_status)&&$payment_status=="2"){echo 'selected="selected"';}?> >Rejected</option>
    </select>
    </td>    
    <td><span class="serch_label">Gift Status</span></td>
    <td>
    <select name="status">
    <option value="" <?php if(isset($status)&&$status==""){echo 'selected="selected"';}?> >All</option>
    <option value="0" <?php if(isset($status)&&$status=="0"){echo 'selected="selected"';}?> >InProgress</option>
    <option value="1" <?php if(isset($status)&&$status=="1"){echo 'selected="selected"';}?> >Delivered</option>
    <option value="2" <?php if(isset($status)&&$status=="2"){echo 'selected="selected"';}?> >Pending</option>
    </select>
    </td>
    </tr>
    <tr>  
    <td>
    <select name="serch_by">
    <?php if(isset($showuser)){ ?><option value="Order.from_name" <?php if(isset($serch_by)&&$serch_by=="Order.from_name"){echo 'selected="selected"';}?> >From Name</option>
<?php } ?>
    <option value="Order.to_name" <?php if(isset($serch_by)&&$serch_by=="Order.to_name"){echo 'selected="selected"';}?> >To Name</option>
    <!--<option value="BrandProduct.voucher_name" <?php if(isset($serch_by)&&$serch_by=="BrandProduct.voucher_name"){echo 'selected="selected"';}?> >Voucher Name</option>-->
        </select>
    </td>
    <td> <input type="text" id="serch_val" name="serch_val" value="<?php if(isset($serch_val)){echo $serch_val;}?>"/></td>
    <td><span class="serch_label">Order From Date</span></td>
    <td><input type="text" id="from_date" name="from_date" value="<?php if(isset($from_date)){echo $from_date;}?>" class="text_date"  readonly="readonly"/></td>
    <td><span class="serch_label">Order To Date</span></td>
    <td><input type="text" id="to_date" name="to_date" value="<?php if(isset($to_date)){echo $to_date;}?>" class="text_date"  readonly="readonly"/></td>
    </tr>
    
     <tr>
    <td><span class="serch_label">Gifting Type</span></td>
      <td>
    <select name="type">
    <option value="" <?php if(isset($type)&&$type==""){echo 'selected="selected"';}?> >All</option>
    <option value="Me To Me" <?php if(isset($type)&&$type=="Me To Me"){echo 'selected="selected"';}?> >Me To Me</option>
    <option value="One To One" <?php if(isset($type)&&$type=="One To One"){echo 'selected="selected"';}?> >One To One</option>
    <option value="Group Gift" <?php if(isset($type)&&$type=="Group Gift"){echo 'selected="selected"';}?> >Group Gift</option>
    </select>
    </td>
    </tr>
    
    <tr>
    <td colspan="6" align="right"><input type="submit" value="Search" class="submit" onclick="return search_product();"/>
    </td></tr>
   
    </table>
    </div>
</form>
</div>
<div class="">
	<h2><?php echo __('Orders'); if(!isset($showuser)){ echo " by ".$user['first_name']." ".$user['last_name'];}?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th align="left" style="white-space:normal;"><?php echo $this->Paginator->sort('id','Order ID');?></th>
			<?php if(isset($showuser)){?><th style="white-space:normal;"><?php echo $this->Paginator->sort('from_name');?></th><?php } ?>
            <th style="white-space:normal;"><?php echo $this->Paginator->sort('type');?></th>
            <th style="white-space:normal;"><?php echo $this->Paginator->sort('to_name');?></th>
            <th style="white-space:normal;"><?php echo $this->Paginator->sort('to_email');?></th>
            <th style="white-space:normal;"><?php echo $this->Paginator->sort('to_phone');?></th>
            <!--<th style="white-space:normal;"><?php echo $this->Paginator->sort('BrandProduct.voucher_name','Voucher Name');?></th>-->									
            <th style="white-space:normal;"><?php echo $this->Paginator->sort('total_amount');?></th>
			<th style="white-space:normal;"><?php echo $this->Paginator->sort('amount_paid');?></th>
            <th style="white-space:normal;"><?php echo $this->Paginator->sort('incomplete_deliver');?></th>
			<th style="white-space:normal;"><?php echo $this->Paginator->sort('payment_status','Payment Status');?></th>
			<th style="white-space:normal;"><?php echo $this->Paginator->sort('status','Gift Status');?></th>
			<th style="white-space:normal;"><?php echo $this->Paginator->sort('created','Order Date');?></th>
	</tr>
	<?php if(count($gyfts)<=0)
	{?>
    <tr><td colspan='13'><span class='norecord'>No record Found</span></td></tr>
    <?php } else {
	$i = 0;
	foreach ($gyfts as $gyft):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr <?php echo $class;?>>
		<td><?php echo $gyft['Order']['id']; ?></td>
		<?php if(isset($showuser)){?><td><?php echo $gyft['Order']['from_name']; ?></td><?php } ?>
        <td><?php echo $gyft['Order']['type']; ?></td>
        <td><?php echo $gyft['Order']['to_name']; ?></td>
        <td><?php echo $gyft['Order']['to_email']; ?></td>
        <td><?php echo $gyft['Order']['to_phone']; ?></td>
        <!--<td><?php echo $gyft['BrandProduct']['voucher_name']; ?></td>-->
		<td><?php echo $gyft['Order']['total_amount']; ?></td>
		<td><?php echo $gyft['Order']['amount_paid']; ?></td>        
		<td><?php switch($gyft['Order']['incomplete_deliver'])
		{
			case 0: echo "No";break;
			case 1: echo "Yes";break;
		}?></td>        
		<td><?php switch($gyft['Order']['payment_status'])
		{
			case 0: echo "Pending";break;
			case 1: echo "Paid";break;
			case 2: echo "Rejected";break;
			}?></td>
		<td><?php switch($gyft['Order']['status'])
		{
			case 0: echo "InProgress";break;
			case 1: echo "Delivered";break;
			case 2: echo "Pending";break;
		}?></td>
        <td><?php echo date('j/m/Y',strtotime($gyft['Order']['created'])); ?></td>		
	</tr>
				
<?php endforeach; } ?>
	</table>
  </div>	
	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), null, null, array('class'=>'disabled'));?>
	 <?php echo $this->Paginator->numbers();?>
 	 <?php echo $this->Paginator->next(__('next', true) . ' >>', null, null, array('class' => 'disabled'));?>
	</div>
</div>
<?php //echo $this->element('sql_dump');?>
<script type="text/javascript">
$(document).ready(function(e) {	
	var to_day=new Date();
    $('#from_date').datepicker({          
			dateFormat:"yy-mm-dd",
			onSelect: function (dateText, inst){
				 	var rangedate=new Date(dateText);
					//rangedate.setDate(rangedate.getDate()+1);
					$('#to_date').datepicker('option', 'minDate',rangedate);
			 }
			 });

 $('#to_date').datepicker({
           // buttonImage: '<?php echo SITE_URL; ?>/img/calender_search_bg.png',
			dateFormat:"yy-mm-dd",
			onSelect: function (dateText, inst){
				var date1=$('#from_date').datepicker('getDate');
				
				 	var rangedate=new Date(dateText);
					//alert(date1.getTime() + ' '+ rangedate.getTime() );
					
					if(rangedate.getTime()< date1.getTime())
					{
						$('#from_date').val('');
					}//rangedate.setDate(rangedate.getDate()+1);
					//$('#to_date').datepicker('option', 'minDate',rangedate);
			 }
			 //minDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate()+1, 0, 0),
		   });
});
</script> 