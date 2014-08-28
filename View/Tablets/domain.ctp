<?php 
		echo $this->Html->script(array('jquery.ba-cond.min', 'jquery.slitslider'));		
		echo $this->Html->script(array('jquery.bxslider.js'));
                echo $this->Html->script(array('browser_and_os_classes.js'));

?>
<script type="text/javascript">	
		

		
	$(function() {
		
		 var quotes = $(".choose-deals");
	    var quoteIndex = -1;
	
	    function showNextQuote() {
	        ++quoteIndex;
	        quotes.eq(quoteIndex % quotes.length)
	            .fadeIn(1000)
	            .delay(1500)
	            .fadeOut(1000, showNextQuote);
	    }
	
	    showNextQuote();    
		
					
		/*var Page = (function() {
			var $nav = $( '#nav-dots > span' ),
				slitslider = $( '#slider' ).slitslider( {
					onBeforeChange : function( slide, pos ) {
						$nav.removeClass( 'nav-dot-current' );
						$nav.eq( pos ).addClass( 'nav-dot-current' );
						if($(".take-content-h").hasClass('visible-div'))
						{
							$(".off-content-h").addClass('visible-div').fadeIn(0);
							$(".take-content-h").removeClass('visible-div').fadeOut(0);
						}
						else if($(".off-content-h").hasClass('visible-div'))
						{
							$(".take-content-h").addClass('visible-div').fadeIn(0);
							$(".off-content-h").removeClass('visible-div').fadeOut(0);
						}
					},
					onAfterChange : function(){
					}
				} ),

				init = function() {
					initEvents();
				},
				initEvents = function() {
					$nav.each( function( i ) {
						$( this ).on( 'click', function( event ) {
							var $dot = $( this );
							if( !slitslider.isActive() ) {
							$nav.removeClass( 'nav-dot-current' );
								$dot.addClass( 'nav-dot-current' );
							}
							slitslider.jump( i + 1 );
							return false;
						} );
					} );
				};
				return { init : init };
		})(); */
		//Page.init();
		
	}); 
	
	function on_resize() {
		var heightwindow = parseInt($(window).height());
		var _width = $(this).width();
		
			$('#slider, .sl-content-wrapper').css('height', heightwindow+20);
			
		
	}
	
	$(window).resize( function(){
		//on_resize();               
	});
	$(document).ready(function() {
//            $('.pattern').height($('.login-wrap').height());
	 
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
	            slideMargin: 10
	            //pager: false
	        });
	    }
      //  on_resize();        
	 /*	$('.bxslider').bxSlider({
			minSlides: 1,
			maxSlides: 2,
			slideWidth: 440,
			slideMargin:11 ,
		});
		on_resize();*/
	});
	
	
	
	
	<?php if(!$this->Session->check('coupon_location_good')) { ?>
		getLocation();
	<?php } ?>
	
	function getLocation() {
	    if (navigator.geolocation) {
	        navigator.geolocation.getCurrentPosition(showPosition,showError);
	    } else { 
	        x.innerHTML = "Geolocation is not supported by this browser.";
	    }
	}
	
	function showPosition(position) {
		var lat = position.coords.latitude; 
	    var longitude = position.coords.longitude;	
	   // console.log(position);
	    $.post('<?php echo $this->webroot.'tablets/checkLocation'; ?>',{ latitude: lat, longitude:longitude }, function(data){
	    //	console.log(data);
	    });
	}
	
	function showError(error) {
		var err=null;
	    switch(error.code) {
	        case error.PERMISSION_DENIED:
	            err = "User denied the request for Geolocation."
	            break;
	        case error.POSITION_UNAVAILABLE:
	            err = "Location information is unavailable."
	            break;
	        case error.TIMEOUT:
	            err = "The request to get user location timed out."
	            break;
	        case error.UNKNOWN_ERROR:
	            err = "An unknown error occurred."
	            break;
	    }
	    //console.log(err);
	}
</script>

<style>
	/*.deal-logo{ height:auto;}*/
</style>

