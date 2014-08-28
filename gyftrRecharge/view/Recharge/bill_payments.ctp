<style>
.note_div{ font-weight:bold;}
.small_note{color: #737373;font-family: 'robotolight'; font-size:11px;}
.redemption{ display:none;}
</style>
<ul class="tabing">
                	<li class="li_num_4" onclick="toggle_recharge_type('4');"><label class="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='4') echo 'active'; }else{ echo 'active'; }?>"><span>Mobile</span></label></li>
                    <li class="li_num_5" onclick="toggle_recharge_type('5');"><label class="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='5') echo 'active'; }?>"><span>Electricity</span></label></li>
                    <li class="li_num_6" onclick="toggle_recharge_type('6');"><label class="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='6') echo 'active'; }?>"><span>Landline</span></label></li>
                    <li class="li_num_7" onclick="toggle_recharge_type('7');"><label class="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='7') echo 'active'; }?>"><span>Gas</span></label></li>
                    <li class="li_num_8" onclick="toggle_recharge_type('8');"><label class="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='8') echo 'active'; }?>"><span>Insurance</span></label></li>
                    
                </ul>
                <div class="tab_details">
                	<div class="detail_section">
                    	<div class="common_steps">
                        	<form id="mobRechargeForm" name="mobRechargeForm" method="post" action="<?php echo $this->webroot; ?>recharge/proceed_to_recharge" onsubmit="return proceed_to_recharge();">
                            	<fieldset>
                                	<input id="recharge_type" type="hidden" name="data[Recharge][recharge_type]" value="<?php if(isset($setdata)) echo $setdata['Recharge']['recharge_type']; else echo '4';  ?>"/>
                                    <input id="redeemed_code" type="hidden" name="data[Recharge][voucher_code]" value=""/>
                                    <div class="error_div error_div_1" style="display:none;">Please enter voucher code</div>
                                	<div class="common_row tabTypes tab_type_4" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='4') echo 'style="display:none;"';} ?>>
                                        <label>Recharge my postpaid mobile no.</label>
                                        <span class="inn">+91</span><input type="text" id="mobile_num" class="mobile_num validate[required,custom[integer],minSize[10],maxSize[10]]]" name="data[Recharge][mobile_num]" maxlength="10" min="0" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='4') echo $setdata['Recharge']['number']; } ?>">
                                    </div>
                                    <div class="common_row tabTypes tab_type_4" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='4'){ echo 'style="display:none;"';}} ?>>
                                    <label>Mobile Operator</label>
                                    <select name="data[Recharge][mob_operator]" class="validate[required]" onchange="check_circle(this.value);">
                                    	<?php if(!isset($setdata)){ ?>
                                        <option value="">Select Your Operator</option>
                                        <?php } ?>
                                        <?php foreach($operator as $ops){ if($ops['Operator']['type']=='4'){ ?>
                                        	<option value="<?php echo $ops['Operator']['id']; ?>" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='4'){ if($setdata['Recharge']['operator_id']==$ops['Operator']['id']) echo 'selected'; }}?>><?php echo $ops['Operator']['name']; ?></option>
                                        <?php }} ?>
                                    </select></div>
                                    
                                    <div class="common_row tabTypes tab_type_4" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='4'){ echo 'style="display:none;"';}} ?>>
                                    <label>Circle</label>
                                    <select name="data[Recharge][circle_id]" class="circle_select validate[required]">
                                    	<?php if(!isset($setdata)){ ?>
                                        <option value="">Select Your Circle</option>
                                        <?php } ?>
                                       	<?php foreach($circles as $cr){ ?>
                                        	<option value="<?php echo $cr['Circle']['id']; ?>" <?php if(in_array($cr['Circle']['id'],$rel_circles)) echo 'class="not_rel_op"';?> <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='4'){ if($setdata['Recharge']['circle_id']==$cr['Circle']['id']) echo 'selected'; }}?>><?php echo $cr['Circle']['circle']; ?></option>
                                        <?php } ?>
                                    </select></div>
                                    
                                    
                                    <div class="common_row tabTypes tab_type_5" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='5'){ echo 'style="display:none;"';}}else{ echo 'style="display:none;"';} ?>>
                                    <label>Electricity Provider</label>
                                    <select name="data[Recharge][electricity_provider]" class="validate[required]" onchange="check_el_provider(this.value);">
                                    	<?php if(!isset($setdata)){ ?>
                                        <option value="">Select Your Electricity Provider</option>
                                        <?php } ?>
                                       	<?php foreach($operator as $ops){ if($ops['Operator']['type']=='5'){ ?>
                                        	<option value="<?php echo $ops['Operator']['id']; ?>" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='5'){ if($setdata['Recharge']['operator_id']==$ops['Operator']['id']) echo 'selected'; }}?>><?php echo $ops['Operator']['name']; ?></option>
                                        <?php }} ?>
                                    </select></div>
                                    
                                   <div class="common_row tabTypes tab_type_5 tab_type_5_1" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='5') echo 'style="display:none;"'; else if($setdata['Recharge']['operator_id']!='45') echo 'style="display:none;"';}else{ echo 'style="display:none;"';} ?>>
                                        <label>Customer No.</label>
                                        <input type="text" class="input validate[required,custom[integer],minSize[9],maxSize[9]]]" name="data[Recharge][customer_num]" maxlength="9" min="0" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='5') echo $setdata['Recharge']['number']; } ?>">
                                    </div>
                                    
                                    <div class="common_row tabTypes tab_type_5  tab_type_5_1" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='5') echo 'style="display:none;"'; else if($setdata['Recharge']['operator_id']!='45') echo 'style="display:none;"';}else{ echo 'style="display:none;"';} ?>>
                                        <label>Cycle No.</label>
                                        <input type="text" class="input validate[required,custom[integer],minSize[2],maxSize[2]]]" name="data[Recharge][cycle_number]" maxlength="2" min="0" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='5') echo $setdata['Recharge']['cycle_number']; } ?>">
                                    </div>
                                    
                                    <div class="common_row tabTypes tab_type_5_2" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='5') echo 'style="display:none;"'; else if($setdata['Recharge']['operator_id']!='46' && $setdata['Recharge']['operator_id']!='47') echo 'style="display:none;"'; }else{ echo 'style="display:none;"'; } ?>>
                                        <label>Customer Account No.</label>
                                        <input type="text" class="input validate[required,custom[integer],minSize[9],maxSize[10]]]" name="data[Recharge][customer_acc_num]" maxlength="10" min="0" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='5') echo $setdata['Recharge']['number']; } ?>">
                                    </div>
                                    
                                    <div class="common_row tabTypes tab_type_5_3" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='5') echo 'style="display:none;"'; else if($setdata['Recharge']['operator_id']!='48') echo 'style="display:none;"';}else{ echo 'style="display:none;"'; } ?>>
                                        <label>Customer Account No.</label>
                                        <input type="text" class="input validate[required,custom[integer],minSize[11],maxSize[12]]]" name="data[Recharge][customer_ndpl_num]" maxlength="12" min="0" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='5') echo $setdata['Recharge']['number']; } ?>">
                                    </div>
                                    
                                    <div class="common_row tabTypes tab_type_6" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='6') echo 'style="display:none;"'; }else{ echo 'style="display:none;"';} ?>>
                                        <label>Landline Phone Number</label>
                                        <input type="text" class="input validate[required,minSize[3],maxSize[5]]]" name="data[Recharge][std_code]" maxlength="5" min="3" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='6') echo $setdata['Recharge']['std_code']; } ?>" style="float:left; width:87px;" placeholder="STD Code"/>
                                        <input type="text" class="input validate[required,custom[integer],minSize[8],maxSize[8]]]" name="data[Recharge][landline_num]" maxlength="8" min="0" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='6') echo $setdata['Recharge']['number']; } ?>" style="margin-left: 14px;width: 364px;">
                                    </div>
                                    
                                    <div class="common_row tabTypes tab_type_6" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='6'){ echo 'style="display:none;"';}}else{ echo 'style="display:none;"';} ?>>
                                    <label>Operator</label>
                                    <select name="data[Recharge][landline_operator]" class="validate[required]" onchange="check_ldl_provider(this.value);">
                                    	<?php if(!isset($setdata)){ ?>
                                        <option value="">Select Your Operator</option>
                                        <?php } ?>
                                       	<?php foreach($operator as $ops){ if($ops['Operator']['type']=='6'){ ?>
                                        	<option value="<?php echo $ops['Operator']['id']; ?>" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='6'){ if($setdata['Recharge']['operator_id']==$ops['Operator']['id']) echo 'selected'; }}?>><?php echo $ops['Operator']['name']; ?></option>
                                        <?php }} ?>
                                    </select></div>
                                    
                                    <div class="common_row tabTypes tab_type_6_1" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='6') echo 'style="display:none;"'; else if($setdata['Recharge']['operator_id']!='50') echo 'style="display:none;"';}else{ echo 'style="display:none;"'; } ?>>
                                        <label>Customer Account No.</label>
                                        <input type="text" class="input validate[required,custom[integer],minSize[10],maxSize[10]]]" name="data[Recharge][customer_acc_number]" maxlength="10" min="0" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='6') echo $setdata['Recharge']['customer_acc_number']; } ?>">
                                    </div>
                                    
                                    
                                    <div class="common_row tabTypes tab_type_7" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='7'){ echo 'style="display:none;"';}}else{ echo 'style="display:none;"';} ?>>
                                    <label>Gas Provider</label>
                                    <select name="data[Recharge][gas_provider]" class="validate[required]">
                                    	<?php if(!isset($setdata)){ ?>
                                        <option value="">Select Your Gas Provider</option>
                                        <?php } ?>
                                       	<?php foreach($operator as $ops){ if($ops['Operator']['type']=='7'){ ?>
                                        	<option value="<?php echo $ops['Operator']['id']; ?>" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='7'){ if($setdata['Recharge']['operator_id']==$ops['Operator']['id']) echo 'selected'; }}?>><?php echo $ops['Operator']['name']; ?></option>
                                        <?php }} ?>
                                    </select></div>
                                    
                                    <div class="common_row tabTypes tab_type_7" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='7') echo 'style="display:none;"'; }else{ echo 'style="display:none;"'; } ?>>
                                        <label>Consumer Account No.</label>
                                        <input type="text" class="input validate[required,custom[integer],minSize[12],maxSize[12]]]" name="data[Recharge][gas_num]" maxlength="12" min="0" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='7') echo $setdata['Recharge']['number']; } ?>">
                                    </div>
                                    
                                    <div class="common_row tabTypes tab_type_8" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='8'){ echo 'style="display:none;"';}}else{ echo 'style="display:none;"';} ?>>
                                    <label>Policy Provider</label>
                                    <select name="data[Recharge][policy_provider]" class="validate[required]">
                                    	<?php if(!isset($setdata)){ ?>
                                        <option value="">Select Your Policy Provider</option>
                                        <?php } ?>
                                       	<?php foreach($operator as $ops){ if($ops['Operator']['type']=='8'){ ?>
                                        	<option value="<?php echo $ops['Operator']['id']; ?>" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='8'){ if($setdata['Recharge']['operator_id']==$ops['Operator']['id']) echo 'selected'; }}?>><?php echo $ops['Operator']['name']; ?></option>
                                        <?php }} ?>
                                    </select></div>
                                    
                                    <div class="common_row tabTypes tab_type_8" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='8') echo 'style="display:none;"'; }else{ echo 'style="display:none;"'; } ?>>
                                        <label>Policy Number</label>
                                        <input type="text" class="input validate[required,custom[integer],minSize[8],maxSize[10]]]" name="data[Recharge][policy_number]" maxlength="10" min="0" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='8') echo $setdata['Recharge']['number']; } ?>">
                                    </div>
                                    
                                    <div class="common_row tabTypes tab_type_8" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='8') echo 'style="display:none;"'; }else{ echo 'style="display:none;"'; } ?>>
                                        <label>Date of Birth</label>
                                        <input type="text" id="date_of_birth" class="input validate[required]" name="data[Recharge][date_of_birth]" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='8') echo $setdata['Recharge']['date_of_birth']; } ?>">
                                    </div>
                                    
                                    
                                    
                                    <div class="common_row check" <?php if(isset($setdata)){  echo 'style="display:none;"'; } ?>>
                                    <label class="check active"><input type="hidden" id="is_voucher" name="data[Recharge][is_voucher]"><span>I have a gift voucher</span></label></div>
                                    <div class="error_div error_div_2" style="display:none;">Invalid voucher code. Please try again.</div>
                                    <div class="common_row redeem_div"><label>Enter your Voucher Code</label>
                                    <input id="voucher_code_val" class="middle" type="text" name="data[Recharge][voucher_code_val]" autocomplete="off"><a class="btn" href="javascript://" onclick="redeem_voucher();">Redeem</a></div>
                                    
                                    <div class="common_row redemption"><label>Usable value of Gift Code available for recharge</label>
                                    <span class="inn"><?php echo $this->html->image('rupee_img.png',array('escape'=>false,'div'=>false,'alt'=>'rupee'));?></span><input id="amount" type="text" readonly="readonly" name="data[Recharge][amount]" value="0" autocomplete="off"><div class="small_note">Usable value = Gift code face value  minus handling  charges</div></div>
                                    
                                    <div class="error_div error_div_3" style="display:none;"></div>
                                    <div class="common_row redemption"><label>Enter Allowed recharge value</label>
                                    <span class="inn"><?php echo $this->html->image('rupee_img.png',array('escape'=>false,'div'=>false,'alt'=>'rupee'));?></span><input id="recharge_value" type="text" name="data[Recharge][recharge_value]" value="0" onblur="validate_recharge_value(this.value);"><div class="small_note">Allowed recharge amount varies for different operators  you need to put in the exact amount for the recharge to successful.</div></div>
                                    
                                    <div class="common_row note_div">
                                    		<p>Please NOTE the following:</p>
                                        	<ul class="note_list">
                                            	
                                        		<li>Voucher Code once used cannot be reused</li>
                                                <li>Usable value  of Gift Code available for recharge is calculated basis the value of the gift code minus the  handling charges</li>
                                                <li>Check exact details with your operator for the tariff applicable and accordingly fill in the Allowed recharge value. If a value mismatch is their the recharge would not happen</li>
                                                <li>Only one recharge is allowed for one number in one hour</li>
                                                <li>Once a recharge is successful its not possible to reverse it.</li>
                                                </ul>
                                              
									</div>
                                    
                                    <div class="common_row redemption"><input type="submit" value="Proceed to recharge"></div>
                                </fieldset>
                            </form>
                        </div>
                      
                    </div>
                </div>
                
                 <div class="coming_soon_div" style="display:none; margin-top:99px;">
					<?php echo $this->Html->image('coming_soon.png',array('escape'=>false,'alt'=>'coming soon','div'=>false)); ?>
                    </div>
                
