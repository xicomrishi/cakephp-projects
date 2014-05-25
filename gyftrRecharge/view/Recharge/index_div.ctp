<ul class="tabing">
                	<li class="li_num_1" onclick="toggle_recharge_type('1');"><label class="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='1') echo 'active'; }else{ echo 'active'; }?>"><span>Mobile</span></label></li>
                    <li class="li_num_2"  onclick="toggle_recharge_type('2');"><label class="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='2') echo 'active'; }?>"><span>DTH</span></label></li>
                    <li class="li_num_3"  onclick="toggle_recharge_type('3');"><label class="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='3') echo 'active'; }?>"><span>Data Card</span></label></li>
                    
                </ul>
                <div class="tab_details">
                	<div class="detail_section">
                    	<div class="common_steps">
                        	<form id="mobRechargeForm" name="mobRechargeForm" method="post" action="<?php echo $this->webroot; ?>recharge/proceed_to_recharge" onsubmit="return proceed_to_recharge();">
                            	<fieldset>
                                	<input id="recharge_type" type="hidden" name="data[Recharge][recharge_type]" value="<?php if(isset($setdata)) echo $setdata['Recharge']['recharge_type']; else echo '1';  ?>"/>
                                    
                                    <input id="redeemed_code" type="hidden" name="data[Recharge][voucher_code]" value=""/>
                                    <div class="error_div error_div_1" style="display:none;">Please enter voucher code</div>
                                	<div class="common_row tabTypes tab_type_1" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='1') echo 'style="display:none;"';} ?>>
                                        <label>Recharge my prepaid mobile no.</label>
                                        <span class="inn">+91</span><input type="text" id="mobile_num" class="mobile_num validate[required,custom[integer],minSize[10],maxSize[10]]]" name="data[Recharge][mobile_num]" maxlength="10" min="0" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='1') echo $setdata['Recharge']['number']; } ?>">
                                    </div>
                                    <div class="common_row tabTypes tab_type_1" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='1'){ echo 'style="display:none;"';}} ?>>
                                    <label>Mobile Operator</label>
                                    <select id="mob_operator" name="data[Recharge][mob_operator]" class="validate[required]">
                                    	<?php if(!isset($setdata)){ ?>
                                        <option value="">Select Your Operator</option>
                                        <?php } ?>
                                        <?php foreach($operator as $ops){ if($ops['Operator']['type']=='1'){ ?>
                                        	<option value="<?php echo $ops['Operator']['id']; ?>" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='1'){ if($setdata['Recharge']['operator_id']==$ops['Operator']['id']) echo 'selected'; }}?>><?php echo $ops['Operator']['name']; ?></option>
                                        <?php }} ?>
                                    </select></div>
                                    
                                    
                                     <div class="common_row tabTypes tab_type_1" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='1'){ echo 'style="display:none;"';}} ?>><label>Circle</label>
                                    <select id="mob_circles" name="data[Recharge][circle_id]" class="validate[required]">
                                    	<option value="">Select Your Circle</option>
                                        <?php foreach($circles as $cr){ ?>
                                        	<option value="<?php echo $cr['Circle']['id']; ?>" <?php if(isset($setdata)){  if($setdata['Recharge']['circle_id']==$cr['Circle']['id']) echo 'selected'; }?>><?php echo $cr['Circle']['circle']; ?></option>
                                        <?php } ?>
                                    </select></div>
                                    
                                    <div class="common_row tabTypes tab_type_2" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='2'){ echo 'style="display:none;"';}}else{ echo 'style="display:none;"'; } ?>>
                                        <label>Enter your Customer ID</label>
                                        <input type="text" id="customer_id" class="input validate[required]" name="data[Recharge][customer_id]" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='2') echo $setdata['Recharge']['number']; } ?>">
                                    </div>
                                    <div class="common_row tabTypes tab_type_2" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='2'){ echo 'style="display:none;"';}}else{ echo 'style="display:none;"'; } ?>><label>DTH Provider</label>
                                    <select name="data[Recharge][dth_operator]" class="validate[required]">
                                    	<?php if(!isset($setdata)){ ?>
                                    	<option value="">Select your DTH provider</option>
                                        <?php } ?>
                                        <?php foreach($operator as $ops){ if($ops['Operator']['type']=='2'){ ?>
                                        	<option value="<?php echo $ops['Operator']['id']; ?>" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='2'){ if($setdata['Recharge']['operator_id']==$ops['Operator']['id']) echo 'selected'; }}?>><?php echo $ops['Operator']['name']; ?></option>
                                        <?php }} ?>
                                    </select></div>
                                    
                                    <div class="common_row tabTypes tab_type_3" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='3'){ echo 'style="display:none;"';}}else{ echo 'style="display:none;"'; } ?>>
                                        <label>Enter Prepaid Datacard Number</label>
                                        <input type="text" id="datacard_num" class="input validate[required]" name="data[Recharge][datacard_num]" value="<?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='3') echo $setdata['Recharge']['number']; } ?>">
                                    </div>
                                    <div class="common_row tabTypes tab_type_3" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']!='3'){ echo 'style="display:none;"';}}else{ echo 'style="display:none;"'; } ?>><label>Datacard Operator</label>
                                    <select name="data[Recharge][dc_operator]" class="validate[required]">
                                    	<?php if(!isset($setdata)){ ?>
                                    	<option value="">Select Your Operator</option>
                                        <?php } ?>
                                        <?php foreach($operator as $ops){ if($ops['Operator']['type']=='3'){ ?>
                                        	<option value="<?php echo $ops['Operator']['id']; ?>" <?php if(isset($setdata)){ if($setdata['Recharge']['recharge_type']=='3'){ if($setdata['Recharge']['operator_id']==$ops['Operator']['id']) echo 'selected'; }}?>><?php echo $ops['Operator']['name']; ?></option>
                                        <?php }} ?>
                                    </select></div>
                                    
                                    <div class="common_row check" <?php if(isset($setdata)){  echo 'style="display:none;"'; } ?>>
                                    <label class="check active"><input type="hidden" id="is_voucher" name="data[Recharge][is_voucher]"><span>I have a gift voucher</span></label></div>
                                    <div class="error_div error_div_2" style="display:none;">Invalid voucher code. Please try again.</div>
                                    <div class="common_row redeem_div"><label>Enter your Voucher Code</label>
                                    <input id="voucher_code_val" class="middle" type="text" name="data[Recharge][voucher_code_val]" autocomplete="off"><a class="btn" href="javascript://" onclick="redeem_voucher();">Redeem</a></div>                                    
                                                                       
                                    <div class="common_row redemption"><label>Usable value of Gift Code available for recharge</label>
                                    <span class="inn"><?php echo $this->html->image('rupee_img.png',array('escape'=>false,'div'=>false,'alt'=>'rupee'));?></span><input id="amount" type="text" readonly="readonly" name="data[Recharge][amount]" value="0"  autocomplete="off"><div class="small_note">Usable value = Gift code face value  minus handling  charges</div></div>
                                    
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
                   
            