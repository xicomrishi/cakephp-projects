 
	  <section class="tabing_container">

<section class="top_sec pad2">
          <section class="left_sec"><h3> Add/Update Agency Card</h3>
            </section>
          
        </section>
<section class="coach_card">
<div id="msg" class="success"></div>
        <form action="frmCard" id="frmCard" name="frmCard"><fieldset>
        <input type="text" name="company_name" value="<?php if(isset($card['company_name'])) echo $card['company_name']; else echo "Company Name*";?>" onblur="if(this.value=='')this.value='Company Name*'" onFocus="if(this.value=='Company Name*')this.value=''" class="required input">
		
        <input type="text" name="position_available" value="<?php if(isset($card['position_available'])) echo $card['position_available']; else echo "Job Title*";?>" onblur="if(this.value=='')this.value='Job Title*'" onFocus="if(this.value=='Job Title*')this.value=''" class="input required">
		
		<div class="inputdiv"><label class="pad">Industry</label> <select name="industry" class="required">
										<?php foreach($industries as $key=>$industry){
											if(isset($card['industry']) && $card['industry']==$key)
												echo "<option value='$key' selected>$industry</option>";
											else
												echo "<option value='$key' >$industry</option>";
										}
										?>
									   </select>	
									   </div>
		<div class="inputdiv"><label class="pad">Position Level</label> <select name="position_level">
										<?php foreach($position_levels as $key=>$position){
											if(isset($card['position_level']) && $card['position_level']==$key)
												echo "<option value='$key' selected>$position</option>";
											else
												echo "<option value='$key' >$position</option>";
										}
										?>
									   </select>	
									   </div>
		<div class="inputdiv"><label class="pad">Job Function</label> <select name="job_function">
										<?php foreach($job_function as $key=>$function){
											if(isset($card['job_function']) && $card['job_function']==$key)
												echo "<option value='$key' selected>$function</option>";
											else
												echo "<option value='$key' >$function</option>";
										}
										?>
									   </select>	
									   </div>
		<div class="inputdiv"><label class="pad">Job Type</label> <select name="job_type">
										<?php foreach($job_type as $key=>$type){
											if(isset($card['job_type']) && $card['job_type']==$key)
												echo "<option value='$key' selected>$type</option>";
											else
												echo "<option value='$key'>$type</option>";
										}
											?>
									   </select>	
									   </div>
		<div class="inputdiv"><label class="pad">Country</label> <select name="country"  onchange="changestate(this.value);">
										<?php foreach($countries as $key=>$country){
											if(isset($card['country']) && $card['country']==$key)
												echo "<option value='$key' selected>$country</option>";
											else
												echo "<option value='$key'>$country</option>";
										}
										?>
									   </select>	
									   </div>
									   
		   <div class="inputdiv" id="td_state"> <input type="text" name="state" value="<?php if(isset($card['state']) && $card['state']!='') echo $card['state']; else echo "State/Province";?>" onblur="if(this.value=='')this.value='State/Province'" onFocus="if(this.value=='State/Province')this.value=''" class="input"></div>
		    <input type="text" name="city" value="<?php if(isset($card['city']) && $card['city']!='') echo $card['city']; else echo "City";?>" onblur="if(this.value=='')this.value='City'" onFocus="if(this.value=='City')this.value=''" class="input">
		<div class="inputdiv"><label class="pad">Application Deadline</label> <input class="input" type="text" name="application_deadline" value="<?php if(isset($card['application_deadline'])) echo $card['application_deadline'];?>" readonly id="application_deadline" />

									   </div>
        <input type="text" name="salary" value="<?php if(isset($card['salary'])) echo $card['salary']; else echo "Salary";?>" onblur="if(this.value=='')this.value='Salary'" onFocus="if(this.value=='Salary')this.value=''" class="input">
                                       
