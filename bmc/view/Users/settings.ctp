
<section id="login_container" class="none"><?php ?>
	<div class="login_details">	
		<h3 class="title">Update Password</h3>	
		<form id="SettingsForm" name="SettingsForm" method="post" action="" onSubmit="return update_settings();">
			<div id="flashMessage" style="display:none;"></div>
            <fieldset>
            	<input type="hidden" name="user_id" value="<?php echo $user_id?>"/>
        		<span class="input_bg">
                <input class="validate[required] course" type="password" placeholder="Old Password" name="old_password"/>
                <input class="validate[required,minSize[8]] course" id="new_password"  type="password" placeholder="New Password" name="new_password"/>
                <input class="validate[required,minSize[8],equals[new_password]] course"  type="password" placeholder="Confirm Password"/>
                 </span>
                 
            	<span class="login_bg"><input type="submit" value="Update"></span>
    		</fieldset>
		</form>
     </div>
</section>
<script type="text/javascript">
$(document).ready(function(e) {
    $("#SettingsForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	setTimeout(function(){ $('#flashMessage').hide(); },4000);
});
</script>