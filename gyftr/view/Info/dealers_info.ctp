<div class="nano">
<div class="detail">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr class="head_row">
<td class="col first">Name</td>
<td class="col">Address</td>
<td class="col">City</td>
<td class="col">State</td>
<td class="col">Phone</td>

</tr>
<?php foreach($dealer as $sh){ ?>
<tr class="conm_row last">
<td class="col first"><?php echo $sh['Shops']['name']; ?></td>
<td class="col"><?php echo $sh['Shops']['address']; ?></td>
<td class="col"><?php echo $sh['Shops']['city']; ?></td>
<td class="col"><?php echo $sh['Shops']['state']; ?></td>
<td class="col"><?php echo $sh['Shops']['phone']; ?></td>
</tr>
<?php } ?>
</table>
</div>
</div>


<script type="text/javascript">
$(document).ready(function(e) {
    setTimeout(function(){ $(".nano").nanoScroller({alwaysVisible:true, contentClass:'detail',sliderMaxHeight: 70 });},1000);
});
</script>
