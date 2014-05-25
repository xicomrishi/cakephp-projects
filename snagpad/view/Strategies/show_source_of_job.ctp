<section class="submit_left">
<h4><?php echo $popTitle;?></h4>
  <p class="full"><?php echo $check['Checklist']['description'];?></p>
  </section>
  <section class="submit_right">
  <div id="opp_error" class="error1">Please select the source</div>
  <form id="strat_source_of_jobForm" name="strat_source_of_jobForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	<input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
  	<label>Opportunity found through</label>
    <select id="type_of_op" name="type_of_op" <?php echo $disabled;?>>
    <option value="">Select</option>
    <?php foreach($opportunity as $opp){ ?>
    <option value="<?php echo $opp['Opportunity']['name'];?>" <?php if($opp['Opportunity']['name']==$card['Card']['type_of_opportunity']){echo 'selected';}?>><?php echo $opp['Opportunity']['name'];?></option>
   
	<?php } ?>
    </select>   
    <?php if($disabled==""){?>
    <div class="submit_row">
     <a href="javascript://" onclick="submit_source_of_job();" class="save_btn">SAVE</a>
     </div>
     <?php }?>
   </form>
   
</section>

<script type="text/javascript">
function submit_source_of_job()
{
	var opp=$('#type_of_op').val();
	if(opp=='')
	{
		$('#opp_error').show();	
	}else{
		var check_id=$('#check_id').val();
	$.post('<?php echo SITE_URL;?>/strategies/save_source_of_job',$('#strat_source_of_jobForm').serialize(),function(data){
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
	}
}
</script>
    