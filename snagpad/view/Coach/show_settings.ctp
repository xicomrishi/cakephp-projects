<div id="returnMsg" align="center" style=" display:none;margin-top:10px;"></div>
		<div id="flashmsg" align="center" style="margin-top:10px;"><?php echo $this->Session->flash(); ?></div>
        <section class="box border">
        <form id="settingsForm" name="settingsForm" action="" method="post">
        <input type="hidden" id="coachid" name="data[Coach][id]" value="<?php echo $coachid;?>"/>
        <fieldset>
        <section class="row">
        <label>Name</label>
        <input type="text" name="data[Coach][name]" class="required" value="<?php echo $coach['Coach']['name'];?>">
        </section>
        <!--<section class="row">
        <label>Position</label>
        <input type="text" name="data[Client][position]" value="<?php echo $coach['Coach']['position']?>">
        </section>-->
        <section class="row">
        <label>Email</label>
        <input class="none" type="text" value="<?php echo $coach['Coach']['email'];?>" readonly="readonly" disabled="disabled"/>
        </section>
        <!--<section class="row">
        <label>Phone No</label>
        <input type="text" name="data[Client][phone]" class="required digits" value="<?php echo $coach['Coach']['phone']?>">
        </section>-->
        <section class="row last">
		<input type="submit" value="Update" onclick="updateDetails();" class="submitbtn"/>
        <!--<a href="javascript://" onClick="updateDetails();">update</a>-->
        </section>
        </fieldset>
        </form>
        </section>
        <section class="box">
        <form id="passwordForm" name="passwordForm" action="" method="post">
        <input type="hidden" name="data[Coach][id]" value="<?php echo $coachid;?>"/>
        
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
<script type="text/javascript">        
function updateDetails()
{	//alert(1);
	$('#settingsForm').validate({
		debug:false,
		submitHandler: function(form){
	$.post("<?php echo SITE_URL;?>/coach/settings_details",$('#settingsForm').serialize(),function(data){
					var respons=data.split("|");
					$('#user_name').html(respons[1]);
					$('#returnMsg').html(respons[0]);
					$('#returnMsg').fadeIn('slow');
					setTimeout(function(){$('#returnMsg').fadeOut('slow')},3000);

				});
		}
	});			
}

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
							$.post("<?php echo SITE_URL;?>/coach/change_pass",$('#passwordForm').serialize(),function(data){
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