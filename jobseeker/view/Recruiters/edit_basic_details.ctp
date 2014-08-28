<style type="text/css">
.ui-autocomplete{ max-height: 270px !important;overflow: auto; z-index:99999;}
</style>
<?php 
if(isset($profDetail) && !empty($profDetail)){
	extract($profDetail['Recruiter']);	
}
?>
<section class="main_container none">
<section class="jobs">
<section class="title">
Basic Details
</section>
<section class="details">

<div id="commentStatus">

</div>
<form name="EditProfessionals" method="post" id="EditProfessionals" action="" onsubmit="return updateBasicDetails();" novalidate="novalidate">
<input type="hidden" name="data[Recruiter][id]" value="<?php echo $id; ?>"/>
<section class="inputs">
<div class="input_row"><label>Company Name:<span class="req">*</span></label>

<?php echo $this->Form->input('Recruiter.current_company',array('label'=>false,'required'=>'required','value'=>$current_company,
                	  'placeholder'=>'Name of your company','class'=>'current_company validate[required]','data-errormessage-value-missing'=>'Please enter current company'));?>
</div>
<div class="input_row last"><label>Current Location:<span class="req">*</span></label>
<?php echo $this->Form->input('Recruiter.current_location',array('label'=>false,'required'=>'required','value'=>$current_location,
                	  'placeholder'=>'City','class'=>'current_location validate[required]','data-errormessage-value-missing'=>'Please enter city','onblur'=>'detectNationality();'));?>
 </div>
<div class="input_row"><label>Company Website<span class="req">*</span></label> 
<?php echo $this->Form->input('Recruiter.company_website',array('label'=>false,'required'=>'required','value'=>$company_website,'onfocus'=>'if (this.value=="") this.value = "http://"; return false;','onblur'=>'if(this.value=="http://") this.value="";','placeholder'=>'http://www.abc.com','class'=>'company_website validate[required,custom[url]]','data-errormessage-value-missing'=>'Please enter company website','data-errormessage'=>"Please enter a valid website address"));?>
</div>

</section>


<section class="inputs">
<!--<div class="input_row last"><label>Nationality:<span class="req">*</span></label>
<?php echo $this->Form->input('Recruiter.nationality',array('label'=>false,'value'=>$nationality,'error' => false,'placeholder'=>'Country of Citizenship','class'=>'nationality validate[required]','data-errormessage-value-missing'=>'Please enter nationality'));?>
 </div>-->
<div class="input_row"><label>Email:<span class="req">*</span></label>
 <?php echo $this->Form->input('Recruiter.email',array('value'=>$email,
             				'label'=>false,'required'=>'required','placeholder'=>'Email','class'=>'email validate[required,custom[email]]','data-errormessage-value-missing'=>'Please enter email','data-errormessage'=>"Please enter valid email id",'readonly'=>'readonly'));?>
</div>
<div class="input_row more_pad phone"><label>Phone Number:<span class="req">*</span></label>
<div class="input_text small_text1">
<?php 
 echo $this->Form->input('Recruiter.phone_nbr.code',array('label'=>false,'value'=>$phone_nbr['code'],'placeholder'=>'+1234','class'=>'ProfessionalPhoneNbrNumber validate[required,custom[integer]]','data-errormessage-value-missing'=>'Please enter phone number','data-errormessage'=>'Please enter only numeric value'));?></div>

<div class="input_text small_text2">

 <?php echo $this->Form->input('Recruiter.phone_nbr.number',array('label'=>false,'value'=>$phone_nbr['number'],
		            'placeholder'=>'1234567890','class'=>'ProfessionalPhoneNbrNumber validate[required,custom[integer]]','data-errormessage-value-missing'=>'Please enter phone number','data-errormessage'=>'Please enter only numeric value'));?></div>

</div>
</section>
<section class="inputs">
<div class="add_btn">
<?php echo $this->Form->input('save',array('label'=>false,
          			  'type'=>'submit','class'=>'submit'));?>
<img src="<?php echo $this->webroot;?>img/ajax-loader.gif" alt="wait.." id="loader1" style="display:none" />
 </div>
</section>
</section>
<?php $this->Form->end();

?>

</section>
</section>
<script type="text/javascript">
jQuery(document).ready(function(){
jQuery("#EditProfessionals").validationEngine('attach',{promptPosition: "bottomLeft",scroll: false});

$('input[type="text"],input[type="email"]').each(function() {
	if($(this).val()!='')
		$(this).validationEngine().css({'background-color' : "#FAFFBD"});
	});

	$( 'input[type="text"],input[type="email"]').focus(function() {
			$(this).validationEngine('hide');
			$(this).validationEngine().css({border : "1px solid #E4E1E1"});
			$(this).validationEngine().css({'background-color' : "#ffffff"});
	});

	$( 'input[type="text"],input[type="email"]').blur(function() {
				 
		var error=$(this).validationEngine('validate');
				
		if(error){
			$(this).validationEngine().css({border : "1px solid red"});
		}else{
			if($(this).val()!='')
			$(this).validationEngine().css({'background-color' : "#FAFFBD"});
				 
		}	
	});
	
	$("#RecruiterPhoneNbrCode").autocomplete({
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
					
		$('#RecruiterCompanyWebsite').keyup(function(){
	
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
function updateBasicDetails(){
	 var validate = $("#EditProfessionals").validationEngine('validate');
	 if(validate){
	$('#commentStatus').html('');
	$('#loader1').show();
	
	
	$.post('<?php echo $this->webroot;?>recruiters/edit_basic_details',$('#EditProfessionals').serialize(),function(data){
	$('#loader1').hide();
	var res = data.split(',');
	if(res[1]=='error'){
	$('#commentStatus').html(res[0]);	
	}else{
	$('#commentStatus').html(res[0]);
    $.fancybox.close();                // Modified by Rajesh to close the fancy box.
//	setTimeout(function() {
//				window.location='<?php echo $this->webroot;?>recruiters/profile';
//		}, 2000);
	}
	
		
	});
	
	 }
	
		
return false;
}
function detectNationality(){
	var location=$('#RecruiterCurrentLocation').val();
	if(location!=''){
	$.post('<?php echo $this->webroot;?>recruiters/detectNationality',{location:location},function(data){
		
	var res = data.split(',');
	
	
	$('#RecruiterNationality').val(res[0]);
	$('#RecruiterPhoneNbrCode').val(res[2]);
		
	$('#RecruiterNationality,#RecruiterPhoneNbrCode').trigger('blur');	
	});
	}

}
</script>
