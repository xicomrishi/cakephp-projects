<div class="tab_container">
        <div class="inner_container">
            	<div class="tab_details">
        			<h3>how does it <span>work?</span></h3>
            		<div class="inner_detail">
                    <div class="wrapper">
        			<div class="common_box first">
						<span class="img_box"><img src="<?php echo $this->webroot; ?>img/one_to_one.jpg" alt="One to One Gifting"  /></span>
						<img src="<?php echo $this->webroot; ?>img/common_text1.jpg" alt="select the gift" /> 
						<span class="detail">Choose the person you want to send the gift.  Pick the gift from our wide variety of exciting Instant Gift options from coffees, ice creams, luxury facials, spa, apparel, footwear, gym memberships to big ones like mobiles, LEDs and more...</span>
					</div>

					<div class="common_box">
<span class="img_box"><img src="<?php echo $this->webroot; ?>img/many_to_many.jpg" alt="Group Gifting"  /></span>
<img src="<?php echo $this->webroot; ?>img/common_text2.jpg" alt="who will contribute" /> 
<span class="detail">You will be the only contributor in case of One to one / Self Gift. In case of a group gift, you can select who all will contribute along with you. It's as simple as picking friends from Facebook, Gmail etc. If they are not there, simply type in their names and details. You can decide who contributes how much.</span>
</div>

					<div class="common_box last">
<span class="img_box"><img src="<?php echo $this->webroot; ?>img/self.jpg" alt="Self Gifting"  /></span>
<img src="<?php echo $this->webroot; ?>img/common_text3.png" alt="we'll deliver the gift" /> 
<span class="detail">The gifts can be sent to the recipients instantly or at the exact time you wish on their mobile/ email. Now, send those Birthday gifts exactly at 12 o'clock to create the moment! The best part is the complete cost of gift and delivery can be as low as INR 50... Keep Gyfting! </span>
</div>
					</div>
                    </div>
                 </div>
        </div>
        <div class="wrapper">
			<ul class="tabing">
                <li class="active"><a href="javascript://">how does it work?</a></li>
                <li><a href="<?php echo $this->webroot; ?>contest">contest</a></li>
                <li><a href="<?php echo $this->webroot; ?>promo-codes">promo codes</a></li>
                <li><a href="<?php echo $this->webroot; ?>loyalty">loyalty</a></li>
                <li><a href="<?php echo $this->webroot; ?>contact-us">contact us</a></li>
                <li><a href="<?php echo $this->webroot; ?>faq">f.a.qs</a></li>
                <li><a href="<?php echo $this->webroot; ?>offers">offers</a></li>
           </ul>
		</div>
</div>

<div id="bottom_container">
<div class="wrapper">
	<div class="allbrand_detail">
    	<h3>Top Brands on myGyFTR: View all brands</h3>
        <?php $this->requestAction('/info/get_categories');?>
        
    </div>
</div>
</div>

