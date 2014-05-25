<div class="nano">
  <div class="strategy_pop_up" style="height:186px !important; width:100%">
  <form id="cardDetailForm" name="cardDetailForm" method="post" action="">
  <fieldset>
  
  <div class="form_section">
  <div class="form_box">
   <div class="form_row"><label>Position Reports To</label><b><?php if(!empty($card_col['Cardcolumn']['reporter_name'])) { echo $card_col['Cardcolumn']['reporter_name']; }else{ echo 'NA'; } ?></b></div>
   <div class="form_row"><label>Interview Process</label><b><?php if(!empty($card_col['Cardcolumn']['process_understand'])) { echo $card_col['Cardcolumn']['process_understand']; }else{ echo 'NA'; } ?></b></div>
   <div class="form_row"><label>Job Expectations</label><b><?php if(!empty($job_e)) { ?>
   											<ul><?php foreach($job_e as $job){ 
											echo '<li class="CapText">'.$job['Cardcolext']['text_value'].' | </li>';
											} ?>
                                            	
                                            </ul>		
											<?php }else{ echo 'NA'; } ?></b></div>
    <div class="form_row"><label>Expected Decision</label><b><?php if($card_col['Cardcolumn']['expected_date_of_employer_decision']!='0000-00-00') { echo show_formatted_date($card_col['Cardcolumn']['expected_date_of_employer_decision']); }else{ echo 'NA'; } ?></b></div>
    <div class="form_row"><label>Location</label><b><?php if(!empty($card_col['Cardcolumn']['interview_location'])) { $val=explode('||',$card_col['Cardcolumn']['interview_location']); echo $val[1]; }else{ echo 'NA'; } ?></b></div>
     <div class="form_row"><label>Average Salary</label><b><?php if(!empty($card['Card']['salary'])) { echo $card['Card']['salary']; }else{ echo 'NA'; } ?></b></div>
  
  </div>
  
  <div class="form_box">
  
   <div class="form_row"><label>Risk Factors</label><b><?php if(!empty($card_col['Cardcolumn']['risk_factor'])) { echo $card_col['Cardcolumn']['risk_factor']; }else{ echo 'NA'; } ?></b></div>
     <div class="form_row"><label>Opportunity matches my goals</label><b><?php if(!empty($card_col['Cardcolumn']['job_fitness'])) { echo $card_col['Cardcolumn']['job_fitness'].'/5'; }else{ echo 'NA'; } ?></b></div>
        <div class="form_row"><label>Interview Agenda</label><b><?php if(!empty($card_col['Cardcolumn']['interview_agenda'])) {  echo $card_col['Cardcolumn']['interview_agenda']; }else{ echo 'NA'; } ?></b></div>
         
         <div class="form_row"><label>Promotion Opportunities</label><b><?php if(!empty($card_col['Cardcolumn']['job_promotion'])) { echo $card_col['Cardcolumn']['job_promotion']; }else{ echo 'NA'; } ?></b></div>
          <div class="form_row"><label>Professional Development Opportunities</label><b><?php if(!empty($pdo)) { ?>
   											<ul><?php foreach($pdo as $p){ 
											echo '<li class="CapText">'.$p['Cardcolext']['text_value'].' | </li>';
											} ?>
                                            	
                                            </ul>		
											<?php }else{ echo 'NA'; } ?></b></div>
  </div>
  </div>
  </fieldset>
  </form>
  </div>
  </div>
<script type="text/javascript">
$(document).ready(function(){
	$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up'});
	});
$(document).ready(function(){
 
});
</script>  