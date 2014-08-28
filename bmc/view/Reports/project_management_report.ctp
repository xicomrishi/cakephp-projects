<style>
.pdf_link { color:#333; text-decoration:none;}
.benchmark_a{ font-size:10px;}
table.summery_details td span.img_border { border:1px solid #808080;}
</style>
<div class="wrapper">  
  <section id="body_container">
    <div class="login_detail right">
    <div class="company_id  full"><?php echo __('Participant Name:'); ?><span><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></span></div>
    <div class="company_id full"><?php echo __('Group ID:'); ?><span><?php echo $course['Course']['course_id']; ?></span></div>
    <div class="company_id full"><?php echo __('Group Name:'); ?><span><?php echo $course['Course']['course_name']; ?></span></div>
    <div class="company_id full"><?php echo __('Company:'); ?><span><?php echo $section_data[1]['company']['name']; ?></span></div>
  	 <div id="pdf_link" class="company_id full"><?php echo __('Download Report:'); ?><span><a href="<?php echo SITE_URL;?>/reports/project_management_report/<?php echo $pr_id;?>/1" class="pdf_link" target="_blank"><img src="<?php echo $this->webroot; ?>img/pdf_download.jpg" alt="" height="20" width="20"/></a></span></div>
     
  </div>
  	<div class="details"> 
         	<h3 class="report"><?php echo __('Introduction'); ?> - <?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></h3>
           
			<?php echo $intro_text; ?>
            <p class="bottom"><?php echo __('BMC Assessment Inventory of Project Management Report'); ?> <span class="right"><?php echo __('Created:'); ?> <?php echo show_formatted_date(date("Y-m-d")); ?></span></p>
         </div>
    <div class="details">
    	<h3 class="report"><?php echo __('Section Averages Summary'); ?> - <?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></h3>
       	<div class="inner none"> 
                <table class="table none">
                  <tbody>
                  <?php $i=1; foreach($section_data as $section){ ?>
                  	
                    <tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>">
                    <td><?php if($i==1) echo __('Planning'); else if($i==2) echo __('Organizing &amp; Staffing'); else if($i==3) echo __('Directing &amp; Leading'); else if($i==4) echo __('Controlling'); if($i==5) echo __('Reporting'); if($i==6) echo __('Risk Management'); ?></td>
                    <td>                    	
                        <table class="summery_details">                      
                      <?php  
					  	for($j=3;$j<7;$j++){
					 ?>
                            <tr>
                            	<td><span class="points"><?php if($j==3) echo __('Project Manager:'); else if($j==4) echo __('Team member:'); else if($j==5) echo __('Manager of Project Managers:'); else echo __('Own Score:'); ?></span><span class="img_border"><img src="<?php echo $this->webroot; ?>img/pixel_img_<?php echo $j; ?>.png" style="width:<?php  if(isset($section['usertype'][$j]['avg'])) echo $section['usertype'][$j]['avg']*20; else echo '0'; ?>%"/></span>(<?php if(isset($section['usertype'][$j]['avg'])) echo number_format($section['usertype'][$j]['avg'],2); else echo '0'; ?>)</td>
                            </tr>
                       
                         <?php  } ?>   
                        </table>                        
                     </td>
                  </tr>
                  <?php if($role_id=='3') $role=__('Project Manager'); else if($role_id=='4') $role=__('Team Member'); else if($role_id=='5') $role=__('Manager of Project Manager'); ?>
                  
                  <!-----------------------------------------My Group -------------------------------------------------->
                  
                  <tr class="even last">
                    <td><img src="<?php echo $this->webroot; ?>img/industry_icon.png"><?php echo __("My Group"); ?></td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                            	<td>
                                <div class="boxes">
								  <?php   for($l1=5;$l1>0;$l1--){  ?>
                                        <span class="<?php if(!isset($section['group']['count_resp'][$l1])) echo 'none'; ?>"><?php if(!isset($section['group']['count_resp'][$l1])) echo '&nbsp;'; else echo ($section['group']['count_resp'][$l1]); ?></span>
                                       
                                   <?php } ?>     
                                    </div>
                                </td>
                                <td style="width:50%"><span class="points">&nbsp;&nbsp;<?php echo __('Average score:'); ?></span><span class="img_border border_1"><img src="<?php echo $this->webroot; ?>img/pixel_img_8.png" style="width:<?php echo $section['group']['avg']*20;  ?>%"/></span>(<?php echo number_format($section['group']['avg'],2); ?>)</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>
                  <!------------------------------------------------------------------------------------------------------>
    				
                <!-----------------------------------------My Company-------------------------------------------------->
                  <tr class="even last">
                    <td><img src="<?php echo $this->webroot; ?>img/company.jpg"><?php echo __('My Company (%s)',$section['company']['name']); ?></td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                               <td>
                                <div class="boxes">
								  <?php for($l2=5;$l2>0;$l2--){									  		 
								  		  if(!isset($bench_data[1][$i-1]['val']['num_'.$l2])){
										 		$bench_add=0;
										  }else{ 
												$bench_add=$bench_data[1][$i-1]['val']['num_'.$l2]; 
										  }
										  
								 ?>
                                        <span class="<?php if(!isset($section['company']['count_resp'][$l2]) && $bench_add==0) echo 'none'; ?>">
										
										<?php if(!isset($section['company']['count_resp'][$l2]) && $bench_add==0) echo '&nbsp;'; else{ if(isset($section['company']['count_resp'][$l2])) $CountVal=intval($section['company']['count_resp'][$l2]); else $CountVal=0; echo ($CountVal+$bench_add); } ?></span>
                                       
                                   <?php } ?>     
                                    </div>
                                </td>
                            	<td style="width:50%"><span class="points">&nbsp;&nbsp;<?php echo __('Average score:'); ?></span><span class="img_border border_1"><img src="<?php echo $this->webroot; ?>img/pixel_img_8.png" style="width:<?php echo $section['company']['avg']*20;  ?>%"/></span>(<?php echo number_format($section['company']['avg'],2); ?>)</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>
            <!------------------------------------------------------------------------------------------------------>

              <!-----------------------------------------My Company in My Country-------------------------------------------------->    
                  <tr class="even last">
                    <td><img src="<?php echo $this->webroot; ?>img/company.jpg"><?php echo __('My Company in My Country  (%s)',$section['company_location']['name']); ?></td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                            	<td>
                                <div class="boxes">
								  <?php   for($l3=5;$l3>0;$l3--){  
								  			if(!isset($bench_data[2][$i-1]['val']['num_'.$l3])){
												$bench_add=0;
											}else{
												$bench_add=intval($bench_data[2][$i-1]['val']['num_'.$l3]);
											}
								  ?>
                                        <span class="<?php if(!isset($section['company_location']['count_resp'][$l3]) && $bench_add==0) echo 'none'; ?>">
										
										<?php if(!isset($section['company_location']['count_resp'][$l3]) && $bench_add==0) echo '&nbsp;'; else{ if(isset($section['company_location']['count_resp'][$l3])) $CountVal=intval($section['company_location']['count_resp'][$l3]); else $CountVal=0; echo ($CountVal+$bench_add); } ?></span>
                                       
                                   <?php } ?>     
                                    </div>
                                </td>
                            	<td style="width:50%"><span class="points">&nbsp;&nbsp;<?php echo __('Average score:'); ?></span><span class="img_border border_1"><img src="<?php echo $this->webroot; ?>img/pixel_img_8.png" style="width:<?php echo $section['company_location']['avg']*20;  ?>%"/></span>(<?php echo number_format($section['company_location']['avg'],2); ?>)</td>
                            </tr> 
                        </table>
                     </td>
                  </tr>
				 <!------------------------------------------------------------------------------------------------------>
				
                 <!-----------------------------------------My Industry--------------------------------------------------> 	
                  <tr class="even last">
                    <td><img src="<?php echo $this->webroot; ?>img/industry_icon.png"><?php echo __('My Industry (%s)',$section['industry']['name']); ?></td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                            	<td>
                                <div class="boxes">
								  <?php   for($l4=5;$l4>0;$l4--){  
								  			if(!isset($bench_data[3][$i-1]['val']['num_'.$l4])){
												$bench_add=0;
											}else{
												$bench_add=$bench_data[3][$i-1]['val']['num_'.$l4];
											}
								  ?>
                                        <span class="<?php if(!isset($section['industry']['count_resp'][$l4]) && $bench_add==0) echo 'none'; ?>">
										
										<?php if(!isset($section['industry']['count_resp'][$l4]) && $bench_add==0) echo '&nbsp;'; else{  if(isset($section['industry']['count_resp'][$l4])) $CountVal=intval($section['industry']['count_resp'][$l4]); else $CountVal=0; echo ($CountVal+$bench_add); } ?></span>
                                       
                                   <?php } ?>     
                                    </div>
                                </td>
                            	<td style="width:50%"><span class="points">&nbsp;&nbsp;<?php echo __('Average score:'); ?></span><span class="img_border border_1"><img src="<?php echo $this->webroot; ?>img/pixel_img_8.png" style="width:<?php  echo $section['industry']['avg']*20;  ?>%"/></span>(<?php echo number_format($section['industry']['avg'],2); ?>)</td>
                            </tr> 
                        </table>
                     </td>
                  </tr> 
                  <!------------------------------------------------------------------------------------------------------>
                  
                   <!-----------------------------------------Overall--------------------------------------------------> 	
                  <tr class="even last">
                    <td><img src="<?php echo $this->webroot; ?>img/icon_acc_settings.gif"><?php echo __('Overall Benchmark'); ?></td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                            	<td>
                                <div class="boxes">
								  <?php   for($l5=5;$l5>0;$l5--){  
								  			if(!isset($bench_data[4][$i-1]['val']['num_'.$l5])){
												$bench_add=0;
											}else{
												$bench_add=$bench_data[4][$i-1]['val']['num_'.$l5];
											}
								  ?>
                                        <span class="<?php if(!isset($section['overall']['count_resp'][$l5]) && $bench_add==0) echo 'none'; ?>">
										
										<?php if(!isset($section['overall']['count_resp'][$l5]) && $bench_add==0) echo '&nbsp;'; else{  if(isset($section['overall']['count_resp'][$l5])) $CountVal=intval($section['overall']['count_resp'][$l5]); else $CountVal=0; echo ($CountVal+$bench_add); } ?></span>
                                       
                                   <?php } ?>     
                                    </div>
                                </td>
                            	<td style="width:50%"><span class="points">&nbsp;&nbsp;<?php echo __('Average score:'); ?></span><span class="img_border border_1"><img src="<?php echo $this->webroot; ?>img/pixel_img_8.png" style="width:<?php  echo $section['overall']['avg']*20;  ?>%"/></span>(<?php echo number_format($section['overall']['avg'],2); ?>)</td>
                            </tr> 
                        </table>
                     </td>
                  </tr> 
                  <!------------------------------------------------------------------------------------------------------>
                               
                  <?php $i++; } ?>                                   
                </tbody>
             </table>
        </div>
    </div>
    <div class="details">
    	<h3 class="report"><?php echo __('Feedback Summary'); ?> - <?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></h3>
        
        <?php $p=1; foreach($question_data as $ques){ ?>
        <div class="common_section">
        	<h3 class="section report"><?php echo $p.'. '; if($p==1) echo __('Planning'); else if($p==2) echo __('Organizing &amp; Staffing'); else if($p==3) echo __('Directing &amp; Leading'); else if($p==4) echo __('Controlling'); else if($p==5) echo __('Reporting'); else if($p==6) echo __('Risk Management'); ?></h3>
        	<div class="inner none"> 
                <table class="table none">
                <tbody>
                <?php $q=1; foreach($ques as $ind=>$usertype_data){  ?>
                  <tr class="<?php if($q%2==0) echo 'even'; else echo 'odd'; ?>">
                    <td style="width:40%;">
						 <table>
                        <tr><td><?php echo $ind.'. '.$usertype_data['question']; ?></td></tr>
                        <tr><td class="comment"><?php echo __('Comments'); ?>:-<br><br><?php echo $usertype_data['comments']; ?></td></tr>
                        </table>
					</td>
                    <td>
                    	<table class="summery_details">
                        	<tr>
                            	<td><span class="points">&nbsp;</span><div class="boxes none"><small>A</small><small>B</small><small>C</small><small>D</small><small>E</small></div></td>
                            </tr>
                            <?php 
							for($r=3;$r<8;$r++){ 
							 ?>
                        	<tr>
                            	<td>
                                <span class="points"><?php if($r==3) echo __('Project Manager: '); else if($r==4) echo __('Team Member: '); else if($r==5) echo __('Manager of Project Managers: '); else if($r==6) echo __('Own Score: '); else echo __('Overall'); ?></span>
                                
                    <div class="boxes">
                  <?php   for($l=5;$l>0;$l--){  ?>
                        <span class="<?php if(!isset($usertype_data['usertype'][$r]['count'][$l])) echo 'none'; ?>"><?php if(!isset($usertype_data['usertype'][$r]['count'][$l])) echo '&nbsp;'; else echo $usertype_data['usertype'][$r]['count'][$l]; ?></span>
                       
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
        
        <?php if($participant['Participant']['action_plan_status']=='0'){ ?>
        <p><?php echo __('Now that you\'ve read your report you can begin your Action Plan for improving management');?> - <a href="<?php echo $this->webroot; ?>reports/action_plan/<?php echo $pr_id; ?>"><?php echo __('click here'); ?></a> <?php echo __('to access your Action Plan'); ?></p>
        <?php }else{ ?>
        <p><a href="<?php echo $this->webroot; ?>reports/view_action_plan/<?php echo $pr_id; ?>"><?php echo __('click here'); ?></a> <?php echo __('to access your Action Plan'); ?></p>
        <?php } ?>
    </div>
  </section>
</div>