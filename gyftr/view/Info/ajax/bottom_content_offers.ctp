<div class="tab_container">
	          	
                <?php $this->requestAction('/info/get_discount_offers/6'); ?>                 
      
    <div class="wrapper">
	<ul class="tabing">
                <li><a href="javascript://" onclick="get_bottom_page_ajax('howitwork');">how does it work?</a></li>
                <li><a href="javascript://" onclick="get_bottom_page_ajax('contest');">contest</a></li>
                <li><a href="javascript://" onclick="get_bottom_page_ajax('promocode');">promo codes</a></li>
                <li><a href="javascript://" onclick="get_bottom_page_ajax('loyalty');">loyalty</a></li>
                <li><a href="javascript://" onclick="get_bottom_page_ajax('contact');">contact us</a></li>
                <li><a href="javascript://" onclick="get_bottom_page_ajax('faq');">f.a.qs</a></li>
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
