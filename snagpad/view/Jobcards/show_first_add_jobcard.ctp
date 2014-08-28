<div id="error" class="errmassge1"></div> 
<section class="top_sec add_job_cart" style="width:690px;">
<form id="jobcardForm" name="jobcardForm" method="post" action=""  style="position:relative">
<div class="contact_left">
<h3 style="width:113px; float:left;">Enter Job Detail</h3>&nbsp;<a title="Use this to manually add a job opportunity to your 'Pad' that you've found through a referral, posting on a bulletin board, newspaper or some other source other than the internet."><?php echo $this->Html->image('ico_information.png',array('escape'=>false,'alt'=>'','style'=>array('margin-top:4px;')));?></a>
<input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid; ?>"/>
<input type="text" id="comp_name" name="company_name" class="required" value="Company Name" onblur="if(this.value=='')this.value='Company Name'" onfocus="if(this.value=='Company Name')this.value=''"/>
<input type="text" id="position" name="position_available" class="required" value="Position Available" onblur="if(this.value=='')this.value='Position Available'" onfocus="if(this.value=='Position Available')this.value=''"/>
<input type="text" id="job_url" name="job_url" class="url" value="Job Details URL" onblur="if(this.value=='http://')this.value='Job Details URL'" onfocus="if(this.value=='Job Details URL')this.value='http://'"/>
<input type="text" id="job_location" name="location" value="Job Location i.e. City/State/Country" onblur="if(this.value=='')this.value='Job Location i.e. City/State/Country'" onfocus="if(this.value=='Job Location i.e. City/State/Country')this.value=''"/>
<input type="submit" value="CREATE" onClick="return cardsubmit();" class="submit"/>
</div>

<div class="show_jobs" style="margin:0 0 0 35px">
<?php //echo $this->Html->image('and_img.jpg');?>
<section class="heading_row" style="border:0px; padding:0 0 7px 0">
<span class="col1" style="font-size:14px; line-height:16px; color: #F26E01; font-weight:bold; text-align:left;">Suggested Job Postings</span>
</section>
<?php if(!empty($job_indeed)){ ?>
<section class="job_search_section">
<?php for($i=0;$i<5;$i++){ ?>
<section class="heading_row" style="border:0px; padding:0 0 7px 0">
<span class="col1" style="font-size:14px; line-height:16px; text-align:left;" onclick="loadJobPopup('<?php echo SITE_URL;?>/jobsearch/job_details','<?php echo $job_indeed[$i]['country'];?>','<?php echo $job_indeed[$i]['city']; ?>','<?php echo $job_indeed[$i]['state']; ?>','<?php echo $job_indeed[$i]['url'];?>','<?php echo $job_indeed[$i]['jobtitle']; ?>','<?php echo $job_indeed[$i]['company'];?>');"><?php echo $job_indeed[$i]['jobtitle'];?></span>
<span class="col1" style="font-size:14px; line-height:16px; text-align:left;"><?php echo $job_indeed[$i]['company']; ?></span>
<span class="col5" style="width:111px"><a style="width:111px; font-size:14px; line-height:16px;" href="javascript://" onclick="add_suggested_card('<?php echo $job_indeed[$i]['jobkey'];?>','<?php echo $job_indeed[$i]['url'];?>','<?php echo $job_indeed[$i]['jobtitle']; ?>','<?php echo $job_indeed[$i]['company']; ?>','<?php echo $job_indeed[$i]['city']; ?>','<?php echo $job_indeed[$i]['state']; ?>','<?php echo $job_indeed[$i]['country']; ?>');" class="suggested_card">CREATE A JOB CARD</a></span>
</section>
<?php } ?>
</section>
<div style="color: #767676; font-size:11px; font-weight:bold; padding-bottom:-7px;">To customize your suggested job postings complete your <a href="<?php echo SITE_URL; ?>/jobcards/profileView" style="color:#00F">profile</a>.</div>
<?php }else{ ?>
<div style="color: #767676; font-size:11px; font-weight:bold; padding-bottom:-7px;">No Job Postings found. To customize your suggested job postings complete your <a href="<?php echo SITE_URL; ?>/jobcards/profileView" style="color:#00F">profile</a>.</div>
<?php } ?>
</div>

</form>
<div class="browse_job" style="margin: 10px -41px 67px;">
<a href="<?php echo SITE_URL;?>/jobsearch/index" class="search_job">browse jobs</a>
</div>
<div class="plugin"><a href="<?php echo SITE_URL;?>/snagpad.xpi"><?php echo $this->Html->image('plugin_img.png');?></a></div>
</section>
<script type="text/javascript">
$(document).ready(function(e) {
	// $('.contact_left a').tooltip();
     $("html, body").animate({ scrollTop: 0 }, 600);
	
});

function add_suggested_card(jobkey,url,title,company,city,state,country)
{
	$('.add_jobcard').html('<div style="height:200px; margin-top:150px;text-align:center;"><?php echo $this->Html->image('loading.gif');?></div>');
	var clientid=$('#clientid').val();
	add_card_status=0;
	$.post('<?php echo SITE_URL; ?>/jobcards/add_suggested_card',{jobkey:jobkey,url:url,title:title,company:company,clientid:clientid,city:city,state:state,country:country},function(data){
			
			get_strategy_meter();
			show_top_tab(clientid);
			show_jobcards(clientid);	
			//show_add_jobcard();
			disablePopup();
			
	});	
	
}

function cardsubmit()
{
 	var clientid=$('#clientid').val();
	var job_url=$('#job_url').val();
	var loc=$('#job_location').val();
	if(job_url=='Job Details URL')
	{
		$('#job_url').val('');
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
			}
			else if(pos=='Position Available')
			{ $('#error').html('Please enter position available.'); 
				$('#error').show();
			}else {
						if(loc=='Job Location i.e. City/State/Country')
							$('#job_location').val('Job Location i.e City/State/Country');
				$.post("<?php echo SITE_URL;?>/jobcards/save_new_card",$('#jobcardForm').serialize(),function(data){
					disablePopup();
					
					get_strategy_meter();
					show_top_tab(clientid);
					show_jobcards(clientid);	
				});
			}
			
		return false;
		}
			
	});	
	
	
}
</script>