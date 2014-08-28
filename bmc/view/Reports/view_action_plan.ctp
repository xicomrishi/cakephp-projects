<div class="wrapper">
  <section id="body_container">
  <div class="login_detail right">  	
     <div class="company_id  full"><?php echo __('Group ID'); ?>:<span><?php echo $participant['Course']['course_id']; ?></span></div>
     <div class="company_id full"><?php echo __('Group Name'); ?>:<span><?php echo $participant['Course']['course_name']; ?></span></div>
     <div class="company_id full"><?php echo __('Company'); ?>:<span><?php echo $participant['User']['Company']['company']; ?></span></div>
      <?php if($participant['Participant']['status']=='1'){ ?> 
       <div class="company_id full"><?php echo __('Report'); ?>:<span><a href="<?php echo $this->webroot; ?>reports/project_management_report/<?php echo $pr_id; ?>"><?php echo __('View'); ?></a></span></div>
      <?php } ?> 
      <div class="company_id full" id="pdf_link"><?php echo __('Action Plan'); ?>:<span><a target="_blank" class="pdf_link" href="<?php echo $this->webroot; ?>reports/view_action_plan/<?php echo $pr_id; ?>/1"><img width="20" height="20" alt="" src="<?php echo $this->webroot; ?>img/pdf_download.jpg"></a></span></div>
  </div>
  	<div class="details"> 
         	<h3 class="report"><?php echo __('DIRECTIONS'); ?></h3>
            <?php echo $intro_text; ?>
         </div>
    <div class="details">
    	<h3 class="report center"><?php echo __('THE ACTION PLAN'); ?></h3>
        <form id="actionPlanForm" name="actionPlanForm" method="post" action="<?php echo $this->webroot; ?>reports/save_action_plan">
        <input type="hidden" name="participant_id" value="<?php echo $pr_id; ?>"/>
        <?php for($i=1;$i<7;$i++){ 		
			if($i==1) $plan=__('Planning'); else if($i==2) $plan=__('Organizing and Staffing'); else if($i==3) $plan=__('Directing and Leading'); else if($i==4) $plan=__('Controlling'); else if($i==5) $plan=__('Reporting'); else if($i==6) $plan=__('Risk Management'); 
		?>
        <div class="common_section">
        	<h3 class="section report"><?php echo __('Key Result Area'); ?>: <?php echo $plan; ?></h3>
        	<div class="inner none"> 
                <table class="table none">
                <tbody>
                <?php $j=1; foreach($questions as $ques){ ?>
                  <tr class="<?php if($j%2==0) echo 'even'; else echo 'odd'; ?>">
                    <td align="left" width="5%" valign="top"><?php echo $j; ?>)</td>
                    <td align="left" width="88%" valign="top">
                    	<table class="summery_details none">
						<tr><td valign="top"><?php if($ques['APquestion']['question_key']==1||$ques['APquestion']['question_key']==4) echo $ques['APquestion']['question'].' '.$plan.'?'; else echo $ques['APquestion']['question']; ?></td></tr>
                        <?php if($ques['APquestion']['question_key']==4){ ?>
                        	 <tr><td><table width="100%"><tr><td valign="top" width="64.8%" class="full">&nbsp;</td><td valign="top" width="20%"><?php echo __('By When'); ?>?</td><td valign="top" width="20%"><?php echo __('By Whom'); ?>?</td></tr></table></td></tr>
                        <?php } ?>
                        
                        <?php 
							for($m=1; $m<($ques['APquestion']['ans_count']+1); $m++){ 
								if($ques['APquestion']['question_key']==4){ ?>
									  <tr><td><table width="100%"><tr><td valign="top" width="64.8%" class="full"><?php echo $m; ?>.<input type="text" value="<?php echo $response[$i][$j]['response'][$m][1];?>" disabled="disabled" /></td><td valign="top" width="20%"><input type="text" value="<?php echo $response[$i][$j]['response'][$m]['when'];?>" disabled="disabled"/></td><td valign="top" width="20%"><input type="text"  value="<?php echo $response[$i][$j]['response'][$m]['whom'];?>" disabled="disabled"/></td></tr></table></td></tr>
                                 <?php }else{ ?>                                         
                        		<tr><td valign="top"><?php echo $m; ?>.<input type="text" value="<?php echo $response[$i][$j]['response'][$m];?>" disabled="disabled"/></td></tr>
                        <?php }} ?>
                        </table>
                     </td>
                  </tr>                  
                  
                  <?php $j++; } ?>
                </tbody>
                
               </table>
        	</div>
        </div>
        <?php } ?>
      
        </form>
    </div>
  </section>
</div>