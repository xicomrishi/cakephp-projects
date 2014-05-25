<section class="tabing_container">		
	<section class="cms_page_detail">
        <div class="pricing">
            <div class="left_sec">
            <h3>Pricing</h3>
            <?php $jobseeker_flag=1;$jobseeker_lastflag=0;
			$precat='';$precat_flag=0;
			 foreach($datas as $key=>$data){ 
			 	if($key!=0) $class="style='padding-top:25px;'";else $class="";
				$url=SITE_URL.'/info/shoping_cart/'.$data['Subscription']['alias'];
				if(isset($account_id))$url.='/'.$account_id;
				 if($precat!=$data['Subscription']['category'])
				 {
					 if($precat=='Independent Job Seeker'){$jobseeker_flag=0;$jobseeker_lastflag=1;}
					 $precat=$data['Subscription']['category'];
					 if($precat=='Independent Job Seeker'){$jobseeker_lastflag=2;}
					 $precat_flag=0;					
				 }
				 else
				 	$precat_flag=1;
			if($jobseeker_flag==0){
		    echo '<p style="color:#F07700;display:inline-block;">According to the Future Workplace&nbsp; “Multiple Generations @ Work”&nbsp;survey of 1,189 employees and 150 managers, the average person will have 15-20 jobs over the course of their lives.&nbsp; <b>Consider a life account.</b></p>'; 
			}	 
			if($precat_flag==0)	 
			{
           echo "<h4 id='".str_replace(' ','_',$data['Subscription']['category'])."'".$class.">".$data['Subscription']['category']."</h4>";
		   if($precat=='Independent Job Seeker')	
		    echo '<p style="font-style:italic;">(If you are in a job search on your own, this is the SnagPad option for you!)</p>'; 
			}
		    ?>
           <div class="row1">
           <div class="col1"><?php //echo "<p>".$data['Subscription']['title']."</p>";
			 echo $data['Subscription']['description'];?></div>
           <div class="col2" ><?php echo "<p> $".$data['Subscription']['amount']."</p>";
		   if($data['Subscription']['save']>0)
		   echo "<p><span>Save( $".$data['Subscription']['save'].")</span></p>"; ?></div>
           <div class="col3"><a href="<?php echo $url;?>" ><?php if($data['Subscription']['subscription_type']!=0){echo $this->Html->image('buy-now.png', array('alt' =>'Buy Now', 'border' => '0'));}else {echo $this->Html->image('try_now.png', array('alt' =>'Try Now', 'border' => '0'));}?> </a> </div> </div>          
           <?php } 
            if($jobseeker_lastflag==2){
		    echo '<p style="color:#F07700;display:inline-block;">According to the Future Workplace&nbsp; “Multiple Generations @ Work”&nbsp;survey of 1,189 employees and 150 managers, the average person will have 15-20 jobs over the course of their lives.&nbsp; <b>Consider a life account.</b></p>'; 
			}	?>
        </div>
        <div class="right_sec">
            <h3>Pricing</h3>
            <p><a href="#Individual_Coach">Individual Coach</a></p>
            <p><a href="#Higher_Education">Higher Education</a></p>
            <p><a href="#Workforce_Agency">Workforce Agency</a></p>
            <p><a href="#Outplacement">Outplacement</a></p>
            <p><a href="#Public_Library">Public Library</a></p>
            </div>
        </div>
	</section>     
</section> 