<script type="text/javascript">
$(document).ready(function(e) {
    $('.mobile_num').keyup(function () {     
	  this.value = this.value.replace(/[^0-9\.]/g,'');
	});
	$("#mobRechargeForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	var to_day=new Date();
    $("#date_of_birth").datepicker({dateFormat:"dd-mm-yy"});
});

function validate_recharge_value(val)
{
	var avail=$('#amount').val();
	if(avail!='' && avail!='undefined' && avail!='0')
	{
		val=parseInt(val.replace(/[^0-9\.]/g,''));
		if(val=='' || isNaN(val) || val=='undefined' || val>parseInt(avail))
		{
			$('.error_div_3').html('Maximum recharge amount available is INR '+avail);
			$('.error_div_3').show();
			$('.error_div_3').delay(4000).fadeOut('slow');			
		}
	}else if(avail=='0'){
		$('.error_div_3').html('Please redeem voucher to get available recharge amount.');
		$('.error_div_3').show();
		$('.error_div_3').delay(4000).fadeOut('slow');	
	}else{
		$('.error_div_3').html('Please enter valid recharge value');
		$('.error_div_3').show();
		$('.error_div_3').delay(4000).fadeOut('slow');		
	}	
	
}

function check_circle(val)
{
	$('.circle_select option[value=""]').attr('selected','selected');
	if(val=='43')
	{	$('.not_rel_op').hide(); $('.not_rel_op').attr('disabled','disabled'); }
	else
	{	$('.not_rel_op').show(); $('.not_rel_op').removeAttr('disabled');	}
}
function check_el_provider(val)
{
	if(val=='45')
	{	$('.tab_type_5_1').show();
		$('.tab_type_5_2').hide();
		$('.tab_type_5_3').hide();
	}
	else if(val=='46'||val=='47')
	{	$('.tab_type_5_2').show();
		$('.tab_type_5_1').hide();
		$('.tab_type_5_3').hide();
	}
	else if(val=='48')
	{	$('.tab_type_5_3').show();
		$('.tab_type_5_2').hide();
		$('.tab_type_5_1').hide();	
	}	
}

function check_ldl_provider(val)
{
	if(val=='50')
		$('.tab_type_6_1').show();
	else
		$('.tab_type_6_1').hide();		
}
</script>                
            