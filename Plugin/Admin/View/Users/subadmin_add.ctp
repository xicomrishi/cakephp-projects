 <style>
			body {
				font-family:	'Segoe UI', Verdana, Arial, Helvetica, sans-serif;
				font-size:		62.5%;
			}
        </style>
<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Admin Add Sub-admin User'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage User').'</span>', array('controller' => 'users','action' => 'subadmin_index','plugin' => 'admin'),array( 'class'=>'black_btn','escape'=>false));?>
	</div>
	<div class="errorMsg">
	<?php
		if (isset($invalidfields)) {
			echo " <p class='top15 gray12'><table>
				<tr><th>Fields</th><th>Error</th><tr>";
			foreach ($invalidfields as $key => $field) {
				echo "<tr><td>" . $key . "</td><td>";
				echo "<ul>";
				foreach ($field as $error) {
					echo "<li>" . $error . "</li>";
				}
				echo "</ul></td></tr>";
			}
			echo "</table>  </p>";
		}
		?>
	</div>
</div>

<div align="center" class="whitebox mtop15">
   <?php 
			echo $this->Form->create('Admin', array(
									'type'=>'file',
									'url'=>array('controller'=>'users', 'action'=>'subadmin_add'),
									'class'=>'validate',
									'inputDefaults'=>array('div'=>false, 'label'=>false)									
								)
							);
	?>
	    <table cellspacing="0" cellpadding="7" border="0" align="center">
	
			<?php
			echo $this->Form->input('id',array('type' => 'hidden'));
			?>
			
			<tr>
				<td align="left">					
					<strong class="upper">First Name</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('first_name', array(
													'type' => 'text', 
													'class' => 'input check toolTip', 												
													'id' => 'first_name',
													'style'=>'width: 450px;',													
												)
											);
					?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Last Name</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('last_name', array(
													'type' => 'text', 
													'class' => 'input check', 												
													'id' => 'last_name',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Username</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('username', array(
													'type' => 'text', 
													'class' => 'input check_username', 												
													'id' => 'username',
													'style'=>'width: 450px;'
												)
											);
					?>
				
				</td>
				<td>
					<?php 
							echo $this->Form->input('Suggestion', array(
													'type' => 'button',													 												
													'id' => 'username_suggestion',
													'disabled'=>true
													
												)
											);
					?>					
				</td>
				<td class="username_loader"></td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Email</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('email', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'email',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td class="email_loader"></td>
			</tr>		
			
			
			<tr>
				<td align="left"></td>
				<td align="left">
					<div class="black_btn2">
						<span class="upper"><?php echo $this->Form->submit(__('Submit'));?></span>
					</div>
				</td>
			</tr>
	    </table>
    <?php echo $this->Form->end();?>
</div>
<script type="text/javascript">
	$(document).ready(function (){
		
		$(".check").on('focusout', function(){
			var first_name = $.trim($("#first_name").val());
			var last_name =$.trim($("#last_name").val());
			if(first_name.length > 1  && last_name.length > 1) {
				$("#username_suggestion").attr('disabled', false);
			}
			else{
				$("#username_suggestion").attr('disabled', true);
			}
		});
		
		$("#username_suggestion").on("click", function(){
			var first_name = $.trim($("#first_name").val());
			var last_name =$.trim($("#last_name").val());
			
			$.ajax({
				url: SITE_URL+'admin/users/suggest_username',
				type: "GET",
				data: {'f_name': first_name, l_name: last_name},
				beforeSend : function(){
					loader('username_loader');
				},
				complete : function (){
					$(".username_loader").html('');
					$("#website_url_suggestion").attr('disabled', false);
					$("#tablet_url_suggestion").attr('disabled', false);
				},
				success: function(html){
					var encoded_html = $.parseJSON(html);
					if(encoded_html.status == 'ok')
					{
						$('#username').val(encoded_html.data);
					}
					else
					{
						alert(encoded_html.data);
					}
				},
				error : function(resp) {
					ajax_error(resp);
				}
				
			});
			return false;
		});
		
		$('.validate').validate({
			ignore: '',
			onkeyup : false,
			rules : {
				"data[Admin][first_name]" : {
					required : true,
					minlength : 2,
					maxlength : 70,
					lettersOnly : true
				},
				"data[Admin][last_name]" : {
					required : true,
					minlength : 2,
					maxlength : 70,
					lettersOnly : true
				},
				"data[Admin][username]" : {
					required : true,
					minlength : 2,					
					maxlength : 140,
					userName : true,
					remote: {
				        url: SITE_URL+'admin/users/check_username',
				        type: "get",
				        data: {
				          search_string: function() {
				            return $( "#username" ).val();
				          },
				          type : 'username'
			        	},
			        	beforeSend : function(){
							loader('username');
						},
						complete : function(){
							$(".username").html('');
						}
			      	}
				},
				"data[Admin][email]" : {
					required : true,
					email : true,
					maxlength : 255
					
				},
				"data[Admin][password]" : {
					required : true,
					minlength : 6,
					maxlength : 100
				}				
			},
			messages: { 
	            
				"data[Admin][username]": {						       
					remote: jQuery.format("{0} is already in use")
				}
				
		    },
		    errorElement: 'div',
		     errorPlacement: function(error, element) {
				
					error.insertAfter(element);
				
			}			

		});
		
		
		
		
	});	

		
</script>
