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
        <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
		<section class="setting_section">
        </section>
        
      </section>
	  
<script language="javascript">
$(document).ready(function(e) {
setTimeout($('#flashmsg').fadeOut('slow'),500000);
show_update_cred();
});

function show_mail_pref()
{
	var clientid=$('#clientid').val();
	$.post("<?php echo SITE_URL;?>/clients/show_mail_pref",'clientid='+clientid,function(data){
					$('#update_cred').removeClass('active');
					$('#mail_pref').addClass('active');
					$('.setting_section').html(data);
				});	
	
}

function show_update_cred()
{
	var clientid=$('#clientid').val();
	$.post("<?php echo SITE_URL;?>/clients/show_update_cred",'clientid='+clientid,function(data){
					$('#mail_pref').removeClass('active');
					$('#update_cred').addClass('active');
					$('.setting_section').html(data);
				});		
	
}


	
</script>

<?php echo $this->Js->writeBuffer(); ?>		  