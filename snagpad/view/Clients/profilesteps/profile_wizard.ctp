<div id="step1">
<section class="head_row">
  <h3>Enter Job A</h3>
  <p>Knowing what job you're looking for is important for staying focused in your job search. Enter the Job Title below for the job you're most interested in getting. Moving forward you will now refer to this job as Job A.</p>
  </section>
  <section class="pop_up_detail border">
 
              <section class="job_descrip_box">
              <?php echo $this->Form->create('Client',array('id'=>'ClientProfileWizardForm'));?>
              <!--<form  class="stepForm" name="stepForm" action="">-->
              <fieldset>
               <input type="hidden" name="clientid" value="<?php echo $clientid;?>"/>
              <?php echo $this->Form->input('Client.id',array('type'=>'hidden'));?>
              <?php echo $this->Form->input('Client.job_a_title',array('type'=>'text','label'=>false,'class'=>'required'));?>
              </fieldset>
              </form>
              <p>TIP: It's important to indicate your ideal job so that when you're using your job<br> search board and networking with contacts they are clear on what kind of job<br> you're looking for.</p>
              <span class="btn_row">
              <input type="submit" class="save_btn" onclick="save_step();" value="SAVE &amp; NEXT"/>
              <!--<a href="javascript://" onclick="save_step();" class="save_btn">SAVE &amp; NEXT</a>-->
              <!--<a href="#" class="skip_btn">SKIP ></a>-->
              </span>
              </section>
      
  </section>
 <ul class="pop_up_paging">
	  <li class="active"><a href="javascript://" onclick="step('1')">1</a></li>
	  <li><a href="javascript://" onclick="step('2')">2</a></li>
	  <li><a href="javascript://" onclick="step('3')">3</a></li>
	  <li><a href="javascript://" onclick="step('4')">4</a></li>
	  <li><a href="javascript://" onclick="step('5')">5</a></li>
	  <li><a href="javascript://" onclick="step('6')">6</a></li>
       <li><a href="javascript://" onclick="step('7')">7</a></li>
  </ul>
</div>
<script language="javascript">
$(document).ready(function(e) {
    $("#ClientProfileWizardForm").validate({
		debug:false
	});
});
function save_step()
{		
		$.post("<?php echo SITE_URL; ?>/clients/add_step",$('#ClientProfileWizardForm').serialize(),function(data){	
					$("#step1").html(data);
				
				});	
			
}

function step(num)
{	
	$.post("<?php echo SITE_URL; ?>/clients/step"+num,$('#ClientProfileWizardForm').serialize(),function(data){	
					$("#step1").html(data);
				
				});	
	
}
</script>