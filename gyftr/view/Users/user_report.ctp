<?php echo $this->Html->script(array('highcharts'));?>
<div  class="basic_detail">
<div class="detail_row">
<strong>Name: </strong>
<span><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></span>
</div>
<div class="detail_row">
<strong>Email: </strong>
<span><?php echo $user['User']['email']; ?></span>
</div>
<div class="detail_row">
<strong>Total Points: </strong>
<span><?php echo $user['User']['points']; ?></span>
</div>
<div class="detail_row">
<strong>Total Gifts setup: </strong>
<span><?php echo $total; ?></span>
</div>

<div class="detail_row">
<strong>Total Gifts as Chip in: </strong>
<span><?php echo count($gpgift); ?></span>
</div>
<div class="detail_row">
<strong>Last Login Time: </strong>
<span><?php echo $lastlogin['Userlog']['login_time']; ?></span>
</div>
</div>

<div class="detail_row"><h3>Gifting Type</h3></div>

<div id="container" class="graph" style="width: 270px; height: 419px; float:left"></div>







<script type="text/javascript">

var chart;
$(document).ready(function(e) {
    
	 chart = new Highcharts.Chart({
			legend: {
						width:180,  maxHeight: 500,
						 itemStyle: {
							paddingBottom: '7px'
							},

						itemWidth: 180,verticalAlign: 'bottom',
							//x: 5,
							//y: -22,
							//borderColor: '#fff',
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
					//center: [82, 81],
					//size: 157
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
</script>