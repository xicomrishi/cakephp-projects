<section class="body_container">
    	<section class="slider_container">
       		<section class="top_menu">
                <div class="wrapper">
                    <ul>
                        <li><a href="javascript://" onclick="scrollToAnchor('.left_container'); show_all_vouchers();">Buy Now</a></li>
                        <li><a href="javascript://" onclick="show_best_deals();">Offers</a></li>
                        <li><a href="javascript://" onclick="scrollToAnchor('.voucher_box');">Partner Brands</a></li>
                        <li><a href="javascript://" onclick="scrollToAnchor('.bottom_box');">How to Redeem</a></li>
                        <li><a href="<?php echo $this->webroot; ?>Dominos-TnC" target="_blank">TnC</a></li>
                    </ul>
                </div>
            </section>
        	<ul class="slider">
            	<li>
                	<img src="<?php echo $this->webroot; ?>img/slide1.jpg">
                    <section class="slide_detail">
                        <div class="wrapper">
                            <section class="info">
                                <strong><img src="<?php echo $this->webroot; ?>img/pizza_logo.png"></strong>
                                <h4>Important Instructions</h4>
                               <div class="list">
                                    <ul>
                                        <li>eVouchers can't be used for ordering Simply Veg &amp; Simply Nov Veg Pizza. </li>
                                        <li>Orders accepted only between 11.00 am to 11.00 pm.  </li>
                                        <li>No other Coupon Code  can be used while paying with e-vouchers. </li>
                                        <li>One voucher can be used against one order. </li>
                                    </ul>
                                </div>
                                <a href="javascript://" onclick="scrollToAnchor('.bottom_box');">REDEEM eVOUCHER</a>
                            </section>
                        </div>
                     </section>
                     <p>Yeh Hai Rishton Ka Time</p>
                </li>
            </ul>
            <section class="paging">
            	<div class="wrapper">
                	<a href="#" class="left"></a>
                    <a href="#" class="right"></a>
                </div>
            </section>
        </section>
        <section class="main_container">
        	<div class="wrapper">            	
                <?php echo $this->element('brand_page_products'); ?>
                                
                <section class="right_container">
                	<section class="dominos_box">
                    	<h3>DOMINOS</h3>
                        <?php echo $this->element('all_brands_list'); ?>
                        
                    </section>
                    <section class="information_box">
                    	<h4>DOMINOS INFORMATION</h4>
                        <ul>
                        	<li><span>HELPLINE</span><span>68886888</span></li>
                        	<li class="last"><span>WEBSITE</span><a href="#">www.dominos.co.in</a></li>
                        </ul>
                    </section>
                </section>
            </div>
        </section>
        <section class="voucher_box">
        	<div class="wrapper">
            	<h3>Domino's Vouchers also available  at </h3>
                <ul>
                	<li><img src="<?php echo $this->webroot; ?>img/img1.png"></li>
                	<li><img src="<?php echo $this->webroot; ?>img/img2.png"></li>
                	<li><img src="<?php echo $this->webroot; ?>img/img3.png"></li>
                </ul>
            </div>
        </section>
        <section class="bottom_box">
        	<div class="wrapper">
        		<h3>How to Redeem at <strong style="color:#F37612">www.dominos.co.in</strong></h3>
                <img src="<?php echo $this->webroot; ?>img/bottom_img.png">
                <section class="buttons">
                	<a href="https://pizzaonline.dominos.co.in/?src=brand" target="_blank">Redeem eVoucher</a>                	
                </section>
            </div>
        </section>
    </section>
   
    
<script type="text/javascript">

/*$(document).ready(function(e) {
   $(".list ul").mCustomScrollbar();
});*/

function scrollToAnchor(aclass){
    var aTag = $(aclass);
    $('html,body').animate({scrollTop: aTag.offset().top-100},500);
}

function show_best_deals(){
	$('.all_vouchers_list').hide();
	$('.best_deals_list').show();
	$('.menu li').removeClass('active');
	$('.menu li').eq(1).addClass('active');
	var aTag = $('.menu');
    $('html,body').animate({scrollTop: aTag.offset().top-100},500);	
}

function show_all_vouchers(){
	$('.all_vouchers_list').show();
	$('.best_deals_list').hide();
	$('.menu li').removeClass('active');
	$('.menu li').eq(0).addClass('active');
}
</script>