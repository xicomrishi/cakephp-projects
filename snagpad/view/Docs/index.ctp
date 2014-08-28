<section class="tabing_container">
        <section class="tabing">
          <ul class="tab">
            <li id="add_doc_li" class=""><a href="javascript://" onclick="show_add_doc();">+ UPLOAD DOCUMENT</a></li>
            <li id="search_doc_li" class="active last"><a href="javascript://" onclick="show_search_doc();">SEARCH DOCUMENTS</a></li>
            
          </ul>
        </section>
        <input type="hidden" id="num" value="<?php echo $num; ?>"/>
         <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
        <section class="top_sec">
               
        </section>
     
        <section class="contact_section">
        
      	 </section>
        
      </section>
<script language="javascript"/>
$(document).ready(function(e) {
    var num=$('#num').val();
	if(num=='1')
	{
		show_add_doc();
	}else{
		show_search_doc();
		}
	
	
    get_index_doc();
});

function get_index_doc()
{
	var id=$('#clientid').val();
	//alert(id);
	$.post("<?php echo SITE_URL; ?>/docs/index",'clientid='+id,function(data){	
					$(".contact_section").html(data);
				
				});		
	
}

function show_add_doc()
{
	$('#search_doc_li').removeClass('active');
	$('#add_doc_li').addClass('active');
	
	var id=$('#clientid').val();
	$.post("<?php echo SITE_URL; ?>/docs/show_add_doc",'clientid='+id,function(data){	
					$(".top_sec").html(data);
				
				});	
}

function show_search_doc()
{
	$('#add_doc_li').removeClass('active');
	$('#search_doc_li').addClass('active');
	var id=$('#clientid').val();
	$.post("<?php echo SITE_URL; ?>/docs/show_search",'clientid='+id,function(data){	
					$(".top_sec").html(data);
				
				});		
}

</script>      