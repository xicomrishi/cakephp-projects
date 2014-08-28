var site_url='http://'+window.location.host+'/gyftr';
var variab='/gyftr';

function redirect_after_login()
{
	$.post(site_url+'/home/get_status_page',function(data){		
		var response=data;
		if(response=="gpuser")
		{
			gpuser_redirect();	
		}
		if(parseInt(response)==9)
		{	
			check_profile_details();					
		}else{			
			showLoading('#banner');
			$('#banner').html(data);
		}
		$('.login_sec').hide();
		update_user_pic();
		$('.logout_sec').show();
	});
}

function get_bottom_page(page)
{
	$('.bt_section').html('');
	$.post(site_url+'/info/get_bottom_page',{page:page},function(data){
		$('.bt_section').html(data);			
		$('html, body').animate({scrollTop: '700px'}, 600);		
	});
}

function check_profile_details()
{
	$.post(site_url+'/home/check_profile_details',function(data){
			if(data=='1')
			{
				display_profile();
			}else{
				$('#banner').html(data);	
				removeClass('.logo','large');
				removeClass('#banner_container','none');
				$('.login_sec').show();
				$('.logout_sec').hide();
			}
		});	
}  
  
$(function(){
	var width = $(window).width()+17;
	$('.social_bar').click(function(){
		$('#social_icon').toggle();
		});
		
	setTimeout(function(){
		$(".allbrand_ontainer").jCarouselLite({
		   btnNext: ".left_arrow",
		   btnPrev: ".right_arrow",
		   auto: 2000,
           speed: 1000,
		   visible: 5
	  });
  
 	$('.brand_container').cycle({
		fx:'scrollLeft',
		timeout:0,
		speed:2000,
		pager: '.paging_bottom_home',
		activePagerClass: 'active',
			pagerAnchorBuilder: function(idx, slide) { 
		return '<li><a href="javascript://"></a></li>';
		// return '.paging_bottom_home li:eq(' + (idx) + ')';		
 		}
	});
	},700);
  
	$('#bottom_container h3').click(function(){
		$('.detail_box').hide();
		$('#bottom_container h3').show();
		$(this).hide();
		$(this).next().show();
	});
	if(width<=480){
		$('.common_box').hide();
		boxSelect();
	}else{
		$('.common_box').show();
	}
		
});

function removeClass(from,name)
{
	$(from).removeClass(name);	
}

function addClass(to,name)
{
	$(to).addClass(name);	
}

function show_hidden_cats()
{
	$('.hidden_cats').show();
	$('.more_cats').hide();	
}

function nextStep(step,session_step){
	
	removeClass('.logo','large');
	removeClass('#banner_container','none');
	showLoading('#banner');
	if(step=='step-2'||step=='display_login'||step=='register')
	{	get_default_bottom();
	}
	$.post(site_url+'/home/get_page/'+step,{session_step:session_step},function(data){
		
		//$('#banner').hide("slide", { direction: "left" },1000);			
			//setTimeout(function(){$('#banner').html(data)},1200 );
			$('#banner').html(data);
			//$('#banner').show("slide", { direction: "right" },1000);
			$('#top_row').hide();
			$('#banner_container').removeAttr('class');
 			$('#banner_container').addClass(step);
			$('#body_container').addClass('inner');	
						
	});
	return false;
}

function get_default_bottom()
{
	$.post(site_url+'/info/get_default_bottom',function(data){
			$('.bt_section').html(data);
		});	
}



function remove_item(num,pr_id)
{
	showLoading('#banner');
	$.post(site_url+'/home/remove_item/'+num+'/'+pr_id,function(data){
		$('#banner').html(data);
	});	
}

function productStep(product_id,br_name,cat_name){
	showCustomLoading('.gift_section','100px','80px');
	$.post(site_url+'/home/get_brand_products/'+product_id,{br_name:br_name,cat_name:cat_name},function(data){	
		//$('.gift_type').hide("slide", { direction: "left" },1000);	
		//$('.gift_range').hide("slide", { direction: "right" },1000);			
		$('.gift_section').html(data);
		//$('.gift_section').show("slide", { direction: "right" },1000);		
	});		
}

function showCustomLoading(divid,height,mtop)
{
	$(divid).html('<div style="height:'+height+'; margin-top:'+mtop+';text-align:center;"><img src="'+site_url+'/img/ajax-loader.gif" alt="Loading..."/></div>');	
}

function voucherStep(func){
	showLoading('#banner');
	$.post(site_url+'/home/'+func,function(data){	
		//$('#banner').hide("slide", { direction: "left" },1000);	
		$('#banner').html(data);		
		//setTimeout(function(){$('#banner').html(data)},1200 );
		//$('#banner').show("slide", { direction: "right" },1000);		
	});		
}



