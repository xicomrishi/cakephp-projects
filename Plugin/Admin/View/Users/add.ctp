
<?php
	
	echo $this->Html->css(array('/admin/css/jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/ui-lightness/jquery-ui.css',
								'/admin/js/colorpicker/jquery.colorpicker.css', 'developer','jquery.fancybox'
								)
							);
	echo $this->Html->script(array('/admin/js/additional-methods.min', '/admin/js/jquery-ui', '/admin/js/ckeditor/ckeditor',
			'/admin/js/colorpicker/jquery.colorpicker.js', '/admin/js/colorpicker/i18n/jquery.ui.colorpicker-nl.js',
			'/admin/js/colorpicker/swatches/jquery.ui.colorpicker-pantone.js', '/admin/js/colorpicker/parts/jquery.ui.colorpicker-rgbslider.js',
			'/admin/js/colorpicker/parts/jquery.ui.colorpicker-memory.js', '/admin/js/colorpicker/parsers/jquery.ui.colorpicker-cmyk-parser.js',
			'/admin/js/colorpicker/parsers/jquery.ui.colorpicker-cmyk-percentage-parser.js', 
			'https://maps.google.com/maps/api/js?libraries=places&language=en&sensor=true',
			'fancybox/source/jquery.fancybox'
		)
	);		
?>

<script type="text/javascript">
	$(document).ready(function(){
		//CKEDITOR.replace('textarea1', function(){alert('hi');});
		CKEDITOR.config.toolbar = [
									   ['Bold','Italic','Underline','SpellChecker','TextColor','BGColor','Undo','Redo','Link','Unlink','-','Format'],
									   '/',   ['NumberedList','BulletedList','JustifyLeft','JustifyCenter','JustifyRight','Font','FontSize'],
								  ] ;
	});
	
</script>
 <style>

body {
	font-family:	'Segoe UI', Verdana, Arial, Helvetica, sans-serif;
	font-size:		62.5%;
}
	
.black_btn2 .links_a {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 0 none;
    color: #FFFFFF !important;
    cursor: pointer;
    font-family: Arial,Tahoma,Helvetica,sans-serif11px !important;
    font-size: 11px !important;
    font-weight: bold !important;
    margin: 0;
    outline: medium none;
    padding: 0;
    text-shadow: 0 -1px #17181D !important;
    text-transform: uppercase;
   }
.error, .error-message{ float: none;}
</style>

