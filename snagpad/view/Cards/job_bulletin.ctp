	<section id="inner_body_container">
    <section class="tabing_container spacer0">
      <section class="tabing" style="margin:-64px 0 0 0">
        <ul>
          <li class="spacer"><a href="#" class="border">SEARCH FOR JOBS</a></li>
        </ul>
      </section>
	  <div id="error" style="display:none;"></div>

      <section class="top_sec space1">
        <form action="#" method="post" onsubmit="searchJob()" id="searchForm" name="searchForm">
          <fieldset>
          <h3>Enter Job Search Details</h3>
          <input type="text" value="Keywords" name="keywords" id="job_position" class=" required job_title" onBlur="if(this.value=='')this.value='Keywords'" onFocus="if(this.value=='Keywords')this.value=''">
         	  <input type="hidden" name="pagenum" value="1" id="pagenum" />
          <a href="javascript://" onclick="searchJob();">SEARCH</a>
          </fieldset>
        </form>  
        </section>
      
        
      <section class="job_search_section">
      
      </section>
    </section>
  </section>
  <script language="javascript">
$('#error').hide();
var frmval;
function searchJob()
{
	
		$('#error').hide();	
		frmval=$('#searchForm').serialize();
		$('.job_search_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
		$.post("<?php echo SITE_URL; ?>/cards/job_bulletin_mid",frmval,function(data){	
		if(data=='Error')
			$(".job_search_section").html('There is some error.');
		else{
			$('.job_search_section').html(data);
			
			}
				});	
	
}
searchJob();
function showPage(i)
{
	if($('#searchForm').serialize()==frmval)
	{
		$('#pagenum').val(i);
		frmval=$('#searchForm').serialize();
		$('.job_search_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
		$.post("<?php echo SITE_URL; ?>/jobsearch/search",frmval,function(data){	
		if(data=='Error')
			$(".job_search_section").html('A contact with this email ID already exist.');
		else{
			$('.job_search_section').html(data);
			}
				});	
	}
	else
		alert("You have changed form fields. Please click on search first");
}
 function add_card(id)
    {
            $('#div_'+id).html('<?php echo $this->Html->image('loading.gif');?>');
			$.post('<?php echo SITE_URL; ?>/cards/add_card/'+id,'',function(data){ 
			$('#error').html(data);
			$('#div_'+id).html('<a href="javascript" class="snagged">Snagged</a>');
				
            //$j('#msg').html(data);
        });
    }
</script>     