<iframe src="https://social-referrals.com/viveksharma" height="600" width="600" target="_parent"></iframe>


<?php $bg = !empty($user_data['Admin']['bg_color'])?$user_data['Admin']['bg_color']:''; ?>
<?php $fore_color = !empty($user_data['Admin']['color'])?$user_data['Admin']['color']:''; ?>
<?php $font_color = !empty($user_data['Admin']['font_color'])?$user_data['Admin']['font_color']:'fff'; ?>
<div class="login-wrap" style="background-color:#<?php echo $bg; ?> !important; background:none;">
	<div class="pattern" style="background: url('<?php echo $this->webroot.'img/textures/texture_'.$user_data['Admin']['bg_texture'].'.png'; ?>') repeat 0 0!important;">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12 dls" style="word-wrap: break-word;">
                                    <figure class="deal-logo">
                                        <img src="<?php echo $this->webroot.'img/company/'.$user_data['Admin']['company_logo']; ?>"  alt="" />
                                    </figure>
                                    <h1 class="choose-deals" style="height:215px; color:#<?php echo $font_color; ?>;">
                                    	<?php 
												if ($user_data['Admin']['tablet_url'] == 'GNPCC') {
													echo '<span style="font-size:80%">GNPCC Presents the Make it ViRAL</span>' ; 
												}else if( !empty($user_data['Admin']['main_page_text_1']) ) {
													echo $user_data['Admin']['main_page_text_1']; 
												}else{ echo 'Enter to save!'; } 
										?>
									</h1>
									<h1 class="choose-deals" style="height: 215px; color:#<?php echo $font_color; ?>; display: none;">
										<?php if ($user_data['Admin']['tablet_url']  == 'GNPCC') 
													echo '92nd Annual Business Expo'; 
											 else if( !empty($user_data['Admin']['main_page_text_2']) ) 
											 		echo $user_data['Admin']['main_page_text_2']; 
											 else echo 'Choose Your Deal Below!'; ?>
									</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" landing-page-slider">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">                        
                                <div class="slider-wrap">
                                    <ul class="bxslider">
                                    	<?php 
												foreach($user_data['AdminClientDeal'] as $deal) 
												{
													if(!empty($deal['AdminIcon']['image']) && file_exists(DEALSLIDER.$deal['AdminIcon']['image'])) 
													{
										?>
                                        <li>
                                        	  <?php 
													if($deal['type'] == 1)
													{
														$txt = 'Get '.$deal['price'].'% off '.$deal['product'];
													}
													else if($deal['type'] == 2)
													{
														$txt = 'Get $'.$deal['price'].' off '.$deal['product'];
													}
													else if($deal['type'] == 3)
													{
														$txt = 'Buy One Get One Free '.$deal['product'];
													}
													else
													{
														$txt = $deal['product'];
													}
											
												
											?>
                                            <a href="<?php echo SITE_URL.'tablets/login/'.$deal['id']; ?>" title="<?php echo $txt; ?>">
                                                <figure>
                                                    <?php 
															echo $this->Html->image(DEALSLIDERURL.$deal['AdminIcon']['image'], 
																						array(
																							'alt'=>$deal['AdminIcon']['image'],																				
																							'style'=>'max-width:58px; max-height: 96px;'																							
																						)
																					); 
													?>
                                                </figure>
                                              
                                                <article>
                                                	<?php echo $this->Text->truncate($this->Session->read('Client.company'), '20', array('exact'=>true)); ?><br>
                                                	<?php echo $deal['title']; ?><br>
                                                	<?php 
															
															echo $this->Text->truncate($txt, '38', array('exact'=>true));
														?>
                                                </article>
                                            </a>
                                        </li>
                                        <?php 		} 
												} 
										?>
                                       
                                    </ul>
                                </div>                                         
                            </div>                
                        </div>  
                    </div>  
                </div>  
                <div class="footer-wrap landing-page">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <footer class="footer col-sm-12">
                                    <a href="#" class="text-center" ><img src="<?php echo $this->webroot.'img/powered-by.png'; ?>" alt="" /></a>
                                </footer>  
                            </div>                   
                        </div>    
                    </div>
                    <div class="clear"></div>
                </div>
               <div class="clear"></div>
            </div> 
    <div class="clear"></div>
