<?php echo $this->Html->css('jquery.Jcrop');
echo $this->Html->css('demos');

echo $this->Html->script("frontend/jquery.Jcrop");?>
<style type="text/css">
.ui-autocomplete{ max-height: 270px !important;overflow: auto; z-index:999;}
</style>
<style type="text/css">
/*.fancybox-wrap {
    width: 1000px !important;
}
.fancybox-skin {
	height:auto !important;
}
.fancybox-inner{
	width: 1000px !important;
}*/
/* Apply these styles only when #preview-pane has
   been placed within the Jcrop widget */
.common_box,#profName,.top_line,.main_info{ cursor:pointer;}
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
<?php //$prof=$this->Session->read('Professional');
//print_r($profDetails);die;
if(!empty($profDetails)){
	extract($profDetails['Professional']);	
}
?>

<?php if(isset($profile_modified_date)){?>
<?php $udate=date("dS M Y",strtotime($profile_modified_date));?>
<?php $newudate=explode(" ",$udate);
$dateNum=substr($newudate[0], 0, 2);
$datesuffix=substr($newudate[0],-2);
}?>
<?php if(isset($profile_status) && $profile_status=='NO'){?>
<div class="bottom_line green" id="top_bottom_line"
	style="display: block">
<div class="wrapper">
<div class="profession">
<div class="top_line"><span class="prof_status">Currently
seeking new opportunities</span>


<div class="tooltip">
<div class="tt">
<div class="edit"><input type="button" value="Edit" onclick="$('.current_status').show();"> <section
	class="current_status">
 <div class="action_msg" id="statusMsg"></div>
<form name="professional_status" action="#" method="post" id="professional_status">
<?php echo $this->Form->input('Professional.profile_status',array('label'=>false,
                	  'type'=>'hidden','id'=>'current_status'));?>
     <section class="status">
<div onclick="setTopBar('yellow_bar');" class="yellow"><label
	onclick="$('.status label').removeClass('active'); $(this).addClass('active');$('.io').show();$('.unavail').hide();$('#current_status').val('IO'); "
	class="status">Always open to interesting opportunities</label>
    <div class="unav_inner io"><label class="pad">Preferred Location</label>

<div class="time_periode">
<div class="input_row">


<?php echo $this->Form->input('Professional.locations_for_interesting_op',array('label'=>false,
                	  'placeholder'=>'Add cities, regions, countries','id'=>'interesting_opportunities','after'=>'<div>(Separate multiple locations by comma)</div>'));?>
</div>
</div>
<input type="submit" value="Save" onclick="return updateProfessionals('#professional_status','profile_status','#statusMsg');"></span></div>
    </div>
</section> <section class="status">

<div onclick="setTopBar('red_bar');" class="rad"><label
	onclick="$('.status label').removeClass('active'); $(this).addClass('active'); $('.unavail').show();$('.io').hide();$('#current_status').val('U');"
	class="status">Unavailable</label>
<div class="unav_inner unavail"><label class="pad">DO NOT DISTURB</label>
<div class="time_periode">
 <div class="input_row do_not_disturb"> <span class="unavailable_box" id="unavailable_by_year_span" onclick="$('.input_row span').removeClass('active'); $(this).addClass('active');$('#unavailable_by_year').val(1);$('#unavailable_by_date').val('');">for 1 Year</span>
             <?php echo $this->Form->input('Professional.do_not_disturb_year_flag',array('label'=>false,
                	  'type'=>'hidden','id'=>'unavailable_by_year'));?> </div>
                      <div class="input_row"> <span id="unavailable_by_date_span" class="unavailable_box" onclick="$('.input_row span').removeClass('active'); $(this).addClass('active');$('#unavailable_by_year').val('');"> <?php echo $this->Form->input('Professional.do_not_disturb_date',array('label'=>false,
                	  'type'=>'text','id'=>'unavailable_by_date','placeholder'=>'until dd/mm/yy','after'=>'<img onclick="$(&apos;#unavailable_by_date&apos;).datepicker(&apos;show&apos;);" src="'.$this->webroot.'images/calender_bg1.png" alt=""/>'));?> </span> </div>
</div>
<!--<div class="time_periode">
 
</div>-->
<input type="submit" value="Save" onclick="return updateProfessionals('#professional_status','profile_status','#statusMsg');"></span></div>
</div>
</section> <span class="arrow"> </span> 
</form></section></div>
<input type="button" value="Cancel" onclick="stop_propagation(event);$('.top_line').removeClass('active');$('.current_status').hide();"> <span class="arrow"> </span></div>
</div>

</div>
</div>

<?php if(isset($profile_modified_date)){?>
<span class="update_date">
<?php //$udate=date("dS M Y",strtotime($profile_modified_date));?>
Updated: <span class="date"><?php echo $dateNum;?></span><?php echo $datesuffix;?><?php echo ' '.$newudate[1];?><?php echo ' ';?><span class="date"><?php echo $newudate[2];?></span>
</span>
<?php }?>

</div>
</div>

<?php }elseif(isset($profile_status) && $profile_status=='IO'){?>

<div class="bottom_line yellow">
<div class="wrapper">
<div class="profession">
<div class="top_line"><span class="prof_status">Always open to interesting opportunities</span>
<div class="tooltip">
<div class="tt">
<div class="edit"><input type="button" value="Edit" onclick="$('.current_status').show();"> <section
	class="current_status"> 
    <div class="action_msg" id="statusMsg"></div>
<form name="professional_status" action="#" method="post" id="professional_status">
<?php echo $this->Form->input('Professional.profile_status',array('label'=>false,
                	  'type'=>'hidden','id'=>'current_status'));?>
    
    <section class="status">
<div onclick="setTopBar('green_bar');" class="green"><label
	onclick="$('.status label').removeClass('active'); $(this).addClass('active');$('.no').show();$('.unavail').hide();$('#current_status').val('NO'); "
	class="status">Currently
seeking new opportunities</label>
    <div class="unav_inner no"><label class="pad">Preferred Location</label>

<div class="time_periode">
<div class="input_row">


<?php echo $this->Form->input('Professional.locations_for_new_op',array('label'=>false,
                	  'placeholder'=>'Add cities, regions, countries','id'=>'new_opportunities','after'=>'<div>(Separate multiple locations by comma)</div>'));?>
</div>
</div>
<input type="submit" value="Save" onclick="return updateProfessionals('#professional_status','profile_status','#statusMsg');"></span></div>
    </div>
</section>
    
    
 
 
 <section class="status">

<div onclick="setTopBar('red_bar');" class="rad"><label
	onclick="$('.status label').removeClass('active'); $(this).addClass('active'); $('.unavail').show();$('.no').hide();$('#current_status').val('U');"
	class="status">Unavailable</label>
<div class="unav_inner unavail"><label class="pad">DO NOT DISTURB</label>
<div class="time_periode">
 <div class="input_row do_not_disturb"> <span class="unavailable_box" id="unavailable_by_year_span" onclick="$('.input_row span').removeClass('active'); $(this).addClass('active');$('#unavailable_by_year').val(1);$('#unavailable_by_date').val('');">for 1 Year</span>
             <?php echo $this->Form->input('Professional.do_not_disturb_year_flag',array('label'=>false,
                	  'type'=>'hidden','id'=>'unavailable_by_year'));?> </div>
                      <div class="input_row"> <span id="unavailable_by_date_span" class="unavailable_box" onclick="$('.input_row span').removeClass('active'); $(this).addClass('active');$('#unavailable_by_year').val('');"> <?php echo $this->Form->input('Professional.do_not_disturb_date',array('label'=>false,
                	  'type'=>'text','id'=>'unavailable_by_date','placeholder'=>'until dd/mm/yy','after'=>'<img onclick="$(&apos;#unavailable_by_date&apos;).datepicker(&apos;show&apos;);" src="'.$this->webroot.'images/calender_bg1.png" alt=""/>'));?> </span> </div>
</div>
<!--<div class="time_periode">
 
</div>-->
<input type="submit" value="Save" onclick="return updateProfessionals('#professional_status','profile_status','#statusMsg');"></span></div>
</div>
</section> <span class="arrow"> </span> 
</form></section></div>
    

<input type="button" value="Cancel" onclick="stop_propagation(event);$('.top_line').removeClass('active');$('.current_status').hide();"> <span class="arrow"> </span></div>
</div>
</div>
</div>

<?php if(isset($profile_modified_date)){?>
<span class="update_date">
<?php //$udate=date("dS M Y",strtotime($profile_modified_date));?>
Updated: <span class="date"><?php echo $dateNum;?></span><?php echo $datesuffix;?><?php echo ' '.$newudate[1];?><?php echo ' ';?><span class="date"><?php echo $newudate[2];?></span>
</span>
<?php }?>

</div>
</div>

<?php }else{?>
<div class="bottom_line rad">
<div class="wrapper">
<div class="profession">
<div class="top_line"><span class="prof_status">Unavailable.
DO NOT DISTURB until <?php if(isset($do_not_disturb_date)){
$date=date("dS M Y",strtotime($do_not_disturb_date));
 $newdate=explode(" ",$date);
$dateNum1=substr($newdate[0], 0, 2);
$datesuffix1=substr($newdate[0],-2);
//echo $date;

?>
<span class="date"><?php echo $dateNum1;?></span><?php echo $datesuffix1;?><?php echo ' '.$newdate[1];?><?php echo ' ';?><span class="date"><?php echo $newdate[2];?></span>
<?php }?>
</span>

<div class="tooltip">
<div class="tt">
<div class="edit"><input type="button" value="Edit" onclick="$('.current_status').show();"> <section
	class="current_status"> 
     <div class="action_msg" id="statusMsg"></div>
<form name="professional_status" action="#" method="post" id="professional_status">
<?php echo $this->Form->input('Professional.profile_status',array('label'=>false,
                	  'type'=>'hidden','id'=>'current_status'));?>
    
    <section class="status">
<div onclick="setTopBar('green_bar');" class="green"><label
	onclick="$('.status label').removeClass('active'); $(this).addClass('active');$('.no').show();$('.io').hide();$('#current_status').val('NO'); "
	class="status">Currently
seeking new opportunities</label>
    <div class="unav_inner no"><label class="pad">Preferred Location</label>

<div class="time_periode">
<div class="input_row">


<?php echo $this->Form->input('Professional.locations_for_new_op',array('label'=>false,
                	  'placeholder'=>'Add cities, regions, countries','id'=>'new_opportunities','after'=>'<div>(Separate multiple locations by comma)</div>'));?>
</div>
</div>
<input type="submit" value="Save" onclick="return updateProfessionals('#professional_status','profile_status','#statusMsg');"></span></div>
    </div>
</section>
    
    
    <section class="status">
<div onclick="setTopBar('yellow_bar');" class="yellow"><label
	onclick="$('.status label').removeClass('active'); $(this).addClass('active');$('.io').show();$('.no').hide();$('#current_status').val('IO'); "
	class="status">Always open to interesting opportunities</label>
    <div class="unav_inner io"><label class="pad">Preferred Location</label>

<div class="time_periode">
<div class="input_row">


<?php echo $this->Form->input('Professional.locations_for_interesting_op',array('label'=>false,
                	  'placeholder'=>'Add cities, regions, countries','id'=>'interesting_opportunities','after'=>'<div>(Separate multiple locations by comma)</div>'));?>
</div>
</div>
<input type="submit" value="Save" onclick="return updateProfessionals('#professional_status','profile_status','#statusMsg');"></span></div>
    </div>
</section>
 <span class="arrow"> </span>
 </form>
  </section></div>
<input type="button" value="Cancel" onclick="stop_propagation(event);$('.top_line').removeClass('active');$('.current_status').hide();"> <span class="arrow"> </span></div>
</div>


</div>
</div>
<?php if(isset($profile_modified_date)){?>
<span class="update_date">
<?php //$udate=date("dS M Y",strtotime($profile_modified_date));?>

Updated: <span class="date"><?php echo $dateNum;?></span><?php echo $datesuffix;?><?php echo ' '.$newudate[1];?><?php echo ' ';?><span class="date"><?php echo $newudate[2];?></span>
</span>
<?php }?>
</div>

</div>

<?php }?>

