<?php
$this->Paginator->options(array (
		'update' => '#main-container',
		'evalScripts' => true,
		'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array ('buffer' => true)),
		'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array ('buffer' => true)),
));
?>
<div class="users index">
	<h2>
		<?php echo __('Manage Email Templates '); ?>
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
						<!------<?php echo $this->Form->create('User',array('action'=>'manage','id'=>'CustomerAddForm','inputDefaults'=>array('label'=>false,'div'=>false)));?>
						<table cellspacing="0" cellpadding="4" border="0">
							<tr valign="top">
								<td valign="middle" align="left"><?php echo $this->Form->input('searchkey',array('id'=>'MetaInfoKeyword','class'=>'input','placeholder'=>"Keywords",'style'=>'width: 200px;'));?>
								</td>

								<td valign="middle" align="left">
									<div class="black_btn2">
										<span class="upper"> <?php echo $this->Form->submit('Search User',array('name'=>'SearchUser' ,'value'=>'Search User'));?>
										</span>
									</div>
								</td>
							</tr>
						</table>
						<?php echo $this->Form->end();?> ----->
					</div>

					<div class="floatright top5">
						<?php echo $this->Html->link('<span>'.__('Add New Email Template').'</span>', array('controller' => 'emails','action' => 'add'),array('class'=>'black_btn','escape'=>false));?>
					</div>

				</td>
			</tr>
		</table>
	</div>



	<div class="row mtop30">

		<?php 
		if ( count($templates) )
		{

	echo $this->Form->create('User', array( 'url' => array('controller'=>'emails','action'=>'manage','admin' => true)) ); ?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0"
			align="center" class="listing">
			<tr>				
				<th width="20%" align="left" nowrap="nowrap">Name</th>
				<th width="20%" align="left" nowrap="nowrap"><?php echo $this->Paginator->sort('subject'); ?></th>
				<th width="20%" align="left" nowrap="nowrap"><?php echo $this->Paginator->sort('from_email'); ?>  </th>
				<th width="20%" align="left" nowrap="nowrap"><?php echo $this->Paginator->sort('from_name'); ?>  </th>
				<th width="15%" align="left" nowrap="nowrap"><?php echo $this->Paginator->sort('modified'); ?></th>
				<th width="6%" align="center">Details</th>
				<th width="5%" align="center"><input type="checkbox" onclick="checkall(this.form)" value="check_all" id="check_all" name="check_all"></th>
				
			</tr>
			<?php 
			$foremailtext = Configure::read('ARR_EMAIL_TEMPLATE_IDENTIFIER');						
			$i=1;
			$bgClass="";				
			foreach($templates as $row)
			{	
					
				$row = $row['EmailTemplate'];					
				//$page++;
				if($i%2==0)
					$bgClass = "oddRow";
				else
					$bgClass = "evenRow";
			
				$keyidentifier = $row['name']
		?>
			<tr class="<?php $bgClass?>">					
				
				<td align="left"><?php echo $keyidentifier?></td>
				<td align="left"><?php echo $row['subject']?></td>
				<td align="left"><?php echo $row['from_email'];?></td>
				<td align="left"><?php echo $row['from_name'];?></td>
				<td align="left"><?php echo $row['modified']; ?></td>
				
				<td align="center" valign="middle" >&nbsp;<?php echo $this->Html->link($this->Html->image('/admin/images/edit_icon.gif'), array('controller' => 'emails', 'action' => 'edit', $row['id']), array('escape' => false)); ?></td>
				<td valign="middle" align="center"><input type="checkbox" value="<?php echo $row['id']; ?>" name="ids[]"></td>
							
			</tr> 
		<?php
				$i++; 
			}
			
			?>
<tr align="right">
			<td colspan="7" align="left" class="bordernone">
			<div class="floatleft mtop7">
			<div class="pagination">
			
			<?php echo $this->Paginator->prev(); ?><?php echo $this->Paginator->numbers(); ?><?php echo $this->Paginator->next(); ?>			
			
			</div>
			</div>
			
			<div class="floatright">
				<div class="floatleft">
				<select name="option"  class="select">
					<option value="">Select Option</option>
					<option value="delete">Delete</option>
					<option value="active">Activate</option>
					<option value="deactive">Deactivate</option>					
				 </select>
			  </div>
				 
				 <div class="floatleft mleft10"><div class="black_btn2"><span class="upper"><input type="submit" value="SUBMIT" name=""></span></div></div>
			   </div>                 </td>
		  </tr>
		</table>

		<div class="row paging">
			<!----<div class="floatleft mtop7">
				<div class="pagination">
					<?php
					echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array('separator' => ''));
					echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
					?>
				</div>
			</div>
			<div class="floatright">
				<div class="floatleft">
					<select name="action_options" class="select" id="action_options">
						<option value="">Select Option</option>
						<option value="active">Acivate</option>
						 <option value="inactive">Inactivate</option>
						<option value="block">Block</option>
					</select>
				</div>
				<div class="floatleft mleft10">
					<div class="black_btn2">
						<span class="upper"> <input id='submit_actions' type="submit"
							value="SUBMIT" name="actions">
						</span>
					</div>
				</div>
			</div>
		</div>-->

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
