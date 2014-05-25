<div class="tab_container">
	          	
                <?php $this->requestAction('/info/get_discount_offers/6'); ?>                 
      
    <div class="wrapper">
	<ul class="tabing">
                <li><a href="<?php echo $this->webroot; ?>how-does-it-work">how does it work?</a></li>
                <li><a href="<?php echo $this->webroot; ?>contest">contest</a></li>
                <li><a href="<?php echo $this->webroot; ?>promo-codes">promo codes</a></li>
                <li><a href="<?php echo $this->webroot; ?>loyalty">loyalty</a></li>
                <li><a href="<?php echo $this->webroot; ?>contact-us">contact us</a></li>
                <li><a href="<?php echo $this->webroot; ?>faq">f.a.qs</a></li>
                <li class="active"><a href="javascript://">offers</a></li>
           </ul>
</div>
</div>



<script type="text/javascript">
$('.brand_container').cycle({
		fx:'fade',
		timeout:4000,
		speed:1000,
		pager: '.paging_bottom_home',
		activePagerClass: 'active',
			pagerAnchorBuilder: function(idx, slide) {
		 return '.paging_bottom_home li:eq(' + (idx) + ')';		
 		}
	});
</script>
