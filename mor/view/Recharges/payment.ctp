<section class="form_sec">
<?php $cart=$this->Session->read('Cart');
	 $guest=$this->Session->read('GuestCustomer');?>
<?php if(isset($cart)){?>
<section class="information_box">
<h3>Your Order Details</h3>          
  <ul id="cart_preview">
   <li><strong>Service Type</strong>:&nbsp;<?php echo $cart['Cart']['ReType'];?></li>
    <li><strong>Number</strong>:&nbsp;<?php echo $cart['Cart']['Number'];?></li>
	<li><strong>Operator</strong>:&nbsp;<?php echo $cart['Cart']['Operator'];?></li>
	<li class="cart_amount"><strong>Amount</strong>:&nbsp;<?php echo $cart['Cart']['Amount'];?></li>
	
	<?php if($cart['Cart']['ServiceCharge']>0){?>
	<li class="service_charge"><strong>Service Charge</strong>:&nbsp;
	<?php 
		echo $cart['Cart']['ServiceCharge'];?>
	</li>
	
	<?php if(isset($cart['Cart']['Discount'])){?>
	<li><strong>Discount</strong>:&nbsp;<?php echo $cart['Cart']['Discount'];?>
	</li>
	<?php }?>
	
	<li class="total_amount"><strong>Total</strong>:&nbsp;
	<?php 
		echo $cart['Cart']['TotalAmount'];?>
	</li>	
	<?php 
	}?>
	
	<?php if($cart['Cart']['Account']){?>
	<li><strong>Account#/Cycle#/DOB</strong>:&nbsp;<?php echo $cart['Cart']['Account'];?>
	</li>
	<?php }?>
 </ul>

</section>
<?php }?>

<!-- coupon box -->
<section class="coupon_box">
<div id="comment_status"><?php echo $this->Session->flash('coupon');?></div>

<?php if(!isset($cart['Cart']['Discount']) && $CouponSetting!='Inactive'){?>	
<div id="coupon_form">
<?php 
echo $this->Form->create('Coupon',array('url'=>'/recharges/coupon_verification','novalidate'=>'novalidate'));?>
<fieldset>
<ul>
	<li>
	<input type="checkbox" name="data[Coupon][action]" id="coupon_option" onclick="click_event();" <?php if($this->Form->value('action')=='Yes'){?>checked="checked"<?php }?>/>
	<h2>I have a coupon code!</h2>
	</li>    
    
	<li  class="coupon_row" style="display:none; width:60%">
	<?php 
	echo $this->Form->input('coupon_code', array('type'=>'text',
	'div'=>false,'between' =>'<span>','after'=>'</span>',
	'label'=>'Coupon Code<strong>*</strong>'));
	?>
	</li>    
	
   
	<li class="coupon_row" style="display:none; width:40%; margin:9px 0 0 0">
	<?php echo $this->Js->submit('Apply',
	 	array('url'=>'/recharges/coupon_verification',
	 	'success'=>'ajax_complete(data, textStatus);',
	 	'before' => $this->Js->get('#loader')->effect('show', array('buffer' => false)),
		'complete' => $this->Js->get('#loader')->effect('hide', array('buffer' => false))
	 	));
		?>
	</li>	
  
	
</ul>
</fieldset>
<?php echo $this->Form->end();
echo $this->Html->image('ajax-loader-5.gif', array('id'=>'loader','style'=>'display:none'));
echo $this->Js->writeBuffer();
?>	
</div>	
<?php }?>
</section>
<!-- /coupon box -->


