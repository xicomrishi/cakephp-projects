<style>
.cke_chrome { width:70%; margin-left:166px;}
</style>
<div class="cmses form">
<?php echo $this->Form->create('Cmse'); ?>
	<fieldset>
		<legend><?php echo __('Edit Page'); ?></legend>
	<?php
		echo $this->Form->input('page_id');
		echo $this->Form->input('page_title');
		echo $this->Form->input('page_slug',array('onfocus'=>'getPageSlug();','size'=>50,'after'=>'&nbsp;(It will be shown in URL.)'));
		echo $this->Form->input('page_sub_title');
		echo $this->Form->input('page_content',array('class'=>'ckeditor'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Cmse.page_id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Cmse.page_id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Pages'), array('action' => 'index')); ?></li>
	</ul>
</div>
<script type="text/javascript">
function getPageSlug(){
	var str='';
	str+=$("input[name='data[Cmse][page_title]']").val().replace(/ /g,"_");
	$("input[name='data[Cmse][page_slug]']").val(str.toLowerCase());

}
</script>
