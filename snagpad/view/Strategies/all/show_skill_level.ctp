<?php echo $this->Html->css(array('datepicker/jquery.ui.core.min','datepicker/jquery.ui.theme.min','datepicker/jquery-ui.min'));?>
<?php echo $this->Html->script(array('datepicker/jquery.ui.core.min','fileupload/jquery.ui.widget','jquery.ui.mouse','jquery.ui.slider'));?>
<style type="text/css">  
	#slider1{ width:510px; }	
	.ui-widget{width:520px; font-size:12px; }
  </style>
<div class="head_row">
  <p class="full"><?php echo $check['Checklist']['description'];?></p>
  </div>
  <div class="pop_up_detail">
  <form id="strat_skill_levelForm" name="strat_skill_levelForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	<input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
  	<p>On a scale of 1 to 5 rate yourself based on how well you feel your skills and abilities match up to the job opening. If you feel they don't match up well, indicate that with a 1, if you feel they match up very well, select 5.</p>
   
    <input type="hidden" id="skill_assessment" name="skills_assessment" value=""/>
    <div id="slider"></div>
    <div class="ui-widget">
					<?php for($k=0;$k<5;$k+=1)
						echo "<div class=\"div\"><span class=\"text\">$k</span></div>";
				    ?>
					<div class=""><span class="text"><?php echo 5; ?></span></div></div>
<?php if($disabled==""){?>    <a href="javascript://" onclick="submit_skill_level();" class="save_btn">SUBMIT</a><?php }?>
    </form>
  </div>
<script type="text/javascript">
$(function() {
		$( "#slider" ).slider({
			value:1,
			min: 1,
			max: 5,
			step: 1,
			disabled:<?php if($disabled=="") echo "false"; else echo "true";?>,
			slide: function( event, ui ) {
				$( "#skill_assessment" ).val( ui.value );
			}
		});
		$( "#skill_assessment" ).val( $( "#slider" ).slider( "value" ) );
	});
function submit_skill_level()
{	var check_id=$('#check_id').val();
	var frm1=$('#strat_skill_levelForm').serialize();
	$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
	$.post('<?php echo SITE_URL;?>/strategies/save_skill_level',frm1,function(data){
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});	
}	
</script>  