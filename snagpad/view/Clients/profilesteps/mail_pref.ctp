<section class="top_sec pad0">
<h3>Mail Preference</h3>
</section>
<div id="success_message1" class="success" style="display:none;"></div>

<div class="settings_mail">
<form id="mailprefForm" name="mailprefForm" action="" method="post">
        <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
        <fieldset>
        <section class="row">
        <label>Enable Daily Email Reminders :</label>
        <input type="radio" name="data[Client][reminder_weekly_mail]" value="1" <?php if($client['Client']['reminder_weekly_mail']=='1'){echo 'checked';}?>/><span class="text">Yes</span>
         <input type="radio" name="data[Client][reminder_weekly_mail]" value="0" <?php if($client['Client']['reminder_weekly_mail']=='0'){echo 'checked';}?>/><span class="text">No</span>
        </section>
       
        <section class="row">
        <label style="padding:5px 0 0 0">Set the number of days to be notified via email that a card hasn't moved :</label>
        <input type="text" id="card_days" name="data[Client][same_card_days]" class="required digits textbox_1" value="<?php echo $client['Client']['same_card_days'];?>"/>
        </section>
        <br/>
         <section class="row">
        <input type="submit" value="Update" class="submitbtn" style="margin-top:37px !important; margin-left:248pxpx !important;"/>
         </section>
        </fieldset>
        </form>
</div>        
<script language="javascript">
$(document).ready(function(e) {
    $("#mailprefForm").validate({
		submitHandler: function(form){
			$.post("<?php echo SITE_URL;?>/clients/add_mail_pref",$('#mailprefForm').serialize(),function(data){
					$('#success_message1').html(data);
					$('#success_message1').show();
					setTimeout(function(){$('#success_message1').hide();},3000);
				});	
			
		}
		
	});
});
</script>        
