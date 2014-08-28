
<div class="bottom_line profile_page black" id="top_bottom_line">
	<div class="wrapper">
    
    	<div class="select_box" onclick="$('.select_box').removeClass('active'); $(this).addClass('active');">
								<a href="javascript:void(0)">Flag</a>
                                <form name="profFlag" id="profFlag" action="<?php echo $this->webroot;?>recruiters/recruiter_profile/<?php echo $profDetails['Recruiter']['id'];?>" method="post">
								<ul class="drop_down">
                                <?php if(!empty($flagDetails)){?>
                                <input type="hidden" name="data[profFlag][id]" value="<?php echo $flagDetails['ProfessionalFlag']['id'];?>" />
                                <?php 
								$flagType=explode(',',$flagDetails['ProfessionalFlag']['flag_type']);}?>
									<li>
                                    <label><input type="checkbox" name="data[profFlag][FlagType][]" value="Spammer" <?php if(!empty($flagDetails) && in_array('Spammer',$flagType)){ ?> checked="checked" <?php }?>/>Spammer</label></li>
									<li><label><input type="checkbox"  name="data[profFlag][FlagType][]" value="Invalid contact info" <?php if(!empty($flagDetails) && in_array('Invalid contact info',$flagType)){?> checked="checked" <?php }?>/>Invalid contact info</label></li>
									<li><label><input type="checkbox"  name="data[profFlag][FlagType][]" value="Invalid profile info" <?php if(!empty($flagDetails) && in_array('Invalid profile info',$flagType)){?> checked="checked" <?php }?>/>Invalid profile info</label></li>
                                    <li><label><input type="checkbox"  name="data[profFlag][FlagType][]" value="Invalid client" <?php if(!empty($flagDetails) && in_array('Invalid client',$flagType)){?> checked="checked" <?php }?>/>Invalid client</label></li>
                                    <li><label><input type="checkbox"  name="data[profFlag][FlagType][]" value="Others" <?php if(!empty($flagDetails) && in_array('Others',$flagType)){?> checked="checked" <?php }?>/>Others</label></li>
									<li class="last"><input type="text" value="<?php if(!empty($flagDetails)){ echo $flagDetails['ProfessionalFlag']['flag_details']; }else {?>Details<?php }?>" onblur="if(this.value=='')this.value='Details'" onfocus="if(this.value=='Details')this.value=''" name="data[profFlag][details]"><a href="javascript://" onclick="return saveFlagInfo();">Submit</a></li>
								</ul>
                                </form>
							</div>
		<div class="profession recruiter less"><div class="top_line"><?php echo $profDetails['Recruiter']['current_designation']; ?></div></div>
    	<span class="update_date">Updated: <?php echo show_formatted_date($profDetails['Recruiter']['profile_modified_date']); ?></span>
    </div>
</div>

