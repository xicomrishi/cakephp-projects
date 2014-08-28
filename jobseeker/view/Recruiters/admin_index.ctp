<!--<div class="actions">
	<ul>
		<li>Recruiters</li>
	</ul>
</div>-->
<style>
 img{cursor:pointer}
</style>
<div class="prof index">
	<h2><?php echo __('Recruiters');?></h2>
    
 <form action="<?php echo $this->webroot;?>admin/recruiters" name="adminSearchRecruiterForm" method="get" id="adminSearchRecruiterForm">
   <div class="inputs">
  <div class="input_row search">
    <input type="text" name="admin_search_prof" class="admin_search_prof" value="Search for rercuiters by name, company, current location" onblur="if(this.value=='')this.value='Search for rercuiters by name, company, current location'" onfocus="if(this.value=='Search for rercuiters by name, company, current location')this.value=''" style="width:50%">
   <div class="submit"><input type="submit" value="Search"></div>              
   
  </div>
   </div>

<a style="float:right; padding-top:12px;" href="<?php echo $this->webroot;?>admin/recruiters">View All</a>
</form> 


</div>  
	<?php if(isset($Recruiters)){?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Recruiter.first_name');?></th>
			<th><?php echo $this->Paginator->sort('Recruiter.last_name');?></th>
			<th><?php echo $this->Paginator->sort('Recruiter.email');?></th>
            <th><?php echo $this->Paginator->sort('Recruiter.current_company');?></th>
			<th><?php echo $this->Paginator->sort('Recruiter.current_role');?></th>
			<th><?php echo $this->Paginator->sort('Recruiter.last_login_ip');?></th>
			<th><?php echo $this->Paginator->sort('Recruiter.last_login_date');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	
	$i = 0;
	foreach ($Recruiters as $recruit):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $recruit['Recruiter']['first_name']; ?></td>
		<td><?php echo $recruit['Recruiter']['last_name']; ?></td>
		<td><?php echo $recruit['Recruiter']['email']; ?></td>
        <td><?php echo $recruit['Recruiter']['current_company']; ?></td>
		<td><?php echo $recruit['Recruiter']['current_role']; ?></td>
		<td><?php echo $recruit['Recruiter']['last_login_ip']; ?></td>
		<td><?php echo $recruit['Recruiter']['last_login_date']; ?></td>
		<td class="actions">
<!--        	<a href="javascript://" id="status_anch_<?php echo $recruit['Recruiter']['id']; ?>" onclick="change_status('<?php echo $recruit['Recruiter']['status']; ?>','<?php echo $recruit['Recruiter']['id']; ?>');"><?php if($recruit['Recruiter']['status']=='0') echo 'Activate'; else echo 'Deactivate'; ?></a>
-->
        	<img src="<?php echo $this->webroot; ?>images/setting.png" title="Account Setting" onclick="action_perform('account_setting',<?=$recruit['Recruiter']['id']?>)"/>
        	<img src="<?php echo $this->webroot; ?>img/view.png" title="Account View" onclick="action_perform('view',<?=$recruit['Recruiter']['id']?>)"/>
        	<img src="<?php echo $this->webroot; ?>images/delete_user.png" title="Account Delete" onclick="action_perform('delete',<?=$recruit['Recruiter']['id']?>)"/>
			<?php // echo $this->Html->link(__('View', true), array('action' => 'view', $recruit['Recruiter']['id'])); ?>
			<?php // echo $this->Html->link(__('Delete', true), array('action' => 'delete', $recruit['Recruiter']['id']),null, sprintf(__('Are you sure you want to delete # %s?', true), $recruit['Recruiter']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 	 |	<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	<?php }else{?>
	<div class="record_not_found error">Records not found.</div>
	<?php }?>
</div>
<form id="form" action="" method="post"></form>
<script type="text/javascript">

function change_status(val,id)
{
	var status=1; var text='Deactivate';
	if(val==1)
	{	var status=0;
		text='Activate';
	}
	$.post('<?php echo $this->webroot; ?>recruiters/change_status',{status:status,id:id},function(data){
		$('#status_anch_'+id).attr('onclick','change_status("'+status+'","'+id+'");');
		$('#status_anch_'+id).html(text);	
	});
}

 function action_perform(actionName,id)
  {
	  var path = "<?php echo $this->webroot;?>admin/recruiters/"+actionName+"/"+id;
	  if(actionName === 'delete')   {
		  if(!confirm('Are you sure you want to delete the record',false))
		    return false;
	  } 
	  $("#form").attr('action',path).submit(); 
  }

</script>
