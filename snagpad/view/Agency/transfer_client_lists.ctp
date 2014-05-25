	<?php
$this->Paginator->options(array(
'url' => $this->data,
    'update' => '#search_section',
    'evalScripts' => true,
    
));

?>
<?php 
if(is_array($clients) && count($clients)>0){?>
      
        <?php foreach($clients as $client){?>
        <section class="cmn_row">
        <span class="coln1" style="width:98px"><input type="checkbox" name="id[]" class="check" value="<?php echo $client['Client']['account_id']; ?>" onclick="objDelChecked(this)" ></span>
        <span class="coln2 color" style="width:220px; text-align:left"><?php echo $client['Client']['name'];?></span>
        <span class="coln3 color" style="width:400px"><?php echo $client['Client']['email'];?></span>   
        <span class="coln4 color" style="width:200px; text-align:center"><?php echo show_formatted_date($client['Client']['reg_date']);?></span>       
        </section>
        <?php }?>
 

<?php }else{?>
<div style="text-align: center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal">No record found</div>
<?php } ?>
<script type="text/javascript">  
function objDelChecked(chk)
 {
     if(chk.checked==true)
     iDelTotalChecked=iDelTotalChecked+1
 else
  iDelTotalChecked=iDelTotalChecked-1
}
function check(el)
{
	if(el.checked==true)
	{
		$('.check').attr('checked',true);
		iDelTotalChecked=<?php echo count($client);?>;
		
	}else{
		$('.check').attr('checked',false);
		iDelTotalChecked=0;
	}
}


</script>
	<?php /*?><?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p><?php */?>

	<div class="paging">
	<?php
		//echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		//echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
<?php echo $this->Js->writeBuffer(); ?>       