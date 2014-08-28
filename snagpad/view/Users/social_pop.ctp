<div class="pop_up_detail" style="padding:49px 0">
<form action="#">
<div class="sign_up_row" style="border-right:1px dashed #999; width:398px">
<h3>Connect Your SnagPad Profile<br>to</h3>
<?php if(empty($client['Client']['profile_id'])){?>
<?php echo $this->Html->link($this->Html->image('facebook_btn1.png', array('alt' => 'Facebook Login', 'border' => '0')), 'javascript:myfunc();', array('escape' => false, 'class' => 'facebook_btn')); ?>
<?php }else{ 
 echo $this->Html->image('facebook_btn1_visited.jpg',array('escape'=>false,'alt'=>'Facebook Login'));
 } ?>
</div>

<div class="sign_up_row">
<h3>Connect Your SnagPad Profile<br>to</h3>
 <?php if(empty($client['Client']['linkedin_id'])){?>
  <?php echo $this->Html->link($this->Html->image('linkedin_btn1.png', array('alt' => 'Linkedin Login', 'border' => '0')), array('controller'=>'linkedin','action'=>'auth'), array('escape' => false, 'class' => 'linkedin_btn')); ?>
  <?php }else{ 
  	 echo $this->Html->image('linkedin_btn1_visited.png',array('escape'=>false,'alt'=>'Linkedin Login'));
   } ?>
</div>  
</form>
</div>  
  
  
  <script type="text/javascript">
  $(document).ready(function(e) {
	$("html, body").animate({ scrollTop: 0 }, 600);
  });
function myfunc() {
  FB.login(function(response) {
    window.location.href='<?php echo SITE_URL;?>/users/fblogin/';
  }, {scope:'email,read_mailbox,publish_stream,user_work_history,friends_work_history,user_location,friends_location,user_education_history,friends_education_history,offline_access'});
}

</script>
  
  