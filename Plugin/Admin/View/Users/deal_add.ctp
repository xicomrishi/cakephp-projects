<?php
	//echo $this->Html->script(array('/admin/js/jquery-ui.js'), array('inline' => false));
	echo $this->Html->css(array('/admin/css/jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/ui-lightness/jquery-ui.css','developer'));
	echo $this->Html->script(array('/admin/js/additional-methods.min', '/admin/js/jquery-ui'));		
?>

<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Add New Deal'); ?></h1></div>
    <div class="floatright">
        <?php
			echo $this->Html->link('<span>'.__('Back To Manage Deals').'</span>', array('controller' => 'users','action' => 'deals', $user_id,'plugin' => 'admin'),array( 'class'=>'black_btn','escape'=>false));
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
			echo $this->Form->create('AdminClientDeal', array(
									'type'=>'file',
									'url'=>array('controller'=>'users', 'action'=>'deal_add'),
									'class'=>'validate',
									'inputDefaults'=>array('div'=>false, 'label'=>false)									
								)
							);
	?>
	
	
			<?php
				echo $this->Form->input('user_id',array('type' => 'hidden', 'value'=>$user_id));
				echo $this->Form->input('company',array('type' => 'hidden', 'id' => 'company',  'value'=>$user['Admin']['company']));
				echo $this->Form->input('mobile',array('type' => 'hidden', 'id' =>'mobile' , 'value'=>$user['Admin']['mobile']));
				echo $this->Form->input('website_url',array('type' => 'hidden', 'id' =>'website_url', 'value'=>$user['Admin']['website_url']));
				echo $this->Form->input('twitter_url',array('type' => 'hidden', 'id' =>'twitter_url', 'value'=>$user['Admin']['twitter_url']));
				echo $this->Form->input('first_name',array('type' => 'hidden', 'id' =>'first_name', 'value'=>$user['Admin']['first_name']));
				echo $this->Form->input('last_name',array('type' => 'hidden', 'id' =>'last_name', 'value'=>$user['Admin']['last_name']));
			?>
			
	    <table cellspacing="0" cellpadding="7" border="0" align="center">
	
			<tr>
				<td align="left">					
					<strong class="upper">Title</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('title', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'title',
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
				<td align="left">
					<div>
						<div class="wrap" style="width:463px;">				
								<div class="share-text" style="border: 1px solid #111111;padding: 6px; word-wrap: break-word;">				
									<h3>What will be posted on user facebook wall?</h3>
									<p class="fb_text_wall"></p>
									<h3>What will be posted on user twitter wall?</h3>
									<p class="tw_text_wall"></p>
									<h3>What will be posted on your Fan Page wall?</h3>
									<p class="fanpage_text_wall"></p>
								</div>
					</div>
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
													'options'=>array('1'=>'Percentage', '2'=>'Dollar', '3'=>'Buy One Get One', '4'=>'Others') ,
													'class' => 'input', 												
													'id' => 'type',
													'onChange' => 'update_post_messages()',
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
				<td align="left">
					<div>
						<span>
						
						<input type="radio" class="check_radio" name="data[AdminCLientDeal][is_custom_post_message]" checked="checked" value="0">
						<label>Use above message</label>
						</span>
						
						<span>
						
						<input type="radio" class="check_radio is_custom" name="data[AdminClientDeal][is_custom_post_message]" value="1">
						<label>Use my custom message</label>
						</span>
					</div>
				
					
				</td>	
				
			</tr>
			<tr id="deal_value_container">
				<td align="left">					
					<strong class="upper" id="deal_value_text">Deal Value</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('price', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'price',
													'onBlur' => 'update_post_messages()',
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
				<td align="left">
					
					
				</td>
			</tr>
			<tr id="product_container">
				<td align="left">					
					<strong class="upper" id="deal_value_text">Product or Service</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('product', array(
													'type' => 'text', 
													'class' => 'input', 												
													'id' => 'product',
													'onBlur' => 'update_post_messages()',
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
				<td align="left">
					<div class="custom_post_msg">
					<div>Facebook Post Message</div>
					<div>
						
						<?php 
							echo $this->Form->input('fb_post_message', array(
													'type' => 'textarea', 
													'class' => 'input fb_text_wall_custom', 												
													'id' => 'fb_post_message',
													'style'=>'width: 450px;'
													
													
													)
											);
					?>
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'What will be posted on user facebook wall?'
												)
											);
					?>	
					</div>
					</div>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Description</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('description', array(
													'type' => 'textarea', 
													'class' => 'input', 												
													'id' => 'textarea1',
													'style'=>'width: 450px;',
													'placeholder'=>'Character limit - 200'
												)
											);
					?>
					<span id="ckeditor-error"></span>
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
				<td align="left">
					<div class="custom_post_msg">
					<div>Twitter Post Message</div>
					<div>
						<?php 
							echo $this->Form->input('tw_post_message', array(
													'type' => 'textarea', 
													'class' => 'input tw_text_wall_custom', 												
													'id' => 'tw_post_message',
													'style'=>'width: 450px;',
													'max-length' => '110',
													'placeholder'=>'Character limit - 110'
												)
											);
					?>
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'What will be posted on user twitter wall?'
												)
											);
					?>	
					</div>
					</div>
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Image</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('image', array(
													'type' => 'file', 
													'class' => 'input', 												
													'id' => 'image',
													'style'=>'width: 450px;'
												)
											);
					?>
					<div  class="error deal_image_error"></div>
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
				<td align="center">
					<div class="custom_post_msg">
					<div style="float:left;">Fan Page Message</div>
					<div>
						<?php 
							echo $this->Form->input('fanpage_message', array(
													'type' => 'textarea', 
													'class' => 'input fanpage_text_wall_custom', 												
													'id' => 'fanpage_message',
													'style'=>'width: 450px;'
													
												)
											);
					?>
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'What will be posted on user fan page?'
												)
											);
					?>	
					</div>
					</div>
				</td>
			</tr>
			
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
				<td align="left">
					<div class="custom_post_msg">
							You can use following variables:<br>
							<ul style="margin-left:15px;">
								
								<li>{FIRST_NAME} - "For user first name"</li>
								<li>{LAST_NAME} - "For user last name"</li>
								<li>{PRICE} - "For deal value"</li>
								<li>{PRODUCT} - "For product or service"</li>
								<li>{COMPANY} - "For company name"</li>
								<li>{APP_URL} - "For app url"</li>
								<li>{WEBSITE_URL} - "For landing page url"</li>
							</ul>
						
					</div>
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
													'style'=>'width: 450px;'
													
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
				<td align="left">
					
				</td>		
			</tr>
			<tr>
				<td align="left">
					<strong class="upper">Deal Icon</strong>
					<span class="required_val">*</span>
				</td>
				
				<td>
					<?php 
							echo $this->Form->input('slider_image', array(
													'type' => 'file', 
													'class' => 'input', 												
													'id' => 'slider_image',
													'style'=>'width: 450px;'
												)
											);
					?>
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
				<td align="left">
					
				</td>
			</tr>
			<tr>
				<td></td>
				
				<td align="left" style="width:120px">	
					<?php 
							foreach($icons as $icon)
							{ ?>
								<input name="data[AdminClientDeal][deal_icon]" id="UserGenderM" value="<?php echo $icon['AdminIcon']['id']; ?>" type="radio" class="deal-icon"/>
								<?php echo $this->Html->image(DEALSLIDERURL.$icon['AdminIcon']['image'], array('width'=>50, 'height'=>50)); ?>	
					<?php	}
					?>					
				</td>
				
			</tr>
					
			
			<tr>
				<td align="left">					
					<strong class="upper">Deal Disclaimer</strong>
					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('disclaimer', array(
													'type' => 'textarea', 
													'class' => 'input', 												
													'id' => 'textarea1',
													'style'=>'width: 450px;',
													'max-length' => '500',
													'placeholder'=>'Character limit - 500'
												)
											);
					?>
					<span id="ckeditor-error"></span>
				</td>
				<td align="left">	
					
				</td>
				<td align="left">
					
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
				</td>
			</tr>
	    </table>
    <?php echo $this->Form->end();?>
