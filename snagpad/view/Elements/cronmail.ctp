<table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:12px; line-height:14px; color:#404040">
        <tr>
        <td>Thanks for supporting my job search. Below is a summary of my search and what activity took place this week. Please review and let me know if you or your network may be of assistance.</td>
        </tr>
        <tr>
        <td style="font-size:0px;" valign="top" height="10"></td>
        </tr>
        <tr>
        <td style="border:2px solid #111; background:#7f7f7f">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td width="280" style="padding:15px;" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td>My Ideal Job is</td>
        </tr>
        <tr>
        <td style="font-size:0px" height="20"></td>
        </tr>
        <tr>
        <td><?php echo $data['from_user_client']['Client']['job_a_title'];?></td>
        </tr>
        </table>
        </td>
        <td width="284" style="padding:10px; border-left:2px solid #111">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td>My Criteria For take a job other than my ideal job is</td>
        </tr>
        <tr>
        <td style="font-size:0px" height="20"></td>
        </tr>
        <tr>
        <td>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <?php if(!empty($data['to_user']['Client']['job_b_criteria'])) 
				{ $crit=explode('|',$data['to_user']['Client']['job_b_criteria']); 
					unset($crit[count($crit)-1]);
				
				foreach($crit as $cr)
				{				
				 ?>
        <tr>
        <td width="60" align="left"><?php echo $this->Html->image(SITE_URL.'/img/bullets.jpg',array('alt'=>'bullets','escape'=>false,'border'=>'0'));?></td>
        <td><?php echo $cr; ?></td>
        </tr>
        <?php }} ?>
       
        </table>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        <tr>
        <td style="font-size:0px;" valign="top" height="15"></td>
        </tr>
        <tr>
        <td bgcolor="#b5b5b5" style="padding:6px 0 6px 15px; width:555px">I found these Job Opportunities this week. Any suggestions, contacts, tips etc.</td>
        </tr>
        
        
        
        <tr>
        <td valign="top">
        <table  width="100%" cellpadding="0" cellspacing="0" border="0" style=" font-size:12px; line-height:14px">
         <?php 
		$count=count($data['cards']);
		
		if($count>0)
		{ 
		 ?>
        <tr>
        <td style="background:url(/app/webroot/img/card_bg2.jpg) no-repeat 0 0;" width="285" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
       
        <tr>
        <td width="108" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][0]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][0]['Card']['position_available'];?></td>
        </tr>
        </table>
        </td>
        <td width="130" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:1/c:<?php echo $data['cards'][0]['Card']['company_name'];?>">I may  Have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:2/c:<?php echo $data['cards'][0]['Card']['company_name'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:3/c:<?php echo $data['cards'][0]['Card']['company_name'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        </td>
        </tr>
       
        
        
        
        </table>
        </td>
        
        <?php if($count>1){  ?>
        <td style="background:url(/app/webroot/img/card_bg2.jpg) no-repeat 0 0;" width="285" valign="top">
        	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
       
        <tr>
        <td width="108" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][1]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][1]['Card']['position_available'];?></td>
        </tr>
        </table>
        </td>
        <td width="130" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:1/c:<?php echo $data['cards'][1]['Card']['company_name'];?>">I may  Have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:2/c:<?php echo $data['cards'][1]['Card']['company_name'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:3/c:<?php echo $data['cards'][1]['Card']['company_name'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        </td>
        </tr>
       
        
        
        
        </table>
        </td>
        <?php } ?>
        </tr>
        
         <?php } 
		 	if($count>2)
			{
				
		 ?>
        		<tr>
        <td style="background:url(/app/webroot/img/card_bg2.jpg) no-repeat 0 0;" width="285" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
       
        <tr>
        <td width="108" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][2]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][2]['Card']['position_available'];?></td>
        </tr>
        </table>
        </td>
        <td width="130" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:1/c:<?php echo $data['cards'][2]['Card']['company_name'];?>">I may  Have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:2/c:<?php echo $data['cards'][2]['Card']['company_name'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:3/c:<?php echo $data['cards'][2]['Card']['company_name'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        </td>
        </tr>
       
        
        
        
        </table>
        </td>
        
        <?php if($count>3){  ?>
        <td style="background:url(/app/webroot/img/card_bg2.jpg) no-repeat 0 0;" width="285" valign="top">
        	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
       
        <tr>
        <td width="108" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][3]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][3]['Card']['position_available'];?></td>
        </tr>
        </table>
        </td>
        <td width="130" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:1/c:<?php echo $data['cards'][3]['Card']['company_name'];?>">I may  Have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:2/c:<?php echo $data['cards'][3]['Card']['company_name'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:3/c:<?php echo $data['cards'][3]['Card']['company_name'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        </td>
        </tr>
       
        
        
        
        </table>
        </td>
        <?php } ?>
        </tr>
        <?php }
			
			
			if($count>4)
			{
				
		 ?>
        		<tr>
        <td style="background:url(/app/webroot/img/card_bg2.jpg) no-repeat 0 0;" width="285" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
       
        <tr>
        <td width="108" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][4]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][4]['Card']['position_available'];?></td>
        </tr>
        </table>
        </td>
        <td width="130" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:1/c:<?php echo $data['cards'][4]['Card']['company_name'];?>">I may  Have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:2/c:<?php echo $data['cards'][4]['Card']['company_name'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:3/c:<?php echo $data['cards'][4]['Card']['company_name'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        </td>
        </tr>
       
        
        
        
        </table>
        </td>
        
        <?php if($count>5){  ?>
        <td style="background:url(/app/webroot/img/card_bg2.jpg) no-repeat 0 0;" width="285" valign="top">
        	 <table width="100%" cellpadding="0" cellspacing="0" border="0">
       
        <tr>
        <td width="108" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][5]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][5]['Card']['position_available'];?></td>
        </tr>
        </table>
        </td>
        <td width="130" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:1/c:<?php echo $data['cards'][5]['Card']['company_name'];?>">I may  Have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:2/c:<?php echo $data['cards'][5]['Card']['company_name'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['to_user']['name'];?>/a:<?php echo $data['from_user_client']['Client']['account_id']; ?>/r:<?php echo $data['req_id']?>/m:3/c:<?php echo $data['cards'][5]['Card']['company_name'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        </td>
        </tr>
       
        
        
        
        </table>
        </td>
        <?php } ?>
        </tr>
        <?php } ?>
		
        </table>
        </td>
        </tr>
        
        
        
        
        
        <tr>
        <td bgcolor="#b5b5b5" style="padding:6px 0 6px 15px; width:555px">I am really interested in these employers. Do you have any contacts, experience, thoughts to share?</td>
        </tr>
        
        
        <tr>
        <td bgcolor="#fff" style="padding:6px 0 6px 15px; width:555px">Thank you again for supporting my job search. Please let me know if I or my network can help you in any way.<br><br>Sincerely<br><?php echo $data['from_user']['Account']['name']; ?></td>
        </tr>
        </table>