<?php
echo $this->Html->script(array('datepicker/jquery.ui.core.min.js','datepicker/jquery.ui.datepicker.min.js','jquery.ui.mouse'));
echo $this->Html->css(array('datepicker/jquery.ui.core.min.css','datepicker/jquery.ui.datepicker.min.css','datepicker/jquery.ui.theme.min.css','datepicker/demos.css'));
?>

<section class="tabing_container">
    <section class="tabing">
        <ul class="tab">
        <?php if(!isset($employer)){?>
            <li id="add_doc_li" class=""><a href="javascript://" onclick="show_add(0);">+ ADD/UPDATE CARD</a></li>
		<?php }?>            
            <li id="search_doc_li" class="active last"><a href="javascript://" onclick="show_search();">SEARCH CARDS</a></li>

        </ul>
    </section>
    <section class="div_add">
    </section>

    <section class="div_search">

            <section class="coach_section">

                
            </section>

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
$.post("<?php echo SITE_URL; ?>/cards/addCard/"+id,'',function(data){	
$(".div_add").html(data);

});	

}

function show_search()
{
$.post("<?php echo SITE_URL; ?>/cards/show_search<?php if(isset($employer)) echo '/1';?>",'',function(data){	
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
var searchfield=$('#search_id').val();
if(searchfield=='Company Name'){ $('#search_id').val(''); }

var searchfield1=$('#search_id1').val();
if(searchfield1=='Position Available'){ $('#search_id1').val(''); }

frmval=$('#searchForm').serialize();
$('#search_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0', 'align' => 'middle')); ?></div>');
$.post("<?php echo SITE_URL; ?>/cards/search",frmval,function(data){	
if(data=='Error')
$("#search_section").html('There is some error.');
else{
$('#search_section').html(data);
$('#search_id').val('Company Name'); 
$('#search_id1').val('Position Available');
}
});	

}

function approve_card(id,val){
	$.post("<?php echo SITE_URL; ?>/cards/approve_card/"+id+"/"+val,'',function(data){	
	searchCard();
	});
}
	

function deleteCard()
{
iDelTotalChecked=$('.contact_check').filter(':checked').length;
if(iDelTotalChecked==0)
alert("Please select card to delete");
else{
y=confirm("Are you sure you want to delete the selected card(s)?");
if(y)
{
searchCard();
}
}
}
</script>      