<?php if(count($searchData)>0){
	//print_r($searchData).'/n';
	//print_r($domain);
	$this->Paginator->options(array(
'url' => $this->data,
    'update' => '.candidate_details',
    'evalScripts' => true
   
));	
	?>

          
   
   <?php foreach($searchData as $recruiterList){?>  
      	<section class="details_section">
       
                	<span class="img_box">
                    <a href="<?php echo $this->webroot;?>recruiters/recruiter_profile/<?php echo $recruiterList['Recruiter']['id'];?>">
                    <?php if($recruiterList['Recruiter']['profile_photo']!=''){?>
                    <img src="<?php echo $this->webroot;?>files/recruiter_images/<?php echo $recruiterList['Recruiter']['profile_photo'];?>" alt=""/>
                    <?php }else{?>
                    	<img src="<?php echo $this->webroot;?>images/profile_pic.png" alt=""/>
                        <?php }?>
                        </a>
                    </span>
                    <section class="details">
                    	<section class="top_section">
                        	<label><a href="<?php echo $this->webroot;?>recruiters/recruiter_profile/<?php echo $recruiterList['Recruiter']['id'];?>"><?php echo trim($recruiterList['Recruiter']['first_name'].' '.$recruiterList['Recruiter']['last_name']);?></a></label>
                            <?php $online_profiles=unserialize(base64_decode($recruiterList['Recruiter']['online_profiles']));
							
								extract($online_profiles);?>
                            <ul>
                            	<li><a href="mailto:<?php echo $recruiterList['Recruiter']['email'];?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon_email.png" alt="" title="Email"/></a></li>
                                <li><img src="<?php echo $this->webroot;?>images/profile_filter_icon_phone.png" alt="" title="<?php echo $recruiterList['Recruiter']['phone_nbr'];?>" style="cursor:pointer;"/></li>
                                <?php if(!empty($linkedin)){?>
                                    <li><a href="<?php echo $linkedin;?>" target="_blank">
                                    <img src="<?php echo $this->webroot;?>images//profile_filter_icon1.png" alt="" title="Linkdin" /></a></li>
								<?php }?>
                               <?php if(!empty($googleplus)){?>
                                    <li><a href="<?php echo $googleplus;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon2.png" alt="" title="Google+" /></a></li>
                                <?php }?>
                               <?php if(!empty($facebook)){?>
                                <li><a href="<?php echo $facebook;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon3.png" alt="" title="Facebook" /></a></li>
                            <?php }?>
                               <?php if(!empty($twitter)){?>
                                <li><a href="<?php echo $twitter;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon4.png" alt=""
                                    title="Twitter" /></a></li>
                            <?php }?>
                               <?php if(!empty($xing)){?>
                                    <li><a href="<?php echo $xing;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon5.png" alt="" title="Xing" /></a></li>
                                <?php }?>
                                
                                 <?php if(!empty($pinterest)){?>
                                    <li><a href="<?php echo $pinterest;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon10.png" alt=""
                                        title="Pinterest" /></a></li>
                                <?php }?>
                                 <?php if(!empty($apnacircle)){?>
                                    <li><a href="<?php echo $apnacircle;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon11.png" alt=""
                                        title="ApnaCircle" /></a></li>
                                <?php }?>
                                <?php if(!empty($blogger[0])){?>
                                    <li><a href="<?php echo $blogger[0];?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon12.png" alt=""
                                        title="Blogger" /></a></li>
                                <?php }?>
                                <?php if(!empty($skillpages)){?>
                                    <li><a href="<?php echo $skillpages;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon13.png" alt="" title="Skillpages" /></a></li>
                                <?php }?>
                                 <?php if(!empty($about_me)){?>
                                    <li><a href="<?php echo $about_me;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon14.png" alt="" title="About me" /></a></li>
                                <?php }?>
                                <?php if(!empty($other['website_name'])){?>
                                    <li><a href="<?php echo $other['website_link'];?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon14.png" alt="" title="Others" /></a></li>
                                <?php }?>
                               
                               
                              
                              
                               
                                
                              
                            </ul>
                        </section>
                        <section class="bottom_section">
                        	<section class="detail"><span><?php echo $recruiterList['Recruiter']['current_designation'];?>, <a href="<?php echo $recruiterList['Recruiter']['company_website'];?>" target="_blank"><?php echo $recruiterList['Recruiter']['current_company'];?></a></span></section>
                            
                            <?php /*?><section class="detail">
                            <span>
                            <?php 
							$domainList='';
							foreach($recruiterList['RecruiterDomain'] as $dom){
							if(array_key_exists($dom['domain_id'], $domain)){
								$domainList.=$domain[$dom['domain_id']].', ';
							}
							}
							$domainList=rtrim($domainList,', ');
							echo $domainList;
							?>
                           </span></section><?php */?>
                            <section class="detail"><div class="buttons gray">
                            <?php if(!empty($recruiterList['Recruiter']['geographies'])){
								$arrGeographies=explode(',', $recruiterList['Recruiter']['geographies']);
										foreach($arrGeographies as $geographies){
											$geographies=trim($geographies);
											if($geographies!='')
											echo "<span style='margin: 5px 5px 0px 0px !important'>{$geographies}</span>";
										}
                            //echo rtrim($recruiterList['Recruiter']['geographies'],', ');
                             }?>
                            
                            </div></section>
                            <section class="detail"><span class="gray">
                            <?php if(!empty($recruiterList['Recruiter']['current_location'])){
								
                            echo $recruiterList['Recruiter']['current_location'];
                             }?>
                            </span></section>
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
                  
	  
 

  
	
  