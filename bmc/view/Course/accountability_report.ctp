<style>
#login_container{ width:800px; }
.login_details{ width:798px !important; }
.right{ margin-right:13px;}
#login_container .login_details .inner .reports { height:300px;}
</style>
<section id="login_container" class="account">
	<div class="login_details account">	
		<h3 class="title"><?php echo __('Programme Participants'); ?> <?php if(isset($comp_id)){ ?><a href="javascript://" onclick="open_lightbox('/companies/get_company_courses/<?php echo $comp_id; ?>',805);"><?php echo __('Go Back'); ?></a><?php } ?></h3>	
		<div class="top_row">
        <?php if(!isset($comp_id)){ ?>
        <!--<div class="cradit">
        <select id="comp_list_box" onchange="update_participant(this.value);">
        	<option value="0"><?php echo __('Select Company'); ?></option>
        	<?php foreach($companies as $comp){ ?>
            	<option value="<?php echo $comp['Company']['id']; ?>"><?php echo $comp['Company']['company']; ?></option>
            <?php } ?>
        </select>
        </div>-->
        <?php } ?>
       
        <div class="right">
        <div class="company_id"><?php echo __('Trainer Name:'); ?><span><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></span></div><br>
        <div class="company_id"><?php echo __('Group ID:'); ?><span onclick="get_companies_list('<?php echo $course['Course']['id']; ?>');"><?php echo $course['Course']['course_id']; ?></span></div>
        </div>
        </div>
        
        <div class="inner">
        <div id="about" class="nano">
        <div class="reports">
        <table class="table none1">
        <thead>
        <tr>
        <th class="center"><?php echo __('S.No.'); ?></th>
        <th class="center"><?php echo __('Participant'); ?></th>
        <th class="center"><?php echo __('Email'); ?></th>
        <th class="center"><?php echo __('Company'); ?></th>
        <th class="center"><?php echo __('Status'); ?></th>
        <th class="center"><?php echo __('Report'); ?></th>
        
        <th class="center"><?php echo __('Action Plan'); ?></th>
        <?php if(!isset($comp_id)&&$this->Session->read('User.type')!='Admin'){ ?>
        <th class="center"><?php echo __('Action'); ?></th>
		<?php } ?> 
        </tr>
        </thead>        
            <tbody>
            <?php $i=1; foreach($participants as $part){ ?>
                <tr class="part_row comp_<?php echo $part['U']['company']; ?><?php if($i%2==0) echo ' even'; else echo ' odd'; ?>">
                    <td><?php echo $i; ?></td>
                    <td><a href="javascript://" onclick="open_lightbox('/participant/view_participant/<?php echo $part['P']['id']; ?>/<?php if(isset($comp_id)){ echo $comp_id; }else{ echo '0'; }?>',985);"><?php echo $part['U']['first_name'].' '.$part['U']['last_name']; ?></a></td>
                    <td><?php echo $part['U']['email']; ?></td>
                    <td><?php echo $part['C']['company']; ?></td>
                    <td><?php if($part['P']['status']==0) echo 'Registered <br>'.show_formatted_date($part['P']['created']); else echo 'Completed <br>'.show_formatted_date($part['P']['survey_completion']); ?></td>
                    <td><?php if($part['P']['status']==0) echo 'N/A'; else{ ?><a href="<?php echo $this->webroot; ?>reports/project_management_report/<?php echo $part['P']['id']; ?>" target="_blank"><?php echo __('View Report'); ?></a><br><br><a href="javascript://" onclick="delete_assessment('<?php echo $part['P']['id']; ?>','<?php echo $course['Course']['id']; ?>');"><?php echo __('Delete Report'); ?></a><?php } ?></td>
                    <td><?php if($part['P']['action_plan_status']==1){ ?><a href="<?php echo $this->webroot; ?>reports/view_action_plan/<?php echo $part['P']['id']; ?>" target="_blank"><?php echo __('View'); ?></a><?php }else{   ?><a href="<?php echo $this->webroot; ?>reports/action_plan/<?php echo $part['P']['id']; ?>" target="_blank">View</a><?php } ?></td>
                    
                    <?php if(!isset($comp_id)&&$this->Session->read('User.type')!='Admin'){ ?>
                    <td><?php if($part['P']['status']==1) echo '-'; else{ ?><a href="javascript://" onclick="remove_participant('<?php echo $part['P']['id']; ?>','<?php echo $course['Course']['id']; ?>','<?php echo $trainer_id; ?>');"><?php echo __('Remove from survey'); ?></a><?php } ?></td>
                    <?php } ?>
                </tr> 
            <?php $i++; } ?>        
            </tbody>
        </table>
        </div>
        </div>
        </div>

     </div>
</section>

<script type="text/javascript">
$(document).ready(function(e) {
    setTimeout(function(){ $(".nano").nanoScroller({alwaysVisible:true, contentClass:'reports',sliderMaxHeight: 70 }),500});
});

function update_participant(comp_id)
{
	if(comp_id!=0)
	{
	$('.part_row').hide();
	$('.comp_'+comp_id).show();	
	$(".nano").nanoScroller({alwaysVisible:true, contentClass:'reports',sliderMaxHeight: 70 });
	}else{
		$('.part_row').show();
		$(".nano").nanoScroller({alwaysVisible:true, contentClass:'reports',sliderMaxHeight: 70 });
	}
}

function get_companies_list(cr_id)
{
	$('.reports').html('<div style="margin-top:100px;"><img src="<?php echo $this->webroot; ?>img/hourglass.gif"/></div>');	
	$('.cradit').hide();
	$('.login_details h3').html('<?php echo __('Accountability Report'); ?> <a href="javascript://" onclick="open_lightbox(\'/course/accountability/<?php echo $course['Course']['id']; ?>/<?php if(isset($comp_id)) echo $comp_id; else echo '0'; ?>\',805);"><?php echo __('Go back'); ?></a>');
	$(".nano").nanoScroller({alwaysVisible:true, contentClass:'reports',sliderMaxHeight: 70 });
	$.post(site_url+'/companies/get_companies_list/'+cr_id,function(data){
		$('.reports').html(data);
		$(".nano").nanoScroller({alwaysVisible:true, contentClass:'reports',sliderMaxHeight: 70 });	
	});
}

function delete_assessment(pr_id,cr_id)
{
	y=confirm("Are you sure you want to delete report?");
	if(y){
		showLoading('.login_details');
		$.post(site_url+'/course/remove_assessment/'+pr_id+'/'+cr_id,function(data){
			$('.fancybox-inner').html(data);
		});	
	}
}
</script>