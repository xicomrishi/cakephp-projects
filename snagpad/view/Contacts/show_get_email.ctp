<section class="submit_right" style="border:0px;">
<div id="msg2" class="success2" style="margin:0 0 0 -100px"></div>
    <form id="import_contact_form" name="import_contact_form" action="" method="post">
        <ul class="indexSkills1" style="height:auto; text-align:left">
            <li style=" text-align:left !important;  width:100% !important">
                <div id="div_error" style="color:#ff0000"></div>
                 <div class="rowdd"><label>Select Email Provider: </label>
                 <select name='email_provider' style="width:249px;">
                 	<option value="gmail">Gmail</option>
                    <option value="yahoo">Yahoo</option>
                    <option value="hotmail">Hotmail</option>
                 </select></div>
                  <div class="rowdd">
                  	<label>Username: </label>
                    <input type="text" id="username_email" class="required email input" style="margin:0px;" value="example@gmail.com" name="username" onBlur="if(this.value=='')this.value='example@gmail.com'" onFocus="if(this.value=='example@gmail.com')this.value=''"/>
                   </div> 
                   <div class="rowdd">
                  	<label>Password: </label>
                    <input type="password" class="required input" style="margin:0px;" name="password"/>
                   </div> 
                   <div class="rowdd">
                  	
                    <input type="submit" class="submitbtn" value="Import"/>
                   </div>  
              </li>
          </ul>
        </form>
     </section>  
<script type="text/javascript">
$(document).ready(function(e) {
    $('#import_contact_form').validate({
		submitHandler: function(form) {
			
				$.post('<?php echo SITE_URL; ?>/contacts/email_connect',$('#import_contact_form').serialize(),function(data){
						//alert(data);
						$('.contact_section').html(data);	
						disablePopup();
					});
					return false;
		}
			
		});	
});

		

</script>   