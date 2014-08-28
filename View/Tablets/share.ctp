<?php 
		echo $this->Html->script(array('jquery.bxslider.js'));
		//echo '<link href=\'https://fonts.googleapis.com/css?family=Maven+Pro:500\' rel=\'stylesheet\' type=\'text/css\'>';
?>
<script src="https://platform.twitter.com/widgets.js"></script>
<script>
	$(document).ready(function() {
							
		
		 $('.slider-popup').bxSlider({
            minSlides: 1,
            maxSlides: 1,
            slideWidth: 337,
            slideMargin: 10
            
           
        });
        if ($(window).width() > 767) {
	        $('.bxslider').bxSlider({
	            minSlides: 2,
	            maxSlides: 2,
	            slideWidth: 337,
	            slideMargin: 10
	            //pager: false
	        });
	    }
	    else {
	        $('.bxslider').bxSlider({
	            minSlides: 1,
	            maxSlides: 1,
	            slideWidth: 337,
	            slideMargin: 10,
                     adaptiveHeight: true
	            //pager: false
	        });
	    }
						
		/*$('.preview').click(function(e) {
			$('#overlay').fadeIn();
			$('.view_deal').fadeIn();
			e.preventDefault();
		});
		
		$('#overlay ,.close').click(function(e) {
			$('#overlay').fadeOut();
			$('.index-popup').fadeOut();
			e.preventDefault();
		});*/
		
		 // popups
        $(".call-popup").click(function() {
            $('div.share-poup').fadeOut(500).delay(500);
            var popup = $($(this).attr("href"));
            $(".overlay").fadeIn(500);
            popup.fadeIn(500);
            return false;
        });

        $("#close,.overlay").click(function() {
            $(".overlay,.share-popup").removeClass('active').fadeOut(500);

        });
		
		
	});
	
	function share(value)
	{			
		$("#share").submit();		
	}
	
	
</script>

