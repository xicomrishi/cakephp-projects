<?php //echo $this->Html->script('cufon');?>
<div id="step">
<?php echo $this->element('profile_progress');?>
<section class="show_loading_img">
<section class="head_row">
  <h3>Job B criteria: Indicate the reasons why would you take a job other than job A
</h3>
  <p>You now need to indicate the reasons why you would take a Job other than your Job A. For example, if it is important that your job be close to where you live, check 'Location'. You can check as many criteria as you feel necessary and add any new criteria to the field below.</p>
  </section>
  <form id="step3Form" name="step3Form" action="">
  <section class="pop_up_detail border">
  
 			<div id="select_err" align="center" style="display:none;">Please either select or enter at least one criteria</div>
              <section class="job_descrip_box" style="height: 70px; overflow:hidden !important">
              <?php //echo $this->Form->create('Client',array('id'=>'profileStep2'));?>
              <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
              <fieldset>
              <div class="rowdd" style="width:100%;height:auto;">
              <?php foreach($criterias as $criteria) { ?>
              <div class="inputdd" style="width:48%;float:left;">
              
              <input type="checkbox" name="cr_check[]" value="<?php echo $criteria;?>" style="margin-left:41px;" <?php if(in_array($criteria,$added_cr)){ echo "checked";}?>><label style="float:left;"><?php echo $criteria;?></label>
              </div>
              <?php } ?>
             
              
              </div>
               </fieldset>
              </section>
             <input id="ex_criteria" type="hidden" name="count_ex_criteria" value="<?php if(empty($extra_cr)) {echo '2';}else {echo count($extra_cr)+1;}?>"/>
               </section>
              <ul class="indexSkills" style="height:auto;">
              	<li class="Caption">Add your own criteria(s) : </li>
                 <?php if(!empty($extra_cr)){ $i=1;
						foreach($extra_cr as $cr) { ?>
                <li class="CapText1" id="inp_<?php echo $i;?>" <?php if($i!=1){ ?>style="margin:0 0 7px 313px; display:inline"<?php } ?>><input type="text" id="cr_<?php echo $i;?>" name="data[Criteria][cr_<?php echo $i;?>]" value="<?php echo $cr;?>"/><?php if($i!=1){ ?>
				<a href="javascript://" onclick="remove_cr(<?php echo $i;?>)">Delete</a>
				<?php } ?></li>
                <?php $i++; } }else { ?>
                	 <li id="inp_1" class="CapText"><input type="text" id="cr_1" name="data[Criteria][cr_1]"/></li>
                <?php } ?>
				</ul>
				<ul class="clsFirstRow">
                <li id="li_1" class="CapText"><a href="javascript://" onclick="add_more_cr()">Add another criteria</a>
              </ul>
              
            </form>  
              <section class="job_descrip_box">
              <p class="pText" align="center">TIP: When looking at jobs other then your Job A, it is important that you take a position that makes you more competitive in the future. When an employer reviews a resume they're looking for a pattern of experiences that matches the available position. You can use the criteria you establish to  determine if a Job B opportunity adds value to your work history.</p>
              
              <span class="btn_row" style="padding:0 0 45px 0">
              <!--<input type="submit" class="save_btn" value="SAVE &amp; NEXT" onclick="return "/>-->
              <a href="javascript://" onclick="check_step3();" class="save_btn">SAVE &amp; NEXT</a>
              <?php //if($skip=='1') { ?>
              <a href="javascript://" class="skip_btn" onclick="step('4')">SKIP ></a>
              <?php //} ?>
              </span>
              </section>
             
      

   
  </section> 
  <ul class="pop_up_paging">
	<?php echo $this->element('profile_steps');?>
  </ul>
  
</div>
<script language="javascript">
$(document).ready(function(e) {
     $("html, body").animate({ scrollTop: 0 }, 600);
});

function add_more_cr()
{	var num=$('#ex_criteria').val();
	//alert(num);
	var m=0;
	for(m=0;m<10;m++)
	{ $('#li_'+(parseInt(num)+parseInt(m))).remove(); 
		 $('#li_'+(parseInt(num)-parseInt(m))).remove();
	}
	//$('#li_'+(parseInt(num)+2)).remove();
	//$('#li_'+(parseInt(num)-2)).remove();
	//$('#li_'+(parseInt(num)-1)).remove();
	//$('#li_'+(parseInt(num)+1)).remove();
	//$('#li_'+(parseInt(num))).remove();
	$('.indexSkills').append('<li id="inp_'+num+'" class="CapText1" style="margin:0 0 7px 313px; display:inline"><input type="text" name="data[Criteria][cr_'+num+']"/><a href="javascript://" onclick="remove_cr('+num+')">Delete</a></li><li id="li_'+num+'" class="CapText" style="margin:3px 0 0 505px; display:inline;"><a href="javascript://" onclick="add_more_cr('+num+')">Add another criteria</a></li>');
	$('#li_'+(parseInt(num)-2)).remove();
	$('#li_'+(parseInt(num)-1)).remove();
	var old_ex_criteria=$('#ex_criteria').val();
	$('#ex_criteria').val(parseInt(old_ex_criteria)+1);
	//num++;
	}

function remove_cr(i)
{
	$('#inp_'+i).remove();
	var tot=$('#ex_criteria').val();
	$('#ex_criteria').val(tot-1);
	}	
function step(num)
{
	var clientid=$('#clientid').val();
	$(".show_loading_img").html('<div class="back_scroll"><?php echo $this->Html->image('loading.gif',array('escape'=>false));?></div>');
	$.post("<?php echo SITE_URL; ?>/clients/profile_step"+num,'cl_id='+clientid,function(data){	
					$("#step1").html(data);
				
			});	
}

function check_step3()
{	//alert(1);
	var val=new Array();
	var i=0;
	$('input:checked').each(function(index, element) {
        val[i]=$(this).attr("value");
		i++;
		
    });
	if(val=='')
	{
		var f_cr=$('#cr_1').val();
		if(f_cr==''){
		$('#select_err').show();
		return false; 
		}else{
			$('#select_err').hide();
			save_step3();

			}
		}else{
			$('#select_err').hide();
			save_step3();
			
			}
}

function save_step3()
{
	var step3form=$('#step3Form').serialize();
	//alert(step3form);
	$(".show_loading_img").html('<div class="back_scroll"><?php echo $this->Html->image('loading.gif',array('escape'=>false));?></div>');
	$.post("<?php echo SITE_URL; ?>/clients/profile_step3",step3form,function(data){	
					$("#step1").html(data);
				
				});	
				
	}
</script>