<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->Html->charset(); ?>
<title><?php echo $title_for_layout; ?></title>
<?php
echo $this->Html->meta('icon');
//echo $this->Html->css('cake.generic');
echo $this->Html->css('frontend/style');
echo $this->Html->css('frontend/jquery.fancybox');
echo $this->Html->css('frontend/extra');
echo $this->Html->css('frontend/validationEngine.jquery');
?>
<!--[if IE 6]><?php echo $this->Html->script(array('frontend/jq-png-min'));?><![endif]-->
<!--[if IE]><?php echo $this->Html->script(array('frontend/ieh5fix'));?></script><![endif]-->
<?php 
echo $this->Html->script(array('frontend/jquery','frontend/hoverCard','frontend/index',
'frontend/jquery.fancybox','frontend/jquery.validationEngine','frontend/jquery.validationEngine-en'));
echo $scripts_for_layout;
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
</head>

<body>
<noscript>
<div class="notice"><p>This is a Warning Notice! You will need to enable JavaScript on your browser.</p></div>
</noscript>
<?php echo $this->element('feedback');?>
<?php echo $this->element('header');?>
<?php echo $content_for_layout; ?>
<?php echo $this->element('footer');?>
</body>
<script type="text/javascript">
$(function(){
if (navigator.appName == 'Microsoft Internet Explorer'){
$('input[placeholder]').each(function(){  
			var input = $(this);        
			$(input).val(input.attr('placeholder'));
						
			$(input).focus(function(){
				if (input.val() == input.attr('placeholder')) {
				   input.val('');
				}
			});
				
			$(input).blur(function(){
			   if (input.val() == '' || input.val() == input.attr('placeholder')) {
				   input.val(input.attr('placeholder'));
			   }
			});
		});
}
});
</script>
</html>