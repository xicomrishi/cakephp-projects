<?php echo $this->Html->css('jquery.Jcrop');
echo $this->Html->css('demos');

echo $this->Html->script("frontend/jquery.Jcrop");?>
<style>
.common_box,#profName,.top_line,.main_info{ cursor:pointer;}
.details .basic_info .other_info .main_section .common_box { position:relative; }
.edit .edit_prof_hir{ width:410px !important; }
.edit .edit_prof_hir form input[type="text"]{ width:284px !important; }
.jcrop-holder #preview-pane {
  display: block;
  position: absolute;
  z-index: 2000;
  top: 10px;
  right: -280px;
  padding: 6px;
  border: 1px rgba(0,0,0,.4) solid;
  background-color: white;

  -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px;

  -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
}

/* The Javascript code will set the aspect ratio of the crop
   area based on the size of the thumbnail preview,
   specified here */
#preview-pane .preview-container {
  width: 200px;
  height: 200px;
  overflow: hidden;
}
</style>
<div style="display:none;">
   	  <div class="fancybox_box" id="ImageInFancybox" style="float:left; width:100%!important; height:100%">
      <img id="target" class="targetImg"/>

      <div id="preview-pane">
        <div class="preview-container">
          <img class="jcrop-preview" alt="Preview" />
        </div>
      </div>
      <form action="#" name="cropImageHolder" id="cropImageHolder">
      	<input type="hidden" id="profImageName" name="profImageName" />
  		<input type="hidden" id="x" name="x" />
  		<input type="hidden" id="y" name="y" />
  		<input type="hidden" id="w" name="w" />
  		<input type="hidden" id="h" name="h" />
       <input type="hidden" id="counter" name="counter"/>
        <input type="submit" value="Save" onclick="return cropImage();" class="submit"/>
        <input type="button" value="Delete" onclick="return deleteImage();" class="submit"/>
        <img id="loader" src="<?php echo $this->webroot;?>img/ajax-loader.gif" height="50" width="50" style="display:none;">
        </form>
        
   </div>
   </div>


<div class="bottom_line profile_page black" id="top_bottom_line">
	<div class="wrapper">
		<div class="profession"><div class="top_line"><span class="rec_status"><?php echo $profDetails['Recruiter']['current_designation']; ?></span></div></div>
        
    	<span class="update_date">Updated: <?php echo show_formatted_date($profDetails['Recruiter']['profile_modified_date']); ?></span>
    </div>
</div>

