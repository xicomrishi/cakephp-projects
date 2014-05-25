<section class="head_row">
  <!--<h3>Job B criteria indicate the reasions why you would take a job other than job A</h3>-->
  <p>Indicate below your job search preferences. This will help your network to clearly know what you are focusing on in your job search.</p>
  </section>
  <form id="step6Form" name="step6Form" action="">
  <section class="pop_up_detail border">
  
 			<div id="select_err" align="center" style="display:none;"></div>
              <section class="job_descrip_box" style="height:auto;">
              
              <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
              <fieldset>
               <ul class="indexSkills" style="height:auto;">
              	<li class="Caption">Targeted Employment Industry 1 : </li>
            	<select id="TR_industry" name="data[Client][industry]" class="selectbox">
                	<option value="">Select Industry 1</option>
                    <?php foreach($industries as $industry)
					{
						if($exist_data['industry']==$industry['Industry']['id']) { ?>
							<option value="<?php echo $industry['Industry']['id'];?>" selected><?php echo $industry['Industry']['industry'];?></option>
					<?php 	}else { ?>
							<option value="<?php echo $industry['Industry']['id'];?>"><?php echo $industry['Industry']['industry'];?></option>
				<?php  }	}	?>
                </select> 	
           	  </ul>	
              
              
               <ul class="indexSkills" style="height:auto;">
              	<li class="Caption">Targeted Employment Industry 2 :  </li>
            	<select id="TR_industry2" name="data[Client][industry2]" class="selectbox">
                	<option value="">Select Industry 2</option>
                    <?php foreach($industries as $industry)
					{
						if($exist_data['industry2']==$industry['Industry']['id']) { ?>
							<option value="<?php echo $industry['Industry']['id'];?>" selected><?php echo $industry['Industry']['industry'];?></option>
					<?php 	}else { ?>
							<option value="<?php echo $industry['Industry']['id'];?>"><?php echo $industry['Industry']['industry'];?></option>
				<?php  }	}	?>
                </select> 	
           	  </ul>	
              
               <ul class="indexSkills" style="height:auto;">
              	<li class="Caption">Targeted Employment Industry 3 :  </li>
            	<select id="TR_industry3" name="data[Client][industry3]" class="selectbox">
                	<option value="">Select Industry 3</option>
                    <?php foreach($industries as $industry)
					{
						if($exist_data['industry3']==$industry['Industry']['id']) { ?>
							<option value="<?php echo $industry['Industry']['id'];?>" selected><?php echo $industry['Industry']['industry'];?></option>
					<?php 	}else { ?>
							<option value="<?php echo $industry['Industry']['id'];?>"><?php echo $industry['Industry']['industry'];?></option>
				<?php  }	}	?>
                </select> 	
           	  </ul>	
              
               <ul class="indexSkills" style="height:auto;">
              	<li class="Caption">Targeted Position Level :  </li>
            	<select id="TR_position" name="data[Client][tposition]" class="selectbox">
                	<option value="">Select Position</option>
                    <?php foreach($var_position as $pos)
					{
						if($exist_data['tposition']==$pos['Position']['id']) { ?>
							<option value="<?php echo $pos['Position']['id'];?>" selected><?php echo $pos['Position']['position'];?></option>
					<?php 	}else { ?>
							<option value="<?php echo $pos['Position']['id'];?>"><?php echo $pos['Position']['position']; ?></option>
				<?php  }	}	?>
                </select> 	
           	  </ul>	
              
              <ul class="indexSkills" style="height:auto;">
              	<li class="Caption">Targeted Job Type :  </li>
            	<select id="TR_jobtype" name="data[Client][job_type]" class="selectbox">
                	<option value="">Select Job Type</option>
                    <?php foreach($job_types as $job)
					{
						if($exist_data['job_type']==$job['Jobtype']['id']) { ?>
							<option value="<?php echo $job['Jobtype']['id'];?>" selected><?php echo $job['Jobtype']['job_type'];?></option>
					<?php 	}else { ?>
							<option value="<?php echo $job['Jobtype']['id'];?>"><?php echo $job['Jobtype']['job_type'];?></option>
				<?php  }	}	?>
                </select> 	
           	  </ul>	
              
               <ul class="indexSkills" style="height:auto;">
              	<li class="Caption">Targeted Job Function : </li>
            	<select id="TR_jobfunction" name="data[Client][job_function]" class="selectbox">
                	<option value="">Select Job Function</option>
                    <?php foreach($job_functions as $func)
					{
						if($exist_data['job_function']==$func['Jobfunction']['id']) { ?>
							<option value="<?php echo $func['Jobfunction']['id'];?>" selected><?php echo $func['Jobfunction']['job_function'];?></option>
					<?php 	}else { ?>
							<option value="<?php echo $func['Jobfunction']['id'];?>"><?php echo $func['Jobfunction']['job_function'];?></option>
				<?php  }	}	?>
                </select> 	
           	  </ul>	
              
             
              
              </fieldset>    
              
              </section>
               <section class="job_descrip_box" style="height: 134px;">
              <p class="pText" align="center">TIP: The type of position you are targeting is often applicable to many different industries. Be open to the possibility of working in different industries. This will increase the number of job opportunities available to you.</p>    
              <span class="btn_row" style="padding-top:15px;">
              <!--<input type="submit" class="save_btn" value="SAVE &amp; NEXT" onclick="return save_step6();"/>-->
              <a href="javascript://" onclick="save_step6();" class="save_btn">SAVE &amp; NEXT</a>
              <!--<a href="#" class="skip_btn">SKIP ></a>-->
              </span>
               </section>
             
      
  </section>
   </form>
  <ul class="pop_up_paging">
  	<?php echo $this->element('profile_steps');?>
  </ul>

<script language="javascript">
$(document).ready(function(e) {
     $("html, body").animate({ scrollTop: 110 }, 600);
});

function save_step6()
{		
	
	var industry1=$('#TR_industry').val();
	var industry2=$('#TR_industry2').val();
	var industry3=$('#TR_industry3').val();
	var position=$('#TR_position').val();
	var jobtype=$('#TR_jobtype').val();
	var jobfunc=$('#TR_jobfunction').val();
	
	if(industry1==''||industry2==''||industry3==''){
			$('#select_err').html('Please select industry');
			$('#select_err').show();
	}else if(position==''){
			$('#select_err').html('Please select position');
			$('#select_err').show();
	}else if(jobtype==''){
			
			$('#select_err').html('Please select job type');
			$('#select_err').show();
	}else if(jobfunc==''){
			$('#select_err').html('Please select job function');
			$('#select_err').show();
	}else
	{
				$.post("<?php echo SITE_URL; ?>/clients/profile_step6",$('#step6Form').serialize(),function(data){	
					$("#step1").html(data);
				
				});
				
	}
			
}
function step(num)
{
	clientid=$('#clientid').val();
	$.post("<?php echo SITE_URL; ?>/clients/profile_step"+num,'cl_id='+clientid,function(data){	
					$("#step1").html(data);
				
			});	
	
}
</script>