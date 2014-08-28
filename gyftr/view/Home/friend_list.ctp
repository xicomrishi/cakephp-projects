<?php echo $this->Html->css('jquery.ui.autocomplete');?>
<?php //echo $this->Html->script('tinysort');?>
<div id="form_section" style="margin:0 0 5px 0; padding:0 1%;">
<div class="select_dele all">/ / Friend <strong>list</strong></div>

<div style="margin-top:57px;">
<label>Search Friends: </label>
<input type="text" id="search_frnd" name="search_frnd" style="padding:4px;"/>
</div>


 <div class="nano">
 <div class="friend_detail_row">

 
<?php  
if(!isset($gm_friends)){
if(!empty($friends)) {		
		foreach($friends as $fnd){ ?>

<div class="friend_det" id="<?php echo $fnd['first_name']; ?>" onclick="select_friend('<?php echo $fnd['id']?>','<?php echo $fnd['first_name']; ?>','1');">
<div class="image"><?php echo '<img src="https://graph.facebook.com/'.$fnd['id'].'/picture" alt=""/>'; ?></div>
<div class="name"><?php echo $fnd['first_name'].' '.$fnd['last_name']; ?></div>
</div>  
   
<?php }}}else if(isset($gm_friends)){ 
			foreach($gm_friends as $gm){ $string = str_replace(array(' ','\'', '"', ',' , ';', '<', '>','.'),'_',$gm['name']);  ?>
            
<div class="friend_det" id="<?php echo $string; ?>" onclick="select_friend('<?php echo $gm['email']?>','<?php echo $gm['name']; ?>','2');">
<div class="image"><?php echo '<img src="/img/facebook_profile_pic.jpg" alt=""/>'; ?></div>
<div class="name"><?php echo $gm['name'];?></div>
</div>			
				
<?php 	}}else echo 'No friends Found!'; ?>  
   </div>  
</div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	$(".nano").nanoScroller({alwaysVisible:true, contentClass:'friend_detail_row' });
	
    	//$('.login_sec').hide();
		//update_user_pic();
		//$('.logout_sec').show();

		var availableTags=[<?php 
			$last=count($datfrnds); 
			$m=1;
			foreach($datfrnds as $j ){ 
			 
				if($m==$last){
					echo '"'.$j.'"';
					}else{
						echo '"'.$j.'",'; } }?>];
		//alert(availableTags);				
		$( "#search_frnd" ).autocomplete({
			source: availableTags,
			focus: function( event, ui ) {
				
				var disp=ui.item.label.replace(/ /g,"_");
				disp=disp.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,"_");
				$( "#search_frnd" ).val( ui.item.label );
				var selectedDiv=$('#'+disp).clone();
				$('#'+disp).remove();
				$('.friend_detail_row').prepend(selectedDiv);
				//$('.friend_det').hide();
				//$('.friend_detail_row').tsort('div#'+ui.item.label);
				//$('#'+ui.item.label).tsort({place:'start'});
				//$('#'+ui.item.label).show();
				//$('#'+ui.item.label).show();
				return false;
			}
		});				
setTimeout(function(){$(".nano").nanoScroller({alwaysVisible:true, contentClass:'friend_detail_row' })},5000);

});


function select_friend(id,name,typ)
{
	var field='friend_name';

	$.post('<?php echo SITE_URL; ?>/home/set_session/<?php echo $this->Session->read('User.User.id');?>',{dat:'friend_name',value:name,email:id,type:typ},function(data){
		
		$('#friend_name').val(name);	
		$.fancybox.close();	
		setTimeout(function(){nextStep('step-3','<?php echo $this->Session->read('Gifting.type');?>');},500);
	});
}
</script>
