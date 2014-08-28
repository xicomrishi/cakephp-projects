<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">   
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      
     	<title><?php echo $title_for_layout; ?></title>
		<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('frontend/style','frontend/responsive','frontend/jqtransform'));
		echo $this->Html->script(array('frontend/jquery-1.7.2.min','frontend/index','frontend/jquery.jqtransform'));
		echo $scripts_for_layout;
		?>		
		<!--[if IE 6]><?php echo $this->Html->script(array('frontend/jq-png-min'));?><![endif]-->
        <!--[if IE]><?php echo $this->Html->script(array('frontend/ieh5fix'));?><![endif]-->
   		
   		<script type="text/javascript" src="<?php echo $this->webroot;?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot;?>js/fancybox/jquery.fancybox-1.3.4.css" />
		 
        </head>
       
		<body>
        <section id="header_container">
            <div class="wrapper">
                 <!-- header area -->
                <?php echo $this->element('header.inc');?>
                <!-- /header area -->
            </div>
        </section>
        
        <section id="main_tab">
            <div class="wrapper">
                <!-- menu area -->
                <?php echo $this->element('main_menu.inc');?>
                <!-- /menu area -->
            </div>
        </section>
    
        <section class="main_container">
        	<div class="wrapper">
            	<!-- content area -->
            	<?php echo $this->Session->flash();				
            	?>
				<?php echo $content_for_layout; ?>
            	<!-- /content area -->
            </div>
        </section>
        
       <?php echo $this->element('footer.inc');?>
    </body>
</html>