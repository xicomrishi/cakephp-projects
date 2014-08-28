
<div class="users index">
	<h2>
		<?php echo __('Marketing Schedule Email'); ?>
	</h2>
	<p class="top15 gray12">
		<?php echo $this->Session->flash(); ?>
	</p>
	<div class="row mtop15">
		<table width="100%" cellspacing="0" cellpadding="0" border="0"
			align="center">
			<tr valign="top">
				<td align="left" class="searchbox">
					<div class="floatleft">
						<?php echo $this->Form->create('User',array('action'=>'manage','id'=>'CustomerAddForm','inputDefaults'=>array('label'=>false,'div'=>false)));?>
						<table cellspacing="0" cellpadding="4" border="0">
							<tr valign="top">
								<td valign="middle" align="left">
									<?php echo $this->Form->input('subject',array('id'=>'MetaInfoKeyword','class'=>'input','placeholder'=>"Enter Subject",'style'=>'width: 200px;'));?>
								</td>
								<td valign="middle" align="left">
									<?php echo $this->Form->input('date',array('id'=>'MetaInfoKeyword','class'=>'input','placeholder'=>"Enter Send Date",'style'=>'width: 200px;'));?>
								</td>
								<td valign="middle" align="left">
									<div class="black_btn2">
										<span class="upper"> <?php echo $this->Form->submit('Search User',array('name'=>'SearchUser' ,'value'=>'Search User'));?>
										</span>
									</div>
								</td>
							</tr>
						</table>
						<?php echo $this->Form->end();?>

					<div class="floatright top5">
						<?php //echo $this->Html->link('<span>'.__('Add New Email Template').'</span>', array('controller' => 'emails','action' => 'add'),array('class'=>'black_btn','escape'=>false));?>
					</div>

				</td>
			</tr>
		</table>
	</div>



	<div class="row mtop30">

		<?php 
		if ( count($marketing_email_history) )
		{

	echo $this->Form->create('User', array( 'url' => array('controller'=>'emails','action'=>'marketing_schedule_email','admin' => true)) ); ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0"
			align="center" class="listing">
			<tr>	
				<th width="20%" align="left" nowrap="nowrap"><?php echo $this->Paginator->sort('subject'); ?></th>
				<th width="20%" align="left" nowrap="nowrap"><?php echo $this->Paginator->sort('from_email'); ?>  </th>
				<th width="20%" align="left" nowrap="nowrap"><?php echo $this->Paginator->sort('from_name'); ?>  </th>
				<th width="15%" align="left" nowrap="nowrap"><?php echo $this->Paginator->sort('schedule_date', 'Schedule Date'); ?></th>
				<th width="15%" align="left" nowrap="nowrap"><?php echo $this->Paginator->sort('schedule_time', 'Schedule Time'); ?></th>
				<th width="6%" align="center">Actions</th>
				<th width="5%" align="center"><input type="checkbox" onclick="checkall(this.form)" value="check_all" id="check_all" name="check_all"></th>
			</tr>
			<?php 
				$foremailtext = Configure::read('ARR_EMAIL_TEMPLATE_IDENTIFIER');						
				$i=1;
				$bgClass="";				
				foreach($marketing_email_history as $row)
				{						
					$row = $row['AdminClientMarketingEmail'];					
				
					if($i%2==0)
						$bgClass = "oddRow";
					else
						$bgClass = "evenRow";			
					
			?>
			<tr class="<?php $bgClass?>">	
				<?php //for($i = 0;$i<=23;$i++) { $time[$i] = $i.':00'; } ?>
				<td align="left"><?php echo $row['subject']?></td>
				<td align="left"><?php echo $row['from_email'];?></td>
				<td align="left"><?php echo $row['from_name'];?></td>
				<td align="left"><?php echo $row['schedule_date']; ?></td>
				<td align="left"><?php echo $row['schedule_time'].' '.$row['schedule_time_type']; ?></td>
				<td align="center" valign="middle" >
					<?php echo $this->Html->link($this->Html->image('/admin/images/edit_icon.gif'), array('controller' => 'emails', 'action' => 'marketing_schedule_edit_email', $row['id']), array('escape' => false, 'title' => 'Edit Email')); ?>
					<?php echo $this->Html->link($this->Html->image('/admin/images/schedule.png'), array('controller' => 'emails', 'action' => 'marketing_schedule_change', $row['id']), array('escape' => false, 'title' => 'Edit schedule time')); ?>
				</td>
				<td valign="middle" align="center">
				<input type="checkbox" value="<?php echo $row['id']; ?>" name="ids[]">
			</td>	
			</tr> 
		<?php
				$i++; 
			}
			
			?>
				<tr align="right">
					<td colspan="7" align="left" class="bordernone">
						<div class="floatleft mtop7">
							<div class="pagination">							
								<?php echo $this->Paginator->prev(); ?>
								<?php echo $this->Paginator->numbers(); ?>
								<?php echo $this->Paginator->next(); ?>	
							</div>
						</div>
						
						<div class="floatright">
							<div class="floatleft">
								<select name="option"  class="select">
									<option value="">Select Option</option>
									<option value="delete">Delete</option>												
								</select>
							</div>							 
							<div class="floatleft mleft10">
								<div class="black_btn2">
									<span class="upper">
										<input type="submit" value="SUBMIT" name="">
									</span>
								</div>
							</div>
					   </div>             
					</td>
				</tr>
		</table>

		<?php
		echo $this->Form->end();
		}
		else
		{
			echo __('<center>No record found</center>');
		}
		?>

	</div>


</div>

<?php
echo $this->Js->writeBuffer();
?>
