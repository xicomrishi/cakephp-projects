<div class="wrapper">   
  <section id="body_container">
  	<div class="menu">
    	<ul>
        	<li id="dash_tab_1" class="active first dash_tab"><a href="javascript://"><?php echo __('Dashboard'); ?></a></li>
        </ul>
    </div>
    <section class="container">
    
    <div class="tab_detail"> 
     <div class="invite">
     <?php if(isset($resp) && $resp==1){?>
     <a href="<?php echo $this->webroot; ?>assessment/project_management_edit/<?php echo $role_id; ?>"  style="background-color:#ccc; padding:5px;"><span><?php echo __('Edit Assessment >>'); ?></span></a>
     <a href="<?php echo $this->webroot; ?>reports/project_management_report/<?php echo $this->Session->read('User.Participant.Participant.id');?>"   style="background-color:#ccc; padding:5px;"><span><?php echo __('View Report >>'); ?></span></a>
     <?php }else{ ?>
      <span><?php echo __('Go to Assessment'); ?></span><a href="<?php echo $this->webroot; ?>assessment/project_management/<?php echo $role_id; ?>"><img src="<?php echo $this->webroot; ?>img/invite.png" alt=""/></a>
     <?php }?>
     </div>
     <h3 class="title">&nbsp;</h3>
        <div class="inner"><?php echo $intro_text; ?></div>
    </div>
    
    </section>
  </section>
</div>