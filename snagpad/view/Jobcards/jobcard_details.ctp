<div id="jsb_CardPopup"></div>
<div id="background_CardPopup"></div>
<input type="hidden" id="card_id" value="<?php echo $cardid;?>"/>
<input type="hidden" id="show_tab" value="<?php echo $show_tab;?>"/>
<ul class="note">
  <li><a href="javascript://" onclick="loadNotesPopup('<?php echo SITE_URL;?>/jobcards/notes_index','<?php echo $cardid;?>','0')">NOTES</a></li>
  <li><a href="javascript://" onclick="show_card_contacts('<?php echo $cardid;?>');">CONTACTS</a></li>
  <li><a href="javascript://" onclick="loadNotesPopup('<?php echo SITE_URL;?>/jobcards/attachments_index','<?php echo $cardid;?>','0')">ATTACHMENTS</a></li>
  <li class="last"><a href="javascript://" onclick="loadNotesPopup('<?php echo SITE_URL;?>/jobcards/notes_index','<?php echo $cardid; ?>','1')">COACH NOTES</a></li>
  </ul>
  
  <ul class="sub_tab2">
 
  <li id="loc"><a href="javascript://" onclick="show_location('<?php echo $cardid;?>');">LOCATION</a></li>
   <li id="cont_inf"><a href="javascript://" onclick="show_contact('<?php echo $cardid;?>');">CONTACT INFO</a></li>
   <li id="pos_inf"><a href="javascript://" onclick="show_position('<?php echo $cardid;?>');">POSITION INFO</a></li>
   <li id="net_inf"><a href="javascript://" onclick="show_network('<?php echo $cardid;?>');">NETWORK INFO</a></li>
   <li id="int_agenda"><a href="javascript://" onclick="show_interview('<?php echo $cardid;?>');">INTERVIEW AGENDA</a></li>
  </ul>
  <div id="inp_error" style="display:none;"></div>
  
  
   <section class="tab_details">
                       
 </section>

  
  <!--<section class="submit_box">
 <?php //echo $this->Html->link($this->Html->image('close_icon.png', array('alt' => $siteDescription, 'border' => '0')), '#', array('escape' => false,'class'=>'close')); ?>
  <section class="submit_left">
  <h4>Determine my interview agenda</h4>
  <p>Put together an agenda that outlines what information you hope to gather from the interview to determine whether this is a job you would like to have.
(Hint: does it have professional development opportunities)?</p>
  </section>
  
  <section class="submit_right">
  <textarea name="">Your input here...</textarea>
  <input type="submit" value="SAVE" class="save">
  </section>
  </section>-->
<script type="text/javascript">
var card=$('#card_id').val();
var show=$('#show_tab').val();
if(show==1)
{
	show_network(card);
}else if(show==2){
	show_contact(card)
	}
else{
	get_job_details_first(card);
	}
    
	
function get_job_details_first(card_id)
{
	$('.tab_details').html('<div style="height:100px; margin-top:50px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/jobcard_details_first','cardid='+card_id,function(data){
		$('.tab_details').html(data);
		
		});	
}	

function show_location(card_id)
{
	$('li#loc').siblings(this).removeClass('active');
	$('#loc').addClass('active');
	$('.tab_details').html('<div style="height:100px; margin-top:50px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/show_location','cardid='+card_id,function(data){
		$('.tab_details').html(data);
		
		});	
}

function show_contact(card_id)
{	
	$('li#cont_inf').siblings(this).removeClass('active');
	$('li#cont_inf').addClass('active');
	$('.tab_details').html('<div style="height:100px; margin-top:50px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/show_contact','cardid='+card_id,function(data){
		$('.tab_details').html(data);
		
		});	
}
function show_position(card_id)
{
	$('li#pos_inf').siblings(this).removeClass('active');
	$('#pos_inf').addClass('active');
	$('.tab_details').html('<div style="height:100px; margin-top:50px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/show_position','cardid='+card_id,function(data){
		$('.tab_details').html(data);
		
		});	
}
function show_network(card_id)
{
	$('li#net_inf').siblings(this).removeClass('active');
	$('#net_inf').addClass('active');
	$('.tab_details').html('<div style="height:100px; margin-top:50px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/show_network','cardid='+card_id,function(data){
		$('.tab_details').html(data);
		
		});	
}
function show_interview(card_id)
{
	$('li#int_agenda').siblings(this).removeClass('active');
	$('#int_agenda').addClass('active');
	$('.tab_details').html('<div style="height:100px; margin-top:50px; margin-left:450px;"><?php echo $this->Html->image('loading.gif');?></div>');
	$.post('<?php echo SITE_URL;?>/jobcards/show_interview','cardid='+card_id,function(data){
		$('.tab_details').html(data);
		
		});	
}

function show_card_contacts(card_id)
{
	disablePopup();
	show_contact(card_id);
			
}

</script>  