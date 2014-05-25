<div id="form_section" class="updatePassDiv" style="margin:0 0 5px 0; padding:0 1%;">
<span class="select_dele">/ / Select <strong> Password</strong></span>
<div id="infoMsg">Password and Confirm Password does not match!</div>
<form id="passwordForm" name="passwordForm" method="post" action="" onSubmit="return update_password();">
<input type="hidden" name="userid" value="<?php echo $this->Session->read('User.User.id');?>"/>
<div class="comn_box recipient">
            
            <div class="detail_row">
            <label>Update Password: </label>
          	 <span class="detail"><input type="password" id="passwd" name="passwd" value="" class="validate[required,minSize[6]]"/></span>
            </div>
              <div class="detail_row">
            <label>Confirm Password: </label>
          	 <span class="detail"><input type="password" id="conf_passwd" name="con_passwd" value="" class="validate[required]"/></span>
            </div>
            
</div>
<input type="submit" class="done" value="submit"/>   
</form>

</div>
<script type="text/javascript">
$(document).ready(function(e) {
     $("#passwordForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
});

function update_password()
{
	var valid = $("#passwordForm").validationEngine('validate');
	if(valid)
	{ 
		var pass=$('#passwd').val();
		var conf=$('#conf_passwd').val();
		if(pass==conf)
		{
			$.post(site_url+'/users/update_password',$('#passwordForm').serialize(),function(data){
				$('.updatePassDiv').html('Password updated successfully.');
				setTimeout(function(){$.fancybox.close();},1500);
			});
		}else{
			$('#infoMsg').show();
		}
	}else{
			$("#passwordForm").validationEngine({scroll:false,focusFirstField : false});
			shakeField();
		}
	return false;	
}
</script>