<style>
div.error{display:block;text-align:center}
</style>
<section class="tabing_container">


        <section class="tabing">
          <ul>
            <li id="mail_pref"><a href="javascript://" onclick="show_mail_pref();">MAIL PREFERENCES</a></li>
            <li id="update_cred" class="active last"><a href="javascript://" onclick="show_update_cred();">UPDATE CREDENTIALS</a></li>
          </ul>
        </section>
        <input type="hidden" id="coachid" name="coachid" value="<?php echo $coachid;?>"/>
        <input type="hidden" id="tab" value="<?php echo $tab;?>"/>
		<section class="setting_section">
        </section>
        
      </section>
	  
<script language="javascript">
$(document).ready(function(e) {
var tab=$('#tab').val();
setTimeout(function(){ $('#flashmsg').fadeOut('slow')},3000);
if(tab)
	show_mail_pref();
else
	show_update_cred();
});

function show_mail_pref()
{
	var coachid=$('#coachid').val();
	$.post("<?php echo SITE_URL;?>/coach/show_mail_pref",'coachid='+coachid,function(data){
					$('#update_cred').removeClass('active');
					$('#mail_pref').addClass('active');
					$('.setting_section').html(data);
				});	
	
}

function show_update_cred()
{
	var coachid=$('#coachid').val();
	$.post("<?php echo SITE_URL;?>/coach/show_update_cred",'coachid='+coachid,function(data){
					$('#mail_pref').removeClass('active');
					$('#update_cred').addClass('active');
					$('.setting_section').html(data);
				});		
	
}


	
</script>

<?php echo $this->Js->writeBuffer(); ?>		  