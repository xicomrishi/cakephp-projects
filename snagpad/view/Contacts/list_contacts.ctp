<section class="tabing_container">
<?php if(isset($network)){ ?>
        <section class="tabing">
          <ul class="gap">
          	<li class="active"><a>Snagged Contact(s)</a></li>
          </ul>
        </section>
        <?php } ?>
<section class="contact_section">
<?php if(!isset($network)) { ?>
<form name="list_contacts_form" id="list_contacts_form" method="post" action="">
        <fieldset>
        <input type="hidden" id="current_page" name="current_page" value=""/>
        <input type="hidden" id="show_per_page" name="show_per_page" value=""/>
        <section class="title_row">
         <span class="column1"><input type="checkbox" id="all_check" onclick="select_all_check();"/><small>TITLE</small></span>
        
        <span class="column2 text_indent">E-MAIL</span>
        <span class="column3">ADDED</span>
        <?php if(!isset($network)){ ?> <!--<span class="column4" style="width:173px;">MODIFIED</span>-->
		<span class="column4">JOBCARDS</span>
		<?php } ?></section>
        <div id="cont">
        <?php if(!empty($contacts)){
			foreach($contacts as $contact) { ?>
        <section class="comon_row" id="contact_row_<?php echo $contact['Contact']['id'];?>">
        <span class="column1 colour1"><input type="checkbox" name="cbox[]" class="contact_check" onclick="objDelChecked(this); uncheck();" value="<?php echo $contact['Contact']['id']; ?>"><small><a href="javascript://" id="contact_<?php echo $contact['Contact']['id'];?>" onclick="show_edit_contact('<?php echo $contact['Contact']['id']; ?>');"><?php echo $contact['Contact']['contact_name']; ?></a></small>
        
        </span>
        <span class="column2 colour2"><a href="mailto:<?php echo $contact['Contact']['email']; ?>"><?php echo $contact['Contact']['email']; ?></a></span>
        <span class="column3 colour3"><?php echo show_formatted_datetime($contact['Contact']['date_added']); ?></span>
        <?php if(!isset($network)){ ?><!--<span class="column4 colour3" style="width:173px;"><?php echo show_formatted_datetime($contact['Contact']['date_modified']); ?></span>-->
        <span class="column4 colour3">
		<a href="javascript://" onclick="view_jobcards('<?php echo $contact['Contact']['id'];?>');">View</a>
        </span>
		<?php } ?>
        </section>
        
        <?php }}else{ ?>
        	<div style="text-align: center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal">No record found</div>
        <?php } ?>
        </span>
        </div>
       
        <span class="delete_btn">
       	<?php if(count($contacts)>0) { ?>
        <a href="javascript://" onclick="deletecontact();">delete</a>
        <?php } ?>
        </span>
        </fieldset>
        </form>
        <?php if(!empty($contacts)){ ?>
        <div id="page_navigation">
        </div>
        <?php } ?>
        <!--<ul>
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        </ul>-->
       <?php }else{ ?>
       <div align="center" id="loading" style="height:100px;padding-top:200px;width:950px;text-align:center;">Coming Soon!</div>
       <?php } ?> 
     </section>   
     </section>
        
<script language="javascript">
    $(document).ready(function(){  
      
        //how much items per page to show  
        var show_per_page = 8;  
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
        //var navigation_html = '<a class="previous_link" href="javascript:previous();">Prev</a>';  
		var navigation_html = '';  
        var current_link = 0;  
        while(number_of_pages > current_link){  
            navigation_html += '<a class="page_link" href="javascript:go_to_page(' + current_link +')" longdesc="' + current_link +'">'+ (current_link + 1) +'</a>';  
            current_link++;  
        }  
       // navigation_html += '<a class="next_link" href="javascript:next();">Next</a>';  
      
        $('#page_navigation').html(navigation_html);  
      
        //add active_page class to the first page link  
        $('#page_navigation .page_link:first').addClass('active_page');  
      
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
        //$('.page_link[longdesc=' + page_num +']').addClass('active_page').siblings('.active_page').removeClass('active_page');  
      
        //update the current page input field  
        $('#current_page').val(page_num);  
    }  
</script>               
        
<script language="javascript">
var iDelTotalChecked=0;
 function objDelChecked(chk)
 {
     if(chk.checked==true)
     iDelTotalChecked=iDelTotalChecked+1
 else
  iDelTotalChecked=iDelTotalChecked-1
}

function deletecontact()
{
	if(ConfirmChoice())
	{
		//document.list_contacts_form.action="<?php echo SITE_URL; ?>/contacts/delete_contact";
		$.post('<?php echo SITE_URL; ?>/contacts/delete_contact',$('#list_contacts_form').serialize(),function(data){
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
		answer = confirm("Are you sure you want to Delete the selected contact(s)?");
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

function show_edit_contact(contact_id)
{
		$.post("<?php echo SITE_URL; ?>/contacts/edit_contact",'contact_id='+contact_id,function(data){	
					$(".top_sec").html(data);
				
		});	
	
}

function select_all_check()
{
	if($('#all_check').attr('checked'))
	{
		$('.contact_check').each(function(index, element) {
         $(this).attr('checked',true);
		objDelChecked(this);
	});
	 
	}else{
	$('.contact_check').each(function(index, element) {
        $(this).attr('checked',false);
		objDelChecked(this);
		
    });
	}
}
function uncheck()
{
	if($('#all_check').attr('checked'))
	{
		$('#all_check').attr('checked',false);
	}	
}

function view_jobcards(con_id)
{
	loadPopup('<?php echo SITE_URL; ?>/contacts/view_jobcards/'+con_id);
}

</script>        