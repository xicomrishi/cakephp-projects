<?php //echo $this->Html->script('jquery.nicescroll.min');?>
<div id="jsb_CardPopup"></div>
<div id="jsbVideoPopup"></div> 
<div id="backgroundVideoPopup"></div>
<input type="hidden" id="client_id"  value="<?php echo $client_id;?>"/>
<input type="hidden" id="card_id"  value="<?php echo $card['Card']['id'];?>"/>
<input type="hidden" id="path"  value="<?php echo $card['Card']['job_url'];?>"/>
<ul class="note">
  <li><a href="javascript://" onclick="loadNotesPopup('<?php echo SITE_URL;?>/jobcards/notes_index','<?php echo $card['Card']['id'];?>','0')">NOTES</a></li>
  <li><a href="javascript://" onclick="show_card_contacts_strat('<?php echo $card['Card']['id'];?>');">CONTACTS</a></li>
  <li><a href="javascript://" onclick="loadNotesPopup('<?php echo SITE_URL;?>/jobcards/attachments_index','<?php echo $card['Card']['id'];?>','0')">ATTACHMENTS</a></li>
  <li class="last"><a href="javascript://" onclick="loadNotesPopup('<?php echo SITE_URL;?>/jobcards/notes_index','<?php echo $card['Card']['id'];?>','1');">COACH NOTES</a></li>
  </ul>
<div class='strat_content'>
<div class="content_left">
  <ul>
  <li><strong>GOAL</strong><p><?php echo $goal;?></p></li>
  <li><strong>TIP</strong><p><?php echo $description['Config']['value'];?></p></li>
  </ul>
  <?php if($c_col!='J'&&$show_button=='1' && $this->Session->read('usertype')==3){ ?>
  <a  href="javascript://"  onclick="save_checklist('<?php echo $card_id;?>','<?php echo $c_col;?>','<?php echo $move_action;?>');" class="blue_btn"><?php echo $this->Html->image('btn_left_curv.png',array('escape'=>false,'div'=>false));?><span><?php echo $move_button_text;?></span><?php echo $this->Html->image('btn_right_curv.png',array('escape'=>false,'div'=>false));?></a> 
  <?php } ?>
  
  </div>
  
  <div class="content_right">
 <!-- <h3>Choose your strategies for <strong><?php echo $current_column; ?>:</strong></h3>-->
 <h3>I need to...</h3>
 
<?php if($i==1||$i==3||$i==4) { ?> 
<div class="nano">

  <ul class="strategies_list job_descrip_box">
<?php }else{ ?>
 <ul class="strategies_list job_descrip_box" style="height:189px !important">
<?php } ?>  
  <?php 
  if($this->Session->read('usertype')=='3'){
  foreach($checklists as $check) { 
   if($check['CH']['type']!='9') { ?>
   <li><a id="li_a_<?php echo $check['CH']['id'];?>" class="<?php if($check['CCH']['status']=='1'){echo 'done';}?>" <?php //if($check['CCH']['status']!=''){ ?>onclick="show_skills('<?php echo $card['Card']['id'];?>','<?php echo $check['CH']['id'];?>','<?php echo $check['CH']['type'];?>');" <?php //} ?>><?php echo $this->Html->image('qus_icon.png',array('escape'=>false,'div'=>false,'class'=>'qus_icon'));?><small><?php echo $check['CH']['title'];?></small><?php echo $this->Html->image('tick.png',array('escape'=>false,'div'=>false,'class'=>'tick'));  ?></a></li>
    <?php } } 
  }else{
	    foreach($checklists as $check) { 
   if($check['CH']['type']!='9') { ?>
   <li><a id="li_a_<?php echo $check['CH']['id'];?>" class="<?php if($check['CCH']['status']=='1'){echo 'done';}?>" <?php //if($check['CCH']['status']!=''){ ?> <?php //} ?> <?php if($check['CH']['id']=='1'){ ?>onclick="show_skills('<?php echo $card['Card']['id'];?>','<?php echo $check['CH']['id'];?>','<?php echo $check['CH']['type'];?>');"<?php } ?>><?php echo $this->Html->image('qus_icon.png',array('escape'=>false,'div'=>false,'class'=>'qus_icon'));?><small><?php echo $check['CH']['title'];?></small><?php echo $this->Html->image('tick.png',array('escape'=>false,'div'=>false,'class'=>'tick'));  ?></a></li>
    <?php } } 

	?>
   <?php } ?>
 
 <?php if($i==1||$i==4) { ?> 
  </ul>
 </div>

  
<?php }else{ ?>
 </ul>
<?php } ?>  

  </div>