<div class="wrapper">
    <section class="main_container profile">
      <section class="detail_form edit border">
      <?php echo $this->Session->flash();?>
      <span class="profile_img_container">
      	<span class="profile_img">
        <?php if(!empty($profDetails['Recruiter']['profile_photo'])){ ?>
        	<img src="<?php echo $this->webroot;?>files/recruiter_images/<?php echo $profDetails['Recruiter']['profile_photo'];?>" height="200" width="205"	alt="" />
        <?php }else{  ?>
        <img src="<?php echo $this->webroot; ?>img/profile_img.png" alt=""/> 
        <?php } ?>
        </span>
        
        <div class="imgEdit" style="display:none;">
		   <?php if(!empty($profDetails['Recruiter']['profile_photo'])){?>
           <a title="Delete" href="<?php echo $this->webroot;?>recruiters/delete_profile_image" onclick="return confirm('Are you sure you want to remove profile photo?');">Delete</a> 
        <a title="Edit" href="javascript:void(0)" onclick="return imagecropping('<?php echo $profDetails['Recruiter']['profile_photo']; ?>','<?php echo $this->webroot;?>files/recruiter_images/',1);" class="edit_imgcrop">Edit</a> 
        <?php }?>
          <div id="me" class="styleall" style="cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:12px;"><span class="editimage" style=" cursor:pointer;" title="Browse">Change</span></span></div><span id="mestatus" ></span>
        
        </div>
        </span>
        
        <section class="details">
              <div class="top_row no_border">
              	<div id="rec_name" class="e_name"	onclick="$(this).removeClass('active'); $(this).addClass('active');">
              	<span id="profName"><?php echo $profDetails['Recruiter']['first_name'].' '.$profDetails['Recruiter']['last_name']; ?></span>
                
                <!-- edit professional name -->
                <div class="tooltip">
                <div class="tt">
                <div class="edit">
                <input type="button" value="Edit" onclick="$('#edit_prof_name').show();">
                <div class="option_row" id="edit_prof_name">
                <div class="action_msg" id="actMsg"></div>
                <span class="input_text">
                <form name="recruiter_name" action="#" method="post" id="recruiter_name">
                 <input type="text" value="<?php echo $profDetails['Recruiter']['first_name'].' '.$profDetails['Recruiter']['last_name']; ?>" name="data[Recruiter][name]" class="validate[required]" data-errormessage-value-missing="Please enter name">
                 <input type="submit" value="Save" onclick="return updateRecruiters('#recruiter_name','name','#actMsg');"> </form></span> <span class="arrow"> </span></div>
                </div>
                <input type="button" value="Cancel" onclick="stop_propagation(event);$('#rec_name').removeClass('active');$('#edit_prof_name').hide();"> <span class="arrow"> </span></div>
                </div>
                <!-- /edit professional name -->
                </div>
              </div>
              <div class="basic_info">
                  <div id="rec_basic_info" class="main_info"  onclick="$(this).removeClass('active'); $(this).addClass('active');">
                  	<div class="common_row"><img src="<?php echo $this->webroot; ?>img/company.jpg" alt="" title="Company"/><span><a href="<?php echo $profDetails['Recruiter']['company_website']; ?>" target="_blank"><?php echo $profDetails['Recruiter']['current_company']; ?></a> </span></div>
                    <div class="common_row"><img src="<?php echo $this->webroot; ?>img/location.png" alt="" title="Location"/><span><?php echo $profDetails['Recruiter']['current_location']; ?></span></div>
                    <div class="common_row"><img src="<?php echo $this->webroot; ?>img/skills.jpg" alt="" title="Skills"/><?php echo $profDetails['Recruiter']['current_role']; ?></div>
               		<div class="common_row email"><img src="<?php echo $this->webroot; ?>img/email.png" alt="" title="Email"/><span><a href="mailto:<?php echo $profDetails['Recruiter']['email']; ?>"><?php echo $profDetails['Recruiter']['email']; ?></a></span></div>
                    <div class="common_row"><img src="<?php echo $this->webroot; ?>img/contact.png" alt="" title="Contact"/><span><?php if(!empty($profDetails['Recruiter']['phone_nbr'])) echo $profDetails['Recruiter']['phone_nbr']; else echo 'Unavailable'; ?></span></div>
                   
                   <!-- edit basic details -->
                    <div class="tooltip">
                    <div class="tt">
                    <div class="edit" onclick="openLightbox('<?php echo $this->webroot;?>recruiters/edit_basic_details');"><input
                        type="button" value="Edit"></div>
                    <input type="button" value="Cancel" onclick="stop_propagation(event);$('#rec_basic_info').removeClass('active');"> <span class="arrow"> </span></div>
                    </div>
                    <!-- /edit basic details -->
                   
                   
                    </div>
                  <div class="other_info">
                  	<ul class="icons">
                    	<?php 
						  if(!empty($profDetails['Recruiter']['online_profiles'])){
						   $online_profiles=unserialize(base64_decode($profDetails['Recruiter']['online_profiles'])); 
						  // extract($online_profiles);
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
                    	<?php if(!empty($linkedin)){?>
                        <li><a href="<?php echo $linkedin;?>" target="_blank">
                        <img src="<?php echo $this->webroot;?>images/profile_icon1.png" alt=""
                            title="LinkedIn" /></a></li>
							<?php }?>
                            
                            <?php if(!empty($googleplus)){?>
                                <li><a href="<?php echo $googleplus;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon2.png" alt=""
                                    title="Google+" /></a></li>
                            <?php }?>
                            
                            <?php if(!empty($facebook)){?>
                                <li><a href="<?php echo $facebook;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon3.png" alt=""
                                    title="Facebook" /></a></li>
                            <?php }?>
                            
                            <?php if(!empty($twitter)){?>
                                <li><a href="<?php echo $twitter;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon4.png" alt=""
                                    title="Twitter" /></a></li>
                            <?php }?>
                                    
                            <?php if(!empty($xing)){?>
                                <li><a href="<?php echo $xing;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon5.png" alt=""
                                    title="Xing" /></a></li>
                            <?php }?>
                            
                            <?php if(!empty($pinterest)){?>
                                <li><a href="<?php echo $pinterest;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon10.png" alt=""
                                    title="Pinterest" /></a></li>
                            <?php }?>
                            
                                    
                            <?php if(!empty($apnacircle)){?>
                                <li><a href="<?php echo $apnacircle;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon11.png" alt=""
                                    title="Viadeo / Apna Circle" /></a></li>
                            <?php }?>
                            
                            <?php if(!empty($blogger)){
                            foreach($blogger as $bloggerx){
                                if(!empty($bloggerx)){?>
                                <li><a href="<?php echo $bloggerx;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon12.png" alt=""
                                    title="Blogger" /></a></li>
                            <?php }
                                }
                            }?>
                            
                            <?php if(!empty($skillpages)){?>
                                <li><a href="<?php echo $skillpages;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon13.png" alt=""
                                    title="Skillpages" /></a></li>
                            <?php }?>
                            <?php if(!empty($about_me)){?>
                                <li>
                                 <a href="<?php echo $about_me;?>" target="_blank">
                                  <img src="<?php echo $this->webroot;?>images/profile_icon14.png" alt="" title="Skillpages" />
                                 </a>
                                </li>
                            <?php }?>
                        <?php } ?>     
                    </ul>
                    <div class="main_section">
                    
              <div id="rec_hir" onclick="$(this).removeClass('active'); $(this).addClass('active');"	class="common_box work">      
                    Hiring for <br><strong id="roleNum"><?php if(!empty($profDetails['Recruiter']['roles'])){ echo count(explode(',',$profDetails['Recruiter']['roles'])); }else{ echo '0'; } ?></strong> <span id="roleText">role<?php if(!empty($profDetails['Recruiter']['roles']) && count(explode(',',$profDetails['Recruiter']['roles']))>1) echo 's'; ?> </span>
                  <div class="tooltip">
                      <div class="tt">
                        <div class="edit" onclick="$('#edit_prof_hir').show();"><input type="button" value="Edit">
                            <div class="option_row small edit_prof_hir" id="edit_prof_hir">
                                <div class="action_msg" id="expMsg1"></div>
                                <span class="input_text small_text1"> 
                                <form name="recruiter_roles" action="#" method="post" id="recruiter_roles">
                                <label>Roles</label>
                                <input type="text" value="<?php echo $profDetails['Recruiter']['roles'];?>" name="data[Recruiter][roles]" />
                                </span> 
                                <span class="input_text">
                               	 <input type="submit" value="Save" onclick="return updateRecruiters('#recruiter_roles','hiring_roles','#expMsg1');">
                                </span>
                                </form>
                                <span class="arrow"> </span>
                            </div>
                        </div>
                        <input type="button" value="Cancel" onclick="stop_propagation(event);$('#rec_hir').removeClass('active');$('#edit_prof_hir').hide();"> <span class="arrow"> </span></div>
                      </div>
               </div>     
                    
                    
