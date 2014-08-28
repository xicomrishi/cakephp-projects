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
                <li><a href="javascript://" onclick="voucherStep('get_decide_contri');">contribution</a></li>
                <li class="last">Summary</li>
              </ul>
</div>
<div id="form_section">
		
            <span class="select_dele">/ / <strong>Summary</strong>
            </span>
             <form id="editable" class="editable" action="">           
            <div class="comn_box">
            <div class="main_heading"><span>About the <strong>Recipient</strong></span> <a href="javascript://" class="edit" onclick="edit_giftsummary_page();">Edit</a></div>
            <div class="detail_row">
            <label>Name:</label>
            <span class="detail" id="s_to_name"><?php echo $order['friend_name']; ?></span>
            </div>
            <div class="detail_row">
            <label>Delivery Date and Time:</label>
            <span class="detail"><?php echo show_formatted_datetime($order['delivery_details']['delivery_time']); ?></span>
            </div>
            <div class="detail_row">
            <label>Delivery e-mail id:</label>
            <span class="detail" id="s_to_email"><?php if($this->Session->check('Gifting.friend_email')){ if($this->Session->read('Gifting.friend_email')!='') echo $this->Session->read('Gifting.friend_email'); else echo '<input type="text" id="s_to_email_submit" class="validate[required,custom[email]]" value=""/>';; }else{ ?><a href="javascript://" class="mail none"><?php echo '<input type="text" id="s_to_email_submit" class="validate[required,custom[email]]" value=""/>'; ?></a><?php } ?></span>
            </div>
            <div class="detail_row">
            <label>Delivery Mobile No.:</label>
            <span class="detail" id="s_to_phone"><?php if($this->Session->check('Gifting.friend_phone')&&($this->Session->read('Gifting.friend_phone')!='')){ echo $this->Session->read('Gifting.friend_phone'); }else{ echo '<input type="text" id="s_to_phone_submit" maxlength="10" value="" class="validate[required,custom[integer],minSize[10],maxSize[10]]"/>'; }  ?></span>
            </div>
               <div class="detail_row last" id="error_msg">
            <?php if(!$this->Session->check('Gifting.friend_email')){  ?>             
         	 <span style="color:#FF0000" id="incomp_msg">*Email Id and mobile number of recipient are required for delivering the gift.</span>    
            <?php }else if(!($this->Session->check('Gifting.friend_phone'))||($this->Session->read('Gifting.friend_phone')=='')){ ?>
            	 <span style="color:#FF0000" id="incomp_msg">*Mobile number of recipient is required for delivering the gift.</span>    
            <?php } ?>
              </div>
            
            </div>
            
            <div class="comn_box">
            <div class="main_heading"><span>About the <strong>Gift</strong></span></div>
            <?php foreach($basket as $bask){ ?>
            <div class="detail_row">
            <label>Voucher: </label>
            <span class="detail"><?php echo '<b>'.str_replace("_","'",$bask['details']['voucher_name']).'</b>'; ?></span>
            </div> 
            <div class="detail_row">
            <label>Quantity: </label>
            <span class="detail"><?php echo $bask['details']['qty']; ?></span>
            </div> 
            <div class="detail_row">
            <label>Expiry Date: </label>
            <span class="detail"><?php echo $bask['details']['voucher_expiry']; ?></span>
            </div> 
            <div class="detail_row">
            <label>Amount: </label>
            <span class="detail"><?php echo $bask['details']['sub_total']; ?></span>
            </div> 
            <?php } ?>
            <div class="detail_row last">
            <label>Incomplete Delivery:</label>
            <div class="progress_bar">
             <span class="detail green">
            <?php if($order['delivery_details']['incomplete_deliver']=='1'){ ?>
            	Yes
            <?php }else{ ?>
             No
            <?php } ?>
            </span>
       
            </div>
            </div>
            </div>
            
            <div class="comn_box Contributing">
            <div class="main_heading"><span>People who would be <strong>Contributing</strong></span></div>
            <div class="detail_row full last">
            <div class="Contri_deatil">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr class="head_row">
            <td class="col large"><strong>Contributors</strong></td>
            <td class="col large"><strong>E-mail Id</strong></td>
            <td class="col large"><strong>Mobile No.</strong></td>
            <td class="col large"><strong>Targeted Contribution</strong></td>
            <td class="col large last"><strong>Update Details</strong></td>
            </tr>
            <?php $i=0; foreach($order['group_gift']['friends'] as $fr){ ?>
            <tr class="comn_row">
            <td class="col large" id="summary_frname_<?php echo $i; ?>"><?php echo $fr['name']; ?></td>
            <td class="col large"><a href="javascript://" class="mail" id="summary_fremail_<?php echo $i; ?>"><?php if(!empty($fr['email'])){ echo $fr['email']; }else{ echo 'N/A'; }?></a></td>
            <td class="col large" id="summary_frphone_<?php echo $i; ?>"><?php if(isset($fr['phone'])) echo $fr['phone']; else echo 'N/A'; ?></td>
            <td class="col large"><?php echo $fr['contri_exp']; ?></td>
            <td class="col large last"><a href="javascript://" class="edit" onclick="edit_summary_frnd('<?php echo $i; ?>','0');">Edit</a></td>
            </tr>
            <?php $i++; } ?>
            <tr class="comn_row none">
            <td class="col full brown">Total</td>
            <td class="col large orenge"><?php echo $total['total']; ?></td>
            </tr>
            <tr class="comn_row none last">
            <td class="col full gray">Balance</td>
            <td class="col large black"><?php echo $total['balance']; ?></td>
            </tr>
            </table>
            </div>
            </div>
            </div>
            <?php if($available_flag==1){ ?>
             <div class="submit_row"><a class="done add_contributor"  id="go_group_gift_button" href="javascript://" onclick="go_group_gyft();">Go Gyft</a></div> 
             <?php } ?>        
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
    $("#editable").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	check_validation();
	<?php if($available_flag==0){ ?>
		gift_not_available();
	<?php } ?>
});


</script>       