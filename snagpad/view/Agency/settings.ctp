<style>
div.error{display:block;text-align:center}
</style>
<?php echo 	$this->Html->Script('/ckeditor/ckeditor');?>
<?php echo $this->Html->Script('jquery.ocupload'); ?>

<section class="tabing_container">


        <section class="tabing">
          <ul>
            <li id="update_cred" class="active"><a href="javascript://" onclick="show_update_cred(0)">PROFILE</a></li>
              <li id="mail_pref" class="last"><a href="javascript://" onclick="show_update_cred(1)">SETTINGS</a></li>
          </ul>
        </section>
        <input type="hidden" id="coachid" name="coachid" value="<?php echo $coachid;?>"/>
		<section class="setting_section">
        </section>
        
      </section>
	  
<script language="javascript">
$(document).ready(function(e) {
setTimeout(function(){ $('#flashmsg').fadeOut('slow');},2000);
show_update_cred(0);
});
function show_update_cred(type)
{
	var coachid=$('#coachid').val();
        			
  
	$.post("<?php echo SITE_URL;?>/agency/show_update_cred/"+type,'coachid='+coachid,function(data){
					$('.setting_section').html(data);
		if(type==0){
					$('#mail_pref').removeClass('active');
					$('#update_cred').addClass('active');
								
								 CKEDITOR.replace('data[Agency][description]');
								CKEDITOR.replace('data[Agency][specification]');
			
		}
		else{
				$('#mail_pref').addClass('active');
					$('#update_cred').removeClass('active');

		}

				});		
}


	
</script>

<?php echo $this->Js->writeBuffer(); ?>		  