<div class="tab_container">	            	
     <?php $this->requestAction('/info/get_discount_offers/3'); ?>      
</div>

<div class="wrapper">
	<div class="middle_container">
		<div class="common_box">
        	<span class="img_box"><img src="<?php echo $this->webroot; ?>img/home_cat_img1.png" alt="contests"/></span>
            <div class="details">
           	 	<h3>contests</h3>
            	<p>Are you the lucky One !  why don’t you  cheque it out and if you are you would get  gifts from ours side ! and even if you don’t win we assure you that you certainly would have had a great time ! </p>
            	<span class="read_more"><a href="javascript://" onclick="get_bottom_page_ajax('contest');">read more</a></span>
            </div>
        </div>
        <div class="common_box second">
        	<span class="img_box"><img src="<?php echo $this->webroot; ?>img/home_cat_img2.png" alt="promo code"/></span>
            <div class="details">
            	<h3><span>promo</span> Code</h3>
            	<p>Well Promo Codes are that magical codes which you allows you to get more ! We have three kind of promo codes Value, Brand and offer based so go ahead and use it good things don't last forever</p>
            	<span class="read_more"><a href="javascript://" onclick="get_bottom_page_ajax('promocode');">read more</a></span>
            </div>
        </div>
        <div class="common_box last">
        	<span class="img_box"><img src="<?php echo $this->webroot; ?>img/home_cat_img3.png" alt="loaylty points"/></span>
            <div class="details">
            	<h3>Loyalty <span>pays</span></h3>
            	<p>Loyalty pays !  and in our own small way we thank you for any kind of transaction you may do monitory or non-monitory so go ahead start collecting the myGyFTR Coins each coin is equal to INR 1</p>
            	<span class="read_more"><a href="javascript://" onclick="get_bottom_page_ajax('loyalty');">read more</a></span>
            </div>
        </div>
        <div class="middle_links">
        	<ul>
            	<li><a href="javascript://" onclick="get_bottom_page_ajax('howitwork');">how does it <span>work?</span></a></li>
                <li><a href="javascript://" onclick="get_bottom_page_ajax('contact');"><span>Talk</span> to us</a></li>
                <li class="last"><a href="javascript://" onclick="get_bottom_page_ajax('faq');"><span>F.A.Qs</span></a></li>
            </ul>
        	
        </div>
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
<script type="text/javascript">
$('.brand_container').cycle({
		fx:'scrollLeft',
		timeout:0,
		speed:2000,
		pager: '.paging_bottom_home',
		activePagerClass: 'active',
			pagerAnchorBuilder: function(idx, slide) { 
		return '<li><a href="javascript://"></a></li>';
		// return '.paging_bottom_home li:eq(' + (idx) + ')';		
 		}
	});
</script>