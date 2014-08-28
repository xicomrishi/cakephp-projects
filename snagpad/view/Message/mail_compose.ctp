<section class="top_sec pad2">
<h3>Compose Message</h3>
</section>
<div id="success_message" style="display:none;"></div>

<div class="settings_mail">
<form id="mailprefForm" name="mailprefForm" action="<?php echo SITE_URL;?>/message/compose_submit" method="post" enctype="multipart/form-data">
        <input type="hidden" name="from_userid" id="from_userid" value="<?php echo $this->Session->read('Account.id');?>" />
        <input type="hidden" name="from_usertype" id="from_usertype" value="<?php echo $this->Session->read('usertype');?>" />
        <input type="hidden" name="group_id" id="group_id" value="<?php if(isset($group_id)) echo $group_id; else echo 0;?>" />
        <fieldset>
         <section class="row" style="width:760px">
        <?php if(isset($clients)){?>
       
        <label style="width:310px"><?php if(isset($no_coach)){ ?>Select Contact(s)<?php }else{ ?>Select Clients*<?php } ?> :</label>
        <select name="to_users[]"  style="width:420px" id="trclient" class="required select"  multiple="multiple" size="4" onchange="changeclient()">
        <?php if(!empty($clients)){ ?><option value="0">All Clients</option><?php } ?>
        <?php foreach($clients as $key=>$val)
        	echo "<option value='$key'>$val</option>";
		?>
        </select>
        <input type="hidden" name="to_usertype" value="3" />
        <?php }else{?>
        <label style="width:310px"><?php echo $to_title;?></label><span class="notes"  style="width:395px"><?php if(isset($no_coach)){ echo "You are not linked to a coach"; }else{ echo $to_name; } ?></span>
        <input type="hidden" name="to_userid" value="<?php echo $to_userid;?>" />
        <input type="hidden" name="to_usertype" value="<?php echo $to_usertype;?>" />
        <?php }?>
        </section>
       
        <section class="row">
        <label style="padding:5px 0 0 0; width:310px">Subject :</label>
        <input type="text" id="subject" name="subject" class="required textbox_1" value="<?php if(isset($subject)) echo $subject;?>" style="width:395px"/>
        </section>
        
        <section class="row">
        <label style="padding:5px 0 0 0;width:310px">Message :</label>
        <textarea name="message" id="message" class="required textbox_1" style="width:395px; height:80px"><?php if(isset($message)) echo $message;?></textarea>
        </section>
        
          <div class="row">
        <label style="width:310px">Attachment</label>
        <input type="file" name="attachment" id="attachment" class="browse" style="width:395px" />
        </div>
        <section class="row">
        <label style="width:310px">&nbsp;</label>
        <span class="notes"  style="width:395px">[.exe files are not allowed]</span>
        </section>
<!--         <section class="row">
        <label style="font-size:15px;">*Hold the control button to select multiple clients.</label>
        </section>-->
        <br/>
         <section class="row" style="text-align:center; width:100%">
        <input type="submit" value="Send" class="submitbtn" style="margin:37px 0 0 0 !important; float:none !important"/>
         </section>
        </fieldset>
        </form>
</div>        
<script language="javascript">
$(document).ready(function(e) {
    $("#mailprefForm").validate({
		submitHandler: function(form){
			<?php if(isset($no_coach)){ ?>
				alert('You are not linked to a coach');
			<?php }else{ ?>
				document.mailprefForm.submit();
				<?php } ?>
			/*$.post("<?php echo SITE_URL;?>/message/compose_submit",$('#mailprefForm').serialize(),function(data){
					$('#success_message').html(data);
					$('#success_message').show();
					show_search(1);
				});	
			*/
		}
		
	});
});
function changeclient()
{
if(document.getElementById('trclient')!='undefined' && document.getElementById('trclient')!=null){
	if(document.getElementById('trclient').options[0].selected==true)
	{
		len=document.getElementById('trclient').options.length;
		for(i=0;i<len;i++)
			document.getElementById('trclient').options[i].selected=true;
		
	}
}	
}
</script>        
