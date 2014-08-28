<?php echo $this->Html->css('jquery.ui.autocomplete');?>
<?php //echo $this->Html->script('tinysort');?>
<div id="form_section" style="margin:0 0 5px 0; padding:0 1%;">
<div class="select_dele all">/ / Friend <strong>list</strong></div>

<div style="margin-top:57px;">
<label>Search Friends: </label>
<input type="text" id="search_frnd" name="search_frnd" style="padding:4px;"/>
<a href="javascript://" onclick="submit_all_friends();" style="float:none; font-size:12px; padding-left:10px !important; padding-right:10px !important;" class="done">Done</a>
</div>


 <div class="nano_1 nano">
 <div class="friend_detail_row">

 
<?php  
if(!isset($gm_friends)){
if(!empty($friends)) {		
		foreach($friends as $fnd){ ?>

<div class="friend_det" id="<?php echo $fnd['first_name']; ?>">

<div class="image"><input type="checkbox"  class="fb selecting" title="<?php echo 'name_'.$fnd['id']; ?>" value="<?php echo $fnd['first_name']; ?>" style="float:left; margin-top:37px; margin-right:5px;"/><?php echo '<img src="https://graph.facebook.com/'.$fnd['id'].'/picture" alt=""/>'; ?></div>
<div class="name"><?php echo $fnd['first_name'].' '.$fnd['last_name']; ?></div>
</div>  
   
<?php }}}else if(isset($gm_friends)){ 
			foreach($gm_friends as $gm){ $string = str_replace(array(' ','\'', '"', ',' , ';', '<', '>','.'),'_',$gm['name']);  ?>
            
<div class="friend_det" id="<?php echo $string; ?>">
<div class="image"><input type="checkbox" class="gm selecting" title="<?php echo $gm['email']; ?>" value="<?php echo $gm['name']; ?>" style="float:left; margin-top:37px; margin-right:5px;"/><?php echo '<img src="/img/facebook_profile_pic.jpg" alt=""/>'; ?></div>
<div class="name"><?php echo $gm['name'];?></div>
</div>			
				
<?php 	}}else echo 'No friends Found!'; ?>  
   </div>  
</div>
</div>
<form id="friendsForm" name="friendsForm">
<div class="fr_form_div"></div>
</form>
<script type="text/javascript">
$(document).ready(function(e) {
	$(".nano_1").nanoScroller({alwaysVisible:true, contentClass:'friend_detail_row' });
	
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
				return false;
			}
		});				
setTimeout(function(){$(".nano_1").nanoScroller({alwaysVisible:true, contentClass:'friend_detail_row' }); },5000);

});

function submit_all_friends()
{
	$('.chip_detail').html('<div style="height:100px; margin-top:30px;text-align:center;"><img src="<?php echo SITE_URL; ?>/img/ajax-loader.gif" alt="Loading..."/></div>');
	var fb=gm=0; 
	$('.selecting').each(function(index, element) {
		
		if($(this).is(':checked'))
		{	
			
			if($(this).attr('class')=='fb selecting')
			{				
				
				var name=$(this).attr('value').replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,"_");				
				$('.fr_form_div').append('<input type="hidden" name="data[frnd]['+fb+'][name]" value="'+name+'"/><input type="hidden" name="data[frnd]['+fb+'][fid]" value="'+$(this).attr('title')+'"/>');
				fb++;
			}else{
				
				var name=$(this).attr('value').replace(/[&\/\\#,+()$~%.'":*?<>{}]/g,"_");				
				$('.fr_form_div').append('<input type="hidden" name="data[frnd]['+gm+'][name]" value="'+name+'"/><input type="hidden" name="data[frnd]['+gm+'][email]" value="'+$(this).attr('title')+'"/>');
				gm++;
			}
			
		}
    });	
	
	setTimeout(function(){
		var frm=$('#friendsForm').serialize();
		$.post('<?php echo SITE_URL; ?>/home/update_chip_list',frm,function(data){
				$('.chip_detail').html(data);
				$.fancybox.close();
				document.getElementById('chipinForm').reset();	
		});
		
	},1000);
}
</script>
