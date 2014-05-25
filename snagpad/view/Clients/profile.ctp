<div id="jsbPopup"></div>
<div id="backgroundPopup"></div>
<input type="hidden" id="first" value="<?php echo $first; ?>"/>
<script language="javascript">
$(document).ready(function(e) {
	var first=$('#first').val();
    if(first=='1')
	{
		loadPopup('<?php echo SITE_URL;?>/clients/profile_setup');
		}else{
	loadPopup('<?php echo SITE_URL;?>/clients/profile_step1');
		}
});
</script>