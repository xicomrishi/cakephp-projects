<?php if(isset($showtabs)){ ?>
<div class="tabing">
          <ul class="gap">
            <li id="tnc_li" class="active tnc_li tabs_li" onclick="show_module('tnc_li','<?php echo $product['BrandProduct']['id']; ?>');"><a href="javascript://">Terms &amp; Conditions</a></li>
            <li id="shops_li" class="shops_li tabs_li" onClick="show_module('shops_li','<?php echo $product['BrandProduct']['id']; ?>');"><a href="javascript://"><span>Shops</span></a></li>
            <li id="voucher_li" class="voucher_li tabs_li" onclick="show_module('voucher_li','<?php echo $product['BrandProduct']['id']; ?>');"><a href="javascript://">Voucher</a></li>
          </ul>
        </div>
<?php } ?>        
        
<div id="module_content">
<div id="flashmsg" style="display:none; color:#33CC00;">Terms &amp; Conditions updated successfully.</div>
<form id="tncForm" name="tncForm" method="post" action="" onsubmit="return submit_tnc();">
<input type="hidden" id="voucher_id" value="<?php echo $product['BrandProduct']['id'];?>"/>
<div>
<label style="font-size:15px; line-height:17px; color:#333; padding:0 0 10px 0; width:auto !important">Terms &amp; Conditions: </label>
<textarea id="product_tnc" class="ckeditor" name="product_tnc"><?php echo nl2br($product['BrandProduct']['product_tnc']); ?></textarea>
</div>
<div>
<input type="submit" value="submit" onClick="return submit_tnc();"/>
</div>
</form>
</div>        


<script type="text/javascript">
$(document).ready(function(e) {
     CKEDITOR.replace('product_tnc');	
	  
});
function show_module(mod,pr_id)
{
	$.post('<?php echo SITE_URL; ?>/products/get_module/'+mod,{pr_id:pr_id},function(data){
		$('.tabs_li').removeClass('active');
		$('#module_content').html(data);
		$('#'+mod).addClass('active');			
	});
		
}
function submit_tnc()
{
	 for ( instance in CKEDITOR.instances )
			  CKEDITOR.instances[instance].updateElement();
	
				var voucher=$('#voucher_id').val();
				var terms=$('#product_tnc').val();
				if(terms!='')
				{
				$.post('<?php echo SITE_URL; ?>/products/update_tnc/'+voucher,{terms:terms},function(data){
					 $("html, body").animate({ scrollTop: 0 }, 600);
					$('#flashmsg').show();		
				});	
				}else{
					alert('Please enter Terms & Conditions');
					}
		
	return false;
}

</script>
<?php echo $this->Js->writeBuffer(); ?>	