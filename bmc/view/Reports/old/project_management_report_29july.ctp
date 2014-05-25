<div class="wrapper">  
  <section id="body_container">
  <div class="login_detail right">
  	 <div id="pdf_link"> <a href="<?php echo SITE_URL;?>/reports/project_management_report/<?php echo $pr_id;?>/1" target="_blank">Save PDF</a></div>
  </div>
  	<div class="details"> 
         	<h3 class="report">Introduction - <?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></h3>
            
			<p><strong>Read through your report initially to gain an overview. Then read it again, working through each competency area looking
at the individual items.</strong></p>
			<ul class="points">
				<li>There will be both positive and negative feedback.  Get the two in balance.</li>
				
				<li>Don’t overly focus on the negatives</li>
				<li>Consider your strengths: Could they be more adequately used in the business?</li>
				<li>Look for general trends in the feedback, both positive and negative. Focus on what part you may play in the emerging
pattern, rather than focusing on external factors.</li>
				<li>Focus on general trends.</li>
				<li>Start to think about what you might do differently.</li>
				<li>Think of the report as someone else’s!</li>
            </ul>
            <p class="bottom">Subject: <?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?> Report <span class="right">Created: <?php echo show_formatted_date(date("Y-m-d")); ?></span></p>
         </div>
    <div class="details">
    	<h3 class="report">Section Averages Summary - <?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></h3>
       	<div class="inner none"> 
                <table class="table none">
                  <tbody>
                  <?php $i=1; foreach($section_data as $section){ ?>
                  	
                    <tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>">
                    <td><?php if($i==1) echo 'Planning'; else if($i==2) echo 'Organizing &amp; Staffing'; else if($i==3) echo 'Directing &amp; Leading'; else if($i==4) echo 'Controlling'; if($i==5) echo 'Reporting'; if($i==6) echo 'Risk Management'; ?></td>
                    <td>                    	
                        <table class="summery_details">                      
                      <?php  
					  	for($j=3;$j<7;$j++){
					 ?>
                            <tr>
                            	<td><span class="points"><?php if($j==3) echo 'Project Manager:'; else if($j==4) echo 'Team member:'; else if($j==5) echo 'Manager of Project Managers:'; else echo 'Self'; ?></span><span class="img_border"><img src="<?php echo $this->webroot; ?>img/pixel_img_<?php echo $j; ?>.png" style="width:<?php  if(isset($section['usertype'][$j]['avg'])) echo $section['usertype'][$j]['avg']*20; else echo '0'; ?>%"/></span>(<?php if(isset($section['usertype'][$j]['avg'])) echo number_format($section['usertype'][$j]['avg'],2); else echo '0'; ?>)</td>
                            </tr>
                       
                         <?php  } ?>   
                        </table>                        
                     </td>
                  </tr>
                  
                  <tr class="even last">
                    <td><img src="<?php echo $this->webroot; ?>img/company.jpg"><?php echo 'My Company ('.$section['company']['name'].')'; ?></td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                            	<td><span class="points">Average score:</span><span class="img_border"><img src="<?php echo $this->webroot; ?>img/pixel_img_7.png" style="width:<?php echo $section['company']['avg']*20;  ?>%"/></span>(<?php echo number_format($section['company']['avg'],2); ?>)</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>
                  
                  <tr class="even last">
                    <td><img src="<?php echo $this->webroot; ?>img/industry_icon.png"><?php echo 'My Industry ('.$section['industry']['name'].')'; ?></td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                            	<td><span class="points">Average score:</span><span class="img_border"><img src="<?php echo $this->webroot; ?>img/pixel_img_8.png" style="width:<?php  echo $section['industry']['avg']*20;  ?>%"/></span>(<?php echo number_format($section['industry']['avg'],2); ?>)</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>                  
                  
                  <?php $i++; } ?>                  
                                   
                </tbody></table>
        </div>
    </div>
    <div class="details">
    	<h3 class="report">Feedback Summary - <?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></h3>
        
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
							for($r=3;$r<7;$r++){ 
							 ?>
                        	<tr>
                            	<td>
                                <span class="points"><?php if($r==3) echo 'Project Manager: '; else if($r==4) echo 'Team Member: '; else if($r==5) echo 'Manager of Project Managers: '; else echo 'Self: '; ?></span>
                                
                    <div class="boxes">
                  <?php   for($l=1;$l<6;$l++){  ?>
                        <span class="<?php if(!isset($usertype_data['usertype'][$r]['count'][$l])) echo 'none'; ?>"><?php if(!isset($usertype_data['usertype'][$r]['count'][$l])) echo '&nbsp;'; else echo $usertype_data['usertype'][$r]['count'][$l] ?></span>
                       
                   <?php } ?>     
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
       <p>Now that you've read your report you can begin your Action Plan for improving management - <a href="<?php echo $this->webroot; ?>reports/action_plan" target="_blank">click here</a> to access your Action Plan</p>
 
    </div>
  </section>
</div>