<!-- /professional profile -->

<div class="wrapper">
<section class="main_container profile">
<section class="detail_form edit">
<?php echo $this->Session->flash();?>
<span class="profile_img_container">
 <span class="profile_img">
	<?php if(!empty($profile_photo)){?>
		<img src="<?php echo $this->webroot;?>files/professional_images/<?php echo $profile_photo;?>" 
		height="200" width="205" alt="" /><?php 
	 }else{?>
		<img src="<?php echo $this->webroot;?>images/profile_img.png" alt="" /><?php 
	}?>
	 </span> 
   <div class="imgEdit" style="display:none;">
   <?php if(!empty($profile_photo)){?>
   	<a title="Delete" href="<?php echo $this->webroot;?>professionals/delete_profile_image" onclick="return confirm('Are you sure you want to remove profile photo?');">Delete</a> 
	<a title="Edit" href="javascript://" onclick="return imagecropping('<?php echo $profile_photo;?>','<?php echo $this->webroot;?>files/professional_images/',1);" class="edit_imgcrop">Edit</a> 
	<?php }?>
  	<div id="me" class="styleall" style="cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:12px;"><span class="editimage" style=" cursor:pointer;" title="Browse">Change</span></span></div><span id="mestatus" ></span>

	</div>
</span>

<section class="details">
<div class="top_row no_border">
<div class="e_name"	onclick="$(this).removeClass('active'); $(this).addClass('active');">
<span id="profName"><?php if(!empty($first_name)){ echo ucfirst($first_name);}if(!empty($last_name)){ echo ' '.ucfirst($last_name);}?></span>

