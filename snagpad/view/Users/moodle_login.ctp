<?php
header('X-Frame-Options: GOFORIT'); 
?>
<style>
#region-pre{ display:none;}
</style>
<div class="pop_up_detail" style="padding:49px 0">
<form name="moodleForm" action="http://www.moodle.snagpad.com/login/index.php" method="post" target="myframe">
<input type="hidden" value="<?php echo $this->Session->read('Client.Client.email');?>"  name="username">
<input type="hidden" id="cr_val" value="4"  name="cr_id">
<input  type="hidden" value="<?php echo $this->Session->read('Client.Client.email');?>" name="password">
<div class="sign_up_row" style="border-right:1px dashed #999; width:398px">
<h3><a href="javascript://" onclick="sub_form(4);">Social Capital Developement <?php echo $this->Html->image('scbCourseImg.jpg',array('escape'=>false,'alt'=>'','div'=>false));?></a> </h3>
</div>
<div class="sign_up_row">
<h3><a href="javascript://" onclick="sub_form(3);">Strategic Job Search Management <?php echo $this->Html->image('searchManageImg.jpg',array('escape'=>false,'alt'=>'','div'=>false));?></a> </h3>
</div>
</form>
</div> 
<iframe name="myframe" id="moodle_iframe" style="display:none;" frameborder="0" height="600" width="100%"></iframe>
<script type="text/javascript">
 $(document).ready(function(e) {
	$("html, body").animate({ scrollTop: 0 }, 600);
  });
function sub_form(cr_id)
{
	$('#cr_val').val(cr_id);
	$('.pop_up_detail').hide();
	$('#moodle_iframe').show();
	document.moodleForm.submit();	
}
</script>