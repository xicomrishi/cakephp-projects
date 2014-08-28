<?php
$siteDescription = __d('cake_dev', 'myGyFTR');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $siteDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('brand_style','brandfonts','jquery.fancybox','jquery-ui-css','jquery.mCustomScrollbar'));
		echo $this->Html->script(array('jquery','jquery.fancybox','jquery-ui.min','jquery.mCustomScrollbar','jquery.mousewheel'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
	?>
 <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-41390420-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>    
</head>
<body>
	<header>
        <section class="top_header">
        	<div class="wrapper">
            	<ul>
                	<li><span>08510004444</span></li>
                	<li><a href="mailto:help@mygyftr.com" class="msg"><img src="<?php echo $this->webroot; ?>img/msg.png"></a></li>
                </ul>
            </div>
        </section>
        <section class="main_header">
        	<div class="wrapper">
            	<a href="<?php echo $this->webroot; ?>" class="logo"><img src="<?php echo $this->webroot; ?>img/brandlogo.png"></a>
                <?php echo $this->element('voucher_form'); ?>
            </div>
        </section>
    </header>
    <?php echo $this->fetch('content'); ?>
    
    
</body>
</html>
