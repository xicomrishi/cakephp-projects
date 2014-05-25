<div class="head_row">
  
  <p id="msg_success" class="success"></p>
  </div>
  <div class="pop_up_detail">
  <div class="setting_section">
  	<div class="box">
 
 		 <form id="sendmessageForm" name="sendmessageForm" action="" method="post">	
            <input type="hidden" id="card_id" name="card_id" value="<?php echo $card['Card']['id'];?>"/>
             <input type="hidden" id="check_id" name="check_id" value="<?php echo $check_id?>"/>
             
            
             <div class="row">
<label>To: </label>
<input type="hidden" name="to_id" value="<?php foreach($data as $dat){ echo $dat['id'].' '; } ?>"/>
<input type="text" name="to_title" value="<?php foreach($data as $dat){ echo $dat['title'].' '; }?>" /></div>
<div class="row">
<label>Message</label>
<div class="submit_right" style="float:none; border-left:none; margin-left:102px;">
<textarea name="message">Hi there,
I'm in the process of conducting a job search and I'm interested in applying for a position within <?php echo $card['Card']['company_name'];?>. I was wondering if you would be willing to connect so I could learn more about your experience with them.  If not, perhaps you would be willing to pass this along to one of your contacts who is connected to the organization and may be willing to share some information with me. Any help would be appreciated,
Regards,
<?php echo $this->Session->read('Client.Client.name');?></textarea></div></div>
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
	var card_id=$('#card_id').val();	
	$.post('<?php echo SITE_URL;?>/strategies/send_message',$('#sendmessageForm').serialize(),function(frm){
			$('#msg_success').html('A Message is sent to your friends.');
			setTimeout(function(){ disablePopup();},2500);
			show_strategy(card_id,1,'O');
			$("html, body").animate({ scrollTop: $('.row_'+card_id).offset().top - 80}, 500);	
		});	
		return false;
}
</script>
 
