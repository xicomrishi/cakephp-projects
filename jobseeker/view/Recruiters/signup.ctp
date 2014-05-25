<?php echo $this->Html->css('jquery.Jcrop');
echo $this->Html->css('demos');

echo $this->Html->script("frontend/jquery.Jcrop");?>

<script
	language="JavaScript" src="http://j.maxmind.com/app/geoip.js"></script>
<style type="text/css">
.ui-autocomplete {
	max-height: 270px !important;
	overflow: auto;
}
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
	border: 1px rgba(0, 0, 0, .4) solid;
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
<span
	class="bottom_line black" id="top_bottom_line"></span>
<div class="wrapper"><section class="main_container">
<div style="display: none;">
<div class="fancybox_box" id="ImageInFancybox"
	style="float: left; width: 100% !important; height: 100%"><img
	id="target" class="targetImg" />

<div id="preview-pane">
<div class="preview-container"><img class="jcrop-preview" alt="Preview" />
</div>
</div>
<form action="#" name="cropImageHolder" id="cropImageHolder"><input
	type="hidden" id="profImageName" name="profImageName" /> <input
	type="hidden" id="x" name="x" /> <input type="hidden" id="y" name="y" />
<input type="hidden" id="w" name="w" /> <input type="hidden" id="h"
	name="h" /> <input type="submit" value="Save"
	onclick="return cropImage();" class="submit" /> <input type="button"
	value="Delete" onclick="return deleteImage();" class="submit" /> <img
	id="loader" src="<?php echo $this->webroot;?>img/ajax-loader.gif"
	height="50" width="50" style="display: none;"></form>

</div>
</div>

<?php echo $this->Session->flash();?> <?php echo $this->Form->create('Recruiter',array('url'=>"/recruiters/signup",'type'=>'file',
     'id'=>'recruiter_signup','novalidate','onsubmit'=>'return checkValidation();'));?>
<fieldset><?php echo $this->Form->input('id',array('label'=>false,
                	  'type'=>'hidden','value'=>$recruiterId));?> <?php 

if(isset($Errors)){
	$this->Core->renderValidationErrors($Errors);
}?> <section class="detail_form"> <span class="profile_img styleall"
	id="profImage"> <span
	style="cursor: pointer; font-family: Verdana, Geneva, sans-serif; font-size: 12px;"><span
	style="cursor: pointer;"> <?php if($this->Form->value('profile_photo')==''){?>

<img class="profile_pic"
	onclick="$('#prof_profile_photo').trigger('click');"
	src="<?php echo $this->webroot;?>images/profile_img.png" alt=""
	height="200" width="205" /> <?php }else{?> <img class="profile_pic"
	onclick="$('#prof_profile_photo').trigger('click');"
	src="<?php echo $this->webroot;?>files/temp_recruiter_images/<?php echo $this->Form->value('profile_photo');?>"
	alt="" height="200" width="205" /> <?php }?> </span></span> <span
	id="mestatus"></span> <?php echo $this->Form->input('Recruiter.profile_photo',array('label'=>false,
                	  'type'=>'hidden','id'=>'profile_photo_name'));?> </span>
<section class="details">
<div class="top_row"><?php 
if(!empty($IndexData['first_name'])){
	$name=trim($IndexData['first_name']).' '.trim($IndexData['last_name']);
}
echo $this->Form->input('name',array('value'=>$name,
             'label'=>false,'required'=>'required','placeholder'=>'Name','error' => false,'class'=>'name validate[required]','data-errormessage-value-missing'=>'Please enter name'));?>
</div>
<div class="comn_row pad">
<div class="input_row"><label>Email<span>*</span></label> <?php $readonly=false; if(isset($IndexData) && $IndexData['email']!=''){ $readonly='readonly';}?>
<?php echo $this->Form->input('email',array('value'=>$IndexData['email'],
             				'label'=>false,'required'=>'required','placeholder'=>'Email','error' => false,'class'=>'email validate[required,custom[email]]','data-errormessage-value-missing'=>'Please enter email id','data-errormessage'=>"Please enter valid email id",'readonly'=>$readonly));?>
</div>
<div class="input_row"><label>Password<span>*</span></label> <?php echo $this->Form->input('password',array('type'=>'password','label'=>false,'required'=>'required',
                	  'placeholder'=>'Password','error' => false,'class'=>'password validate[required,minSize[6]]','data-errormessage-value-missing'=>'Please enter password','data-errormessage'=>"Password should be atleast 6 characters"));?>
