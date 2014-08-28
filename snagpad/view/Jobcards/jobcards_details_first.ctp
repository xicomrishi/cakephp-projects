<div class="nano">
<div class="strategy_pop_up" style="height:186px !important; width:100%">
  <form id="cardDetailForm" name="cardDetailForm" method="post" action="">
  <fieldset>
  <input type="hidden" id="card_id" value="<?php echo $card['Card']['id'];?>"/>
  <section class="form_section">
  <section class="form_box">
  <section class="form_row"><label>Company name</label><b class="click_company" id="company_name|<?php echo $card['Card']['id'];?>"><?php echo $card['Card']['company_name']; ?></b></section>
  <section class="form_row"><label>Position available</label><b class="click_position" id="position_available|<?php echo $card['Card']['id'];?>"><?php echo $card['Card']['position_available']; ?></b></section>
  <section class="form_row"><label>Opportunity related to</label><b class="click_opp" id="job_type|<?php echo $card['Card']['id'];?>"><?php if($card['Card']['job_type']=='C') { echo 'NA';}elseif($card['Card']['job_type']=='A'){ echo 'Job A'; }else{ echo 'Job B';} ?></b></section>
  <section class="form_row"><label>Application deadline</label><b class="click_deadline" id="application_deadline|<?php echo $card['Card']['id'];?>"><?php if($card['Card']['application_deadline']!='0000-00-00'){ echo show_formatted_date($card['Card']['application_deadline']);}else{echo 'NA';}?></b></section>
  <section class="form_row"><label>Opportunity found through</label><?php if($card['Card']['added_by']==1) echo "<b>Coach</b>";elseif(!empty($card['Card']['other_web_job_id'])&&(empty($card['Card']['type_of_opportunity']))) {if($card['Card']['resource_id']==1) echo "<b>Indeed.com</b>"; else echo "<b>Linkedin</b>"; ?><?php }else{ ?><b class="click_oppthru" id="type_of_opportunity|<?php echo $card['Card']['id']; ?>"><?php if(!empty($card['Card']['type_of_opportunity'])){ echo $card['Card']['type_of_opportunity']; }else{ echo 'NA';}?></b><?php } ?></section>
   <section class="form_row"><label>Job Status</label>
   <b><?php switch($card['Card']['column_status'])
   	 				{	
						case 'O': echo 'Opportunity'; break;
						case 'A': echo 'Applied';  break;
						case 'S': echo 'Set Interview'; break;
						case 'I': echo 'Interview'; break;
						case 'V': echo 'Verbal Job Offer'; break;
						case 'J': echo 'Job'; break;
					}?></b></section>
  </section>
  
  <section class="form_box">
  <!--<section class="form_row"><label>Job URL</label><?php if(!empty($card['Card']['job_url'])) { ?><b class="click_joburl" id="job_url|<?php echo $card['Card']['id']; ?>"><?php echo $card['Card']['job_url']; ?></b>&nbsp;&nbsp;<a href="<?php echo $card['Card']['job_url'];?>" target="_blank">Click here</a><?php } else{ ?><b class="click_joburl" id="job_url|<?php echo $card['Card']['id'];?>">NA</b><?php } ?></section>-->
   <section class="form_row"><label>Job Details URL</label><b><?php if(!empty($card['Card']['job_url'])) { ?><a href="<?php echo $card['Card']['job_url'];?>" target="_blank" style="font-size:15px;padding: 6px 0 0; margin-top:-5px; margin-left:-1px;">GO >></a><?php }else{ echo 'NA'; } ?></b></section>
   <?php if($card['Card']['resourcetype']=='3' && is_file(WWW_ROOT."/jobs/".$card['Card']['resource_id'].".pdf")){?>
      <section class="form_row"><label>Snagged Details</label><b><a href="<?php echo SITE_URL.'/jobs/'.$card['Card']['resource_id'].'.pdf';?>" target="_blank" style="font-size:15px;padding: 6px 0 0; margin-top:-5px; margin-left:-1px;">GO >></a></b></section>

   <?php }?>
     <section class="form_row"><label>Interview Type</label><?php if(!empty($card['Card']['interview_type'])) { ?><b class="click_int_type" id="interview_type|<?php echo $card['Card']['id'];?>"><?php echo $card['Card']['interview_type']; ?></b><?php  }else{ echo "<b>".'NA'."</b>"; } ?></section>
   <section class="form_row"><label>Interview Date</label><?php if(!empty($card['Card']['interview_date'])) { ?><b class="click_deadline" id="interview_date|<?php echo $card['Card']['id'];?>"><?php echo show_formatted_date($card['Card']['interview_date']); ?></b><?php }else{ echo "<b>".'NA'."</b>"; } ?></b></section>
   <?php if(!empty($card['Card']['interview_time'])) { ?>
    <section class="form_row"><label>Interview Time</label><b class="click_time" id="interview_time|<?php echo $card['Card']['id'];?>"><?php echo $card['Card']['interview_time']; ?></b></section>
    <?php } ?>
     <section class="form_row"><label>Date Added</label><b><?php if($card['Card']['reg_date']!='0000-00-00') { echo show_formatted_date($card['Card']['reg_date']); }else{ echo 'NA'; } ?></b></section>
  </section>
  </section>
  </fieldset>
  </form>
 </div>
 </div>
 
 <script type="text/javascript">