<div class="wrapper">
    <section class="main_container profile">
      <section class="detail_form edit border">
      	<span class="profile_img">
        <?php if(!empty($profDetails['Recruiter']['profile_photo'])){ ?>
        	<img src="<?php echo $this->webroot;?>files/recruiter_images/<?php echo $profDetails['Recruiter']['profile_photo'];?>" height="200" width="205"	alt="" />
        <?php }else{  ?>
        <img src="<?php echo $this->webroot; ?>img/profile_img.png" alt=""/> 
        <?php } ?>
        </span>
        <section class="details">
              <div class="top_row no_border">
              	<span><?php echo $profDetails['Recruiter']['first_name'].' '.$profDetails['Recruiter']['last_name']; ?></span>
              </div>
              <div class="basic_info">
                  <div class="main_info none">
                  	<div class="common_row"><img src="<?php echo $this->webroot; ?>img/company.jpg" alt="" title="Company"/><span><a href="<?php echo $profDetails['Recruiter']['company_website']; ?>" target="_blank"><?php echo $profDetails['Recruiter']['current_company']; ?></a> </span></div>
                    <div class="common_row"><img src="<?php echo $this->webroot; ?>img/location.png" alt="" title="Location"/><span><?php echo $profDetails['Recruiter']['current_location']; ?></span></div>
                    <div class="common_row"><img src="<?php echo $this->webroot; ?>img/skills.jpg" alt="" title="Skills"/><?php echo $profDetails['Recruiter']['current_role']; ?></div>
               		<div class="common_row email"><img src="<?php echo $this->webroot; ?>img/email.png" alt="" title="Email"/><span><a href="mailto:<?php echo $profDetails['Recruiter']['email']; ?>"><?php echo $profDetails['Recruiter']['email']; ?></a></span></div>
                    <div class="common_row"><img src="<?php echo $this->webroot; ?>img/contact.png" alt="" title="Contact"/><span><?php if(!empty($profDetails['Recruiter']['phone_nbr'])) echo $profDetails['Recruiter']['phone_nbr']; else echo 'Unavailable'; ?></span></div>
                    </div>
                  <div class="other_info">
                  	<ul class="icons">
                    <?php 
						if(!empty($profDetails['Recruiter']['online_profiles'])){
						$online_profiles=unserialize(base64_decode($profDetails['Recruiter']['online_profiles'])); 
//							extract($online_profiles);
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
      <img src="<?php echo $this->webroot;?>images/profile_icon14.png" alt="" title="About Me" />
     </a>
    </li>
<?php }?>
<?php } ?>     
                    </ul>
                    <div class="main_section">
                    <div class="common_box none">Hiring for <br><strong id="roleNum"><?php if(!empty($profDetails['Recruiter']['roles'])){ echo count(explode(',',$profDetails['Recruiter']['roles'])); }else{ echo '0'; } ?></strong> <span id="roleText">role<?php if(!empty($profDetails['Recruiter']['roles']) && count(explode(',',$profDetails['Recruiter']['roles']))>1) echo 's'; ?> </span> </div>
                    
                    
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
                   
                    <div class="common_box none last">Experience <strong id="exp_in_years"><?php if($profDetails['Recruiter']['recruiting_experience']<12){ echo $expInMonth;} else{ echo $expInYear.'.'.$expInMonth;}?></strong> <span id="yearText"> <?php echo $yearText;?></span> </div>
                    </div>
                  </div>
              </div>
        </section>
      </section>
      <section class="select_tab">
      	<ul>
        	<li class="active first"><a href="javascript://">Profile</a></li>
           
        </ul>
       
      <section style="display:block" class="recui_tab_detail">
      	<section class="preferred_location">
      		<p>Currently hiring in:</p><div class="locations">
            <?php if(!empty($profDetails['Recruiter']['geographies'])){ 
						$all_geos=explode(',',$profDetails['Recruiter']['geographies']);
							foreach($all_geos as $gs){ 	
							  if(trim($gs))   {
							?>  
                              
                        		<span class="color"><?php echo trim($gs); ?></span>
                         <?php }}}else{ echo '<span class="color">Not Available</span>'; } ?>          	
            			
              
             </div>
      	</section>
      	<section class="five_things">
      		<div class="detail_section first">
                <div class="points recruit">
                	<p><span>Domains:</span> <?php if(!empty($domains)) echo $domains; else echo 'N/A'; ?></p>
                	<p><span>Skills / Technologies:</span> <?php if(!empty($profDetails['Recruiter']['skills'])) echo $profDetails['Recruiter']['skills']; else echo 'Not Available'; ?></p>
					
					<p id="roleList"><span>Roles:</span> <?php if(!empty($profDetails['Recruiter']['roles'])) echo $profDetails['Recruiter']['roles']; else echo 'Not Available'; ?></p>
                	<p><span>Geographies:</span> <?php if(!empty($profDetails['Recruiter']['geographies'])) echo $profDetails['Recruiter']['geographies']; else echo 'Not Available'; ?></p>
                	<p><span>Companies:</span> <?php if(!empty($profDetails['Recruiter']['type_of_companies'])) echo str_replace('_',' ',$profDetails['Recruiter']['type_of_companies']); else echo 'Not Available'; ?>
</p>
					
                	<p><span>Direct Client :</span> 
					<?php if(!empty($reclients['direct'])){ 
							$count_dir=0;
					  			foreach($reclients['direct'] as $redc){ $count_dir++;
					?><a href="<?php if(!empty($redc['company_website'])) echo $redc['company_website']; else echo 'javascript://'; ?>" target="_blank"><?php echo $redc['company_name']; ?><?php if(!empty($redc['candidate_placed'])){ ?><small>(</small><?php echo $redc['candidate_placed']; ?><small>)</small><?php } ?><?php if($count_dir < count($reclients['direct'])) echo ', '; ?></a>
                    <?php }}else{ echo 'Not Available'; } ?></p>
            	<p><span>Indirect Client :</span> 
                    <?php if(!empty($reclients['indirect'])){ 
					 			$count_dir=0;
					  			foreach($reclients['indirect'] as $redc){ $count_dir++;
					?><a href="<?php if(!empty($redc['company_website'])) echo $redc['company_website']; else echo 'javascript://'; ?>" target="_blank"><?php echo $redc['company_name']; ?><?php if(!empty($redc['candidate_placed'])){ ?><small>(</small><?php echo $redc['candidate_placed']; ?><small>)</small><?php } ?><?php if($count_dir < count($reclients['indirect'])) echo ', '; ?></a>
                    <?php }}else{ echo 'Not Available'; } ?>
                    </p>
                
   				</div>
            </div>
      </section>
      </section>
      </section>
   </section>
</div>


<script type="text/javascript">
$(document).ready(function(){
$(document).click(function(event){$('.select_box').removeClass('active');});	
$('.select_box').click(function(event){event.stopPropagation();});
});
function saveFlagInfo(){
	$( "#profFlag" ).submit();
	return false;
}
</script>