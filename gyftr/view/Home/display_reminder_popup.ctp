<div id="form_section"  style="margin:0 0 5px 0; padding:0 1%">
<div class="select_dele all">/ / Reminder</div>
<form id="sendReminderForm" name="sendReminderForm" action="">
<div class="comn_box recipient">
<input type="hidden" name="to_email" value="<?php echo $gpuser['GroupGift']['email']; ?>"/>
<input type="hidden" name="req_id" value="<?php echo $gpuser['GroupGift']['req_id']; ?>"/>
<input type="hidden" name="gpuserid" value="<?php echo $gpuser['GroupGift']['id']; ?>"/>
<input type="hidden" name="orderid" value="<?php echo $gpuser['GroupGift']['order_id']; ?>"/>
<div class="detail_row">
<label>Email: </label>
<span class="detail"><?php echo $gpuser['GroupGift']['email']; ?></span>
</div>

<div class="detail_row last">
<label>Message: </label>
<span class="detail"><textarea name="message" class="validate[required]"><?php echo $content; ?></textarea></span>
</div>

<input type="submit" value="Send" onClick="return send_reminder();" class="done"/>
</div>
</form>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
    $("#sendReminderForm").validationEngine({promptPosition: "topLeft",scroll:false});
});

function send_reminder()
{
	var valid = $("#sendReminderForm").validationEngine('validate');
	if(valid)
	{ 
		var frm=$('#sendReminderForm').serialize();
		$.post(site_url+'/home/send_reminder_mail',frm,function(data){
			$('#reminder_section').html('Reminder has been sent.');
			redirect_to_summary(data);
			setTimeout(function(){$.fancybox.close();},2000);	
		});	
	}else{
			$("#sendReminderForm").validationEngine();
		}
	return false;			
}

</script>