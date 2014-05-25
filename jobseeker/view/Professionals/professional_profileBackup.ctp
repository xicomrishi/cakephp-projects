<?php 
if(!empty($profDetails)){
	extract($profDetails['Professional']);	
}
?>
<?php if(isset($profile_status)){
if($profile_status=='NO')
{
	$color="green";
	$text="Currently seeking new opportunities";
}else if($profile_status=='IO')
{
	$color="yellow";
	$text="Always open to interesting opportunities";
}else{
	$color="rad";
	$text="Unavailable.DO NOT DISTURB until";
 if(isset($do_not_disturb_date)){
	 $text=$text." ".show_formatted_date($do_not_disturb_date);
 }
}
	
}?>


<div class="bottom_line <?php echo $color;?>" id="top_bottom_line" style="display:block">
	<div class="wrapper">
    	<div onclick="$('.select_box').removeClass('active'); $(this).addClass('active');" class="select_box black">
			<a href="javascript:void(0)">Flag</a>
            <form name="profFlag" id="profFlag" action="<?php echo $this->webroot;?>professionals/professional_profile/<?php echo $id;?>" method="post">
			<ul class="drop_down">
             <?php if(!empty($flagDetails)){?>
                                <input type="hidden" name="data[profFlag][id]" value="<?php echo $flagDetails['RecruiterFlag']['id'];?>" />
                                <?php 
								$flagType=explode(',',$flagDetails['RecruiterFlag']['flag_type']);}?>
				<li><label><input type="checkbox" name="data[profFlag][FlagType][]" value="Incorrect status" <?php if(!empty($flagDetails) && in_array('Incorrect status',$flagType)){ ?> checked="checked" <?php }?>>Incorrect status</label></li>
				<li><label><input type="checkbox" name="data[profFlag][FlagType][]" value="Incorrect preferred location list" <?php if(!empty($flagDetails) && in_array('Incorrect preferred location list',$flagType)){ ?> checked="checked" <?php }?>>Incorrect preferred location list</label></li>
				<li><label><input type="checkbox" name="data[profFlag][FlagType][]" value="Invalid contact info" <?php if(!empty($flagDetails) && in_array('Invalid contact info',$flagType)){ ?> checked="checked" <?php }?>>Invalid contact info</label></li>
				<li><label><input type="checkbox" name="data[profFlag][FlagType][]" value="Incorrect profile info" <?php if(!empty($flagDetails) && in_array('Incorrect profile info',$flagType)){ ?> checked="checked" <?php }?>>Incorrect profile info</label></li>
				<li class="last"><input type="text" onfocus="if(this.value=='Details')this.value=''" onblur="if(this.value=='')this.value='Details'" value="<?php if(!empty($flagDetails)){ echo $flagDetails['RecruiterFlag']['flag_details']; }else {?>Details<?php }?>" name="data[profFlag][details]"><a href="javascript://" onclick="return saveFlagInfo();">Submit</a></li>
			</ul>
		</div>
        <div onclick="$('.select_box').removeClass('active'); $(this).addClass('active');" class="select_box black">
			<a href="javascript:void(0)">Tag</a>
			<ul class="drop_down tagManange">
            <?php $dispay='none'; 
			if(!empty($tagDetails)){
				$dispay='block';
				foreach($tagDetails as $tags)
				{?>
                <li><label><input type="checkbox" value="<?php echo $tags['ProfessionalTag']['tag_name'];?>" onchange="updateTagStatus(this,'<?php echo $tags['ProfessionalTag']['id'];?>');" <?php if($tags['ProfessionalTag']['tag_status']=='Yes'){ ?> checked="checked" <?php }?> /><?php echo $tags['ProfessionalTag']['tag_name'];?></label></li>
					
				
            <?php }}?>
				
                <li class="popup"><a href="#">Create tag</a>
                    <span class="create">
                        	<input type="text" onfocus="if(this.value=='Create tag')this.value=''" onblur="if(this.value=='')this.value='Create tag'" value="Create tag" name="createTag" id="createTag">
                        	<a href="javascript://" onclick="return addTag();" class="addTagButton"><img src="<?php echo $this->webroot;?>img/yes.png" alt="" title="Post it"></a>
                   </span>
                </li>
				<li class="manageTag" style=" display:<?php echo $dispay;?>;"><a onclick="openLightbox('<?php echo $this->webroot;?>professionals/edit_tags/<?php echo $id;?>');" href="javascript:void(0)">Manage tags</a></li>
			</ul>
		</div>
        <div onclick="$('.select_box').removeClass('active'); $(this).addClass('active');" class="select_box black">
			<a href="javascript:void(0)">Track</a>
			<ul class="drop_down">
				<li><label><input type="checkbox" name="track_status" value="Status change" onchange="updateTrackEvent(this);" <?php if(!empty($trackArray) && in_array('Status change',$trackArray)){ ?> checked="checked" <?php }?>>Status change</label></li>
				<li><label><input type="checkbox" name="track_location" value="Preferred location change" onchange="updateTrackEvent(this);" <?php if(!empty($trackArray) && in_array('Preferred location change',$trackArray)){ ?> checked="checked" <?php }?>>Preferred location change</label></li>
                 <li><label><input type="checkbox" name="track_notice" value="Notice period change" onchange="updateTrackEvent(this);" <?php if(!empty($trackArray) && in_array('Notice period change',$trackArray)){ ?> checked="checked" <?php }?>>Notice period change</label></li>
                <li><label><input type="checkbox" name="track_profile" value="Any profile change" onchange="updateTrackEvent(this);" <?php if(!empty($trackArray) && in_array('Any profile change',$trackArray)){ ?> checked="checked" <?php }?>>Any profile change</label></li>
			</ul>
		</div>
		<div class="profession professional center">
        	<div class="top_line" onclick="$(this).removeClass('active'); $(this).addClass('active')"><?php echo $text;?>
            </div>
        </div>
    	<span class="update_date">Updated: <?php echo show_formatted_date($profile_modified_date); ?></span>
    </div>
