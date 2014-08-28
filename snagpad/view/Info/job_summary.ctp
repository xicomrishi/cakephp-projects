<section class="tabing_container">

        <section class="tabing" style="margin:12px 0 0 0">
          <ul class="gap">
           
            <li class="active"><a>Job Summary Report</a></li>
          	
          </ul>
        </section>
<section class="cms_page_detail">
<div class="online_training">
      
       <h3 class="sub" style="font-size:20px"><?php echo $job['Jobfamily']['title']; ?></h3>
       <p><?php echo $job['Jobfamily']['description']; ?></p>
       <?php if(!empty($task)){ ?>
       <h4 style="font-weight:bold; background:#eee; padding:5px 0">Task</h4>
       <ul>
       <?php foreach($task as $t){ ?>
       	<li><?php echo $t['Task']['task']; ?></li>
       <?php } ?>
       </ul>
		<?php } ?>
        
       <?php if(!empty($skills)){ ?>
       <h4 style="font-weight:bold; background:#eee; padding:5px 0">Knowledge</h4>    
       <?php foreach($skills as $sk){
		   if($sk['Skillslist']['type']=='3') 
	   		echo '<p style="padding:0 0 10px 0"><strong>'.$sk['Skillslist']['skill'].'</strong> - '.$sk['Skillslist']['description'].'</p>';
	    } ?>
        
         <h4 style="font-weight:bold; background:#eee; padding:5px 0">Skills</h4>    
       <?php foreach($skills as $sk){
		   if($sk['Skillslist']['type']=='1') 
	   		echo '<p style="padding:0 0 10px 0"><strong>'.$sk['Skillslist']['skill'].'</strong> - '.$sk['Skillslist']['description'].'</p>';
	    } ?>
        
          <h4 style="font-weight:bold; background:#eee; padding:5px 0">Abilities</h4>    
       <?php foreach($skills as $sk){
		   if($sk['Skillslist']['type']=='2') 
	   		echo '<p style="padding:0 0 10px 0"><strong>'.$sk['Skillslist']['skill'].'</strong> - '.$sk['Skillslist']['description'].'</p>';
	    } ?>
        
       <?php } ?>
        
       <?php if(!empty($work_values)){ ?>
       <h4 style="font-weight:bold; background:#eee; padding:5px 0">Work Values</h4>
       <?php foreach($work_values as $wv){ 
	   	echo '<p style="padding:0 0 10px 0"><strong>'.$wv['C']['element_name'].'</strong> - '.$wv['C']['description'].'</p>';
	    }} ?>
        
        <?php if(!empty($work_styles)){ ?>
       <h4 style="font-weight:bold; background:#eee; padding:5px 0">Work Styles</h4>
       <?php foreach($work_styles as $ws){ 
	   	echo '<p style="padding:0 0 10px 0"><strong>'.$ws['C']['element_name'].'</strong> - '.$ws['C']['description'].'</p>';
	    }} ?>
        
       </div>
 </section>     
 </section>