$(window).resize(function(){
	var width_r = $(window).width()+17;	
	if(width_r<=767){
		$('#social_icon').hide();
	}else{
		$('#social_icon').show();
	}
	if(width_r<=480){
		$('#bottom_container h3').show();
		$('.detail_box').hide();
		$('.common_box').hide();
		boxSelect();
	}else{
		$('#bottom_container h3').hide();
		$('.detail_box').show();
		$('.common_box').show();
	}
});
function boxSelect(){
  $('.select_box').click(function(){
  $('.drop_down').show(); 
  return false;
   });
  $('.select_box ul.drop_down li').click(function(){
  var indx = $(this).index();
  $('.common_box').hide();
  $('.drop_down').hide();
  $('.common_box').eq(indx).show();
  return false;  
 });
  
  }

function incomplete_check(val)
{
	if(val=='1')
	{
		$('#delivery_no').removeClass('active');
		$('#delivery_yes').addClass('active');
		$('#incomp_deliver').val('1');
		submit_deliveryForm();
	}else{
			$('#delivery_yes').removeClass('active');
			$('#delivery_no').addClass('active');
			$('#incomp_deliver').val('0');
			submit_deliveryForm();
		}
	
} 

function submit_deliveryForm()
{
	var valid = $("#deliveryForm").validationEngine('validate');
	if(valid)
	{
		var frm=$('#deliveryForm').serialize();
		showLoading('#banner');
		$.post(site_url+'/home/delivery_details',frm,function(data){	
			//$('#banner').hide("slide", { direction: "left" },1000);	
			$('#banner').html(data);		
			//setTimeout(function(){$('#banner').html(data)},1200 );
			//$('#banner').show("slide", { direction: "right" },1000);		
		});
		
		
	}else{
		$("#deliveryForm").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
	}
	return false;
		
} 

function paging_gift_cat(max_id,typ)
{
	
	showCustomLoading('.gift_section','100px','80px');
	$.post(site_url+'/home/paging_gift_cat',{max_id:max_id,typ:typ},function(data){	
		//$('.gift_section').hide("slide", { direction: "left" },1000);			
		$('.gift_section').html(data);
		//$('.gift_section').show("slide", { direction: "right" },1000);		
	});	
}

function show_brands(id,name)
{
	showLoading('#banner');
	if(name=='0')
	{
		var temp=id.split('_');	
		var id=temp[0];
		var name=temp[1];
	}
	$.post(site_url+'/home/get_cat_brands/'+id+'/'+name,function(data){	
		//$('.gift_range').hide("slide", { direction: "left" },1000);		
		$('#banner').html(data);
		//$('.gift_range').show("slide", { direction: "right" },1000);		
	});	
}

function select_product(id,price)
{
	if(id==0)
	{
		//$.fancybox.close();
			showLoading('#banner');
			$.post(site_url+'/home/add_product_to_basket/'+id,function(data){	
				//$('.gift_range').hide("slide", { direction: "left" },1000);		
				$('#banner').html(data);
				//$('.gift_range').show("slide", { direction: "right" },1000);	
				//get_basket(data);	
			});	
	}else{
		if($('#check_terms').is(':checked'))
		{			
			//$.fancybox.close();
			showLoading('#banner');
			$.post(site_url+'/home/add_product_to_basket/'+id+'/'+price,function(data){						
				$('#banner').html(data);	
				//get_basket(data);	
			});
		}else{
		 
			$('#infoMsg').show("slide",{direction: "down"},100);	
			setTimeout(function(){ $('#infoMsg').hide("slide",{direction: "down"},100);},4000);
		}
	}
}


function loginStep()
{
	$.post(site_url+'/users/login_user',$('#loginForm').serialize(),function(data){	
		$('#loginForm').hide();
		$('.formLoading').show();
		if(data=='password_error')
		{
			$('#flash_msg').html('Authentication failed! Password does not match.');
			$('#flash_msg').show();	
			$('#loginForm').show();
			$('.formLoading').hide();
		}else if(data=='error')
		{
			$('#flash_msg').html('Authentication failed!');
			$('#flash_msg').show();
			$('#loginForm').show();
			$('.formLoading').hide();
		}else if(data=='inactive')
		{
			$('#flash_msg').html('Your account is de-activated by administrator!');
			$('#flash_msg').show();
			$('#loginForm').show();
			$('.formLoading').hide();
		}else{			
			showLoading('#banner');
			redirect_after_login();
		}
	});	
}



function gpuser_redirect()
{
	$.post(site_url+'/home/get_gpuser_page',function(data){	
		$('#banner').html(data);		
		//setTimeout(function(){$('#banner').html(data)},1200 );	
	});		
}

function update_user_pic()
{
	$.post(site_url+'/home/user_pic',function(data){	
		$('.logout_sec').html(data);
	
	});
}

function get_dashboard()
{
	showLoading('#banner');
	$.post(site_url+'/dashboard/index',function(data){			
		$('#banner').html(data);			
	});	
}

