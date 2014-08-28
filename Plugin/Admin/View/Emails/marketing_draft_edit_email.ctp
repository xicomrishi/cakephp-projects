<?php	
	echo $this->Html->css(array(
								'/admin/css/jquery-ui',
								'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/ui-lightness/jquery-ui.css',
								'developer', '/js/fancybox/source/jquery.fancybox.css?v=2.1.5'
							)
						);
	echo $this->Html->script(array(
									'/admin/js/additional-methods.min', '/admin/js/jquery-ui', '/admin/js/ckeditor/ckeditor'								
								)
							);			
?>

<?php /*
 <script type="text/javascript">
	$(document).ready(function(){
		//CKEDITOR.replace('textarea1', function(){alert('hi');});
		/*CKEDITOR.config.toolbar = [
									   ['Bold','Italic','Underline','SpellChecker','TextColor','BGColor','Undo','Redo','Link','Unlink','-','Format'],
									   '/',   ['NumberedList','BulletedList','JustifyLeft','JustifyCenter','JustifyRight','Font','FontSize'],
								  ] ;
	});
	
</script>*/ ?>
    <div class="overlay"></div>
    <div class="row">
		<div class="floatleft mtop10"><h1>Send Marketing Email</h1></div>
    </div>
    <div class="row mtop15">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
			<tr valign="top">
			  <td align="left" class="searchbox">	
				<div class="floatleft">
					<?php echo $this->Form->create('Search', array('url' => '/admin/emails/marketing_filter_email', 'type' => 'get', 'id'=>'search'));  ?>
						<table cellspacing="0" cellpadding="4" border="0">
							<tr valign="top">
								
								<td valign="middle" align="left" >
									<input type="text" id="from_date" class="input datepicker" value="<?php if(!empty($_GET['from_date'])) echo $_GET['from_date'] ?>" placeholder="Enter from date" style="width:300px;" name="from_date">
								</td>							
							
								<td valign="middle" align="left" >
									<input type="text" id="to_date" class="input datepicker" value="<?php if(!empty($_GET['to_date'])) echo $_GET['to_date'] ?>" placeholder="Enter to date" style="width:300px;" name="to_date">
								</td>
					
							
								<td valign="middle" align="left" >
									<select class="select" name="share_type" style="width:300px;">
										<option value="">Select social Media</option>
										<option value="facebook">Facebook</option>
										<option value="twitter">Twitter</option>
									</select>
								</td>
								<td valign="middle" align="left" >
									<select class="select" name="imported_share_type" style="width:300px;">
										<option value="">Select social Media for imported users</option>
										<option value="csv">CSV</option>
										<option value="google">Gmail</option>
										<option value="yahoo">Yahoo</option>
									</select>
								</td>
								<td valign="middle" align="left">
									<div class="black_btn2">
										<span class="upper">
											<input type="submit" value="Search User" id="searchSubmit">											
										</span>										
									</div>									
								</td>
								<td valign="middle" align="left">
									<div class="search_loader" style="display:none;"><?php echo $this->Html->image('ajax-loader.gif'); ?></div>
								</td>
							</tr>
						</table>
					</form>
				</div>		
				<div class="floatright top5">
					<?php //echo $this->Html->link('<span>Manage Deals</span>', array('controller' => 'users', 'action' => 'deal_report', 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false)); ?>
				</div>
			  </td>
		  </tr>
		</table>
	</div> 
	
	<div align="center" class="greybox mtop15">
	
			<table class="allUsers" cellspacing="0" cellpadding="7" border="0" align="center">
				<tr>
					<td valign="middle"><strong class="upper">App Contacts:</strong></td>
					<td>
						<?php 						
							echo $this->Form->input('checkall', array('type'=>'checkbox',  'label' => 'Check All','id'=>'checkall', 'name'=>'checkall'));
						?> 
						<div class="loadUser sharedUser">						
							<?php //foreach($emails as $key=>$email) { ?>
							<div class="multipleUsers musers">
								<?php echo $this->Form->input('users', array(
																	'type'=>'select', 'class' => 'multipleUser',
																	'style' => "width: 450px;", 'div'=>false, 
																	'options'=>$emails, 
																	'multiple'=>'checkbox',
																	'label' => false,
																	'selected'=>$selected['users']															
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
							<?php //} ?>
						</div>
						<label id="users_error_a" class="customize_error"></label>
					</td>
					
					<td valign="middle"><strong class="upper">Imported Contacts:</strong></td>
					<td>
						<?php if(!empty($imported_emails)){ ?>
						<?php 						
							echo $this->Form->input('checkall_imported', array('type'=>'checkbox', 'label' => 'Check All','id'=>'checkall_imported', 'name'=>'checkall_imported'));
						?> 
						<div class="loadUser importedUser">						
							
							<div class="multipleUsers musers">
								<?php 
								
								echo $this->Form->input('users_imported', array(
																	'type'=>'select', 'class' => 'multipleUser',
																	'style' => "width: 450px;", 'div'=>false, 
																	'options'=>$imported_emails, 
																	'multiple'=>'checkbox',
																	'label' => false,
																	'selected'=>$selected['imported_users']															
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
						<?php } ?>
					</td>
				</tr>
			</table>
			<?php echo $this->Form->create('AdminClientMarketingEmail', array('url' => array('controller'=>'emails','action'=>'marketing_draft_edit_email'), 'class' => 'aa', 'type'=>'file', 'id' => 'marketing_email', 'inputDefaults' => array('label' => false, 'div' => false, 'error' => false))) ?>
			<?php 						
				echo $this->Form->input('type', array('type'=>'hidden', 'id'=>'requestType'));
				echo $this->Form->input('id', array('type'=>'hidden', ));
				echo $this->Form->input('checkboxes', array('type' => 'hidden', 'id' => 'checkboxes'));
				echo $this->Form->input('checkboxes_imported', array('type' => 'hidden', 'id' => 'checkboxes_imported'));
			?>
				<input type="hidden" id="is_checked" value="1">
			<table cellspacing="0" cellpadding="7" border="0" align="center">
				<tr>
					<td valign="middle"><strong class="upper">Subject:</strong></td>
					<td><?php echo $this->Form->input('subject', array('type'=>'text', 'class' => 'input required formfield', 'style' => "width: 450px;",'label'=>false,'div'=>false,'required'=>'required')); ?></td>
				</tr>
				<tr>
					<td valign="middle"><strong class="upper">From Name</strong></td>
					<td><?php echo $this->Form->input('from_name', array('type'=>'text', 'class' => 'input required formfield', 'style' => "width: 450px;",'label'=>false,'div'=>false,'required'=>'required')); ?></td>
				</tr>
				<tr>
					<td valign="middle"><strong class="upper">From Email:</strong></td>
					<td><?php echo $this->Form->input('from_email', array('type'=>'text', 'class' => 'input formfield', 'style' => "width: 450px;",'label'=>false,'div'=>false,'required'=>'required')); ?></td>
				</tr>
				<tr>
					<td valign="middle"><strong class="upper">Reply To:</strong></td>
					<td><?php echo $this->Form->input('reply_to', array('type'=>'text', 'class' => 'input formfield', 'style' => "width: 450px;",'label'=>false,'div'=>false,'required'=>'required')); ?></td>
				</tr>
				
				<tr>
					<td valign="middle"><strong class="upper">Attachment:</strong></td>
					<td><?php echo $this->Form->input('file', array('type'=>'file', 'class' => 'input', 'style' => "width: 450px;",'label'=>false,'div'=>false,'required'=>false)); ?>
					<?php if(!empty($this->data['AdminClientMarketingEmail']['attachment']) && file_exists(EMAILATTACHMENT.$this->data['AdminClientMarketingEmail']['attachment'])) { ?>
						
							<?php echo $this->Html->link(EMAILATTACHMENTURL.$this->data['AdminClientMarketingEmail']['attachment']); ?>
						
					<?php } ?></td>
				</tr>
				<tr>
					<td valign="middle"><strong class="upper">Content:</strong></td>
					<td>
						<?php echo $this->Form->input('content', array('class' => 'input ckeditor formfield', 'style' => "width: 450px;", 'rows' => '10','label'=>false,'div'=>false)); ?>						 
					</td>
					<td>
					<strong>Key use in template:</strong>
					<?php 
						$keysforemail = $this->Common->getMarketingEmailVariable();
						foreach($keysforemail as $key) 
						{
							echo '<p>'.$key.'</p>';
						}
					?>
					</td>
				</tr>
				<tr id="schedulePopUpContainer" style="display:none">					
					<td valign="middle">
						<span class="fancybox-close" id="schedulePopUpContainerClose"></span>
						<table cellspacing="0" border="0" align="center">
						   <tr>
							   <td valign="middle" width="150"><strong class="upper">Schedule Date:</strong></td>
							   <td>			
									<?php echo $this->Form->input('schedule_date', array('type'=>'text', 'class' => 'input required  scheduleField', 'disabled'=>true, 'style' => "width: 91%;",'label'=>false,'div'=>false,'required'=>'required', 'readonly'=>true,'id'=>'updateDate')); ?>									
								</td>	
							</tr>
							<tr>
							   <td valign="middle"><strong class="upper">Schedule Time:</strong></td>
							   <td>
									<?php for($i = 1;$i<=12;$i++) { $time[$i] = $i.':00'; } ?>
									<?php echo $this->Form->input('schedule_time', array('type'=>'select', 'options'=>$time, 'disabled'=>true, 'class' => 'input required scheduleField', 'style' => "width: 50%;",'label'=>false,'div'=>false,'required'=>'required', 'id'=>'')); ?>
									
									<?php $time = array('AM'=>'AM', 'PM'=>'PM') ; ?>
									<?php echo $this->Form->input('schedule_time_type', array('type'=>'select', 'options'=>$time, 'disabled'=>true, 'class' => 'input required scheduleField', 'label'=>false,'div'=>false,'required'=>'required', 'id'=>'')); ?>									
								
								</td>
							</tr>
						   <tr>
							   <td valign="middle" width="150"><strong class="upper">Repeat Monthly:</strong></td>
							   <td>			
									<?php echo $this->Form->checkbox('is_repeat', array('class' => 'input scheduleField', 'disabled'=>true, 'style' => "width: 91%;",'label'=>false,'div'=>false)); ?>
								</td>	
							</tr>
							<tr>
								<td>&nbsp;</td>
							   <td>
									<div class="black_btn2">
										<span class="upper"><input type="button" value="Save" class="action" id="schedule"></span>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
                	<td>&nbsp;</td>
					<td valign="middle" align="left">
						<div class="black_btn2">
							<span class="upper"><input type="button" value="Send Now"  class="action" id="send"></span>
						</div>
						<div class="black_btn2">
							<span class="upper"><input type="button" value="Save with new changes" class="action" id="draft"></span>
						</div>		
						<div class="black_btn2">
							<span class="upper"><input type="button" value="Schedule to be sent later"  class="action" id="schedulePopUopButton"></span>
						</div>
										
					</td>
				</tr>
				
			</table>			
		<?php echo $this->Form->end()?>
	</div>

<script type="text/javascript">
	$(document).ready(function (){
		
		$('#send').click(function(){
			$(".overlay").fadeIn();
		});
		
		$("#from_date").datepicker({
			dateFormat: 'yy-mm-dd',
			maxDate : 0,
			onClose: function( selectedDate ) {
					$( "#to_date" ).datepicker( "option", "minDate", selectedDate );
				}
		});
		$("#to_date").datepicker({
			dateFormat: 'yy-mm-dd',
			maxDate : 0,
			onClose: function( selectedDate ) {
					$( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
				}
		});
		$("#updateDate").datepicker({
			dateFormat: 'yy-mm-dd',
			minDate : 0
		});
		// Search users with ajax 
		$("#searchSubmit").click(function(){
			$(".search_loader").show();
			$.ajax({
				url:SITE_URL+'admin/emails/marketing_filter_email',
				type:'GET',
				data : $("#search").serialize(),
				success: function(resp){
					$(".search_loader").hide();
					$(".allUsers").html(resp);
				}
			});
			return false;
		});
		
	var boxes = {};
	var  boxes_imported  = {};			
		// Form submit with send , schedule and draft option		
		$(".action").click(function(){
			var formValid = $(".formfield").valid();		
			var action = $(this).attr("id");
			
			var flag = 1;
			
			if($('#is_checked').val() == 0)
			{
				flag = 0;
			}
			
			if(action == 'send') {
							
				$(".scheduleField").attr("disabled", true);
				$("#requestType").val('send');
			} 
			else if (action == 'draft') 
			{
							
				$(".scheduleField").attr("disabled", true);
				$("#requestType").val('draft');
			}
			else if (action == 'schedule') 
			{
				$("#requestType").val('schedule');				
			}
			else if (action == 'schedulePopUopButton') 
			{	
				$(".scheduleField").attr("disabled", false);
				$(".overlay").fadeIn(0);
				$("#schedulePopUpContainer").show();
				return false;				
			}
			
		
			if(formValid !== false)
			{		
				if(flag == 1)
				{
					$('.sharedUser :checkbox').each(function(){

			            if($(this).prop('checked')){
			                boxes[$(this).prop('value')] = '1';
			               
			            }
			        });
			        $('#checkboxes').val(JSON.stringify(boxes));
				
					 $('.importedUser :checkbox').each(function(){

			            if($(this).prop('checked')){
			                boxes_imported[$(this).prop('value')] = '1';
			                
			            }
			        });
			        $('#checkboxes_imported').val(JSON.stringify(boxes_imported));
			        
			       $('form').submit();
			        
				}else{
					alert('Please select atleast 1 user.');
				}
			}
			
		});
		// hide schedule popup
		$("#schedulePopUpContainerClose, .overlay").click(function(){
			$(".overlay, #schedulePopUpContainer ").fadeOut();			
		});
				
		$("#marketing_email").validate({
			rules : {
				"data[AdminClientMarketingEmail][users][]" : {
					//required : true,
					
				},
				"data[AdminClientMarketingEmail][from_email]" : {
					required : true,
					email : true
				},
				"data[AdminClientMarketingEmail][reply_to]" : {
					required : true,
					email : true
				}
			},
			errorPlacement : function(error, element) {
				if($(element).parent().hasClass('multipleUser')) {
					error.insertAfter(".loadUser");
				}
				else {
					error.insertAfter(element);
				}
			}
		});
	});
	
	
	function update_is_checked()
	{
		var flg = 0;
		$('input:checkbox').each(function(e){
			if($(this).is(':checked'))
			{
				flg = 1;
				return;
			}
		});
		
		if(flg == 1)
		{
			$('#is_checked').val(1);
		}else{
			$('#is_checked').val(0);
		}
		//console.log(123);
	}
</script>
<style>
.loadUser
{
    overflow-y: scroll;
	max-width:464px;
}
.multipleUsers
{
	width:100%;
	float:left;
}
#fanc
{
	width:500px;
}
</style>
<script>
(function($){
	$(document).ready(function(){
		
		$('.musers :checkbox').bind('click',update_is_checked);
		
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
})(jQuery);
</script>
