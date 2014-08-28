				<tr>
					
					<td valign="middle"><strong class="upper">Users:</strong></td>
					<td>
						<?php
							echo $this->Form->input('checkall', array('type'=>'checkbox', 'id'=>'checkall', 'name'=>'checkall', 'div' => false, 'label' => false));
						?> <strong>Check All</strong>
						<div class="loadUser sharedUser">
							
							<div class="multipleUsers">
								<?php echo $this->Form->input('AdminClientMarketingEmail.users', array(
																	'type'=>'select', 'class' => 'multipleUser',
																	'style' => "width: 450px;", 'div'=>false,
																	'options'=>$emails,
																	'label' => false,
																	'multiple'=>'checkbox'
																)
													);
								?>
							</div>
							<style>
							.loadUser
							{
							<?php if(count($emails)>5){ ?>
								height: 125px !important;
							<?php } ?>
							}
							</style>
							
						</div>
						<label id="users_error_a" class="customize_error"></label>
					</td>					
					
			
					<td valign="middle"><strong class="upper">Imported Users:</strong></td>
					<td>
						<?php
							echo $this->Form->input('checkall_imported', array('type'=>'checkbox', 'id'=>'checkall_imported', 'name'=>'checkall_imported', 'label' => false, 'div' => false));
						?> <strong>Check All</strong>
						<div class="loadUser importedUser">
							
							<div class="multipleUsers">
								<?php echo $this->Form->input('AdminClientMarketingEmail.users_imported', array(
																	'type'=>'select', 'class' => 'multipleUser',
																	'style' => "width: 450px;", 'div'=>false,
																	'options'=>$imported_emails,
																	'label' => false,
																	'multiple'=>'checkbox'
																)
													);
								?>
							</div>
							<style>
							.loadUser
							{
							<?php if(count($imported_emails)>5){ ?>
								height: 125px !important;
							<?php } ?>
							}
							</style>
							
						</div>
						<label id="users_error_a" class="customize_error"></label>
					</td>
				</tr>
				
<script type="text/javascript">
$(document).ready(function(e){
	
	$('#checkall').click(function(event) {
			if(this.checked) {
				$('.sharedUser :checkbox').prop('checked', true);
			}
			if(!this.checked) {
				$('.sharedUser :checkbox').prop('checked', false);
			}
		});
		
		$('#checkall_imported').click(function(event) {
			if(this.checked) {
				$('.importedUser :checkbox').prop('checked', true);
			}
			if(!this.checked) {
				$('.importedUser :checkbox').prop('checked', false);
			}
		});
		
});	
</script>