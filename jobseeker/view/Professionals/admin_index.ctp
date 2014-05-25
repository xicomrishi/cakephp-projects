

<div class="prof index">
	<h2><?php echo __('Professionals');?></h2>
    
    <form action="<?php echo $this->webroot;?>admin/professionals" name="adminSearchProfessionalForm" method="get" id="adminSearchProfessionalForm">
   <div class="inputs">
  <div class="input_row search">
    <input type="text" name="admin_search_prof" class="admin_search_prof" value="Search for professionals by name, company, current location" onblur="if(this.value=='')this.value='Search for professionals by name, company, current location'" onfocus="if(this.value=='Search for professionals by name, company, current location')this.value=''" style="width:50%">
   <div class="submit"><input type="submit" value="Search"></div>              
   
  </div>
   </div>

<a style="float:right; padding-top:12px;" href="<?php echo $this->webroot;?>admin/professionals">View All</a>
</form> 
	<?php if(isset($Professionals)){?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Professional.first_name');?></th>
			<th><?php echo $this->Paginator->sort('Professional.last_name');?></th>
			<th><?php echo $this->Paginator->sort('Professional.email');?></th>
			<th><?php echo $this->Paginator->sort('Professional.status');?></th>
			<th><?php echo $this->Paginator->sort('Professional.last_login_ip');?></th>
			<th><?php echo $this->Paginator->sort('Professional.last_login_date');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	
	$i = 0;
	foreach ($Professionals as $prof):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $prof['Professional']['first_name']; ?></td>
		<td><?php echo $prof['Professional']['last_name']; ?></td>
		<td><?php echo $prof['Professional']['email']; ?></td>
		<td><?php echo $prof['Professional']['status']; ?></td>
		<td><?php echo $prof['Professional']['last_login_ip']; ?></td>
		<td><?php echo $prof['Professional']['last_login_date']; ?></td>
		<td class="actions">
       	<a href="javascript://" id="status_anch_<?php echo $prof['Professional']['id']; ?>" onclick="change_status('<?php echo $prof['Professional']['status']; ?>','<?php echo $prof['Professional']['id']; ?>');"><?php if($prof['Professional']['status']=='0') echo 'Activate'; else echo 'Deactivate'; ?></a>
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $prof['Professional']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $prof['Professional']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $prof['Professional']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers(); ?>
 	 |	<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	<?php }else{?>
	<div class="record_not_found error">Records not found.</div>
	<?php }?>
</div>

<script type="text/javascript">

function change_status(val,id)
{
	var status=1; var text='Deactivate';
	if(val==1)
	{	var status=0;
		text='Activate';
	}
	$.post('<?php echo $this->webroot; ?>professionals/change_status',{status:status,id:id},function(data){
		$('#status_anch_'+id).attr('onclick','change_status("'+status+'","'+id+'");');
		$('#status_anch_'+id).html(text);	
	});
}

</script>
