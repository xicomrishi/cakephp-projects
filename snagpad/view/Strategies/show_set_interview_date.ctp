<div class="submit_left">
<h4><?php echo $popTitle;?></h4>
  <p class="full"><?php echo $check['Checklist']['description'];?></p>
  </div>
  <div class="submit_right" >
   <div id="opp_error" class="error1"></div>
  <form id="strat_interviewdateForm" name="strat_interviewdateForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	<input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
    <div class="detail_row" style="padding:0 0 13px 0">
  	<label>Interview type</label>
    <input type="radio" name="interview_type" value="Face to Face" <?php if(empty($card['Card']['interview_type'])||($card['Card']['interview_type']=='Face to Face')){ echo 'checked';} echo ' '.$disabled;?>  class="radio"/><span class="text">Face to Face</span>
    <input type="radio" name="interview_type" value="Telephone" class="radio" <?php  if(!empty($card['Card']['interview_type'])&&($card['Card']['interview_type']=='Telephone')){ echo 'checked';} echo ' '.$disabled; ?>/><span class="text">Telephone</span>
    </div>
    <div class="detail_row" style="padding:0 0 13px 0">
    <label>Enter Interview Date</label>
    <input type="text" id="interview_date" name="interview_date" class="text" value="<?php if($date_val!='0000-00-00'&& $date_val!='12-31-1969'){echo $date_val;}?>" readonly="" <?php echo $disabled;?>/>
   </div>
   <div class="detail_row" style="padding:0 0 13px 0">
    <label>Employee Interview Time :</label>
    <?php
	/*$options = array(
    'label' => '',
    'type' => 'time',
    'timeFormat'=>'12',
    'separator'=>':',
	'selected'=>$time_val,
	'disabled'=>$disabled
);*/
		if(!empty($time_val)&& $time_val!='NULL'){ 
			$t_hour=array('value'=>$hour,'empty'=>false);
			$t_min=array('value'=>$min,'empty'=>false);
			$t_merid=array('value'=>$merid,'empty'=>false);
		}else{
			$t_hour=array('value'=>'01','empty'=>false);
			$t_min=array('value'=>'00','empty'=>false);
			$t_merid=array('value'=>'am','empty'=>false);
			
			}

	 echo $this->Form->hour('Card.interview_time_hour',false,$t_hour);
     echo $this->Form->minute('Card.interview_time_minute',$t_min);
	 echo $this->Form->meridian('Card.interview_time_meridian',$t_merid);?>
  <!--  <select name='hour' style="width:50px !important; padding:0px; margin:0 6px 0 0; display:inline; min-height:18px">
		<?php for($i=1;$i<=12;$i++) if($i<10) { ?> 
  	  <option value='0<?php echo $i;?>'>0<?php echo $i;?></option>
		<?php  }else{ ?>
 	   <option value='<?php echo $i;?>'><?php echo $i;?></option>
		<?php } ?>
    </select> 
    <span style="float:left;margin:0 6px 0 0; display:inline">: </span>
    <select style="width:50px !important; padding:0px; margin:0 6px 0 0; display:inline ;min-height:18px" name="minute"><?php for($i=0;$i<=50;$i+=10) if($i<10){ ?><option value='0<?php echo $i;?>'>0<?php echo $i;?></option><?php }else{ ?> <option value='<?php echo $i;?>'><?php echo $i;?></option><?php } ?></select> <select style="width:50px !important; padding:0px; min-height:18px" name="am"><option value='AM'>AM</option><option value='PM'>PM</option></select>-->
   	  </div>
      <div class="submit_row">
     <a href="javascript://" onclick="submit_interview_date();" class="save_btn">SAVE</a></div>
   </form>
   
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#opp_error').hide();
	//var year=new Date.getFullYear();
	//var y1=parseInt(year)+1;
	var to_day=new Date();
	$( "#interview_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			 minDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate()),
			yearRange: 'c:+1',
			dateFormat: 'mm-dd-yy'
			
			
		});
	});
	
	$('#interview_date').keyup(function(e) {
    if(e.keyCode == 8 || e.keyCode == 46) {
        $.datepicker._clearDate(this);
    }
});	
	
function submit_interview_date()
{
	var int_date=$('#interview_date').val();
	if(int_date=='')
	{
		$('#opp_error').html('Please select interview date');	
		$('#opp_error').show();
	}else{
		var check_id=$('#check_id').val();
		$.post('<?php echo SITE_URL;?>/strategies/save_set_interview_date',$('#strat_interviewdateForm').serialize(),function(data){
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
		show_calender_ico();
		
		}
}	


</script>
    