  <form id="cardDetailForm" name="cardDetailForm" method="post" action="">
  <fieldset>
  <section class="form_section">
  <section class="form_box"  style="width:908px; margin:0px  !important; padding:0 0 0 40px">
  
 <div id="info_contact">
        
         <div class="nano">
        <div class="show_card_contact" style="height:150px; overflow:auto;">
       <?php if(isset($no_connect)){ ?><div style="text-align: center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal"><?php echo 'No contacts found.<br> <a href="javascript://" onclick="link_social();">Click here</a> to link your Facebook and Linkedin account to SnagPad'; ?></div> <?php }else{
        
		 if(isset($fb_friends)){
			 $count=count($fb_friends);
			for($i=0,$j=1,$k=2,$l=3;$i<$count;$i+=4,$j+=4,$k+=4,$l+=4){ ?>
        <div class="comon_row" style="width:auto">
       
        <span class="column1 colour2" style="width:210px; min-height:110px"><?php if(isset($fb_friends[$i]['name'])){echo "<a href='http://facebook.com/profile.php?id=".$fb_friends[$i]['uid']."' target='_blank'>"; echo "<img src='https://graph.facebook.com/".$fb_friends[$i]['uid']."/picture' alt='".$fb_friends[$i]['name']."' title='".$fb_friends[$i]['name']."' border='0' align='absmiddle'><br>";   echo $fb_friends[$i]['name']."</a>";}?></span>
        <span class="column2 colour2" style="width:210px; min-height:110px"><?php if(isset($fb_friends[$j]['name'])){echo "<a href='http://facebook.com/profile.php?id=".$fb_friends[$j]['uid']."' target='_blank'>"; echo "<img src='https://graph.facebook.com/".$fb_friends[$j]['uid']."/picture' alt='".$fb_friends[$j]['name']."' title='".$fb_friends[$j]['name']."' border='0' align='absmiddle'><br>";   echo $fb_friends[$j]['name']."</a>";}?></span>
        <span class="column3 colour2" style="width:210px; min-height:110px"><?php if(isset($fb_friends[$k]['name'])){echo "<a href='http://facebook.com/profile.php?id=".$fb_friends[$k]['uid']."' target='_blank'>"; echo "<img src='https://graph.facebook.com/".$fb_friends[$k]['uid']."/picture' alt='".$fb_friends[$k]['name']."' title='".$fb_friends[$k]['name']."' border='0' align='absmiddle'><br>";   echo $fb_friends[$k]['name']."</a>";}?></span>
        <span class="column4 colour2" style="width:210px; min-height:110px"><?php if(isset($fb_friends[$l]['name'])){echo "<a href='http://facebook.com/profile.php?id=".$fb_friends[$i]['uid']."' target='_blank'>"; echo "<img src='https://graph.facebook.com/".$fb_friends[$l]['uid']."/picture' alt='".$fb_friends[$l]['name']."' title='".$fb_friends[$l]['name']."' border='0' align='absmiddle'><br>";   echo $fb_friends[$l]['name']."</a>";}?></span>
        
        </div>
        <?php } 
		 } else{ ?> <div style="text-align: center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal"><?php echo 'No Facebook Friend Found'; ?> </div>
         
         
         <?php }
		 //echo '<pre>';print_r($friends);
		  if(is_array($friends) && $friends['num-results']!=0){
			 $friends=$friends['people']['person'];
			 $count=count($friends);
			 for($i=0,$j=1,$k=2,$l=3;$i<$count-1;$i+=4,$j+=4,$k+=4,$l+=4){ ?>
        <div class="comon_row" style="width:auto">
       
        <span class="column1 colour2" style="width:210px; min-height:110px"><?php if(isset($friends[$i]['first-name'])){echo "<a href='".$friends[$i]['site-standard-profile-request']['url']."' target='_blank'>";if(isset($friends[$i]['picture-url'])) echo "<img src='".$friends[$i]['picture-url']."' alt='".$friends[$i]['headline']."' title='".$friends[$i]['headline']."' border='0' align='absmiddle'><br>"; else echo "<img src='".SITE_URL."/img/photo.png' title='".$friends[$i]['headline']."' border='1' align='absmiddle'><br>";  echo $friends[$i]['first-name']." ".$friends[$i]['last-name']."</a>";}?></span>
        <span class="column2 colour2" style="width:210px; min-height:110px"><?php if(isset($friends[$j]['first-name'])){echo "<a href='".$friends[$j]['site-standard-profile-request']['url']."' target='_blank'>";if(isset($friends[$j]['picture-url'])) echo "<img src='".$friends[$j]['picture-url']."' alt='".$friends[$j]['headline']."' title='".$friends[$j]['headline']."' border='0' align='absmiddle'><br>";  else echo "<img src='".SITE_URL."/img/photo.png' title='".$friends[$j]['headline']."' border='1' align='absmiddle'><br>"; echo $friends[$j]['first-name']." ".$friends[$j]['last-name']."</a>";}?></span>
        <span class="column3 colour2" style="width:210px; min-height:110px"><?php if(isset($friends[$k]['first-name'])){echo "<a href='".$friends[$k]['site-standard-profile-request']['url']."' target='_blank'>"; if(isset($friends[$k]['picture-url'])) echo "<img src='".$friends[$k]['picture-url']."' alt='".$friends[$k]['headline']."' title='".$friends[$k]['headline']."' border='0' align='absmiddle'><br>";   else echo "<img src='".SITE_URL."/img/photo.png' title='".$friends[$k]['headline']."' border='1' align='absmiddle'><br>"; echo $friends[$k]['first-name']." ".$friends[$k]['last-name']."</a>";}?></span>
        <span class="column4 colour2" style="width:210px; min-height:110px"><?php if(isset($friends[$l]['first-name'])){echo "<a href='".$friends[$l]['site-standard-profile-request']['url']."' target='_blank'>"; if(isset($friend[$l]['picture-url'])) echo "<img src='".$friends[$l]['picture-url']."' alt='".$friends[$l]['headline']."' title='".$friends[$j]['headline']."' broder='0' align='absmiddle'><br>";  else echo "<img src='".SITE_URL."/img/photo.png' title='".$friends[$l]['headline']."' border='1' align='absmiddle'><br>"; echo $friends[$l]['first-name']." ".$friends[$l]['last-name']."</a>";}?></span>
        
        </div>
        <?php } 
		 } else{ ?> <div style="text-align: center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal"><?php echo 'No Linkedin Friend Found'; ?> </div> <?php } ?>
         <?php } ?>
        </div>
        </div>
 </div>
  
 
 
  </section>
  
  </section>
  </fieldset>
  </form>
<script type="text/javascript">
function link_social()
{
	disablePopup();
	setTimeout(function(){ loadPopup('<?php echo SITE_URL;?>/users/social_pop'); },1500);
		
}
</script>  
 