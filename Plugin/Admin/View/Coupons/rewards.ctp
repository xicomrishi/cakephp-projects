 <h1>Redeem Rewards</h1>


<div class="row mtop30">
<?php echo $this->Form->create(array('url' => '/admin/users/index', 'type' => 'post'));  ?>
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
		  <tr>
			<th width="4%" align="center">S No.</th>
			<th width="15%" align="left"><?php echo 'QR Code' ?></th>
			<th width="10%" align="left"><?php echo 'First Name' ?></th>
			<th width="10%" align="left"><?php echo 'Last Name'; ?></th>
			<th width="10%" align="left"><?php echo 'Email'; ?></th>			
			<th width="9%" align="left"><?php echo  'Deal Title' ?></th>
			<th width="9%" align="left"><?php echo  'Number of Shares'; ?></th>
			<th width="9%" align="left"><?php echo  'Coupon Code'; ?></th>
			<th width="9%" align="left"><?php echo  'Coupon Date'; ?></th>
			<th width="9%" align="left"><?php echo  'Valid Till'; ?></th>
			<th width="9%" align="left"><?php echo  'Redemption Status'; ?></th>
			<th width="9%" align="left">Action</th>
		</tr>
	  <?php		
	  $i=1;
	  foreach($users as $user)
	  {
	  	
	  ?>
		 <tr>
			<td align="center"><?php echo  $i; $i++;?></td>
			<td align="left"><img src="<?php echo $this->webroot.'img/QRcodes/'.$user['UserCoupon']['qr_image']; ?>" alt="" style="max-width:150px;"></td>
			<td align="left"><?php echo $user['User']['first_name']; ?></td>
			<td align="left"><?php echo $user['User']['last_name']; ?></td>
			<td align="left"><?php echo $user['User']['email']; ?></td>			
			<td align="left"><?php echo $user['Coupon']['AdminClientDeal']['title']; ?></td>
			<td align="center"><?php echo $user['Coupon']['no_of_share']; ?></td>
			<td align="center"><?php echo strtoupper($user['UserCoupon']['code']); ?></td>
			<td align="center"><?php echo date('F d Y H:i:s', strtotime($user['UserCoupon']['created'])); ?></td>
			<td align="center"><?php echo date('F d Y H:i:s', strtotime($user['UserCoupon']['valid_till'])); ?></td>
			<td align="center"><?php if($user['UserCoupon']['status'] == 'used') echo 'Redeemed'; else echo strtoupper($user['UserCoupon']['status']); ?></td>
		  	<td align="center">
		  		
		  		<?php 
		  		if($user['UserCoupon']['status'] == 'not used'){
		  		echo $this->Html->link('Redeem', array('controller' => 'coupons','action' => 'redeem_coupon', $user['UserCoupon']['id']),array('escape'=>false), __('Are you sure you want to update coupon status # %s?', $user['UserCoupon']['id'])); 
				}
				?>
		  		
		  	</td>
		  </tr>
	 <?php
	 }
	 ?>
		<tr align="right">
			<td colspan="12" align="left" class="bordernone">
				<div class="floatleft mtop7">
					<div class="pagination">
						<?php echo $this->Paginator->prev(); ?>
						<?php echo $this->Paginator->numbers(); ?>
						<?php echo $this->Paginator->next(); ?>
					</div>
				</div>

			             
			</td>
		</tr>
	</table>
	</form>
</div>
