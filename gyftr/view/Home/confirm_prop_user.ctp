<div id="form_section" id="confirm_contri_div" style="margin:0 0 5px 0; padding:0 1%;">
<span class="select_dele">/ / Proposed Contributor <strong> Details</strong></span>
<form id="AddPropUserForm" name="AddPropUserForm" method="post" action="" onSubmit="return accept_prop_user();">
<input type="hidden" name="prop_id" value="<?php echo $prop['PropUser']['id']; ?>"/>
<input type="hidden" name="order_id" value="<?php echo $prop['PropUser']['order_id']; ?>"/>
<input type="hidden" id="max_contri_allowed" value="<?php echo $max_contri_allowed; ?>"/>
<div class="comn_box recipient">
            
            <div class="detail_row">
            <label>Name:</label>
            <span class="detail"><input type="text"  name="name" value="<?php echo $prop['PropUser']['name']; ?>" class="validate[required]"/></span>
            </div>
            
            <div class="detail_row">
            <label>Email:</label>
            <span class="detail"><input type="text"  name="email" value="<?php echo $prop['PropUser']['email']; ?>" class="validate[required,custom[email]]"/></span>
            </div>
          	
            <div class="detail_row last">
            <label>Mobile No.:</label>
            <span class="detail"><input type="text"  name="phone" value="<?php echo $prop['PropUser']['phone']; ?>" class="validate[required]"/></span>
            </div>
            <div id="info_msg" style="display:none;"></div>
            <?php if($order['Order']['contri_type']!=1){ ?>
             <div class="detail_row last">
            <label>Expected Contribution:</label>
            <span class="detail"><?php if($order['Order']['contri_type']==0){ echo $equal; ?><input type="hidden" name="contri_expected" value="<?php echo $equal; ?>"/><?php }else if($order['Order']['contri_type']==2){  ?><input type="text" id="contri_expected"  name="contri_expected" value="" class="validate[required,custom[integer],min[1]]"/><?php } ?></span>
            </div>
            <?php } ?>
            </div>
         <input type="submit" class="done" value="submit" onClick="return accept_prop_user();"/>   
</form>


</div>
<script type="text/javascript">
$(document).ready(function(e) {
     $("#AddPropUserForm").validationEngine({promptPosition: "topLeft"});
});

function accept_prop_user()
{
	var valid = $("#AddPropUserForm").validationEngine('validate');
	if(valid)
	{ 
		var max_allow=$('#max_contri_allowed').val();
		var contri_exp=$('#contri_expected').val();
		
			var frm=$('#AddPropUserForm').serialize();
			$.post(site_url+'/home/accept_prop_user',frm,function(data){
				if(data=='already')
				{
					$('#confirm_contri_div').html('Contributor already added.');
					setTimeout(function(){$.fancybox.close();},3000);	
				}else{
					redirect_to_summary(data);
					$.fancybox.close();	
				}
			});	
		
	}else{
			$("#AddPropUserForm").validationEngine();
		}
	return false;	
}
</script>