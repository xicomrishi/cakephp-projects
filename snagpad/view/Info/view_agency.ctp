<?php echo $this->Html->script(array('datepicker/jquery.ui.core.min','datepicker/jquery.ui.datepicker.min'));
	echo $this->Html->css(array('datepicker/jquery.ui.core.min','datepicker/jquery.ui.datepicker.min','datepicker/jquery.ui.theme.min','datepicker/jquery-ui.min','datepicker/demos'));
?>
<section class="tabing_container">
<?php if(isset($agency)){?>
        <section class="tabing" style="margin:12px 0 0 0">
          <ul class="gap">
           
            <li id="li_1" class="active li_con"><a href="javascript://" onclick="show_content(1)"><?php echo $agency['name'];?></a></li>
          	<li id="li_2" class='li_con'><a href="javascript://" onclick="show_content(2)">More Info</a></li>
<?php if($this->Session->check('usertype') && $this->Session->read('usertype')=='4'){?>            
            <li id="li_3" class='li_con'><a href="javascript://" onclick="show_content(3);">Add Card</a></li>
            <li id="li_4" class='li_con'><a href="javascript://" onclick="show_content(4)">My Cards</a></li>

<?php }?>            
          </ul>
        </section>
    
<section class="cms_page_detail" id="maindiv">
<div class="description" id="div_1">
       <?php if($agency['thumb']!='') echo "<img src='".SITE_URL."/logo/$agency[thumb]' align='left'> "; echo $agency['description'];?>

       <div id="contact_usForm">
        <div class="row">
        <?php if(!$this->Session->check('usertype') || $this->Session->read('usertype')!='4'){?>
        <input type="button" value="Sign Up as Job Seeker" class="botton" onclick="loadPopup('<?php echo SITE_URL;?>/users/signup/3/<?php echo $agency['account_id'];?>')" />
       <!-- <input type="button" value="Login as Employer" class="botton" onclick="loadPopup('<?php echo SITE_URL;?>/users/login/4')" />-->
        <?php }?>
        </div>
        </div>
</div>
<div class="description" id="div_2">
       <?php if($agency['thumb']!='') echo "<img src='".SITE_URL."/logo/$agency[thumb]' align='left'> "; echo $agency['specification'];?>

       <div id="contact_usForm">
        <div class="row">
        <?php if(!$this->Session->check('usertype') || $this->Session->read('usertype')!='4'){?>
        <input type="button" value="Sign Up as Job Seeker" class="botton" onclick="loadPopup('<?php echo SITE_URL;?>/users/signup/3/<?php echo $agency['account_id'];?>')" />
        <!--<input type="button" value="Login as Employer" class="botton" onclick="loadPopup('<?php echo SITE_URL;?>/users/login/4')" />-->
        <?php }?>
        </div>
        </div>
</div>

        <div class="div_add description" id="div_3">
        <section class="coach_card">
<div id="msg"></div>
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
<input type="hidden" name="coach_ids" id="coach_ids" />
<input type="hidden" name="client_ids" id="client_ids" />
        <div class="common_btn"><a href="javascript://" onclick="saveCard()">save</a></div></fieldset></form></section>
        </div>
        
        <div class="description" id="div_4">
        </div>
       </section>
<script type="text/javascript">
var jobid=0;
function show_content(id){
	if(id==4)
		$('#maindiv').attr('class','cms_page_detail none');
	else
		$('#maindiv').attr('class','cms_page_detail');
		$('.description').hide();
		switch(id)
		{
		case 4:
			$.post("<?php echo SITE_URL; ?>/cards/search",'',function(data){	
if(data=='Error')
$("#div_4").html('There is some error.');
else
$('#div_4').html(data);
})
break;
case 3: $.post("<?php echo SITE_URL; ?>/cards/addCard/"+jobid+"/<?php echo $agency['account_id'];?>",'',function(data){	
$("#div_3").html(data);
});	
break;
		}
		$('#div_'+id).show();
		$('.li_con').removeClass('active');
		$('#li_'+id).addClass('active');
  	    $("html, body").animate({ scrollTop: 0 }, 600);	
	
}
	show_content('1');

</script>       
       <?php }else{?>    
<section class="cms_page_detail"> 
<div class="description">
<p>Agency Not found</p></div></section>       
<?php }?>       
       </section>
 <script type="text/javascript">

function show_add(id){
	jobid=id;
	show_content(3);
}
</script>
