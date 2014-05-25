<?php if(!empty($notes)) { 
	foreach($notes as $note){
	?>
<p>wrote on <?php echo show_formatted_date($note['Note']['date_added']);?></p>    
<p class="border"><?php echo $note['Note']['note'];?></p>

<?php }}else{ echo 'No note found';} ?>