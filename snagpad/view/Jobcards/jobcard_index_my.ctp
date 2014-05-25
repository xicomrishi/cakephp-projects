<?php echo $this->Html->script('cufon');?>
<section class="main_section">
  <span class="odds">ODDS METER </span>
<?php $i=1;
 foreach($cards as $card) { ?>  
  <div class="row">
  <div class="coll">
 <?php if($card['Card']['column_status']=='O') { ?> 
  <div class="card_box <?php echo 'card_'.$card['Card']['id'];?>">
  <div class="card">
  <strong><?php echo $card['Card']['company_name']; ?></strong>
  <h3><?php echo $card['Card']['position_available'];?></h3>

<div class="text"><?php echo $this->Html->image('bg_1.png',array('escape'=>false,'alt'=>''));?></a><span onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');">Apply</span></div>
  </div>
  
  <ul class="icon"> 
  <li><?php echo $this->Html->link($this->Html->image('social_samll_icon1.jpg', array('alt' => '', 'border' => '0')), '#', array('escape' => false)); ?></li>
   <li><?php echo $this->Html->link($this->Html->image('social_samll_icon2.jpg', array('alt' => '', 'border' => '0')), '#', array('escape' => false)); ?></li>
    <li class="last"><?php echo $this->Html->link($this->Html->image('social_samll_icon3.jpg', array('alt' => '', 'border' => '0')), '#', array('escape' => false)); ?></li>
  </ul>
  
  </div>
  <ul class="sub_tab">
  <li><a href="#"></a></li>
  <li><a href="#"></a></li>
  <li class="active "><a href="#" class="bg_2">JOB CARD DETAILS</a></li>
  <li class="off"><a href="#"></a></li>
  <li class="off"><a href="#"></a></li>
  <li class="off"><a href="#"></a></li>
  </ul>
  <?php } ?>
   </div>
  <div class="coll">
   <?php if($card['Card']['column_status']=='A') { ?> 
   <div class="card_box">
      <div class="card">
      <strong><?php echo $card['Card']['company_name']; ?></strong>
      <h3><?php echo $card['Card']['position_available'];?></h3>
      <div class="text"><?php echo $this->Html->image('bg_1.png',array('escape'=>false,'alt'=>''));?></a><span onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');">Set Interview</span></div>
    
    
      </div>
      </div>
     <ul class="sub_tab" onclick="show_job_details('<?php echo $card['Card']['id']; ?>','<?php echo $i;?>');">
  <li><a href="#"></a></li>
  <li><a href="#"></a></li>
  <li class="active "><a href="#" class="bg_2">JOB CARD DETAILS</a></li>
  <li class="off"><a href="#"></a></li>
  <li class="off"><a href="#"></a></li>
  <li class="off"><a href="#"></a></li>
  </ul>  
   <?php } ?>
  </div>
  <div class="coll">
   <?php if($card['Card']['column_status']=='S') { ?> 
   <div class="card_box">
      <div class="card">
      <strong><?php echo $card['Card']['company_name']; ?></strong>
      <h3><?php echo $card['Card']['position_available'];?></h3>
   <div class="text"><?php echo $this->Html->image('bg_1.png',array('escape'=>false,'alt'=>''));?></a><span onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');">Interview</span></div>
    
      </div>
      </div>
       <ul class="sub_tab" onclick="show_job_details('<?php echo $card['Card']['id']; ?>','<?php echo $i;?>');">
  <li><a href="#"></a></li>
  <li><a href="#"></a></li>
  <li class="active "><a href="#" class="bg_2">JOB CARD DETAILS</a></li>
  <li class="off"><a href="#"></a></li>
  <li class="off"><a href="#"></a></li>
  <li class="off"><a href="#"></a></li>
  </ul>
   <?php } ?>
  </div>
  <div class="coll">
   <?php if($card['Card']['column_status']=='I') { ?> 
   <div class="card_box">
      <div class="card">
      <strong><?php echo $card['Card']['company_name']; ?></strong>
      <h3><?php echo $card['Card']['position_available'];?></h3>
   <div class="text"><?php echo $this->Html->image('bg_1.png',array('escape'=>false,'alt'=>''));?></a><span onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');">Verbal Job Offer</span></div>
    
      </div>
      </div>
       <ul class="sub_tab" onclick="show_job_details('<?php echo $card['Card']['id']; ?>','<?php echo $i;?>');">
  <li><a href="#"></a></li>
  <li><a href="#"></a></li>
  <li class="active "><a href="#" class="bg_2">JOB CARD DETAILS</a></li>
  <li class="off"><a href="#"></a></li>
  <li class="off"><a href="#"></a></li>
  <li class="off"><a href="#"></a></li>
  </ul>
   <?php } ?>
  </div>
  <div class="coll">
  <?php if($card['Card']['column_status']=='V') { ?> 
   <div class="card_box">
      <div class="card">
      <strong><?php echo $card['Card']['company_name']; ?></strong>
      <h3><?php echo $card['Card']['position_available'];?></h3>
    <div class="text"><?php echo $this->Html->image('bg_1.png',array('escape'=>false,'alt'=>''));?></a><span onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');">Job</span></div>
    
      </div>
      </div>
       <ul class="sub_tab" onclick="show_job_details('<?php echo $card['Card']['id']; ?>','<?php echo $i;?>');">
  <li><a href="#"></a></li>
  <li><a href="#"></a></li>
  <li class="active "><a href="#" class="bg_2">JOB CARD DETAILS</a></li>
  <li class="off"><a href="#"></a></li>
  <li class="off"><a href="#"></a></li>
  <li class="off"><a href="#"></a></li>
  </ul>
   <?php } ?></div>
  <div class="coll">
  <?php if($card['Card']['column_status']=='J') { ?> 
   <div class="card_box">
      <div class="card">
      <strong><?php echo $card['Card']['company_name']; ?></strong>
      <h3><?php echo $card['Card']['position_available'];?></h3>
      <div class="text"><?php echo $this->Html->image('bg_1.png',array('escape'=>false,'alt'=>''));?></a><span onclick="show_strategy('<?php echo $card['Card']['id'];?>','<?php echo $i;?>');">Complete</span></div>
      </div>
      </div>
       <ul class="sub_tab" onclick="show_job_details('<?php echo $card['Card']['id']; ?>','<?php echo $i;?>');">
  <li><a href="#"></a></li>
  <li><a href="#"></a></li>
  <li class="active "><a href="#" class="bg_2">JOB CARD DETAILS</a></li>
  <li class="off"><a href="#"></a></li>
  <li class="off"><a href="#"></a></li>
  <li class="off"><a href="#"></a></li>
  </ul>
   <?php } ?>
  </div>
 <div class="meter">
 <div class="bar_bg"><span class="bar orange"></span></div>
 </div>
 
<section class="content_box <?php echo 'content_'.$i; ?>" style="display:none;"></section> 
  </div>
<?php $i++; } ?>
   
  
  <div class="row">
  <div class="meter spacer">
  <div class="text_box">
  <?php echo $this->Html->image('text.png',array('escape'=>false,'alt'=>''));?>

  <strong>72%;</strong>  </div>
  
 <div class="bar_bg"><span class="bar green"></span></div>
 </div>
  
  
 
  </div>
  
  </section>
  
<script type="text/javascript">
/*$(document).ready(function(){
	$(".card").hover(function(){
  $(".text").animate({left:'+=30px'});
  	//$(this).
  },function(){
  //$(".text").animate({left:'-=30px'});
});
	
});*/

function show_job_details(card_id,row)
{	$('.content_box').hide();
	$('.content_'+row).html('<div style="height:100px; margin-top:100px; margin-left:300px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$('.content_'+row).show();
	
	$.post('<?php echo SITE_URL; ?>/jobcards/job_details','cardid='+card_id,function(data){
		//$('.row_'+row).append(data);
		$('.content_'+row).html(data);
				
	});
}
function show_strategy(card_id,row)
{
	$('.content_box').hide();
	$('.content_'+row).html('<div style="height:100px; margin-top:100px; margin-left:300px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$('.content_'+row).show();	
	$.post('<?php echo SITE_URL;?>/strategies/checklist','card_id='+card_id,function(data){
			$('.content_'+row).html(data);
		});
}

</script> 