</div>



<div class="wrapper">
    <section class="main_container profile">
      <section class="detail_form edit">
      <span class="profile_img_container">
      	<span class="profile_img">
        <?php if(!empty($profile_photo)){?>
		<img src="<?php echo $this->webroot;?>files/professional_images/<?php echo $profile_photo;?>" 
		height="200" width="205" alt="" /><?php 
	 }else{?>
		<img src="<?php echo $this->webroot;?>images/profile_img.png" alt="" /><?php 
	}?>
        </span>
        </span>
        <section class="details">
              <div class="top_row no_border">
              	<div class="e_name"><span id="profName"><?php if(!empty($first_name)){ echo ucfirst($first_name);}if(!empty($last_name)){ echo ' '.ucfirst($last_name);}?></span>
                	
                </div>
              </div>
                    
              <div class="basic_info">
                  <div class="main_info none">
                  <?php if(!empty($current_company)){?>
                  	<div class="common_row"><img title="Company" src="<?php echo $this->webroot;?>images/company.jpg" alt=""><span><a href="<?php echo $company_website;?>" target="_blank"><?php echo $current_company;?></a></span></div>
                    <?php }?>
                   <?php if(!empty($current_location)){?>
<div class="common_row"><img title="Location"
	src="<?php echo $this->webroot;?>images/location.png" alt=""><span><?php echo $current_location;?></span></div>
<?php }?>    
                   <?php if(!empty($nationality)){?>
<div class="common_row"><img title="Nationality"
	src="<?php echo $this->webroot;?>images/nation.png" alt=""><span><?php echo $nationality;?> citizen</span></div>
<?php }?>
                   <?php if(!empty($email)){?>
<div class="common_row email"><img title="Email"
	src="<?php echo $this->webroot;?>images/email.png" alt=""><span><a
	href="mailto:<?php echo $email;?>"><?php echo $email;?></a></span></div>
<?php }?>
                   <?php 
if(!empty($mode_of_contact) && $mode_of_contact=="Private"){?>
	<div class="common_row">
	<img title="Contact" src="<?php echo $this->webroot;?>images/contact.png" alt="">
	<span><?php echo $mode_of_contact;?></span></div><?php 
}else{
	$phone_nbr=trim($phone_nbr,'-');
	?>
	<div class="common_row"><img title="Contact"
		src="<?php echo $this->webroot;?>images/contact.png" alt=""><span><?php if(!empty($phone_nbr)){ $ph_split=explode('-',$phone_nbr); if(!empty($ph_split[1])){  echo $phone_nbr;}else{ echo 'Not Available'; }}else{ echo 'Not Available';}?></span></div>
	<?php }?>
                    
                  </div>
                  <div class="other_info">
                  	<ul class="icons">
                    	<?php $online_profiles=unserialize(base64_decode($online_profiles));
