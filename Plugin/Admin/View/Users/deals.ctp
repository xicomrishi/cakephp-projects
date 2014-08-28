<?php 	
	echo $this->Html->css(array('/js/fancybox/source/jquery.fancybox.css?v=2.1.5'));
	echo $this->Html->script(array('fancybox/source/jquery.fancybox.js?v=2.1.5'));		
?>
<script>
$(document).ready(function(){
		$('.fancybox').fancybox();
});
</script>
<h1>User Website Deals</h1>
<div class="row mtop15">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr valign="top">
		  <td align="left" class="searchbox">			
			<div class="floatright top5">
				<?php echo $this->Html->link('<span>Add New Deal</span>', array('controller' => 'users', 'action' => 'deal_add', $user_id, 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false));  ?>
				<?php if($this->Session->read('Auth.User.id') == 1) { ?>
					<?php echo $this->Html->link('<span>Manage users</span>', array('controller' => 'users', 'action' => 'index', 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false)); ?>
				<?php } ?>
				
			</div>
		  </td>
	  </tr>
	</table>
</div>
    

	<div class="row mtop30">
		<?php echo $this->Form->create(array('url' => '/admin/users/deals', 'type' => 'post'));  ?>
			<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
				  <tr>
					<th width="4%" align="center">ID.</th>
					<th width="38%" align="left"><?php echo $this->Paginator->sort('Title'); ?></th>
					<th width="30%" align="left"><?php echo  $this->Paginator->sort('Status'); ?></th>
					<th width="30%" align="left"> Actions </th>
					
					<!--<th width="5%" align="center"><input type="checkbox" onclick="checkall(this.form)" value="check_all" id="check_all" name="check_all"></th>
			  --></tr>
			  <?php if(!empty($records)) { $i=1; ?>
				  <?php	 foreach($records as $record) { ?>
					 <tr>
						<td align="center"><?php echo  $record['AdminClientDeal']['id']; $i++;?></td>
						<td align="left">
							<span class="blue">
								<?php echo $record['AdminClientDeal']['title']; ?>
							</span>
						</td>
						<td align="left">
							<?php echo $record['AdminClientDeal']['status']; ?>
						</td>
						<td align="left">
							<?php echo $this->Html->link($this->Html->image('/admin/images/edit_icon.gif'), array('controller' => 'users', 'action' => 'deal_edit', $record['AdminClientDeal']['id']), array('escape' => false, 'title' => 'Edit Deal')); ?>
							<?php echo $this->Html->link('View Message', '#inline'.$i , array('class'=>'fancybox', 'escape' => false)); ?>
							<?php echo $this->Html->link($this->Html->image('delete_icon.gif'), array('controller'=>'users', 'action'=>'deal_delete', $record['AdminClientDeal']['id']), array('escape' => false, 'title' => 'Delete Deal'), "Are you sure you wish to delete the Deal?"); ?>
						</td>
						<!--<td valign="middle" align="center">
							<input type="checkbox" value="<?php echo $record['AdminClientDeal']['id']; ?>" name="ids[]">
						</td>-->
					  </tr>
					  <?php
							$StatusMessage = new StatusMessage();
		
							$fb_message = $StatusMessage->fb_message($record['Admin'], $record['Admin'],$record);
							$tw_message = $StatusMessage->tw_message($record['Admin'], $record['Admin'], $record);
							$user_Data = array('first_name'=>'{FIRST_NAME}', 'last_name'=>'{LAST_NAME}');
							$fb_fanpage_message = $StatusMessage->fb_fanpage_message($user_Data, $record['Admin'], $record);
					  ?>
					  <div  style="width:800px;display: none;" id="inline<?php echo $i;?>" >
							<div class="wrap">				
								<div class="share-text">				
									<h3>What will be posted on user facebook wall?</h3>
									<p><?php if(!empty($record['AdminClientDeal']['fb_post_message'])) 
												echo $record['AdminClientDeal']['fb_post_message']; 
											 else 
												echo $fb_message;
										 ?>
									</p>
									<h3>What will be posted on user twitter wall?</h3>
									<p><?php 
											if(!empty($record['AdminClientDeal']['tw_post_message'])) 
												echo $record['AdminClientDeal']['tw_post_message']; 
											 else 
												echo $tw_message; 
										?></p>
									<h3>What will be posted on your Fan Page wall?</h3>
									<p><?php 
											if(!empty($record['AdminClientDeal']['fanpage_message'])) 
												echo $record['AdminClientDeal']['fanpage_message']; 
											 else 
												echo $fb_fanpage_message; 
										?></p>
								</div>
							</div>
						</div>
					<?php } ?>
				<tr align="right">
					<td colspan="7" align="left" class="bordernone">
						<div class="floatleft mtop7">
							<div class="pagination">
								<?php echo $this->Paginator->prev(); ?><?php echo $this->Paginator->numbers(); ?><?php echo $this->Paginator->next(); ?>
							</div>
						</div>
					<?php /*
						<div class="floatright">
							<div class="floatleft">
							<select name="option"  class="select">
								<option value="">Select Option</option>
								<option value="active">Active</option>
								<option value="active">In-Active</option>
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
						*/ ?>
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
	
<style>
.wrap{
	font-size:14px;
}
.share-text > p{
	padding : 5px 2px 10px 2px;
}
</style>
