<div class="submit_left">
<h4><?php echo $popTitle;?></h4>
<?php if($flag==6){ ?>
<div class="nano" style="width:220px !important">
<div class="strategy_pop_up">
<p class="full"><?php echo $check['Checklist']['description']; ?></p>
</div>
</div>
<?php }else{ ?>
  <p class="full"><?php echo $check['Checklist']['description']; ?></p>
<?php } ?>  
  </div>
  <?php if($check['Checklist']['video']){ ?> 
  <div class="video">
  <?php echo $this->Html->link($this->Html->image('VideoLogo.png', array('alt' =>'View Video', 'border' => '0')), 'Javascript://', array('escape' => false, 'class' => 'logo','onClick'=>'viewStrategyvideo('.$check['Checklist']['id'].')')); ?>
  </div>
  <?php } ?>
  <div class="submit_right">
  	<div id="opp_error" class="error1"></div>
  	 <form id="strat_textboxForm" name="strat_textboxForm" method="post" action="">
  	 <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  	 <input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
      <input type="hidden" id="flag" name="flag" value="<?php echo $flag;?>"/>
      
      <?php if($flag=='1'){ ?>
      <h3><?php echo $caption;?></h3>

      <input type="text" class="text" id="text_box" name="<?php echo $field;?>" <?php echo $disabled;?>  value="<?php if(!empty($card['Card']['salary'])){ echo $card['Card']['salary'];}?>" style="margin:0 0 0 30px; display:inline"/>
		<br><br>
        <h3>I don't know the average salary</h3>
       	<a href="<?php echo $url;?>" class="save_btn" target="_blank"><?php echo $downloadButton;?></a>
	  <?php } ?>
      
      <?php if($flag=='2'){ ?>
      <div class="detail_row">
      	 <label>Contact Name: </label>
      <input type="text" id="reporter_name"  class="text" name="reporter_name" <?php echo $disabled;?>  value="<?php if(!empty($card_detail['Cardcolumn']['reporter_name'])){ echo $card_detail['Cardcolumn']['reporter_name'];}?>"/></div>
      <div class="detail_row">
       <label>Title</label>
      <input type="text" id="reporter_title"  class="text" name="reporter_title"  <?php echo $disabled;?>  value="<?php if(!empty($card_detail['Cardcolumn']['reporter_title'])){ echo $card_detail['Cardcolumn']['reporter_title'];}?>"/></div>
      <div class="detail_row">
       <label>Email Address: </label>
      <input type="text" id="reporter_email"  class="email text" name="email" <?php echo $disabled;?>  value="<?php if(!empty($card_detail['Cardcolumn']['email'])){ echo $card_detail['Cardcolumn']['email'];}?>"/></div>
      <div class="detail_row">
       <label>Phone Number: </label>
      <input type="text" id="reporter_phone" class="digits text" name="phone_no" <?php echo $disabled;?>  value="<?php if(!empty($card_detail['Cardcolumn']['phone_no'])){ echo $card_detail['Cardcolumn']['phone_no'];}?>"/></div>
      <?php } ?>
      
       <?php if($flag=='3'){ ?>
       <div class="detail_row">
      	 <label>Job Expectations #1: </label>
      <input type="text" id="job_e_1"  name="job_e[]" value="<?php if(isset($text_val_1)){ echo $text_val_1;}?>" <?php echo $disabled;?>  class="text"/></div>
      <div class="detail_row">
       <label>Job Expectations #2: </label>
      <input type="text" id="job_e_2"  name="job_e[]" value="<?php if(isset($text_val_2)){ echo $text_val_2;}?>" <?php echo $disabled;?>  class="text"/></div>
      <div class="detail_row">
       <label>Job Expectations #3: </label>
      <input type="text" id="job_e_3" name="job_e[]" value="<?php if(isset($text_val_3)){ echo $text_val_3;}?>" <?php echo $disabled;?>  class="text"/></div>
      
      <?php } ?>
      
       <?php if($flag=='4'){ ?>
       <input type="hidden" id="check_radio_benefit" name="check_radio_benefit" value="1"/>
       <div class="detail_row">
      	 <label>Salary Offered: </label>
      <input type="text" id="salary_offered"  name="salary_offered" <?php echo $disabled;?>  value="<?php if(!empty($card_detail['Cardcolumn']['salary_offered'])){ echo $card_detail['Cardcolumn']['salary_offered'];}?>" class="text"/></div>
      <div class="detail_row">
       <label>Benefits</label>
      <input type="radio"   name="benefits" value="Yes" <?php echo $disabled;?>  onclick="show_detail('1');" <?php if($card_detail['Cardcolumn']['benefits']=='Yes'){ echo 'checked';}?> checked="checked" class="radio"/><span class="text">Yes</span>
       <input type="radio"  name="benefits" value="No" <?php echo $disabled;?>  onclick="show_detail('0');" <?php if($card_detail['Cardcolumn']['benefits']=='No'){ echo 'checked';}?> class="radio"/><span class="text">No</span></div>

       <div class="detail_row">
        <label id="label_show_benefit_details" <?php if($card_detail['Cardcolumn']['benefits']=='No'){ echo 'style="display:none;"';}?>>Details</label>
       	 <input type="text" id="show_benefit_details" <?php echo $disabled;?>  name="benefit_details" value="<?php if(!empty($card_detail['Cardcolumn']['benefit_details'])){ echo $card_detail['Cardcolumn']['benefit_details'];}?>" class="text" <?php if($card_detail['Cardcolumn']['benefits']=='No'){ echo 'style="display:none;"';}?>/></div>
<div class="detail_row">
       <label>Vacation Time: </label>
      <input type="text" id="vacation_time" name="vacation_time" <?php echo $disabled;?>  value="<?php if(!empty($card_detail['Cardcolumn']['vacation_time'])){ echo $card_detail['Cardcolumn']['vacation_time'];}?>" class="text"/></div>
      
      <?php } ?>
      
       <?php if($flag=='5'){ ?>
       <h3><?php echo $caption;?></h3>
       <div class="detail_row">
      	 <label>Professional Development Opportunity #1: </label>
      <input type="text" id="pdo_1"  name="pdo[]" <?php echo $disabled;?>  value="<?php if(isset($text_val_1)){ echo $text_val_1;}?>" class="text"/></div>
      <div class="detail_row">
       <label>Professional Development Opportunity #2: </label>
      <input type="text" id="pdo_2"  name="pdo[]" <?php echo $disabled;?>  value="<?php if(isset($text_val_2)){ echo $text_val_2;}?>" class="text"/></div>
      <div class="detail_row">
       <label>Professional Development Opportunity #3: </label>
      <input type="text" id="pdo_3" name="pdo[]" <?php echo $disabled;?>  value="<?php if(isset($text_val_3)){ echo $text_val_3;}?>" class="text"/></div>
      
      <?php } ?>
      
       <?php if($flag=='6'){ ?>
       <h3><?php echo $caption;?></h3>
       <div class="detail_row">
      	 <label>Key Individual #1: </label>
      <input type="text" id="key_1"  name="key[]" <?php echo $disabled;?>  value="<?php if(isset($text_val_1)){ echo $text_val_1;}?>" class="text"/></div>
      <div class="detail_row">
       <label>Key Individual #2: </label>
      <input type="text" id="key_2"  name="key[]" <?php echo $disabled;?>  value="<?php if(isset($text_val_2)){ echo $text_val_2;}?>" class="text"/></div>
      <div class="detail_row">
       <label>Key Individual #3: </label>
      <input type="text" id="key_3" name="key[]" <?php echo $disabled;?>  value="<?php if(isset($text_val_3)){ echo $text_val_3;}?>" class="text"/></div>
      
      <?php } ?>
      
       <?php if($flag=='7'){ ?>
       <h3><?php echo $caption;?></h3>
       <div class="detail_row">
      	 <label>Co-worker #1: </label>
      <input type="text" id="co_1"  name="co_worker[]" <?php echo $disabled;?>  value="<?php if(isset($text_val_1)){ echo $text_val_1;}?>" class="text"/></div>
      <div class="detail_row">
       <label>Co-worker #2: </label>
      <input type="text" id="co_2"  name="co_worker[]" <?php echo $disabled;?>  value="<?php if(isset($text_val_2)){ echo $text_val_2;}?>" class="text"/></div>
      <div class="detail_row">
       <label>Co-worker #3: </label>
      <input type="text" id="co_3" name="co_worker[]" <?php echo $disabled;?>  value="<?php if(isset($text_val_3)){ echo $text_val_3;}?>" class="text"/>
      </div>
      <?php } ?>
      
       <?php if($flag=='8'){ ?>
       <h3><?php echo $caption;?></h3>
       <div class="detail_row">
      	 <label>30 Day goal #1: </label>
      <input type="text" id="go_1"  name="goal[]" <?php echo $disabled;?>  value="<?php if(isset($text_val_1)){ echo $text_val_1;}?>" class="text"/></div>
      <div class="detail_row">
       <label>60 Day goal #2: </label>
      <input type="text" id="go_2"  name="goal[]" <?php echo $disabled;?>  value="<?php if(isset($text_val_2)){ echo $text_val_2;}?>" class="text"/></div>
      <div class="detail_row">
       <label>90 Day goal #3: </label>
      <input type="text" id="go_3" name="goal[]" <?php echo $disabled;?>  value="<?php if(isset($text_val_3)){ echo $text_val_3;}?>" class="text"/></div>
      
      <?php } ?>
      <?php if($disabled==''){?>
            <div class="submit_row">
      <input type="submit" value="SAVE" onclick="return submit_textboxtype();" class="save_btn"/>
      </div>
      <?php }?>
   </form>
   
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.nano').nanoScroller({alwaysVisible: true, contentClass: 'strategy_pop_up'});
	$('#opp_error').hide();
	});
