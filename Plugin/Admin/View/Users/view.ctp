
<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Admin View User'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage User').'</span>', array('controller' => 'users','action' => 'index','plugin' => 'admin'),array( 'class'=>'black_btn','escape'=>false));?>
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
					<strong class="upper">User id</strong>
					
				</td>
				<td align="left">	
					<?php echo $user_info['Admin']['id']; ?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">First Name</strong>
					
				</td>
				<td align="left">	
					<?php echo $user_info['Admin']['first_name']; ?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Last Name</strong>
				</td>
				<td align="left">	
					<?php echo $user_info['Admin']['last_name']; ?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Username</strong>
					
				</td>
				<td align="left">	
					<?php echo $user_info['Admin']['username']; ?>
				</td>
				
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Email</strong>
					
				</td>
				<td align="left">	
					<?php echo $user_info['Admin']['email']; ?>
				</td>
				
			</tr>		
			<tr>
				<td align="left">					
					<strong class="upper">Company</strong>
					
				</td>
				<td align="left">	
					<?php echo $user_info['Admin']['company']; ?>
				</td>
				
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Website URL</strong>
					
				</td>
				<td align="left">	
					<span>
						<?php echo $this->Html->link(SITE_URL.'websites/domain/'.$user_info['Admin']['website_url'], 
											SITE_URL.'websites/domain/'.$user_info['Admin']['website_url'],
											array('id'=>'1', 'target'=>'_blank')
									); 
										
						?>
					</span>
					
				</td>				
			</tr>			
			<tr>
				<td align="left">					
					<strong class="upper">Tablet URL</strong>
					
				</td>
				<td align="left">	
					<span>
						<?php echo $this->Html->link(SITE_URL.trim(str_replace(' ','-',$user_info['Admin']['company'])), 
											SITE_URL.trim(str_replace(' ','-',$user_info['Admin']['company'])), 
											array('id'=>'2', 'target'=>'_blank')
									); 
										
						?>
					</span>
					
				</td>		
			</tr>
			
			<tr>
				<td align="left"><strong class="upper">Business Phone</strong></td>
				<td align="left">	
					<?php echo $user_info['Admin']['mobile']; ?>
				</td>
			</tr>
				
			<tr>
				<td align="left"><strong class="upper">Address</strong></td>
				<td align="left">	
					<?php echo $user_info['Admin']['address']; ?>
				</td>
			</tr>
			
			<tr>
				<td align="left"><strong class="upper">DOB</strong></td>
				<td align="left">	
					<?php echo $user_info['Admin']['dob']; ?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Company</strong>					
				</td>
				<td align="left">	
					<?php echo $user_info['Admin']['company']; ?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Facebook Fanpage Id</strong>					
				</td>
				<td align="left">	
					<?php echo $user_info['Admin']['fb_fanpage_id']; ?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Facebook (Page name)</strong>					
				</td>
				<td align="left">	
					<?php echo $user_info['Admin']['facebook_url']; ?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Twitter (Screenname)</strong>					
				</td>
				<td align="left">	
					<?php echo $user_info['Admin']['twitter_url']; ?>
				</td>				
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Google+ ID</strong>
					
				</td>
				<td align="left">	
					<?php echo $user_info['Admin']['google_url']; ?>
				</td>				
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Send Feedback Email</strong>
					
				</td>
				<td align="left">	
					<?php echo ucfirst($user_info['Admin']['feedback_email']); ?>
				</td>
				
			</tr>
			<tr>
				<td align="left"><strong class="upper">Status</strong></td>
				<td align="left">	
					<?php echo $user_info['Admin']['status']; ?>
				</td>
			</tr>	
	    </table>
   
</div>
