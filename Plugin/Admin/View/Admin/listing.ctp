 <h1>Manage Products</h1>
<div class="row mtop15">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr valign="top">
		  <td align="left" class="searchbox">
			<div class="floatleft">
				  <table cellspacing="0" cellpadding="4" border="0">
				  <tr valign="top">
					  <td valign="middle" align="left" ><input type="text" class="input" value="Enter Keyword" onblur="if(this.value == '') this.value = 'Enter Keyword'" onfocus="if(this.value == 'Enter Keyword') this.value = ''" style="width:300px;"></td>
					  <td valign="middle" align="left" ><select class="select" name="Search_Option" style="width:300px;">
						  <option value="Name">By Name</option>
						  <option value="Product_Code">By Product Code</option>
						</select></td>
					  <td valign="middle" align="left"><div class="black_btn2"><span class="upper"><input type="submit" value="Search Products" name=""></span></div></td>
					</tr>
				</table>
			</div>
			
			<div class="floatright top5"><a href="add-form.php" class="black_btn"><span>Add New Product</span></a> <a href="#" class="black_btn mleft5"><span>Manage Products</span></a></div>
			
		  </td>
	  </tr>
	</table>
</div>
    

<div class="row mtop30">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
		  <tr>
			<th width="4%" align="center">S No.</th>
			<th width="38%" align="left">Name</th>
			<th width="30%" align="left">Title</th>
			<th width="9%" align="left">Created On</th>
			<th width="8%" align="center">Status</th>
			<th width="6%" align="center">Action</th>
			<th width="5%" align="center"><input type="checkbox" onclick="checkall(this.form)" value="check_all" id="check_all" name="check_all"></th>
	  </tr>
		  <tr>
			<td align="center">1.</td>
			<td align="left"><span class="blue">Second Home Bonanza, Just Make Sure You've Got Cash</span></td>
			<td align="left">New Construction &amp; Resale Outlook</td>
			<td align="left">08, Apr 2011</td>
			<td align="center">Active</td>
			<td align="center" valign="middle" >&nbsp;<a href="#"><img border="0" src="images/edit_icon.gif"></a></td>
			<td valign="middle" align="center"><input type="checkbox" value="1" name="delIDs[]"></td>
		  </tr>
		  <tr>
			<td align="center">2.</td>
			<td align="left"><span class="blue">For 12th Straight Quarter, New Housing Starts Decline, Set New Low</span></td>
			<td align="left">New Construction &amp; Resale Outlook</td>
			<td align="left">08, Apr 2011</td>
			<td align="center">Active</td>
			<td align="center" valign="middle">&nbsp;<a href="#"><img border="0" src="images/edit_icon.gif"></a></td>
			<td valign="middle" align="center"><input type="checkbox" value="5" name="delIDs[]"></td>
		  </tr>
		  <tr>
			<td align="center">3.</td>
			<td align="left"><span class="blue">Second Home Bonanza, Just Make Sure You've Got Cash</span></td>
			<td align="left">New Construction &amp; Resale Outlook</td>
			<td align="left">08, Apr 2011</td>
			<td align="center">Active</td>
			<td align="center" valign="middle" >&nbsp;<a href="#"><img border="0" src="images/edit_icon.gif" /></a></td>
			<td valign="middle" align="center"><input type="checkbox" value="1" name="delIDs[]2" /></td>
		  </tr>
		  <tr>
			<td align="center">4.</td>
			<td align="left"><span class="blue">For 12th Straight Quarter, New Housing Starts Decline, Set New Low</span></td>
			<td align="left">New Construction &amp; Resale Outlook</td>
			<td align="left">08, Apr 2011</td>
			<td align="center">Active</td>
			<td align="center" valign="middle" >&nbsp;<a href="#"><img border="0" src="images/edit_icon.gif" /></a></td>
			<td valign="middle" align="center"><input type="checkbox" value="5" name="delIDs[]2" /></td>
		  </tr>
		  <tr align="right">
			<td colspan="7" align="left" class="bordernone">
			<div class="floatleft mtop7">
			<div class="pagination"><a href="#">Previous</a><span class="current">1</span><a href=" ?page=2">2</a><a href=" ?page=3">3</a><a href=" ?page=4">4</a><a href="#">Next</a></div>
			</div>
			
			<div class="floatright">
				<div class="floatleft">
				<select name=""  class="select">
					<option value="">Select Option</option>
					<option value="Delete">Delete</option>
					<option value="Activate">Activate</option>
					<option value="Deactivate">Deactivate</option>
					<option value="FeatureProduct">Featured Product</option>
					<option value="NotFeatured">Not Featured</option>
				 </select>
			  </div>
				 
				 <div class="floatleft mleft10"><div class="black_btn2"><span class="upper"><input type="submit" value="SUBMIT" name=""></span></div></div>
			   </div>                 </td>
		  </tr>
	</table>
</div>