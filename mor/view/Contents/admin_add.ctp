<div class="contents form">
<?php echo $this->Form->create('Content'); ?>
	<fieldset>
		<legend><?php echo __('Add Page'); ?></legend>
	<?php
		echo $this->Form->input('page_title');
		echo $this->Form->input('page_slug',array('onfocus'=>'getPageSlug();','size'=>40,'after'=>'&nbsp;(It will be shown in URL.)'));
		echo $this->Form->input('page_sub_title');
		echo $this->Form->input('page_content',array('class'=>'text-editor'));
		echo $this->Form->input('status',array('options'=>array('Publish'=>'Publish','Draft'=>'Draft','Trash'=>'Trash')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Pages'), array('action' => 'index')); ?></li>
	</ul>
</div>
<script type="text/javascript">
function getPageSlug(){
	var str='';
	str+=$("input[name='data[Content][page_title]']").val().replace(/ /g,"_");
	$("input[name='data[Content][page_slug]']").val(str.toLowerCase());

}
</script>
