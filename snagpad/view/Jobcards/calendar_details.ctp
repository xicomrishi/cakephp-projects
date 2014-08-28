 <h4><?php echo $date;?></h4>
                  <ul>
                  <?php 
				  		if($flag=='1'){
				  		foreach($data as $dat){ 
				  			foreach($dat['field'] as $field) {   ?>
                  <li><strong><a href="javascript://" onclick="display_strat_from_cal('<?php echo $dat['card'];?>','<?php echo $field;?>');"><?php echo $field;?></a></strong></li>
                  <?php } } }else{ ?>
                 
                  <li class="none"><strong style="float:none">There are no action items.</strong></li>
                  <?php } ?>
				
<script type="text/javascript">
function display_strat_from_cal(card_id,field)
{
	
	window.location='<?php echo SITE_URL;?>/jobcards/view/'+card_id;
			
}
</script>                  