<input type="hidden" id="profile_step_no" value="<?php echo $step; ?>"/>
 <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>

<div id="step1">
</div>
<script type="text/javascript">
$(document).ready(function(e) {
    var step=$('#profile_step_no').val();
	var clientid=$('#clientid').val();
	$.post('<?php echo SITE_URL;?>/clients/profile_step'+step,'cl_id='+clientid,function(data){	
					$("#step1").html(data);
				
			});	
});
</script>