function submit_textboxtype()
{
	var flag=$('#flag').val();
	var check_id=$('#check_id').val();
	if(flag=='1'){
			var text=$('#text_box').val();
			if(text=='')
			{
				$('#opp_error').html('Please enter <?php echo $caption;?>');	
				$('#opp_error').show();
				return false;
			}else{
					var frm1=$('#strat_textboxForm').serialize();
	$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');	
				$.post('<?php echo SITE_URL;?>/strategies/<?php echo $action;?>',frm1,function(data) {
					disablePopup();
					$('#li_a_'+check_id).addClass('done');
					get_strategy_meter();
					get_bar_meter_percent();
				});
				return false;
				}
	}else if(flag=='2'){
			
		$('#strat_textboxForm').validate({
			submitHandler: function(form){
				
					var f1=$('#reporter_name').val();
					var f2=$('#reporter_title').val();
					var f3=$('#reporter_email').val();
					var f4=$('#reporter_phone').val();
					if(f1==''&&f2==''&&f3==''&&f4=='')
					{
						$('#opp_error').html('Please enter details.');	
						$('#opp_error').show();
					}else{
							var frm1=$('#strat_textboxForm').serialize();
	$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');	
						$.post('<?php echo SITE_URL;?>/strategies/<?php echo $action;?>',frm1,function(frm1) {
							disablePopup();
							$('#li_a_'+check_id).addClass('done');
							get_strategy_meter();
							get_bar_meter_percent();
						});
					}
					return false;
				
				}
			
			});
		//alert(1);
		
		
		}else if(flag=='3')
		{
			var job1=$('#job_e_1').val();
			var job2=$('#job_e_2').val();
			var job3=$('#job_e_3').val();
			validate_field(job1,job2,job3,'Job expectation');
		    return false;
			
		}else if(flag=='4')
		{
			var sal=$('#salary_offered').val();
			var vac=$('#vacation_time').val();	
			var val=$('#check_radio_benefit').val();
			var check=1;
			if(sal==''){ $('#opp_error').html('Please enter Salary Offered'); 
			$('#opp_error').show();
			check=0; return false;}
			
			if(val=='1')
			{
				var det=$('#benefit_details').val();
				if(det==''){ $('#opp_error').html('Please enter Benefit Details'); 
				$('#opp_error').show();
				check=0; return false;}	
			}
			if(vac==''){ $('#opp_error').html('Please enter Vacation Time'); 
			$('#opp_error').show();
			check=0; return false;}
			if(check=='1')
			{
					var frm1=$('#strat_textboxForm').serialize();
	$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');	
				$.post('<?php echo SITE_URL;?>/strategies/<?php echo $action;?>',frm1,function(frm1) {
					disablePopup();
					$('#li_a_'+check_id).addClass('done');
					get_strategy_meter();
					get_bar_meter_percent();
				});
				return false;
				}
			
		}else if(flag=='5')
		{
			var pdo1=$.trim($('#pdo_1').val());
			var pdo2=$.trim($('#pdo_2').val());
			var pdo3=$.trim($('#pdo_3').val());
			validate_field(pdo1,pdo2,pdo3,'Professional development opportunity');
			return false;			
		}else if(flag=='6')
		{
			var pdo1=$.trim($('#key_1').val());
			var pdo2=$.trim($('#key_2').val());
			var pdo3=$.trim($('#key_3').val());
			validate_field(pdo1,pdo2,pdo3,'Key individual');
			return false;			
		}else if(flag=='7')
		{			
			var pdo1=$.trim($('#co_1').val());
			var pdo2=$.trim($('#co_2').val());
			var pdo3=$.trim($('#co_3').val());
			validate_field(pdo1,pdo2,pdo3,'Co-worker');
			return false;			
		}else if(flag=='8')
		{
			var pdo1=$.trim($('#go_1').val());
			var pdo2=$.trim($('#go_2').val());
			var pdo3=$.trim($('#go_3').val());
			validate_field(pdo1,pdo2,pdo3,'Goal');
			return false;			
		}
}