<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Admin Add User'); ?></h1></div>
    <div class="floatright">
        <?php
        if(!$subadmin_user){         
			echo $this->Html->link('<span>'.__('Back To Manage User').'</span>', array('controller' => 'users','action' => 'index','plugin' => 'admin'),array( 'class'=>'black_btn','escape'=>false));
		}
		?>
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
									'url'=>array('controller'=>'users', 'action'=>'add'),
									'class'=>'validate',
									'inputDefaults'=>array('div'=>false, 'label'=>false)									
								)
							);
			
			if(isset($subadmin_user)){
				echo $this->Form->input('subadmin_id', array('type' => 'hidden', 'value' => $subadmin_user));
			}				
							
	?>
	    <table cellspacing="0" cellpadding="7" border="0" align="center">
	
			<?php
			echo $this->Form->input('id',array('type' => 'hidden'));
			?>
			<?php echo $this->Form->input('latitude',array('type' => 'hidden', 'class' => "MapLat"));?>
			<?php echo $this->Form->input('longitude',array('type' => 'hidden', 'class' => "MapLon"));?>
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
			<?php if(!isset($page)) { ?>
			<tr>
				<td align="left">					
					<strong class="upper">Password</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('password', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'password',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td align="left">					
					<strong class="upper">Company Name</strong>
					<span class="required_val">*</span>
					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('company', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'company_name',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'Your Business\'s name'
												)
											);
					?>
				</td>
			</tr>
			
				<tr>
				<td align="left">					
					<strong class="upper">Company Logo</strong>		
					<span class="required_val">*</span>			
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('Admin.company_logo', array(
													'type' => 'file', 
													'class' => 'input ', 												
													'id' => 'company_logo',
													'style'=>'width: 450px;'
												)
											);
					?> <br/>
					<label>Image should not be less than 50x50 size<br>Image size should not be more than 500kb.</label>
					<label for="company_logo" class="error company_logo_error"></label>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'Your Company logo is recommended. This image will be shown on tablet'
												)
											);
					?>
				</td>		
				
			</tr>
			<tr>
				<td align="left"><strong class="upper">Business Phone</strong></td>
				<td align="left">	
					<?php 
							echo $this->Form->input('mobile', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'mobile',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
			</tr>
			
				
						
			
				
			<tr>
				<td align="left">					
					<strong class="upper">App URL</strong>
					<span class="required_val">*</span>
					
				</td>
				<td align="left">	
					<span class="tablet_url_text">
						<?php 
								echo $this->Form->input('tablet_url', array(
														'type' => 'text', 
														'class' => 'input', 												
														'id' => 'tablet_url',
														
														'style'=>'width: 450px;',
													'onBlur' => 'generate_tablet_url(this.value);'
													)
												);
						?>
					</span>
					<?php 
									echo $this->Form->input('website_url', array(
															'type' => 'hidden', 
															'class' => 'input', 												
															'id' => 'website_url'
															
															
														)
													);
							?>
					<span class="tablet_url" style="width:50%; float:left;">
					
					</span>
				</td>
				<td>
					<?php 
							echo $this->Form->input('Suggestion', array(
													'type' => 'button',													 												
													'id' => 'tablet_url_suggestion',
													'disabled'=>true
													
												)
											);
					?>				
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This is the url that the people will go to share your deal on the web. This is based on your company name.'
												)
											);
					?>
				</td>	
				<td class="tablet_loader"></td>
			</tr>
		
			<tr>
				<td align="left">					
					<strong class="upper">Facebook (Page name)</strong>
					<span class="required_val">*</span>				
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('facebook_url', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'facebook_url',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'Please just use the part the part that comes after the slash. Example : facebook.com/YOUR_PAGE_NAME. You would use YOUR_PAGE_NAME'
												)
											);
					?>
				</td>			
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Facebook (Page Id)</strong>
					<span class="required_val">*</span>				
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('fb_fanpage_id', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'fb_fanpage_id',
													'style'=>'width: 450px;'
												)
											);
					?>
					<div>(Enter 0 if you do not want app to post to facebook page)</div>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'If you do not know your Facebook Page ID please go to https://findmyfacebookid.com'
												)
											);
					?>
				</td>				
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Twitter (Screenname)</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('twitter_url', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'twitter_url',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'Please just use the part the part that comes after the slash. Example : twitter.com/YOUR_SCREEN_NAME. You would use YOUR_SCREEN_NAME'
												)
											);
					?>
				</td>			
			</tr>
		
			<tr>
				<td align="left"><strong class="upper">Status</strong></td>
				<td align="left">	
					<?php
							echo $this->Form->input('status',array(
													'type'=>'select',
													'class' => 'input',
													'style'=>'width: 450px;',
													'options' => array('active' => 'Active', 'inactive' => 'Inactive')
										)
									);
					?>
				</td>
			</tr>		
			
			<tr>
				<td align="left"></td>
				<td align="left">
					<div class="black_btn2">
						<span class="upper"><?php echo $this->Form->submit(__('Submit'));?></span>
					</div>
					<!--<div class="black_btn2">
						<span class="upper">
						<a href="javascript://" class="links_a" onclick="preview(0); return false;" id="preview">Preview Tablet</a>
						</span>
					</div>
					<div class="black_btn2">
						<span class="upper">
						<a href="javascript://" class="links_a" onclick="preview(1)" id="preview_website">Preview Website</a>
						</span>
					</div>-->	
				</td>
			</tr>
	    </table>
    <?php echo $this->Form->end();?>
</div>

<div id="texture_img" style="display:none; background:#999;"></div>

<script type="text/javascript">
function preview_texture(val)
{
	$('#texture_preview').html('<img src="<?php echo $this->webroot; ?>img/textures/texture_'+val+'.png" height="180" width="180"/>');
}

