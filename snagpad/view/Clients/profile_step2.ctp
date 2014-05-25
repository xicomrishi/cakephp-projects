<?php echo $this->Html->css(array('jquery.ui.slider'));?>
<?php echo $this->Html->script('jquery-ui-1.9.1.custom.min');?>
<div id="step">
<?php echo $this->element('profile_progress');?>

<section class="show_loading_img">
<section class="head_row">
  <h3 style="color:#F07700;">Rate yourself on the competencies required for Job A</h3>
  <p>The following knowledge, skills and abilities are required for your Job A. Review the list and rate your level of competency for each. A score of 1 represents that you have no experience in that area and a 5 means that you are fully competent in that area.</p>
  </section>
  <form id="step2Form" name="step2Form" action="">
  <div id="select_err" align="center" style="display:none;">Please either select or enter at least one skill</div>
             <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
 <?php if(!isset($custom_job_A)){ ?>            
  <?php if(!empty($skills)){ ?>
  <section class="pop_up_detail border">
  				
 			
             <div style="float: right; margin-top: -17px; width: 245px;"><a href="<?php echo SITE_URL; ?>/info/job_summary/<?php echo $onet_job_A.'/'; ?>" target="_blank">Click here for definitions</a></div>
              <h3 class="h_label">Knowledge</h3>
             <div class="nano">
              <section class="job_descrip_box" style="height:95px;">
                                      
              <div class="rowdd" style="width:100%;height:104px;">
              <?php foreach($skills as $skill) { if($skill['Skillslist']['type']==3){ ?>
              <div class="inputdd" style="width:700px;float:left; margin-left:40px;">
              
              <input type="hidden" name="skill_check[<?php echo $skill['Skillslist']['id']; ?>][check]" value="<?php echo $skill['Skillslist']['skill'];?>"/>
              <input type="checkbox" id="check_slider_<?php echo $skill['Skillslist']['id']; ?>" title="<?php if(in_array($skill['Skillslist']['skill'],$exist)){ echo $arr[$skill['Skillslist']['skill']]; }else{ echo '0'; } ?>" value="<?php echo $skill['Skillslist']['skill'];?>"  style="display:none;"><label title="<?php echo $skill['Skillslist']['description'];?>" style="float:left; width:310px; text-align:left"><?php echo $skill['Skillslist']['skill'];?></label>
              <div id="slider_<?php echo $skill['Skillslist']['id']; ?>" <?php if(in_array($skill['Skillslist']['skill'],$exist)){ echo 'class="exist_slider"'; } ?> style="width:315px; float:left;"></div>
              <div id="inp_<?php echo $skill['Skillslist']['id']; ?>"></div>
                   
              </div>
              <?php }} ?>
              </div>
              </section>
               </div>
               
               </section>
               <?php } ?>
              
              <section class="pop_up_detail border"> 
               <?php if(!empty($skills)){ ?> 
               <h3 class="h_label">Skills</h3>
              <div class="nano">
              <section class="job_descrip_box" style="height:95px;">
                                      
              <div class="rowdd" style="width:100%;height:104px;">
              <?php foreach($skills as $skill) { if($skill['Skillslist']['type']==1){ ?>
              <div class="inputdd" style="width:700px;float:left; margin-left:40px;">
              
                 <input type="hidden" name="skill_check[<?php echo $skill['Skillslist']['id']; ?>][check]" value="<?php echo $skill['Skillslist']['skill'];?>"/>
              <input type="checkbox" id="check_slider_<?php echo $skill['Skillslist']['id']; ?>" title="<?php if(in_array($skill['Skillslist']['skill'],$exist)){ echo $arr[$skill['Skillslist']['skill']]; }else{ echo '0'; } ?>" value="<?php echo $skill['Skillslist']['skill'];?>" style="display:none;"><label title="<?php echo $skill['Skillslist']['description'];?>" style="float:left; width:310px; text-align:left"><?php echo $skill['Skillslist']['skill'];?></label>
              <div id="slider_<?php echo $skill['Skillslist']['id']; ?>" <?php if(in_array($skill['Skillslist']['skill'],$exist)){ echo 'class="exist_slider"'; } ?> style="width:315px; float:left;"></div>
              <div id="inp_<?php echo $skill['Skillslist']['id']; ?>"></div>
               
              </div>
              <?php }} ?>
              
               </div>
             </section>
            </div>
            <?php } ?>
                		
               <div class="indexSkills">
              	<div id="li_1" style="margin:3px 0 0 505px;"><a href="javascript://" onclick="add_more_skill()" style="color:#5F8B00;">Add another skill</a></div>
                <?php if(!empty($extra)){ $i=1;
						foreach($extra as $ext_key=>$ext_val) { ?>
                <input type="checkbox" id="check_slider_<?php echo $ext_key; ?>" title="<?php if(in_array($ext_val['text'],$exist)){ echo $arr[$ext_val['text']]; }else{ echo '0'; } ?>" name="skill_check[<?php echo $ext_key; ?>][check]" value="<?php echo $ext_val['text'];?>" style="display:none;">
                
                <div id="divinp_<?php echo $i;?>" style="margin:0 0 7px 29px; width:770px;"><div style="width:50px; padding:7px 10px 0 50px; float:left;"><a href="javascript://" onclick="remove_skill(<?php echo $i;?>)" style="color:#FF0000;">Delete</a></div><div style="float:left; padding:0 13px 0 0;"><input type="text" id="skill_<?php echo $i;?>" name="skill_check[<?php echo $ext_key; ?>][check]" value="<?php echo $ext_val['text'];?>"  style="padding:6px;"/></div>
                <div id="slider_<?php echo $ext_key; ?>" <?php if(in_array($ext_val['text'],$exist)){ echo 'class="exist_slider"'; } ?> style="width:315px; float:left; margin:7px 13px 0 0;"></div>
              <div id="inp_<?php echo $ext_key; ?>" style="float:left;width:65px; padding:7px;"></div></div>
             <?php $i++; } }?>
                
				</div>
			   </section>
               
                <?php if(!empty($skills)){ ?> 
               <section class="pop_up_detail border">
                <h3 class="h_label">Abilities</h3>
              <div class="nano">
              <section class="job_descrip_box" style="height:95px;">
                                      
              <div class="rowdd" style="width:100%;height:104px;">
              <?php foreach($skills as $skill) { if($skill['Skillslist']['type']==2){ ?>
              <div class="inputdd" style="width:700px;float:left; margin-left:40px;">
              
                 <input type="hidden" name="skill_check[<?php echo $skill['Skillslist']['id']; ?>][check]" value="<?php echo $skill['Skillslist']['skill'];?>"/>
              <input type="checkbox" id="check_slider_<?php echo $skill['Skillslist']['id']; ?>" title="<?php if(in_array($skill['Skillslist']['skill'],$exist)){ echo $arr[$skill['Skillslist']['skill']]; }else{ echo '0'; } ?>" value="<?php echo $skill['Skillslist']['skill'];?>" style="display:none;"><label title="<?php echo $skill['Skillslist']['description'];?>" style="float:left; width:320px; text-align:left"><?php echo $skill['Skillslist']['skill'];?></label>
              <div id="slider_<?php echo $skill['Skillslist']['id']; ?>" <?php if(in_array($skill['Skillslist']['skill'],$exist)){ echo 'class="exist_slider"'; } ?> style="width:315px; float:left;"></div>
              <div id="inp_<?php echo $skill['Skillslist']['id']; ?>"></div>
              
              </div>
              <?php }} ?>             
             
              </div>
             
              </section>
               </div>
             </section>
             <?php } ?>
   <?php }else{ ?>
   
   			<section class="pop_up_detail border"> 
               <?php if(!empty($skills)){ ?> 
               <p style="color:#FF0033; width:640px; padding: 0 0 7px 49px;">The job you entered for your Job A is not in our database. Therefore, you need to rate the skills below that you believe are required for that job. If you do not see a skill, you can add one by clicking on 'add another skill'.</p>
               <h3 class="h_label">Skills</h3>
              <div class="nano">
              <section class="job_descrip_box" style="height:95px;">
                                      
              <div class="rowdd" style="width:100%;height:104px;">
              <?php foreach($skills as $skill) { if($skill['Skillslist']['type']==4){ ?>
              <div class="inputdd" style="width:700px;float:left; margin-left:40px;">
              
                 <input type="hidden" name="skill_check[<?php echo $skill['Skillslist']['id']; ?>][check]" value="<?php echo $skill['Skillslist']['skill'];?>"/>
              <input type="checkbox" id="check_slider_<?php echo $skill['Skillslist']['id']; ?>" title="<?php if(in_array($skill['Skillslist']['skill'],$exist)){ echo $arr[$skill['Skillslist']['skill']]; }else{ echo '0'; } ?>" value="<?php echo $skill['Skillslist']['skill'];?>" style="display:none;"><label title="<?php echo $skill['Skillslist']['description'];?>" style="float:left; width:310px; text-align:left"><?php echo $skill['Skillslist']['skill'];?></label>
              <div id="slider_<?php echo $skill['Skillslist']['id']; ?>" <?php if(in_array($skill['Skillslist']['skill'],$exist)){ echo 'class="exist_slider"'; } ?> style="width:315px; float:left;"></div>
              <div id="inp_<?php echo $skill['Skillslist']['id']; ?>"></div>
               
              </div>
              <?php }} ?>
              
               </div>
             </section>
            </div>
            <?php } ?>
                		
               <div class="indexSkills">
              	<div id="li_1" style="margin:3px 0 0 505px;"><a href="javascript://" onclick="add_more_skill()" style="color:#5F8B00;">Add another skill</a></div>
                <?php if(!empty($extra)){ $i=1;
						foreach($extra as $ext_key=>$ext_val) { ?>
                <input type="checkbox" id="check_slider_<?php echo $ext_key; ?>" title="<?php if(in_array($ext_val['text'],$exist)){ echo $arr[$ext_val['text']]; }else{ echo '0'; } ?>" name="skill_check[<?php echo $ext_key; ?>][check]" value="<?php echo $ext_val['text'];?>" style="display:none;">
                
                <div id="divinp_<?php echo $i;?>" style="margin:0 0 7px 29px; width:770px;"><div style="width:50px; padding:7px 10px 0 50px; float:left;"><a href="javascript://" onclick="remove_skill(<?php echo $i;?>)" style="color:#FF0000;">Delete</a></div><div style="float:left; padding:0 13px 0 0;"><input type="text" id="skill_<?php echo $i;?>" name="skill_check[<?php echo $ext_key; ?>][check]" value="<?php echo $ext_val['text'];?>"  style="padding:6px;"/></div>
                <div id="slider_<?php echo $ext_key; ?>" <?php if(in_array($ext_val['text'],$exist)){ echo 'class="exist_slider"'; } ?> style="width:315px; float:left; margin:7px 13px 0 0;"></div>
              <div id="inp_<?php echo $ext_key; ?>" style="float:left;width:65px; padding:7px;"></div></div>
             <?php $i++; } }?>
                
				</div>
                                  
                
			   </section>
   <?php } ?>          
             
             <input id="ex_skill" type="hidden" name="count_ex_skill" value="<?php if(empty($extra)) {echo '1';}else { echo count($extra)+1;} ?>"/>
              </section>
             
              </form>
              <section class="job_descrip_box">
              <p class="pText" style="display:block">TIP: By identifying the skills necessary for your job A you will be able to determine what skills you have and those that you're missing. Additionally, if you're missing skills you can take other types of jobs that will help you acquire them.</p>
              
              <span class="btn_row" style="padding:0 0 45px 0">
              <a href="javascript://" onclick="check_step2();" class="save_btn">SAVE &amp; NEXT</a>
              
              <?php //if($skip=='1') { ?>
              <a href="javascript://" class="skip_btn" onclick="step('3')">SKIP ></a>
              <?php //} ?>
              </span>
              </section>            
      
  </section>
   
 </section>  
  <ul class="pop_up_paging">
	<?php echo $this->element('profile_steps');?>
  </ul>
