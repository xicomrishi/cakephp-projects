<div class="submit_left">
<h4><?php echo $popTitle;?></h4>
  <p class="full"><?php echo $check['Checklist']['description']; ?></p>
  </div>
  <div class="submit_right">
  	<div id="opp_error" class="error1"></div>
  	 <form id="strat_textareaForm" name="strat_textareaForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	 <input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
      <input type="hidden" id="field" name="field" value="<?php echo $field;?>"/>
      
       <textarea col="50" rows="5" id="text_area"  name="<?php echo $field; ?>" <?php echo $disabled;?> 
       onfocus="show_val(this.value,'<?php echo $flag; ?>','focus');"
        onblur="show_val(this.value,'<?php echo $flag; ?>','blur');"><?php if($flag==1)
	   		{ 	   
				   if($card_detail['Cardcolumn']['risk_factor']=='')
				   {
					   echo 'I.e., I don\'t have all the skills required for this job.'."\n".'I.e., My education is not up-to-date.'."\n".'I.e., I do not have direct experience for this position.';
					   }else
				  		{
					   		echo $card_detail['Cardcolumn']['risk_factor'];
						}  
		
			}else if($flag==2){  
					if($card_detail['Cardcolumn']['interview_agenda']=='')
					{
						echo "I.e., An opportunity for promotion."."\n"."I.e., Access to contacts."."\n"."I.e., Within my salary range.";
						}else
					{ echo $card_detail['Cardcolumn']['interview_agenda'];
	  						 }
							 
			}else if($flag==3){
								 if($card_detail['Cardcolumn']['process_understand']=='')
								  {
									 echo 'I.e., There will be one more interview and then a candidate will be selected.';
									  }else
	 							  { echo $card_detail['Cardcolumn']['process_understand'];
	  						 }
			}else if($flag==4){
								  if($card_detail['Cardcolumn']['job_promotion']=='')
								  {
									  echo "I.e., There is a 'Future Leaders' program for employees who hope to move to a management position.";
									  }else
								  { 
									 echo $card_detail['Cardcolumn']['job_promotion'];
	  						 		}
								 
								 }?></textarea>
       
       <?php if($disabled==""){?>
           <a href="javascript://" onclick="submit_textareatype();" class="save_btn2">SAVE</a>
      	<?php }?>
      </form>
   
</div>

<script type="text/javascript">
function submit_textareatype()
{
	var text=$('#text_area').val();
	if(text==''||text=='I.e., Is there an opportunity for a job promotion?')
	{
		$('#opp_error').html('Please enter <?php echo $error;?>');	
	}else{
		var check_id=$('#check_id').val();
		$.post('<?php echo SITE_URL;?>/strategies/<?php echo $action;?>',$('#strat_textareaForm').serialize(),function(data) {
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
		
		}	
}
function show_val(val,field,type){
	//alert(val);
	//alert(field);
	//val.replace(/\n/g, "");
	//val.replace(/\r/g, "");
	//alert(val);
	var txt=$('#text_area');
	if(type=='focus')
	{
		switch(field)
		{
			case '2': 
					if(val=='I.e., An opportunity for promotion.\r\nI.e., Access to contacts.\r\nI.e., Within my salary range.')
						txt.val(''); break;
					if(val=='I.e., An opportunity for promotion.\nI.e., Access to contacts.\nI.e., Within my salary range.')	
						txt.val(''); break;		
		}		
	}else{
		switch(field)
		{
			case '2': if(val=='')
						txt.val('I.e., An opportunity for promotion.\r\nI.e., Access to contacts.\r\nI.e., Within my salary range.'); break;
								
		}
		
		
	}
	
	
}
</script>