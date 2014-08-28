
    <div class="row">
		<div class="floatleft mtop10"><h1>Change Password</h1></div>
    </div>

	  <?php echo $this->Session->flash('auth'); ?>

	<div align="center" class="greybox mtop15">
		<form name="frm_addedit" id="frm_addedit" action="" method="post" enctype="multipart/form-data">
			<?php echo $this->Form->input('User.id', array('type'=>'hidden')); ?>
			<table cellspacing="0" cellpadding="7" border="0" align="center">
				<tr>
					<td valign="middle"><strong class="upper">Old Password:</strong></td>
					<td><?php echo $this->Form->input('Admin.old_password', array('class' => 'input required', 'style' => "width: 450px;", 'label' => false,
																					 'div' => false, 'error' => false, 'value' => '', 'type' => 'password')); ?></td>
				</tr>
				<tr>
					<td valign="middle"><strong class="upper">New Password:</strong></td>
					<td><?php echo $this->Form->input('Admin.password', array('class' => 'input required', 'style' => "width: 450px;", 'label' => false, 'div' => false, 
																				'error' => false, 'value' => '', 'type' => 'password')); ?></td>
				</tr>
				<tr>
					<td valign="middle"><strong class="upper">Confirm New Password:</strong></td>
					<td><?php echo $this->Form->input('Admin.compare_password', array('class' => 'input required', 'style' => "width: 450px;", 'label' => false,
																					 'div' => false, 'error' => false, 'value' => '', 'type' => 'password')); ?></td>
				</tr>
				<tr>
                	<td>&nbsp;</td>
					<td>
						<div class="floatleft">
							<input type="submit" class="submit_btn" value="">
						</div>
						<div class="floatleft" id="domain_loader" style="padding-left:5px;"></div>
					</td>
				</tr>
			</table>
		</form>
	</div>
	
<script type="text/javascript">
$(document).ready(function(){
			$("#frm_addedit").validate({
				rules:{
					'data[Admin][password]': {
						required: true,
						minlength: 4
					},
					'data[Admin][compare_password]': {
						required: true,
						minlength: 4,
						equalTo: "#AdminPassword"
					}
				},
				messages:{
					'data[Admin][password]': {
						required: "This field is required.",
						minlength: "Your password must be at least 4 characters long"
					},
					'data[Admin][compare_password]': {
						required: "Please confirm password",
						minlength: "Your password must be at least 4 characters long",
						equalTo: "Please enter the same password as above"
					}
				},
				errorElement: 'div'
			});
		});	
	
</script>
	
