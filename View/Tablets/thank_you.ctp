<?php

echo $this->Html->script(array('jquery.bxslider.js'));
		echo '<link href=\'https://fonts.googleapis.com/css?family=Maven+Pro:500\' rel=\'stylesheet\' type=\'text/css\'>';
?>


<script type="text/javascript">
    $(document).ready(function() {

                <?php if(!empty($share_deal_id)) { ?>
        $.ajax({
            url: SITE_URL + 'tablets/post_message',
            type: 'POST',
            data: {'id': '<?php echo $share_deal_id;?>'},
            success: function() {

            }
        });
                <?php } ?>
        
          <?php 
          if(isset($slider_deal) && !empty($slider_deal)){
          ?>
        	 $('#popup1').fadeIn(500);
          	 $('.overlay_other').fadeIn();
        <?php }else{
        	if (isset($coupon)){ 
        	 ?>        
	        // popups
	     	 $('#popup').fadeIn(500);
	         $('.overlay_coupon').fadeIn();
	    <?php }} ?>	   
        
       
         
      
        
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

        $('.bxslider2').bxSlider({
            minSlides: 1,
            maxSlides: 1,
            slideWidth: 337,
            slideMargin: 10,
            autoHover: true,
            infiniteLoop: false,
            moveSlides: 2
        });


        $(document).on('click', ".alt-d", function() {
            if ($(this).is(":checked"))
            {
                $(this).parent().parent().addClass('grey-bg');
            }
            else
            {
                $(this).parent().parent().removeClass('grey-bg');
            }
        });

        $('.overlay_coupon ,.close_coupon').click(function(e) {
            $('.overlay').fadeOut();
            
            $('#popup1').fadeOut();
            $('#popup').fadeOut();
            e.preventDefault();
        });
        
         $('.overlay_other ,.close_other').click(function(e) {     	
         	
            $('.overlay_other').fadeOut();
          
            $('#popup').fadeOut();
            e.preventDefault();
            
             <?php if(isset($coupon)){ ?>        
		        // popups
		        setTimeout(function(){
		           $('#popup').fadeIn(500);
		           $('.overlay_coupon').fadeIn();
		        },1000);
	     
	        <?php } ?>
        });

        $(document).on("click", ".share-more-deals", function() {

            if ($(".alt-d").is(':checked') === true)
            {
                $.ajax({
                    url: SITE_URL + 'tablets/thank_you',
                    type: 'POST',
                    data: $("#share").serialize(),
                    beforeSend: function() {
                        $('.overlay_other').fadeOut();
                       
                        $('#popup1').fadeOut();
                         <?php if(isset($coupon)){ ?>        
					        // popups
					        setTimeout(function(){
					           $('#popup').fadeIn(500);
					           $('.overlay_coupon').fadeIn();
					        },1000);
				     
				        <?php } ?>
                    },
                    success: function() {
                    }
                });
            }
            else
            {
                $(".error").text("Please select at-least one deal to be share.");
            }

        });

        $(".gry").on('click', function() {
            OSName = '';
            if (navigator.platform.indexOf("iPad") != -1 || navigator.platform.indexOf("iPhone") != -1 || navigator.platform.indexOf("iPod") != -1) {
                OSName = "MacOS"
            }

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

        $("#close,.overlay").click(function() {
            $(".overlay,.share-popup").removeClass('active').fadeOut(500);

        });

    });
    
    function select_this_deal(id)
    {
    	id = id.split("_");
    	if($('.checkbox_'+id[1]).prop("checked"))
    	{	
    		$('.checkbox_'+id[1]).prop('checked',false);
    		$('#a_'+id[1]).removeClass('active');
    		$('#a_'+id[1]).css('background-color','');
    	}else{
    		
    		$('.checkbox_'+id[1]).prop('checked',true);
    		$('#a_'+id[1]).addClass('active');
    		$('#a_'+id[1]).css('background-color','#d9d9d9');
    	}
    }
</script>
<?php $bg = !empty($user_data['Admin']['bg_color'])?$user_data['Admin']['bg_color']:''; ?>
<?php $fore_color = !empty($user_data['Admin']['color'])?$user_data['Admin']['color']:''; ?>
<?php $font_color = !empty($user_data['Admin']['font_color'])?$user_data['Admin']['font_color']:'fff'; ?>
<style>
.profile-sec h1 {color: #<?php echo $font_color;  ?>;}
</style>

<div class="profile-outer">
<div class="profile-wrap" style="background-color:#<?php echo $bg; ?> !important; background:none;">
    <div class="pattern"  style="background: url('<?php echo $this->webroot.'img/textures/texture_'.$user_data['Admin']['bg_texture'].'.png'; ?>') repeat-x !important; ">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <section class="profile-sec">
                        <figure class="profile-pic">
                                   <?php 							
										if(!empty($loggedInUser['User']['image']) && file_exists(PROFILE.$loggedInUser['User']['image']))
										{
											echo $this->Html->image(PROFILEURL.$loggedInUser['User']['image'], array('alt'=>'loading image', 'style' => 'max-width: 182px; max-height: 182px;'));
										}
										else
										{
											echo $this->Html->image('no_image_available.jpg', array('alt'=>'loading image', 'style' => 'max-width: 182px; max-height: 182px;'));
										}					
								?>
                        </figure>
                        <h1>
                                <?php 				
										$username = trim($loggedInUser['User']['first_name']).' '.trim($loggedInUser['User']['last_name']); 
										$username = rtrim($username, " ");
						
									echo 'Thank you very much '.$username.' for using Social Referrals&trade;. We look forward to serving you in the future. You have been automatically logged out. Please click to Exit.'; 
								?>
                        </h1>
                    </section> 
                </div>
            </div>
        </div>
    </div>
</div>
<div class="profile-rating-wrap">
<div class="container">
    <div class="row">
        <div class="col-sm-12 thanku-rating">
        	<?php if(isset($coupon_count))
								{ ?>
            <div class="rating-box">
                <ul>
                   <?php  $cpn_count = 10;
						
							$cpn_count = $coupon_count;
							
                    	for($i=1; $i<=$cpn_count; $i++){	?>
                    		<li class="<?php if($share_count >= $i) echo 'active'; ?>"></li>
                    	<?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
        <section class="col-sm-12 thanku">
            <figure>
                    	<?php 
					
								if(!empty($deal['AdminClientDeal']['image']) && file_exists(DEAL.$deal['AdminClientDeal']['image']))
								{
									echo $this->Html->image(DEALURL.$deal['AdminClientDeal']['image'], array('alt'=>'thank you', 'class'=>'imglogout')); 
								}
								else
								{
									echo $this->Html->image('no_image_available_small.png', array('alt'=>'thank you' , 'class'=>'imglogout')); 
								}
						?>		

            </figure>
            <ul class="nav-buttons">                                           
                <li><a href="javascript://" class="gry"><i class="exit-icon icons"></i>Exit</a></li>                    
            </ul>
            <div class="clear"></div>
        </section>                
    </div>
</div>
    </div>
<div class="slider-sec">
    <div class="container" style="height: 190px;">
        <div class="row">
                	<?php if(!empty($slider_deal)){ ?>
            <section class=" col-sm-12">
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

<?php if (isset($coupon)){ ?>
<div class="overlay overlay_coupon"></div>
<div class="share-popup" id="popup">
    <span id="close" class="close_coupon">X</span>
    <h3><?php echo $coupon['Coupon']['title']; ?></h3>
    <div class="wrap">
        <figure style="text-align: center;">
            <img src="<?php echo $this->webroot.'img/coupons/'.$coupon['Coupon']['image']; ?>" alt="<?php echo $coupon['Coupon']['title'];?>" style="max-height:250px; max-width: 250px;"/>

        </figure>

        <div class="share-text" style="color:#333; text-align: center; padding: 10px 5%;">
		<?php 	echo $coupon['Coupon']['description'];	?>
		
					
        </div>
        <?php if(isset($user_coupon_details)){ ?>
        <div class="redeem_box">
        	<h2>Redeem Coupon</h2>
        	<img src="<?php echo $this->webroot.'img/QRcodes/'.$user_coupon_details['UserCoupon']['qr_image']; ?>" alt="" style="max-width:200px;" />
        	<div class="coupon_div">
        		<input type="hidden" id="user_code" name="user_code" value="<?php echo $user_coupon_details['UserCoupon']['code']; ?>">
        		<label>Enter Coupon here</label>
        		<input type="text" name="code" id="coupon_code" />
                        <a href="javascript://" onclick="redeem_coupon();" id="redeem_btn">Go</a>
        		<span class="msg_span" style="display:none;">Please wait...</span>
        		
        	</div>
        </div>
        <?php } ?>
    </div>
</div>	
		<?php } ?>
		
<?php if(isset($slider_deal) && !empty($slider_deal)) { ?>
	
	<div class="overlay overlay_other"></div>
        <div class="share-popup" id="popup1">
        	<?php echo $this->Form->create('Share', array('id'=>'share')); ?>
				<?php echo $this->Form->input('type', array('type'=>'hidden', 'id'=>'type')); ?>
            <span id="close" class="close_other">X</span>
            <h3>Get other local deals by clicking, then
                sharing them below</h3>
            <div class="slider-wrap">
						<ul class="slider-popup bxslider2">
							
								<?php 
										$count=0;
										foreach($slider_deal as $key=>$slider_pop) 
										{ 
											
											if(!empty($slider_pop['AdminIcon']['image']) && file_exists(DEALSLIDER.$slider_pop['AdminIcon']['image'])) 
											{
								
									?>		
											
											<?php if($count == 0){ ?>
												<li>
											<?php }  $count++;  ?>													
																	
	
													
														<a href="javascript://" onclick="select_this_deal(this.id);" id="a_<?php echo $slider_pop['AdminClientDeal']['id']; ?>">
															<figure >
																<?php 	echo $this->Form->inut('MultiShare.ids.', array('type'=>'checkbox', 'value'=>$slider_pop['AdminClientDeal']['id'].'-'.$slider_pop['AdminClientDeal']['user_id'], 
																																						'class'=>'alt-d checkbox_'.$slider_pop['AdminClientDeal']['id'])); ?>
																<?php 
																		echo $this->Html->image(DEALSLIDERURL.$slider_pop['AdminIcon']['image'], 
																									array(
																										'alt'=>$slider_pop['AdminClientDeal']['deal_icon'],																				
																										
																										'style' =>'max-height: 96px; max-width: 58px;',
																										'class'=>''
																									)
																								); 
																?>
															</figure>
														
															<article>
																<?php echo $this->Text->truncate($slider_pop['Admin']['company'], '20', array('exact'=>true)); ?><br>
																<?php echo $this->Text->truncate($slider_pop['AdminClientDeal']['title'], '20', array('exact'=>true)); ?><br>
																	
																	
																		<?php 
																				if($slider_pop['AdminClientDeal']['type'] == 1)
																				{
																					echo 'Get '.$slider_pop['AdminClientDeal']['price'].'% off '.$slider_pop['AdminClientDeal']['product'];
																				}
																				else if($slider_pop['AdminClientDeal']['type'] == 2)
																				{
																					echo 'Get $'.$slider_pop['AdminClientDeal']['price'].' off '.$slider_pop['AdminClientDeal']['product'];
																				}
																				else if($slider['AdminClientDeal']['type'] == 3)
																				{
																					echo 'Buy One Get One Free '.$slider_pop['AdminClientDeal']['product'];																
																				}
																				else
																				{
																					echo $slider_pop['AdminClientDeal']['product'];
																				}
																		?>	
	                                    	
															</article>
														</a>
														
											
												<?php if($count == 2){ ?>
												</li>
											<?php $count = 0; }    ?>	
										
								<?php 		} 
										} 
									if(count($slider_deal) % 2 != 0)
										echo '</li>';
								?>
						
						</ul>
			
            </div>
            <div class="text-center mt20">
            	<label class="error share-error"></label>
						
						<a class="share-more-deals" href="javascript://">
							<?php echo $this->Html->image('share-group.png', array('class'=>'share', 'alt'=>'share')); ?>
						</a>
                
            </div>    
        </div>
	<?php } ?>
 
</div>

<script type="text/javascript">
	
function redeem_coupon()
{
	var code = $('#coupon_code').val();
	var user_code = $('#user_code').val();
	if(code == "")
	{
		alert('Please enter coupon code');
	}else{
		$('#redeem_btn').hide();
		$('.msg_span').show();
		
		$.post('<?php echo $this->webroot.'tablets/redeem_coupon_code'; ?>',{ code: code, user_code: user_code}, function(data){
			$('.msg_span').html(data);
			$('#redeem_btn').show();
			$('#coupon_code').val('');
		});
	}
}
</script>