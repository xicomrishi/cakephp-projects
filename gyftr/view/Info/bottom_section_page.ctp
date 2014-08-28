<input type="hidden" id="show_terms_id" value="0"/>

<div id="social_row">
<button class="social_bar btn-navbar" type="button">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<ul id="social_icon">

<li><a href="https://www.facebook.com/mygyftr" target="_blank" ><?php echo $this->Html->image('fb_icon.png',array('alt'=>'','escape'=>false,'div'=>false));?></a></li>
<!--<li style="padding-right:4px;"><a href="#" ><?php echo $this->Html->image('tw_icon.png',array('alt'=>'','escape'=>false,'div'=>false));?></a></li>-->
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
<a class="logo large" href="<?php echo SITE_URL; ?>"><?php echo $this->Html->image('logo.jpg',array('alt'=>'mygyftr','escape'=>false,'div'=>false));?></a>
</div>
</div>

<div id="banner_container" class="none">
<div class="wrapper">
<div id="banner">
<div class="step_1" style="margin-top:-45px;" onclick="return nextStep('step-2','start');">
<?php echo $this->Html->image('step1_img.png',array('alt'=>'Instant Gifting','escape'=>false,'div'=>false));?>
</div>
<div class="action">
<a class="continue" onclick="return nextStep('step-2','start');" href="javascript://">Continue</a>
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

<div id="body_container_1">
<div class="wrapper">
	<div class="allbrand_ontainer">
    	<ul class="logo_brands">
           <?php $this->requestAction('/info/get_brands_logo');?>
        </ul>        
    </div>
    <div class="slider_arrows">
        	<a href="javascript://" class="left_arrow"></a>
            <a href="javascript://" class="right_arrow"></a>
        </div>
</div>
</div>

<div class="bt_section">

</div>

<div id="footer_container">
<div class="wrapper">
<div id="footer">
<div class="footer_links">
<div class="inner">
<?php echo $this->Html->image('footer_img.jpg',array('alt'=>'','escape'=>false,'div'=>false));?> 
<ul class="links">
<li style="font-size:10px;"><a href="<?php echo SITE_URL; ?>/contact-us" target="_blank">Contact Us</a></li>
<li style="font-size:10px;"><a href="<?php echo SITE_URL; ?>/cancellation-refund-policy" target="_blank">Cancellation &amp; Refund Policy</a></li>
<li  style="font-size:10px;"><a href="<?php echo SITE_URL; ?>/privacy-policy" target="_blank">Privacy Policy</a></li>
<li class="last" style="font-size:10px;"><a href="<?php echo SITE_URL; ?>/terms-conditions" target="_blank">Terms &amp; Conditions</a></li>
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
     
<?php //echo $this->Session->flash(); ?>
<script type="text/javascript">
$(document).ready(function(e) {
	
	$.post(site_url+'/info/get_bottom_page',{page:'<?php echo $page; ?>'},function(content){
			$('.bt_section').html(content);
			$('html, body').animate({scrollTop: '700px'}, 600);
		});
	
	<?php if(isset($redirectFromPay)){ ?>
		showLoading('#banner');
	<?php if(isset($isPayError)){ ?>	
		setTimeout(function(){ $('#banner').html('<div style="height:200px; text-align:center;">Oops! There is some error. Transaction not successfull. Please try again</div>');},1000);
	<?php }else{ ?>
	//alert('<?php echo $order_id; ?>');
			removeClass('.logo','large');
			removeClass('#banner_container','none');
			view_order_details('<?php echo $order_id; ?>');
		payment_successfull_msg('<?php echo $order_id; ?>');
	<?php }}else{  ?>
	<?php if(isset($is_register)){ ?>
	showLoading('#banner');	
	$.post('<?php echo SITE_URL; ?>/home/register_redirect',function(data){
				$('#banner').html(data);		
					removeClass('.logo','large');
					removeClass('#banner_container','none');
					$('.login_sec').show();
					$('.logout_sec').hide();
		});
	<?php }else if(isset($gift_type)){ ?>
	
	nextStep('step-2','start');
	<?php }else{ ?>
		 var pr_id=$('#show_terms_id').val();
	if(pr_id!=0)
	{
		$.post('<?php echo SITE_URL; ?>/products/get_terms/'+pr_id,function(data){
				$('#banner').html(data);		
			});		
	}		
	<?php }} ?>	
	$("#voucherstatusForm").validationEngine({scroll:false,focusFirstField : false});
  
});

<?php if(!isset($is_register)){ ?>
update_user_pic();
<?php } ?>

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