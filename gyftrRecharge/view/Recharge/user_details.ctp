<div class="tab_details">
                	<div class="detail_section">
                    	<div class="common_steps RegisterSection" <?php if(isset($login_failed)){ echo 'style="display:none;"'; } ?>>
                        	<form id="userRegisterForm" name="userRegisterForm" method="post" action="<?php echo $this->webroot; ?>recharge/register_user" onsubmit="return continue_as_guest(0);">
                            	<fieldset>
                                	<input  type="hidden" name="data[Recharge][recharge_type]" value="<?php echo $data['Recharge']['recharge_type']; ?>"/>
                                    <input  type="hidden" name="data[Recharge][voucher_code]" value="<?php echo $data['Recharge']['voucher_code']; ?>"/>
                                    <input  type="hidden" name="data[Recharge][operator_id]" value="<?php echo $data['Recharge']['operator_id']; ?>"/>
                                    <input  type="hidden" name="data[Recharge][number]" value="<?php echo $data['Recharge']['number']; ?>"/>
                                    <input type="hidden" name="data[Recharge][amount]" value="<?php echo $data['Recharge']['amount']; ?>"/>
                                    <input type="hidden" name="data[Recharge][log_id]" value="<?php echo $data['Recharge']['log_id']; ?>"/>
                                    <input type="hidden" name="data[Recharge][recharge_value]" value="<?php echo $data['Recharge']['recharge_value']; ?>"/>
                                    <input type="hidden" name="data[Recharge][circle_id]" value="<?php if(isset($data['Recharge']['circle_id'])) echo $data['Recharge']['circle_id']; ?>"/>
                                    <?php if(isset($data['Recharge']['circle_id'])){ ?>
                                    	<input type="hidden" name="data[Recharge][circle_id]" value="<?php echo $data['Recharge']['circle_id']; ?>"/>
                                    <?php } ?>
                                    <?php if(isset($data['Recharge']['cycle_number'])){ ?>
                                    	<input type="hidden" name="data[Recharge][cycle_number]" value="<?php echo $data['Recharge']['cycle_number']; ?>"/>
                                    <?php } ?>
                                    <?php if(isset($data['Recharge']['customer_acc_number'])){ ?>
                                    	<input type="hidden" name="data[Recharge][customer_acc_number]" value="<?php echo $data['Recharge']['customer_acc_number']; ?>"/>
                                    <?php } ?>
                                     <?php if(isset($data['Recharge']['date_of_birth'])){ ?>
                                        <input type="hidden" name="data[Recharge][date_of_birth]" value="<?php echo $data['Recharge']['date_of_birth']; ?>"/>
                                    <?php } ?>
                                    <?php if(isset($data['Recharge']['std_code'])){ ?>
                                        <input type="hidden" name="data[Recharge][std_code]" value="<?php echo $data['Recharge']['std_code']; ?>"/>
                                    <?php } ?>
                                     <input  id="is_register_guest" type="hidden" name="data[Recharge][is_guest]" value="0"/>
                                     <?php if(isset($is_user_exist)){ ?>
                                    <div class="error_div error_div_1">Email ID already exist.</div>
                                    <?php } ?>
                                	<div class="common_row all_step step_1">
                                        <label>Can we know your name</label>
                                        <input type="text" id="user_name" class="input validate[required]" name="data[User][name]" autocomplete="off">
                                        
                                    </div>
                                    <div class="common_row all_step step_1">
                                        <label>Your Email ID</label>
                                        <input type="text" id="user_email" class="input validate[required,custom[email]]" name="data[User][email]">
                                        
                                    </div> 
                                    <div class="common_row all_step step_1">
                                            <label>Your mobile number</label>
                                           <span class="inn">+91</span><input type="text" id="mobile_num" class="validate[required,custom[integer],minSize[10],maxSize[10]]]" name="data[User][phone]" maxlength="10" min="0" autocomplete="off">
                                            
                                     </div>
                                     <div class="common_row all_step step_1">                
                                        <label>Select a password</label>
                                       <input type="password" id="user_pass" class="validate[required,minSize[6]]" name="data[User][password]" autocomplete="off">
                                     </div>
                                     <div class="common_row all_step step_1"> 
                                       <label>Re-enter password</label>
                                       <input type="password" class="validate[equals[user_pass]]" autocomplete="off">                                        
                                    </div>                                   
                                    
                                    <div class="common_row all_step step_7"><input type="submit" value="Register">
                                    	<span class="or">Or</span>
                                        <a href="javascript://" class="other_link" onclick="show_div('.LoginSection');">Already have an account: Login</a>
                                    </div>                                    
                                    
                                    <a href="javascript://" class="continue_guest" onclick="continue_as_guest(1);">Continue as a guest >></a>
                                </fieldset>
                            </form>
                        </div>       
                        
                        
                        <div class="common_steps LoginSection" <?php if(!isset($login_failed)){ echo 'style="display:none;"'; } ?>>
                        	<form id="userLoginForm" name="userLoginForm" method="post" action="<?php echo $this->webroot; ?>recharge/login_user" onsubmit="return login_as_guest(0);">
                            	<fieldset>
                                	<input  type="hidden" name="data[Recharge][recharge_type]" value="<?php echo $data['Recharge']['recharge_type']; ?>"/>
                                    <input  type="hidden" name="data[Recharge][voucher_code]" value="<?php echo $data['Recharge']['voucher_code']; ?>"/>
                                    <input  type="hidden" name="data[Recharge][operator_id]" value="<?php echo $data['Recharge']['operator_id']; ?>"/>
                                    <input  type="hidden" name="data[Recharge][number]" value="<?php echo $data['Recharge']['number']; ?>"/>
                                    <input type="hidden" name="data[Recharge][amount]" value="<?php echo $data['Recharge']['amount']; ?>"/>
                                    <input type="hidden" name="data[Recharge][log_id]" value="<?php echo $data['Recharge']['log_id']; ?>"/>
                                    <input type="hidden" name="data[Recharge][recharge_value]" value="<?php echo $data['Recharge']['recharge_value']; ?>"/>
                                    <input type="hidden" name="data[Recharge][circle_id]" value="<?php if(isset($data['Recharge']['circle_id'])) echo $data['Recharge']['circle_id']; ?>"/>
                                    <?php if(isset($data['Recharge']['circle_id'])){ ?>
                                    	<input type="hidden" name="data[Recharge][circle_id]" value="<?php echo $data['Recharge']['circle_id']; ?>"/>
                                    <?php } ?>
                                    <?php if(isset($data['Recharge']['cycle_number'])){ ?>
                                    	<input type="hidden" name="data[Recharge][cycle_number]" value="<?php echo $data['Recharge']['cycle_number']; ?>"/>
                                    <?php } ?>
                                     <?php if(isset($data['Recharge']['customer_acc_number'])){ ?>
                                    	<input type="hidden" name="data[Recharge][customer_acc_number]" value="<?php echo $data['Recharge']['customer_acc_number']; ?>"/>
                                    <?php } ?>
                                     <?php if(isset($data['Recharge']['date_of_birth'])){ ?>
                                        <input type="hidden" name="data[Recharge][date_of_birth]" value="<?php echo $data['Recharge']['date_of_birth']; ?>"/>
                                    <?php } ?>
                                    <?php if(isset($data['Recharge']['std_code'])){ ?>
                                        <input type="hidden" name="data[Recharge][std_code]" value="<?php echo $data['Recharge']['std_code']; ?>"/>
                                    <?php } ?>
                                     <input  id="is_guest" type="hidden" name="data[Recharge][is_guest]" value="0"/>
                                     <?php if(isset($login_failed)){ ?>
                                    <div class="error_div error_div_1">Email ID or Password does not match.</div>
                                    <?php } ?>
                                	
                                    <div class="common_row">
                                       <label>Email ID</label>
                                       <input type="text" id="user_email" class="input validate[required,custom[email]]" name="data[User][email]" autocomplete="off">
                                        
                                    </div>
                                    <div class="common_row">
                                        <label>Password</label>
                                        <input type="password" id="user_pass" class="validate[required]" name="data[User][password]" autocomplete="off">
                                        
                                    </div> 
                                       
                                   
                                    
                                    <div class="common_row all_step step_7"><input type="submit" value="Login">
                                    	<span class="or">Or</span>
                                    	<a href="javascript://" class="other_link" onclick="show_div('.RegisterSection');">New User: Register here</a>
                                    </div>
                                    
                                    <a href="javascript://" class="continue_guest" onclick="login_as_guest(1);">Continue as a guest >></a>
                                </fieldset>
                            </form>
                        </div>
                      
                   </div>
                </div>

        
