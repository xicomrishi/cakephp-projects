<?php
echo $this->Html->css(array(
    'bootstrap/3.0.0/css/bootstrap', 'bootstrap/3.0.0/css/bootstrap-theme.css',
    'bootstrap/3.0.0/css/bootstrap.min.css', 'bootstrap/3.0.0/css/carousel/carousel.css',
    'appt/style.css',
        )
);

echo $this->Html->script(array('/admin/js/additional-methods.min'));		
?>
<style>
<?php if(!empty($user_data['Admin']['bg_color'])) {
?> body {
background : #<?php echo $user_data['Admin']['bg_color'];
?>
}
<?php
}
?>
</style>
<div class="container">
<div class="row">
  <div class="col-md-3 col-xs-12 col-lg-3">
    <div class="shadow" style="margin-top:20px; margin-bottom:0px;"> <?php echo $this->Flash->show(); ?>
      <div style="background-color:<?php echo !empty($user_data['Admin']['color'])?'#'.$user_data['Admin']['color']: '#5aa3c8';?>; padding:10px;text-align:left; color:#FFF; border-radius:5px;font-size:16px;line-height:20px;min-height:125px" align="center"> 
        <!--XICOM CHANEGE CUSTOMER NAME HERE --> 
        <div style="float:left"><b style="font-size:28px; font-weight:bold;"> <?php echo isset($user_data['Admin']['company']) ? $user_data['Admin']['company'] : ''; ?> </b></div>
       <div style="float:right"> <figure class="deal-logo"><img src="<?php echo $this->webroot.'img/company/'.$user_data['Admin']['company_logo']; ?>"  alt="" style="max-width:100px;height:auto;" /> </figure></div>
      </div>
    </div>
    <table class="table col-lg-12 col-md-12 col-xs-12 main-table" style="width:100%;">
      
      <tr>
        <td align="left"><div class="white-box" style="width: 100%;">
            <p><span style="font-size:24px; font-weight:bold; line-height:24px; word-wrap: 

break-word;"><?php echo isset($user_data['AdminClientDeal']['description']) ? $user_data['AdminClientDeal']['description'] : '' ?></span></p>
            <button class="btn btn-primary btn-lg" style="margin-bottom:0px" 