function view_texture()
{
	
	$('#texture_img').html($('#texture_preview').html());

	$('#texture_img').find('img').removeAttr('width');
	$('#texture_img').find('img').removeAttr('height');
	$.fancybox.open({
		type: 'inline',		
		href: '#texture_img'
	});


}
	$(document).ready(function (){
			
		var _URL = window.URL || window.webkitURL, FLAG = true;
				
		$("#company_logo").change(function (e) {
			var file, img;
			
			if ((file = this.files[0])) {
				img = new Image();
				img.onload = function () {
					
					FLAG = true;
					$(".company_logo_error").text('');					
				};
				img.src = _URL.createObjectURL(file);
			}
		});
		
		$(".datepicker").datepicker({
			dateFormat: 'yy-mm-dd'
		});
		$('#bg_color').colorpicker();
		$('#font_color').colorpicker();
		$('#bname_bgcolor').colorpicker();
		$('#color').colorpicker();
		$('.toolTip').tooltip({		
			track : true
		});
		
		$.validator.addMethod('checkType', function(a,b){
			var type = $("#type").val();
			if((type == 1 || type == 2) && ( a != '' && !$.isNumeric(a)))
			{
				return false;
			}
			else{
				return true;
			}
		},'Only numeric values are allowed');
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
					/*remote: {
				        url: SITE_URL+'admin/users/check_username',
				        type: "get",
				        data: {
				          search_string: function() {
				            return $( "#email" ).val();
				          },
				          type : 'email'
			        	},
			        	beforeSend : function(){
							loader('email');
						},
						complete : function(){
							$(".email").html('');
						}
			      	}*/
				},				
				"data[Admin][company_logo]" : {	
					required : true,								
					extension : "jpe?g|png"
				},
				"data[Admin][password]" : {
					required : true,
					minlength : 6,
					maxlength : 100
				},
											
				"data[Admin][tablet_url]" : {								
					maxlength : 100,
					remote: {
				        url: SITE_URL+'admin/users/check_username',
				        type: "get",
				        data: {
				          search_string: function() {
				            return $( "#tablet_url" ).val();
				          },
				          type : 'tablet_url'
			        	},
			        	beforeSend : function(){
							loader('tablet_loader');
						},
						complete : function(){
							$(".tablet_loader").html('');
						}
			      	}
				},
				"data[Admin][website_url]" : {
									
					maxlength : 100,
					remote: {
				        url: SITE_URL+'admin/users/check_username',
				        type: "get",
				        data: {
				          search_string: function() {
				            return $( "#website_url" ).val();
				          },
				          type : 'website_url'
			        	},
			        	beforeSend : function(){
							loader('website_loader');
						},
						complete : function(){
							$(".website_loader").html('');
						}
			      	}
				},			
							
				"data[Admin][mobile]" : {					
					digits : true,
					minlength : 10,
					maxlength : 10
				},				
						
				"data[Admin][facebook_url]" : {
					required : true,
					maxlength : 150
				},				
				"data[Admin][fb_fanpage_id]" : {
					required : true,
					digits : true
				},				
				"data[Admin][twitter_url]" : {
					required : true,
					maxlength : 150
				}
			},
			messages: { 
	            
				"data[Admin][username]": {						       
					remote: jQuery.format("{0} is already in use")
				},
				"data[Admin][email]": {						       
					remote: jQuery.format("{0} is already in use")
				},
				"data[Admin][company]": {						       
					remote: jQuery.format("{0} is already in use")
				},
				
				"data[Admin][tablet_url]": {						       
					remote: jQuery.format("{0} is already in use")
				},
				"data[Admin][website_url]": {						       
					remote: jQuery.format("{0} is already in use")
				},
				"data[Admin][company_logo]" : {
					extension : "Only jpeg, jpg, png files allowed."
				}
						
				
		    },
		    errorElement: 'div',
		     errorPlacement: function(error, element) {
				if (element.hasClass("ckeditor")) {
				   $("#ckeditor-error").html(error);
				}				
				else { 
					error.insertAfter(element);
				}
			}
			

		});

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
		
		$("#type").on('change', function(){
			var value = $.trim($("#type").val());
			
			if(value == 3  || value == 4) {
				$("#deal_value_text").text('Product or Service');
				$("#deal_value_container").hide();
			}
			else{
				$("#deal_value_text").text('Deal Value');
				$("#deal_value_container").show();
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
		
		$(".check_username").on('focusout', function(){
			var username = $.trim($("#username").val());			
			if(username.length > 1) {				
				$("#website_url_suggestion").attr('disabled', false);
				$("#tablet_url_suggestion").attr('disabled', false);
			}
			else{
				$("#website_url_suggestion").attr('disabled', true);
				$("#tablet_url_suggestion").attr('disabled', true);
			}
			
		});
		$("#website_url_suggestion").on("click", function(){
			var username = $.trim($("#username").val());
			var website_url = SITE_URL+'w/'+username;
			$("#website_url").val(username);
			$(".website_url").html(username);
			return false;
		});
		$("#tablet_url_suggestion").on("click", function(){
			var username = $.trim($("#username").val());
			var tablet_url = SITE_URL+username;
			var website_url = SITE_URL+'w/'+username;
			$("#tablet_url").val(username);
				
			$('span.tablet_url').html('<strong>App URL : </strong>'+tablet_url+'<br><strong>Landing Page URL : </strong>'+website_url);
  		
			$('#website_url').val(username);
			return false;
		});
			
	});
	

function generate_tablet_url(value)
{
	value = value.replace(/\s+/g, '-').toLowerCase();
	var url = "<?php echo SITE_URL; ?>"+value;
	var website_url = "<?php echo SITE_URL; ?>w/"+value;
 $('span.tablet_url').html('<strong>App URL : </strong>'+url+'<br><strong>Landing Page URL : </strong>'+website_url);
  $('#website_url').val(value);
}

function generate_website_url(value)
{
	value = value.replace(/\s+/g, '-').toLowerCase();
	var url = "<?php echo SITE_URL; ?>w/"+value;
 $('span.website_url').html(url);
}


</script>