<?php 
$exp=0;
if(!empty($profDetails['Recruiter']['recruiting_experience'])){
	
	$exp=round(($profDetails['Recruiter']['recruiting_experience']/12),1);
	$expInYear=(int)($profDetails['Recruiter']['recruiting_experience']/12);
	$expInMonth=(int)($profDetails['Recruiter']['recruiting_experience']%12);
	$yearText='yrs';
	
	if($profDetails['Recruiter']['recruiting_experience']<2){
		$yearText='month';
	}
	if($profDetails['Recruiter']['recruiting_experience']<12 && $profDetails['Recruiter']['recruiting_experience']>1){
		$yearText='months';
	}
}?>                    
                    
                        <div id="rec_exp" class="common_box" onclick="$(this).removeClass('active'); $(this).addClass('active');">Experience<br/>
                         <strong id="exp_in_years"><?php if($profDetails['Recruiter']['recruiting_experience']<12){ echo $expInMonth;} else{ echo $expInYear.'.'.$expInMonth;}?></strong> <span id="yearText"> <?php echo $yearText;?></span>
                        	<div class="tooltip">
                                <div class="tt">
                                <div class="edit" onclick="$('#edit_prof_exp').show();">
                                 <input type="button" value="Edit">
                                 <div class="option_row small" id="edit_prof_exp">
                                  <div class="action_msg" id="expMsg2"></div>
                                  <span class="input_text small_text1"> 
                                  <form name="recruiter_exp" action="#" method="post" id="recruiter_exp">
                                  <input type="text" value="<?php echo $expInYear;?>" name="data[Recruiter][work_experience][year]" id="exp_years"/>
                                  <label>years</label>
                                  <input type="text" value="<?php echo $expInMonth;?>" name="data[Recruiter][work_experience][month]" id="exp_months"/>
                                  <label>months</label>
                                </span> <span class="input_text"><input type="submit" value="Save" onclick="return updateRecruiters('#recruiter_exp','work_experience','#expMsg2');"></span>
                                </form>
                                <span class="arrow"> </span></div>
                                </div>
                                <input type="button" value="Cancel" onclick="stop_propagation(event);$('#rec_exp').removeClass('active');$('#edit_prof_exp').hide();"> <span class="arrow"> </span></div>
                            </div>
                        </div>
                        
                    </div>
                  </div>
              </div>
        </section>
      </section>
      <section class="select_tab">
      	<ul>
        	<li class="active first"><a href="javascript:void(0)">Profile</a></li>
            <!--<li class="second"><a href="#">Jobs</a></li>-->
            <?php
			  if($profDetails['Recruiter']['flag_search'])   {
			    echo '<li class="second"><a href="javascript:void(0)">Search</a></li>';
			  }
			?>
        </ul>
       
      <section class="recui_tab_detail" style="display:block">
      	<section class="preferred_location">
      		<p>Currently hiring in:</p><div class="locations">
            <?php if(!empty($profDetails['Recruiter']['geographies'])){ 
						$all_geos=explode(',',$profDetails['Recruiter']['geographies']);
							foreach($all_geos as $gs){ 
							
							if(trim($gs)){
								 ?>
                        		<span class="color"><?php echo trim($gs); ?></span>
                         <?php }
							}
						 }else{ echo '<span class="color">Not Available</span>'; } ?>           	
            			
              
             </div>
      	</section>
      	<section class="five_things">
      		<div class="detail_section first">
            	<!--<h3>Recruitment Profile</h3>-->
                <div class="points recruit">
                	<p>
                      <span>Domains:</span>
                      <span class="datainfo"> 
					  <?php if(!empty($domains)) echo $domains; else echo 'N/A'; ?>
                      <?php if(!empty($otherDomain)) echo '('.$otherDomain.')'; ?>
                      </span>
                    </p>
                    <p id="roleList">
                     <span>Roles:</span>
                     <span class="datainfo">
					  <?php if(!empty($profDetails['Recruiter']['roles'])) echo $profDetails['Recruiter']['roles']; else echo 'Not Available'; ?>
                     </span>
                    </p>
                	<p>
                     <span>Companies:</span>
                     <span class="datainfo">
                      <?php if(!empty($profDetails['Recruiter']['type_of_companies'])) echo str_replace('_',' ',$profDetails['Recruiter']['type_of_companies']); else echo 'Not Available'; ?>
                     </span>
                    </p>
                 </div>
                <div class="points recruit">

