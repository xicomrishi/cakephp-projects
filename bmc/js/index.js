var site_url='http://'+window.location.host+'/bmc';
var variab='/bmc';

$(document).ready(function(e) {
    $('input[placeholder]').each(function(){  
			var input = $(this);        
			$(input).val(input.attr('placeholder'));
						
			$(input).focus(function(){
				if (input.val() == input.attr('placeholder')) {
				   input.val('');
				}
			});
				
			$(input).blur(function(){
			   if (input.val() == '' || input.val() == input.attr('placeholder')) {
				   input.val(input.attr('placeholder'));
			   }
			});
		});
});

function change_language()
{
	var lang=$('#language_select').val();
	var location=window.location;
	$.post(site_url+'/cms/change_language/'+lang,function(data){
		window.location.href=location;	
	});	
}

function get_page(page,display_in)
{
	$(display_in).html('<div style="text-align:center; margin-top:150px; height:300px;"><img src="'+site_url+'/img/hourglass.gif" alt="Loading..."/></div>');
	if(page=='dashboard')
	{	
		window.location.href=site_url+'/admin/dashboard/index';
	}else if(page=='trainer_dashboard'){
		window.location.href=site_url+'/dashboard/trainer_home';
	}else if(page=='trainers_list'){
		window.location.href=site_url+'/admin/trainer/index';	
	}else if(page=='companies_list'){
		window.location.href=site_url+'/admin/companies/index';
	}else if(page=='get_cms_content')
	{	window.location.href=site_url+'/admin/cms/index';
	}else if(page=='get_cms_questions')
	{	window.location.href=site_url+'/admin/questions/index';
	}else if(page=='get_benchmark_data')
	{	window.location.href=site_url+'/admin/benchmark/index';
	}else{
		$.post(site_url+'/dashboard/get_page/'+page,function(data){
			$(display_in).html(data);
			$.fancybox.hideLoading();	
		});	
	}	
}

function showLoading(name)
{
	$(name).html('<div style="text-align:center; margin-top:100px; height:300px;"><img src="'+site_url+'/img/hourglass.gif" alt="Loading..."/></div>');
} 

function get_trainers_index()
{
	$('.dash_tab').removeClass('active');
	$('#dash_tab_2').addClass('active');
	showLoading('.tab_detail');
	$.post(site_url+'/admin/trainer/index/1',function(data){
		$('.tab_detail').html(data);
	});		
} 

