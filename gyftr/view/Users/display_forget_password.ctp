<div id="form_section" style="margin:0 0 5px 0; padding:0 1%;">
		<?php //echo $this->element('breadcrumb');?>
		
            <span class="select_dele">/ / Forgot <strong>Password</strong>
            </span>
            <div id="successMsg" style="display:none; color:green;">Your password is sent to your email id.</div>
            <form id="forgetPassForm" name="forgetPassForm" method="post" onsubmit="return saveForgetPassForm();" action="">
			
            <div class="comn_box gift">
         
                    
            
            <div class="detail_row">
            <label style="width:30% !important;">Email: </label>
          	<span class="detail"><input type="text" name="email" value="" class="validate[required,custom[email]]"/></span>
            </div>
           
        </div>
           <input type="submit" value="Submit" class="done"/>
            </form>
     </div>        
        
       </div>
<script type="text/javascript">
$(document).ready(function(e) {
    $("#forgetPassForm").validationEngine({scroll:false,focusFirstField : false});
	
});

function saveForgetPassForm()
{
	var valid = $("#forgetPassForm").validationEngine('validate');
	//alert(valid);
	if(valid)
	{
		var frm=$('#forgetPassForm').serialize();
		
		$.post(site_url+'/users/submit_forget_password',frm,function(data){	
			
			if(data=='error')
			{
				$('#successMsg').html('Email Id not found in database.');	
				$('#successMsg').css('color','red');
				$('#successMsg').show();
			setTimeout(function(){ $('#successMsg').hide();},5000);	
			}else{
				$('#successMsg').html('A mail is sent to your inbox.');
				$('#successMsg').css('color','green');
				$('#successMsg').show();
			setTimeout(function(){ $.fancybox.close();},3000);	
			}
			
	});	
	}else{
		$("#forgetPassForm").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
		//alert(test);
	}
	return false;		
}
</script>       
       