<script type="text/javascript">
$(document).ready(function(e) {
   
  $('body').scrollTop(0);
	$("#userRegisterForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	$("#userLoginForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	
});



function continue_as_guest(num)
{
	if(num==1)
	{
		$('#is_register_guest').val('1');
		$('input').removeAttr('class');
	}
	var valid = $("#userRegisterForm").validationEngine('validate');
	if(valid)
	{
		var frm=$('#userRegisterForm').serialize();
		showCustomLoading('.inner_tabing','350px','175px');	
		$.post(site_url+'/recharge/register_user',frm,function(data){
			$('.inner_tabing').html(data);
			update_user_name();	
		});
	}else{
		$("#userRegisterForm").validationEngine({scroll:false,focusFirstField : false});
		shakeField();	
	}
	return false;	
}

function login_as_guest(num)
{
	if(num==1)
	{
	$('#is_guest').val('1');
	$('input').removeAttr('class');
	}
	//$('#userLoginForm').submit();	
	var valid = $("#userLoginForm").validationEngine('validate');
	if(valid)
	{
		var frm=$('#userLoginForm').serialize();
		showCustomLoading('.inner_tabing','350px','175px');	
		$.post(site_url+'/recharge/login_user',frm,function(data){
			$('.inner_tabing').html(data);	
			update_user_name();
		});
	}else{
		$("#userLoginForm").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
	}
	return false;
}

function show_div(cl_name)
{
	//$('.main li').removeClass('active');
	
	$('.common_steps').hide();
	//$('.main li').eq(tab-1).addClass('active');
	$('#userLoginForm').validationEngine('hideAll');
	$('#userRegisterForm').validationEngine('hideAll');

	$('input').css('border','');
	$('input').css('box-shadow','');
	$(cl_name).show();	
}

</script>        