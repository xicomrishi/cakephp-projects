<style>
.signup_form p.last {
    width: 100% !important;
}
</style>
<div class="wrapper">  
  <section id="body_container">

    <section class="container">
   
    <form id="ParticipantRegisterForm" name="ParticipantRegisterForm" method="post" onsubmit="return register_form_submit();"  action="<?php echo $this->webroot; ?>login/save_participant_register">
    <fieldset>
    <div class="tab_detail">
    	<h3 class="title"><?php echo __('Registration Form'); ?></h3>
            <?php echo $this->Session->flash(); ?> 
            <div id="infoMsg"></div>   	
            <section class="signup_form">
             <?php if($num==0){ ?>
            	<p><label><?php echo __('First Name'); ?><span>*</span></label><input type="text" class="validate[required]" name="data[User][first_name]"/></p>
                <p><label><?php echo __('Last Name'); ?><span>*</span></label><input type="text" class="validate[required]" name="data[User][last_name]"/></p>
                <p><label><?php echo __('Country'); ?><span>*</span></label>
                	<select name="data[User][country_id]" class="validate[required]">
                    	<option value=""><?php echo __('Select'); ?></option>
                    	<?php foreach($countries as $country){ ?>
                        <option value="<?php echo $country['Country']['country_id']; ?>"><?php echo $country['Country']['country_name']; ?></option>	
                        <?php } ?>
                    </select>
                </p>
                <p><label><?php echo __('City'); ?></label><input type="text" name="data[User][city]" /></p>
                <p><label><?php echo __('Industry'); ?><span>*</span></label>
                	<select name="data[User][industry_id]" class="validate[required]">
                    	<option value=""><?php echo __('Select'); ?></option>
                    	<?php foreach($industries as $industry){ ?>
                        <option value="<?php echo $industry['Industry']['id']; ?>"><?php echo $industry['Industry']['industry']; ?></option>	
                        <?php } ?>
                    </select>
                </p>
                <p><label><?php echo __('Company'); ?><span>*</span></label>
                	<input type="text" id="comp_list_inp" name="data[User][company]" class="validate[required]" />
                </p>
                <p><label><?php echo __('Company Location'); ?><span>*</span></label>
                	<select name="data[User][company_location]" class="validate[required]">
                    	<option value=""><?php echo __('Select'); ?></option>
                    	<?php foreach($countries as $country){ ?>
                        <option value="<?php echo $country['Country']['country_id']; ?>"><?php echo $country['Country']['country_name']; ?></option>	
                        <?php } ?>
                    </select>
                </p>
                <p><label><?php echo __('Phone'); ?></label><input type="text" name="data[User][phone]" /></p>
                <p><label><?php echo __('Role'); ?><span>*</span></label>
                	<select name="data[User][user_role_id]" class="validate[required]">
                    	<option value=""><?php echo __('Select'); ?></option>
                    	<option value="3"><?php echo __('Project Manager'); ?></option>
                    	<option value="4"><?php echo __('Team Member'); ?></option>
                        <option value="5"><?php echo __('Manager of Project Manager'); ?></option>
                    </select>
                </p>
                <p><label><?php echo __('Group ID'); ?><span>*</span></label><input type="text" class="validate[required]" name="data[Participant][course_id]"/></p>
                <p><label><?php echo __('Company Website'); ?></label><input type="text" class="validate[custom[url]]" name="data[User][company_url]" onclick="if(this.value=='') this.value='http://';" onblur="if(this.value=='http://') this.value='';"/><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(e.g http://www.bmc-global.com)</span></p>
                <p><label><?php echo __('Email'); ?><span>*</span></label><input type="text" class="validate[required,custom[email]]" name="data[User][email]"/></p>
                <p class="captcha_code" style="  float: none !important; margin-left: 140px;">
                
                </p>
                <p style="width:100% !important;"><label style="margin-top:22px;"><?php echo __('Enter security code: '); ?></label><input type="text" style="float: left; margin-right: 14px; margin-top:10px;" class="validate[required]" name="data[Participant][captcha]"/><?php echo $this->Html->image($this->Html->url(array('controller'=>'login', 'action'=>'captcha'), true),array('style'=>'','id'=>'img_captcha','vspace'=>2)); ?><a id="a-reload" href="javascript://"  style="margin-left:10px; color: #828284; font-size:14px;"><?php echo __('Reload security code'); ?></a></p>
                   
                <p class="last"><input type="checkbox" id="check_terms"/><label><?php echo __('I give permission to use my personal data for this assessment process.'); ?></label></p>
                <p class="last"><input type="submit" value="<?php echo __('Register'); ?>"/></p>
        <?php }else{ ?>
       		<p style="font-size: 14px;height: 300px;margin-top: 120px;text-align: center;width: 100% !important;"><?php echo __('Thank you for registering for the Assessment Inventory of Project Management.'); ?><br><br><?php echo __('You will receive an email with a link to the assessment questionnaire and your login and password details.'); ?></p>
       <?php } ?> 
            </section> 	
            </div>
            </fieldset>
            </form>
         
    </section>
  </section>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	$("#ParticipantRegisterForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	setTimeout(function(){ $('#flashMessage').hide(); },4000);
	 $('#a-reload').click(function() {
          var $captcha = jQuery("#img_captcha");
            $captcha.attr('src', $captcha.attr('src')+'?'+Math.random());
          return false;
        });
});

var availableTags=[<?php 
			$last=count($all_comps); 
			$m=1;
			foreach($all_comps as $j ){ 
				if($m==$last){
					echo '"'.$j['label'].'"';
					}else{
						echo '"'.$j['label'].'",'; } $m++; }?>];
						
$("#comp_list_inp").autocomplete({
			source: function( request, response ) {
				var matches = $.map( availableTags, function(tag) {
				  if ( tag.toUpperCase().indexOf(request.term.toUpperCase()) === 0 ) {
					return tag;
				  }
				});
				response(matches);
			  },
			focus: function( event, ui ) {
				//$("#inp_comp_"+num).val( ui.item.label );
				return false;
			},
			select: function( event, ui ) {
						//alert(num);
					$("#comp_list_inp").val( ui.item.label );
					return false;
			}
	}); 						

function register_form_submit()
{
	var valid = $("#ParticipantRegisterForm").validationEngine('validate');
	if(valid)
	{
		if($('#check_terms').is(':checked'))
		{
			document.forms['ParticipantRegisterForm'].submit();	
		}else{
			
			$('#infoMsg').html('<?php echo __('Please accept terms and conditions.'); ?>');	
		}
	}else{
		$("#ParticipantRegisterForm").validationEngine({scroll:false,focusFirstField : false});	
	}
	return false;
}

</script>