</div>  
 
<script type="text/javascript">
$(document).ready(function(e) {
	
   	 $(".nano").nanoScroller({alwaysVisible:true});
});

function get_bar_meter_percent()
{
	var card_id=$('#card_id').val();
	$.post('<?php echo SITE_URL;?>/strategies/get_bar_meter_percent',{card_id:card_id},function(data){
		
			setTimeout(function(){$('#bar_percent_'+card_id).css('height',data+'%');},1000);
			setTimeout(function(){ $('#tot_points_meter_'+card_id).html(data+'%');},1000);
		});	
	
}

function show_skills(card_id,ch_id,type)
{
	//alert(type);
	if(type!='0'){
		//alert(card_id);
	loadCardPopup('<?php echo SITE_URL;?>/strategies/show_skill',card_id,ch_id);
	}else{
		//alert(1);
		$.post('<?php echo SITE_URL;?>/strategies/show_skill',{card_id:card_id,check_id:ch_id},function(data){
				disablePopup();
				if(ch_id==35)
				{
				$('#li_a_'+ch_id).addClass('done');
				}
				get_bar_meter_percent();
			});
		
		}
}


function save_checklist(card,col,action)
{
	//alert(col);
	$.post('<?php echo SITE_URL;?>/strategies/check_for_card_move',{column:col,card_id:card},function(data){
		//alert(data);
		if(data=='Error')
		{
			var y=confirm('You need to link this job opportunity to Job A or Job B before applying for the Job. \n\nClick OK to go to profile wizard');
					if(y){ window.location='<?php echo SITE_URL;?>/jobcards/profileView';}else{ return false; }
			
			}else{
				var response = data.split("|");
				//alert(response);
		if(response[3]=='0')
		{		
		if(response[0]=='1'&&(response[1]=='O'||response[1]=='A'))
		{	
				if(col=='O' && response[4]=='0')
				{
					
					loadPopup('<?php echo SITE_URL;?>/strategies/apply_directly/'+card);	
				
				}else{
					
					var path=$('#path').val();
					if(path==''){ }else if(col=='O' && response[4]=='1'){ 
						window.open(path,'_blank');
					
						}
					loadCardPopup('<?php echo SITE_URL;?>/strategies/'+action,card,0);
					}
			
			}else if(response[0]=='1'||(response[1]!='O'&&response[1]!='A')){
				//alert(1);
			
				$.post('<?php echo SITE_URL;?>/strategies/update_card_column',{card_id:card,new_status: response[2]},function(frm){
				//window.location='<?php echo SITE_URL;?>/jobcards';
					var clientid=$('#client_id').val();	
					get_strategy_meter();
					show_top_tab(clientid);
					show_jobcards(clientid);
					var get_res=frm.split("|");
					//alert(card);
					/*$(".main_div").ajaxComplete(function(event,request, settings){
					   show_strategy(card,get_res[0],get_res[1]);
					 });*/
					setTimeout(function(){show_strategy(card,get_res[0],get_res[1])},3000);
					//show_strategy(card,get_res[0],get_res[1]);
					
				});
				
			}else{
				if(response[1]=='O')
				{
					alert('You need to link this job opportunity to Job A or Job B before applying for the Job.');
					
				}else if(response[1]=='A')
				{
					alert('You need to set an Interview date with employer.');
				}
					
			}
		}else if(response[3]=='1'){ alert('Job Card already moved to next column');}
		}
	});
}

function show_card_contacts_strat(card_id)
{
	$.post('<?php echo SITE_URL;?>/strategies/get_card_row_info',{card_id:card_id},function(data){
			//alert(card_id);
			show_job_details(card_id,data);
			//setTimeout(function(){show_contact(card_id),2000});
			setTimeout(function(){show_contact(card_id)},2000);
			
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
function viewStrategyvideo(statgy_id)
{	
		
		$("#backgroundVideoPopup").fadeIn("slow");
		$("#jsbVideoPopup").fadeIn("slow");
		popupStatus = 1;
         jQuery.post('<?php echo SITE_URL;?>/strategies/show_video',{id:statgy_id},function(data){		 
                            $('#jsbVideoPopup').html(data);
							centerVideoPopup();
            	})	
}
</script>  