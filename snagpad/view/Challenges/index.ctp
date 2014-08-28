<section class="tabing_container">
		<input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id;?>"/>
        <input type="hidden" id="setting" value="<?php if(isset($setting)) echo $setting;?>"/>
        
        <section class="tabing">
          <ul>
           <?php if($usertype==3){?> <li class="active"><a href="javascript://" id="challengeSurvey" onclick="show_challenge_survey('<?php echo $client_id;?>');">CHALLENGE SURVEY</a></li><?php } ?>
            <li class="last"><a href="javascript://" id="myChallenge" onclick="show_my_challenge('<?php echo $client_id;?>');">MY CHALLENGES</a></li>
          </ul>
        </section>
      <div id="challenge_index_content"></div>
      </section>

<script type="text/javascript">
$(document).ready(function(e) {
	var clientid=$('#client_id').val();
	if($('#setting').val()=='start')
    	show_challenge_survey(clientid);
	else if($('#setting').val()=='ch_progress')
			show_my_challenge(clientid,'ch_progress');
	else	
		show_my_challenge(clientid,'0');
});

function show_challenge_survey(clientid)
{
	$('#challengeSurvey').parent().addClass('active');
	$('#myChallenge').parent().removeClass('active');
	loading('#challenge_index_content');
	$.post('<?php echo SITE_URL;?>/challenges/activity_settings',{client_id:clientid},function(data){
			$('#challenge_index_content').html(data);
		});	
}

function show_my_challenge(clientid,challengeid)
{
	loading('#challenge_index_content');
	$('#challengeSurvey').parent().removeClass('active');
	$('#myChallenge').parent().addClass('active');
	
	$.post('<?php echo SITE_URL;?>/challenges/my_challenge',{client_id:clientid,challenge_id:challengeid},function(data){
			$('#challenge_index_content').html(data);
		});	
}

function completeChallenge(challengeid,id,status)
{
	loading('#challenge_index_content');
	$('#challengeSurvey').parent().removeClass('active');
	$('#myChallenge').parent().removeClass('active');
	var clientid=$('#client_id').val();
	$.post('<?php echo SITE_URL;?>/challenges/form',{client_id:clientid,challenge_id:challengeid,status:status},function(data){
			$('#challenge_index_content').html(data);
		});	
}
function loading(divid)
{
	$(divid).html('<div align="center" id="loading" style="height:100px;padding-top:150px;width:850px; text-align:center;"><img src="<?php echo SITE_URL;?>/img/loading.gif" alt="Loading" border="0" align="middle" /></div>');
 }
	
</script>      