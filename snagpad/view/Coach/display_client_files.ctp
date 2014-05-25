<section class="tabing_container">
<section class="job_search_section">
        <section class="heading_row">
       
        <span class="col2" style="text-indent:8px">File Name</span>
        <span class="col3">Description</span>
        <span class="col4"><strong>Last Modified</strong></span>
        <!--<span class="col5 none">nn</span>-->
        </section>
        <?php 
		if(!empty($files)) {
		foreach($files as $file){ ?>
       	<section class="heading_row">
        <span class="col2" style="text-indent:8px"><a href="<?php echo $path.$file['Clientfile']['file'];?>" target="_blank"><?php echo $file['Clientfile']['filename'];?></a></span>
        <span class="col3"><?php if(!empty($file['Clientfile']['description'])&&($file['Clientfile']['description']!='Description')) { echo $file['Clientfile']['description']; }else{ echo 'NA';}?></span>
        <span class="col4 spacer" style="width:195px !important;text-indent:20px"><?php echo show_formatted_date($file['Clientfile']['last_modified']);?></span>
       <!-- <span class="col5" style="width:152px !important;"><a href="javascript://" onclick="display_card_strat('<?php echo $card['Card']['id'];?>')">Apply</a></span>-->
        </section>
        <?php } }else{?><div style="text-align: center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal">No File Found</div><?php  } ?>
        
</section>
</section>
<script type="text/javascript">
$(document).ready(function(e) {
    $("html, body").animate({ scrollTop: 0 }, 600);
});
</script>
