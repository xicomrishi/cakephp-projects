<div class="settings full-width">
<div class="service_charge">
<?php echo $this->Form->create('Setting',array('action'=>'change_recharge_option', 'default' => false,'autocomplete'=>'off'));?>
<div id="action_msg"></div>	 
<?php 
echo $this->Form->input('recharge_option',
	array('label'=>'Recharge Option','options'=>array('Active'=>'Active','Inactive'=>'Inactive'),'value'=>@$Settings['Setting']['value']));

echo $this->Js->submit('Save',
 	array('url'=>'/admin/settings/change_recharge_option',
 	'update' => '#action_msg',
 	'before' => $this->Js->get('#loader')->effect('show', array('buffer' => false)),
	'complete' =>$this->Js->get('#loader')->effect('hide', array('buffer' => false)),
 	));
?>
<?php echo $this->Form->end();
echo $this->Html->image('ajax-loader-5.gif', array('id'=>'loader','style'=>'display:none'));
echo $this->Js->writeBuffer();
?>
</div><!-- /service charge -->

</div><!-- /settings -->