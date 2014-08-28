<div class="submit_left">
<h4><?php echo $popTitle;?></h4>
  <p class="full"><?php echo $check['Checklist']['description'];?></p>
  </div>
  <div class="submit_right">
  <div id="opp_error" class="error1">Please select industry</div>
  <form id="strat_industryForm" name="strat_industryForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	<input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
  	<label>Industry</label>
    <select id="industry" name="industry" <?php echo $disabled;?>>
    <option value="">Select</option>
    <?php foreach($industry as $ind){ ?>
    <option value="<?php echo $ind['Industry']['id'];?>" <?php if($ind['Industry']['id']==$card['Card']['industry']){echo 'selected';}?>><?php echo $ind['Industry']['industry'];?></option>
	<?php } ?>
    </select>   
    <?php if($disabled==''){?>
    <div class="submit_row">
     <a href="javascript://" onclick="submit_industry();" class="save_btn">SAVE</a>
     </div>
     <?php }?>
   </form>
   
</div>

<script type="text/javascript">
function submit_industry()
{
	var opp=$('#industry').val();
	if(opp=='')
	{
		$('#opp_error').show();	
	}else{
	var check_id=$('#check_id').val();	
	var frm1=$('#strat_industryForm').serialize();
	$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
	$.post('<?php echo SITE_URL;?>/strategies/save_industry',frm1,function(data){
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
	}
}
</script>
    