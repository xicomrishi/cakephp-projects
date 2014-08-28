<style>
div.error{display:block;text-align:center}
</style>
<section class="tabing_container">


        <section class="tabing">
          <ul>
            <li id="update_cred" class="active last"><a href="javascript://">UPDATE CREDENTIALS</a></li>
          </ul>
        </section>
		<section class="setting_section">
<div id="returnMsg" align="center" style=" display:none;margin-top:10px;"></div>
        <section class="box">
        <form id="passwordForm" name="passwordForm" action="" method="post">       
        <fieldset>
        <section class="row">
        <label class="large">Old Password</label>
        <input type="password" name="data[Account][old_password]" id="old_pass" class="required"/>
        </section>
        <section class="row">
        <label class="large">New Password</label>
        <input type="password" name="data[Account][new_password]" id="new_pass" class="required" minlength="6"/>
        </section>
        <section class="row">
        <label class="large">Confirm Password</label>
        <input type="password" id="confirm_pass" class="required">
        </section>
        <section class="row last">
        <input type="submit" value="Update" onclick="updatePasswd();" class="submitbtn"/>
        <!--<a href="#">update</a>-->
        </section>
        </fieldset>
        </form>
        </section>
                

        </section>
        
      </section>
	  
<script language="javascript">
$(document).ready(function(e) {
setTimeout($('#flashmsg').fadeOut('slow'),500000);
});
function updatePasswd()
{
			
					$('#passwordForm').validate({
						debug:false,
						submitHandler: function(form){
							var new_pass=$('#new_pass').val();
							var confirm_pass=$('#confirm_pass').val();
			
							if(new_pass!=confirm_pass)
							{
								alert('New Password & Confirm Password does not match! Please enter password again.');
							}
							else{
							$.post("<?php echo SITE_URL;?>/super/change_pass",$('#passwordForm').serialize(),function(data){
								if(data=='Old password does not match! Please try again.'){
									$('#returnMsg').addClass('error');
									
									}
									else
									{
										$('#returnMsg').removeClass('error');
										}
									$('#returnMsg').html(data);
									$('#returnMsg').fadeIn('slow');
									setTimeout(function(){$('#returnMsg').fadeOut('slow')},3000);
				
								});
							}
						}
					});	
			
				

}        

</script>

<?php echo $this->Js->writeBuffer(); ?>		  