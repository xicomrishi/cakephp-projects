<div class="apply_box">
<input type="hidden" id="client_id" value="<?php echo $clientid;?>"/>
  <p class="full">
  <?php if($col=='O'){ ?>
  	<p><strong>Congratulations on applying for this job!</strong><br/> We will send you an email to remind you to follow up with the employer if you have not heard anything. If you do get a call for an interview, simply hover over the job card and click the Interview tab and answer 'yes' to move it to the set interview column.'</p>
	<?php } ?>
    
      <?php if($col=='A'){ ?>
  	 <p><strong>Way to go! You’ve scheduled an interview with the employer!</strong><br/> With most job opportunities, less then 5% of applicants typically get a chance to interview for the job. To take advantage of this opportunity it's important to continue to think strategically throughout the remainder of the process. When you move this job card to the 'Set Interview' column, make sure to go through the strategy checklist so you can increase your chance of getting a job offer.</p>	
	<?php } ?>
  


  <div class="submit_row">
    <?php if($col=='O'){ ?>
  		<a class="save_btn" href="javascript://" onclick="opp_complete('<?php echo $card_id;?>','A')">I have applied</a>
        <a class="save_btn" href="javascript://" onclick="cancel_apply();">I have not applied</a>
	<?php } ?>
    
    
      <?php if($col=='A'){ ?>
  			<a class="save_btn" href="javascript://" onclick="opp_complete('<?php echo $card_id;?>','S')">OK</a>
	<?php } ?>
  </div>
  </div>
  
<script type="text/javascript">
function opp_complete(card,newstatus)
{
	var clientid=$('#client_id').val();
	$('.apply_box').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
	$.post('<?php echo SITE_URL;?>/strategies/update_card_column',{card_id:card,new_status:newstatus},function(data){
		//window.location='<?php echo SITE_URL;?>/jobcards';
		get_strategy_meter();
		disablePopup();
		show_top_tab(clientid);
		show_jobcards(clientid);
		var get_res=data.split("|");
		//$('.row_'+get_res[0]).html('<div style="height:100px; margin-top:100px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
		setTimeout(function(){show_strategy(card,get_res[0],newstatus)},3000);
		//alert(1);
		//show_strategy(card,get_res[0],newstatus);
		//$('.row_'+get_res[0]).addClass('active');
	});
}

function cancel_apply()
{
	disablePopup();
}
</script>  