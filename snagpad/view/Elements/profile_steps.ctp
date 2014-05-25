<?php $current=$this->Session->read('Client.profile_step');
	$step=$this->Session->read('Client.P_step');
	for($i=1;$i<=7;$i++){
			if($i==$current)
			{ ?>
            <li class="active"><a href="javascript://"><?php echo $i;?></a></li>
       <?php //}else if($i<=$step) { ?>
        <?php }else{ ?> 
       			<li class=""><a href="javascript://" onclick="step(<?php echo $i;?>);"><?php echo $i;?></a></li>
       <?php //}else{ ?>     
             <!--<li class=""><a href="javascript://"><?php echo $i;?></a></li>-->
<?php }}?>    