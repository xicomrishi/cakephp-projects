<?php
$siteDescription = __d('cake_dev', 'myGyFTR');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">

<head>
	<?php echo $this->Html->charset(); 
		echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0'));
	?>
   
   	<?php $get_url=$_SERVER['REQUEST_URI']; 
			$url=explode('/',$get_url);
		 $path=strtolower(trim(end($url)));
		 if(empty($path)){	  
	?>
    <title>Online Gift Voucher Website | myGyFTR.com</title>
    <meta name="description" content="myGyFTR.com is an online gifting website which provides the gift vouchers of top brands with various contests, promo codes and opportunity to earn coins to send a free gift">
	<meta name="keywords" content="vouchers, online gifting, gift vouchers, gift coupons, promo code, voucher codes, coupons, discount vouchers, promotion code">
    <?php }else if($path=='contest'){ ?>
   	<title>Online Gifting Contest for Free Gifts by myGyFTR.com</title>
    <meta name="description" content="Join online gifting contest in order to win free gifts by getting free vouchers, promo codes and coins by which you can grab and send a free gift voucher">
	<meta name="keywords" content="online gifting contest, free gift voucher, promo code, free gift coupons, free online gifts, voucher codes, discount vouchers, free stuff online, contest">   
	<?php }else if($path=='promo-codes'){ ?>
   	<title>Promo code by myGyFTR.com for Gift Vouchers</title>
    <meta name="description" content="myGyFTR.com provides Value, Brand and offer based best buy promo codes that allows you to get more in your gift vouchers while gifting online">
	<meta name="keywords" content="promo code, promotion code, coupon codes, online coupon codes, online discount coupon codes, voucher codes, discount vouchers">   
	<?php }else if($path=='loyalty'){ ?>
   	<title>Earn myGyFTR Coins</title>
    <meta name="description" content="Earn myGyFTR Coins and use it to purchase a gift voucher or to get the equivalent cash back so enjoy online gifting by earning your shopping points to get free stuff.">
	<meta name="keywords" content="earn points and get free stuff, get free stuff with points, earn coins, earn points get free stuff, get free vouchers, online gifting points">   
	<?php }else if($path=='how-does-it-work'){ ?>
   	<title>myGyFTR.com | How does it work</title>
    <meta name="description" content="Get to know about the online purchase process steps of online gifting service of myGyFTR.com to place an order to send or purchase a gift voucher with great ease.">
	<meta name="keywords" content="how to send gift, online gifting services, purchase process steps, how to gift online, online gift voucher services">   
	<?php }else if($path=='contact-us'){ ?>
   	<title>Contact Us | myGyFTR.com</title>
    <meta name="description" content="Contact myGyFTR.com to place an order online for sending a gift voucher or to get any help related to online gifting or purchasing">
	<meta name="keywords" content="contact, contact for online gifting,  get help, contact for free gift voucher, contact for free gift coupons">   
	<?php }else if($path=='faq'){ ?>
   	<title>FAQ – Frequently Asked Questions | myGyFTR.com</title>
    <meta name="description" content="You have any query regarding online gifting services, gift vouchers, earn myGyFTR coin then check our frequently asked questions section to get help.">
	<meta name="keywords" content="online gifting faq, frequently asked question, faq for free gift vouchers, faq to earn coins, online shopping help, get help">   
	<?php }else if($path=='spice-hotspot'){ ?>
   	<title>T&amp;C and Outlet Locator of Spice HotSpot | myGyFTR.com</title>
    <meta name="description" content="Check out the information about Spice HotSpot including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About Spice HotSpot, Spice HotSpot outlet locator, Spice HotSpot online purchase, Spice HotSpot online gift vouchers, Spice HotSpot purchase t&c">   
	<?php }else if($path=='croma'){ ?>
   	<title>T&amp;C and Outlet Locator of Croma | myGyFTR.com</title>
    <meta name="description" content="Check out the information about Croma including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About Croma, Croma outlet locator, Croma online purchase, Croma online gift vouchers, Croma purchase t&c">   
	<?php }else if($path=='jack-&-jones'){ ?>
   	<title>T&amp;C and Outlet Locator of Jack &amp; Jones | myGyFTR.com</title>
    <meta name="description" content="Check out the information about Jack & Jones including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About Jack & Jones, Jack & Jones outlet locator, Jack & Jones online purchase, Jack & Jones online gift vouchers, Jack & Jones purchase t&c">   
	<?php }else if($path=='benetton'){ ?>
   	<title>T&amp;C and Outlet Locator of Benetton | myGyFTR.com</title>
    <meta name="description" content="Check out the information about Benetton including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About Benetton, Benetton outlet locator, Benetton online purchase, Benetton online gift vouchers, Benetton purchase t&c">   
	<?php }else if($path=='baskin-robbins'){ ?>
   	<title>T&amp;C and Outlet Locator of Baskin-Robbins | myGyFTR.com</title>
    <meta name="description" content="Check out the information about Baskin-Robbins including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About Baskin-Robbins, Baskin-Robbins outlet locator, Baskin-Robbins online purchase, Baskin-Robbins online gift vouchers, Baskin-Robbins purchase t&c">   
	<?php }else if($path=='di-bella'){ ?>
   	<title>T&amp;C and Outlet Locator of Di-Bella | myGyFTR.com</title>
    <meta name="description" content="Check out the information about Di-Bella including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About Di-Bella, Di-Bella outlet locator, Di-Bella online purchase, Di-Bella online gift vouchers, Di-Bella purchase t&c">   
	<?php }else if($path=='ruby_s-bar-&-grill'){ ?>
   	<title>T&amp;C and Outlet Locator of Ruby's Bar &amp; Grill | myGyFTR.com</title>
    <meta name="description" content="Check out the information about Ruby's Bar & Grill including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About Ruby's Bar & Grill, Ruby's Bar & Grill outlet locator, Ruby's Bar & Grill online purchase, Ruby's Bar & Grill online gift vouchers, Ruby's Bar & Grill purchase t&c">   
	<?php }else if($path=='mandarin-trail'){ ?>
   	<title>T&amp;C and Outlet Locator of Mandarin-Trail | myGyFTR.com</title>
    <meta name="description" content="Check out the information about Mandarin-Trail including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About Mandarin-Trail, Mandarin-Trail outlet locator, Mandarin-Trail online purchase, Mandarin-Trail online gift vouchers, Mandarin-Trail purchase t&c">   
	<?php }else if($path=='indus-grill'){ ?>
   	<title>T&amp;C and Outlet Locator of Indus-Grill | myGyFTR.com</title>
    <meta name="description" content="Check out the information about Indus-Grill including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About Indus-Grill, Indus-Grill outlet locator, Indus-Grill online purchase, Indus-Grill online gift vouchers, Indus-Grill purchase t&c">   
	<?php }else if($path=='tgif'){ ?>
   	<title>T&amp;C and Outlet Locator of TGIF | myGyFTR.com</title>
    <meta name="description" content="Check out the information about TGIF including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About TGIF, TGIF outlet locator, TGIF online purchase, TGIF online gift vouchers, TGIF purchase t&c">   
	<?php }else if($path=='talwalkars'){ ?>
   	<title>T&amp;C and Outlet Locator of Talwalkars | myGyFTR.com</title>
    <meta name="description" content="Check out the information about Talwalkars including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About Talwalkars, Talwalkars outlet locator, Talwalkars online purchase, Talwalkars online gift vouchers, Talwalkars purchase t&c">   
	<?php }else if($path=='book-my-show'){ ?>
   	<title>T&amp;C and Outlet Locator of Book My Show | myGyFTR.com</title>
    <meta name="description" content="Check out the information about Book My Show including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About Book My Show, Book My Show outlet locator, Book My Show online purchase, Book My Show online gift vouchers, Book My Show purchase t&c">   
	<?php }else if($path=='bata'){ ?>
   	<title>T&amp;C and Outlet Locator of Bata | myGyFTR.com</title>
    <meta name="description" content="Check out the information about Bata including its outlet locator and terms & conditions for online gift voucher purchase.">
	<meta name="keywords" content="About Bata, Bata outlet locator, Bata online purchase, Bata online gift vouchers, Bata purchase t&c">   
	<?php }else if($path=='cancellation-refund-policy'){ ?>
   	<title>Cancellation &amp; Refund Policy | myGyFTR.com</title>
    <meta name="description" content="Check out the Cancellation & Refund Policy for online purchasing of gift vouchers">
	<meta name="keywords" content="cancellation policy, refund policy, online shopping policy">   
	<?php }else if($path=='privacy-policy'){ ?>
   	<title>Privacy Policy | myGyFTR.com</title>
    <meta name="description" content="Check out the Privacy Policy for online purchasing of gift vouchers from myGyFTR.com">
	<meta name="keywords" content="privacy policy, brand privacy policy, myGyFTR privacy policy">   
	<?php }else if($path=='terms-conditions'){ ?>
   	<title>Terms and Conditions | myGyFTR.com</title>
    <meta name="description" content="Check out the Terms and Conditions for online purchasing of gift vouchers from myGyFTR.com">
	<meta name="keywords" content="Terms and Conditions, brand Terms and Conditions, myGyFTR Terms and Conditions, online shopping Terms and Conditions">   
	<?php }else{ ?>
    <title>Online Gift Voucher Website | myGyFTR.com</title>
    <meta name="description" content="myGyFTR.com is an online gifting website which provides the gift vouchers of top brands with various contents, promo codes and opportunity to earn coins to send a free gift">
	<meta name="keywords" content="vouchers, online gifting, gift vouchers, gift coupons, promo code, voucher codes, coupons, discount vouchers, promotion code">
    
    <?php } ?>
    
    
    
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('bootstrap','fonts','bootstrap-responsive','nanoscroll','jquery-ui-css','jquery.jscrollpane','timepicker-addon','validation','jquery.fancybox'));
		echo $this->Html->script(array('jquery','jquery.cycle.all','jquery-ui.min','jquery.mousewheel-3.0.6.pack','jquery.fancybox','nanoScroller','jquery.jscrollpane','timepicker','jquery.validationEngine','validation-en','jcarousal','jquery.jeditable','blockUI','client','index'));
	?>
   
    <!--[if IE 6]><?php echo $this->Html->script('jq-png-min');?><![endif]-->
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
<?php echo $content_for_layout; ?>  

<script type="text/javascript">
$(document).ready(function(e) {
	
     $('body').click(function(e){
		 var ind=$('.row.active').index();
		 var clickedOn = $(e.target);
	 	if (clickedOn.parents().andSelf().is('.user_name')||clickedOn.parents().andSelf().is('#friend_name')||clickedOn.parents().andSelf().is('.friend_detail'))
		{}else{ $('.instruction_box').hide(); 
				$('.fb_disp').hide();
				}	
	 });
	
	$(document).ajaxComplete(function(event, XMLHttpRequest, ajaxOptions) {
     
	    $('input:text').blur(function(e) {
			$(this).css('border','');
			$(this).css('box-shadow','');
			$('.formError').remove();
		 });
		  $('input:password').blur(function(e) {
			$(this).css('border','');
			$(this).css('box-shadow','');
			$('.formError').remove();
		 });
		$('#editable input').blur(function(e) {			
            check_validation();
        });
		
    });
});

</script>

</body>
</html>