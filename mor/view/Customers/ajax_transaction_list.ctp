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
		?></span>
		
		
		</li><?php 
		
	}
	}?>
	
</ul>
<?php 
 if(empty($Recharges)){?>
	<span>No transaction found.</span><?php 
}?>	

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
</div>