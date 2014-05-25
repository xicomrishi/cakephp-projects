<section class="tabing_container">

        <section class="tabing" style="margin:12px 0 0 0">
          <ul class="gap">
           	<?php $i=1; foreach($content as $conts){ ?>
            <li id="li_tab_<?php echo $i;?>" class="li_tab"><a href="javascript://" onclick="change_page_cms('<?php echo $conts['Content']['page_name'];?>','<?php echo $i;?>');"><?php echo $conts['Content']['title'];?></a></li>
          	<?php $i++; } ?>
          </ul>
        </section>
       
        <section class="cms_page_detail">
        <?php echo $page_content['Content']['content'];?>
       </section>
        
</section>

<script type="text/javascript">
$(document).ready(function(e) {
    $('#li_tab_1').addClass('active');
});

function change_page_cms(page,num)
{
$.post('<?php echo SITE_URL;?>/info/get_page',{page_name:page},function(data){
		$('.contact_section').html(data);	
		$('.li_tab').removeClass('active');
		$('#li_tab_'+num).addClass('active');
	});	
	
}

</script>