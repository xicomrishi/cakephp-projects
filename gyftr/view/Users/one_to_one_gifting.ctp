<input type="hidden" id="show_gmail_id" value="<?php echo $show_gmail_id; ?>"/>
<div id="social_row">
<button class="social_bar btn-navbar" type="button">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<ul id="social_icon">
<li><a href="#" ><?php echo $this->Html->image('g_icon.png',array('alt'=>'','escape'=>false,'div'=>false));?></a></li>
<li><a href="#" ><?php echo $this->Html->image('5_icon.png',array('alt'=>'','escape'=>false,'div'=>false));?></a></li>
<li><a href="#" ><?php echo $this->Html->image('4_icon.png',array('alt'=>'','escape'=>false,'div'=>false));?></a></li>
<li><a href="#" ><?php echo $this->Html->image('3_icon.png',array('alt'=>'','escape'=>false,'div'=>false));?></a></li>
<li><a href="#" ><?php echo $this->Html->image('fb_icon.png',array('alt'=>'','escape'=>false,'div'=>false));?></a></li>
<li><a href="#" ><?php echo $this->Html->image('tw_icon.png',array('alt'=>'','escape'=>false,'div'=>false));?></a></li>
</ul>

<ul class="login_sec" <?php if($this->Session->check('User')){ echo 'style="display:none";';}?>>
<li><a href="javascript://" onclick="nextStep('register',0);">Register</a></li>
<li><a href="javascript://" onclick="nextStep('display_login','0');" class="color">Login</a></li>
</ul>
<ul class="logout_sec" <?php if(!$this->Session->check('User')){ echo 'style="display:none";';}?>>
<li id="user_img"><a href="javascript://" class="facebook"><?php echo $this->Html->image('facebook_profile_pic.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></a></li>
<li><a href="javascript://" onclick="logout();" class="color">Logout</a></li>
</ul>
</div>

<div id="header">
<div class="wrapper">
<a class="logo large" href="<?php echo SITE_URL; ?>"><?php echo $this->Html->image('logo.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></a>
</div>
</div>

<div id="banner_container">
<div class="wrapper">
<div id="banner">
<div class="breadcrumb">
<ul>
<li class="first"><a href="<?php echo SITE_URL; ?>">home</a></li>
<li><a href="javascript://" onclick="return nextStep('step-2','<?php echo $this->Session->read('Gifting.type');?>');">select gift type</a></li>
<li class="last">select a friend</li>
</ul>
</div>
<div class="step_3_com">
<?php echo $this->Html->image('step3_com_img.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
</div>
<div class="friend_detail">

<!--<ul class="paging">
<li class="active"><a href="#" onclick="return nextStep('step-3_com');">1</a></li>
<li><a href="#" onclick="return nextStep('step-3_com-1');">2</a></li>
<li><a href="#" onclick="return nextStep('step-3_com-2');">3</a></li>
</ul>-->
<form id="friendForm" name="friendForm" action="" onsubmit="return frndSubmit();">
<input type="hidden" id="gifting_type" value="<?php echo $this->Session->read('Gifting.type');?>"/>
<input type="text" id="friend_name" placeholder="Enter recipents name" class="validate[required]" onfocus="show_fb_connect()" />
</form>
<div class="instruction_box" style="display:none;">
<h3>Enter your friend's name manually</h3>
<div class="separator">
<span class="overlay"> or </span>
<hr>
</div>
<a href="javascript://" onclick="connect_fb('1','1');"><?php echo $this->Html->image('facebook_btn.png',array('escape'=>false,'alt'=>'','div'=>false)); ?></a>
   <a href="https://accounts.google.com/o/oauth2/auth?client_id=<?php echo Google_ID; ?>&redirect_uri=<?php echo Google_REDIRECT; ?>&scope=https://www.google.com/m8/feeds/&response_type=code">Get friends from Gmail</a>

</div>

<div class="friend"><?php echo $this->Html->image('friend_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?></div>
</div>

            <div class="action">
             
            <a href="javascript://"  class="no" onclick="frndSubmit();">Next</a>
                <a href="javascript://"  class="yes" onclick="return nextStep('step-2','<?php echo $this->Session->read('Gifting.type');?>');">Previous</a>
            
            </div>
</div>
</div>
</div>

<div id="top_row">
<div class="wrapper">
<form id="voucherstatusForm" name="voucherstatusForm" action="" class="status_row" method="post" onsubmit="return check_voucher_status();">
<label>Check your instant gift voucher details</label>
<input type="text" class="input validate[required]" value="" name="voucherid" />
<input type="submit" value="Check Now!" class="check" onclick="return check_voucher_status();">
</form>
</div>
</div>

<div id="body_container">
<div class="wrapper">
<div class="main_heading">
<p>how does it <strong>work ?</strong></p>
<!--<a href="#" class="drop_down_arr"><img src="common/images/drop_down_arr.jpg" alt="" /></a>
--><div class="select_box">
<a href="#" onclick="return false;">Select Type</a>
<ul class="drop_down">
<li><a href="#">Me to You</a></li>
<li><a href="#">Group Gift</a></li>
<li><a href="#">Me to Me</a></li>
</ul>
</div>
</div>
</div>
</div>

<div id="inner_container">
<div class="wrapper">
<div class="inner_detail">

<div class="common_box first">
<span class="img_box"><?php echo $this->Html->image('one_to_one.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></span>
<?php echo $this->Html->image('common_text1.png',array('alt'=>'','escape'=>false,'div'=>false));?>
<span class="detail">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of </span>
</div>

<div class="common_box">
<span class="img_box"><?php echo $this->Html->image('many_to_many.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></span>
<?php echo $this->Html->image('common_text2.png',array('alt'=>'','escape'=>false,'div'=>false));?>
<span class="detail">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of </span>
</div>

<div class="common_box last">
<span class="img_box"><?php echo $this->Html->image('self.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></span>
<?php echo $this->Html->image('common_text3.png',array('alt'=>'','escape'=>false,'div'=>false));?>
<span class="detail">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of </span>
</div>
</div>
</div>
</div>

<div id="bottom_container">
<div class="wrapper">
<h3>who we are</h3>
<div class="detail_box">
<div class="icon_box"><?php echo $this->Html->image('detail_box_icon1.png',array('alt'=>'','escape'=>false,'div'=>false));?></div>
<div class="gift_detail">
<strong><span>who</span> we are</strong>
<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make</p>
</div>
</div>
<h3>why myGyFTR?</h3>
<div class="detail_box">
<div class="icon_box"><?php echo $this->Html->image('detail_box_icon2.png',array('alt'=>'','escape'=>false,'div'=>false));?></div>
<div class="gift_detail">
<strong><span>why my</span>GyFTR?</strong>
<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make</p>
</div>
</div>
<h3>brands</h3>
<div class="detail_box last">
<div class="icon_box"><?php echo $this->Html->image('detail_box_icon3.png',array('alt'=>'','escape'=>false,'div'=>false));?></div>
<div class="gift_detail">
<strong>brands</strong>
<ul class="brands">
<li><?php echo $this->Html->image('brand1.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></li>
<li><?php echo $this->Html->image('brand1.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></li>
<li><?php echo $this->Html->image('brand1.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></li>
</ul>
<div class="slide_arr">
<a href="#" class="prev"><?php echo $this->Html->image('box_slide_arr_left.png',array('alt'=>'','escape'=>false,'div'=>false));?></a>
<a href="#" class="next"><?php echo $this->Html->image('box_slide_arr_right.png',array('alt'=>'','escape'=>false,'div'=>false));?></a>
</div>
</div>
</div>
</div>
</div>


<div id="footer_container">
<div class="wrapper">
<div id="footer">
<div class="footer_links">
<div class="inner">
<?php echo $this->Html->image('footer_img.jpg',array('alt'=>'','escape'=>false,'div'=>false));?> 
<ul class="links">
<li><a href="#">Contact Us</a></li>
<li><a href="#">Disclaimer</a></li>
<li class="last"><a href="#">T&amp;C</a></li>
</ul>
</div>
</div>
<div class="copyright">
<span class="left">Powered by takeAwayDigital</span>
<span class="right">Copyright &copy; 2003-2013 Vouchagram Ltd.</span>
</div>
</div>
</div>
</div>
<div id="fb-root"></div>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
       
<!--    <script type="text/javascript" src="common/js/bootstrap-transition.js"></script>
    <script type="text/javascript" src="common/js/bootstrap-alert.js"></script>
    <script type="text/javascript" src="common/js/bootstrap-modal.js"></script>
    <script type="text/javascript" src="common/js/bootstrap-dropdown.js"></script>
    <script type="text/javascript" src="common/js/bootstrap-scrollspy.js"></script>
    <script type="text/javascript" src="common/js/bootstrap-tab.js"></script>
    <script type="text/javascript" src="common/js/bootstrap-tooltip.js"></script>
    <script type="text/javascript" src="common/js/bootstrap-popover.js"></script>
    <script type="text/javascript" src="common/js/bootstrap-button.js"></script>

    <script type="text/javascript" src="common/js/bootstrap-collapse.js"></script>
    <script type="text/javascript" src="common/js/bootstrap-carousel.js"></script>
    <script type="text/javascript" src="common/js/bootstrap-typeahead.js"></script>
-->
  
<?php //echo $this->Session->flash(); ?>
<script type="text/javascript">
$(document).ready(function(e) {
	$("#voucherstatusForm").validationEngine({scroll:false,focusFirstField : false});
   /* var pr_id=$('#show_terms_id').val();
	if(pr_id!=0)
	{
		$.post('<?php echo SITE_URL; ?>/products/get_terms/'+pr_id,function(data){
				$('#banner').html(data);		
			});
		
	}*/
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '500',
				'href'          	: site_url+'/users/temp_gmail/'
			}
		);	
});
update_user_pic();
window.fbAsyncInit = function() {

    FB.init({
      appId  : '<?php echo FB_APPID;?>',
      status : true, // check login status
      cookie : true, // enable cookies to allow the server to access the session
      xfbml  : true,  // parse XFBML
	  frictionlessRequests : true
	 
    });
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
</script>  