function logout()
{
	$.post(site_url+'/users/logout',function(data){	
		window.location.href=site_url;	
	});		
}

function showLoading(divid)
{
	$(divid).html('<div style="height:350px; margin-top:170px;text-align:center;"><img src="'+site_url+'/img/ajax-loader.gif" alt="Loading..."/></div>')	
}

function get_friend_name(type)
{
	var name=$('#friend_name').val();
	var email=$('#friend_email').val();
	var phone=$('#friend_phone').val();
	$.post(site_url+'/home/set_session/',{dat:'friend_name',value:name,type:2,email:email,phone:phone},function(data){	
		nextStep('step-3',type);
	});
}

function display_profile()
{
	removeClass('.logo','large');
	removeClass('#banner_container','none');
	showLoading('#banner');
	$.post(site_url+'/users/get_profile',function(data){	
		$('#banner').html(data);
		update_user_pic();
		$('.login_sec').hide();
		$('.logout_sec').show();
		$("html, body").animate({ scrollTop: 0 }, 600);
	});
}

function get_edit_profile()
{
$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '500',
				'href'          	: site_url+'/users/get_edit_profile',
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		); 	
}

function add_chipin()
{
	var valid = $("#chipinForm").validationEngine('validate');
	if(valid)
	{
		var fr_fb_id=fb_name=null;
		var fr_name=$('#cf_name').val();
		var fr_email=$('#cf_email').val();
		$.post(site_url+'/home/add_chip_in',{fr_fb_id:fr_fb_id,fb_name:fb_name,fr_name:fr_name,fr_email:fr_email },function(data){	
			
			if(data=='success')
			{
				$('#flashmsg').hide();
				update_chipin_friend(fr_fb_id,fb_name,fr_name,fr_email);	
			}else{	
				$('#flashmsg').show();
			}
		});
	}else{
		$("#chipinForm").validationEngine({scroll:false,focusFirstField : false});	
		shakeField();
	}
	return false;
} 

function update_chipin_friend(fr_fb_id,fb_name,fr_name,fr_email)
{
	$.post(site_url+'/home/update_chipin_friends/',{fr_fb_id:fr_fb_id,fb_name:fb_name,fr_name:fr_name,fr_email:fr_email},function(data){	
			$('.friend_list').prepend(data);
	});	
}

function check_voucher_status()
{
	var valid = $("#voucherstatusForm").validationEngine('validate');
	if(valid)
	{
		var frm=$('#voucherstatusForm').serialize();
		showLoading('#banner');
		get_default_bottom();
		$.post(site_url+'/products/voucher_status',frm,function(data){	
			$('#banner').html(data);
			$("html, body").animate({ scrollTop: 0 }, 600);
			removeClass('.logo','large');
			removeClass('#banner_container','none');	
	});	
	}else{
		$("#voucherstatusForm").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
	}
	return false;	
	
}

function saveProfileForm()
{
	var valid = $("#profileForm").validationEngine('validate');
	if(valid)
	{
		var frm=$('#profileForm').serialize();
		showLoading('#banner');
		$.post(site_url+'/users/saveProfile',frm,function(data){	
			display_profile();
			$.fancybox.close();
	});	
	}else{
		$("#profileForm").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
	}
	return false;		
}

function edit_status_page(id)
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '350',
				'href'          	: site_url+'/home/edit_status_page/'+id,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);
}

function edit_giftsummary_page()
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '400',
				'href'          	: site_url+'/home/edit_giftsummary_page',
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);	
}

function update_status_page()
{
	var valid = $("#editStatusPage").validationEngine('validate');
	if(valid)
	{	var frm=$('#editStatusPage').serialize();
		//showLoading('#banner');
		$.post(site_url+'/home/update_status_page',frm,function(data){	
			var resp=unescape(data);
			var res=resp.split('|');
			$('#s_to_name').html(res[0]);
			//$('#s_delivery_time').html(res[1]);
			$('#s_to_email').html(res[1]);
			$('#s_to_phone').html(res[2]);
			$('#error_msg').hide();
			$.fancybox.close();
	});	
	}else{
		$("#editStatusPage").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
	}
	return false;	
}

function update_giftsummary_page()
{
	var valid = $("#editStatusPage").validationEngine('validate');
	if(valid)
	{	var frm=$('#editStatusPage').serialize();
		$.post(site_url+'/home/update_giftsummary_page',frm,function(data){	
			var resp=unescape(data);
			var res=resp.split('|');
			$('#s_to_name').html(res[0]);			
			$('#s_to_email').html(res[1]);
			$('#s_to_phone').html(res[2]);
			$('#error_msg').hide();
			$.fancybox.close();
	});	
	}else{
		$("#editStatusPage").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
	}
	return false;	
}

