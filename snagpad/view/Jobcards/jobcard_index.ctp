<section class="main_section">
  <span class="odds">ODDS METER </span>
  <input type="hidden" id="is_client" value="<?php if($this->Session->check('Client')){echo '1';}else{ echo '0';}?>"/>
<?php 
	if(!empty($cards)){ 
	$i=1;
 foreach($cards as $card) { ?>  
  <div class="row row_<?php echo $card['Card']['id'];?>">
  <input type="hidden" id="net_<?php echo $card['Card']['id'];?>" value="0"/>
  <div class="coll">
 <?php if($card['Card']['column_status']=='O') { ?> 
  <div class="card_box <?php echo 'card_'.$card['Card']['id'];?>">
  <div class="card" onclick="show_job_details('<?php echo $card['Card']['id']; ?>','<?php echo $i;?>');">
  <strong id="company_name_<?php echo $card['Card']['id'];?>"><?php $c_len=strlen($card['Card']['company_name']); if($c_len>14){ $c_name=substr($card['Card']['company_name'], 0, 14);
  				echo $c_name."..."; }else{ echo $card['Card']['company_name'];} ?></strong>
  <h3 id="pos_name_<?php echo $card['Card']['id'];?>"><?php  $c_pos_len=strlen($card['Card']['position_available']); if($c_pos_len>18){ $c_pos=substr($card['Card']['position_available'], 0, 17); echo $c_pos."...";}else{ echo $card['Card']['position_available'];} ?></h3>


  </div>
  <div class="text" <?php if($card['Card']['show_exclaim']=='0'||$this->Session->check('Client')){ ?> style=" background:none;"<?php } ?>><?php echo $this->Html->image('bg_1.png',array('escape'=>false,'alt'=>''));?></a><span onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>','O');" class="display_content">Apply</span></div>
  
  <ul class="icon"> 
  <li><a href="javascript://" onclick="show_card_cont('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon1.jpg',array('escape'=>false));?></a></li>
   <li><a href="javascript://" onclick="move_to_recycle('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon2.jpg',array('escape'=>false));?></a></li>
    <li class="last"><a href="javascript://" onclick="show_card_net('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon3.jpg',array('escape'=>false));?></a></li>
  </ul>
  <?php if($card['Card']['added_by']=='1'){?>
  <span class="strip"><?php echo $this->Html->image('coach_ribbon.png');?></span>
  <?php }?>
  </div>
 
 
 
  <?php } ?>
   </div>
  <div class="coll">
   <?php if($card['Card']['column_status']=='A') { ?> 
   <div class="card_box">
      <div class="card" onclick="show_job_details('<?php echo $card['Card']['id']; ?>','<?php echo $i;?>');">
      <strong id="company_name_<?php echo $card['Card']['id'];?>"><?php $c_len=strlen($card['Card']['company_name']); if($c_len>14){ $c_name=substr($card['Card']['company_name'], 0, 14);
  				echo $c_name."..."; }else{ echo $card['Card']['company_name'];} ?></strong>
  <h3 id="pos_name_<?php echo $card['Card']['id'];?>"><?php  $c_pos_len=strlen($card['Card']['position_available']); if($c_pos_len>18){ $c_pos=substr($card['Card']['position_available'], 0, 17); echo $c_pos."...";}else{ echo $card['Card']['position_available'];} ?></h3>

     
    
    
      </div>
       <div class="text"<?php if($card['Card']['show_exclaim']=='0'||$this->Session->check('Client')){ ?> style=" background:none;"<?php } ?>><?php echo $this->Html->image('bg_1.png',array('escape'=>false,'alt'=>''));?></a><span onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>','A');" class="display_content">Set Interview</span></div>
        <ul class="icon"> 
   <li><a href="javascript://" onclick="show_card_cont('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon1.jpg',array('escape'=>false));?></a></li>
   <li><a href="javascript://" onclick="move_to_recycle('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon2.jpg',array('escape'=>false));?></a></li>
    <li class="last"><a href="javascript://" onclick="show_card_net('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon3.jpg',array('escape'=>false));?></a></li>
    
  </ul>

      <?php if($card['Card']['added_by']=='1'){?>
  <span class="strip"><?php echo $this->Html->image('coach_ribbon.png');?></span>
  <?php }?>
       
      </div>
   
   <?php } ?>
  </div>
  <div class="coll">
   <?php if($card['Card']['column_status']=='S') { ?> 
   <div class="card_box">
      <div class="card" onclick="show_job_details('<?php echo $card['Card']['id']; ?>','<?php echo $i;?>');">
      <strong id="company_name_<?php echo $card['Card']['id'];?>"><?php $c_len=strlen($card['Card']['company_name']); if($c_len>14){ $c_name=substr($card['Card']['company_name'], 0, 14);
  				echo $c_name."..."; }else{ echo $card['Card']['company_name'];} ?></strong>
  <h3 id="pos_name_<?php echo $card['Card']['id'];?>"><?php  $c_pos_len=strlen($card['Card']['position_available']); if($c_pos_len>18){ $c_pos=substr($card['Card']['position_available'], 0, 17); echo $c_pos."...";}else{ echo $card['Card']['position_available'];} ?></h3>

  
    
      </div>
       <div class="text" <?php if($$card['Card']['show_exclaim']=='0'||$this->Session->check('Client')){ ?> style=" background:none;"<?php } ?>><?php echo $this->Html->image('bg_1.png',array('escape'=>false,'alt'=>''));?></a><span onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>','S');" class="display_content">Interview</span></div>
       
        <ul class="icon"> 
  <li><a href="javascript://" onclick="show_card_cont('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon1.jpg',array('escape'=>false));?></a></li>
   <li><a href="javascript://" onclick="move_to_recycle('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon2.jpg',array('escape'=>false));?></a></li>
    <li class="last"><a href="javascript://" onclick="show_card_net('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon3.jpg',array('escape'=>false));?></a></li>
    
  </ul>

      <?php if($card['Card']['added_by']=='1'){?>
  <span class="strip"><?php echo $this->Html->image('coach_ribbon.png');?></span>
  <?php }?>
      </div>
      
   <?php } ?>
  </div>
  <div class="coll">
   <?php if($card['Card']['column_status']=='I') { ?> 
   <div class="card_box">
      <div class="card" onclick="show_job_details('<?php echo $card['Card']['id']; ?>','<?php echo $i;?>');">
      <strong id="company_name_<?php echo $card['Card']['id'];?>"><?php $c_len=strlen($card['Card']['company_name']); if($c_len>14){ $c_name=substr($card['Card']['company_name'], 0, 14);
  				echo $c_name."..."; }else{ echo $card['Card']['company_name'];} ?></strong>
  <h3 id="pos_name_<?php echo $card['Card']['id'];?>"><?php  $c_pos_len=strlen($card['Card']['position_available']); if($c_pos_len>18){ $c_pos=substr($card['Card']['position_available'], 0, 17); echo $c_pos."...";}else{ echo $card['Card']['position_available'];} ?></h3>

   
    
      </div>
      <div class="text" <?php if($card['Card']['show_exclaim']=='0'||$this->Session->check('Client')){ ?> style=" background:none;"<?php } ?>><?php echo $this->Html->image('bg_1.png',array('escape'=>false,'alt'=>''));?></a><span onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>','I');" class="display_content">Verbal Job Offer</span></div>
       <ul class="icon"> 
  <li><a href="javascript://" onclick="show_card_cont('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon1.jpg',array('escape'=>false));?></a></li>
   <li><a href="javascript://" onclick="move_to_recycle('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon2.jpg',array('escape'=>false));?></a></li>
    <li class="last"><a href="javascript://" onclick="show_card_net('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon3.jpg',array('escape'=>false));?></a></li>
    
  </ul>

      <?php if($card['Card']['added_by']=='1'){?>
  <span class="strip"><?php echo $this->Html->image('coach_ribbon.png');?></span>
  <?php }?>

  </ul>
      
      </div>
     
   <?php } ?>
  </div>
  <div class="coll">
  <?php if($card['Card']['column_status']=='V') { ?> 
   <div class="card_box">
      <div class="card" onclick="show_job_details('<?php echo $card['Card']['id']; ?>','<?php echo $i;?>');">
     <strong id="company_name_<?php echo $card['Card']['id'];?>"><?php $c_len=strlen($card['Card']['company_name']); if($c_len>14){ $c_name=substr($card['Card']['company_name'], 0, 14);
  				echo $c_name."..."; }else{ echo $card['Card']['company_name'];} ?></strong>
  <h3 id="pos_name_<?php echo $card['Card']['id'];?>"><?php  $c_pos_len=strlen($card['Card']['position_available']); if($c_pos_len>18){ $c_pos=substr($card['Card']['position_available'], 0, 17); echo $c_pos."...";}else{ echo $card['Card']['position_available'];} ?></h3>

   
    
      </div>
       <div class="text" <?php if($card['Card']['show_exclaim']=='0'||$this->Session->check('Client')){ ?> style=" background:none;"<?php } ?>><?php echo $this->Html->image('bg_1.png',array('escape'=>false,'alt'=>''));?></a><span onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>','V');" class="display_content">Job</span></div>
       
        <ul class="icon"> 
  <li><a href="javascript://" onclick="show_card_cont('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon1.jpg',array('escape'=>false));?></a></li>
   <li><a href="javascript://" onclick="move_to_recycle('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon2.jpg',array('escape'=>false));?></a></li>
    <li class="last"><a href="javascript://" onclick="show_card_net('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon3.jpg',array('escape'=>false));?></a></li>
      </ul>

      <?php if($card['Card']['added_by']=='1'){?>
  <span class="strip"><?php echo $this->Html->image('coach_ribbon.png');?></span>
  <?php }?>

      </div>
      
   <?php } ?></div>
  <div class="coll">
  <?php if($card['Card']['column_status']=='J') { ?> 
   <div class="card_box">
      <div class="card" onclick="show_job_details('<?php echo $card['Card']['id']; ?>','<?php echo $i;?>');">
      <strong id="company_name_<?php echo $card['Card']['id'];?>"><?php $c_len=strlen($card['Card']['company_name']); if($c_len>14){ $c_name=substr($card['Card']['company_name'], 0, 14);
  				echo $c_name."..."; }else{ echo $card['Card']['company_name'];} ?></strong>
  <h3 id="pos_name_<?php echo $card['Card']['id'];?>"><?php  $c_pos_len=strlen($card['Card']['position_available']); if($c_pos_len>18){ $c_pos=substr($card['Card']['position_available'], 0, 17); echo $c_pos."...";}else{ echo $card['Card']['position_available'];} ?></h3>

     
      </div>
       <div class="text" <?php if($card['Card']['show_exclaim']=='0'||$this->Session->check('Client')){ ?> style=" background:none;"<?php } ?>><?php echo $this->Html->image('bg_1.png',array('escape'=>false,'alt'=>''));?></a><span onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>','J');" class="display_content last">Complete</span></div>
        <ul class="icon"> 
  <li><a href="javascript://" onclick="show_card_cont('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon1.jpg',array('escape'=>false));?></a></li>
   <li><a href="javascript://" onclick="move_to_recycle('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon2.jpg',array('escape'=>false));?></a></li>
    <li class="last"><a href="javascript://" onclick="show_card_net('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');"><?php echo $this->Html->image('social_samll_icon3.jpg',array('escape'=>false));?></a></li>
      </ul>

      <?php if($card['Card']['added_by']=='1'){?>
  <span class="strip"><?php echo $this->Html->image('coach_ribbon.png');?></span>
  <?php }?>

       
      </div>
    
   <?php } ?>
  </div>
 <div class="meter" id="meter_<?php echo $card['Card']['id'];?>">
 <div class="bar_bg"><span class="bar orange" id="bar_percent_<?php echo $card['Card']['id']; ?>" style="height:<?php echo $card['Card']['total_points'].'%';?>"></span></div>
 <div class="text_box">
  <?php echo $this->Html->image('text.png',array('escape'=>false,'alt'=>''));?>

  <strong class="total_points_meter" id="tot_points_meter_<?php echo $card['Card']['id']; ?>"><?php echo number_format($card['Card']['total_points'],2);?>%</strong>  </div>
 </div>
  <ul class="sub_tab sub_tab_<?php echo $card['Card']['id'];?>">
  <?php switch($card['Card']['column_status']){ 
  			case 'O':$p='1';
			break;	
			case 'A':$p='2';
			break;	
			case 'S':$p='3';
			break;	
			case 'I':$p='4';
			break;	
			case 'V':$p='5';
			break;	
			case 'J':$p='6';
			break;	
  
 	 }
  ?>
  <li class="<?php if($card['Card']['column_status']=='O') echo 'active';?>" id="sub_tab_<?php echo $card['Card']['id'];?>"><a href="javascript://" class="bg_2" <?php if($p>=1){ ?>onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>','O');"<?php }else{ echo 'style="font-weight:normal"';} ?>>OPPORTUNITY</a></li>
  <li class="<?php if($card['Card']['column_status']=='A') echo 'active';?>" id="sub_tab_<?php echo $card['Card']['id'];?>"><a href="javascript://" class="bg_2" <?php if($p>=2){ ?>onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>','A');"<?php }else{ echo 'style="font-weight:normal"';}  ?>>APPLIED</a></li>
  <li class="<?php if($card['Card']['column_status']=='S') echo 'active';?>" id="sub_tab_<?php echo $card['Card']['id'];?>"><a href="javascript://" class="bg_2" <?php if($p>=3){ ?>onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>','S');"<?php }else{ echo 'style="font-weight:normal"';}  ?>>SET INTERVIEW</a></li>
  <li class="<?php if($card['Card']['column_status']=='I') echo 'active';?>" id="sub_tab_<?php echo $card['Card']['id'];?>"><a href="javascript://" class="bg_2" <?php if($p>=4){ ?>onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>','I');"<?php }else{ echo 'style="font-weight:normal"';}  ?>>INTERVIEW</a></li>
  <li class="<?php if($card['Card']['column_status']=='V') echo 'active';?>" id="sub_tab_<?php echo $card['Card']['id'];?>"><a href="javascript://" class="bg_2" <?php if($p>=5){ ?>onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>','V');"<?php }else{ echo 'style="font-weight:normal"';}  ?>>VERBAL JOB OFFER</a></li>
  <li class="<?php if($card['Card']['column_status']=='J') echo 'active';?>" id="sub_tab_<?php echo $card['Card']['id'];?>"><a href="javascript://" class="bg_2" <?php if($p>=6){ ?>onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>','J');"<?php }else{ echo 'style="font-weight:normal"';}  ?>>JOB</a></li>

  </ul>
  
  <ul class="job_details_arrow info_tab_<?php echo $$card['Card']['id'];?>">
  <li class="<?php if($card['Card']['column_status']=='O') echo 'active';?>" id="info_tab_<?php echo $card['Card']['id'];?>"><a>Job Card Details</a></li>
   <li class="<?php if($card['Card']['column_status']=='A') echo 'active';?>" id="info_tab_<?php echo $card['Card']['id'];?>"><a>Job Card Details</a></li>
    <li class="<?php if($card['Card']['column_status']=='S') echo 'active';?>" id="info_tab_<?php echo $card['Card']['id'];?>"><a>Job Card Details</a></li>
     <li class="<?php if($card['Card']['column_status']=='I') echo 'active';?>" id="info_tab_<?php echo $card['Card']['id'];?>"><a>Job Card Details</a></li>
      <li class="<?php if($card['Card']['column_status']=='V') echo 'active';?>" id="info_tab_<?php echo $card['Card']['id'];?>"><a>Job Card Details</a></li>
       <li class="<?php if($card['Card']['column_status']=='J') echo 'active';?>" id="info_tab_<?php echo $card['Card']['id'];?>"><a>Job Card Details</a></li>
  </ul>
  
<section class="content_box <?php echo 'content_'.$card['Card']['id']; ?>" style="display:none;"></section>

  </div>
<?php $i++; } ?>
   
  <?php }else{  ?>
  	 <div class="row" style="text-align:center; margin-top:100px;">
 		<p><a href="javascript://" onclick="loadPopup('<?php echo SITE_URL; ?>/jobcards/show_first_add_card');">Click here</a> to add a Job Card</p>
	 </div>
  <?php } ?>
  <div class="row">
 
 </div>
  
  
 
 
  
  </section>
  
<script type="text/javascript">
$(document).ready(function(){
	$('.row').removeClass('active');
	$('.sub_tab').hide();
	$('.job_details_arrow').hide();
	
	$('.meter').hover(function(){
		$('.bar').removeClass('orange');
		$('.bar').addClass('green');
		},function(){
			$('.bar').removeClass('green');
		$('.bar').addClass('orange');
			});
		
});
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
function show_strategy(card_id,row,col)
{
	disablePopup();
	$('.row').removeClass('active');
	$('.job_details_arrow').hide();
	$('.sub_tab').hide();
	$('.sub_tab_'+card_id).show();
	$('.content_box').html('');
	$('.content_box').hide();
	$('.row_'+card_id).addClass('active');
	$('.content_'+card_id).html('<div style="height:100px; margin-top:100px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$('.content_'+card_id).show();	
	$.post('<?php echo SITE_URL;?>/strategies/checklist',{card_id:card_id,column:col,client_id:<?php echo $clientid;?>},function(data){
			$('.content_'+card_id).html(data);
		});
	$("html, body").animate({ scrollTop: $('.row_'+card_id).offset().top - 80 }, 100);	
}

function move_to_recycle(card_id,row)
{
	<?php if($this->Session->read('usertype')=='3'){?>
	var is_client=$('#is_client').val();
	if(is_client==1)
	{
	
	answer = confirm("Are you sure you want to move job card to recycle bin?");
		if (answer !=0)
		{
			$.post('<?php echo SITE_URL;?>/jobcards/move_to_recycle',{card_id:card_id},function(data){
			//$('.row_'+row).html('<div style="height:100px; margin-top:100px; margin-left:450px;">Card moved to recycle bin.</div>');
			//setTimeout(function(){$('.row_'+row).slideUp()},3000);
			$('.row_'+card_id).html('');
			
			get_strategy_meter();
			show_top_tab(data);
			$('.row_'+card_id).slideUp();
		});	
		}
		else
		{
		return false;
		}
	}
	<?php }else{?>
	alert("Only client can remove card from his/her job pad");
	<?php }?>
}

function show_card_cont(card_id,row)
{
	$('#net_'+card_id).val('2');
	show_job_details(card_id,row);	
	//setTimeout(function(){show_contact(card_id)},2000);
}

function show_card_net(card_id,row)
{
	$('#net_'+card_id).val('1');
	show_job_details(card_id,row);	
	//setTimeout(function(){show_network(card_id)},2000);
}

function show_contact(card_id)
{	
	//$('li#cont_inf').siblings(this).removeClass('active');
	$('li#cont_inf').addClass('active');
	$('.tab_details').html('<div style="height:100px; margin-top:50px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/show_contact','cardid='+card_id,function(data){
		$('.tab_details').html(data);
		
		});	
}

</script> 