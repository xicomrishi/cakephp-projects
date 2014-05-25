<?php echo $this->Html->css('jquery.ui.autocomplete');?>

<div id="form_section"  style="margin:0 0 5px 0; padding:0;  width:99.3%">
<div class="select_dele">/ / Add <strong>Contributors</strong></div>
<?php if($flag==1){ ?>
<div id="flashmsg" style="display:none; color:#FF0033;">Friend added already.</div>
<h3>Who all are chipping in?</h3>

<form id="chipinForm" name="chipinForm" method="post" action="" onsubmit="return submit_addmember_form();">
<input type="hidden" id="count_fnd" value="0"/>
<input type="hidden" id="fb_frnds_done" value="0"/>
<input type="hidden" id="google_click" value="0"/>
<div class="nano" style="width:100%">
<div class="multi_frnds">
<div style="float:left; width:100%; padding:0 0 8px 0">
<div class="user_pic"><?php echo $this->Html->image('facebook_profile_pic.jpg',array('escape'=>false)); ?></div>
<div class="user_name"><input type="text" id="frnd_name_0" name="frnd[0][name]" class="frnd_name validate[required]" placeholder="Enter Name" onclick="show_fb_connect(0);"/>
<div class="instruction_box" id="inst_0" style="display:none; position:absolute; padding:0 3%;">
<h3 style="font-size:11px !important; line-height:14px !important; padding:0px !important">Enter your friend's name manually</h3>
<div class="separator">
<span class="overlay"> or </span>
<hr>
</div>
<a href="javascript://" onclick="get_fb_friends(0);" class="small"><?php echo $this->Html->image('facebook_login.png',array('escape'=>false,'alt'=>'','div'=>false)); ?></a>
<a href="javascript://" id="g_0" class="get_google small"><?php echo $this->Html->image('gmail_login.png',array('escape'=>false,'alt'=>'','div'=>false)); ?></a>
</div>

<div class="scroll" style="width:100%">
<div id="fbdisplay_0" class="fb_disp" style="display:none; height:87px; width:184px; left:0px; overflow:auto; background:#f4f4f4; position:absolute; padding:0 17px 0 0; z-index:9999">
</div>
</div>
</div>

<div id="frnd_email_div_0" class="user_mail"><input type="text" id="frnd_email_0" name="frnd[0][email]" class="validate[required,custom[email]]" placeholder="Enter Email" onclick="hide_fb_connect();"/></div>

</div>


</div>
</div>

<div class="inp_frnds"></div>
<div id="add_0" class="add" style="float:left;"><a href="javascript://" onclick="add_more_frnd();"><?php echo $this->Html->image('add-friend.png',array('escape'=>false,'alt'=>'','div'=>false)); ?></a></div>
<input style="float:right !important; margin:0 42px 0 0 !important" type="submit" id="chip_submit" value="done" class="done" />
</form>
<?php }else{ ?>
<div>Sorry! This gift has been closed.</div>
<?php } ?>
</div>
<script type="text/javascript">
var fr_data='';
var this_num=0;
var clientId = '<?php echo Google_ID; ?>';
var apiKey = '<?php echo Google_KEY;?>';
var scopes = 'https://www.google.com/m8/feeds';
$(document).ready(function(e) {
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
	  
	  handleChipClientLoad();	
     $("#chipinForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	 $(".nano").nanoScroller({alwaysVisible:true, contentClass:'multi_frnds',sliderMaxHeight: 70 });
	 $(".scroll").nanoScroller({alwaysVisible:true, contentClass:'fb_disp',sliderMaxHeight: 70 });
	
 	input_blur_function();
	
});

function submit_addmember_form()
{
	var valid = $("#chipinForm").validationEngine('validate');
	if(valid)
	{	var frm=$('#chipinForm').serialize();
		showLoading('#banner');
		$('#chip_submit').hide();
		$.post('<?php echo SITE_URL; ?>/home/addto_contri_member/<?php echo $ordid; ?>',frm,function(data){
			
			$.fancybox.close();
			$('#banner').html(data);
			});
	}else{
		 $("#chipinForm").validationEngine({scroll:false,focusFirstField : false});
		 shakeField();	
	}
	return false;
}
function show_fb_connect(num)
{
	var fb_al=$('#fb_frnds_done').val();
	
	if(fb_al=='1')
	{
		$('.instruction_box').html('<h3 style="font-size:11px !important; line-height:14px!important; padding:0px!important ">Start typing friends name</h3><a href="javascript://"  id="g_'+num+'" class="get_google small"><img src="/img/gmail_login.png"></a>');	
		autocomplete_func(fr_data,num,'1');
		initiate_onclick('.get_google',1);
	}else if(fb_al=='3'){
		$('.instruction_box').html('<h3 style="font-size:11px !important; line-height:14px!important; padding:0px!important">Start typing friends name</h3><a onclick="get_fb_friends('+num+');" href="javascript://" class="small"><img src="/img/facebook_login.png"></a>');	
		autocomplete_func(fr_data,num,'2');
		}
	$('.instruction_box').hide();
	setTimeout(function(){ $('#inst_'+num).slideDown(200);},100);
	
}
   
</script>