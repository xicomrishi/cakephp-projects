<?php
$siteDescription = __d('cake_dev', 'SnagPad');
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title> <?php echo $siteDescription ?>: <?php if(isset($agency['name'])){ echo $agency['name']; }else{ echo $title_for_layout; } ?> </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(array('style','nanoscroller'));
        echo $this->Html->script(array('jquery', 'jquery.validate.min','popup','jquery.tinyscrollbar','cycle_all','jquery.nanoscroller.min'));?>
           <!--[if IE]><?php echo $this->Html->script('ieh5fix');?></script><![endif]-->
        <?php
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
 <script type="text/javascript">
 $(function(){
	 $('.slider_container').cycle({
		 speed: 1000,
		 timeout:4000, 
  		fx: 'fade',
  	 pager: '.step_tabs',  
  		activePagerClass: 'active',
			pagerAnchorBuilder: function(idx, slide) {
		 return '.step_tabs li:eq(' + (idx) + ')';
		
 		}
		 
		 });
	 
	 });
	 
	function display_cms(page)
	{
		$.post('<?php echo SITE_URL;?>/info/index',{page_name:page},function(data){
				$('#body_container').html(data);
			});	
	} 
	 
 
 </script>    
    </head>
   <body>
   <section id="main_container">
<!--main_container_start_here-->
<section id="home_container">
<!--wrapper_start_here-->
<!--header_start_here-->
<section id="header_container">
<div class="home_wrapper">
<header>
  <?php echo $this->Html->link($this->Html->image('logo.png', array('alt' => $siteDescription, 'border' => '0')), SITE_URL, array('escape' => false, 'class' => 'logo')); ?>
  
  <span class="start_snagging">Better Process, Faster Placement</span>
  
  <section class="sign_in">
  <?php if($this->Session->check('Client')&&!isset($accept_terms)) { 
  echo $this->Html->link('MY ACCOUNT','/jobcards/index'); ?>
  <br />
  <?php
  echo $this->Html->link('SIGN OUT',array('controller'=>'users','action'=>'logout'));
  
  }else if($this->Session->check('Coach')){
	   echo $this->Html->link('MY ACCOUNT','/coach/index'); ?>
       <br />
       <?php 
  echo $this->Html->link('SIGN OUT',array('controller'=>'users','action'=>'logout'));
  }elseif($this->Session->check('usertype'))   echo $this->Html->link('SIGN OUT',array('controller'=>'users','action'=>'logout'));else{
  ?>
  <a href="javascript://" onclick="loadPopup('<?php echo SITE_URL;?>/users/login')">SIGN IN</a>
  <?php } ?>
  </section>
  </header>
  </div>
</section>
  
  <!--header_end_here-->

  <!--body_container_start_here-->
  <div class="home_wrapper">
  <section id="body_container">
    
       <?php echo $this->Session->flash(); ?>
<?php echo $this->fetch('content'); ?>
    
    
  </section>
  </div>
  <!--body_container_end_here-->
  <!--wrapper_end_here-->
  </section>
  <!--main_container_end_here-->
  
  <!--footer_start_here-->
  <section id="footer_container">
  <div class="home_wrapper">
  <footer>
  <section class="footer_link_box first">
  <h3>ABOUT</h3>
  <ul>
  <li><a href="<?php echo SITE_URL;?>/info/Why_SnagPad">Why SnagPad</a></li>
  <li><a href="<?php echo SITE_URL;?>/info/terms_of_service" onclick="display_cms('terms_of_service');">Terms of Service/Privacy</a></li>
  </ul>
  </section>
  
  <section class="footer_link_box second">
  <h3>EXTRAS</h3>
  <ul>
  <li><a href="http://jsb.myjobcards.com/blog" target="_blank">Blog</a></li>
  <li><a href="<?php echo SITE_URL;?>/info/online_training">Online Training</a></li>
  </ul>
  </section>
  
  <section class="footer_link_box third">
  <h3>SUPPORT</h3>
  <ul>
  <li><a href="<?php echo SITE_URL;?>/info/faq">FAQ</a></li>
  <li><a href="<?php echo SITE_URL;?>/info/addtoservices">SnagPad API</a></li>
  <li><a href="<?php echo SITE_URL;?>/info/contact_us">Contact Us</a></li>
  <li><?php echo $this->Html->link("Sign Up",array('controller' => 'users', 'action' => 'NewUser', 'full_base' => true), array('escape' => false)); ?></li>
  </ul>
  </section>
  
  <section class="social_links">
  
  <ul>
  <li> <?php echo $this->Html->link($this->Html->image('social_icon1.png', array('alt' => $siteDescription, 'border' => '0')), '#', array('escape' => false,'target'=>'_blank')); ?></li>
  <li class="last"><?php echo $this->Html->link($this->Html->image('social_icon2.png', array('alt' => $siteDescription, 'border' => '0')), 'http://www.youtube.com/user/snagpad', array('escape' => false,'target'=>'_blank')); ?></li>
  <li><?php echo $this->Html->link($this->Html->image('social_icon4.png', array('alt' => $siteDescription, 'border' => '0')), 'https://twitter.com/jobsearchboard', array('escape' => false,'target'=>'_blank')); ?></li>
  <li class="last"><?php echo $this->Html->link($this->Html->image('social_icon3.png', array('alt' => $siteDescription, 'border' => '0')), ' http://www.linkedin.com/company/2261060?goback=.fcs_GLHD_snagpad_false_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2&trk=ncsrch_hits', array('escape' => false,'target'=>'_blank')); ?></li>  
  </ul>
  </section>
  
  
  
  
  
  </footer>
   <?php echo $this->Html->link($this->Html->image('footer_logo.png', array('alt' => $siteDescription, 'border' => '0')), SITE_URL, array('escape' => false, 'class' => 'footer_logo')); ?>
   <span class="cpright">&copy;Copyright 2013.</span>
   <span class="cpright" style="width:100%; padding:10px 0 0 0; text-align:center">For Better User Experience Use IE9+, Firefox15+, Google Crome16+, Safari.</span>
   </div>
  </section>
  <!--footer_end_here-->
 
  <div id="jsbPopup"></div>
  <div id="backgroundPopup"></div>
  <?php 
if($this->Session->check('rand_key')==true && $this->Session->check('linksubmit')==false){
    echo "<script type='text/javascript'>loadPopup('".SITE_URL."/users/linked');</script>";
      }
?>  
</section>
</body>
</html>