function connect_fb(step,status_step) {

	FB.login(function(response) {
		$.fancybox.open(
			{
				'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : 450,
				'type'				: 'ajax',
				'height'            : 550,
				'href'          	: site_url+'/home/get_friends/'+step+'/'+status_step,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		); 
	  
	}, {scope:'email,read_mailbox,publish_stream,user_location,offline_access'});		

}

function add_chipin_popup(step)
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '400',
				'href'          	: site_url+'/home/add_chipin_popup/'+step,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);	
}

function update_frnd_list()
{
	$.post(site_url+'/home/update_friend_list',function(data){
		$('.friend_list').html(data);	
	});
}

function get_decide_contri()
{
	$.post(site_url+'/home/get_decide_contri',function(data){
			$('#banner').html(data);	
		});	
	return false;
}

function get_contri_type(type)
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '500',
				'href'          	: site_url+'/home/get_contri_type/'+type,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);	
}

function go_group_gyft()
{
	var valid = $("#editable").validationEngine('validate');
	
	if(valid)
	{
		$('#go_group_gift_button').removeAttr('onclick');
		setTimeout(function(){ $('#go_group_gift_button').attr('onclick','go_group_gyft();')},1500);
		//showLoading('#banner');
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '960',
				'type'				: 'ajax',
				'height'            : '700',
				'href'          	: site_url+'/home/go_group_gyft/',
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);
	}else{
		$("#editable").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
		//return false;
	}	
}

function edit_summary_frnd(num,name)
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '400',
				'href'          	: site_url+'/home/edit_summary_page/'+name+'/'+num,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);	
}


function sendRequestToRecipients(uid,fb_user,ord_id) {

 if(fb_user!='')
 {	
  FB.ui({method: 'apprequests',
    message: 'You are invited to Group Gifting on mygyftr',
	data:uid,
    to: fb_user,
	title:'mygyftr',
	
  },function (response) {
	   if (response.request && response.to) {
               
                    var request_ids = response.request;
					$.post(site_url+'/home/update_group_gift/'+uid,{reqid:request_ids,fb_user:fb_user},function(data){
						//alert(1);
						redirect_to_summary(ord_id);
						$.fancybox.close();
					});
               		
            } else {
                alert('cancelled');
            }
	  
	  });
 }else{
		redirect_to_summary(ord_id);
	}
  return;
}

function redirect_to_summary(ord_id)
{
	$.post(site_url+'/home/get_final_summary/'+ord_id,function(data){
			$('#banner').html(data);
		});	
}

function view_order_details(ord_id)
{
	$.post(site_url+'/home/view_order_details/'+ord_id,function(data){
		$('#banner').html(data);	
		$("html, body").animate({ scrollTop: 0 }, 600);
	});	
}

function edit_groupgift_user(gpuser_id)
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '440',
				'href'          	: site_url+'/home/edit_groupgift_user/'+gpuser_id,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);	
}

function show_setup_success_msg(ord_id)
{
	setTimeout(function(){$.fancybox.open(
			{
				//'autoDimensions'    : true,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '300',
				'href'          	: site_url+'/home/setup_success_msg/'+ord_id,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		)	 },1000);
	
	setTimeout(function(){ $.fancybox.close()},7000);		
}

function add_propose_popup(ord_id)
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '700',
				'type'				: 'ajax',
				'height'            : '400',
				'href'          	: site_url+'/home/add_propose_popup/'+ord_id,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);		
}

function goToStep(name)
{
	$('#infoMsg').html('<img src="'+variab+'/img/validate_left_img.png" alt="" /><div class="text">Please select a '+name+'.</div><img src="'+variab+'/img/validate_right_img.png" alt="" />');
	$('#infoMsg').show("slide",{direction: "down"},100);
	setTimeout(function(){ $('#infoMsg').hide("slide",{direction: "down"},100);},3000);
}

function confirm_prop_user(prop_id)
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '500',
				'href'          	: site_url+'/home/confirm_prop_user/'+prop_id,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);	
}

function shakeField()
{
		$('input').css('border','');
		$('input').css('box-shadow','');
		var field=Array(); var i=0;
		$('.formError').each(function(index, element) {
            field[i]=$(this).next().attr('id');
			$('#'+field[i]).css('border','1px solid #FF0000');
			$('#'+field[i]).css('box-shadow','0 0 8px #FF0000');
			$('#'+field[i]).effect( "bounce", "fast" );
			i++;
        });
		
}

function decline_prop_user(prop_id,ordid)
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '500',
				'href'          	: site_url+'/home/decline_prop_user/'+prop_id,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);	
	redirect_to_summary(ordid);	
}

function make_payment(ordid,userid,typ)
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '500',
				'href'          	: site_url+'/payment/make_payment/'+ordid+'/'+userid+'/'+typ,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);	
}



function send_reminder_to_gpuser(gpuser)
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '400',
				'href'          	: site_url+'/home/send_reminder/'+gpuser,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);		
}

