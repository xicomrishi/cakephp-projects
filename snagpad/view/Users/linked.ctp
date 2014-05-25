 <div id="error" style="display:none; margin-left:228px; margin-top:35px;"></div>
    <div id="success" style="display:none; margin-top:120px; font-size:19px;" align="center">Please check your email to verify your account.</div> 
<section class="pop_up_detail" id="logindisplay"> 
<form id="passForm" name="passForm" method="post" action="">
  <fieldset>
    
 
  <span class="row">
  <input type="text" value="E-mail" name="email" onBlur="if(this.value=='')this.value='E-mail'" onFocus="if(this.value=='E-mail')this.value=''" class="required email"/>
  </span>
  
  <span class="row">
 <input type="submit" value="Submit" class="sing_in" style="width:76px;"/>
  <!--<a href="javascript://" onclick="signupsubmit();" class="sing_in">Submit</a>-->
  </span>
  </fieldset>
  </form>
  </section>
<script language="javascript">
 $('#error').hide();
		
	 $('#passForm').validate({
		
		submitHandler: function(form) {
		 $('#error').hide();
		
				$.post("<?php echo SITE_URL;?>/users/linked_mail",$('#passForm').serialize(),function(data){
                                               // $('#success').html(data);
						$('#logindisplay').fadeOut('fast');
						$('#success').fadeIn('fast');
						

				});
			
		
		}
	});

</script>

<?php echo $this->Js->writeBuffer(); ?>	  