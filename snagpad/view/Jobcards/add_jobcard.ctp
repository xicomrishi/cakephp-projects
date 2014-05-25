<div id="error" class="errmassge"></div> 
<section class="top_sec add_job_cart" style="padding:30px 30px 40px 30px; width:<?php if(isset($is_popup))echo "710"; else echo "900";?>px;">
<form id="jobcardForm" name="jobcardForm" method="post" action="">
<div class="contact_left">
<h3>Enter Job Detail</h3>
<input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid; ?>"/>
<input type="hidden" id="is_coach" name="is_coach" value="<?php echo $is_coach; ?>"/>
<input type="text" id="comp_name" name="company_name" class="required" value="Company Name" onblur="if(this.value=='')this.value='Company Name'" onfocus="if(this.value=='Company Name')this.value=''"/>
<input type="text" id="position" name="position_available" class="required" value="Position Available" onblur="if(this.value=='')this.value='Position Available'" onfocus="if(this.value=='Position Available')this.value=''"/>
<input type="text" id="job_url" name="job_url" class="url" value="Job Details URL" onblur="if(this.value=='')this.value='Job Details URL'" onfocus="if(this.value=='Job Details URL')this.value=''"/>
<input type="text" id="job_location" name="location" value="Job Location i.e. City/State/Country" onblur="if(this.value=='')this.value='Job Location i.e. City/State/Country'" onfocus="if(this.value=='Job Location i.e. City/State/Country')this.value=''"/>
<input type="submit" value="CREATE" onClick="return cardsubmit();" class="submit"/>
</div>
<?php if(isset($is_popup)){?>
<div class="browse_job" style="margin: 0 35px 10px;float:left;">
<a href="<?php echo SITE_URL;?>/jobsearch/index" class="search_job">browse jobs</a>
</div>
<div class="plugin" style="top:10px;"><a href="javascript:installPlugin()" onmouseout="hideTooltip();" onmouseover="showTooltip(event,'Install the Job Card Plugin to capture and store job postings from across the Internet. When you visit a webpage, simply click on the ‘SP’ icon on your Firefox browser and enter the details. Once you’re done collecting job postings, click transfer to SnagPad and start applying. Stay organized on SnagPad!');"><?php echo $this->Html->image('plugin_img.png');?></a></div>
<?php } ?>
<div class="show_jobs">
<?php //echo $this->Html->image('and_img.jpg');?>
<section class="heading_row" style="border:0px; padding:0 0 7px 0">
<span class="col1" style="font-size:18px; line-height:22px; color: #F26E01; font-weight:bold; text-align:left;">Suggested Job Postings</span>
</section>
<?php if(!empty($job_indeed)){ ?>
<div class="nano">	
<section class="job_search_section">
<?php $i=0; foreach($job_indeed as $result){ if($i==40)break;
	 if($result['count']!='1'){ ?>
 <section class="heading_row" style="border:0px; padding:3px 0 3px 0">
 <?php if($result['resource_id']=='3'){ 
 if(isset($result['Company']) && !is_array($result['Company']) && $result['Company']!=''){ $i++;?>
 <span class="col2" style="font-size:14px; line-height:16px; text-align:left;width:155px;padding:0" ><a href="javascript://" onclick="loadJobPopup('<?php echo SITE_URL;?>/jobsearch/job_details','<?php echo $result['CountryCode'];?>','<?php echo $result['City']; ?>','<?php echo $result['StateCode']; ?>','<?php echo $result['JobDetailsURL'];?>','<?php echo $result['JobTitle']; ?>','<?php echo $result['Company'];?>','<?php echo $result['id'];?>','<?php echo $result['resource_id'];?>');"><?php echo $result['JobTitle'];?></a></span>
         <span class="col3" style="font-size:14px; line-height:16px; text-align:left;width:130px;"><?php echo $result['Company'];?></span>                  
          <span class="col5"  style="width:109px" id="div_<?php echo $result['resource_id']."_".$result['id'];?>"><?php if($result['count']=='1') echo "<a href='javascript://' class='snagged'>Snagged</a>"; else{ echo "<a style='width:109px; font-size:14px; line-height:16px;' href='javascript://' onclick='setVal(\"".urlencode($result['JobTitle'])."\",\"".urlencode($result['Company'])."\",\"".urlencode($result['City'])."\",\"".urlencode($result['StateCode'])."\",\"".urlencode($result['CountryCode'])."\",\"".urlencode($result['JobDetailsURL'])."\",\"$result[resource_id]\",\"$result[id]\",\"$result[usertype]\");'>CREATE A JOB CARD</a>";} ?></span>          
        <?php } } else { if((isset($result['company']) && is_array($result['company']) && $result['company']['name']!='') || (!is_array($result['company']) && $result['company']!='')) { $i++;  ?>
         <span class="col2" style="font-size:14px; line-height:16px; text-align:left;width:155px;padding:0" ><a href="javascript://" onclick="loadJobPopup('<?php echo SITE_URL;?>/jobsearch/job_details','<?php echo $result['country'];?>','<?php echo $result['city']; ?>','<?php echo $result['state']; ?>','<?php echo $result['url'];?>','<?php echo $result['jobtitle']; ?>','<?php echo $result['company'];?>','<?php if($result['count']!='1') echo $result['id'];?>','<?php echo $result['resource_id'];?>');"><?php echo $result['jobtitle'];?></a></span>
        <span class="col3" style="font-size:14px; line-height:16px; text-align:left;width:130px;"><?php if(isset($result['company']) && is_array($result['company']) && $result['company']['name']!='') echo $result['company']['name'];elseif(!is_array($result['company']) && $result['company']!='') echo $result['company']; else echo "NA";?></span>       
        <span class="col5" style="width:109px" id="div_<?php echo $result['resource_id']."_".$result['id'];?>"><?php if($result['count']=='1') echo "<a href='javascript://' class='snagged'>Snagged</a>"; else{ if($result['resource_id']==1) echo "<a style='width:109px; font-size:14px; line-height:16px;' href='javascript://' onclick='setVal(\"".urlencode($result['jobtitle'])."\",\"".urlencode($result['company'])."\",\"".urlencode($result['city'])."\",\"".urlencode($result['state'])."\",\"".urlencode($result['country'])."\",\"".urlencode($result['url'])."\",\"$result[resource_id]\",\"$result[id]\",\"$result[usertype]\");'>CREATE A JOB CARD</a>"; 
		else 
		echo "<a style='width:109px; font-size:14px; line-height:16px;' href='javascript://' onclick='setVal(\"".urlencode($result['jobtitle'])."\",\"".urlencode($result['company']['name'])."\",\"".urlencode($result['city'])."\",\"\",\"".urlencode($result['country'])."\",\"".urlencode($result['url'])."\",\"$result[resource_id]\",\"$result[id]\",\"$result[usertype]\");'>CREATE A JOB CARD</a>";		
		} ?>
        </span>
        
  <?php } } ?>
  </section>
  <?php } }  ?>
</section>
</div>
<?php if($this->Session->check('Client')){ ?>
<div style="color: #767676; font-size:11px; font-weight:bold;padding:10px 0px;">To customize your suggested job postings complete your <a href="<?php echo SITE_URL; ?>/jobcards/profileView" style="color:#00F">profile</a>.</div>
<?php } ?>
<?php } else{ ?>
<div style="color: #767676; font-size:11px; font-weight:bold;padding:10px 0px;">No Job Postings found. <?php if($this->Session->check('Client')){ ?>To customize your suggested job postings complete your <a href="<?php echo SITE_URL; ?>/jobcards/profileView" style="color:#00F">profile</a>.<?php } ?></div>
<?php } ?>

