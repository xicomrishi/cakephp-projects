<div id="header_outer">
<div class="wrapper">
<header>
  
 <!--profile nav( visible after login )-->
 <?php 
 
 $prof=$this->Session->read('Professional');
 $recprof=$this->Session->read('Recruiter');
 $homeURL=$this->webroot.'home';
	
 
 if(isset($prof)){
 	$homeURL=$this->webroot.'professionals/profile';
 ?>
 <div class="profile_btn">
  <span class="bg_img">
   <a href="<?php echo $homeURL?>">
    <input type="button" value="<?php if(isset($prof['Professional']['first_name'])){ echo ucfirst($prof['Professional']['first_name']);}?>" class="k-hover-trigger" id="btn_profile" />
   </a> 
    </span>
	<ul class="drop_down1">
	
	<li><a href="<?php echo $this->webroot;?>professionals/edit_profile"><img
		src="<?php echo $this->webroot;?>images/edit_profile.png" alt=""><small>Edit Profile</small></a></li>
	
	<li><a href="<?php echo $this->webroot;?>professionals/professional_settings"><img src="<?php echo $this->webroot;?>images/setting.png" alt=""><small>Settings</small></a></li>
	
	<li class="last">
	<a href="<?php echo $this->webroot;?>professionals/logout">
	<img src="<?php echo $this->webroot;?>images/logout_bg.png" alt=""><small>Log Out</small></a></li>
	</ul>
 </div>
 <?php }elseif(isset($recprof)){
	$homeURL=$this->webroot.'recruiters/profile'; 	
 	?>
  <div class="profile_btn">
   <span class="bg_img">
    <a href="<?php echo $homeURL;?>">
     <input type="button" value="<?php if(isset($recprof['Recruiter']['first_name'])){ echo ucfirst($recprof['Recruiter']['first_name']);}?>" class="k-hover-trigger" id="btn_profile" /></a></span>
	<ul class="drop_down1">
	
	<li><a href="<?php echo $this->webroot; ?>recruiters/edit_profile"><img
		src="<?php echo $this->webroot;?>images/edit_profile.png" alt=""><small>Edit Profile</small></a></li>
	
	<li><a href="<?php echo $this->webroot;?>recruiters/recruiter_settings"><img src="<?php echo $this->webroot;?>images/setting.png" alt=""><small>Settings</small></a></li>
	
	<li class="last">
	<a href="<?php echo $this->webroot;?>recruiters/logout">
	<img src="<?php echo $this->webroot;?>images/logout_bg.png" alt=""><small>Log Out</small></a></li>
	</ul>
  </div>
 <?php }?>
 <!--[end]profile nav( visible after login )-->

  <section class="navi">
  <ul>
  <li><a href="<?php echo $homeURL;?>">Home</a></li>
<!--  <li class="<?php if(strtolower($this->name)=='professionals'){?>active<?php }?>">
  <a href="<?php echo $this->webroot;?>professionals/profile" >Professionals</a></li>
  <li class="<?php if(strtolower($this->name)=='recruiters'){?>active<?php }?>">
  <a href="<?php echo $this->webroot;?>recruiters/profile" >Recruiters</a></li>-->

  <?php if (strpos($this->here,'page/professionals') !== false) {?>
    <li class="active"><a href="<?php echo $this->webroot;?>cms/page/professionals" >Professionals</a></li>
  <?php }else{ ?>
    <li><a href="<?php echo $this->webroot;?>cms/page/professionals" >Professionals</a></li>
  <?php }?>
  
  <?php if (strpos($this->here,'page/recruiters') !== false) {?>
    <li class="active"><a href="<?php echo $this->webroot;?>cms/page/recruiters" >Recruiters</a></li>
  <?php }else{ ?>
    <li><a href="<?php echo $this->webroot;?>cms/page/recruiters" >Recruiters</a></li>
  <?php }?>
 
  <?php if (strpos($this->here,'faq') !== false) {?>
  <li class="active"><a href="<?php echo $this->webroot;?>cms/page/faqs">FAQs</a></li>
  <?php }else{ ?>
  <li><a href="<?php echo $this->webroot;?>cms/page/faqs">FAQs</a></li>
  <?php }?>
  
  <li class="<?php if (strpos($this->here,'about_us') !== false || $this->action=='contact_us') {?>drop active"<?php }else{ echo "drop"; }?>">
  <a href="<?php echo $this->webroot;?>cms/page/about_us" >About Us</a>
  		<ul class="submenu">
        	<li class="last"><a href="<?php echo $this->webroot;?>contacts">Contact Us</a></li>
        </ul>
  </li>
  <li class="last blog"><a href="#">Blog</a></li>
  </ul>
  </section>
  </header>
  
</div>
</div>