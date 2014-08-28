<section class="left_container">
    <section class="black_row">
        <ul class="menu">
            <li class="active"><a href="javascript://" onclick="show_all_vouchers();">ALL</a></li>
            <!--<li><a href="#">BEST SELLING</a></li>-->
            <li><a href="javascript://" onclick="show_best_deals();">BEST DEALS</a></li>
        </ul>
                
        <?php if($allcount>4){ ?>        
        <section class="paging_sec all_list_paging">
            <a href="javascript://" onclick="show_next_vouchers(0,1);" class="left"></a>
            <span class="count_all_span">01 of 02</span>
            <a href="javascript://" onclick="show_next_vouchers(0,2);" class="right"></a>
        </section>
        <?php } 
		
		if($dealcount>4){ ?>		
        <section class="paging_sec deals_list_paging">
            <a href="javascript://" onclick="show_next_vouchers(1,1);" class="left"></a>
            <span class="count_deal_span">01 of 02</span>
            <a href="javascript://" onclick="show_next_vouchers(1,2);" class="right"></a>
        </section>
        <?php } ?>
    </section>
    <section class="offer_box">
        <ul class="all_vouchers_list">
        	<?php $num=$allnum=0; 
			if(!empty($alloffers)){
			foreach($alloffers as $ap){ ?>
            <li class="all_li_<?php echo $num; ?> all_li" style="display:none;">
            	<section class="price_box">
                    <strong><?php echo $ap['price']; ?></strong>
                    <a href="#"></a>
                </section>
                <section class="info_sec">
                    <p><?php echo str_replace("_","'",$ap['voucher_name']); ?></p>
                    <small>Offer Price:<span><?php if(isset($ap['display_in'])){ echo $ap['offer_price']; }else{ echo $ap['price']; } ?></span></small>
                    <h4><a href="javascript://" style="cursor:default;"><img src="<?php echo $this->webroot; ?>img/basket2.png"></a><a href="<?php echo $this->webroot; ?>home/gift_type" class="buy">BUY</a></h4>
                </section>
            </li>	
            <?php $allnum++;
					if($allnum==4) $num++;
			 }}else{ ?>
             	<li>
                	<section class="info_sec"><p>No deals available</p></section>
                </li>
             <?php } ?>           
        </ul>
        <ul class="best_deals_list">
        	<?php if(!empty($alloffers)){ 
					$num=$allnum=0;
					foreach($alloffers as $off){ 
						if(isset($ap['display_in'])){
					?>
                     <li class="deal_li_<?php echo $num; ?> deal_li" style="display:none;">
                        <section class="price_box">
                            <strong><?php echo $off['price']; ?></strong>
                            <a href="#"></a>
                        </section>
                        <section class="info_sec">
                            <p><?php echo str_replace("_","'",$off['voucher_name']); ?></p>
                            <small>Offer Price:<span><?php echo $off['offer_price']; ?></span></small>
                            <h4><a href="javascript://"  style="cursor:default;"><img src="<?php echo $this->webroot; ?>img/basket2.png"></a><a href="<?php echo $this->webroot; ?>home/gift_type" class="buy">BUY</a></h4>
                        </section>
                    </li>        	
            
            <?php  $allnum++;
					if($allnum>4) $num++;
					
					}}
					if($allnum==0){ ?>
					 <li>
                        <section class="info_sec" style="border-bottom:none;"><p>No deals available</p></section>
                    </li>	
				<?php	}	
					
					}else{ ?>
                    <li>
                        <section class="info_sec"><p>No deals available</p></section>
                    </li>
             <?php } ?> 
        </ul>
    </section>
    <section class="black_row center">
      <?php if($allcount>4){ ?>  
        <section class="paging_sec all_list_paging">
            <a href="javascript://" onclick="show_next_vouchers(0,1);"  class="left"></a>
            <span class="count_all_span">01 of 02</span>
            <a href="javascript://" onclick="show_next_vouchers(0,2);" class="right"></a>
        </section>
       <?php } 
	   if($dealcount>4){	?> 
        <section class="paging_sec deal_list_paging">
            <a href="javascript://" onclick="show_next_vouchers(1,1);"  class="left"></a>
            <span class="count_deal_span">01 of 02</span>
            <a href="javascript://" onclick="show_next_vouchers(1,2);" class="right"></a>
        </section>
       <?php }else echo '&nbsp'; ?> 
    </section>
</section>

<script type="text/javascript">
var globalcount=0;
$(document).ready(function(e) {
	
	
	
    $('.all_vouchers_list').show();
	$('.best_deals_list').hide();
	
	$('.all_list_paging').show();
	$('.deal_list_paging').show();
	
	$('.all_li_0').show();
	$('.deal_li_0').show();
	
	$('.menu li').removeClass('active');
	$('.menu li:first').addClass('active');
});

function show_next_vouchers(type,action){
	
	var display='.all_li';
	var other='.deal_li';
	var text_count='.count_all_span';	

	if(type==1){
		display='.deal_li';
		other='.all_li';
		var text_count='.count_deal_span';	
	}

	if(globalcount==0 && action=='2'){
		globalcount=parseInt(globalcount)+1;
		$(other).hide();
		$(display).hide();
		$(display+'_'+globalcount).show();
		$(text_count).html('02 of 02');	
	}else if(globalcount>0 && action=='1'){
		globalcount=parseInt(globalcount)-1;
		$(other).hide();
		$(display).hide();
		$(display+'_'+globalcount).show();	
		$(text_count).html('01 of 02');	
	}
	
}
</script>