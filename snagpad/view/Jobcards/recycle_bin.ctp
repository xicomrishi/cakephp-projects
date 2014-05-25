<section class="tabing_container">
<section class="tabing">
          <ul>
           <li class="active last"><a>RECYCLE BIN</a></li>
          </ul>
        </section>
        
<section class="job_search_section">
        <section class="heading_row">
       
        <span class="col2" style="text-indent:8px">Company Name</span>
        <span class="col3">Position</span>
        <span class="col4"><strong>Location</strong></span>
        <span class="col5 none">nn</span>
        <span class="col5 none">nn</span>
        </section>
        <?php 
		$i=1;
		foreach($cards as $card){ ?>
       	<section class="heading_row" id="head_row_<?php echo $i;?>">
        <span class="col2" style="text-indent:8px"><?php echo $card['Card']['company_name'];?></span>
        <span class="col3"><?php echo $card['Card']['position_available'];?></span>
        <span class="col4 spacer" style="width:195px !important;text-indent:20px"><?php $val=$card['Card']['city'].','.$card['Card']['state'].','.$card['Card']['country']; if($val!=',,'&&$val!='Job Location i.e City,State,Country') { echo $val; }else{ echo 'NA';}?></span>
         <span class="col5" id="restore_<?php echo $i;?>" style="width:152px !important;"><a href="javascript://" onclick="restore_card('<?php echo $card['Card']['id'];?>','<?php echo $i;?>')">Restore</a></span>
        <span class="col5" id="delete_<?php echo $i;?>" style="width:152px !important; margin:0 0 0 12px"><a href="javascript://" onclick="delete_card('<?php echo $card['Card']['id'];?>','<?php echo $i;?>')">Delete</a></span>
        </section>
        <?php $i++;} ?>
        
</section>
</section>

<script type="text/javascript">
function delete_card(card_id,row)
{
	answer = confirm("Are you sure you want to permanently delete job card?");
		if (answer !=0)
		{
	$('#head_row_'+row).html('<div style="height:20px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/delete_card',{card_id:card_id},function(data){
		$('#head_row_'+row).html('<div style="height:10px; margin-left:450px;">Card deleted.</div>');
		setTimeout(function(){$('#head_row_'+row).html('')},3000);
		$('#head_row_'+row).slideUp();
	});
		}else{
				return false;
			}
}

function restore_card(card_id,row)
{
	$.post('<?php echo SITE_URL;?>/jobcards/restore_card',{cardid:card_id},function(data){
			
			//$('#restore_'+row).html('<a href="javascript://" class="snagged">Restored</a>');
			$('#head_row_'+row).slideUp();
			get_strategy_meter();
		});	
	
}

</script>