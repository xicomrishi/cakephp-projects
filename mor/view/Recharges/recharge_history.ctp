<section class="form_sec">
<section class="information_box">
<h3>Transaction History</h3>   
<?php if(isset($Transaction)){?>       
  <ul>
    <li><strong>Service Type</strong>:&nbsp;<?php echo $Transaction['Extra']['ReType'];?></li>
    <li><strong>Number</strong>:&nbsp;<?php echo $Transaction['Extra']['Number'];?></li>
	<li><strong>Service Provider</strong>:&nbsp;<?php echo $Transaction['Extra']['Operator'];?></li>
	<li><strong>Transaction Id</strong>:&nbsp;<?php echo $Transaction['TransactionId'];?></li>
	<li><strong>Payment Id</strong>:&nbsp;<?php echo $Transaction['PaymentId'];?></li>
	<li><strong>Amount</strong>:&nbsp;<?php echo $Transaction['Amount'];?></li>
	<li><strong>Response</strong>:&nbsp;<?php echo $Transaction['TransactionStatus'];?></li>	
 </ul>
<?php }else{?>
<span>Transaction not found.</span>
<?php }?>
<a class="continue" href="<?php echo $this->webroot?>recharges/recharge_now">Continue Recharge..</a>
</section>

</section><!-- /left section -->

<section class="right_sec">
<section class="detail_box">
  <section class="tab_box">
  <section class="home_box">
  <?php if(isset($recharge_history_page)){
	echo $this->Core->render($recharge_history_page['page_content']);
   }?>  	
   </section>            
</section>
</section>
</section>