</div>
<div class="input_row last"><label>Confirm Password<span>*</span></label>
<?php echo $this->Form->input('confirm_password',array('type'=>'password','label'=>false,'required'=>'required',
                	  'placeholder'=>'Confirm Password','error' => false,'class'=>'confirm_password validate[required,equals[RecruiterPassword]]','data-errormessage'=>"The passwords don't match. Please try again!"));?>
</div>
</div>
<P>Register with you official email ID (unless you are a freelance
recruiter)</P>
</section> </section> <section class="i_am">
<h3>Current role<span>*</span></h3>
<section class="selections r_profile">
<div class="status corporate"
	onClick="$('.status').removeClass('active'); $(this).addClass('active');$('#current_role').val('Corporate Recruiter');$('.role_error').remove(); ">Corporate
Recruiter</div>

<div class="status agency"
	onClick="$('.status').removeClass('active'); $(this).addClass('active');$('#current_role').val('Agency Recruiter');$('.role_error').remove(); ">Agency
(3rd party) Recruiter</div>

<div class="status last freelance"
	onClick="$('.status').removeClass('active'); $(this).addClass('active');$('#current_role').val('Freelance Recruiter');$('.role_error').remove(); ">Freelance
Recruiter</div>
<?php echo $this->Form->input('current_role',array('label'=>false,
                	  'type'=>'hidden','id'=>'current_role'));?> <span
	class="input_row"> <label>Phone No<span>*</span></label> <span
	class="small_input1"><?php echo $this->Form->input('Recruiter.phone_nbr.code',array('label'=>false,
            'placeholder'=>'+1234'));?></span> <span
	class="small_input2"> <?php echo $this->Form->input('Recruiter.phone_nbr.number',array('label'=>false,
            'placeholder'=>'12345678910','class'=>'RecruiterPhoneNbrNumber validate[required,custom[integer]]','data-errormessage-value-missing'=>'Please enter phone number','data-errormessage'=>"Please enter only numeric value"));?></span>
</span> </section> <!-- set data while validation error occur --> <?php 
$curRole=$this->Form->value('current_role');

if(isset($curRole) && $curRole=="Corporate Recruiter"){?> <script
	type="text/javascript">
	       $(function(){
		      $(".r_profile .corporate").trigger('click');
	      });	       
	    </script> <?php }?> <?php        
	    if(isset($curRole) && $curRole=="Agency Recruiter"){?> <script
	type="text/javascript">
	       $(function(){
		      $(".r_profile .agency").trigger('click');
	      });	       
	    </script> <?php }?> <?php 

	    if(isset($curRole) && $curRole=="Freelance Recruiter"){?> <script
	type="text/javascript">
	       $(function(){
		      $(".r_profile .freelance").trigger('click');
	      });
		      	       
	    </script> <?php }?> <section class="inputs">
<div class="input_row less"><label>Current Company<span>*</span></label>
	    <?php echo $this->Form->input('current_company',array('label'=>false,'required'=>'required',
                	  'placeholder'=>'Name of your company','error' => false,'class'=>'current_company validate[required]','data-errormessage-value-missing'=>'Please enter current company'));?>
</div>
<div class="input_row less"><label>Company Website<span>*</span></label>
	    <?php $websiteVal='';
	    if($this->Form->value('company_website')!='')
			  $websiteVal=$this->Form->value('company_website');

			  echo $this->Form->input('company_website',array('label'=>false,'required'=>'required',
                	  'placeholder'=>'http://www.abc.com','error' => false,'value'=>$websiteVal,'class'=>'company_website validate[required,custom[url]]','data-errormessage-value-missing'=>'Please enter company website','data-errormessage'=>"Please enter a valid website address"));?>
</div>
<div class="input_row less"><label>Current Designation<span>*</span></label>
			  <?php echo $this->Form->input('current_designation',array('label'=>false,'required'=>'required',
                	  'placeholder'=>'Current Designation','value'=>$locVal,'error' => false,'class'=>'current_designation validate[required]','data-errormessage-value-missing'=>'Please enter current designation'));?>
</div>
<div class="input_row  less last"><?php $locVal='';
if($this->Form->value('current_location')!=''){
	$locVal=$this->Form->value('current_location');
}?> <script language="JavaScript">
             <?php if($this->Form->value('current_location')==''){?>
			 $(function(){
				 var str=geoip_country_name();
				 if(str.toLowerCase()=='canada' || str.toLowerCase()=='usa' || str.toLowerCase()=='india'){
				 $('#RecruiterCurrentLocation').val(geoip_city()+', '+geoip_region_name()+', '+geoip_country_name());
				 }else{
					 $('#RecruiterCurrentLocation').val(geoip_city()+', '+geoip_country_name());
				 }
				detectNationality();
			 });
			<?php }?>
            </script> <label>Current Location<span>*</span></label> <?php echo $this->Form->input('current_location',array('label'=>false,'required'=>'required',
                	  'placeholder'=>'City','value'=>$locVal,'error' => false,'class'=>'current_location validate[required]','data-errormessage-value-missing'=>'Please enter city','onblur'=>'detectNationality();'));?>

