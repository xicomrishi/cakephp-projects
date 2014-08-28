<?php echo 	$this->Html->Script('/ckeditor/ckeditor');?>
<?php echo $this->Html->script('jquery.ocupload'); ?>
<section class="tabing_container">

        <section class="tabing">
          <ul class="gap">
            <li id="add_agency_li"><a href="javascript://" onclick="show_add_agency(0);">+ ADD/UPDATE AGENCY</a></li>
           
            <li class="last active" id="search_agency_li"><a href="javascript://" onclick="show_search_agency();">SEARCH AGENCY</a></li>
          </ul>
        </section>
      
        <section class="search_area">
           <form id="agencyForm" name="agencyForm" action="">
       
         <section class="top_sec">
          
         
        </section>
        <section class="contact_section">
      
       </section>
    </form>    
      </section>
  </section>      
<script type="text/javascript">

function show_search_agency()
{
	$('#search_agency_li').addClass('active');
	$('#add_agency_li').removeClass('active');
	$.post('<?php echo SITE_URL;?>/admin/super/show_search','',function(data){
			$('.top_sec').html(data);
					get_all_agency();
		});	

	
}
show_search_agency();
function show_add_agency(id)
{
	$('#add_agency_li').addClass('active');
	$('#search_agency_li').removeClass('active');
	$('.top_sec').html('<h3>ADD/UPDATE AGENCY</h3>');
	$.post('<?php echo SITE_URL;?>/admin/super/show_add_agency/'+id,'',function(data){
			$('.contact_section').html(data);
			 CKEDITOR.replace( 'description' );
			 CKEDITOR.replace('specification');
		});	
}

function get_all_agency()
{
	var frm=$('#agencyForm').serialize();
	$.post('<?php echo SITE_URL;?>/admin/super/get_all_agency',frm,function(data){
			$('.contact_section').html(data);
		});	
}

function upgrade_subscription(id){
	$.post('<?php echo SITE_URL;?>/admin/super/upgrade_subscription/'+id,'',function(data){
			get_all_agency();
			$('#msg').html('Agency\'s subscription updated successfully.');	
		});	
	
}

function deleteAgency(){
if(iDelTotalChecked==0)
alert("Please select at least one agency(s) you want to delete");
else{
var y=confirm(" All coach(es) and client(s) will also deleted from system. Are you sure you want to delete the selected agency?");
if(y)
{
	$('#msg').html('Agency deleted successfully.');
get_all_agency();
}
}
}
function change_status(id,status){
	if(status!=0)
	{
		var v=confirm("All coach(es) and client(s) will be released. Do you want to deactivate this agency?");
		if(v){
			$.post("<?php echo SITE_URL."/admin/super/change_status/"?>"+id,{'id':id,'status':status},function(data){
			get_all_agency();
			$('#msg').html('Agency deactivated successfully.');
			})
		}
		}else{
				$.post("<?php echo SITE_URL."/admin/super/change_status/"?>"+id,{'id':id,'status':status},function(data){
					
			get_all_agency();
			$('#msg').html('Agency activated successfully.');
})
		}

}

</script>      