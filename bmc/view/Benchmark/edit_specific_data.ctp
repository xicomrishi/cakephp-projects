
<div class="dataTabs invite">
<span  onclick="show_filter_data('<?php echo $comp_id; ?>',0,0)"><a href="javascript://">View</a></span>
<span class="current"><a href="javascript://">Edit</a></span>
<span onclick="show_filter_data('<?php echo $comp_id; ?>',2,0);"><a href="javascript://">Delete</a></span>
</div>
<div class="data_tables">
<form name="specDataForm" id="specDataForm" method="post" onsubmit="return save_bc_data();">
 <fieldset>
 <?php for($i=1;$i<7;$i++){ 
 			if(isset($data[$i-1])){ 
 
 ?>
 	
              	<div class="comn_row">
                <div class="title"><?php if($i==1) echo __('Planning'); else if($i==2) echo __('Organizing &amp; Staffing'); else if($i==3) echo __('Directing &amp; Leading'); else if($i==4) echo __('Controlling'); else if($i==5) echo __('Reporting'); else if($i==6) echo __('Risk Management'); ?></div>
                <input type="hidden" name="data[val][<?php echo $i; ?>][id]" value="<?php echo $data[$i-1]['BenchmarkData']['id']; ?>"/>
                <input type="hidden" name="comp_id" value="<?php echo $comp_id; ?>"/>
                <table width="50%">               
                	<thead>
                    	<th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>E</th>                       
                    </thead>
                    <tbody>                    	
                    	<tr>
                        	<td><input type="text" name="data[val][<?php echo $i; ?>][num_a]" value="<?php echo $data[$i-1]['BenchmarkData']['num_a']; ?>"/></td>
                            <td><input type="text"  name="data[val][<?php echo $i; ?>][num_b]" value="<?php echo $data[$i-1]['BenchmarkData']['num_b']; ?>"/></td>
                            <td><input type="text"  name="data[val][<?php echo $i; ?>][num_c]" value="<?php echo $data[$i-1]['BenchmarkData']['num_c']; ?>"/></td>
                            <td><input type="text"  name="data[val][<?php echo $i; ?>][num_d]" value="<?php echo $data[$i-1]['BenchmarkData']['num_d']; ?>"/></td>
                            <td><input type="text"  name="data[val][<?php echo $i; ?>][num_e]" value="<?php echo $data[$i-1]['BenchmarkData']['num_e']; ?>"/></td>                            
                        </tr>
                    </tbody>
                </table>
                </div>
                <?php }} ?>
                <?php if(!empty($data)){ ?>
                <div class="comn_row last"><input type="submit" value="Save"/></div> 
                <?php } ?>
                </fieldset>
            </form>    
      </div>