function display_product_details(pr_id,price)
{
	showLoading('#banner');
	$.post(site_url+'/home/display_product_details/'+pr_id+'/'+price,function(data){
			$('#banner').html(data);
		});
		
}

function password_change_popup()
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '500',
				'href'          	: site_url+'/users/password_change_popup',
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);	
}



function check_valid_contri(typ,tot_allowed)
{
	var flg=1;
	if(typ!=1)
	{
		var maxtot=0;
		$('.contri').each(function(index, element) {
            maxtot+=parseInt($(this).val());
        });	
		if(maxtot>tot_allowed)
			flg=0;
	}
	return flg;
}

function check_validation()
{
	var form_id=$('form').attr('id');
	var valid = $("#"+form_id).validationEngine('validate');
	
	if(!valid)
	{		
		$("#"+form_id).validationEngine({scroll:false,focusFirstField : false});
		shakeField();
		
	}else{
		if(form_id=='editable')
		{
			save_editable_field_form();	
		}
	}	
}

function save_editable_field_form()
{
		var email=$('#s_to_email_submit').val();
		var phone=$('#s_to_phone_submit').val();
		if(email||phone)
		{		
			var ord=$('#order_id').val();
			if(ord!='undefined'&&ord!=''&&ord!=null)
			{
				$.post(site_url+'/home/update_recipient_details/'+ord+'/'+email+'/'+phone,function(data){
					$('#s_to_email').html(email);
					$('#s_to_phone').html(phone);
					$('#incomp_msg').hide();
				});
			}else{
				$.post(site_url+'/home/update_giftsummary_page/'+email+'/'+phone,function(data){								
				$('#s_to_email').html(email);
				$('#s_to_phone').html(phone);
				$('#incomp_msg').hide();				
			});					
			}
		}	
		if($('#user_phone_submit').length>0)
		{
			get_user_id();			
		}
		
	return;
}

function get_user_id()
{
	$.post(site_url+'/users/get_user_id',function(data){
		var val=$('#user_phone_submit').val();
			check_user_phone(val,data);
		});	
	
}
 

  ///////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////Chip in Page Js///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
function handleChipClientLoad() {
		
		 var google_click=$('#google_click').val();
		 if(google_click==1)
		 {
			 $('#fb_frnds_done').val(3);
			  $('.fb_disp').hide();
		 }
        gapi.client.setApiKey(apiKey);
        window.setTimeout(checkChipAuth,1);
      }

      function checkChipAuth() {
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleChipAuthResult);
	   }






 function handleChipAuthResult(authResult) { 

       var authorizeButton = document.getElementsByClassName('get_google');
        if (authResult && !authResult.error) {
          //authorizeButton.style.visibility = 'hidden';
		  var authParams=gapi.auth.getToken();			
			authParams.alt = 'json';
			makeChipAPIcall(authParams);			
        } else {
       
		initiate_onclick('.get_google',1);
         // authorizeButton.onclick = handleChipAuthClick;
        }
      }
	  
function makeChipAPIcall(authParams)
{
		
		var authorizeButton = document.getElementsByClassName('get_google');
		$.ajax({
				  url: 'https://www.google.com/m8/feeds/contacts/default/full',
				  dataType: 'jsonp',
				  data: authParams,
				  success: function(data) {  
				  $.post(site_url+'/home/get_google_friends/1',{resp:data},function(fr){
					 
					fr_data=JSON.parse(fr);					
					autocomplete_func(fr_data,this_num,'2');
					$('.instruction_box').html('<h3 style="font-size:11px !important; line-height:13px !important;">Start typing gmail friend\'s name</h3><a onclick="get_fb_friends('+this_num+');" href="javascript://" class="small"><img src="'+variab+'/img/facebook_login.png"></a>');
					$('#fb_frnds_done').val('3');					
					});
				  
				  }
				});
}

function handleManualChipAuthResult(authRes)
{
	var authorizeButton = document.getElementsByClassName('get_google');
        if (authRes && !authRes.error) {        
			checkChipAuth();
			$('#google_click').val(1);			
	  	 } else {
		  initiate_onclick('.get_google',1);
        }	
}	  


      function handleChipAuthClick(event) {
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleManualChipAuthResult);
        return false;
      }  
	  
	  function initiate_onclick(forname,flag)
		{
			   $(forname).click(function(e) {
				$('#google_click').val(1);
				 var rep=$(this).attr('id').split('_');
				 this_num=rep[1];
				 if(flag==1)
				 {
				   $('.instruction_box').html('<h3 style="font-size:11px !important; line-height:13px !important;">Accessing gmail friends, Please wait...</h3>');	 
				  handleChipAuthClick();
				 }
				
				});		
		}  