</div>
</section>

<div class="input_row experiance"><label class="pad">Recruiting
Experience<span>*</span> </label> <?php echo $this->Form->input('Recruiter.recruiting_experience.year',array('label'=>false,'error' => false,'div'=>false,'type'=>'text','class'=>'RecruiterRecruitingExperienceYear validate[groupRequired[experience],custom[integer]]','data-errormessage-value-missing'=>'Please enter experience','data-errormessage'=>"Please enter only numeric value"));?>
<label class="pad">years</label> <?php echo $this->Form->input('Recruiter.recruiting_experience.month',array('label'=>false,
        		 'required'=>'required','type'=>'text','error' => false,'div'=>false,'class'=>'RecruiterRecruitingExperienceMonth validate[groupRequired[experience],custom[integer],max[11]]','data-errormessage-value-missing'=>'Please enter experience','data-errormessage'=>"Please enter only numeric value",'data-errormessage-range-overflow'=>'month cannot exceed 11'));?>
<label class="pad">months</label></div>
</section> <section class="public_profile">
<h3>Public Profile<span>*</span></h3>
<section class="inputs">
<div class="input_row">
<ul class="public_pro">
	<li onclick="showSocialInput(this);" title="LinkedIn" class="linkdin">
	<div class="tooltip">
	<div class="tt">Please Enter your Profile URL <span class="input_box">
	<?php echo $this->Form->input('Recruiter.online_profiles.linkedin',
	array('label'=>false,'onclick'=>'if (this.value=="") this.value = "http://"','placeholder'=>'http://','class'=>'socialProfile linkedin validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"linkdin");'));?>
	<a onclick="return saveField('linkdin',event);" href="#"> <img alt=""
		src="<?php echo $this->webroot;?>images/yes.png"></a></span></div>
	<div class="arrow"></div>
	</div>
	</li>
	<li onclick="showSocialInput(this)" title="Google+" class="google">
	<div class="tooltip">
	<div class="tt">Please Enter your Profile URL <span class="input_box">
	<?php echo $this->Form->input('Recruiter.online_profiles.googleplus',
	array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile googleplus validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"google");'));?>
	<a onclick="return saveField('google',event);" href="#"> <img alt=""
		src="<?php echo $this->webroot;?>images/yes.png"></a></span></div>
	<div class="arrow"></div>
	</div>
	</li>
	<li onclick="showSocialInput(this);" title="Facebook" class="facebook">
	<div class="tooltip">
	<div class="tt">Please Enter your Profile URL <span class="input_box">
	<?php echo $this->Form->input('Recruiter.online_profiles.facebook',
	array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile facebook validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"facebook");'));?>
	<a onclick="return saveField('facebook',event);" href="#"> <img alt=""
		src="<?php echo $this->webroot;?>images/yes.png"></a></span></div>
	<div class="arrow"></div>
	</div>
	</li>
	<li onclick="showSocialInput(this);" title="Twitter" class="twitter">
	<div class="tooltip">
	<div class="tt">Please Enter your Profile URL <span class="input_box">
	<?php echo $this->Form->input('Recruiter.online_profiles.twitter',
	array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile twitter validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"twitter");'));?>
	<a onclick="return saveField('twitter',event);" href="#"> <img alt=""
		src="<?php echo $this->webroot;?>images/yes.png"></a></span></div>
	<div class="arrow"></div>
	</div>
	</li>
	<li onclick="showSocialInput(this);" title="Xing" class="xing">
	<div class="tooltip">
	<div class="tt">Please Enter your Profile URL <span class="input_box">
	<?php echo $this->Form->input('Recruiter.online_profiles.xing',
	array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile xing validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"xing");'));?>
	<a onclick="return saveField('xing',event);" href="#"> <img alt=""
		src="<?php echo $this->webroot;?>images/yes.png"></a></span></div>
	<div class="arrow"></div>
	</div>
	</li>

	<li onclick="showSocialInput(this);" title="Pinterest"
		class="pinterest">
	<div class="tooltip">
	<div class="tt">Please Enter your Profile URL <span class="input_box">
	<?php echo $this->Form->input('Recruiter.online_profiles.pinterest',
	array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile pinterest validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"pinterest");'));?>
	<a onclick="return saveField('pinterest',event);" href="#"> <img alt=""
		src="<?php echo $this->webroot;?>images/yes.png"></a></span></div>
	<div class="arrow"></div>
	</div>
	</li>
	<li onclick="showSocialInput(this);" title="ApnaCircle"
		class="apnacircle">
	<div class="tooltip">
	<div class="tt">Please Enter your Profile URL <span class="input_box">
	<?php echo $this->Form->input('Recruiter.online_profiles.apnacircle',
	array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile apnacircle validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"apnacircle");'));?>
	<a onclick="return saveField('apnacircle',event);" href="#"> <img
		alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span></div>
	<div class="arrow"></div>
	</div>
	</li>
	<li onclick="showSocialInput(this);" title="Blog" class="blogger">
	<div class="tooltip big">
	<div class="tt">Please Enter your Profile URL <span class="input_box">
	<?php echo $this->Form->input('Recruiter.online_profiles.blogger.',
	array('label'=>false,'placeholder'=>'http://','required'=>false,'onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile blogger validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"blogger");'));?>
	<!-- 
                       <a href="#"><img alt="" src="<?php echo $this->webroot;?>images/plus_forward.png" class="plus"></a> 
                       --> <a
		onclick="return saveField('blogger',event);" href="#"> <img alt=""
		src="<?php echo $this->webroot;?>images/yes.png"></a> <!-- 
                        <a href="#"> <img alt="" src="<?php echo $this->webroot;?>images/close.jpg"></a>
                           --> </span></div>
	<div class="arrow"></div>
	</div>
	</li>
	<li onclick="showSocialInput(this);" title="SkillPages"
		class="skillpages">
	<div class="tooltip">
	<div class="tt">Please Enter your Profile URL <span class="input_box">
	<?php echo $this->Form->input('Recruiter.online_profiles.skillpages',
	array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile skillpages validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"skillpages");'));?>
	<a onclick="return saveField('skillpages',event);" href="#"> <img
		alt="" src="<?php echo $this->webroot;?>images/yes.png"></a></span></div>
	<div class="arrow"></div>
	</div>
	</li>
	<li onclick="showSocialInput(this);" title="About.me" class="about_me">
	<div class="tooltip">
	<div class="tt">Please Enter your Profile URL <span class="input_box">
	<?php echo $this->Form->input('Recruiter.online_profiles.about_me',
	array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile about_me validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"about_me");'));?>
	<a onclick="return saveField('about_me',event);" href="#"> <img alt=""
		src="<?php echo $this->webroot;?>images/yes.png"></a></span></div>
	<div class="arrow"></div>
	</div>
	</li>
	<li onclick="showSocialInput(this);" class="others"><a
		href="javascript:void(0)"> <span
		onclick="$('.input_row span').removeClass('active'); $(this).addClass('active'); ">Others</span></a>
	<div class="tooltip other_small">
	<div class="tt">Please Enter Details <span class="input_box"> <?php echo $this->Form->input('Recruiter.online_profiles.other.website_name',
	array('label'=>false,'placeholder'=>'Name of Website'));?> <?php echo $this->Form->input('Recruiter.online_profiles.other.website_link',
	array('label'=>false,'placeholder'=>'http://','onclick'=>'if (this.value=="") this.value = "http://"','class'=>'socialProfile website_link validate[custom[url]]','data-errormessage'=>"Please enter a valid website address",'onblur'=>'if(this.value=="http://") this.value=""; showColorIcon(this,"others");'));?>
	<a onclick="return saveField('others',event);" href="#"> <img alt=""
		src="<?php echo $this->webroot;?>images/yes.png"></a></span></div>
	<div class="arrow"></div>
	</div>
	</li>
