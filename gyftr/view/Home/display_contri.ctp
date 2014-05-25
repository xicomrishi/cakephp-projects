<div class="select_dele"><?php if($contri_type==1) echo '/ / Equal <strong>Contribution</strong>'; else if($contri_type==2) echo '/ / Participants <strong>Decide</strong>'; else echo '/ / I will <strong>Decide</strong>'; ?></div>
<form id="contriForm" name="contriForm" action="" method="post" onsubmit="return confirm_contri();">
<input type="hidden" id="total_valid" value="<?php echo $data['total_amount']; ?>"/>
<div id="infoMsg">Total contribution amount exceeds total gift cost!</div>
<?php if($contri_type==1){ ?>

<input type="hidden" id="selected_contri" name="contri" value="<?php echo ($data['contri']+10); ?>"/>

<div class="con_row orenge">The gift you want to give to <?php echo $data['to_name']; ?> is costing INR <?php echo $data['total_amount']; ?> and if we just use simple maths it works out to INR <?php echo $data['contri']; ?> per head.</div>
<div class="con_row">But if you really want to make this happen we recommend a contribution of INR <?php echo ($data['contri']+10); ?> to make provision for non-contributers.</div> 

<div class="con_row center">
<div class="action">
            
            <a href="javascript://" id="contri_1" class="yes contri_exp_dec" onclick="select_contri('<?php echo $data['contri']; ?>','1')">Select <?php echo $data['contri']; ?></a>
                <a href="javascript://" id="contri_2" class="no active contri_exp_dec" onclick="select_contri('<?php echo $data['contri']+10; ?>','2')">Select <?php echo $data['contri']+10; ?></a>
            </div>
            </div>
<?php }else if($contri_type==2){ ?>


<div class="con_row orenge">Well each person would get to know what is overall amount of gift. </div>
<label>Input amount you want to contribute: </label><input type="text" id="selected_contri" class="contri" name="contri" value="<?php echo ($data['contri']+10); ?>"/>

<?php }else{ ?>


<div class="con_row orenge">I would play God and decide who pays how much</div>
<div class="con_row">We suggest a higher amount so that you can provision for a few non-contributers.</div>
<div class="comn_box Contributors">
            
                        
            <div class="detail_row last">
            <div class="Contri_deatil">
            
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr class="head_row">
            <td class="col" style="font-size:16px; width:46.8%"><strong>People who are participating in the Gift</strong></td>
            <td class="col last" style="font-size:16px; width:46.8%"><strong>Contribution</strong></td>
            </tr>
            <?php $i=0; 
			foreach($data['friends']['group_gift']['friends'] as $fnd){ ?>
            <tr class="comn_row">
            <td class="col" style="width:46.8%"><?php echo $fnd['name']; ?></td>
            <td class="col last" style="width:46.8%"><input style="width:70%" type="text" class="validate[required] contri" name="data[<?php echo $i; ?>][contri]"/></td>
            </tr>
            <?php $i++; } ?>
            </table>
            
            </div>
            </div>
            </div>


<?php } ?>
<input type="submit" class="submit" value="Confirm Contribution" onclick="return confirm_contri('<?php echo $contri_type?>')"/>
</form>

<script type="text/javascript">
$(document).ready(function(e) {
     $("#contriForm").validationEngine({promptPosition: "topLeft"});
});
function confirm_contri(typ)
{
	var valid = $("#contriForm").validationEngine('validate');
	if(valid)
	{
		var tot_allowed=$('#total_valid').val();
		var flag=check_valid_contri(typ,tot_allowed);
		if(flag==1)
		{
			$.post(site_url+'/home/confirm_contri/'+typ,$("#contriForm").serialize(),function(data){
				$('#banner').html(data);
				$.fancybox.close();	
			});
		}else{
			$('#infoMsg').show();	
		}
	}else{
		 $("#contriForm").validationEngine({scroll:false});
		 shakeField();
	}
	return false;
} 
function select_contri(value,num)
{
	$('#selected_contri').val(value);
	$('.contri_exp_dec').removeClass('active');	
	$('#contri_'+num).addClass('active');
	
}


</script>