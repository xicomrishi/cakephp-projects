<?php ?>
<section id="login_container">
	<div class="login_details">	
		<h3 class="title"><?php echo __('Login'); ?></h3>	
		<form id="LoginForm" name="LoginForm" method="post" action="<?php echo $this->webroot; ?>login/verify_participant_login">
        	<?php echo $this->Session->flash(); ?>
			<fieldset>
        		<span class="input_bg">
                <input class="validate[required,custom[email]] user" type="text"  title="<?php echo __('User Name'); ?>" <?php if(!isset($data['email'])){ ?>placeholder="<?php echo __('User Name'); ?>" <?php } ?> name="email" value="<?php if(isset($data['email']))  echo $data['email'];  ?>"/>
                <input class="validate[required] pass"  type="password"  title="Password" <?php if(!isset($data['email'])){ ?>placeholder="Password"<?php } ?>  name="password" value="<?php if(isset($data['password'])) echo $data['password']; ?>"/>
                <input class="validate[required] course" type="text"  title="<?php echo __('Group ID'); ?>" <?php if(!isset($data['email'])){ ?>placeholder="<?php echo __('Group ID'); ?>"<?php } ?> name="course_id"  value="<?php if(isset($data['course_id'])) echo $data['course_id']; ?>"/>
                <select class="validate[required] role" name="user_role_id">
                    <option value=""><?php echo __('Role'); ?></option>
                    <option value="3"><?php echo __('Project Manager'); ?></option>
                    <option value="4"><?php echo __('Team Member'); ?></option>
                    <option value="5"><?php echo __('Manager of Project Managers'); ?></option>
                </select>
                </span>
            	<p><a href="<?php echo $this->webroot;?>login/forgot_details/1"><?php echo __('Forgot Your details'); ?> ?</a></p>
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