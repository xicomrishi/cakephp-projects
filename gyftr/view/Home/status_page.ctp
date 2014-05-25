<style>
.action{ min-height:16px !important; }
</style>
<div id="form_section">
	
            <span class="select_dele">/ / All About The <strong>Gift</strong>
            </span>
           <form id="editable" class="editable paymentForm" action="">
            <input type="hidden" id="order_id" value="<?php echo $order['Order']['id']; ?>"/>
            <div class="comn_box">
            <div class="detail_row" style="width:80%;">
            <label style="width:30% !important;">Gift Status:</label>
            <div class="progress_bar">
            <span class="bar">
          
            <a href="javascript://" <?php if($order['Order']['status']==2){ echo 'class="active"'; }?>>Pending</a>
              <a href="javascript://" <?php if($order['Order']['status']==0){ echo 'class="active"'; }?>>In Progress</a>
            <a href="javascript://" <?php if($order['Order']['status']==1){ echo 'class="active"'; }?>>Delivered</a>
             <a href="javascript://" <?php if($order['Order']['status']==3){ echo 'class="active"'; }?>>Expired</a>
            </span>
            </div>
            </div>
            <div class="detail_row">
            <label>Gift created on:</label>
            <span class="detail"><?php echo show_formatted_datetime($order['Order']['created']); ?></span>
            </div>
            <div class="detail_row">
            <label>Your Details:</label>
            <span class="detail"><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></span>
            </div>
            <div class="detail_row">
            <label>Your e-mail id:</label>
            <span class="detail"><a href="mailto:'<?php echo $user['User']['email']; ?>'" class="mail"><?php echo $user['User']['email']; ?></a></span>
            </div>
            <div class="detail_row <?php if(!empty($user['User']['phone'])) echo 'last'; ?>">
            <label>Your Mobile No.:</label>
            <span class="detail" id="user_phone"><?php if(!empty($user['User']['phone'])||($order['Order']['status']==3)){ echo $user['User']['phone']; }else{ echo '<input type="text" id="user_phone_submit" value="" maxlength="10" class="validate[required,custom[integer],minSize[10],maxSize[10]]"/>'; } ?></span>
            </div>
             <div class="detail_row last" id="error_msg1">
            <?php if(empty($user['User']['phone'])){  ?>             
         	 <span style="color:#FF0000" id="incomp_phone_msg">*Your mobile number is required.</span>      
            <?php } ?>
            </div>
            </div>
            
            
			 <?php if(($order['Order']['payment_status']=='0'||($order['Order']['total_amount']-$order['Order']['amount_paid'])>0)&&($order['Order']['status']!=1)&&($order['Order']['status']!=3)){ ?>
            <div class="comn_box">
            <div class="main_heading"><span>My Payment <strong>Status</strong></span></div>
            <div class="detail_row">
            <label>Amount Pending:</label>
             <span class="detail">INR <?php echo $order['Order']['total_amount']-$order['Order']['amount_paid']; ?></span>
             </div>
            <div class="detail_row">
            <label>Your contribution amount:</label>
            <span class="detail">INR <?php if(($order['Order']['total_amount']-$order['Order']['amount_paid'])>0) echo $order['Order']['total_amount']-$order['Order']['amount_paid']; else echo 0; ?></span>
            </div>
         
            <?php if($order['Order']['payment_status']=='0'||($order['Order']['total_amount']-$order['Order']['amount_paid'])>0){ ?>
            <div class="detail_row last">
            <label>I want to pay: INR </label>
            <span class="detail"><input type="text" style="float:left; border:1px solid #ccc; margin-right:14px;" id="pay_amount" class="validate[custom[integer],min[1]]"/><a href="javascript://" onclick="show_payment_proceed('<?php echo $order['Order']['id'];?>','<?php echo $user['User']['id']; ?>');" class="action">Submit</a></span>
            </div>
            <?php } ?>
                     
            </div>
         
                 
            <div class="comn_box">
            <div class="main_heading"><span>MyGyFTR Coins <strong>Status</strong></span></div>            
        
            
            <div class="detail_row">
            <label>Number of Coins:</label>
            <span class="detail"><?php echo $user['User']['points']; ?></span>
            </div>
            <div class="detail_row">
            <label>Redeemable Coins:</label>
            <span class="detail"><?php if($user['User']['points']>100){ $rdp=$user['User']['points']; echo $rdp; }else{ echo '0'; } ?></span>
            </div>
            
            <?php if($order['Order']['payment_status']=='0'&&$user['User']['points']>100){ $rdp=$user['User']['points']; ?>
            <div class="detail_row last">
            <label>Convert Coins to INR:</label>
            <span class="detail"><input type="text" style="float:left; border:1px solid #ccc; margin-right:14px;" id="rd_points" class="validate[custom[integer],min[1]]"/><a href="javascript://" class="action redeem_pts" onclick="redeem_points('<?php echo $order['Order']['id']; ?>','<?php echo $user['User']['id']; ?>','0');">Redeem Now</a></span>
            </div>
            <?php } ?>
            </div>
            
            
             <?php if(empty($order['Order']['promo_code'])){ ?>
            <div class="comn_box">
            <div class="main_heading"><span>Use Promo <strong>Code</strong></span></div>                                   
            
            <div class="detail_row last">
            <span style="color:#FF0000; display:none;" id="invalid_promo">Invalid Promo Code!</span> 
            <label>Promo Code: </label>
            <span class="detail">
                    <input type="text" style="float:left; border:1px solid #ccc; margin-right:14px;" id="promo_code_inp"/><a href="javascript://" onclick="use_promo_code('<?php echo $order['Order']['id'];?>','<?php echo $user['User']['id']; ?>');" class="action">Submit</a>
               </span>
              
            </div>   
            
            </div>
            <?php } ?>    
            
            <?php if(empty($order['Order']['voucher_code'])){ ?>
            <div class="comn_box">
            <div class="main_heading"><span>Pay by MyGyFTR <strong>Voucher</strong></span></div>                                   
            
            <div class="detail_row last">
            <span style="color:#FF0000; display:none;" id="invalid_voucher">Invalid Voucher Code!</span> 
            <label>Enter your Voucher Code: </label>
            <span class="detail">
                    <input type="text" style="float:left; border:1px solid #ccc; margin-right:14px;" id="voucher_code_inp"/><a href="javascript://" onclick="use_voucher_code('<?php echo $order['Order']['id'];?>','<?php echo $user['User']['id']; ?>');" class="action voucher_submit">Submit</a><span class="voucher_sub_text" style="display:none;">Please wait...</span>
               </span>
              
            </div>   
            
            </div>
            <?php } ?>
            
            <?php } ?>
            
            
            <div class="comn_box">
            <div class="main_heading"><span>About the <strong>Recipient</strong></span>  <?php if(($order['Order']['payment_status']==0)){ ?><a href="javascript://" class="edit" onclick="edit_status_page('<?php echo $order['Order']['id']; ?>');">Edit</a><?php } ?></div>
            <div class="detail_row">
            <label>Name:</label>
            <span class="detail" id="s_to_name"><?php echo $order['Order']['to_name']; ?></span>
            </div>
            <div class="detail_row">
            <label>Delivery Date and Time:</label>
            <span class="detail" id="s_delivery_time"><?php echo show_formatted_datetime($order['Order']['delivery_time']); ?></span>
            </div>
            <div class="detail_row">
            <label>Delivery e-mail id:</label>
            <span class="detail"><?php if($this->Session->check('Gifting.friend_email')){ echo $this->Session->read('Gifting.friend_email');}else{ ?><a href="javascript://" class="mail none" id="s_to_email"><?php if(!empty($order['Order']['to_email'])||($order['Order']['status']==3)) echo $order['Order']['to_email']; else echo '<input type="text" id="s_to_email_submit" class="validate[required,custom[email]]" value=""/>'; ?></a><?php } ?></span>
            </div>
            <div class="detail_row last">
            <label>Delivery Mobile No.:</label>
            <span class="detail" id="s_to_phone"><?php if(!empty($order['Order']['to_phone'])||($order['Order']['status']==3)){ echo $order['Order']['to_phone']; }else{ echo '<input type="text" id="s_to_phone_submit" maxlength="10" value="" class="validate[required,custom[integer],minSize[10],maxSize[10]]"/>'; } ?></span>
            </div>
            <div class="detail_row last" id="error_msg">
            <?php if(empty($order['Order']['to_email'])||empty($order['Order']['to_phone'])){  ?>
             
         	 <span style="color:#FF0000" id="incomp_msg">*Email Id and mobile number of recipient are required for delivering the gift.</span>           
          
            <?php } ?>
            </div>
            </div>
            
            <div class="comn_box">
            <div class="main_heading"><span>About the <strong>Gift</strong></span></div>
            <?php foreach($basket as $bask){ ?>
            <div class="detail_row">
            <label>Voucher: </label>
            <span class="detail"><?php echo '<b>'.str_replace("_","'",$bask['voucher']['BrandProduct']['voucher_name']).'</b>'; ?></span>
            </div> 
            <div class="detail_row">
            <label>Quantity: </label>
            <span class="detail"><?php echo $bask['details']['quantity']; ?></span>
            </div> 
            <div class="detail_row">
            <label>Expiry Date: </label>
            <span class="detail"><?php echo $bask['voucher']['BrandProduct']['voucher_expiry']; ?></span>
            </div> 
            <div class="detail_row">
            <label>Amount: </label>
            <span class="detail"><?php echo $bask['details']['total_value']; ?></span>
            </div> 
            <?php } ?>
            <div class="detail_row">
            <label>Total Price:</label>
            <span class="detail">INR <?php echo $order['Order']['total_amount']; ?></span>
            </div> 
            <?php if($order['Order']['type']!='Me To Me'){ ?>       
            <div class="detail_row last">
            <label>Send Partial Gift:</label>
            <div class="progress_bar">
            <span class="detail green">
            <?php if($order['Order']['incomplete_deliver']=='1'){ ?>
            	Yes
            <?php }else{ ?>
             No
            <?php } ?>
            </span>
          
            </div>
            </div>
            <?php } ?>
            </div>
            
            </form>
            <div class="bottom">
            	<span class="left_img">
               	 <?php echo $this->Html->image('form_left_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
                <span class="right_img">
                <?php echo $this->Html->image('form_right_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
            </div>
       </div>
       
<script type="text/javascript">
$(document).ready(function(e) {
    <?php if(isset($success_setup_gift)){ ?>
		show_setup_success_msg('<?php echo $order['Order']['id']; ?>');
	<?php }else if(isset($promocode)){ 
					if($promocode==1){ ?>	
		$('#invalid_promo').show();
		setTimeout(function(){ $('#invalid_promo').hide(); },10000);
	<?php }else{ if($msg['type']==1) $tp=1; else $tp=2; ?>
		show_promo_discount('<?php echo $msg['val']; ?>','<?php echo $tp; ?>');
	<?php }}else if(isset($vouchercode)){ ?>
						
		$('#invalid_voucher').html('<?php echo $vouchererror; ?>');	
		$('#invalid_voucher').show();
		setTimeout(function(){ $('#invalid_voucher').hide(); },10000);
		
	<?php }else if(isset($payment_success)){ ?>
			payment_successfull_msg('<?php echo $order['Order']['id']; ?>');
	<?php } ?>		
	
	$("#editable").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	check_validation();	
	
});

</script>          
       