<!--               	<p><span>Geographies:</span> <?php if(!empty($profDetails['Recruiter']['geographies'])) echo $profDetails['Recruiter']['geographies']; else echo 'Not Available'; ?></p> -->
                	<p>
                     <span>Skills / Technologies:</span>
                     <span class="datainfo"><?php if(!empty($profDetails['Recruiter']['skills'])) echo $profDetails['Recruiter']['skills']; else echo 'Not Available'; ?>
                     </span>
                    </p>
                	<p>
                     <span>Direct Client :</span>
                     <span class="datainfo"> 
					 <?php if(!empty($reclients['direct'])){ 
							$count_dir=0;
					  			foreach($reclients['direct'] as $redc){ $count_dir++;
					 ?><a style="text-decoration:none" href="<?php if(!empty($redc['company_website'])) echo $redc['company_website']; else echo 'javascript:void(0)'; ?>" target="_blank"><?php echo $redc['company_name']; ?><?php if(!empty($redc['candidate_placed'])){ ?><small>(</small><?php echo $redc['candidate_placed']; ?><small>)</small><?php } ?><?php if($count_dir < count($reclients['direct'])) echo ', '; ?></a>
                    <?php }}else{ echo 'Not Available'; } ?>
                    </span>
                   </p>

                	

					
            	    <p> 
                      <span>Indirect Client :</span> 
                      <span class="datainfo">
                       <?php if(!empty($reclients['indirect'])){ 
					 			$count_dir=0;
					  			foreach($reclients['indirect'] as $redc){ $count_dir++;
					  ?><a style="text-decoration:none" href="<?php if(!empty($redc['company_website'])) echo $redc['company_website']; else echo 'javascript:void(0)'; ?>" target="_blank"><?php echo $redc['company_name']; ?><?php if(!empty($redc['candidate_placed'])){ ?><small>(</small><?php echo $redc['candidate_placed']; ?><small>)</small><?php } ?><?php if($count_dir < count($reclients['indirect'])) echo ', '; ?></a>
                    <?php }}else{ echo 'Not Available'; } ?>
                     </span>
                    </p>

                
   				</div>
            </div>
            <!--<div class="detail_section">
            	<h3>Clients</h3>
                <div class="points recruit">
                	<p class="color"><span>Direct Client :</span> 
					<?php if(!empty($reclients['direct'])){ 
							$count_dir=0;
					  			foreach($reclients['direct'] as $redc){ $count_dir++;
					?><a href="<?php if(!empty($redc['company_website'])) echo $redc['company_website']; else echo 'javascript:void(0)'; ?>" target="_blank"><?php echo $redc['company_name']; ?><?php if(!empty($redc['candidate_placed'])){ ?><small>(</small><?php echo $redc['candidate_placed']; ?><small>)</small><?php } ?><?php if($count_dir < count($reclients['direct'])) echo ', '; ?></a>
                    <?php }}else{ echo 'Not Available'; } ?></p>
            	<p class="color"><span>Indirect Client :</span> 
                    <?php if(!empty($reclients['indirect'])){ 
					 			$count_dir=0;
					  			foreach($reclients['indirect'] as $redc){ $count_dir++;
					?><a href="<?php if(!empty($redc['company_website'])) echo $redc['company_website']; else echo 'javascript:void(0)'; ?>" target="_blank"><?php echo $redc['company_name']; ?><?php if(!empty($redc['candidate_placed'])){ ?><small>(</small><?php echo $redc['candidate_placed']; ?><small>)</small><?php } ?><?php if($count_dir < count($reclients['indirect'])) echo ', '; ?></a>
                    <?php }}else{ echo 'Not Available'; } ?>
                    </p>
                </div>
            </div>-->
      </section>
      	<!--<section class="input_row">
        	<p><span>Awards:</span></p>
        </section>-->
      </section>
      
      <section class="recui_tab_detail recruitInfo" style="display:none">
        	<h3>Professional Search</h3>
            <form action="#" name="searchProfessionalForm" method="post" id="searchProfessionalForm" onsubmit="return false;">
      		<div class="inputs">
            	<div class="input_row search">
                 <div>
      			  <input type="text" name="search_prof" class="search_prof" placeholder="Search for rercuiters by skill, company, current location or use advanced search for Boolean / combo search">
                <span><a href="javascript:void(0)" onclick="showProfSearchResult();" id="searchProfButton" class="link">Search</a></span>
                <div style="background-color: #eee;width:79.5%; display:inline-block; margin:10px 0 0 0">
                <div id="searchCriteria" style="display:inline-block; width:100%; border-bottom:1px solid #aaa; padding:5px 0; min-height:24px"></div>
                 <div id="defaultFilter">
                   <ul style="border-bottom: none !important; margin: 10px 0;">
                        <li style="width:33%" onmouseover="$('#expDiv').show();" onmouseout="$('#expDiv').hide();">
                         Experince ▾ 
                          <ul id="expDiv">
                           <li onclick="createDiv('All Experince','1','exp')">All</li>
                           <li onclick="createDiv('0 - 2 years','0-24','exp')">0 - 2 years</li>
                           <li onclick="createDiv('2 - 5 years','25-60','exp')">2 - 5 years</li>
                           <li onclick="createDiv('5 - 10 years','61-120','exp')">5 - 10 years</li>
                           <li onclick="createDiv('10 - 15 years','121-180','exp')">10 - 15 years</li>
                           <li onclick="createDiv('15+ years','181','exp')">15+ years</li>
                          </ul>
                        </li>
                        <li style="width:33%" onmouseover="$('#locDiv').show();" onmouseout="$('#locDiv').hide();">
                         Location ▾ 
                          <ul id="locDiv">
                           <li class="none">
                             <input id="preferredLocation" name="preferredLocation" style="margin-top: 10px;width:168px;" autocomplete="off" placeholder="Preferred Location" onkeyup="autoComplete('preferredLocation')"/>
                             <div id="preferredLocationDiv"></div>
                           </li>
