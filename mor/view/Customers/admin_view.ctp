<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Customer', true), array('action' => 'edit', $Customer['Customer']['customer_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Customer', true), array('action' => 'delete', $Customer['Customer']['customer_id']), null, sprintf(__('Are you sure you want to delete?', true))); ?> </li>
		<li><?php echo $this->Html->link(__('Back to Customers', true), array('action' => 'index')); ?> </li>
	</ul>
</div>

<div class="customers view">
	<h2><?php echo __('Customer');?>: <?php echo $Customer['Customer']['name'];?></h2>
	<table>
	
		<tr><th colspan="4">Account Info</th></tr>
		<tr>
		<td><strong>Name</strong></td><td><?php 
		echo $Customer['Customer']['name'];
		
		?></td>
		<td><strong>Type</strong></td><td><?php echo $Customer['Customer']['customer_type']; ?></td>
		</tr><tr>
		<td><strong>Email</strong></td><td><?php echo $Customer['Customer']['email']; ?></td>
		<td><strong>Address</strong></td><td><?php echo $Customer['Customer']['address']; ?></td>
		</tr><tr>
		<td><strong>Phone</strong></td><td><?php echo $Customer['Customer']['phone']; ?></td>
		<td><strong>City</strong></td><td><?php echo $Customer['Customer']['city'];?></td>		
		</tr><tr>
		<td><strong>State</strong></td><td><?php echo $Customer['State']['state_name']; ?></td>
		<td><strong>Country</strong></td><td><?php echo $Customer['Country']['country_name']; ?></td>
		</tr><tr>
		<td><strong>Pin</strong></td><td><?php echo $Customer['Customer']['zip_code']; ?></td>
		<td><strong>Wallet Amount</strong></td><td><?php echo $Customer['Customer']['wallet_current_amount']; ?></td>
		</tr><tr>
		<td><strong>Status</strong></td><td><?php echo $Customer['Customer']['customer_status']; ?></td>	
		<td><strong>Added Date</strong></td><td><?php echo $Customer['Customer']['customer_added_date']; ?></td>
		</tr><tr>
		<td><strong>Modified Date</strong></td><td><?php echo $Customer['Customer']['customer_modified_date']; ?></td>
		<td><strong>Last Login Date</strong></td><td><?php echo $Customer['Customer']['last_login_date']; ?></td>
		</tr><tr>
		<td><strong>Last Login IP</strong></td><td><?php echo $Customer['Customer']['last_login_ip']; ?></td>
		<td colspan="2">&nbsp;</td>
		</tr>
	
	
	</table>
	
	<table>
	
		<tr><th colspan="2">Wallet History</th></tr>		
		<tr><td><strong>Date</strong></td><td><strong>Transactions</strong></td><td><strong>Wallet Balance</strong></td></tr>
        <?php if(!empty($Customer['Wallet'])){
				foreach($Customer['Wallet'] as $wt){ ?>
             <tr>
             	<td><?php echo date("d-m-Y H:i:s",strtotime($wt['date'])); ?></td>
             	<td><?php 
					
					if($wt['type']=='Credit' && $wt['refund']=='Yes'){
						echo 'Refund of failed recharge '.$wt['Recharge']['number'].', Rs.'.$wt['amount'];
					}else if($wt['type']=='Credit' && !empty($wt['payment_id'])){ 
						echo 'Rs.'.$wt['amount'].' added to wallet.';
					}else if($wt['type']=='Credit' && empty($wt['payment_id'])){
						echo 'Failed Transaction - Rs.'.$wt['amount'].' funds to wallet.';
					}else if($wt['type']=='Debit' && $wt['payment_mode']=='Wallet'){ 
						echo 'Recharge '.$wt['Recharge']['number'].', Rs.'.$wt['amount'];
					}
				
				?></td>
                <td><?php if(!empty($wt['wallet_current_amount'])) echo 'Rs.'.$wt['wallet_current_amount']; else echo 'n/a'; ?></td>
             </tr>
        
        <?php }}else{ ?>
		<tr><td  colspan="3">No transaction found.</td></tr>
        <?php } ?>
	</table>
	
	<table>
	
		<tr>
		<th colspan="6">Recharge History</th></tr>		
		
		<tr>
		<td><strong>Date</strong></td><td><strong>Number</strong></td><td><strong>Operator</strong></td><td>
		<strong>Order #</strong></td><td><strong>Amount(r<small>s</small>.)</strong></td><td><strong >Status</strong>
		</td>
		</tr>
		
		<?php if(!empty($Customer['Recharge'])){
		foreach($Customer['Recharge'] as $recharge){?>
			<tr>
			<td><?php if(!empty($recharge['payment_date']) && $recharge['payment_date']!='0000-00-00 00:00:00'){ echo $this->Time->format('Y-m-d',$recharge['payment_date']);}?></td>
			<td><?php echo $recharge['number'];?></td>
			<td><?php echo $recharge['Operator']['name'];?></td>
			<td><?php echo $recharge['transaction_id'];?></td>
			<td><?php echo $recharge['amount'];?></td>
			<td>
			<?php if($recharge['recharge_payment_status']==1 && $recharge['recharge_status']==1){
				echo 'success';
						
			}elseif($recharge['recharge_payment_status']==1 && $recharge['recharge_status']==0){
				echo 'processing';
				      					
			}else{
				echo 'failed';
			}
			?></td></tr>	
		<?php 			
		}
		}else{?>
		
		<tr><td  colspan="6">No transaction found.</td></tr><?php 
	}	?>
	</table>
	
	
</div>

