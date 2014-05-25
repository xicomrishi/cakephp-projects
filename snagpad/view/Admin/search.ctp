<section class="search_area">
          <form id="agencyForm" name="agencyForm" action="">
          <fieldset>
         
          <input type="text" id="searchkeyword" name="keyword" value="Enter Agency Name" onfocus="if(this.value=='Enter Agency Name')this.value=''" onblur="if(this.value=='')this.value='Enter Agency Name'">
          <a href="javascript://" onclick="submit_search();" class="pad0">SEARCH</a>
          </fieldset>
          </form>
         </section>
<script language="javascript">

function submit_search()
{
	
	var inp=$('#searchkeyword').val();
	if(inp==''||inp=='Enter Agency Name')
	{
		alert("Do Not Leave Search Field Blank");
		document.contactForm.keyword.focus();
	}
	else
	{
		$.post("<?php echo SITE_URL; ?>/admin/search_agency",$('#agencyForm').serialize(),function(data){	
					$(".contact_section").html(data);
				
				});	
	}
	
	
}
</script>         