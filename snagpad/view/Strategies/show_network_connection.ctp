 <div class="submit_left">
<h4><?php echo $popTitle;?></h4>

<div class="nano" style="width:220px !important;">
<div class="strategy_pop_up" style="width:203px !important;   overflow:hidden">

  <p class="full"><?php echo $check['Checklist']['description'];?></p>

 </div>
  </div>
 
  </div>
   <?php if($check['Checklist']['video']){ ?> 
  <div class="video">
  <?php echo $this->Html->link($this->Html->image('VideoLogo.png', array('alt' =>'View Video', 'border' => '0')), 'Javascript://', array('escape' => false, 'class' => 'logo','onClick'=>'viewStrategyvideo('.$check['Checklist']['id'].')')); ?>
  </div>
  <?php } ?>
   <div class="submit_right">
 <input type="hidden" id="check_id" value="<?php echo $check['Checklist']['id']; ?>"/>  
  <input type="hidden" id="card_id" value="<?php echo $card_id; ?>"/> 
  
 
    <ul style="text-align:left">
              	<li class="" style=" text-align:left !important">   
                	<div class="form_div">
  <div class="form_box" style="width:600px; margin:0px  !important;">
  
 <div id="info_contact" style="width:580px">
        <?php if($flag=='1'){ ?>
         <div class="nano" style="width:580px !important">
         <?php } ?>
         <div class="strategy_pop_up" style="width:580px !important; height:136px !important; overflow:hidden">
         
      	<?php	 if(isset($fb_friends)){
			 $count=count($fb_friends);
			for($i=0,$j=1,$k=2;$i<$count;$i+=3,$j+=3,$k+=3){ ?>
        <div class="comon_row" style="width:auto">
       
        <span class="column1 colour2" style="width:179px; min-height:110px"><?php if(isset($fb_friends[$i]['name'])){echo "<a href='http://facebook.com/profile.php?id=".$fb_friends[$i]['uid']."' target='_blank'>"; echo "<img src='https://graph.facebook.com/".$fb_friends[$i]['uid']."/picture' alt='".$fb_friends[$i]['name']."' title='".$fb_friends[$i]['name']."' border='0' align='absmiddle'><br>";   echo $fb_friends[$i]['name']."</a>";}?><input type="checkbox" name="include[]" id="include[]" class="connection" value="<?php echo $fb_friends[$i]['uid']; ?>" title="<?php echo $fb_friends[$i]['name'];?>"/></span>
        <span class="column2 colour2" style="width:179px; min-height:110px"><?php if(isset($fb_friends[$j]['name'])){echo "<a href='http://facebook.com/profile.php?id=".$fb_friends[$j]['uid']."' target='_blank'>"; echo "<img src='https://graph.facebook.com/".$fb_friends[$j]['uid']."/picture' alt='".$fb_friends[$j]['name']."' title='".$fb_friends[$j]['name']."' border='0' align='absmiddle'><br>";   echo $fb_friends[$j]['name']."</a>";}?><input type="checkbox" name="include[]" id="include[]" class="connection" value="<?php echo $fb_friends[$i]['uid']; ?>" title="<?php echo $fb_friends[$i]['name'];?>"/></span>
        <span class="column3 colour2" style="width:179px; min-height:110px"><?php if(isset($fb_friends[$k]['name'])){echo "<a href='http://facebook.com/profile.php?id=".$fb_friends[$k]['uid']."' target='_blank'>"; echo "<img src='https://graph.facebook.com/".$fb_friends[$k]['uid']."/picture' alt='".$fb_friends[$k]['name']."' title='".$fb_friends[$k]['name']."' border='0' align='absmiddle'><br>";   echo $fb_friends[$k]['name']."</a>";}?><input type="checkbox" name="include[]" id="include[]" class="connection" value="<?php echo $fb_friends[$i]['uid']; ?>" title="<?php echo $fb_friends[$i]['name'];?>"/></span>
               
        </div>
        <?php } 
		 } else{ ?> <div style="text-align: center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal"><?php echo 'No Facebook Friend Found'; ?> </div>
         
         
         <?php }
          if(isset($friends['people']['person']) && count($friends)>0){ ?>
			 <input type="hidden" id="flag_con" value="1"/>
		<?php	 $friends=$friends['people']['person'];
			 $count=count($friends);
			 for($i=0,$j=1,$k=2;$i<$count-1;$i+=3,$j+=3,$k+=3){ ?>
        <div class="comon_row" style="width:auto">
       
        <span class="column1 colour2" style="width:179px; min-height:110px"><?php if(isset($friends[$i]['first-name'])){echo "<a href='".$friends[$i]['site-standard-profile-request']['url']."' target='_blank'>";if(isset($friends[$i]['picture-url'])) echo "<img src='".$friends[$i]['picture-url']."' alt='".$friends[$i]['headline']."' title='".$friends[$i]['headline']."' border='0' align='absmiddle'><br>"; else echo "<img src='".SITE_URL."/img/photo.png' title='".$friends[$i]['headline']."' border='1' align='absmiddle'><br>";  echo $friends[$i]['first-name']." ".$friends[$i]['last-name']."</a>"; }?><input type="checkbox" name="include[]" id="include[]" class="connection" value="<?php echo $friends[$i]['id']; ?>" title="<?php echo $friends[$i]['first-name']." ".$friends[$i]['last-name'];?>"/></span>
        
        <span class="column2 colour2" style="width:179px; min-height:110px"><?php if(isset($friends[$j]['first-name'])){echo "<a href='".$friends[$j]['site-standard-profile-request']['url']."' target='_blank'>";if(isset($friends[$j]['picture-url'])) echo "<img src='".$friends[$j]['picture-url']."' alt='".$friends[$j]['headline']."' title='".$friends[$j]['headline']."' border='0' align='absmiddle'><br>";  else echo "<img src='".SITE_URL."/img/photo.png' title='".$friends[$j]['headline']."' border='1' align='absmiddle'><br>"; echo $friends[$j]['first-name']." ".$friends[$j]['last-name']."</a>";}?><input type="checkbox" name="include[]" id="include[]" class="connection" value="<?php echo $friends[$j]['id']; ?>" title="<?php echo $friends[$j]['first-name']." ".$friends[$j]['last-name'];?>"/></span>
        
        <span class="column3 colour2" style="width:179px; min-height:110px"><?php if(isset($friends[$k]['first-name'])){echo "<a href='".$friends[$k]['site-standard-profile-request']['url']."' target='_blank'>"; if(isset($friends[$k]['picture-url'])) echo "<img src='".$friends[$k]['picture-url']."' alt='".$friends[$k]['headline']."' title='".$friends[$k]['headline']."' border='0' align='absmiddle'><br>";   else echo "<img src='".SITE_URL."/img/photo.png' title='".$friends[$k]['headline']."' border='1' align='absmiddle'><br>"; echo $friends[$k]['first-name']." ".$friends[$k]['last-name']."</a>";}?><input type="checkbox" name="include[]" id="include[]" class="connection" value="<?php echo $friends[$k]['id']; ?>" title="<?php echo $friends[$k]['first-name']." ".$friends[$k]['last-name'];?>"/></span>
        
        </div>
        <?php } 
		 } else{ ?> <div  style=" text-align:center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal"><?php if(isset($no_connect)){ echo 'No Linkedin Contacts found.<br> <a href="javascript://" onclick="link_social();">Click here</a> to link your Facebook and Linkedin account to SnagPad'; }else{ echo 'No Linkedin Friend Found.';} ?> </div>
        	<input type="hidden" id="flag_con" value="0"/>
          <?php } ?>
      
        </div>
        <?php if($flag=='1'){ ?>
        </div>
        <?php } ?>
 </div>
  
 
 
  </div>
  
  </div>
                </li>
                
                 
     </ul>  
    
      <a href="javascript://" onclick="contact_connect('<?php echo $flag;?>');" class="save_btn2" style="margin-bottom:-3px;"><?php if($flag=='0'){ echo 'Save'; }else{ echo 'Contact';}?></a>  
    
     </div>
     
