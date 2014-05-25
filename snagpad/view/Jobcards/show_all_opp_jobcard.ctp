<section class="tabing_container">
<section class="job_search_section">
        <section class="heading_row border">
       
        <span class="col2" style="text-indent:8px">Company Name</span>
        <span class="col3">Position</span>
        <span class="col4"><strong style="background:none">Date Snagged</strong></span>
        <span class="col5 none">nn</span>
        </section>
        <?php 
		
		foreach($cards as $card){ ?>
       	<section class="heading_row">
        <span class="col2" style="padding:0 0 0 6px"><?php echo $card['Card']['company_name'];?></span>
        <span class="col3"><?php echo $card['Card']['position_available'];?></span>
        <span class="col4 spacer" style="width:195px !important;text-indent:20px"><?php if(!empty($card['Card']['reg_date'])) { echo show_formatted_date($card['Card']['reg_date']);}else{ echo 'NA';}?></span>
        <span class="col5" style="width:152px !important;"><a href="javascript://" onclick="display_card_strat('<?php echo $card['Card']['id'];?>')">Apply</a></span>
        </section>
        <?php } ?>
        
</section>
</section>

<script type="text/javascript">
$(document).ready(function(e) {
     $("html, body").animate({ scrollTop: 0 }, 300);
	
});
function display_card_strat(card_id)
{
	$.post('<?php echo SITE_URL;?>/jobcards/display_card',{card_id:card_id},function(data){
		show_strategy(card_id,data,'O');
	});
}

</script>