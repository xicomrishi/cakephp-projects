<style>
.signup_form p.last {
    width: 100% !important;
}
</style>
<div class="wrapper">  
  <section id="body_container">

    <section class="container">
   
    <form id="ParticipantRegisterForm" name="ParticipantRegisterForm" method="post" onsubmit="return register_form_submit();"  action="<?php echo $this->webroot; ?>login/save_participant_register">
    <input type="hidden" name="data[User][user_role_id]" value="<?php echo $role_id; ?>"/> 
    <input type="hidden" name="data[User][corporate_email]" value=""/>    
    
    <fieldset>
    <div class="tab_detail">
    	<h3 class="title"><?php echo __('Registration Form - ').$course['Course']['course_name'].' - '.$role_text; ?></h3>
            <?php echo $this->Session->flash(); ?> 
            <div id="infoMsg" style="background-color: #FFFFA8;border: 1px solid;color: #FF0000;font-size: 14px;padding: 5px;"></div>   	
            <section class="signup_form">
             
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
                <p><label><?php echo __('Group ID'); ?><span>*</span></label><input type="text" class="validate[required]" name="data[Participant][course_id]"/ value="<?php echo $course['Course']['course_id']; ?>" readonly="readonly"></p>
                <p><label><?php echo __('Company Website'); ?></label><input type="text" class="validate[custom[url]]" name="data[User][company_url]" onclick="if(this.value=='') this.value='http://';" onblur="if(this.value=='http://') this.value='';"/><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(e.g http://www.bmc-global.com)</span></p>
                <p><label><?php echo __('Email'); ?><span>*</span></label><input type="text" class="validate[required,custom[email]]" name="data[User][email]"/></p>
                <p class="captcha_code" style="  float: none !important; margin-left: 140px;">
                
                </p>
                <p style="width:100% !important;"><label style="margin-top:22px;"><?php echo __('Enter security code: '); ?></label><input type="text" style="float: left; margin-right: 14px; margin-top:10px;" class="validate[required]" name="data[Participant][captcha]"/><?php echo $this->Html->image($this->Html->url(array('controller'=>'login', 'action'=>'captcha'), true),array('style'=>'','id'=>'img_captcha','vspace'=>2)); ?><a id="a-reload" href="javascript://"  style="margin-left:10px; color: #828284; font-size:14px;"><?php echo __('Reload security code'); ?></a></p>
                   
                <p class="last"><input type="checkbox" id="check_terms"/><label><?php echo __('I give permission to use my personal data for this assessment process.'); ?></label></p>
                <p class="last register_submit"><input type="submit" value="<?php echo __('Register'); ?>"/></p>
       
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
		$('.register_submit').hide();
		if($('#check_terms').is(':checked'))
		{
			var frm=$('#ParticipantRegisterForm').serialize();
			$.post('<?php echo $this->webroot; ?>login/save_direct_participant_register',frm,function(data){
				var resp=data.split('|');
				if(resp[0]=='error')
				{
					$('.register_submit').show();
					$('#infoMsg').html(resp[1]);
					
				}else if(resp[0]=='success')
				{
					$('.parti_id').val(resp[2]);
					var survey=$('#AssessmentForm').serialize();
					$('#infoMsg').hide();
					showLoading('.signup_form');
					$.post('<?php echo $this->webroot; ?>assessment/submit_assessment/1',survey,function(response){
						
					$('#body_container').html('<p style="font-size: 14px;height: 300px;margin-top: 120px;text-align: center;width: 100% !important;">'+resp[1]+'</p>');
					$('.signup_form').html('<p style="font-size: 14px;height: 300px;margin-top: 120px;text-align: center;width: 100% !important;">'+resp[1]+'</p>');	
					
					});
				}	
			});
				
		}else{
			$('.register_submit').show();
			
			$('#infoMsg').html('<?php echo __('Please accept terms and conditions.'); ?>');	
		}
	}else{
		$("#ParticipantRegisterForm").validationEngine({scroll:false,focusFirstField : false});	
	}
	return false;
}

</script>