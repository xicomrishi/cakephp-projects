<ul>
<li class="tab1"><?php if(!$this->Session->check('Coach')) { ?><a href="javascript://" <?php  if($count=='0') { ?>onclick="loadPopup('<?php echo SITE_URL;?>/jobcards/show_first_add_card');"<?php }else{ ?>onclick="loadPopup('<?php echo SITE_URL;?>/jobcards/show_opp_jobcards');" <?php } ?>><strong>SNAGGED JOBS</strong><span><?php echo $opp;?></span></a><?php }else{ ?><a href="javascript://"><strong>SNAGGED JOBS</strong><span><?php echo $opp;?></span></a><?php } ?></li>
<li class="tab2"><a href="#"><strong>APPLIED</strong><span><?php echo $apply;?></span></a></li>
<li class="tab3"><a href="#"><strong>SET INTERVIEW</strong><span><?php echo $setinterview;?></span></a></li>
<li class="tab4"><a href="#"><strong>INTERVIEW</strong><span><?php echo $interview;?></span></a></li>
<li class="tab5"><a href="#"><strong>VERBAL JOB<br> 
OFFER</strong><span><?php echo $verbal;?></span></a></li>
<li class="tab6"><a href="#"><strong>job</strong><span><?php echo $job;?></span></a></li>
</ul>