<!--                           <div>India</div>
                           <div>Noida</div>
                           <div>Gurgaon</div>
                           <div>Delhi NCR</div>-->
                           <li class="none"><input id="currentLocation" name="currentLocation" style="margin:10px 0px 5px 0px;width:168px;" placeholder="Current Location" onkeyup="autoComplete('currentLocation')"/>
                            <div id="currentLocationDiv"></div>
                           </li>
                          </ul>
                        </li>
                        <li style="width:33%" onmouseover="$('#avalDiv').show();" onmouseout="$('#avalDiv').hide();">
                         Availability ▾ 
                          <ul id="avalDiv">
                           <li onclick="createDiv('All Availability','0','avail')">All</li>
                           <li onclick="createDiv('30 days or less','0-30','avail')">30 days or less</li>
                           <li onclick="createDiv('45 days or less','31-45','avail')">45 days or less</li>
                           <li onclick="createDiv('2 months or less','46-60','avail')">2 months or less</li>
                           <li onclick="createDiv('More than 2 months','61','avail')">More than 2 months</li>
                          </ul>
                        </li>
                   </ul>
                 </div>
                </div>
               </div> 
              </div>
            </div>
            <section class="filter_candidate" style="display:none;">
            	<?php for($s=1;$s<4;$s++){ ?>
                <input type="hidden" id="status_<?php echo $s; ?>" name="data[status_icons][<?php echo $s ;?>]" class="ico_inputs" value="1"/>
                <?php } ?>
                <input type="hidden" id="status_resume" name="data[status_resume]" class="ico_inputs" value="0"/>
                <input type="hidden" id="status_security" name="data[status_security]" class="ico_inputs" value="0"/>
                <input type="hidden" id="status_phone" name="data[status_phone]" class="ico_inputs" value="0"/>
                <input type="hidden" id="experience" name="data[experience]" class="ico_inputs" value=""/>
                <input type="hidden" id="availability" name="data[availability]" class="ico_inputs" value=""/>
            	<section class="advance_filter">
<!--                	<label>Advanced Filters</label>-->
                	<section class="icons" style="display:block !important">
                    <br/>
                    	<ul>
                        	<li>
                             <a href="javascript:void(0)" onclick="validate_display(1);"> 
                               <img id="1_filter_img" src="<?php echo $this->webroot;?>images/profile_filter_status_green.png" alt="" title="Currently seeking new opportunities"/>
                             </a>
                            </li>
                            <li>
                             <a href="javascript:void(0)" onclick="validate_display(2);">
                              <img id="2_filter_img" src="<?php echo $this->webroot;?>images/profile_filter_status_yellow.png" alt="" title="Always open to interesting opportunities"/> 
                             </a>
                            </li>
                            <li>
                             <a href="javascript:void(0)" onclick="validate_display(3);">
                              <img id="3_filter_img" src="<?php echo $this->webroot;?>images/profile_filter_status_red.png" alt="" title="Unavailable"/>
                             </a>
                            </li>
                            <li>
                             <a href="javascript:void(0)" onclick="validate_display(4);">
                              <img id="4_filter_img" src="<?php echo $this->webroot;?>images/profile_filter_icon_resume.png" alt="" title="resume"/>
                             </a>
                            </li>
                            <li>
                             <a href="javascript:void(0)" onclick="validate_display(5);">
                              <img id="5_filter_img" src="<?php echo $this->webroot;?>images/profile_filter_icon_security.png" alt="" title="security"/>
                             </a>
                            </li>
                        	<!--<li><a href="javascript:void(0)" onclick="validate_display(6);"><img src="<?php echo $this->webroot;?>images/profile_filter_icon_email.png" alt="" title="email"/></a></li>-->
                            <li>
                             <a href="javascript:void(0)" onclick="validate_display(7);">
                              <img id="7_filter_img" src="<?php echo $this->webroot;?>images/profile_filter_icon_phone.png" alt="" title="phone no"/>
                             </a>
                            </li>
                        </ul>
                	</section>
            	</section>
               
            </section>
            <section class="candidate_details">
       
            </section>
      </section>
      
      
      </section>
   </section>
</div>

