<div id="form_section" class="payment_option" style="margin:0 0 5px 0; padding:0 1%">

<div class="select_dele">/ / Payment <strong>Detail</strong></div>
<div id="info_msg"></div>
<div class="payment_left">
<div class="con_row"><strong>Gift Cost: INR <?php echo $order['Order']['total_amount']; ?></strong></div>
<div class="con_row">Your expected contribution: INR <?php echo $my_gp['GroupGift']['contri_amount_expected']; ?></div>
<div class="con_row">Redeem Points</div>
<div class="con_row">You have <strong><?php echo $user['User']['points']; ?></strong> points.</div>
<div class="con_row"><a class="done" style="font-size:18px !important; line-height:26px !important; width:28% !important" href="javascript://" onclick="redeem_points('<?php echo $user['User']['points']; ?>','10','<?php echo $user['User']['id']; ?>','<?php echo $order['Order']['id']; ?>');">Redeem Now</a></div>
</div>

<!--<div class="payment_right">
<div class="con_row"><strong>Payment Gateway</strong></div>
</div>-->

</div>


<script type="text/javascript">
function redeem_points(us_point,req_point,us_id,ord_id)
{
	//alert(req_point);
	//alert(us_point);
	//if(parseInt(req_point)>parseInt(us_point))
	//alert(1);
	if(parseInt(req_point)>parseInt(us_point))
	{
		$('#info_msg').html("You don\'t have enough points to redeem.");
		$('#info_msg').show();
		
		setTimeout(function(){$('#info_msg').hide();},5000);
		
	}else{
		$.post('<?php echo SITE_URL; ?>/payment/proceed_points_payment/'+ord_id+'/'+us_id,function(data){
			$('.payment_option').html('Payment Successfull');
			view_order_details(ord_id);
			$.fancybox.close();
		});	
	}
}
</script>
