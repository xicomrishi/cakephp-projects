<style>
.menubg .custom_nav span{
	  
    color: #FFFFFF;
    display: block;
    float: left;
    font-size: 11px;
    font-weight: bold;
    height: 24px;
    padding: 11px 15px 2px;
    text-decoration: none;
    text-shadow: 0 -1px #26272F;
    text-transform: uppercase;
}
</style>
<?php 
	$loggedinUser = $this->Session->read('Auth.User'); 

?>
<div id="header">
    <div id="head_lt">
    <!--Logo Start from Here-->
    <span class="floatleft">
	<?php echo $this->Html->link($this->Html->image('logo-combined.png', array('style' => "margin-right:10px;")), array('controller' => 'users', 'action' => 'index', 'plugin' => 'admin'), array('escape' => false)); ?>
	</span>
	<span class="slogan">
		<!--administration suite -->
	</span>
    <!--Logo end  Here-->
    </div>
	<?php
	
	
	if ( isset( $loggedinUser) )
	{	$us_name =  $loggedinUser['username'];
	
				if($this->Session->check('is_subadmin_user'))
					$us_name = $this->session->read('is_subadmin_user.username');
	?>
		<div id="head_rt">Welcome <span><?php echo $us_name; ?></span>&nbsp;&nbsp;|&nbsp;&nbsp; <?php echo date('d M, Y h:i A'); ?></div>
	<?php
	} ?>
