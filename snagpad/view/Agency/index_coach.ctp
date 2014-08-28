      <section class="tabing_container">
              <section class="tabing">
          <ul class="tabs">
            <li class="active"><a href="#">DASHBOARD</a></li>
          </ul>
        </section>

	  <div id="error" style="display:none;"></div>
<section class="top_sec pad0">
          <section class="left_sec">
            <h3 class="small">Customize Display</h3>
          </section>
          
        </section>
                <form action="#" method="post" onsubmit="searchClient()" id="searchForm" name="searchForm">
      <section class="coach_section">

        <fieldset>
        <div class="search_sec">
          <input type="checkbox" name="status_chk" value="1" class="check"><label> Filter Clients for</label>
          <input type="radio" name="activity" value="1" class="radio_btn"><label> Red</label>
          <input type="radio" name="activity" value="2" class="radio_btn"> <label>Yellow</label>
          <input type="radio" name="activity" value="3" class="radio_btn"> <label>Green</label>
	        <label>Search by name:</label>
<input type="text" class="text" name="keyword"/>
          <a href="javascript://" onclick="searchClient()" class="refresh_btn">REFRESH DASHBOARD</a>
          </fieldset>
        <input type="hidden" id="current_page" name="current_page" value=""/>
        <input type="hidden" id="show_per_page" name="show_per_page" value=""/>


        </section>
      
        
      <section class="client_search_section">
      
      </section>
              </form>  
    </section>
  <script language="javascript">
$('#error').hide();
var frmval;
function searchClient()
{
	
		$('#error').hide();	
		frmval=$('#searchForm').serialize();
		$('.job_search_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
		$.post("<?php echo SITE_URL; ?>/coach/search",frmval,function(data){	
		if(data=='Error')
			$(".client_search_section").html('There is some error.');
		else{
			$('.client_search_section').html(data);
			Cufon.refresh();
			}
				});	
	
}
</script>     