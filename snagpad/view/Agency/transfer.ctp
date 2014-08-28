<section id="inner_body_container" style="margin:0px !important">
    <section class="tabing_container spacer0" style="margin:0px !important">
      <section class="tabing" >
        <ul>
          <li class="spacer active"><a href="#" class="border"><?php foreach($coachs as $coach)		  
		  {	 if($coach['Coach']['account_id']==$id) {echo $coach['Coach']['name'];break;}} ?>'s Client Transfer</a></li>
        </ul>
      </section>
	  <div id="error" style="display:none;position:relative"></div>
	<section class="coach_section">
    <form id="searchForm" name="searchForm" method="post"   action="searchForm">
      <section class="search_sec">
          <br/>
			<label>Select Coach</label>           
            <select name="coach" id="coach" class="select" style=" border: 1px solid #CCCCCC;width: 150px;height: 26px; margin: 7px 0 0; padding: 3px;">
            <option value="">Select coach</option>
            <?php foreach($coachs as $coach)
			if($coach['Coach']['account_id']!=$id) {
            	echo "<option value='".$coach['Coach']['account_id']."'>".$coach['Coach']['name']."</option>"; 
			} ?>
         	</select>
         	<input type="hidden" name="pagenum" value="1" id="pagenum" />
          <a href="javascript://" onclick="validate_transfer();" style="margin:0 0 0 20px" class="refresh_btn">Transfer</a>          
          
        </section>    
        <section class="heading_row">
        <span class="coln1" style="width:98px"><input type="checkbox" name="cbox[]" id="masterbox" onclick='check(this);' value=""></span>
        <span class="coln2" style="text-align:left; width:220px;">Name</span>
        <span class="coln3" style="width:400px">Email</span>        
        <span class="coln4" style="width:200px">Date Added</span>
        
        </section>
      <section id="search_section">   </section>
      </form>
      </section>
    </section>
  </section>
  <script language="javascript">
$('#error').hide();
 var iDelTotalChecked=0;
var frmval;

function validate_transfer()
{
	var err=0;	
	if(iDelTotalChecked==0)
	{
		$('#error').html("Please select the clients(es) you want to transfer.");
		$('#error').show();	
		err=1;
	}
	if($('#coach').val()=='')
	{
		
		$('#error').html("Please select the coach you want to transfer.");
		$('#error').show();	
		err=1;
	}
	if(err==0)
	{
		$('#error').hide();	
		frmval=$('#searchForm').serialize();
		$.post("<?php echo SITE_URL; ?>/agency/transfer_client",frmval,function(data){				
			if(data=='Error')
				$("#error").html('There is some error.');
			else{
				$("#error").html(data+" clients successfully transfered.");
				$('#error').show();	
				report_mid('<?php echo $id;?>');;				
				}
			});	
		
	}
	
}
function report_mid(id)
{
	iDelTotalChecked=0			
		$('#search_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
		$.post("<?php echo SITE_URL; ?>/agency/transfer_client_lists",{id:id},function(data){	
		if(data=='Error')
			$("#search_section").html('There is some error.');
		else{
			$('#search_section').html(data);
			
			}
				});	
	
}
report_mid('<?php echo $id;?>');
</script>     