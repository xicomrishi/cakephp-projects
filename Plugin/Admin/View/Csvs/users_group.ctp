 <h1>Group Users</h1>
<div class="row mtop15">
	
</div>
    

<div class="row mtop30">
<?php echo $this->Form->create('ImportedUser',array('url' => '/admin/csvs/save_group', 'type' => 'post'));  ?>


	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
		  <tr>
			<th width="4%" align="center">S No.</th>
			<th width="15%" align="left"><?php echo $this->Paginator->sort('first_name'); ?></th>
			<th width="15%" align="left"><?php echo $this->Paginator->sort('last_name'); ?></th>
			<th width="15%" align="left"><?php echo $this->Paginator->sort('email'); ?></th>
			
			<th width="5%" align="center"><!--<input type="checkbox" onclick="checkall(this.form)" value="check_all" id="check_all" name="check_all">--></th>
	  </tr>
	  <?php		
	  $i=1;
	  foreach($default as $user)
	  {
	  	if ( !in_array($user['Admin']['id'],$already) )
	  	{
	  ?>
		 <tr>
			<td align="center"><?php echo  $i; $i++;?></td>
			<td align="left"><?php echo $user['ImportedUser']['first_name']; ?></td>
			<td align="left"><?php echo $user['Admin']['last_name']; ?></td>
			<td align="left"><?php echo $user['Admin']['username']; ?></td>
			<td align="left"><?php echo $user['Admin']['email']; ?></td>			

			
			<td valign="middle" align="center">
				<input type="checkbox" id="check_<?php echo $user['Admin']['id']; ?>" <?php if(in_array($user['Admin']['id'],$assigned)) echo 'checked'; ?> value="<?php echo $user['Admin']['id']; ?>" name="ids[]" onclick="update_input(this.value);">
			</td>
		  </tr>
	 <?php
	 }}
	 ?>
		<tr align="right">
			<td colspan="7" align="left" class="bordernone">
				<div class="floatleft mtop7">
					
					<div class="pagination">
						<?php echo $this->Paginator->prev(); ?><?php echo $this->Paginator->numbers(); ?><?php echo $this->Paginator->next(); ?>
					</div>
				</div>

				<div class="floatright">
					
				<div class="floatleft mleft10">
					<div class="black_btn2">
						<span class="upper">
							<input type="submit" value="Assign" name="">
						</span>
					</div>
				</div>
				</div>                 
			</td>
		</tr>
	</table>
	</form>
</div>

<script type="text/javascript">

$(document).ready(function(e){
	
	get_checked_users();
});


</script>