<?php echo $this->Html->script('cufon');?>
<div id="success_m" style="display:none;">File saved successfully.</div>

<section class="contact_section">
        <form name="listing_form" id="listing_form" method="post" action="">
        <input type="hidden" id="session_check" value="<?php echo $this->Session->read('Client.edit_success');?>"/>
        <input type="hidden" id="current_page" name="current_page" value=""/>
        <input type="hidden" id="show_per_page" name="show_per_page" value=""/>
        
        <fieldset>
        <section class="head_row">
        <span class="col1 none">gcfg</span>
        <span class="col2">FILE</span>
        <span class="col3">shared</span>
        <span class="col4">UPLOAD</span>
        <span class="col5">MODIFIED</span>
        <span class="col6 none">cfhfgc</span>
        </section>
        <div id="cont">
        <?php 
			foreach($files as $file ) { ?>
        
        <section class="comn_row spacer">
        <span class="col1"><input type="checkbox" name="cbox[]" onclick="objDelChecked(this)" value="<?php echo $file['File']['id']; ?>"></span>
        <span class="col2"><a href="javascript://" onclick="show_edit(<?php echo $file['File']['id']; ?>);"><?php echo $file['File']['filename']; ?></a></span>
        <span class="col3"><input type="checkbox" <?php if($file['File']['shared']=='Y') { echo 'checked'; } ?>></span>
        <span class="col4"><?php echo show_formatted_datetime($file['File']['reg_date']); ?></span>
        <span class="col5"><?php echo show_formatted_datetime($file['File']['last_modified']); ?></span>
       <!-- <span class="col6"><a href="<?php echo $path . $file['File']['client_id'];?>\<?php echo $file['File']['file'] ; ?>" target="_blank">download</a></span>-->
         <span class="col6"><a href="<?php echo $this->webroot;?>files/<?php echo $file['File']['client_id'].'/'.$file['File']['file'] ; ?>" target="_blank">download</a></span>
       </section>
       <?php  }
		 ?>
       </div>
      
          
        <span class="delete_btn space">
        <a href="javascript://" onclick="deletefile();">delete</a>
        </span>
        </fieldset>
        </form>
        <div id="page_navigation">
        </div>
        
        <!--<ul class="spacer">
        
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        </ul>-->
       
       </section>
       
<script language="javascript">
    $(document).ready(function(){  
      
        //how much items per page to show  
        var show_per_page = 10;  
        //getting the amount of elements inside content div  
        var number_of_items = $('#cont').children().size();  
		//alert(number_of_items);
        //calculate the number of pages we are going to have  
        var number_of_pages = Math.ceil(number_of_items/show_per_page);  
      
        //set the value of our hidden input fields  
        $('#current_page').val(0);  
        $('#show_per_page').val(show_per_page);  
      
        //now when we got all we need for the navigation let's make it '  
      
        /* 
        what are we going to have in the navigation? 
            - link to previous page 
            - links to specific pages 
            - link to next page 
        */  
       // var navigation_html = '<a class="previous_link" href="javascript:previous();">Prev</a>';  
	   var navigation_html = '';  
        var current_link = 0;  
        while(number_of_pages > current_link){  
            navigation_html += '<a href="javascript:go_to_page(' + current_link +')" longdesc="' + current_link +'">'+ (current_link + 1) +'</a>';  
            current_link++;  
        }  
       // navigation_html += '<a class="next_link" href="javascript:next();">Next</a>';  
     
        $('#page_navigation').html(navigation_html);  
      
        //add active_page class to the first page link  
        $('#page_navigation a:first').addClass('active_page');  
		//$('#page_navigation .page_link:first').addClass('active'); 
      
        //hide all the elements inside content div  
        $('#cont').children().css('display', 'none');  
      
        //and show the first n (show_per_page) elements  
        $('#cont').children().slice(0, show_per_page).css('display', 'block');  
      
    });  
      
    function previous(){  
      
        new_page = parseInt($('#current_page').val()) - 1;  
        //if there is an item before the current active link run the function  
        if($('.active_page').prev('.page_link').length==true){  
            go_to_page(new_page);  
        }  
      
    }  
      
    function next(){  
        new_page = parseInt($('#current_page').val()) + 1;  
        //if there is an item after the current active link run the function  
        if($('.active_page').next('.page_link').length==true){  
            go_to_page(new_page);  
        }  
      
    }  
    function go_to_page(page_num){  
        //get the number of items shown per page  
        var show_per_page = parseInt($('#show_per_page').val());  
      
        //get the element number where to start the slice from  
        start_from = page_num * show_per_page;  
      
        //get the element number where to end the slice  
        end_on = start_from + show_per_page;  
      
        //hide all children elements of content div, get specific items and show them  
        $('#cont').children().css('display', 'none').slice(start_from, end_on).css('display', 'block');  
      
        /*get the page link that has longdesc attribute of the current page and add active_page class to it 
        and remove that class from previously active page link*/  
		$('#page_navigation a').removeClass('active_page');
		$('#page_navigation a[longdesc=' + page_num +']').addClass('active_page');
      //  $('a[longdesc=' + page_num +']').addClass('active_page').siblings('active_page').removeClass('active_page');  
		
        //update the current page input field  
        $('#current_page').val(page_num);  
    }  
</script>           

<script language="javascript">
$(document).ready(function(e) {
	var session_val=$('#session_check').val();
	if(session_val==1)
	{
		$('#success_m').show();	
		<?php //echo $this->Session->write('Client.edit_success',0);?>
	}
	setTimeout($('#success_m').hide(),500000);
    
});
var iDelTotalChecked=0;
 function objDelChecked(chk)
 {
     if(chk.checked==true)
     iDelTotalChecked=iDelTotalChecked+1
 else
  iDelTotalChecked=iDelTotalChecked-1
}
function deletefile()
{
	if(ConfirmChoice())
	{
		//document.listing_form.action="<?php echo SITE_URL; ?>/docs/delete_file";
		$.post('<?php echo SITE_URL; ?>/docs/delete_file',$('#listing_form').serialize(),function(data){
			$(".contact_section").html(data);
			});
	}
}
//*************Function for checking if any one checkbox is selected for deleting
function ConfirmChoice()
{
	if(iDelTotalChecked==0)
	{
		alert("Please select at least one record to delete.");
		return false;
	}
	else
	{
		answer = confirm("Are you sure you want to Delete the selected client(s)?");
		if (answer !=0)
		{
			return true;
		}
		else
		{
		return false;
		}
	}
}

function show_edit(file_id)
{
	
	$.post("<?php echo SITE_URL; ?>/docs/edit_doc",{ fileid: +file_id },function(data){	
					$(".top_sec").html(data);
					$("html, body").animate({ scrollTop: 0 }, 600);				
				
			});		
	
}

</script>       