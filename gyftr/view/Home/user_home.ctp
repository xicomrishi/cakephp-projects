<input type="hidden" id="show_terms_id" value="<?php echo $show_terms_id; ?>"/>
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
<li><a href="javascript://" onclick="nextStep('register',0);">REGISTER</a></li>
<li><a href="javascript://" onclick="nextStep('display_login','0');" class="color">LOGIN</a></li>
</ul>
<ul class="logout_sec" <?php if(!$this->Session->check('User')){ echo 'style="display:none";';}?>>
<li id="user_img"><a href="javascript://" class="facebook"><?php echo $this->Html->image('facebook_profile_pic.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></a></li>
<li><a href="javascript://" onclick="logout();" class="color">LOGOUT</a></li>
</ul>
</div>

<div id="header">
<div class="wrapper">
<a class="logo" href="<?php echo SITE_URL; ?>"><?php echo $this->Html->image('logo.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></a>
</div>
</div>

<div id="banner_container">
<div class="wrapper">
<div id="banner">
<div id="form_section">
		<?php //echo $this->element('breadcrumb');?>
            <span class="select_dele">/ /<strong> Login</strong>
            </span>
            <form id="loginForm" name="loginForm" method="post" action="">
            	
            	<input type="hidden" name="fb_login" id="fb_login" value="0"/>
                <input type="hidden" name="user_fb_id" id="user_fb_id"/>
                 <input type="hidden" name="user_first_name" id="user_first_name"/>
                 <input type="hidden" name="user_last_name" id="user_last_name"/>
            	<div id="flash_msg" style="display:none; color:#FF0033;"></div>
                <label>Email</label>
                <span class="text_box">
            		<input type="text" id="user_email" name="email" class="validate[required,custom[email]]"/>
                </span>
                <label>Password</label>
                <span class="text_box">
            		<input type="password"  name="password" class="validate[required]"/>
                </span>
                               <div class="instruction_box">
            <span class="image">
<?php echo $this->Html->image('or_1.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
<a href="javascript://" onclick="myfunc();"><?php echo $this->Html->image('facebook_btn_1.png',array('escape'=>false,'alt'=>'','div'=>false)); ?></a>
</span>
<p>**myGyftr Group Gifts will not contact your Facebook <br>   
   friends or share information without your permission.</p>
</div>
            <div class="submit">
              <input class="done" type="submit" value="SUBMIT">
            </div>          
            </form>

            
            <div class="other_login">
             <?php echo $this->Html->image('or_1.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
             <a href="javascript://" onclick="nextStep('register',0);">Register now</a>
             </div>
            <div class="bottom">
            	<span class="left_img">
                	<?php echo $this->Html->image('form_left_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
                <span class="right_img">
                <?php echo $this->Html->image('form_right_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
            </div>
       </div>
       

        
</div>
</div>
</div>

<div id="top_row">
<div class="wrapper">
<form id="voucherstatusForm" name="voucherstatusForm" action="" class="status_row" method="post" onsubmit="return check_voucher_status();">
<label>check your instant gift voucher details</label>
<input type="text" class="input validate[required]" value="" name="voucherid" />
<input type="submit" value="check now!" class="check" onclick="return check_voucher_status();">
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
<li><a href="#">me to you</a></li>
<li><a href="#">group gift</a></li>
<li><a href="#">me to me</a></li>
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
	$("#voucherstatusForm").validationEngine();
   
	  $("#loginForm").validationEngine({promptPosition: "topLeft"});
		$('.done').click(function(e) {
       		var valid = $("#loginForm").validationEngine('validate');
			if(valid)
				loginStep();
			else
				$("#loginForm").validationEngine();
				
    });
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
  
  function myfunc() {
  FB.login(function(response) {
	$.post('<?php echo SITE_URL; ?>/home/get_fb_details',function(data){
		var arr=JSON.parse(data);		
			$('#user_fb_id').val(arr['id']);
			$('#user_first_name').val(arr['first_name']);
			$('#user_last_name').val(arr['last_name']);
			$('#user_email').val(arr['email']);
			$('#fb_login').val('1');
			loginStep();
		});  
   // window.location.href='<?php echo SITE_URL;?>/home/get_fb_details/';
	}, {scope:'email,read_mailbox,publish_stream,user_location,offline_access'});
}

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
</script>  