<section class="payment_box">
<form id="payment_form" name="payment_form" action="<?php echo $this->webroot;?>recharges/payment" method="post">
<section class="row">
<span>select a payment method</span>
</section>
<section class="main_payment">
<ul class="pay pay_left">


	<li><input type="radio" name="data[payment_type]" value="net_banking" checked="checked"> <label>Net Banking</label></li>
	<li><input type="radio" name="data[payment_type]" value="credit_card"> <label>Credit Card</label></li>
	<li><input type="radio" name="data[payment_type]" value="debit_card"> <label>Debit Card</label></li>
    <?php if(!$guest){?>
	 
	<li>
		<input type="radio" name="data[payment_type]" value="my_wallet"> <label>My Wallet</label>
		
		<section class="wallet_sec top_sec" style="display:none;">
		<div class="my_wallet">My Wallet <br>
		<strong>Balance</strong>
		</div>
		<label class="wallet_amount">
		<small>Rs.</small>
		<strong class="wall_cur_amt"><?php echo $customer['wallet_current_amount']; ?></strong>	
		</label>
        <?php if($customer['wallet_current_amount']>=$cart['Cart']['TotalAmount']){ ?>	
			<!--<a href="javascript://" id="pay_from_wallet">pay from my wallet</a>-->  
                     
        <?php }else{ ?>        	
        	<div class="infor">You do not have sufficient balance to pay for this transaction. <a href="<?php echo $this->webroot; ?>customers/profile/wallet">Click Here</a> to add funds to your wallet</div>
        
		<?php } ?>
		 </section>
	
	</li>
	 
	<?php }?>
</ul>
</section>
<section class="row2">
<a href="<?php echo $this->webroot;?>recharges/recharge_now">Cancel</a>
<input id="proceed_btn" class="btn_min" type="button" value="Proceed" onclick="checkCouponCode();">
</section>
</form>

</section>
</section><!-- /left section -->

<section class="right_sec">
<section class="detail_box">
  <section class="tab_box">
  <section class="home_box">
  <?php if(isset($payment_page)){
	echo $this->Core->render($payment_page['page_content']);
   }?>  	
   </section>            
</section>
</section>
</section>

<div id="dialog-confirm" title="Confirmation!" style="display:none;">
  <p>you want to continue without using the coupon?</p>
</div>

<script type="text/javascript">
$(document).ready(function(e) {
	
	$('input:checkbox').jqTransCheckBox();
	$('#coupon_option').attr('checked','');
	$('.jqTransformCheckbox').addClass('jqTransformChecked');
	
	$("input[name='data[payment_type]']").click(function(){
		$(".wallet_sec").hide();
		$('#proceed_btn').show();
		var val=$(this).val();
		if(val=='my_wallet'){
			
			$(".wallet_sec").show();
			var cur_balance=$('.wall_cur_amt').html();
			
			if(parseInt(cur_balance)<<?php echo $cart['Cart']['TotalAmount'];?>){
				$('#proceed_btn').hide();
			}
		}else{
			$('#proceed_btn').show();
		}	
	});

    $('#pay_from_wallet').click(function(e) {	
    	checkCouponCode();
        document.getElementById('payment_form').submit();
    });

    
});

function click_event(){	
        console.log($('#coupon_option').attr('checked'));
		
		if($('#coupon_option').is(":checked")){
			console.log('a');
			$("li.coupon_row").show();
		}else{
			console.log('b');
			$("li.coupon_row").hide();
		}		
   
}

function checkCouponCode(){

	if($("#coupon_option").is(":checked")){
		
		$( "#dialog-confirm" ).dialog({
		      resizable: true,
		      modal: true,
		      buttons: {
		        "Yes": function(){
				   $(this).dialog("close");
		           $("form#payment_form").submit();
		          
		        },
		        "No": function() {
		         	$(this).dialog("close");
		          	return false;
		         }
		      }
		});
	}else{
					
		 $("form#payment_form").submit();
		
	}
}

function ajax_complete(data,textStatus){

	if(textStatus=='success'){
		var objData=$.parseJSON(data);
		var status=objData.status;
		var resMsg=objData.message;
		
		if(status==1){

			var discount=status=objData.discount;
			var totalAmount=status=objData.totalAmount;
			$("#coupon_option").removeAttr("checked");
			$("#comment_status").html(resMsg);			
			var dis="<li><strong>Discount</strong>:&nbsp;"+discount+"</li>";
			var tm="<li><strong>Total Amount</strong>:&nbsp;"+totalAmount+"</li>";
			var tm_new="<strong>Total Amount</strong>:&nbsp;"+totalAmount;
			
			var is_total_amount=$('#cart_preview li.total_amount').length;
			
			if(is_total_amount>0){
				$("#cart_preview li.cart_amount").after(dis);
				$("#cart_preview li.total_amount").html(tm_new);	
			}else{
				
				$("#cart_preview li.cart_amount").after(dis+tm);	
			}
			
			
			$("#coupon_form").hide();

			
		}else{
			$("#comment_status").html(resMsg);
		}
	}
		
}

</script>