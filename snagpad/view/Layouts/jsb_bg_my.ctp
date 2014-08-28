<?php
$siteDescription = __d('cake_dev', 'JobSearchBoard');
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title> <?php echo $siteDescription ?>: <?php echo $title_for_layout; ?> </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('style');
        echo $this->Html->script(array('jquery', 'jquery.validate.min','popup'));?>
           <!--[if IE]><?php echo $this->Html->script('ieh5fix');?></script><![endif]-->
        <?php
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
     
    </head>
<body class="inner_body">
<a href="javascript://" onclick="loadPopup('<?php echo SITE_URL;?>/help/index')" class="help_link">get help</a> <a href="javascript://" class="challenge_btn" onclick="show_challenges();">challenge</a>
<ul class="featured_box">
  <li><a href="#">- ADS</a></li>
  <li><a href="#">- FEATURED JOBS</a></li>
  <li><a href="#">- WIDGETS</a></li>
</ul>
<section id="main_container">
  <div class="white_strip"></div>
  <div id="wrapper">
    <header>
    	<?php echo $this->element('header');?>
    </header>
    <section id="inner_body_container">
    	<?php echo $this->fetch('content');?>
    </section>
    
     </div>
</section>
 <div id="jsbPopup"></div>
        <div id="backgroundPopup"></div>

<script type="text/javascript">
function show_challenges()
{
	$.post('<?php echo SITE_URL;?>/challenges/index',{ch:1},function(data){
		$('#inner_body_container').html(data);
	});
}
</script>

</body>
</html>    