<script type="text/javascript">

 function autoComplete(field) 
  {
	  var loc = '';
	  if(field == 'currentLocation') {
		  loc = $('#currentLocation').val();
	  }
	  else {
		  loc = $('#preferredLocation').val();
	  }
	  if(loc != '') {
		  $.ajax({
			  'url' : '<?php echo $this->webroot ?>recruiters/location_autocomplete',
			  'type' : 'post',
			  'data': {'location':field,'val':loc},
			  'success' : function(res){
				  $('#'+field+'Div').html(res);
			  }
		  });
	  }
  }

 function locSelected(loc,position)
  {
	  $('#'+position).val(loc);
	  createDiv(loc,loc,position+'small');
  }

 function createDiv(txt,val,field) 
  {
	  switch(field) {
		  case 'exp' : id="exp"; break;
		  case 'avail' : id="avail"; break;
		  case 'preferredLocationsmall' : id="preLoc"; break;
		  case 'currentLocationsmall' : id="currLoc"; break;
		  default : id='';
	  }
      var div = '<div id="'+id+'"><div style="background:#ccc;border-radius: 5px;float: left;height: 20px;padding: 2px 5px;width: auto !important;  margin:0 5px;">';
	  div += '<span style="margin-right:3px; font-size:12px; Color:#333;">';
	  div += txt;
	  div += '</span>';
 	  div += '<img src="<?php echo $this->webroot ?>img/close-tag.png"  style="float:right;margin: 0.5px;" onclick="removeDiv(\''+id+'\')"/>';

//	  div += '<img src="<?php echo $this->webroot ?>img/close-tag.png"  style="float:right;margin: 0.5px;" onclick="$(this).parent().parent().remove();showProfSearchResult()"/>';
	  div += '</div></div>';
	  switch(field) {
		  case 'exp' : $('#searchCriteria > #exp').remove(); $('#experience').val(val); break;
		  case 'avail' : $('#searchCriteria > #avail').remove(); $('#availability').val(val); break;
		  case 'preferredLocationsmall' : $('#searchCriteria > #preLoc').remove(); $('#preferredLocation').val(val); break;
		  case 'currentLocationsmall' : $('#searchCriteria > #currLoc').remove(); $('#currentLocation').val(val); break;
	  }
	  $('#searchCriteria').append(div);
	  showProfSearchResult();
  }

 function removeDiv(ele)
 {
//	 alert(ele);
	 switch(ele) {
		  case 'exp' : $('#searchCriteria > #exp').remove(); $('#experience').remove(); break;
		  case 'avail' : $('#searchCriteria > #avail').remove(); $('#availability').remove(); break;
		  case 'preLoc' : $('#searchCriteria > #preLoc').remove(); $('#preferredLocation').remove(); break;
		  case 'currLoc' : $('#searchCriteria > #currLoc').remove(); $('#currentLocation').remove(); break;
     }
	 showProfSearchResult();
 }

$(document).ready(function(e) {
	jQuery("#recruiter_name").validationEngine('attach',{promptPosition: "bottomLeft",scroll: false});
	
	$('.profile_img').click(function(e) {
			$('.imgEdit').show();
			e.stopPropagation();
			
		});
/*	$('.advance_filter').click(function(e) {
        $('.icons').toggle();
    });*/
	
		
		
		
$('.search_prof').keyup(function(e){
    if(e.keyCode == 13)
    {
		
    $('#searchProfButton').trigger("click");
    }
});
$('input:radio').change(function(e){
        if ($(this).is(':checked')) {
			showProfSearchResult();
           
        }
    });

	 $('.top_line').click(function(e) {
		 var clickedOn = $(e.target);
		$(this).removeClass('active'); $(this).addClass('active');
		if (clickedOn.is('.tooltip .tt input') || clickedOn.is('.status label') || clickedOn.is('.status span') || clickedOn.is('.status img') || clickedOn.is('.status div')){
			e.stopPropagation();
		}else{
		var offset = $(this).offset();
		var pos=e.clientX - offset.left;
		$(this).find('.tooltip').css({'left' : pos});
		}		
 	 });	
		
	 $(document).click(function(e) {	
        var clickedOn = $(e.target);
		
		if (clickedOn.parents().andSelf().is('.tooltip')||clickedOn.parents().andSelf().is('.notes')||clickedOn.is('.top_line') || clickedOn.is('.top_line span')||clickedOn.is('.e_name')||clickedOn.is('.common_box') || clickedOn.is('.common_box strong')|| clickedOn.is('.place') || clickedOn.is('.main_info') || clickedOn.is('.main_info .common_row') || clickedOn.is('.main_info .common_row span') ||clickedOn.is('#profName') || clickedOn.is('#yearText') || clickedOn.is('#profAvailability') || clickedOn.is('.ui-autocomplete .ui-menu-item a')){ }else{
			$('.notes').removeClass('active');
			$('.top_line').removeClass('active');
			$('.e_name').removeClass('active'); 
			$('.place').removeClass('active');
			$('.common_box').removeClass('active');
			$('.main_info').removeClass('active');
			$('#edit_prof_hir,#edit_prof_ctc,#edit_prof_avail,#edit_prof_name,.current_status').hide();
		}
		if(clickedOn.is('.imgEdit a') || clickedOn.is('.styleall span') || clickedOn.is('input[type=file]')){
		}else{
		$('.imgEdit').hide();
		}
		
	});
	});
	


function openLightbox(page)
{
	$.fancybox.open(
			{
				scrolling : 'no',
				'autoSize'     :   false,
				//'width'             : width,
				'type'				: 'ajax',
				//'height'            : height,
				'href'          	: page,
				beforeShow : function(){
				$(".fancybox-skin").addClass("cropphoto");
					},
				'afterClose' : function() {
					window.location='<?php echo $this->webroot;?>recruiters/profile';
					
				}
			}
		);		
}

