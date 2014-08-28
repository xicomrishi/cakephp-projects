
    <div class="row">
		<div class="floatleft mtop10"><h1>Forget Password</h1></div>
    </div>

	  <?php echo $this->Session->flash(); ?>

	<div align="center" class="greybox mtop15">
		<form name="frm_addedit" id="frm_addedit" action="" method="post" enctype="multipart/form-data">
			
			<table cellspacing="0" cellpadding="7" border="0" align="center">
				<tr>
					<td valign="middle"><strong class="upper">Username:</strong></td>
					<td><?php echo $this->Form->input('Admin.username', array('class' => 'input required', 'style' => "width: 450px;", 'label' => false,
																					 'div' => false, 'error' => false, 'value' => '', 'type' => 'text')); ?></td>
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
					'data[Admin][username]': {
						required: true,
						minlength: 4
					}
				},
				messages:{
					'data[Admin][username]': {
						required: "This field is required."
						
					}
				},
				errorElement: 'div'
			});
		});	
	
</script>
	