</ul>
</div>
</section> </section> <section class="i_hire">
<h3>I hire for/in</h3>                                                      <!-- Modified Br Rajesh -->
<section class="inputs">
<div class="input_row"><label class="recLabel">Domains</label>
<div class="select_box company"><a href="javascript:void(0)">Domain</a>
<ul class="drop_down">
	<li>
      <label>
	    <?php echo $this->Form->input('RecruiterDomain.domain_id',array('multiple'=>'checkbox','label'=>false,'options'=>$domain));?>
      </label>
    </li>

	<li class="last" id="otherOption" style="display:none"><?php echo $this->Form->input('RecruiterDomain.other_domain',array('label'=>false,'placeholder'=>' Others'));?><!--<a href="#">Submit</a>--></li>
</ul>
</div>
<div class="skills"><label class="pad">Skills / Technologies</label> <?php echo $this->Form->input('skills',array('label'=>false,'error' => false,'placeholder'=>'Java, sales, finance'));?>
</div>
</div>

<div class="input_row"><label class="recLabel">Roles </label> <?php echo $this->Form->input('roles',array('label'=>false,'error' => false));?>
</div>

<div class="input_row"><label class="recLabel">Geographies </label> <?php echo $this->Form->input('geographies',array('label'=>false,'error' => false,'placeholder'=>'USA, India, China, Europe'));?>

