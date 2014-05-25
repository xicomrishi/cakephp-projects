
<div class="menu">
    	<ul>
        	<li id="dash_tab_1" class="<?php if($this->params['controller']=='dashboard') echo 'active'; ?> first dash_tab" onclick="get_page('trainer_dashboard','.tab_detail');"><a href="javascript://"><?php echo __('Dashboard'); ?></a></li>
            <li id="dash_tab_2" class="<?php if($this->params['controller']=='course') echo 'active'; ?> second dash_tab" onclick="get_courses_index('<?php echo $trainer_id; ?>');"><a href="javascript://"><?php echo __('Groups'); ?></a></li>
        </ul>
    </div>