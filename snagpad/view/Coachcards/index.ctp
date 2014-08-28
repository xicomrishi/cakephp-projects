<?php
echo $this->Html->script(array('datepicker/jquery.ui.core.min.js','datepicker/jquery.ui.datepicker.min.js','fileupload/jquery.ui.widget.js','jquery.ui.mouse'));
echo $this->Html->css(array('datepicker/jquery.ui.core.min.css','datepicker/jquery.ui.datepicker.min.css','datepicker/jquery.ui.theme.min.css'));
?>

<section class="tabing_container">
    <section class="tabing">
        <ul class="tab">
            <li id="add_doc_li" class=""><a href="javascript://" onclick="show_add(0);">+ ADD JOB CARD</a></li>
            <li id="search_doc_li" class="active last"><a href="javascript://" onclick="show_search();">SEARCH JOB CARD</a></li>

        </ul>
    </section>
    <section class="div_add">
    </section>

    <section class="div_search coach_section">

        <form action="#" method="post" onsubmit="searchClient()" id="searchForm" name="searchForm">
            <section class="coach_section">

                <fieldset>
                    <div class="search_sec">
                       <label>Search by Keyword:</label>
                        <input type="text" class="text" name="keyword"/>
                        <a href="javascript://" onclick="searchCard()" class="refresh_btn">SEARCH</a>
                </fieldset>
                <input type="hidden" id="current_page" name="current_page" value=""/>
                <input type="hidden" id="show_per_page" name="show_per_page" value=""/>

            </section>
        </form>        
    </section>

</section>

<script language="javascript"/>
$(document).ready(function(e) {
var num=$('#num').val();
if(num=='1')
{
show_add();
}else{
show_search();
}

});

function show_add(id)
{

$('#search_doc_li').removeClass('active');
$('#add_doc_li').addClass('active');
$.post("<?php echo SITE_URL; ?>/Coachcards/addCard/"+id,'',function(data){	
$(".div_add").html(data);
$('.div_add').show();
$('.div_search').hide();
});
	
	

}

function show_search()
{
	
$.post("<?php echo SITE_URL; ?>/Coachcards/show_search",'',function(data){	
$(".div_search").html(data);
$('#search_doc_li').addClass('active');
$('#add_doc_li').removeClass('active');
$('.div_add').hide();
$('.div_search').show();	

searchCard();
});		
}

function searchCard()
{

$('#error').hide();	
frmval=$('#searchForm').serialize();
$('#search_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0', 'align' => 'middle')); ?></div>');
$.post("<?php echo SITE_URL; ?>/Coachcards/search",frmval,function(data){	
if(data=='Error')
$("#search_section").html('There is some error.');
else{
$('#search_section').html(data);

}
});	
return false;
}

function deleteCard()
{
if(iDelTotalChecked==0)
alert("Please select the card(s) you want to delete");
else{
y=confirm("Are you sure you want to delete the selected card(s)?");
if(y)
{
searchCard();
}
}
}
</script>      