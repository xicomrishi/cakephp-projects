 <div id="error3" class="error" style="display:none;"></div>
    <div id="success" class="success1" style="display:none; text-align:center; color:#090">Your password was sent to your email address, try signing in using the enclosed information.</div>  
<section class="pop_up_detail" id="logindisplay">
<form id="passForm" name="passForm" method="post" action="">
  <fieldset>
    
 
  <span class="row">
  <input type="text" value="E-mail" name="email" onBlur="if(this.value=='')this.value='E-mail'" onFocus="if(this.value=='E-mail')this.value=''" class="required email"/>
  </span>
  
  <span class="row">
  <select id="type" name="type">
  	<option selected="" value="3">Job Seeker</option>
	<option value="2">Coach</option>
	<option value="1">Agency</option>
  </select>
  </span>
 
  <span class="row">
 <input type="submit" value="Submit" class="sing_in" style="width:76px;"/>
  <!--<a href="javascript://" onclick="signupsubmit();" class="sing_in">Submit</a>-->
  </span>
  </fieldset>
  </form>
  </section>
  
<script language="javascript">
 $('#error3').hide();
		
	 $('#passForm').validate({
		
		submitHandler: function(form) {
		 $('#error3').hide();
		
		
				$.post("<?php echo SITE_URL;?>/users/forgot_pass_mail",$('#passForm').serialize(),function(data){
					if(data=='Error')
					{ $('#error3').html('Email ID or user type does not match with our records.');
						$('#error3').fadeIn('fast');
					}else{
						
						$('#success').fadeIn('fast');
						setTimeout(function(){ $('#success').fadeOut('fast'); },2500);
						setTimeout(function(){ disablePopup();},3000);
						}
				});
			
		
		}
	});

</script>

<?php echo $this->Js->writeBuffer(); ?>	  