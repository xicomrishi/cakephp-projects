<div class="nano nano_3">
<div class="detail none scroll">
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="none">
            <tbody>
            	<?php 
				$m=0;
				foreach($data as $dat){ ?>
                	<tr class="<?php if($m%2==0) echo 'even'; else echo 'odd'; ?>">
               			 <td align="left"><?php if(!empty($dat['fb_id'])){ ?><img src="https://graph.facebook.com/<?php echo $dat['fb_id']?>/picture" alt="" height="28" width="28"/><?php }else{  ?><img src="<?php echo $this->webroot; ?>img/facebook_profile_pic.jpg" alt="" height="28" width="28"/><?php } ?>
                         <?php echo $dat['name']; ?>
                         </td>
                	</tr>
                <?php $m++; } ?>
             
            </tbody>
        </table>
   </div>      
</div>        

<script type="text/javascript">
$(document).ready(function(e) {
	setTimeout(function(){ $(".nano_3").nanoScroller({alwaysVisible:true, contentClass:'detail',sliderMaxHeight: 70 });},500);
	$('.done_button').html('<a href="javascript://" onclick="next_contri_step();" class="done orenge">Done</a>');
});
</script>