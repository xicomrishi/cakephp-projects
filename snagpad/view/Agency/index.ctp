<section class="tabing_container">
    <section class="tabing">
        <ul class="tab">
            <li id="add_doc_li" class=""><a href="javascript://" onclick="show_add(0);">+ ADD CLIENT</a></li>
            <li id="upload_doc_li" class=""><a href="javascript://" onclick="loadPopup('<?php echo SITE_URL."/agency/upload";?>')">+ Import CLIENT</a></li>
            <li id="search_doc_li" class="active last"><a href="javascript://" onclick="show_search();">SEARCH CLIENTS</a></li>

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
$.post("<?php echo SITE_URL; ?>/agency/show_add",'id='+id,function(data){	
$(".div_add").html(data);
$('#msg').html('');

});	

}

function show_search()
{
$.post("<?php echo SITE_URL; ?>/agency/show_search",'',function(data){	
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
$('#msg').html('');
$('#error').hide();	
var searchfield=$('#search_id').val();
if(searchfield=='Name/Email'){ $('#search_id').val(''); }
frmval=$('#searchForm').serialize();
$('#search_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0', 'align' => 'middle')); ?></div>');
$.post("<?php echo SITE_URL; ?>/agency/search",frmval,function(data){	
if(data=='Error')
$("#search_section").html('There is some error.');
else{
$('#search_section').html(data);
$('#search_id').val('Name/Email'); 
}
});	

}

function deleteClient()
{
iDelTotalChecked=$('.client_check').filter(':checked').length;
if(iDelTotalChecked==0)
alert("Please select the client(s) you want to delete");
else{
y=confirm("Are you sure you want to delete these client(s)?");
if(y){
	searchClient();
    $("#msg").html('Client(s) deleted successfully');	

}
else{
	$('.client_check').attr('checked',false);
	$('.checkall').attr('checked',false);
}
}
}
function releaseClient(id){
$('#msg').html('');
y=confirm("Are you sure to release this client(s)?");
if(y){
    $('#release').val(id);
    searchClient();
    $("#msg").html('Client released successfully.');
}    
}
function viewClient(id)
{
if(open_id==id)
{
	if(document.getElementById('client_detail_'+open_id).style.display=="none")
		document.getElementById('client_detail_'+open_id).style.display="";
	else
		document.getElementById('client_detail_'+open_id).style.display="none";
}
if(open_id!=id){
	if(open_id!='')
		document.getElementById('client_detail_'+open_id).innerHTML='';
open_id=id;
div_id="#client_detail_"+id;
$.post("<?php echo SITE_URL."/agency/viewClient/"?>"+id,'',function(data){
$(div_id).html(data);
})
}
}
function updateClient(id,coach_id,account_id){
$.post("<?php echo SITE_URL."/agency/updateClient/"?>"+id,{'coach_id':coach_id},function(data){
	$("#client_"+account_id).html($('#coach_id_'+id+' option:selected').text());
    $("#msg").html('Client updated successfully.');
	$("#msg").addClass('success');
	$('#client_detail_'+account_id).hide();
})

}

</script>      