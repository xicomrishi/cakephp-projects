<div class="submit_left">
<h4><?php echo $popTitle;?></h4>
<?php if($flag==1||$flag==3||$flag==5){ ?>
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
   <div id="opp_error" class="error1"></div>
  <form id="strat_caldateForm" name="strat_caldateForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	<input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
   
    <div class="detail_row">
    <?php if($flag=='3'){ ?><label>Expected Date of Employer Decision: </label><?php if($saved_data!='0000-00-00'){ echo date('m-d-Y',strtotime($saved_data));}else{ echo 'NA'.'<br><br>';}} ?></div>
    <div class="detail_row">
     <label><?php if($flag=='1'){ echo 'Enter Reminder Date';} if($flag=='2'){echo 'Expected Date of Employer Decision';} if($flag=='4'){echo 'Start Date';} if($flag=='5'){echo 'Expected Response';} if($flag=='3'){echo 'Reminder Date for follow up:';}?></label>
    <input type="text" id="cal_date" class="text" name="<?php echo $field;?>" value="<?php if($date_val!='0000-00-00'){echo date('m-d-Y',strtotime($date_val));}?>" readonly="" <?php echo $disabled;?> /></div>
    <?php if($disabled==""){?>
 	  <div class="submit_row">
     <a href="javascript://" onclick="submit_cal_date();" class="save_btn">SAVE</a>
     </div>
     <?php }?>
   </form>
   
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up'});
	$('#opp_error').hide();	
	});
$(document).ready(function(){
	//var year=new Date.getFullYear();
	//var y1=parseInt(year)+1;
	var to_day=new Date();
	$( "#cal_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			minDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate()),
			yearRange: 'c:+1',
			dateFormat: 'mm-dd-yy'
			
		});
	$('#cal_date').keyup(function(e) {
    if(e.keyCode == 8 || e.keyCode == 46) {
        $.datepicker._clearDate(this);
    }
});	
		
	});
function submit_cal_date()
{
	var int_date=$('#cal_date').val();
	if(int_date=='')
	{
		$('#opp_error').html('Please select date');	
		$('#opp_error').show();
	}else{
		var check_id=$('#check_id').val();
			var frm1=$('#strat_caldateForm').serialize();
	$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');	
		$.post('<?php echo SITE_URL;?>/strategies/<?php echo $action;?>',frm1,function(data){
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
		show_calender_ico();
		}
}	


</script>
        