<section class="head_row">
  
  <div id="msg_success" class="success"></div>
  </section>
  <section class="pop_up_detail">
  <div class="setting_section">
  	<div class="box">
 
<form id="sendmessageForm" name="sendmessageForm" action="" method="post">	
<div class="row">
<label>Name: </label>
<input type="text" name="name" class="required" value="<?php if(!isset($con_email)){ echo $name; }  ?>"/>
</div>                       
<div class="row">
<label>Email: </label>
<input type="hidden" id="profile_id" name="profile_id" value="<?php echo $id; ?>"/>

<input type="text" name="email" class="required email" value="<?php if(isset($con_email)){ echo $name; }?>"/>

</div>
<div class="row">
<label>Message</label>
<div class="submit_right" style="float:none; border-left:none; margin-left:102px;">
<textarea name="message"><?php echo $content;?></textarea></div></div>
<div class="row">
<input type="submit" value="submit" class="submitbtn" onclick="return sendmessage();"/>
</div>
</form>
</div>
</div>
       
      
  </section>
<script type="text/javascript">
$(document).ready(function(e) {
	$("html, body").animate({ scrollTop: 0 }, 600);
	
});
function sendmessage()
{
	$('#sendmessageForm').validate({
		
		submitHandler: function(form) {
	$.post('<?php echo SITE_URL;?>/contacts/send_message',$('#sendmessageForm').serialize(),function(frm){
			if(frm=='success')
			{ 	var profile=$('#profile_id').val();
				$('#msg_success').removeClass('error');
				$('#msg_success').addClass('success');
				$('#msg_success').html('A Message is sent to your friends.');
				//$('#connect_'+profile).html('Snagged');
				setTimeout(function(){ disablePopup();},2500);	
			}else{
				$('#msg_success').removeClass('success');
				$('#msg_success').addClass('error');
				$('#msg_success').html('Account with this email already exist.');
				}
		//	$('#connect_'+id).html('Invite');
			
		});

		return false;
		}
	});
}
</script>
 
