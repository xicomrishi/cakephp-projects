<form id="editShopForm" name="editShopForm" method="post" action="" onsubmit="return save_shop();">
<input type="hidden" name="id"  value="<?php echo $shop['Shops']['id']; ?>"/>

<div>
<label>Outlet Name: </label>
<input type="text" name="name" class="validate[required]"  value="<?php echo $shop['Shops']['name']; ?>"/>
</div>
<div>
<label>Address: </label>
<input type="text" name="address" class="validate[required]" value="<?php echo $shop['Shops']['address']; ?>"/>
</div>
<div>
<label>City: </label>
<input type="text" name="city" class="validate[required]"  value="<?php echo $shop['Shops']['city']; ?>"/>
</div>
<div>
<label>State: </label>
<input type="text" name="state" class="validate[required]" value="<?php echo $shop['Shops']['state']; ?>"/>
</div>
<div>
<label>Phone: </label>
<input type="text" name="phone" class="validate[required]"  value="<?php echo $shop['Shops']['phone']; ?>"/>
</div>
<div style="text-align:center; float:left; width:96%;">
<input type="submit" value="Submit" onclick="return save_shop();"/>
</div>
</form>
<script type="text/javascript">

$(document).ready(function(e) {
    $("#editShopForm").validationEngine({promptPosition: "topLeft"});
});

function save_shop()
{
	var valid = $("#editShopForm").validationEngine('validate');
		if(valid)
		{
			var frm=$('#editShopForm').serialize();
			$.post('<?php echo SITE_URL; ?>/products/save_shop_details',frm,function(data){	
			show_module('shops_li','<?php echo $product_id; ?>');
			$.fancybox.close();
			 $("html, body").animate({ scrollTop: 0 }, 600);
				$('#flashmsg').show();	
			});		
		}else{
			$("#editShopForm").validationEngine();
		}
		return false;
}
</script>