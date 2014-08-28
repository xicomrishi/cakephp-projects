<style>
.link_div{ font-size:15px;}
.link_div a{ text-decoration: underline;}
</style>
<h1>Import Gmail Contacts</h1>

<div class="row mtop15">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr valign="top">
		  <td align="left" class="searchbox">			
			<div class="link_div">
				<?php
				//if(isset($return) && $return) {
					echo $this->Html->link('Click here', $url);
					echo ' to import Yahoo contacts';
				//}
			?></div>
		  </td>
	  </tr>
	</table>
</div>

<?php 
		
		if(isset($imported_contacts) && !empty($imported_contacts)){	
 ?>
	
<div class="row mtop30">
	
			<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
				  <tr>
					<th width="4%" align="center">S No.</th>
					<th width="38%" align="left"><?php echo 'Name'; ?></th>
					<th width="30%" align="left"><?php echo  'Email'; ?></th>
					
				 </tr>
			  <?php if(!empty($imported_contacts)) { $i=1; ?>
				  <?php	 foreach($imported_contacts as $record) { ?>
					 <tr>
						<td align="center"><?php echo  $i; $i++;?></td>
						<td align="left">
							<span class="blue">
								<?php echo $record['first_name'].' '.$record['last_name']; ?>
							</span>
						</td>
						<td align="left">
							<?php echo $record['email']; ?>
						</td>
						
					  </tr>
					 					
					<?php } ?>
				
				<?php } else { ?>
					<tr>
						<td colspan="5">
							No contacts imported
						</td>
					</tr>
				<?php } ?>
			</table>
		
	</div>
<?php } ?>