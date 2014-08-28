<?php
	//echo $this->Html->script(array('/admin/js/jquery-ui.js'), array('inline' => false));
	echo $this->Html->css(array('/admin/css/jquery-ui'));
	echo $this->Html->script(array( '/admin/js/jquery-ui'));		
?>
<script>
$(document).ready(function (){		
		
		$('.toolTip').tooltip({		
			track : true
		});
});
</script>
<h1>
	Deals Report
	<?php 
		echo $this->html->image('help.png', array(													
								'class' => 'help toolTip', 
								'title'=>'You can see the users detail here like user first name, last name their email ids who had shared the deal.'
							)
						);
?>
</h1>
<div class="row mtop15">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr valign="top">
		  <td align="left" class="searchbox">	
			<div class="floatleft">
				<?php echo $this->Form->create(array('url' => '/admin/users/deal_report_client', 'type' => 'get'));  ?>
					  <table cellspacing="0" cellpadding="4" border="0">
					  <tr valign="top">
						  <td valign="middle" align="left" >
							  <input type="text" class="input" value="<?php if(isset($_GET['search_keyword'])) echo $_GET['search_keyword'] ?>" placeholder="Enter Keyword" style="width:300px;" name="search_keyword">
						  </td>
						  <td valign="middle" align="left" ><select class="select" name="filter" style="width:300px;">
							  <option value="title">By Deal Title</option>
							</select></td>
						  <td valign="middle" align="left">
							  <div class="black_btn2">
								  <span class="upper"><input type="submit" value="Search Deal" name=""></span>
							  </div>
						  </td>
						</tr>
					</table>
				</form>
			</div>		
			<div class="floatright top5">
				<?php //echo $this->Html->link('<span>Manage Deals</span>', array('controller' => 'users', 'action' => 'deal_report', 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false)); ?>
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
				<th width="38%" align="left"><?php echo $this->Paginator->sort('title'); ?></th>
				
				<th width="38%" align="left"><?php echo $this->Paginator->sort('total_friend_view', 'Total Deals', array('title' => 'This feild shows the total friends and followers for the users who have shared this deal')); ?></th>
				<th width="38%" align="left"><?php echo $this->Paginator->sort('share', 'Total Share', array('title' => 'The total number of times this deal was shared')); ?></th>
				
				<th width="30%" align="left"> Actions </th>
		  </tr>
		  <?php if(!empty($records)) { $i=1; ?>
			  <?php	 foreach($records as $record) { ?>
				 <tr>
					<td align="center"><?php echo  $i; $i++;?></td>
					<td align="left">
						<span class="blue">
							<?php echo $record['AdminClientDeal']['title']; ?>
						</span>
					</td>
					
					<td align="left">
						<span class="blue">
							<?php echo !empty($record['AdminClientDeal']['total_friend_view'])?$record['AdminClientDeal']['total_friend_view']:0; ?>
						</span>
					</td>
					<td align="left">
						<span class="blue">
							<?php echo !empty($record['AdminClientDeal']['share'])?$record['AdminClientDeal']['share']:0; ?>
						</span>
					</td>
					
					<td align="left">
						<?php echo $this->Html->link($this->Html->image('/admin/images/view.gif'), array('controller' => 'users', 'action' => 'deal_report_client_view', $record['AdminClientDeal']['id']), array('escape' => false, 'title' => 'View report')); ?>
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
