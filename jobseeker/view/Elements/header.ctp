<style type="text/css">
.success{ float:none !important;}
</style>
<div id="header_outer">
<div class="wrapper">
  <header> 
    <?php
 
	$prof=$this->Session->read('Professional');
	$recprof=$this->Session->read('Recruiter');
	$homeURL=$this->webroot.'home';
	
 	if(isset($prof)){
 		$homeURL=$this->webroot.'professionals/profile';
 	?>
	 <div class="profile_btn">
      <span class="bg_img">
       <input type="button" value="<?php if(isset($prof['Professional']['first_name'])){ echo ucfirst($prof['Professional']['first_name']);}?>" class="k-hover-trigger" id="btn_profile" />
      </span>
	  <ul class="drop_down1">		
		<li>
         <a href="#">
          <img src="<?php echo $this->webroot;?>images/edit_profile.png" alt=""><small>Edit Profile</small>
         </a>
        </li>		
		<li>
         <a href="<?php echo $this->webroot;?>professionals/professional_settings">
          <img src="<?php echo $this->webroot;?>images/setting.png" alt=""><small>Settings</small>
         </a>
        </li>		
		<li class="last">
		 <a href="<?php echo $this->webroot;?>professionals/logout">
		  <img src="<?php echo $this->webroot;?>images/logout_bg.png" alt=""><small>Log Out</small>
         </a>
        </li>
		</ul>
	 </div>
	 
 <?php }elseif(isset($recprof)){
 	$homeURL=$this->webroot.'recruiters/profile';
 	?>
	 <div class="profile_btn"><span class="bg_img"><input type="button"
		value="<?php if(isset($recprof['Recruiter']['first_name'])){ echo ucfirst($recprof['Recruiter']['first_name']);}?>" class="k-hover-trigger" id="btn_profile" /></span>
		<ul class="drop_down1">
		
		<li><a href="<?php echo $this->webroot; ?>recruiters/edit_profile"><img
			src="<?php echo $this->webroot;?>images/edit_profile.png" alt=""><small>Edit Profile</small></a></li>
		
		<li><a href="<?php echo $this->webroot;?>recruiters/recruiter_settings"><img src="<?php echo $this->webroot;?>images/setting.png" alt=""><small>Settings</small></a></li>
		
		<li class="last">
		<a href="<?php echo $this->webroot;?>recruiters/logout">
		<img src="<?php echo $this->webroot;?>images/logout_bg.png" alt=""><small>Log Out</small></a></li>
		</ul>
	 </div>
 <?php }else{?> 
 
  <div class="login_btn">
   <?php if(!in_array($this->action,array('professional_signup'))){?>
     <input type="button" value="Log in" class="k-hover-trigger"  id="btn_login"/>
     <div style="display:none;" class="banner_right hover_card" id="wnd_login">
  	   <div class="banner_right_inner">
        	<div class="search_box" id="loginbox">
            <?php $email_val='Enter Email';
			if($this->Session->check('login_error')){?>
            <div class="error_msg"><?php echo $this->Session->read('login_error.msg');
			$email_val=$this->Session->read('login_error.email');?></div>
            <?php }?>
             
            	<form accept-charset="utf-8" method="post" id="ProfessionalIndexForm" action="<?php echo $this->webroot;?>logins/user_verify_login">
						
                    <fieldset>
                                    	<div style="display:none;">
                    	<input type="hidden" value="POST" name="_method">
                    </div>
             			<div class="input_bg required">
                       
                        	<input type="text" id="ProfessionalEmail" maxlength="255" onblur="if(this.value=='')this.value='Enter Email'" 
                        	onfocus="if(this.value=='Enter Email')this.value=''" value="<?php echo $email_val;?>" class="validate[required,custom[email]]" name="data[Login][email]"
                        	data-errormessage-value-missing="Please enter email id" data-errormessage ="Please enter valid email id">
                         </div>
                         <div class="input_bg required">
                         	<input type="password" id="ProfessionalPassword" 
                         	 onblur="if(this.value=='')this.value='Password'" 
                         	 onfocus="if(this.value=='Password')this.value=''" value="Password" class="validate[required]"
                         	 name="data[Login][password]" data-errormessage-value-missing="Please enter password">
                         </div>
                        <!-- <div class="input_bg required">
                         	<select name="data[Login][user_role]" class="validate[required]" id="UserRole" data-errormessage-value-missing="Please select role">
                            <option value="">Select Role</option>
                            <option value="3">Professional</option>
                            <option value="4">Recruiter</option>
                            </select>
                         	
                         </div>-->
                     
                     <div class="submit">
                     	<input type="submit" value="Log In" class="signin_bg">
                     </div>
                     </fieldset>
                 </form>
                 
            </div>
            <div style="display:none; width:80%" class="search_box" id="forgotpass">
             <div id="success_msg"></div>
                <form accept-charset="utf-8" method="post" id="forgot_pass" name="forgot_pass" action="#" onsubmit="return sendForgotPasswordMail();">
                
                <fieldset>
              
                	<div style="display:none;">
                    	<input type="hidden" value="POST" name="_method">
                    </div>
                    
                    	<div class="input_bg required">
                        	<input type="text" id="ProfessionalEmail" maxlength="255" onBlur="if(this.value=='')this.value='Enter Email'" onFocus="if(this.value=='Enter Email')this.value=''" data-validation-placeholder="Enter Email" value="Enter Email" class="validate[required,custom[email]]" name="data[Login][email]" data-errormessage-value-missing="Please enter email id">
                        </div>
                         <!--<div class="input_bg required">
                         	<select name="data[Login][user_role]" class="validate[required]" id="UserRole" data-errormessage-value-missing="Please select role">
                            <option value="">Select Role</option>
                            <option value="3">Professional</option>
                            <option value="4">Recruiter</option>
                            </select>
                         	
                         </div>-->
                       	<div class="submit">
                        	<input type="submit" value="Submit" class="signin_bg">
                        </div>
                       
                     </fieldset>
                     
                </form>
            </div>
            <a class="forgot_password" href="javascript:void(0);" onClick="javascript:$('#loginbox').hide();$('.social_icon').hide();$('#forgotpass').show();$('.forgot_password').show();$(this).hide();" id="fpass">Trouble logging in?</a>
            <a class="forgot_password" href="javascript:void(0);" onClick="javascript:$('#forgotpass').hide();$('#loginbox').show();$('.social_icon').show();$('.forgot_password').show();$(this).hide();" style="display:none" id="loginpass">Click for login</a>                    
    </div>
     <?php echo $this->Html->image('ajax-loader.gif', array('id'=>'loader','style="display:none"'));?>
  </div>
   <?php }else{?>&nbsp;<?php }?>
  </div>
 <?php }?>
  <section class="navi">
  <ul>
  <li class="active"><a href="<?php echo $homeURL;?>">Home</a></li> 
  
  <li><a href="<?php echo $this->webroot;?>professionals/profile">Professionals</a></li>
  <li><a href="<?php echo $this->webroot;?>recruiters/profile" >Recruiters</a></li>
  <li><a href="<?php echo $this->webroot;?>cms/page/faqs">FAQs</a></li>
  <li class="drop"><a href="<?php echo $this->webroot;?>cms/page/about_us" >About Us</a>
  		<ul class="submenu">
        	<li class="last"><a href="<?php echo $this->webroot;?>contacts">Contact Us</a></li>
        </ul>
  </li>
  <li class="last blog"><a href="#">Blog</a></li>
  </ul>
  </section>
  </header>
</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
        jQuery("#ProfessionalIndexForm,#forgot_pass,#UserIndexForm").validationEngine('attach',{promptPosition: "bottomLeft",scroll: false});
		$( 'input[type="text"],input[type="email"]' ).focus(function() {
		$(this).validationEngine('hide');
		$(this).validationEngine().css({border : "1px solid #D5D0D0"});
		
			});
			$( 'input[type="text"],input[type="email"],input[type="password"]' ).blur(function() {
				var error=$(this).validationEngine('validate');
				
				if(error){
				$(this).validationEngine().css({border : "1px solid red"});
			 }
	
			});
			 <?php if($this->Session->check('login_error')){?>
			 $('#wnd_login').show();
			  setTimeout(function() {
				 $('.error_msg').remove();
				 <?php unset($_SESSION['login_error']);?>
				}, 10000 );
			 <?php }?>
			


		
    });
	function sendForgotPasswordMail()
	{
		$('#loader').show();
		
		$.post('<?php echo $this->webroot;?>logins/forget_password/',$(forgot_pass).serialize(),function(data){
			$('#loader').hide();
			
			$('#success_msg').html(data);
			document.getElementById("forgot_pass").reset();
		});
		return false;
	}
	</script>