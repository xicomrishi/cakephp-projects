<div class="wrapper">
  <section id="content">
  
<div class="row">
  
<div class="span12">
<h1>Contact Us</h1>
</div>

<div class="contact_us">
<section class="contact_left">
<form action="<?php echo $this->webroot;?>contacts" class="contactForm" name="contactForm" method="post">
<?php echo $this->Session->flash();?> 
<fieldset>
<p>Please enter your message</p>
<div class="comn_row">
<label>First name<span>*</span></label>
<input type="text" placeholder="First Name" class="first_name validate[required]" data-errormessage-value-missing="Please enter first name" name="FirstName">
</div>

<div class="comn_row">
<label>Last name<span>*</span></label>
<input type="text" placeholder="Last Name" class="last_name validate[required]" data-errormessage-value-missing="Please enter last name" name="LastName">
</div>

<div class="comn_row">
<label>Email address<span>*</span></label>
<input type="text" placeholder="Email" class="email validate[required,custom[email]]" data-errormessage-value-missing="Please enter email id" data-errormessage="Please enter valid email id" name="Email">
</div>

<div class="comn_row">
<label>Your message</label>
<textarea cols="0" rows="0" name="Message"></textarea>
</div>

<div class="comn_row">
<label>&nbsp;</label>
<input class="submit_btn" type="submit" value="Submit">
</div>

</fieldset>
</form>
</section>

<section class="contact_right">
<img src="<?php echo $this->webroot;?>img/Capture.png" alt="" >
</section>
</div>

</div>

  </section>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
       jQuery(".contactForm").validationEngine('attach',{promptPosition: "bottomLeft",scroll: false});
	   
	   $('input[type="text"],input[type="email"]').each(function() {
		 if($(this).val()!='')
				 $(this).validationEngine().css({'background-color' : "#FAFFBD"});
				 
		
	  });
	  
	  $( 'input[type="text"],input[type="email"]' ).focus(function() {
		$(this).validationEngine('hide');
		$(this).validationEngine().css({border : "1px solid #D5D0D0"});
		});
			 $( 'input[type="text"],input[type="email"]' ).blur(function() {
				 
				var error=$(this).validationEngine('validate');
				
				if(error){
				$(this).validationEngine().css({border : "1px solid red"});
			 }else{
				 if($(this).val()!='')
				 $(this).validationEngine().css({'background-color' : "#FAFFBD"});
				 
			 }
			 });
});
</script>