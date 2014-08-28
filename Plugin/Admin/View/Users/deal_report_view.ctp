<h1>Deals Report</h1>
<div class="row mtop15">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr valign="top">
		  <td align="left" class="searchbox">			
			<div class="floatright top5">
				<?php echo $this->Html->link('<span>Manage Deals</span>', array('controller' => 'users', 'action' => 'deal_report', 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false)); ?>
			</div>
		  </td>
	  </tr>
	</table>
</div>
    

	<div class="row mtop30">
		<?php echo $this->Form->create(array('url' => '/admin/users/deals', 'type' => 'post'));  ?>
			<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
			   <tr>
					<th width="4%" align="center">S No.</th>
					<th width="25%" align="left"><?php echo $this->Paginator->sort('User.email', 'User Email'); ?></th>
					<th width="15%" align="left"><?php echo $this->Paginator->sort('User.first_name', 'First Name'); ?></th>
					<th width="15%" align="left"><?php echo $this->Paginator->sort('User.last_name', 'Last Name'); ?></th>
					<th width="15%" align="left"><?php echo $this->Paginator->sort('AdminClientDealShare.created', 'Shared On'); ?></th>
					<th width="15%" align="left"><?php echo $this->Paginator->sort('AdminClientDealShare.share_type','Share type'); ?></th>
					<th width="15%" align="left"><?php echo $this->Paginator->sort('AdminClientDealShare.friend_count','Friend Count'); ?></th>
					
			  </tr>
			  <?php if(!empty($records)) { $i=1; ?>
				  <?php	 foreach($records as $record) { ?>
					 <tr>
						<td align="center"><?php echo  $i; $i++;?></td>
						<td align="left">
							<span class="blue">
								<?php echo $record['User']['email']; ?>
							</span>
						</td>
						<td align="left">
							<span class="blue">
								<?php echo $record['User']['first_name']; ?>
							</span>
						</td>
						<td align="left">
							<span class="blue">
								<?php echo $record['User']['last_name']; ?>
							</span>
						</td>
						<td align="left">
							<span class="blue">
								<?php echo $record['AdminClientDealShare']['created']; ?>
							</span>
						</td>
						<td align="left">
							<span class="blue">
								<?php echo ucfirst($record['AdminClientDealShare']['share_type']); ?>
							</span>
						</td>
						<td align="left">
							<span class="blue">
								<?php echo $record['AdminClientDealShare']['friend_count']; ?>
							</span>
						</td>
					  </tr>
				 <?php } ?>
				<tr align="right">
					<td colspan="7" align="left" class="bordernone">
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
						<td colspan="5">
							No record found
						</td>
					</tr>
				<?php } ?>
			</table>
		</form>
	</div>

