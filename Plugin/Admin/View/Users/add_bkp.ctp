
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
</style>

<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Admin Add User'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage User').'</span>', array('controller' => 'users','action' => 'index','plugin' => 'admin'),array( 'class'=>'black_btn','escape'=>false));?>
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
					?>
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
				<td align="left">					
					<strong class="upper">Deal Title</strong>					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('AdminClientDeal.title', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'deal_title',
													'style'=>'width: 450px;',
													'placeholder'=>'Character limit - 25'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This is the title of the deal. Example 50 % off Eyeglass. Character count may not exceed 25 characters.'
												)
											);
					?>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Deal Type</strong>
					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('AdminClientDeal.type', array(
													'type' => 'select',
													'options'=>array('1'=>'Percentage', '2'=>'Dollar', '3'=>'Buy One Get One', '4'=>'Other') ,
													'class' => 'input', 												
													'id' => 'type',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'Select the offer type.'
												)
											);
					?>
				</td>			
			</tr>
			<tr id="deal_value_container">
				<td align="left">					
					<strong class="upper" id="deal_value_text">Deal Value</strong>
					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('AdminClientDeal.price', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'deal_price',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This is the value of the deal. Example $50 Off or Buy One Get One Free.'
												)
											);
					?>
				</td>			
			</tr>
			<tr id="product_container">
				<td align="left">					
					<strong class="upper" id="deal_value_text">Product or Service</strong>
					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('AdminClientDeal.product', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'product',
													'style'=>'width: 450px;',
													'placeholder'=>'Character limit - 25'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This is the product of the deal. Example $50 Off on Haircut'
												)
											);
					?>
				</td>			
			</tr>
			<tr>
				<td align="left"><strong class="upper">Deal Icon</strong></td>
				<td align="left" style="width:120px">	
					
					<?php 
							foreach($icons as $icon)
							{ ?>
								<input name="data[AdminClientDeal][deal_icon]"  id="UserGenderM" value="<?php echo $icon['AdminIcon']['id']; ?>" type="radio" class="deal-icon"/>
								<?php echo $this->Html->image(DEALSLIDERURL.$icon['AdminIcon']['image'], array('width'=>50, 'height'=>50)); ?>	
					<?php	}
					?>
					
					<span id="deal-icon-error"></span>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'Choose an icon from below or upload your own.'
												)
											);
					?>
				</td>
			</tr>
			
			<tr>
				<td align="left">					
					<strong class="upper">Deal Description</strong>					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('AdminClientDeal.description', array(
													'type' => 'textarea', 
													'class' => 'input', 												
													'id' => 'deal_description',
													'style'=>'width: 450px;',
													'placeholder'=>'Character limit - 200'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This explains the deal to the customer and will be displayed on the app. Example 50% off Eyeglass. Character count may not exceed 200.'
												)
											);
					?>
				</td>
			</tr>			
			<tr>
				<td align="left">					
					<strong class="upper">Deal Image</strong>					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('AdminClientDeal.image', array(
													'type' => 'file', 
													'class' => 'input ', 												
													'id' => 'deal_image',
													'style'=>'width: 450px;'
												)
											);
					?>
					<label for="deal_image" class="error deal_image_error"></label>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'Your Business logo is recommended or a photo of the product or service you are offering in the deal. The image will be posted to the customer\'s Facebook or twitter profile.'
												)
											);
					?>
				</td>			
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Start Date</strong>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('AdminClientDeal.start_date', array(
													'type' => 'text', 
													'class' => 'input datepicker', 												
													'id' => 'start_date',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>	
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'The day you would like the deal to start.'
												)
											);
					?>
				</td>			
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">End Date</strong>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('AdminClientDeal.end_date', array(
													'type' => 'text', 
													'class' => 'input datepicker', 												
													'id' => 'end_date',
													'style'=>'width: 450px'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'The day you want your deal to end. The deal will no longer show on your app after the date specified here.'
												)
											);
					?>
				</td>				
			</tr>
			
			<tr>
				<td align="left">					
					<strong class="upper">FeedGrabber Script</strong>
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
													'title'=>'We recommend using your business\'s social media feed on your SOCIAL REFERRALS™ website. You can go to https://feedgrabbr.com and create your custom feed there. Then simply paste the code from feedgrabbr here. If you do not choose this option a map of your location will be placed there instead. See a sample SOCIAL REFERRALS™ page here.'
												)
											);
					?>
				</td>
				
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Website URL</strong>
					
				</td>
				<td align="left">	
					<span>
						<?php 
								echo $this->Form->input('website_url', array(
														'type' => 'text', 
														'class' => 'input', 												
														'id' => 'website_url',
														'style'=>'width: 450px;'
													)
												);
						?>
					</span>
					<span class="website_url" style="width:50%; float:left;"></span>
				</td>
				<td>
					<?php 
							echo $this->Form->input('Suggestion', array(
													'type' => 'button',													 												
													'id' => 'website_url_suggestion',
													'disabled'=>true
													
												)
											);
					?>					
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This is the url that the people will go to make appointments and, view your socail profile on the web. We recommend using your business\'s name for the url. '.SITE_URL.'domain/web/YOUR_BUSINESS_NAME'
												)
											);
					?>
				</td>	
				<td class="website_loader"></td>
			</tr>			
			<tr>
				<td align="left">					
					<strong class="upper">Tablet URL</strong>
					
				</td>
				<td align="left">	
					<span>
						<?php 
								echo $this->Form->input('tablet_url', array(
														'type' => 'text', 
														'class' => 'input', 												
														'id' => 'tablet_url',
														'style'=>'width: 450px;'
													)
												);
						?>
					</span>
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
													'title'=>'This is the url that the people will go to shareyour deal on the web. We recommend using your business\'s name for the url.'
												)
											);
					?>
				</td>	
				<td class="tablet_loader"></td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Website Slider Image (740*300)</strong>					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('AdminClientSlider.image', array(
													'type' => 'file', 
													'class' => 'input', 												
													'id' => 'file',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This image will appear as the image on your slider that is displayed on your SOCIAL REFERRALS™ website.'
												)
											);
					?>
				</td>			
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Website Slider Text</strong>					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('AdminClientSlider.text', array(
													'type' => 'textarea', 
													'class' => 'input ckeditor', 												
													'id' => 'textarea1',
													'style'=>'width: 450px;'
												)
											);
					?>
					<span id="ckeditor-error"></span>
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'This text will appear over your slider images. To see an example go to the link and see what this will look like.'
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
				<td><div id="map_canvas" style="height: 350px;width: 350px;margin: 0.6em;"></div></td>
			</tr>
			<tr>
				<td align="left"><strong class="upper">DOB</strong></td>
				<td align="left">	
					<?php 
							echo $this->Form->input('dob', array(
													'type' => 'text', 
													'class' => 'input datepicker', 												
													'id' => 'dob',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
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
					<strong class="upper">Google+ URL</strong>
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
													'title'=>'This is your Google plus business profile\'s url'
												)
											);
					?>
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
																			
																			'options' => array('1' => 'Appointment Form', '2' => 'Contact Form', '3' => 'Image Upload Form')			
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
			
			<tr>
				<td align="left">					
					<strong class="upper">Color</strong>
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
													'title'=>'This will be the primary color of your SOCIAL REFERRALS™ website and your app.'
												)
											);
					?>
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
													'title'=>'This color will be used for the background of your SOCIAL REFERRALS™ website as well as your app.'
												)
											);
					?>
				</td>				
			</tr>
			
				<tr>
				<td align="left">					
					<strong class="upper">Background Texture</strong>
				</td>
				<td align="left">	
					<?php
							echo $this->Form->input('bg_texture',array(
													'type'=>'select',
													'class' => 'input',
													'onchange' => 'preview_texture(this.value)',
													'style'=>'width: 450px;',
													'options' => array('1' => 'Texture 1', '2' => 'Texture 2', '3' => 'Texture 3', '4' => 'Texture 4', '5' => 'Texture 5')
													
										)
									);
					?>
					
				</td>
				<td align="left">	
					<div id="texture_preview" onclick="view_texture();" style="cursor:pointer;">
						<img src="<?php echo $this->webroot; ?>img/textures/texture_1.png" height="180" width="180" />
					</div>
					<span>Click on image to enlarge</span>
				</td>				
			</tr>
			
			
			</tr>
			
				<tr>
				<td align="left">					
					<strong class="upper">Main Page Text Font Color</strong>
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
													'title'=>'This color will be used for the text font color of your SOCIAL REFERRALS™ website as well as your app.'
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
							
								$mtext_1 = 'Enter to Save!';
							echo $this->Form->input('main_page_text_1', array(
													'type' => 'text', 
													'class' => 'input check',
													'value' => $mtext_1, 												
													'id' => 'main_page_text_1',
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
							
								$mtext_2 = 'Choose Your Deal Below!';
							echo $this->Form->input('main_page_text_2', array(
													'type' => 'text', 
													'class' => 'input check',
													'value' => $mtext_2, 												
													'id' => 'main_page_text_2',
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
							
								$Ltext_1 = 'Login & Save';
							echo $this->Form->input('login_page_text_1', array(
													'type' => 'text', 
													'class' => 'input check',
													'value' => $Ltext_1, 												
													'id' => 'login_page_text_1',
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
						<a href="javascript://" class="links_a" onclick="preview(0); return false;" id="preview">Preview Tablet</a>
						</span>
					</div>
					<div class="black_btn2">
						<span class="upper">
						<a href="javascript://" class="links_a" onclick="preview(1)" id="preview_website">Preview Website</a>
						</span>
					</div>	
				</td>
			</tr>
	    </table>
    <?php echo $this->Form->end();?>
</div>

<div id="texture_img" style="display:none;"></div>

<script type="text/javascript">
	$(document).ready(function (){
		
	
		var _URL = window.URL || window.webkitURL, FLAG = true;
		$("#deal_image").change(function (e) {
			var file, img;
			
			if ((file = this.files[0])) {
				img = new Image();
				img.onload = function () {
					if(this.width < 50 || this.height < 50) {
						FLAG = false;
						$(".deal_image_error").text('Please upload image greater than 50*50');
					}
					else{
						FLAG = true;
						$(".deal_image_error").text('');
					}
				};
				img.src = _URL.createObjectURL(file);
			}
		});
		
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
				"data[Admin][company]" : {									
					maxlength : 100
				},
				"data[AdminClientDeal][title]" : {									
					maxlength : 25
				},
				"data[AdminClientDeal][price]" : {
					checkType : true
				},								
				"data[AdminClientDeal][description]" : {									
					maxlength : 200
				},				
				"data[AdminClientDeal][image]" : {									
					extension : "jpe?g|png"
				},
				"data[AdminClientDeal][product]" : {									
					maxlength : 25
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
				"data[AdminClientSlider][image]" : {
					extension : "jpe?g|png"
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
				},				
				"data[Admin][google_url]" : {	
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
				"data[AdminClientDeal][description]": {						       
					required: 'This field is required',
					maxlength: 'Character count may not exceed 200'
				},
				"data[Admin][tablet_url]": {						       
					remote: jQuery.format("{0} is already in use")
				},
				"data[Admin][website_url]": {						       
					remote: jQuery.format("{0} is already in use")
				},
				"data[Admin][company_logo]" : {
					extension : "Only jpeg, jpg, png files allowed."
				},
				"data[AdminClientDeal][image]" : {
					extension : "Only jpeg, jpg, png files allowed."
				},				
				"data[AdminClientSlider][image]" : {
					extension : "Only jpeg, jpg, png files allowed."
				}
		    },
		     errorPlacement: function(error, element) {
				if (element.hasClass("ckeditor")) {
				   $("#ckeditor-error").html(error);
				}
				else if(element.hasClass("deal-icon")) {
					$("#deal-icon-error").html(error);
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
			var website_url = SITE_URL+'websites/domain/'+username;
			$("#website_url").val(username);
			$(".website_url").html(website_url);
			return false;
		});
		$("#tablet_url_suggestion").on("click", function(){
			var username = $.trim($("#username").val());
			var tablet_url = SITE_URL+'tablets/domain/'+username;
			$("#tablet_url").val(username);
			$(".tablet_url").html(tablet_url);
			return false;
		});
			
	});
	
$(function () {
    var lat = 44.88623409320778,
        lng = -87.86480712897173,
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

function preview(type)
{
	var fields = Array('company_name','deal_title','deal_price','type','product','deal_description',
						'main_page_text_1','main_page_text_2','color','bg_color','font_color','AdminBgTexture');
	
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
		
		var deal_desc = $('#product').val();
		var deal_type = $('#type').val();
		if(deal_type == 1)
			deal_desc = 'Get ' + $('#deal_price').val() + '% off ' + $('#product').val();
		else if(deal_type == 2)
			deal_desc = 'Get $' + $('#deal_price').val() + ' off ' + $('#product').val();	
		else if(deal_type == 3)
			deal_desc = 'Buy One Get One Free ' + $('#product').val();
			
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
	 					
	 					$('#unique_deal_desc').html(deal_desc);
	 				},1000);
	 					
	 			}
	 	});

	}
	
}


</script>
