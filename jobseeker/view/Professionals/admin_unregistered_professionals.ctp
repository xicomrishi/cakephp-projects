

<div class="prof index">
	<h2><?php echo __('Unregistered Professionals');?></h2>
	 <form action="<?php echo $this->webroot;?>admin/professionals/unregistered_professionals" name="adminSearchUnregisteredProfessionalForm" method="get" id="adminSearchUnregisteredProfessionalForm">
   <div class="inputs">
  <div class="input_row search">
    <input type="text" name="admin_search_prof" class="admin_search_prof" value="Search for professionals by name, email" onblur="if(this.value=='')this.value='Search for professionals by name, email'" onfocus="if(this.value=='Search for professionals by name, email')this.value=''" style="width:50%">
   <div class="submit"><input type="submit" value="Search"></div>              
   
  </div>
   </div>

<a style="float:right; padding-top:12px;" href="<?php echo $this->webroot;?>admin/professionals/unregistered_professionals">View All</a>
</form> 
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th style="text-align:left"><?php echo $this->Paginator->sort('TempProfessional.first_name','First Name');?></th>
			<th style="text-align:left"><?php echo $this->Paginator->sort('TempProfessional.last_name','Last Name');?></th>
			<th style="text-align:left"><?php echo $this->Paginator->sort('TempProfessional.email','Email');?></th>
			<th style="text-align:left"><?php echo $this->Paginator->sort('TempProfessional.added_date','Added Date');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
    <?php if(isset($TempProfessional) && !empty($TempProfessional)){?>
	<?php
	
	$i = 0;
	foreach ($TempProfessional as $prof):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $prof['TempProfessional']['first_name']; ?></td>
		<td><?php echo $prof['TempProfessional']['last_name']; ?></td>
		<td><?php echo $prof['TempProfessional']['email']; ?></td>
		<td><?php echo $prof['TempProfessional']['added_date']; ?></td>
		<td class="actions">
		
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete_Unregister_professional', $prof['TempProfessional']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $prof['TempProfessional']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	
	
	
	<?php }else{?>
	<tr><td colspan="5"><div class="record_not_found error">Records not found.</div></td></tr>
	<?php }?>
    </table>
    <div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 	 |	<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