<textarea name="job_description" class="input" onfocus="if(this.value=='Job Description') this.value='';" onblur="if(this.value=='') this.value='Job Description';"><?php if(!empty($card['job_description'])) echo $card['job_description'];else echo "Job Description";?></textarea>
<textarea name="how_to_apply" class="input" onfocus="if(this.value=='How to Apply') this.value='';" onblur="if(this.value=='') this.value='How to Apply';"><?php if(!empty($card['how_to_apply'])) echo $card['how_to_apply'];else echo "How to Apply";?></textarea>
<textarea name="job_requirement" class="input" onfocus="if(this.value=='Job Requirement') this.value='';" onblur="if(this.value=='') this.value='Job Requirement';"><?php if(!empty($card['job_requirement'])) echo $card['job_requirement'];else echo "Job Requirement";?></textarea>
        <input type="text" name="contact_name" value="<?php if(!empty($card['contact_name'])) echo $card['contact_name']; else echo "Contact Name";?>" onblur="if(this.value=='')this.value='Contact Name'" onFocus="if(this.value=='Contact Name')this.value=''" class="input">
        <input type="text" name="email" value="<?php if(!empty($card['email'])) echo $card['email']; else echo "Contact Email";?>" onblur="if(this.value=='')this.value='Contact Email'" onFocus="if(this.value=='Contact Email')this.value=''" class="input">
        <input type="text" name="phone" value="<?php if(!empty($card['phone'])) echo $card['phone']; else echo "Contact Phone";?>" onblur="if(this.value=='')this.value='Contact Phone'" onFocus="if(this.value=='Contact Phone')this.value=''" class="input">
        <input type="text" name="address" value="<?php if(!empty($card['address'])) echo $card['address']; else echo "Contact Address";?>" onblur="if(this.value=='')this.value='Contact Address'" onFocus="if(this.value=='Contact Address')this.value=''" class="input">
<textarea name="information" class="input" onfocus="if(this.value=='Contact Information') this.value='';" onblur="if(this.value=='') this.value='Contact Information';"><?php if(!empty($card['information'])) echo $card['information'];else echo "Contact Information";?></textarea>

        <div class="common_btn"><a href="javascript://" onclick="saveCard()">save</a></div></fieldset></form></section>
		</section>
<script type="text/javascript">
$(document).ready(function(){
	var to_day=new Date();
	$( "#application_deadline" ).datepicker({
			changeMonth: true,
			changeYear: true,
			 minDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate()),
			yearRange: 'c:+1',
			dateFormat: 'yy-mm-dd'
			
			
		});

	
	$('#application_deadline').keyup(function(e) {
    if(e.keyCode == 8 || e.keyCode == 46) {
        $.datepicker._clearDate(this);
    }
});	
	});
function saveCard()
{
frm=document.frmCard;
	if(frm.company_name.value=="Company Name*")
		alert("Please enter Company Name");
	else{
		if(frm.position_available.value=="Job Title*")
			alert("Please enter Job Title");
		else
		{
			<?php if(!isset($card)){?>
			y=confirm('After clicking on OK, this card will be saved and shared with all clients/coaches whereas if you click on the Cancel button this card will be saved and you can choose to whom this card will be shared from your Job card Search section.');
			if(y==true)
				y=1;
			else
				y=0;
			$.post('<?php echo SITE_URL;?>/Agencycards/saveCard<?php if(isset($card)) echo "/$card[id]"; else echo "/0";?>',$('#frmCard').serialize()+"&share_all="+y,function(data){<?php }else{?>
			$.post('<?php echo SITE_URL;?>/Agencycards/saveCard<?php if(isset($card)) echo "/$card[id]"; else echo "/0";?>',$('#frmCard').serialize(),function(data){		
			<?php }?>
			if(data=="")
			{
				$('#msg').html("Card saved successfully.");
show_search();
			}
			else
			{
				$('#msg').html("There is some error. Please check your data");
			}
			});
		}
		
	}
}
function changestate(val)
{
if(val=="US" || val=="CA"){
	$.post("<?php echo SITE_URL; ?>/agencycards/list_state","country="+val+"&type=state",function(data){
	$("#td_state").html(data);
		$('#td_state').attr('class','inputdiv');
	})
	}else{
	$("#td_state").html('<input type="text" name="state" value="State/Province" onblur="if(this.value==\'\')this.value=\'State/Province\'" onFocus="if(this.value==\'State/Province\')this.value=\'\'" class="input">');
	$('#td_state').attr('class','');
	}
}
<?php if(isset($card['country'])) echo "changestate('$card[country]')"; else echo "changestate('US')";?>
</script>		
<?php $this->Js->writeBuffer();