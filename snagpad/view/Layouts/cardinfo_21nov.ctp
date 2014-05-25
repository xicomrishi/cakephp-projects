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
		echo $this->Html->css(array('datepicker/jquery.ui.core.min','datepicker/jquery.ui.datepicker.min','datepicker/jquery.ui.theme.min','datepicker/jquery-ui.min','datepicker/demo','nanoscroller'));
		
        echo $this->Html->script(array('jquery', 'cufon-yui', 'jquery.validate.min','popup','jquery.nanoscroller.min','datepicker/jquery.ui.core.min','fileupload/jquery.ui.widget','datepicker/jquery.ui.datepicker.min','jquery.ui.mouse','jquery.ui.slider'));?>
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
<a href="javascript://" onclick="loadPopup('<?php echo SITE_URL;?>/help/index')" class="help_link">get help</a> <a href="#" class="challenge_btn">challenge</a>


<section id="main_container">
<div class="white_strip"></div>
<div id="wrapper">
  <header>
    	<?php echo $this->element('header');
		if($this->params['controller']=="jobcards"){?>
        <span class="job_card_btn"><a href="javascript://" onclick="show_add_jobcard();">+ CREATE JOB CARD</a></span>
        <?php }?>
    </header>
  
  


<?php echo $this->fetch('content'); ?> 
  

  
</div>
<div id="jsbPopup"></div>
<div id="backgroundPopup"></div>
</section>
<script type="text/javascript">
$(document).ready(function () {
	add_card_status=0;
	 $('body').click(function(e){
		 var ind=$('.row.active').index();
		 var clickedOn = $(e.target);
    if (clickedOn.parents().andSelf().is('.display_content')||clickedOn.parents().andSelf().is('.content_box')||clickedOn.parents().andSelf().is('.card_box')||clickedOn.parents().andSelf().is('.sub_tab')||clickedOn.parents().andSelf().is('.row_'+ind)||clickedOn.parents().andSelf().is('#ui-datepicker-div')||clickedOn.parents().andSelf().is('.ui-icon')||clickedOn.parents().andSelf().is('.calender_box'))
     {}
	else{
		
		$('.content_box').hide();
		$('.job_details_arrow').hide();
		$('.sub_tab').hide();
		$('.calender_box').hide();
		//$('.row').removeClass('active');
      //console.log( "Clicked outside the div" );}
	 }
  });
});

</script>
</body>
</html>
