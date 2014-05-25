
<section class="tabing_container">
<?php if($this->Session->read('usertype')!=4 ){?>
	<section class="top_sec pad2">
          <section class="left_sec"><h3> Add/Update <?php if($this->Session->read('usertype')==4 || isset($employer))echo "Consltant"; else if($this->Session->read('usertype')==0) echo "Admin"; elseif($this->Session->read('usertype')==1) echo "Agency"; ?> Card</h3>
            </section>          
    </section>
  <?php } ?>     
<section class="coach_card">
<div id="msg" class="success"></div>
        <form action="frmCard" id="frmCard" name="frmCard"><fieldset>
        <input type="hidden" id="share_all_card" name="share_all" value="<?php if(isset($card['share_all'])) echo $card['share_all']; elseif($this->Session->read('usertype')=='4')echo '1'; else '0';?>"/>
        <input type="hidden" id="account_id" name="account_id" value="<?php if(isset($card['account_id'])) echo $card['account_id']; else echo $this->Session->read('Account.id');?>"/> 
        <input type="hidden" id="usertype" name="usertype" value="<?php if(isset($card['usertype'])) echo $card['usertype']; else echo $this->Session->read('usertype');?>"/>                
        <input type="text" name="company_name" value="<?php if(isset($card['company_name'])) echo $card['company_name']; else echo "Company Name*";?>" onblur="if(this.value=='')this.value='Company Name*'" onFocus="if(this.value=='Company Name*')this.value=''" class="required input">         		
        <input type="text" name="position_available" value="<?php if(isset($card['position_available'])) echo $card['position_available']; else echo "Job Title*";?>" onblur="if(this.value=='')this.value='Job Title*'" onFocus="if(this.value=='Job Title*')this.value=''" class="input required">
        
        <input type="text" id="job_url" name="job_url" value="<?php if(isset($card['job_url'])) echo $card['job_url']; else echo "Job Details URL";?>" onblur="if(this.value=='')this.value='Job Details URL'" onfocus="if(this.value=='Job Details URL')this.value=''" class="url input" />
        
		
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
		<div class="inputdiv"><label class="pad">Job Type</label> <select name="job_type_o">
										<?php foreach($job_type as $key=>$type){
											if(isset($card['job_type_o']) && $card['job_type_o']==$key)
												echo "<option value='$key' selected>$type</option>";
											else
												echo "<option value='$key'>$type</option>";
										}
											?>
									   </select>	
									   </div>
		<div class="inputdiv"><label class="pad">Country</label> <select name="country"  onchange="changestate(this.value,'');">
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
        <input type="text" name="salary" value="<?php if(isset($card['salary'])&& $card['salary']!='' ) echo $card['salary']; else echo "Salary";?>" onblur="if(this.value=='')this.value='Salary'" onFocus="if(this.value=='Salary')this.value=''" class="input">
                                       
<textarea name="job_description" class="input" onfocus="if(this.value=='Job Description') this.value='';" onblur="if(this.value=='') this.value='Job Description';"><?php if(isset($card['job_description']) && !empty($card['job_description'])) echo $card['job_description'];else echo "Job Description";?></textarea>
<textarea name="how_to_apply" class="input" onfocus="if(this.value=='How to Apply') this.value='';" onblur="if(this.value=='') this.value='How to Apply';"><?php if(isset($card['how_to_apply']) && !empty($card['how_to_apply'])) echo $card['how_to_apply'];else echo "How to Apply";?></textarea>
<textarea name="job_requirement" class="input" onfocus="if(this.value=='Job Requirement') this.value='';" onblur="if(this.value=='') this.value='Job Requirement';"><?php if(isset($card['job_requirement']) && !empty($card['job_requirement'])) echo $card['job_requirement'];else echo "Job Requirement";?></textarea>
        <input type="text" name="contact_name" value="<?php if(isset($card['contact_name']) && !empty($card['contact_name'])) echo $card['contact_name'];elseif($this->Session->read('usertype')=='4') echo $this->Session->read('Employer.Employer.name'); else echo "Contact Name";?>" onblur="if(this.value=='')this.value='Contact Name'" onFocus="if(this.value=='Contact Name')this.value=''" class="input">
        <input type="text" name="email" value="<?php if(isset($card['email']) && !empty($card['email'])) echo $card['email']; elseif($this->Session->read('usertype')=='4') echo $this->Session->read('Employer.Employer.email'); else echo "Contact Email";?>" onblur="if(this.value=='')this.value='Contact Email'" onFocus="if(this.value=='Contact Email')this.value=''" class="input">
        <input type="text" name="phone" value="<?php if(isset($card['phone']) && !empty($card['phone'])) echo $card['phone']; else echo "Contact Phone";?>" onblur="if(this.value=='')this.value='Contact Phone'" onFocus="if(this.value=='Contact Phone')this.value=''" class="input">
        <input type="text" name="address" value="<?php if(isset($card['address']) && !empty($card['address'])) echo $card['address']; else echo "Contact Address";?>" onblur="if(this.value=='')this.value='Contact Address'" onFocus="if(this.value=='Contact Address')this.value=''" class="input">
<textarea name="information" class="input" onfocus="if(this.value=='Contact Information') this.value='';" onblur="if(this.value=='') this.value='Contact Information';"><?php if(isset($card['information']) && !empty($card['information'])) echo $card['information'];else echo "Contact Information";?></textarea>
<input type="hidden" name="coach_ids" id="coach_ids" />
<input type="hidden" name="client_ids" id="client_ids" />
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
			<?php if(isset($card) || $this->Session->read('usertype')==0 || $this->Session->read('usertype')==4) echo "confirmCard();"; else{?>
			loadPopup('<?php echo SITE_URL;?>/cards/share_card')
			<?php }?>
		}
	}
}

function confirmCard(){
			$.post('<?php echo SITE_URL;?>/cards/saveCard<?php if(isset($card)) echo "/$card[id]"; else echo "/0"; if(isset($agency_id)) echo "/".$agency_id;?>',$('#frmCard').serialize(),function(data){		
			
			if(data=="")
			{
				$('#msg').html("Card saved successfully.");
				window.scrollTo(100,100);
				setTimeout(function(){
				<?php  if($this->Session->read('usertype')==4) echo " show_content(4);";	else echo "show_search();";?>
				},3000);
			}
			else
			{
				$('#msg').html("There is some error. Please check your data");				
			}
			});
}
function changestate(val,state_val)
{
if(val=="US" || val=="CA"){
	$.post("<?php echo SITE_URL; ?>/cards/list_state","country="+val+"&state="+state_val,function(data){
	$("#td_state").html(data);
		$('#td_state').attr('class','inputdiv');
	})
	}else{
		if(state_val=='') state_val="State/Province";		
	$("#td_state").html('<input type="text" name="state" value="'+state_val+'" onblur="if(this.value==\'\')this.value=\'State/Province\'" onFocus="if(this.value==\'State/Province\')this.value=\'\'" class="input">');
	$('#td_state').attr('class','');
	}
}
<?php if(isset($card['country'])) echo "changestate('$card[country]','$card[state]')"; else echo "changestate('US','')";?>
</script>		
<?php $this->Js->writeBuffer(); ?>