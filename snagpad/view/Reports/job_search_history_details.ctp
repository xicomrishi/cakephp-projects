<table>
    <tr style=" border-bottom:1px solid #ccc">
    <th width="105">Applied Date</th>
    <th width="120">Job</th>
    <th width="125">Company Name</th>
    <th width="125">Contact Person</th>
    <th width="175">Opportunity</th>
    <th width="100">Job Type</th>
    <th width="125">Job Card Column</th></tr>
    <?php 
	if(!empty($cards)) {
	foreach($cards as $card){ 
		if(!empty($card['applied_date'])){ 
		?>
    	
    <tr>
    	<td width="105"><?php echo show_formatted_date($card['applied_date']['Cardchecklist']['date_added']);?></td>
        <td width="120"><?php echo $card['Card']['position_available'];?></td>
       <td width="125"><?php echo $card['Card']['company_name'];?></td>
        <td width="125"><?php if(!empty($card['contact'])) { 
									foreach($card['contact'] as $c){
										
										echo $c['Contact']['contact_name'].' ';
										}
								}else{ echo 'NA';} ?></td>
        <td  width="175"><?php if(!empty($card['Card']['type_of_opportunity'])){ echo $card['Card']['type_of_opportunity'];}else{ echo 'NA';} ?></td>
        <td  width="100"><?php  if(!empty($card['Card']['job_type_o'])){
									switch($card['Card']['job_type_o']){
									case '0': echo 'NA'; break;
									case 'NULL': echo 'NA'; break;
									case '1': echo 'Full Time'; break;
									case '2': echo 'Part-time'; break;
									case '3': echo 'Contract'; break;
									case '4': echo 'Temporary'; break;
			
						   }}else{ echo 'NA';}?></td>
         <td width="125"><?php switch($card['Card']['column_status']){
			 			case 'A': echo 'Applied'; break;
						case 'S': echo 'Set Interview'; break;
						case 'I': echo 'Interview'; break;
						case 'V': echo 'Verbal Job Offer'; break;
						case 'J': echo 'Job'; break;
			 		
			 
			 }?></td>
    </tr>    
        
    	
    <?php }}}else{ ?>  
    
    <tr><td>
   <?php  echo 'No Results Found for Date Range.'; ?>
    </td></tr>
    <?php  } ?>
    </table>