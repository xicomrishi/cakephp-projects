
 
  <section class="pop_up_detail" id="adminlogin">
  <div id="adminloginForm">
    <div id="error" class="error" style="display:none"></div>
    <div id="success" class="success1" style="display:none; text-align:center; color:#090">Your password was sent to your email address, try signing in using the enclosed information.</div>  

  <div id="loginfrm">

  <form id="adminloginfrm" name="frmlogin" method="post" action="">
  <fieldset>
  <h3>Login</h3>
  <span class="row">
  <input type="text" value="E-mail" id="login_email" name="login_email" onBlur="if(this.value=='')this.value='E-mail'" onFocus="if(this.value=='E-mail')this.value=''" class="required email">
  </span>
  <span class="row">
  <input type="password" value="Password" id="TR_login_password" name="TR_login_password" onBlur="if(this.value=='')this.value='Password'" onFocus="if(this.value=='Password')this.value=''" class="required">
  </span>
  <input type="hidden" name="usertype" value="0" />
  <span class="forget_password"><a href="javascript://" onclick="forgotpass();">FORGOT PASSWORD?</a></span>
  <span class="row">
 	<input type="submit" value="SIGN IN" class="sing_in" style="width:76px;"/>
 <!--<a href="javascript://" onclick="loginsubmit();" class="sing_in">SIGN IN</a>-->
  </span>
  </fieldset>
  </form>
</div>
<div id="forgetfrm" style="display:none">

<form id="passForm" name="passForm" method="post" action="">
  <fieldset>
    <h3>Forget Password</h3>
 
  <span class="row">
  <input type="text" value="E-mail" name="email" onBlur="if(this.value=='')this.value='E-mail'" onFocus="if(this.value=='E-mail')this.value=''" class="required email"/>
  </span>
  <input type="hidden" name="type" value="0" />
  <span class="row">
 <input type="submit" value="Submit" class="sing_in" style="width:76px;"/>
  <!--<a href="javascript://" onclick="signupsubmit();" class="sing_in">Submit</a>-->
  </span>
  </fieldset>
  </form>
  </div>
  </div>
  </section>
<script language="javascript">

$(document).ready(function(e) {
   $('#error').hide();
	$('#adminloginfrm').validate({		
		submitHandler: function(form) {
			$('#error').hide();
			 $('#err_checkbox').hide();	
			$.post("<?php echo SITE_URL;?>/users/login",$('#adminloginfrm').serialize(),function(data){
				//alert(data);
				if(data=='Error'||data=='Your account needs to be verified, please check your inbox.'||data=='Invalid Username or Password!')
					{ $('#error').html(data);$('#error').show();
						$('#error').fadeIn('fast');
											
					}else 
							window.location.href='<?php echo SITE_URL;?>/admin/super/';
					
			});
		}
	});
	

});
 $('#passForm').validate({
		
		submitHandler: function(form) {
		 $('#error').hide();
		
		
				$.post("<?php echo SITE_URL;?>/users/forgot_pass_mail",$('#passForm').serialize(),function(data){
					if(data=='Error')
					{ $('#error').html('Email ID does not match with our records.');
					$('#error').show();
						$('#error').fadeIn('fast');
					}else{
						
						$('#success').fadeIn('fast');
						setTimeout(function(){ $('#success').fadeOut('fast'); },2500);
	$('#loginfrm').show();
	$('#forgetfrm').hide();
						}
				});
			
		
		}
	});

function forgotpass()
{
	$('#forgetfrm').show();
	$('#loginfrm').hide();
		
}

	
 
</script>