<div class="submit_left">
<h4><?php echo $popTitle;?></h4>
<div class="nano" style="width:220px !important">
<div class="strategy_pop_up">
  <p class="full"><?php echo $check['Checklist']['description'];?></p>
  </div>
  </div>
  </div>
   <?php if($check['Checklist']['video']){ ?> 
  <div class="video">
  <?php echo $this->Html->link($this->Html->image('VideoLogo.png', array('alt' =>'View Video', 'border' => '0')), 'Javascript://', array('escape' => false, 'class' => 'logo','onClick'=>'viewStrategyvideo('.$check['Checklist']['id'].')')); ?>
  </div>
  <?php } ?>
  <div class="submit_right">
  <div id="opp_error" class="error1"></div>
  <form id="strat_hiringcycleForm" name="strat_hiringcycleForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	<input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
    <div class="detail_row" style="padding:0 0 12px 0">
  	<label>Date Job First Posted:</label>
    <input type="text" id="first_post_date" name="data[Cardcolumn][job_first_posted_date]" class="text" value="<?php if($card_detail['Cardcolumn']['job_first_posted_date']!='0000-00-00'){ echo date('m-d-Y',strtotime($card_detail['Cardcolumn']['job_first_posted_date']));}?>" readonly="" <?php echo $disabled;?>/></div>
    <div class="detail_row" style="padding:0 0 12px 0">
    <label>Date You Acquired Job Card : </label><?php echo date('m-d-Y H:i:s',strtotime($card['Card']['reg_date']));?></div>
    <div class="detail_row" style="padding:0 0 12px 0">
    <label>Employee Start Date :</label>
    <input type="text" id="employee_start_date" name="data[Cardcolumn][employee_start_date]" class="text" value="<?php if($card_detail['Cardcolumn']['employee_start_date']!='0000-00-00'){echo date('m-d-Y',strtotime($card_detail['Cardcolumn']['employee_start_date']));}?>" readonly=""  <?php echo $disabled;?>/></div>
<?php if($disabled==""){?>
   	  <div class="submit_row">
     <a href="javascript://" onclick="submit_hiringcycle();" class="save_btn">SAVE</a></div>
<?php }?>     
   </form>
   
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up'});
	});

$(document).ready(function(){
	//var year=new Date.getFullYear();
	//var y1=parseInt(year)+1;
	$( "#first_post_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: 'c:+1',
			dateFormat: 'mm-dd-yy',
			onSelect: function( selectedDate ) {
				$( "#employee_start_date" ).datepicker( "option", "minDate", selectedDate );
			}
			//showOn: ("focus")
		});
		$( "#employee_start_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: 'c:+1',
			dateFormat: 'mm-dd-yy',
			onSelect: function( selectedDate ) {
				$( "#first_post_date" ).datepicker( "option", "maxDate", selectedDate );
			}
			//showOn: ("focus")
		});
		$('#first_post_date').keyup(function(e) {
   		 if(e.keyCode == 8 || e.keyCode == 46) {
        $.datepicker._clearDate(this);
    	}
		});	
		$('#employee_start_date').keyup(function(e) {
   		 if(e.keyCode == 8 || e.keyCode == 46) {
        $.datepicker._clearDate(this);
    	}
		});		
		
		
});

function submit_hiringcycle()
{
	var d1=$('#first_post_date').val();
	var d2=$('#employee_start_date').val();
	if(d1=='')
	{	$('#opp_error').html('Please enter Job first posted date');
		$('#opp_error').show();	
	}else if(d2==''){
		$('#opp_error').html('Please enter Employee start date');
		$('#opp_error').show();
	}else{
		
		var check_id=$('#check_id').val();
			var frm1=$('#strat_hiringcycleForm').serialize();
			$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
			$.post('<?php echo SITE_URL;?>/strategies/save_hiringcycle',frm1,function(data){
			disablePopup();
			
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
	}
}
</script>
    