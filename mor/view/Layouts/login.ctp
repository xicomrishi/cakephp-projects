<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->Html->charset(); ?>
<title><?php echo $title_for_layout; ?></title>
<?php
echo $this->Html->meta('icon');
echo $this->Html->css('cake.generic');
echo $this->Html->css('style');
echo $this->Html->css('form');
echo $this->Html->css('tables');
echo $this->Html->script('jquery.min');

echo $scripts_for_layout;
?>
</head>

<body>
<div id="wrapper">
<div id="header">
<noscript>
<div class="notice"><span>This is a Warning Notice!</span>
<p>You will need to enable JavaScript on your browser.</p>
</div>
</noscript>
<h3><a href="<?php echo $this->webroot;?>">
<img src="<?php echo $this->webroot;?>img/frontend/logo.png" alt="logo"/></a>
</h3>
</div><!-- [end]#header -->

<div id="menu"></div><!--[end]#menu -->


<div style="clear: both"></div>

<div id="middlepart">
<?php echo $this->Session->flash();
echo $this->Session->flash('auth');
?>
 <?php echo $content_for_layout; ?>

<?php //echo $this->element('sql_dump'); ?>
</div><!--[end]#middlepart -->
</div><!--[end]#wrapper -->

<div id="footer">
<p class="copyright">&copy; Copyright <?php echo date("Y"); ?> All rights reserved <br /></p>
</div>

</body>
</html>



