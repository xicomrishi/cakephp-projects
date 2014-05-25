<section class="tabing_container">
<section class="job_search_section">
	
		<section class="heading_row">
        <span class="col2" style="text-indent:15px">Position : </span>
        <span class="col3" style="width:500px"><?php echo $data['position']; ?></span>
        </section>
        <section class="heading_row">
        <span class="col2" style="text-indent:15px">Company : </span>
        <span class="col3" style="width:500px"><?php echo $data['company']; ?></span>
        </section>
        <section class="heading_row">
        <span class="col2" style="text-indent:15px">Country : </span>
        <span class="col3" style="width:500px"><?php echo $data['country']; ?></span>
        </section>
        <section class="heading_row">
        <span class="col2" style="text-indent:15px">City : </span>
        <span class="col3" style="width:500px"><?php echo $data['city']; ?></span>
        </section>
        <section class="heading_row">
        <span class="col2" style="text-indent:15px">State : </span>
        <span class="col3" style="width:500px"><?php echo $data['state']; ?></span>
        </section>
        <section class="heading_row">
        <span class="col2" style="text-indent:15px">Job URL : </span>
        <span class="col3" style="width:500px"><a href="<?php echo $data['job_url'];?>" target="_blank" style="color:#2168A0; text-decoration:none">Click here</a></span>
        </section>
        <?php if($data['resource_id']=='2') { ?>
         <section class="heading_row">
        <span class="col2" style="text-indent:15px">Description : </span>
        <span class="col3" style="width:500px"><?php echo $data['description']; ?></span>
        </section>
        <?php } ?>
        
      
        
        
</section>
</section>

<script type="text/javascript">
$(document).ready(function(e) {
     $("html, body").animate({ scrollTop: 0 }, 600);
	
});

</script>