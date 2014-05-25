<div class="wrapper">
  <section id="body_container">
  <div class="login_detail right">
  
  	<div class="company_id  full">Trainer Name:<span><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></span></div>
    <div class="company_id full">Course Id:<span><?php echo $course['Course']['course_id']; ?></span></div>
    <div id="pdf_link"> <a href="<?php echo SITE_URL;?>/reports/project_management_trainer_report/<?php echo $course['Course']['course_id'];?>/1" target="_blank">Save PDF</a></div>
    </div>
  	<div class="details"> 
         	<h3 class="report">Introduction</h3>
            <p>Guidelines when reading your 360 feedback</p>
            <p>When reviewing this report, please remember that you have asked your colleagues for their honest, frank feedback about
how they perceive you in relation to the competence areas covered in this report.</p>
			<p>Respondents were asked to give ratings and additional comments regarding what you are good at, and what you could
improve. Please review their responses in this context. You invited their perceptions, rather than necessarily deep insights;
how you come across to them, not necessarily the objective truth.</p>
			<p>The report has been prepared by collating, anonymising and randomising the feedback from all your colleagues so</p>
			<p><strong>Read through your report initially to gain an overview. Then read it again, working through each competency area looking
at the individual items.</strong></p>
			<ul class="points">
				<li>You will receive both positive and some negative feedback. Get the two in balance.</li>
				<li>Look for the overall flavour of the feedback. You will see different perceptions, since different people see you in
different contexts. This is natural and does not constitute a reason to discount the data.</li>
				<li>Don’t overly focus on the negatives</li>
				<li>Consider your strengths: Could they be more adequately used in the business?</li>
				<li>There is a natural tendency to attribute feedback to individuals. Resist blaming others or trying to pin some
comments/ratings on others.</li>
				<li>Ask: ‘Why might different individuals see me differently?'</li>
				<li>Look for general trends in the feedback, both positive and negative. Focus on what part you may play in the emerging
pattern, rather than focusing on external factors.</li>
				<li>Put individual comments in context – focus on general trends.</li>
				<li>Start to think about what you might do differently.</li>
				<li>Try and remove your own emotion. Think of the report as someone else’s!</li>
            </ul>
            <p class="bottom">Subject: <?php echo $course['Course']['course_name']; ?> Report <span class="right">Created: <?php echo show_formatted_date(date("Y-m-d")); ?></span></p>
         </div>
    <div class="details">
    	<h3 class="report">Section Averages Summary</h3>
       	<div class="inner none"> 
                <table class="table none">
                  <tbody>
                  <?php $i=1; foreach($section_data as $section){ ?>
                  	
                    <tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>">
                    <td><?php if($i==1) echo 'Planning'; else if($i==2) echo 'Organizing &amp; Staffing'; else if($i==3) echo 'Directing &amp; Leading'; else if($i==4) echo 'Controlling'; if($i==5) echo 'Reporting'; if($i==6) echo 'Risk Management'; ?></td>
                    <td>                    	
                        <table class="summery_details">                      
                      <?php  
					  	for($j=3;$j<6;$j++){
					 ?>
                            <tr>
                            	<td><span class="points"><?php if($j==3) echo 'Project Manager:'; else if($j==4) echo 'Team member:'; else if($j==5) echo 'Manager of Project Managers:'; ?></span><span class="img_border"><img src="<?php echo $this->webroot; ?>img/pixel_img_<?php echo $j; ?>.png" style="width:<?php  if(isset($section['usertype'][$j]['avg'])) echo $section['usertype'][$j]['avg']*20; else echo '0'; ?>%"/></span>(<?php if(isset($section['usertype'][$j]['avg'])) echo number_format($section['usertype'][$j]['avg'],2); else echo '0'; ?>)</td>
                            </tr>
                       
                         <?php  } ?>   
                        </table>                        
                     </td>
                  </tr>
                  
                  <?php $i++; } ?>                  
                                   
                </tbody></table>
        </div>
    </div>
    <div class="details">
    	<h3 class="report">Feedback Summary</h3>
        
        <?php $p=1; foreach($question_data as $ques){ ?>
        <div class="common_section">
        	<h3 class="section report"><?php echo $p.'. '; if($p==1) echo 'Planning'; else if($p==2) echo 'Organizing &amp; Staffing'; else if($p==3) echo 'Directing &amp; Leading'; else if($p==4) echo 'Controlling'; else if($p==5) echo 'Reporting'; else if($p==6) echo 'Risk Management'; ?></h3>
        	<div class="inner none"> 
                <table class="table none">
                <tbody>
                <?php $q=1; foreach($ques as $ind=>$usertype_data){  ?>
                  <tr class="<?php if($q%2==0) echo 'even'; else echo 'odd'; ?>">
                    <td><?php echo $ind.'. '.$usertype_data['question']; ?></td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                            	<td><span class="points">&nbsp;</span><div class="boxes none"><small>1</small><small>2</small><small>3</small><small>4</small><small>5</small></div></td>
                            </tr>
                            <?php 
							for($r=3;$r<6;$r++){ 
							 ?>
                        	<tr>
                            	<td>
                                <span class="points"><?php if($r==3) echo 'Project Manager: '; else if($r==4) echo 'Team Member: '; else if($r==5) echo 'Manager of Project Managers: '; else echo 'Self: '; ?></span>
                                
                    <div class="boxes">
                        <span class="<?php if(!isset($usertype_data['usertype'][$r]['count'][1])) echo 'none'; ?>"><?php if(!isset($usertype_data['usertype'][$r]['count'][1])) echo '&nbsp;'; else echo $usertype_data['usertype'][$r]['count'][1] ?></span>
                        <span class="<?php if(!isset($usertype_data['usertype'][$r]['count'][2])) echo 'none'; ?>"><?php if(!isset($usertype_data['usertype'][$r]['count'][2])) echo '&nbsp;'; else echo $usertype_data['usertype'][$r]['count'][2] ?></span>
                        <span class="<?php if(!isset($usertype_data['usertype'][$r]['count'][3])) echo 'none'; ?>"><?php if(!isset($usertype_data['usertype'][$r]['count'][3])) echo '&nbsp;'; else echo $usertype_data['usertype'][$r]['count'][3] ?></span>
                        <span class="<?php if(!isset($usertype_data['usertype'][$r]['count'][4])) echo 'none'; ?>"><?php if(!isset($usertype_data['usertype'][$r]['count'][4])) echo '&nbsp;'; else echo $usertype_data['usertype'][$r]['count'][4] ?></span>
                        <span class="<?php if(!isset($usertype_data['usertype'][$r]['count'][5])) echo 'none'; ?>"><?php if(!isset($usertype_data['usertype'][$r]['count'][5])) echo '&nbsp;'; else echo $usertype_data['usertype'][$r]['count'][5] ?></span>
                    </div>
                   <div class="color"><span><img src="<?php echo $this->webroot; ?>img/pixel_img_<?php echo $r; ?>.png" style="width:<?php if(isset($usertype_data['usertype'][$r]['avg'])) echo $usertype_data['usertype'][$r]['avg']*20; else echo 0; ?>%"/></span></div><span class="pad">(<?php if(isset($usertype_data['usertype'][$r]['avg'])) echo number_format($usertype_data['usertype'][$r]['avg'],2); else echo 0; ?>)</span></td>
                            </tr>
                            <?php } ?>                            
                           
                        </table>
                     </td>
                  </tr>
                  
                <?php $q++; } ?>  
				  
                </tbody>
                </table>
        	</div>
        </div>
        <?php $p++; } ?>
          </div>
  </section>
</div>