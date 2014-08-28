<section class="tabing_container">

        <section class="tabing" style="margin:12px 0 0 0">
          <ul class="gap">
          <?php foreach($contents as $content){
			  echo "<li id='li_".$content['Content']['page_url']."' class='li_con'><a href='javascript://' onclick='show_content(\"".$content['Content']['page_url']."\")'>".$content['Content']['title']."</a></li>";
		  }
		  ?>
		  <!-- li id="outplacement"><a href="javascript://" onclick="display_outplacement();">OUTPLACEMENT</a></li>
           <li id="higheredu"><a href="javascript://" onclick="display_higheredu();">HIGHER EDUCATION</a></li>
            <li id="job_search_prof" class="active"><a href="javascript://" onclick="display_job_search_prof();">JOB SEARCH PROFESSIONALS</a></li -->
          	
          </ul>
        </section>
<section class="cms_page_detail">
<div class="do_u_asist">
       <?php foreach($contents as $content){?>
	<div class="<?php echo $content['Content']['page_url'];?> cmscon">
	    <h2><?php echo $content['Content']['title'];?></h2>
    	<?php echo $content['Content']['content'];?>	   
    </div>
	   <?php }?>
       </div>
</section>
<script type="text/javascript">
	function show_content(id){
		$('.cmscon').hide();
		$('.'+id).show();
		$('.li_con').removeClass('active');
		$('#li_'+id).addClass('active');
  	    $("html, body").animate({ scrollTop: 0 }, 600);	
	}
	show_content('<?php echo $default;?>');
</script>	   	 