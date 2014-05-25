<!-- finder sec start -->
<div class="finder_sec"> <a href="javascript://" onclick="show_feedback();" class="link"><?php echo $this->Html->image('feedback.png',array('div'=>false,'escape'=>false));?></a> </div>
<!-- finder sec end --> 

<!-- finder details start -->
<div class="finder_details">
  <div class="details">
   <div id="success_message" class="success" style="display:none;">Message sent successfully.</div>
 <form id="contact_usForm" name="contact_usForm" action="" method="post">
  <fieldset>
  <span class="row">
  <label style="width:auto !important">Name<small>*</small></label>
  <input type="text" name="name" class="input required" value=""></span>
  <span class="row">
  <label style="width:auto !important">Email<small>*</small></label>
  <input type="text" name="email" class="input required email" value=""></span>
  <span class="row">
  <label style="width:auto !important">Message<small>*</small></label>
  <textarea rows="0" cols="0" name="message" class="required"></textarea></span>
  <span class="row">
  <input type="submit" value="send" class="submit"></span>
  <p>Please feel free to get in touch, we value your feedback</p>
  </fieldset>
  </form>
  </div>
</div>
<!-- finder details end --> 

 <script type="text/javascript">
 var feedback=0;

 $(document).ready(function(e) {
    $('#contact_usForm').validate({
		submitHandler: function(form) {
			$.post('<?php echo SITE_URL;?>/info/contact_us_submit',$('#contact_usForm').serialize(),function(data){
						$('#success_message').show();
						setTimeout(function(){ $('#success_message').fadeOut('fast');},2000);
						document.getElementById('contact_usForm').reset();
						
				});	
		}
		
	});
});

function show_feedback()
{
	document.getElementById('contact_usForm').reset();
	if(feedback==0)
	{
	$('.finder_sec').addClass('active');
	$('.finder_details').show();
	feedback=1;	
	}else{
		$('.finder_sec').removeClass('active');
			$('.finder_details').hide();
			feedback=0;		
		}
}


</script>
