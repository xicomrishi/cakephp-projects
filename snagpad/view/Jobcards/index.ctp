<!--<span class="job_card_btn"><a href="javascript://" onclick="show_add_jobcard();">+ CREATE JOB CARD</a></span>-->
<input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
<input type="hidden" id="first_check" value="<?php echo $first; ?>"/>
<input type="hidden" id="num" value="<?php echo $num; ?>"/>
<section class="add_jobcard"></section>
<section class="tab">

</section>

<section id="inner_body_container1">
  </section>
  
<div id="jsbPopup"></div>
<div id="backgroundPopup"></div>

<script language="javascript">
$(document).ready(function(e) {
 $("html, body").animate({ scrollTop: 0 }, 300);
	var clientid=$('#clientid').val();
	var first=$('#first_check').val();	
	//alert(first);
	add_card_status=0;
	show_top_tab(clientid);
	show_jobcards(clientid);
	<?php if($this->Session->check('Coach')){ ?>
	show_client_details(clientid);
	<?php } ?>
	if(first=='social')
	{
		add_card_status=0;
		loadPopup('<?php echo SITE_URL;?>/users/social_pop');
	}	
	else if(first=='apply')
	{
		add_card_status=0;
		loadPopup('<?php echo SITE_URL;?>/jobcards/show_opp_jobcards');
	}
	
	else if(first==9)
	{
		add_card_status=0;
		show_add_jobcard();	
	}	
	else if(first==1)
	{
		loadPopup('<?php echo SITE_URL;?>/clients/profile_setup');
		}else if(first=='2')
		{
			loadPopup('<?php echo SITE_URL;?>/clients/profile_start_step1');
			}else if(first=='0'){
			
			$.post('<?php echo SITE_URL;?>/jobcards/check_exist_card',{client_id:clientid},function(data){
				disablePopup();
				var data_response=data.split('|');
				if(data_response[0]=='0')
				{	loadPopup('<?php echo SITE_URL;?>/jobcards/show_first_add_card');
					
					
				}else if(data_response[1]=='0'){
					loadPopup('<?php echo SITE_URL;?>/jobcards/show_first_add_card');
					
				}else{
					loadPopup('<?php echo SITE_URL;?>/jobcards/show_opp_jobcards');
					
					}
				
			});
			
		}
});

function show_top_tab(clientid)
{
	$.post('<?php echo SITE_URL;?>/jobcards/index_top_tab','clientid='+clientid,function(data){
		$(".tab").html(data);
	});
}

function show_jobcards(clientid)
{
	$('#inner_body_container1').html('<div style="height:400px; margin-top:200px;text-align:center;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/index_jobcards','clientid='+clientid,function(data){
		$("#inner_body_container1").html(data);
		var cardShow=$('#first_check').val();	
		var cardid=$('#num').val();	
		if(cardShow=='cardShow')
		{			
			show_job_details(cardid,'0');
			$('#first_check').val('');
		}
		check_auto_challenges(clientid);
	});
		
}

function show_add_jobcard(is_coach)
{
	//alert(add_card_status);
	if(is_coach==null)
	{
		is_coach=0;
	}
	if(add_card_status==1)
	{
		$(".add_jobcard").hide();
		add_card_status=0;		
	}else{
	add_card_status=1;	
	$('.add_jobcard').html('<div style="height:200px; margin-top:150px;text-align:center;"><?php echo $this->Html->image('loading.gif');?></div>');
	$(".add_jobcard").show();
	var id=$('#clientid').val();
	
	$.post("<?php echo SITE_URL; ?>/jobcards/add_jobcard/"+is_coach,'clientid='+id,function(data){	
					if(data=='Error')
					{
						$(".add_jobcard").html('You can not add a job card to this client\'s board because the client has not set up their job A skills and Job B criteria');
						}else{
							$(".add_jobcard").html(data);
						}
				});			
	}
}


function show_client_details(clientid)
{
	$.post('<?php echo SITE_URL;?>/jobcards/client_details_for_coach',{clientid:clientid},function(data){
			$('#client_info_coach').html(data);
		});	
}

</script>  