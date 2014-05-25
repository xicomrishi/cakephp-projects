<?php echo $this->Html->script('cufon');?>
<section class="head_row">
  <h3>List the skills required to do your Job A</h3>
  <p>You now need to indicate the skills necessary to perform effectively in your Job A. Check as many skills that are required to perform the Job. You can check multiple skills if necessary. If you can't find a skill, you can enter it in the text field provided.</p>
  </section>
  <form id="step2Form" name="step2Form" action="">
  <section class="pop_up_detail border">
  
 			<div id="select_err" align="center" style="display:none;">Please either select or enter at least one skill</div>
             <div class="nano">
              <section class="job_descrip_box">
             
              <?php //echo $this->Form->create('Client',array('id'=>'profileStep2'));?>
              <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
              <fieldset>
              <div class="rowdd" style="width:100%;height:250px;">
              <?php foreach($skills as $skill) { ?>
              <div class="inputdd" style="width:48%;float:left;">
              
              <input type="checkbox" name="skill_check[]" value="<?php echo $skill['Skillslist']['skill'];?>" style="width:30px; float:left; margin-left:20px;" <?php if(in_array($skill['Skillslist']['skill'],$added_skill)){ echo "checked"; }?>><label style="float:left;"><?php echo $skill['Skillslist']['skill'];?></label>
              </div>
              <?php } ?>
              </fieldset>
              
             
              </div>
              </section>
               </div>
             <input id="ex_skill" type="hidden" name="count_ex_skill" value="<?php if(empty($extra_skill)) {echo '2';}else { echo count($extra_skill)+1;} ?>"/>
             
              <ul class="indexSkills">
              	<li class="Caption">Add your own skill(s) : </li>
                <?php if(!empty($extra_skill)){ $i=1;
						foreach($extra_skill as $sk) { ?>
                <li class="CapText" id="inp_<?php echo $i;?>" <?php if($i!=1){ ?>style="margin:7px 0 7px 288px;"<?php } ?>><input type="text" id="skill_<?php echo $i;?>" name="data[Skill][skill_<?php echo $i;?>]" value="<?php echo $sk;?>"/><?php if($i!=1){ ?>
				<a href="javascript://" onclick="remove_skill(<?php echo $i;?>)">Delete</a>
				<?php } ?></li>
                <?php $i++; } } else { ?>
                	 <li class="CapText" id="inp_1"><input type="text" id="skill_1" name="data[Skill][skill_1]"/></li>
                <?php } ?>
				</ul>
				<ul class="clsFirstRow">
                <li id="li_1" class="CapText" ><a href="javascript://" onclick="add_more_skill()">Add More Skill</a>
				</ul>
              
              <section class="job_descrip_box">
              <p class="pText" style="display:block">TIP: It's important to indicate your ideal job so that when you're using your job<br> search board and networking with contacts they are clear on what kind of job<br> you're looking for.</p>
              
              <span class="btn_row" style="padding:0 0 45px 0">
              <!--<input type="submit" class="save_btn" value="SAVE &amp; NEXT" onclick="return save_step2();"/>-->
              <a href="javascript://" onclick="check_step2();" class="save_btn">SAVE &amp; NEXT</a>
              <?php if($skip=='1') { ?>
              <a href="javascript://" class="skip_btn" onclick="step('3')">SKIP ></a>
              <?php } ?>
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
	 $(".nano").nanoScroller();
});

function add_more_skill()
{	
	num=$('#ex_skill').val();
	//alert(num);
	$('#li_'+(parseInt(num))).remove();
	$('#li_'+(parseInt(num)-2)).remove();
	$('#li_'+(parseInt(num)+1)).remove();
	$('#li_'+(parseInt(num)-1)).remove();
	$('.indexSkills').append('<li id="inp_'+num+'" class="CapText" style="margin:7px 0 7px 288px;"><input type="text" name="data[Skill][skill_'+num+']"/><a href="javascript://" onclick="remove_skill('+num+')">Delete</a></li><li id="li_'+num+'" class="CapText" style="margin:10px 0 0 505px;"><a href="javascript://" onclick="add_more_skill('+num+')">Add More Skill</a></li>');

	var old_ex_skill=$('#ex_skill').val();
	$('#ex_skill').val(parseInt(old_ex_skill)+1);
	//num++;
	}

function remove_skill(i)
{
	//alert(i);
	$('#inp_'+i).remove();
	var tot=$('#ex_skill').val();
	$('#ex_skill').val(tot-1);
	}	


function check_step2()
{	//alert(1);
	var val=new Array();
	var i=0;
	$('input:checked').each(function(index, element) {
        val[i]=$(this).attr("value");
		i++;
		
    });
	if(val=='')
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
	$.post("<?php echo SITE_URL; ?>/clients/profile_step2",$('#step2Form').serialize(),function(data){	
					$("#step1").html(data);
				
				});
					
	
	}
	
function step(num)
{	
	clientid=$('#clientid').val();
	$.post("<?php echo SITE_URL; ?>/clients/profile_step"+num,'cl_id='+clientid,function(data){	
					$("#step1").html(data);
				
			});	

}
</script>