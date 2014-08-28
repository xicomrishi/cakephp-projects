<style>		
.scroll-pane
{
    width: 891px;   
    overflow: auto;	
}
.horizontal-only
{
    height: auto;   
}
</style>

<div class="tab_container">
<div class="inner_container">
    	<div class="tab_details">
        	<div class="wrapper">
        		<h3>promo codes</h3>
                <div class="procode_container">
                	
                    		<?php $this->requestAction('/info/get_promo_codes'); ?> 
                            
                       
                   
                    <div class="offer_based">
                    	<div class="common_box">
                        	<span><img src="<?php echo $this->webroot; ?>img/promo_based_img1.png" alt="bill based promo code"/></span>
                        	<div class="inner">
                            	<h3><span>bill</span> based</h3>
                            	<p>This promo code can be used when your bill amount is above a specified amount. You may have one or multiple vouchers in the basket all you need to ensure that you bill value is more than the amount mentioned to be able to use the promo code.</p>
                            	
                        	</div>
                    	</div>
                        <div class="common_box">
                        	<span><img src="<?php echo $this->webroot; ?>img/promo_based_img2.png" alt="brand based promo code"/></span>
                        	<div class="inner">
                            	<h3><span>brand</span> based</h3>
                            	<p>We at times get great offers for our customers for various brands and as such want you to get the benefit of that offer. So if you have a promo code with the desired brand we would suggest immediately buying the brand voucher and avail  that promotional benefits.</p>
                            	
                        	</div>
                    	</div>
                        <div class="common_box">
                        	<span><img src="<?php echo $this->webroot; ?>img/promo_based_img3.png" alt="offer based promo code"/></span>
                        	<div class="inner">
                            	<h3><span>offer</span> based</h3>
                            	<p>At time the promotion may be very specify i.e. if you are buying two specify brands together etc. and  if you are doing so then you can avail the benefit by using the promo code.</p>                            
                        	</div>
                    	</div>
                    </div>
                 </div>
			</div>
        </div>
    </div>
    <div class="wrapper">
			<ul class="tabing">
                 <li><a href="javascript://" onclick="get_bottom_page_ajax('howitwork');">how does it work?</a></li>
                <li><a href="javascript://" onclick="get_bottom_page_ajax('contest');">contest</a></li>
                <li class="active"><a href="javascript://">promo codes</a></li>
                <li><a href="javascript://" onclick="get_bottom_page_ajax('loyalty');">loyalty</a></li>
                <li><a href="javascript://" onclick="get_bottom_page_ajax('contact');">contact us</a></li>
                <li><a href="javascript://" onclick="get_bottom_page_ajax('faq');">f.a.qs</a></li>
                <li><a href="javascript://" onclick="get_bottom_page_ajax('offers');">offers</a></li>
           </ul>
		</div>
	</div>
<script type="text/javascript">
$(document).ready(function(e) {
	var count=$('.offer_percent > div').length;
	var width=330*count+'px';
	$('.offer_percent').css('width',width);	
    setTimeout(function(){ $('.scroll-pane').jScrollPane();},500);
});

</script>    