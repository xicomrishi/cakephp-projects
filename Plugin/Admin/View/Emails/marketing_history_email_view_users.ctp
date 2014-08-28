 <h1>Marketing Email History Users List</h1>
<div class="row mtop15">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr valign="top">
		  <td align="left" class="searchbox">
			
			<?php	/*<div class="floatleft">
				<?php echo $this->Form->create('null', array('url' => '/admin/users/marketing_history_email_view_users', 'type' => 'get'));  ?>
					  <table cellspacing="0" cellpadding="4" border="0">
					  <tr valign="top">
						  <td valign="middle" align="left" ><input type="text" class="input" value="<?php if(isset($_GET['search_keyword'])) echo $_GET['search_keyword'] ?>" placeholder="Enter Keyword" style="width:300px;" name="search_keyword"></td>
						  <td valign="middle" align="left" ><select class="select" name="filter" style="width:300px;">
							  <option value="first_name">By First Name</option>
							  <option value="last_name">By Last Name</option>
							  <option value="email">By Email</option>
							</select></td>
						  <td valign="middle" align="left"><div class="black_btn2"><span class="upper"><input type="submit" value="Search Users" name=""></span></div></td>
						</tr>
					</table>
				</form>
			</div> */?>
			
			<div class="floatright top5">			
				<?php echo $this->Html->link('<span>Back</span>', array('controller' => 'emails', 'action' => 'marketing_history_email', 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false)); ?>
			</div>
		  </td>
	  </tr>
	</table>
</div>
    

<div class="row mtop30">
<?php echo $this->Form->create('null', array('url' => '/admin/users/marketing_history_email_view_users', 'type' => 'post'));  ?>
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
	<tr>
		<th width="4%" align="center">S No.</th>
		<th width="20%" align="left"><?php echo  $this->Paginator->sort('user_email', 'Email'); ?></th>
		<th width="8%" align="center"><?php echo $this->Paginator->sort('track_status', 'Status'); ?></th>
		<th width="20%" align="center">Error</th>
	</tr>
	  <?php		
	  $i=1;
	  foreach($marketing_email_history_users as $user)
	  {
	  ?>
		 <tr>
			<td align="center"><?php echo  $i; $i++;?></td>			
			<td align="left"><?php echo $user['AdminClientMarketingEmailUser']['user_email']; ?></td>
			<td align="center"><?php echo $user['AdminClientMarketingEmailUser']['track_status']; ?></td>
			<td align="center"><?php echo strip_tags($user['AdminClientMarketingEmailUser']['error_text']); ?></td>
		  </tr>
	 <?php
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

			<!--	<div class="floatright">
					<div class="floatleft">
					<select name="option"  class="select">
						<option value="">Select Option</option>
						<option value="delete">Delete</option>
						<option value="active">Activate</option>
						<option value="deactive">Deactivate</option>					
					</select>
				</div>
				<div class="floatleft mleft10">
					<div class="black_btn2">
						<span class="upper">
							<input type="submit" value="SUBMIT" name="">
						</span>
					</div>
				</div>
				</div>     -->            
			</td>
		</tr>
	</table>
	</form>
</div>
