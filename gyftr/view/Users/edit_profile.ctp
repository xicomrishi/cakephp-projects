<div id="form_section" style="margin:0 0 5px 0; padding:0 1%;">
		<?php //echo $this->element('breadcrumb');?>
		
            <span class="select_dele">/ / Edit <strong>Profile</strong>
            </span>
            <form id="profileForm" name="profileForm" method="post" onsubmit="return saveProfileForm();" action="">
			
            <div class="comn_box gift" style="padding-bottom:0px;">
            <!--<div class="main_heading"><span><strong>Recipient: </strong><?php echo $dat['order']['Order']['to_name']; ?></span></div>-->
            <div class="detail_row">
            <label>First Name:</label>
            <span class="detail"><input type="text" name="first_name" value="<?php echo $user['User']['first_name']; ?>" class="validate[required]"/></span>
            </div>        
            <div class="detail_row">
            <label>Last Name:</label>
            <span class="detail"><input type="text" name="last_name" value="<?php echo $user['User']['last_name']; ?>" class="validate[required]"/></span>
            </div>
            <div class="detail_row">
            <label>Email: </label>
          	 <span class="detail"><?php echo $user['User']['email']; ?></span>
            </div>
             <div class="detail_row">
            <label>Mobile No.: </label>
          	 <span class="detail"><input type="text" name="phone" maxlength="10" value="<?php echo $user['User']['phone']; ?>" class="validate[required,custom[integer],minSize[10],maxSize[10]]"/></span>
            </div>
             <div class="detail_row">
            <label>Date of Birth: </label>
          	 <span class="detail"><input type="text" id="dob" name="dob" value="<?php echo $user['User']['dob']; ?>" class="validate[required]" onclick="addClass('#ui-datepicker-div','dob');"/></span>
            </div>
            
             <div class="detail_row">
            <label>Gender: </label>
          	 <span class="detail"><select name="gender" style="color:#484848; font-size:14px;">
             <option value="0" <?php if($user['User']['gender']==0) echo 'selected';?> style="color:#484848; font-size:14px;">Male</option>
             <option value="1" <?php if($user['User']['gender']==1) echo 'selected';?> style="color:#484848; font-size:14px;">Female</option>
             </select></span>
            </div>
           
              <div class="detail_row">
            <label>Update Password: </label>
          	 <span class="detail"><input type="password" id="passwd" name="passwd" value="" class="validate[minSize[6]]"/></span>
            </div>
              <div class="detail_row">
            <label>Confirm Password: </label>
          	 <span class="detail"><input type="password" name="con_passwd" value="" class="validate[equals[passwd]]"/></span>
            </div>
        </div>
           <input type="submit" value="Submit" class="done"/>
            </form>
     </div>        
        
       </div>
<script type="text/javascript">
$(document).ready(function(e) {
    $("#profileForm").validationEngine({scroll:false,focusFirstField : false});
var to_day=new Date();
	 $('#dob').datepicker({	
		 yearRange: "-90:+0",	            
			dateFormat:"dd-mm-yy",
			 changeMonth: true,
			changeYear: true,
			
			maxDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate()),
			onSelect: function(dateText, inst) {
					//$('#delivery_date').val(dateText);
					$('.formError').remove();
					removeClass('#ui-datepicker-div','dob');
					//$(this).datetimepicker('hide');
				}
       });
});
</script>       
       