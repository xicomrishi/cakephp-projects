<div id="inner_container">
<div class="wrapper">
<div class="inner_detail">

<div class="common_box first">
<span class="img_box"><?php echo $this->Html->image('one_to_one.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></span>
<?php echo $this->Html->image('common_text1.jpg',array('alt'=>'','escape'=>false,'div'=>false));?>
<span class="detail">Choose the person you want to send the gift.  Pick the gift from our wide variety of exciting Instant Gift options from coffees, ice creams, luxury facials, spa, apparel, footwear, gym memberships to big ones like mobiles, LEDs and more...
</span>
</div>

<div class="common_box">
<span class="img_box"><?php echo $this->Html->image('many_to_many.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></span>
<?php echo $this->Html->image('common_text2.jpg',array('alt'=>'','escape'=>false,'div'=>false));?>
<span class="detail">You will be the only contributor in case of One to one / Self Gift. In case of a group gift, you can select who all will contribute along with you. It's as simple as picking friends from Facebook, Gmail etc. If they are not there, simply type in their names and details. You can decide who contributes how much.</span>
</div>

<div class="common_box last">
<span class="img_box"><?php echo $this->Html->image('self.jpg',array('alt'=>'','escape'=>false,'div'=>false));?></span>
<?php echo $this->Html->image('common_text3.png',array('alt'=>'','escape'=>false,'div'=>false));?>
<span class="detail">The gifts can be sent to the recipients instantly or at the exact time you wish on their mobile/ email. Now, send those Birthday gifts exactly at 12 o'clock to create the moment! The best part is the complete cost of gift and delivery can be as low as INR 50... Keep Gyfting! </span>
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
<p>We are the Singapore based company and we believe that the experience of receiving a gift should be like a gift itself- Fun, Fast and definitely at the right on time! Log on now to  enjoy your first 100 Mygyftr coins!</p>
</div>
</div>
<h3>why myGyFTR?</h3>
<div class="detail_box">
<div class="icon_box"><?php echo $this->Html->image('detail_box_icon2.png',array('alt'=>'','escape'=>false,'div'=>false));?></div>
<div class="gift_detail">
<strong><span>why my</span>GyFTR?</strong>
<p>myGyFTR  is India's first  group gifting platform which allows individual and group gifting to friends, family, colleagues and yourself.  It has for you the never before ease of delivering the gift at the precise moment ...</p>
</div>
</div>
<h3>brands</h3>
<div class="detail_box last">
<div class="icon_box"><?php echo $this->Html->image('detail_box_icon3.png',array('alt'=>'','escape'=>false,'div'=>false));?></div>
<div class="gift_detail">
<strong>brands</strong>

<?php $this->requestAction('/home/get_brands_logo');?>

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