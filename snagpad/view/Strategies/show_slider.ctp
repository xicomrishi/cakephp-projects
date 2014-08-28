<?php echo $this->Html->css(array('jquery.ui.slider'));?>
<?php echo $this->Html->script('jquery-ui-1.9.1.custom.min');?>

<div class="submit_left">
<h4><?php echo $popTitle;?></h4>
<?php if($field=='ask_job'){ ?>
<div class="nano" style="width:220px !important">
<div class="strategy_pop_up">
  <p class="full"><?php echo $check['Checklist']['description'];?></p>
   </div>
  </div>
<?php }else{ ?>  
 <p class="full"><?php echo $check['Checklist']['description'];?></p>
<?php } ?>
  </div>
    <?php if($check['Checklist']['video']){ ?> 
  <div class="video">
  <?php echo $this->Html->link($this->Html->image('VideoLogo.png', array('alt' =>'View Video', 'border' => '0')), 'Javascript://', array('escape' => false, 'class' => 'logo','onClick'=>'viewStrategyvideo('.$check['Checklist']['id'].')')); ?>
  </div>
  <?php } ?>
  <div class="submit_right">
  <form id="strat_sliderForm" name="strat_sliderForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	<input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
    
  	<p><?php if($field=='skills_assessment'){ ?>On a scale of 1 to 5 rate yourself based on how well you feel your skills and abilities match up to the job opening. If you feel they don't match up well, indicate that with a 1, if you feel they match up very well, select 5.
	<?php }elseif($field=='job_fitness'){ ?>
    On a scale of 1 to 5 rate this job on how well it fits into your long-term career plans.
    <?php }elseif($field=='ask_job'){ ?>
   On a scale of 0 to 100 rate yourself based on What do you think your chances are to get asked back or be offered a job after this interview. If you feel they don't match up well, indicate that with a 0, if you feel they match up very well, select 100.
    <?php }?>
   
    
    </p>
   
    <input type="hidden" id="slider_val" name="<?php echo $field;?>" value=""/>
    <br/>
    <div id="slider">
    </div>
    <br/>
    <div id="show_slider_val">Current Value: 0</div>
   
                   
    <div class="submit_row">
<?php if($disabled==""){ ?><a href="javascript://" onclick="submit_sliderl();" class="save_btn">SAVE</a><?php }?></div>
    </form>
  </div>
<script type="text/javascript">

$(document).ready(function() {
 
$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up'});
		$( "#slider" ).slider({
			
			value:'<?php if(empty($slider_val)){ echo 1;}else{ echo $slider_val;}?>',
			range:'min',
			min: <?php echo $min;?>,
			max: <?php echo $max;?>,
			step: <?php echo $inc;?>,
			disabled:<?php if($disabled=="") echo "false"; else echo "true";?>,
			slide: function( event, ui ) {
				$( "#slider_val" ).val( ui.value );
				$( "#show_slider_val" ).html( 'Current Value: '+ui.value);
			}
		});
		$( "#slider_val" ).val('<?php echo $slider_val;?>');
		$( "#show_slider_val" ).html( 'Current Value: <?php if(empty($slider_val)){ echo 1;}else{ echo $slider_val;}?>' );
});
	
function submit_sliderl()
{	var check_id=$('#check_id').val();
		var frm1=$('#strat_sliderForm').serialize();
	$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');	
	$.post('<?php echo SITE_URL;?>/strategies/<?php echo $action;?>',frm1,function(data){
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});	
}	
</script>  