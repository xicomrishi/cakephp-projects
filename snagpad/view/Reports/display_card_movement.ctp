<section class="contact_section"> 
  <input type="hidden" id="current_page" name="current_page" value=""/>
        <input type="hidden" id="show_per_page" name="show_per_page" value=""/>
        <div class="head_row">
<span class="col1" style="width:300px">Company name</span>
<span class="col1" style="width:300px">Action</span>
<span class="col1" style="width:245px; text-align:center">Date</span>
</div>
<div id="cont">
<?php foreach($data as $dat){ ?>
<div class="comn_row">
<span class="col1" style="width:300px"><?php echo $dat['C']['company_name'];?></span>

<span class="col2" style="width:300px"><?php switch($dat['CD']['column_status'])
			{
				case 'O' : echo 'Moved to Opportunity'; break;
				case 'A' : echo 'Moved from opportunity to applied'; break;	
				case 'S' : echo 'Moved from applied to set interview'; break;	
				case 'I' : echo 'Moved from set interview to interview'; break;	
				case 'V' : echo 'Moved from interview to verbal job offer'; break;	
				case 'J' : echo 'Moved from verbal job offer to job'; break;		
				case 'R' : echo 'Moved to Recycle bin'; break;					
			}

?></span>

<span class="col3" style="width:245px; text-align:center"><?php echo show_formatted_date($dat['CD']['start_date']);?></span>
</div>
<?php } ?>
</div>
 <div id="page_navigation">
        </div>
</section>




<script type="text/javascript">
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