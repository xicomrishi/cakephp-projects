<?php
echo $this->Html->script(array('datepicker/jquery.ui.core.min.js','datepicker/jquery.ui.datepicker.min.js','jquery.ui.widget.js','jquery.ui.mouse'));
echo $this->Html->css(array('datepicker/jquery.ui.core.min.css','datepicker/jquery.ui.datepicker.min.css','datepicker/jquery.ui.theme.min.css','datepicker/demos.css'));
?>

<section class="tabing_container">
    <section class="tabing">
        <ul class="tab">
            <li id="add_doc_li" class=""><a href="javascript://" onclick="show_add(0);">+ ADD CARD</a></li>
            <li id="search_doc_li" class="active last"><a href="javascript://" onclick="show_search();">SEARCH CARDS</a></li>

        </ul>
    </section>
    <section class="div_add">
    </section>

    <section class="div_search">

        <form action="#" method="post" onsubmit="searchClient()" id="searchForm" name="searchForm">
            <section class="coach_section">

                
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
$('.div_add').show();
$('.div_search').hide();	
$.post("<?php echo SITE_URL; ?>/agencycards/addCard/"+id,'',function(data){	
$(".div_add").html(data);

});	

}

function show_search()
{
$.post("<?php echo SITE_URL; ?>/agencycards/show_search",'',function(data){	
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
$.post("<?php echo SITE_URL; ?>/agencycards/search",frmval,function(data){	
if(data=='Error')
$("#search_section").html('There is some error.');
else{
$('#search_section').html(data);
}
});	

}

function deleteCard()
{
if(iDelTotalChecked==0)
alert("Please select card to delete");
else{
y=confirm("Are you sure you want to delete selected card(s)?");
if(y)
{
searchCard();
}
}
}
</script>      