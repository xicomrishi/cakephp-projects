<div id="form_section" style="margin:0 0 5px 0; padding:0 1%;">
		
		
            <span class="select_dele">/ / Payment <strong>Summary</strong>
            </span>
            <form name="payuForm" method="post" action="<?php echo PayBaseURL.'/_payment'; ?>">
			 <input type="hidden" name="key" value="<?php echo PayMID; ?>" />
              <input type="hidden" name="hash" value="<?php echo $hash; ?>"/>
              <input type="hidden" name="txnid" value="<?php echo $txnid; ?>" />
               <input type="hidden" name="amount" value="<?php echo $payamount; ?>" />
              <input type="hidden" name="firstname" value="<?php echo $user['User']['first_name']; ?>" />
              <input type="hidden" name="lastname" value="<?php echo $user['User']['last_name']; ?>" />
              <input type="hidden" name="email" value="<?php echo $user['User']['email']; ?>" />
               <input type="hidden" name="phone" value="<?php echo $user['User']['phone'];  ?>" />
              <input type="hidden" name="productinfo" value="<?php foreach($products as $pr){ echo $pr['BrandProduct']['voucher_name']; } ?>" />
              <input type="hidden" name="surl" value="<?php echo SITE_URL.'/home/index/0/success';  ?>" />
              <input type="hidden" name="furl" value="<?php echo SITE_URL.'/home/index/0/failure';  ?>" />
              <input type="hidden" name="curl" value="<?php echo SITE_URL.'/home/index';  ?>" />
              <input type="hidden" name="udf1" value="<?php echo $order['Order']['id'];  ?>" />
              <input type="hidden" name="udf2" value="<?php echo $user['User']['id'];  ?>" />
              <input type="hidden" name="udf3" value="<?php echo $gpuser_id;  ?>" />
            <div class="comn_box gift">
           
            <div class="detail_row">
            <label>First Name:</label>
            <span class="detail"><?php echo $user['User']['first_name']; ?></span>
            </div>        
            <div class="detail_row">
            <label>Last Name:</label>
            <span class="detail"><?php if(!empty($user['User']['last_name'])) echo $user['User']['last_name']; else echo 'N/A';?></span>
            </div>
            <div class="detail_row">
            <label>Email: </label>
          	 <span class="detail"><?php echo $user['User']['email']; ?></span>
            </div>
             <div class="detail_row">
            <label>Phone: </label>
          	 <span class="detail"><?php if(!empty($user['User']['phone'])) echo $user['User']['phone']; else echo 'N/A'; ?></span>
            </div>
            
             <div class="detail_row">
            <label>Vouchers: </label>
          	 <span class="detail"><?php foreach($products as $pr){ echo str_replace("_","'",$pr['BrandProduct']['voucher_name']).' '; } ?></span>
            </div>
             <div class="detail_row">
            <label>Amount: </label>
          	 <span class="detail"><?php echo $payamount; ?></span>
            </div>
             
            <input type="submit" class="done" value="Proceed"/>
        </div>
        
        </form>
        
       </div> 
     