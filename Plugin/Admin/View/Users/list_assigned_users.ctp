 <h1>Manage Users</h1>
<div class="row mtop15">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr valign="top">
		  <td align="left" class="searchbox">
			<div class="floatleft">
			<?php echo $this->Form->create(array('url' => '/admin/users/subadmin_index', 'type' => 'get'));  ?>
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
			</div>
			
			
		  </td>
	  </tr>
	</table>
</div>
    

<div class="row mtop30">
<?php echo $this->Form->create(array('url' => '/admin/users/subadmin_index', 'type' => 'post'));  ?>
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
		  <tr>
			<th width="4%" align="center">S No.</th>
			<th width="15%" align="left"><?php echo $this->Paginator->sort('first_name'); ?></th>
			<th width="15%" align="left"><?php echo $this->Paginator->sort('last_name'); ?></th>
			<th width="15%" align="left"><?php echo $this->Paginator->sort('username'); ?></th>
			<th width="20%" align="left"><?php echo  $this->Paginator->sort('email'); ?></th>			
			
			<!--<th width="5%" align="center"><input type="checkbox" onclick="checkall(this.form)" value="check_all" id="check_all" name="check_all"></th>-->
	  </tr>
	  <?php		
	  $i=1;
	  foreach($users as $user)
	  {
	  ?>
		 <tr>
			<td align="center"><?php echo  $i; $i++;?></td>
			<td align="left"><?php echo $user['Admin']['first_name']; ?></td>
			<td align="left"><?php echo $user['Admin']['last_name']; ?></td>
			<td align="left"><?php echo $user['Admin']['username']; ?></td>
			<td align="left"><?php echo $user['Admin']['email']; ?></td>			
			
			<!--<td valign="middle" align="center">
				<input type="checkbox" value="<?php echo $user['Admin']['id']; ?>" name="ids[]">
			</td>-->
		  </tr>
	 <?php
	 }
	 ?>
		<tr align="right">
			<td colspan="7" align="left" class="bordernone">
				<div class="floatleft mtop7">
					<div class="pagination">
						<?php echo $this->Paginator->prev(); ?><?php echo $this->Paginator->numbers(); ?><?php echo $this->Paginator->next(); ?>
					</div>
				</div>

				<!--<div class="floatright">
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
				</div>-->
				</div>                 
			</td>
		</tr>
	</table>
	</form>
</div>
