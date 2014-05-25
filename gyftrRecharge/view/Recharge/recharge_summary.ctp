<style>
.back_btn{background: none repeat scroll 0 0 #F87C03;border: medium none;border-radius: 3px 3px 3px 3px;color: #FFFFFF;cursor: pointer;float: left;  font-family: 'robotolight';font-size: 26px;line-height: 34px; margin-right:10px; text-decoration:none; padding: 5px 16px;width: auto;}
</style>
<div class="tab_details">
    <div class="detail_section">
        <div class="common_steps stepSection">
	<form id="RechargeForm" name="RechargeForm" method="post" action="<?php echo $this->webroot; ?>recharge/verify_recharge" onsubmit="return recharge_proceed();">
        <fieldset>
            <input  type="hidden" name="data[Recharge][recharge_type]" value="<?php echo $data['Recharge']['recharge_type']; ?>"/>
            <input  type="hidden" name="data[Recharge][voucher_code]" value="<?php echo $data['Recharge']['voucher_code']; ?>"/>
            <input  type="hidden" name="data[Recharge][operator_id]" value="<?php echo $data['Recharge']['operator_id']; ?>"/>
            <input type="hidden" name="data[Recharge][number]" value="<?php echo $data['Recharge']['number']; ?>"/>
            <input  type="hidden" name="data[Recharge][amount]" value="<?php echo $data['Recharge']['amount']; ?>"/>
            <input  type="hidden" name="data[Recharge][log_id]" value="<?php echo $data['Recharge']['log_id']; ?>"/>
            <input type="hidden" name="data[Recharge][recharge_value]" value="<?php echo $data['Recharge']['recharge_value']; ?>"/>
            <input type="hidden" name="data[Recharge][circle_id]" value="<?php if(isset($data['Recharge']['circle_id'])) echo $data['Recharge']['circle_id']; ?>"/>
            <?php if(isset($data['Recharge']['circle_id'])){ ?>
                <input type="hidden" name="data[Recharge][circle_id]" value="<?php echo $data['Recharge']['circle_id']; ?>"/>
            <?php } ?>
            <?php if(isset($data['Recharge']['cycle_number'])){ ?>
                <input type="hidden" name="data[Recharge][cycle_number]" value="<?php echo $data['Recharge']['cycle_number']; ?>"/>
            <?php } ?>
             <?php if(isset($data['Recharge']['customer_acc_number'])){ ?>
                <input type="hidden" name="data[Recharge][customer_acc_number]" value="<?php echo $data['Recharge']['customer_acc_number']; ?>"/>
            <?php } ?>
            <?php if(isset($data['Recharge']['date_of_birth'])){ ?>
                <input type="hidden" name="data[Recharge][date_of_birth]" value="<?php echo $data['Recharge']['date_of_birth']; ?>"/>
            <?php } ?>
            <?php if(isset($data['Recharge']['std_code'])){ ?>
                <input type="hidden" name="data[Recharge][std_code]" value="<?php echo $data['Recharge']['std_code']; ?>"/>
            <?php } ?>
            <input  type="hidden" name="data[User][id]" value="<?php echo $user_id; ?>"/>
             <?php if(isset($RechargeStatus)){ ?>
            <div class="error_div error_div_1"><?php echo $RechargeStatus; ?></div>
            <?php } ?>
                      
            <div class="common_row ">                
                <span><strong>Number/ID: </strong><?php echo $data['Recharge']['number']; ?></span>               
             </div>
             <div class="common_row">                
                <span><strong>Operator: </strong><?php echo $operator['Operator']['name']; ?></span>               
             </div>
             <div class="common_row">                
                <span><strong>Voucher: </strong><?php echo $data['Recharge']['voucher_code']; ?></span>               
             </div>
             <div class="common_row">                
                <span><strong>Recharge Value: </strong><?php echo $data['Recharge']['recharge_value']; ?></span>               
             </div>
             <div class="common_row"> 
             	<a href="javascript://" onclick="back_to_index();" class="back_btn">Go Back</a>               
                <input type="submit" id="proceed_btn" value="Proceed" />              
             </div>
                                  
        </fieldset>
    </form>
    
         </div>
          
        </div>
    </div>

        
<script type="text/javascript">
$(document).ready(function(e) {
	 $('body').scrollTop(0);
    $('#proceed_btn').one('click',function(){
			$('#proceed_btn').remove();
			recharge_proceed();
		});
});
function recharge_proceed()
{
	var frm=$('#RechargeForm').serialize();
	showCustomLoading('.inner_tabing','350px','175px');	
	$.post(site_url+'/recharge/verify_recharge',frm,function(data){
		$('.inner_tabing').html(data);		
	});
	return false;
	//$('#userRegisterForm').submit();	
}
</script>         