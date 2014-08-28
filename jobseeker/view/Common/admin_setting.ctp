<div class="logins dashboard notes">
<div id="succes" class="succes"></div>
	<?php   
	echo $this->Form->create('Common');
	echo $this->Form->input('contact_us_email_key',array('type'=>'hidden','value'=>'contact_us_email'));
	echo $this->Form->input('contact_us_email_id',array('type'=>'hidden','value'=>$Settings['contact_us_email']['id']));
	echo $this->Form->input('contact_us_email_value',array('label'=>'Contact Us Email','value'=>$Settings['contact_us_email']['value']));
	echo $this->Js->submit('Update',array( 'url' => '/common/contact_us_email',
			'update' => '#succes',
			'before' => $this->Js->get('#loader_img')->effect('show', array('buffer' => false)),
			'complete' => $this->Js->get('#loader_img')->effect('hide', array('buffer' => false))));
	echo $this->Html->image('small-ajax-loader.gif', array('id'=>'loader_img','style="display:none"'));		
	echo $this->Js->writeBuffer();
	echo $this->Form->end(); 
 ?>
 
 <?php   
	echo $this->Form->create('Common');
	echo $this->Form->input('footer_copyright_key',array('type'=>'hidden','value'=>'footer_copyright'));
	echo $this->Form->input('footer_copyright_id',array('type'=>'hidden','value'=>$Settings['footer_copyright']['id']));
	echo $this->Form->input('footer_copyright_value',array('label'=>'Footer Copyright','value'=>$Settings['footer_copyright']['value']));
	echo $this->Js->submit('Update',array( 'url' => '/common/footer_copyright',
			'update' => '.succes',
			'before' => $this->Js->get('#loader_img1')->effect('show', array('buffer' => false)),
			'complete' => $this->Js->get('#loader_img1')->effect('hide', array('buffer' => false))));
	echo $this->Html->image('small-ajax-loader.gif', array('id'=>'loader_img1','style="display:none"'));		
	echo $this->Js->writeBuffer();
	echo $this->Form->end(); 
 ?>
</div>
