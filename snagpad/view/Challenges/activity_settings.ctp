  <section class="top_sec">
          <section class="left_sec space">
            <h3>Challenge Survey</h3>
            <p>To determine your 'weekly challenge point total', fill out the following survey. Each month you will be sent an email to come back and update the survey. Your weekly point total is based on the responses you provide.</p>
          </section>
        </section>        
        <section class="challenge_section">
        <form name="quesSurveyForm" id="quesSurveyForm" method="post" action="">       
        <fieldset>
        <?php 
			$disabled="";
			//print_r($a_dective[0][0]['diff']);
			//print_r($a_dective[0]['jsb_client']['challenge_date']);
	if($a_dective[0]['jsb_client']['challenge_date']!='0000-00-00' && $a_dective[0][0]['diff']>=28)
	{		
		echo '<p class="msg">You are going to change your activity setting, this will reset your challenges</p>';
	}
	elseif($a_dective[0]['jsb_client']['challenge_date']!='0000-00-00')
	{
			$disabled="disabled";
			//print_r($a_dective[0][0]['diff']);
		//print_r($a_dective[0]['jsb_client']['challenge_date']);
	}
	//echo $disabled;
		$i=1;
		foreach($ques as $q){ ?>        
         <section class="question_row">
        <h3 <?php if($i==1){ echo 'class="space"';}?>><span><?php echo $i;?>.</span><?php echo $q['question'];?>:</h3>
        <ul>
        <?php foreach($q['data'] as $dat){ ?>
       		 <li><input type="radio" class="required" name="ques_<?php echo $i;?>" value="<?php echo $dat['point'];?>" <?php if(isset($ans[$i])) if($ans[$i]==$dat['point']) echo 'Checked="Checked"'; echo $disabled;?> /><?php echo $dat['answer'];?></li>
        <?php } ?>
        </ul>
        </section>
        <?php $i++; } ?>
        <?php if($disabled=="") { ?>
        
        <div class="common_btn"><a href="javascript://" onclick="submit_survey();">SUBMIT</a></div>
		<?php } ?>
        </fieldset>
        </form>
        </section>
<script type="text/javascript">
function submit_survey()
{
	
	var clientid=$('#client_id').val();
	if($('#quesSurveyForm').valid())
	{
		$.post('<?php echo SITE_URL;?>/challenges/activity_submit',$('#quesSurveyForm').serialize()+'&client_id='+clientid,function(data){					
						show_my_challenge(clientid,'0');
						show_challenge_scroll();
				});	
				
	}
	else
	{	var oft;
		var ofts=$('.error');
		for(i=0;i<ofts.length;i++)
		{
			if(ofts[i].style.display!="none")
			{
				oft=ofts[i];
				break;
			}
		}
		if(oft==null)
		return;
		var t=$(oft).offset().top;		
		t=t-100;
		window.scrollTo(0,t);
	}
	
}
</script>        