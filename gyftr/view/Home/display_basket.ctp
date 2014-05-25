<div class="breadcrumb">
			<ul>
				<li class="first"><a href="<?php echo SITE_URL; ?>">home</a></li>
				<li><a href="javascript://" onclick="return nextStep('step-2','start');">select gift type</a></li>
                 <?php if($this->Session->read('Gifting.type')!='me_to_me'){ ?>
				<li><a href="javascript://" onclick="return nextStep('one_to_one','<?php echo $this->Session->read('Gifting.type');?>');">Recipient</a></li>
				<?php } ?>
				<li><a href="javascript://" onclick="<?php if(isset($basket_empty)) { ?>return nextStep('step-3','<?php echo $this->Session->read('Gifting.type');?>');<?php }else{ echo 'back_to_show_vouchers();'; } ?>">select Gift</a></li>
                <li class="last">Basket</li>
            </ul>
	</div>


<div id="infoMsg">
</div> 
<input type="hidden" id="flag_val" value="<?php echo $flag; ?>"/>
<div class="basket_detail">
<div class="title">/ / Your <strong>Basket</strong></div>
<div class="head_row">
<div class="col1" style="text-align:center">Description</div>
<div class="col2">Price (INR)</div>
<div class="col3">Qty.</div>
<div class="col4">Sub Total (INR)</div>
<div class="col5">&nbsp;</div>
</div>

<div class="nano" style="height:auto !important">
<div class="selected_gift">
<?php 
$i=0;
foreach($items as $itm){ ?>

<div class="com_detail_row">
<div class="col1">
<span class="image"><img src="<?php echo $this->webroot.'files/BrandImage/'.$itm['cat_id'].'/Product/'.$itm['product_thumb']; ?>" alt="<?php echo $itm['product_name']?>" title="<?php echo str_replace("_","'",$itm['product_name']); ?>"></span>
<span class="detail"><p><?php echo str_replace("_","'",$itm['voucher_name']); ?></p></span>
</div>

<div class="col2"><?php echo 'INR '.$itm['price']; ?></div>
<div class="col3" id="item_<?php echo $i; ?>"><?php echo $itm['qty']; ?><a href="javascript://" style="float:left; margin:0px  0 0 0" onclick="update_qty('<?php echo $i; ?>','<?php echo $itm['id']; ?>','<?php echo $itm['qty']; ?>');">Change</a></div>
<div class="col4"><?php echo $itm['discount_sub_total']; ?></div>
<div class="col5"><a href="javascript://" onclick="remove_item('<?php echo $i; ?>','<?php echo $itm['id']; ?>');"><?php echo $this->Html->image('close1.png',array('escape'=>false,'alt'=>''));?></a></div>
</div>

<?php $i++; } ?>
</div>
</div>
<div class="total_row">
<span class="col1">Total (INR)</span>
<span class="col2"><?php echo $total_price; ?></span>
</div>

<a href="javascript://" class="add_more" onclick="<?php if(isset($basket_empty)) { ?>return nextStep('step-3','<?php echo $this->Session->read('Gifting.type');?>');<?php }else{ echo 'back_to_show_vouchers();'; } ?>">Add More Items</a>
</div>

<div class="action">
            
            <a href="javascript://"  class="yes" onclick="check_flag();">Next</a>
                <a href="javascript://"  class="no" onclick="<?php if(isset($basket_empty)) { ?>return nextStep('step-3','<?php echo $this->Session->read('Gifting.type');?>');<?php }else{ echo 'back_to_show_vouchers();'; } ?>">Previous</a>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
    $(".nano").nanoScroller({alwaysVisible:true, contentClass:'selected_gift',sliderMaxHeight: 70 });
});
</script>
<script type="text/javascript">
function check_flag()
{
	var flag=$('#flag_val').val();
	if(flag=='1')
	{
		voucherStep('get_delivery');		
	}else{
		$('#infoMsg').html('Please add some items to basket');	
	}
}

function back_to_show_vouchers()
{
	show_brands('<?php echo $last['cat_id'];?>','<?php echo $last['cat_name']; ?>');	
	setTimeout(function(){show_vouchers('<?php echo $last['brand_id']; ?>','<?php echo $last['brand_name']; ?>','<?php echo $last['cat_id']; ?>','<?php echo $last['brand_thumb']; ?>')},300);
}

function update_qty(num,pr_id,qty)
{
	$('#item_'+num).html('<input type="text" id="item_qty_inp_'+num+'" value="'+qty+'"/><a href="javascript://" onclick="save_qty_val(\''+num+'\',\''+pr_id+'\',\''+qty+'\');">Save</a>');	
	/*$.post(site_url+'/home/add_product_qty/'+num+'/'+pr_id+'/'+action,function(data){
		$('#banner').html(data);
	});*/	
}

function save_qty_val(num,pr_id,qty)
{
	var qty=$('#item_qty_inp_'+num).val();
	showLoading('#banner');
	$.post(site_url+'/home/add_product_qty/'+num+'/'+pr_id+'/'+qty,function(data){
		$('#banner').html(data);
	});	
}
</script>