</div>
<script language="javascript">
$(document).ready(function(e) {
     $("html, body").animate({ scrollTop: 0 }, 600);
	 $(".nano").nanoScroller({alwaysVisible:true});
	 get_slider();
	
});

function get_slider()
{
	$('input:checkbox').each(function(index, element){
        var sl_val=$(this).attr('title');
		var temp=$(this).attr('id');
		temp=unescape(temp);
		var sl_id=temp.split('_');
		slider_instance(sl_id[2],sl_val);
		
		$('#inp_'+sl_id[2]).html('<input type="text" value="'+sl_val+'" id="inp_slider_'+sl_id[2]+'" class="val_input" name="skill_check['+sl_id[2]+'][val]" style="margin:0 0 0 16px; width:13px; padding:0;" readonly="readonly"/>');
		$(".nano").nanoScroller({alwaysVisible:true});
    });	
}

function slider_instance(sl_id,sl_val)
{
	 $('#slider_'+sl_id).slider({
		 		value:sl_val,
				min: 0,
				range:'min',
				max: 5,
				step: 1,				
				slide: function( event, ui ) {
					$('#inp_slider_'+sl_id).val(ui.value);
				}		 
		});	
}

function add_more_skill()
{	
	var num=$('#ex_skill').val();
	//alert(num);
	var m=0;
	for(m=0;m<20;m++)
	{ $('#li_'+(parseInt(num)+parseInt(m))).remove(); 
		 $('#li_'+(parseInt(num)-parseInt(m))).remove();
	}
			
	$('.indexSkills').append('<input id="check_slider_ex'+num+'" type="checkbox" style="display:none;" name="skill_check[ex'+num+'][check]" title="0" value="0"/><div id="divinp_'+num+'" class="CapText1" style="margin:0 0 7px 29px; width:770px;"><div style="width:50px; padding:7px 10px 0 50px; float:left;"><a href="javascript://" onclick="remove_skill('+num+')" style="color:#FF0000;">Delete</a></div><div style="float:left;padding:0 13px 0 0;"><input type="text" id="skill_'+num+'" name="skill_check[ex'+num+'][check]" style="padding:6px;"/></div><div id="slider_ex'+num+'" style="width:315px; float:left; margin:7px 13px 0 0;"></div><div id="inp_ex'+num+'" style="float: left;padding: 7px;width: 65px;"><input id="inp_slider_ex'+num+'" type="text" class="val_input" readonly="readonly" style="margin:0 0 0 16px; width:13px;padding: 0; border-radius:0;" name="skill_check[ex'+num+'][val]" value="0"/></div></div><div id="li_'+num+'" class="CapText" style="margin:3px 0 0 505px;"><a href="javascript://" onclick="add_more_skill('+num+')" style="color:#5F8B00;">Add another skill</a></div>');
	slider_instance('ex'+num,'0');
	var old_ex_skill=$('#ex_skill').val();
	$('#ex_skill').val(parseInt(old_ex_skill)+1);

	}

function remove_skill(i)
{
	$('#divinp_'+i).remove();
	var tot=$('#ex_skill').val();
	$('#ex_skill').val(tot-1);
	}	


function check_step2()
{	//alert(1);
	var flag=0;
	
	$('.val_input').each(function(index, element) {
        if($(this).attr("value")!='')
				flag=1;
		
    });
	
	if(flag==0)
	{
		var f_skill=$('#skill_1').val();
		if(f_skill==''){
			$('#select_err').show();
			return false;
		}else{
				save_step2();				
			}
		}else{
			$('#select_err').hide();
			save_step2();
			
			}
}

function save_step2()
{	
	var step2form=$('#step2Form').serialize();
	$(".show_loading_img").html('<div class="back_scroll"><?php echo $this->Html->image('loading.gif',array('escape'=>false));?></div>');
	$.post("<?php echo SITE_URL; ?>/clients/profile_step2",step2form,function(data){	
					$("#step1").html(data);				
				});
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