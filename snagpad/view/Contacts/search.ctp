<section class="search_area">
          <form id="contactForm" name="contactForm" action="">
          <fieldset>
          <input type="hidden" id="account_id" name="account_id" value="<?php echo $account_id;?>"/>
          <input type="text" id="searchkeyword" name="keyword" value="Enter Contact Name" onfocus="if(this.value=='Enter Contact Name')this.value=''" onblur="if(this.value=='')this.value='Enter Contact Name'">
          <a href="javascript://" onclick="submit_search();" class="pad0">SEARCH</a>
          </fieldset>
          </form>
         </section>
         <!--<a href="<?php echo SITE_URL; ?>/contacts/show_contact_network/<?php echo $this->Session->read('Account.id');?>">SnagCast</a>-->
<script language="javascript">

function submit_search()
{
	
		$.post("<?php echo SITE_URL; ?>/contacts/search_contact",$('#contactForm').serialize(),function(data){	
					$(".contact_section").html(data);
				
				});	
	
}


</script>         