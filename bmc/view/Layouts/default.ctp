<?php
$cakeDescription = __d('cake_dev', 'BMC-Global');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('style','validation','jquery.fancybox','nanoscroll','jquery-ui-1.9.2.custom.min'));
		
		echo $this->Html->script(array('jquery','nanoScroller','jquery.fancybox','validation-en','jquery.validationEngine','jquery-ui-1.9.2.custom.min','index'));
	?>
    <!--[if IE 6]><?php echo $this->Html->script('jq-png-min');?><![endif]-->
     <!--[if IE 6]><?php echo $this->Html->script('ieh5fix');?><![endif]-->
     <script type="text/javascript">
	 $(document).ready(function(e) {
		 
        $(':input').focus(function(e) {
            $('form').validationEngine('hideAll');
        });
    });
	 </script>
</head>
<body>
<?php
if($this->Session->read('User.type')=='Participant')
	$ele='header_participant';
else if($this->Session->read('User.type')=='Trainer')
  $ele='header_trainer';
else 
	$ele='header'; 
	
  echo $this->element($ele);		
?>	
	<?php echo $content_for_layout; ?>
</body>
</html>
