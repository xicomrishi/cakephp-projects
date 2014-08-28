<style>
.text_msg_div{ float:left; width:50%; height:100px; text-align:center; margin-top:50px;}
</style>
<div id="social_row">
<button class="social_bar btn-navbar" type="button">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<ul id="social_icon">

<li><a href="https://www.facebook.com/mygyftr" target="_blank" ><?php echo $this->Html->image('fb_icon.png',array('alt'=>'fb','escape'=>false,'div'=>false));?></a></li>
<!--<li style="padding-right:4px;"><a href="#" ><?php echo $this->Html->image('tw_icon.png',array('alt'=>'','escape'=>false,'div'=>false));?></a></li>-->
</ul>
</div>

<div id="header">
<div class="wrapper">
<h1>online gifting<a class="logo large" href="<?php echo $this->webroot; ?>thankyou"><?php echo $this->Html->image('logo.jpg',array('alt'=>'mygyftr','escape'=>false,'div'=>false));?></a></h1>
</div>
</div>

<div id="banner_container" class="none">
<div class="wrapper">
<div id="banner">
<div id="form_section" class="thanku" style="min-height:600px;">
            <span class="select_dele">/ / Registration <strong>Form</strong>
            </span>
           	<div class="text_msg_div" style="display:none;">Registration successfull. You will receive Gift Voucher shortly.</div>
            <form class="register" id="registerForm" name="registerForm" action="<?php echo $this->webroot; ?>/home/register_user"  method="post">
            
            <div id="flash_msg" style="display:none; color:#FF0033; font-size:16px;">User with this Email ID already exist!</div>
            <div class="common_row">
           
            <label>First name<span>*</span></label>
            	<span class="text_box">
            		<input type="text" name="first_name"  class="small validate[required]"/>
                </span>
                </div>
                <div class="common_row">
            <label>Last name<span>*</span></label>
            	<span class="text_box">
            		<input type="text" name="last_name"  class="small validate[required]"/>
                </span>
                </div>
                <div class="common_row">
            <label>Date of Birth<span>*</span></label>
            	<span class="text_box">
            		<input type="text" id="dob" name="dob" class="small validate[required]" onclick="addClass('#ui-datepicker-div','register');"/>
                </span>
                </div>
                 <div class="common_row">
            <label>Mobile No.<span>*</span></label>
            	<span class="text_box">
            		<input type="text" name="phone"  class="small validate[required,custom[integer],minSize[10],maxSize[10]]]" maxlength="10"/>
                </span>
                </div>
                <div class="common_row">
            <label>Email address<span>*</span></label>
            	<span class="text_box">
            		<input type="text" name="email" class="small validate[required,custom[email]]"/>
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
                <label>Enter Security Code:<span>*</span></label>
                <span class="text_box">
              	  <input type="text" id="captcha_code" name="captcha" class="small validate[required]"/>
                  <?php echo $this->Html->image($this->Html->url(array('controller'=>'users', 'action'=>'captcha'), true),array('style'=>'','id'=>'img_captcha','vspace'=>2)); ?><a id="a-reload" href="javascript://"  style="margin-left:10px; color: #828284; font-size:14px;"><?php echo __('Reload security code'); ?></a>
                </span>
                </div>
                
                <div class="common_row full">
                
<label style="color:#3C3C3C; font-size:12px;"><input type="checkbox" id="check_terms"/> By logging on to the site I hereby agree with the <a href="<?php echo SITE_URL; ?>/terms-conditions" target="_blank">Term and Conditions</a>  and  explicitly allow mygyftr to contact me via e-mail, SMS, Phone and will send you relevant alerts. </label>
                </div>
                
             <div class="common_row full">
                            
            <div class="">
            <input class="done" id="register_submit" type="submit" value="submit" onclick="return register_go();"/>
            </div>
            </div>
            </form>
            
            <div class="right_thanku_section">
            	<div class="fb-like" data-href="https://www.facebook.com/myGyFTR" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>

            	<div class="bottom">
                	<span class="img_box">
                    	<?php echo $this->Html->image('thanku_image.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                    </span>
            		<span class="left_img">
                		<?php echo $this->Html->image('form_left_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                	</span>
            	</div>
           	</div>
            
       </div>
       
</div>  
</div>       
       
       
</div>

<!--<div id="top_row">
<div class="wrapper">
<form id="voucherstatusForm" name="voucherstatusForm" action="" class="status_row" method="post" onsubmit="return check_voucher_status();">
<label>Check your instant gift voucher details</label>
<input type="text" class="input validate[required]" value="" name="voucherid" />
<input type="submit" value="Check Now!" class="check" onclick="return check_voucher_status();">
</form>
</div>
</div>-->


<?php echo $this->element('bottom_section_thankyou'); ?>


<div id="fb-root"></div>


     
<?php //echo $this->Session->flash(); ?>
<script type="text/javascript">
$(document).ready(function(e) {
	//$("#voucherstatusForm").validationEngine({scroll:false,focusFirstField : false});
	 $('input').blur(function(e) {
			$(this).css('border','');
			$(this).css('box-shadow','');
			$('.formError').remove();
		 });
		 
	 $('#a-reload').click(function() {
		 console.log(1);
          var $captcha = jQuery("#img_captcha");
            $captcha.attr('src', $captcha.attr('src')+'?'+Math.random());
          return false;
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
					$('.formError').remove();
				}
       });
});

function register_go()
{
	    var valid = $("#registerForm").validationEngine('validate');
		if(valid){
			if($('#passwd').val()==$('#confirm_passwd').val())
			{	
				if($('#check_terms').is(':checked'))
				{
					
				var frm=$('#registerForm').serialize();
				$('#registerForm').hide();
				$('.text_msg_div').html('Please wait...');
				$('.text_msg_div').show();
				$.post('<?php echo SITE_URL; ?>/users/thankyou_register',frm,function(data){
					//$('#fb-root').html(data);
					if(data=='user_exist')
					{
						$('#registerForm').show();
						$('.text_msg_div').hide();
						$('#flash_msg').html('User with this Email ID already exist!');
						$('#flash_msg').show();
						$("html, body").animate({ scrollTop: 0 }, 600);	
					}else if(data=='captcha_error'){
						$('#registerForm').show();
						$('.text_msg_div').hide();
						$('#flash_msg').html('Invalid security code. Please enter correct security code.');
						$('#flash_msg').show();
						$("html, body").animate({ scrollTop: 0 }, 600);	
					}else if(data=='success'){						
						$('.text_msg_div').html('Registration successfull.<br/> You will receive Gift Voucher shortly.');
						
						$("html, body").animate({ scrollTop: 0 }, 600);	
						setTimeout(function(){ 
							//$('.text_msg_div').hide();
							window.location.href='https://www.facebook.com/myGyFTR';
						},4000);							
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

window.fbAsyncInit = function() {

    FB.init({
      appId  : '<?php echo FB_APPID;?>',
      status : true, // check login status
      cookie : true, // enable cookies to allow the server to access the session
      xfbml  : true,  // parse XFBML
	  frictionlessRequests : true
	 
    });
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
</script>  