function save_trainer(num)
{
	var valid = $("#AddTrainerForm").validationEngine('validate');
	if(valid)
	{
		var frm=$('#AddTrainerForm').serialize();
		showLoading('#AddTrainerForm');
		$.post(site_url+'/trainer/save_trainer',frm,function(data){	
			if(data=='exist')
			{
				$('#AddTrainerForm').html('Trainer with this Email ID already exist!');	
			}else{
				if(num==0)
					window.location.href=site_url+'/admin/trainer/index';
				$('.name').html(data);
				$.fancybox.close();	
			}
		});
		
	}else{
		$("#AddTrainerForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	}
	return false;	
}


function open_lightbox(page,width)
{
	$.fancybox.open(
			{
				scrolling : 'no',
				'autoSize'     :   false,
				'width'             : width,
				'type'				: 'ajax',
				//'height'            : height,
				'href'          	: site_url+page,
			}
		);		
}

function change_status(id,anchor_id,status_of,new_state)      
{	
	var old_state=0;
	if(new_state==0) old_state=1;  
	$.post(site_url+'/'+status_of+'/change_status',{ id:id,status:new_state},function(data){
		$('#'+anchor_id).html(data);
		$('#'+anchor_id).attr('onclick','change_status(\"'+id+'\",\"'+anchor_id+'\",\"'+status_of+'\",\"'+old_state+'\")');			
	});	
}

function search_trainer()
{
	var frm=$('#searchTrainerForm').serialize();
	showLoading('.tab_detail');
	$.post(site_url+'/trainer/search_trainer',frm,function(data){
		window.location.href=site_url+'/admin/trainer/index';
	});	
}

function delete_trainer()
{
	iDelTotalChecked=$('.trainer_check').filter(':checked').length;
	if(iDelTotalChecked==0)
		alert("Please select the trainer(s) you want to delete");
	else{
		y=confirm("Are you sure you want to delete these trainer(s)?");
		if(y){
			search_trainer();
			return false;			
		}
		else{
			$('.trainer_check').attr('checked',false);
			$('.checkall').attr('checked',false);
		}
	}
}

function delete_course(cr_id,tr_id)
{
	if(cr_id==0)
	{
		iDelTotalChecked=$('.course_check').filter(':checked').length;
		if(iDelTotalChecked==0)
			alert("Please select the group(s) you want to delete");
		else{
			y=confirm("Are you sure you want to delete these group(s)?");
			if(y){
				document.forms['searchCourseForm'].submit();			
			}
			else{
				$('.course_check').attr('checked',false);
				$('.checkall').attr('checked',false);
			}
		}	
	}else{
		y=confirm("Are you sure you want to delete this group?");	
		if(y)
		{
			window.location.href=site_url+'/course/delete_course/'+cr_id+'/'+tr_id+'/1';
		}
	}		
}

function update_settings()
{
	var valid = $("#SettingsForm").validationEngine('validate');
	if(valid)
	{
		var frm=$('#SettingsForm').serialize();
		
		$.post(site_url+'/users/save_settings',frm,function(data){	
			if(data=='error')
			{
				$('#flashMessage').html('Old Password does not match.');
				$('#flashMessage').show();
				
			}else{
				$('#SettingsForm').html('Password updated successfully.');
				setTimeout(function(){ $.fancybox.close();},3000);	
			}
		});
		
	}else{
		$("#SettingsForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	}
	return false;	
}

function get_courses_index(tr_id)
{
	$('.dash_tab').removeClass('active');
	$('#dash_tab_2').addClass('active');
	window.location.href=site_url+'/course/index/'+tr_id
}

function save_course(type)
{
	$('#login_course_submit').hide();
	var valid = $("#AddCourseForm").validationEngine('validate');
	if(valid)
	{
		var frm=$('#AddCourseForm').serialize();		
		$.post(site_url+'/course/save_course',frm,function(data){			
			if(type==0)
				$('#AddCourseForm').html('New Group added.');
			else
				$('#AddCourseForm').html('Group updated successfully');	
			
			
			//$('#AddCourseForm').html('Assessment Link: '+rep[1]);
			get_courses_index(data);
			setTimeout(function(){ $.fancybox.close();},3000);				
		});		
	}else{
		$("#AddCourseForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
		$('#login_course_submit').show();
	}
	return false;		
}

function response_form_submit()
{	
	open_lightbox('/login/please_wait_message/1',300);
	var all_answered=1;
	var tempname=null;
	$('input:radio').each(function() {
		
		  var name = $(this).attr("name");		
		  if($("input[name='"+name+"']").is(":checked"))
		  {
			  all_answered=2; 		
		  }else{ 
				tempname=name;
				all_answered=1;
				return false;		  
		  }	  	
    }); 
	if(all_answered==2)
	{		
		document.forms['AssessmentForm'].submit();	
		$.fancybox.close();
	}else{
		$('#resp_form_submit').show();
		$('#flashMsg').show();
		 
		setTimeout(function(){ 
			$('#wait_titleMsg').html('Message');
			$('#waitMsg').html('Oops! you did not answered all questions.');
			scrollToAnchor(tempname);
		},1000);
	}	
	return false;
}


function direct_assessment_submit(role,course)
{
	open_lightbox('/login/please_wait_message/1',300);
	var all_answered=1;
	var tempname=null;
	$('input:radio').each(function() {
		
		  var name = $(this).attr("name");		
		  if($("input[name='"+name+"']").is(":checked"))
		  {
			  all_answered=2; 		
		  }else{ 
				tempname=name;
				all_answered=1;
				return false;		  
		  }	  	
    });
 
	if(all_answered==2)
	{	
		var frm=$('#AssessmentForm').serialize();
		open_lightbox('/login/direct_participant_register/'+role+'/'+course,985);
		
	}else{
		$('#resp_form_submit').show();
		$('#flashMsg').show();
		 
		setTimeout(function(){ 
			$('#wait_titleMsg').html('Message');
			$('#waitMsg').html('Oops! you did not answered all questions.');
			scrollToAnchor(tempname);
		},1000);
	}	
	return false;	
}

function scrollToAnchor(aid){
    var aTag = $("input[name='"+ aid +"']");
    $('html,body').animate({scrollTop: aTag.offset().top-100},'slow');
}

function remove_participant(pr_id,cr_id,tr_id)
{
	y=confirm("Are you sure you want to remove this participant?");
	if(y){
		$.post(site_url+'/course/remove_participant/'+pr_id+'/'+cr_id,function(data){
			$('.fancybox-inner').html(data);
		});	
	}
}