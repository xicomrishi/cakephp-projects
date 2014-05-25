<!--<span class="job_card_btn"><a href="javascript://" onclick="show_add_jobcard();">+ CREATE JOB CARD</a></span>-->
<input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>


<section class="add_jobcard"></section>
<section class="tab">

</section>

<section id="inner_body_container1">
  </section>
  
<div id="jsbPopup"></div>
<div id="backgroundPopup"></div>
<input type="hidden" id="card_id" value="<?php echo $card_id; ?>"/>

<script language="javascript">

$(document).ready(function(e) {
	 
	var clientid=$('#clientid').val();
	var card_id=$('#card_id').val();
	show_temp_jobcards(clientid);
	show_top_tab(clientid);
	
		
		
	//setTimeout(function(){ show_job_details(card_id,card_id);},3500);
	   
});

function show_top_tab(clientid)
{
	$.post('<?php echo SITE_URL;?>/jobcards/index_top_tab','clientid='+clientid,function(data){
		$(".tab").html(data);
	});
}



function show_jobcards(clientid)
{
	$.post('<?php echo SITE_URL;?>/jobcards/index_jobcards','clientid='+clientid,function(data){
		$("#inner_body_container1").html(data);
	});
}

function show_add_jobcard()
{
	//alert(add_card_status);
	if(add_card_status==1)
	{
		$(".add_jobcard").hide();
		add_card_status=0;		
	}else{
	add_card_status=1;	
	$(".add_jobcard").show();
	var id=$('#clientid').val();
	//alert(id);
	$.post("<?php echo SITE_URL; ?>/jobcards/add_jobcard",'clientid='+id,function(data){	
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
function show_job_details(card_id,row)
{	$('.row').removeClass('active');
	$('.sub_tab').hide();
		disablePopup();
	$('.content_box').html('');
	$('.content_box').hide();
	$('.job_details_arrow').hide();
	//$('#sub_tab_'+row).addClass('active');
	$('.row_'+card_id).addClass('active');
	$('.info_tab_'+card_id).show();
	$('.content_'+card_id).html('<div style="height:100px; margin-top:100px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$('.content_'+card_id).show();
	var show_tab=0;
	var net=$('#net_'+card_id).val();
	if(net==1){ show_tab='1'; 
	}else if(net==2){ show_tab='2'; 
	}else{ 
		show_tab='0'; 
	}
	$.post('<?php echo SITE_URL; ?>/jobcards/job_details',{cardid:card_id,show_tab:show_tab},function(data){
		//$('.row_'+row).append(data);
		$('.content_'+card_id).html(data);
		$('#net_'+card_id).val('0');
				
	});
	$("html, body").animate({ scrollTop: $('.row_'+card_id).offset().top - 80}, 100);	
}

function show_temp_jobcards(clientid)
{
	var card_id=$('#card_id').val();
	$.post('<?php echo SITE_URL;?>/jobcards/index_jobcards','clientid='+clientid,function(data){
		$("#inner_body_container1").html(data);
		show_job_details(card_id,card_id);
		
	});
	
}


</script>  