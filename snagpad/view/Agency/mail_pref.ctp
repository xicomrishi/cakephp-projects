<section class="top_sec pad0">
<h3>Mail Preference</h3>
</section>
<div id="success_message" style="display:none;"></div>

<div class="settings_mail">
<form id="mailprefForm" name="mailprefForm" action="" method="post">
        <input type="hidden" id="coachid" name="coachid" value="<?php echo $coachid;?>"/>
        <fieldset>
        <section class="row">
        <label>Enable Daily Email Reminders :</label>
        <input type="radio" name="data[Coach][reminder_mail]" value="1" <?php if($coach['Coach']['reminder_mail']=='1'){echo 'checked';}?>/><span class="text">Yes</span>
         <input type="radio" name="data[Coach][reminder_mail]" value="0" <?php if($coach['Coach']['reminder_mail']=='0'){echo 'checked';}?>/><span class="text">No</span>
        </section>
       
        <section class="row">
        <label style="padding:5px 0 0 0">Set No. of days before being notified a clients card has not moved :</label>
        <input type="text" id="card_days" name="data[Coach][card_moved]" class="required digits textbox_1" value="<?php echo $coach['Coach']['card_moved'];?>"/>
        </section>
        
        <section class="row">
        <label style="padding:5px 0 0 0">Set No. of days before being notified a client has not logged in :</label>
        <input type="text" id="card_days" name="data[Coach][login_user]" class="required digits textbox_1" value="<?php echo $coach['Coach']['login_user'];?>"/>
        </section>
        
       <section class="row">
        <label>Do you want to receive an email notifying you that a client has an application pending? </label>
        <input type="radio" name="data[Coach][application_deadline]" value="1" <?php if($coach['Coach']['application_deadline']=='1'){echo 'checked';}?>/><span class="text">Yes</span>
         <input type="radio" name="data[Coach][application_deadline]" value="0" <?php if($coach['Coach']['application_deadline']=='0'){echo 'checked';}?>/><span class="text">No</span>
        </section>
        
          <section class="row">
        <label>Do you want to receive an email notifying you that a client has an upcoming interview? </label>
        <input type="radio" name="data[Coach][interview]" value="1" <?php if($coach['Coach']['interview']=='1'){echo 'checked';}?>/><span class="text">Yes</span>
         <input type="radio" name="data[Coach][interview]" value="0" <?php if($coach['Coach']['interview']=='0'){echo 'checked';}?>/><span class="text">No</span>
        </section>
        
        <br/>
         <section class="row">
        <input type="submit" value="Update" class="submitbtn" style="margin-top:37px !important; margin-left:248px !important;"/>
         </section>
        </fieldset>
        </form>
</div>        
<script language="javascript">
$(document).ready(function(e) {
    $("#mailprefForm").validate({
		submitHandler: function(form){
			$.post("<?php echo SITE_URL;?>/coach/add_mail_pref",$('#mailprefForm').serialize(),function(data){
					$('#success_message').html(data);
					$('#success_message').show();
				});	
			
		}
		
	});
});
</script>        
