<?php 
		echo $this->Html->script(array('jquery.ba-cond.min', 'jquery.slitslider'));		
		echo $this->Html->script(array('jquery.bxslider.js'));
?>
<script type="text/javascript">	
		
	$(function() {
		var Page = (function() {
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
		})();
		Page.init();
		
	}); 
	
	function on_resize() {
		var heightwindow = parseInt($(window).height());
		var _width = $(this).width();
		
			$('#slider, .sl-content-wrapper').css('height', heightwindow);
			
		
	}
	
	$(window).resize( function(){
		on_resize();
	});
	$(document).ready(function() {
		$('.bxslider').bxSlider({
			minSlides: 1,
			maxSlides: 2,
			slideWidth: 440,
			slideMargin: 13,
		});
		on_resize();
	})
</script>

<?php $bg = !empty($user_data['Admin']['bg_color'])?$user_data['Admin']['bg_color']:''; ?>

<div class="page-width landing-slider" style="background-color:#<?php echo $bg?>;">
	<div class="slider-text">
		<div class="take-content">
			<h2 class="take-content-h visible-div"> Enter to save!</h2>
			<h2 class="off-content-h">Choose Your Deal Below!</h2>
		</div>
	</div>
	<div class="demo-2">
		<div id="slider" class="sl-slider-wrapper">
			
			<div class="sl-slider">
				<div class="sl-slide" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
					<div class="sl-slide-inner">
						<div class="bg-img bg-img-2"></div>
												
					</div>
				</div>
				<div class="sl-slide" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
					<div class="sl-slide-inner">
						<div class="bg-img bg-img-2"></div>
						
						
					</div>
				</div>					
			</div>			
		</div>
		
		<div class="page-logo">
			<div class="test">
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
</div>

