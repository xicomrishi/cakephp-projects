<section class="search_area">
          <form id="searchForm" name="searchForm" action="" onsubmit="return submitform();">
          <fieldset>
          <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid; ?>"/>
          <input type="text" id="keyword" name="keyword" value="Enter Document Name/Tags/Desc" onfocus="if(this.value=='Enter Document Name/Tags/Desc')this.value=''" onblur="if(this.value=='')this.value='Enter Document Name/Tags/Desc'">
          <a href="javascript://" onClick="submitform();" class="pad0">SEARCH</a>
          </fieldset>
          </form>
         </section>

<script language="javascript">
function submitform()
{
		
	var inp=$('#keyword').val();

		$.post("<?php echo SITE_URL; ?>/docs/search_doc",$('#searchForm').serialize(),function(data){	
					$(".contact_section").html(data);
				
				});	
				
	
	
	return false

}
</script>         