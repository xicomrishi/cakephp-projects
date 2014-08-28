<style>
#login_container form { padding-top:0px;}
#login_container form p { padding-bottom:10px; }
.personal_detail a{ color: #333333;float: left;margin-left: 52px;margin-top: 20px;}
.signup_form .common_section { padding-top:0%;}
.signup_form .last{ border:none; }

</style>
<section id="login_container" class="personal_detail">
	<div class="login_details personal_detail">	
		<h3 class="title"><?php echo __('Participant Profile'); ?> <a href="javascript://" onclick="open_lightbox('/course/accountability/<?php echo $course['Course']['id']; ?>/<?php if(isset($comp_id)) echo $comp_id; else echo '0'; ?>',805);"><?php echo __('Go back'); ?></a></h3>
		
        
			
    <div class="tab_detail">
    	            
            <div id="infoMsg"></div>   	
            <section class="signup_form">
            	<div class="common_section"> 
                    <p><label><?php echo __('First Name');?>:</label><span><?php echo $user[0]['U']['first_name']; ?></span></p>
                    <p><label><?php echo __('Last Name');?>:</label><span><?php echo $user[0]['U']['last_name']; ?></span></p>
                    <p><label><?php echo __('Country');?>:</label><span><?php echo $user[0]['CO']['country_name']; ?></span></p>
                    <p><label><?php echo __('City');?>:</label><span><?php if(!empty($user[0]['U']['city'])) echo $user[0]['U']['city']; else echo 'N/A'; ?></span></p>
                    <p><label><?php echo __('Industry');?>:</label><span><?php echo $user[0]['I']['industry']; ?></span></p>
                     
                </div>
                <div class="common_section last"> 
                    <p><label><?php echo __('Company');?>:</label><span><?php echo $user[0]['C']['company']; ?></span></p>
                        
                    <p><label><?php echo __('Phone');?>:</label><span><?php if(!empty($user[0]['U']['phone'])) echo $user[0]['U']['phone']; else echo __('N/A'); ?></span></p>
                    <p><label><?php echo __('Role');?>:</label><span><?php if($user[0]['P']['user_role_id']=='3') echo __('Project Manager'); else if($user[0]['P']['user_role_id']=='4') echo __('Team Member'); else if($user[0]['P']['user_role_id']=='5') echo __('Manager of Project Managers'); ?></span></p>
    
                    <p><label><?php echo __('Company Website');?>:</label><span><?php if(!empty($user[0]['U']['company_url'])) echo $user[0]['U']['company_url']; else echo 'N/A'; ?></span></p>
                    <p><label><?php echo __('Email');?>:</label><span><?php echo $user[0]['U']['email']; ?></span></p>
                    
                </div>
              
            </section> 	
            </div>

   
     </div>
</section>
