<form id="addRangeForm" name="addRangeForm" method="post" action="" onsubmit="return save_range_form();">
<input type="hidden" name="point_id" value="<?php if(isset($range)){ echo $range['Points']['id']; }?>"/>
<div>
<label>Range: </label>
<input type="text" name="range" class="validate[required]" value="<?php if(isset($range)){ echo $range['Points']['range']; }?>"/>
</div>
<div>
<label>Points (in %): </label>
<input type="text" name="points" class="validate[required,custom[integer]],min[0],max[99]"  value="<?php if(isset($range)){ echo $range['Points']['points']; }?>"/>
</div>
<div>
<input type="submit" value="Save" onClick="return save_range_form();"/>
</div>
</form>

<script type="text/javascript">
$(document).ready(function(e) {
     $("#addRangeForm").validationEngine();
});
</script>