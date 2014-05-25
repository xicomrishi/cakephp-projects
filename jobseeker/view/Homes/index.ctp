<div class="wrapper">  
  <section id="home_content">  
  
  <?php echo $this->Session->flash();?>
  
  <section class="slider_green">
  <a id="slideLeftArrow" class="left_arrow proff" href="#" ></a>
  <a id="slideRightArrow" class="right_arrow proff" href="#" ></a>
  <section class="caption">
  <strong>Keep recruiters informed that you are still 
looking for a change. </strong>
  <ul>
  <li>Are the recruiters calls down to a trickle in a few weeks of your job search?</li>
  <li>Still looking for a job? Let the recruiters know</li>
  </ul>
  <a id="_recruiter1_professionals" class="g_learn learn" href="#" >Learn More</a>
  </section>
  <!--<ul class="paging_green">
   <li><a href="#" ></a></li>
   <li><a href="#" ></a></li>
   <li><a href="#" ></a></li>
   <li><a href="#" ></a></li>
  </ul>-->
  </section>
  
  <section class="anchor_btn">
  <a id="_professional1" class="professionals left"  >Professionals</a>
  <a id="_recruiter1" class="recruiters right"  >Recruiters</a>
  </section>
  </section>
</div>
  <span class="line"></span>
  
 <div class="wrapper">
  <section id="bottom_content">
 	<?php

 	echo $this->Form->create('User',
 		array('enctype'=>'multipart/form-data',
 		'inputDefaults'=>array( 'div'=> false, "label"=>false),
 		'url'=>'/professionals/signup','novalidate'));?> 
  	 <fieldset>
   	<div class="input_row">
    <?php $firstName='';$lastName='';$emailVal='';
			if($this->Session->check('homeError')){
				$firstName=$this->Session->read('homeError.fname');
				$lastName=$this->Session->read('homeError.lname');
				$emailVal=$this->Session->read('homeError.email');
				$userTypeVal=$this->Session->read('homeError.user_type');
				$errorMsg=$this->Session->read('homeError.msg');
				
			?>
     		 <div class="error_msg"><?php  echo $errorMsg;?></div>
     
			<?php  unset($_SESSION['homeError']);
			}
			?>
           
           
	<?php 
	
	echo $this->Form->input('first_name',array('placeholder' => 'First Name','class'=>'first_name validate[required]','data-errormessage-value-missing'=>'Please enter first name','value'=>$firstName));
	echo $this->Form->input('last_name',array('placeholder'=>'Last Name','class'=>'last_name validate[required]','data-errormessage-value-missing'=>'Please enter last name','value'=>$lastName));
	echo $this->Form->input('email',array('placeholder'=>'Email','class'=>'email validate[required,custom[email]]','data-errormessage-value-missing'=>'Please enter email id','data-errormessage'=>"Please enter valid email id",'value'=>$emailVal));
	echo $this->Form->input('index_counter',array('type'=>'hidden','value'=>'1'));
	?>

   </div>
   <section class="radio">
   <div class="radio_row">
   <?php $checked1=false;
   	   if(isset($userTypeVal) && $userTypeVal=='Professionals'){ $checked1=true;}?>
        <?php $checked2=false;
   	   if(isset($userTypeVal) && $userTypeVal=='Recruiters'){ $checked2=true;}else{$checked1=true; }?>
   <?php echo $this->Form->input('user_type',array('type'=>'radio','options'=>array('Professionals'=>'Professionals'),
   'class'=>'radio_btn','checked'=>$checked1));
	?>  
   </div>   
   <div class="radio_row last">
   
   <?php 
		echo $this->Form->input('user_type',array('type'=>'radio','options'=>array('Recruiters'=>'Recruiters'),'class'=>'radio_btn','checked'=>$checked2));
	?>
   </div>
   
   </section>
  
    <?php echo $this->Form->input('Sign Up',array('type'=>'button','class' => 'sign_up_green','onclick'=>'return gotoSignup()'));
	echo $this->Form->end(); ?>
  
   
   </fieldset>
  
  </section> 
</div>
<script type="text/javascript">
/*jQuery(document).ready(function(){
        jQuery("#UserIndexForm").validationEngine('attach',{promptPosition: "bottomLeft"});
		jQuery( 'input[type="text"],input[type="email"]' ).focus(function() {
		jQuery(this).validationEngine('hide');
		
			});
		
    });*/
function gotoSignup(){
	
	var action='';
	var radSelected = $("#UserUserTypeProfessionals").is(':checked');
	
	if(radSelected){
	
	action = "<?php echo $this->webroot;?>professionals/signup";
	/*return false;*/
	}else{
		
		action = "<?php echo $this->webroot;?>recruiters/signup";
		
	}	
	$('#UserIndexForm').attr({'action':action});
	$('#UserIndexForm').submit();
	
	
}

$(document).ready(function(){
	$(".sign_up_green").css("background-color","#5E9F16");

	$("#UserUserTypeProfessionals").click(function(){
		$(".sign_up_green").css("background-color","#5E9F16");
	});
	
	$("#UserUserTypeRecruiters").click(function(){
		$(".sign_up_green").css("background-color","#0198D9");
	});
	
});


</script>