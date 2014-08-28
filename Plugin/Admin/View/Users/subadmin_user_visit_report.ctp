 <h1>Users Visits Report</h1>

    

<div class="row mtop30">

	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
		  <tr>
			
			
			<th width="10%" align="left"><?php echo 'Total Visits'; ?></th>
			<th width="10%" align="left"><?php echo  'Facebook Visits'; ?></th>
			<th width="10%" align="left"><?php echo  'Twitter Visits'; ?></th>
			<th width="10%" align="left"><?php echo  'Other Visits'; ?></th>
	  </tr>
	  
	  <?php if(!empty($user)){
	  	
		foreach($user as $us){ ?>
	 
		 <tr>
			
			<td align="left"><?php echo $us['Admin']['total_visit']; ?></td>	
			<td align="left"><?php echo $us['Admin']['facebook_visit']; ?></td>	
			<td align="left"><?php echo $us['Admin']['twitter_visit']; ?></td>
			<td align="left"><?php echo $us['Admin']['other_visit']; ?></td>			
		  </tr>
	<?php }} ?>
		
	</table>

</div>
