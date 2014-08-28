<div class="submit_left">
  <p class="full"><?php echo $check['Checklist']['description'];?></p>
  </div>
  <div class="submit_right">
   <form id="strat_wearForm" name="strat_wearForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	 <input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
     
     <div class="submit_row">
       <a href="<?php echo $path; ?>" target="_blank" onclick="submit_wear();" class="save_btn">Download Pdf</a></div>
   </form>
   
</div>

<script type="text/javascript">
function submit_wear()
{
	var check_id=$('#check_id').val();
		$.post('<?php echo SITE_URL;?>/strategies/save_wear',$('#strat_wearForm').serialize(),function(data) {
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
		
			
}
</script>
      