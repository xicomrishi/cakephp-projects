<input type="hidden" id="select_popup" value="<?php echo $link;?>"/>
<input type="hidden" id="card_id" value="<?php echo $card_id;?>"/>
<div id="jsbPopup"></div>
<div id="backgroundPopup"></div>
<script type="text/javascript">
$(document).ready(function(){
	var poplink=$('#select_popup').val();
	var card_id=$('#card_id').val();
	loadCardPopup('<?php echo SITE_URL;?>/strategies/'+poplink,card_id);
});
</script>