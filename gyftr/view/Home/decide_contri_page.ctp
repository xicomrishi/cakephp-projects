
<div class="breadcrumb">
			<ul>
				<li class="first"><a href="<?php echo SITE_URL; ?>">Home</a></li>
				<li><a href="javascript://" onclick="return nextStep('step-2','start');">Select Gift Type</a></li>
                  <?php if($this->Session->read('Gifting.type')!='me_to_me'){ ?>
				<li><a href="javascript://" onclick="return nextStep('one_to_one','group_gift');">Recipient</a></li>
				<?php } ?>
				<li><a href="javascript://" onclick="return nextStep('step-3','<?php $sess=$this->Session->read('Gifting.type'); if($sess=='me_to_me') echo 'meTome'; else echo $sess; ?>');">Select Gift</a></li> 
                <li><a href="javascript://" onclick="return select_product('0');">Basket</a></li>                
                <li><a href="javascript://" onclick="voucherStep('get_delivery');">Delivery</a></li>
                <li><a href="javascript://" onclick="voucherStep('get_chip_in_page');">Contributors</a></li>
                <li class="last">Contribution</li>
              </ul>
</div>
<div id="form_section"  class="none1" style="min-height:380px;">
<form id="decideContriForm" name="decideContriForm" action="" onsubmit="return submit_contriForm();">
<div class="select_dele">/ / Chipin<strong>  Contribution</strong>
    <div class="select_box">
    <a href="javascript://"><span><?php if($this->Session->check('Gifting.group_gift.contri_type')){ if($this->Session->read('Gifting.group_gift.contri_type')=='0') echo 'Equal Contribution'; else if($this->Session->read('Gifting.group_gift.contri_type')=='1') echo 'Participant Decide'; else if($this->Session->read('Gifting.group_gift.contri_type')=='3') echo 'I Decide';  }else{  ?>Select Contribution<?php } ?></span></a>
        <ul class="drop_down">
            <li><a href="javascript://" onclick="change_contri_distribution(0);">Equal Contribution</a></li>
            <li><a href="javascript://" onclick="change_contri_distribution(1);">Participant Decide</a></li>
            <li><a href="javascript://" onclick="change_contri_distribution(3);">I Decide</a></li>
        </ul>
    </div>
</div>

<input type="hidden" id="total_basket_value" value="<?php echo $total; ?>"/>
<input type="hidden" id="count_friends" value="<?php echo $count; ?>"/>
<input type="hidden" id="equal_contri" name="equal_contri" value="<?php echo $equal; ?>"/>
<input type="hidden" id="contri_type" name="contri_type" class="check1" value="<?php if($this->Session->check('Gifting.group_gift.contri_type')){ echo $this->Session->read('Gifting.group_gift.contri_type');  }else echo '0'; ?>"/>
            
          
<div class="chip_detail" style="padding:0px; width:100%">
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="detail">
<?php 
$i=0;
foreach($friends as $fr){ 
if($this->Session->check('User')&&(!empty($fr['fb_id']))&&($fr['fb_id']==$this->Session->read('User.User.fb_id')||$fr['email']==$this->Session->read('User.User.email'))){ 
?>

<tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>">

<td align="left">
<?php if($this->Session->check('User')){ $us=$this->Session->read('User'); if(!empty($us['User']['thumb'])) { ?><img src="<?php echo SITE_URL; ?>/files/ProfileImage/<?php echo $us['User']['id']?>/mini_thumb_<?php echo $us['User']['thumb']?>" alt="" height="28" width="28"/><?php }else if(!empty($us['User']['thumb'])){ ?><img src="https://graph.facebook.com/<?php echo $us['User']['id']?>/picture" alt="" height="28" width="28"/><?php }}else{ ?>
<img src="<?php echo $this->webroot; ?>img/facebook_profile_pic.jpg"alt="" height="28" width="28"/> 
<?php } ?>
<?php echo $fr['name']; ?>

</td>


<td align="left">&nbsp;</td>

<td  class="contri_distribution last" style="color:#fff; <?php if($this->Session->check('Gifting.group_gift.contri_type')){ if(trim($this->Session->read('Gifting.group_gift.contri_type'))=='3') echo 'display:none;'; } ?>"><?php if(isset($fr['contri_exp'])) echo $fr['contri_exp']; else echo $equal; ?></td>

<td class="i_decide last" <?php if($this->Session->check('Gifting.group_gift.contri_type')){ if($this->Session->read('Gifting.group_gift.contri_type')!='3') echo 'style="display:none;"'; }else{ ?> style="display:none" <?php } ?>><input type="text" name="<?php echo 'fr_'.$i; ?>" class="every_contri validate[required,custom[integer],min[1]]" value="<?php if(isset($fr['contri_exp'])) echo $fr['contri_exp']; ?>" /></td>
</tr>
<?php }else{ ?>
<tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>">

<td align="left">

<?php if(!empty($fr['fb_id'])){ ?><img src="https://graph.facebook.com/<?php echo $fr['fb_id']?>/picture" alt="" height="28" width="28"/><?php }else{ ?><img src="<?php echo $this->webroot; ?>img/facebook_profile_pic.jpg"alt="" height="28" width="28"/> <?php } ?>

<?php echo  $fr['name']; ?>
</td>

<td align="left" class="orenge"><?php if(!empty($fr['fb_id'])) echo $this->Html->image('button_fb-ba350fcd03ce7c663a47ee06d981162e.png',array('escape'=>false)).' VIA Facebook Private Message '; else echo $fr['email']; ?></td>

<td  class="contri_distribution last" style="color:#fff; <?php if($this->Session->check('Gifting.group_gift.contri_type')){ if(trim($this->Session->read('Gifting.group_gift.contri_type'))=='3') echo 'display:none;'; } ?>"><?php if(isset($fr['contri_exp'])) echo $fr['contri_exp']; else echo $equal; ?></td>

<td class="i_decide last" <?php if($this->Session->check('Gifting.group_gift.contri_type')){ if($this->Session->read('Gifting.group_gift.contri_type')!='3') echo 'style="display:none;"'; }else{ ?> style="display:none" <?php } ?>><input type="text" name="<?php echo 'fr_'.$i; ?>" class="every_contri validate[required,custom[integer],min[1]]" value="<?php if(isset($fr['contri_exp'])) echo $fr['contri_exp']; ?>"/></td>
</tr>
<?php } $i++; } ?>

