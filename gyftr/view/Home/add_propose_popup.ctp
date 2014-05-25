<div id="form_section" class="prop_form" style="margin:0 0 5px 0; padding:0;  width:99.3%">
<?php if($flag==1){ ?>
<span class="select_dele">/ / Propose <strong>Contributor</strong></span>
<div class="comm_row">
<form id="add_frnd_form" name="add_frnd_form" method="post" action="">
<input type="hidden" id="count_frnd" value="0"/>
<input type="hidden" name="data[puser][0][fb_id]"/>
<input type="hidden" name="order_id" value="<?php echo $order_id; ?>"/>
<input type="hidden" name="userid" value="<?php echo $userid; ?>"/>
<div class="nano" style="width:100%">
<div class="multi_frnds">
<div id="proposed_friend" style="float:left; width:100%">
<input type="text" id="frnd_name" name="data[puser][0][frnd_name]" class="validate[required]" placeholder="Enter Friend Name"/>
<input type="text" id="frnd_email" name="data[puser][0][frnd_email]" class="validate[required,custom[email]]" placeholder="Enter Friend Email"/>
<input type="text" id="frnd_phone" name="data[puser][0][frnd_phone]" class="validate[required,custom[integer],minSize[10],maxSize[10]]" placeholder="Enter Friend Phone"/>
</div>
</div></div>
<div style="float: left; margin: 20px 0px 0px;">
<a href="javascript://" onclick="add_another_field();" class="add_friend"><?php echo $this->Html->image('add-friend.png',array('escape'=>false));?></a>
</div>
<div style="margin: 0px 57px 0px; float: right;">
<input  type="submit" value="Submit" class="done" id="prop_submit" style="width:110% !important" onclick="return inc_added_frnd();"/>
</div>
</form>
</div>
<?php }else{ ?>
<div>Sorry! This gift has been closed.</div>
<?php } ?>

</div>
<script type="text/javascript">
$(document).ready(function(e) {
    $("#add_frnd_form").validationEngine({promptPosition: "topLeft",scroll:false ,focusFirstField : false});
	$(".nano").nanoScroller({alwaysVisible:true, contentClass:'multi_frnds',sliderMaxHeight: 70 });
	
	

        $('input[placeholder]').each(function(){  
			var input = $(this);        
			
			$(input).val(input.attr('placeholder'));
						
			$(input).focus(function(){
				if (input.val() == input.attr('placeholder')) {
				   input.val('');
				}
			});
				
			$(input).blur(function(){
			   if (input.val() == '' || input.val() == input.attr('placeholder')) {
				   input.val(input.attr('placeholder'));
			   }
			   setTimeout(function(){ $('input').css('border','1px solid #ABD0E9'); },100);
			   
			});
		});
    
 
	
});

function inc_added_frnd()
{
	var valid = $("#add_frnd_form").validationEngine('validate');
	if(valid)
	{
		var frm=$('#add_frnd_form').serialize();
		showLoading('.prop_form');
			$.post('<?php echo SITE_URL; ?>/home/propose_contri_member',frm,function(data){
				//$('#banner').html(data);
				$.fancybox.close();
			});
		
	}else{
		$("#add_frnd_form").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
	}
	return false;
}
function add_another_field()
{
	var count=parseInt($('#count_frnd').val());
	count+=1;
	$('#count_frnd').val(count);
	$('#proposed_friend').prepend('<div id="div_'+count+'" class="add_another"><input type="hidden" name="data[puser]['+count+'][fb_id]"/><input type="text" name="data[puser]['+count+'][frnd_name]" class="validate[required]" placeholder="Enter Friend Name"/><input type="text" name="data[puser]['+count+'][frnd_email]" class="validate[required,custom[email]]" placeholder="Enter Friend Email"/><input type="text" name="data[puser]['+count+'][frnd_phone]" class="validate[required]" placeholder="Enter Friend Phone"/><a href="javascript://" onclick="remove(\''+count+'\');"><img alt="close" src="/img/close.png"></a></div>');
	if(count>3){
	$(".multi_frnds").addClass('height');
			}
	$(".nano").nanoScroller({alwaysVisible:true, contentClass:'multi_frnds',sliderMaxHeight: 70 });
}
function remove(num)
{
	$('#div_'+num).remove();
	var count=parseInt($('#count_frnd').val());
	count-=1;
	$('#count_frnd').val(count);
	if(count<3){
	$(".multi_frnds").removeClass('height');
			}
	$(".nano").nanoScroller({alwaysVisible:true, contentClass:'multi_frnds',sliderMaxHeight: 70 });
}
</script>