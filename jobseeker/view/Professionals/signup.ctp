<?php echo $this->Html->css('jquery.Jcrop');
echo $this->Html->css('demos');

echo $this->Html->script("frontend/jquery.Jcrop");?>

<script language="JavaScript" src="http://j.maxmind.com/app/geoip.js"></script>
<style type="text/css">
.ui-autocomplete{ max-height: 270px !important;overflow: auto;}
</style>
<style type="text/css">

/* Apply these styles only when #preview-pane has
   been placed within the Jcrop widget */

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
#ui-datepicker-div{height:315px !important}
</style>
<span class="bottom_line" id="top_bottom_line"></span>
<div class="wrapper">
  <section class="main_container"> 
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
        <input type="submit" value="Save" onclick="return cropImage();" class="submit"/>
        <input type="button" value="Delete" onclick="return deleteImage();" class="submit"/>
        <img id="loader" src="<?php echo $this->webroot;?>img/ajax-loader.gif" height="50" width="50" style="display:none;">
        </form>
        
       </div>
       </div>
  <?php echo $this->Session->flash();?>
  <?php echo $this->Form->create('Professional',array('url'=>"/professionals/signup",'type'=>'file',
     'id'=>'professinal_signup','novalidate','onsubmit'=>'return checkValidation();'));?>
    <fieldset>
      <?php 
      
      if(isset($Errors)){
    	  $this->Core->renderValidationErrors($Errors);
      }?>
      <section class="detail_form"> <span class="profile_img styleall" id="profImage"> 
     <span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:12px;"><span style=" cursor:pointer;">
     <?php if($this->Form->value('profile_photo')==''){?>
	 
      <img class="profile_pic" onclick="$('#prof_profile_photo').trigger('click');" 
      src="<?php echo $this->webroot;?>images/profile_img.png" alt="" height="200" width="205"/>
      <?php }else{?>
      <img class="profile_pic" onclick="$('#prof_profile_photo').trigger('click');" 
      src="<?php echo $this->webroot;?>files/temp_professional_images/<?php echo $this->Form->value('profile_photo');?>" alt="" height="200" width="205"/>
      <?php }?>
      </span></span>
       <span id="mestatus" ></span>
       <?php /*echo $this->Form->input('Professional.profile_photo',array('label'=>false,'type'=>'file',
       'style'=>'display:none;','id'=>'prof_profile_photo','error' => false,'onchange'=>'Image.UpdatePreview(this)'));*/?>
       <?php echo $this->Form->input('Professional.profile_photo',array('label'=>false,
                	  'type'=>'hidden','id'=>'profile_photo_name'));?> 
       
     
   	
       </span>
       
        <section class="details">
        

          <div class="top_row">
            <?php 
               if(!empty($IndexData['first_name'])){
               		$name=trim($IndexData['first_name']).' '.trim($IndexData['last_name']);
               }
               echo $this->Form->input('name',array('value'=>$name,
             'label'=>false,'required'=>'required','placeholder'=>'Name','error' => false,'class'=>'name validate[required]','data-errormessage-value-missing'=>'Please enter name'));?>
          </div>
          <div class="comn_row">
            <div class="input_row">
              <label>Email<span class="star">*</span></label>
              <?php $readonly=false; if(isset($IndexData) && $IndexData['email']!=''){ $readonly='readonly';}?>
              <?php echo $this->Form->input('email',array('value'=>$IndexData['email'],
             				'label'=>false,'required'=>'required','placeholder'=>'Email','error' => false,'class'=>'email validate[required,custom[email]]','data-errormessage-value-missing'=>'Please enter email id','data-errormessage'=>"Please enter valid email id",'readonly'=>$readonly));?> </div>
            <div class="input_row">
              <label>Password<span class="star">*</span></label>
              <?php echo $this->Form->input('password',array('type'=>'password','label'=>false,'required'=>'required',
                	  'placeholder'=>'Password','error' => false,'class'=>'password validate[required,minSize[6]]','data-errormessage-value-missing'=>'Please enter password','data-errormessage'=>"Password should be atleast 6 characters"));?> </div>
            <div class="input_row last">
              <label>Confirm Password<span class="star">*</span></label>
              <?php echo $this->Form->input('confirm_password',array('type'=>'password','label'=>false,'required'=>'required',
                	  'placeholder'=>'Confirm Password','error' => false,'class'=>'confirm_password validate[required,equals[ProfessionalPassword]]','data-errormessage'=>"The passwords don't match. Please try again!"));?> </div>
          </div>
          <div class="comn_row">
            <div class="input_row">
              <label>Current Company<span class="star">*</span></label>
              <?php echo $this->Form->input('current_company',array('label'=>false,'required'=>'required',
                	  'placeholder'=>'Name of your company','error' => false,'class'=>'current_company validate[required]','data-errormessage-value-missing'=>'Please enter current company'));?> <span class="question">
                	  <a href="#" class="tool_tip" tabindex="-1" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"> <img src="<?php echo $this->webroot;?>images/question.png" alt=""/></a></span> </div>
            <div class="input_row">
              <label>Company Website<span class="star">*</span></label>
              <?php $websiteVal='';
			 if($this->Form->value('company_website')!='')
			  $websiteVal=$this->Form->value('company_website');  
			  
			  echo $this->Form->input('company_website',array('label'=>false,
			  		 'required'=>'required',
			  		 'placeholder'=>'http://www.abc.com',
                	 'error' => false,'value'=>$websiteVal,
                	 'class'=>'company_website validate[required,custom[url]]','data-errormessage-value-missing'=>'Please enter company website',
                	 'data-errormessage'=>"Please enter a valid website address"));?>
                	  
                	  <span class="question">
                	  <a href="#" class="tool_tip" tabindex="-1" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"> <img src="<?php echo $this->webroot;?>images/question.png" alt=""/></a></span> </div>
            <div class="input_row last">
            <?php $locVal='';
			if($this->Form->value('current_location')!=''){
				$locVal=$this->Form->value('current_location');
			}?>
            <script language="JavaScript">
             <?php if($this->Form->value('current_location')==''){?>
			 $(function(){
				 var str=geoip_country_name();
				 if(str.toLowerCase()=='canada' || str.toLowerCase()=='usa' || str.toLowerCase()=='india'){
				 $('#ProfessionalCurrentLocation').val(geoip_city()+', '+geoip_region_name()+', '+geoip_country_name());
				 }else{
					 $('#ProfessionalCurrentLocation').val(geoip_city()+', '+geoip_country_name());
				 }
				 detectNationality();
			 });
			<?php }?>
            </script>
              <label>Current Location<span class="star">*</span></label>
              <?php echo $this->Form->input('current_location',array('label'=>false,'required'=>'required',
                	  'placeholder'=>'City','value'=>$locVal,'error' => false,'class'=>'current_location validate[required]','data-errormessage-value-missing'=>'Please enter city','onblur'=>'detectNationality();'));?> </div>
          </div>
          <div class="profile_row">
            <label class="main">Who can view your profile </label>
            <img src="<?php echo $this->webroot;?>images/yes_sign.jpg" alt="" />
            <label>External / 3rd Party Recruiters</label>
            <br>
            <div style="padding:5px 0 0 0; float:left">
              <label class="main" style="color:#fff;opacity:0;">Who Can View Your Profile </label>
              <img src="<?php echo $this->webroot;?>images/close.jpg" alt="" />
              <label>Company Recruiters</label>
              <img src="<?php echo $this->webroot;?>images/close.jpg" alt="" />
              <label>Peers</label>
              <img src="<?php echo $this->webroot;?>images/close.jpg" alt="" />
              <label>Managers</label>
              <img src="<?php echo $this->webroot;?>images/close.jpg" alt="" />
              <label>Other Professionals</label>
            </div>
          </div>
        </section>
      </section>
      <section class="current_status">
        <h3>Current Status<span class="star">*</span></h3>
        <section class="status"> <span class="green"  onclick="setTopBar('green_bar');setStatus('new_opportunities','NO',this);">
          <label class="status">Currently seeking new opportunities</label>
          </span> <span class="right" style="float:right">
          <label>Preferred Locations<small class="star">*</small></label>
          <?php echo $this->Form->input('locations_for_new_op',array('label'=>false,
                	  'placeholder'=>'Add cities, regions, countries','disabled'=>'disabled',
                	  'class'=>'current_status_box text_box locations_for_new_op validate[required]','id'=>'new_opportunities','data-errormessage-value-missing'=>'Please enter preferred location','after'=>'<div class="multiple_loc">(Separate multiple locations by comma)</div>'));?> </span> </section>
        <section class="status"> <span class="yellow" onclick="setTopBar('yellow_bar');setStatus('interesting_opportunities','IO',this);">
          <label class="status">Always open to interesting opportunities</label>
          </span> <span class="right" style="float:right">
          <label>Preferred Locations<small class="star">*</small></label>
          <?php echo $this->Form->input('locations_for_interesting_op',array('label'=>false,
                	  'placeholder'=>'Add cities, regions, countries','disabled'=>'disabled',
                	  'class'=>'current_status_box text_box locations_for_interesting_op validate[required]','id'=>'interesting_opportunities','data-errormessage-value-missing'=>'Please enter preferred location','after'=>'<div class="multiple_loc">(Separate multiple locations by comma)</div>'));?> </span> </section>
        <section class="status"> <span class="rad" onclick="setTopBar('red_bar');setStatus('unavailable_by_date','U',this);">
          <label class="status">Unavailable</label>
          </span>
          <label class="pad"><a href="#" class="tool_tip" tabindex="-1" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"> <img src="<?php echo $this->webroot;?>images/question.png" alt=""/></a>DO NOT DISTURB</label>
          <div class="time_periode">
            <div class="input_row do_not_disturb"> <span class="unavailable_box" id="unavailable_by_year_span" onclick="if($('#current_status').val() == 'U') { $('.do_not_disturb span').removeClass('active'); $(this).addClass('active');$('#unavailable_by_year').val(1);}">for 1 Year</span>
             <?php echo $this->Form->input('do_not_disturb_year_flag',array('label'=>false,
                	  'type'=>'hidden','id'=>'unavailable_by_year'));?> </div>
          </div>
          <div class="time_periode">
            <div class="input_row do_not_disturb"> <span id="unavailable_by_date_span" class="unavailable_box" onclick="if($('#current_status').val() == 'U') {$('.do_not_disturb span').removeClass('active'); $(this).addClass('active');$('#unavailable_by_year').val('');}"> <?php echo $this->Form->input('do_not_disturb_date',array('label'=>false,
                	  'type'=>'text','id'=>'unavailable_by_date','placeholder'=>'until dd-mm-yy','disabled'=>'disabled','class'=>'current_status_box'));?> <img src="<?php echo $this->webroot;?>images/calender_bg1.png" alt="" onclick="if($('#current_status').val() == 'U') { $(&apos;#unavailable_by_date&apos;).datepicker(&apos;show&apos;);}"/></span> </div>
          </div>
        </section>
        <?php echo $this->Form->input('profile_status',array('label'=>false,
                	  'type'=>'hidden','id'=>'current_status'));?> </section>
      
      <!-- set data while validation error occur -->
      <?php 
        $curStatus=$this->Form->value('profile_status');      
       
        if(isset($curStatus) && $curStatus=="NO"){?>
      <script type="text/javascript">
	       $(function(){
		      $("section.status span.green").trigger('click');
	      });	       
	    </script>
      <?php }?>
      <?php        
        if(isset($curStatus) && $curStatus=="IO"){?>
      <script type="text/javascript">
	       $(function(){
		      $("section.status span.yellow").trigger('click');
	      });	       
	    </script>
      <?php }?>
      <?php 
       
        if(isset($curStatus) && $curStatus=="U"){?>
      <script type="text/javascript">
	       $(function(){
		      $("section.status span.rad").trigger('click');
	      });
		      	       
	    </script>
      <?php }?>
      <?php 
       	$doNotDisDateFlag=$this->Form->value('do_not_disturb_date');
        if(isset($doNotDisDateFlag) && $doNotDisDateFlag!="" && !isset($unavailYearFlag)){?>
      <script type="text/javascript">
	       $(function(){
		      $("#unavailable_by_date_span").trigger('click');
	      });	       
	    </script>
      <?php }?>
      <?php 
       	$unavailYearFlag=$this->Form->value('do_not_disturb_year_flag');
        if(isset($unavailYearFlag) && $unavailYearFlag=="1"){?>
      <script type="text/javascript">
	       $(function(){
		      $("#unavailable_by_year_span").trigger('click');
	      });	       
	    </script>
      <?php }?>
      
      <!-- /set data while validation error occur -->
      
      <div class="profe_detail">
        <div class="option_row spacer"> 
       
        <span class="title pad">My Online Profiles<small class="star">*</small></span>
         <a href="#" class="tool_tip" tabindex="-1" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"> <img alt="/" src="<?php echo $this->webroot;?>images/question.png"></a>
          <section class="inputs">
            <div class="input_row">
              <ul class="public_pro">
                <li onclick="showSocialInput(this);" title="LinkedIn" class="linkdin">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box">
                     <?php echo $this->Form->input('Professional.online_profiles.linkedin',
                            		 array('label'=>false,'onclick'=>'if (this.value=="") this.value = "http://"','placeholder'=>'http://','class'=>'socialProfile linkedin validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"linkdin");'));?>
                            		  <a onclick="return saveField('linkdin',event);" href="#">
                            		  <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this)" title="Google+" class="google">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box"> 
                    <?php echo $this->Form->input('Professional.online_profiles.googleplus',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile googleplus validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"google");'));?> 
                            		 <a onclick="return saveField('google',event);" href="#">
                            		  <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" title="Facebook" class="facebook">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box"> 
                    <?php echo $this->Form->input('Professional.online_profiles.facebook',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile facebook validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"facebook");'));?>
                            		  <a onclick="return saveField('facebook',event);" href="#">
                            		  <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" title="Twitter" class="twitter">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box">
                     <?php echo $this->Form->input('Professional.online_profiles.twitter',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile twitter validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"twitter");'));?>
                            		  <a onclick="return saveField('twitter',event);" href="#">
                            		  <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" title="Xing" class="xing">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box">
                     <?php echo $this->Form->input('Professional.online_profiles.xing',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile xing validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"xing");'));?> 
                            		 <a onclick="return saveField('xing',event);"  href="#">
                            		 <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" title="GitHub" class="gitHub">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box">
                     <?php echo $this->Form->input('Professional.online_profiles.github',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile github validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"gitHub");'));?> 
                            		 <a onclick="return saveField('gitHub',event);" onclick="return saveField(this);" href="#">
                            		 <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" title="Stack Overflow" class="stackoverflow">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box">
                     <?php echo $this->Form->input('Professional.online_profiles.stack_overflow',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile stack_overflow validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"stackoverflow");'));?> 
                            		 <a onclick="return saveField('stackoverflow',event);" href="#" >
                            		 <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" title="Behance" class="behance">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box">
                     <?php echo $this->Form->input('Professional.online_profiles.behance',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile behance validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"behance");'));?>
                            		  <a onclick="return saveField('behance',event);" href="#">
                            		  <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" title="Dribble" class="dribbble_ball">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box"> 
                    <?php echo $this->Form->input('Professional.online_profiles.dribble',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile dribble validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"dribbble_ball");'));?>
                            		  <a onclick="return saveField('dribbble_ball',event);" href="#">
                            		  <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" title="Pinterest" class="pinterest">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box">
                     <?php echo $this->Form->input('Professional.online_profiles.pinterest',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile pinterest validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"pinterest");'));?>
                     <a onclick="return saveField('pinterest',event);" href="#">
                     <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" title="ApnaCircle" class="apnacircle">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box">
                     <?php echo $this->Form->input('Professional.online_profiles.apnacircle',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile apnacircle validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"apnacircle");'));?>
                       <a onclick="return saveField('apnacircle',event);" href="#">
                       <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" title="Blog" class="blogger">
                  <div class="tooltip big">
                    <div class="tt">Please Enter your Profile URL <span class="input_box">
                     <?php echo $this->Form->input('Professional.online_profiles.blogger.',
                     array('label'=>false,'placeholder'=>'http://','required'=>false,'onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile blogger validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"blogger");'));?>
                      <!-- 
                       <a href="#"><img alt="" src="<?php echo $this->webroot;?>images/plus_forward.png" class="plus"></a> 
                       -->
                        <a onclick="return saveField('blogger',event);" href="#">
                        <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a>
                       
                          <!-- 
                        <a href="#"> <img alt="" src="<?php echo $this->webroot;?>images/close.jpg"></a>
                           -->
                         </span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" title="SkillPages" class="skillpages">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box">
                     <?php echo $this->Form->input('Professional.online_profiles.skillpages',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile skillpages validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"skillpages");'));?>
                            		  <a onclick="return saveField('skillpages',event);" href="#">
                            		  <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" title="About.me" class="about_me">
                  <div class="tooltip">
                    <div class="tt">Please Enter your Profile URL <span class="input_box">
                     <?php echo $this->Form->input('Professional.online_profiles.about_me',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile about_me validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"about_me");'));?>
                       <a onclick="return saveField('about_me',event);" href="#">
                     <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
                <li onclick="showSocialInput(this);" class="others"><a href="javascript:void(0)"> 
                <span onclick="$('.input_row span').removeClass('active'); $(this).addClass('active'); ">Others</span></a>
                  <div class="tooltip other_small">
                    <div class="tt">Please Enter Details <span class="input_box">
                     <?php echo $this->Form->input('Professional.online_profiles.other.website_name',
                            		 array('label'=>false,'placeholder'=>'Name of Website'));?>
                     <?php echo $this->Form->input('Professional.online_profiles.other.website_link',
                            		 array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile website_link validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"others");'));?>
                    <a onclick="return saveField('others',event);" href="#">
                    <img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span>
                   </div>
                    <div class="arrow"> </div>
                  </div>
                </li>
              </ul>
            </div>
          </section>
        </div>
        <div class="option_row"> <span class="title pad exp">Experience<small class="star">*</small></span>
         <span class="input_text small_text1 exp">
          <?php echo $this->Form->input('Professional.work_experience.year',array('label'=>false,'error' => false,'div'=>false,'type'=>'text','class'=>'ProfessionalWorkExperienceYear validate[groupRequired[experience],custom[integer]]','data-errormessage-value-missing'=>'Please enter experience','data-errormessage'=>"Please enter only numeric value"));?>
          <label>years</label>
          <?php echo $this->Form->input('Professional.work_experience.month',array('label'=>false,
        		 'required'=>'required','type'=>'text','error' => false,'div'=>false,'class'=>'ProfessionalWorkExperienceMonth validate[groupRequired[experience],custom[integer],max[11]]','data-errormessage-value-missing'=>'Please enter experience','data-errormessage'=>"Please enter only numeric value",'data-errormessage-range-overflow'=>'month cannot exceed 11'));?>
          <label>months</label>
          </span>
          <div class="input_row skills"> <span class="title pad main_wid">Skills<small class="star">*</small></span>
           <span class="input_text skills">
            <?php echo $this->Form->input('skills',array('label'=>false,'error' => false,'placeholder'=>'Java, sales, finance','class'=>'skills validate[required]','data-errormessage-value-missing'=>'Please enter skills','after'=>'<div class="hint_line">(Separate multiple skills by comma)</div>'));?> 
            </span> </div>
        </div>
        <div class="option_row">
          <div class="input_row"> 
          
          <span class="title pad">Phone Number</span>
          
           <span class="input_text small_text1">
           	<?php echo $this->Form->input('Professional.phone_nbr.code',array('label'=>false,
            'placeholder'=>'+1234'));?> </span>
            
            
             <span class="input_text small_text2"> 
             <?php echo $this->Form->input('Professional.phone_nbr.number',array('label'=>false,
            'placeholder'=>'12345678910','class'=>'ProfessionalPhoneNbrNumber validate[custom[integer]]','data-errormessage'=>"Please enter only numeric value"));?>
            
             </span>
          </div>
         
          <div class="input_row right"> <span class="title pad main_wid">Mode of Contact<small class="star">*</small></span> <a href="#" class="tool_tip" tabindex="-1" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"> <img src="<?php echo $this->webroot;?>images/question.png" alt="/"></a>
            <div class="buttons contact"> <span id="mode_of_contact_email" onclick="modeOfContact(this,'Email');">Email</span> <span id="mode_of_contact_phone" onclick="modeOfContact(this,'Phone');">Phone</span> <span id="mode_of_contact_private" onclick="modeOfContact(this,'Private');">Private</span> 
            <?php 
			echo $this->Form->input('mode_of_contact',array('label'=>false,
            'type'=>'hidden','id'=>'mode_of_contact','value'=>''));?> </div>
            <label class="pad">(Displayed to recruiters)</label>
          </div>
          
          <!-- set data for mode of contact while validation error occur -->
          <?php 
	 		$modeOfContact=$this->Form->value('mode_of_contact');
	    
		 $conMode=explode(',',$modeOfContact);
		 //print_r($conMode);die;
		 foreach($conMode as $mode){
	        if($mode=="Email"){?>
          <script type="text/javascript">
		       $(function(){
			      $("#mode_of_contact_email").trigger('click');
		      });	       
		    </script>
          <?php }?>
          <?php 
	  
	        if($mode=="Phone"){?>
          <script type="text/javascript">
		       $(function(){
			      $("#mode_of_contact_phone").trigger('click');
		      });	       
		    </script>
          <?php }?>
          <?php 
	        if($mode=="Private"){?>
          <script type="text/javascript">
		       $(function(){
			      $("#mode_of_contact_private").trigger('click');
		      });	       
		    </script>
          <?php }}?>
          
          <!-- [end]set data for mode of contact while validation error occur --> 
          
        </div>
        <div class="option_row">
        
        <div class="input_row"> <span class="title pad">Resume</span>
            <ul class="resume">
              <li onclick="$('.resume li').removeClass('active'); $(this).addClass('active'); " class="doc" title="Doc">
                <div class="tooltip">
                  <div class="tt"> <small class="input_box"> 
                  <?php echo $this->Form->input('Professional.uploaded_resumes.resume_doc',array('label'=>false,
          			  'type'=>'file','onblur'=>'showColorIcon(this,"doc");'));?> </small> </div>
                  <div class="arrow"> </div>
                </div>
              </li>
              <li onclick="$('.resume li').removeClass('active'); $(this).addClass('active'); "  class="pdf" title="PDF">
                <div class="tooltip">
                  <div class="tt"> <small class="input_box"> 
                  <?php echo $this->Form->input('Professional.uploaded_resumes.resume_pdf',array('label'=>false,
          			  'type'=>'file','onblur'=>'showColorIcon(this,"pdf");'));?> </small> </div>
                  <div class="arrow"> </div>
                </div>
              </li>
              <li onclick="$('.resume li').removeClass('active'); $(this).addClass('active'); "  class="googledoc" title="Google Docs">
                <div class="tooltip">
                  <div class="tt">Please enter your profile link <span class="input_box"> 
                  <?php echo $this->Form->input('Professional.online_resume_links.goole_doc',array('label'=>false,
          			  'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"googledoc");','class'=>'socialProfile goole_doc validate[custom[url]]','data-errormessage'=>"Please enter a valid website address"));?> <a onclick="return saveResumeField('googledoc',event);" href="#"><img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                  <div class="arrow"> </div>
                </div>
              </li>
              <li onclick="$('.resume li').removeClass('active'); $(this).addClass('active'); "  class="visualcv" title="Visual CV">
                <div class="tooltip">
                  <div class="tt">Please enter your profile link <span class="input_box">
                   <?php echo $this->Form->input('Professional.online_resume_links.visual_cv',array('label'=>false,
          			  'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"visualcv");','class'=>'socialProfile visual_cv validate[custom[url]]','data-errormessage'=>"Please enter a valid website address"));?> <a onclick="return saveResumeField('visualcv',event);" href="#"><img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                  <div class="arrow"> </div>
                </div>
              </li>
              <li onclick="$('.resume li').removeClass('active'); $(this).addClass('active'); "  class="resumenucket" title="Resume Bucket">
                <div class="tooltip">
                  <div class="tt">Please enter your profile link <span class="input_box">
                   <?php echo $this->Form->input('Professional.online_resume_links.resume_bucket',array('label'=>false,
          			  'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"resumenucket");','class'=>'socialProfile resume_bucket validate[custom[url]]','data-errormessage'=>"Please enter a valid website address"));?> <a onclick="return saveResumeField('resumenucket',event);" href="#"><img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                  <div class="arrow"> </div>
                </div>
              </li>
              <li onclick="$('.resume li').removeClass('active'); $(this).addClass('active'); "  class="resumedot last" title="Resume.com">
                <div class="tooltip">
                  <div class="tt">Please enter your profile link <span class="input_box"> 
                  <?php echo $this->Form->input('Professional.online_resume_links.resume_dot',array('label'=>false,
          			  'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"resumedot");','class'=>'socialProfile resume_dot validate[custom[url]]','data-errormessage'=>"Please enter a valid website address"));?> <a onclick="return saveResumeField('resumedot',event);" href="#"><img alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span> </div>
                  <div class="arrow"> </div>
                </div>
              </li>
            </ul>
          </div>
          </div>
        <div class="option_row">
          <div class="input_row"> <span class="title pad nat">Nationality<small class="star">*</small>&nbsp;&nbsp;<a href="#" class="tool_tip" tabindex="-1" title="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"> <img alt="" src="<?php echo $this->webroot;?>images/question.png"></a> </span> <span class="input_text small"> <?php echo $this->Form->input('nationality',array('label'=>false,'error' => false,'placeholder'=>'Country of Citizenship','class'=>'nationality validate[required]','data-errormessage-value-missing'=>'Please enter nationality'));?> </span> </div>
          
        </div>
      <div class="option_row sec_clear" style="display:none;">
       <?php echo $this->Form->input('security_clear',array('label'=>false,
          			  'type'=>'hidden','id'=>'security_clear'));?>
            		<div class="line_pad"><span class="title pad">Security Clearance </span></div>
              		<div class="buttons yes_no" style="width:110px;">
                    	<span class="sec_yes" onclick="$('.yes_no span').removeClass('active'); $(this).addClass('active');$('#security_clear').val('Yes');$('#security_type_specification').attr('disabled',false); ">Yes</span>
                        <span class="sec_no" onclick="$('.yes_no span').removeClass('active'); $(this).addClass('active');$('#security_clear').val('No');$('#security_type_specification').val('');$('#security_type_specification').css({'background-color' : '#ffffff'});$('#security_type_specification').attr('disabled','disabled'); ">No</span>
                    </div>
                    <span class="title pad" style="min-width:80px;">Specify Type </span><span class="input_text small"> <?php echo $this->Form->input('security_type_specification',array('label'=>false,'error' => false,'placeholder'=>'Specify Type','id'=>'security_type_specification'));?> </span>
            	 </div>
                 
             <?php $nationality=$this->Form->value('nationality');
	   if($nationality!='Indian' && $nationality!=''){
	   ?>
       <script type="text/javascript">
	   $(document).ready(function(){
		 
		$('.sec_clear').show();
	   });
	   </script>
      
       <?php $secClear=$this->Form->value('security_clear');
	        if(isset($secClear) && $secClear=="Yes"){?>
          <script type="text/javascript">
		       $(function(){
			      $(".sec_yes").trigger('click');
		      });	       
		    </script>
          <?php }?> 
          <?php 	       
	        if(isset($secClear) && $secClear=="No"){?>
          <script type="text/javascript">
		       $(function(){
			      $(".sec_no").trigger('click');
		      });	       
		    </script>
          <?php }}?>
           
        <div class="option_row">
          <div class="option_sal"> <span class="title pad">Current <span id="currentCtxText">CTC / Rate</span></span>
            <div class="input_text small_text1"> 
            		<?php echo $this->Form->input('ctc_currency',array('label'=>false,
          			  'placeholder'=>'INR','div'=>false));?>
                    <div class="professional_salary_inr">
          			<?php echo $this->Form->input('Professional.current_ctc.lacs',array('label'=>false,'div'=>false,'class'=>'ProfessionalCurrentCtcLacs validate[custom[number]]','data-errormessage'=>"Please enter only numeric value"));?>
              <label>Lacs</label>
              <?php echo $this->Form->input('Professional.current_ctc.thousands',array('label'=>false,'div'=>false,'class'=>'ProfessionalCurrentCtcThousands validate[custom[number]]','data-errormessage'=>"Please enter only numeric value"));?>
              <label>Thousand per</label>
              <div class="buttons time_dur">
              
               <span class="ctc_cycle_month" onclick="$('.time_dur span').removeClass('active'); $(this).addClass('active');$('#current_ctc_cycle').val('Month');">Month</span>
              
               <span class="ctc_cycle_year_span" onclick="$('.time_dur span').removeClass('active'); $(this).addClass('active');$('#current_ctc_cycle').val('Year');">Year</span>
               </div>
               </div>
              
               
          <div class="professional_salary_other" style="display:none;">
           
            <?php echo $this->Form->input('Professional.current_ctc.dollar',array('label'=>false,'div'=>false,'class'=>'ProfessionalCurrentCtcDollar validate[custom[number]]','data-errormessage'=>"Please enter only numeric value"));?>
            
              <label>per</label>
            
           
              <div class="buttons time_dur" style=" width:200px;"> 
              
              <span class="ctc_cycle_hour" onclick="$('.time_dur span').removeClass('active'); $(this).addClass('active'); $('#current_ctc_cycle').val('Hour'); ">Hour</span>
               <span class="ctc_cycle_day" onclick="$('.time_dur span').removeClass('active'); $(this).addClass('active'); $('#current_ctc_cycle').val('Day'); ">Day</span> 
               <span class="ctc_cycle_week" onclick="$('.time_dur span').removeClass('active'); $(this).addClass('active'); $('#current_ctc_cycle').val('Week'); ">Week</span>
               <span class="ctc_cycle_year" onclick="$('.time_dur span').removeClass('active'); $(this).addClass('active'); $('#current_ctc_cycle').val('Year'); ">Year</span> 
               </div>
            </div>
        
          <?php echo $this->Form->input('ctc_cycle',array('label'=>false,
          			  'type'=>'hidden','id'=>'current_ctc_cycle'));?>
            </div>
          </div>
       <?php $ctcCurrency=$this->Form->value('ctc_currency');
	   if($ctcCurrency!='INR' && $ctcCurrency!=''){
	   ?>
       <script type="text/javascript">
	   $(document).ready(function(){
		  $('.professional_salary_inr').hide();
		$('.professional_salary_other').show();
	   });
	   </script>
       <?php }?>
          <!-- set data for ctc cycle while validation error occure -->
          
          <?php 	         
	        $ctcCycle=$this->Form->value('ctc_cycle');
	        if(isset($ctcCycle) && $ctcCycle=="Hour"){?>
          <script type="text/javascript">
		       $(function(){
			      $(".ctc_cycle_hour").trigger('click');
		      });	       
		    </script>
          <?php }?>
          <?php 	       
	        if(isset($ctcCycle) && $ctcCycle=="Day"){?>
          <script type="text/javascript">
		       $(function(){
			      $(".ctc_cycle_day").trigger('click');
		      });	       
		    </script>
          <?php }?>
          <?php 	       
	        if(isset($ctcCycle) && $ctcCycle=="Week"){?>
          <script type="text/javascript">
		       $(function(){
			      $(".ctc_cycle_week").trigger('click');
		      });	       
		    </script>
          <?php }?>
          <?php 	       
	        if(isset($ctcCycle) && $ctcCycle=="Month"){?>
          <script type="text/javascript">
		       $(function(){
			      $(".ctc_cycle_month").trigger('click');
		      });	       
		    </script>
          <?php }?>
          <?php 	       
         
	        if(isset($ctcCycle) && $ctcCycle=="Year"){?>
          <script type="text/javascript">
		       $(function(){
			    
			      $(".ctc_cycle_year_span").trigger('click');
		      });	       
		    </script>
          <?php }?>
          
          <!-- [end]set data for ctc cycle while validation error occure --> 
          
          <span class="input_text small_text1"> 
        <?php $checked='checked';
		if($this->Form->value('display_to_recruiters')!=''){
			$checked=$this->Form->value('display_to_recruiters');
						}?>
          <?php echo $this->Form->input('display_to_recruiters',array('label'=>false,
          			  'type'=>'checkbox','class'=>'pad','div'=>false,'checked'=>$checked));?>
                        
          <label>Display to recruiters</label>
          </span> </div>
        <div class="option_row"> <span class="title pad">When can you start</span>
          <div class="input_row">
            <div class="buttons start">
             <span id="immediate_joining_span" onclick="$('.start span').removeClass('active'); $(this).addClass('active');$('#start_immediately').val('1');$('#joining_by_date').val('');$('#joining_by_day').val('');$('#joining_by_day').css({'background-color' : '#ffffff'});">Immediately</span> 
            <?php echo $this->Form->input('immediate_joining_flag',array('label'=>false,
          			  'type'=>'hidden','id'=>'start_immediately'));?>
         
         	 <span id="joining_by_date_span"  onclick="$('.start span').removeClass('active'); $(this).addClass('active');$('#start_immediately').val('');$('#joining_by_day').val('');$('#joining_by_day').css({'background-color' : '#ffffff'});">
         
          	<?php echo $this->Form->input('joining_by_date',array('label'=>false,
          			  'type'=>'text','id'=>'joining_by_date','placeholder'=>date('d-M-Y'),'after'=>'<img onclick="$(&apos;#joining_by_date&apos;).datepicker(&apos;show&apos;);" src="'.$this->webroot.'images/calender_bg1.png" alt="">'));?>
          			
           </span> 
           </div>
           
          </div>
          <span class="input_text small_text1"> 
          <?php echo $this->Form->input('joining_by_day',array('label'=>false,
          			  'type'=>'text','onfocus'=>'return resetJoinDate(this);','id'=>'joining_by_day'));?> </span> <span class="input_text small_text1">
          <label class="last">Days from job offer</label>
          </span> </div>
        
        <!-- set data for joining while validation error occur -->
        
        <?php 	         
	        $joiningF=$this->Form->value('immediate_joining_flag');
	        if(isset($joiningF) && $joiningF=="1"){?>
        <script type="text/javascript">
		       $(function(){
			      $("#immediate_joining_span").trigger('click');
		      });	       
		    </script>
        <?php }?>
        <?php 	         
	        $joiningDate=$this->Form->value('joining_by_date');
	        if(isset($joiningDate) && $joiningF!="1"){?>
        <script type="text/javascript">
		       $(function(){
			       $("#joining_by_date_span").trigger('click');
		      });	       
		    </script>
        <?php }?>
      </div>
      <div class="recruiter_message">
        <label class="pad">Message for recruiters</label>
        
        <?php echo $this->Form->input('message_for_recruiters',array('label'=>false,'type'=>'textarea',
          		'placeholder'=>'Share additional information on your salary, notice period, location preferences, if any',
      			'rows'=>4,'onkeydown'=>'limitText(this,this.form.countdown,500);','onkeyup'=>'limitText(this,this.form.countdown,500);'));?> <small><input readonly type="text" name="countdown" class="countdown" size="3" value="500"> characters left.</font></small> 
                
                </div>
      			
      <section class="agree"> 
      <?php echo $this->Form->input('terms_acceptance_falg',array('label'=>false,
          			  'type'=>'checkbox','error'=>false,'class'=>'terms_acceptance_falg validate[required]','data-errormessage-value-missing'=>'Please select terms & conditions','checked'=>false));?> I agree with the <a href="#">Terms of Service</a> &amp; 
          			  <a href="#">Privacy Policy</a>
         </section>
   
   
      <section class="capcha" style="display:none"> <img id="captcha" src="<?php echo $this->Html->url('/common/captcha_image');?>" alt="" />
       <a href="javascript:void(0);" 
 		   onclick="javascript:document.images.captcha.src='<?php echo $this->Html->url('/common/captcha_image');?>?' + Math.round(Math.random(0)*1000)+1">Reload image</a> <?php echo $this->Form->input('captcha_value',array('label'=>false,
          			  'type'=>'text','required'=>'required','value'=>'','class'=>'captcha_value validate[required]','data-errormessage-value-missing'=>'Please enter above code'));?>
       </section>
       
      <span class="sign_up"> 
      
 		    <?php echo $this->Form->input('professional_signup',array('label'=>false,
          			  'type'=>'hidden','value'=>'1'));?> 
 		  
 		   <?php echo $this->Form->input('Sign Up',array('label'=>false,
          			  'type'=>'submit','class'=>'sign_up_green submit'));?> </span>
    </fieldset>
    <?php echo $this->Form->end();?> </section>
