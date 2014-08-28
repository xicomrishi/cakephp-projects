<style>
#login_container{ width:800px; }
.login_details{ width:798px !important; }
.right{ margin-right:13px;}
#login_container .login_details .inner .reports { height:300px;}
</style>
<section id="login_container" class="account">
	<div class="login_details account">	
		<h3 class="title"><?php echo __('Company programmes'); ?></h3>	
		<div class="top_row">
        
        
        </div>
        
        <div class="inner">
        <div id="about" class="nano">
        <div class="reports">
        <?php if(!isset($no_found)){ ?>
        <table class="table none1">
        <thead>
        <tr>
        <th class="center"><?php echo __('S.No.'); ?></th>
        <th class="center"><?php echo __('Group ID'); ?></th>
        <th class="center"><?php echo __('Group Name'); ?></th>
        <th class="center"><?php echo __('Trainer'); ?></th>
        <th class="center"><?php echo __('Start Date'); ?></th>
        <th class="center"><?php echo __('End Date'); ?></th>
        </tr>
        </thead>        
            <tbody>
            <?php $i=1; foreach($data as $dat){ ?>
                <tr class="part_row <?php if($i%2==0) echo ' even'; else echo ' odd'; ?>">
                    <td><?php echo $i; ?></td>
                    <td><a href="javascript://" onclick="open_lightbox('/course/accountability/<?php echo $dat['Course']['id']; ?>/<?php echo $comp_id; ?>',805);"><?php echo $dat['Course']['course_id']; ?></a></td>
                    <td><a href="<?php echo $this->webroot; ?>reports/project_management_trainer_report/<?php echo $dat['Course']['course_id']; ?>" target="_blank"><?php echo $dat['Course']['course_name']; ?></a></td>
                    <td><?php echo $dat['User']['first_name'].' '.$dat['User']['last_name']; ?></td>
                    <td><?php echo show_formatted_date($dat['Course']['start_date']); ?></td>
                    <td><?php echo show_formatted_date($dat['Course']['end_date']); ?></td>
                </tr> 
            <?php $i++; } ?>        
            </tbody>
        </table>
        <?php }else{ ?>
        <p><?php echo __('No Groups found!'); ?></p>
        <?php } ?>
        </div>
        </div>
        </div>

     </div>
</section>