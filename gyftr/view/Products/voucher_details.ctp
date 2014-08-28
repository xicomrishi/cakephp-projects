<div id="flashmsg" style="display:none; color:#33CC00;">Voucher details updated successfully.</div>
<form id="voucherForm" name="voucherForm" method="post" action="" onsubmit="return save_voucher();">
<input type="hidden" name="product_id" value="<?php echo $product['BrandProduct']['id']; ?>"/>
<div>
<label>Brand Details: </label>
<input type="text" name="brand_details" class="validate[required]" readonly="readonly"  value="<?php echo $brand['GiftBrand']['name'];  ?>"/>
</div>
<div>
<label>Validity: </label>
<input type="text" name="voucher_expiry" class="validate[required]"  value="<?php echo $product['BrandProduct']['voucher_expiry'];  ?>"/>
</div>
<div>
<label>Value: </label>
<input type="text" name="price" class="validate[required]"  value="<?php echo $product['BrandProduct']['price'];  ?>"/>
</div>
<div>
<label>Available Quantity: </label>
<input type="text" name="available_qty" class="validate[required]"  value="<?php echo $product['BrandProduct']['available_qty'];  ?>"/>
</div>
<div>
<label>Discount (in %): </label>
<input type="text" name="discount" class="validate[required]"  value="<?php echo $product['BrandProduct']['discount'];  ?>"/>
</div>
<div>
<input type="submit" value="Submit" onclick="return save_voucher();"/>
</div>
</form>
<script type="text/javascript">

$(document).ready(function(e) {
    $("#voucherForm").validationEngine();
});
function save_voucher()
{
	var valid = $("#voucherForm").validationEngine('validate');
		if(valid)
		{
			var frm=$('#voucherForm').serialize();
			$.post('<?php echo SITE_URL; ?>/products/save_voucher_details',frm,function(data){	
			
			 $("html, body").animate({ scrollTop: 0 }, 600);
				$('#flashmsg').show();	
			});		
		}else{
			$("#voucherForm").validationEngine();
		}
		return false;
}
</script>