</div>

<div class="input_row"><label class="recLabel">Type of Companies</label>
<ul class="company_selector">
	<li class="startup" onClick="setCompanyType(this,'Startup');">Startup</li>
	<li class="product"
		onClick="setCompanyType(this,'Product Development');">Product
	Development</li>
	<li class="services" onClick="setCompanyType(this,'Services based');">Services
	based</li>
	<li class="cmm5" onClick="setCompanyType(this,'CMMI_5');">CMMI 5</li>
	<li class="cmm3" onClick="setCompanyType(this,'CMMI_3');">CMMI 3</li>
	<li class="onsite" onClick="setCompanyType(this,'Onsite');">Onsite
	(International)</li>
	<li class="fortune100" onClick="setCompanyType(this,'Fortune_100');">Fortune
	100</li>
	<li class="fortune500" onClick="setCompanyType(this,'Fortune_500');">Fortune
	500</li>
	<li class="fortune1000" onClick="setCompanyType(this,'Fortune_1000');">Fortune
	1000</li>
	<li class="last otherComp" id="otherComp"
		onClick="setCompanyType(this,$('#others').val());"><input type="text"
		name="data[Recruiter][otherComp]" id="others" placeholder="Others" /></li>
</ul>
	<?php echo $this->Form->input('type_of_companies',array('label'=>false,
                	  'type'=>'hidden','id'=>'type_of_companies','value'=>''));?>
</div>
</section> </section> <!-- set data while validation error occur --> <?php 
$companyType=$this->Form->value('type_of_companies');
$comType=explode(',',$companyType);
//print_r($comType);die;
foreach($comType as $type){
	if($type=="Startup"){?> <script type="text/javascript">
	       $(function(){
		      $("ul.company_selector .startup").trigger('click');
	      });	       
	    </script> <?php }?> <?php        
	    if($type=="Product Development"){?> <script type="text/javascript">
	       $(function(){
		      $("ul.company_selector .product").trigger('click');
	      });	       
	    </script> <?php }?> <?php 

	    if($type=="Services based"){?> <script type="text/javascript">
	       $(function(){
		      $("ul.company_selector .services").trigger('click');
	      });
		      	       
	    </script> <?php }?> <?php 

	    if($type=="CMMI 5"){?> <script type="text/javascript">
	       $(function(){
		      $("ul.company_selector .cmm5").trigger('click');
	      });
		      	       
	    </script> <?php }?> <?php 

	    if($type=="CMMI 3"){?> <script type="text/javascript">
	       $(function(){
		      $("ul.company_selector .cmm3").trigger('click');
	      });
		      	       
	    </script> <?php }?> <?php 

	    if($type=="Onsite"){?> <script type="text/javascript">
	       $(function(){
		      $("ul.company_selector .onsite").trigger('click');
	      });
		      	       
	    </script> <?php }?> <?php 

	    if($type=="Fortune_hundred"){?> <script type="text/javascript">
	       $(function(){
		      $("ul.company_selector .fortune100").trigger('click');
	      });
		      	       
	    </script> <?php }?> <?php 

	    if($type=="Fortune_five_hundred"){?> <script type="text/javascript">
	       $(function(){
		      $("ul.company_selector .fortune500").trigger('click');
	      });
		      	       
	    </script> <?php }?> <?php 

	    if($type=="Fortune_thousand"){?> <script type="text/javascript">
	       $(function(){
		      $("ul.company_selector .fortune1000").trigger('click');
	      });
		      	       
	    </script> <?php }?> <?php 
	    $otherCompany=$this->Form->value('otherComp');
	    if(isset($otherCompany) && $otherCompany!=''){?> <script
	type="text/javascript">
	       $(function(){
			   $("ul.company_selector .otherComp").addClass('active');
			   $("#others").val('<?php echo $otherCompany;?>');
			    
			  
	      });
		      	       
	    </script> <?php }
}?> <section class="client_list">
<h3>Client List<span class="question"><a href="#"><img
	src="<?php echo $this->webroot; ?>img/question.png" alt=""
	title="Bragging rights. This shows the quality of work experience and provides extremely useful information to the candidates that they are workinng with the right recruiter for a particular job. Your Client List is only shown to professionals and not to fellow recruiters." /></a></span>
