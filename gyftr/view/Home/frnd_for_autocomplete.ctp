<?php foreach($fdat as $fr){ ?>
<div id="frnd_<?php echo $fr['value']; ?>" class="frnd_img" onclick="append_frnd('<?php echo $fr['label']; ?>','<?php echo $fr['value']; ?>','<?php echo $num; ?>');"><?php echo $this->Html->image('facebook_profile_pic.jpg',array('escape'=>false));?><span><?php echo $fr['label']; ?></span></div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(e) {
   setUserSession('<?php echo $userid; ?>'); 
});
function setUserSession(userid)
{
	$.post('<?php echo SITE_URL; ?>/home/setUserSession/'+userid,function(data){
		
	});	
}
</script>