extract($online_profiles);

?>
<?php if(!empty($linkedin)){?>
	<li><a href="<?php echo $linkedin;?>" target="_blank">
	<img src="<?php echo $this->webroot;?>images/profile_icon6.png" alt=""
		title="Linkdin" /></a></li>
<?php }?>

<?php if(!empty($googleplus)){?>
	<li><a href="<?php echo $googleplus;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon5.png" alt=""
		title="Google+" /></a></li>
<?php }?>

<?php if(!empty($facebook)){?>
	<li><a href="<?php echo $facebook;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon4.png" alt=""
		title="Facebook" /></a></li>
<?php }?>

<?php if(!empty($twitter)){?>
	<li><a href="<?php echo $twitter;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon8.png" alt=""
		title="Twitter" /></a></li>
<?php }?>
		
<?php if(!empty($xing)){?>
	<li><a href="<?php echo $xing;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon7.png" alt=""
		title="Xing" /></a></li>
<?php }?>

<?php if(!empty($pinterest)){?>
	<li><a href="<?php echo $pinterest;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon10.png" alt=""
		title="Pinterest" /></a></li>
<?php }?>

		
<?php if(!empty($apnacircle)){?>
	<li><a href="<?php echo $apnacircle;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon2.png" alt=""
		title="apnacircle" /></a></li>
<?php }?>

<?php if(!empty($blogger)){
foreach($blogger as $bloggerx){
	if(!empty($bloggerx)){?>
	<li><a href="<?php echo $bloggerx;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon3.png" alt=""
		title="Blogger" /></a></li>
<?php }
	}
}?>

<?php if(!empty($skillpages)){?>
	<li><a href="<?php echo $skillpages;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_icon9.png" alt=""
		title="Skillpages" /></a></li>
<?php }?>        
                    </ul>
                    <div class="main_section">
                    
 <?php 
$avail='';
$availDate='';
$availDay='';

if(!empty($immediate_joining_flag) && $immediate_joining_flag==1){
	$avail='Available <strong class="availability">Immediately</strong>';
    }else if(!empty($joining_by_date)){
	$avail="Available from <strong class='availability'>".date('d M Y',strtotime($joining_by_date))."</strong>";
	$availDate=date('d M Y',strtotime($joining_by_date));
     }else if(!empty($joining_by_day)){
	$avail="Available in <br/><strong>$joining_by_day</strong> days";
	
}else{
	$avail="N/A";
}

if(!empty($joining_by_day)){
	$availDay=$joining_by_day;
}?>
 <?php if($avail!='N/A'){?>
<div class="common_box none work"><span id="profAvailability"><?php echo $avail;?></span>
   </div>
<?php }?>    

<?php 
$ctc=0;
$ctcCycle='';
if(strtolower($ctc_cycle)=='year'){
	$ctcCycle='annual';
	 }else if(strtolower($ctc_cycle)=='month'){
	$ctcCycle='monthly';
   }else if(strtolower($ctc_cycle)=='hour'){
	$ctcCycle='hourly';
     }else if(strtolower($ctc_cycle)=='week'){
	$ctcCycle='weekly';
     }else if(strtolower($ctc_cycle)=='day'){
	$ctcCycle='daily';
   }
if(!empty($current_ctc)){
	$ctc=number_format($current_ctc);
}
if(!empty($ctc_currency) && strtolower($ctc_currency)=='inr'){
	if(!empty($current_ctc)){
	$ctcInLac=(int)($current_ctc/100000);
	$ctcInThousand=(($current_ctc%100000)/1000);
	if($current_ctc>=100000){
		if(round(($current_ctc/100000),2)>1)
		$ctc='<strong>'.round(($current_ctc/100000),2).'</strong> Lacs';
		else
		$ctc='<strong>'.round(($current_ctc/100000),2).'</strong> Lac';
	}
	}
	$ctc="Current ".$ctcCycle." pay <br/>INR {$ctc}";
}else{
	$ctc="Current ".$ctcCycle." pay <br/>".strtoupper($ctc_currency)." <strong>{$ctc}</strong>";
}
if($current_ctc>0){?>
<div class="common_box none work max"><span id="profCurrentCtc"><?php echo $ctc;?></span>

</div>
<?php }?>         
                    
  <?php 