</div>
<?php if(!isset($is_popup)){?>
<div class="browse_job">
<a href="<?php echo SITE_URL;?>/jobsearch/index" class="search_job">browse jobs</a>
</div>
<?php if($this->Session->check('Client')){ if($plugin==0){ ?>
<div class="plugin"><a href="javascript:installPlugin()" onmouseout="hideTooltip();" onmouseover="showTooltip(event,'Install the Job Card Plugin to capture and store job postings from across the Internet. When you visit a webpage, simply click on the ‘SP’ icon on your Firefox browser and enter the details. Once you’re done collecting job postings, click transfer to SnagPad and start applying. Stay organized on SnagPad!');"><?php echo $this->Html->image('plugin_img.png');?></a></div>
<?php } ?>
<?php } } ?>
</form>
</section>

<script type="text/javascript">
function add_suggested_card(jobkey,url,title,company,city,state,country,is_coach_card)
{
	$('.add_jobcard').html('<div style="height:200px; margin-top:150px;text-align:center;"><?php echo $this->Html->image('loading.gif');?></div>');
	var clientid=$('#clientid').val();
	
	
		
	add_card_status=0;
	$.post('<?php echo SITE_URL; ?>/jobcards/add_suggested_card',{jobkey:jobkey,url:url,title:title,company:company,clientid:clientid,city:city,state:state,country:country,is_coach_card:is_coach_card},function(data){
			if(is_coach_card==0)
			{
				get_strategy_meter();
			}
			//show_top_tab(clientid);
			show_jobcards(clientid);			
			show_add_jobcard(is_coach_card);
			
			
	});	
	
}
 function setVal(position,company,city,state,country,job_url,jbtype,id,usertyp)
    {
		 add_card_status=0; 					
	    var clientid=$('#clientid').val();		
		var is_coach_card=$('#is_coach').val();
		$('.add_jobcard').html('<div style="height:200px; margin-top:150px;text-align:center;"><?php echo $this->Html->image('loading.gif');?></div>'); 
		//if(usertyp==2)
		//{
			//loadJobPopup('<?php echo SITE_URL; ?>/jobsearch/get_all_clients',country,city,state,job_url,position,company,id);
		//}else{
			disablePopup();			
			  
            $.post('<?php echo SITE_URL; ?>/jobsearch/jobAdd',{position_available:position,company_name:company,city:city,state:state,country:country,job_url:job_url,other_web_job_id:id,resource_id:jbtype,is_coach_card:is_coach_card,clientid:clientid},function(data){ 
			//
			if(is_coach_card==0)
			{
				get_strategy_meter();
			}
			//show_top_tab(clientid);
			show_jobcards(clientid);			
			show_add_jobcard(is_coach_card);
      	  });
		//}
    }
	
