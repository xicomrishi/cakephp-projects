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
		echo $this->Html->css(array('datepicker/jquery.ui.core.min','datepicker/jquery.ui.datepicker.min','datepicker/jquery.ui.theme.min','datepicker/jquery-ui.min','datepicker/demo','nanoscroller','jquery.tooltip'));
		
        echo $this->Html->script(array('jquery', 'cufon-yui', 'cufon', 'Conduit_ITC_400.font', 'Conduit_ITC_700.font', 'Conduit_ITC_italic_400.font', 'Conduit_ITC_italic_700.font','jquery.validate.min','popup','jquery.nanoscroller.min','datepicker/jquery.ui.core.min','fileupload/jquery.ui.widget','datepicker/jquery.ui.datepicker.min','jquery.ui.mouse','jquery.ui.slider','jquery.tooltip.pack'));?>
           <!--[if IE]><?php echo $this->Html->script('ieh5fix');?></script><![endif]-->
          
        <?php
		
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-keG23IgPilsjt9g6BW2NvWpfFeil3zo&sensor=false">
    </script>
    </head>
   

<body class="inner_body">
<a href="javascript://" onclick="loadPopup('<?php echo SITE_URL;?>/help/index')" class="help_link">get help</a> <a href="javascript://" class="challenge_btn" onclick="show_challenges();">challenge</a>


<section id="main_container">
<div class="white_strip"></div>
<div id="wrapper">
  <header>
    	<?php echo $this->element('header');?>
        <span class="job_card_btn"><a href="javascript://" onclick="show_add_jobcard();">+ CREATE JOB CARD</a></span>
    </header>
  
  


<?php echo $this->fetch('content'); ?> 
  

  
</div>
<div id="jsbPopup"></div>
<div id="backgroundPopup"></div>
</section>
<script type="text/javascript">
$(document).ready(function () {
    $(".submenu").hover(
  function () {
     $('ul.drop_down.drop_1').show();
  },
  function () {
     $('ul.drop_down.drop_1').hide();
  }
);

     $(".drop_1 li").hover(
  function () {
	  $('ul.drop_down.drop_1').show();
    // $(this).children("ul").slideDown('medium');
  },
  function () {
	   $('ul.drop_down.drop_1').hide();
   // $(this).children("ul").slideUp('medium');
  }
);
});

function show_challenges()
{
	$.post('<?php echo SITE_URL;?>/challenges/index',{ch:1},function(data){
		$('#main_container').html(data);
	});
}

</script>
</body>
</html>