$exp=0;
if(!empty($work_experience)){
	
	$exp=round(($work_experience/12),1);
	$expInYear=(int)($work_experience/12);
	$expInMonth=(int)($work_experience%12);
	$yearText='yrs';
	
	if($work_experience<2){
		$yearText='month';
	}
	if($work_experience<12 && $work_experience>1){
		$yearText='months';
	}
}?>
<div class="common_box none work last">Experience <br/><strong id="exp_in_years"><?php if($work_experience<12){ echo $expInMonth;} else{ echo $expInYear.'.'.$expInMonth;}?></strong> <span id="yearText"> <?php echo $yearText;?></span> </div>
                        
                    </div>
                  </div>
              </div>
        </section>
      </section>
      
      <section class="recui_tab_detail info first" style="display:block">
      <section class="detail_points">
        <section class="option_row">
        	<section class="inputs">
      			<p>Skills:</p>
           		<div class="buttons">
<?php 
$strSkill='';
if(!empty($skills)){
	$arrSkills=explode(',', $skills);
	foreach($arrSkills as $skill){
		$skill=trim($skill);
		if($skill!='')
		echo "<span>{$skill}</span>";
	}
	
}?>

</div>
      		</section>
            <?php $uploaded_resumes=unserialize(base64_decode($uploaded_resumes));
extract($uploaded_resumes); 

$online_resume_links=unserialize(base64_decode($online_resume_links));
extract($online_resume_links);

?>
<?php if(array_filter($online_resume_links) || array_filter($uploaded_resumes)){?>
             <section class="inputs rightDiv">
                <p>Resume:</p>
                <ul class="resume">
                       <?php if(!empty($doc)){?>
	<a target="_blank" href="<?php echo $this->webroot;?>files/professional_docs/<?php echo $doc;?>"><li title="Doc" class="doc">
	<div class="tooltip">
	<!--<div class="tt"><small class="input_box"><input type="file"></small></div>
	<div class="arrow"></div>-->
	</div>
	</li></a>
    <?php }?>
    <?php if(!empty($pdf)){?>
    <a target="_blank" href="<?php echo $this->webroot;?>files/professional_docs/<?php echo $pdf;?>">
	<li title="PDF" class="pdf">
	<div class="tooltip">
	<div class="tt"><small class="input_box"><input type="file"></small></div>
	<div class="arrow"></div>
	</div>
	</li></a>
     <?php }?>
      <?php if(isset($goole_doc) && !empty($goole_doc)){?>
       <a target="_blank" href="<?php echo $goole_doc;?>">
	<li title="Google Docs" class="googledoc">
        
	
	</li></a>
      <?php }?>
      <?php if(isset($visual_cv) && !empty($visual_cv)){?>
       <a target="_blank" href="<?php echo $visual_cv;?>">
	<li title="Visual CV" class="visualcv">
	
	</li></a>
      <?php }?>
       <?php if(isset($resume_bucket) && !empty($resume_bucket)){?>
       <a target="_blank" href="<?php echo $resume_bucket;?>">
	<li title="Resume Bucket" class="resumenucket">
       
	
	</li>
     </a>
    <?php }?>
     <?php if(isset($resume_dot) && !empty($resume_dot)){?>
      <a target="_blank" href="<?php echo $resume_dot;?>">
	<li title="Resume.com" class="resumedot last">
	
	</li></a>
     <?php } ?>
                    </ul>
         	</section>
            <?php }?>
        </section>
        <?php if((!empty($profile_status) && $profile_status!='U') || !empty($security_clear)){?>
<section class="option_row"> 
<?php if(!empty($profile_status) && $profile_status!='U'){?>
 <section class="inputs">
<p>Preferred Locations:</p>
<div class="buttons">
<?php 
$prefLocation='NA';
if(!empty($profile_status) && $profile_status=='NO'){
	$prefLocation=$locations_for_new_op;
}elseif(!empty($profile_status) && $profile_status=='IO'){
	$prefLocation=$locations_for_interesting_op;
}
$arrPrefLocation=explode(',', $prefLocation);
foreach($arrPrefLocation as $ploc){
	$ploc=trim($ploc);
	if($ploc!='')
	echo "<span>{$ploc}</span>";
}?>

</div>
</section> 
<?php }?>
<?php if(!empty($security_clear)){?>
 <section class="inputs rightDiv">
<p>Security Clearance:</p>
<div class="buttons">
<?php 
if(!empty($security_type_specification)){
	$sec_type=" (Type:".$security_type_specification.")";
}else{
	$sec_type='';	
}
echo "<span>{$security_clear}".$sec_type."</span>";
?>

</div>
</section> 
<?php }?>
</section>
<?php }?>
      </section>
      <!--<section class="notes">
        	<span class="notes_outer">
            	<textarea placeholder="Notes"></textarea>
            </span>
            <span class="notes_msg">"Only visible to you"</span>
      </section>-->
     <?php if(!empty($message_for_recruiters)){?>
<section class="option_row textarea_cl">
<p>Message for recruiters:</p>
<div class="buttons">
<?php 
echo "<span>{$message_for_recruiters}</span>";
?>

</div>
</section> 
<?php }?>   
    </section>
        
      
      </section>
  </div>
  
 <script type="text/javascript">
