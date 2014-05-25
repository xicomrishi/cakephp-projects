<?php
$siteDescription = __d('cake_dev', 'myGyFTR');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->Html->charset(); ?>
<title> <?php echo $siteDescription ?>: <?php echo $title_for_layout; ?> </title>
<?php
echo $this->Html->meta('icon');
echo $this->Html->css(array('cake.generic','style_admin','form','tables','validation'));
echo $this->Html->script(array('jquery-1.8.3','jquery.validationEngine','validation-en'));
//echo $scripts_for_layout;

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
<a href="<?php echo $this->webroot; ?>admin/recharge"><?php echo $this->Html->image('logo.png',array('escape'=>false,'alt'=>'','div'=>false));?></a>
</div><!-- [end]#header -->

<div id="menu"></div><!--[end]#menu -->


<div style="clear: both"></div>

<div id="middlepart">
<?php echo $this->Session->flash(); ?>
 <?php echo $content_for_layout; ?>

</div><!--[end]#middlepart -->
</div><!--[end]#wrapper -->


<div id="footer">
<p class="copyright">&copy; Copyright <?php echo date("Y"); ?> All rights reserved <br /></p>
</div>

</body>
</html>