function validate_field(a1,a2,a3,err)
{
		if(a3!='')
		{
			if(a2!=''&&a1!='')
			{		
					submit_text_form();
					return false;
					
			}else{
					show_error(err);
					return false;
					
				}	
		}else if(a2!='')
		{
			if(a1!='')
			{
				submit_text_form();
				return false;
			}else{
					
				show_error(err);
				return false;	
				}	
		}else if(!a1&&!a2&&!a3)
		{
				show_error(err);
				return false;	
		}else{
				submit_text_form();
				return false;
			}
			
}

function show_error(err)
{
	$('#opp_error').html('Please enter '+err); 
	$('#opp_error').show();
	return false;
}

function submit_text_form()
{		var check_id=$('#check_id').val();
	var frm1=$('#strat_textboxForm').serialize();
	$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');	
		$.post('<?php echo SITE_URL;?>/strategies/<?php echo $action;?>',frm1,function(frm1) {
						disablePopup();
						$('#li_a_'+check_id).addClass('done');
						get_strategy_meter();
						get_bar_meter_percent();
			});
		return false;	
	
}

function show_detail(val)
{
	if(val=='1')
	{	
		$('#label_show_benefit_details').show();
		$('#show_benefit_details').show();
		$('#check_radio_benefit').val('1');
		}else{
			$('#label_show_benefit_details').hide();
			$('#show_benefit_details').hide();
			$('#benefit_details').val('');
			$('#check_radio_benefit').val('0');
			}	
}
</script>
      