function get_fb_friends(num)
{
	var already_fb=$('#fb_frnds_done').val();
$('.fb_disp').hide();
	
		FB.login(function(response) {
			
			 $('.instruction_box').html('<h3 style="font-size:11px !important; line-height:13px !important;">Accessing friends, Please wait...</h3>');
			$.post(site_url+'/home/get_friends/2/1',{num:num},function(data){
				fr_data=JSON.parse(data);
				autocomplete_func(fr_data,num,'1');
				$('.instruction_box').html('<h3 style="font-size:11px !important; line-height:13px !important;">Start typing facebook friend\'s name</h3><a href="javascript://" id="g_'+num+'" class="get_google small"><img src="'+variab+'/img/gmail_login.png"/></a>');
				$('#fb_frnds_done').val('1');
				
			});							
		}, {scope:'email,read_mailbox,publish_stream,user_location,offline_access'});	
	
	$(".nano").nanoScroller({alwaysVisible:true, contentClass:'multi_frnds',sliderMaxHeight: 70 });
	 $(".scroll").nanoScroller({alwaysVisible:true, contentClass:'fb_disp',sliderMaxHeight: 70 });
}

function autocomplete_func(data,num,tip)
{	
		 var projects =  data;
		 if(tip==1)
		 {
				 $(".frnd_name").autocomplete({
					minLength: 0,
					source: projects,
					focus: function( event, ui ) {
						
					$("#frnd_name_"+num).val( ui.item.label );
					return false;
					},
					select: function( event, ui ) {
						
						append_frnd(ui.item.label,ui.item.value,num,tip);
					return false;
					}
					}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li>" )
					.data( "item.autocomplete", item )
					.append( "<a><img src=\"http://graph.facebook.com/"+item.value+"/picture\" />" + item.label + "</a>" )
					.appendTo( ul );
				};	
		 }else{
			 $(".frnd_name").autocomplete({
					minLength: 0,
					source: projects,
					focus: function( event, ui ) {
						
					$("#frnd_name_"+num).val( ui.item.label );
					return false;
					},
					select: function( event, ui ) {
						
						append_frnd(ui.item.label,ui.item.value,num,tip);
					return false;
					}
					}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li>" )
					.data( "item.autocomplete", item )
					.append( "<a><img src=\""+variab+"/img/facebook_profile_pic.jpg\" />" + item.label + "</a>" )
					.appendTo( ul );
				}; 
			 
		}
}

function append_frnd(name,id,num,tip)
{

 var count=$('#count_fnd').val();
 
 $('#frnd_name_'+num).val(name);
 if(tip==1)
 {
	 $('.inp_frnds').append('<input type="hidden" id="input_frnds_inp_'+num+'" name="frnd['+num+'][fid]" value="'+name+'_'+id+'"/>');
 $('#frnd_email_div_'+num).html('<img src="'+variab+'/img/button_fb-ba350fcd03ce7c663a47ee06d981162e.png" alt="facebook"><span>VIA Facebook Private Message</span>');
 }else if(tip==2)
 {
	 
	 $('#frnd_email_'+num).val(id); 
 }
 $('.fb_disp').hide();

}

function add_more_frnd()
{
	var count=$('#count_fnd').val();
	var added_count=parseInt(count)+1;
	if(added_count>2)
	{
		addClass('.multi_frnds','height');	
	}
	//$('.add').hide();
	var lastDiv = $('.multi_frnds').find("div.added_div:first");
	lastDiv=lastDiv.attr('id');
	
	if(count!=0)
	{
		var resp=lastDiv.split('_');
		count=resp[2];	
		
	}

	count=parseInt(count)+1;
	

	$('#count_fnd').val(count);	
	$('.multi_frnds').prepend('<div style="float:left; width:100%; padding:0 0 8px 0" id="added_div_'+count+'" class="added_div"><div class="user_pic"><img src="'+variab+'/img/facebook_profile_pic.jpg" alt="pic"/></div><div class="user_name"><input type="text" id="frnd_name_'+count+'" class="frnd_name validate[required]" name="frnd['+count+'][name]" placeholder="Enter Name" onfocus="show_fb_connect('+count+');" /><div class="instruction_box" id="inst_'+count+'" style="display:none; position:absolute; padding:0 3%;"><h3 style="font-size:11px !important; line-height:14px !important; padding:0px !important;">Enter your friend\'s name manually</h3><div class="separator"><span class="overlay"> or </span><hr></div><a class="small" href="javascript://" onclick="get_fb_friends('+count+');"><img src="'+variab+'/img/facebook_login.png"/></a><a href="javascript://" id="g_'+count+'" class="get_google small"><img src="'+variab+'/img/gmail_login.png"/></a></div><div class="scroll" style="width:100%"><div id="fbdisplay_'+count+'" class="fb_disp" style="display:none; height:87px; width:184px; left:0px; overflow:auto; background:#f4f4f4; position:absolute; padding:0 17px 0 0; z-index:9999;"></div></div></div><div class="user_mail" id="frnd_email_div_'+count+'"><input type="text" id="frnd_email_'+count+'" name="frnd['+count+'][email]" class="validate[required,custom[email]]" placeholder="Enter Email" onclick="hide_fb_connect();"/></div><div class="close"><a href="javascript://" onclick="remove_more_frnd('+count+');"><img src="'+variab+'/img/close.png" alt="close"/></a></div></div>');
	 $(".nano").nanoScroller({alwaysVisible:true, contentClass:'multi_frnds',sliderMaxHeight: 70 });
	  $(".scroll").nanoScroller({alwaysVisible:true, contentClass:'fb_disp',sliderMaxHeight: 70 });
	  for(var m=0;m<=(count-1);m++)
	  {		
		var fb_disp=$('#fbdisplay_'+m).html();
		
		fb_disp=String.trim(fb_disp);
		if(fb_disp!='')
		{
			$('.fb_disp').html(fb_disp);
			break;	
		}	  
	  }
	 var fb_al=$('#fb_frnds_done').val();
	setTimeout(function(){ $(".nano").nanoScroller({alwaysVisible:true, contentClass:'multi_frnds',sliderMaxHeight: 70 });},1000);
	setTimeout(function(){$(".scroll").nanoScroller({alwaysVisible:true, contentClass:'fb_disp',sliderMaxHeight: 70 });},1000);
	input_blur_function();
	initiate_onclick('.get_google',1);
}