<?php $bg = !empty($user_data['Admin']['bg_color'])?$user_data['Admin']['bg_color']:''; ?>
<?php $fore_color = !empty($user_data['Admin']['color'])?$user_data['Admin']['color']:''; ?>
<?php $font_color = !empty($user_data['Admin']['font_color'])?$user_data['Admin']['font_color']:'fff'; ?>
<style>
.profile-sec h1 {color: #<?php echo $font_color;  ?>;}
</style>
 <div class="profile-container">
            <div class="profile-wrap"  style="background-color:#<?php echo $bg; ?> !important; background:none;">
                <div class="pattern" style="background: url('<?php echo $this->webroot.'img/textures/texture_'.$user_data['Admin']['bg_texture'].'.png'; ?>') repeat-x !important; ">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <section class="profile-sec">
                                    <figure class="profile-pic">
                                        <?php 
												if(!empty($loggedInUser['User']['image']) && file_exists(PROFILE.$loggedInUser['User']['image']))
												{
													echo $this->Html->image(PROFILEURL.$loggedInUser['User']['image'], array('alt'=>'loading image', 'width' => 170, 'height' => 170));
												}
												else
												{
													echo $this->Html->image('no_image_available.jpg', array('alt'=>'No image', 'class'=>'circle small'));
												}
										?>
                                    </figure>
                                    <?php 				
											$username = trim($loggedInUser['User']['first_name']).' '.trim($loggedInUser['User']['last_name']); 
											$username = rtrim($username, " ");
									?>
                                    <h1>Hi <?php echo $username; ?>, <?php echo $client_details['Admin']['company']; ?> would like you to share  with all 
                                    	<?php 
												if($this->Session->read('LoginType') == 'facebook')
												{
													echo $loggedInUser['User']['fb_friends'] != 0?$loggedInUser['User']['fb_friends']:'';
												}
												else if($this->Session->read('LoginType') == 'twitter')
												{
													echo $loggedInUser['User']['tw_friends'] != 0?$loggedInUser['User']['tw_friends']:'';
												}
										?> 	 of your 
										<?php 							
												if($deal['AdminClientDeal']['type'] == 1)
												{
													echo 'friends ';
												}
												else if($deal['AdminClientDeal']['type'] == 2)
												{
													echo 'friends ';
												}
												else if($deal['AdminClientDeal']['type'] == 3)
												{
													echo 'friends ';
												}
												else
												{
													echo 'friends ';
												}
										?>! Please follow the 2 steps below. Thank you.</h1>
                                </section> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rating-sec">
                <div class="container">
                    <div class="row">
                        <section class="col-sm-12">
                        	<?php if(isset($coupon_count))
								{ ?>
                            <div class="rating-box">
                                <ul>
                                <?php  
                                	$cpn_count = 10;
									
										$cpn_count = $coupon_count;
										
                                	for($i=1; $i<=$cpn_count; $i++){	?>
                                		<li class="<?php if($share_count >= $i) echo 'active'; ?>"></li>
                                	<?php } ?>
                                   
                                </ul>
                            </div>
                            <?php } ?>
                       
                            <ul class="users">
                            	 <li class="fb-like">
                                    <?php if(isset($already_liked)){
                                    						if($this->Session->read('LoginType') == 'twitter'){
                                    							echo '<strong><span class="num">1.</span> <span class="text">Skip -> <small>Already Followed!</small></span></strong>';
                                    						}else{
																 echo '<strong><span class="num">1.</span> <span class="text">Skip -> <small>Already Liked!</small></span></strong>'; 
															}
													}else{  ?>
														<strong>1. </strong>
													<?php } ?>		
													
                                  
                                    	<?php 
											if($client_details != '') { 
												if($this->Session->read('LoginType') == 'facebook')
												{
													if(!isset($already_liked)){
									?>
													<span class="step-shape-blue">
																		
														
															  <?php $url = "//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2F".$client_details['Admin']['facebook_url']."&amp;width=250&amp;height=250&amp;colorscheme=light&amp;layout=button&amp;action=like&amp;show_faces=false&amp;send=false&amp;appId=249418735228119"; ?>
															<iframe id="facebook-share" src="<?php echo $url; ?>" scrolling="no" class="facebook_share" frameborder="0" style="border:none; overflow:hidden; width:150px; height:90px;zoom:100%;"></iframe>
																													
													</span>
									
									<?php 		}} 
												else if($this->Session->read('LoginType') == 'twitter')
												{  if(!isset($already_liked)){
									?>				
													<span class="sky-blue">	
														
														<iframe id="twitter-widget-0" class="facebook_share" allowtransparency="true" src="https://platform.twitter.com/widgets/follow_button.1384205748.html#_=1384850333975&dnt=true&id=twitter-widget-0&lang=en&screen_name=<?php echo $client_details['Admin']['twitter_url'];?>&show_count=false&show_screen_name=false&size=xl" class="twitter-follow-button shadow twitter-follow-button nothidden iframy shadow1 iframytwit" title="Twitter Follow Button" data-twttr-rendered="false" style="border:none; right:32px; overflow:hidden; width:58px; height:20px;-webkit-border-radius: 3px; border-radius: 3px;" frameborder="0" scrolling="no"></iframe>
													</span>
									<?php		}}	
										}	
									?>
                                        <!--<img src="images/fb-thumb.png" alt="" />
                                        <label>Like</label>-->
                                  
                                </li>
                               
                                
                                <li class="group-share">
                                	<?php 
											echo $this->Form->create('Share', array('id'=>'share'));
												echo $this->Form->input('id', array('type'=>'hidden'));
									?>
												<a href="javascript:share()" class='light-red'>
													<img src="<?php echo $this->webroot; ?>img/step2.jpg" alt="" />	
												</a>
									<?php	echo $this->Form->end(); ?>
                                    
                                </li>

                            </ul>
                        </section>                
                    </div>
                     
                </div>
                <ul class="nav-buttons">                    
                                <li><a href="#popup" class="preview-toggle call-popup" ><i class="preview-icon icons"></i>Preview</a></li>
                                <?php if(!empty($deal['AdminClientDeal']['disclaimer'])){ ?><li><a href="#popup_disclaimer" class="preview-toggle call-popup" style="top:49px;"><i class=""></i>Disclaimer</a></li>
                               <?php } ?>
                                <li><a href="<?php echo $this->webroot.'tablets/exit_page'; ?>" class="exit-toggle"><i class="exit-icon icons"></i>Exit</a></li>                    
                            </ul>
            </div>
            <div class="slider-sec">
                <div class="container" style="height: 140px;">
                	
                    <div class="row">
                    	<?php if(!empty($slider_deal)) { ?>
                        <section class="col-sm-12">
                            <h2>Local Business Deals</h2>
                            <div class="slider-wrap">
                               <ul class="bxslider">
	                          <?php 
									foreach($slider_deal as $slider) 
									{ 
										if(!empty($slider['AdminIcon']['image']) && file_exists(DEALSLIDER.$slider['AdminIcon']['image'])) 
										{
							?>
	                                <li>
	                                	<a href="<?php echo 'javascript://' //echo SITE_URL.$slider['Admin']['company']; ?>">
	                                    <figure>
	                                       	<?php 
												echo $this->Html->image(DEALSLIDERURL.$slider['AdminIcon']['image'], 
																			array(
																				'alt'=>$slider['AdminClientDeal']['deal_icon'],																				
																					'style'=>'max-width:58px; max-height: 96px;'
																			)
																		); 
										?>
	                                    </figure>
	                                    <article>
	                                     <?php echo $this->Text->truncate($slider['Admin']['company'], '20', array('exact'=>true)); ?><br>
										<?php echo $this->Text->truncate($slider['AdminClientDeal']['title'], '20', array('exact'=>true)); ?><br>
											
											
												<?php 
														if($slider['AdminClientDeal']['type'] == 1)
														{
															echo 'Get '.$slider['AdminClientDeal']['price'].'% off '.$slider['AdminClientDeal']['product'];
														}
														else if($slider['AdminClientDeal']['type'] == 2)
														{
															echo 'Get $'.$slider['AdminClientDeal']['price'].' off '.$slider['AdminClientDeal']['product'];
														}
														else if($slider['AdminClientDeal']['type'] == 3)
														{
															echo 'Buy One Get One Free '.$slider['AdminClientDeal']['product'];																
														}
														else
														{
															echo $slider['AdminClientDeal']['product'];
														}
												?>	
	                                    	
	                                        
	                                    </article>
	                                    </a>
	                                </li>
	                           <?php 
										}
									}
	                           ?>                      
	                            </ul>
                            </div>
                            <div class="clear"></div>
                        </section>     
                       <?php } ?>            
                    </div>
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
        </div>
        <div class="overlay"></div>
        <div class="share-popup" id="popup">
            <span id="close">X</span>
            <!--<h3>Get other local deals by clicking, then
                sharing them below</h3>-->
              <div class="wrap">
				<figure style="text-align: center;">
					<?php echo $this->Html->image(DEALURL.$deal['AdminClientDeal']['image'], 
													array(
														'alt'=>$deal['AdminClientDeal']['title'],
														'style' => 'max-width: 250px; max-height: 250px;'
														
													)
												); 
					?>
				</figure>
				
				<div class="share-text" style="color:#333; text-align: center">
					<?php 
							if($this->Session->read('LoginType') == 'facebook')
							{
								$fb_message = str_replace('{LAST_NAME}',$frontuser['last_name'],str_replace('{FIRST_NAME}',$frontuser['first_name'], $fb_message));
					?>			
								<h3>What will be posted on your facebook wall?</h3>
								<p style="font-weight: 200;"><?php echo $fb_message; ?></p>
					<?php	}
							else if($this->Session->read('LoginType') == 'twitter')
							{
								$tw_message = str_replace('{LAST_NAME}',$frontuser['last_name'],str_replace('{FIRST_NAME}',$frontuser['first_name'], $tw_message));
					
					?>			<h3>What will be posted on your twitter wall?</h3>
								<p style="font-weight: 200"><?php echo $tw_message; ?></p>
					<?php	}
					?>
				</div>
			</div>
		</div>
		
		<div class="share-popup" id="popup_disclaimer">
            <span id="close">X</span>
            
              <div class="wrap">
								
				<div class="share-text" style="color:#333; text-align: center">
						
					<h3>Disclaimer</h3>
					<p style="font-weight: 200;"><?php echo $deal['AdminClientDeal']['disclaimer']; ?></p>
					
				</div>
			</div>
		</div>	
  

<style>
.facebook_content {
    float: left;
    height: 40px;
    margin: 36px 9px;
    overflow: hidden;
    width: 66px;
}

.twitter_content {
    float: left;
    height: 29px;
    margin: -56px 18px;
    overflow: hidden;
    width: 74px;
    border-radius:5px;
    }

.twitter_content a {
    background: none repeat scroll 0 0 transparent;
    border: medium none;
    display:none;
}
.xl .btn .label {    padding: 0 8px 0 24px !important;}
.xl .btn i{ left :2px!important;}

</style>
