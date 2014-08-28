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
		
		echo $this->Html->script(array('jquery','nanoScroller','jquery.fancybox','validation-en','jquery.validationEngine','jquery-ui-1.9.2.custom.min'));
	?>
    <!--[if IE 6]><?php echo $this->Html->script('jq-png-min');?><![endif]-->
     <!--[if IE 6]><?php echo $this->Html->script('ieh5fix');?><![endif]-->
     
     <script type="text/javascript">
	 $(document).ready(function(e) {
		 
        $(':input').focus(function(e) {
            $('form').validationEngine('hideAll');
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
	
	function change_language()
	{
		var location=window.location;
		var lang=$('#language_select').val();
		$.post('<?php echo $this->webroot; ?>cms/change_language/'+lang,function(data){
			window.location.href=location;	
		});	
	}
	 </script>
</head>
<body>

<section id="header_container">
  <div class="wrapper">
      <header>
        	<a href="<?php echo $this->webroot; ?>"><img src="<?php echo $this->webroot; ?>img/logo.png"/></a>
       <div class="language_box">      
      		<?php $this->requestAction('/cms/get_language_dropdown'); ?>
      </div>
      </header>
     
  </div>
</section>	

<?php echo $content_for_layout; ?> 	

</body>
</html>