id="submit_button1" onClick="javascript:updateLocation()">Enter Here!</button>
          </div></td>
      </tr>
      <tr>
        <td align="left"></td>
      </tr>
      <tr><!-- CHANGE CLIENT OFFER IMAGE HERE -->
        <td align="center"><div class="img-thumbnail">
            <?php
							if (!empty($user_data['AdminClientDeal']['image']) && file_exists(DEAL . 

$user_data['AdminClientDeal']['image'])) {
								echo $this->Html->image(DEALURL . $user_data['AdminClientDeal']['image'], 

array("class" => "img-responsive shadow"));
							} else {
								echo $this->Html->image('no_image_available.jpg', array("style" => "max-

width:325px", "class" => "img-responsive shadow"));
							}
							?>
          </div></td>
      </tr>
      <?php if(isset($user_data['AdminClientDeal']['disclaimer']) && !empty($user_data['AdminClientDeal']

['disclaimer'])){ ?>
      <tr>
        <td align="left"><div class="white-box" style="width: 100%;">
            <p style="width: 100%; word-wrap: break-word;"><span style="font-size:20px;line-height:9px; font-weight:bold;">Disclaimer</span><br>
              <span style="font-size:9px;"><?php echo isset($user_data['AdminClientDeal']['disclaimer']) ? 

$user_data['AdminClientDeal']['disclaimer'] : '' ?></span></p>
          </div></td>
      </tr>
      <?php } ?>
      <tr class="onlybig">
        <td class="inner-main-sec"  width="100%"></td>
      </tr>
      <?php /*
				<tr class="onlybig">
					<?php if ($user_data['Admin']['twitter_url'] != '') { ?>
						<td style="border-bottom:1px solid #89b7ce" width="100%">
							<div class="user-title" >Follow us on twitter</div>
							<div class="user">
								<!-- cHANGE SOCIAL MEDIA FOLLOW BUTTON ID'S BELOW -->

								<a href="https://twitter.com/<?php echo $user_data['Admin']

['twitter_url']; ?>" class="twitter-follow-button" data-show-

count="false" data-size="large" data-show-screen-name="false" data-dnt="true" width="300px">Follow @<?php echo $user_data['Admin']

['twitter_url']; ?></a> 
								<script>!function(d, s, id) {
														var js, fjs = 

d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 

'http' : 'https';
														if (!d.getElementById

(id)) {
															js = 

d.createElement(s);
															js.id = id;
															js.src = p + 

'://platform.twitter.com/widgets.js';
															

fjs.parentNode.insertBefore(js, fjs);
														}
													}(document, 'script', 'twitter-

wjs');</script>
							</div>
						</td>
					<?php } ?>
				</tr>
				<tr class="onlybig">
					<?php if ($user_data['Admin']['facebook_url'] != '') { ?>
						<td align="left" style="border-bottom:1px solid #89b7ce" height="47">
							<div class="user-title" style="line-height:24px;">Follow us on facebook</div>
							<div class="user">
								<?php $url = "//www.facebook.com/plugins/like.php?href=https%3A%2F

%2Fwww.facebook.com%2F" . $user_data['Admin']

['facebook_url'] . 

"&amp;width=100&amp;height=21&amp;colorscheme=light&amp;layout=button&amp;action=like&amp;show_faces=false&amp;send=false&amp;appId=55753

6137630811"; ?>
								<iframe src="<?php echo $url; ?>" scrolling="no" frameborder="0" 

style="border:none; overflow:hidden; width:100px; 

height:21px;zoom:100%;
										-moz-transform:scale(1.5);
										-moz-transform-origin: 0 0;
										-o-transform: scale(1.5);
										-o-transform-origin: 0 0;
										-webkit-transform: scale(1.5);
										-webkit-transform-origin: 0 0;
										-ms-transform: scale(1.5);
										-ms-transform-origin: 0 0;
										"></iframe>
							</div>
						</td>
					<?php } ?>
					</tr>
				<tr class="onlybig">
					<?php if ($user_data['Admin']['google_url'] != '') { ?>
						<td align="left"  >
							<div class="user-title">Follow us on Google plus</div>
							<div class="user">
								<!-- Place this tag where you want the widget to render. -->

								<div class="g-follow" data-annotation="bubble" data-height="24" data-

href="//plus.google.com/<?php echo $user_data['Admin']

['google_url'];?>" data-rel="publisher"></div>

								<!-- Place this tag after the last widget tag. --> 
								<script type="text/javascript">
									(function() {
										var po = document.createElement('script');
										po.type = 'text/javascript';
										po.async = true;
										po.src = 'https://apis.google.com/js/plusone.js';
										var s = document.getElementsByTagName('script')[0];
										s.parentNode.insertBefore(po, s);
									})();
								</script>
							</div>
						</td>
					<?php } ?>
				</tr>*/ ?>
      <tr>
        <td align="left"></td>
      </tr>
    </table>
  </div>
  
  <!--Thrre End-->
  <div class="clearfix visible-xs"></div>
  <div class="col-md-6 col-xs-12 col-lg-6 on-small" style="background:<?php echo !empty($user_data['Admin']['color'])?'#'.

$user_data['Admin']['color']: '#243A62';?>;">
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
          <?php $count = count($user_data['AdminClientSlider']); ?>
          <?php 
							if($count > 1) {
								for($j=0;$j<$count;$j++) { ?>
          <li data-target="#myCarousel" data-slide-to="<?php echo $j;?>" 

class="<?php echo ($j == 0) ? 'active' : '' ?>"></li>
          <?php 	} 
							}
						?>
        </ol>
        <div class="carousel-inner">
          <?php if (!empty($user_data['AdminClientSlider'])) { ?>
          <?php $i = 1;
								foreach ($user_data['AdminClientSlider'] as $slider) { ?>
          <div class="item <?php echo ($i == 1) ? 'active' : '' ?>">
            <?php
									if (!empty($slider['image']) && file_exists(SLIDER . 

LARGESLIDER.$slider['image'])) {
										echo $this->Html->image(SLIDERURL . LARGESLIDER.$slider

['image']);
									}
									else if (!empty($slider['image']) && file_exists(SLIDER .$slider

['image'])) {
										echo $this->Html->image(SLIDERURL . $slider['image']);
									} 
									else {
										echo $this->Html->image('no_image_available.jpg', array

());
									}
									?>
            <div class="container">
              <div class="carousel-caption"> 
                <!-- <h1>Experienced</h1> --> 
                
                <?php echo $slider['text']; ?> </div>
            </div>
          </div>
          <?php $i++;
							} ?>
          <?php } else { ?>
          <div class="item active"> <?php echo $this->Html->image('no_image_available.jpg', array()); 

?>
            <div class="container">
              <div class="carousel-caption"> 
                <!-- <h1>Experienced</h1> --> 
                
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
        <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon 

glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon 

glyphicon-chevron-right"></span></a> </div>
    </div>
    <!-- /.carousel -->
    
    <div class="col-lg-12 col-md-12 col-xs-12">
      <?php 
				if(!empty($user_data['Admin']['feed_graber']))
				{
					echo $user_data['Admin']['feed_graber']; 
				}
				else
				{
					?>
      <div class="domain_map" style="margin-bottom: 22px;">
        <iframe width="100%" height="360" style="border:4px solid #8EC1DA" frameborder="0" 

scrolling="no" marginheight="0" marginwidth="0" 
							src="https://maps.google.com/maps?q=<?php echo urlencode($user_data['Admin']['latitude']); ?>,<?php echo urlencode($user_data['Admin']['longitude']); ?>&hl=en&amp;z=16&amp;t=m&amp;iwloc=A&amp;output=embed"> </iframe>
      </div>
      <?php
				}
				?>
    </div>
  </div>
  <div class="clearfix visible-xs"></div>
  <div class="col-lg-3 col-md-3 col-xs-12">
    <div style="margin-top:20px">
      <?php if($user_data['Admin']['display_form_type'] == 3){ ?>
      <div style="width:100%;">
        <div class="blue" style="background:<?php echo !empty($user_data['Admin']['color'])?'#'.

$user_data['Admin']['color']: '#243A62';?>;">
          <div class="col-lg-12 col-md-12 col-xs-12 upload_img">
            <table width="100%">
              <tr>
                <td><a href="<?php if(!empty($user_data['Admin']

['website_image_url'])) echo $user_data['Admin']['website_image_url']; else echo 'javascript://'; ?>" target="_blank"> <img src="<?php echo $this->webroot.'img/company/'.$user_data

['Admin']['website_image']; ?>" alt=""/> </a></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <?php }else if($user_data['Admin']['display_form_type'] == 2){  ?>
      <div style="width:100%;">
        <div class="blue" style="background:<?php echo !empty($user_data['Admin']['color'])?'#'.$user_data['Admin']['color']: '#243A62';?>;border-radius:5px 5px 5px 5px;">
          <div class="col-lg-12 col-md-12 col-xs-12">
            <h2 align="left" class="shadow"><b style="text-

transform:uppercase">Contact Form</b></h2>
            <p>&nbsp;</p>
            <p style="font-size:12px;text-transform:uppercase;">*All 
              
              fields are required.</p>
            <p></p>
            <p style="font-size:13px;" id="contactFormMsg"></p>
          </div>
          <?php
								echo $this->Form->create('UserAppointment', array(
									'url' => array(
										'controller' => 'websites', 'action' => 

'appointment_contact'
									),
									'inputDefaults' => array(
										'div' => false, 'class' => false, 'label' => false
									),
									'novalidate' => true,
									'id' => 'contactForm'
										)
								);
								
								echo $this->Form->input('client_id',array('type'=>'hidden', 'value'=> 

$user_data['Admin']['id']));
								echo $this->Form->input('contact_type',array('type'=>'hidden', 'value'=> 

'2'));
								?>
          <div class="col-lg-12 col-md-12 col-xs-12">
            <table width="100%">
              <tr>
                <td width="100%" align="left" style="font-

size:16px;line-height:28px">Name:</td>
              </tr>
              <tr>
                <td width="100%" style="padding-bottom:10px;"><?php
											echo $this->Form->input('name', array(
												'type' => 'text',
												'class' => 'input-sm',
												'align' => 'left',
												'style' => 'width:100%;background-

color:#7f8da6;border-top:1px solid #3e4551;border-left:1px solid 
	
	#3e4551;border-right:1px solid #a3afc0;border-bottom:1px solid #a3afc0;',
												'autofocus' => true,
													)
											);
											?></td>
              </tr>
              <tr>
                <td width="100%" align="left" style="font-

size:16px;line-height:28px">Email:</td>
              </tr>
              <tr>
                <td width="100%" style="padding-bottom:10px;"><?php
											echo $this->Form->input('email', array(
												'type' => 'text',
												'class' => 'input-sm',
												'align' => 'left',
												'style' => 'width:100%;background-

color:#7f8da6;border-top:1px solid #3e4551;border-left:1px solid 
	
	#3e4551;border-right:1px solid #a3afc0;border-bottom:1px solid #a3afc0;',
												'autofocus' => true,
													)
											);
											?></td>
              </tr>
              <tr>
                <td width="100%" align="left" style="font-

size:16px;line-height:28px">Subject:</td>
              </tr>
              <tr>
                <td width="100%" style="padding-bottom:10px;"><?php
											echo $this->Form->input('subject', array(
												'type' => 'text',
												'class' => 'input-sm',
												'align' => 'left',
												'style' => 'width:100%;background-

color:#7f8da6;border-top:1px solid #3e4551;border-left:1px solid 
	
	#3e4551;border-right:1px solid #a3afc0;border-bottom:1px solid #a3afc0;',
												'autofocus' => true,
													)
											);
											?></td>
              </tr>
              <tr>
                <td width="100%" align="left" style="font-

size:16px;line-height:28px">Message:</td>
              </tr>
              <tr>
                <td width="100%" style="padding-bottom:10px;"><?php
											echo $this->Form->input('message', array(
												'type' => 'textarea',
												'class' => 'input-sm',
												'align' => 'left',
												'style' => 'width:100%;background-

color:#7f8da6;border-top:1px solid #3e4551;border-left:1px solid 
	
	#3e4551;border-right:1px solid #a3afc0;border-bottom:1px solid #a3afc0;',
												'autofocus' => true,
													)
											);
											?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="left" width="100%"><?php
											echo $this->Form->submit('Submit', array(
												'align' => 'right',
												'id' => 'contactFormSubmit',
												'style' => 'background-color:#ff6c1b;float:left;border:0;font-size:16px;color:#fff;height:34px;width:120px;font-weight:bold;border-radius:3px 3px 3px 3px','class' => false));?>
                  <span id="contactFormLoader" style="display: 

none; font-size: 14px;">Please wait...</span></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <?php } else { ?>
      <div class="white">
        <div class="col-lg-12 col-md-12 col-xs-12">
          <h1 align="left" class="shadow"><b style="text-

transform:uppercase">"Appointments"</b></h1>
          <p style="font-size:12px;text-transform:uppercase"> To make an appointment AND SAVE <?php echo !empty($user_data['AdminClientDeal']) 

? $user_data['AdminClientDeal']['price'] : '0'; ?>, 
            
            please use
            any of the options below. </p>
          <br/>
        </div>
        <div class="col-lg-12 col-md-12 col-xs-12">
          <?php if ($this->Session->read('Auth.User.id') == '') { ?>
          <table width="100%" border="0" cellpadding="auto" class="imgSec">
            <tr>
              <td><a href="<?php echo SITE_URL; ?>domain/register"> <?php echo $this->Html->image('icons/mgs.png', 

array("style" => "border:none;", "class" => "img-responsive shadow one")); ?> <?php echo $this->Html->image('icons/Email.jpg', 

array("style" => "border:none;", "class" => "img-responsive shadow two")); ?> </a></td>
              <td><a href="<?php echo SITE_URL; ?>domain/login/facebook/web"> <?php echo $this->Html->image('icons/fb.png', 

array("style" => "border:none;", "class" => "img-responsive shadow one")); ?> <?php echo $this->Html->image

('icons/Facebook.jpg', array("style" => "border:none;", "class" => 

"img-responsive shadow two")); ?> </a></td>
              <td><a href="<?php echo SITE_URL; ?>domain/login/twitter/web"> <?php echo $this->Html->image('icons/twr.png', 

array("style" => "border:none;", "class" => "img-responsive shadow one")); ?> <?php echo $this->Html->image

('icons/Twitter.jpg', array("style" => "border:none;", "class" => 

"img-responsive shadow two")); ?> </a></td>
              <td><a href="<?php echo SITE_URL; ?>domain/login/google/web"> <?php echo $this->Html->image('icons/gog.png', 

array("style" => "border:none;", "class" => "img-responsive shadow one")); ?> <?php echo $this->Html->image

('icons/Google_Plus.jpg', array("style" => "border:none;", "class" => 

"img-responsive shadow two")); ?> </a></td>
            </tr>
            <tr>
              <td><p>&nbsp;</p></td>
              <td><p>&nbsp;</p></td>
              <td><p>&nbsp;</p></td>
              <td><p>&nbsp;</p></td>
            </tr>
            <tr>
              <td><a href="<?php echo SITE_URL; ?>domain/LinkedinLogin/web"> <?php echo $this->Html->image('icons/inn.png', 

array("style" => "border:none;", "class" => "img-responsive shadow one")); ?> <?php echo $this->Html->image

('icons/Linkedin.jpg', array("style" => "border:none;", "class" => 

"img-responsive shadow two")); ?> </a></td>
              <td><a href="<?php echo SITE_URL; ?>domain/login/yahoo/web"> <?php echo $this->Html->image('icons/yah.png', 

array("style" => "border:none;", "class" => "img-responsive shadow one")); ?> <?php echo $this->Html->image('icons/Yahoo.jpg', 

array("style" => "border:none;", "class" => "img-responsive shadow two")); ?> </a></td>
              <td></td>
              <td></td>
            </tr>
          </table>
          <?php } ?>
        </div>
      </div>
    </div>
    <div style="width:100%;">
      <div class="blue" style="background:<?php echo !empty($user_data['Admin']['color'])?'#'.$user_data

['Admin']['color']: '#243A62';?>;">
        <?php if ($this->Session->read('Auth.User.id') == '') { ?>
        <div class="col-lg-12 col-md-12 col-xs-12">
          <p>&nbsp;</p>
          <p style="font-size:12px;text-transform:uppercase;">If you used your 
            
            username to register
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
							'id' => 'loginForm'
								)
						);
						?>
        <div class="col-lg-12 col-md-12 col-xs-12">
          <table width="100%">
            <tr>
              <td width="100%" align="left" style="font-size:16px;line-

height:28px">Email:</td>
            </tr>
            <tr>
              <td width="100%" style="padding-bottom:10px;"><?php
										echo $this->Form->input('email', array(
											'type' => 'text',
											'class' => 'input-sm',
											'align' => 'left',
											'style' => 'width:100%;background-

color:#7f8da6;border-top:1px solid #3e4551;border-left:1px solid 

#3e4551;border-right:1px solid #a3afc0;border-bottom:1px solid #a3afc0;',
											'autofocus' => true,
												)
										);
										?></td>
            </tr>
            <tr>
              <td width="100%" style="font-size:16px;line-

height:28px">Password:</td>
            </tr>
            <tr>
              <td width="100%"><?php
										echo $this->Form->input('password', array(
											'type' => 'password',
											'class' => 'input-sm',
											'align' => 'left',
											'style' => 'width:100%;background-

color:#7f8da6;border-top:1px solid #3e4551;border-left:1px solid 

#3e4551;border-right:1px solid #a3afc0;border-bottom:1px solid #a3afc0;',
												)
										);
										?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="left" width="100%"><?php
										echo $this->Form->submit('Sign-in', array(
											'align' => 'right',
											'style' => 'background-

color:#ff6c1b;border:0;font-size:16px;height:34px;width:120px;font-weight:bold;border-radius:3px 3px 3px 3px',
											'class' => false
												)
										);
										?></td>
            </tr>
          </table>
        </div>
        <?php echo $this->Form->end(); ?>
        <?php } else { ?>
        <?php echo $this->Html->link('Logout', array('controller' => 'domain', 'action' => 

'logout'),array('class'=> 'pink-btn')); ?> <?php echo $this->Html->link('Appointment', array('controller' => 'websites', 'action' => 

'profile'),array('class'=> 'pink-btn')); ?>
        <?php } ?>
        </form>
      </div>
    </div>
    <?php } ?>
    <div class="clear"></div>
    <div class="inner-main-sec" style="margin-top:30px;width:100%">
      <table cellpadding="0" cellspacing="0" width="100%" class="white-box" >
        <?php if ($user_data['Admin']['twitter_url'] != '') { ?>
        <tr>
          <td><div style="padding:5px 0 0 0" >
              <div class="user-title" >Follow us on twiltter</div>
              <div class="user"> 
                <!-- cHANGE SOCIAL MEDIA FOLLOW BUTTON ID'S BELOW --> 
                
                <a href="https://twitter.com/<?php echo $user_data['Admin']

['twitter_url']; ?>" class="twitter-follow-button" data-show-count="false" data-size="medium" data-show-screen-name="false" data-

dnt="true" width="300px">Follow @<?php echo $user_data['Admin']['twitter_url']; ?></a> 
                <script>!function(d, s, id) {
														var js, fjs = 

d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 

'http' : 'https';
														if (!d.getElementById

(id)) {
															js = 

d.createElement(s);
															js.id = id;
															js.src = p + 

'://platform.twitter.com/widgets.js';
															

fjs.parentNode.insertBefore(js, fjs);
														}
													}(document, 'script', 'twitter-wjs');</script> 
              </div>
              <div class="clear"></div>
            </div></td>
        </tr>
        <?php } ?>
        <?php if ($user_data['Admin']['facebook_url'] != '') { ?>
        <tr>
          <td><div style="padding:5px 0 0 0">
              <div class="user-title" style="line-height:24px;">Follow us on facebook</div>
              <div class="user user-fb">
                <?php $url = "//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2F" . $user_data['Admin']['facebook_url'] ."&amp;width=100&amp;height=21&amp;colorscheme=light&amp;layout=button&amp;action=like&amp;show_faces=false&amp;send=false&amp;appId=557536137630811"; ?>
                <iframe src="<?php echo $url; ?>" scrolling="no" frameborder="0" 

style="border:none; overflow:hidden; width:100px; 

height:21px;zoom:100%;
										-moz-transform:scale(1.5);
										-moz-transform-origin: 0 0;
										-o-transform: scale(1.5);
										-o-transform-origin: 0 0;
										-webkit-transform: scale(1.5);
										-webkit-transform-origin: 0 0;
										-ms-transform: scale(1.5);
										-ms-transform-origin: 0 0;
										"></iframe>
                <div class="clear"></div>
              </div>
              <div class="clear"></div>
            </div></td>
        </tr>
        <?php } ?>
        <?php if ($user_data['Admin']['google_url'] != '') { ?>
        <tr>
          <td><div style="padding: 5px 0 0 0">
              <div class="user-title">Follow us on Google plus</div>
              <div class="user"> 
                <!-- Place this tag where you want the widget to render. -->
                
                <div class="g-follow" data-annotation="bubble" data-height="24" data-href="//plus.google.com/<?php echo $user_data['Admin']['google_url'];?>" data-rel="publisher"></div>
                
                <!-- Place this tag after the last widget tag. --> 
                <script type="text/javascript">
									(function() {
										var po = document.createElement('script');
										po.type = 'text/javascript';
										po.async = true;
										po.src = 'https://apis.google.com/js/plusone.js';
										var s = document.getElementsByTagName('script')[0];
										s.parentNode.insertBefore(po, s);
									})();
								</script> 
              </div>
            </div></td>
        </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">
function updateLocation()
{
    window.location.href = SITE_URL + 'domain/check_auth/tab';
}
$("#loginForm").validate({
    rules: {
        "data[User][email]": {
            required: true,
            email: true
        },
        "data[User][password]": {
            required: true
        }
    }
});

$("#contactForm").validate({
    rules: {
    	
        "data[UserAppointment][name]": {
            required: true
        },
        "data[UserAppointment][email]": {
            required: true,
            email: true
        },
        
        "data[UserAppointment][subject]": {
            required: true
        },
        "data[UserAppointment][message]": {
            required: true
        },
        
    },
    submitHandler: function(){
    	
    	$('#contactFormSubmit').hide();
    	$('#contactFormLoader').show();
    	$.post('<?php echo $this->webroot.'websites/appointment_contact'; ?>', $('#contactForm').serialize(), function(data){
    		if(data == "success")
    			$('#contactFormMsg').html('Your message has been sent. We will contact you soon.');
    		else 
    			$('#contactFormMsg').html('There is some issue. Please try again later.');
    			
    		$('#contactFormSubmit').show();
    		$('#contactFormLoader').hide();
    		
    		document.getElementById('contactForm').reset();
    		return false;
    	});
    }
});

$("#ImgForm").validate({
    rules: {    	
        "data[UserAppointment][image]": {
        	extension : "jpe?g|png",
            required: true
        }
     },   
        messages: { 
				
					"data[UserAppointment][image]" : {
					extension : "Only jpeg, jpg, png files allowed."
				}
		   
    },
    submitHandler: function(){
    		//alert(1);
    		document.getElementById('ImgForm').submit();  	
    }
});
</script> 
