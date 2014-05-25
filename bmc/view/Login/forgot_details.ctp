<?php ?>
<section id="login_container">
	<div class="login_details">	
		<h3 class="title"><?php echo __('Forgot Details'); ?></h3>	
		<form id="ForgotDetailsForm" name="ForgotDetailsForm" method="post" action="<?php echo $this->webroot; ?>login/submit_forgot_details/<?php if(isset($is_participant)) echo '3'; else echo '2'; ?>">
        	<?php echo $this->Session->flash(); ?>
			<fieldset>
        		<span class="input_bg">
                <input class="validate[required,custom[email]] user" type="text"  title="<?php echo __('Email'); ?>" placeholder="<?php echo __('Enter your email ID'); ?>"  name="email" />
               	<?php if(isset($is_participant)){ ?>
                <input class="validate[required] course" type="text"  title="<?php echo __('Group ID'); ?>" placeholder="<?php echo __('Group ID'); ?>" name="course_id" />
                <select class="validate[required] role" name="user_role_id">
                    <option value=""><?php echo __('Role'); ?></option>
                    <option value="3"><?php echo __('Project Manager'); ?></option>
                    <option value="4"><?php echo __('Team Member'); ?></option>
                    <option value="5"><?php echo __('Manager of Project Manager'); ?></option>
                </select>
                <?php } ?>	
                <div class="captcha_code"><?php echo $this->Html->image($this->Html->url(array('controller'=>'login', 'action'=>'captcha'), true),array('style'=>'','vspace'=>2)); ?>
                
                </div>
                <a href="<?php echo $this->webroot; ?>login/forgot_details" style="margin-right:46px;"><?php echo __('Reload security code'); ?></a>
                <input class="validate[required] course" type="text"  placeholder="<?php echo __('Enter security code'); ?>"  name="captcha" />
                
                </span>
            	
            	<span class="login_bg"><input type="submit" value="<?php echo __('Submit'); ?>"></span>
    		</fieldset>
		</form>
     </div>
</section>

<script type="text/javascript">
$(document).ready(function(e) {
    $("#ForgotDetailsForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	setTimeout(function(){ $('#flashMessage').hide(); },4000);
});


</script>