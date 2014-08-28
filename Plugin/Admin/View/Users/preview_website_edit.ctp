<?php

		echo $this->Html->css(array( 'developer'));
		echo $this->Html->script(array('/css/bootstrap/3.0.0/js/bootstrap',
										'/css/bootstrap/3.0.0/js/bootstrap.min',
										
									)
							);
	echo $this->Html->css(array(
    'bootstrap/3.0.0/css/bootstrap', 'bootstrap/3.0.0/css/bootstrap-theme.css',
    'bootstrap/3.0.0/css/bootstrap.min.css', 'bootstrap/3.0.0/css/carousel/carousel.css',
    'appt/style.css',
        )
);
?>
<style>
<?php if(!empty($bg_color)) { ?>
.fancybox-inner .container { background : #<?php echo $bg_color;?> !important; }
.upload_img img{ max-height: 250px; max-width: 250px;}
<?php }?>
</style>
<div class="container">
	<div class="row">
		<div class="col-md-3 col-xs-12 col-lg-3">
			<div class="shadow" style="margin-top:20px; margin-bottom:0px;">
				<?php echo $this->Flash->show(); ?> 
				<div style="background-color:<?php echo !empty($color)?'#'.$color: '#5aa3c8';?>; padding:10px;text-align:left; 

color:#FFF; border-radius:5px;font-size:16px;line-height:20px" align="center">
					<!--XICOM CHANEGE CUSTOMER NAME HERE -->
					<b style="font-size:28px; font-weight:bold;" id="unique_company_name"></b>
				</div>
			</div>
			<table class="table col-lg-12 col-md-12 col-xs-12 main-table" style="width:100%;"><tr>
					<td>
						<div class="white-box">
							<span style="font-size:24px; font-weight:bold; margin-bottom:10px"> Get Our latest deal below!</span><br/>



						</div>
					</td>
				</tr>
				<tr>					
					<td align="left">
						<div class="white-box">
							
							<p><span style="font-size:24px; font-weight:bold; line-height:24px" id="unique_deal_description"></span></p>
							<button class="btn btn-primary btn-lg" style="margin-bottom:0px" id="submit_button1" onClick="return false;">Get our deal</button> 
						</div>						
					</td>
				</tr>
				<tr>
					<td align="left"></td>
				</tr>
				<tr><!-- CHANGE CLIENT OFFER IMAGE HERE -->
					<td align="center">
						<div class="img-thumbnail">
								<?php echo $this->Html->image('sample_image.jpg', array("style" => "max-width:325px", "class" => "img-responsive shadow")); ?>				
						</div>
					</td>
				</tr>
				<tr>					
					<td align="left">
						<div class="white-box" style="width: 100%;">
							
							<p style="width: 100%; word-wrap: break-word;"><span style="font-size:24px; font-weight:bold; line-height:24px;">Disclaimer</span><br>
								<span>Deal disclaimer text</span></p>
							 
						</div>						
					</td>
				</tr>
				<tr class="onlybig">
					<td class="inner-main-sec"  width="100%">
					   
					
					
					</td>
				</tr>
				<tr>
					<td align="left"></td>
				</tr>
				
			</table>   
		</div>
	  
		<!--Thrre End-->
		<div class="clearfix visible-xs"></div>
		<div class="col-md-6 col-xs-12 col-lg-6 on-small" style="background:<?php echo !empty($color)?'#'.$color: '#243A62';?>;">

			<div class="col-lg-12 col-md-12 col-xs-12">
				<!-- Carousel
				================================================== -->
				<script type="text/javascript">
					var $ = jQuery.noConflict();
					$(document).ready(function()
					{
						$('#myCarousel').carousel({interval: 3000, cycle: true});
					});

				</script>
				<!-- XICOM ADD SLIDER IMAGES BELOW. -->
				<div id="myCarousel" class="carousel slide shadow">
					<!-- Indicators -->
					 <ol class="carousel-indicators">
						
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
													
					</ol>
					<div class="carousel-inner">
						
								<div class="item active">
									<?php echo $this->Html->image('sample_image.jpg', array()); ?>
									<div class="container">
										<div class="carousel-caption">
											<!-- <h1>Experienced</h1> -->								 

										</div>
									</div>
								</div>
						
					</div>
					<a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
					<a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
			</div>
			<!-- /.carousel -->

			<div class="col-lg-12 col-md-12 col-xs-12">
				
					<div class="domain_map" style="margin-bottom: 22px;">
						
						<iframe width="100%" height="360" style="border:4px solid #8EC1DA" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" 
							src="https://maps.google.com/maps?q=<?php echo urlencode(28.62); ?>,<?php echo urlencode(77.09444400000007); ?>&hl=en&amp;z=16&amp;t=m&amp;iwloc=A&amp;output=embed">
						</iframe>
							
					</div>
				
			</div>
		</div>
		<div class="clearfix visible-xs"></div>
		<div class="col-lg-3 col-md-3 col-xs-12">
			<div style="margin-top:20px; float:left;">
				<?php if($display_form_type == 3){ ?>
					
					<div style="float:left; width:100%;">
						<div class="blue" style="background:<?php echo !empty($color)?'#'.$color: '#243A62';?>;">
							<div class="col-lg-12 col-md-12 col-xs-12">
								
								
							</div>
							
						
							<div class="col-lg-12 col-md-12 col-xs-12 upload_img">
								<table width="100%">
														
								<tr>
									<td>
										<img src="<?php echo $this->webroot.'img/sample_image.jpg'; ?>" alt=""/>			
									</td>
								</tr>						
										
								</table>
							</div>	
									
							</div>
						</div>	
									
					
				<?php }else if($display_form_type == 2){  ?>
					
					<div style="float:left; width:100%;">
						<div class="blue" style="background:<?php echo !empty($color)?'#'.$color: '#243A62';?>;">
							<div class="col-lg-12 col-md-12 col-xs-12">
								<h2 align="left" class="shadow"><b style="text-transform:uppercase">Contact Form</b></h2>
								
								<p>&nbsp;</p><p style="font-size:12px;text-transform:uppercase;">*All fields are required.</p>
								<p></p><p style="font-size:13px;" id="contactFormMsg"></p>
							</div>
							<?php
								echo $this->Form->create('UserAppointment', array(
									'url' => '#',
									'inputDefaults' => array(
										'div' => false, 'class' => false, 'label' => false
									),
									'onSubmit' => 'return false;',
									'novalidate' => true,
									'id' => 'contactForm'
										)
								);
								
								echo $this->Form->input('client_id',array('type'=>'hidden', 'value'=> ''));
								echo $this->Form->input('contact_type',array('type'=>'hidden', 'value'=> '2'));
								?>
								
							<div class="col-lg-12 col-md-12 col-xs-12">
								<table width="100%">
									<tr>
										<td width="100%" align="left" style="font-size:16px;line-height:28px">Name:</td>
									</tr>
									<tr>
										<td width="100%" style="padding-bottom:10px;">
											<?php
											echo $this->Form->input('name', array(
												'type' => 'text',
												'class' => 'input-sm',
												'align' => 'left',
												'style' => 'width:100%;background-color:#7f8da6;border-top:1px solid #3e4551;border-left:1px solid 
	
	#3e4551;border-right:1px solid #a3afc0;border-bottom:1px solid #a3afc0;',
												'autofocus' => true,
													)
											);
											?>
	
										</td>
									</tr>
									
									
									<tr>
										<td width="100%" align="left" style="font-size:16px;line-height:28px">Email:</td>
									</tr>
									<tr>
										<td width="100%" style="padding-bottom:10px;">
											<?php
											echo $this->Form->input('email', array(
												'type' => 'text',
												'class' => 'input-sm',
												'align' => 'left',
												'style' => 'width:100%;background-color:#7f8da6;border-top:1px solid #3e4551;border-left:1px solid 
	
	#3e4551;border-right:1px solid #a3afc0;border-bottom:1px solid #a3afc0;',
												'autofocus' => true,
													)
											);
											?>
	
										</td>
									</tr>
	
									<tr>
										<td width="100%" align="left" style="font-size:16px;line-height:28px">Subject:</td>
									</tr>
									<tr>
										<td width="100%" style="padding-bottom:10px;">
											<?php
											echo $this->Form->input('subject', array(
												'type' => 'text',
												'class' => 'input-sm',
												'align' => 'left',
												'style' => 'width:100%;background-color:#7f8da6;border-top:1px solid #3e4551;border-left:1px solid 
	
	#3e4551;border-right:1px solid #a3afc0;border-bottom:1px solid #a3afc0;',
												'autofocus' => true,
													)
											);
											?>
	
										</td>
									</tr>
									
									<tr>
										<td width="100%" align="left" style="font-size:16px;line-height:28px">Message:</td>
									</tr>
									<tr>
										<td width="100%" style="padding-bottom:10px;">
											<?php
											echo $this->Form->input('message', array(
												'type' => 'textarea',
												'class' => 'input-sm',
												'align' => 'left',
												'style' => 'width:100%;background-color:#7f8da6;border-top:1px solid #3e4551;border-left:1px solid 
	
	#3e4551;border-right:1px solid #a3afc0;border-bottom:1px solid #a3afc0;',
												'autofocus' => true,
													)
											);
											?>
	
										</td>
									</tr>
									
									<tr>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td align="left" width="100%">
											<?php
											echo $this->Form->submit('Submit', array(
												'align' => 'right',
												'id' => 'contactFormSubmit',
												
												'style' => 'background-color:#ff6c1b;float:left;border:0;font-
	
	size:16px;color:#fff;height:34px;width:120px;font-weight:bold;border-radius:3px 3px 3px 3px',
												'class' => false
													)
											);
											?>
											<span id="contactFormLoader" style="display: none; font-size: 14px;">Please wait...</span>
										</td>
									</tr>
								</table>
							</div>	
									
							</div>
						</div>	
					
				<?php } else { ?>
				<div class="white">
					<div class="col-lg-12 col-md-12 col-xs-12">
						<h1 align="left" class="shadow"><b style="text-transform:uppercase">"Appointments"</b></h1>
						<p style="font-size:12px;text-transform:uppercase">
							
							To make an appointment AND SAVE <span id="unique_deal_price"></span>, 

please use
							any of the options below.
						</p>
						<br/>
					</div>
					<div class="col-lg-12 col-md-12 col-xs-12">
						
							<table width="100%" border="0" cellpadding="auto" class="imgSec">
								<tr>
									<td>
										<a href="#">
											<?php echo $this->Html->image('icons/mgs.png', array("style" => "border:none;", "class" => "img-responsive shadow one")); ?>
											<?php echo $this->Html->image('icons/Email.jpg', array("style" => "border:none;", "class" => "img-responsive shadow two")); ?>

										</a>
									</td>
									<td>
										<a href="#">
											<?php echo $this->Html->image('icons/fb.png', array("style" => "border:none;", "class" => "img-responsive shadow one")); ?>
											<?php echo $this->Html->image('icons/Facebook.jpg', array("style" => "border:none;", "class" => 

"img-responsive shadow two")); ?>
										</a> 
									</td>
									<td>
										 <a href="#">
											<?php echo $this->Html->image('icons/twr.png', array("style" => "border:none;", "class" => "img-responsive shadow one")); ?>
											<?php echo $this->Html->image('icons/Twitter.jpg', array("style" => "border:none;", "class" => 

"img-responsive shadow two")); ?>							
										</a>
									</td>
									<td> 
										<a href="#">
											<?php echo $this->Html->image('icons/gog.png', array("style" => "border:none;", "class" => "img-responsive shadow one")); ?>
											<?php echo $this->Html->image('icons/Google_Plus.jpg', array("style" => "border:none;", "class" => 

"img-responsive shadow two")); ?>

										</a>
									</td>
								</tr>
								<tr>
									<td>
										<p>&nbsp;</p>
									</td>
									<td>
										<p>&nbsp;</p>
									</td>
									<td>
										<p>&nbsp;</p>
									</td>
									<td>
										<p>&nbsp;</p>
									</td>
								</tr>
								<tr>
									<td>
									   <a href="#">
											<?php echo $this->Html->image('icons/inn.png', array("style" => "border:none;", "class" => "img-responsive shadow one")); ?>
											<?php echo $this->Html->image('icons/Linkedin.jpg', array("style" => "border:none;", "class" => 

"img-responsive shadow two")); ?>

										</a>
									</td>
									<td>
										 <a href="#">
											<?php echo $this->Html->image('icons/yah.png', array("style" => "border:none;", "class" => "img-responsive shadow one")); ?>
											<?php echo $this->Html->image('icons/Yahoo.jpg', array("style" => "border:none;", "class" => "img-responsive shadow two")); ?>

										</a>
									</td>
									<td></td>
									<td></td>
								</tr>
							</table>
						
					</div>
				</div>
			</div>
			<div style="float:left; width:100%;">
				<div class="blue" style="background:<?php echo !empty($color)?'#'.$color: '#243A62';?>;">
					
						<div class="col-lg-12 col-md-12 col-xs-12">

							<p>&nbsp;</p><p style="font-size:12px;text-transform:uppercase;">If you used your username to register
								before, please sign in below.</p>
						</div>

						<?php
						echo $this->Form->create('User', array(
							'url' => array(
								'controller' => 'websites', 'action' => 'site_login'
							),
							'inputDefaults' => array(
								'div' => false, 'class' => false, 'label' => false
							),
							'novalidate' => true,
							'id' => 'loginForm',
							'onSubmit' => 'return false;'
								)
						);
						?>
						<div class="col-lg-12 col-md-12 col-xs-12">
							<table width="100%">
								<tr>
									<td width="100%" align="left" style="font-size:16px;line-height:28px">Email:</td>
								</tr>
								<tr>
									<td width="100%" style="padding-bottom:10px;">
										<?php
										echo $this->Form->input('email', array(
											'type' => 'text',
											'class' => 'input-sm',
											'align' => 'left',
											'style' => 'width:100%;background-color:#7f8da6;border-top:1px solid #3e4551;border-left:1px solid 

#3e4551;border-right:1px solid #a3afc0;border-bottom:1px solid #a3afc0;',
											'autofocus' => true,
												)
										);
										?>

									</td>
								</tr>

								<tr>
									<td width="100%" style="font-size:16px;line-height:28px">Password:</td>
								</tr>
								<tr>
									<td width="100%">
										<?php
										echo $this->Form->input('password', array(
											'type' => 'password',
											'class' => 'input-sm',
											'align' => 'left',
											'style' => 'width:100%;background-color:#7f8da6;border-top:1px solid #3e4551;border-left:1px solid 

#3e4551;border-right:1px solid #a3afc0;border-bottom:1px solid #a3afc0;',
												)
										);
										?>

									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="left" width="100%">
										<?php
										echo $this->Form->submit('Sign-in', array(
											'align' => 'right',
											'style' => 'background-color:#ff6c1b;border:0;font-

size:16px;color:#fff;height:34px;width:120px;font-weight:bold;border-radius:3px 3px 3px 3px',
											'class' => false
												)
										);
										?>

									</td>
								</tr>
							</table>
						</div>
						<?php echo $this->Form->end(); ?>
					
					</form>
				</div>
			</div>
			<?php } ?>	
			<div class="clear"></div>
			<div class="inner-main-sec" style="margin-top:30px;">
			<table cellpadding="0" cellspacing="0" width="100%" class="white-box" >
					   	 	
					   	 <tr>
					   	 	<td>
						<div style="padding:5px 0 0 0" >
							<div class="user-title" >Follow us on twiltter</div>
							<div class="user">
								<img src="<?php echo $this->webroot.'img/twiiter_follow.jpeg'; ?>" alt="" style="width:64px;"/>
								<!-- cHANGE SOCIAL MEDIA FOLLOW BUTTON ID'S BELOW -->

								<a href="#" class="twitter-follow-button" data-show-

count="false" data-size="medium" data-show-screen-name="false" data-dnt="true" width="300px"><span id="unique_company_name"></span></a> 
								
							</div>
							<div class="clear"></div>
						</div>
					   	 	</td>
					   	 </tr>
					
					   	  <tr>
					   	 	<td>
					
					   	 	</td>
					   	 </tr>
					
					   	 <tr>
					   	 	<td>
					   	 		
						<div style="padding: 5px 0 0 0">
							<div class="user-title">Follow us on facebook</div>
							<div class="user">
								<!-- Place this tag where you want the widget to render. -->

								<img src="<?php echo $this->webroot.'img/fblike.jpeg'; ?>" alt="" style="width:64px;margin-top:-18px;"/>
							
							</div>
						</div>
					
					   	 	</td>
					   	 </tr>
					   	
					   </table>
			</div>
	</div>
</div>

