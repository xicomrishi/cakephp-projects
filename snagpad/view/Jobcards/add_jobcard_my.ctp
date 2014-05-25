<?php echo $this->Html->script('cufon');?>
<div id="error" class="errmassge"></div> 
<section class="top_sec add_job_cart">
<form id="jobcardForm" name="jobcardForm" method="post" action="">
<div class="contact_left">
<h3>Enter Job Detail</h3>
<input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid; ?>"/>
<input type="text" id="comp_name" name="company_name" class="required" value="Company Name" onblur="if(this.value=='')this.value='Company Name'" onfocus="if(this.value=='Company Name')this.value=''"/>
<input type="text" id="position" name="position_available" class="required" value="Position Available" onblur="if(this.value=='')this.value='Position Available'" onfocus="if(this.value=='Position Available')this.value=''"/>
<input type="text" id="job_url" name="job_url" class="url" value="Job Details URL" onblur="if(this.value=='')this.value='Job Details URL'" onfocus="if(this.value=='Job Details URL')this.value=''"/>
<input type="text" id="job_location" name="location" value="Job Location" onblur="if(this.value=='')this.value='Job Location'" onfocus="if(this.value=='Job Location')this.value=''"/>
<input type="submit" value="CREATE" onClick="return cardsubmit();" class="submit"/>
</div>

<div class="browse_job">
<?php echo $this->Html->image('and_img.jpg');?>
<a href="#" class="search_job">browse jobs</a>
</div>
<div class="plugin"><a href="#"><?php echo $this->Html->image('plugin_img.png');?></a></div>
</form>
</section>
<script type="text/javascript">
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
				$.post("<?php echo SITE_URL;?>/jobcards/save_new_card",$('#jobcardForm').serialize(),function(data){
					$('.add_jobcard').slideUp();
					//$('.add_jobcard').remove();
					show_top_tab(clientid);
					show_jobcards(clientid);	
				});
			}
			
		return false;
		}
			
	});	
	
	
}
</script>