<p class="full ">
<?php 
$global_col=array('O','A','S','I','V','J');
$num=0; $i=1; foreach($n as $key=>$note){ 
	if($key==$col) { 
?>
<a href="javascript://" onclick="toggle_expand('<?php echo $i;?>','0')" class="expand" id="expand_<?php echo $num;?>">
<?php echo $this->Html->image('minus-icon.png',array('escape'=>false,'alt'=>'-'));
		echo ' '.$note['col_name'];
?></a>
<div class="col_text" id="col_text_<?php echo $i;?>"><?php echo $note[$i]['date'].'<br>'.$note[$i]['text'];?></div>
<?php //echo $?>
<?php }else{ ?>
<a href="javascript://" onclick="toggle_expand('<?php echo $i;?>','1');" class="collapse" id="collapse_<?php echo $num;?>"><?php echo $this->Html->image('plus-icon.png',array('escape'=>false,'alt'=>'-'));
echo ' '.$note['col_name'];
?></a>
<div class="col_text" style="display:none;" id="col_text_<?php echo $i;?>"><?php echo $note[$i]['date'].'<br>'.$note[$i]['text'];?></div>

<?php } ?>		<br/>

<?php $num++; } ?>





  <?php /*foreach($notes as $note){ 
  	echo show_formatted_date($note['Note']['date_added']);
  	echo '<br>'.$note['Note']['note'].'<br>';
  }*/
  ?>
  
  </p>

</section>
</div>
  
  
  
<script type="text/javascript">

function toggle_expand(key,stat)
{
	//$('.colclass').hide();
	//$('.expand').show();
	//$('.collapse').hide();
	//$('#col_text_'+key).hide();
	if(stat==0){
	//$('#expand_'+key).hide();
	//$('#collapse_'+key).show();
	//$('#col_'+key).show();
	$('#col_text').hide();
	$('#col_text_'+key).show();
	}
}
</script>	  