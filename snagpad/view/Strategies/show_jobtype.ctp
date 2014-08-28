<div class="submit_left">
<h4><?php echo $popTitle;?></h4> 
<?php if($flag=='1'){ ?>
<div class="nano" style="width:220px !important">
<div class="strategy_pop_up">

  <p><?php echo $check['Checklist']['description'];?></p>
   </div>
  </div>
<?php }else{ ?>
 <p><?php echo $check['Checklist']['description'];?></p>
<?php } ?> 
  </div>
  <?php if($check['Checklist']['video']){ ?> 
  <div class="video">
  <?php echo $this->Html->link($this->Html->image('VideoLogo.png', array('alt' =>'View Video', 'border' => '0')), 'Javascript://', array('escape' => false, 'class' => 'logo','onClick'=>'viewStrategyvideo('.$check['Checklist']['id'].')')); ?>
  </div>
  <?php } ?>
  <div class="submit_right">
  <div id="strat_error" class="error1"></div>
  <form id="strat_jobtypeForm" name="strat_jobtypeForm" method="post" action="">
  <div class="detail_row">
  <input type="hidden" id="card_id" name="card_id" value="<?php echo $card['Card']['id'];?>"/>
  <input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
  <label>Opportunity Related To :</label>
  <input type="radio" id="jobA" name="cbox" onclick="check_radio();" value="A" class="radio" <?php if($card['Card']['job_type']=='A') echo 'checked'; echo ' '.$disabled;?>/><span class="text">Job A</span>
  <input type="radio" id="jobB" name="cbox" onclick="check_radio();" value="B" class="radio" <?php if($card['Card']['job_type']=='B') echo 'checked'; echo ' '.$disabled;?>/><span class="text">Job B</span>
  </div>
  <div id="show_job_message" class="text" style="margin-top:30px;">Congratulations on identifying your ideal job!</div>
  <div id="skill_criteria" <?php if($card['Card']['job_type']!='A'){ ?>style="display:none;"<?php } ?>>
 
  	<div class="strat_jobA">
     <div class="nano">
<div class="strategy_pop_up" style="width:100% !important; height:100px !important">
  <ul style="width:100%;"> 
  	<li>Here is a list of knowledge, skills and abilities required for this job. Beside each area is the rating you gave yourself for each of them. If you decide to apply to this opportunity make sure that you address those areas that you rated 3 or lower in your cover letter indicating to the employer how you will make up for them.</li>
    
    <?php $values=array(); foreach($skills as $sk) { if($sk['val']!=0){ $values[]=$sk; ?>
    <li style="float: left;width: 286px;"><div style="width:250px; <?php if($sk['val']<=3) echo 'background-color:#ccc;'; ?>"><?php echo $sk['text'].' : '.$sk['val'];?></div></li>
	<?php }}
	if(empty($values)){ ?>
    <br/>
    <li><a href="<?php echo SITE_URL; ?>/jobcards/profileView">Click here</a> to rate your skills.</li>
    <?php } ?>
  </ul>
  
   </div>
   </div>
   </div>
   <div class="strat_jobB" <?php if($card['Card']['job_type']!='B') { ?>style="display:none"<?php } ?>>
   <div class="nano">
  <div class="strategy_pop_up" style="width:100% !important; height:126px !important;">
  <ul class="border">
  <?php if(empty($skills) && empty($criteria)) { ?>
    	<li>You need to complete step-2 and step-3 of Profile Wizard to get skills and criteria. <a href="<?php echo SITE_URL;?>/jobcards/profileView">Click here</a> to go to Profile Wizard.</li>
    <?php }else{ ?>
  	<li><h3>Skills</h3>&nbsp;<span><i>"What skills can I gain from this job?"</i></span></li>
    
    <?php $skill_vl=array(); foreach($skills as $sk) { if($sk['val']!=0){ $skill_vl[]=$sk; ?>
    <li><input type="checkbox" class="radio" name="skbox[]" value="<?php echo $sk['text'];?>" <?php if(in_array($sk['text'],$exist_skills)){echo 'checked'; echo " $disabled";}?>/><?php echo $sk['text'];?></li>
	<?php }} 
	if(empty($values)){ ?>
  
    <li><a href="<?php echo SITE_URL; ?>/jobcards/profileView">Click here</a> to rate your skills.</li>
    <?php } ?>
  </ul>
  <ul  style="width:48%;">
  	<li><h3>Criteria</h3>&nbsp;<span><i>"Why would I take this job?"</i></span></li>
  	<?php foreach($criteria as $crit){ ?>
    	<li><input type="checkbox" class="radio" name="crbox[]" class="check_data" value="<?php echo $crit;?>" <?php if(in_array($crit,$exist_criteria)){echo 'checked';} echo " $disabled"?>/><?php echo $crit;?></li>
	<?php }} ?>
  </ul>
   </div>
   </div>
   </div>
   
   
  </div>
  </div>
  <?php if($disabled==""){?>
  <div class="submit_row">
  <a href="javascript://" onclick="submit_jobtype();" class="save_btn">SAVE</a>
  </div>
  <?php }?>
  </form>
  </div>
<script type="text/javascript">
$(document).ready(function(){
	$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up'});
	$('.error1').show();
	$('#show_job_message').hide();
	});
function check_radio()
{
	var jobA=document.getElementById('jobA');
	var jobB=document.getElementById('jobB');
	if(jobB.checked==true)
	{
		$('#show_job_message').hide();
		$('#skill_criteria').show();
		$('.strat_jobA').hide();
		$('.strat_jobB').show();
		$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up'});
					
	}
	if(jobA.checked==true)
	{
		$('#skill_criteria').show();	
		$('#strat_error').hide();
		$('#show_job_message').show();
		$('.strat_jobA').show();
		$('.strat_jobB').hide();
		$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up'});
	}
}

function submit_jobtype()
{
	var flag=0;
	var jobA=document.getElementById('jobA');
	var jobB=document.getElementById('jobB');
	if(jobA.checked==true)
	{
		flag=1;
	}
	if(jobB.checked==true)
	{
	$('input:checked').each(function(){
		var ch=$(this).attr('name');
		//alert(ch);
		if(ch=='crbox[]'||ch=='skbox[]'){
			flag=1;
			return false;
			}
		});
	}
	//alert(flag);
	if(flag==1)
	{
		var check_id=$('#check_id').val();
		var frm1=$('#strat_jobtypeForm').serialize();
		$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');
		$.post('<?php echo SITE_URL;?>/strategies/save_jobtype',frm1,function(data){
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
		//document.forms['strat_jobtypeForm'].submit();
	}else{
		
		$('#strat_error').html('Please select at least one skill or criteria');
		$('#strat_error').show();
		}
		
			
}
</script>  