<script type="text/javascript">
$(document).ready(function(){
	$('.nano').nanoScroller({alwaysVisible: false, contentClass: 'strategy_pop_up',sliderMaxHeight: 70});
	
	});
	
function contact_connect(flag)
{
	
	var card=$('#card_id').val();
	var check_id=$('#check_id').val();
	if(flag==1)
	{
	var i=1;
	var name=new Array();
	var id=new Array();
	
	
	$('.connection').each(function() {
        if($(this).attr('checked'))
		{
			name[i]=$(this).attr('title');
			id[i]=$(this).attr('value');
			i++;
		}
    	
	});	
	if(id==null)
	{
		alert('Please select contacts to send message.');	
	}else{
	disablePopup();
	loadContactPopup('<?php echo SITE_URL;?>/strategies/contact_connection/'+card+'/'+check_id,id,name);	
	}
	}else{
		var check_id=$('#check_id').val();
		$.post('<?php echo SITE_URL;?>/strategies/move_con_checklist',{card_id:card,check_id:check_id},function(frm){
				disablePopup();
				$('#li_a_'+check_id).addClass('done');
				get_strategy_meter();
				get_bar_meter_percent();
			})	
		
	}
}	

function link_social()
{
	disablePopup();
	setTimeout(function(){ loadPopup('<?php echo SITE_URL;?>/users/social_pop'); },1500);
		
}
</script>	           
 
  
  