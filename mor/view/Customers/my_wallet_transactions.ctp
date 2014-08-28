<ul id="wl_list">
	<li class="first"><strong>date</strong>
	<small>transaction</small><strong>wallet balance</strong></li>
    <?php if(!empty($arr)){ 
			foreach($arr as $wt){ 
	?>
		<li><strong><?php echo date("d-m-Y",strtotime($wt['Wallet']['date'])); ?></strong>
		<small>
        <?php 
			if($wt['Wallet']['type']=='Credit' && $wt['Wallet']['refund']=='Yes'){
				echo 'Refund of failed recharge '.$wt['Recharge']['number'].', Rs.'.$wt['Wallet']['amount'];
			}else if($wt['Wallet']['type']=='Credit' && !empty($wt['Wallet']['payment_id'])){ 
				echo 'Rs.'.$wt['Wallet']['amount'].' added to wallet.';
			}else if($wt['Wallet']['type']=='Credit' && empty($wt['Wallet']['payment_id'])){
				echo 'Failed Transaction - Rs.'.$wt['Wallet']['amount'].' funds to wallet.';
			}else if($wt['Wallet']['type']=='Debit' && $wt['Wallet']['payment_mode']=='Wallet'){ 
				echo 'Recharge '.$wt['Recharge']['number'].', Rs.'.$wt['Wallet']['amount'];
			}?></small>
            <strong><?php if(!empty($wt['Wallet']['wallet_current_amount'])) echo 'Rs.'.$wt['Wallet']['wallet_current_amount']; else echo 'n/a'; ?></strong>
            </li>
          
    <?php }}else{ 	?>
    	<li><small>No Wallet Transactions</small></li>
    <?php } ?>

</ul>
<?php
$this->Paginator->options(
	        array(        
	        'update'=>'.transaction_detail',
	        'before' => $this->Js->get('#paging_loader2')->effect('fadeIn', array('speed' => 'fast')),
	    	'complete' => $this->Js->get('#paging_loader2')->effect('fadeOut', array('speed' => 'fast')),
	        //'data'=>http_build_query($this->request->data),
	        'method'=>'POST'
	        ));
	?>
	<img alt="Loading" id="paging_loader2" style="display:none;" src="<?php echo $this->webroot;?>img/ajax-loader-5.gif"/>
	<ul class="pagination">
	<?php
	echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled','tag'=>'li','disabledTag' => 'a'));
	echo $this->Paginator->numbers(array('separator' => '','tag'=>'li','currentClass' => 'active','currentTag' => 'a'));
	echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled','tag'=>'li','disabledTag' => 'a')); ?>
    </ul>
 <?php  
	echo $this->Js->writeBuffer(); 
	?>
