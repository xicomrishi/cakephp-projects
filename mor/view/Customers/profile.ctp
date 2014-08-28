<section class="form_sec">
<div class="ajax_loader" style="display:none; vertical-align: text-top;">
<img src="<?php echo $this->webroot;?>img/ajax-loader-5.gif"/>&nbsp;Processing...</div>
<div id="recharge_form">
<?php echo $this->requestAction('/recharges/get_recharge_form/1');?>
</div>
</section>

<section class="right_sec">
<section class="detail_box">
<span class="toggle"><a href="#"></a></span>
<ul class="tab">
	<li class="active"><a href="javascript://" class="home"><span>Home</span></a></li>
    <li><a href="javascript://" class="recharge"><span>recharge history</span></a></li>
    <li><a href="javascript://" class="wallet" onclick="get_my_wallet();"><span>my wallet</span></a></li>
	<li><a href="javascript://" class="account"><span>account info</span></a></li>
	
	  
</ul>
<section class="tab_box">
<section class="home_box">
<?php if(isset($profile_home_content)){
	echo $this->Core->render($profile_home_content['page_content']);
}?>

</section>
</section>

<!-- transaction tab -->
<section class="tab_box" style="display:none">
<section class="recharge_box">
<div  id="list_wrapper">
<ul>
	<li class="first"><strong>date</strong> <strong>Number</strong> <strong>Operator</strong>
	<strong>Order #</strong> <strong>Amount(r<small>s</small>.)</strong><strong  class="last">Status</strong>
	</li>
	<?php if(!empty($Recharges)){
	foreach($Recharges as $recharge){?>
		<li><span><?php if(!empty($recharge['Recharge']['payment_date']) && $recharge['Recharge']['payment_date']!='0000-00-00 00:00:00'){ echo $this->Time->format('Y-m-d',$recharge['Recharge']['payment_date']);}?></span>
		<span><?php echo $recharge['Recharge']['number'];?></span>
		<span class="net"><?php echo $recharge['Operator']['name'];?></span>
		<span><?php echo $recharge['Recharge']['transaction_id'];?></span>
		<span><?php echo $recharge['Recharge']['amount'];?></span>
		<span class="last">
		<?php if($recharge['Recharge']['recharge_payment_status']==1 && $recharge['Recharge']['recharge_status']==1){
			echo 'success';
					
		}elseif($recharge['Recharge']['recharge_payment_status']==1 && $recharge['recharge_status']==0){
			echo 'processing';
			      					
		}else{
			echo 'failed';
		}
		?></span></li>	
	<?php 
		
	}
	}?>
	
</ul>
<?php 
 if(empty($Recharges)){?>
	<span>No transaction found.</span><?php 
}else{?>
	<?php 
	if(!isset($url)){
		//$url=array('controller'=>$this->params['controller'],'action'=>$this->params['action']);
		$url=$this->passedArgs;
	}
	$this->Paginator->options(
	        array('url'=>$url,        
	        'update'=>'#list_wrapper',
	        'before' => $this->Js->get('#paging_loader')->effect('fadeIn', array('speed' => 'fast')),
	    	'complete' => $this->Js->get('#paging_loader')->effect('fadeOut', array('speed' => 'fast')),
	        'data'=>http_build_query($this->request->data),
	        'method'=>'POST'
	        ));
	?>
	<img alt="Loading" id="paging_loader" style="display:none;" src="<?php echo $this->webroot;?>img/ajax-loader-5.gif"/>
	<ul class="pagination">
	<?php
	echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled','tag'=>'li','disabledTag' => 'a'));
	echo $this->Paginator->numbers(array('separator' => '','tag'=>'li','currentClass' => 'active','currentTag' => 'a'));
	echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled','tag'=>'li','disabledTag' => 'a'));
	echo $this->Js->writeBuffer(); 
	?>
	</ul>
<?php }?>
</div>
</section>
<section class="bottom_row">
<a class="_help_content" href="<?php echo $this->webroot;?>contents/page/help_and_support">Need support?</a>
<!-- used in href for open contact form: #need_support-->
</section>
</section>

<!-- /transaction tab -->