function cardsubmit()
{
 	var clientid=$('#clientid').val();
	var job_url=$('#job_url').val();
	var loc=$('#job_location').val();
	$('#job_url').val($('#job_url').val().trim());
	if(job_url=='Job Details URL')
	{
		$('#job_url').val('');
	}else{
		
		job_url=job_url.trim();
		var is_http=job_url.substring(0,4);
		//alert(is_http);
		if(is_http.toLowerCase()!='http'){
			job_url='http://'+job_url;	
			$('#job_url').val(job_url);
		}	
		
	}
	if(loc=='Job Location')
	{
		$('#job_location').val('');
	}
	
	$('#jobcardForm').validate({
		submitHandler: function(form) {
			var name=$('#comp_name').val();
			var pos=$('#position').val();
			if(name=='Company Name')
			{ $('#error').html('Please enter company name.'); 
				$('#error').show();
				setTimeout(function(){$('#error').fadeOut('slow')},5000);
			}
			else if(pos=='Position Available')
			{ $('#error').html('Please enter position available.'); 
				$('#error').show();
				setTimeout(function(){$('#error').fadeOut('slow')},5000);
	
			}else {
				disablePopup();	
					if(loc=='Job Location i.e. City/State/Country')
						$('#job_location').val('Job Location i.e City/State/Country');
					var jobcardForm=$('#jobcardForm').serialize();
						$('.add_jobcard').html('<div style="height:200px; margin-top:150px;text-align:center;"><?php echo $this->Html->image('loading.gif');?></div>');
				$.post("<?php echo SITE_URL;?>/jobcards/save_new_card",jobcardForm,function(data){
					$('.add_jobcard').slideUp();
					add_card_status=0;
					var is_coach_card=$('#is_coach').val();
					if(is_coach_card==0)
					{
						get_strategy_meter();
					}
						//show_top_tab(clientid);
						show_jobcards(clientid);
						
				});
			}
			
		return false;
		}
			
	});	
	
	
}
</script>