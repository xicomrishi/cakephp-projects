<div class="wrapper">  
  <section id="body_container">
  <div class="left">
  <h2> <?php echo __('Welcome to the Assessment Inventory of Project Management'); ?></h2>
  </div>
  <div class="login_detail right">
  	<div class="company_id  full"><?php echo __('Trainer Name:');?><span><?php echo $trainer['U']['first_name'].' '.$trainer['U']['last_name']; ?></span></div>
    <div class="company_id full"><?php echo __('Group ID:'); ?><span><?php echo $trainer['C']['course_id']; ?></span></div>
    <div class="company_id full"><?php echo __('Group Name:'); ?><span><?php echo $trainer['C']['course_name']; ?></span></div>
    
    </div>
   		 <div id="about" class="nano">
   		 <div class="discription"><?php echo $intro_text; ?></div>
    </div>
    <div id="flashMsg" style="display:none; padding:5px;"><p style="color:#F00; font-size:13px;">*<?php echo __('All question are mandatory.'); ?></p></div>
    <section class="container none">
    <form id="AssessmentForm" name="AssessmentForm" method="post" action="<?php echo $this->webroot; ?>assessment/submit_assessment" class="form">
    <fieldset>    	
    	<?php $i=0; $p=0;
			 foreach($data as $dat){ ?>
        	<div class="comn_sec">
        <h3 class="title"><?php if($i==0) echo __('Planning'); if($i==1) echo __('Organizing &amp; Staffing'); if($i==2) echo __('Directing &amp; Leading'); if($i==3) echo __('Controlling'); if($i==4) echo __('Reporting'); if($i==5) echo __('Risk Management'); ?><span><?php echo __('90-100% (almost always) , 75-89% (usually) , 50-74% (often)<br>25-49% (sometimes) , 0-24% (seldom)'); ?></span></h3>
        <div class="inner none"> 
                <table class="table none">
                  <tbody>
                  <tr>
                    <th class="none">&nbsp;</th>
                    <th class="center">A<br>(90-100%)</th>
                    <th class="center">B<br>(75-89%)</th>
                    <th class="center">C<br>(50-74%)</th>
                    <th class="center">D<br>(25-49%)</th>
                    <th class="center">E<br>(0-24%)</th>
                  </tr>
                 
                  <?php 
				  $j=1;
				  foreach($dat['question'] as $ques){ ?>
                  	<tr class="<?php if($j%2==0) echo 'even'; else echo 'odd'; ?>">                   
                    <td  class="none"><?php echo $j; ?>. <?php echo $ques['text']; ?></td>
                    <input type="hidden" name="data[<?php echo $i; ?>][<?php echo $j; ?>][participant_id]" value="<?php echo $participant_id; ?>"/>
                    <input type="hidden" name="data[<?php echo $i; ?>][<?php echo $j; ?>][tool_id]" value="1"/>
                    <input type="hidden" name="data[<?php echo $i; ?>][<?php echo $j; ?>][qid]" value="<?php echo $ques['id']; ?>"/>
                    <input type="hidden" name="data[<?php echo $i; ?>][<?php echo $j; ?>][qkey]" value="<?php echo $ques['question_key']; ?>"/>
                    
                    <?php for($m=5;$m>0;$m--){ ?>
                    <td align="center"><div class="select"><input class="check validate[required]" type="radio" name="data[<?php echo $i; ?>][<?php echo $j; ?>][check]" value="<?php echo $m; ?>" onClick="$('.tooltip').hide(); $('#tooltip_<?php echo $i.'_'.$j.'_'.$m; ?>').fadeIn('fast');" <?php if(isset($is_response)){ if(($m==$responses[$p]['Response']['response'])) echo 'checked disabled'; } ?>>
                    <div class="tooltip" id="tooltip_<?php echo $i.'_'.$j.'_'.$m; ?>">
            					<div class="tt"><?php echo __('Please enter comments if you wish to support your scoring'); ?>
                            		<span class="input_box"><input type="text" name="data[<?php echo $i; ?>][<?php echo $j; ?>][inp][<?php echo $m; ?>]" placeholder="Comments"/><a href="javascript://" onclick="$('.tooltip').fadeOut('fast');"><img src="<?php echo $this->webroot; ?>img/yes.png" alt=""/></a></span>
                            	</div>
            					<div class="arrow"> </div>
            				</div></div></td>
                    <?php } ?>                    
                  </tr>
                  <?php $j++; $p++; } ?>                                    
                </tbody>
              </table>
            </div>
         </div>
        <?php $i++; } ?>
       <?php if(!isset($is_response)){ ?>	  
      		 <input type="submit" id="resp_form_submit" value="Submit" onclick="return response_form_submit();" >
       <?php } ?>
       </fieldset>
       </form>  
    </section>
  </section>
</div>
<script type="text/javascript">
$(document).ready(function(e) {

    setTimeout(function(){ $(".nano").nanoScroller({alwaysVisible:true, contentClass:'discription',sliderMaxHeight: 70 }),500});
	 $('#body_container').click(function(e){
		 var clickedOn = $(e.target);
   			 if (clickedOn.parents().andSelf().is('.select'))
			 {}else{
					$('.tooltip').hide(); 
				}
	 });
	 
	 $('#resp_form_submit').click(function(e) {
        $('#resp_form_submit').hide();
		response_form_submit();
    });
});
</script>