function hide_fb_connect()
{
	$('.instruction_box').hide();	
}


function remove_more_frnd(num)
{
	$('#added_div_'+num).remove();
	$('#input_frnds_inp_'+num).remove();
	num-=1;
	
	var count=$('#count_fnd').val();
	count-=1;
	if(count<3)
	{
		removeClass('.multi_frnds','height');	
	}
	$('#count_fnd').val(count);

  $(".nano").nanoScroller({alwaysVisible:true, contentClass:'multi_frnds',sliderMaxHeight: 70 });
  $(".scroll").nanoScroller({alwaysVisible:true, contentClass:'fb_disp',sliderMaxHeight: 70 });
}



function submit_chipin_form()
{
	var valid = $("#chipinForm").validationEngine('validate');
	if(valid)
	{	var frm=$('#chipinForm').serialize();
		showLoading('#banner');
		$.post(site_url+'/home/save_chipin_frnds',frm,function(data){
			
			get_decide_contri();
			
			});
	}else{
		 $("#chipinForm").validationEngine({scroll:false,focusFirstField : false});
		shakeField();
	}
	return false;
}
	        
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////


function input_blur_function()
{
	$(document).ready(function(e) {           
		 $('input:text').blur(function(e) {
			$(this).css('border','');
			$(this).css('box-shadow','');
		 });
	 }); 	
}


function redeem_points(ord_id,user_id,type)
{
	var valid = $("#editable").validationEngine('validate');
	if(valid)
	{
	
	var rdp=$('#rd_points').val();
	if(rdp&&rdp!=null)
	{
		$('.redeem_pts').removeAttr('onclick');
		
		showLoading('#banner');
		$.post(site_url+'/payment/redeem_points/'+rdp+'/'+ord_id+'/'+user_id+'/'+type,function(data){
				
			payment_successfull_msg(ord_id);
			
		});
	}else{
		$('#rd_points').css('border','1px solid #FF0000');
			$('#rd_points').css('box-shadow','0 0 8px #FF0000');
			$('#rd_points').effect( "bounce", "fast" );
	}
	}else{
		
		if($('#s_to_phone_submit').length>0)
		{
			 $('html, body').animate({
				 scrollTop: $("#s_to_phone_submit").offset().top-100
			 }, 2000);	
		}
		if($('#s_to_email_submit').length>0)
		{
			 $('html, body').animate({
				 scrollTop: $("#s_to_email_submit").offset().top-100
			 }, 2000);	
		}
		$("#editable").validationEngine({scroll:true,focusFirstField : false});
		
		
	}
	
}

function show_payment_proceed(ord_id,user_id)
{
	var valid = $("#editable").validationEngine('validate');
	if(valid)
	{
		var pay_amount=$('#pay_amount').val();
		if(pay_amount)
		{
			$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '350',
				'href'          	: site_url+'/payment/show_payment_proceed/'+ord_id+'/'+user_id+'/'+pay_amount,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);		
		}else{
			$('#pay_amount').css('border','1px solid #FF0000');
			$('#pay_amount').css('box-shadow','0 0 8px #FF0000');
			$('#pay_amount').effect( "bounce", "fast" );	
		}
	}else{
		
		if($('#s_to_phone_submit').length>0)
		{
			 $('html, body').animate({
				 scrollTop: $("#s_to_phone_submit").offset().top-100
			 }, 2000);	
		}
		if($('#s_to_email_submit').length>0)
		{
			 $('html, body').animate({
				 scrollTop: $("#s_to_email_submit").offset().top-100
			 }, 2000);	
		}
		$("#editable").validationEngine({scroll:true,focusFirstField : false});
		
	}
}