</div>
<div id="dialog-confirm" style="display:none; height:55px;">
<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>Do you wat to upload resume?</p>
</div>
<script type="text/javascript">

function setStatus(elId,curVal,thisObj){
	
	$('.status_error').remove();
	
		$('.formError').remove();
		$('#unavailable_by_year').val('');
	
	var _elId=$("#"+elId);
	
	$("#current_status").val(curVal);
	$(".current_status_box").attr('disabled','disabled');
	_elId.removeAttr('disabled');
	$('.unavailable_box').removeClass('active');
	$('.unavailable_box').removeClass('disable');
	$('.unavailable_box').removeClass('hover');
	
	if(curVal=='U'){
		$('.unavailable_box').addClass('hover');
	}
	
	$('label.status').removeClass('active');
	$('label.status',thisObj).addClass('active'); 
}

$(function() {
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

	$( ".tool_tip" ).tooltip({
	      show: {
	        effect: "slideDown",
	        delay: 250
	      }
	});
	$("#ProfessionalPhoneNbrCode").autocomplete({
		source:"<?php echo Router::url('/', true);?>professionals/findPhoneCode",
    	minChars: 2
		
    });
	$("#ProfessionalCurrentLocation").autocomplete({
		source:"<?php echo Router::url('/', true);?>professionals/findCurrentLocation",
    	minChars: 2
		
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
			
			$( "#ProfessionalSkills" ).autocomplete({
			source: function( request, response ) {
			$.getJSON( "<?php echo Router::url('/', true);?>professionals/findskills", {
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
			
			
			
	$('#ProfessionalCompanyWebsite,.socialProfile').keyup(function(){

		if(this.value.length<=6){
			this.value = 'http://';
		}

		if(this.value.indexOf('http://') !== 0 ){ 
	        this.value = 'http://' + this.value;
	     }	   

	});

	$('#ProfessionalCompanyWebsite').blur(function() {
		if (this.value=="http://") this.value = '';		
	});
	    	
});
 
function showSocialInput(objThis){

	$('.public_pro li').not($(objThis)).removeClass('active');	
	$(objThis).addClass('active'); 
	
}

function saveField(curListClass,event){
	
	event.stopPropagation();
	$("."+curListClass).removeClass("active");
	return false;
}

function saveResumeField(curListClass,event){
	
	event.stopPropagation();
	$("."+curListClass).removeClass("active");
	return false;
}

$(document).ready(function(){
	
	$('#ProfessionalCtcCurrency').blur(function(e) {
        var fi_val=$('#ProfessionalCtcCurrency').val().toLowerCase();
		if(fi_val=='inr' || typeof fi_val === "undefined")
		{
			$('.professional_salary_other input').val('');
			$('.professional_salary_other').hide();
			$('.professional_salary_inr').show();
			$('.sec_clear').hide();
			$('#currentCtxText').text('CTC / Rate');
			
		}else{			
			$('.professional_salary_inr input').val('');
			$('.professional_salary_inr').hide();
			$('.professional_salary_other').show();
			$('#currentCtxText').text('Salary');
			$('.sec_clear').show();
		}
    });
	
	
	$('input[type="file"]').change(function(e) {
		
        $('.resume li').removeClass('active');
    });
	
	$('body').click(function(e) {
	    var clickedOn = $(e.target);
	    
		if (clickedOn.parents().andSelf().is('.tooltip') || clickedOn.parents().andSelf().is('.public_pro li') || 
				clickedOn.parents().andSelf().is('.resume li') || clickedOn.is('.upload_resume') || 
				clickedOn.is('.box')||clickedOn.is('.e_status')||clickedOn.is('.company_apply')){ 

		}else{
			$('.public_pro li').removeClass('active');
			$('.resume li').removeClass('active');
			$('.upload_resume').removeClass('active');
			$('.box').removeClass('active');
			$('.e_status').removeClass('active');
			$('.company_apply').removeClass('active');
		}
	});
	myform = document.getElementById('professinal_signup');
	limitText(myform.ProfessionalMessageForRecruiters,myform.countdown,500);
	
});

jQuery(document).ready(function(){
       jQuery("#professinal_signup").validationEngine('attach',{promptPosition: "bottomLeft",scroll: false});
	  /* $("#professinal_signup").each(function(){
   		 alert($(this).filter(':input')); 
	   }*/
	  $('input[type="text"],input[type="email"], input[type="password"]').each(function() {
		 if($(this).val()!='' && !$(this).hasClass('hasDatepicker') && !$(this).hasClass('socialProfile') && !$(this).hasClass('captcha_value') && !$(this).hasClass('countdown'))
				 $(this).validationEngine().css({'background-color' : "#FAFFBD"});
				 
		if($(this).hasClass('socialProfile')){
			 		var id=$(this).attr('id');
					 $("#"+id).trigger('blur');
		 }
	  });
       
        
	   $( 'input[type="text"],input[type="email"],input[type="password"]' ).focus(function() {
		$(this).validationEngine('hide');
		$(this).validationEngine().css({border : "1px solid #D5D0D0"});
		if(!$(this).hasClass('socialProfile') && !$(this).hasClass('hasDatepicker'))
		 $(this).validationEngine().css({'background-color' : "#ffffff"});
			});
			 $( 'input[type="text"],input[type="email"],input[type="password"]' ).blur(function() {
				 
				var error=$(this).validationEngine('validate');
				
				if(error){
				$(this).validationEngine().css({border : "1px solid red"});
			 }else{
				 if($(this).val()!='' && !$(this).hasClass('hasDatepicker') && !$(this).hasClass('socialProfile') && !$(this).hasClass('captcha_value') && !$(this).hasClass('countdown'))
				 $(this).validationEngine().css({'background-color' : "#FAFFBD"});
				 
			 }
			 if($(this).hasClass('ProfessionalPhoneNbrNumber')){
				$('.mode_error').remove();
			 }
			 if($(this).hasClass('ProfessionalWorkExperienceYear')){
				if($(this).val()!=''){
				$('.ProfessionalWorkExperienceMonth').css({border : "1px solid #D5D0D0"});	
				$('.ProfessionalWorkExperienceYearformError').remove();
				}
			 }
			 if($(this).hasClass('ProfessionalWorkExperienceMonth')){
				if($(this).val()!=''){
				$('.ProfessionalWorkExperienceYear').css({border : "1px solid #D5D0D0"});	
				}
			 }
	
			});
			
		$("#ProfessionalTermsAcceptanceFalg").change(function() {
			$('.capcha').hide();
   		 if($(this).is(':checked')) {
			
      $('.capcha').show();
    	}
});
    });
	

function limitText(limitField, limitCount, limitNum) {
	
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
function modeOfContact(obj,txt){
	
	$('.mode_error').remove();
	var obj=$(obj);	
	
	if(txt=='Private'){
	
	$('.contact span').removeClass('active'); 
	obj.addClass('active');
	$('#mode_of_contact').val('Private');
	}else{
		if(txt=='Phone' && $('#ProfessionalPhoneNbrNumber').val()==''){
		$('.mode_error').remove();
		$('#mode_of_contact').after("<div class='formErrorContent mode_error'>Please enter the phone number</div>");
			return;
		}
		var myInput = $('#mode_of_contact').val();
		if(myInput=='Private'){
			myInput='';
		}
		$('#mode_of_contact_private').removeClass('active');
		obj.toggleClass('active');
		if (myInput.indexOf(txt) >= 0){
			
			
			myInput=myInput.replace(txt,'');
			myInput=myInput.replace(',','');
			$('#mode_of_contact').val($.trim(myInput));
		}else{
		
		if(myInput!=''){
			myInput+=','+txt;
		$('#mode_of_contact').val(myInput);
		}else{
			
		$('#mode_of_contact').val(txt);
		}
		}
	}
	
}
function checkValidation(){
	
	
	var i=0;
	if($('#current_status').val()==''){
		$('.status_error').remove();
		$('.current_status h3').after("<div class='formErrorContent status_error'>please select current status</div>");
		i++;
	}else if($('#current_status').val()=='U'){
		if($('#unavailable_by_year').val()=='' && $('#unavailable_by_date').val()==''){
			$('.status_error').remove();
			$('#current_status').after("<div class='formErrorContent unavailable_error'>please enter do not disturb period</div>");
		i++;
		}
		
	}
	$('.mode_error').remove();
	if($('#mode_of_contact').val()==''){
		
		$('#mode_of_contact').after("<div class='formErrorContent mode_error'>please select mode of contact</div>");
		i++;
	}
	if($('#mode_of_contact').val().indexOf('Phone') >= 0 && $('#ProfessionalPhoneNbrNumber').val()==''){
		
		$('#mode_of_contact').after("<div class='formErrorContent mode_error'>Please enter the phone number</div>");
			i++;
		}
	var input = ['linkdin','google','facebook','twitter','xing','gitHub','stackoverflow','behance','dribbble_ball','pinterest','apnacircle','blogger','skillpages','about_me','others','googledoc','visualcv','resumenucket','resumedot'];
	
    for (var j = 0; j < input.length; j++)
    {
		
        if ($('.'+input[j]).find('.formError').length==1) {
			$('.'+input[j]).addClass('active');
			i++;
		}
	}
	if(i>0){
		
	return false;
	}else{
	
	<?php if(isset($ErrorsResume)){?>
	if($('#ProfessionalUploadedResumesResumeDoc').val()=='' && $('#ProfessionalUploadedResumesResumePdf').val()==''){
		var error2=$("#professinal_signup").validationEngine('validate');
	if(error2){
	$( "#dialog-confirm" ).dialog({
				resizable: false,
				height:160,
				width:350,
				modal: true,
				open: function() {
   			 $(this).dialog("widget").find(".ui-dialog-titlebar").remove();
  				},
				buttons: {
				'Yes': function() {
				$( this ).dialog( "close" );
				
				},
				'skip': function() {
				$( this ).dialog( "close" );
				document.getElementById('professinal_signup').submit();
				}
				}
				});
		return false;
	}
	}else{
		return true;
	}
			
	<?php }else{ ?>	
	return true;
	<?php }?>
	
		
	}
}
function detectNationality(){
	var location=$('#ProfessionalCurrentLocation').val();
	if(location!=''){
	$.post('<?php echo $this->webroot;?>professionals/detectNationality',{location:location},function(data){
	var res = data.split(',');
	
	$('#ProfessionalNationality').val(res[0]);
	
	$('#ProfessionalPhoneNbrCode').val(res[2]);
	if(res[1]=='INR' || typeof res[1] === "undefined"){
		$('.professional_salary_other input').val('');
		$('.professional_salary_other').hide();
		$('.professional_salary_inr').show();
		$('.sec_clear').hide();
		$('#currentCtxText').text('CTC / Rate');
	$('#ProfessionalCtcCurrency').val(res[1]);
	}else{
		$('#ProfessionalCtcCurrency').val(res[1]);
		$('.professional_salary_inr input').val('');
		$('.professional_salary_inr').hide();
		$('.professional_salary_other').show();
		$('#currentCtxText').text('Salary');
		$('.sec_clear').show();
	}
	
	$('#ProfessionalNationality,#ProfessionalPhoneNbrCode,#ProfessionalCtcCurrency').trigger('blur');	
	});
	}

}
function showColorIcon(obj,iconClass){
	
var error1=$(obj).validationEngine('validate');

	if(obj.value!='' && !error1){
		
		$('.'+iconClass).addClass('hover');
	}else{
		$('.'+iconClass).removeClass('hover');
	}
	
	
	
}
function resetJoinDate(obj){
	
$('.start span').removeClass('active');

 $('#start_immediately').val('');
 $('#joining_by_date').val('');
 return false;
	
	
}

</script>
	
<script type="text/javascript" >
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
			$.post('<?php echo $this->webroot;?>professionals/crop_profile_image',$('#cropImageHolder').serialize(),function(data){
				$('#loader').hide();
				$('#profile_photo_name').val(data);
				$('.profile_pic').attr('src', '<?php echo $this->webroot;?>files/temp_professional_images/'+data+'');
				
				$.fancybox.close();
				
				  });
			}
		return false;
	
  	}
	function deleteImage(){
			   
	   	var status1=confirm('Are you sure you want to remove profile photo?');
	   	if(status1){
	  		var profImageName=$('#profImageName').val();
	  
	   		$('#loader').show();
			$.post('<?php echo $this->webroot;?>professionals/delete_uploaded_image',{profImageName:profImageName},function(data){
				$('#loader').hide();
						
				$.fancybox.close();
		
		  	});
	  	}
		return false;
	   
   }


	$(function(){
		var jcrop_api;
		
		/*$('#mainPhoto').imgAreaSelect({ x1: 120, y1: 90, x2: 280, y2: 210 });*/
		var btnUpload=$('#profImage');
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
										
					
					$('.targetImg').attr('src', '<?php echo $this->webroot;?>files/temp_professional_images/professional_'+file+'');
					$('.jcrop-preview').attr('src', '<?php echo $this->webroot;?>files/temp_professional_images/professional_'+file+'');
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
							/*setSelect: [ 60, 70, 540, 330 ],*/
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
					
					
					
				} else{
					$('#mestatus').text(response);
				}
			}
		});
		
	});
</script>
