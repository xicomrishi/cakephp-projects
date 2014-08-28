 <h1>Manage Users</h1>
<div class="row mtop15">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr valign="top">
		  <td align="left" class="searchbox">
			<div class="floatleft">
			<?php echo $this->Form->create(array('url' => '/admin/cms/index', 'type' => 'get'));  ?>
				  <table cellspacing="0" cellpadding="4" border="0">
				  <tr valign="top">
					  <td valign="middle" align="left" ><input type="text" class="input" value="<?php if(isset($_GET['search_keyword'])) echo $_GET['search_keyword'] ?>" placeholder="Enter Keyword" style="width:300px;" name="search_keyword"></td>
					  <td valign="middle" align="left" ><select class="select" name="filter" style="width:300px;">
						  <option value="page_name">By Title</option>
						  <option value="url_key">By Url</option>						  
						</select></td>
					  <td valign="middle" align="left"><div class="black_btn2"><span class="upper"><input type="submit" value="Search Cms" name=""></span></div></td>
					</tr>
				</table>
			</form>
			</div>
			
			<div class="floatright top5">
			<?php echo $this->Html->link('<span>Add cms</span>', array('controller' => 'cms', 'action' => 'add', 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false)); ?>
			<?php echo $this->Html->link('<span>Manage cms</span>', array('controller' => 'cms', 'action' => 'index', 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false)); ?>
			
		  </td>
	  </tr>
	</table>
</div>
    

<div class="row mtop30">
<?php echo $this->Form->create(array('url' => '/admin/cms/index', 'type' => 'post'));  ?>
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
		  <tr>
			<th width="4%" align="center">S No.</th>
			<th width="38%" align="left"><?php echo $this->Paginator->sort('page_name'); ?></th>
			<th width="30%" align="left"><?php echo  $this->Paginator->sort('url_key'); ?></th>
			<th width="9%" align="left"><?php echo  $this->Paginator->sort('created'); ?></th>
			<th width="8%" align="center"><?php echo $this->Paginator->sort('status'); ?></th>
			<th width="6%" align="center">Details</th>
			<th width="5%" align="center"><input type="checkbox" onclick="checkall(this.form)" value="check_all" id="check_all" name="check_all"></th>
	  </tr>
	  <?php		
	  $i=1;
	  foreach($cms as $single)
	  {
	  ?>
		 <tr>
			<td align="center"><?php echo  $i; $i++;?></td>
			<td align="left"><span class="blue"><?php echo $single['Cms']['page_name']; ?></span></td>
			<td align="left"><?php echo $single['Cms']['url_key']; ?></td>
			<td align="left"><?php echo $single['Cms']['created']; ?></td>
			<td align="center"><?php echo $single['Cms']['status']; ?></td>
			<td align="center" valign="middle" >&nbsp;<?php echo $this->Html->link($this->Html->image('/admin/images/edit_icon.gif'), array('controller' => 'cms', 'action' => 'edit', $single['Cms']['id']), array('escape' => false)); ?></td>
			<td valign="middle" align="center"><input type="checkbox" value="<?php echo $single['Cms']['id']; ?>" name="ids[]"></td>
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
			
			<div class="floatright">
				<div class="floatleft">
				<select name="option"  class="select">
					<option value="">Select Option</option>
					<option value="delete">Delete</option>
					<option value="active">Activate</option>
					<option value="deactive">Deactivate</option>					
				 </select>
			  </div>
				 
				 <div class="floatleft mleft10"><div class="black_btn2"><span class="upper"><input type="submit" value="SUBMIT" name=""></span></div></div>
			   </div>                 </td>
		  </tr>
	</table>
	</form>
</div>
