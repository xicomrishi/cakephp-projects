<style type="text/css">
.ui-autocomplete{ max-height: 270px !important;overflow: auto; z-index:99999;}
</style>
<?php 
if(isset($profDetail) && !empty($profDetail)){
	extract($profDetail['Professional']);	
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
<form name="EditProfessionals" method="post" id="EditProfessionals" action="#" onsubmit="return updateBasicDetails();" novalidate="novalidate">

<section class="inputs">
<div class="input_row"><label>Company Name:<span class="req">*</span></label>

<?php echo $this->Form->input('Professional.current_company',array('label'=>false,'required'=>'required','value'=>$current_company,
                	  'placeholder'=>'Name of your company','class'=>'current_company validate[required]','data-errormessage-value-missing'=>'Please enter current company'));?>
</div>
<div class="input_row last"><label>Current Location:<span class="req">*</span></label>
<?php echo $this->Form->input('Professional.current_location',array('label'=>false,'required'=>'required','value'=>$current_location,
                	  'placeholder'=>'City','class'=>'current_location validate[required]','data-errormessage-value-missing'=>'Please enter city','onblur'=>'detectNationality();'));?>
 </div>
<div class="input_row"><label>Company Website<span class="req">*</span></label> 
<?php echo $this->Form->input('Professional.company_website',array('label'=>false,
'required'=>'required','value'=>$company_website,
'placeholder'=>'http://www.abc.com','class'=>'company_website validate[required,custom[url]]',
'data-errormessage-value-missing'=>'Please enter company website','data-errormessage'=>"Please enter a valid website address"));?>
</div>
<!--
<div class="input_row">
    <label>Job Type<span class="req">*</span></label>
     <div onclick="$(this).toggleClass('active'); " class="select_box">
	<a href="javascript:void(0)">Job Type</a>
                            <ul class="drop_down">
		<li><label><input type="checkbox" value="">Full Time</label></li>
		<li><label><input type="checkbox" value="">Contract</label></li>
		<li><label><input type="checkbox" value="">Contract to Hire</label></li>
		<li><label><input type="checkbox" value="">Part Time</label></li>
		<li><label><input type="checkbox" value="">Freelance</label></li>
		<li><label><input type="checkbox" value="">Temp</label></li>
		<li class="last"><label><input type="checkbox" value="">Intern</label></li>
	</ul>
</div>
</div>                   
-->
</section>

<section class="inputs">
<div class="input_row full_skill"><label>Skills:<span class="req">*</span></label>
<div class="input_text skills">
<?php echo $this->Form->input('Professional.skills',array('label'=>false,'value'=>$skills,'placeholder'=>'Java, sales, finance','class'=>'skills validate[required]','data-errormessage-value-missing'=>'Please enter skills','after'=>'<div class="multiple_loc">(Separate multiple skills by comma)</div>'));?>
</div>
</div>

</section>

<section class="inputs">
<div class="input_row last"><label>Nationality:<span class="req">*</span></label>
<?php echo $this->Form->input('Professional.nationality',array('label'=>false,'value'=>$nationality,'error' => false,'placeholder'=>'Country of Citizenship','class'=>'nationality validate[required]','data-errormessage-value-missing'=>'Please enter nationality'));?>
 </div>
<div class="input_row"><label>Email:<span class="req">*</span></label>
 <?php echo $this->Form->input('Professional.email',array('value'=>$email,
             				'label'=>false,'required'=>'required','placeholder'=>'Email','class'=>'email validate[required,custom[email]]','data-errormessage-value-missing'=>'Please enter email','data-errormessage'=>"Please enter valid email id"));?>
</div>
<div class="input_row more_pad phone"><label>Phone Number:</label>
<div class="input_text small_text1">
<?php 
 echo $this->Form->input('Professional.phone_nbr.code',array('label'=>false,'value'=>$phone_nbr['code'],
		            'placeholder'=>'+1234'));?></div>

<div class="input_text small_text2">

 <?php echo $this->Form->input('Professional.phone_nbr.number',array('label'=>false,'value'=>$phone_nbr['number'],
		            'placeholder'=>'12345678910','class'=>'ProfessionalPhoneNbrNumber validate[custom[integer]]','data-errormessage'=>"Please enter only numeric value"));?></div>

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
function updateBasicDetails(){
	 var validate = $("#EditProfessionals").validationEngine('validate');
	 if(validate){
	    $('#commentStatus').html('');
	    $('#loader1').show();
	
	    $.post('<?php echo $this->webroot;?>professionals/edit_basic_details',$('#EditProfessionals').serialize(),function(data){
	         $('#loader1').hide();
	         var res = data.split(',');
	         if(res[1]=='error'){
	            $('#commentStatus').html(res[0]);	
	         }else{
	            $('#commentStatus').html(res[0]);
	            $.fancybox.close();                // Modified by Rajesh to close the fancy box.
//	            setTimeout(function() {
//				              window.location='<?php echo $this->webroot;?>professionals/profile';
//		                   }, 2000);
	         }
		
	    });
	
	 }
	
		
return false;
}
function detectNationality(){
	var location=$('#ProfessionalCurrentLocation').val();
	if(location!=''){
	$.post('<?php echo $this->webroot;?>professionals/detectNationality',{location:location},function(data){
		
	var res = data.split(',');
	
	
	$('#ProfessionalNationality').val(res[0]);
	$('#ProfessionalPhoneNbrCode').val(res[2]);
		
	$('#ProfessionalNationality,#ProfessionalPhoneNbrCode').trigger('blur');	
	});
	}

}
</script>
