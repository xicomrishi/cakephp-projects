<?php ?>
<section id="login_container">
	<div class="login_details">	
		<h3 class="title">Admin Login</h3>	
		<form id="LoginForm" name="LoginForm" method="post" action="<?php echo $this->webroot; ?>admin/login/verify_login">
        	<?php echo $this->Session->flash(); ?>
			<fieldset>
        		<span class="input_bg"><input class="validate[required,custom[email]] user" type="text"  title="User Name" placeholder="User Name"  name="email" />
                <input class="validate[required] pass"  type="password" placeholder="Password"  title="Password" name="password"/></span>
            	<!--<p><a href="">Forgot Your details ?</a></p>-->
            	<span class="login_bg"><input type="submit" value="Login"></span>
    		</fieldset>
		</form>
     </div>
</section>

<script type="text/javascript">
$(document).ready(function(e) {
    $("#LoginForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	setTimeout(function(){ $('#flashMessage').hide(); },4000);
});
</script>