<section id="login_container" class="personal_detail">
	<div class="login_details personal_detail">	
		<h3 class="title">Trainer Details - Trainer ID - <?php echo $trainer['Trainer']['trainer_id'];  ?></h3>
		
        <section class="signup_form">
        
         	 <div class="common_section">     	
               
                <p><label>Name:</label><span><?php echo $trainer['User']['first_name'].' '.$trainer['User']['last_name']; ?></span></p>
                <p><label>Email:</label><span><?php echo $trainer['User']['email']; ?></span></p>
                <p><label>Trainer ID:</label><span><?php echo $trainer['Trainer']['trainer_id']; ?></span></p>
                                 
            </div>
            <div class="common_section" id="right_sec"> 
            <form id="resetPassForm" name="resetPassForm" action="" method="post">
            	<input type="hidden" name="user_id" value="<?php echo $trainer['User']['id']; ?>"/>
            	<p><label>Password: </label><input type="text" id="new_pass" class="validate[required,minSize[8]]" name="new_password"/><span><a href="javascript://" onclick="generate_password();">Generate Password</a></span></p>
                <p><label>&nbsp;</label><input type="button" id="reset_button" value="Reset" onclick="reset_pass();"/></p>
              </form>  
            </div>              
        </section>
     </div>
</section>

<script type="text/javascript">
function generate_password()
{
	$.post(site_url+'/users/generateRandomString/8/1',function(data){
		$('#new_pass').val(data);	
	});	
}
function reset_pass()
{
	var valid = $("#resetPassForm").validationEngine('validate');
	if(valid)
	{	
		$('#reset_button').removeAttr('onclick');
		setTimeout(function(){ $('#reset_button').attr('onclick','reset_pass();')},1500);
		$('#right_sec').append('<div id="up_msg">Updating password <img src="<?php echo $this->webroot; ?>img/fancybox_loading.gif" alt="..."/></div>');
		$.post(site_url+'/users/update_password',$('#resetPassForm').serialize(),function(data){
			$('#up_msg').html('Password updated successfully.');
			setTimeout(function(){ $('#up_msg').hide(); },3000);	
		});	
	}
}
</script>