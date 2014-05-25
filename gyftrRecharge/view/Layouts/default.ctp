<?php

$cakeDescription = __d('cake_dev', 'MyGyFTR');
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
		echo $this->Html->css(array('bootstrap','fonts','validation','jquery-ui-css'));
		echo $this->Html->script(array('jquery-1.8.3','jquery.validationEngine','validation-en','jquery-ui.min','index'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
<script type="text/javascript">
$(document).ready(function(e) {
    $('input,select').blur(function(e) {
			$(this).css('border','');
			$(this).css('box-shadow','');
			$('.formError').remove();
		 });
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
});


</script>    
    
</head>
<body>
<div id="header">
<noscript>
    <div class="notice"><span>This is a Warning Notice!</span>
    <p>You will need to enable JavaScript on your browser.</p>
    </div>
</noscript>
    <div class="wrapper">
		<h1><a class="logo" href="<?php echo $this->webroot; ?>"><?php echo $this->Html->image('logo.jpg',array('escape'=>false,'div'=>false,'alt'=>'mygyftr'));?></a></h1>
        <div class="user_name_div"><?php echo 'Welcome '; if($this->Session->check('RecUser')){ echo $this->Session->read('RecUser.User.name').', <a href="'.$this->webroot.'recharge/logout">Logout</a>'; }else{ echo 'guest!'; } ?></div>
	</div>
</div>

<div id="body_container">
	<div class="wrapper">
			<?php echo $this->fetch('content'); ?>
    </div>
</div>

<?php echo $this->element('bottom_brands'); ?> 
<?php echo $this->element('footer'); ?>            
</body>
</html>
