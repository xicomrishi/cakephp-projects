<div class="friend_detail_row">
<?php  if(!empty($friends)) {	$i=0;	
		foreach($friends as $fnd){ ?>
<div class="friend_det">
<div class="check"><input type="checkbox" id="<?php echo $i; ?>" name="<?php echo $fnd['id'].'_'.$fnd['first_name']; ?>"  /></div> 
<div class="image"><?php echo '<img src="https://graph.facebook.com/'.$fnd['id'].'/picture" alt=""/>'; ?></div>
<div class="name"><?php echo $fnd['first_name']; ?></div>
</div>      
<?php $i++; }}else echo 'No friends Found!'; ?>  
<div class="submit_row">
<a href="javascript://" onclick="add_selected_friends();" class="done">Done</a>  
</div>   
</div>



<script type="text/javascript">
$(document).ready(function(e) {
    	$('.login_sec').hide();
		update_user_pic();
		$('.logout_sec').show();
});
function add_selected_friends()
{
	var values = new Array();
	$('input:checkbox').each(function(index, element) {
        if($(this).attr('checked'))
		{
			var id=$(this).attr('id');
			var info=$(this).attr('name');
			values[id]=info;			
		}	
    });
	//alert(values);
	
	$.post('<?php echo SITE_URL; ?>/home/add_selected_friends/<?php echo $this->Session->read('User.User.id'); ?>/<?php echo $status_step; ?>',{values:values},function(frm){
		
	<?php if($status_step==1){ ?>
		$('#chip_in_frnd').val(frm);
		update_frnd_list();
		<?php }else{ ?>
		//alert(frm);
			var frm=unescape(frm);
			var resp=frm.split('|');
			sendRequestToRecipients(resp[0],resp[1],resp[2]);
		//$('#banner').html(frm);
		<?php } ?>	
		$.fancybox.close();	
	});	

}
</script>