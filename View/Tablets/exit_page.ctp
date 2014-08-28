<?php 
		echo $this->Html->script(array('jquery.bxslider.js'));
		//echo '<link href=\'https://fonts.googleapis.com/css?family=Maven+Pro:500\' rel=\'stylesheet\' type=\'text/css\'>';
?>
<script>
	$(document).ready(function() {
		$('.bxslider').bxSlider({
			minSlides: 1,
			maxSlides: 2,
			slideWidth: 440,
			slideMargin: 13			
		});
		
		$(".gry").on('click', function(){
			OSName = '';
			if (navigator.platform.indexOf("iPad") != -1 || navigator.platform.indexOf("iPhone") != -1 || navigator.platform.indexOf("iPod") != -1) { OSName = "MacOS";	}
			window.location.href = '<?php echo SITE_URL.'domain/logout/tab'; ?>';
			//Android.logout();
			/*if(OSName == 'MacOS')
			{
				window.location = 'socialreferral://logout';
			}
			else
			{
				Android.logout();
			}*/
		});
			
	});
	
	
</script>
<?php $bg = !empty($user_data['Admin']['bg_color'])?$user_data['Admin']['bg_color']:''; ?>
<?php $fore_color = !empty($user_data['Admin']['color'])?$user_data['Admin']['color']:''; ?>
<?php $font_color = !empty($user_data['Admin']['font_color'])?$user_data['Admin']['font_color']:'fff'; ?>
<style>
.profile-sec h1 {color: #<?php echo $font_color;  ?>;}
</style>

<div class="profile-wrap"  style="background-color:#<?php echo $bg; ?> !important; background:none;">
            <div class="pattern"   style="background: url('<?php echo $this->webroot.'img/textures/texture_'.$user_data['Admin']['bg_texture'].'.png'; ?>') repeat-x !important; ">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <section class="profile-sec">
                                <figure class="profile-pic">
                                    <?php 
											if(!empty($loggedInUser['User']['image']) && file_exists(PROFILE.$loggedInUser['User']['image']))
											{
												echo $this->Html->image(PROFILEURL.$loggedInUser['User']['image'], array('alt'=>'loading image','width'=>170, 'height' => 170));
											}
											else if(isset($user) && !empty($user['User']['image'])){												
												
												echo $this->Html->image(PROFILEURL.$user['User']['image'], array('alt'=>'loading image','width'=>170, 'height' => 170));
										
											}else
											{
												echo $this->Html->image('no_image_available.jpg', array('alt'=>'loading image', 'width' => 170, 'height' => 170));
											}
									?>
                                </figure>
                                <?php 				
										$username = trim($loggedInUser['User']['first_name']).' '.trim($loggedInUser['User']['last_name']); 
										$username = rtrim($username, " ");
								?>
								<?php if($num == 0){ ?>
                                <h1>We are sorry to see you go <?php echo $username; ?>. If you would like another chance to access your Deal, please click the "Exit" button and start over. Thank you. </h1>
                            	<?php }else{ ?>
                            		<h1>We are sorry to see you go <?php echo $username; ?>. You need to provide required facebook permissions to continue, please click the "Exit" button and start over. Thank you. </h1>
                            	
                            	<?php } ?>	
                            </section> 
                        </div>
                    </div>            
                </div>            
            </div>            
        </div>   

        <div class="container">
            <div class="row">
                <section class="exit-section">
                    <ul class="nav-buttons">                                           
                        <li><a href="javascript://" class="gry"><i class="exit-icon icons"></i>Exit</a></li>                    
                    </ul>
                    <figure>
                   
                    	<img src="<?php echo $this->webroot; ?>img/exit-page-img.jpg" alt="" />
                    </figure>
                </section>                
            </div>
        </div>
        <div class="footer-wrap">
            <footer class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <p><strong>Want this App?</strong>  Call 1800-SocialEyes. Turn Your Business into a Social Referral Center!</p>
                        </div>  
                    </div>
                </div>
            </footer>
        </div>


