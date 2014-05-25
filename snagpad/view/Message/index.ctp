<input type="hidden" id="num" value="<?php echo $num;?>"/>
<section class="tabing_container">
    <section class="tabing">
        <ul class="tab">
            <li id="add_doc_li" class=""><a href="javascript://" onclick="show_add(0,0);">+Compose Message</a></li>
           
            <li id="search_doc_li" class=""><a href="javascript://" onclick="show_search(1);">OUTBOX</a></li>
             <li id="upload_doc_li" class="last active"><a href="javascript://" onclick="show_search(0)">INBOX</a></li>

        </ul>
    </section>
    <section class="div_add">
    </section>

    <section class="div_search">

        <form action="#" method="post" onsubmit="searchClient()" id="searchForm" name="searchForm">
            <section class="coach_section">
            </section>
                            <input type="hidden" id="current_page" name="current_page" value=""/>
                <input type="hidden" id="show_per_page" name="show_per_page" value=""/>

        </form>        
    </section>

</section>

<script language="javascript"/>
$(document).ready(function(e) {
var num=$('#num').val();
<?php if(isset($msg_open)) { ?>
show_search('msg_'+num+'_0');
<?php }else{ ?>
if(num=='1')
{
show_add(0,0);
}else{
show_search(0);
}
<?php } ?>
});

function show_add(id,to_id)
{
$('#search_doc_li').removeClass('active');
$('#upload_doc_li').removeClass('active');
$('#add_doc_li').addClass('active');
$('.div_add').show();
$('.div_search').hide();	
$.post("<?php echo SITE_URL; ?>/message/compose/"+id+"/"+to_id,'',function(data){	
$(".div_add").html(data);

});	

}

function show_search(type)
{
	type=unescape(type);
	var msg_open=type.split("_");
	if(msg_open[0]=='msg')
	{
		type=msg_open[2];	
	}
	$.post("<?php echo SITE_URL; ?>/message/show_search/"+type,'',function(data){	
		$(".div_search").html(data);
		if(type==0){
			$('#upload_doc_li').addClass('active');
			$('#search_doc_li').removeClass('active');
		}else{
			$('#upload_doc_li').removeClass('active')
			$('#search_doc_li').addClass('active');
		}
		$('#add_doc_li').removeClass('active');
		$('.div_add').hide();
		$('.div_search').show();
		if(msg_open[0]=='msg')
		{
			searchMail(msg_open);	
		}else{	
			searchMail(type);
		}
	});		
}

function searchMail(type)
{
	type=unescape(type);
	var msg_open=type.split(",");
	if(msg_open[0]=='msg')
	{
		type=msg_open[2];
	}
	$('#error').hide();	
	frmval=$('#searchForm').serialize();
	$('#search_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0', 'align' => 'middle')); ?></div>');
	$.post("<?php echo SITE_URL; ?>/message/search/"+type,frmval,function(data){	
		if(data=='Error')
			$("#search_section").html('There is some error.');
		else{
			$('#search_section').html(data);
			if(msg_open[0]=='msg')
			{
				view_mail(msg_open[1],type);
			}
			
		}
	});	

}

function deleteMail(type)
{
if(iDelTotalChecked==0)
alert("Please select mail to delete");
else{
y=confirm("Are you sure to delete Selected Message(s)?");
if(y)
{
searchMail(type);
}
}
}
function view_mail(id,type)
{
if(open_id==id)
{
	if(document.getElementById('email_detail_'+open_id).style.display=="none")
		document.getElementById('email_detail_'+open_id).style.display="";
	else
		document.getElementById('email_detail_'+open_id).style.display="none";
}
if(open_id!=id){
	if(open_id!='')
		document.getElementById('email_detail_'+open_id).innerHTML='';
open_id=id;
div_id="#email_detail_"+id;
$.post("<?php echo SITE_URL."/message/view_mail/"?>"+id+"/"+type,'',function(data){
$(div_id).html(data);
//var l=document.getElementById('text_count_read').value;
//$j("#div_no_inbox").html(l);
//$j("#txt_no_file").html(l);
get_message_count();
});

}
}

</script>      