<div class="profile_row recruiter"><small>(</small> <label class="main">Who
can view your profile :</label> <img alt=""
	src="<?php echo $this->webroot;?>images/yes_sign.jpg"> <label>Professionals
/ Jobseekers</label> <img alt=""
	src="<?php echo $this->webroot;?>images/close.jpg"> <label>Other
recruiters</label> <small class="right">)</small></div>
</h3>

<section class="inputs"> <span class="input_row"> <label>Company</label><?php echo $this->Form->input('RecruiterClient.company_name',array('label'=>false,'placeholder'=>'Company Name'));?>
</span> <span class="input_row"> <label>Company Website</label>
<?php echo $this->Form->input('RecruiterClient.company_website',array('label'=>false,'placeholder'=>'http://www.abc.com','class'=>'company_website validate[custom[url]]','data-errormessage'=>"Please enter a valid website address"));?>
</span> <span class="input_row total_placed"> <label>Candidates Placed</label><?php echo $this->Form->input('RecruiterClient.candidate_placed',array('label'=>false,'type'=>'text','class'=>'less validate[custom[integer]]','data-errormessage'=>"Please enter only numeric value"));?>
</span>
<div class="input_row less"><span
	onClick="$('.input_row span').removeClass('active'); $(this).addClass('active');$('#type_of_hire').val('Direct'); ">Direct</span>
<span
	onClick="$('.input_row span').removeClass('active'); $(this).addClass('active');$('#type_of_hire').val('Indirect'); ">Indirect</span>
<?php echo $this->Form->input('RecruiterClient.type_of_hire',array('label'=>false,
                	  'type'=>'hidden','id'=>'type_of_hire'));?></div>
<div class="add_btn right"><a class="pad" href="javascript:void(0)"
	onClick="return updateAddClients();">add</a> <img
	src="<?php echo $this->webroot;?>img/ajax-loader.gif" alt="wait.."
	id="loader1" style="display: none" /></div>
</section>

<table class="update_client">
	<thead>
		<tr>
			<th>Company</th>
			<th>Type of hire</th>
			<th class="last">Candidates Placed</th>
		</tr>
	</thead>
	<tbody class="client_data">

	<?php if(!empty($recruiterClient)){

		foreach($recruiterClient as $client){ ?>
		<tr>
			<td><?php echo $client['RecruiterClient']['company_name'];?></td>
			<td><?php echo $client['RecruiterClient']['type_of_hire'];?></td>
			<td class="last"><?php echo $client['RecruiterClient']['candidate_placed'];?></td>
		</tr>
		<?php } }?>
	</tbody>
</table>
</section> <section class="agree recruit">
                                                           <!--  Modified by Rajesh  -->
<p>We are building a unique platform for recruiters. Your details will be verified before you are given access to professional search.</p>
		<?php echo $this->Form->input('terms_acceptance_flag',array('label'=>false,
          			  'type'=>'checkbox','error'=>false,'class'=>'terms_acceptance_flag validate[required]','data-errormessage-value-missing'=>'Please select terms & conditions','checked'=>false));?>
I agree with the <a href="#">Terms of Service</a> &amp; <a href="#">Privacy
Policy</a> </section> <section class="capcha" style="display:none"> <img
	id="captcha"
	src="<?php echo $this->Html->url('/common/captcha_image');?>" alt="" />
<a href="javascript:void(0);"
	onclick="javascript:document.images.captcha.src='<?php echo $this->Html->url('/common/captcha_image');?>?' + Math.round(Math.random(0)*1000)+1">Reload
image</a> <?php echo $this->Form->input('captcha_value',array('label'=>false,
          			  'type'=>'text','required'=>'required','value'=>'','class'=>'captcha_value validate[required]','data-errormessage-value-missing'=>'Please enter above code'));?>
</section> <span class="sign_up"> <?php echo $this->Form->input('recruiter_signup',array('label'=>false,
          			  'type'=>'hidden','value'=>'1'));?> <?php echo $this->Form->input('Sign Up',array('label'=>false,
          			  'type'=>'submit','class'=>'sign_up_blue submit'));?> </span>
</fieldset>
<?php echo $this->Form->end();?> </section></div>
<script type="text/javascript">

