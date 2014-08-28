<?php ?>

<h1>Client Contact Requests</h1>
<?php if($this->Session->read('Auth.User.id') == 1) { ?>
<div class="row mtop15">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr valign="top">
		  <td align="left" class="searchbox">			
			<div class="floatright top5">
				<?php //echo $this->Html->link('<span>Add New Deal</span>', array('controller' => 'users', 'action' => 'deal_add', $user_id, 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false));  ?>
				
					<?php echo $this->Html->link('<span>Manage users</span>', array('controller' => 'users', 'action' => 'index', 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false)); ?>
				
			</div>
		  </td>
	  </tr>
	</table>
</div>
<?php } ?>    

	<div class="row mtop30">
		<?php echo $this->Form->create(array('url' => '/admin/users/clien_appointments', 'type' => 'post'));  ?>
			<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
				  <tr>
					<th width="10%" align="left"><?php echo $this->Paginator->sort('id','ID'); ?></th>
					<th width="10%" align="left"><?php echo $this->Paginator->sort('name','Name'); ?></th>
					<th width="10%" align="left"><?php echo $this->Paginator->sort('email','Email'); ?></th>
					<th width="20%" align="left"><?php echo $this->Paginator->sort('subject','Subject'); ?></th>
					<th width="10%" align="left"><?php echo $this->Paginator->sort('message','Message'); ?></th>
					<th width="10%" align="left"><?php echo 'Response Status'; ?></th>
					<th width="5%" align="left"> Actions </th>
					
					<?php /* <th width="5%" align="center"><input type="checkbox" onclick="checkall(this.form)" value="check_all" id="check_all" name="check_all"></th> */?>
			  </tr>
			  <?php if(!empty($records)) { $i=1; ?>
				  <?php	 foreach($records as $record) { ?>
					 <tr>
						<td align="left"><?php //echo  $i; $i++; 
										echo $record['UserAppointment']['id'];  ?></td>
						<td align="left">
								<?php echo $record['UserAppointment']['name']; ?>
						</td>
						
						<td align="left">
								<?php echo $record['UserAppointment']['email']; ?>
						</td>
						<td align="left">
								<?php echo $record['UserAppointment']['subject']; ?>
						</td>
						<td align="left">
								<?php echo $record['UserAppointment']['message']; ?>
						</td>
						
						<td align="left">
								<?php if(empty($record['UserAppointment']['response_id'])) echo '-'; else echo 'Sent'; ?>
						</td>
						
						<td align="left">
							<?php echo $this->Html->link($this->Html->image('/admin/images/edit_icon.gif'), array('controller' => 'users', 'action' => 'client_contact_respond', $record['UserAppointment']['id']), array('escape' => false, 'title' => 'Respond to request')); ?>
				
							<?php echo $this->Html->link($this->Html->image('delete_icon.gif'), array('controller'=>'users', 'action'=>'client_appointment_delete', $record['UserAppointment']['id']), array('escape' => false, 'title' => 'Delete contact request'), "Are you sure you wish to delete the contact request?"); ?>
							
						</td>
						<?php /*
							<td valign="middle" align="center">
								<input type="checkbox" value="<?php echo $record['AdminClientDeal']['id']; ?>" name="ids[]">
							</td>
						*/?>
					  </tr>
				 <?php } ?>
				<tr align="right">
					<td colspan="10" align="left" class="bordernone">
						<div class="floatleft mtop7">
							<div class="pagination">
								<?php echo $this->Paginator->prev(); ?><?php echo $this->Paginator->numbers(); ?><?php echo $this->Paginator->next(); ?>
							</div>
						</div>
					
						</div>                 
					</td>
				</tr>
				<?php } else { ?>
					<tr>
						<td colspan="8">
							No record found
						</td>
					</tr>
				<?php } ?>
			</table>
		</form>
	</div>
