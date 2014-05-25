<div id="form_section" style="margin:0 0 5px 0; padding:0 1%;">
<span class="select_dele">/ / Edit <strong> Details</strong></span>
<form id="editGPStatusPage" name="editGPStatusPage" method="post" action="" onSubmit="return update_gpstatus_page();">
<input type="hidden" name="ord_id" value="<?php echo $user['GroupGift']['order_id']; ?>"/>
<input type="hidden" name="gp_id" value="<?php echo $user['GroupGift']['id']; ?>"/>
<input type="hidden" id="min_contri_allowed" value="<?php if(isset($user['GroupGift']['contri_amount_expected'])&&!empty($user['GroupGift']['contri_amount_expected'])) echo $user['GroupGift']['contri_amount_expected']; else echo '1'; ?>"/>
<div class="comn_box recipient">
            
            <div class="detail_row">
            <label>Name:</label>
            <span class="detail"><input type="text"  name="name" value="<?php echo $user['GroupGift']['name']; ?>" class="validate[required]"/></span>
            </div>
          	
            <div class="detail_row">
            <label>Email:</label>
            <span class="detail"><input type="text"  name="email" value="<?php echo $user['GroupGift']['email'];  ?>" class="validate[required,custom[email]]"/ <?php if($user['GroupGift']['other_user_id']==$this->Session->read('User.User.id')){ ?> readonly="readonly"<?php } ?>></span>
            </div>
            <div class="detail_row">
            <label>Mobile No.:</label>
            <span class="detail"><input type="text"  name="phone" maxlength="10" value="<?php if(isset($user['GroupGift']['phone'])) echo $user['GroupGift']['phone']; ?>" class="validate[custom[integer],minSize[10],maxSize[10]]"/></span>
            </div>
            <div id="info_msg" style="display:none;"></div>
            <div class="detail_row last">
            <label>Expected Contribution:</label>
            <span class="detail"><input type="text" id="contri_expected"  name="contri_amount_expected" value="<?php if(isset($user['GroupGift']['contri_amount_expected'])) echo $user['GroupGift']['contri_amount_expected']; ?>" class="validate[required,custom[integer],min[1]]"/></span>
            <span style="color:#FF0000; display:none;" id="amount_error_msg">*Expected contribution should be more than <?php if(isset($user['GroupGift']['contri_amount_expected'])&&!empty($user['GroupGift']['contri_amount_expected'])) echo $user['GroupGift']['contri_amount_expected']; ?>.</span> 
            </div>
            </div>
         <input type="submit" class="done" value="submit" onClick="return update_gpstatus_page();"/>   
</form>


</div>
<script type="text/javascript">
$(document).ready(function(e) {
     $("#editGPStatusPage").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
});

function update_gpstatus_page()
{
	var valid = $("#editGPStatusPage").validationEngine('validate');
	if(valid)
	{ 
		var min_allow=$('#min_contri_allowed').val();
		var contri_exp=$('#contri_expected').val();
		if(parseInt(contri_exp) < parseInt(min_allow))
		{
			$('#amount_error_msg').show();
		}else{		
			var frm=$('#editGPStatusPage').serialize();
			$.post(site_url+'/home/update_gpusers',frm,function(data){
				redirect_to_summary(data);
				$.fancybox.close();	
			});
		}
		
	}else{
			$("#editGPStatusPage").validationEngine({scroll:false,focusFirstField : false});
			shakeField();
		}
	return false;	
}
</script>