/*********************************************
  Script function for hide and display other domain text box.
  Developed by Rajesh Kumar Kanojia
**********************************************/
$(document).ready(function(){

 $("#RecruiterDomainDomainId15").click(function(){
	if($("#RecruiterDomainDomainId15").is(':checked'))
	   $("#otherOption").css('display','block');
	else 
	   $("#otherOption").css('display','none');
 });

});


$(document).ready(function(){
	$(document).click(function(e) {
        var clickedOn = $(e.target);
		if (clickedOn.parents().andSelf().is('.tooltip')||clickedOn.parents().andSelf().is('.public_pro li'))
		{ }else{
	
			$('.public_pro li').removeClass('active');	
			$('.select_box.company').removeClass('active');	
		}
  	});
	
	$('.select_box').click(function(e) {
	
	
		$(this).addClass('active');
		e.stopPropagation();
	});

	$('#RecruiterDomainOtherDomain,.checkbox input,.checkbox label').click(function(e) {
	
		e.stopPropagation();
	});
	
});


jQuery(document).ready(function(){
       jQuery("#recruiter_signup").validationEngine('attach',{promptPosition: "bottomLeft",scroll: false});
	 
	  $('input[type="text"],input[type="email"], input[type="password"]').each(function() {
		 if($(this).val()!='' && $(this).attr('id')!='others' && !$(this).hasClass('socialProfile') && !$(this).hasClass('captcha_value'))
				 $(this).validationEngine().css({'background-color' : "#FAFFBD"});
				 
				 if($(this).hasClass('socialProfile')){
			 		var id=$(this).attr('id');
					 $("#"+id).trigger('blur');
		 }
	  });
       
        
    $( 'input[type="text"],input[type="email"],input[type="password"]' ).focus(function() {
		$(this).validationEngine('hide');
		if($(this).attr('id')!='others')
		$(this).validationEngine().css({border : "1px solid #D5D0D0"});
		if(!$(this).hasClass('socialProfile') && $(this).attr('id')!='others')
		$(this).validationEngine().css({'background-color' : "#ffffff"});
	});

	$( 'input[type="text"],input[type="email"],input[type="password"]' ).blur(function() {
				 
			var error=$(this).validationEngine('validate');
				
				if(error){
				$(this).validationEngine().css({border : "1px solid red"});
			 }else{
				 if($(this).val()!='' && $(this).attr('id')!='others' && !$(this).hasClass('socialProfile') && !$(this).hasClass('captcha_value'))
				 $(this).validationEngine().css({'background-color' : "#FAFFBD"});
				 
			 }
			  if($(this).hasClass('RecruiterRecruitingExperienceYear')){
				if($(this).val()!=''){
				$('.RecruiterRecruitingExperienceMonth').css({border : "1px solid #D5D0D0"});	
				$('.RecruiterRecruitingExperienceMonthformError').remove();
				}
			 }
			 if($(this).hasClass('RecruiterRecruitingExperienceMonth')){
				if($(this).val()!=''){
				$('.RecruiterRecruitingExperienceYear').css({border : "1px solid #D5D0D0"});	
				}
			 }
	
	});
			
	$("#RecruiterTermsAcceptanceFlag").change(function() {
		$('.capcha').hide();
   		 if($(this).is(':checked')) {
			$('.capcha').show();
			$('.RecruiterTermsAcceptanceFlagformError').remove();
    	}
	});
});


