<div id="flashmsg" style="display:none; color:#33CC00;">Shop details updated successfully.</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td><strong>Shop Name</strong></td>
<td><strong>Outlet Address</strong></td>
<td><strong>City</strong></td>
<td><strong>State</strong></td>
<td><strong>Phone</strong></td>
<td><strong>Action</strong></td>
</tr>



<?php foreach($shops as $sh){ ?>
<tr>
<td><?php echo $sh['Shops']['name']; ?></td>
<td><?php echo $sh['Shops']['address']; ?></td>
<td><?php echo $sh['Shops']['city']; ?></td>
<td><?php echo $sh['Shops']['state']; ?></td>
<td><?php echo $sh['Shops']['phone']; ?></td>
<td><a href="javascript://" onclick="edit_shop('<?php echo $sh['Shops']['id']; ?>','<?php echo $pr_id; ?>');">Edit</a></td>

</tr>
<?php } ?>

<script type="text/javascript">
function edit_shop(id,pr_id)
{
	$.fancybox.open(
			{
				'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : 350,
				'type'				: 'ajax',
				'height'            : 400,
				'href'          	: '<?php echo SITE_URL; ?>/products/edit_shop/'+id+'/'+pr_id
			}
		); 	
}
function submitShopForm()
{
	var valid = $("#shopForm").validationEngine('validate');
		if(valid)
		{
			var frm=$('#shopForm').serialize();
			$.post('<?php echo SITE_URL; ?>/products/save_shop_details',frm,function(data){	
			 $("html, body").animate({ scrollTop: 0 }, 600);
				$('#flashmsg').show();	
			});		
		}else{
			$("#shopForm").validationEngine();
		}
		return false;
}
</script>