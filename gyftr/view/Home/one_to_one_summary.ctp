<div class="breadcrumb">
			<ul>
				<li class="first"><a href="<?php echo SITE_URL; ?>">Home</a></li>
				<li><a href="javascript://" onclick="return nextStep('step-2','start');">Select Gift Type</a></li>
                  <?php if($this->Session->read('Gifting.type')!='me_to_me'){ ?>
				<li><a href="javascript://" onclick="return nextStep('one_to_one','<?php echo $this->Session->read('Gifting.type');?>');">Recipient</a></li>
				<?php } ?>
				<li><a href="javascript://" onclick="return nextStep('step-3','<?php $sess=$this->Session->read('Gifting.type'); if($sess=='me_to_me') echo 'meTome'; else echo $sess; ?>');">Select Gift</a></li> 
                <li><a href="javascript://" onclick="return select_product('0');">Basket</a></li>                
                <li><a href="javascript://" onclick="voucherStep('get_delivery');">Delivery</a></li>
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
            <span class="detail" id="s_to_name"><?php if(isset($order['friend_name'])&&(trim($order['friend_name'])!='')) echo $order['friend_name']; else echo 'Me'; ?></span>
            </div>
            <div class="detail_row">
            <label>Delivery Date and Time:</label>
            <span class="detail"><?php echo show_formatted_datetime($order['delivery_details']['delivery_time']); ?></span>
            </div>
            <div class="detail_row">
            <label>Delivery e-mail id:</label>
            <span class="detail" id="s_to_email"><?php if($this->Session->check('Gifting.friend_email')){ if($this->Session->read('Gifting.friend_email')!='') echo $this->Session->read('Gifting.friend_email'); else echo '<input type="text" id="s_to_email_submit" class="validate[required,custom[email]]" value=""/>'; }else if($this->Session->read('Gifting.type')=='me_to_me'){ echo 'My Email'; }else{ ?><a href="javascript://" class="mail none"><?php echo '<input type="text" id="s_to_email_submit" class="validate[required,custom[email]]" value=""/>'; ?></a><?php } ?></span>
            </div>
            <div class="detail_row">
            <label>Delivery Mobile No.:</label>
            <span class="detail" id="s_to_phone"><?php if($this->Session->check('Gifting.friend_phone')&&($this->Session->read('Gifting.friend_phone')!='')){ echo $this->Session->read('Gifting.friend_phone'); }else if($this->Session->read('Gifting.type')=='me_to_me'){ echo 'My Mobile No.'; }else{ echo '<input type="text" id="s_to_phone_submit" maxlength="10" value="" class="validate[required,custom[integer],minSize[10],maxSize[10]]"/>'; }  ?></span>
            </div>
               <div class="detail_row last" id="error_msg">
            <?php if(!$this->Session->check('Gifting.friend_email')){  ?>             
         	 <span style="color:#FF0000" id="incomp_msg">*Email Id and mobile number of recipient are required for delivering the gift.</span>    
            <?php }else if(!$this->Session->check('Gifting.friend_phone')){ ?>
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
            <?php if($this->Session->read('Gifting.type')!='me_to_me'){ ?>
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
            <?php } ?>
            </div>
            
            
            <?php if($available_flag==1){ ?>
             <div class="submit_row"><a class="done add_contributor" href="javascript://" onclick="get_status_page();">Go Gyft</a></div> 
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

function get_status_page()
{
	var valid = $("#editable").validationEngine('validate');
	
	if(valid)
	{
	showLoading('#banner');
	$.post('<?php echo SITE_URL; ?>/home/get_status_page',function(data){
			$('#banner').html(data);
		});	
	}else{
		$("#editable").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
	}
}

</script>       