function payment_successfull_msg(ord_id)
{
	setTimeout(function(){$.fancybox.open(
			{
				//'autoDimensions'    : true,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '300',
				'href'          	: site_url+'/home/payment_success_msg/'+ord_id,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		)	 },200);
	
	setTimeout(function(){ view_order_details(ord_id)},2800);		
}

function check_user_phone(phone,user_id)
{
	var valid = $("#editable").validationEngine('validate');
	if(valid)
	{
		$.post(site_url+'/users/update_user_phone/'+phone+'/'+user_id,function(data){
					$('#user_phone').html(phone);
					$('#incomp_phone_msg').hide();
				});
	}else{
		$("#editable").validationEngine({scroll:false,focusFirstField : false});
		if($('#s_to_phone_submit').length>0)
		{
			 $('html, body').animate({
				 scrollTop: $("#s_to_phone_submit").offset().top-100
			 }, 2000);	
		}
		
	}
}

function proceed_deliver(ord_id)
{
	$('#payment_success').html('<div style="text-align:center; margin:50px 0 0 0; color:#090;">Sending Gyft...</div>');
	$.post(site_url+'/cron/crontest/'+ord_id,function(data){
			$('#payment_success').html(data);
			if(data==1)
			{	view_order_details(ord_id);
				$('#payment_success').html('<div style="text-align:center; margin:50px 0 0 0; color:#090;">Congratulations! Gyft has been delivered.</div>');
				
				setTimeout(function(){ $.fancybox.close();},3000);
			}
			else{	
				$('#payment_success').html('<div style="text-align:center; margin:50px 0 0 0; color:#ff0000;">Oops! there is some issue. Please contact our support staff.</div>');
			}
		});	
}

function show_content()
{
	$('#inner_container').slideDown(500);
	$('#read_more_btn').hide();	
}

function show_cms_lightbox(cms_page)
{
	$.fancybox.close();
	setTimeout(function(){
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '500',
				'scrolling'			: 'no',
				'href'          	: site_url+'/home/get_cms/'+cms_page,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);},1000);	
}

function gift_not_available()
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '350',
				'scrolling'			: 'no',
				'href'          	: site_url+'/home/gift_not_available/',
				modal:false,
				keys : {
							close  : null
						  },
				closeClick  : false, // prevents closing when clicking INSIDE fancybox
				helpers     : { 
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
			}
		);	
}

function go_to_buy()
{
	window.location.href=site_url+'/home/gift_type';	
}

function show_div(show_divid,hide_divid,li_id)
{
	$('.tabbing ul li').removeClass('active');
	$('#'+li_id).addClass('active');
	$('#'+hide_divid).hide();
	$('#'+show_divid).show();
	 $(".nano").nanoScroller({alwaysVisible:true, contentClass:'detail',sliderMaxHeight: 70 });	
}

function use_promo_code(ord_id,user_id)
{
	var promo_code=$('#promo_code_inp').val();
	promo_code = promo_code.replace(/[^a-zA-Z0-9]/g,'');
	if(promo_code)
	{
		showLoading('#banner');
		$.post(site_url+'/home/use_promo_code',{order_id:ord_id,user_id:user_id,promo_code:promo_code},function(data){
			$('#banner').html(data);	
		});
			
	}else{
		$('#promo_code_inp').css('border','1px solid #FF0000');
		$('#promo_code_inp').css('box-shadow','0 0 8px #FF0000');
		$('#promo_code_inp').effect( "bounce", "fast" );	
	}	
}

function show_promo_discount(msg,tp)
{
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '300',
				'href'          	: site_url+'/home/success_promo_discount/'+msg+'/'+tp,
			}
		);
}

function get_bottom_page_ajax(page)
{
	$.post(site_url+'/info/get_bottom_page_ajax/'+page,function(data){
			$('.bt_section').html(data);
		});	
}

function use_voucher_code(ord_id,user_id)
{
	var voucher_code=$('#voucher_code_inp').val();
	$('.voucher_submit').hide();
	$('.voucher_sub_text').show();
	voucher_code = voucher_code.replace(/[^a-zA-Z0-9]/g,'');
	if(voucher_code)
	{
		//showLoading('#banner');
		$.post(site_url+'/home/use_voucher_code',{order_id:ord_id,user_id:user_id,voucher_code:voucher_code},function(data){
			$('#banner').html(data);
			$('.voucher_submit').show();
			$('.voucher_sub_text').hide();
			$("html, body").animate({ scrollTop: 0 }, 600);	
		});
			
	}else{
		$('#voucher_code_inp').css('border','1px solid #FF0000');
		$('#voucher_code_inp').css('box-shadow','0 0 8px #FF0000');
		$('#voucher_code_inp').effect( "bounce", "fast" );	
		$('.voucher_submit').show();
		$('.voucher_sub_text').hide();
	}	
}
