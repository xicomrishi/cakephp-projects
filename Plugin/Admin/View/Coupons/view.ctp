
<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('View Coupon'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Coupons').'</span>', array('controller' => 'coupons','action' => 'index','plugin' => 'admin'),array( 'class'=>'black_btn','escape'=>false));?>
	</div>
	<div class="errorMsg">
		<?php
			if (isset($invalidfields)) {
				echo " <p class='top15 gray12'><table>
					<tr><th>Fields</th><th>Error</th><tr>";
				foreach ($invalidfields as $key => $field) {
					echo "<tr><td>" . $key . "</td><td>";
					echo "<ul>";
					foreach ($field as $error) {
						echo "<li>" . $error . "</li>";
					}
					echo "</ul></td></tr>";
				}
				echo "</table>  </p>";
			}
		?>
	</div>
</div>

<div align="center" class="whitebox mtop15">
 
	    <table cellspacing="0" cellpadding="7" border="0" align="center">
	
			<?php
				echo $this->Form->input('id',array('type' => 'hidden'));
			?>
			<tr>
				<td align="left">					
					<strong class="upper">Deal</strong>
					
				</td>
				<td align="left">	
					<?php echo $coupon['AdminClientDeal']['title']; ?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Coupon Title</strong>
					
				</td>
				<td align="left">	
					<?php echo $coupon['Coupon']['title']; ?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Coupon Description</strong>
					
				</td>
				<td align="left">	
					<?php echo $coupon['Coupon']['description']; ?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Number of share's required</strong>
				</td>
				<td align="left">	
					<?php echo $coupon['Coupon']['no_of_share']; ?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Valid For (in hours)</strong>
					
				</td>
				<td align="left">	
					<?php echo $coupon['Coupon']['valid_for']; ?>
				</td>
				
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Image</strong>
					
				</td>
				<td align="left">	
					<img src="<?php echo $this->webroot.'img/coupons/M_'. $coupon['Coupon']['image']; ?>" alt="" ?>
				</td>
				
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Status</strong>
					
				</td>
				<td align="left">	
					<?php echo $coupon['Coupon']['status']; ?>
				</td>
				
			</tr>		
			<tr>
				<td align="left">					
					<strong class="upper">Created</strong>
					
				</td>
				<td align="left">	
					<?php echo date('F d Y H:i:s', strtotime($coupon['Coupon']['created'])); ?>
				</td>
				
			</tr>
				
	    </table>
   
</div>
