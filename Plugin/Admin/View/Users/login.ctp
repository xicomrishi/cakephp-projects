 <?php echo $this->Form->create(); ?>
     <!--Admin logn section Start from Here-->
    <div id="login-box">
      <div class="white-box" style="width:325px; padding-top:60px;">
        <div class="tl">
          <div class="tr">
            <div class="tm"> </div>
          </div>
        </div>
        <div class="ml">
          <div class="mr">
            <div class="middle">
              <div class="lb-data">
                <h1>Login</h1>
                <p class="top15 gray12">Please enter a valid username and password to gain access to the console.</p>
                <?php echo $this->Session->flash('auth'); ?>
                <p class="top5">
					<?php echo $this->Form->input('username'); ?>
                </p>
                <p class="top15">
					<?php echo $this->Form->input('password'); ?>
                </p>
                <div class="top15">
					<div class="floatright">
						<div class="black_btn2">
							<span class="upper"> 
								<?php echo $this->Form->submit('Submit'); ?>
							</span>
						</div>
					</div>
                </div>
				 <?php echo $this->Html->link('Forgot Password?', array('controller' => 'users', 'action' => 'forget_password'),array('class'=> 'pink-btn')); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="bl">
          <div class="br">
            <div class="bm">&nbsp;</div>
          </div>
        </div>
      </div>
    </div>
 <?php echo $this->Form->end(); ?>
