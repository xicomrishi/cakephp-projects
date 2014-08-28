<?php /*
if(!isset($usertype))
echo $this->Html->link('NEW USER SIGN UP',array('controller'=>'users','action'=>'NewUser'),array('class'=>'sign_up_btn'));
else
echo $this->Html->link('NEW USER SIGN UP',array('controller'=>'users','action'=>'NewUser',4),array('class'=>'sign_up_btn')); */
?>

<?php if(!isset($usertype)){?> 
  <section class="social_singin_row">
  <h3>Social Sign-In</h3>
  <?php echo $this->Html->link($this->Html->image('facebook_btn.png', array('alt' => 'Facebook Login', 'border' => '0')), 'javascript:myfunc();', array('escape' => false, 'class' => 'facebook_btn')); ?>
  <?php echo $this->Html->link($this->Html->image('linkedin_btn.png', array('alt' => 'Linkedin Login', 'border' => '0')), array('controller'=>'linkedin','action'=>'auth'), array('escape' => false, 'class' => 'linkedin_btn')); ?>
  </section>
  <?php }?>
    <div id="err_checkbox" class="error" style="display:none">Please tick the checkbox for terms and conditions.</div>
  <div id="error_login" class="error"><?php echo $this->Session->flash(); ?></div>
  <section class="pop_up_detail" id="logindisplay">
  <form id="loginForm" name="frmlogin" method="post" action="">
   <input type="hidden" name="qrystring" id="qrystring" value="<?php if(isset($qrystring['qry'])){ echo $qrystring['qry'];}?>"/>
  <fieldset>
  <h3>E-mail Sign-In</h3>
  <span class="row">
  <input type="text" value="E-mail" id="login_email" name="login_email" onBlur="if(this.value=='')this.value='E-mail'" onFocus="if(this.value=='E-mail')this.value=''" class="required email">
  </span>
  <span class="row">
  <input type="password" value="Password" id="TR_login_password" name="TR_login_password" onBlur="if(this.value=='')this.value='Password'" onFocus="if(this.value=='Password')this.value=''" class="required">
  </span>
  <?php if(isset($usertype)) echo "<input type='hidden' id='usertype' name='usertype' value='$usertype'>"; else{?>
  <span class="row">
  <select id="usertype" name="usertype">
  	<option selected="" value="3">Job Seeker</option>
	<option value="2">Coach</option>
	<option value="1">Agency</option>
  </select>
  </span>
  <?php }?>
  <span class="forget_password"><a href="javascript://" onclick="forgotpass();">RESET PASSWORD?</a></span>
  <span class="row">
 	<input type="submit" value="SIGN IN" class="sing_in" style="width:76px;"/>
 <!--<a href="javascript://" onclick="loginsubmit();" class="sing_in">SIGN IN</a>-->
  </span>
  </fieldset>
  </form>
  </section>


<script language="javascript">
$(document).ready(function(e) {
	$("html, body").animate({ scrollTop: 0 }, 600);
	$('.pop_up_logo').hide();
	<?php echo $this->set("popTitle","SIGN IN");?>
	$('#loginForm').validate({
		
		submitHandler: function(form) {
			$('#error_login').hide();
			 $('#err_checkbox').hide();	
			$.post("<?php echo SITE_URL;?>/users/login",$('#loginForm').serialize(),function(data){				
				if(data!='admin' && data!="")
					{ 
						if(data=='coach_added_client'){
							window.location.href='<?php echo SITE_URL;?>/info/terms_of_service/1';
						}else{
							$('#error_login').html(data);
							$('#error_login').fadeIn('fast');
						}
					}else if(data=='admin')
						{
							window.location.href='<?php echo SITE_URL;?>/admin';
					}else{
                        utype=$('#usertype').val();
						url="";
						switch(utype){
							case '1': url="<?php echo SITE_URL;?>/dashboard/index";break;
							case '2': var qrystring=$('#qrystring').val();
										if(qrystring)
										{
										var qrystringArr=qrystring.split(",");										
										if(qrystringArr.length>0)
										{
											if(qrystringArr.length>2)											
											url="<?php echo SITE_URL;?>/"+qrystringArr[0]+"/"+qrystringArr[1]+"/"+qrystringArr[2];
											else
												url="<?php echo SITE_URL;?>/"+qrystringArr[0]+"/"+qrystringArr[1];
																 
										}
										}
										else							 	
											 url="<?php echo SITE_URL;?>/coach/index";
										break;
							case '3':  var qrystring=$('#qrystring').val();
										if(qrystring)
										{
										var qrystringArr=qrystring.split(",");										
										if(qrystringArr.length>0)
										{
											if(qrystringArr.length>2)											
											url="<?php echo SITE_URL;?>/"+qrystringArr[0]+"/"+qrystringArr[1]+"/"+qrystringArr[2];
											else
												url="<?php echo SITE_URL;?>/"+qrystringArr[0]+"/"+qrystringArr[1];
																 
										}
										}
										else							 	
											 url="<?php echo SITE_URL;?>/jobcards/profileWizard";
										break;
								 }
								if(url!='')
                                     window.location.href=url;
								else
									document.location.reload();
										
                               }
				
			});
		}
	});
	

});

function forgotpass()
{
	disablePopup();
	setTimeout(function(){ loadPopup('<?php echo SITE_URL;?>/users/forgotpass/<?php if(isset($usertype)) echo $usertype;?>'); },1000);
	/*$.post("<?php echo SITE_URL;?>/users/forgotpass",{pass:'pass'},function(data){
				$('.pop_up_detail').html(data);
				
			});	*/
	
}

	
 
</script>
<script type="text/javascript">
function myfunc() {
  FB.login(function(response) {
    window.location.href='<?php echo SITE_URL;?>/users/fblogin/';
  }, {scope:'email,read_mailbox,publish_stream,user_work_history,friends_work_history,user_location,friends_location,user_education_history,friends_education_history,offline_access'});
}

</script>


<?php echo $this->Js->writeBuffer(); ?>	  

  