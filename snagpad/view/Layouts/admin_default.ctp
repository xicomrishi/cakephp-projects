<?php
$siteDescription = __d('cake_dev', 'SnagPad Admin');
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title> <?php echo $siteDescription ?>: <?php echo $title_for_layout; ?> </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(array('style','nanoscroller'));
        echo $this->Html->script(array('jquery', 'jquery.validate.min','popup','jquery.nanoscroller.min'));?>
           <!--[if IE]><?php echo $this->Html->script('ieh5fix');?></script><![endif]-->
        <?php
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
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
  </header>
  </div>
</section>
  
  <!--header_end_here-->

  <!--body_container_start_here-->
  <div class="home_wrapper">
<?php echo $this->fetch('content'); ?>
  </div>
  <!--body_container_end_here-->
  <!--wrapper_end_here-->
  </section>
  <!--main_container_end_here-->
  <div id="jsbPopup"></div>
  <div id="backgroundPopup"></div>
</section>
</body>
</html>