function updateRecruiters(formid,field,msg){
	var validate = $(formid).validationEngine('validate');
	if(validate){
	if(field=='name'){	
		var value=$(formid+' input[type="text"]').val();
	}
	$(formid).append('<img id="indiactor" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
	$.post('<?php echo $this->webroot;?>recruiters/edit_recruiter_details/'+field,$(formid).serialize(),function(data){
	$('#indiactor').remove();
	
		var result=JSON.parse(data);
		console.log(result);
		
		if(result.Success){
			$(msg).html(result.Success);
			if(field=='name'){
				$('#profName').text(value);
				$('#btn_profile').val(result.first_name);
                setTimeout(function(){
                    $('#rec_name').removeClass('active');
					$('#edit_prof_name').hide();
					},1000);
			}
			if(field=='work_experience'){
				$('#exp_in_years').text(result.value);
				$('#yearText').text(result.yearText);
                setTimeout(function(){
					$('#rec_exp').removeClass('active');
					$('#edit_prof_exp').hide();
					},1000);
			}
			if(field=='hiring_roles')
			{
				$('#roleNum').text(result.roleNum);
				$('#roleText').text(result.roleText);
				$('#roleList').html('<span>Roles: </span>'+result.roleList);	
                setTimeout(function(){
					$('#rec_hir').removeClass('active');
					$('#edit_prof_hir').hide();
					},1000);
			}		
		}else{			
			$(msg).html(result[field]);
		}
	
	setTimeout(function() {
				$(msg).html('');
		}, 5000);
		
	});
	}else{
		$(formid).validationEngine('attach',{promptPosition: "bottomLeft",scroll: false});	
	}
	return false;
	}



function showProfSearchResult(){
	
		//$('.search').append('<img id="indiactor" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
		$('.candidate_details').html('<div style="text-align:center; height:200px; margin-top:50px;"><img id="indiactor" src="<?php echo $this->webroot;?>img/indicator.gif"/></div>');
$.post('<?php echo $this->webroot;?>recruiters/professional_search',$(searchProfessionalForm).serialize(),function(data){
	$('#indiactor').remove();
	if(data!='' && data.trim()!='No Record Found'){
		$('.filter_candidate').show();
		$('.candidate_details').html(data);
	}else{
		$('.filter_candidate').show();
	$('.candidate_details').html('<div class="record_not_found error">'+data+'</div>');
	}
	 $('html,body').animate({scrollTop: $('.icons').offset().top},'slow');
	});
	
	return false;
		
	
}
function showAscDesc(obj){
//	if($('#experience').is(':checked')){
	if(obj.hasClass('inc')){
		obj.removeClass('inc');
		obj.addClass('dec');
//		$('#expOrder').val('desc');
	}else{
		obj.removeClass('dec');
		obj.addClass('inc');
//		$('#expOrder').val('asc');
	}
	$('#experience').val('1');
	$('#expRange').val($('#expRangeDropDown').val());
	showProfSearchResult();
//	}
}
function cropImage()
            {
			var status=checkCoords();
			if(status){
			$('#loader').show();
			$.post('<?php echo $this->webroot;?>recruiters/crop_profile_image/profile',$('#cropImageHolder').serialize(),function(data){
				$('#loader').hide();
				/*$('#profile_photo_name').val(data);
				$('.profile_pic').attr('src', '<?php echo $this->webroot;?>files/temp_professional_images/'+data+'');*/
				
				$.fancybox.close();
				if(data!=''){
					window.location='<?php echo $this->webroot;?>recruiters/profile';
				}
				
				  });
			}
				  return false;
			
           }
		   
	function checkCoords()
	{
		
		if (parseInt($('#w').val())) return true;
		alert('Please select area to crop.');
		return false;
	};

	function deleteImage(){
			   
			   var status1=confirm('Are you sure you want to remove profile photo?');
			   if(status1){
			   var profImageName=$('#profImageName').val();
			  var counter=$('#counter').val();
			   $('#loader').show();
			$.post('<?php echo $this->webroot;?>recruiters/delete_uploaded_image',{profImageName:profImageName,counter:counter},function(data){
				$('#loader').hide();
								
				window.location='<?php echo $this->webroot;?>recruiters/profile';
				
				  });
			   }
				   return false;
			   
		   }
	function imagecropping(file,path,counter){
		
		$('#counter').val(counter);
		$('.targetImg').attr('src', path+file);
					$('.jcrop-preview').attr('src', path+file);
					$('#profImageName').val(file);
					setTimeout(function(){ 
					 $.fancybox.open({
		 				scrolling : 'no',
						href:'#ImageInFancybox',
						width:1000,
						'afterShow' : function() {
							
							var boundx,	boundy;

							// Grab some information about the preview pane
							$preview = $('#preview-pane');
							$pcnt = $('#preview-pane .preview-container');
							$pimg = $('#preview-pane .preview-container img');
							
							xsize = $pcnt.width();
							ysize = $pcnt.height();
							
    
							console.log('init',[xsize,ysize]);
							 $('.targetImg').Jcrop({
							
							  onChange: updatePreview,
							  onSelect: updatePreview,
							  aspectRatio: xsize / ysize
							},function(){
								
								
							  // Use the API to get the real image size
							  var bounds = this.getBounds();
							  boundx = bounds[0];
							  boundy = bounds[1];
							  // Store the API in the jcrop_api variable
							  jcrop_api = this;
						
							  // Move the preview into the jcrop container for css positioning
							  $preview.appendTo(jcrop_api.ui.holder);
							});

							function updatePreview(c)
							{
								$('#x').val(c.x);
								$('#y').val(c.y);
								$('#w').val(c.w);
								$('#h').val(c.h);
							  if (parseInt(c.w) > 0)
							  {
								var rx = xsize / c.w;
								var ry = ysize / c.h;
						
								$pimg.css({
								  width: Math.round(rx * boundx) + 'px',
								  height: Math.round(ry * boundy) + 'px',
								  marginLeft: '-' + Math.round(rx * c.x) + 'px',
								  marginTop: '-' + Math.round(ry * c.y) + 'px'
								});
							  }
							 
							};
					
											
				},
				beforeShow : function(){
				$(".fancybox-skin").addClass("cropphoto");
					},
				afterClose : function() {
					jcrop_api.release();
					$('#w').val('');
					
				}
		 			});
					},800);
					
	}
	$(function(){
		var jcrop_api;
		var btnUpload=$('#me');
		var mestatus=$('#mestatus');
		var files=$('#ImageInFancybox');
		new AjaxUpload(btnUpload, {
			action: '<?php echo $this->webroot;?>recruiters/upload_profile_image',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					mestatus.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				mestatus.html('<img src="<?php echo $this->webroot;?>img/ajax-loader.gif" height="16" width="16">');
			},
			onComplete: function(file, response){
				
				
				//On completion clear the status
				mestatus.html('');
				//On completion clear the status
				/*files.html('');*/
				//Add uploaded file to list
				if(response==="success"){
										
					setTimeout(function(){ 
					imagecropping(file,'<?php echo $this->webroot;?>files/temp_recruiter_images/recruiter_',2);
					},500);
					
					
					
					
				} else{
					$('#mestatus').text(response);
				}
			}
		});
		
	});
	
