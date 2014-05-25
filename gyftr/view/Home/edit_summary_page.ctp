<div id="form_section" style="margin:0 0 5px 0; padding:0 1%;">
<span class="select_dele">/ / Edit <strong> Details</strong></span>
<form id="editSummaryPage" name="editSummaryPage" method="post" action="" onSubmit="return update_gpsummary_page('<?php echo $num; ?>');">
<input type="hidden" name="fb_id" value="<?php echo $fr['fb_id']; ?>"/>

<input type="hidden" name="contri_exp" value="<?php echo $fr['contri_exp']; ?>"/>
<div class="comn_box recipient">
            
            <div class="detail_row">
            <label>Name:</label>
            <span class="detail"><input type="text"  name="name" value="<?php echo $fr['name']; ?>" class="validate[required]"/></span>
            </div>
            
            <div class="detail_row">
            <label>Email:</label>
            <span class="detail"><input type="text"  name="email" value="<?php echo $fr['email']; ?>" class="validate[required,custom[email]]"/></span>
            </div>
          	
            <div class="detail_row last">
            <label>Mobile No.:</label>
            <span class="detail"><input type="text"  name="phone" maxlength="10" value="<?php if(isset($fr['phone'])){ echo $fr['phone']; }?>" class="validate[required,custom[integer],minSize[10],maxSize[10]]"/></span>
            </div>
            </div>
         <input type="submit" class="done" value="submit"/>   
</form>


</div>
<script type="text/javascript">
$(document).ready(function(e) {
     $("#editSummaryPage").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
});

function update_gpsummary_page(num)
{
	var valid = $("#editSummaryPage").validationEngine('validate');
	if(valid)
	{ 
		var frm=$('#editSummaryPage').serialize();
		$.post(site_url+'/home/update_gpsummary/'+num,frm,function(data){
			var resp=unescape(data);
			var resp=resp.split('|');
			$('#summary_frname_'+num).html(resp[0]);
			$('#summary_fremail_'+num).html(resp[1]);
			$('#summary_frphone_'+num).html(resp[2]);
			//alert(data);
			$.fancybox.close();	
		});	
	}else{
			$("#editSummaryPage").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
		}
	return false;	
}
</script>