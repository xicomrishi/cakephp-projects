<section id="inner_body_container">
    <section class="tabing_container spacer0">
      <section class="tabing">
        <ul>
          <li class="spacer"><a href="#" class="border">SEARCH FOR JOBS</a></li>
        </ul>
      </section>
	  <div id="error" style="display:none;"></div>

      <section class="top_sec space1">
        <form action="#" method="post" onsubmit="searchJob()" id="searchForm" name="searchForm">
          <fieldset>
          <h3>Enter Job Search Details</h3>
          <input type="text" value="Job Title, Keywords or Company Name" name="job_position" id="job_position" class=" required job_title" onBlur="if(this.value=='')this.value='Job Title, Keywords or Company Name'" onFocus="if(this.value=='Job Title, Keywords or Company Name')this.value=''">
          <input type="text" value="City, State/Province" name="job_location" class="city" onBlur="if(this.value=='')this.value='City, State/Province'" onFocus="if(this.value=='City, State/Province')this.value=''">
          <!--<input type="text" value="Postal Code" name="job_postal_code" class="city" onBlur="if(this.value=='')this.value='Postal Code'" onFocus="if(this.value=='Postal Code')this.value=''" style="margin-right:5px; width:77px;">-->
          <select name="distance">
          	<option value="0">Only in</option>
            <option value="5" selected="selected">Within 5 miles of</option>
            <option value="10">Within 10 miles of</option>
            <option value="15">Within 15 miles of</option>
            <option value="25">Within 25 miles of</option>
            <option value="50">Within 50 miles of</option>
            <option value="100">Within 100 miles of</option>
          </select>
		  <input type="hidden" name="pagenum" value="1" id="pagenum" />
          <select name="job_country">
		  <?php foreach($country as $key=>$val)
		  			if($key==$default_country)
						echo "<option value='$key' selected>$val</option>";
					else
						echo "<option value='$key'>$val</option>";
		 ?>
          </select>
          <a href="javascript://" onclick="searchJob();" style="float:right; margin:18px 0px 0 0">SEARCH</a>
          </fieldset>
        </form>  
        <form action="" method="post" id="frmjob">
        <input type="hidden" name="city" id="city" />
        <input type="hidden" name="state" id="state" />
        <input type="hidden" name="country" id="country" />
        <input type="hidden" name="job_url" id="job_url" />
        <input type="hidden" name="usertyp" id="usertyp" />
        <input type="hidden" name="position_available" id="position_available" />
        <input type="hidden" name="company_name" id="company_name" />
        <input type="hidden" name="other_web_job_id" id="other_web_job_id" />
        <input type="hidden" name="resource_id" id="resource_id" />
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
	if($('#job_position').val()=="Job Title, Keywords or Company Name"){
		$('#error').html("Please enter Job title or Company Name");
		$('#error').show();
	}
	else
	{
		$('#error').hide();	
		$('#pagenum').val(1);
		frmval=$('#searchForm').serialize();
		$('.job_search_section').html('<div align="center" id="loading" style="height:100px;padding-top:100px;width:950px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
		$.post("<?php echo SITE_URL; ?>/jobsearch/search",frmval,function(data){	
		if(data=='Error')
			$(".job_search_section").html('There is some error.');
		else{
			$('.job_search_section').html(data);
				}
				});	
				}
}
function showPage(i)
{
	//if($('#searchForm').serialize()==frmval)
	//{
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
	//}
	//else
		//alert("You have changed form fields. Please click on search first");
}
 function setVal(position,company,city,state,country,job_url,jbtype,id,usertyp)
    {
       	
	   
		$('#city').val(city);
        $('#state').val(state);
        $('#country').val(country);
        $('#job_url').val(job_url);
        $('#position_available').val(position);
        $('#company_name').val(company);
        $('#resource_id').val(jbtype);
		$('#other_web_job_id').val(id);
		//$('#usertyp').val(usertyp);
        frmval=$("#frmjob").serialize(); 
		if(usertyp==2)
		{
			loadJobPopup('<?php echo SITE_URL; ?>/jobsearch/get_all_clients',country,city,state,job_url,position,company,id);
		}else{
			$('#div_'+jbtype+'_'+id).html('<?php echo $this->Html->image('loading.gif');?>');   
            $.post('<?php echo SITE_URL; ?>/jobsearch/jobAdd',frmval,function(data){ 
			$('#error').html(data);
			$('#div_'+jbtype+"_"+id).html('<a href="javascript://" class="snagged">Snagged</a>');
	            //$j('#msg').html(data);
      	  });
		}
    }
</script>     