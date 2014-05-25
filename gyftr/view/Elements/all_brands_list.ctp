<ul style="min-height:300px;">
	<?php 
			$count=0;
	 foreach($allbrands as $ab){ $count++; ?>
    	<li class="<?php if($count<=9) echo 'first_br'; else echo 'second_br'; if($count=='9' || $count=='18') echo ' last';?>"><a href="<?php echo $this->webroot.str_replace(' ','-',strtolower($ab['GiftBrand']['name'])); ?>"><?php echo str_replace('_',"'",$ab['GiftBrand']['name']); ?></a></li>
    <?php } ?>
</ul>
<ul class="paging">
    <li><a href="javascript://" onclick="show_brand_list(2);" class="right"></a></li>
    <li><a href="javascript://" onclick="show_brand_list(1);" class="left"></a></li>
</ul>

<script type="text/javascript">
$(document).ready(function(e) {
    $('.second_br').hide();
});

function show_brand_list(count){
	var up='.first_br';
	var down='.second_br';
	if(count==2){
		$(up).hide('fast');
		setTimeout(function(){ $(down).show('fast'); },200);	
			
	}else if(count==1){
		$(down).hide('fast');
		setTimeout(function(){ $(up).show('fast'); },200);	
	}	
}
</script>