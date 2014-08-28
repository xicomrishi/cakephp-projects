<style>
#login_container form { padding-top:0px;}
#login_container form p { padding-bottom:10px; }
</style>
<section id="login_container" class="personal_detail">
	<div class="login_details personal_detail">	
		<h3 class="title"><?php echo __('Details'); ?> </h3>
		
        
    <form id="ParticipantRegisterForm" name="ParticipantRegisterForm" method="post" onsubmit="return register_form_submit();"  action="" class="personalForm">
    <fieldset>
    <input type="hidden" name="data[User][id]" value="<?php echo $user['User']['id']; ?>"/>
    <div class="tab_detail">
    	            
            <div id="infoMsg"></div>   
            <div id="about" class="nano">	
            <section class="signup_form">
            	<p><label><?php echo __('First Name'); ?><span>*</span></label><input type="text" class="validate[required]" name="data[User][first_name]" value="<?php echo $user['User']['first_name']; ?>"/></p>
                <p><label><?php echo __('Last Name'); ?><span>*</span></label><input type="text" class="validate[required]" name="data[User][last_name]" value="<?php echo $user['User']['last_name']; ?>"/></p>
                <p><label><?php echo __('Country'); ?><span>*</span></label>
                	<select name="data[User][country_id]" class="validate[required]">
                    	<option value=""><?php echo __('Select'); ?></option>
                    	<?php foreach($countries as $country){ ?>
                        <option <?php if($user['User']['country_id']==$country['Country']['country_id']) echo 'selected'; ?> value="<?php echo $country['Country']['country_id']; ?>"><?php echo $country['Country']['country_name']; ?></option>	
                        <?php } ?>
                    </select>
                </p>
                <p><label><?php echo __('City'); ?></label><input type="text" name="data[User][city]" value="<?php echo $user['User']['city']; ?>"/></p>
                <p><label><?php echo __('Industry'); ?><span>*</span></label>
                	<select name="data[User][industry_id]" class="validate[required]">
                    	<option value=""><?php echo __('Select'); ?></option>
                    	<?php foreach($industries as $industry){ ?>
                        <option <?php if($user['User']['industry_id']==$industry['Industry']['id']) echo 'selected'; ?>  value="<?php echo $industry['Industry']['id']; ?>"><?php echo $industry['Industry']['industry']; ?></option>	
                        <?php } ?>
                    </select>
                </p>
                <p><label><?php echo __('Company'); ?><span>*</span></label>
                	<select name="data[User][company]" class="validate[required]">
                    	<option value=""><?php echo __('Select'); ?></option>
                    	<?php foreach($companies as $comp){ ?>
                        <option <?php if($user['User']['company']==$comp['Company']['id']) echo 'selected'; ?>   value="<?php echo $comp['Company']['id']; ?>"><?php echo $comp['Company']['company']; ?></option>	
                        <?php } ?>
                    </select>
                </p>
                <p><label><?php echo __('Phone'); ?></label><input type="text" name="data[User][phone]" value="<?php echo $user['User']['phone']; ?>" /></p>
                <p><label><?php echo __('Role'); ?><span>*</span></label>
                	<input type="text" class="validate[required]" value="<?php if($participant['Participant']['user_role_id']==3) echo __('Project Manager'); else if($participant['Participant']['user_role_id']==4) echo __('Team Member'); else echo __('Manager of Project Managers'); ?>" readonly="readonly"/>
                	
                </p>
                <p><label><?php echo __('Course Id'); ?><span>*</span></label><input type="text" class="validate[required]" name="data[Participant][course_id]" value="<?php echo $participant['Participant']['course_id']; ?>" readonly="readonly"/></p>
                <p><label><?php echo __('Company Website'); ?></label><input type="text" class="validate[custom[url]]" name="data[User][company_url]" value="<?php echo $user['User']['company_url']; ?>"/></p>
                <p><label><?php echo __('Email'); ?><span>*</span></label><input type="text" class="validate[required,custom[email]]" name="data[User][email]" value="<?php echo $user['User']['email']; ?>" readonly="readonly"/></p>
                
                
                <p class="last"><input type="submit" value="<?php echo __('Update'); ?>"/></p>
            </section> 	
            </div>
            </div>
            </fieldset>
            </form>
  
     </div>
</section>
<script type="text/javascript">
$(document).ready(function(e) {
	$("#ParticipantRegisterForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
    setTimeout(function(){ $(".nano").nanoScroller({alwaysVisible:true, contentClass:'signup_form',sliderMaxHeight: 70 }),500});
	setTimeout(function(){ $('#flashMessage').hide(); },4000);
});

function register_form_submit()
{
	var valid = $("#ParticipantRegisterForm").validationEngine('validate');
	if(valid)
	{
		var frm=$('#ParticipantRegisterForm').serialize();
		showLoading('#ParticipantRegisterForm');
		$('.personalForm div').css('width','980px');
		$.post('<?php echo $this->webroot; ?>participant/update_participant',frm,function(data){
			$('.name').html(data);
			$('.signup_form').html('<div style="height:300px; text-align:center; margin-top:50px;"><?php echo __('Details updated successfully'); ?>.</div>');
			setTimeout(function(){ $.fancybox.close();	},1500);
		});		
	}else{
		$("#ParticipantRegisterForm").validationEngine({scroll:false,focusFirstField : false});	
	}
	return false;
}
</script>