<div id="form_section">
            <span class="select_dele">/ / New User <strong>Registration</strong>
            </span>
            <?php  //if(isset($incomplete_register)){  echo '<div style="color:#ff0000;">Please complete your registration.</div>'; } ?>
            <form class="register" id="registerForm" name="registerForm" action="<?php echo SITE_URL; ?>/home/register_user"  method="post">
            <?php if(isset($order_id)){ ?>
            	<input type="hidden" name="rg_val" value="<?php echo $order_id; ?>"/>
            <?php } ?>
               <?php if(isset($forget_pass)){ ?>
            	<input type="hidden" name="forget_pass" value="1"/>
            <?php } ?>
               <?php if(isset($fb_login)){ ?>
            	<input type="hidden" name="fb_login" value="1"/>
            <?php } ?>
            <div id="flash_msg" style="display:none; color:#FF0033; font-size:16px;">User with this Email ID already exist!</div>
            <div class="common_row">
           
            <label>First name<span>*</span></label>
            	<span class="text_box">
            		<input type="text" name="first_name"  class="small validate[required]" value="<?php if(isset($rg_val)) echo $rg_val['User']['first_name']; ?>"/>
                </span>
                </div>
                <div class="common_row">
            <label>Last name<span>*</span></label>
            	<span class="text_box">
            		<input type="text" name="last_name"  class="small validate[required]" value="<?php if(isset($rg_val)) echo $rg_val['User']['last_name']; ?>"/>
                </span>
                </div>
                <div class="common_row">
            <label>Date of Birth<span>*</span></label>
            	<span class="text_box">
            		<input type="text" id="dob" name="dob" class="small validate[required]" onclick="addClass('#ui-datepicker-div','register');" value="<?php if(isset($rg_val)) echo $rg_val['User']['dob']; ?>"/>
                </span>
                </div>
                 <div class="common_row">
            <label>Mobile No.<span>*</span></label>
            	<span class="text_box">
            		<input type="text" name="phone"  class="small validate[required,custom[integer],minSize[10],maxSize[10]]]" maxlength="10" value="<?php if(isset($rg_val)) echo $rg_val['User']['phone']; ?>"/>
                </span>
                </div>
                <div class="common_row">
            <label>Email address<span>*</span></label>
            	<span class="text_box">
            		<input type="text" name="email" class="small validate[required,custom[email]]" value="<?php if(isset($rg_val)) echo $rg_val['User']['email']; ?>" <?php if(isset($rg_val)){ ?> readonly="readonly" <?php }?>/>
                </span>
                </div>
                 <div class="common_row">
            <label>Gender<span>*</span></label>
            	<span class="text_box">
            		<select name="gender" class="small" style="height:47px !important;">
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                    </select>
                </span>
                </div>
                
                <div class="common_row">
            <label>Password<span>*</span></label>
            	<span class="text_box">
            		<input type="password" id="passwd" name="password" value="" class="small validate[required,minSize[6]]"/>
                </span>
                </div>
                 <div class="common_row">
           	 <label>Confirm Password<span>*</span></label>
            	<span class="text_box">
            		<input type="password" id="confirm_passwd" value="" class="small validate[required]"/>
                </span>
                </div>
         	    <div class="common_row full">
                
<label style="color:#3C3C3C; font-size:12px;"><input type="checkbox" id="check_terms"/> By logging on to the site I hereby agree with the <a href="<?php echo SITE_URL; ?>/terms-conditions" target="_blank">Term and Conditions</a>  and  explicitly allow mygyftr to contact me via e-mail, SMS, Phone and will send you relevant alerts. </label>
                </div>
             <div class="common_row full">
                            <h3><span style="color:#F87400">*</span>All field(s) are required</h3>
            <div class="">
            <input class="done" id="register_submit" type="submit" value="submit" onclick="return register_go();"/>
            </div>
            </div>
            </form>
           <!-- <div class="other_login">
             <?php echo $this->Html->image('or_1.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
            <a href="#" class="facebook"> <?php echo $this->Html->image('facebook-btn.png',array('escape'=>false,'alt'=>'','div'=>false)); ?></a>
             </div>-->
            <div class="bottom">
            	<span class="left_img">
                	<?php echo $this->Html->image('form_left_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
                <span class="right_img">
                 <?php echo $this->Html->image('form_right_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
            </div>
       </div>
<script type="text/javascript">
$(document).ready(function(e) {
	$('input:text').click(function(e) {
        $('.formError').remove();
    });
	
	$("#registerForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	
	var to_day=new Date();
	 $('#dob').datepicker({	
		 yearRange: "-90:+0",	            
			dateFormat:"dd-mm-yy",
			 changeMonth: true,
			changeYear: true,
			maxDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate()),
			onSelect: function(dateText, inst) {
					//$('#delivery_date').val(dateText);
					$('.formError').remove();
					//$(this).datetimepicker('hide');
				}
       });
});

function register_go()
{
	//$('#register_submit').click(function(e) {		
        var valid = $("#registerForm").validationEngine('validate');
		if(valid){
			if($('#passwd').val()==$('#confirm_passwd').val())
			{	
				if($('#check_terms').is(':checked'))
				{
					
				
				$.post('<?php echo SITE_URL; ?>/users/register_user',$('#registerForm').serialize(),function(data){
					if(data=='user_exist')
					{
						$('#flash_msg').show();
						$("html, body").animate({ scrollTop: 0 }, 600);	
					}else if(data=='success'){						
						showLoading('#banner');
						//display_profile();
						redirect_after_login();								
					}else{
						showLoading('#banner');
						$('.login_sec').hide();
						$('.logout_sec').show();
						update_user_pic();
						view_order_details(data);	
					}
				});
				}else{
					alert('Please accept Terms and Conditions.');	
				}
			}else{
				alert('Password and Confirm Password does not match! Please try again.');
				
			}
				
		}else{
				$("#registerForm").validationEngine({scroll:false,focusFirstField : false});
				shakeField();
				}
   // });	
   return false;
}
</script>