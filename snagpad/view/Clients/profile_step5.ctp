<div id="step">
<?php echo $this->element('profile_progress');?>
<section class="show_loading_img">
<section class="head_row">
  <h3>Your location</h3>
  <p>Enter your location information so that jobs and connections can be identified automatically for you.</p>
  </section>
  <form id="step5Form" name="step5Form" action="">
  <section class="pop_up_detail">
  
 			<div id="select_err" align="center" style="display:none;"></div>
             
              
              <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
            
               <!--<ul class="indexSkills1" style="height:auto;">
              	<li class="Caption"> Sex :</li>
            	<select id="TR_gender" name="data[Client][gender]" class="selectbox">
                	<option value="">Select gender</option>
                    <?php foreach($var_gender as $gender)
					{
						if($exist_data['gender']==$gender)
							echo "<option value='$gender' selected>$gender</option>";
						else
							echo "<option value='$gender'>$gender</option>";
					}	?>
                </select> 	
           	  </ul>	-->
              <!--<ul class="indexSkills1" style="height:auto;">
                  <li class="Caption">Date of Birth : </li>
                   <li class="CapText"><input type="text" id="tr_dob" name="data[Client][dob]" class="TR_dob" readonly="" value="<?php echo $exist_data['dob'];?>" /></li>
                </ul>-->
                <div id="inlineDatepicker"></div>
  
                
               <ul class="indexSkills1"  style="height:auto;">
              	<li class="Caption">Country : </li>
                 <li class="CapText"> <select id="tr_country" name="data[Client][country]" onchange="changestate(this.value);" class="selectbox">
                 <option value="">Select country</option>
                 <?php foreach($countries as $country)
                    {
                        if($exist_data['country']==$country['Country']['country_code']) { ?>
                            <option value="<?php echo $country['Country']['country_code'];?>" selected><?php echo $country['Country']['country'];?></option>
                      <?php   }else{ ?>
                           <option value="<?php echo $country['Country']['country_code'];?>"><?php echo $country['Country']['country'];?></option>
                   <?php } }?>
			</select></li>
               </ul>
               <ul class="indexSkills1"  style="height:auto;">
                    <li class="Caption"> State/Province :</li>
                    <li class="CapText" id="td_state"><?php if($exist_data['country']=='US')
							{	
								echo "<select id='tr_state' name='data[Client][state]' class='selectbox'>";
								echo "<option value='0'>Select State/Province</option>";
									foreach($US_states as $US_state)
									{
										if($exist_data['state']==$US_state['State']['state']) { ?>
										<option value="<?php echo $US_state['State']['state'];?>" selected><?php echo $US_state['State']['state'];?></option>
									 <?php   }else{ ?>
											<option value="<?php echo $US_state['State']['state'];?>"><?php echo $US_state['State']['state'];?></option>
								 <?php } }
								echo "</select>";
                                
                                 }elseif( $exist_data['country']=="CA") {  
										echo "<select id='tr_state' name='data[Client][state]' class='selectbox'>";
										echo "<option value='0'>Select State/Province</option>";
											foreach($CA_states as $CA_state)
											{
												if($exist_data['state']==$CA_state['State']['state']) { ?>
													<option value="<?php echo $CA_state['State']['state'];?>" selected><?php echo $CA_state['State']['state'];?></option>
											 <?php   }else{ ?>
													<option value="<?php echo $CA_state['State']['state'];?>"><?php echo $CA_state['State']['state'];?></option>
										 <?php } }
										echo "</select>";
										
									}else
								echo "<input type='text' id='tr_state' name='data[Client][state]' value='$exist_data[state]'>";
				?>  
                   </li>
                </ul>
                	<ul class="indexSkills1"  style="height:auto;">
                        <li class="Caption">City of Residence :</li>
                        <li class="CapText"><input type="text" id="tr_city" name="data[Client][city]" value="<?php echo $exist_data['city'];?>"/>
                         </li>
                    </ul>
                    
                    <ul class="indexSkills1"   style="height:auto;">
                        <li class="Caption">Zip Code/Postal Code : </li>
                        <li class="CapText"><input id="tr_zip" type="text" name="data[Client][postalcode]" value="<?php echo $exist_data['postalcode'];?>" maxlength="10">
                        </li>
                    </ul>
               
               
                  <section class="job_descrip_box" style="height:40px">
              <span class="btn_row">
              <!--<input type="submit" class="save_btn" value="SAVE &amp; NEXT" onclick="return save_step5();"/>-->
              <a href="javascript://" onclick="save_step5();" class="save_btn">SAVE &amp; NEXT</a>
              <?php //if($skip=='1') { ?>
              <a href="javascript://" class="skip_btn" onclick="step('6')">SKIP ></a>
              <?php //} ?>
              </span>
			  </section>
               </section>
             

   </form>
   </section>
  <ul class="pop_up_paging">
	<?php echo $this->element('profile_steps');?>
  </ul>
</div>

<script language="javascript">

	$(document).ready(function(e) {
		
     $("html, body").animate({ scrollTop: 0 }, 600);
   // $('.TR_dob').datepick();
	/*$('.inlineDatepicker').datepick({
		yearRange: '1950:2002', 
		//showTrigger: '.TR_dob',
		onSelect: showDate});*/	
		
	
		$( ".TR_dob" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '1950:2002'
			//showOn: ("focus")
		});
	
		$('.TR_dob').keyup(function(e) {
    if(e.keyCode == 8 || e.keyCode == 46) {
        $.datepicker._clearDate(this);
    }
});	
	
	});	
function changestate(val)
{
if(val=="US" || val=="CA"){
	$.post("<?php echo SITE_URL; ?>/clients/list_state","country="+val+"&type=state",function(data){
	$("#td_state").html(data);
	})
	}else{
	$("#td_state").html('<input type="text" id="tr_state" name="data[Client][state]">');
	}
}


function save_step5()
{		
	//alert(1);
	var gender=$('#TR_gender').val();
	var dob=$('#tr_dob').val();
	var country=$('#tr_country').val();
	//alert(country);
	var state=$('#tr_state').val();
	//alert(state);
	var city=$('#tr_city').val();
	var zip=$('#tr_zip').val();
	
	if(gender==''){
			$('#select_err').html('Please select gender');
			$('#select_err').show();
	}else if(dob==''){
			$('#select_err').html('Please select date of birth');
			$('#select_err').show();
	}else if(country==''){
			$('#select_err').html('Please select country');
			$('#select_err').show();
	}else if(state==''||state=='0'){
			if(country=='US'||country=='CA'){$('#select_err').html('Please select state'); }
			else{ $('#select_err').html('Please enter state'); }
				
			$('#select_err').show();
	}else if(city==''){
			
			$('#select_err').html('Please enter city');
			$('#select_err').show();
	}else if(zip==''){
			$('#select_err').html('Please enter postal code');
			$('#select_err').show();
	}else
	{
				var step5form=$('#step5Form').serialize();
				$(".show_loading_img").html('<div class="back_scroll"><?php echo $this->Html->image('loading.gif',array('escape'=>false));?></div>');
				$.post("<?php echo SITE_URL; ?>/clients/profile_step5",step5form,function(data){	
					$("#step1").html(data);
				
				});
				
	}
		
			
}

function step(num)
{
	var clientid=$('#clientid').val();
	$(".show_loading_img").html('<div class="back_scroll"><?php echo $this->Html->image('loading.gif',array('escape'=>false));?></div>');
	$.post("<?php echo SITE_URL; ?>/clients/profile_step"+num,'cl_id='+clientid,function(data){	
					$("#step1").html(data);
				
			});	
	
}
</script>