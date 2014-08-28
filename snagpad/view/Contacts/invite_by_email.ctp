<div class="head_row">
  
  <p id="msg_success" class="success"></p>
  </div>
  <div class="pop_up_detail">
  <div class="setting_section">
  	<div class="box">
 
 		 <form id="sendmessageForm" name="sendmessageForm" action="" method="post">	
           
 
    <div class="row">
<label>Name: </label>

<input type="text" id="to_name" name="to_name" class="required"  /></div>
<div class="row">
 
 
  <div class="row">
<label>Email: </label>

<input type="text" id="to_email" name="to_email" class="required email"  /></div>
<div class="row">
<label>Message</label>
<div class="submit_right" style="float:none; border-left:none; margin-left:102px;">
<textarea name="message" class=""></textarea></div></div>

<div class="row">
<input type="submit" value="submit" class="submitbtn" onclick="return sendmessage();"/>
</div>
</form>
</div>
</div>
       
      
  </div>
<script type="text/javascript">
$(document).ready(function(e) {
	$("html, body").animate({ scrollTop: 0 }, 600);
	
});
function sendmessage()
{
	//var frm=$('#sendmessageForm').serialize();
	$("#sendmessageForm").validate({
			submitHandler: function(form) { 
				//$('.setting_section').html();
				$.post('<?php echo SITE_URL;?>/contacts/send_invite_email',$('#sendmessageForm').serialize(),function(frm){
						
						if(frm=='success')
						{
							$('#msg_success').addClass('success');
							$('#msg_success').removeClass('error');
							$('#msg_success').html('Invitation has been sent.');
						}else{
							$('#msg_success').addClass('error');
							$('#msg_success').removeClass('success');
							$('#msg_success').html('Contact already exist.');
						}
						setTimeout(function(){ disablePopup();},2500);	
						$('.contact_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php  echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
	$.post("<?php echo SITE_URL; ?>/contacts/list_invited_contacts",function(data){	
					$(".contact_section").html(data);
				
				});	
					});	
				return false;	
			}
	});		
		
}
</script>
 
