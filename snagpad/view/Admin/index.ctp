<section class="tabing_container">

        <section class="tabing">
          <ul class="gap">
            <li id="add_agency_li"><a href="javascript://" onclick="show_add_agency()">+ ADD AGENCY</a></li>
           
            <li class="last active" id="search_agency_li"><a href="javascript://" onclick="show_search_agency()">SEARCH AGENCY</a></li>
          </ul>
        </section>
        
         <section class="top_sec">
          
         
        </section>
        <section class="contact_section">
       	<section class="title_row">
             <span class="column1"><input type="checkbox" onclick="select_all_check();"/>
            <small>TITLE</small></span>
            <span class="column2 text_indent">NAME</span>
            <span class="column3">EMAIL</span>
            <span class="column4">DATE ADDED</span>
        </section>
        <?php foreach($agency as $ag){ ?>
         <section class="comon_row">
          <span class="column1 colour1"><input type="checkbox" name="cbox[]" class="contact_check" onclick="objDelChecked(this)" value="<?php echo $ag['Agency']['id']; ?>"><small><a href="javascript://"><?php echo $ag['Agency']['name']; ?></a></small></span>
        <span class="column2 colour2"><a href="mailto:<?php echo $ag['Agency']['email']; ?>"><?php echo $ag['Agency']['email']; ?></a></span>
        <span class="column3 colour3"><?php echo show_formatted_datetime($ag['Agency']['reg_date']); ?></span>
       
        </section>
        <?php } ?>
       </section>
        
      </section>
<script language="javascript">

function show_search_agency()
{
	$('#search_agency_li').addClass('active');
	$('#add_agency_li').removeClass('active');
	$.post('<?php echo SITE_URL;?>/admin/show_search','',function(data){
			$('.top_sec').html(data);
		});	
		get_all_agency();
	
}

function show_add_agency()
{
	$('#add_agency_li').addClass('active');
	$('#search_agency_li').removeClass('active');
	$('.top_sec').html('<h3>ADD AGENCY</h3>');
	$.post('<?php echo SITE_URL;?>/admin/show_add_agency','',function(data){
			$('.contact_section').html(data);
		});	
}

function get_all_agency()
{
	$.post('<?php echo SITE_URL;?>/admin/get_all_agency','',function(data){
			$('.contact_section').html(data);
		});	
}


</script>      