<div id="flashmsg" style="display:none;"></div>
<div id="searchSection">
	<h2><?php echo __('Points');?></h2>
    <div id="tableSection">
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th align="left"><?php echo $this->Paginator->sort('id','S.No.');?></th>
			<th><?php echo $this->Paginator->sort('range','Upto');?></th>
			<th><?php echo $this->Paginator->sort('points');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
       <?php $i = 0;
	foreach ($points as $pt){
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		
		?>
        <tr <?php echo $class; ?>>
		<td><?php echo $pt['Points']['id']; ?></td>
		<td><?php echo $pt['Points']['range']; ?></td>
		<td><?php echo $pt['Points']['points']; if($pt['Points']['range']!='default'){ echo ' %'; }?></td>
			
		<td class="actions">
       		<a href="javascript://" onclick="edit_range('<?php echo $pt['Points']['id']; ?>');">Edit</a>
			<?php if($pt['Points']['id']!=1){ ?><a href="javascript://" onclick="delete_range('<?php echo $pt['Points']['id']; ?>');">Delete</a><?php } ?>						
		</td>
		</tr>
        
      <?php }  ?> 
      
 
</table>
</div>
<!--<div class="actions"> <a href="javascript://" onclick="add_range();">Add Range</a></div>-->
</div>   
<script type="text/javascript">
$(document).ready(function(e) {
    $("#defPointsForm").validationEngine();
	
});



</script> 