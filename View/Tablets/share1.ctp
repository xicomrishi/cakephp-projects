<?php if(!empty($slider_deal)) { ?>
                        <div class="sliderSec share-slider-new">
                                <ul class="bxslider">
					<?php 
							foreach($slider_deal as $slider) 
							{ 
								if(!empty($slider['AdminIcon']['image']) && file_exists(DEALSLIDER.$slider['AdminIcon']['image'])) 
								{
					?>
                                                                        <li>								
                                                                                <div class="tecket thanks-slider-nu">
                                                                                        <figure>
                                                                                                
												<?php 
														echo $this->Html->image(DEALSLIDERURL.$slider['AdminIcon']['image'], 
																					array(
																						'alt'=>$slider['AdminClientDeal']['deal_icon'],																				
																						'width'=>98, 'height'=>93
																					)
																				); 
												?>
                                                                                        </figure>
                                                                                        <div class="figure-info">
                                                                                                <h3><?php echo $this->Text->truncate($slider['Admin']['company'], '20', array('exact'=>true)); ?></h3>
                                                                                                <h3><?php echo $this->Text->truncate($slider['AdminClientDeal']['title'], '20', array('exact'=>true)); ?></h3>
                                                                                                <p>
													<?php //echo $this->Text->truncate($slider['AdminClientDeal']['description'], '80', array('exact'=>true)); ?>
                                                                                                </p>
                                                                                                <p>
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
                                                                                                </p>
                                                                                        </div>
                                                                                </div>	
                                                                        </li>
					<?php 		} 
							} 
					?>					
                                </ul>
                        </div>
                        <div class="index-popup share clinet_deal">
				<?php echo $this->Form->create('Share', array('id'=>'share')); ?>
				<?php echo $this->Form->input('type', array('type'=>'hidden', 'id'=>'type')); ?>
                                <div class="wrap">					
                                        <h4>Get other local deals by clicking, then sharing them below</h4>
                                        <div class="sliderSec">
                                                <ul class="bxslider2">
							<?php if(count($slider_deal) > 2) { ?>
								<?php 
										
										foreach($slider_deal as $key=>$slider_pop) 
										{ 
											
											if(!empty($slider_pop['AdminIcon']['image']) && file_exists(DEALSLIDER.$slider_pop['AdminIcon']['image'])) 
											{
								?>
											<?php if(($key+1) % 2 != 0) { ?>
                                                                                                <li>
											<?php } ?>								
                                                                                                        <div class="tecket remove-checkbox tecket-with-nopadding">
                                                                                                                <label>
                                                                                                                        <figure >
																<?php 	echo $this->Form->inut('MultiShare.ids.', array('type'=>'checkbox', 'value'=>$slider_pop['AdminClientDeal']['id'].'-'.$slider_pop['AdminClientDeal']['user_id'], 'class'=>'alt-d')); ?>
																<?php 
																		echo $this->Html->image(DEALSLIDERURL.$slider_pop['AdminIcon']['image'], 
																									array(
																										'alt'=>$slider_pop['AdminClientDeal']['deal_icon'],																				
																										'width'=>98, 'height'=>93,
																										'class'=>''
																									)
																								); 
																?>
                                                                                                                        </figure>
                                                                                                                
                                                                                                                        <div class="figure-info">
                                                                                                                                <h3><?php echo $this->Text->truncate($slider_pop['Admin']['company'], '20', array('exact'=>true)); ?></h3>
                                                                                                                                <h3><?php echo $slider_pop['AdminClientDeal']['title']; ?></h3>
                                                                                                                                <p>
																	<?php //echo $this->Text->truncate($slider_pop['AdminClientDeal']['description'], '80', array('exact'=>true)); ?>
                                                                                                                                
																	<?php 
																			if($slider_pop['AdminClientDeal']['type'] == 1)
																			{
																				echo 'Get '.$slider_pop['AdminClientDeal']['price'].'% off '.$slider_pop['AdminClientDeal']['product'];
																			}
																			else if($slider_pop['AdminClientDeal']['type'] == 2)
																			{
																				echo 'Get $'.$slider_pop['AdminClientDeal']['price'].' off '.$slider_pop['AdminClientDeal']['product'];
																			}
																			else if($slider_pop['AdminClientDeal']['type'] == 3)
																			{
																				echo 'Buy One Get One Free '.$slider_pop['AdminClientDeal']['product'];																
																			}
																			else
																			{
																				echo $slider_pop['AdminClientDeal']['product'];
																			}
																	?>
                                                                                                
                                                                                                                                </p>
                                                                                                                        </div>
                                                                                                                </label>
                                                                                                        </div>	
											<?php if(($key+1) % 2 == 0) { ?>
                                                                                                </li>
											<?php } ?>
								<?php 		} 
										} 
								?>
							<?php } else { ?>
								<?php 
										
										foreach($slider_deal as $key=>$slider_pop) 
										{ 
											
											if(!empty($slider_pop['AdminIcon']['image']) && file_exists(DEALSLIDER.$slider_pop['AdminIcon']['image'])) 
											{
								?>
                                                                                        
                                                                                                <li>
                                                                                                                                                
                                                                                                        <div class="tecket remove-checkbox tecket-with-nopadding">
                                                                                                                <label>
                                                                                                                        <figure >
																<?php 	echo $this->Form->inut('MultiShare.ids.', array('type'=>'checkbox', 'value'=>$slider_pop['AdminClientDeal']['id'].'-'.$slider_pop['AdminClientDeal']['user_id'], 'class'=>'alt-d')); ?>
																<?php 
																		echo $this->Html->image(DEALSLIDERURL.$slider_pop['AdminIcon']['image'], 
																									array(
																										'alt'=>$slider_pop['AdminClientDeal']['deal_icon'],																				
																										'width'=>98, 'height'=>93,
																										'class'=>''
																									)
																								); 
																?>
                                                                                                                        </figure>
                                                                                                                
                                                                                                                        <div class="figure-info">
                                                                                                                                <h3><?php echo $this->Text->truncate($slider_pop['Admin']['company'], '20', array('exact'=>true)); ?></h3>
                                                                                                                                <h3><?php echo $slider_pop['AdminClientDeal']['title']; ?></h3>
                                                                                                                                <p>
																	<?php //echo $this->Text->truncate($slider_pop['AdminClientDeal']['description'], '80', array('exact'=>true)); ?>
                                                                                                                                
																	<?php 
																			if($slider_pop['AdminClientDeal']['type'] == 1)
																			{
																				echo 'Get '.$slider_pop['AdminClientDeal']['price'].'% off '.$slider_pop['AdminClientDeal']['product'];
																			}
																			else if($slider['AdminClientDeal']['type'] == 2)
																			{
																				echo 'Get $'.$slider_pop['AdminClientDeal']['price'].' off '.$slider_pop['AdminClientDeal']['product'];
																			}
																			else if($slider_pop['AdminClientDeal']['type'] == 3)
																			{
																				echo 'Buy One Get One Free '.$slider_pop['AdminClientDeal']['product'];																
																			}
																			else
																			{
																				echo $slider_pop['AdminClientDeal']['product'];
																			}
																	?>
                                                                                                
                                                                                                                                </p>
                                                                                                                        </div>
                                                                                                                </label>
                                                                                                        </div>	
                                                                                        
                                                                                                </li>
                                                                                
								<?php 		} 
										} 
								?>
							<?php } ?>
                                                </ul>
                                        </div>
                                        <figure>
                                                <label class="error share-error"></label>
                                                
                                                <a class="share-more-deals">
							<?php echo $this->Html->image('share-btn.png', array('class'=>'share', 'alt'=>'share')); ?>
                                                </a>
                                        </figure>
                                        <a href="#" class="close"><span>X</span></a>
                                </div>	
                        </div>
                        <div id="overlay"></div>			
		<?php } ?>