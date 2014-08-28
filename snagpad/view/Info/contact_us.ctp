<section class="tabing_container">

        <section class="tabing" style="margin:12px 0 0 0">
          <ul class="gap">
           
            <li class="active"><a>CONTACT US</a></li>
          	
          </ul>
        </section>
<section class="cms_page_detail">
<div class="online_training">
       <p>Have a question, comment or suggestion? Fill out the form and someone will get back to you.</p>
       <div id="success_message" class="success" style="display:none;">Message sent successfully.</div>
       <form id="contact_usForm" name="contact_usForm" action="" method="post">
       <div class="row">
       <label>Name : </label>
       <input type="text" name="name" class="input required" value=""/>
       </div>
       <div class="row">
       <label>Email : </label>
        <input type="text" name="email" class="input required email" value=""/>
        </div>
        <div class="row">
        <label>Message : </label>
        <textarea name="message" class="input required" style="min-height:140px"></textarea>
        </div>
        <div class="row">
        <label>&nbsp;</label>
        <input type="submit" value="Send" class="botton"/>
        <input type="reset" value="Reset" class="botton"/>
        </div>
      </form>
       </div>
       </section>
       </section>
 <script type="text/javascript">
 $(document).ready(function(e) {
    $('#contact_usForm').validate({
		
		submitHandler: function(form) {
			$.post('<?php echo SITE_URL;?>/info/contact_us_submit',$('#contact_usForm').serialize(),function(data){
						$('#success_message').show();
						setTimeout(function(){ $('#success_message').hide();},2000);
				});	
		}
		
	});
});
 </script>      