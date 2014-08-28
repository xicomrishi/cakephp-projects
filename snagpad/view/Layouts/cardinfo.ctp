<?php
$siteDescription = __d('cake_dev', 'SnagPad');
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title> <?php echo $siteDescription ?>: <?php echo $title_for_layout; ?> </title>
        
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('style');
		echo $this->Html->css(array('datepicker/jquery.ui.core.min','datepicker/jquery.ui.datepicker.min','datepicker/jquery.ui.theme.min','datepicker/jquery-ui.min','datepicker/demos','nanoscroller')); ?>		
        
		<?php
        echo $this->Html->script(array('jquery',  'jquery.validate2.min','popup','jquery.nanoscroller.min','datepicker/jquery.ui.core.min','fileupload/jquery.ui.widget','datepicker/jquery.ui.datepicker.min','jquery.ui.mouse','jquery.ui.slider','jeditable','tooltip','jquery.jeditable.datepicker'));?>
           <!--[if IE]><?php echo $this->Html->script(array('ieh5fix'));?><![endif]-->
           
        <?php
		
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
     <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-keG23IgPilsjt9g6BW2NvWpfFeil3zo&sensor=false">
    </script>
        <?php if($this->Session->check('Coach')||$this->Session->check('Client')){ ?>
        	<link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8">
			<script type="text/javascript" src="/cometchat/cometchatjs.php" charset="utf-8"></script>
        <?php } ?>
    </head>
   

<body class="inner_body">
<a href="<?php echo SITE_URL;?>/info/<?php if($this->Session->read('usertype')=='2'){ echo 'coach_help_page'; }else if($this->Session->read('usertype')=='1'){echo 'agency_help_page'; }else if($this->Session->read('usertype')=='3'){ echo 'faq'; } ?>" target="_blank"  class="help_link">get help</a>
<div class="challenge_sec">
<?php if($this->Session->read('usertype')==3){?> <a href="javascript://" class="challenge_btn" onclick="show_challenge_scroll();">challenge</a><?php } else if($this->Session->read('usertype')==2){?><a href="javascript://" class="challenge_btn" onclick="show_challenge_scroll();">challenge</a> <?php }?>

<div class="challenge_detail">
	<div class="input_box">
    	<div class="value" id="weekly_points_val">0</div>
        <span>Weekly Points Needed</span>
    </div>
    <div class="input_box">
    	<div class="value" id="points_ach_val">0</div>
        <span>Points Achieved</span>
    </div>
    <div class="input_box">
    	<div class="value" id="points_rem_val">0</div>
        <span>Points remaining</span>
    </div>
    <a href="<?php echo SITE_URL; ?>/challenges/index/ch_progress">Challenges in Progress</a>
    <a href="<?php echo SITE_URL; ?>/challenges/index" class="pad">View all Challenges</a>
    <a href="<?php echo SITE_URL; ?>/challenges/index" class="pad" id="start_ch" style="display:none;">Start challenge now</a>
</div>
</div>


<?php echo $this->element('feedback_form');?>
<section id="main_container">
<div class="white_strip"></div>
<div id="wrapper">
   <header>
    	<?php
        $usertype=$this->Session->read('usertype');
        switch($usertype)
        {
            case 0: $ele='header'; break;
			case 1: $ele="header_agency";break;
            case 2: $ele="header_coach";break;
            case 3: $ele='header'; break;
        }
        echo $this->element($ele);
       if(($this->params['controller']=='jobcards'||$this->params['controller']=='Jobcards')&&($this->Session->check('Coach')||$this->Session->check('Client'))){ ?>
        <span class="job_card_btn"><a href="javascript://" onclick="show_add_jobcard('<?php if($this->Session->check('Coach')){ echo '1'; }else{ echo '0'; }?>');">+ CREATE JOB CARD</a></span>
        <?php }?>
    </header>
  
<?php echo $this->fetch('content'); ?> 
  
</div>
<div id="jsbPopup"></div>
<div id="backgroundPopup"></div>
</section>
<div id="fb-root"></div>
<?php if($this->Session->read('usertype')!='3') { ?>
<div id="client_info_coach"></div>

<?php } ?>
<a href="javascript://" onclick="scroll_to_top();" class="back_to_top">BACK TO TOP</a>
<script type="text/javascript">
var show_challenge=0;
$(document).ready(function () {
	
	add_card_status=0;
	 $('body').click(function(e){
		 var ind=$('.row.active').index();
		 var clickedOn = $(e.target);
    if (clickedOn.parents().andSelf().is('.display_content')||clickedOn.parents().andSelf().is('.content_box')||clickedOn.parents().andSelf().is('.card_box')||clickedOn.parents().andSelf().is('.sub_tab')||clickedOn.parents().andSelf().is('.row_'+ind)||clickedOn.parents().andSelf().is('#ui-datepicker-div')||clickedOn.parents().andSelf().is('.ui-icon')||clickedOn.parents().andSelf().is('.calender_box')||clickedOn.parents().andSelf().is('#jsbPopup')||clickedOn.parents().andSelf().is('.pop_up')||clickedOn.parent().andSelf().is('.already_sub')||clickedOn.parent().andSelf().is('.save_btn')||clickedOn.parent().andSelf().is('.save_btn2'))
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

function scroll_to_top()
{
	$("html, body").animate({ scrollTop: $('.inner_body').offset().top }, 1000);		
}

function show_challenge_scroll()
{
	if(show_challenge==0)
	{
		var clientid=<?php if(!isset($clientid)){ echo $this->Session->read('Client.Client.id'); }else{ echo $clientid; }?>;
		//alert(clientid);	
		$.post('<?php echo SITE_URL; ?>/challenges/challenge_points/'+clientid,{cl_id:clientid},function(data){
				//alert(data);
				data=unescape(data);
				var rep=data.split('|');
				$('#weekly_points_val').html(rep[0]);
				$('#points_ach_val').html(rep[1]);
				$('#points_rem_val').html(rep[2]);
				if(rep[3]==1)
					$('#start_ch').show();
				else
					$('#start_ch').hide();
						
				$('.challenge_detail').slideDown();	
			});
		show_challenge=1;	
			
	}else{
			
			$('.challenge_detail').slideUp();
			$('#start_ch').hide();
			show_challenge=0;
		}
	}

</script>

 <script type="text/javascript">
window.fbAsyncInit = function() {
    FB.init({
      appId  : '<?php echo FB_APPID;?>',
      status : true, // check login status
      cookie : true, // enable cookies to allow the server to access the session
      xfbml  : true  // parse XFBML
    });
  };

  (function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
  }());      </script>
</body>
</html>