</div>
<?php if(!empty($loggedinUser)) { ?>
<div class="menubg">
	<div class="nav">
		<ul id="navigation">
			
			
				<?php if($this->Session->check('is_subadmin_user')){ ?>
				<li onmouseout="this.className=''" onmouseover="this.className='hov'">
					<?php echo $this->Html->link('Dashboard', '/admin/users/subadmin_dashboard', array('class' => '','title'=>'My Dashboard')); ?>
				</li>
				<?php } ?>
			
			<?php if(!$this->Session->check('is_subadmin_user')){ ?>
			<li onmouseout="this.className=''" onmouseover="this.className='hov'">
				<?php 
					if($this->Session->check('is_subadmin_user'))
					{
						echo $this->Html->link('Admin Dashboard', '/admin', array('class' => '')); 
					
					}else{
						
						if($loggedinUser['type'] == '3')
						{
							echo $this->Html->link('Home', '/admin/users/subadmin_dashboard', array('class' => '')); 
						}else{
							echo $this->Html->link('Home', '/admin', array('class' => '')); 
						}						
					
					}
				?>
			</li>
			<?php } ?>
			<?php if($loggedinUser['type'] == 3) { 
					
					
			?>
			
				<li onmouseout="this.className=''" onmouseover="this.className='hov'">
					<?php echo $this->Html->link('Add User', '/admin/users/subadmin_add_user', array('class' => '','title'=>'You can add new user from here')); ?>
				</li>
				
				<li onmouseout="this.className=''" onmouseover="this.className='hov'">
					<?php echo $this->Html->link('Change Password', '/admin/users/change_password', array('class' => '','title'=>'You can change you login password from here')); ?>
				</li>
			<?php } ?>	
			<?php if($loggedinUser['type'] == 1) { ?>
				<li onmouseout="this.className=''" onmouseover="this.className='hov'"><?php echo $this->Html->link('Manage users', 'javascript:void(0);', array()); ?>
					<div class="sub">
						<ul>
							<li>
								<?php echo $this->Html->link('List users', array('controller' => 'users', 'action' => 'index', 'plugin' => 'admin')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Add user', array('controller' => 'users', 'action' => 'add', 'plugin' => 'admin')); ?>
							</li>
						</ul>
					</div>
				</li>
				
				<li onmouseout="this.className=''" onmouseover="this.className='hov'"><?php echo $this->Html->link('Manage sub-admins', 'javascript:void(0);', array()); ?>
					<div class="sub">
						<ul>
							<li>
								<?php echo $this->Html->link('List sub-admins', array('controller' => 'users', 'action' => 'subadmin_index', 'plugin' => 'admin')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Add sub-admin', array('controller' => 'users', 'action' => 'subadmin_add', 'plugin' => 'admin')); ?>
							</li>
						</ul>
					</div>
				</li>
				
				<li onmouseout="this.className=''" onmouseover="this.className='hov'"><?php echo $this->Html->link('CMS Management', array('controller' => 'cms', 'action' => 'index', 'plugin' => 'admin')); ?>
					<div class="sub">
						<ul>
							<li>
								<?php echo $this->Html->link('List cms pages', array('controller' => 'cms', 'action' => 'index', 'plugin' => 'admin')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Add cms page', array('controller' => 'cms', 'action' => 'add', 'plugin' => 'admin')); ?>
							</li>
						</ul>
					</div>
				</li>
				<li onmouseout="this.className=''" onmouseover="this.className='hov'">
					<?php echo $this->Html->link('Admin', '/admin/emails/manage/', array('class' => '')); ?>
					<div class="sub">
						<ul>
							<li>
								<?php echo $this->Html->link('Manage Email Template', '/admin/emails/manage/', array('class' => '')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Change Password', '/admin/users/change_password', array('class' => '')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Site Settings', '/admin/settings/site_setting', array('class' => '')); ?>
							</li>

						</ul>
					</div>
				</li>
				<li onmouseout="this.className=''" onmouseover="this.className='hov'">
					<?php echo $this->Html->link('Report', '/admin/users/deal_report/', array('class' => '')); ?>
					<div class="sub">
						<ul>
							<li>
								<?php echo $this->Html->link('Deal', '/admin/users/deal_report/', array('class' => '')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Users Visits', '/admin/users/user_visit_report/', array('class' => '')); ?>
							</li>
						</ul>
					</div>
				</li>
			<?php } elseif($loggedinUser['type'] == 2) { ?>
				
				
				<li onmouseout="this.className=''" onmouseover="this.className='hov'"><?php echo $this->Html->link('Manage', 'javascript:void(0);', array('title'=>'Manage your profile, website pages and appointments')); ?>
					<div class="sub">
						<ul>
							<li>
								<?php echo $this->Html->link('View Profile', array('controller' => 'users', 'action' => 'profile', $loggedinUser['id'], 'plugin' => 'admin')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Edit Profile', array('controller' => 'users', 'action' => 'edit', $loggedinUser['id'], 'plugin' => 'admin')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Slider', array('controller' => 'users', 'action' => 'slider', $loggedinUser['id'], 'plugin' => 'admin')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Deals', array('controller' => 'users', 'action' => 'deals', $loggedinUser['id'], 'plugin' => 'admin')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Appointments', array('controller' => 'users', 'action' => 'client_appointments', $loggedinUser['id'], 'plugin' => 'admin')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Contact Requests', array('controller' => 'users', 'action' => 'client_contact_requests', $loggedinUser['id'], 'plugin' => 'admin')); ?>
							</li>
							<!--<li>
								<?php echo $this->Html->link('Uploaded Document', array('controller' => 'users', 'action' => 'client_document_upload_requests', $loggedinUser['id'], 'plugin' => 'admin')); ?>
							</li>-->
							<li>
								<?php //echo $this->Html->link('Reports', array('controller' => 'users', 'action' => 'deal_report_client', $loggedinUser['id'], 'plugin' => 'admin')); ?>
							</li>
						</ul>
					</div>
				</li>
				
				<li onmouseout="this.className=''" onmouseover="this.className='hov'">
					<?php echo $this->Html->link('Rewards', '/admin/coupons/rewards', array('class' => '','title'=>'List of users eligible for rewards')); ?>
					<div class="sub">
						<ul>
							<li>
								<?php echo $this->Html->link('Rewards', '/admin/coupons/rewards', array('class' => '','title'=>'List of users eligible for rewards')); ?>
							</li>
							
							<li>
								<?php echo $this->Html->link('Coupons', '/admin/coupons/index', array('class' => '','title'=>'List of coupons')); ?>
							</li>	
						</ul>
					</div>	
				</li>
				<li onmouseout="this.className=''" onmouseover="this.className='hov'">
					<?php echo $this->Html->link('Report', '/admin/users/deal_report_client/', array('class' => '','title'=>'View deal and user reports.')); ?>
					<div class="sub">
						<ul>
							<li>
								<?php echo $this->Html->link('Deal', '/admin/users/deal_report_client/', array('class' => '')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Users Visits', '/admin/users/client_user_visit_report/', array('class' => '')); ?>
							</li>
						</ul>
					</div>
				</li>
				<li onmouseout="this.className=''" onmouseover="this.className='hov'">
					<?php echo $this->Html->link('Settings', '/admin/users/change_password', array('class' => '','title'=>'You can change you login password from here')); ?>
					<div class="sub">
						<ul>
							<li>
								<?php echo $this->Html->link('Change Password', '/admin/users/change_password', array('class' => '','title'=>'You can change you login password from here')); ?>
					
							</li>
							<li>
								<?php echo $this->Html->link('Connect with Facebook', '/admin/users/get_page_access_token/1', array('class' => '','title'=>'Coonect with facebook')); ?>
					
							</li>
						</ul>
					</div>
				</li>
				<li onmouseout="this.className=''" onmouseover="this.className='hov'">
					<?php echo $this->Html->link('Feedback Email', '/admin/emails/feedback_email/'.$loggedinUser['id'], array('class' => '','title'=>'The feedback email is sent to the user to recieve feedback on the deals they used. This email goes out to your client after the number of days of interval as set here.')); ?>
				</li>
				<li onmouseout="this.className=''" onmouseover="this.className='hov'">
					<?php echo $this->Html->link('Deal Share Email', '/admin/emails/deal_email/'.$loggedinUser['id'], array('class' => '','title'=>'The deal email is sent to the user when the user shares your deal along with the coupon. This email is sent to the user when the deal is shared.')); ?>
				</li>
				<li onmouseout="this.className=''" onmouseover="this.className='hov'">
					<?php echo $this->Html->link('Marketing Email', 'javascript:void(0);', array('class' => '','title'=>'Engage your clients with a marketing email. you can add sheduled emails, save drafts or reach out to your clients immediately')); ?>
					<div class="sub">
						<ul>
							<li>
								<?php echo $this->Html->link('Create Email', '/admin/emails/marketing_send_email/'.$loggedinUser['id'], array('class' => '')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Scheduled Emails', '/admin/emails/marketing_schedule_email/'.$loggedinUser['id'], array('class' => '')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Drafts', '/admin/emails/marketing_draft_email/'.$loggedinUser['id'], array('class' => '')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('History', '/admin/emails/marketing_history_email/'.$loggedinUser['id'], array('class' => '')); ?>
							</li>
						</ul>
					</div>
				</li>
				<li onmouseout="this.className=''" onmouseover="this.className='hov'">
					<?php echo $this->Html->link('Import Users', '#_', array('class' => '','title'=>'')); ?>
					<div class="sub">
						<ul>
							<li>
								<?php echo $this->Html->link('Import from csv', array('plugin' => 'admin', 'controller' => 'csvs', 'action' => 'import'), array('class' => '')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Import from Gmail', array('plugin' => 'admin', 'controller' => 'csvs', 'action' => 'import_google'), array('class' => '')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('Import from Yahoo', array('plugin' => 'admin', 'controller' => 'csvs', 'action' => 'import_yahoo'), array('class' => '')); ?>
							</li>
							
						</ul>
					</div>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class="logout">
		<?php
			echo $this->Html->image("/admin/images/logout.gif", array(
					"alt" => "Logout",
					'url' => array('controller' => 'users', 'action' => 'logout', 'plugin' => 'admin')
				));
		?>
	</div>
</div>

<?php if($this->Session->check('is_subadmin_user')){ ?>
	<div class="menubg" style="background-color: #777">
		<div class="nav custom_nav">
			<span>
					<?php
						$sub =  $this->Session->read('Auth.User');
					 echo $sub['first_name'].' '.$sub['last_name'].' - '.$sub['username'].' | '.$sub['company'].' | '.$sub['address']; ?>
				</span>	
		</div>	
	</div>
		
<?php } ?>	

<?php } ?>


