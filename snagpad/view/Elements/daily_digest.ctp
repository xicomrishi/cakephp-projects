<table border="0" cellpadding="0" cellspacing="0" width="600" bgcolor="#eaeaea">  
 	<tr>	
     	<td style="font-size:16px; line-height:18px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#0a79a7;">Good morning <i> <?php echo $name?>,</i></td>
  </tr>
  <tr><td style="font-size:0px;" height="10"></td></tr>
  <tr>	
     	<td style="font-size:16px; line-height:18px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#0a79a7;">Your job search success depends on your intensity and organization. Use the daily digest to plan your day.</td>
  </tr>
   <tr><td style="font-size:0px;" height="10"></td></tr>
<tr>
<td width="100%" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="400" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
			
           <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr>        
        <tr>	<!--4th text tr-->
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">      
            <tr>
                <td width="10" style="font-size:0px"></td>
                <td width="250" height="40" align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff; font-weight:bold">Suggested Job Cards</td>
                <td width="130" style="font-size:0px;  text-align:right" align="right"><?php 
				 $query_string1 = ("file=jobsearch&action=index");
		$url1 =$site_url. "/Pages/display?".$query_string1;	
		 echo $this->Html->link($this->Html->image($site_url.'/img/browse_jobs.png',array('escape'=>false,'border'=>'0')),$url1,array('escape' => false)); ?></td>
                <td width="10" style="font-size:0px"></td>
            </tr>             
            </table>
        </td>
        </tr>                       
        <tr><td height="24" style="font-size:0px"></td></tr>
        
        <tr>	<!--single text line 6-->
        <td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">      
           			 <?php foreach($row['indeed_job'] as $indeed) { echo '<tr>'.$indeed.'</tr><tr><td>&nbsp;</td></tr>'; } ?>
                 </table>      
           </td>
        </tr>
        
          <!-- Start Challenges Reminder --> 
          <?php //if(in_array($row['client_id'],array(6,33,1,697))){  ?>  
          <?php if (isset($row['challenge_reminder']) || isset($row['challenge_new_reminder'])) {  
			  $btnChallange="view_all_challenges.png";	
			  $query_string = "file=Challenges&action=index";		  
			  if (isset($row['challenge_reminder'])) $txtChallange=$row['challenge_reminder']; 
				else $txtChallange=$row['challenge_new_reminder']; 
		  }
		  else
		  {
		  	$btnChallange="start_challenges.png";
			 $txtChallange="You have not started your challenges. To start, click on the 'Start Challenges Now' button to begin.";			  
			  $query_string = "file=Challenges&action=index&card_id=start";
		  }
			  ?>                 
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr>        
        <tr>	<!--4th text tr-->
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">      
            <tr>
                <td width="10" style="font-size:0px"></td>
                <td width="60" style="font-size:0px"><?php echo $this->Html->image($site_url.'/img/icon_challenge.png',array('escape'=>false,'border'=>'0'));?></td>
                <td width="190" align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff; font-weight:bold">Challenges</td>
                <td width="130" style="font-size:0px;  text-align:right" align="right"><?php				
				$url =$site_url. "/Pages/display?".$query_string;	
		 echo $this->Html->link($this->Html->image($site_url.'/img/'.$btnChallange,array('escape'=>false,'border'=>'0')),$url,array('escape' => false)); ?></td>
                <td width="10" style="font-size:0px"></td>
            </tr>             
            </table>
        </td>
        </tr> 
        <tr><td height="15" style="font-size:0px"></td></tr>
        <tr>	<!--single text line 6-->
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;"><?php echo $txtChallange; ?></td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>                            
        <tr><td height="15" style="font-size:0px"></td></tr>        
        <?php //} ?>  
                 
        
        <!-- Start Action Reminder -->                   
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr>        
        <tr>	<!--4th text tr-->
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">      
            <tr>
                <td width="10" style="font-size:0px"></td>
                <td width="60" style="font-size:0px"><?php echo $this->Html->image($site_url.'/img/reminder.png',array('escape'=>false,'border'=>'0'));?></td>
                <td width="190" align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff; font-weight:bold">Action Reminders</td>
                <td width="130" style="font-size:0px;  text-align:right" align="right"><?php 
				 $query_string1 = ("file=jobcards&action=index");
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
		if (isset($row['client_application_deadline'])){ $noAction=1; ?> 
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
                <td align="left" valign="middle" style="font-size:17px; line-height:19px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff; font-weight:bold;">Application Deadlines</td>
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
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;"><?php echo $row['client_application_deadline']; ?></td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr> 
        <?php } ?>
         <!-- Start Upcoming Interviews 1.2 -->  
        <?php if (isset($row['client_upcoming_interview'])){ $noAction=1; ?> 
         <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr>
        <tr>
        <td valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">
                <tr><td height="10" style="font-size:0px" colspan="2"></td></tr>
                <tr>
                    <td width="15" style="font-size:0px"></td>
                    <td align="left" valign="middle" style="font-size:17px; line-height:19px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff; font-weight:bold;">Upcoming Interviews</td>
                </tr>
                <tr><td height="10" style="font-size:0px" colspan="2"></td></tr>
            </table>
        </td>
        </tr>
        <tr><td height="15" width="100%" style="font-size:0px"></td></tr>        
        <tr>
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;"><?php echo $row['client_upcoming_interview']; ?></td>
        </tr>
        <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>          
        <?php } ?>
         <!-- Start Pending Thank You Notes 1.3-->  
        <?php if (isset($row['client_thank_note'])){ $noAction=1; ?> 
         <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr>
        <tr>
        <td valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">
            <tr><td height="10" style="font-size:0px" colspan="2"></td></tr>
            <tr>
                <td width="15" style="font-size:0px"></td>
                <td align="left" valign="middle" style="font-size:17px; line-height:19px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff;">Pending Thank You Notes</td>
            </tr>
            <tr><td height="10" style="font-size:0px" colspan="2"></td></tr>
            </table>
        </td>
        </tr>
        <tr><td height="15" width="100%" style="font-size:0px"></td></tr>        
        <tr>	
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;"><?php echo $row['client_thank_note']; ?></td>
        </tr>
        <tr><td height="15" width="100%" style="font-size:0px"></td></tr> 
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>         
        <?php } ?>
         <!-- Identify hiring timeframe  1.4 -->  
        <?php if (isset($row['expected_date_of_employer_decision'])){ $noAction=1; ?> 
         <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr>
        <tr>	<!--5th text tr-->
        <td valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">
            <tr><td height="10" style="font-size:0px" colspan="2"></td></tr>
            <tr>
                <td width="15" style="font-size:0px"></td>
                <td align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff;">Identify Hiring Timeframe</td>
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
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;"><?php echo $row['expected_date_of_employer_decision']; ?></td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr> 
        <?php } ?> 
         <!-- Ask permission to follow up  1.5 -->  
        <?php if (isset($row['client_interview_follow'])){ $noAction=1; ?> 
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
                <td align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff; font-weight:bold;">Ask permission to follow up</td>
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
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040"><?php echo $row['client_interview_follow']; ?></td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>   
        <?php } ?> 
         <!-- Learn desired start date 1.6 -->  
        <?php if (isset($row['desired_start_date'])){ $noAction=1; ?> 
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
                <td align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff">Learn desired start date</td>
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
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040"><?php echo $row['desired_start_date']; ?></td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>          
        <?php } ?>
         <!-- Determine when the employer expects a response 1.7 -->  
        <?php if (isset($row['client_expected_response'])){ $noAction=1; ?> 
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
                <td align="left" valign="middle" style="font-size:18px; line-height:20px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff;">Determine when the employer expects a response</td>
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
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;"><?php echo $row['client_expected_response']; ?></td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>          
        <?php } ?>
         <!-- Start Upcoming Task 1.8 -->  
        <?php if (isset($row['client_upcoming_task'])){ $noAction=1; ?> 
         <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr>
        <tr>
        <td valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#2f96c1">
                <tr><td height="10" style="font-size:0px" colspan="2"></td></tr>
                <tr>
                    <td width="15" style="font-size:0px"></td>
                    <td align="left" valign="middle" style="font-size:17px; line-height:19px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#ffffff; font-weight:bold;">Upcoming task</td>
                </tr>
                <tr><td height="10" style="font-size:0px" colspan="2"></td></tr>
            </table>
        </td>
        </tr>
        <tr><td height="15" width="100%" style="font-size:0px"></td></tr>        
        <tr>
        	<td width="100%" align="left" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040;"><?php echo $row['client_upcoming_task']; ?></td>
        </tr>
        <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr>          
        <?php } ?>
         
        <?php if($noAction==0) { ?>
         <tr>	<!--single text line 6-->
        	<td width="100%" align="center" valign="middle" style="font-size:14px; line-height:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#404040; font-style:italic;">You have no reminders.</td>
        </tr>
         <tr><td height="15" width="100%" style="font-size:0px"></td></tr>
        <tr><td height="1" width="100%" style="font-size:0px" bgcolor="#0c79a8"></td></tr> 
        <tr><td height="5" width="100%" style="font-size:0px"></td></tr> 
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
         <?php  $query_string1 = ("file=clients&action=settings&card_id=1");
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
                <td style="font-size:15px; line-height:17px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-weight:bold; text-decoration:underline;">Job Search Status</td>
            </tr>
            <tr><td style="font-size:0px;" height="8"></td></tr>
            <tr>
                <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">Stategic Score - <b><?php echo $s_score;?>%</b></td>
            </tr>
            <tr><td style="font-size:0px;" height="8"></td></tr>
            <tr>
                <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">Job A:Job B - <b><?php echo $jobType;?></b></td>
            </tr>
            <tr><td style="font-size:0px;" height="8"></td></tr>
            <tr>
                <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;"><?php echo $row['client_pai']; ?></td>
            </tr>
            <tr><td style="font-size:0px;" height="8"></td></tr>
            <tr>
                <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">Intensity Score -<b><?php echo $i_score;?>%</b></td>
            </tr>
        </table>
    </td>
    </tr>
    <tr>
    	<td height="40" valign="top"  style="font-size:0px"></td>
    </tr>
     <?php if (isset($row['client_no_card_movement'])){ ?> 
    <tr>
    <td>
        <table  border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
        <td style="font-size:15px; line-height:17px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-weight:bold; text-decoration:underline;"">Job Card Movement (Getting Cold) - <?php echo $row['client_no_card_movement'];?></td>
        </tr>
        <tr><td style="font-size:0px;" height="8"></td></tr>
        <tr>
        <td style="font-size:14px; line-height:16px; color:#0a79a7; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;"></td>
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
    <?php } ?>    
    </table>
</td>
</tr>
</table>
</td>
</tr>  

      
</table>