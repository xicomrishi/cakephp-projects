<?php
	//echo $this->Html->script(array('/admin/js/jquery-ui.js'), array('inline' => false));
	//echo $this->Html->css('popup');
	echo $this->Html->script(array('/admin/js/additional-methods.min', '/admin/js/ckeditor/ckeditor'));		
?>
<?php
	echo $this->Html->css('jquery.fancybox');
	echo $this->Html->script(array('fancybox/source/jquery.fancybox'));		
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
<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Upload Slider Image'); ?></h1></div>
    <div class="floatright">
        <?php
			echo $this->Html->link('<span>'.__('Back To Manage Slider').'</span>', array('controller' => 'users','action' => 'slider', $this->data['AdminClientSlider']['user_id'], 'plugin' => 'admin'),array( 'class'=>'black_btn','escape'=>false));
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
			echo $this->Form->create('AdminClientSlider', array(
									'type'=>'file',
									'url'=>array('controller'=>'users', 'action'=>'slider_image_edit'),
									'class'=>'validate',
									'inputDefaults'=>array('div'=>false, 'label'=>false)									
								)
							);
	?>
	    <table cellspacing="0" cellpadding="7" border="0" align="center">
	
			<?php
				echo $this->Form->input('id',array('type' => 'hidden'));
				echo $this->Form->input('user_id',array('type' => 'hidden'));
				echo $this->Form->input('old_image',array('type' => 'hidden', 'value'=>$this->data['AdminClientSlider']['image']));
			?>
			
			<tr>
				<td align="left">					
					<strong class="upper">Website Slider Image</strong>
					<span class="required_val">*</span>
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('slider_image', array(
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
							if(!empty($this->data['AdminClientSlider']['image']) && file_exists(SLIDER.LARGE.$this->data['AdminClientSlider']['image']))
							{
								echo $this->Html->image(SLIDERURL.LARGE.$this->data['AdminClientSlider']['image']);
							?>
							<br/>
							<a href="javascript://" onclick="open_slider('<?php echo $this->webroot.'admin/users/slider_crop_image/'.$this->data['AdminClientSlider']['id']; ?>');">View and Crop</a>
								
							<?php	
							}
							else {
								echo $this->Html->image('no_image_available_small.png');
							}
					?>
					
				</td>
			</tr>
			<tr>
				<td align="left">					
					<strong class="upper">Website Slider Text</strong>
					
				</td>
				<td align="left">	
					<?php 
							echo $this->Form->input('text', array(
													'type' => 'textarea', 
													'class' => 'input ckeditor', 												
													'id' => 'textarea1',
													'style'=>'width: 450px;'
												)
											);
					?>
					<span id="ckeditor-error"></span>
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
		
		
		$('.validate').validate({
			
			ignore: 'hidden',
			onkeyup : false,
			rules : {
				
				"data[AdminClientSlider][slider_image]" : {	
					extension : "jpe?g|png"
				},				
				"data[AdminClientSlider][text]" : {					
					//check_ckeditor : true,				
				}
			},
			messages: { 
				
				"data[Admin][slider_image]" : {
					extension : "Only jpeg, jpg, png files allowed."
				}
		    },
		     errorPlacement: function(error, element) {
				if (element.hasClass("ckeditor")) {
				   $("#ckeditor-error").html(error);
				}
				else { 
					error.insertAfter(element);
				}
			}
		});
	});
	
	function open_slider(url)
	{
		$.fancybox.open({
			'type' : 'ajax',
			'href' : url,
	});
	}
</script>