<!-- wallet tab -->
<section class="tab_box"
	style="display:none">
<section class="wallet_box">
<!--<h4>my wallet transaction</h4>-->
<section class="balance_sec">
<div class="left_detail" style="width:35%; float:left">
<small>my wallet <strong>balance</strong></small>
<section class="wallet_content">
<span>Rs.</span>
<strong><?php echo $Customer['Customer']['wallet_current_amount']; ?></strong>
</section>
</div>
<div class="right_detail" style="width:27%; float:left">
<?php echo $this->Form->create('WalletRecharge',array('method'=>'post','url'=>array('controller'=>'recharges','action'=>'payment_wallet'))); ?>
<input type="text" name="wallet_recharge_amount" placeholder="Amount" class="required"/>
<select name="wallet_recharge_type" class="required">
	
	<option value="net_banking">Net Banking</option>
	<option value="credit_card">Credit Card</option>
	<option value="debit_card">Debit Card</option>
</select>
<input type="submit" value="Add Cash to Wallet"/>
<?php echo $this->Form->end(); ?>
</div>
</section>


<section class="transaction_detail">
<img alt="Loading" id="paging_loader" src="<?php echo $this->webroot;?>img/ajax-loader-5.gif"/>

</section>
</section>

<section class="bottom_row">
<a class="help_content" href="#what_is_my_wallet">What is my wallet?</a>
<a class="help_content" href="#how_to_add_fund">how to add funds?</a>
<a class="_help_content" href="<?php echo $this->webroot;?>contents/page/help_and_support">Need support?</a>
</section>
</section>
<!-- /wallet tab -->

<!-- profile tab -->
<section class="tab_box"
	style="display:none">
<section class="account_box">
<section class="common_box">
<h4>Profile</h4>
<?php echo $this->Form->create('Customer',array('action'=>'edit_profile', 'default' => false));?>
<div id="action_msg"></div>	 	
<ul>
	<li><small><img src="<?php echo $this->webroot;?>img/frontend/ic1.png"></small> <span>
	<input name="data[Customer][name]" 
		type="text" value="<?php if(!empty($Customer['Customer']['name'])){echo $Customer['Customer']['name'];}else{echo "Name";}?>"
		onFocus="if(this.value=='Name'){this.value=''}"
		onBlur="if(this.value==''){this.value='Name'}"></span></li>
	<li><small><img src="<?php echo $this->webroot;?>img/frontend/ic2.png"></small> <span>
	<input name="data[Customer][email]"  readonly="readonly"
		type="text" value="<?php if(!empty($Customer['Customer']['email'])){echo $Customer['Customer']['email'];}else{echo "Email";}?>"
		onFocus="if(this.value=='Email'){this.value=''}"
		onBlur="if(this.value==''){this.value='Email'}"></span></li>
	<li><small><img src="<?php echo $this->webroot;?>img/frontend/ic3.png"></small> <span>
	<input name="data[Customer][phone]" 
		type="text" value="<?php if(!empty($Customer['Customer']['phone'])){echo $Customer['Customer']['phone'];}else{echo "Mobile No";}?>"
		onFocus="if(this.value=='Mobile No'){this.value=''}"
		onBlur="if(this.value==''){this.value='Mobile No'}"></span></li>
	<li><small><img src="<?php echo $this->webroot;?>img/frontend/ic4.png"></small> <span>
	<input  name="data[Customer][address]" 
		type="text" value="<?php if(!empty($Customer['Customer']['address'])){echo $Customer['Customer']['address'];}else{echo "Area";}?>"
		onFocus="if(this.value=='Area'){this.value=''}"
		onBlur="if(this.value==''){this.value='Area'}"></span></li>
	<li><small><img src="<?php echo $this->webroot;?>img/frontend/ic5.png"></small> <span>
	<input name="data[Customer][city]" 
		type="text" value="<?php if(!empty($Customer['Customer']['city'])){echo $Customer['Customer']['city'];}else{echo "City";}?>"
		onFocus="if(this.value=='City'){this.value=''}"
		onBlur="if(this.value==''){this.value='City'}"></span></li>
	<li><small><img src="<?php echo $this->webroot;?>img/frontend/ic6.png"></small> <span
		class="state">
		
		 <select name="data[Customer][state]" >
			 <option value="0">State</option>
			 <?php if(isset($States)){
			 foreach($States as $state){?>
			
				<option value="<?php echo $state['State']['state_id'];?>"
			 <?php if($state['State']['state_id']==$Customer['Customer']['state_id']){?> selected="selected"<?php }?>><?php echo $state['State']['state_name']?></option>
			<?php }
			 }?>
		</select>
	 </span>
	 </li>
