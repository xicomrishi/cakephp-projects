<?php echo $this->Html->script(array('jeditable','jquery.jeditable.datepicker'));?>
<div id="jsb_CardPopup"></div>
<div id="background_CardPopup"></div>
<ul class="note">
  <li><a href="javascript://" onclick="loadNotesPopup('<?php echo SITE_URL;?>/jobcards/notes_index','<?php echo $card['Card']['id'];?>')">NOTES</a></li>
  <li><a href="javascript://" onclick="show_card_contacts('<?php echo $card['Card']['id'];?>');">CONTACTS</a></li>
  <li><a href="javascript://" onclick="loadNotesPopup('<?php echo SITE_URL;?>/jobcards/attachments_index','<?php echo $card['Card']['id'];?>')">ATTACHMENTS</a></li>
  <li class="last"><a href="#">COACH NOTES</a></li>
  </ul>
  
  <ul class="sub_tab2">
 
  <li id="loc"><a href="javascript://" onclick="show_location('<?php echo $card['Card']['id'];?>');">LOCATION</a></li>
   <li id="cont_inf"><a href="javascript://" onclick="show_contact('<?php echo $card['Card']['id'];?>');">CONTACT INFO</a></li>
   <li id="pos_inf"><a href="javascript://" onclick="show_position('<?php echo $card['Card']['id'];?>');">POSITION INFO</a></li>
   <li id="net_inf"><a href="javascript://" onclick="show_network('<?php echo $card['Card']['id'];?>');">NETWORK INFO</a></li>
   <li id="int_agenda"><a href="javascript://" onclick="show_interview('<?php echo $card['Card']['id'];?>');">INTERVIEW AGENDA</a></li>
  </ul>
  <div id="inp_error" style="display:none;"></div>
  
  
   <section class="tab_details">
                       <div class="nano">
<section class="strategy_pop_up" style="height:186px !important; width:100%">
  <form id="cardDetailForm" name="cardDetailForm" method="post" action="">
  <fieldset>
  
  <section class="form_section">
  <section class="form_box">
  <section class="form_row"><label>Company name</label><b class="click_company" id="company_name|<?php echo $card['Card']['id'];?>"><?php echo $card['Card']['company_name']; ?></b></section>
  <section class="form_row"><label>Position available</label><b class="click_position" id="position_available|<?php echo $card['Card']['id'];?>"><?php echo $card['Card']['position_available']; ?></b></section>
  <section class="form_row"><label>Opportunity related to</label><b class="click_opp" id="job_type|<?php echo $card['Card']['id'];?>"><?php if($card['Card']['job_type']=='C') { echo 'NA';}elseif($card['Card']['job_type']=='A'){ echo 'Job A'; }else{ echo 'Job B';} ?></b></section>
  <section class="form_row"><label>Application deadline</label><b class="click_deadline" id="application_deadline|<?php echo $card['Card']['id'];?>"><?php if($card['Card']['application_deadline']!='0000-00-00'){ echo show_formatted_date($card['Card']['application_deadline']);}else{echo 'NA';}?></b></section>
  <section class="form_row"><label>Opportunity found through</label><?php if(!empty($card['Card']['other_web_job_id'])) { ?><a href="<?php echo $card['Card']['other_web_job_id'];?>" target="_blank" class="go" style="margin:0px"><?php echo $card['Card']['other_web_job_id'];?></a><?php }else{ ?><b class="click_oppthru" id="type_of_opportunity|<?php echo $card['Card']['id']; ?>"><?php if(!empty($card['Card']['type_of_opportunity'])){ echo $card['Card']['type_of_opportunity']; }else{ echo 'NA';}?></b><?php } ?></section>
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
     <section class="form_row"><label>Interview Type</label><?php if(!empty($card['Card']['interview_type'])) { ?><b class="click_int_type" id="interview_type|<?php echo $card['Card']['id'];?>"><?php echo $card['Card']['interview_type']; ?></b><?php  }else{ echo "<b>".'NA'."</b>"; } ?></section>
   <section class="form_row"><label>Interview Date</label><?php if($card['Card']['interview_date']!='0000-00-00') { ?><b class="click_deadline" id="interview_date|<?php echo $card['Card']['id'];?>"><?php echo show_formatted_date($card['Card']['interview_date']); ?></b><?php }else{ echo "<b>".'NA'."</b>"; } ?></b></section>
    <section class="form_row"><label>Interview Time</label><b><?php if(!empty($card['Card']['interview_time'])) { echo $card['Card']['interview_time']; }else{ echo 'NA'; } ?></b></section>
     <section class="form_row"><label>Date Added</label><b><?php if($card['Card']['reg_date']!='0000-00-00') { echo show_formatted_date($card['Card']['reg_date']); }else{ echo 'NA'; } ?></b></section>
  </section>
  </section>
  </fieldset>
  </form>
 </section>
 </div>
 </section>

  
  <!--<section class="submit_box">
 <?php //echo $this->Html->link($this->Html->image('close_icon.png', array('alt' => $siteDescription, 'border' => '0')), '#', array('escape' => false,'class'=>'close')); ?>
  <section class="submit_left">
  <h4>Determine my interview agenda</h4>
  <p>Put together an agenda that outlines what information you hope to gather from the interview to determine whether this is a job you would like to have.
(Hint: does it have professional development opportunities)?</p>
  </section>
  
  <section class="submit_right">
  <textarea name="">Your input here...</textarea>
  <input type="submit" value="SAVE" class="save">
  </section>
  </section>-->
<script type="text/javascript">
$(document).ready(function(){
	$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up'});
	});
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

  
  
});

function show_location(card_id)
{
	$('li#loc').siblings(this).removeClass('active');
	$('#loc').addClass('active');
	$('.tab_details').html('<div style="height:100px; margin-top:50px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/show_location','cardid='+card_id,function(data){
		$('.tab_details').html(data);
		
		});	
}

function show_contact(card_id)
{	
	$('li#cont_inf').siblings(this).removeClass('active');
	$('li#cont_inf').addClass('active');
	$('.tab_details').html('<div style="height:100px; margin-top:50px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/show_contact','cardid='+card_id,function(data){
		$('.tab_details').html(data);
		
		});	
}
function show_position(card_id)
{
	$('li#pos_inf').siblings(this).removeClass('active');
	$('#pos_inf').addClass('active');
	$('.tab_details').html('<div style="height:100px; margin-top:50px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/show_position','cardid='+card_id,function(data){
		$('.tab_details').html(data);
		
		});	
}
function show_network(card_id)
{
	$('li#net_inf').siblings(this).removeClass('active');
	$('#net_inf').addClass('active');
	$('.tab_details').html('<div style="height:100px; margin-top:50px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/show_network','cardid='+card_id,function(data){
		$('.tab_details').html(data);
		
		});	
}
function show_interview(card_id)
{
	$('li#int_agenda').siblings(this).removeClass('active');
	$('#int_agenda').addClass('active');
	$('.tab_details').html('<div style="height:100px; margin-top:50px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/show_interview','cardid='+card_id,function(data){
		$('.tab_details').html(data);
		
		});	
}

function show_card_contacts(card_id)
{
	disablePopup();
	show_contact(card_id);
			
}

</script>  