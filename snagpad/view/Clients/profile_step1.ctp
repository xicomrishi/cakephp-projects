<?php echo $this->Html->css('jquery.ui.autocomplete');?>
<?php echo $this->Html->script(array('jquery.ui.position','jquery.ui.menu','jquery.ui.autocomplete'));?>
<style>
.ui-autocomplete{width:385px !important;
	word-wrap:break-word !important;
	z-index:99999999 !important;
}
.ui-menu-item{ list-style:none !important;  }	
.ui-menu-item a{ font-size:12px !important; float:left; width:98% !important; padding:4px !important; }
.ui-menu-item:hover a{ color:#fff !important; background-color:#F07700 !important; }
</style>
<div id="step">
<?php echo $this->element('profile_progress');?>

<div class="show_loading_img">
<section class="head_row">
  <h3>Enter Job A</h3>
  <p>Knowing what job you're looking for is important for staying focused in your job search. Enter the Job Title below for the job you're most interested in getting. Moving forward you will now refer to this job as Job A.</p>
  </section>
  <section class="pop_up_detail">
  <div id="select_err" align="center" style="display:none;">Please enter Job A.</div>
 			<div class="nano">	
              <section class="job_descrip_box">
              <?php echo $this->Form->create('Client',array('id'=>'ClientProfileWizardForm'));?>
              <!--<form  class="stepForm" name="stepForm" action="">-->
              <fieldset>
               <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid;?>"/>
              
              <?php echo $this->Form->input('Client.id',array('type'=>'hidden'));?>
              <?php echo $this->Form->input('Client.job_a_title',array('type'=>'text','label'=>false,'class'=>'required'));?>
              
              </fieldset>
              </form>
              <p>TIP: It's important to indicate your ideal job so that when you're using your SnagPad<br> and networking with contacts they are clear on what kind of job<br> you're looking for.</p>              
             
              <?php if(isset($job_a_title)&&!empty($job_a_title)){ ?>
             <span class="btn_row" style="width:100%">
             <a href="javascript://" onclick="load_pop('moodle');" class="learn_more">Learn more:Click here to complete training</a>
              <!--<input type="submit" class="save_btn" onclick="save_step();" value="SAVE &amp; NEXT"/>-->
              <a href="javascript://" onclick="save_step();" class="save_btn">SAVE &amp; NEXT</a>
              <?php //if($skip=='1') { ?>
             <a href="javascript://" class="skip_btn" onclick="step('2')">SKIP ></a>
                            <?php //} ?>
              </span>
              <?php }else{ ?>
              	 <span class="btn_row">
              <!--<input type="submit" class="save_btn" onclick="save_step();" value="SAVE &amp; NEXT"/>-->
              <a href="javascript://" onclick="save_step();" class="save_btn">SAVE &amp; NEXT</a>
              <?php //if($skip=='1') { ?>
             <a href="javascript://" class="skip_btn" onclick="step('2')">SKIP ></a>
                            <?php //} ?>
              </span>
              <?php } ?>
              </section>
              </div>      
  </section>
 </div> 
 <ul class="pop_up_paging">
	<?php echo $this->element('profile_steps');?>
  </ul>
</div>
<script language="javascript">
$(document).ready(function(e) {
	$("html, body").animate({ scrollTop: 0 }, 600);
	var availableTags=[<?php 
			$last=count($jobs); 
			$m=1;
			foreach($jobs as $j ){ 
				if($m==$last){
					echo '"'.$j.'"';
					}else{
						echo '"'.$j.'",'; } }?>];
			
	$( "#ClientJobATitle" ).autocomplete({
			source: availableTags,
			focus: function( event, ui ) {
				$( "#ClientJobATitle" ).val( ui.item.label );
				return false;
			}
		});
		
     $(".nano").nanoScroller();
	$("#ClientProfileWizardForm").validate({
		debug:false
	});
});
function save_step()
{		
		var jobA=$('#ClientJobATitle').val();
		if(jobA=='')
		{	$('#select_err').show();
			}
		else{	
		frm=$('#ClientProfileWizardForm').serialize()
		$(".show_loading_img").html('<div class="back_scroll"><?php echo $this->Html->image('loading.gif',array('escape'=>false));?></div>');		
		$.post("<?php echo SITE_URL; ?>/clients/profile_step1",frm,function(data){						
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