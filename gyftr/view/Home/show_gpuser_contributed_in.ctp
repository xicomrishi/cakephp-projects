<style>
.action{ min-height:16px !important; }
</style>
<div id="form_section">
		
            <span class="select_dele">/ / All About The <strong>Gift</strong>
            </span>
            <form action="#">
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
            <div class="detail_row last">
            <label>Gift started by:</label>
            <span class="detail"><?php echo $startedbyUser['User']['first_name'].' '.$startedbyUser['User']['last_name']; ?></span>
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
           <span class="detail"><?php if($order['Order']['contri_type']!=1) echo 'INR'; ?> <?php foreach($group as $gp){ 
				if($gp['GroupGift']['email']==$this->Session->read('User.User.email')||(($gp['GroupGift']['fb_id']==$this->Session->read('User.User.fb_id'))&&(!empty($gp['GroupGift']['fb_id'])))){
					if(!empty($gp['GroupGift']['contri_amount_expected'])){ 
							if($gp['GroupGift']['contri_amount_expected']-$gp['GroupGift']['contri_amount_paid']>0)
                            {       echo $gp['GroupGift']['contri_amount_expected']-$gp['GroupGift']['contri_amount_paid']; 
							}else{
							 	if($order['Order']['contri_type']==1) echo 'You decide'; else echo '0';
							}
                }else{ if($order['Order']['contri_type']==1) echo 'You decide'; else echo '0'; }}} ?></span>
            </div>
            
            
            <?php if($order['Order']['payment_status']=='0'){ ?>
            <div class="detail_row last">
            <label>I want to pay: INR</label>
            <span class="detail"><?php foreach($group as $gp){ 
				if($gp['GroupGift']['email']==$this->Session->read('User.User.email')||(($gp['GroupGift']['fb_id']==$this->Session->read('User.User.fb_id'))&&(!empty($gp['GroupGift']['fb_id'])))){
					//if(empty($gp['det']['contri_amount_paid'])){ ?>
                    <input type="text" style="float:left; border:1px solid #ccc; margin-right:14px;" id="pay_amount" class="validate[custom[integer],min[1]]"/> <a href="javascript://" onclick="show_payment_proceed('<?php echo $order['Order']['id'];?>','<?php echo $user['User']['id']; ?>');" class="action">Pay Now</a>
                    
                <?php //}else{ echo '<a href="javascript://" class="action">Paid</a>'; }
				
				}} ?></span>
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
            <span class="detail"><input type="text" style="float:left; border:1px solid #ccc; margin-right:14px;" id="rd_points" class="validate[custom[integer],min[1]]"/><a href="javascript://" class="action redeem_pts" onclick="redeem_points('<?php echo $order['Order']['id']; ?>','<?php echo $user['User']['id']; ?>','1');">Redeem Now</a></span>
            </div>
            <?php } ?>
            </div>
            <?php } ?>
            
            <div class="comn_box">
            <div class="main_heading"><span>About the <strong>Recipient</strong></span></div>
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
            <span class="detail"><a href="javascript://" class="mail none" id="s_to_email"><?php if(!empty($order['Order']['to_email'])) echo $order['Order']['to_email']; else echo 'N/A'; ?></a></span>
            </div>
            <div class="detail_row last">
            <label>Delivery Mobile No.:</label>
            <span class="detail" id="s_to_phone"><?php if(!empty($order['Order']['to_phone'])){ echo $order['Order']['to_phone']; }else{ echo 'N/A'; } ?></span>
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
            <td class="col large last"><strong>Contributed Amount</strong></td>
            <!--<td class="col small last"><strong>Refund</strong></td>-->
                 
            </tr>
            <?php foreach($group as $gp){ ?>
            <tr class="comn_row">
            <td class="col large"><?php echo $gp['GroupGift']['name']; ?></td>
            <td class="col large"><a href="javascript://" class="mail"><?php if(!empty($gp['GroupGift']['fb_id'])) {echo 'Via Facebook';}else{ echo $gp['GroupGift']['email']; } ?></a></td>
            <td class="col large"><?php if(!empty($gp['GroupGift']['phone'])) echo $gp['GroupGift']['phone']; else echo 'N/A';  ?></td>
            <td class="col large"><?php echo $gp['GroupGift']['contri_amount_expected']; ?></td>
            <td class="col large last"><?php if(!empty($gp['GroupGift']['contri_amount_paid'])) echo $gp['GroupGift']['contri_amount_paid']; else echo '0'; ?></td>
            <!--<td class="col small last"><?php echo '0'; //echo $gp['GroupGift']['contri_amount_paid'] - $gp['GroupGift']['contri_amount_expected']; ?></td>-->
           
            </tr>
            <?php } ?>                
         
            </table>
            </div>
            </div>
             
            </div>
             <?php if(($order['Order']['payment_status']!=0)){ ?>
            	            	<div class="gift_status"><?php echo $this->Html->image('form_right_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>Gift has been closed for editing.</div>
            <?php }else{ ?>  
            <div class="submit_row"><a class="done add_contributor" href="javascript://" onclick="add_propose_popup('<?php echo $order['Order']['id']; ?>');">Propose Contributor</a></div>
            <?php } ?>
          
            </form>
            <?php if(($order['Order']['payment_status']==0)){ ?>            
            
            <div class="bottom">
            	<span class="left_img">
               	<?php echo $this->Html->image('form_left_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
                <span class="right_img">
                <?php echo $this->Html->image('form_right_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
            </div>
             <?php } ?>
       </div>
       