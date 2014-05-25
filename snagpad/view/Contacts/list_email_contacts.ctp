<section class="tabing_container">

        <section class="tabing">
          <ul class="gap">
          
            <li class="active"><a>Gmail Contact(s)</a></li>
           
          </ul>
        </section>
  <section class="top_sec">
          <h3>Invite your Email Contacts</h3>
         <span class="delete_btn" style="float:right; width:auto"><a  href="<?php echo SITE_URL;?>/contacts/index/3" style="width:164px;;">Back to SnagCast</a></span>
        </section>       
<section class="contact_section">        
<section class="title_row">
         
       
        <span class="column2 text_indent">NAME</span>
       
        <span class="column3">ACTION</span>
        
</section>	

<?php echo $abc;
if(!empty($contacts)){
foreach($contacts as $key=>$contact){ ?>
<section class="comon_row"  style="min-height:32px">
<span class="column2 colour2"><?php echo $contact['email']; ?></span>
<span class="column3 colour3"><?php if($contact['exist']=='0'){ ?><a class="snaged_btn" href="javascript://" onclick="send_invite('0','<?php echo $contact['email']; ?>');">Invite</a><?php }else{ ?><a href="" class="snaged_btn snagged">Snagged</a><?php } ?></span>
</section>
<?php }}else{ ?>
<div class="reply_massage">Could not retrieve contacts!</div>
<?php } ?>
</section>
<script type="text/javascript">
function send_invite(id,email)
{
	loadPopup('<?php echo SITE_URL;?>/contacts/send_invite/'+email+'/'+id);
}
</script>