</ul>

<?php echo $this->Js->submit('Save',
 	array('url'=>'/customers/edit_profile',
 	'update' => '#action_msg',
 	'before' => $this->Js->get('#loader')->effect('show', array('buffer' => false)),
	'complete' => $this->Js->get('#loader')->effect('hide', array('buffer' => false)),
 	));
?>
<?php echo $this->Form->end();
echo $this->Html->image('ajax-loader-5.gif', array('id'=>'loader','style'=>'display:none'));
echo $this->Js->writeBuffer();
?>
</section>
<section class="common_box pass">
<h4>password</h4>
<?php echo $this->Form->create('Customer',array('action'=>'change_password', 'default' => false,'autocomplete'=>'off'));?>
<div id="pass_action_msg"></div>	 
<ul>
	<li><small><img src="<?php echo $this->webroot;?>img/frontend/lock.png"></small> <span>
	<input name="data[Customer][old_password]"
		type="password" placeholder="Old Password"></span></li>
	<li><small><img src="<?php echo $this->webroot;?>img/frontend/lock.png"></small> <span>
	<input name="data[Customer][password]"
		type="password" placeholder="New Password"></span></li>
	<li><small><img src="<?php echo $this->webroot;?>img/frontend/lock.png"></small> <span>
	<input name="data[Customer][confirm_password]"
		type="password" placeholder="Confirm Password"></span></li>
</ul>

<?php 
$complete=$this->Js->get('#loader_pass')->effect('hide', array('buffer' => false));
$complete.="$('input[type=\'password\']').val('');";
echo $this->Js->submit('Save',
 	array('url'=>'/customers/change_password',
 	'update' => '#pass_action_msg',
 	'before' => $this->Js->get('#loader_pass')->effect('show', array('buffer' => false)),
	'complete' =>$complete,
 	));
?>
<?php echo $this->Form->end();
echo $this->Html->image('ajax-loader-5.gif', array('id'=>'loader_pass','style'=>'display:none'));
echo $this->Js->writeBuffer();
?>
</section>
</section>
</section>
<!-- /profile tab -->







</section>



</section>

<!-- what is wallet  -->
<div style="display:none">
<div id="what_is_my_wallet" class="fancy_box_content">
<?php if(isset($what_is_my_wallet)){
	echo $this->Core->render($what_is_my_wallet['page_content']);
}?>
</div>
</div>
<!-- /what is wallet  -->

<!-- how to add wallet  -->
<div style="display:none">
<div id="how_to_add_fund" class="fancy_box_content">
<?php if(isset($how_to_add_fund)){
	echo $this->Core->render($how_to_add_fund['page_content']);
}?>
</div>
</div>
<!-- /how to add wallet -->


<!-- need support  -->
<div style="display:none">
<div id="need_support" class="fancy_box_content">
<?php echo $this->element('contact_form');?>
</div>
</div>
<!-- /need support -->


<script type="text/javascript">

$(document).ready(function(e) {
	
    <?php if(isset($tab) && $tab=="wallet"){ ?>	
		get_my_wallet();
		$('ul.tab li').removeClass('active');
		$('.detail_box ul.tab li').eq(2).addClass('active');
		 $('.detail_box .tab_box').hide();
   		 $('.detail_box .tab_box').eq(2).show();
	<?php } ?>
	
});
function get_my_wallet(){
	jQuery.post('<?php echo $this->webroot; ?>customers/get_my_wallet',function(data){
		jQuery('.transaction_detail').html(data);
	});	
}

jQuery(function(){
	
	jQuery(".help_content").fancybox({
			scrolling : 'no',
			padding : 5,
		    margin : 100			
	}); 		
	
});



</script>
