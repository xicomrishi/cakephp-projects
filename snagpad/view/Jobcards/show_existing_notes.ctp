<input type="hidden" id="coach_flag" value="<?php echo $flag; ?>" />
   <p class="full ">

  <?php 
  if(!empty($notes)){
  foreach($notes as $note){ ?>
  	<i><?php echo show_formatted_date($note['Note']['date_added']); ?></i>
  	<?php echo '<br>'.stripslashes($note['Note']['note']).'<br>';
  }}else{
  ?>
  No Notes Found
  <?php } ?></p>


  
  
<script type="text/javascript">
$(document).ready(function(){
	var flag=$('#coach_flag').val();
	alert(flag);
	if(flag==0)
	{
		$('.coach_not_linked').html('You are not linked to a coach');	
		//$('.submit_left').removeClass('full');	
		}
});
</script>	  