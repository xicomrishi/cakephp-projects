<div id="step">
<?php echo $this->element('profile_progress');?>
<section class="show_loading_img">
<section class="head_row">
  <h3>Educational background</h3>
  <p>Indicate below your highest level of education obtained. This will help you benchmark your job search activity against similar Job Seekers. This information is not visible or shared with anyone.</p>
  </section>
  <form id="step4Form" name="step4Form" action="">
  <section class="pop_up_detail">
  
 			<div id="select_err" align="center" style="display:none;">Please select Highest education.</div>
              
              
              <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
             
               <ul class="indexSkills1" style="height:auto;">
              	<li class="Caption">Highest Education Level : </li>
                <li class="CapText">
            	<select id="TR_highest_education" name="data[Client][highest_education]" onchange="showeducation();" class="selectbox">
                	<option value="">Select highest education</option>
                    <?php foreach($var_education as $key=>$col)
					{
						if($exist_data['highest_education']==$key)
							echo "<option value='$key' selected>$col</option>";
						else
							echo "<option value='$key'>$col</option>";
					}	?>
                </select></li>	
           	  </ul>	
              <ul class="indexSkills1" id="tr_year" style="height:auto;">
                  <li class="Caption">Year Degree Obtained : </li>
                   <li class="CapText"><select id="degree_obtained" name="data[Client][degree_obtained]" class="selectbox">
                      <?php for($i=date("Y");$i>1920;$i--)
                        {
                            if($exist_data['degree_obtained']==$i) echo "<option value='$i' selected>$i</option>"; 
                            else echo "<option value='$i'>$i</selected>";
                        }									
                        ?>
                    </select></li>
                </ul>
               <ul class="indexSkills1" id="tr_what" style="height:auto;">
              	<li class="Caption">What Year : </li>
                 <li class="CapText"> <select id="degree_type" name="data[Client][degree_type]" onchange="showeducation();" class="selectbox">
                 <?php foreach($var_degree_type as $key=>$col)
                    {
                        if($exist_data['degree_type']==$key)
                            echo "<option value='$key' selected>$col</option>";
                        else
                            echo "<option value='$key'>$col</option>";
                    }?>
			</select></li>
               </ul>
               <ul class="indexSkills1" id="tr_university" style="height:auto;">
                    <li class="Caption"> College/University :</li>
                    <li class="CapText"> <select id="college" name="data[Client][college]" class="selectbox">
                      <?php 
                      
                      foreach($university as $college)
                        {
                            if($exist_data['college']==$college['University']['id']) { ?>
                               <option value="<?php echo $college['University']['id'];?>" selected><?php echo $college['University']['name'];?></option>
                           <?php }else{ ?>
                               <option value="<?php echo $college['University']['id'];?>"><?php echo $college['University']['name'];?></option>
                      <?php }  }?>
                    </select><br />
                    <span class="desc">If College/University not found in selected list,<br><a href='javascript://' onclick="loadPageProfile('div_college')"><b>Click here</b></a></span> 
                     <div id="div_college" class="tool_tip">
                     	<div id="err1" style="display:none;">Please enter College/University Name</div>
                        	
                        	 <ul class="indexSkills" style="height:auto;">
                                <li class="Caption"> College/University :</li>
                                <li class="CapText"> <input id="ex_college" name="ex_college" class="inp_box"/>
                        		</li>
                            </ul>
                            <a href="javascript://" onclick="mail_college();" class="save_btn">Submit</a>&nbsp;
                            <a href="javascript://" onclick="cancel('div_college');" class="save_btn">Cancel</a>
                           
                           
                        </div>	
                     
                   </li>
                </ul>
                	<ul class="indexSkills1" id="tr_major" style="height:auto;">
                        <li class="Caption">Major :</li>
                        <li class="CapText"><select id="major" name="data[Client][major]" class="selectbox">
                                    <option value="0" selected="selected">Not Applicable</option>
                          <?php 
                         
                          foreach($majors as $major)
                            {
                                if($exist_data['major']==$major['Major']['id']) { ?>
                                   <option value="<?php echo $major['Major']['id'];?>" selected><?php echo $major['Major']['major'];?></option>
                             <?php }else{ ?>
                                    <option value="<?php echo $major['Major']['id'];?>"><?php echo $major['Major']['major'];?></option>
                          <?php }  }?>
                        </select><br /> 
                         <span class="desc">If Major not found in selected list, <a href='javascript://' onclick="loadPageProfile('div_major')"><b>Click here</b></a></span> 
                         <div id="div_major"  class="tool_tip">
                         	<div id="err2" style="display:none;">Please enter Major Name</div>
                        	
                        	 <ul class="indexSkills" style="height:auto;">
                                <li class="Caption">Major:</li>
                                <li class="CapText"> <input id="ex_major" name="ex_major" class="inp_box"/>
                        		</li>
                            </ul>
                            <a href="javascript://" onclick="mail_major();" class="save_btn">Submit</a>&nbsp;
                            <a href="javascript://" onclick="cancel('div_major');" class="save_btn">Cancel</a>
                           
                        </div>	
                         
                       </li>
                    </ul>
                    
                    <ul class="indexSkills1"  id="tr_minor" style="height:auto;">
                        <li class="Caption">Minor : </li>
                        <li class="CapText"><select id="minor" name="data[Client][minor]" class="selectbox">
                             <option value="0" selected="selected">Not Applicable</option>
                          <?php 
                         
                          foreach($minors as $minor)
                            {
                                if($exist_data['minor']==$minor['Minor']['id']) { ?> 
                                   <option value="<?php echo $minor['Minor']['id']?>" selected><?php echo $minor['Minor']['minor'];?></option>
                              <?php } else{ ?>
                                    <option value="<?php echo $minor['Minor']['id']?>"><?php echo $minor['Minor']['minor'];?></option>
                           <?php } }?>
                        </select>  <br />  
                         <span class="desc">If Minor not found in selected list, <a href='javascript://' onclick="loadPageProfile('div_minor');"><b>Click here</b></a></span> 
                        <div id="div_minor"  class="tool_tip">
                          
                         	<div id="err3" style="display:none;">Please enter Minor Name</div>
                        	
                        	 <ul class="indexSkills" style="height:auto;">
                                <li class="Caption">Minor:</li>
                                <li class="CapText"> <input id="ex_minor" name="ex_minor" class="inp_box"/>
                        		</li>
                            </ul>
                            <a href="javascript://" onclick="mail_minor();" class="save_btn">Submit</a>&nbsp;
                            <a href="javascript://" onclick="cancel('div_minor');" class="save_btn">Cancel</a>
                           
                        </div>	
                         
                        </li>
                    </ul>
               
               
                
			  <section class="job_descrip_box" style="height:40px">  
              <span class="btn_row">
              <!--<input type="submit" class="save_btn" value="SAVE &amp; NEXT" onclick="return save_step4();"/>-->
              <a href="javascript://" onclick="save_step4();" class="save_btn">SAVE &amp; NEXT</a>
              <?php //if($skip=='1') { ?>
              <a href="javascript://" class="skip_btn" onclick="step('5')">SKIP ></a>
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
	 showeducation();
});
function showeducation()
{
	education=$('#TR_highest_education').val();
	if(education=='')
	{	
		document.getElementById('tr_major').style.display='none';
		document.getElementById('tr_minor').style.display='none';
		document.getElementById('tr_university').style.display='none';
		document.getElementById('tr_year').style.display='none';
		document.getElementById('tr_what').style.display='none';
	}
	else
	{
		degree_type=$('#degree_type').val();	
		if(education==1)
		{			
			document.getElementById('tr_year').style.display='none';
			document.getElementById('tr_what').style.display='';
			if(degree_type==1 || degree_type==2 || degree_type==3)
			{
				document.getElementById('tr_major').style.display='none';
				document.getElementById('tr_minor').style.display='none';
				document.getElementById('tr_university').style.display='none';
	
			}else
			{
				document.getElementById('tr_major').style.display='';
				document.getElementById('tr_minor').style.display='';
				document.getElementById('tr_university').style.display='';
			}
		}
		else
		{
			document.getElementById('tr_what').style.display='none';
			document.getElementById('tr_year').style.display='';
			if(education==2 || education==3)
			{
				document.getElementById('tr_major').style.display='none';
				document.getElementById('tr_minor').style.display='none';
				document.getElementById('tr_university').style.display='none';				
			}
			else
			{
				document.getElementById('tr_major').style.display='';
				document.getElementById('tr_minor').style.display='';
				document.getElementById('tr_university').style.display='';				
			}
		}
	}
}

