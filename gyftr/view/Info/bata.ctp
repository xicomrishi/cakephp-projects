<?php echo $this->Html->css('jquery.ui.autocomplete');?>
<?php echo $this->Html->script(array('jquery.ui.core.min','jquery.ui.widget','jquery.ui.position','jquery.ui.menu','jquery.ui.autocomplete'));?>
<style>
.ui-autocomplete{width:213 !important;word-wrap:break-word !important;z-index:99999999 !important;background:#FFF;}
.ui-menu-item{ list-style:none !important;  float:left; width:100%; margin:0px}	
.ui-menu-item a{ font-size:12px !important; float:left; width:100% !important; padding:5px 0 !important; text-decoration:none}
.ui-menu-item:hover a{ color:#F8952F !important; background-color:#FFF !important; text-decoration:none}
.ui-widget-content a{ color:#000; }

</style>
<section class="body_container">
    	<section class="slider_container">
       		<section class="top_menu">
                <div class="wrapper">
                    <ul>
                        <li><a href="javascript://" onclick="scrollToAnchor('.left_container'); show_all_vouchers();">Buy Now</a></li>
                        <li><a href="javascript://" onclick="show_best_deals();">Offers</a></li>
                        <li><a href="javascript://" onclick="scrollToAnchor('.voucher_box');">Partner Brands</a></li>
                        <li><a href="javascript://" onclick="scrollToAnchor('.bottom_box');">How to Redeem</a></li>
                    </ul>
                </div>
            </section>
        	<ul class="slider">
            	<li>
                	<img src="<?php echo $this->webroot; ?>img/slide2.jpg">
                    <section class="slide_detail">
                        <div class="wrapper">
                            <section class="info">
                                <strong><img src="<?php echo $this->webroot; ?>img/bata_logo.png"></strong>
                                <h4>Important Instructions</h4>
                               <div class="list">
                                    <ul>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </li>
                                        <li>Nam sollicitudin velit eu dui euismod imperdiet.  </li>
                                        <li>Vivamus elementum et dui id bibendum.</li>
                                        <li>Nam sollicitudin velit eu dui euismod imperdiet. </li>
                                                               
                                    </ul>
                                </div>
                                <!--<a href="#">REDEEM VOUCHER</a>-->
                                <form action="#" id="locatorForm" name="locatorForm" onsubmit="return get_outlets();">
                                <fieldset>
                                <label>OUTLET LOCATER</label>
                                <input type="hidden" id="product_id" name="product_id" value="<?php if(isset($product_id)) echo $product_id; ?>"/>
                                <input type="text" name="city" id="city" placeholder="Enter city"/>
                                <input type="submit" value="LOCATE"/>
                                </fieldset>
                                </form>
                            </section>
                        </div>
                     </section>
                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer elementum nisl at lacus pharetra, quis elementum</p>
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
                    	<h3>BATA</h3>
                        <?php echo $this->element('all_brands_list'); ?>
                        
                    </section>
                    <section class="information_box">
                    	<h4>BATA INFORMATION</h4>
                        <ul>
                        	<li><span>HELPLINE</span><span>1800-xxx-xxxx</span></li>
                        	<li class="last"><span>WEBSITE</span><a href="#">www.bata.in</a></li>
                        </ul>
                    </section>
                </section>
            </div>
        </section>
        <section class="voucher_box">
        	<div class="wrapper">

            	<h3>Bata Vouchers also available  at </h3>
                <ul>
                	<li><img src="<?php echo $this->webroot; ?>img/img1.png"></li>
                	<li><img src="<?php echo $this->webroot; ?>img/img2.png"></li>
                	<li><img src="<?php echo $this->webroot; ?>img/img3.png"></li>
                </ul>
            </div>
        </section>
        <section class="bottom_box">
        	<div class="wrapper">
        		<h3>How to Redeem your <strong style="color:#F37612">Bata Gift Voucher</strong></h3>
                <img src="<?php echo $this->webroot; ?>img/bottom_img3.png">
                <!--<section class="buttons">
                	<a href="#">Redeen eVoucher</a>                	
                </section>-->
            </div>
        </section>
        
    </section>
   
    
<script type="text/javascript">

$(document).ready(function(e) {
    $(".list ul").mCustomScrollbar();
	<?php if(isset($cities) && !empty($cities)){ ?>
	var availableTags=[<?php 
			$last=count($cities); 
			$m=1;
			foreach($cities as $p ){ 
				if($m==$last){
					echo '"'.$p.'"';
					}else{
						echo '"'.$p.'",'; } }?>];
			
		$( "#city" ).autocomplete({
			source: availableTags,focus: function( event, ui ) {
				$( "#city" ).val( ui.item.label );
				return false;
			}
		});
	<?php } ?>	
});

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

function get_outlets(){
	
	var code=$('#city').val();
	var pr_id=$('#product_id').val();
	if(code==""){
		$('#city').css('border','1px solid #FF0000');
		$('#city').css('box-shadow','0 0 8px #FF0000');
		$('#city').effect( "bounce", "fast" );
	}else if(pr_id==""){
		alert("No Vouchers Available");
	}else{
		
		$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '900',
				'type'				: 'ajax',
				'height'            : '300',
				'href'          	: '<?php echo $this->webroot; ?>info/get_outlets/'+code.replace(' ','_')+'/'+pr_id,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);		
	}
	return false;	
}
</script>