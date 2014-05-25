<section class="title_row">
         
        <span class="column1">IMAGE</span>
        <span class="column2 text_indent">NAME</span>
       
        <span class="column3">ACTION</span>
        
</section>	
<?php  if(isset($fb_friends)){ 
			foreach($fb_friends as $fnd){
?>
<section class="comon_row facebook">	

<span class="column1 colour2"><img src='https://graph.facebook.com/<?php echo $fnd['uid']; ?>/picture' alt='<?php echo $fnd['name']; ?>' title='<?php echo $fnd['name']; ?>' border='0' align='absmiddle'></span>
 <span class="column2 colour3"><?php echo $fnd['name'];?></span>
 
  <span id="connect_<?php echo $fnd['uid'];?>" class="column3 colour3"><?php if($fnd['exist']==0){ ?><a class="snaged_btn" href="javascript://" onclick="send_invite('<?php echo $fnd['uid'];?>','<?php echo $fnd['name'];?>');">Invite</a><?php }else{ ?><a href="" class="snaged_btn snagged">Snagged</a><?php } ?></span>


</section>


<?php }}if(is_array($friends)){  
	foreach($friends as $frnd){
		if(isset($frnd['first-name'])){
		
?>
<section class="comon_row linkedin">	

<span class="column1 colour2"><?php  if(isset($frnd['picture-url'])) echo "<img src='".$frnd['picture-url']."' alt='".$frnd['headline']."' title='".$frnd['headline']."' border='0' align='absmiddle'><br>"; else echo "<img src='".SITE_URL."/img/photo.png' title='".$frnd['headline']."' border='1' align='absmiddle'>" ?></span>
 <span class="column2 colour3"><?php echo $frnd['first-name'].' '. $frnd['last-name'];?></span>
 
  <span id="connect_<?php echo $frnd['id'];?>" class="column3 colour3"><?php if($frnd['exist']==0){ ?><a class="snaged_btn" href="javascript://" onclick="send_invite('<?php echo $frnd['id'];?>','<?php echo $frnd['first-name'];?>');">Invite</a><?php }else{ ?><a href="" class="snaged_btn snagged">Snagged</a><?php } ?></span>
</section>


<?php }}} ?>


<script type="text/javascript">
function send_invite(id,name)
{
	loadPopup('<?php echo SITE_URL;?>/contacts/send_invite/'+name+'/'+id);
}
</script>

