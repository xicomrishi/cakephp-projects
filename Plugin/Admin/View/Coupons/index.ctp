 <h1>Manage Coupons</h1>
<div class="row mtop15">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr valign="top">
		  <td align="left" class="searchbox">
						
			<div class="floatright top5">
			<?php echo $this->Html->link('<span>Create Coupon</span>', array('controller' => 'coupons', 'action' => 'add', 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false)); ?>
			</div>
		  </td>
	  </tr>
	</table>
</div>
    

<div class="row mtop30">
<?php echo $this->Form->create(array('url' => '/admin/coupons/index', 'type' => 'post'));  ?>
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
		  <tr>
			<th width="4%" align="left">ID.</th>
			<th width="15%" align="left"><?php echo $this->Paginator->sort('deal_id', 'Deal'); ?></th>
			<th width="15%" align="left"><?php echo $this->Paginator->sort('image', 'Image'); ?></th>
			<th width="10%" align="left"><?php echo  $this->Paginator->sort('title', 'Title'); ?></th>
			<th width="10%" align="left"><?php echo  $this->Paginator->sort('coupon_code', 'Coupon Code'); ?></th>						
			<th width="8%" align="left"><?php echo $this->Paginator->sort('no_of_share', 'No. of Share\'s required'); ?></th>
			<th width="8%" align="left"><?php echo $this->Paginator->sort('valid_for', 'Valid for'); ?></th>
			<!--<th width="8%" align="left"><?php echo $this->Paginator->sort('used_count', 'Usage Count'); ?></th>-->
			<th width="8%" align="left"><?php echo $this->Paginator->sort('status', 'Status'); ?></th>
			<th width="8%" align="left"><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
			<th  width="8%" align="left">Action</th>
			  </tr>
	  <?php		
	  $i=1;
	  foreach($coupons as $cp)
	  {
	  ?>
		 <tr>
			<td align="left"><?php echo $cp['Coupon']['id']; ?></td>
			<td align="left"><?php echo $cp['AdminClientDeal']['title']; ?></td>
			<td align="left"><img src="<?php echo $this->webroot.'img/coupons/M_'.$cp['Coupon']['image']; ?>" alt=""/></td>
			<td align="left"><?php echo $cp['Coupon']['title']; ?></td>	
			<td align="left"><?php echo $cp['Coupon']['coupon_code']; ?></td>	
			<td align="left"><?php echo $cp['Coupon']['no_of_share']; ?></td>	
			<td align="left"><?php echo $cp['Coupon']['valid_for']; ?></td>	
			<!--<td align="left"><?php echo $cp['Coupon']['usage_count']; ?></td>-->	
			<td align="left"><?php echo $cp['Coupon']['status']; ?></td>	
			<td align="left"><?php echo date('F d Y H:i:s', strtotime($cp['Coupon']['created'])); ?></td>			
			
			<td align="center" valign="middle" >&nbsp;
				<?php echo $this->Html->link($this->Html->image('/admin/images/view.gif'), array('controller' => 'coupons', 'action' => 'view', $cp['Coupon']['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link($this->Html->image('/admin/images/edit_icon.gif'), array('controller' => 'coupons', 'action' => 'edit', $cp['Coupon']['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link($this->Html->image('/admin/images/close.png'), array('controller' => 'coupons','action' => 'delete', $cp['Coupon']['id']),array('escape'=>false), __('Are you sure you want to delete # %s?', $cp['Coupon']['id'])); ?>
				
			</td>
			
		  </tr>
	 <?php
	 }
	 ?>
		<tr align="right">
			<td colspan="11" align="left" class="bordernone">
				<div class="floatleft mtop7">
					<div class="pagination">
						<?php echo $this->Paginator->prev(); ?><?php echo $this->Paginator->numbers(); ?><?php echo $this->Paginator->next(); ?>
					</div>
				</div>			
				
				</div>                 
			</td>
		</tr>
	</table>
	</form>
</div>
