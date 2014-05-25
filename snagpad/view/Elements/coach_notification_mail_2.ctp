<table border="0" cellpadding="0" cellspacing="0" width="600" bgcolor="#eaeaea">  
 	<tr>	
     	<td style="font-size:16px; line-height:18px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#0a79a7;">Good morning <i> <?php echo $data['CH']['Coach']['name'];?>,</i></td>
  </tr>
  <tr><td style="font-size:0px;" height="10"></td></tr>
  <tr>	
     	<td style="font-size:16px; line-height:18px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#0a79a7;">Here is a list of your client activity. Click on any of the items to access more information.</td>
  </tr>
   <tr><td style="font-size:0px;" height="10"></td></tr>
<tr>
<td width="100%" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="400" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">        
        <!-- Start Action Reminder -->                   
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr>        
        <tr>	<!--4th text tr-->
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">      
            <tr>
                <td width="10" style="font-size:0px"></td>
                <td width="60" style="font-size:0px"><?php echo $this->Html->image($site_url.'/img/reminder.png',array('escape'=>false,'border'=>'0'));?></td>
                <td width="190" align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff; font-weight:bold">Client Activity</td>
                <td width="130" style="font-size:0px;  text-align:right" align="right"><?php 
				 $query_string1 = ("file=coach&action=index");
		$url1 =$site_url. "/Pages/display?".$query_string1;	
		 echo $this->Html->link($this->Html->image($site_url.'/img/manage_pad.jpg',array('escape'=>false,'border'=>'0')),$url1,array('escape' => false)); ?></td>
                <td width="10" style="font-size:0px"></td>
            </tr>             
            </table>
        </td>
        </tr>                       
        <tr><td height="24" style="font-size:0px"></td></tr> 
        <!-- Start Application Deadlines  1.1-->  
        <?php $noAction=0;
		if($check['count_login_flag']==1){ $noAction=1; ?> 
        <tr>	<!--hr line with color 3-->
        	<td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td>
        </tr>  
        <tr>	<!--5th text tr-->
        <td valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">
            <tr>	
                <td height="10" style="font-size:0px" colspan="2"></td>
            </tr>
            <tr>
                <td width="15" style="font-size:0px"></td>
                <td align="left" valign="middle" style="font-size:17px; line-height:19px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff; font-weight:bold;">Client Login</td>
            </tr>
            <tr>	
                <td height="10" style="font-size:0px" colspan="2"></td>
            </tr>
            </table>
        </td>
        </tr>
        <tr>	<!--Blank after 5th text tr-->
        	<td height="15" width="100%" style="font-size:0px"></td>
        </tr>        
        <tr>	<!--single text line 6-->
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;">The following clients have not logged into SnagPad in the past <?php echo $data['CH']['Coach']['login_user'].' days :'; ?><br/><br/><?php foreach($data['CL'] as $cl){ 
				if(isset($cl['login'])){ 
					$query_string1 = "file=jobcards&action=index&client_id=".$cl['C']['id'];
					$url1 =$site_url. "/Pages/display?".$query_string1;
					echo $this->Html->link($cl['login']['name'],$url1,array('escape' => false));
					echo ' - '.$cl['login']['email'].'<br>';
				
			 }} ?></td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr> 
        <?php } ?>
         <!-- Start Upcoming Interviews 1.2 -->  
        <?php if($check['count_app_flag']==1){ $noAction=1; ?> 
         <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr>
        <tr>
        <td valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">
                <tr><td height="10" style="font-size:0px" colspan="2"></td></tr>
                <tr>
                    <td width="15" style="font-size:0px"></td>
                    <td align="left" valign="middle" style="font-size:17px; line-height:19px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff; font-weight:bold;">Application Pending</td>
                </tr>
                <tr><td height="10" style="font-size:0px" colspan="2"></td></tr>
            </table>
        </td>
        </tr>
        <tr><td height="15" width="100%" style="font-size:0px"></td></tr>        
        <tr>
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;">The following clients have application deadlines:<br/><br/><?php foreach($data['CL'] as $cl){
						if(isset($cl['CD_app_count'])&&$cl['CD_app_count']>0)
						{
							$query_string1 = "file=jobcards&action=index&client_id=".$cl['C']['id'];
							$url1 =$site_url. "/Pages/display?".$query_string1;
							echo $this->Html->link($cl['CD_CL_name'],$url1,array('escape' => false));
							echo ' - '.$cl['CD_app_count'].' cards'.'<br/>';
						}
					
					}?></td>
        </tr>
        <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>          
        <?php } ?>
         <!-- Start Pending Thank You Notes 1.3-->  
        <?php if($check['count_intvw_flag']==1){ $noAction=1; ?> 
         <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr>
        <tr>
        <td valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">
            <tr><td height="10" style="font-size:0px" colspan="2"></td></tr>
            <tr>
                <td width="15" style="font-size:0px"></td>
                <td align="left" valign="middle" style="font-size:17px; line-height:19px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff;">Upcoming Interviews</td>
            </tr>
            <tr><td height="10" style="font-size:0px" colspan="2"></td></tr>
            </table>
        </td>
        </tr>
        <tr><td height="15" width="100%" style="font-size:0px"></td></tr>        
        <tr>	
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;">The following clients have upcoming interviews: <br/><br/><?php foreach($data['CL'] as $cl){
						if(isset($cl['CD_intvw_count'])&&$cl['CD_intvw_count']>0)
						{
							$query_string1 = "file=jobcards&action=index&client_id=".$cl['CD_CL_id'];
							$url1 =$site_url. "/Pages/display?".$query_string1;	
							echo $cl['CD_CL_name'].'  - '; 
							echo $this->Html->link($cl['CD_intvw_count'].' interviews',$url1,array('escape' => false)); ?><br/>
					<?php 	}} ?></td>
        </tr>
        <tr><td height="15" width="100%" style="font-size:0px"></td></tr> 
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>         
        <?php } ?>
         <!-- Identify hiring timeframe  1.4 -->  
        <?php if($check['count_cardmove_flag']==1){ $noAction=1; ?> 
         <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr>
        <tr>	<!--5th text tr-->
        <td valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">
            <tr><td height="10" style="font-size:0px" colspan="2"></td></tr>
            <tr>
                <td width="15" style="font-size:0px"></td>
                <td align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff;">Client job card movement</td>
            </tr>
            <tr>	
                <td height="10" style="font-size:0px" colspan="2"></td>
            </tr>
            </table>
        </td>
        </tr>
        <tr>	<!--Blank after 5th text tr-->
        	<td height="15" width="100%" style="font-size:0px"></td>
        </tr>        
        <tr>	<!--single text line 6-->
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;">The following clients have not moved a job card in a while now.For more details about the job card, click on the client you want to view and go through the job cards that have not moved. <?php echo $data['CH']['Coach']['card_moved'].' days :'; ?><br/><br/><?php foreach($data['CL'] as $cl){ 
				if(isset($cl['card_move'])){ 
				
				$query_string1 = "file=jobcards&action=index&client_id=".$cl['card_move']['id'];
							$url1 =$site_url. "/Pages/display?".$query_string1;	
							echo $this->Html->link($cl['card_move']['name'].' - '.$cl['card_move']['email'],$url1,array('escape' => false)); ?><br/>
					<?php 	}} ?></td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr> 
        <?php } ?> 
         <!-- Ask permission to follow up  1.5 -->  
        <?php if($check['count_clientaction_flag']==1){ $noAction=1; ?> 
         <tr>	<!--hr line with color 3-->
        	<td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td>
        </tr>
        <tr>	<!--5th text tr-->
        <td valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">
            <tr>	
                <td height="10" style="font-size:0px" colspan="2"></td>
            </tr>
            <tr>
                <td width="15" style="font-size:0px"></td>
                <td align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff; font-weight:bold;">Client action required</td>
            </tr>
            <tr>	
                <td height="10" style="font-size:0px" colspan="2"></td>
            </tr>
            </table>
        </td>
        </tr>
        <tr>	<!--Blank after 5th text tr-->
        	<td height="15" width="100%" style="font-size:0px"></td>
        </tr>        
        <tr>	<!--single text line 6-->
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040">The following clients have job cards in the 'Set Interview', 'Interview' and 'Verbal Job Offer' columns. You may consider contacting them to help pre are or review with them the job opportunity.<br/><br/><?php foreach($data['CL'] as $cl){ 
				if(isset($cl['ACT'])){ 
							$query_string1 = "file=jobcards&action=index&client_id=".$cl['card_move']['id'];
							$url1 =$site_url. "/Pages/display?".$query_string1;	
							foreach($cl['ACT'] as $act)
							{
								echo 'Client ';
								echo $this->Html->link($act['CD_CL'],$url1,array('escape' => false)); 
								echo ' has moved their job card <b>'.$act['CD_comp'].'</b> to the ';
								switch($act['CD_col'])
								{
									case 'S': echo '<b>Set Interview</b> Column.'; break;	
									case 'I': echo '<b>Interview</b> Column.'; break;	
									case 'V': echo '<b>Verbal Job Offer</b> Column.'; break;	
								} 
								echo '<br>';
								?>
                                
					<?php 	}}} ?></td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>   
        <?php } ?> 
        
        <!-- Ask permission to follow up  1.5 -->  
        <?php if($check['job_pref_update_flag']==1){ $noAction=1; ?> 
         <tr>	<!--hr line with color 3-->
        	<td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td>
        </tr>
        <tr>	<!--5th text tr-->
        <td valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">
            <tr>	
                <td height="10" style="font-size:0px" colspan="2"></td>
            </tr>
            <tr>
                <td width="15" style="font-size:0px"></td>
                <td align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff; font-weight:bold;">Job Preference Updates</td>
            </tr>
            <tr>	
                <td height="10" style="font-size:0px" colspan="2"></td>
            </tr>
            </table>
        </td>
        </tr>
        <tr>	<!--Blank after 5th text tr-->
        	<td height="15" width="100%" style="font-size:0px"></td>
        </tr>        
        <tr>	<!--single text line 6-->
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040">The following clients have updated their job preferences:<br/><br/><?php foreach($data['CL'] as $cl){ 
				if(isset($cl['job_pref_update'])){ 
							$query_string1 = "file=jobcards&action=index&client_id=".$cl['C']['id'];
							$url1 =$site_url. "/Pages/display?".$query_string1;	
							
								echo $this->Html->link('<b>'.$cl['job_pref_update']['cl_name'].'</b><br>',$url1,array('escape' => false)); 
								
								echo '<b>Job A: </b>'.$cl['job_pref_update']['job_A'].'<br><b>Job B Skills: </b>'.$cl['job_pref_update']['job_Skills'].'<br><b>Job B Criteria: </b>'.$cl['job_pref_update']['job_Criteria'];
								echo '<br>';
								?>
                                
					<?php 	}} ?></td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>   
        <?php } ?> 
        
         <!-- Learn desired start date 1.6 -->  
        <?php if($check['CD_count_flag']==1){ $noAction=1; ?> 
         <tr>	<!--hr line with color 3-->
        	<td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td>
        </tr>
        <tr>	<!--5th text tr-->
        <td valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">
            <tr>	
                <td height="10" style="font-size:0px" colspan="2"></td>
            </tr>
            <tr>
                <td width="15" style="font-size:0px"></td>
                <td align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff">Less than 5 job cards</td>
            </tr>
            <tr>	
                <td height="10" style="font-size:0px" colspan="2"></td>
            </tr>
            </table>
        </td>
        </tr>
        <tr>	<!--Blank after 5th text tr-->
        	<td height="15" width="100%" style="font-size:0px"></td>
        </tr>        
        <tr>	<!--single text line 6-->
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040">'The following clients have lest then 5 job cards on their pad. You may consider reviewing with them where they go to look for job leads<br/><br/><?php foreach($data['CL'] as $cl){
						if(isset($cl['Less_CD']))
						{
							$query_string1 = "file=jobcards&action=index&client_id=".$cl['Less_CD']['cl_id'];
							$url1 =$site_url. "/Pages/display?".$query_string1;	
							echo $this->Html->link($cl['Less_CD']['cl_name'],$url1,array('escape' => false)); ?><br/>
					<?php 	}} ?></td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>          
        <?php } ?>
         <!-- Determine when the employer expects a response 1.7 -->  
        <?php if($check['my_coachcard_flag']==1){ $noAction=1; ?> 
         <tr>	<!--hr line with color 3-->
        	<td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td>
        </tr>
        <tr>	<!--5th text tr-->
        <td valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">
            <tr>	
                <td height="10" style="font-size:0px" colspan="2"></td>
            </tr>
            <tr>
                <td width="15" style="font-size:0px"></td>
                <td align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff;">My Coach Cards</td>
            </tr>
            <tr>	
                <td height="10" style="font-size:0px" colspan="2"></td>
            </tr>
            </table>
        </td>
        </tr>
        <tr>	<!--Blank after 5th text tr-->
        	<td height="15" width="100%" style="font-size:0px"></td>
        </tr>        
        <tr>	<!--single text line 6-->
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;">The following clients have moved one of your job cards:<br/><br/><?php foreach($data['CL'] as $cl){
						if(isset($cl['CH_card']))
						{
							$query_string1 = "file=jobcards&action=index&client_id=".$cl['C']['id'];
							$url1 =$site_url. "/Pages/display?".$query_string1;	
							foreach($cl['CH_card'] as $chcard)
							{
								echo 'Client ';
								echo $this->Html->link($chcard['CD_CL'],$url1,array('escape' => false));
								echo ' has moved a job card <b>'.$chcard['CD_comp'].'</b> added by you to ';
								switch($chcard['CD_col'])
								{
									case 'O': echo '<b>Snagged Jobs</b> Column'; break;	
									case 'A': echo '<b>Applied</b> Column'; break;	
									case 'S': echo '<b>Set Interview</b> Column'; break;	
									case 'I': echo '<b>Interview</b> Column'; break;	
									case 'V': echo '<b>Verbal Job Offer</b> Column'; break;
									case 'J': echo '<b>Job</b> Column'; break;		
								} 
								echo '<br>';
							}}} ?></td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>          
        <?php } ?>
         
       <?php if($noAction==0) { ?>
         <!--<tr>	
        	<td width="100%" align="center" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040; font-style:italic;">You have no reminders.</td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr> -->
        <?php } ?>   
        <tr>
        <td width="100%" style="border:1px solid #838282;  background:#ffffff">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td style="font-size:0px" height="16">
        </td>
        </tr>
        <tr>
        <td align="center" valign="top"  style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;vertical-align:top;">
         <?php  $query_string1 = ("file=coach&action=settings&client_id=1");
		$url1 = $site_url. "/Pages/display?".$query_string1; ?>			
         Click to <?php echo $this->Html->link('Turn Off',$url1,array('escape' => false)); ?> <strong>Daily Email Notification</strong></td>
        </tr>
        <tr>
        <td style="font-size:0px" height="16">
        </td>
        </tr>
        </table>
     </td>
    </tr> 
    </table>