$(document).ready(function(){
	$('body').click(function(e) {
    var clickedOn = $(e.target);
	if (clickedOn.parents().andSelf().is('.tooltip')||clickedOn.parents().andSelf().is('.notes')||clickedOn.is('.top_line')||clickedOn.is('.e_name')||clickedOn.is('.place')){ }else{
		$('.notes').removeClass('active');
		$('.top_line').removeClass('active');
		$('.e_name').removeClass('active');
		$('.place').removeClass('active');
	}
});
	
$(document).click(function(event){$('.select_box').removeClass('active');});	
$('.select_box').click(function(event){event.stopPropagation();});	
	
$('.cont').click(function(){
	if($('.cont').hasClass('active')){
		$('.cont_dur').show();
		}else{
		$('.cont_dur').hide();
		}
	});	
	
});

$(document).ready(function(){
  $(".popup").click(function(){
   // $(".create").removeClass('active'); 
   if($(this).hasClass('active')){
	   	$(this).removeClass('active');
	 }else{
		$(this).addClass('active');
   }
  });
  $('.create').click(function(event){event.stopPropagation();});
});


function saveFlagInfo(){
	$( "#profFlag" ).submit();
	return false;
}

function updateTrackEvent(obj)
{
	var profId='<?php echo $id;?>';
	
	if($(obj).is(":checked")) {
		$(obj).parent().append('<img id="indiactor" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
		$.post('<?php echo $this->webroot;?>professionals/track_professional_events/'+profId+'/add',{eventVal:obj.value},function(data){
			$('#indiactor').remove();
			/*alert(data);*/
		});
	}else{
		$(obj).parent().append('<img id="indiactor" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
		$.post('<?php echo $this->webroot;?>professionals/track_professional_events/'+profId+'/delete',{eventVal:obj.value},function(data){
			$('#indiactor').remove();
			/*alert(data);*/
		});
	}
}


function updateTagStatus(obj,id)
{
	
	if($(obj).is(":checked")) {
		$(obj).parent().append('<img id="indiactor2" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
		$.post('<?php echo $this->webroot;?>professionals/update_tag_status/'+id+'/Yes',function(data){
			$('#indiactor2').remove();
			/*alert(data);*/
		});
	}else{
		$(obj).parent().append('<img id="indiactor2" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
		$.post('<?php echo $this->webroot;?>professionals/update_tag_status/'+id+'/No',function(data){
			$('#indiactor2').remove();
			/*alert(data);*/
		});
	}
}


function addTag()
{
	var profId='<?php echo $id;?>';
	var tagName=$('#createTag').val();
	if(tagName!='' && tagName!='Create tag')
	{
		$('.addTagButton').append('<img id="indiactor1" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
		$.post('<?php echo $this->webroot;?>professionals/manage_tags/'+profId+'/add',{tagName:tagName},function(data){
			$('#indiactor1').remove();
			
			$('.tagManange').prepend('<li><label><input type="checkbox" value="'+tagName+'" onchange="updateTagStatus(this,'+data+');">'+tagName+'</label></li>');
			$('#createTag').val('Create tag');
			$(".popup").removeClass('active');
			if($('.manageTag').is(':hidden'))
			{
				$('.manageTag').show();
			}
		});
		
	}else{
		alert('Please enter tag name');
	}
}

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
					window.location='<?php echo $this->webroot;?>professionals/professional_profile/<?php echo $id;?>';
					
				}
			}
		);		
}
</script>