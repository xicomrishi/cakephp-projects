<div class="nano">
  <section class="strategy_pop_up" style="height:186px !important; width:100%">
  <form id="cardDetailForm" name="cardDetailForm" method="post" action="">
  <fieldset>
  
  <section class="form_section">
  <section class="form_box">
   <section class="form_row"><label>Position level</label><b class="click_pos_level" id="position_level|<?php echo $card['Card']['id'];?>"><?php if(!empty($card['Card']['position_level'])) { echo $pos_level['Position']['position']; }else{ echo 'NA'; } ?></b></section>
  <section class="form_row"><label>Job function</label><b class="click_job_func" id="job_function|<?php echo $card['Card']['id'];?>"><?php if(!empty($card['Card']['job_function'])) { echo $job_func['Jobfunction']['job_function']; }else{ echo 'NA'; } ?></b></section>
   <section class="form_row"><label>Industry</label><b class="click_job_industry" id="industry|<?php echo $card['Card']['id'];?>"><?php if(!empty($card['Card']['industry'])) { echo $industry['Industry']['industry']; }else{ echo 'NA'; } ?></b></section>
   <section class="form_row"><label>Job type</label><b class="click_job_type" id="job_type_o|<?php echo $card['Card']['id'];?>"><?php if(!empty($card['Card']['job_type_o'])) { echo $job_type['Jobtype']['job_type']; }else{ echo 'NA'; } ?></b></section>
   
   <?php if($card['Card']['job_type']=='B'){ ?>
    <!--<section class="form_row"><label>Job B Skills</label><b><?php if(!empty($card['Card']['job_a_skills'])) { echo $card['Card']['job_a_skills']; }else{ ?> <a href="javascript://" style="font-size:15px; margin-left:-1px;" onclick="loadCardPopup('<?php echo SITE_URL;?>/jobcards/jobcard_details_profile_check');">NA</a> <?php } ?></b></section>
   <section class="form_row"><label>Job B Criteria</label><b><?php if(!empty($card['Card']['job_b_criteria'])) { echo $card['Card']['job_b_criteria']; }else{ ?> <a href="javascript://" style="font-size:15px; margin-left:-1px;" onclick="loadCardPopup('<?php echo SITE_URL;?>/jobcards/jobcard_details_profile_check');">NA</a> <?php } ?></b></section>-->
   
   <section class="form_row"><label>Job B Skills</label><b><?php if(!empty($card['Card']['job_a_skills'])) { echo substr($card['Card']['job_a_skills'], 0, -1); }else{ ?> <a style="font-size:15px; margin-left:-1px;">NA</a> <?php } ?></b></section>
   <section class="form_row"><label>Job B Criteria</label><b><?php if(!empty($card['Card']['job_b_criteria'])) { echo substr($card['Card']['job_b_criteria'],0,-1); }else{ ?> <a style="font-size:15px; margin-left:-1px;">NA</a> <?php } ?></b></section>
   <?php } ?>
  
  </section>
  
  <section class="form_box">
  
    <section class="form_row"><label>My Skills level</label><b><?php if(!empty($card_col['Cardcolumn']['skills_assessment'])) { echo $card_col['Cardcolumn']['skills_assessment'].'/5'; }else{ echo 'NA'; } ?></b></section>
      <section class="form_row"><label>Start Date</label><b><?php if($card_col['Cardcolumn']['desired_start_date']!='0000-00-00') { echo show_formatted_date($card_col['Cardcolumn']['desired_start_date']); }else{ echo 'NA'; } ?></b></section>
       <!-- <section class="form_row"><label>Hiring Cycle</label><b><?php //if($card_col['Cardcolumn']['employee_start_date']!='0000-00-00') { echo $card_col['Cardcolumn']['employee_start_date']; }else{ echo 'NA'; } ?>NA</b></section>-->
         
         <section class="form_row"><label>Average Salary</label><b><?php if(!empty($card['Card']['salary'])) { echo $card['Card']['salary']; }else{ echo 'NA'; } ?></b></section>
          <section class="form_row"><label>Compensation Package Offered</label><b><?php if(!empty($card_col['Cardcolumn']['salary_offered'])) { echo $card_col['Cardcolumn']['salary_offered']; if($card_col['Cardcolumn']['benefits']=='Yes'){ echo ' + '.$card_col['Cardcolumn']['benefit_details']; } if($card_col['Cardcolumn']['vacation_time']!='') echo ' + '.$card_col['Cardcolumn']['vacation_time'];} else {echo "NA"; } ?></b></section>
  <section class="form_row"><label>Job Posting Info</label><b><?php if(!empty($card['Card']['note'])) { echo $card['Card']['note']; }else{ echo 'NA'; } ?></b></section>
 
  </section>
  </section>
  </fieldset>
  </form>
  </section>
  </div>
<script type="text/javascript">
$(document).ready(function(){
	$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up'});
	});
	<?php if($this->Session->read('usertype')=='3'){?>
$(document).ready(function(){
 
 $('.click_pos_level').editable("<?php echo SITE_URL; ?>/jobcards/update_card_position_level", { 
     loadurl   : "<?php echo SITE_URL; ?>/jobcards/all_position_level",
   	 cssclass : 'editable',
	 indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
	 type   : 'select',
	 event		:	"click",
     tooltip   : "Click to edit...",
      style  	: "inherit",
	  onblur 	: 'submit'

 });
 
  $('.click_job_func').editable("<?php echo SITE_URL; ?>/jobcards/update_card_job_function", { 
     loadurl   : "<?php echo SITE_URL; ?>/jobcards/all_job_function",
   	 cssclass : 'editable',
	 indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
	 type   : 'select',
	 event		:	"click",
     tooltip   : "Click to edit...",
      style  	: "inherit",
	  onblur 	: 'submit'

 });
 
  $('.click_job_industry').editable("<?php echo SITE_URL; ?>/jobcards/update_card_industry", { 
     loadurl   : "<?php echo SITE_URL; ?>/jobcards/all_industry",
   	 cssclass : 'editable',
	 indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
	 type   : 'select',
	 event		:	"click",
     tooltip   : "Click to edit...",
      style  	: "inherit",
	  onblur 	: 'submit'

 });
 
  $('.click_job_type').editable("<?php echo SITE_URL; ?>/jobcards/update_card_job_type", { 
     loadurl   : "<?php echo SITE_URL; ?>/jobcards/all_job_type",
   	 cssclass : 'editable',
	 indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
	 type   : 'select',
	 event		:	"click",
     tooltip   : "Click to edit...",
      style  	: "inherit",
	  onblur 	: 'submit'

 });
 

});
 <?php }?>
</script>  