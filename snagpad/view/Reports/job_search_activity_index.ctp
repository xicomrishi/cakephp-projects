<input type="hidden" id="client_id" value="<?php echo $clientid; ?>"/>
<section class="search_histry">
	<div class="display_job_hist" style="border-bottom:1px solid #ccc">
        <div class="col_1">
    	<label>Client</label>
        <p><?php echo $client['Client']['name'];?></p>
        </div>
        <div class="col_1">
        <label>Last Card Move Date</label>
        <p><?php echo show_formatted_datetime($latest_date);?></p>
        </div>
        <div class="col_1">
        <label>Job Search Start Date</label>
        <p><?php echo show_formatted_datetime($client['Client']['reg_date']);?></p>
        </div>
        <div class="col_1">
        <label>Job A</label>
        <p><?php if(!empty($client['Client']['job_a_title'])){ echo $client['Client']['job_a_title'];}else{ echo 'NA';}?></p>
        </div>
        <div class="col_1">
         <label>Job B</label>
        <p><?php if(!empty($client['Client']['job_b_criteria'])){ echo $client['Client']['job_b_criteria'];}else{echo 'NA';} ?></p>
        </div>
    </div>
    
    <div class="display_job_hist">
    	<h3 style="color:#FF9600">Job Card</h3>
    	<div class="display_job_hist" style="border-bottom:1px solid #ccc">
        <div class="col_1">
        	<label>Number of Job A identified</label>
            <p><?php echo $job_A['count'];?></p>
            </div>
            <div class="col_1">
            <label>Avg. time a card is in a Column:</label>
            <p><?php if(!empty($job_A['avg_time'])){echo $job_A['avg_time'].' days';}else{ echo '0';} ?></p>
            </div>
            <div class="col_1">
            <label>Number of Job B identified</label>
            <p><?php echo $job_B['count'];?></p>
            </div>
            <div class="col_1">
            <label>Avg. time a card is in a Column:</label>
            <p><?php if(!empty($job_B['avg_time'])){echo $job_B['avg_time'].' days';}else{ echo '0';} ?></p>
            </div>
            <div class="col_1 small">
        	<label>Current S-A-I Status: </label>
            <p class="timeframe_sai"><?php echo $card_SAI_status['O'].'-'.$card_SAI_status['A'].'-'.$card_SAI_status['I'];?></p>
           </div>
            <div class="error"></div>
            <div class="col_1 large">
            <label class="none">Filter S-A-I Timeframe</label>
            <label for="from" class="none">From</label>
            <input type="text" id="from" name="from" class="input"/>
            <label for="to" class="none">to</label>
            <input type="text" id="to" name="to" class="input"/>
            <input type="submit" onclick="check_date_range()" value="Search" class="search"/>
            </div>
        </div>
        
        <div class="display_job_hist">
            
        	<h3 style="color:#FF9600">Movement of Cards</h3>
            <div class="col_1 large">
            <p class="small">S-A-I Timeframe: </p>
            <label class="none" style="float:none">From: </label><span class="text"><?php echo show_formatted_datetime($client['Client']['reg_date']);?></span>
            <label class="none" style="float:none"> To:</label><span class="text"><?php echo show_formatted_date(date("Y-m-d"));?></span></div>
        	
            <div class="card_movement"></div>
            
        </div>
        
    
    </div>


</section>

<script type="text/javascript">
$(document).ready(function(e) {
    display_card_movement();
});
		$( "#from" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			minDate:'<?php echo $client['Client']['reg_date'];?>',
			onSelect: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			minDate:'<?php echo $client['Client']['reg_date'];?>',
			onSelect: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			}



});
		
function check_date_range()
{
	var from=$('#from').val();
	var to=$('#to').val();
	
	if(from==''||to=='')
	{
		$('.error1').html('Please select date');
		$('.error1').show();
	}else{
			var clientid=$('#client_id').val();
			$.post('<?php echo SITE_URL;?>/reports/job_activity_for_date',{from:from,to:to,clientid:clientid},function(data){
				
				$('.timeframe_sai').html(data);
			});
			
		}	
}		

function display_card_movement()
{
	var clientid=$('#client_id').val();
	$.post('<?php echo SITE_URL;?>/reports/movement_card',{clientid:clientid},function(data){
			$('.card_movement').html(data);
		});	
}

	
</script>		