</div>	
<div class="clear"></div>

<!--<div class="page-width landing-slider" style="background-color:#<?php echo $bg; ?>;">
	<div class="slider-text">
		<div class="take-content">
			<h2 class="take-content-h visible-div" style="color:#<?php echo $font_color; ?> !important;">
					<?php 
						if ($tablet_url == 'GNPCC') {
							echo '<span style="font-size:80%">GNPCC Presents the Make it ViRAL</span>' ; 
						}else if( !empty($user_data['Admin']['main_page_text_1']) ) {
							echo $user_data['Admin']['main_page_text_1']; 
						}else{ echo 'Enter to save!'; } ?>
			</h2>			
			<h2 class="off-content-h" style="color:#<?php echo $font_color; ?> !important;">
				<?php if ($tablet_url == 'GNPCC') 
							echo '92nd Annual Business Expo'; 
					 else if( !empty($user_data['Admin']['main_page_text_2']) ) 
					 		echo $user_data['Admin']['main_page_text_2']; 
					 else echo 'Choose Your Deal Below!'; ?>
			</h2></div>
	</div>
	<div class="demo-2">
		<div id="slider" class="sl-slider-wrapper">
			
			<div class="sl-slider">
				<div class="sl-slide" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
					<div class="sl-slide-inner">
						<div class="bg-img bg-img-2" style="background: url('<?php echo $this->webroot.'img/textures/texture_'.$user_data['Admin']['bg_texture'].'.png'; ?>') repeat-x !important; "></div>
												
					</div>
				</div>
				<div class="sl-slide" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
					<div class="sl-slide-inner">
						<div class="bg-img bg-img-2" style="background: url('<?php echo $this->webroot.'img/textures/texture_'.$user_data['Admin']['bg_texture'].'.png'; ?>') repeat-x !important; "></div>
						
						
					</div>
				</div>					
			</div>			
		</div>
		
		<div class="page-logo">
			<div class="test" style="background-color:#<?php echo $fore_color?>;">
			<div class="sliderSec landing-slider-bottom">
				<ul class="bxslider">
					<?php 
							foreach($user_data['AdminClientDeal'] as $deal) 
							{
								if(!empty($deal['AdminIcon']['image']) && file_exists(DEALSLIDER.$deal['AdminIcon']['image'])) 
								{
					?>
									<li>
										<a href="<?php echo SITE_URL.'tablets/login/'.$deal['id']; ?>">
											<div class="tecket">
												<figure>
													<?php 
															echo $this->Html->image(DEALSLIDERURL.$deal['AdminIcon']['image'], 
																						array(
																							'alt'=>$deal['AdminIcon']['image'],																				
																							'width'=>98, 'height'=>93																							
																						)
																					); 
													?>
												</figure>
												<div class="figure-info">
													<h3><?php echo $this->Text->truncate($this->Session->read('Client.company'), '20', array('exact'=>true)); ?></h3>
													<h3><?php echo $deal['title']; ?></h3>
													<p>
														<?php //echo $this->Text->truncate($deal['description'], '90', array('exact'=>true)); ?>
														<?php 
																if($deal['type'] == 1)
																{
																	echo 'Get '.$deal['price'].'% off '.$deal['product'];
																}
																else if($deal['type'] == 2)
																{
																	echo 'Get $'.$deal['price'].' off '.$deal['product'];
																}
																else if($deal['type'] == 3)
																{
																	echo 'Buy One Get One Free '.$deal['product'];
																}
																else
																{
																	echo $deal['product'];
																}
														?>
													</p>
												</div>
											</div>
										</a>								
									</li>
					<?php 		} 
							} 
					?>
				</ul>
			</div>
		</div>	
			<?php echo $this->Html->image('powered-by.png', array('width'=>"616", 'height'=>"60", 'alt'=>"powerd by social by"));?>			
		</div>
	</div>	
</div>-->
