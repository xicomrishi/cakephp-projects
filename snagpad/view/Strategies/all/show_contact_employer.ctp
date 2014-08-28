<div class="submit_left">
<h4><?php echo $popTitle;?></h4>
<div class="nano" style="width:220px !important">
<div class="strategy_pop_up">
  <p class="full"><?php echo strip_tags(html_entity_decode($check['Checklist']['description']));?></p>
  </div>
  </div>
   </div>
  <?php if($check['Checklist']['video']){ ?> 
  <div class="video">
  <?php echo $this->Html->link($this->Html->image('VideoLogo.png', array('alt' =>'View Video', 'border' => '0')), 'Javascript://', array('escape' => false, 'class' => 'logo','onClick'=>'viewStrategyvideo('.$check['Checklist']['id'].')')); ?>
  </div>
  <?php } ?>

  <div class="submit_right">
  
  	 <form id="strat_employerForm" name="strat_employerForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	 <input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
  	   <div class="submit_row1">
     <a href="<?php echo $url;?>" target="_blank" onclick="submit_source_of_job();" class="save_btn"><?php echo $submit_button_text;?></a>
     </div>
 </form>
   
</div>


<script type="text/javascript">
$(document).ready(function(){
	$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up'});
	});

function submit_source_of_job()
{
	<?php if($disabled==''){?>
	var check_id=$('#check_id').val();
		var frm1=$('#strat_employerForm').serialize();
	$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');	
	$.post('<?php echo SITE_URL;?>/strategies/<?php echo $action;?>',frm1,function(data){
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
	<?php }?>
}
</script>
    