</td>
    
<td width="18" style="font-size:0px;"></td>

<td width="180" valign="top">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">    
    <tr>
    <td>
        <table  border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="font-size:15px; line-height:17px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-weight:bold; text-decoration:underline;">Number of Clients: <strong><?php if(isset($check['count_clients'])){ echo $check['count_clients']; } ?></strong></td>
            </tr>
            <tr><td style="font-size:0px;" height="8"></td></tr>
            <tr>
                <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">Active Clients - <b><?php echo $check['active']; ?></b></td>
            </tr>
            <tr><td style="font-size:0px;" height="8"></td></tr>
            <tr>
                <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">3 Days - <b><?php echo $check['active_three']; ?></b></td>
            </tr>
            <tr><td style="font-size:0px;" height="8"></td></tr>
            <tr>
                <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">>5 Days - <b><?php echo $check['active_five'];?></b></td>
            </tr>
            <tr><td style="font-size:0px;" height="8"></td></tr>
            <tr>
                <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">Active Coach Cards -<b><?php echo $check['Total_CH_Cards']; ?></b></td>
            </tr>
            <tr><td style="font-size:0px;" height="8"></td></tr>
            <tr>
                <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">Avg S-A-I -<b><?php echo $check['avg_S_cards'].'-'.$check['avg_A_cards'].'-'.$check['avg_I_cards'];?></b></td>
            </tr>
        </table>
    </td>
    </tr>
    <!--<tr>
    	<td height="40" valign="top"  style="font-size:0px"></td>
    </tr>
     <?php if (isset($row['client_no_card_movement'])){ ?> 
    <tr>
    <td>
        <table  border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
        <td style="font-size:15px; line-height:17px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-weight:bold; text-decoration:underline;"">Job Card Movement (Getting Cold)</td>
        </tr>
        <tr><td style="font-size:0px;" height="8"></td></tr>
        <tr>
        <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;"> <?php echo $row['client_no_card_movement'];?> </td>
        </tr>
        </table>
    </td>
    </tr>
    <tr><td height="40" valign="top"  style="font-size:0px"></td></tr>
     <?php } ?> 
      <?php if (isset($row['client_no_card_apply'])){ ?> 
    <tr>
    <td>
        <table  border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
        <td style="font-size:15px; line-height:17px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-weight:bold; text-decoration:underline; font-weight:bold">Snagged Jobs</td>
        </tr>
        <tr><td style="font-size:0px;" height="8"></td></tr>
        <tr>
        <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;"><?php echo $row['client_no_card_apply'];?></td>
        </tr>
        </table>
    </td>
    </tr>
    <tr><td height="40" valign="top"  style="font-size:0px"></td></tr>
     <?php } ?> 
    <tr>
    <td>
        <table  border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
        <td style="font-size:15px; line-height:17px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-weight:bold; text-decoration:underline; font-weight:bold;">Profile Completeness</td>
        </tr>
        <tr><td style="font-size:0px;" height="8"></td></tr>
        <tr>
        <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;"><?php echo $profile; ?></td>
        </tr>    
        </table>
    </td>
    </tr>
    <tr><td height="40" valign="top"  style="font-size:0px"></td></tr>
     <?php if (isset($facebook) || isset($linkdin) ){ ?> 
    <tr>
    <td>
        <table  border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
        <td style="font-size:15px; line-height:17px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-weight:bold;text-decoration:underline;">Social Connections</td>
        </tr>        
         <?php if (isset($facebook)){ ?>
         <tr><td style="font-size:0px;" height="8"></td></tr> 
        <tr>
        <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;"><?php echo $facebook; ?></td>
        </tr> 
         <?php } ?> 
          <?php if (isset($linkdin)){ ?>
         <tr><td style="font-size:0px;" height="8"></td></tr> 
        <tr>
        <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;"><?php echo $linkdin; ?></td>
        </tr> 
         <?php } ?> 
          <tr><td height="10" valign="top"  style="font-size:0px"></td></tr>  
        </table>
    </td>
    </tr>
    <?php } ?>-->    
    </table>
</td>
</tr>
</table>
</td>
</tr>  

      
</table>