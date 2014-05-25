<?php
echo $this->Html->script(array('datepicker/jquery.ui.core.min.js','datepicker/jquery.ui.datepicker.min.js','jquery.ui.widget.js','jquery.ui.mouse'));
echo $this->Html->css(array('datepicker/jquery.ui.core.min.css','datepicker/jquery.ui.datepicker.min.css','datepicker/jquery.ui.theme.min.css','datepicker/demos.css'));
?>
<section id="inner_body_container" style="margin:0px !important">
    <section class="tabing_container spacer0" style="margin:0px !important">
      <section class="tabing" >
        <ul>
          <li class="spacer active"><a href="#" class="border">Report</a></li>
        </ul>
      </section>
	  <div id="error" style="display:none;"></div>

      <section class="top_sec space1" style="background:none">
        <form action="#" method="post" onsubmit="searchJob()" id="searchForm" name="searchForm">
          <fieldset>
          <h3 style="padding:0px 0 12px 0">Filter Time Frame</h3>
<label style="float:left; padding:12px 0 0 0">From:</label>
          <input type="text" value="" name="from_date" id="from_date" class="job_title" readonly="readonly" style="margin:0 10px" />
<label style="float:left; padding:12px 0 0 0">To:</label>
          <input type="text" value="" name="to_date" id="to_date" class=" job_title"  readonly="readonly"/ style="margin:0 10px">
         	  <input type="hidden" name="pagenum" value="1" id="pagenum" />
          <a href="javascript://" onclick="report_mid();" style="margin:0 0 0 13px">SEARCH</a>           <a href="javascript://" onclick="document.location.href='<?php echo SITE_URL;?>/Agency/report_download/<?php echo $id;?>/f:'+$('#from_date').val()+'/t:'+$('#to_date').val();" style="float:right; margin:10px 48px 0 0;">PDF DOWNLOAD</a>
          </fieldset>
        </form>  
        </section>
      
        
      <section class="job_search_section">
      
      </section>
    </section>
  </section>
  <script language="javascript">
$('#error').hide();
$(document).ready(function(){
	var to_day=new Date();
	$( "#from_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			minDate:'<?php if(isset($coach)){ echo $coach['Coach']['reg_date']; }?>',
			 maxDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate()),
			//yearRange: 'c:+1',
			dateFormat: 'yy-mm-dd',
			onSelect: function( selectedDate ) {
				$( "#to_date" ).datepicker( "option", "minDate", selectedDate );
			}
			
			
		});

	
	$('#from_date').keyup(function(e) {
    if(e.keyCode == 8 || e.keyCode == 46) {
        $.datepicker._clearDate(this);
    }
});	
$( "#to_date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			minDate:'<?php if(isset($coach)){ echo $coach['Coach']['reg_date']; }?>',
			 maxDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate()),
			//yearRange: 'c:+1',
			dateFormat: 'yy-mm-dd',
			onSelect: function( selectedDate ) {
				$( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
			}
			
			
		});

	
	$('#to_date').keyup(function(e) {
    if(e.keyCode == 8 || e.keyCode == 46) {
        $.datepicker._clearDate(this);
    }
});	
	});
var frmval;
function report_mid()
{
	
		$('#error').hide();	
		frmval=$('#searchForm').serialize();
		$('.job_search_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
		$.post("<?php echo SITE_URL; ?>/agency/report_mid/<?php echo $id;?>",frmval,function(data){	
		if(data=='Error')
			$(".job_search_section").html('There is some error.');
		else{
			$('.job_search_section').html(data);
			
			}
				});	
	
}
report_mid();
</script>     