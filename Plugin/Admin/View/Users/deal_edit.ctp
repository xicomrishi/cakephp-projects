<?php 
	//echo $this->Html->script(array('/admin/js/jquery-ui.js'), array('inline' => false));
	echo $this->Html->css(array('/admin/css/jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/ui-lightness/jquery-ui.css','developer'));
	echo $this->Html->script(array('/admin/js/additional-methods.min', '/admin/js/jquery-ui'));		
?>

<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Edit Deal'); ?></h1></div>
    <div class="floatright">
        <?php
			echo $this->Html->link('<span>'.__('Back To Manage Deal').'</span>', array('controller' => 'users','action' => 'deals', $this->data['AdminClientDeal']['user_id'], 'plugin' => 'admin'),array( 'class'=>'black_btn','escape'=>false));
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
									'url'=>array('controller'=>'users', 'action'=>'deal_edit'),
									'class'=>'validate',
									'inputDefaults'=>array('div'=>false, 'label'=>false)									
								)
							);
	?>
	    <table cellspacing="0" cellpadding="7" border="0" align="center">
	
			<?php
				echo $this->Form->input('id',array('type' => 'hidden'));
				echo $this->Form->input('user_id',array('type' => 'hidden'));
				echo $this->Form->input('old_image',array('type' => 'hidden', 'value'=>$this->data['AdminClientDeal']['image']));
			?>
			
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
													'style'=>'width: 450px;'
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
													'options'=>array('1'=>'Percentage', '2'=>'Dollar', '3'=>'Buy One Get One', '4'=>'Others') ,
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
			<tr id="deal_value_container" <?php echo !in_array($this->data['AdminClientDeal']['type'], array(1,2))?'style="display:none;"':"";?>">
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
			<tr>
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
													'style'=>'width: 450px;'
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
					<strong class="upper">Image</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('deal_image', array(
													'type' => 'file', 
													'class' => 'input', 												
													'id' => 'file',
													'style'=>'width: 450px;'
												)
											);
					?>
				</td>
								
				<td >
					<?php 
							if(!empty($this->data['AdminClientDeal']['image']) && file_exists(DEAL.LARGE.$this->data['AdminClientDeal']['image']))
							{
								echo $this->Html->image(DEALURL.LARGE.$this->data['AdminClientDeal']['image']);
							}
							else {
								echo $this->Html->image('no_image_available_small.png');
							}
					?>					
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
			</tr>
			<tr>
				<td></td>
				
				<td align="left" style="width:120px">	
					<?php 
							foreach($icons as $icon)
							{ ?>
								<input name="data[AdminClientDeal][deal_icon]" <?php echo $this->data['AdminClientDeal']['deal_icon'] == $icon['AdminIcon']['id']?'checked':'';  ?> id="UserGenderM" value="<?php echo $icon['AdminIcon']['id']; ?>" type="radio" class="deal-icon"/>
								<?php echo $this->Html->image(DEALSLIDERURL.$icon['AdminIcon']['image'], array('width'=>50, 'height'=>50)); ?>	
					<?php	}
					?>					
				</td>
				
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Facebook Post Message</strong>
					<span class="required_val">*</span>
				</td>
			<?php echo $this->Form->input('is_custom_post_message', array('type' => 'hidden', 'value' => '1')); ?>	
			<td align="left">	
					<?php 
							$StatusMessage = new StatusMessage();
		
							$fb_post_message = $StatusMessage->fb_message($record['Admin'], $record);
							$tw_post_message = $StatusMessage->tw_message($record['Admin'], $record);
							$user_Data = array('first_name'=>'{FIRST_NAME}', 'last_name'=>'{LAST_NAME}');
							$fanpage_message = $StatusMessage->fb_fanpage_message($user_Data, $record['Admin'], $record);
					
							if(!empty($this->request->data['AdminClientDeal']['fb_post_message']) && $this->request->data['AdminClientDeal']['is_custom_post_message'] == '1')
								$fb_post_message = $this->request->data['AdminClientDeal']['fb_post_message'];
							
							echo $this->Form->input('fb_post_message', array(
													'type' => 'textarea', 
													'class' => 'input required', 												
													'id' => 'textarea1',
													
													'style'=>'width: 450px;',
													'value'=>$fb_post_message
													
												)
											);
					?>
					
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'What will be posted on user facebook wall?'
												)
											);
					?>
						<div class="custom_post_msg" style="margin-left: 82px;">
							You can use following variables for Facebook / Twitter and <br> Fanpage post messages:<br><br>
							<ul>
								
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
					<strong class="upper">Twitter Post Message</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
						if(!empty($this->request->data['AdminClientDeal']['tw_post_message']))
								$tw_post_message = $this->request->data['AdminClientDeal']['tw_post_message'];
						
							echo $this->Form->input('tw_post_message', array(
													'type' => 'textarea', 
													'class' => 'input required', 												
													'id' => 'textarea2',
													'max-length' => '110',
													'style'=>'width: 450px;',
													'value'=>$tw_post_message,
													'placeholder'=>'Character limit - 110'
												)
											);
					?>
					
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'What will be posted on user twitter wall?'
												)
											);
					?>
				
				</td>
				</tr>
				<tr>
					<td align="left">					
					<strong class="upper">Fan Page Message</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
						if(!empty($this->request->data['AdminClientDeal']['fanpage_message']))
								$fanpage_message = $this->request->data['AdminClientDeal']['fanpage_message'];
							echo $this->Form->input('fanpage_message', array(
													'type' => 'textarea', 
													'class' => 'input required', 												
													'id' => 'textarea3',
													'style'=>'width: 450px;',
												
													'value'=>$fanpage_message
													
												)
											);
					?>
					
				</td>
				<td align="left">	
					<?php 
							echo $this->html->image('help.png', array(													
													'class' => 'help toolTip', 
													'title'=>'What will be posted on user fan page wall?'
												)
											);
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
		$(".datepicker").datepicker({
			dateFormat: 'yy-mm-dd'
		});
		$('.toolTip').tooltip({		
			track : true
		});
		$('.preview').click(function(e) {
			$('#overlay').fadeIn();
			$('.view_deal').fadeIn();
			e.preventDefault();
		});
		
		$('textarea').keyup(function(){
		    //Get the value
		    var text = $(this).val();
		   // console.log(text);
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
		
		$('#overlay ,.close').click(function(e) {
			$('#overlay').fadeOut();
			$('.index-popup').fadeOut();
			e.preventDefault();
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
				"data[AdminClientDeal][deal_image]" : {
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
				}
		    },
		     errorPlacement: function(error, element) {				
				if(element.hasClass("deal-icon")) {
					$("#deal-icon-error").html(error);
				}
				else { 
					error.insertAfter(element);
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
</script>
