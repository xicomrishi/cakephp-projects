<div class="actions">
<span class="img_box">
                    <?php if($Professional['Professional']['profile_photo']!=''){?>
                    <img src="<?php echo $this->webroot;?>files/professional_images/<?php echo $Professional['Professional']['profile_photo'];?>" alt="" width="150" height="160"/>
                    <?php }else{?>
                    	<img src="<?php echo $this->webroot;?>images/profile_pic.png" alt=""/>
                    <?php }?>
                    	
        </span>
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Delete Professional', true), array('action' => 'delete', $Professional['Professional']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $Professional['Professional']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Professional', true), array('action' => 'index')); ?> </li>

	</ul>
</div>

<div class="professional view">
	<h2><?php echo __('Professional');?></h2>
	<table style="width:400px" cellpadding="0" cellspacing="0">
		
		<tr><td>Email</td><td><?php echo $Professional['Professional']['email']; ?></td></tr>
		<tr><td>First Name</td><td><?php echo $Professional['Professional']['first_name']; ?></td></tr>
		<tr><td>Last Name</td><td><?php echo $Professional['Professional']['last_name']; ?></td></tr>
        <tr><td>Current Company</td><td><?php echo $Professional['Professional']['current_company']; ?></td></tr>
        <tr><td>Company Website</td><td><?php echo $Professional['Professional']['company_website']; ?></td></tr>
        <tr><td>Current Location</td><td><?php echo $Professional['Professional']['current_location']; ?></td></tr>
        <tr><td>Skills</td><td><?php echo rtrim($Professional['Professional']['skills'],','); ?></td></tr>
        <tr><td>Nationality</td><td><?php echo $Professional['Professional']['nationality']; ?></td></tr>
         <tr><td>Profile Status</td><td>
         <?php if($Professional['Professional']['profile_status']=='U'){ ?>
                            <img src="<?php echo $this->webroot;?>images/profile_filter_status_red.png" alt="" title="Unavailable"/>
                            <?php }else if($Professional['Professional']['profile_status']=='NO'){ ?>
                             <img src="<?php echo $this->webroot;?>images/profile_filter_status_green.png" alt="" title="Currently seeking new opportunities"/>
                             <?php }else{ ?>
                             <img src="<?php echo $this->webroot;?>images/profile_filter_status_yellow.png" alt="" title="Always open to interesting opportunities"/>
                             <?php } ?>
                             </td></tr>
                            <?php if($Professional['Professional']['profile_status']!='U'){?>
                   <tr><td>Preferred Locations</td><td>          
                             <?php 
								$prefLocation='NA';
								if(!empty($Professional['Professional']['profile_status']) && $Professional['Professional']['profile_status']=='NO'){
									$prefLocation=$Professional['Professional']['locations_for_new_op'];
								}elseif(!empty($Professional['Professional']['profile_status']) && $Professional['Professional']['profile_status']=='IO'){
									$prefLocation=$Professional['Professional']['locations_for_interesting_op'];
								}
								$arrPrefLocation=explode(',', $prefLocation);
								foreach($arrPrefLocation as $ploc){
									$ploc=trim($ploc);
									if($ploc!='')
									echo "<span>{$ploc}</span>";
								} ?>
                                
                                
                          </td></tr>
                          <?php }else{
							  
							 if(isset($Professional['Professional']['do_not_disturb_date'])){?>
                          <tr><td>Do not disturb date</td><td>
                          <?php echo date("dS M Y",strtotime($Professional['Professional']['do_not_disturb_date']));?>
                          </td></tr>
                          <?php }} ?>
                          
                          <?php 
								$avail='';
								
								
								
								if(!empty($Professional['Professional']['immediate_joining_flag']) && $Professional['Professional']['immediate_joining_flag']==1){
									$avail='Immediately';?>
									
								<?php }else if(!empty($Professional['Professional']['joining_by_date'])){
									$avail=date('d M Y',strtotime($Professional['Professional']['joining_by_date']));
									?>
								   
								<?php }else if(!empty($Professional['Professional']['joining_by_day'])){
									$avail=$Professional['Professional']['joining_by_day']." days";
									
								}else{
									$avail="N/A";
								}
								?>
								<?php if($avail!='N/A'){?>
                               <tr><td>Available From</td><td>
                               <?php echo $avail;?>
                               </td></tr>
                          		<?php }?>
                          
                 <?php if(!empty($Professional['Professional']['phone_nbr'])){?>
                 <tr><td>Phone Number</td><td><?php echo $Professional['Professional']['phone_nbr']; ?></td></tr>
                 <?php }?>
                  <tr><td>Mode of Contact</td><td><?php echo $Professional['Professional']['mode_of_contact']; ?></td></tr>
                  <?php if(!empty($Professional['Professional']['ctc_currency']) && !empty($Professional['Professional']['current_ctc'])){?>
                  
                   <?php 
				  				 $ctc_currency=$Professional['Professional']['ctc_currency'];
								if(!empty($Professional['Professional']['ctc_cycle'])){
								$ctc_cycle=$Professional['Professional']['ctc_cycle'];
								}
										$ctc=0;
										$ctcCycle='';
										$ctcText='';
										if(strtolower($ctc_cycle)=='year'){
											$ctcCycle='Yearly';?>
											
										<?php }else if(strtolower($ctc_cycle)=='month'){
											$ctcCycle='Monthly';?>
											
										<?php }else if(strtolower($ctc_cycle)=='hour'){
											$ctcCycle='Hourly';?>
											
										<?php }else if(strtolower($ctc_cycle)=='week'){
											$ctcCycle='Weekly';?>
											
										<?php }else if(strtolower($ctc_cycle)=='day'){
											$ctcCycle='Daily';?>
											
										<?php }
                         
											
												$current_ctc=$Professional['Professional']['current_ctc'];
												$ctc=number_format($current_ctc);
											
											if(!empty($current_ctc)){
											if(strtolower($ctc_currency)=='inr'){
												
												$ctcInLac=(int)($current_ctc/100000);
												$ctcInThousand=(($current_ctc%100000)/1000);
												if($current_ctc>=100000){
													$ctc=round(($current_ctc/100000),2).' Lacs';
												}
												
												$ctcText=strtoupper($Professional['Professional']['ctc_currency']).' '.$ctc.' '.$ctcCycle;
											}else{
												$ctcText=strtoupper($Professional['Professional']['ctc_currency']).' '.$ctc.' '.$ctcCycle;
											}
											}?>
											
                  
                 <tr><td>CTC</td><td><?php echo $ctcText;?></td></tr>
                 <?php }?>
                 <tr><td>Experience</td><td>
                 <?php 
										$exp=0;
										if(!empty($Professional['Professional']['work_experience'])){
											
											$exp=round(($Professional['Professional']['work_experience']/12),1);
											$expInYear=(int)($Professional['Professional']['work_experience']/12);
											$expInMonth=(int)($Professional['Professional']['work_experience']%12);
											$yearText='Yrs';
											
											if($Professional['Professional']['work_experience']<2){
												$yearText='Month';
											}
											if($Professional['Professional']['work_experience']<12 && $Professional['Professional']['work_experience']>1){
												$yearText='Months';
											}
											if($Professional['Professional']['work_experience']==0){
												$yearText='Fresher';
											}
										}?>
                                        <?php 
										if($yearText=='Fresher'){
											echo $yearText;
										}else{
										if($Professional['Professional']['work_experience']<12){ echo $expInMonth;} else{ 
										if($expInMonth>0)
										echo $expInYear.'.'.$expInMonth;
										else
										echo $expInYear;
											}?> <?php echo $yearText;}?> 
                                            </td></tr>
                                         <?php    
                                          $online_profiles=unserialize(base64_decode($Professional['Professional']['online_profiles']));
							
										extract($online_profiles);
								$uploaded_resumes=unserialize(base64_decode($Professional['Professional']['uploaded_resumes']));
									extract($uploaded_resumes); 
			
							$online_resume_links=unserialize(base64_decode($Professional['Professional']['online_resume_links']));
								extract($online_resume_links);?>
            <tr><td>Online Profiles</td><td colspan="15">
           
            			<?php if(!empty($linkedin)){?>
                                    <a href="<?php echo $linkedin;?>" target="_blank">
                                    <img src="<?php echo $this->webroot;?>images/profile_filter_icon1.png" alt="" title="LinkedIn" /></a>
								<?php }?>
                               <?php if(!empty($googleplus)){?>
                                   <a href="<?php echo $googleplus;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon2.png" alt="" title="Google+" /></a>
                                <?php }?>
                               <?php if(!empty($facebook)){?>
                                <a href="<?php echo $facebook;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon3.png" alt="" title="Facebook" /></a>
                            <?php }?>
                               <?php if(!empty($twitter)){?>
                                <a href="<?php echo $twitter;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon4.png" alt=""
                                    title="Twitter" /></a>
                            <?php }?>
                               <?php if(!empty($xing)){?>
                                    <a href="<?php echo $xing;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon5.png" alt="" title="Xing" /></a>
                                <?php }?>
                                
                                <?php if(!empty($github)){?>
                                    <a href="<?php echo $github;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon6.png" alt="" title="Github" /></a>
                                <?php }?>
                                 <?php if(!empty($stack_overflow)){?>
                                   <a href="<?php echo $stack_overflow;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon7.png" alt="" title="StackOverflow" /></a>
                                <?php }?>
                                <?php if(!empty($behance)){?>
                                    <a href="<?php echo $behance;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon8.png" alt="" title="Behance" /></a>
                                <?php }?>
                                 <?php if(!empty($dribble)){?>
                                   <a href="<?php echo $dribble;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon9.png" alt="" title="Dribble" /></a>
                                <?php }?>
                                
                                 <?php if(!empty($pinterest)){?>
                                    <a href="<?php echo $pinterest;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon10.png" alt=""
                                        title="Pinterest" /></a>
                                <?php }?>
                                 <?php if(!empty($apnacircle)){?>
                                    <td><a href="<?php echo $apnacircle;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon11.png" alt=""
                                        title="ApnaCircle" /></a></td>
                                <?php }?>
                                <?php if(!empty($blogger[0])){?>
                                    <a href="<?php echo $blogger[0];?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon12.png" alt=""
                                        title="Blogger" /></a>
                                <?php }?>
                                <?php if(!empty($skillpages)){?>
                                    <a href="<?php echo $skillpages;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon13.png" alt="" title="Skillpages" /></a>
                                <?php }?>
                                 <?php if(!empty($about_me)){?>
                                    <a href="<?php echo $about_me;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon14.png" alt="" title="About me" /></a>
                                <?php }?>
                                <?php if(!empty($other['website_name'])){?>
                                    <a href="<?php echo $other['website_link'];?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon14.png" alt="" title="Others" /></a>
                                <?php }?>
                               
                                </td></tr>
                                 <tr><td>Resume</td><td colspan="6">
                                
                                 <?php if(!empty($doc)){ ?>
                             	
                            	<a target="_blank" href="<?php echo $this->webroot;?>files/professional_docs/<?php echo $doc;?>"><img src="<?php echo $this->webroot;?>images/profile_filter_resume1.png" alt="" title="word"/></a>
                                <?php }?>
                                <?php if(!empty($pdf)){?>
                               <a target="_blank" href="<?php echo $this->webroot;?>files/professional_docs/<?php echo $pdf;?>"><img src="<?php echo $this->webroot;?>images/profile_filter_resume2.png" alt="" title="pdf"/></a>
                                  <?php }?>
                                  <?php if(!empty($goole_doc)){?>
                                <a target="_blank" href="<?php echo $goole_doc;?>"><img src="<?php echo $this->webroot;?>images/profile_filter_resume3.png" alt="" title="goole_doc"/></a>
                                  <?php }?>
                                  <?php if(!empty($visual_cv)){?>
                                <a target="_blank" href="<?php echo $visual_cv;?>"><img src="<?php echo $this->webroot;?>images/profile_filter_resume4.png" alt="" title="visual_cv"/></a>
                                  <?php }?>
                                  <?php if(!empty($resume_bucket)){?>
                                <a target="_blank" href="<?php echo $resume_bucket;?>"><img src="<?php echo $this->webroot;?>images/profile_filter_resume5.png" alt="" title="resume_bucket"/></a>
                                  <?php }?>
                                  <?php if(!empty($resume_dot)){?>
                                <a target="_blank" href="<?php echo $resume_dot;?>"><img src="<?php echo $this->webroot;?>images/profile_filter_resume6.png" alt="" title="resume_dot"/></a>
                                  <?php }?>
			</td></tr>
             <?php if(!empty($Professional['Professional']['security_clear'])){ ?>
            <tr><td>Security Clearance</td><td colspan="2">
            <?php echo $Professional['Professional']['security_clear'];
			if($Professional['Professional']['security_clear']=='Yes'){
				 echo $Professional['Professional']['security_type_specification'];
			}
				?>
                         
                            </td></tr>
                    <?php }?>
                    <tr><td>Status</td><td>
                    <?php if($Professional['Professional']['status']==1){ echo 'Active';} else{ echo 'Inactive';}?>
                    </td></tr>
                   <?php if(!empty($Professional['Professional']['message_for_recruiters'])){ ?> 
                    <tr><td>Message For recruiters</td><td>
                    <?php echo $Professional['Professional']['message_for_recruiters']; ?> 
                    </td></tr>
                    <?php }?>
                     <?php if(!empty($Professional['Professional']['display_to_recruiters'])){ ?> 
                    <tr><td>Display To Recruiters</td><td>
                    <?php echo $Professional['Professional']['display_to_recruiters']; ?> 
                    </td></tr>
                    <?php }?>
                     <tr><td>Profile Added Date</td><td><?php echo $Professional['Professional']['profile_added_date']; ?></td></tr>
               <tr><td>Profile Modified Date</td><td><?php echo $Professional['Professional']['profile_modified_date']; ?></td></tr>
                    
	</table>
</div>

