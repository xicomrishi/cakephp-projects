<?php echo $this->Html->script('cufon'); ?>

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

                <fieldset>
                    <div class="search_sec">
                        <label>Search by Keyword:</label>
                        <input type="text" class="text" name="keyword"/>
                        <a href="javascript://" onclick="searchCard()" class="refresh_btn">SEARCH</a>
                </fieldset>
                <input type="hidden" id="current_page" name="current_page" value=""/>
                <input type="hidden" id="show_per_page" name="show_per_page" value=""/>


            </section>


            <section class="card_search_section">

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
get_index();
});

function get_index()
{
var id=$('#clientid').val();
//alert(id);
$.post("<?php echo SITE_URL; ?>/coach/coachcard",'',function(data){	
$(".contact_section").html(data);

});		

}

function show_add(id)
{
$('#search_doc_li').removeClass('active');
$('#add_doc_li').addClass('active');
$('.div_add').show();
$('.div_search').hide();	
$.post("<?php echo SITE_URL; ?>/coach/addCard",'id='+id,function(data){	
$(".div_add").html(data);

});	

}

function show_search()
{
var id=$('#clientid').val();
$.post("<?php echo SITE_URL; ?>/coach/show_search",'clientid='+id,function(data){	
$(".div_search").html(data);

});		
}


</script>      