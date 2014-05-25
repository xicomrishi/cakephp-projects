
<div id="form_section"  style="margin:0 0 5px 0; padding:0; width:99%">
<div class="select_dele all">/ / Sending <strong>Request...</strong></div>
<div class="img">
<?php echo $this->Html->image('form_left_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
   // $("#msgForm").validationEngine({promptPosition: "topLeft"});
	sendRequestToRecipients('<?php echo $uid; ?>','<?php echo $fb_user; ?>','<?php echo $order['Order']['id']; ?>');
	redirect_to_summary('<?php echo $order['Order']['id']; ?>');
	
});

</script>