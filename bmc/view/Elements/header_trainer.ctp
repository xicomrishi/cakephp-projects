<section id="header_container"><?php ?>
  <div class="wrapper">
  <header>
  <a href="<?php echo $this->webroot; ?>dashboard/trainer_home" class="logo"><img src="<?php echo $this->webroot; ?>img/logo.png" alt=""></a>
  
<div class="profile-box">
						<span class="profile" onClick="$(this).toggleClass('active');">
							<a href="javascript://" class="section">
							
								<span class="text-box">
									<?php echo __('Welcome'); ?>
									<strong class="name"><?php echo $this->Session->read('User.User.first_name').' '.$this->Session->read('User.User.last_name'); ?></strong>
								</span>
							</a>
							<a href="javascript://" class="opener">opener</a>
                           
                            <div class="drop_down">
                            <div class="drop_down_inner">
                                <a href="javascript://" onClick="open_lightbox('/trainer/edit_trainer/<?php echo $this->Session->read('User.Trainer.Trainer.id'); ?>',985);" id="acc-details"><?php echo __('Personal details'); ?> </a>
                                <div class="clear">&nbsp;</div>
                                <div class="seprator">&nbsp;</div>
                                <a href="javascript://" onClick="open_lightbox('/users/edit_settings/<?php echo $this->Session->read('User.User.id'); ?>',300);" id="acc-settings"><?php echo __('Settings'); ?></a>
                                <div class="clear">&nbsp;</div>
                            
                            </div>
                            </div>
							
						</span>
						<a href="<?php echo $this->webroot; ?>users/logout" class="btn-on"><?php echo __('logout'); ?></a>
					</div>
  </header>
      </div>
</section>