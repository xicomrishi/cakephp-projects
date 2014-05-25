<?php echo $this->Html->css('jquery.ui.autocomplete');?>
<?php echo $this->Html->script(array('jquery.ui.core.min','jquery.ui.widget','jquery.ui.position','jquery.ui.menu','jquery.ui.autocomplete'));?>
<?php echo 	$this->Html->script('ckeditor/ckeditor');?>
<style>
.ui-autocomplete{width:213 !important;
	word-wrap:break-word !important;
	z-index:99999999 !important;
	background:#ccc;
}
.ui-menu-item{ list-style:none !important;  float:left; width:100%; margin:0px}	
.ui-menu-item a{ font-size:12px !important; float:left; width:100% !important; padding:5px 0 !important; text-decoration:none}
.ui-menu-item:hover a{ color:#fff !important; background-color:#F07700 !important; text-decoration:none}
</style>
<div id="searchSection">
<form id="productSearch" name="productSearch" method="post" action="" onsubmit="return search_product();">
	<div style="float:left; width:100%">
    <label style="padding:10px 10px 0 0; font-size:14px;line-height:16px; width:auto !important;">Voucher Name: </label>
    <input type="text" id="pr_name" name="pr_name" value=""/>
    <input type="submit" value="Search" onclick="return search_product();"  style="margin:0 0 0 10px; padding:10px 8px"/>
    </div>
</form>
</div>
<?php //echo $this->Html->link('Add Product',array('controller'=>'products','action'=>'add_product'));?>
<div id="resultSection">
</div>


<script type="text/javascript">
$(document).ready(function(e) {
	
    	var availableTags=[<?php 
			$last=count($products); 
			$m=1;
			foreach($products as $p ){ 
				if($m==$last){
					echo '"'.$p['BrandProduct']['voucher_name'].'"';
					}else{
						echo '"'.$p['BrandProduct']['voucher_name'].'",'; } }?>];
			
	$( "#pr_name" ).autocomplete({
			source: availableTags,focus: function( event, ui ) {
				$( "#pr_name" ).val( ui.item.label );
				return false;
			}
		});
});

function search_product()
{
	var valid = $("#productSearch").validationEngine('validate');
	if(valid)
	{
		var frm=$('#productSearch').serialize();
		
		$.post('<?php echo SITE_URL; ?>/products/get_product_details',frm,function(data){	
			$('#resultSection').html(data);	
			$('#resultSection').show();		
		});		
	}else{
		$("#productSearch").validationEngine();
	}
	return false;	
}
</script>