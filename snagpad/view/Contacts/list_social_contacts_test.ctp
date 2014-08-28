<section class="title_row">
         
        <span class="column1">IMAGE</span>
        <span class="column2 text_indent">NAME</span>
        <span class="column2 text_indent">EMAIL</span>
        <span class="column3">ACTION</span>
        
</section>
<section class="comon_row">	
<span class="column1 colour2">NA</span>
<span class="column2 colour3">Test</span>
<span class="column2"><input type="text" id="email_1234" name="cbox[]"/></span>
<span id="connect_1234" class="column3 colour3"><a href="javascript://" onclick="send_invite('1234','Test');">Invite</a></span>

</section>

<script type="text/javascript">
function send_invite(id,name)
{
	var email=$('#email_'+id).val();
	loadPopup('<?php echo SITE_URL;?>/contacts/send_invite/'+id+'/'+name+'/'+email);
}
</script>