<div class="home full-width">
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(initChart);

function initChart(){
	drawChart();
}


function drawChart() {

     var data1 = google.visualization.arrayToDataTable([
          ['Month', 'Mobile', 'Data Card','DTH'],
          ['AUG 13',  1000, 400,    600],
          ['SEP 13',  2000, 900,    300],
          ['OCT 13',  4000, 1000,   1000],
          ['NOV 13',  6000, 5000,   8000],
          ['DEC 13',  5000, 3000,   3000],
          ['JAN 14',  9000, 8000,   5000]
        ]);

        var options1 = {
          title: 'Last six month\'s recharges in Rs.',
          hAxis: {title: 'Month', titleTextStyle: {color: 'red'}}
        };        
        var chart1 = new google.visualization.ColumnChart(document.getElementById('bar_chart_recharge'));
        chart1.draw(data1, options1);



        
        var data2 = google.visualization.arrayToDataTable([
				['Month', 'Users', 'Transactions'],
				['AUG 13',  100, 400],
				['SEP 13',  200, 900],
				['OCT 13',  400, 1000],
				['NOV 13',  600, 5000],
				['DEC 13',  500, 4000],
				['JAN 14',  900, 3000]
				]);
				
		var options2 = {
		title: 'Users(Number) & Transactions(Rs)',
		hAxis: {title: 'Month', titleTextStyle: {color: 'red'}}
		};
		
		var chart2 = new google.visualization.ColumnChart(document.getElementById('bar_chart_users'));
		chart2.draw(data2, options2);  


		/*-- line chart--*/

		    var data3 = google.visualization.arrayToDataTable([
	          ['Month', 'Airtel', 'Vodafone','Relience','Aircel','MTS','Idea'],
	          ['AUG 13',  400, 1000, 200, 400, 900, 1100],
			  ['SEP 13',  500, 900, 400, 500, 100, 300],
			  ['OCT 13',  1000, 900, 300, 400, 700, 700],
			  ['NOV 13',  900, 800, 900, 300, 800, 2000],
			  ['DEC 13',  1000, 1500, 500, 1000, 1800, 3000],
			  ['JAN 14',  900, 1800, 800, 2000, 1500, 3000]
	        ]);

	        var options3 = {
	          title: 'Recharges'
	        };

	        var chart3 = new google.visualization.LineChart(document.getElementById('line_chart_operators'));
	        chart3.draw(data3, options3);
	     
        /*-- /line chart--*/                                         	                                                                                                
                                        
 }
</script>
 
<div class="row"> 
 	<div class="left_sec">  
	<h3>Last five recent transactions</h3>
	 <table cellspacing="0" cellpadding="0" style="margin-top:25px">
	 <tr>
    	<th><?php echo $this->Paginator->sort('Recharge.transaction_id','Trans.Id');?></th>
       	<th><?php echo $this->Paginator->sort('Customer.name','Name');?></th>
       	<th><?php echo $this->Paginator->sort('Recharge.recharge_type','Recharge Type');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.number','Number');?></th>
        <th><?php echo $this->Paginator->sort('Operator.name','Operator Name');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.amount','Amount');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.date','Recharge Date');?></th>
        <th><?php echo $this->Paginator->sort('Recharge.record_status','Trans. Status');?></th>
    </tr>

		<?php if($Recharges){?>
	  
		<?php
		$i = 0;
		foreach ($Recharges as $recharge){
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		  
		?>
		<tr <?php echo $class;?>>
			<td><?php if($recharge['Recharge']['transaction_id']){echo $recharge['Recharge']['transaction_id'];}else{echo "N/A";} ?></td>
	        <td><?php echo $recharge['Customer']['name'];?></td>
	        <td><?php echo $recharge['RechargeType']['recharge_type'];  ?></td>
	        <td><?php echo $recharge['Recharge']['number']; ?></td>
	        <td><?php echo $recharge['Operator']['name']; ?></td>
	        <td><?php echo $recharge['Recharge']['amount']; ?></td>
	        <td><?php echo $recharge['Recharge']['payment_date']; ?></td>
	        <td><?php echo $recharge['Recharge']['record_status']; ?></td>
	    </tr>
	 	<?php }
	  }?>   
  
  	
	</table>
		<div style='text-align:right'>
			<?php echo $this->Html->link(__('View All'), array('controller' => 'recharges','action' => 'index')); ?>
		</div>
	</div> 
	 <div class="right_sec"> 
	 	<div id="line_chart_operators" style="height: 400px;"></div>
	 </div>
 </div>
    
 
<div class="row">  
	<div class="left_sec">	 
	   <div id="bar_chart_recharge" style="height: 400px;"></div>  
	</div>
	 
	<div class="right_sec"> 
	    <div id="bar_chart_users" style="height: 400px;"></div>
	</div>
</div>
</div>
