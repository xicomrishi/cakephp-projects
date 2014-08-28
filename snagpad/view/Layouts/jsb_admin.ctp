<?php
$siteDescription = __d('cake_dev', 'SnagPad');
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title> <?php echo $siteDescription ?>: <?php echo $title_for_layout; ?> </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(array('style','datepicker/jquery.ui.datepicker.min','datepicker/jquery.ui.theme.min','datepicker/jquery-ui.min'));
        echo $this->Html->script(array('jquery','jquery.validate.min','jquery.form','popup','datepicker/jquery.ui.core.min','fileupload/jquery.ui.widget','datepicker/jquery.ui.datepicker.min'));?>
           <!--[if IE]><?php echo $this->Html->script(array('ieh5fix','jquery.validate1.min'));?><![endif]-->
        <?php
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
     
    </head>
<body class="inner_body">
<section id="main_container">
  <div class="white_strip"></div>
  <div id="wrapper">
    <header><?php
        echo $this->element('header_admin');
        
        ?>
    </header>
    <section id="inner_body_container">
    	<?php echo $this->fetch('content');?>
    </section>
    
     </div>
      <div id="jsbPopup"></div>
        <div id="backgroundPopup"></div>
</section>


</body>
</html>    