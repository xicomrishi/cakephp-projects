 
	  <section class="tabing_container">

<section class="top_sec pad2">
          <section class="left_sec"><h3> Add/Update Coach Card</h3>
            </section>
          <div id="msg" class="success"></div>
        </section>
<section class="coach_card">

        <form action="frmCard" id="frmCard" name="frmCard"><fieldset>
        <input type="text" name="company_name" value="<?php if(isset($card['company_name'])) echo $card['company_name']; else echo "Company Name*";?>" onblur="if(this.value=='')this.value='Company Name*'" onFocus="if(this.value=='Company Name*')this.value=''" class="required input">
        
		<div class="inputdiv" style="color:#21527F"><label>Opportunity</label> <input class="radio" type="radio" name="opportunity"  value="I" <?php if(isset($card['opportunity']) && $card['opportunity']=="I") echo "checked";?>> Information Interview <input class="radio" type="radio" name="opportunity" value="J" <?php if(!isset($card['opportunity'])&&(!isset($card['position_available']))){echo 'checked';}?> <?php if(isset($card['opportunity']) && $card['opportunity']=="J") echo "checked";?>> Job</div>
        <input type="text" name="position_available" value="<?php if(isset($card['position_available'])) echo $card['position_available']; else echo "Position Available*";?>" onblur="if(this.value=='')this.value='Position Available*'" onFocus="if(this.value=='Position Available*')this.value=''" class="input required">
         <input type="text" name="job_url" value="<?php if(!empty($card['job_url'])){  echo $card['job_url']; }else{ echo "Job URL*";} ?>" onblur="if(this.value=='http://')this.value='Job URL*'" onFocus="if(this.value=='Job URL*')this.value='http://'" class="input required">
		<!-- div class="inputdiv">
		Contact <input type="radio" onclick="AssociateNow(1);" value="1" name="add_contact" > Associate Now <input type="radio" name="AssociateNow(0)" value="0"> Associate Later</div -->
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
		<div class="inputdiv"><label class="pad">Country</label> <select name="country" onchange="changestate(this.value);">
										<?php foreach($countries as $key=>$country){
											if(isset($card['country']) && $card['country']==$key)
												echo "<option value='$key' selected>$country</option>";
											else
												echo "<option value='$key'>$country</option>";
										}
										?>
									   </select>	
									   </div>
									   
		    <div class="inputdiv" id="td_state"><input type="text" name="state" value="<?php if(isset($card['state']) && $card['state']!='') echo $card['state']; else echo "State/Province";?>" onblur="if(this.value=='')this.value='State/Province'" onFocus="if(this.value=='State/Province')this.value=''" class="input"></div>
		    <input type="text" name="city" value="<?php if(isset($card['city']) && $card['city']!='') echo $card['city']; else echo "City";?>" onblur="if(this.value=='')this.value='City'" onFocus="if(this.value=='City')this.value=''" class="input">
		<div class="inputdiv"><label class="pad">Application Deadline</label> <input class="input" type="text" name="application_deadline" value="<?php if(isset($card['application_deadline'])) echo $card['application_deadline'];?>" readonly id="application_deadline" />

									   </div>
<textarea style="height:140px;" name="special_instruction" class="input" onfocus='if(this.value=="Special Instructions"){ this.value="";}' onblur="if(this.value==''){ this.value='Special Instructions';}"><?php if(isset($card['special_instruction'])) echo $card['special_instruction'];else echo "Special Instructions";?></textarea>
										   
        <div class="common_btn"><a href="javascript://" onclick="saveCard()" style="margin:0 20px 0 0 !important;">save</a></div></fieldset></form></section>
		</section>
<script type="text/javascript">
$(document).ready(function(){
	$("html, body").animate({ scrollTop: $('.inner_body').offset().top }, 1000);
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
		if(frm.position_available.value=="Position Avaialble*")
			alert("Please enter Position Available");
		else
		{
			if(frm.job_url.value=="Job URL*"||frm.job_url.value=="http://")
				alert("Please enter Job URL");
			else
			{	
			$.post('<?php echo SITE_URL;?>/Coachcards/saveCard<?php if(isset($card)) echo "/$card[id]"; else echo "/0";?>',$('#frmCard').serialize(),function(data){
			if(data=="")
			{
				document.getElementById('frmCard').reset();
				show_search();
				//$('#msg').html("Card saved successfully.");
				//$("html, body").animate({ scrollTop: $('.inner_body').offset().top }, 1000);	
				//setTimeout(function(){$('#msg').hide();},3000);

			}
			else
			{
				$('#msg').removeClass('success');
				$('#msg').addClass('error');
				$('#msg').html("There is some error. Please check your data");
				$("html, body").animate({ scrollTop: $('.inner_body').offset().top }, 1000);	
				setTimeout(function(){$('#msg').hide();},3000);
			}
			});
			}
		}
		
	}
}
function changestate(val)
{
if(val=="US" || val=="CA"){
	$.post("<?php echo SITE_URL; ?>/cards/list_state","country="+val+"&type=state",function(data){
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
<?php $this->Js->writeBuffer(); ?>