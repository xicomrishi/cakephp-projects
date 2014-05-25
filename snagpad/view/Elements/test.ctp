<table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:12px; line-height:14px; color:#404040">        
        <tr>
        <tr bgcolor="#FFFFFF">
        <td>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td width="280" style="padding:10px;" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td>Thanks for supporting the job search of <span style="font-size:18px;font-weight:bold"> <?php echo $data['from_user']['Account']['name'];?></span> </td>
        </tr>
        </table>
        </td>        
        </tr>
        </table>
        </td>
        </tr>
        <td style="font-size:0px;" valign="top" height="10"></td>
        </tr>
        <tr>
        <td>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td width="280" style="padding:10px;" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td>My Ideal Job is <span style="font-size:18px;font-weight:bold"><?php echo $data['from_user_client']['Client']['job_a_title'];?></span></td>
        </tr>
        </table>
        </td>        
        </tr>
        </table>
        </td>
        </tr>
        <tr>
        <td style="font-size:0px;" valign="top" height="1"></td>
        </tr>
        <tr>
        <td>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td width="280" style="padding:10px;" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="font-style:italic;">The Job Opportunities I've found this week include:</td>
        </tr>
        </table>
        </td>        
        </tr>
        </table>
        </td>
        </tr>
       
        
        <tr>
        <td valign="top">
        <table  width="100%" cellpadding="0" cellspacing="0" border="2" bordercolor="#000099" style=" font-size:12px; line-height:14px">
       
         <?php 
		$count=count($data['cards']);
		if($count==0)
		{?>
        <tr>
        <td>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td width="280" style="padding:10px;" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="font-style:italic;">There was no job search activity for this week</td>
        </tr>
        </table>
        </td>        
        </tr>
        </table>
        </td>
        </tr>
        <?php
		}		
		if($count>0)
		{ 
		 ?> 
          <tr>       
        <td style="background:url(/app/webroot/img/card_bg2.jpg) no-repeat 0 0;" width="285" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">       
        <tr>        
        <td width="238" style="padding:10px 10px 10px 10px;border-right:2px solid #000099;" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][0]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][0]['Card']['position_available'];?></td>
        </tr>
        </table>
        </td>
                
        <td width="238" style="padding:10px 10px 10px 10px" valign="top">
        <?php if($count>1){ ?>    
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][1]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][1]['Card']['position_available'];?></td>
        </tr>
        </table>
        <?php } ?>
        </td>
        </tr> 
        <tr>      
        <td width="238" style="padding:10px 10px 10px 10px;border-right:2px solid #000099;" valign="top">        
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:1/c:<?php echo $data['cards'][0]['Card']['id'];?>">I may  have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:2/c:<?php echo $data['cards'][0]['Card']['id'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:3/c:<?php echo $data['cards'][0]['Card']['id'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        </td>
        <td width="238" style="padding:10px 10px 10px 10px" valign="top"> 
            <?php if($count>1){ ?>        
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:1/c:<?php echo $data['cards'][1]['Card']['id'];?>">I may  have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:2/c:<?php echo $data['cards'][1]['Card']['id'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:3/c:<?php echo $data['cards'][1]['Card']['id'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        <?php } ?>
        </td>
        </tr>      
        </table>
        </td>
         </tr>
        <?php } ?>
        <!-- start 3/4 card -->
         <?php if($count>2){ ?> 
          <tr>       
        <td style="background:url(/app/webroot/img/card_bg2.jpg) no-repeat 0 0;" width="285" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">       
        <tr>        
        <td width="238" style="padding:10px 10px 10px 10px;border-right:2px solid #000099;" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][2]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][2]['Card']['position_available'];?></td>
        </tr>
        </table>
        </td>
                
        <td width="238" style="padding:10px 10px 10px 10px" valign="top">
        <?php if($count>3){ ?>    
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][3]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][3]['Card']['position_available'];?></td>
        </tr>
        </table>
        <?php } ?>
        </td>
        </tr> 
        <tr>      
        <td width="238" style="padding:10px 10px 10px 10px;border-right:2px solid #000099;" valign="top">        
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:1/c:<?php echo $data['cards'][2]['Card']['id'];?>">I may  have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:2/c:<?php echo $data['cards'][2]['Card']['id'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:3/c:<?php echo $data['cards'][2]['Card']['id'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        </td>
        <td width="238" style="padding:10px 10px 10px 10px" valign="top"> 
            <?php if($count>3){ ?>        
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:1/c:<?php echo $data['cards'][3]['Card']['id'];?>">I may  have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:2/c:<?php echo $data['cards'][3]['Card']['id'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:3/c:<?php echo $data['cards'][3]['Card']['id'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        <?php } ?>
        </td>
        </tr>      
        </table>
        </td>
         </tr>
        <?php } ?>
        
         <?php if($count>4)	{  ?> 
          <tr>       
        <td style="background:url(/app/webroot/img/card_bg2.jpg) no-repeat 0 0;" width="285" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">       
        <tr>        
        <td width="238" style="padding:10px 10px 10px 10px;border-right:2px solid #000099;" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][4]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][4]['Card']['position_available'];?></td>
        </tr>
        </table>
        </td>
                
        <td width="238" style="padding:10px 10px 10px 10px" valign="top">
        <?php if($count>5){ ?>    
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][5]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][5]['Card']['position_available'];?></td>
        </tr>
        </table>
        <?php } ?>
        </td>
        </tr> 
        <tr>      
        <td width="238" style="padding:10px 10px 10px 10px;border-right:2px solid #000099;" valign="top">        
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:1/c:<?php echo $data['cards'][4]['Card']['id'];?>">I may  have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:2/c:<?php echo $data['cards'][4]['Card']['id'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:3/c:<?php echo $data['cards'][4]['Card']['id'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        </td>
        <td width="238" style="padding:10px 10px 10px 10px" valign="top"> 
            <?php if($count>5){ ?>        
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:1/c:<?php echo $data['cards'][5]['Card']['id'];?>">I may  have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:2/c:<?php echo $data['cards'][5]['Card']['id'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['email'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:3/c:<?php echo $data['cards'][5]['Card']['id'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        <?php } ?>
        </td>
        </tr>      
        </table>
        </td>
         </tr>
        <?php } ?>      
</table>       
        </td>
        </tr>  
        <tr>
        <td style="padding:6px 0 6px 15px; width:555px">Thank you again for supporting my job search. Please let me know if I or my network can help you in any way.<br><br>Sincerely<br><?php echo $data['from_user']['Account']['name']; ?></td>
        </tr>
        </table>