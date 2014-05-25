<div id="err_checkbox" class="error" style="display:none;" align="center">Please tick the checkbox for terms and conditions.</div>
  <div id="error2" class="error" style="display:none;" align="center"></div>
    <div id="success" style="display:none;" class="success">Please check your email to verify your account.</div>  
  <div align="center"><?php echo $this->Session->flash(); ?></div>
  
 <section class="pop_up_detail" id="signupdisplay">
  <form id="signupForm" name="frmsignup" method="post" action="">
  <fieldset>
    <div class="sign_up_row">
    <h3>E-mail Sign-Up</h3>
  <span class="row">
  <?php if(isset($agency_id)) echo "<input type='hidden' name='agencyid' value='$agency_id'>";?>
  <input type="text" id="username" value="Name" name="name" onBlur="if(this.value=='')this.value='Name'" onFocus="if(this.value=='Name')this.value=''" class="required">
  </span>
  <?php if(isset($usertype) && $usertype==4){?>
  <span class="row">
  <input type="text" value="Company Name" name="company_name" onBlur="if(this.value=='')this.value='Company Name'" onFocus="if(this.value=='Company Name')this.value=''" class="required"/><input type="hidden" name="usertype" value="4">
  </span>
  
  
  <?php }else echo '<input type="hidden" name="usertype" value="3">';?>

  <span class="row">
  <input type="text" value="E-mail" name="email" onBlur="if(this.value=='')this.value='E-mail'" onFocus="if(this.value=='E-mail')this.value=''" class="required email"/><input type="hidden" name="usertype" value="3">
  </span>
  
  <span class="row">
  <input type="checkbox" id="TR_terms" name="TR_terms" style="float:left; padding:0px; margin:0 7px 0 41px; width:4%; border:none">&nbsp;<label for="TR_terms" style="float:left;">I agree with <a href="<?php echo SITE_URL;?>/info/terms_of_service" target="_blank">Terms &amp; Conditions</a></label> 
  </span>
 
 
  <span class="row">
 <input type="submit" value="Submit" class="sing_in" style="width:76px;"/>
  <!--<a href="javascript://" onclick="signupsubmit();" class="sing_in">Submit</a>-->
  </span>
  </div>
  <div class="sign_up_row">
  <h3>Social Sign-Up</h3>
  <span class="row" style="padding:0 0 20px 0">
  <?php echo $this->Html->link($this->Html->image('facebook_btn.png', array('alt' => 'Facebook Login', 'border' => '0')), 'javascript:myfunc();', array('escape' => false, 'class' => '')); ?>
  </span>
  <span class="row">
  <?php echo $this->Html->link($this->Html->image('linkedin_btn.png', array('alt' => 'Linkedin Login', 'border' => '0')), array('controller'=>'linkedin','action'=>'auth'), array('escape' => false, 'class' => '')); ?>
  </span>
  <span class="row">
  <p>Already have an account? <a href="javascript://" onclick="show_signin();">Sign in here</a></p>
  </span>
  </div>
  </fieldset>
  </form>
  </section>

 

<script language="javascript">
$(document).ready(function(e) {
	
   $('#error2').hide();

	 $('#signupForm').validate({
		
		submitHandler: function(form) {
		$('#error2').hide();
		 $('#err_checkbox').hide();	
		 var name=$('#username').val();
		 if(name=='Name')
		 {
			 $('#error2').html('Please enter your name');
			 $('#error2').show();
			 return false;
			 }
		var checkbox=document.getElementById('TR_terms');
		if(checkbox.checked==true)
		{	
				$.post("<?php echo SITE_URL;?>/users/createAccount",$('#signupForm').serialize(),function(data){
					if(data=='Error')
					{ $('#error2').html('Email Id already exists!');
						$('#error2').fadeIn('fast');
					}else{
						 $('#err_checkbox').hide();	
						$('#success').fadeIn('fast');
						//setTimeout(function(){ window.location="<?php echo SITE_URL;?>"},2500);
						
						}
				});
			
		}else{
			
			$('#err_checkbox').show();
			}
		}
	});
});

function show_signin()
{
	disablePopup();
	setTimeout(function(){ loadPopup('<?php echo SITE_URL; ?>/users/login');},2000);	
}
	
</script>
<script type="text/javascript">
function myfunc() {
  FB.login(function(response) {
    window.location.href='<?php echo SITE_URL;?>/users/fblogin/';
  }, {scope:'email,read_stream,publish_stream,user_work_history,friends_work_history,user_location,friends_location,user_education_history,friends_education_history,offline_access'});
}

</script>

<?php echo $this->Js->writeBuffer(); ?>	  
  