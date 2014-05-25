<!-- rechrage form -->
<?php echo $this->Form->create('Contact',array('controller'=>'home','action'=>'contact_us'));?>
<fieldset>
<div id="contact_action_msg"></div>
<ul>
	
   	<li>
	<?php 
	echo $this->Form->input('name', array('type'=>'text','label'=>'Name','value'=>$Customer['Customer']['name']));
	?>
	</li>
	
	<li>
	<?php 
	echo $this->Form->input('email', array('type'=>'email','label'=>'Email',
	'between'=>'<span>*</span>','required'=>true,'value'=>$Customer['Customer']['email']));
	?>
	</li>
	
	<li>
	<?php 
	echo $this->Form->input('phone', array('type'=>'text','label'=>'Phone','value'=>$Customer['Customer']['phone']));
	?>
	</li>
	
	<li>
	<?php 
	echo $this->Form->input('message', array('type'=>'textarea','label'=>'Message','between'=>'<span>*</span>','required'=>true));
	?>
	</li>
	
</ul>
<?php 
$complete=$this->Js->get('#loader_contact')->effect('hide', array('buffer' => false));
$complete.="$('#ContactMessage').val('');";
echo $this->Js->submit('Send',
 	array('url'=>'/home/contact_us',
 	'update' => '#contact_action_msg',
 	'before' => $this->Js->get('#loader_contact')->effect('show', array('buffer' => false)),
	'complete' =>$complete,
 	));
?>
</fieldset>
<?php echo $this->Form->end();
echo $this->Html->image('ajax-loader-5.gif', array('id'=>'loader_contact','style'=>'display:none'));
echo $this->Js->writeBuffer();?>
