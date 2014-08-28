<div class="gallery form">
<?php echo $this->Form->create('Coupon'); ?>
	<fieldset>
		<legend><?php echo __('Edit Coupon'); ?></legend>
	<?php
		$sType=array(0=>'Select Service Type');		
		if(isset($RechargeTypes)){
			foreach($RechargeTypes as $id=>$stype){		
				$sType[$id]=$stype;
			}
		}
		
		$selVal=explode(',', $this->Form->value('recharge_type_id'));
		
		echo $this->Form->input('recharge_type_id',array('options'=>$sType,'multiple'=>true,
		'selected'=>$selVal,'style'=>'width:250px',
		'after'=>'<span>The coupon will be applied for selected service types only.</span>'));
		
		echo $this->Form->input('coupon_code',array('type'=>'text'));
		echo $this->Form->input('coupon_description',array('type'=>'textarea'));
		echo $this->Form->input('coupon_price',array('type'=>'text'));
	
		echo $this->Form->input('start_date',array('type'=>'text','class'=>'datepicker','after'=>'<span>&nbsp;The coupon will be valid from this date.</span>'));
		echo $this->Form->input('end_date',array('type'=>'text','class'=>'datepicker','after'=>'<span>&nbsp;The coupon will be valid to this date.</span>'));
		echo $this->Form->input('min_amount',array('type'=>'text','after'=>'<span>&nbsp;The coupon will be valid on (>=) amount.</span>'));
		echo $this->Form->input('max_uses',array('type'=>'text','after'=>'<span>&nbsp;Maximum number of uses.</span>'));
		echo $this->Form->input('coupon_status', array('options'=>array('Active'=>'Active','Inactive'=>'Inactive')));
		
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
	     <li><?php echo $this->Html->link(__('Back to Coupon List'), array('action' => 'list_coupon')); ?></li>
    </ul>
</div>