</div>
<script type="text/javascript">
	$(document).ready(function (){
		$('.custom_post_msg').hide();
		$('.is_custom').removeAttr('checked');
		
		$('textarea').keyup(function(){
		    //Get the value
		    var text = $(this).val();
		    //console.log(text);
		    //Get the maxlength
		    var limit = $(this).attr('max-length');
		    //Check if the length exceeds what is permitted
		    if(text.length > limit){
		        //Truncate the text if necessary
		        $(this).val(text.substr(0, limit));  
		    }
		});
		
		$('textarea').keypress(function(){
		    //Get the value
		    var text = $(this).val();
		    //console.log(text);
		    //Get the maxlength
		    var limit = $(this).attr('max-length');
		    //Check if the length exceeds what is permitted
		    if(text.length > limit){
		        //Truncate the text if necessary
		        $(this).val(text.substr(0, limit));  
		    }
		});
		
		var _URL = window.URL || window.webkitURL, FLAG = true;
		$("#image").change(function (e) {
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
		
		
		$('.check_radio').click(function(e){
			
			if($(this).is(':checked')){
				if($(this).val() == 0){
					$('.fb_text_wall_custom').removeClass('required');
					$('.tw_text_wall_custom').removeClass('required');
					$('.fanpage_text_wall_custom').removeClass('required');
					$('.custom_post_msg').hide();
				
				}else{
					$('.custom_post_msg').show();
					$('.fb_text_wall_custom').addClass('required');
					$('.tw_text_wall_custom').addClass('required');
					$('.fanpage_text_wall_custom').addClass('required');
				}
			}
		});
		
		$(".datepicker").datepicker({
			dateFormat: 'yy-mm-dd'
		});
		$('.toolTip').tooltip({		
			track : true
		});
		$.validator.addMethod('checkSelectIcon', function(){
				var slider_image = $("#slider_image").val();
				var deal_icon = $("#deal-icon").val();
				if($.trim(slider_image) == '' && $(".deal-icon").is(':checked') == false)
				{
					return false;
				}
				else
				{
					return true;
				}
		},'Please choose an icon from below or upload your own.');
		
		$.validator.addMethod('checkType', function(a,b){
			var type = $("#type").val();
			if((type == 1 || type == 2) && !$.isNumeric(a))
			{
				return false;
			}
			else{
				return true;
			}
		},'Only numeric values are allowed');
		
		$('.validate').validate({			
			
			onkeyup : false,
			rules : {
				"data[AdminClientDeal][title]" : {					
					required : true,					
					maxlength : 25
				},
				"data[AdminClientDeal][price]" : {
					required : true,
					checkType : true,					
				},
				"data[AdminClientDeal][description]" : {
					required : true,					
					maxlength : 200
				},
				"data[AdminClientDeal][product]" : {								
					required : true,
					maxlength : 25
				},
				"data[AdminClientDeal][image]" : {					
					required : true,
					extension : "jpe?g|png"
				},	
				"data[AdminClientDeal][slider_image]" : {									
					extension : "jpe?g|png",
					checkSelectIcon : true
				}
				
			},
			messages: { 				
				"data[AdminClientDeal][image]" : {
					extension : "Only jpeg, jpg, png files allowed."
				},
				"data[AdminClientDeal][slider_image]" : {
					extension : "Only jpeg, jpg, png files allowed."
				}
		    },
		     errorPlacement: function(error, element) {				
				if(element.hasClass("deal-icon")) {
					$("#deal-icon-error").html(error);
				}
				else { 
					error.insertAfter(element);
				}
			},
			submitHandler : function(form){
				if(FLAG == true) {
					form.submit();
				}
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
	});
	
function update_post_messages()
{
	var deal_type = $('#type').val();
	var deal_val = $('#price').val();
	var product = $('#product').val();
	var mobile = $('#mobile').val();
	var company = $('#company').val();
	var website_url = $('#website_url').val();
	var twitter_url = $('#twitter_url').val();
	var first_name = $('#first_name').val();
	var last_name = $('#last_name').val();
	
	var type = $('.is_custom').is(':checked');
	
	if ( deal_type == '1' )
	{	
		$('.fb_text_wall').html(limit_characters('I just saved ' + deal_val + '% off ' + product + 'at ' + company + '. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your coupon! Give them a call at ' + mobile + ' #'+company, 1600));
		$('.tw_text_wall').html(limit_characters('I saved ' + deal_val + '% at @' + twitter_url + ' Click <?php echo SITE_URL.'w/'; ?>' + website_url + '/t and save ' + deal_val + '%', 110));
		$('.fanpage_text_wall').html(limit_characters(first_name + ' ' + last_name + ' just received ' + deal_val + '% off ' + product + '! We hope you will come see us too. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your own coupon and share this post with your friends so they can save too! Thank you.', 2500));
		
		if(type){
			$('.fb_text_wall_custom').html(limit_characters('I just saved ' + deal_val + '% off ' + product + 'at ' + company + '. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your coupon! Give them a call at ' + mobile + ' #'+company, 1600));
			$('.tw_text_wall_custom').html(limit_characters('I saved ' + deal_val + '% at @' + twitter_url + ' Click <?php echo SITE_URL.'w/'; ?>' + website_url + '/t and save ' + deal_val + '%', 110));
			$('.fanpage_text_wall_custom').html(limit_characters(first_name + ' ' + last_name + ' just received ' + deal_val + '% off ' + product + '! We hope you will come see us too. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your own coupon and share this post with your friends so they can save too! Thank you.',2500));
		
		}
		
	}else if ( deal_type == '2' )
	{
		$('.fb_text_wall').html(limit_characters('I just saved $' + deal_val + ' off ' + product + 'at ' + company + '. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your coupon! Give them a call at ' + mobile + ' #'+company, 1600));
		$('.tw_text_wall').html(limit_characters('I saved $' + deal_val + ' at @' + twitter_url + ' Click <?php echo SITE_URL.'w/'; ?>' + website_url + '/t and save $' + deal_val, 110));
		$('.fanpage_text_wall').html(limit_characters(first_name + ' ' + last_name + ' just received $' + deal_val + ' off ' + product + '! We hope you will come see us too. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your own coupon and share this post with your friends so they can save too! Thank you.', 2500));
		
		if(type){
			$('.fb_text_wall_custom').html(limit_characters('I just saved $' + deal_val + ' off ' + product + 'at ' + company + '. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your coupon! Give them a call at ' + mobile + ' #'+company, 1600));
			$('.tw_text_wall_custom').html(limit_characters('I saved $' + deal_val + ' at @' + twitter_url + ' Click <?php echo SITE_URL.'w/'; ?>' + website_url + '/t and save $' + deal_val, 110));
			$('.fanpage_text_wall_custom').html(limit_characters(first_name + ' ' + last_name + ' just received $' + deal_val + ' off ' + product + '! We hope you will come see us too. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your own coupon and share this post with your friends so they can save too! Thank you.', 2500));
		
		}
		
	}else if ( deal_type == '3' )
	{
		$('.fb_text_wall').html(limit_characters('I just received a Buy One Get One Free ' + product + 'at ' + company + '. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your coupon! Give them a call at ' + mobile + ' #'+company, 1600));
		$('.tw_text_wall').html(limit_characters('I got Buy One Get One Free ' + product + ' at @' + twitter_url + ' Click <?php echo SITE_URL.'w/'; ?>' + website_url + '/t and get it too', 110));
		$('.fanpage_text_wall').html(limit_characters(first_name + ' ' + last_name + ' just received a Buy One Get One Free ' + product + '! We hope you will come see us too. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your own coupon and share this post with your friends so they can save too! Thank you.', 2500));
	
		if(type){
			$('.fb_text_wall_custom').html(limit_characters('I just received a Buy One Get One Free ' + product + 'at ' + company + '. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your coupon! Give them a call at ' + mobile + ' #'+company, 1600));
			$('.tw_text_wall_custom').html(limit_characters('I got Buy One Get One Free ' + product + ' at @' + twitter_url + ' Click <?php echo SITE_URL.'w/'; ?>' + website_url + '/t and get it too', 110));
			$('.fanpage_text_wall_custom').html(limit_characters(first_name + ' ' + last_name + ' just received a Buy One Get One Free ' + product + '! We hope you will come see us too. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your own coupon and share this post with your friends so they can save too! Thank you.', 2500));
	
		}
	}else{
		
		$('.fb_text_wall').html(limit_characters(company + ' is offering ' + product + '. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your coupon! Give them a call at ' + mobile + ' #'+company, 1600));
		$('.tw_text_wall').html(limit_characters('I got ' + product + ' at @' + twitter_url + ' Click <?php echo SITE_URL.'w/'; ?>' + website_url + '/t and get it too', 110));
		$('.fanpage_text_wall').html(limit_characters(first_name + ' ' + last_name + ' just received ' + product + '! We hope you will come see us too. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your own coupon and share this post with your friends so they can save too! Thank you.', 2500));
		
		if(type){
			$('.fb_text_wall_custom').html(limit_characters(company + ' is offering ' + product + '. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your coupon! Give them a call at ' + mobile + ' #'+company),1600);
			$('.tw_text_wall_custom').html(limit_characters('I got ' + product + ' at @' + twitter_url + ' Click <?php echo SITE_URL.'w/'; ?>' + website_url + '/t and get it too', 110));
			$('.fanpage_text_wall_custom').html(limit_characters(first_name + ' ' + last_name + ' just received ' + product + '! We hope you will come see us too. Just click <?php echo SITE_URL.'w/'; ?>' + website_url + '/f , and get your own coupon and share this post with your friends so they can save too! Thank you.', 2500));
		
		}
	}
}

function limit_characters(str,count)
{	
	if(str.length >= count)
	{	
		 str = str.substr(0, count); 
		
	}
	return str;
}

</script>