<!-- edit professional name -->
<div class="tooltip">
<div class="tt">
<div class="edit">
<input type="button" value="Edit" onclick="$('#edit_prof_name').show();">
<div class="option_row" id="edit_prof_name">
<div class="action_msg" id="actMsg"></div>
<span class="input_text">
<form name="professional_name" action="#" method="post" id="professional_name">
 <input type="text" value="<?php if(!empty($first_name)){ echo ucfirst($first_name);}if(!empty($last_name)){ echo ' '.ucfirst($last_name);}?>" name="data[Professional][name]">
 <input type="submit" value="Save" onclick="return updateProfessionals('#professional_name','name','#actMsg');"> </form></span> <span class="arrow"> </span></div>
</div>
<input type="button" value="Cancel" onclick="$('#edit_prof_name').hide();"> <span class="arrow"> </span></div>
</div>
<!-- /edit professional name -->

</div>
</div>

<div class="basic_info">
<div class="main_info" onclick="$(this).removeClass('active'); $(this).addClass('active'); ">
<div class="common_row">
<?php if(!empty($current_company)){?>
<img title="Company" src="<?php echo $this->webroot;?>images/company.jpg" alt=""><span><a href="<?php echo $company_website;?>"
	target="_blank"><?php echo $current_company;?></a></span></div>
<?php }?>

<?php if(!empty($current_location)){?>
<div class="common_row" onclick="$('#tooltip').css('display','block')">
 <img title="Location" src="<?php echo $this->webroot;?>images/location.png" alt=""><span><?php echo $current_location;?></span></div>
<?php }?>
	
<?php if(!empty($nationality)){?>
<div class="common_row" onclick="$('#tooltip').css('display','block')">
<img title="Nationality" src="<?php echo $this->webroot;?>images/nation.png" alt=""><span><?php echo $nationality;?> citizen</span></div>
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
	<div class="common_row" onclick="$('#tooltip').css('display','block')"><img title="Contact"
		src="<?php echo $this->webroot;?>images/contact.png" alt=""><span><?php if(!empty($phone_nbr)){ $ph_split=explode('-',$phone_nbr); if(!empty($ph_split[1])){  echo $phone_nbr;}else{ echo 'Not Available'; }}else{ echo 'Not Available';}?></span></div>
	<?php
}?>


<!-- edit basic details -->
<div class="tooltip" id="tooltip">
<div class="tt">
<div class="edit" onclick="openLightbox('<?php echo $this->webroot;?>professionals/edit_basic_details');">
<input type="button" value="Edit"></div>
<input type="button" value="Cancel" onclick="$('#tooltip').css('display','none')"><span class="arrow"> </span></div>
</div>
<!-- /edit basic details -->
</div>

