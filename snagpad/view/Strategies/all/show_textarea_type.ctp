<div class="submit_left">
<h4><?php echo $popTitle;?></h4>
  <p class="full"><?php echo $check['Checklist']['description']; ?></p>
  </div>
  <?php if($check['Checklist']['video']){ ?> 
  <div class="video">
  <?php echo $this->Html->link($this->Html->image('VideoLogo.png', array('alt' =>'View Video', 'border' => '0')), 'Javascript://', array('escape' => false, 'class' => 'logo','onClick'=>'viewStrategyvideo('.$check['Checklist']['id'].')')); ?>
  </div>
  <?php } ?>
  <div class="submit_right">
  	<div id="opp_error" class="error1"></div>
  	 <form id="strat_textareaForm" name="strat_textareaForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	 <input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
      <input type="hidden" id="field" name="field" value="<?php echo $field;?>"/>
      
       <textarea col="50" rows="5" id="text_area"  name="<?php echo $field; ?>" <?php echo $disabled;?> 
       onfocus='if(this.value=="<?php if($flag==1) { echo 'I.e., I don&#39;t have all the skills required for this job.'.'\n'.'I.e., My education is not up-to-date.'.'\n'.'I.e., I do not have direct experience for this position.'; }
	   if($flag==2){ echo 'I.e., An opportunity for promotion.'.'\n'.'I.e., Access to contacts.'.'\n'.'I.e., Within my salary range.'; }
	   if($flag==3){ echo 'I.e., There will be one more interview and then a candidate will be selected.';}
	   if($flag==4){ echo "I.e., There is a &#39;Future Leaders&#39; program for employees who hope to move to a management position.";}
	    ?>") { this.value=""; this.className="normal_txt"; }  return false;'
        onblur='if(this.value==""){ this.value="<?php if($flag==1){ echo 'I.e., I don&#39;t have all the skills required for this job.'.'\n'.'I.e., My education is not up-to-date.'.'\n'.'I.e., I do not have direct experience for this position.';}
		if($flag==2){ echo 'I.e., An opportunity for promotion.'.'\n'.'I.e., Access to contacts.'.'\n'.'I.e., Within my salary range.';}
		 if($flag==3){ echo 'I.e., There will be one more interview and then a candidate will be selected.';}
		
		if($flag==4){ echo "I.e., There is a &#39;Future Leaders&#39; program for employees who hope to move to a management position.";}
		?>"; this.className="autofill_txt";} return false;'><?php if($flag==1)
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
						echo 'I.e., An opportunity for promotion.'."\n".'I.e., Access to contacts.'."\n".'I.e., Within my salary range.';
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
		var frm1=$('#strat_textareaForm').serialize();
	$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
		$.post('<?php echo SITE_URL;?>/strategies/<?php echo $action;?>',frm1,function(data) {
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
		
		}	
}
</script>