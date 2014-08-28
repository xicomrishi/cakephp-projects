<div class="settings full-width">
<div class="service_charge">
<?php echo $this->Form->create('ServiceCharge',array('url'=>'/admin/settings/service_charge'));?>
<fieldset>
<legend><?php echo __('Service Charge'); ?></legend>
	<?php
		
		if(!empty($RechargeTypes)){
			foreach($RechargeTypes as $rt){
				
					$filedValue=$rt['RechargeType']['service_charge'];
					if(isset($ReqData)){
						$filedValue=$ReqData['ServiceCharge'][$rt['RechargeType']['id']];
					}
					echo $this->Form->input($rt['RechargeType']['id'],
					array('label'=>$rt['RechargeType']['recharge_type'],'type'=>'text',
					'value'=>$filedValue,'after'=>'<span>(Rs.)</span>'));
			}
			
		}
		?>
	
</fieldset>
<?php echo $this->Form->end(__('Save', true));?>
</div><!-- /service charge -->

</div><!-- /settings -->