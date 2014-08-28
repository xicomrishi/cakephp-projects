<section class="tabing_container">
<section class="job_search_section" style="min-height:300px;">
<?php if(!empty($cards))
		{ ?>
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
        <span class="col5" style="width:152px !important;"><a href="<?php echo SITE_URL;?>/jobcards/view/<?php echo $card['Card']['id']; ?>">View Card</a></span>
        </section>
        <?php }}else{ ?>
        <div style="text-align: center; width:100%; height:300px; padding:150px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal; text-align:center"><?php echo 'Contact not tied to any Job Cards!'; ?> </div>
        <?php } ?>
        
</section>
</section>

<script type="text/javascript">
$(document).ready(function(e) {
     $("html, body").animate({ scrollTop: 0 }, 300);
	
});

</script>