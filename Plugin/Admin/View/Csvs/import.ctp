<style>
.link_right{ float:right}	
.submit input { background: url("../images/buttons.png") no-repeat scroll right -64px rgba(0, 0, 0, 0);
    border-radius: 3px;
    color: #FFFFFF;
    display: block;
    font-size: 11px;
    font-weight: bold;
    height: 35px;
    margin-top: 10px;
    padding: 2px;
    text-align: center;
    text-shadow: 0 -1px #193356;
    text-transform: uppercase;
    vertical-align: middle;
    width: 87px;}	
</style>
<div class="imports form">
	<h1><?php echo __('Import Users'); ?></h1>
	<div class="link_right">
		<h3><a href="<?php echo $this->webroot.'files'.DS.'sample_import_file.csv'; ?>">Download Sample CSV Format</a></h3>
	</div>
	
	<div class="row mtop15">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr valign="top">
		  <td align="left" class="searchbox">			
			<div class="link_div">
	<?php echo $this->Form->create('Csv', array('enctype' => 'multipart/form-data'));?>
	<div class = "left">
		<?php 
			echo $this->Form->input(__('file_name'), array('between'=>'<br />','type'=>'file', 'label' => false),array('label' =>array('text'=>'File Name')));
		?>
	</div>
	<?php echo $this->Form->end(__('Submit'));?>
	</div>
		  </td>
	  </tr>
	</table>
</div>
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