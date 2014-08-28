
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
		
		$('.toolTip').tooltip({		
			track : true
		});
		
		CKEDITOR.config.toolbar = [
									   ['Bold','Italic','Underline','SpellChecker','TextColor','BGColor','Undo','Redo','Link','Unlink','-','Format'],
									   '/',   ['NumberedList','BulletedList','JustifyLeft','JustifyCenter','JustifyRight','Font','FontSize'],
								  ] ;
	});
	
</script>
<style>
		
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
    <div class="floatleft mtop10"><h1><?php echo __('Edit User'); ?></h1></div>
    <div class="floatright">
        <?php
				if($this->Session->read('Auth.User.type') == 1) {
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
									'url'=>array('controller'=>'users', 'action'=>'edit'),
									'class'=>'validate',
									'inputDefaults'=>array('div'=>false, 'label'=>false)									
								)
							);
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
													'class' => 'input check', 												
													'id' => 'first_name',
													'style'=>'width: 450px;'
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
				</td>
				<td align="left">	
					<?php echo $this->data['Admin']['username']; ?>
				</td>
				
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Email</strong>					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('email', array(
													'type' => 'text', 
													'class' => 'input check', 												
													'id' => 'email',
													'style'=>'width: 450px;'
												)
											);
					?>
					
				</td>
			</tr>		
			<tr>
				<td align="left">					
					<strong class="upper">Company</strong>					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('company', array(
													'type' => 'text', 
													'class' => 'input check', 												
													'id' => 'company_name',
													'readonly' => 'readonly',
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
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('company_logo', array(
													'type' => 'file', 
													'class' => 'input check', 												
													'id' => 'company_logo',
													'style'=>'width: 450px;',
													'onchange' => 'readURL(this);'
												)
											);
					?>
					<div>Image should not be less than 50x50 size<br>Image size should not be more than 500kb.</div>
					<label for="company_logo" class="error company_logo_error"></label>
				</td>
				<td align="left">	
					
					<div id="company_logo_preview">
						<img id="logo_prev" src="<?php echo $this->webroot.'img/company/'.$this->request->data['Admin']['company_logo']; ?>" style="max-width:80px;" />
					</div>
					
				</td>
			</tr>
		
			<tr>
				
							
					<td align="left">					
					<strong class="upper">App URL</strong>
				</td>
				<td align="left">	
					<span>
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
					<span class="tablet_url" style="width:50%; float:left;">
					<?php echo '<strong>App URL : </strong>'.SITE_URL.$this->request->data['Admin']['tablet_url']; 
						  echo '<br><strong>Landing Page URL : </strong>'.SITE_URL.'w/'.$this->request->data['Admin']['tablet_url'];	
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
				</td>
				<td>
					<?php 
							echo $this->Form->input('Suggestion', array(
													'type' => 'button',													 												
													'id' => 'tablet_url_suggestion',
												)
											);
					?>					
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This is the url that the people will go to shareyour deal on the web. We recommend using your business\'s name for the url.'
												)
											);
					?>
				</td>	
				<td class="tablet_loader"></td>
				
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Social Media Feed</strong>
				</td>
				<td align="left">
					<div>
						<?php 
								echo $this->Form->input('feed_graber', array(
														'type' => 'textarea', 
														'class' => 'input', 												
														'id' => 'feed_graber',
														'style'=>'width: 450px;'
													)
												);
						?>
					</div>
					<div>
						<a href="https://socialeyes.ws/fsoc/index.php?route=users/login" target="_blank">https://socialeyes.ws/fsoc/index.php?route=users/login</a>
					</div>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'We recommend using your business\'s social media feed on your SOCIAL REFERRALS™ Landing Page. You can go to https://feedgrabbr.com and create your custom feed there. Then simply paste the code from feedgrabbr here. If you do not choose this option a map of your location will be placed there instead. See a sample SOCIAL REFERRALS™ page here.'
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
					<strong class="upper">Address</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('address', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'searchAddress',
													'style'=>'width: 450px;'
												)
											);
					?>					
				</td>				
			</tr>
			<tr>
				<td></td>
				<td><div id="map_canvas" style="height: 350px;width: 500px;margin: 0.6em;"></div></td>
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
				<td align="left">					
					<strong class="upper">Google+ Id</strong>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('google_url', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'google_url',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This is your Google plus business profile\'s id'
												)
											);
					?>
				</td>			
			</tr>
			<tr>
				<td>
					<h1>Customize Design</h1>
					
				</td>
				</tr>
				
					<tr>
				<td colspan="3">
					<h2>General</h2>
					<hr/>
				</td>
				</tr>
				
				<tr>
				<td align="left">					
					<strong class="upper">Background Color</strong>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('bg_color', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'bg_color',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This color will be used for the background of your SOCIAL REFERRALS™ Landing Page as well as your app.'
												)
											);
					?>
				</td>				
			</tr>
				
				<tr>
				<td colspan="3">
					<h2>App</h2>
					<hr/>
				</td>
			</tr>
			
				<tr>
				<td align="left">					
					<strong class="upper">App Texture</strong>
				</td>
				<td align="left">	
					<?php
							echo $this->Form->input('bg_texture',array(
													'type'=>'select',
													'class' => 'input',
													'onchange' => 'preview_texture(this.value)',
													'style'=>'width: 450px;',
													'options' => array('1' => 'Texture 1', '2' => 'Texture 2', '3' => 'Texture 3', '4' => 'Texture 4', '5' => 'Texture 5', '6' => 'Texture 6')
													
										)
									);
					?>
					
				</td>
				<td align="left">	
					<div id="texture_preview"  style=" display:none; pointer;border: 1px solid #000; width:70px; height:70px; margin-left:26px;">
						<img src="<?php echo $this->webroot; ?>img/textures/texture_<?php if(!empty($this->request->data['Admin']['bg_texture'])) echo $this->request->data['Admin']['bg_texture']; else echo '1'; ?>.png" height="180" width="180" />
					</div>
					<a href="javascript://" onclick="view_texture();">Click to preview</a>
				</td>				
			</tr>
			
			
			</tr>
			
				<tr>
				<td align="left">					
					<strong class="upper">App Font Color</strong>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('font_color', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'font_color',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This color will be used for the text font color of your SOCIAL REFERRALS™ Landing Page as well as your app.'
												)
											);
					?>
				</td>				
			</tr>
			
			<tr>
				<td align="left">					
					<strong class="upper">Main Page Text-1</strong>
					
				</td>
				<td align="left">	
					<?php 
							if(!empty($this->request->data['Admin']['main_page_text_1']))
								$mtext_1 = $this->request->data['Admin']['main_page_text_1'];
							else
								$mtext_1 = 'Enter to Save!';
							echo $this->Form->input('main_page_text_1', array(
													'type' => 'text', 
													'class' => 'input check',
													'value' => $mtext_1, 												
													'id' => 'main_page_text_1',
													'maxlength' => '15',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This text will be used on main page of app.'
												)
											);
					?>
				</td>	
			</tr>
			
			<tr>
				<td align="left">					
					<strong class="upper">Main Page Text-2</strong>
					
				</td>
				<td align="left">	
					<?php 
							if(!empty($this->request->data['Admin']['main_page_text_2']))
								$mtext_2 = $this->request->data['Admin']['main_page_text_2'];
							else
								$mtext_2 = 'Choose Your Deal Below!';
							echo $this->Form->input('main_page_text_2', array(
													'type' => 'text', 
													'class' => 'input check',
													'value' => $mtext_2, 												
													'id' => 'main_page_text_2',
													'maxlength' => '25',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This text will be used on main page of app.'
												)
											);
					?>
				</td>	
			</tr>
			
			<tr>
				<td align="left">					
					<strong class="upper">Login Page Text-1</strong>
				
				</td>
				<td align="left">	
					<?php 
							if(!empty($this->request->data['Admin']['login_page_text_1']))
								$Ltext_1 = $this->request->data['Admin']['login_page_text_1'];
							else
								$Ltext_1 = 'Login & Save';
							echo $this->Form->input('login_page_text_1', array(
													'type' => 'text', 
													'class' => 'input check',
													'value' => $Ltext_1, 												
													'id' => 'login_page_text_1',
													'maxlength' => '15',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This text will be used on login page of app.'
												)
											);
					?>
				</td>	
			</tr>
			
			<tr>
				<td colspan="3">
					<h2>Landing Page</h2>
					<hr/>
				</td>
			</tr>
				
			<tr>
				<td align="left">					
					<strong class="upper">Display Form</strong>
				</td>
				<td align="left">	
				
					<?php echo $this->Form->input('display_form_type', array(
																			'type' => 'radio',
																			'div' => false,
																			'legend' => false,
																			'onclick' => 'check_form_type();',
																			'options' => array('1' => 'Appointment Form', '2' => 'Contact Form', '3' => 'Image')			
																		)
															);
					 ?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'Type of form to display to users - Appointment/ Contact /Image upload'
												)
											);
					?>
				</td>			
			</tr>
			
			
				
			<tr id="website_image_block" style="<?php if($this->request->data['Admin']['display_form_type'] != 3) echo 'display: none;'; ?>">
				<td align="left">					
					<strong class="upper">Image</strong>					
				</td>
				<td align="left">	
					<?php  $cls = '';
							if($this->request->data['Admin']['display_form_type'] == 3 && empty($this->request->data['Admin']['website_image']) )
							$cls = 'required';
							echo $this->Form->input('website_image', array(
													'type' => 'file', 
													'class' => 'input check '.$cls, 												
													'id' => 'website_image',
													'style'=>'width: 450px;'
												)
											);
					?>
					<br/>
					<label>Image should not be less than 50x50 size</label>
					<label for="website_image" class="error website_image_error"></label>
				</td>
				<td align="left">	
					<?php if(!empty($this->request->data['Admin']['website_image'])){ ?>
					<div id="company_logo_preview">
						<img src="<?php echo $this->webroot.'img/company/'.$this->request->data['Admin']['website_image']; ?>" style="max-height: 80px; max-width: 80px;" />
					</div>
					<?php } ?>
				</td>
			</tr>
			
			<tr class="website_image_block"  style="<?php if($this->request->data['Admin']['display_form_type'] != 3) echo 'display: none;'; ?>">
				<td align="left">					
					<strong class="upper">Image Link</strong>					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('website_image_url', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'website_image_url',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				
			</tr>
			
			
			<tr>
				<td align="left">					
					<strong class="upper">Landing Page Color</strong>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('color', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'color',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This will be the primary color of your SOCIAL REFERRALS™ Landing Page and your app.'
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
					<div class="black_btn2">
						<span class="upper">
						<a href="javascript://" class="links_a" onclick="preview(0); return false;" id="preview">Preview App</a>
						</span>
					</div>
					<div class="black_btn2">
						<span class="upper">
						<a href="javascript://" class="links_a" onclick="preview(1)" id="preview_website">Preview Landing Page</a>
						</span>
					</div>	
				</td>
			</tr>
	    </table>
    <?php echo $this->Form->end(); ?>
</div>

<div id="texture_img" style="display:none;  background:#151c49;"></div>

<script type="text/javascript">
	$(document).ready(function (){
		$("#dob").datepicker({
			dateFormat: 'yy-mm-dd'
		});
		$('#bg_color').colorpicker();
		$('#font_color').colorpicker();
		$('#bname_bgcolor').colorpicker();
		$('#color').colorpicker();
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
				"data[Admin][email]" : {
					required : true,
					email	: true					
					
				},
				"data[Admin][company_logo]" : {
					<?php if(empty($this->request->data['Admin']['company_logo'])){ ?>
					required : true,
					<?php } ?>
					extension : "jpe?g|png"
				},
				"data[Admin][website_image]" : {
					
					extension : "jpe?g|png"
				},
				"data[Admin][tablet_url]" : {	
					maxlength : 100,
					remote: {
				        url: SITE_URL+'admin/users/check_username/<?php echo $this->request->data['Admin']['id']; ?>',
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
				        url: SITE_URL+'admin/users/check_username/<?php echo $this->request->data['Admin']['id']; ?>',
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
					maxlength : 12
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
				},				
				"data[Admin][google_url]" : {	
					maxlength : 150
				},				
				"data[Admin][website_image_url]" : {	
					url: true
				}
			},
			messages: { 
	            
				"data[Admin][username]": {						       
					remote: jQuery.format("{0} is already in use")
				},
				"data[Admin][email]": {						       
					remote: jQuery.format("{0} is already in use")
				},
				"data[Admin][company_logo]" : {
					extension : "Only jpeg, jpg, png files allowed."
				},
				"data[Admin][tablet_url]": {						       
					remote: jQuery.format("{0} is already in use")
				},
				"data[Admin][website_url]": {						       
					remote: jQuery.format("{0} is already in use")
				},
				"data[Admin][image]" : {
					extension : "Only jpeg, jpg, png files allowed."
				},
				"data[Admin][website_image]" : {
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
		$("#username_suggestion").on("click", function(){
			var first_name = $.trim($("#first_name").val());
			var last_name =$.trim($("#last_name").val());
			
			$.ajax({
				url: SITE_URL+'admin/users/suggest_username',
				type: "GET",
				data: {'f_name': first_name, l_name: last_name},
				beforeSend : function(){
					loader('website_loader');
				},
				complete : function (){
					$(".website_loader").html('');
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
		
			
		$("#tablet_url_suggestion").on("click", function(){
			var username = '<?php echo $this->data['Admin']['username']?>';
			var tablet_url = SITE_URL+username;
			var website_url = SITE_URL+'w/'+username;
			$("#tablet_url").val(username);
				
			$('span.tablet_url').html('<strong>App URL : </strong>'+tablet_url+'<br><strong>Landing Page URL : </strong>'+website_url);
  		
			$('#website_url').val(username);
			
			return false;
		});
	});
$(function () {
    var lat = <?php echo !empty($this->data['Admin']['latitude'])?$this->data['Admin']['latitude']:'44.88623409320778'; //44.88623409320778 ?>,
        lng = <?php echo !empty($this->data['Admin']['longitude'])?$this->data['Admin']['latitude']:'-87.86480712897173'; //-87.86480712897173 ?>,
        latlng = new google.maps.LatLng(lat, lng),
        image = 'https://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png';

    //zoomControl: true,
    //zoomControlOptions: google.maps.ZoomControlStyle.LARGE,

    var mapOptions = {
        center: new google.maps.LatLng(lat, lng),
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        panControl: true,
        panControlOptions: {
            position: google.maps.ControlPosition.TOP_RIGHT
        },
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE,
            position: google.maps.ControlPosition.TOP_left
        }
    },
    map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions),
        marker = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: image
        });

    var input = document.getElementById('searchAddress');
    var autocomplete = new google.maps.places.Autocomplete(input, {
        types: ["geocode"]
    });

    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();

    google.maps.event.addListener(autocomplete, 'place_changed', function (event) {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }

        moveMarker(place.name, place.geometry.location);
        $('.MapLat').val(place.geometry.location.lat());
        $('.MapLon').val(place.geometry.location.lng());
    });
    google.maps.event.addListener(map, 'click', function (event) {
        $('.MapLat').val(event.latLng.lat());
        $('.MapLon').val(event.latLng.lng());
        infowindow.close();
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    "latLng":event.latLng
                }, function (results, status) {
                    console.log(results, status);
                    if (status == google.maps.GeocoderStatus.OK) {
                        console.log(results);
                        var lat = results[0].geometry.location.lat(),
                            lng = results[0].geometry.location.lng(),
                            placeName = results[0].address_components[0].long_name,
                            latlng = new google.maps.LatLng(lat, lng);

                        moveMarker(placeName, latlng);
                        $("#searchAddress").val(results[0].formatted_address);
                    }
                });
    });
   
    function moveMarker(placeName, latlng) {
        marker.setIcon(image);
        marker.setPosition(latlng);
        infowindow.setContent(placeName);
    }

    function initialize() { 
      var myOptions = {
          zoom: 14,
          center: new google.maps.LatLng(0.0, 0.0),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
          map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
    }
});

function preview_texture(val)
{
	$('#texture_preview').html('<img src="<?php echo $this->webroot; ?>img/textures/texture_'+val+'.png" height="70" width="70"/>');
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


function preview(type)
{
	var fields = Array('company_name','main_page_text_1','main_page_text_2','color','bg_color','font_color','AdminBgTexture');
	
	var resp = verify_fields(fields);	
	
	if(resp)
	{
		var values = get_field_values(fields);
		
		var color = $('#color').val();
		if(color == '')
			color = 'ccc';
			
		var bg_color = $('#bg_color').val();
		if(bg_color == '')
			bg_color = 'ccc';
			
		var font_color = $('#font_color').val();
		if(font_color == '')
			font_color = 'fff';
			
		var bg_texture = $('#AdminBgTexture').val();	
		
			
		var display_form =$("input[type='radio'][name='data[Admin][display_form_type]']:checked").val();
		
		if(display_form == '' || display_form == undefined)
			display_form = 1;	
			
		
		
		var url = '<?php echo $this->webroot; ?>admin/users/preview_tablet_edit/'+color+'/'+bg_color+'/'+font_color+'/'+bg_texture;
		if(type == 1)
			url = '<?php echo $this->webroot; ?>admin/users/preview_website_edit/'+color+'/'+bg_color+'/'+font_color+'/'+bg_texture+'/'+display_form
		$.fancybox.open({
	 			'autoSize'		 : false,
	 			'autoDimensions' : false,
				'width' 	     : '1124',
				'type'			 : 'ajax',
				'height'		 : '780',
	 			'href'			 :  url,
	 			'afterLoad'	 : function(){
	 				
	 				setTimeout(function(){
	 						
	 					for(var i=0; i<fields.length; i++)
						{
							$('#unique_' + fields[i]).html(values[i]);
						}	
	 					
	 					var comp_logo = $('#logo_prev').attr('src');
	 					$('#comp_logo').attr('src',comp_logo);
	 				},1000);
	 					
	 			}
	 	});

	}
	
}
function generate_tablet_url(value)
{
	value = value.replace(/\s+/g, '-').toLowerCase();
	var url = "<?php echo SITE_URL; ?>"+value;
	var website_url = "<?php echo SITE_URL; ?>w/"+value;
 $('span.tablet_url').html('<strong>App URL : </strong>'+url+'<br><strong>Landing Page URL : </strong>'+website_url);
  $('#website_url').val(value);
}

function check_form_type()
{
	if($('#AdminDisplayFormType3').is(':checked'))
	{
		$('.website_image_block').show();
		$('#website_image').addClass('required');
	}else{
		$('#website_image').removeClass('required');
		$('.website_image_block').hide();
	
	}
}


function readURL(input) {
if (input.files[0] && input.files[0]) {
var reader = new FileReader();

reader.onload = function (e) {
$('#logo_prev')
.attr('src', e.target.result)
.width(70)
.height(70);
};

reader.readAsDataURL(input.files[0]);
}
}

</script>
