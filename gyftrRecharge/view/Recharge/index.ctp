<style>
.coming_soon_div{margin-top: 65px;text-align: center;}
.note_list{ margin-left:17px;}
.note_list li{ list-style:decimal; font-size:12px; color: #737373;font-family: 'robotolight';  }
.note_div p{color: #737373;font-family: 'robotolight'; font-size:13px;}
.note_div{ font-weight:bold;}
.small_note{color: #737373;font-family: 'robotolight'; font-size:11px;}
.redemption{ display:none;}
</style>
<div class="recharge_section">
        	<ul class="main">
            	<li class="active"><a href="javascript://" onclick="show_this_tab(0);">Recharges</a></li>
                <li><a href="javascript://" onclick="show_this_tab(1);">Bill Payments</a></li>
                <li><a href="javascript://" onclick="show_this_tab(2);">Bus Tickets</a></li>
            </ul>
            <div class="inner_tabing" style="display:block">
            	<ul class="tabing">
                	<li class="li_num_1" onclick="toggle_recharge_type('1');"><label class="active"><span>Mobile</span></label></li>
                    <li class="li_num_2" onclick="toggle_recharge_type('2');"><label><span>DTH</span></label></li>
                    <li class="li_num_3" onclick="toggle_recharge_type('3');"><label><span>Data Card</span></label></li>
                    
                </ul>
                <div class="tab_details">
                	<div class="detail_section">
                    	<div class="common_steps">
                        	<form id="mobRechargeForm" name="mobRechargeForm" method="post" action="<?php echo $this->webroot; ?>recharge/proceed_to_recharge" onsubmit="return proceed_to_recharge();">
                            	<fieldset>
                                	<input id="recharge_type" type="hidden" name="data[Recharge][recharge_type]" value="1"/>
                                    
                                   
                                    <input id="redeemed_code" type="hidden" name="data[Recharge][voucher_code]" value="<?php //echo substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8); ?>"/>
                                    <div class="error_div error_div_1" style="display:none;">Please enter voucher code</div>
                                	<div class="common_row tabTypes tab_type_1">
                                        <label>Recharge my prepaid mobile no.</label>
                                        <span class="inn">+91</span><input type="text" id="mobile_num" class="mobile_num validate[required,custom[integer],minSize[10],maxSize[10]]]" name="data[Recharge][mobile_num]" maxlength="10" min="0">
                                    </div>
                                    <div class="common_row tabTypes tab_type_1"><label>Mobile Operator</label>
                                    <select id="mob_operator" name="data[Recharge][mob_operator]" class="validate[required]">
                                    	<option value="">Select Your Operator</option>
                                        <?php foreach($operator as $ops){ if($ops['Operator']['type']=='1'){ ?>
                                        	<option value="<?php echo $ops['Operator']['id']; ?>"><?php echo $ops['Operator']['name']; ?></option>
                                        <?php }} ?>
                                    </select></div>
                                    
                                     <div class="common_row tabTypes tab_type_1"><label>Circle</label>
                                    <select id="mob_circles" name="data[Recharge][circle_id]" class="validate[required]">
                                    	<option value="">Select Your Circle</option>
                                        <?php foreach($circles as $cr){ ?>
                                        	<option value="<?php echo $cr['Circle']['id']; ?>"><?php echo $cr['Circle']['circle']; ?></option>
                                        <?php } ?>
                                    </select></div>
                                    
                                    <div class="common_row tabTypes tab_type_2" style="display:none">
                                        <label>Enter your Customer ID</label>
                                        <input type="text" id="customer_id" class="input validate[required]" name="data[Recharge][customer_id]">
                                    </div>
                                    <div class="common_row tabTypes tab_type_2" style="display:none"><label>DTH Provider</label>
                                    <select name="data[Recharge][dth_operator]" class="validate[required]">
                                    	<option value="">Select your DTH provider</option>
                                        <?php foreach($operator as $ops){ if($ops['Operator']['type']=='2'){ ?>
                                        	<option value="<?php echo $ops['Operator']['id']; ?>"><?php echo $ops['Operator']['name']; ?></option>
                                        <?php }} ?>
                                    </select></div>
                                    
                                    <div class="common_row tabTypes tab_type_3" style="display:none">
                                        <label>Enter Prepaid Datacard Number</label>
                                        <input type="text" id="datacard_num" class="input validate[required]" name="data[Recharge][datacard_num]">
                                    </div>
                                    <div class="common_row tabTypes tab_type_3" style="display:none"><label>Datacard Operator</label>
                                    <select name="data[Recharge][dc_operator]" class="validate[required]">
                                    	<option value="">Select Your Operator</option>
                                        <?php foreach($operator as $ops){ if($ops['Operator']['type']=='3'){ ?>
                                        	<option value="<?php echo $ops['Operator']['id']; ?>"><?php echo $ops['Operator']['name']; ?></option>
                                        <?php }} ?>
                                    </select></div>
                                    
                                    <div class="common_row check">
                                    <label class="check active"><input type="hidden" id="is_voucher" name="data[Recharge][is_voucher]"><span>I have a gift voucher</span></label></div>
                                    <div class="error_div error_div_2" style="display:none;">Voucher already used.</div>
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
            </div>         
        </div>
        
<script type="text/javascript">
$(document).ready(function(e) {
    $('.mobile_num').keyup(function () {     
	  this.value = this.value.replace(/[^0-9\.]/g,'');
	});	 
	$("#mobRechargeForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
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

function redeem_voucher()
{
	var code=$('#voucher_code_val').val();	
	code=code.replace(/[^a-zA-Z0-9]/g, "");
	if(code!='')
	{
		showCustomLoading('.redeem_div','80px','40px');	
		$.post('<?php echo $this->webroot; ?>recharge/validate_voucher_code',{code:code},function(data){
			
				var resp=data.split('|');
				if(resp[0]=='success')
				{
						$('.redemption').show();
						//$('.redeem_div').hide();
						$('#amount').val(resp[1]);
						$('#val_amount').val(resp[1]);
						$('#val_amount').html(resp[1]);
						$('#voucher_amount').val(resp[1]);
						$('#redeemed_code').val(resp[2]);
						$('.avail_rech_div').show();
						
					
				}else if(resp[0]=='error'){
					//$('.avail_rech_div').show();
					$('.error_div_2').html(resp[1]);
					$('.error_div_2').show();
					$('.error_div_2').delay(5000).fadeOut('slow');
				}	
				
				$('.redeem_div').html('<label>Enter your Voucher Code</label><input id="voucher_code_val" class="middle" value="'+code+'" type="text"><a class="btn" href="javascript://" onclick="redeem_voucher();">Redeem</a>');		
		});
	}else{
		$('#voucher_code_val').css('border','1px solid #FF0000');
		$('#voucher_code_val').css('box-shadow','0 0 8px #FF0000');
		$('#voucher_code_val').effect( "bounce", "fast" );
	}
}


function proceed_to_recharge()
{
	var valid = $("#mobRechargeForm").validationEngine('validate');
	if(valid){
		var amount=$('#amount').val();
		var val=$('#recharge_value').val();
		val=parseInt(val.replace(/[^0-9\.]/g,''));
		if(parseInt(amount)!='0')
		{
		if(val=='' || isNaN(val) || val=='undefined' || val>parseInt(amount))
		{
			$('.error_div_3').html('Maximum recharge amount available is INR '+amount);
			$('.error_div_3').show();
			scrollToAnchor('.error_div_3');
			$('.error_div_3').delay(4000).fadeOut('slow');	
		}else{			
			if(amount!='0')
			{
				/*if(parseInt(amount)>400)
				{
					
					$('#recharge_value').val(400.00);	
				}*/
				var frm=$('#mobRechargeForm').serialize();			
				showCustomLoading('.inner_tabing','350px','175px');
				$.post(site_url+'/recharge/proceed_to_recharge',frm,function(data){
					$('.inner_tabing').html(data);
					scrollToAnchor('.tab_details');
				});	
			}else{
				$('.error_div_1').show();	
				scrollToAnchor('.error_div_1');
				$('.error_div_1').delay(5000).fadeOut('slow');
			}			
		}
		}else{
				$('.error_div_1').show();	
				scrollToAnchor('.error_div_1');
				$('.error_div_1').delay(5000).fadeOut('slow');
		}
	}else{
		$("#mobRechargeForm").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
		return false;
	}
	return false;
}

function scrollToAnchor(aid){
    var aTag = $(aid);
    $('html,body').animate({scrollTop: aTag.offset().top-100},'slow');
}

function toggle_recharge_type(num)
{
	$('.tabing li label').removeClass('active');
	$('ul.tabing li.li_num_'+num).find('label').addClass('active');
	if(num=='1'||num=='4')
	{
		$('.tab_details').show();	
		$('.coming_soon_div').hide();
		
		$('.tabTypes').hide();
		$('.tab_type_'+num).show();	
		$('#recharge_type').val(num);
	}else{
		$('.tab_details').hide();	
		$('.coming_soon_div').show();
	}	
}

function show_this_tab(num)
{
	$('.main li').removeClass('active');
	$('ul.main li').eq(num).addClass('active');
	showCustomLoading('.inner_tabing','350px','175px');	
	$.post(site_url+'/recharge/show_process',{num:num},function(data){
		$('.inner_tabing').html(data);	
	})	
}

function update_user_name()
{
	$.post(site_url+'/recharge/update_user',function(data){
		$('.user_name_div').html(data);	
	});	
}

function back_to_index()
{
	var frm=$('#RechargeForm').serialize();
	showCustomLoading('.inner_tabing','350px','175px');	
	$.post(site_url+'/recharge/back_to_index',frm,function(data){
		$('.inner_tabing').html(data);	
	});	
}
</script>        