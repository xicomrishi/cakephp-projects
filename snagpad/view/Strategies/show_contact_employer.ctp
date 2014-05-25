<section class="submit_left">
<h4><?php echo $popTitle;?></h4>
<div class="nano" style="width:220px !important">
<section class="strategy_pop_up">
  <p class="full"><?php echo strip_tags(html_entity_decode($check['Checklist']['description']));?></p>
  </section>
  </div>
   </section>
  

  <section class="submit_right">
  
  	 <form id="strat_employerForm" name="strat_employerForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	 <input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
  	   <div class="submit_row1">
     <a href="<?php echo $url;?>" target="_blank" onclick="submit_source_of_job();" class="save_btn"><?php echo $submit_button_text;?></a>
     </div>
 </form>
   
</section>


<script type="text/javascript">
$(document).ready(function(){
	$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up'});
	});

function submit_source_of_job()
{
	<?php if($disabled==''){?>
	var check_id=$('#check_id').val();
	$.post('<?php echo SITE_URL;?>/strategies/<?php echo $action;?>',$('#strat_employerForm').serialize(),function(data){
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
	<?php }?>
}
</script>
    