<!--<tr><td colspan="2" align="right" style="background:#FA9D4C"><strong>Total Gift Value</strong></td> <td align="left" style="background:#F87400; "><?php echo $total; ?></td><td class="last" style="display:none">&nbsp;</td></tr>-->
</table>
<!--<input type="submit" value="Next" class="done" style="float:right !important; width:11% !important"/>-->
</form>
</div>


	
         
</div>

<div class="action">
            
            <a href="javascript://"  class="yes" onclick="return submit_contriForm();">Next</a>
            <a href="javascript://"  class="no" onclick="voucherStep('get_chip_in_page');">Previous</a>
</div>

   <div id="infoMsg" style="display:none;" class="category"></div>

<script type="text/javascript">
$(document).ready(function(e) {
     $("#decideContriForm").validationEngine({scroll:false,focusFirstField : false});
});
function change_contri_distribution(type)
{
	var tot=$('#total_basket_value').val();
	var num=$('#count_friends').val();
	$('#contri_type').val(type);
	if(type==0)
	{
		var equal=$('#equal_contri').val();
		$('.contri_distribution').html(equal);
		$('.contri_distribution').show();
		$('.equal_contri_band').show();
		$('.i_decide').hide();	
	}else if(type==1){
		$('.contri_distribution').html('-');
		$('.contri_distribution').show();
		$('.equal_contri_band').hide();
		$('.i_decide').hide();
		
	}else{
		$('.contri_distribution').hide();
		$('.equal_contri_band').hide();
		$('.i_decide').show();
	}	
}

function submit_contriForm()
{
	var valid = $("#decideContriForm").validationEngine('validate');
	
	if(valid)
	{
		var total_val=0;
		var req_total=$('#total_basket_value').val();
		
		$('.every_contri').each(function(index, element) {
       
            total_val+=parseInt($(this).val());
        });
		
		if(total_val<req_total)
		{
			display_error('0');
	
		}else{
		$.post(site_url+'/home/confirm_contri',$("#decideContriForm").serialize(),function(data){
				$('#banner').html(data);
			});
		}
		return false;
	}else{
		 $("#decideContriForm").validationEngine({scroll:false,focusFirstField : false});
		 shakeField();
	}
	return false;	
}

function display_error(typ)
{
	var msg='';
	if(typ==0)
	{
		msg="Amount entered less than total gift value of <?php echo $total; ?>";		
	}else{
		msg="Amount entered greater than required total amount";
	}
	$('#infoMsg').html('<img src="/img/validate_left_img.png" alt="" /><div class="text">'+msg+'</div><img src="/img/validate_right_img.png" alt="" />');
	$('#infoMsg').show("slide",{direction: "down"},100);
	//$('#infoMsg').show('slow');
	setTimeout(function(){ $('#infoMsg').hide("slide",{direction: "down"},100);},3000);		
}

function select_contri(value,num)
{
	//var total=$('#count_friends').val();
	$('#equal_contri').val(value);
	$('.contri_distribution').html(value);
	$('.contri_exp_dec').removeClass('active');	
	$('#contri_'+num).addClass('active');
	
}
</script>