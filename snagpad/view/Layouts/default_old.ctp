<?php
$siteDescription = __d('cake_dev', 'JobSearchBoard');
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title> <?php echo $siteDescription ?>: <?php echo $title_for_layout; ?> </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('style');
        echo $this->Html->script(array('jquery', 'cufon-yui', 'jquery.validate.min','popup','jquery.tinyscrollbar'));?>
           <!--[if IE]><?php echo $this->Html->script('ieh5fix');?></script><![endif]-->
        <?php
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
     
    </head>
    <body>

        <!--main_container_start_here-->
        <section id="home_container">
            <!--wrapper_start_here-->
            <div class="wrapper">
                <!--header_start_here-->
                <header><?php echo $this->Html->link($this->Html->image('logo.png', array('alt' => $siteDescription, 'border' => '0')), SITE_URL, array('escape' => false, 'class' => 'logo')); ?>
                    <?php if (isset($user)) { ?>
                        <section class="sing_out_row">
                            Welcome <?php echo $user['name'];?><br />
                            <?php echo $this->Html->link('Logout',array('controller' => 'users', 'action' => 'logout', 'full_base' => true), array('escape' => false)); ?>
                        </section>
                    <?php } ?>
                    <section class="bottom_detail">
                        <section class="testomonial_box">
                            <p>I got surprised how only a few small suggestions can improve my skills</p>
                            <span>Susie Q.</span>
                        </section>
                        <section class="search_box">
                            <h1>Manage your<br />
                                <strong>Job Search</strong></h1>
                            <?php echo $this->Html->link("START NOW - IT'S FREE",array('controller' => 'users', 'action' => 'NewUser', 'full_base' => true), array('escape' => false,'class'=>'start_now_btn')); ?>
                           
                            <span>Already a member?  <a href="javascript://" onclick="loadPopup('<?php echo SITE_URL;?>/users/login')">Sign In</a></span>
                        </section>
                    </section>
                </header>
                <!--header_end_here-->

                <!--body_container_start_here-->
                <section id="body_container">
                    <section class="tips_box">
                        <section class="box">
                            <h3>Job Cards</h3>
                            <p>Convert job opportunities from friends, family and internet into powerful Job Cards.</p>
                        </section>

                        <section class="box">
                            <h3>Strategies</h3>
                            <p>Follow tactics that increase your odds of getting an interview and job offer.</p>
                        </section>

                        <section class="box last">
                            <h3>Challenges</h3>
                            <p>Take challenges that perfect your job search  -to get hired faster!</p>
                        </section>
                    </section>
                    <section class="submit_btn_row">
                         <?php echo $this->Html->link("DO YOU ASSIST JOB SEEKERS?",array('controller' => 'users', 'action' => 'create', 'full_base' => true), array('escape' => false)); ?>
                        
                    </section>
                </section>
                <!--body_container_end_here-->
            </div>
            <!--wrapper_end_here-->
        </section>
        <!--main_container_end_here-->

        <!--footer_start_here-->
        <section id="footer_container">
            <div class="wrapper">
                <footer>
                    <section class="footer_link_box first">
                        <h3>ABOUT</h3>
                        <ul>
                            <li><?php echo $this->Html->link("Why The Job Search Board",array('controller' => 'users', 'action' => 'create', 'full_base' => true), array('escape' => false)); ?></li>
                            <li><?php echo $this->Html->link("Terms of Service/Privacy",array('controller' => 'users', 'action' => 'create', 'full_base' => true), array('escape' => false)); ?></li>
                        </ul>
                    </section>

                    <section class="footer_link_box second">
                        <h3>EXTRAS</h3>
                        <ul>
                            <li><?php echo $this->Html->link("Blog",SITE_URL.'/blog', array('escape' => false)); ?></li>
                            <li><?php echo $this->Html->link("DO YOU ASSIST JOB SEEKERS?",array('controller' => 'users', 'action' => 'create', 'full_base' => true), array('escape' => false)); ?><a href="#">Online Training</a></li>
                        </ul>
                    </section>

                    <section class="footer_link_box third">
                        <h3>SUPPORT</h3>
                        <ul>
                            <li><?php echo $this->Html->link("FAQ",array('controller' => 'users', 'action' => 'create', 'full_base' => true), array('escape' => false)); ?></li>
                            <li><?php echo $this->Html->link("Job Search Board API",array('controller' => 'users', 'action' => 'create', 'full_base' => true), array('escape' => false)); ?></li>
                            <li><?php echo $this->Html->link("Contact Us",array('controller' => 'users', 'action' => 'create', 'full_base' => true), array('escape' => false)); ?></li>
                            <li><?php echo $this->Html->link("Sign Up",array('controller' => 'users', 'action' => 'NewUser', 'full_base' => true), array('escape' => false)); ?></li>
                        </ul>
                    </section>

                    <section class="social_links">

                        <ul>
                            <li>
                                <?php echo $this->Html->link($this->Html->image('social_icon1.png', array('alt' => $siteDescription, 'border' => '0')), '#', array('escape' => false)); ?>
                            </li>
                            <li class="last"><?php echo $this->Html->link($this->Html->image('social_icon2.png', array('alt' => $siteDescription, 'border' => '0')), '#', array('escape' => false)); ?></li>
                            <li><?php echo $this->Html->link($this->Html->image('social_icon4.png', array('alt' => $siteDescription, 'border' => '0')), '#', array('escape' => false)); ?></li>
                            <li class="last"><?php echo $this->Html->link($this->Html->image('social_icon3.png', array('alt' => $siteDescription, 'border' => '0')), '#', array('escape' => false)); ?></li>

                        </ul>
                    </section>






                </footer>
            </div>
        </section>
        <div id="jsbPopup"></div>
        <div id="backgroundPopup"></div>
        <!--footer_end_here-->
<?php 
if($this->Session->check('rand_key')==true && $this->Session->check('linksubmit')==false){
    echo "<script type='text/javascript'>loadPopup('".SITE_URL."/users/linked');</script>";
      }
?>      
      </body>
</html>
<?php echo $this->Session->flash(); ?>
<?php echo $this->fetch('content'); ?>