function loadPageProfile(divname)
{
	if(divname=='div_college') $('#div_college').show();
	if(divname=='div_major')$('#div_major').show();
	if(divname=='div_minor')$('#div_minor').show();
}	

function mail_college()
{
	var inp_college=$('#ex_college').val();
	//alert(inp_college);
	//alert($('#collegeForm').serialize());
	if(inp_college!='')
	{
		$.post("<?php echo SITE_URL; ?>/clients/add_college_mail",'name='+inp_college,function(data){	
					$("#div_college").html(data);
				
				});
		}else{
			
			$('#err1').show();
			}	
		
	
}

function mail_major()
{
	var inp_major=$('#ex_major').val();
	if(inp_major!='')
	{
		$.post("<?php echo SITE_URL; ?>/clients/add_major_mail",'name='+inp_major,function(data){	
					$("#div_major").html(data);
				
				});
		}else{
			
			$('#err2').show();
			}	
		
	
}

function mail_minor()
{
	var inp_minor=$('#ex_minor').val();
	if(inp_minor!='')
	{
		$.post("<?php echo SITE_URL; ?>/clients/add_minor_mail",'name='+inp_minor,function(data){	
					$("#div_minor").html(data);
				
				});
		}else{
			
			$('#err3').show();
			}	
		
	
}

function cancel(divname)
{
	$('#'+divname).hide();	
}	
	
function save_step4()
{		
	//alert(1);
	var highest_edu=$('#TR_highest_education').val();
	if(highest_edu!='')
	{
				var step4form=$('#step4Form').serialize();
				$(".show_loading_img").html('<div class="back_scroll"><?php echo $this->Html->image('loading.gif',array('escape'=>false));?></div>');
				$.post("<?php echo SITE_URL; ?>/clients/profile_step4",step4form,function(data){	
					$("#step1").html(data);
				
				});
				
	}else{
			$('#select_err').show();
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