function validate_display(num)
{
	var img = '';
	if(num != 1 && num != 2 && num != 3 && num != 4 && num != 5 && num != 7) {
			$('.ico_inputs').val(0);
	        $('#ico_'+num).val(1);	
	}
	if(num == 1)  {
	   if($("#1_filter_img").attr('src') == '<?php echo $this->webroot;?>images/profile_filter_status_green.png') {
		   $("#1_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_gray.png');
		   $('#status_1').val(0);
	   }
	   else {
		   $("#1_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_green.png');
		   $('#status_1').val(1);
	   }	
    }
	if(num == 2)  {
	   if($("#2_filter_img").attr('src') == '<?php echo $this->webroot;?>images/profile_filter_status_yellow.png') {
		   $("#2_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_gray.png');
		   $('#status_2').val(0);
	   }
	   else {
		   $("#2_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_yellow.png');
		   $('#status_2').val(1);
	   }	
    }
	if(num == 3)  {
	   if($("#3_filter_img").attr('src') == '<?php echo $this->webroot;?>images/profile_filter_status_red.png') {
		   $("#3_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_redgray.png');
		   $('#status_3').val(0);
	   }
	   else {
		   $("#3_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_red.png');
		   $('#status_3').val(1);
	   }	
    }
	if(num == 4)  {
		if($("#4_filter_img").attr('src') == '<?php echo $this->webroot;?>images/profile_filter_icon_resume.png') {
		   $("#4_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_icon_resumegray.png');
			$('#status_resume').val(0);
		}
		else {
			$("#4_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_icon_resume.png');
			$('#status_resume').val(1);
		}
	}
	if(num == 5)  {
		if($("#5_filter_img").attr('src') == '<?php echo $this->webroot;?>images/profile_filter_icon_security.png') {
		   $("#5_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_icon_securitygray.png');
			$('#status_security').val(0);
		}
		else {
			$("#5_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_icon_security.png');
			$('#status_security').val(1);
		}
	}
	if(num == 7)  {
		if($("#7_filter_img").attr('src') == '<?php echo $this->webroot;?>images/profile_filter_icon_phone.png') {
		   $("#7_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_icon_phonegray.png');
			$('#status_phone').val(0);
		}
		else {
			$("#7_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_icon_phone.png');
			$('#status_phone').val(1);
		}
	}
	
	showProfSearchResult();
}	


function validate_display_old(num)
{
	$('.ico_inputs').val(0);
	$('#ico_'+num).val(1);	
	var img = '';
	if(num == 1)  {
 	   $("#1_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_green.png');
	   $("#2_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_gray.png');
	   $("#3_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_redgray.png');
    }
	if(num == 2)  {
 	   $("#1_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_gray.png');
	   $("#2_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_yellow.png');
	   $("#3_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_redgray.png');
    }
	if(num == 3)  {
 	   $("#1_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_gray.png');
	   $("#2_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_gray.png');
	   $("#3_filter_img").attr('src','<?php echo $this->webroot;?>images/profile_filter_status_red.png');
    }
	showProfSearchResult();
}	

function update_display(val)
{
	if(val==1)
	$('.ico_section').hide();
	$('.ico_inputs').each(function(index, element) {
        if($(this).val()=='1')
		{
			var id=$(this).attr('id');
			id=id.split('_');
			//alert(id);
			$('.icodiv_'+id[1]).show();	
		}	
    });
}
	
function stop_propagation(_e){
	_e.stopPropagation();
}


 
/*$(function(){
	 $(".advance_filter label").click(function(){
		 $(this).toggleClass('active');
	 });
	});*/
</script>