<div class="other_info">
<ul class="icons">

<?php 
   $online_profiles=unserialize(base64_decode($online_profiles));
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
   //extract($online_profiles);
   //echo '<pre>';print_r($online_profiles); die;
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

<?php if(!empty($github)){?>
	<li>
     <a href="<?php echo $github;?>" target="_blank">
      <img src="<?php echo $this->webroot;?>images/profile_icon6.png" alt="" title="Github" />
     </a>
    </li>
<?php }?>

<?php if(!empty($stack_overflow)){?>
	<li>
     <a href="<?php echo $stack_overflow;?>" target="_blank">
      <img src="<?php echo $this->webroot;?>images/profile_icon7.png" alt="" title="Stack Overflow" />
     </a>
    </li>
<?php }?>

<?php if(!empty($behance)){?>
	<li>
     <a href="<?php echo $behance;?>" target="_blank">
      <img src="<?php echo $this->webroot;?>images/profile_icon8.png" alt="" title="Behance" />
     </a>
    </li>
<?php }?>

<?php if(!empty($dribble)){?>
	<li>
     <a href="<?php echo $dribble;?>" target="_blank">
      <img src="<?php echo $this->webroot;?>images/profile_icon9.png" alt=""
		title="Dribble" /></a></li>
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

</ul>

<div class="main_section">

<?php 
$avail='';
$availDate='';
$availDay='';

if(!empty($immediate_joining_flag) && $immediate_joining_flag==1){
	$avail='Available <strong class="availability">Immediately</strong>';?>
    <script type="text/javascript">
		       $(function(){
			      $("#immediate_joining_span").trigger('click');
		      });	       
		    </script>
<?php }else if(!empty($joining_by_date)){
	$avail="Available from <strong class='availability'>".date('d M Y',strtotime($joining_by_date))."</strong>";
	$availDate=date('d M Y',strtotime($joining_by_date));?>
    <script type="text/javascript">
		       $(function(){
			       $("#joining_by_date_span").trigger('click');
		      });	       
		    </script>
<?php }else if(!empty($joining_by_day)){
	$avail="Available in <br/><strong>$joining_by_day</strong> days";
	
}else{
	$avail="N/A";
}

if(!empty($joining_by_day)){
	$availDay=$joining_by_day;
}?>
<?php if($avail!='N/A'){?>
<div id="prof_availbility" onclick="$('.work').removeClass('active'); $(this).addClass('active'); "
	class="common_box work"><span id="profAvailability"><?php echo $avail;?></span>
   

<div class="tooltip">
<div class="tt">
<div class="edit"><input type="button" value="Edit" onclick="$('#edit_prof_avail').show();">
<div class="option_row middle" id="edit_prof_avail">
<div class="action_msg" id="availMsg"></div>
<form name="professional_avail" action="#" method="post" id="professional_avail">
<div class="buttons start">
<div class="input_row"><span id="immediate_joining_span" onclick="$('.start span').removeClass('active'); $(this).addClass('active'); $('#start_immediately').val('1');$('#joining_by_date').val('');$('#joining_by_day').val('');">Immediately</span></div>
</div>
<?php echo $this->Form->input('Professional.immediate_joining_flag',array('label'=>false,
          			  'type'=>'hidden','id'=>'start_immediately'));?>
<div class="buttons start">
<div class="input_row"> <span id="joining_by_date_span"  onclick="$('.start span').removeClass('active'); $(this).addClass('active');$('#start_immediately').val('');$('#joining_by_day').val('');">
         
          	<?php 
			
			echo $this->Form->input('Professional.joining_by_date',array('label'=>false,
          			  'type'=>'text','value'=>$availDate,'placeholder'=>date('d M Y'),'id'=>'joining_by_date','after'=>'<img onclick="$(&apos;#joining_by_date&apos;).datepicker(&apos;show&apos;);" src="'.$this->webroot.'images/calender_bg1.png" alt="">'));?>
          			   
           </span> </div>
</div>
<span class="input_text small_text1"><?php echo $this->Form->input('Professional.joining_by_day',array('label'=>false,
          			  'type'=>'text','value'=>$availDay,'onfocus'=>'return resetJoinDate(this);','id'=>'joining_by_day'));?></span>
<span class="input_text small_text1"><label class="last">Days from Offer</label></span>
<span class="input_text small_text1"><input type="submit" value="Save" onclick="return updateProfessionals('#professional_avail','availability','#availMsg');"></span>
<span class="arrow"> </span></div>

</div>
</form>
<input type="button" value="Cancel" onclick="$('#edit_prof_avail').hide();stop_propagation(event);$('#prof_availbility').removeClass('active');"> <span class="arrow"> </span></div>

</div>


</div>
<?php }?>
<?php 
$ctc=0;
$ctcCycle='';
if(strtolower($ctc_cycle)=='year'){
	$ctcCycle='annual';?>
	 <script type="text/javascript">
		       $(function(){
			      $(".ctc_cycle_year_span").trigger('click');
		      });	       
		    </script>
<?php }else if(strtolower($ctc_cycle)=='month'){
	$ctcCycle='monthly';?>
    <script type="text/javascript">
		       $(function(){
			      $(".ctc_cycle_month").trigger('click');
		      });	       
		    </script>
<?php }else if(strtolower($ctc_cycle)=='hour'){
	$ctcCycle='hourly';?>
    <script type="text/javascript">
		       $(function(){
			      $(".ctc_cycle_hour").trigger('click');
		      });	       
		    </script>
<?php }else if(strtolower($ctc_cycle)=='week'){
	$ctcCycle='weekly';?>
    <script type="text/javascript">
		       $(function(){
			      $(".ctc_cycle_week").trigger('click');
		      });	       
		    </script>
<?php }else if(strtolower($ctc_cycle)=='day'){
	$ctcCycle='daily';?>
    <script type="text/javascript">
		       $(function(){
			      $(".ctc_cycle_day").trigger('click');
		      });	       
		    </script>
<?php /*}
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
}*/?>
<?php }
if(!empty($current_ctc)){
	$ctc=number_format($current_ctc);
}
if(!empty($ctc_currency) && strtolower($ctc_currency)=='inr'){
	if(!empty($current_ctc)){
	$ctcInLac=(int)($current_ctc/100000);
	$ctcInThousand=(($current_ctc%100000)/1000);
	if($current_ctc>=100000){
		if(round(($current_ctc/100000),2)>1)
		$ctc='<strong>'.$ctcInLac.'.'.$ctcInThousand.'</strong> Lacs';
		else
		$ctc='<strong>'.$ctcInLac.'.'.$ctcInThousand.'</strong> Lac';
	}
	}
	$ctc="Current ".$ctcCycle." pay <br/>INR {$ctc}";
}else{
	$ctc="Current ".$ctcCycle." pay <br/>".strtoupper($ctc_currency)." <strong>{$ctc}</strong>";
}?>
 <script type="text/javascript">
		       $(function(){
				   $(".common_box").removeClass('active');
				    });	       
		    </script>
 
<?php if($current_ctc>0){?>
<div id="prof_current_annual_pay" onclick="$('.work').removeClass('active'); $(this).addClass('active'); "
	class="common_box work max"><span id="profCurrentCtc"><?php echo $ctc;?></span>

<div class="tooltip">
 <div class="tt">
  <div class="edit">
   <input type="button" value="Edit" onclick="$('#edit_prof_ctc').show();">
   <div class="option_row" id="edit_prof_ctc" style="width: 517px !important;right: -100px !important;">
    <div class="action_msg" id="ctcMsg"></div>
    <form name="professional_ctc" action="#" method="post" id="professional_ctc">
     <input type="hidden" value="<?php echo $ctc_cycle;?>" id="current_ctc_cycle" name="data[Professional][ctc_cycle]">
     <?php if(strtolower($ctc_currency) =='inr'){?>
     <div id="valCh">
      <div class="input_text expert_salary small_text2"><!--<label class="pad">ctc</label>-->
       <input class="less" type="text" value="INR" name="data[Professional][ctc_currency]" onchange="return currencyVal(this);" />
       <input type="text" value="<?php echo $ctcInLac;?>" name="data[Professional][current_ctc][lacs]"/> 
       <label class="pad">Lacs</label>
        <input type="text" value="<?php echo $ctcInThousand;?>" name="data[Professional][current_ctc][thousands]"/>
       <label class="pad">Thousand per</label>
       <div class="buttons expected">
       <span class="ctc_cycle_month" onclick="$('.expected span').removeClass('active'); $(this).addClass('active');$('#current_ctc_cycle').val('Month'); ">Month</span>
      <span class="ctc_cycle_year_span" onclick="$('.expected span').removeClass('active'); $(this).addClass('active'); $('#current_ctc_cycle').val('Year');">Year</span>
<!--<span
	onclick="$('.expected span').removeClass('active'); $(this).addClass('active'); ">+</span>-->
</div>
<!--<label class="pad">(Hidden from Recruiters)</label>--></div>

<span class="input_text">
 <input type="submit" value="Save" onclick="return updateProfessionals('#professional_ctc','current_ctc','#ctcMsg');"></span> 

<span class="arrow"> </span>

</div>
<?php }else{?>
<div id="valCh">
 <div class="input_text expert_salary small_text2"><!--<label class="pad">ctc</label>-->
  <input	class="less" type="text" value="<?php echo strtoupper($ctc_currency);?>" name="data[Professional][ctc_currency]" onchange="return currencyVal(this);"/>
<input type="text" value="<?php echo $current_ctc;?>" name="data[Professional][current_ctc][dollar]"/> <label class="pad">per</label>
<div class="buttons expected"><span class="ctc_cycle_hour" onclick="$('.expected span').removeClass('active'); $(this).addClass('active');$('#current_ctc_cycle').val('Hour'); ">Hour</span>
<span class="ctc_cycle_day" onclick="$('.expected span').removeClass('active'); $(this).addClass('active'); $('#current_ctc_cycle').val('Day');">Day</span>
<span class="ctc_cycle_week" onclick="$('.expected span').removeClass('active'); $(this).addClass('active'); $('#current_ctc_cycle').val('Week');">Week</span>
<span class="ctc_cycle_year_span" onclick="$('.expected span').removeClass('active'); $(this).addClass('active'); $('#current_ctc_cycle').val('Year');">Year</span>
<!--<span
	onclick="$('.expected span').removeClass('active'); $(this).addClass('active'); ">+</span>-->
</div>
<!--<label class="pad">(Hidden from Recruiters)</label>--></div>
<span class="input_text"><input type="submit" value="Save" onclick="return updateProfessionals('#professional_ctc','current_ctc','#ctcMsg');"></span> <span
	class="arrow"> </span>
    
    </div>
    
    <?php }?>
    
 </div>  
  </form>
</div>

<input type="button" value="Cancel" onclick="stop_propagation(event);$('#edit_prof_ctc').hide();$('#prof_current_annual_pay').removeClass('active');"> <span class="arrow"> </span></div>
</div>

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

<div id="prof_work_exp" onclick="$(this).removeClass('active'); $(this).addClass('active'); "
	class="common_box work last">Experience <br/><strong id="exp_in_years"><?php if($work_experience<12){ echo $expInMonth;} else{ echo $expInYear.'.'.$expInMonth;}?></strong> <span id="yearText"> <?php echo $yearText;?></span>
	
	
<div class="tooltip">
	<div class="tt">
	<div class="edit" onclick="$('#edit_prof_exp').show();">
		<input type="button" value="Edit">
		<div class="option_row small" id="edit_prof_exp">
		<div class="action_msg" id="expMsg"></div>
		<span class="input_text small_text1"> 
		<form name="professional_exp" action="#" method="post" id="professional_exp">
		<input type="text" value="<?php echo $expInYear;?>" name="data[Professional][work_experience][year]" id="exp_years"/><label>years</label><input type="text" value="<?php echo $expInMonth;?>" name="data[Professional][work_experience][month]" id="exp_months"/><label>months</label>
		</span> <span class="input_text"><input type="submit" value="Save" onclick="return updateProfessionals('#professional_exp','work_experience','#expMsg');"></span>
		</form>
		<span class="arrow"> </span></div>
	</div>
	<input type="button" value="Cancel" onclick="stop_propagation(event);$('#edit_prof_exp').hide();$('#prof_work_exp').removeClass('active');"> <span class="arrow"> </span>
	</div>
</div>

</div>

</div>
</div>
</div>
</section> 


</section> 
<section class="recui_tab_detail info first"
	style="display:block"> <section class="option_row"> <section
	class="inputs">
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
//extract($uploaded_resumes); 

$online_resume_links=unserialize(base64_decode($online_resume_links));
//extract($online_resume_links);
	$doc = $uploaded_resumes['doc'];
	$pdf = $uploaded_resumes['pdf'];
	$goole_doc = $online_resume_links['goole_doc'];
	$visual_cv = $online_resume_links['visual_cv'];
	$resume_bucket = $online_resume_links['resume_bucket'];
	$resume_dot = $online_resume_links['resume_dot'];

?>
<?php if(array_filter($online_resume_links) || array_filter($uploaded_resumes)){?>
 <section class="inputs rightDiv">
<p class="">Resume:</p>
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
      <?php if(isset($goole_doc) && !empty($goole_doc) && filter_var($goole_doc,FILTER_VALIDATE_URL)){?>
       <a target="_blank" href="<?php echo $goole_doc;?>">
	<li title="Google Docs" class="googledoc">
        
	
	</li></a>
      <?php }?>
      <?php if(isset($visual_cv) && !empty($visual_cv) && filter_var($visual_cv,FILTER_VALIDATE_URL)){?>
       <a target="_blank" href="<?php echo $visual_cv;?>">
	<li title="Visual CV" class="visualcv">
	
	</li></a>
      <?php }?>
       <?php if(isset($resume_bucket) && !empty($resume_bucket) && filter_var($resume_bucket,FILTER_VALIDATE_URL)){?>
       <a target="_blank" href="<?php echo $resume_bucket;?>">
	<li title="Resume Bucket" class="resumenucket">
       
	
	</li>
     </a>
    <?php }?>
     <?php if(isset($resume_dot) && !empty($resume_dot) && filter_var($resume_dot,FILTER_VALIDATE_URL)){?>
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
<?php if(!empty($tagDetails)){ $tagTitle='';?>
<section class="option_row"> 
<p>Tags:</p>
<?php foreach($tagDetails as $tags){
$tagTitle.=$tags['ProfessionalTag']['tag_name'].', ';
 }
 $tagTitle=rtrim($tagTitle,', ');?>
 <span><?php echo $tagTitle;?></span>
</section>
<?php }?>
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

<!-- /professional profile -->

<section class="recui_tab_detail info" style="display:block">
        	<h3>Recruiter  Search </h3>
            <form action="#" name="searchForm" method="post" id="searchForm" onsubmit="return false;">
           
      		<div class="input_row search">
      			<input type="text" name="search_cont" class="search_cont" value="Search for rercuiters by name, company, current location" onblur="if(this.value=='')this.value='Search for rercuiters by name, company, current location'" onfocus="if(this.value=='Search for rercuiters by name, company, current location')this.value=''">
                <input type="submit" name="submit" value="Search" />
                <a href="javascript://" onclick="showSearchResult();" id="searchButton">Search</a>
            </div>
            
           <section class="filter_candidate" style="display:none">
            	<!--<section class="advance_filter">
                	<label>Advanced Filters</label>
                	<section class="icons">
                    	<ul>
                        	<li><a href=""><img src="<?php //echo $this->webroot;?>images/profile_filter_icon_email.png" alt=""></a></li>
                            <li><a href=""><img src="<?php //echo $this->webroot;?>images/profile_filter_icon_phone.png" alt=""></a></li>
                        </ul>
                	</section>
            	</section>-->
                <section class="location_filter">
                	<label>Sort by:</label>
                	<input type="radio" name="hiringLoc"><label>Hiring Location</label>
            	</section>
            </section>
            
            <section class="candidate_details"> 
            
      </section>
      </form>
      </section> 
</section> 
</section>
</div>


<script type="text/javascript">
$(document).ready(function(){

	$('.profile_img').click(function(e) {
		$('.imgEdit').show();
		e.stopPropagation();
		
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
		//alert(e.toSource());
		
	
	
    /*alert(e.clientY - offset.top);*/
  });

	$( "#unavailable_by_date" ).datepicker({
		minDate: 0,
		 	maxDate: '+1Y', 
			numberOfMonths: 1,
			showButtonPanel : false,
			changeMonth: false,
			dateFormat : "dd-M-yy",
			duration: 100,
			beforeShow: function(input, inst) {
				/*$.datepicker._clearDate(this);*/
        		insertMessage();
				if($("#unavailable_by_date").val()!='')
				changeMonth();
				
				
   			}
  	});

	$( "#joining_by_date" ).datepicker({
		minDate: 0,
		maxDate: '+6M',
		numberOfMonths : 1,
			showButtonPanel : false,
			changeMonth: false,
			changeYear: false,
			dateFormat : "dd-M-yy",
			duration: 100,
			beforeShow: function(input, inst) {
				/*$.datepicker._clearDate(this);*/
        		insertMessage1();
				if($("#joining_by_date").val()!='')
				changeMonth1();
				
				
   			}
			
  	});
	
	function split( val ) {
		return val.split( /,\s*/ );
		}
 
		function extractLast( term ) {
			return split( term ).pop();
			}
 
			$( "#new_opportunities" ).autocomplete({
			source: function( request, response ) {
			$.getJSON( "<?php echo Router::url('/', true);?>professionals/findPreferredLocation", {
			term: extractLast( request.term )
			}, response );
			},
			minChars: 2,
			search: function () {
        // custom minLength
				var term = extractLast(this.value);
				if (term.length < 2) {
					return false;
				}
			},
			select: function( event, ui ) {
			// Add the selected term appending to the current values with a comma
			var terms = split( this.value );
			// remove the current input
			terms.pop();
			// add the selected item
			terms.push( ui.item.value );
			// join all terms with a comma
			this.value = terms.join( ", " );
			return false;
			},
			focus: function() {
			// prevent value inserted on focus when navigating the drop down list
			return false;
			}
			});
			
			$( "#interesting_opportunities" ).autocomplete({
			source: function( request, response ) {
			$.getJSON( "<?php echo Router::url('/', true);?>professionals/findPreferredLocation", {
			term: extractLast( request.term )
			}, response );
			},
			minChars: 2,
			search: function () {
        // custom minLength
				var term = extractLast(this.value);
				if (term.length < 2) {
					return false;
				}
			},
			select: function( event, ui ) {
			// Add the selected term appending to the current values with a comma
			var terms = split( this.value );
			// remove the current input
			terms.pop();
			// add the selected item
			terms.push( ui.item.value );
			// join all terms with a comma
			this.value = terms.join( ", " );
			return false;
			},
			focus: function() {
			// prevent value inserted on focus when navigating the drop down list
			return false;
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
			$('#edit_prof_exp,#edit_prof_ctc,#edit_prof_avail,#edit_prof_name,.current_status').hide();
		}
		if(clickedOn.is('.imgEdit a') || clickedOn.is('.styleall span') || clickedOn.is('input[type=file]')){
		}else{
		$('.imgEdit').hide();
		}
		
	});
	
	$('.cont').click(function(){
		if($('.cont').hasClass('active')){
			$('.cont_dur').show();
		}else{
			$('.cont_dur').hide();
		}
	});	
	$('input:radio[name="hiringLoc"]').change(function(e){
        if ($(this).is(':checked')) {
			showSearchResult();
           
        }
    });
	$('.search_cont').keyup(function(e){
    if(e.keyCode == 13)
    {
        $('#searchButton').trigger("click");
    }
});
	
});

</script>
<script language="JavaScript">


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
					window.location='<?php echo $this->webroot;?>professionals/profile';
					
				}
			}
		);		
}
function updateProfessionals(formid,field,msg){
	if(field=='name'){	
		var value=$(formid+' input[type="text"]').val();
	}
	$(formid).append('<img id="indiactor" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
	$.post('<?php echo $this->webroot;?>professionals/edit_professional_details/'+field,$(formid).serialize(),function(data){
	$('#indiactor').remove();
		var result=JSON.parse(data);
		if(result.Success){
			$(msg).html(result.Success);
			if(field=='name'){
			$('#profName').text(value);
			}
			if(field=='work_experience'){
				$('#exp_in_years').text(result.value);
				$('#yearText').text(result.yearText);
			}
			if(field=='current_ctc'){
			var ctcText="Current "+result.cycle+" pay <br/>"+result.currency+" "+result.value;
			$('#profCurrentCtc').html(ctcText);
			}
			if(field=='availability'){
			$('#profAvailability').html(result.value);
			}
			if(field=='profile_status'){
				window.location='<?php echo $this->webroot;?>professionals/profile';
			}
			
		}else{
			$(msg).html(result[field]);
		}
		setTimeout(function() {
				$(msg).html('');
				window.location='<?php echo $this->webroot;?>professionals/profile';
		}, 1000);
		
	});
	return false;
	
}

function currencyVal(obj,val){
	var val=$(obj).val();
	//alert(val);	
	if(val.toLowerCase()=='inr'){
		var html='<div class="input_text expert_salary small_text2"><input class="less" type="text" value="INR" name="data[Professional][ctc_currency]" onchange="return currencyVal(this);" /><input type="text" value="" name="data[Professional][current_ctc][lacs]"/> <label class="pad">Lacs</label><input type="text" value="" name="data[Professional][current_ctc][thousands]"/><label class="pad">Thousand per</label><div class="buttons expected"><span class="ctc_cycle_month" onclick="$(\'.expected span\').removeClass(\'active\'); $(this).addClass(\'active\');$(\'#current_ctc_cycle\').val(\'Month\'); ">Month</span><span class="ctc_cycle_year_span" onclick="$(\'.expected span\').removeClass(\'active\'); $(this).addClass(\'active\'); $(\'#current_ctc_cycle\').val(\'Year\');">Year</span></div><span class="input_text"><input type="submit" value="Save" onclick="return updateProfessionals(\'#professional_ctc\',\'current_ctc\',\'#ctcMsg\');"></span><span class="arrow"></span>';
	}else{
		var html='<div class="input_text expert_salary small_text2"><input	class="less" type="text" value="'+val+'" name="data[Professional][ctc_currency]" onchange="return currencyVal(this);"/><input type="text" value="" name="data[Professional][current_ctc][dollar]"/> <label class="pad">per</label><div class="buttons expected"><span class="ctc_cycle_hour" onclick="$(\'.expected span\').removeClass(\'active\'); $(this).addClass(\'active\');$(\'#current_ctc_cycle\').val(\'Hour\'); ">Hour</span><span class="ctc_cycle_day" onclick="$(\'.expected span\').removeClass(\'active\'); $(this).addClass(\'active\'); $(\'#current_ctc_cycle\').val(\'Day\');">Day</span><span class="ctc_cycle_week" onclick="$(\'.expected span\').removeClass(\'active\'); $(this).addClass(\'active\'); $(\'#current_ctc_cycle\').val(\'Week\');">Week</span><span class="ctc_cycle_year_span" onclick="$(\'.expected span\').removeClass(\'active\'); $(this).addClass(\'active\'); $(\'#current_ctc_cycle\').val(\'Year\');">Year</span></div></div><span class="input_text"><input type="submit" value="Save" onclick="return updateProfessionals(\'#professional_ctc\',\'current_ctc\',\'#ctcMsg\');"></span><span class="arrow"> </span>';
		
	}
	$('#valCh').html(html);
}


function showSearchResult(){
	
	
	$('.search').append('<img id="indiactor" src="<?php echo $this->webroot;?>img/indicator.gif"/>');
	/*	{searchQuery:searchInput,order:order}*/
	$.post('<?php echo $this->webroot;?>professionals/recruiter_search',$(searchForm).serialize(),function(data){
		$('#indiactor').remove();
		
		if(data!='' && data.trim()!='No Record Found'){
			$('.filter_candidate').show();
			$('.candidate_details').html(data);
		}else{
			$('.filter_candidate').hide();
			$('.candidate_details').html('<div class="record_not_found error">'+data+'</div>');
		}
	
	});
	return false;
		
	
}




</script>
<script type="text/javascript" >
	function resetJoinDate(obj){
			
		$('.start span').removeClass('active');
		
		 $('#start_immediately').val('');
		 $('#joining_by_date').val('');
		 return false;
		
		
	}
	
	function checkCoords()
    {
	
       	if (parseInt($('#w').val())) return true;
        alert('Please select area to crop.');
        return false;
    };
            
	function cropImage()
	{
		var status=checkCoords();
		if(status){
		$('#loader').show();
		$.post('<?php echo $this->webroot;?>professionals/crop_profile_image/profile',$('#cropImageHolder').serialize(),function(data){
			$('#loader').hide();
			/*$('#profile_photo_name').val(data);
			$('.profile_pic').attr('src', '<?php echo $this->webroot;?>files/temp_professional_images/'+data+'');*/
			
			$.fancybox.close();
			if(data!=''){
				window.location='<?php echo $this->webroot;?>professionals/profile';
			}
			
			  });
		}
		return false;
		
	}
		   


	function deleteImage(){
			   
		var status1=confirm('Are you sure you want to remove profile photo?');
		if(status1){
			var profImageName=$('#profImageName').val();
			var counter=$('#counter').val();
			$('#loader').show();
			$.post('<?php echo $this->webroot;?>professionals/delete_uploaded_image',{profImageName:profImageName,counter:counter},function(data){
				$('#loader').hide();
								
				window.location='<?php echo $this->webroot;?>professionals/profile';
				
				  });
			  }
		return false;
	}
	
	function imagecropping(file,path,counter){
		
		$('#counter').val(counter);
		$('.targetImg').attr('src', path+file);
			$('.jcrop-preview').attr('src', path+file);
			$('#profImageName').val(file);
			$.fancybox({
 				scrolling : 'no',
				href:'#ImageInFancybox',
				width:1000,
				'afterShow' : function() {
					
					var boundx,
        				boundy,

					// Grab some information about the preview pane
					$preview = $('#preview-pane'),
					$pcnt = $('#preview-pane .preview-container'),
					$pimg = $('#preview-pane .preview-container img'),
					
					xsize = $pcnt.width(),
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
		 	}).open();
					
	}

	
	$(function(){
		var jcrop_api;
		var btnUpload=$('#me');
		var mestatus=$('#mestatus');
		var files=$('#ImageInFancybox');
		new AjaxUpload(btnUpload, {
			action: '<?php echo $this->webroot;?>professionals/upload_profile_image',
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
										
					imagecropping(file,'<?php echo $this->webroot;?>files/temp_professional_images/professional_',2);

				} else{
					$('#mestatus').text(response);
				}
			}
		});
		
	});

	function stop_propagation(_e){
		_e.stopPropagation();
	}
</script>
