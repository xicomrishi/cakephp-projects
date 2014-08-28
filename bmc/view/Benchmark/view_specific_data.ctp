<style>
table.view_spec_table td{ background-color:#e8e8e8 !important; }
</style>
<?php if(!empty($data)){ ?>
<div class="dataTabs invite">
<span class="current"><a href="javascript://">View</a></span>
<span onclick="show_filter_data('<?php echo $comp_id; ?>',1,0);"><a href="javascript://">Edit</a></span>
<span onclick="show_filter_data('<?php echo $comp_id; ?>',2,0);"><a href="javascript://">Delete</a></span>
</div>
<?php } ?>
<div class="data_tables">
 <?php $p=0; for($i=1;$i<7;$i++){ 
 			if(isset($data[$i-1])){ $p++;
 
 ?>
 	
              	<div class="comn_row">
                <div class="title"><?php if($i==1) echo __('Planning'); else if($i==2) echo __('Organizing &amp; Staffing'); else if($i==3) echo __('Directing &amp; Leading'); else if($i==4) echo __('Controlling'); else if($i==5) echo __('Reporting'); else if($i==6) echo __('Risk Management'); ?></div>
                <table width="50%" class="view_spec_table">               
                	<thead>
                    	<th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>E</th>                       
                    </thead>
                    <tbody>                    	
                    	<tr>
                        	<td><?php echo $data[$i-1]['BenchmarkData']['num_a']; ?></td>
                            <td><?php echo $data[$i-1]['BenchmarkData']['num_b']; ?></td>
                            <td><?php echo $data[$i-1]['BenchmarkData']['num_c']; ?></td>
                            <td><?php echo $data[$i-1]['BenchmarkData']['num_d']; ?></td>
                            <td><?php echo $data[$i-1]['BenchmarkData']['num_e']; ?></td>                            
                        </tr>
                    </tbody>
                </table>
                </div>
                <?php }} ?>
             <?php if($p==0){ ?>
             <div style="text-align:center; height:100px; margin-top:50px;">No Data available for selected criteria.</div>
             <?php } ?>   
      </div>