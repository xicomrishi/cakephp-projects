<div id="returnMsg" align="center" style=" display:none;margin-top:10px;"></div>
		<div id="flashmsg" align="center" style="margin-top:10px;"><?php echo $this->Session->flash(); ?></div>
<div class="box">
<form id="passwordForm" name="passwordForm" action="" method="post">
        <input type="hidden" name="data[Agency][id]" value="<?php echo $agencyid;?>"/>
        
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
        <input type="button" value="Update" onclick="updatePasswd();" class="submitbtn"/>
        <!--<a href="#">update</a>-->
        </section>
        </fieldset>
        </form>
</div>        
<script language="javascript">
function updatePasswd()
{
		if($('#passwordForm').valid()){
							var new_pass=$('#new_pass').val();
							var confirm_pass=$('#confirm_pass').val();
			
							if(new_pass!=confirm_pass)
								alert('New Password & Confirm Password does not match! Please enter password again.');
							else{
							$.post("<?php echo SITE_URL;?>/Agency/change_pass",$('#passwordForm').serialize(),function(data){
									$('#returnMsg').html(data);
									$('#returnMsg').fadeIn('slow');
									setTimeout(function(){$('#returnMsg').fadeOut('slow')},3000);
				
								});
							}
						}
}        
</script>        
