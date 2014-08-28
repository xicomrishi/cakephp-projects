<section class="top_sec space">
	<h3>My Weekly Challenges</h3>         
</section>
<section class="challenge_section">
<?php if($totalRow>0){ ?>
	<section class="heading_row">
        <span class="cols1">CHALLENGE NAME</span>
        <span class="cols2">POINTS</span>
        <span class="cols3">DATE COMPLETED</span>
        <span class="cols4">POINTS AWARDED</span>
    </section>    
    <?php $c=$tot=$sum=0;
	foreach($challenges as $challenge){$c++;
		$sum+=$challenge['C']['points'];
		$tot+=$challenge['CC']['points'];
		if($c==1){
		?>
        <section class="week_row">Week <?php echo $challenge['CC']['week_id'];?> <span>/ <?php echo date('F j, Y',strtotime($date[0][0]['newdate'])).' to '. date('F j, Y',strtotime($date[0][0]['ch_date']));?></span></section>        
        <?php } ?>
        
        <?php if(isset($showChallenge)&&(!isset($ch_progress))){ if($showChallenge=='welcome') {?>
        <div class="mychallenge_welcome"><?php $welcome; ?></div>
        <?php } else if($showChallenge>0 && $showChallenge==$challenge['C']['id']) { ?>
       	<div class="mychallenge_welcome">
         <?php echo $this->Html->link($this->Html->image('close_img.png', array('alt' => 'Close', 'border' => '0')),'javascript:disablechallengecomplete();' , array('escape' => false, 'class' => 'exit')); ?>
       	<h3>Completed Challenge!</h3>
       	<p>Congratulations! You have successfully completed the '<?php echo $challenge['C']['title'];?>' challenge and have earned <?php echo $challenge['C']['points'];?> points. You require <?php print_r($client_point);?> points to complete your weekly challenge list. Keep up the great work!</p>
        </div>
        <?php }}?>
        
       
        <div class="comn_row">
        <span class="cols1 color1"><?php echo $challenge['C']['title'];?></span>
        <span class="cols2 color2"><?php echo $challenge['C']['points'];?></span>
        <span class="cols3 color3"><?php if($challenge['CC']['date_completed']!='0000-00-00 00:00:00') {echo date('F j, Y g:i A',strtotime($challenge['CC']['date_completed']));} else echo "NA";?></span>
        <span class="cols4 color2"><?php echo $challenge['CC']['points'];?></span>
        <?php if(($challenge['CC']['week_id']<$max)|| ($challenge['CC']['status']==1)||($usertype!=3)){?>
        <span class="cols5"><a href="#" class="comn_btn" onclick="completeChallenge('<?php echo $challenge['C']['id'];?>','<?php echo $challenge['CC']['client_challenge_id'];?>','1')">VIEW</a></span>
         <?php } else { if($challenge['C']['c_type']=='F'){ ?>
          <span class="cols5"><a href="#" class="comn_btn" onclick="completeChallenge('<?php echo $challenge['C']['id'];?>','<?php echo $challenge['CC']['client_challenge_id'];?>','0')">COMPLETE</a></span>
          <?php } else{ ?>
           <span class="cols5"><a href="#" class="comn_btn" onclick="completeChallenge('<?php echo $challenge['C']['id'];?>','<?php echo $challenge['CC']['client_challenge_id'];?>','1')">AUTOMATIC</a></span>
         <?php } } ?>
        </div>
        
      <?php } ?>       
        <div class="total_row">
        <span>Weekly Points Needed <small><?php echo $sum;?></small></span>
        <span>Weekly Total<small><?php echo $tot;?></small></span>
     	</div>
      <?php } else { if($usertype==3){?><div class="nochallenge"><p>You must determine your weekly point requirement first. <a href="#" onclick="show_challenge_survey(<?php echo $client_id;?>)" >Click here</a> to complete the survey.</p></div><?php }else{?><div class="nochallenge"><p>Your client has not completed survey yet.</p></div>
      <?php } } ?>      
</section>
 <script type="application/javascript">
 function disablechallengecomplete()
 {
	 $(".mychallenge_welcome").hide();
 }
 </script>  