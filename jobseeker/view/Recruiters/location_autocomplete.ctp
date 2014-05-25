<?php if(!empty($Locations)){?>
<div>
 <?php
   foreach($Locations as $loc) { 
 ?>
   <div>
    <a href="Javascript:void(0)" onclick="locSelected('<?php echo $loc ?>','<?php echo $Place ?>')"><?php echo $loc ?></a>
   </div>
 <?php	   
   }
 ?>
</div>
<?php  }?>