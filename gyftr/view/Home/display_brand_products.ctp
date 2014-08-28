<div class="title_row">
<span><?php echo str_replace("_","'",$brand_name); ?></span>
<span class="product_value">Basket Value<br><strong>INR <?php if($this->Session->check('Gifting.total_basket_value')) echo $this->Session->read('Gifting.total_basket_value'); else echo 0; ?></strong></span>
 <?php echo $this->Html->image('basket_img.jpg',array('escape'=>false,'alt'=>''));?>
</div>
<input type="hidden" id="current_page" name="current_page" value=""/>
<input type="hidden" id="show_per_page" name="show_per_page" value=""/>

<div class="brand_slider">
<ul class="all_vouchers_display">
<?php 
if(!empty($product)){
foreach($product as $pr) { 
?>
<li onclick="display_product_details('<?php echo $pr['BrandProduct']['id']; ?>','<?php echo $pr['BrandProduct']['price']; ?>');" title="<?php echo str_replace("_","'",$pr['BrandProduct']['voucher_name']); ?>"><a href="javascript://"><?php if($pr['BrandProduct']['voucher_type']=='VALUE VOUCHER'){ echo '<small>INR</small>';  echo '<br><strong>'.$pr['BrandProduct']['price'].'</strong>'; } ?><span><?php $c_len=strlen($pr['BrandProduct']['voucher_name']); if($pr['BrandProduct']['voucher_type']=='VALUE VOUCHER'){ if($c_len>16){ $c_name=substr($pr['BrandProduct']['voucher_name'], 0, 16);
  				echo str_replace("_","'",$c_name)."..."; }else{ echo str_replace("_","'",$pr['BrandProduct']['voucher_name']);}}else{ echo str_replace("_","'",$pr['BrandProduct']['voucher_name']); } ?></span></a><?php echo $this->Html->image('pro_basket.jpg',array('escape'=>false,'alt'=>''));?>
<?php if($pr['BrandProduct']['discount']!=0){ ?>
<span class="disscount"><?php echo $pr['BrandProduct']['discount']; ?>%<br>off</span>

<?php } ?>
<a href="javascript://" class="zoom"><?php echo $this->Html->image('zoom_icon.png',array('escape'=>false,'alt'=>''));?></a>
</li>
<?php }} ?>
</ul>
<?php if(count($product)>4){ ?>
<div class="dir_arr">

<a href="javascript://" onclick=""><?php echo $this->Html->image('prod_slide_arr1.jpg',array('escape'=>false,'alt'=>''));?></a>
<a href="javascript://" onclick=""><?php echo $this->Html->image('prod_slide_arr2.jpg',array('escape'=>false,'alt'=>''));?></a>

</div>
<?php } ?>
</div>


<?php if($this->Session->check('Gifting.total_basket_value')) { ?>
<div class="check_basket active" onclick="<?php echo "select_product('0');";?>"></div>

<?php }else{ ?>
<div class="check_basket"></div>

<?php } ?>

<script language="javascript">
    $(document).ready(function(){  
      
        //how much items per page to show  
        var show_per_page = 4;  
        //getting the amount of elements inside content div  
        var number_of_items = $('.all_vouchers_display').children().size();  
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
		var navigation_html = ''; 
     	  var current_link = 0;  
        while(number_of_pages > current_link){  
            navigation_html += '<a class="page_link" style="display:none" href="javascript:go_to_page(' + current_link +')" longdesc="' + current_link +'">'+ (current_link + 1) +'</a>';  
            current_link++;  
        } 
	  /*  var navigation_html = '<a class="previous_link" href="javascript:previous();">Prev</a>';  
		 
       
		navigation_html += '<a class="next_link" href="javascript:next();">Next</a>';  */
        navigation_html += '<a class="next_link" href="javascript:next();"><img src="'+variab+'/img/prod_slide_arr2.jpg"/></a>';
		 navigation_html += '<a class="previous_link" href="javascript:previous();"><img src="'+variab+'/img/prod_slide_arr1.jpg"/></a>';  
      
        $('.dir_arr').html(navigation_html);  
      
        //add active_page class to the first page link  
        $('.dir_arr .page_link:first').addClass('active_page');  
      
        //hide all the elements inside content div  
        $('.all_vouchers_display').children().css('display', 'none');  
      
        //and show the first n (show_per_page) elements  
        $('.all_vouchers_display').children().slice(0, show_per_page).css('display', 'block');  
      
    });  
      
    function previous(){  
      
        new_page = parseInt($('#current_page').val()) - 1;  
        //if there is an item before the current active link run the function  
		//alert(new_page);
        if($('.active_page').prev('.page_link').length==true){  
            go_to_page(new_page);  
        }  
      
    }  
      
    function next(){  
        new_page = parseInt($('#current_page').val()) + 1;  
        //if there is an item after the current active link run the function  
		//alert(new_page);
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
        $('.all_vouchers_display').children().css('display', 'none').slice(start_from, end_on).css('display', 'block');  
      
        /*get the page link that has longdesc attribute of the current page and add active_page class to it 
        and remove that class from previously active page link*/  
		$('.dir_arr a').removeClass('active_page');
		$('.dir_arr a[longdesc=' + page_num +']').addClass('active_page');
        //$('.page_link[longdesc=' + page_num +']').addClass('active_page').siblings('.active_page').removeClass('active_page');  
      
        //update the current page input field  
        $('#current_page').val(page_num);  
    }  
</script>            