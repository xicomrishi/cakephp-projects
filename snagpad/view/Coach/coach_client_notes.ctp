<div class="coach_notes"><?php if(!empty($notes)) { 
	foreach($notes as $note){
	?>
<p>wrote on <?php echo show_formatted_date($note['Note']['date_added']);?></p>    
<p class="border"><?php echo $note['Note']['note'];?></p>

<?php }}else{ echo 'No note found';} ?>
</div>
<div>
<form id="notes_form" name="notes_form" action="">
<input type="hidden" name="clientid" value="<?php echo $clientid;?>"/>
<label style="width:127px;">Note: </label>
<textarea name="note" id="notes_coach" style="width:509px;"></textarea>
<span class="row">
<a href="javascript://" onclick="submit_note();">SUBMIT</a></span>
</form>
</div>

<script type="text/javascript">
$(document).ready(function(e) {
    $("html, body").animate({ scrollTop: 0 }, 600);
});
function submit_note()
{	
	var text=$('#notes_coach').val();
	if(text==''){
		}else{
	$.post('<?php echo SITE_URL;?>/coach/save_coach_client_note',$('#notes_form').serialize(),function(data){
		$('.coach_notes').html(data);
		document.getElementById('notes_form').reset();
	});
		}
	
}
</script>