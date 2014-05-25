<?php ?>
<section id="login_container">
	<div class="login_details">	
		<h3 class="title"><?php echo __('Login'); ?></h3>	
		<form id="LoginForm" name="LoginForm" method="post" action="<?php echo $this->webroot; ?>login/verify_trainer_login">
        	<?php echo $this->Session->flash(); ?>
			<fieldset>
        		<span class="input_bg">
                <input class="validate[required,custom[email]] user" type="text"  title="<?php echo __('User Name'); ?>" <?php if(!isset($data['email'])){ ?>placeholder="<?php echo __('User Name'); ?>"<?php } ?>  name="email" value="<?php if(isset($data['email']))  echo $data['email'];  ?>" />
                <input class="validate[required] pass"  type="password"  title="Password" <?php if(!isset($data['password'])){ ?>placeholder="Password"<?php } ?>  name="password" value="<?php if(isset($data['password']))  echo $data['password'];  ?>"/>
                <input class="validate[required] trainer" type="text"  title="<?php echo __('Trainer ID'); ?>"  <?php if(!isset($data['trainer_id'])){ ?>placeholder="<?php echo __('Trainer ID'); ?>"<?php } ?> name="trainer_id"  value="<?php if(isset($data['trainer_id']))  echo $data['trainer_id'];  ?>"/>
                </span>
            	<p><a href="<?php echo $this->webroot;?>login/forgot_details"><?php echo __('Forgot Your details'); ?> ?</a></p>
            	<span class="login_bg"><input type="submit" value="<?php echo __('Login'); ?>"></span>
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