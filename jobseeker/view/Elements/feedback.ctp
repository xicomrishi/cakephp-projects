<div class="feedback">
	<a href="#" class="request" id="btn_feedback"></a>
    <div class="feed_area hover_card" style="display:none;" id="wnd_feedback">
    	<div class="details">
        <div id="commentStatus">

			</div>
			<h3>We would love to hear your feedback.</h3>
 			<div style="float:left;width:100%" id="succes"></div>
			<form accept-charset="utf-8" method="post" id="TestimonialIndexForm" onSubmit="return submitFeedback();" class="feedbackForm" action="#" name="feedbackForm">
            <fieldset>
            	<!--<div style="display:none;">
                	<input type="hidden" value="POST" name="_method">
                </div>-->
                <div class="row required">
                    	<label for="TestimonialName">Name</label>
                        <input type="text" id="TestimonialName" maxlength="255" class="input feedbackColumn validate[required]" name="Name" data-errormessage-value-missing="Please enter name">
                    </div>	
                 <div class="row required">
                    	<label for="TestimonialEmail">Email</label>
                    	<input type="text" id="TestimonialEmail" maxlength="255" class="input feedbackColumn validate[required,custom[email]]" name="Email" data-errormessage-value-missing="Please enter email id" data-errormessage="Please enter valid email id">
                    </div>
                 <div class="row required">
                        <div class="radio">
                            <input type="radio" value="Feedback" class="validate[required] radio" name="requestType" data-errormessage-value-missing="Please select an option">
                            <label for="BetterGenderMale">Feedback</label>
                            <input type="radio" value="Feature Request" class="validate[required] radio" name="requestType" data-errormessage-value-missing="Please select an option">
                            <label for="BetterGenderFemale">Feature Request</label>
                        </div>   
                    </div>
                 <div class="row">
                    	<label for="TestimonialMessage">Message</label>
                        <textarea id="TestimonialMessage" rows="6" cols="30" name="Message"></textarea></div>
                 <div class="row">
                    <label>&nbsp;</label>
                 	<input type="submit" value="Submit" class="submit">
                 </div>
                 <img alt="" style="display:none" id="loader_opt" src="<?php echo $this->webroot;?>img/ajax-loader.gif"/>
             </fieldset>
            </form>
        </div>
	</div>
       
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
       jQuery("#TestimonialIndexForm").validationEngine('attach',{promptPosition: "bottomLeft",scroll: false});
	   
	   $('.feedbackColumn').each(function() {
		 if($(this).val()!='')
				 $(this).validationEngine().css({'background-color' : "#FAFFBD"});
				 
		
	  });
	  
	  $( '.feedbackColumn' ).focus(function() {
		$(this).validationEngine('hide');
		$(this).validationEngine().css({border : "1px solid #D5D0D0"});
		});
			 $( '.feedbackColumn' ).blur(function() {
				 
				var error=$(this).validationEngine('validate');
				
				if(error){
				$(this).validationEngine().css({border : "1px solid red"});
			 }else{
				 if($(this).val()!='')
				 $(this).validationEngine().css({'background-color' : "#FAFFBD"});
				 
			 }
			 });
});

function submitFeedback()
{
	var validate = $("#TestimonialIndexForm").validationEngine('validate');
	 if(validate){
	$('#commentStatus').html('');
	$('#loader_opt').show();
	
	
	$.post('<?php echo $this->webroot;?>cmses/submit_feedback',$('#TestimonialIndexForm').serialize(),function(data){
	$('#loader_opt').hide();
	
	var res = data.split(',');
	
	$('#commentStatus').html(data);	
	document.getElementById("TestimonialIndexForm").reset();
	 $('.feedbackColumn').css({'background-color' : "#ffffff"});
	setTimeout(function() {
				window.location='<?php echo $this->request->here;?>';
		}, 2000);
	
	});
	
	 }
	
		
return false;
}
</script>