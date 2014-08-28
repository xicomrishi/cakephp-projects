$(document).ready(function(){

	$('#check_all').click(function(event) {   		
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;                        
            });
        }
        if(!this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = false;                        
            });
        }
    });
    
    $.validator.addMethod("check_ckeditor", function(){
		var data = CKEDITOR.instances.textarea1.document.getBody().getText();
		if($.trim(data) != ''){
			return true;
		}
		return false;
	}, "This field is required");
		
    $.validator.addMethod("userName", function(value, element) {
		return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
	}, "Only letters and numbers are allowed.");
	
	$.validator.addMethod("alphaNumeric", function(value, element) {
		return this.optional(element) || /^[a-zA-Z0-9\s]+$/i.test(value);
	}, "Only letters, and numbers are allowed.");
	
	$.validator.addMethod("lettersOnly", function(value, element) {
		return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
	}, "Only letters are allowed.");
});

function loader(parentDiv)
{
	var html = '<div style="text-align:center"><img width="20" height="20" src="../../img/ajax-loader.gif"></img></div>'
	$('.'+parentDiv).html(html);
}

function ajax_error( response ) 
{
	var message = '';
	if(response.status == 403)
	{
		message = 'Might be you are not logged In or you have not access to use this part'; 
	}
	else
	{
		message = response.statusText;
	}
	return message;
}


function verify_fields(arr)
{
	var flag = 0;
	for(var i=0; i<arr.length; i++)
	{
		if ( $('#' + arr[i] ).val() == "" )
		{
			get_alert_message(arr[i]);
			
			flag = 1;
			break;
		}
	}
	
	if(flag == 0)
		return true;
	else 
		return false;	
}

function get_field_values(arr)
{
	var values = Array();
	
	for(var i=0; i<arr.length; i++)
	{
		values[i] = $('#' + arr[i]).val();
	}	
	
	return values;
}

function get_alert_message(name)
{
	var msg = '';
	switch(name)
	{
		case 'company_name':  msg = 'Please enter company name'; break;
		case 'deal_title':  msg = 'Please enter deal title'; break;
		case 'deal_price':  msg = 'Please enter deal value'; break;
		case 'type':  msg = 'Please select deal type'; break;
		case 'product':  msg = 'Please enter product/service'; break;
		case 'deal_description':  msg = 'Please enter deal description'; break;
		case 'AdminDisplayFormType_':  msg = 'Please select display form type'; break;
		case 'main_page_text_1':  msg = 'Please enter main page text - 1'; break;
		case 'main_page_text_2':  msg = 'Please enter main page text - 2'; break;
		case 'color':  msg = 'Please select color'; break;
		case 'bg_color':  msg = 'Please select background color'; break;
		case 'font_color':  msg = 'Please select font color'; break;
		case 'AdminBgTexture':  msg = 'Please select background texture'; break;
	}
	
	alert(msg);
	//return;
}