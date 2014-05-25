<input type="hidden" id="client_id" value="<?php echo $clientid; ?>"/>
<section class="search_histry">
<p>Job Search Report</p>
<p>Client:&nbsp;<span class="user"><?php echo $username; ?></span></p>
<p></p>
</section>
<section class="search_histry">
<div class="error"></div>
	<div class="search_row">
    <p style="float:left; margin:3px 10px 0 0">Select Range:</p>
    		<label for="from">From</label>
                <input type="text" id="from" name="from" class="input"/>
                <label for="to">to</label>
                <input type="text" id="to" name="to" class="input"/>
                <input type="submit" onclick="check_date_range()" value="Search" class="search"/>
               <div id="pdf_link"> <a href="<?php echo SITE_URL;?>/reports/view/<?php echo $clientid;?>/f:/t:" target="_blank">Save PDF</a></div>
    
    </div>
    
    <div class="display_job_hist">
    <table>
    <tr style=" border-bottom:1px solid #ccc">
    <th width="105">Applied Date</th>
    <th width="120">Job</th>
    <th width="125">Company Name</th>
    <th width="125">Contact Person</th>
    <th width="175">Opportunity</th>
    <th width="100">Job Type</th>
    <th width="125">Job Card Column</th></tr>
    <?php foreach($cards as $card){ 
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
        
    	
    <?php }} ?>
    </table>
    </div>
</section>

<script type="text/javascript">

		$( "#from" ).datepicker({
			
			changeMonth: true,
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			minDate:'<?php echo $client['Client']['reg_date'];?>',
			onSelect: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
				var to_date=$('#to').val();
				$('#pdf_link').html('<a href="<?php echo SITE_URL;?>/reports/view/<?php echo $clientid;?>/f:'+selectedDate+'/t:'+to_date+'" target="_blank">Save PDF</a>');
			}
		});
		$( "#to" ).datepicker({
			
			changeMonth: true,
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			minDate:'<?php echo $client['Client']['reg_date'];?>',
			onSelect: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
				var from_date=$('#from').val();
				$('#pdf_link').html('<a href="<?php echo SITE_URL;?>/reports/view/<?php echo $clientid;?>/f:'+from_date+'/t:'+selectedDate+'" target="_blank">Save PDF</a>');
			}
		});
		
function check_date_range()
{
	var from=$('#from').val();
	var to=$('#to').val();
	$('#pdf_link').html('<a href="<?php echo SITE_URL;?>/reports/view/<?php echo $clientid;?>/f:'+from+'/t:'+to+'" target="_blank">Save PDF</a>');
	
			var clientid=$('#client_id').val();
			//alert(to);
			$.post('<?php echo SITE_URL;?>/reports/job_history_for_date',{from:from,to_date:to,clientid:clientid},function(data){
				
				$('.display_job_hist').html(data);
			});
			
			
}	

	
</script>