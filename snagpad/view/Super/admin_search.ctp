<section class="admin_area">
         
          <fieldset>        
          <input type="text" id="searchkeyword" name="keyword" value="Enter Agency Name or Email" onfocus="if(this.value=='Enter Agency Name or Email')this.value=''" onblur="if(this.value=='')this.value='Enter Agency Name or Email'"/>
          <a href="javascript://" onclick="submit_search();" class="search">SEARCH</a>
          </fieldset>
         </section>
<script type="text/javascript">

function submit_search()
{
	
	var inp=$('#searchkeyword').val();
		$.post("<?php echo SITE_URL; ?>/admin/super/get_all_agency",$('#agencyForm').serialize(),function(data){	
					$(".contact_section").html(data);
				});	
}
</script>         