$(function() {
	$( ".tool_tip" ).tooltip({
	      show: {
	        effect: "slideDown",
	        delay: 250
	      }
	});
	$("#RecruiterPhoneNbrCode").autocomplete({
		source:"<?php echo Router::url('/', true);?>professionals/findPhoneCode",
    	minChars: 2
		
    });
	$("#RecruiterCurrentLocation").autocomplete({
		source:"<?php echo Router::url('/', true);?>professionals/findCurrentLocation",
    	minChars: 2
		
    });
	
	
	 function split( val ) {
		return val.split( /,\s*/ );
		}
 
		function extractLast( term ) {
			return split( term ).pop();
			}
 
			$( "#RecruiterSkills" ).autocomplete({
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
			
			$( "#RecruiterGeographies" ).autocomplete({
			source: function( request, response ) {
			$.getJSON( "<?php echo Router::url('/', true);?>professionals/findGeographies", {
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
			
	$('#RecruiterCompanyWebsite,.socialProfile,#RecruiterClientCompanyWebsite').keyup(function(){

		if(this.value.length<=6){
			this.value = 'http://';
		}

		if(this.value.indexOf('http://') !== 0 ){ 
	        this.value = 'http://' + this.value;
	     }	   

	});

	$('#RecruiterCompanyWebsite').blur(function() {
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

function setCompanyType(objThis,txt){
	
	/*$('.company_selector li').removeClass('active');
		 $(objThis).addClass('active');
		 $('#type_of_companies').val(val);*/
		 
		 
	var obj=$(objThis);	
	var myInput = $('#type_of_companies').val();
	
		obj.toggleClass('active');
	
	
		if (myInput.indexOf(txt) >= 0 && txt!=''){
			var subTxt=myInput.substring(myInput.indexOf(txt), myInput.length - 1);
			var replaceTxt='';
			if(subTxt.indexOf(',') > -1){
				replaceTxt=txt+',';
			}else if(myInput.indexOf(',') > -1){
				replaceTxt=','+txt;
			}else{
				replaceTxt=txt;
			}
			
			myInput=myInput.replace(replaceTxt,'');
			/*myInput=myInput.replace(',','');*/
			$('#type_of_companies').val($.trim(myInput));
		}else{
		
		if(myInput!=''){
			if(txt!=''){
				myInput+=','+txt;
			}
		$('#type_of_companies').val(myInput);
		}else{
			
		$('#type_of_companies').val(txt);
		}
	}


	if(obj.attr('id')=='otherComp'){
		$('#others').val('');
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
function checkValidation(){
	
	
	var i=0;
	if($('#current_role').val()==''){
		$('.role_error').remove();
		$('.r_profile').append("<div class='role_error'>please select current role</div>");
		i++;
	}
	
	var input = ['linkdin','google','facebook','twitter','xing','pinterest','apnacircle','blogger','skillpages','about_me','others'];
	
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
		return true;
	}
}
function detectNationality(){
	var location=$('#RecruiterCurrentLocation').val();
	if(location!=''){
	$.post('<?php echo $this->webroot;?>professionals/detectNationality',{location:location},function(data){
	var res = data.split(',');
	$('#RecruiterPhoneNbrCode').val(res[2]);
	$('#RecruiterPhoneNbrCode').trigger('blur');	
	});
	}

}

</script>
<script type="text/javascript">
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
			$.post('<?php echo $this->webroot;?>recruiters/crop_profile_image',$('#cropImageHolder').serialize(),function(data){
				$('#loader').hide();
				$('#profile_photo_name').val(data);
				$('.profile_pic').attr('src', '<?php echo $this->webroot;?>files/temp_recruiter_images/'+data+'');
				
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
		   $.post('<?php echo $this->webroot;?>recruiters/delete_uploaded_image',{profImageName:profImageName},function(data){
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
										
					
					$('.targetImg').attr('src', '<?php echo $this->webroot;?>files/temp_recruiter_images/recruiter_'+file+'');
					$('.jcrop-preview').attr('src', '<?php echo $this->webroot;?>files/temp_recruiter_images/recruiter_'+file+'');
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
	
function updateAddClients(){
	var id='<?php echo $recruiterId;?>';
	var comp_name=$('#RecruiterClientCompanyName').val();
	var comp_website=$('#RecruiterClientCompanyWebsite').val();
	var candidate=$('#RecruiterClientCandidatePlaced').val();
	var hire_type=$('#type_of_hire').val();
	var validate = $("#RecruiterClientCompanyWebsite").validationEngine('validate');
	 
	if(!validate){
		$('#commentStatus').html('');
		$('#loader1').show();
		
		
		$.post('<?php echo $this->webroot;?>recruiters/add_client_lists',{id:id,comp_name:comp_name,comp_website:comp_website,candidate:candidate,hire_type:hire_type},function(data){
			$('#loader1').hide();
			
			var result=JSON.parse(data);
			if(result.Success){
				$('#commentStatus').html(result.Success);
				$('.update_client .client_data').append('<tr><td>'+result.company+'</td><td>'+result.type_of_hire+'</td><td class="last">'+result.candidate+'</td></tr>');
				$('#RecruiterClientCompanyName').val('');	
				$('#RecruiterClientCompanyWebsite').val('');
				$('#RecruiterClientCandidatePlaced').val('');	
				$('#type_of_hire').val('');
				$('.input_row span').removeClass('active');
				$('#RecruiterClientCompanyName,#RecruiterClientCompanyWebsite,#RecruiterClientCandidatePlaced').validationEngine().css({'background-color' : "#ffffff"});
				}
		
			setTimeout(function() {
					$.fancybox.close();
			}, 2000);
		
			
		});
	
	}
	
		
	return false;
}


</script>
