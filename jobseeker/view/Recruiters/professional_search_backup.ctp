<?php 
//	echo '<pre>'.$this->element('sql_dump'); die;
   if(count($searchData)>0){
	$this->Paginator->options(array(
	'url' => $this->data,
    'update' => '.candidate_details',
    'evalScripts' => true
   
));	
	?>     	
        <?php foreach($searchData as $profList){?> 
         <?php 
		 	$online_profiles=unserialize(base64_decode($profList['Professional']['online_profiles']));
//			extract($online_profiles);
			
			
			$uploaded_resumes=unserialize(base64_decode($profList['Professional']['uploaded_resumes']));
//			extract($uploaded_resumes); 
			
			$online_resume_links=unserialize(base64_decode($profList['Professional']['online_resume_links']));
//			extract($online_resume_links);
            $doc = $uploaded_resumes['doc'];
			$pdf = $uploaded_resumes['pdf'];
			$goole_doc = $online_resume_links['goole_doc'];
			$visual_cv = $online_resume_links['visual_cv'];
			$resume_bucket = $online_resume_links['resume_bucket'];
			$resume_dot = $online_resume_links['resume_dot'];
			$linkedin = $online_profiles['linkedin'];
			$googleplus = $online_profiles['googleplus'];
			$facebook = $online_profiles['facebook'];
			$twitter = $online_profiles['twitter'];
			$xing = $online_profiles['xing'];
			$github = $online_profiles['github'];
			$stack_overflow = $online_profiles['stack_overflow'];
			$behance = $online_profiles['behance'];
			$dribble = $online_profiles['dribble'];
			$pinterest = $online_profiles['pinterest'];
			$apnacircle = $online_profiles['apnacircle'];
			$blogger = $online_profiles['blogger'];
			$skillpages = $online_profiles['skillpages'];
			$about_me = $online_profiles['about_me'];
			$other = $online_profiles['other'];
			
			

		?>  
        <?php
		    
		    if(($filterBy == '4') && (trim($doc) == '') && (trim($pdf) == '') && (trim($goole_doc) == '') && (trim($visual_cv) == '') && (trim($resume_bucket) == '') && (trim($resume_dot) == ''))   {
			  continue;			  
			}
		?>
        <section class="details_section ico_section">
                	<span class="img_box">
                    <a href="<?php echo $this->webroot;?>professionals/professional_profile/<?php echo $profList['Professional']['id'];?>">
                    <?php if($profList['Professional']['profile_photo']!=''){?>
                    <img src="<?php echo $this->webroot;?>files/professional_images/<?php echo $profList['Professional']['profile_photo'];?>" alt=""/>
                    <?php }else{?>
                    	<img src="<?php echo $this->webroot;?>images/profile_pic.png" alt=""/>
                    <?php }?>
                    </a>	
                    </span>
                    <section class="details">
                    	<section class="top_section">
                        	<section class="summary">
                             <label>
                              <a target="_blank" href="<?php echo $this->webroot;?>professionals/professional_profile/<?php echo $profList['Professional']['id'];?>">
							   <?php  echo trim($profList['Professional']['first_name'].' '.$profList['Professional']['last_name']);?>
                               </a></label>
                             <span class="status">
                            <?php if($profList['Professional']['profile_status']=='U'){ ?>
                            <img src="<?php echo $this->webroot;?>images/profile_filter_status_red.png" alt="" title="Unavailable"/>
                            <?php }else if($profList['Professional']['profile_status']=='NO'){ ?>
                             <img src="<?php echo $this->webroot;?>images/profile_filter_status_green.png" alt="" title="Currently seeking new opportunities"/>
                             <?php }else{ ?>
                             <img src="<?php echo $this->webroot;?>images/profile_filter_status_yellow.png" alt="" title="Always open to interesting opportunities"/>
                             <?php } ?>
                             <?php if($profList['Professional']['security_clear']=='Yes'){ ?>
                            <img src="<?php echo $this->webroot;?>images/profile_filter_icon_security.png" alt="" title="Security Clearance"/>
                            <?php }?>
                            </span>
                             <span>
                             <?php 
							     if($profList['Professional']['profile_status']!='U'){
							       if(isset($profList['Professional']['joining_by_date'])) {
									   $date = explode(' ',trim($profList['Professional']['joining_by_date']));
									   if($date[0] != '0000-00-00')  {
										  $format = explode('-',$date[0]); 
    									  echo '{Available From Date : '.$format[2].'-'.$format[1].'-'.$format[0].'}'; 
									   }
								   }
							       if(isset($profList['Professional']['joining_by_day'])) {
									    echo '{Available in days : '.trim($profList['Professional']['joining_by_day']).'}'; 
								   }
						           if($profList['Professional']['immediate_joining_flag'] == 1) {
								    echo '{Immediate Available}'; 
							       }
								 }
								 
							  ?>
                             </span>  
                            </section>
                            <ul>
                             <?php if(!empty($doc)){ ?> 
                            	<li>
                                <a target="_blank" href="<?php echo $this->webroot;?>files/professional_docs/<?php echo $doc;?>"><img src="<?php echo $this->webroot;?>images/profile_filter_resume1.png" alt="" title="word"/></a></li>
                                <?php }?>
                                <?php if(!empty($pdf)){?>
                                <li><a target="_blank" href="<?php echo $this->webroot;?>files/professional_docs/<?php echo $pdf;?>"><img src="<?php echo $this->webroot;?>images/profile_filter_resume2.png" alt="" title="pdf"/></a></li>
                                  <?php }?>
                                  <?php if(!empty($goole_doc) && ($goole_doc != 'http://')){?>
                                <li><a target="_blank" href="<?php echo $goole_doc;?>"><img src="<?php echo $this->webroot;?>images/profile_filter_resume3.png" alt="" title="goole_doc"/></a></li>
                                  <?php }?>
                                  <?php if(!empty($visual_cv) && ($visual_cv != 'http://')){?>
                                <li><a target="_blank" href="<?php echo $visual_cv;?>"><img src="<?php echo $this->webroot;?>images/profile_filter_resume4.png" alt="" title="visual_cv"/></a></li>
                                  <?php }?>
                                  <?php if(!empty($resume_bucket) && ($resume_bucket != 'http://')){?>
                                <li><a target="_blank" href="<?php echo $resume_bucket;?>"><img src="<?php echo $this->webroot;?>images/profile_filter_resume5.png" alt="" title="resume_bucket"/></a></li>
                                  <?php }?>
                                  <?php if(!empty($resume_dot) && ($resume_dot != 'http://')){?>
                                <li><a target="_blank" href="<?php echo $resume_dot;?>"><img src="<?php echo $this->webroot;?>images/profile_filter_resume7.png" alt="" title="resume_dot"/></a></li>
                                  <?php }?>
                                  <?php 
								     if($profList['Professional']['mode_of_contact'] != 'Private')   {
									 if(strstr($profList['Professional']['mode_of_contact'],'Email'))  {
								  ?>
                                 <li><a href="mailto:<?php echo $profList['Professional']['email'];?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon_email.png" alt="" title="Email"/></a></li>
                                 <?php 
								     }
									 if(strstr($profList['Professional']['mode_of_contact'],'Phone'))  {
								 ?>
                                                       
                            	<li><img src="<?php echo $this->webroot;?>images/profile_filter_icon_phone.png" alt="" title="<?php echo $profList['Professional']['phone_nbr'];?>" style="cursor:pointer;"/></li>
                                <?php }} ?> 
                               <?php if(!empty($linkedin) && ($linkedin != 'http://')){?>
                                    <li><a href="<?php echo $linkedin;?>" target="_blank">
                                    <img src="<?php echo $this->webroot;?>images/profile_filter_icon1.png" alt="" title="LinkedIn" /></a></li>
								<?php }?>
                               <?php if(!empty($googleplus) && ($googleplus != 'http://')){?>
                                    <li><a href="<?php echo $googleplus;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon2.png" alt="" title="Google+" /></a></li>
                                <?php }?>
                               <?php if(!empty($facebook) && ($facebook != 'http://')){?>
                                <li><a href="<?php echo $facebook;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon3.png" alt="" title="Facebook" /></a></li>
                            <?php }?>
                               <?php if(!empty($twitter) && ($twitter != 'http://')){?>
                                <li><a href="<?php echo $twitter;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon4.png" alt="" title="Twitter" /></a></li>
                            <?php }?>
                               <?php if(!empty($xing) && ($xing != 'http://')){?>
                                    <li><a href="<?php echo $xing;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon5.png" alt="" title="Xing" /></a></li>
                                <?php }?>
                                
                                <?php if(!empty($github) && ($github != 'http://')){?>
                                    <li><a href="<?php echo $github;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon6.png" alt="" title="Github" /></a></li>
                                <?php }?>
                                 <?php if(!empty($stack_overflow) && ($stack_overflow != 'http://')){?>
                                    <li><a href="<?php echo $stack_overflow;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon7.png" alt="" title="StackOverflow" /></a></li>
                                <?php }?>
                                <?php if(!empty($behance) && ($behance != 'http://')){?>
                                    <li><a href="<?php echo $behance;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon8.png" alt="" title="Behance" /></a></li>
                                <?php }?>
                                 <?php if(!empty($dribble) && ($dribble != 'http://')){?>
                                    <li><a href="<?php echo $dribble;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon9.png" alt="" title="Dribble" /></a></li>
                                <?php }?>
                                 <?php if(!empty($pinterest) && ($pinterest != 'http://')){?>
                                    <li><a href="<?php echo $pinterest;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon10.png" alt=""
                                        title="Pinterest" /></a></li>
                                <?php }?>
                                 <?php if(!empty($apnacircle) && ($apnacircle != 'http://')){?>
                                    <li><a href="<?php echo $apnacircle;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon11.png" alt=""
                                        title="ApnaCircle" /></a></li>
                                <?php }?>
                                <?php if(!empty($blogger[0]) && ($blogger[0] != 'http://')){?>
                                    <li><a href="<?php echo $blogger[0];?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon12.png" alt=""
                                        title="Blogger" /></a></li>
                                <?php }?>
                                <?php if(!empty($skillpages) && ($skillpages != 'http://')){?>
                                    <li><a href="<?php echo $skillpages;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon13.png" alt="" title="Skillpages" /></a></li>
                                <?php }?>
                                 <?php if(!empty($about_me) && ($about_me != 'http://')){?>
                                    <li><a href="<?php echo $about_me;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon14.png" alt="" title="About me" /></a></li>
                                <?php }?>
                                <?php if(!empty($other['website_name']) && ($other['website_name'] != 'http://')){?>
                                    <li><a href="<?php echo $other['website_link'];?>" target="_blank">
                                    <img src="<?php echo $this->webroot;?>images/profile_filter_icon14.png" alt="" title="Others" /></a></li>
                                <?php }?>
                                </ul>
                        </section>
                        <section class="bottom_section">
                        
                        <section class="detail"><span>
                             <?php if(!empty($profList['Professional']['current_company']) && !empty($profList['Professional']['company_website'])){?>
                            
                            <a href="<?php echo $profList['Professional']['company_website'];?>"><?php echo $profList['Professional']['current_company'];?> </a>
                            <?php }?>, 
                              <?php if(!empty($profList['Professional']['current_location'])){
                    			echo $profList['Professional']['current_location'];
                                }?>, 
                                <?php 
										$exp=0;
										if(!empty($profList['Professional']['work_experience'])){
											
											$exp=round(($profList['Professional']['work_experience']/12),1);
											$expInYear=(int)($profList['Professional']['work_experience']/12);
											$expInMonth=(int)($profList['Professional']['work_experience']%12);
											$yearText='Yrs';
											
											if($profList['Professional']['work_experience']<2){
												$yearText='Month';
											}
											if($profList['Professional']['work_experience']<12 && $profList['Professional']['work_experience']>1){
												$yearText='Months';
											}
											if($profList['Professional']['work_experience']==0){
												$yearText='Fresher';
											}
										}?>
                                        <?php 
										if($yearText=='Fresher'){
											echo $yearText;
										}else{
										if($profList['Professional']['work_experience']<12){ echo $expInMonth;} else{ 
										if($expInMonth>0)
										echo $expInYear.'.'.$expInMonth;
										else
										echo $expInYear;
											}?> <?php echo $yearText;}?>,  
                                        <?php /* if(!empty($profList['Professional']['ctc_currency'])){
											$ctc_currency=$profList['Professional']['ctc_currency'];
                    		
                                }?>
                                <?php 
								if(!empty($profList['Professional']['ctc_cycle'])){
								$ctc_cycle=$profList['Professional']['ctc_cycle'];
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
                         
											if(!empty($profList['Professional']['current_ctc'])){
												$current_ctc=$profList['Professional']['current_ctc'];
												$ctc=number_format($current_ctc);
											}
											if(!empty($current_ctc)){
											if(strtolower($ctc_currency)=='inr'){
												
												$ctcInLac=(int)($current_ctc/100000);
												$ctcInThousand=(($current_ctc%100000)/1000);
												if($current_ctc>=100000){
													$ctc=round(($current_ctc/100000),2).' Lac';
												}
												
												$ctcText=strtoupper($profList['Professional']['ctc_currency']).' '.$ctc.' '.$ctcCycle.', ';
											}else{
												$ctcText=strtoupper($profList['Professional']['ctc_currency']).' '.$ctc.' '.$ctcCycle.', ';
											}
											}
											echo $ctcText;?> 
                                             
                                        
                                        <?php if(!empty($profList['Professional']['nationality'])){
                    			echo $profList['Professional']['nationality'].' '.'Citizen';
                                }
		*/						
								?>
                                     </span></section>
                                     
                            <section class="detail"><div class="buttons">
                            <?php 
									$strSkill='';
									if(!empty($profList['Professional']['skills'])){
										$arrSkills=explode(',', $profList['Professional']['skills']);
										foreach($arrSkills as $skill){
											$skill=trim($skill);
											if($skill!='')
											echo "<span>{$skill}</span>";
										}
										
									}?>
                            
                            
                            
                            </div></section>
                            
                            <?php if($profList['Professional']['profile_status']!='U'){?>
                            <section class="detail"><span class="location">Preferred Location(s):</span><div class="city">
                            <?php 
								$prefLocation='NA';
								if(!empty($profList['Professional']['profile_status']) && $profList['Professional']['profile_status']=='NO'){
									$prefLocation=$profList['Professional']['locations_for_new_op'];
								}elseif(!empty($profList['Professional']['profile_status']) && $profList['Professional']['profile_status']=='IO'){
									$prefLocation=$profList['Professional']['locations_for_interesting_op'];
								}
								$arrPrefLocation=explode(',', $prefLocation);
								foreach($arrPrefLocation as $ploc){
									$ploc=trim($ploc);
									if($ploc!='')
									echo "<span>{$ploc} , </span>";
								}?>

                          
                            </div></section>
                            <?php }?>
                        </section>
                    </section>
                </section>
                
                
                 <?php }?>
                
                
               
          <?php
		if($this->Paginator->counter('{:count}')>10) {
?>	
           <div class="paginator">
        <?php echo $this->Paginator->first(' First ', null, null, array('class' => 'disabled')); ?>
        <?php echo $this->Paginator->prev('Previous ', null, null, array('class' => 'disabled')); ?>
        <?php echo $this->Paginator->numbers(array(
				'separator' => '  '
				
)); ?>
       <?php echo $this->Paginator->next(' Next ', null, null, array('class' => 'disabled')); ?>
        <?php echo $this->Paginator->last(' Last ', null, null, array('class' => 'disabled')); ?>
		</div>      
                
   <?php  }
		echo $this->Js->writeBuffer();
		?>
                  <?php }?>
                  
<script type="text/javascript">
$(document).ready(function(e) {

	//update_display(0);
	
});
</script>                  
                