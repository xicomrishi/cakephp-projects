<div class="actions">
<span class="img_box">
                    <?php if($Recruiter['Recruiter']['profile_photo']!=''){?>
                    <img src="<?php echo $this->webroot;?>files/recruiter_images/<?php echo $Recruiter['Recruiter']['profile_photo'];?>" alt="" width="150" height="160"/>
                    <?php }else{?>
                    	<img src="<?php echo $this->webroot;?>images/profile_pic.png" alt=""/>
                    <?php }?>
                    	
        </span>
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Delete Recruiter', true), array('action' => 'delete', $Recruiter['Recruiter']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $Recruiter['Recruiter']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Recruiter', true), array('action' => 'index')); ?> </li>

	</ul>
</div>
<?php //echo '<pre>';
//print_r($Recruiter);die;?>
<div class="professional view">
	<h2><?php echo __('Recruiter');?></h2>
	<table style="width:400px" cellpadding="0" cellspacing="0">
		
		<tr><td>Email</td><td><?php echo $Recruiter['Recruiter']['email']; ?></td></tr>
		
		<tr><td>First Name</td><td><?php echo $Recruiter['Recruiter']['first_name']; ?></td></tr>
		<tr><td>Last Name</td><td><?php echo $Recruiter['Recruiter']['last_name']; ?></td></tr>
        <tr><td>Current Role</td><td><?php echo $Recruiter['Recruiter']['current_role']; ?></td></tr>
        <tr><td>Current Company</td><td><?php echo $Recruiter['Recruiter']['current_company']; ?></td></tr>
        <tr><td>Company Website</td><td><?php echo $Recruiter['Recruiter']['company_website']; ?></td></tr>
        <tr><td>Current Designation</td><td><?php echo $Recruiter['Recruiter']['current_designation']; ?></td></tr>
        <tr><td>Phone Number</td><td><?php echo $Recruiter['Recruiter']['phone_nbr']; ?></td></tr>
        <tr><td>Current Location</td><td><?php echo $Recruiter['Recruiter']['current_location']; ?></td></tr>
        <?php $expInYear=(int)($Recruiter['Recruiter']['recruiting_experience']/12);
	$expInMonth=(int)($Recruiter['Recruiter']['recruiting_experience']%12); 
		?>
        <tr><td>Recruiting Experience</td><td><?php echo $expInYear.' yrs '.$expInMonth.' months'; ?></td></tr>
        <tr><td>Skills</td><td><?php echo $Recruiter['Recruiter']['skills']; ?></td></tr>
          <tr><td>Roles</td><td><?php echo $Recruiter['Recruiter']['roles']; ?></td></tr>
             <tr><td>Geographies</td><td><?php echo $Recruiter['Recruiter']['geographies']; ?></td></tr>
             <?php if(!empty($Recruiter['Recruiter']['type_of_companies'])){?>
             <tr><td>Type Of Companies</td><td><?php echo $Recruiter['Recruiter']['type_of_companies'];?></td></tr>
             <?php }?>
             <?php    
                   $online_profiles=unserialize(base64_decode($Recruiter['Recruiter']['online_profiles']));
							extract($online_profiles);?>
                            <tr><td>Online Profiles</td><td colspan="11">
                            <?php if(!empty($linkedin)){?>
                                    <a href="<?php echo $linkedin;?>" target="_blank">
                                    <img src="<?php echo $this->webroot;?>images/profile_filter_icon1.png" alt="" title="LinkedIn" /></a>
								<?php }?>
                               <?php if(!empty($googleplus)){?>
                                   <a href="<?php echo $googleplus;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon2.png" alt="" title="Google+" /></a>
                                <?php }?>
                               <?php if(!empty($facebook)){?>
                                <a href="<?php echo $facebook;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon3.png" alt="" title="Facebook" /></a>
                            <?php }?>
                               <?php if(!empty($twitter)){?>
                                <a href="<?php echo $twitter;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon4.png" alt=""
                                    title="Twitter" /></a>
                            <?php }?>
                               <?php if(!empty($xing)){?>
                                    <a href="<?php echo $xing;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon5.png" alt="" title="Xing" /></a>
                                <?php }?>
                                
                               
                                
                                 <?php if(!empty($pinterest)){?>
                                    <a href="<?php echo $pinterest;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon10.png" alt=""
                                        title="Pinterest" /></a>
                                <?php }?>
                                 <?php if(!empty($apnacircle)){?>
                                    <td><a href="<?php echo $apnacircle;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon11.png" alt=""
                                        title="ApnaCircle" /></a></td>
                                <?php }?>
                                <?php if(!empty($blogger[0])){?>
                                    <a href="<?php echo $blogger[0];?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon12.png" alt=""
                                        title="Blogger" /></a>
                                <?php }?>
                                <?php if(!empty($skillpages)){?>
                                    <a href="<?php echo $skillpages;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon13.png" alt="" title="Skillpages" /></a>
                                <?php }?>
                                 <?php if(!empty($about_me)){?>
                                    <a href="<?php echo $about_me;?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon14.png" alt="" title="About me" /></a>
                                <?php }?>
                                <?php if(!empty($other['website_name'])){?>
                                    <a href="<?php echo $other['website_link'];?>" target="_blank"><img src="<?php echo $this->webroot;?>images/profile_filter_icon14.png" alt="" title="Others" /></a>
                                <?php }?>
                            </td></tr>
             <tr><td>Recruiter Domain</td><td>
              <?php //print_r($Recruiter['RecruiterDomain']); 
			 $domainStr='';
			 foreach($Recruiter['RecruiterDomain'] as $RecruiterDomain){
				 foreach($domain as $key=>$value){
					 if($key==$RecruiterDomain['domain_id']){
						 $domainStr=$domainStr.$value.', ';
					 }
				 }
			 }
			 $domainStr=rtrim($domainStr,', ');?>
			<?php echo $domainStr;?>
             </td></tr>
              <tr><td>Profile Added Date</td><td><?php echo $Recruiter['Recruiter']['profile_added_date']; ?></td></tr>
               <tr><td>Profile Modified Date</td><td><?php echo $Recruiter['Recruiter']['profile_modified_date']; ?></td></tr>
               <tr><td>Status</td><td>
                    <?php if($Recruiter['Recruiter']['status']==1){ echo 'Active';} else{ echo 'Inactive';}?>
                    </td></tr>
              
			
	</table>
    <h2><?php echo __('Recruiter Clients');?></h2>
    <table class="update_client">
                	<thead>
                    	<tr>
                        	<th>Company</th>
                            <th>Type of hire</th>
                            <th class="last">Candidates Placed</th>
                        </tr>
                    </thead>
                    <tbody class="client_data">
                    	
                        <?php 
						
						if(!empty($Recruiter['RecruiterClient'])){ 
						
						foreach($Recruiter['RecruiterClient'] as $client){ ?>
                        <tr>
                        <td style="text-align:center"><?php echo $client['company_name'];?></td>
                        <td style="text-align:center"><?php echo $client['type_of_hire'];?></td>
                        <td class="last" style="text-align:center"><?php echo $client['candidate_placed'];?></td>
                        </tr>
                        <?php } }?>
                    </tbody>
                </table>
</div>

