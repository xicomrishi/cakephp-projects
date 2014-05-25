
              <form id="cmsForm" name="cmsForm" action="" method="post" class="form">
                <table class="table">
                  <thead>
                  <tr>
                    <th class="first"><?php echo __('S.No.'); ?></th>               
                    <th><?php echo __('Company'); ?></th>
                    <?php if($num=='1'){ ?>
                    <th><?php echo __('Date Modified'); ?></th>
                    <th><?php echo __('Hints'); ?></th>
                    <?php } ?>
                    <th><?php echo __('Action'); ?></th>                                 	
                  </tr>
                  </thead>
                  <tbody>
                 
                  <?php 
				 
				$i=1;
				  foreach($data as $dat){  ?>
                  <tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>" id="data_<?php echo $i; ?>">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $dat['Company']['company']; ?></td>
                    <?php if($num=='1'){ ?>
                        <td><?php echo show_formatted_date($dat['BenchmarkComp']['date_modified']); ?></td>
                        <td><?php echo $dat['BenchmarkComp']['last_update']; ?></td>
                        <td><a href="javascript://" onclick="show_comp_data('<?php echo $dat['BenchmarkComp']['id']; ?>');">Manage</a></td>
                    <?php }else if($num=='2'){ ?>
                    	<td><a href="javascript://" onclick="show_systemComp_data('<?php echo $dat['Company']['id']; ?>');">View</a></td>
                    <?php }else{ ?>
                    	<td><a href="javascript://" onclick="show_aggregateComp_data('<?php echo $dat['Company']['id']; ?>');">View</a></td>
                    <?php } ?>
                    
                  </tr>
                  <?php $i++; } ?>
                  
                </tbody>
                </table>
                
              </form>
    