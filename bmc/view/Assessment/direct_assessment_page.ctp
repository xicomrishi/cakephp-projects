<div class="wrapper">  
  <section id="body_container">
  <div class="container" style="height:115px; min-height:115px;">
	<div class="tab_detail">
    <h3 class="title"><?php echo $course['Course']['course_name']; ?></h3>
    <div  style="padding:20px; height:50px; text-align:center; margin-top:45px;">
     <div>Select your Role : 
  		<select id="as_role" onchange="show_questions(this.value,'<?php echo $course['Course']['id']; ?>','<?php echo $course['Course']['trainer_id']; ?>');">
        	<option value="">Select Role</option>
            <option value="3">Project Manager</option>
            <option value="4">Team Member</option>
            <option value="5">Manager of Project Managers</option>
  		</select>
   </div>
    </div>
    </div>
  </div>

   
   <div id="questions_set"></div>	
  </section>
</div>
<script type="text/javascript">

$(document).ready(function(e) {
    $('#as_role').val('');
});

function show_questions(val,cr_id,tr_id)
{
	if(val!='')
	{
		showLoading('#questions_set');
		$.post('<?php echo $this->webroot; ?>assessment/participant_assessment_questions/'+val+'/'+cr_id+'/'+tr_id,function(data){
			$('#questions_set').html(data);
		});
	}
}
</script>