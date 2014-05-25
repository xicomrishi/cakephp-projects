<?php //echo $this->Html->script('cufon'); ?>

<section class="tabing_container">
    <section class="tabing">
        <ul class="tab">
            <li id="add_doc_li" class=""><a href="javascript://" onclick="show_add(0);">+ ADD CLIENT</a></li>
            <li id="upload_doc_li" class=""><a href="javascript://" onclick="loadPopup('<?php echo SITE_URL."/coach/upload";?>')">+ IMPORT CLIENTS</a></li>
            <li id="search_doc_li" class="active last"><a href="javascript://" onclick="show_search();">SEARCH CLIENTS</a></li>

        </ul>
    </section>
    <section class="div_add">
    </section>

 <section class="div_search coach_section">

        <form action="#" method="post" onsubmit="return searchClient()" id="searchForm" name="searchForm">
            <section class="coach_section">

                <fieldset>
                    <div class="search_sec">
                    	<label>Search by name:</label>
                        <input type="text" class="text" name="keyword"/>
                        <input type="checkbox" name="status_chk" value="1" class="check"><label> Filter Clients for</label>
                        <input type="radio" name="activity" value="1" class="radio_btn"><label> <?php echo $this->Html->image('red.png',array('escape'=>false,'div'=>false));?></label>
                        <input type="radio" name="activity" value="2" class="radio_btn"> <label><?php echo $this->Html->image('yellow.png',array('escape'=>false,'div'=>false));?></label>
                        <input type="radio" name="activity" value="3" class="radio_btn"> <label><?php echo $this->Html->image('green.png',array('escape'=>false,'div'=>false));?></label>
                       
                        <div style="float:left; width:100%; text-align:center" >
                        <a href="javascript://" onclick="searchClient()" class="refresh_btn">REFRESH DASHBOARD</a>
                        </div>
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
$('.div_add').show();
$('.div_search').hide();	
$.post("<?php echo SITE_URL; ?>/coach/show_add",'id='+id,function(data){	
$(".div_add").html(data);

});	

}

function show_search()
{
$.post("<?php echo SITE_URL; ?>/coach/show_search",'',function(data){	
$(".div_search").html(data);
$('#search_doc_li').addClass('active');
$('#add_doc_li').removeClass('active');
$('.div_add').hide();
$('.div_search').show();	

searchClient();
});		
}

function searchClient()
{

$('#error').hide();	
frmval=$('#searchForm').serialize();
$('#search_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0', 'align' => 'middle')); ?></div>');
$.post("<?php echo SITE_URL; ?>/coach/search",frmval,function(data){	
if(data=='Error')
$("#search_section").html('There is some error.');
else{
$('#search_section').html(data);
//Cufon.refresh();
}
});	
return false;
}

function deleteClient()
{
if(iDelTotalChecked==0)
alert("Please select the client(s) you want to delete");
else{
var y=confirm("Are you sure you want to delete the selected client(s)?");
if(y)
{
searchClient();
}
}
}
function releaseClient(id){
$('#msg').html('');
var y=confirm("Are you sure to release this client?");
if(y){
    $('#release').val(id);
    searchClient();
    $("#msg").html('Client released successfully.');
}    
}
</script>      