$(document).ready(function(){
	$('.nano').nanoScroller({alwaysVisible: false, contentClass: 'strategy_pop_up'});
	});

<?php if($this->Session->read('usertype')=='3'){?>	
$(document).ready(function(){
	
	
	
	 $(".click_company").editable("<?php echo SITE_URL; ?>/jobcards/update_card", { 
	 cssclass : 'editable',
      indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
      tooltip   : "Click to edit...",
	  event		:	"click",
      style  	: "inherit",
	  onblur 	: 'submit',
	  onsubmit 	: function(settings,td){
					  
	  				var input = $(td).find('input');
					var val=input.val();
					if(val=='')
					{
						$('#inp_error').html('Company name cannot be left blank');
						$('#inp_error').show();
						return false;
						
					}
						var card_id=$('#card_id').val();
						if(val.length > 14) val = val.substring(0,14)+"..."; 
						$('#company_name_'+card_id).html(val);
						
						
			},
		callback : function(){
			$('#inp_error').hide();
			}	
			
  });
  
   $(".click_position").editable("<?php echo SITE_URL; ?>/jobcards/update_card", { 
	 cssclass : 'editable',
      indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
      tooltip   : "Click to edit...",
	  event		:	"click",
      style  	: "inherit",
	  onblur 	: 'submit',
	  onsubmit 	: function(settings,td){
					  
	  				var input = $(td).find('input');
					var val=input.val();
					if(val=='')
					{
						$('#inp_error').html('Position Available field cannot be left blank.');
						$('#inp_error').show();
						return false;
						
					}
						var card_id=$('#card_id').val();
						if(val.length > 18) val = val.substring(0,18)+"..."; 
						$('#pos_name_'+card_id).html(val);
			},
		callback : function(){
			$('#inp_error').hide();
			}	
			
  });
  
  $(".click_joburl").editable("<?php echo SITE_URL; ?>/jobcards/update_card", { 
	 cssclass : 'editable',
      indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
	  event		:	"click",
	  onsubmit 	: function(settings,td){
					  
	  				var input = $(td).find('input');
					$(this).validate({
						rules: {
               		 		'value': {
                   		 		url: true
              				  }
           				 },
          		  messages: {
               			 'input.value': {
                  		  number: 'Please enter a valid url.'

               		 }

           		 }
			});
				return ($(this).valid());	
			},
      tooltip   : "Click to edit...",
      style  	: "inherit",
	  onblur 	: 'submit'		
  });
  
  $('.click_opp').editable("<?php echo SITE_URL; ?>/jobcards/update_card_opportunity", { 
     data   : " {'A':'Job A','B':'Job B','selected':'<?php echo $card['Card']['job_type'];?>'}",
    cssclass : 'editable',
	indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
	 type   : 'select',
	 event		:	"click",
     tooltip   : "Click to edit...",
      style  	: "inherit",
	  onblur 	: 'submit'
 });
 
 $('.click_int_type').editable("<?php echo SITE_URL; ?>/jobcards/update_card", { 
     data   : " {'Face 2 Face':'Face 2 Face','Telephone':'Telephone','selected':'<?php echo $card['Card']['interview_type'];?>'}",
    cssclass : 'editable',
	indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
	 type   : 'select',
	 event		:	"click",
     tooltip   : "Click to edit...",
      style  	: "inherit",
	  onblur 	: 'submit'
 });
 
  $('.click_oppthru').editable("<?php echo SITE_URL; ?>/jobcards/update_card", { 
     loadurl   : "<?php echo SITE_URL; ?>/jobcards/type_of_opp_list",
   	 cssclass : 'editable',
	 indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
	 type   : 'select',
	 event		:	"click",
     tooltip   : "Click to edit...",
      style  	: "inherit",
	  onblur 	: 'submit'

 });
 
  $('.click_deadline').editable("<?php echo SITE_URL; ?>/jobcards/update_card", { 
     //data   : " {'I':'Interview','J':'Job','selected':'<?php echo $card['Card']['opportunity'];?>'}",
    cssclass : 'editable',
	indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
	 type   : 'datepicker',
	  event		:	"click",
     tooltip   : "Click to edit...",
      style  	: "inherit",
	  onblur 	: 'submit'
 });
 
  $(".click_time").editable("<?php echo SITE_URL; ?>/jobcards/update_card", { 
	 cssclass : 'editable',
      indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
      tooltip   : "Click to edit...",
	  event		:	"click",
      style  	: "inherit",
	  onblur 	: 'submit',
	
			
  });

  
  
});
<?php }?>	
</script>	