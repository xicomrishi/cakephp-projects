<section class="tabing_container">
    <section class="tabing">
        <ul class="tab">
            <li id="add_doc_li" class=""><a href="javascript://" onclick="show_add(0);">+ ADD COACH</a></li>
            <?php if($this->Session->read('usertype')==0 || $this->Session->read('usertype')==1){?>
            <li id="upload_doc_li" class=""><a href="javascript://" onclick="loadPopup('<?php echo SITE_URL."/agency/upload/2";?>')">+ Import COACH</a></li>
            <?php }?>
            <li id="search_doc_li" class="active last"><a href="javascript://" onclick="show_search();">SEARCH COACH</a></li>

        </ul>
    </section>
    <section class="div_add">
    </section>

    <section class="div_search">
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
$('#msg').html('');
$('#error').html('');	

$('#search_doc_li').removeClass('active');
$('#add_doc_li').addClass('active');
$('.div_add').show();
$('.div_search').hide();	
$.post("<?php echo SITE_URL; ?>/agency/show_coachadd",'id='+id,function(data){	
$(".div_add").html(data);

});	
}

function show_search()
{
$.post("<?php echo SITE_URL; ?>/agency/show_coachsearch",'',function(data){	
$(".div_search").html(data);
$('#search_doc_li').addClass('active');
$('#add_doc_li').removeClass('active');
$('.div_add').hide();
$('.div_search').show();	
searchCoach();
});		
}

function searchCoach()
{
$('#msg').html('');
$('#error').html('');	
var searchfield=$('#search_id').val();
if(searchfield=='Name/Email'){ $('#search_id').val(''); }
frmval=$('#searchForm').serialize();
$('#search_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0', 'align' => 'middle')); ?></div>');
$.post("<?php echo SITE_URL; ?>/agency/coach_search",frmval,function(data){	
if(data=='Error')
$("#search_section").html('There is some error.');
else{
$('#search_section').html(data);
$('#search_id').val('Name/Email'); 
}
});	
return false;
}

function deleteCoach()
{
iDelTotalChecked=$('.check').filter(':checked').length;

if(iDelTotalChecked==0)
alert("Please select the coach(s) you want to delete");
else{
y=confirm("Are you sure you want  to delete the selected coache(s)?");
if(y){
	searchCoach();
	$('#msg').html('Coach(es) deleted successfully.');
}
else{
	$('.check').attr('checked',false);
	$('.checkall').attr('checked',false);
}
}
}
function viewCoach(id)
{
if(open_id==id)
{
	if(document.getElementById('coach_detail_'+open_id).style.display=="none")
		document.getElementById('coach_detail_'+open_id).style.display="";
	else
		document.getElementById('coach_detail_'+open_id).style.display="none";
}
if(open_id!=id){
	if(open_id!='')
		document.getElementById('coach_detail_'+open_id).innerHTML='';
open_id=id;
div_id="#coach_detail_"+id;
$.post("<?php echo SITE_URL."/agency/viewCoach/"?>"+id,'',function(data){
$(div_id).html(data);
})
}
}
function updateCoach(id,coach_id,account_id){
$.post("<?php echo SITE_URL."/agency/updateCoach/"?>"+id,{'agency_id':coach_id},function(data){
	$("#coach_"+account_id).html($('#agency_id_'+id+' option:selected').text());
    $("#msg").html('Coach updated successfully.');
	$("#msg").addClass('success');
	$('#coach_detail_'+account_id).hide();
})

}


function change_status(id,status){
$.post("<?php echo SITE_URL."/agency/change_status/"?>"+id,{'id':id,'status':status},function(data){
	$("#msg").addClass('success');
	searchCoach();
    $("#msg").html('Status changed successfully.');	
})


}

</script>      