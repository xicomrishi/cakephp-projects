<?php echo $this->Html->script(array('highcharts'));?>
<section id="report_container">
<section class="job_indicater">
	<div id="container" class="graph" style="min-width: 270px; height: 419px; margin: 0 auto"></div>
  <!--<div class="graph"><img src="common/images/graph.png" alt="" ></div>-->
   <h3><span class="space1">HIDDEN JOB</span><br><span class="space2">MARKET</span><br>INDICATOR</h3>

</section>
  
<section class="searchometer searchometer1">
<h3>SEARCHOMETER</h3>
<ul>
<li class="first" onmouseout="hideTooltip();" onmouseover="showTooltip(event,'The strategic score is based on the aggregate of all checked items in the strategies tab across all of your job cards. The more items you check, the higher your score.');"><h4>STRATEGIC SCORE</h4><div class="meter_box"><figure class="img_m"><?php echo $this->Html->image('meter_big_bg1.png',array('escape'=>false,'class'=>'big_meter'));?></figure><strong class="speed strat_speed_report">0%</strong></div></li>
<li class="sec" onmouseout="hideTooltip();" onmouseover="showTooltip(event,'S-A-I represents the columns Snagged Jobs, Applied and Interviews. Managing the ratios of these three columns will help determine how you are doing. Ideally you should have twice as many job cards in Snagged Jobs as you have in the Applied column and 5% of those in the Interview column.');"><h4>S-A-I</h4><span class="text"><?php echo $card_SAI_status['O'].'-'.$card_SAI_status['A'].'-'.$card_SAI_status['I'];?></span></li>
<li class="third" onmouseout="hideTooltip();" onmouseover="showTooltip(event,'The intensity score is the percentage of challenges completed for the present week. The more challenges you complete, the higher your score. Challenges are coming soon!');"><h4>INTENSITY SCORE</h4><div class="meter_box"><figure class="img_m"><?php echo $this->Html->image('meter_big_bg1.png',array('escape'=>false));?></figure><strong class="speed strat_speed_intensity">0%</strong></div></li>

</ul>
</section>

<section class="tabing_container" style="margin-top:30px;">
        <section class="tabing">
          <ul class="tab">
            <li id="rep_activity_li" class=""><a href="javascript://" onclick="reports_job_activity();">Job Search Activity</a></li>
            <li id="rep_history_li" class="active last"><a href="javascript://" onclick="reports_job_history();">Job Search History</a></li>
            
          </ul>
        </section>
       
         <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
        <section class="top_sec" style="min-height:300px;">
              
        </section>
     
        <section class="contact_section">
        
      	 </section>
        
      </section>


  
</section>

<script type="text/javascript">

var chart;
    
    $(document).ready(function () {
    	reports_job_history();
		get_strategy_score();
		get_intensity_meter();
		//get_strategy_meter();
    	// Build the chart
        chart = new Highcharts.Chart({
			legend: {
						width:180,  maxHeight: 500,
						 itemStyle: {
							paddingBottom: '7px'
							},

						itemWidth: 180,verticalAlign: 'bottom',
							x: 5,
							y: -22,
							borderColor: '#fff',
							labelFormatter: function() {
              					  return this.name;
           					 }
					},
            chart: {
                renderTo: 'container',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
				align: 'left',
				backgroundColor: ''
				
            },
            title:false,
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true,
					center: [82, 81],
					size: 157
                }
            },
			credits:{
					enabled: false
				},
			
            series: [{
                type: 'pie',
                name: 'Average',
                data: [
					<?php	$last=count($data); 
							$m=1;
							
						foreach($data as $dat){
							if($m==$last){ 
								echo "['".$dat['name']."',".$dat['value']."]";
							}else{
								echo "['".$dat['name']."',".$dat['value']."],";
								}
								$m++;
					 } ?>
                   
                ]
            }]
        });
    });
	
function get_strategy_score()
{
	$.post('<?php echo SITE_URL;?>/reports/getStScore/<?php echo $clientid; ?>','',function(data){
			var res=data.split('|');
			$('.strat_speed_report').html(res[0]+'%');
			//alert(res[0]);
			$('.img_m').html("<img src='/img/meter_big_bg"+res[1]+".png'>");
			//$('.big_meter').html();
		});	
}	

function reports_job_history()
{
	$('#rep_activity_li').removeClass('active');
	$('#rep_history_li').addClass('active');
	var clientid=$('#clientid').val();
	$.post('<?php echo SITE_URL;?>/reports/job_search_history',{clientid:clientid},function(data){
			$('.top_sec').html(data);
		});	
}

function reports_job_activity()
{
	$('#rep_history_li').removeClass('active');
	$('#rep_activity_li').addClass('active');
	
	var clientid=$('#clientid').val();
	$.post('<?php echo SITE_URL;?>/reports/job_search_activity',{clientid:clientid},function(data){
			$('.top_sec').html(data);
		});	
}

function get_intensity_meter()
{
	$.post('<?php echo SITE_URL;?>/challenges/getItScore','',function(data){
			var res=data.split('|');
			$('.strat_speed_intensity').html(res[0]+'%');
			$('.img_m').html("<img src='<?php echo SITE_URL;?>/img/meter_big_bg"+res[1]+".png'>");			
		});	
}

</script>