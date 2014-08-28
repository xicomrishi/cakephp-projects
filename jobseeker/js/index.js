$(document).ready(function(){

	var hc = new hoverCard($('#btn_login'), $('#wnd_login'), 'top');
	hc.init();
	var hc2 = new hoverCard($('#btn_feedback'), $('#wnd_feedback'), 'right'); 
	hc2.init();
}); 

function show_wnd_login(){
	$('#wnd_login').show();
}

function setTopBar(_class,_value){
	th = $('#top_bottom_line');
	th.removeClass('yellow_bar');
	th.removeClass('red_bar');
	th.removeClass('green_bar');
	$('#ProfessionalProfileStatus').val(_value);
	th.addClass(_class);
}

$(document).ready(function(){
	$('.recruiters_img').hide();
$("#_recruiter1").click(function(){
	
 	$(".slider_green").addClass('blue');
	$(".learn").css("color","#039BDD");
	$('.recruiters_img').show();
	$('.professionals_img').hide();
	$(".professionals").fadeTo(1000,0.6);
	$(".recruiters").fadeTo(1000,1);
	$('#slideLeftArrow, #slideRightArrow').addClass('rectt');
	$('#slideLeftArrow, #slideRightArrow').removeClass('proff');
	
	
});
$("#_professional1").click(function(){
	
 	$(".slider_green").removeClass('blue');
	$(".learn").css("color","#5C7711");
	$('.recruiters_img').hide();
	$('.professionals_img').show();
	$(".recruiters").fadeTo(1000,0.45);
	$(".professionals").fadeTo(1000,1);
	$('#slideLeftArrow, #slideRightArrow').addClass('proff');
	$('#slideLeftArrow, #slideRightArrow').removeClass('rectt');
});
 $('.tab_description ul.tabs li').click(function(){
	
   var indx = $(this).index();
   $('.tab_description ul.tabs li').removeClass('active');
    $('.tab_description ul.tabs li').eq(indx).addClass('active');
    $('.tab_description .tab_detail').hide();
    $('.tab_description .tab_detail').eq(indx).show();
  });
  
 $('.right_tab ul.main_tabs li').click(function(){
	
   var indx = $(this).index();
   $('.right_tab ul.main_tabs li').removeClass('active');
    $('.right_tab ul.main_tabs li').eq(indx).addClass('active');
    $('.right_tab .inner_tabing').hide();
    $('.right_tab .inner_tabing').eq(indx).show();
  });
  
   $('.select_tab>ul>li').click(function(e){
	var clickedOn = $(e.target);
    
   var indx = $(this).index();
   if (clickedOn.parents().andSelf().is('.drop_down'))
   {}else{
   $('.select_tab>ul>li').removeClass('active');
    $('.select_tab>ul>li').eq(indx).addClass('active');
    $('.select_tab .recui_tab_detail').hide();
    $('.select_tab .recui_tab_detail').eq(indx).show();
   }
  });

$('ul.drop_down1').hover(function(){

  $(this).prev().addClass('active');
  },function(){
  $(this).prev().removeClass('active');
  });
	
}); 
 function country_profile(){
	 var indx=$('#country').val();
	 $('.country').hide();
	 $('.country').eq(indx).show();
	}
	
function open_lightbox(page)
{
	$.fancybox.open(
			{
				scrolling : 'no',
				'autoSize'     :   false,
				//'width'             : width,
				'type'				: 'ajax',
				//'height'            : height,
				'href'          	: page,
			}
		);		
}

function employee_country_profile(obj){
	 var indx=$('#country2').val();
	 var parId = $(obj).parent().parent().parent().attr('id');
	
	 if(indx==0){
		 $('#'+parId+' .test').hide();
		 }else{
		$('#'+parId+' .pad').show();	 
		}
	if(indx==5){
		 $('#'+parId+' .test').hide();
		 }
	 
	 $('#'+parId+' .employ_status').hide();
	 $('#'+parId+' .common'+indx).show();
	}
	
function employee_country_profile3(obj){
	 var parId = $(obj).parent().parent().parent().attr('id');
	 alert
	 var indx=$('#country3').val();
	 $('#'+parId+' .expert_salary').hide();
	 $('#'+parId+' .common'+indx).show();
	 $('#'+parId+' .apply').hide();
	 $('#'+parId+' .common'+indx).show();
	}
	
function signupShow(obj){
	$('.sign_up_link').show();
	$(obj).parent().hide();
	$('.signup_group').hide();
	$('.proceed_btn').hide();
	$(obj).parent().parent().prev().show();
	return false;
}

	