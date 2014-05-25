<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#fff" border="0">
  <tr>
    <td valign="top">
       <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#e0e0e0">
        <tr>
        <td style="font-size:0px; background: url(/app/webroot/img/header_bg_repeat.png) repeat-x 0 0;  border:none;  height: 98px; margin: 0;  padding:0px;  width: 600px;">
        <a href="http://snagpad.com" style="margin:0 0 0 15px"><?php echo $this->Html->image(SITE_URL.'/img/logo.png',array('alt'=>'snagpad.com','escape'=>false,'border'=>'0'));?></a>
        </td>
        </tr>
        
        <tr>
        <td>
        <div style="padding:13px 13px 13px 13px;border:2px solid #b9cbe2; padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px;word-wrap:break-word; table-layout:fixed; color:#383838">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="font-size:0px;" valign="top" height="10"></td>
        </tr>
        <tr>
        <td width="100%" valign="top">
        
        </td>
        </tr>
        <tr>
        <td style="font-size:0px;" valign="top" height="10"></td>
        </tr>
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
        <td><?php echo $data['to_user']['Client']['job_a_title'];?></td>
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
        <table  width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="background:url(/app/webroot/img/card_bg2.jpg) no-repeat 0 0;" height="337" width="285" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <?php 
		for($i=0;$i<3;$i++)
		
		//foreach($data['cards'] as $card)
		{ ?>
        <tr>
        <td width="108" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][$i]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][$i]['position_available'];?></td>
        </tr>
        </table>
        </td>
        <td width="130" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:1/c:<?php echo $data['cards'][$i]['Card']['company_name'];?>">I may  Have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:2/c:<?php echo $data['cards'][$i]['Card']['company_name'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:3/c:<?php echo $data['cards'][$i]['Card']['company_name'];?>">I have a tip about this company</a></td>
        </tr>
        </table>
        </td>
        </tr>
        <?php } ?>
        
        
        
        </table>
        </td>
        
        
        <td style="background:url(/app/webroot/img/card_bg2.jpg) no-repeat 0 0;" height="337" width="285" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <?php 
		for($j=3;$i<6;$j++)
		
		//foreach($data['cards'] as $card)
		{ ?>
        <tr>
        <td width="108" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][$j]['Card']['company_name'];?></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><?php echo $data['cards'][$j]['position_available'];?></td>
        </tr>
        </table>
        </td>
        <td width="130" style="padding:10px 10px 10px 10px" valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:1/c:<?php echo $data['cards'][$j]['Card']['company_name'];?>">I may  Have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:2/c:<?php echo $data['cards'][$j]['Card']['company_name'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:left" align="left"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:3/c:<?php echo $data['cards'][$j]['Card']['company_name'];?>">I have a tip about this company</a></td>
        </tr>
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
        <tr>
        <td bgcolor="#b5b5b5" style="padding:6px 0 6px 15px; width:555px">I am really interested in these employers. Do you have any contacts, experience, thoughts to share?</td>
        </tr>
        <tr>
        <td valign="top">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        
        <td width="190">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="font-size:0px;" align="center"><?php echo $this->Html->image(SITE_URL.'/img/comp_logo.jpg',array('alt'=>'comp_logo','escape'=>false,'border'=>'0'));?></td>
        </tr>
        <tr>
        <td style="text-align:center" align="center"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:1/c:<?php echo $card['Card']['company_name'];?>">I may  Have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:center" align="center"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:2/c:<?php echo $card['Card']['company_name'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:center" align="center"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:3/c:<?php echo $card['Card']['company_name'];?>">I have a tip about this company.</a></td>
        </tr>
        </table>
        </td>
        <td width="190">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="font-size:0px;" align="center"><?php echo $this->Html->image(SITE_URL.'/img/comp_logo.jpg',array('alt'=>'comp_logo','escape'=>false,'border'=>'0'));?></td>
        </tr>
        <tr>
        <td style="text-align:center" align="center"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:1/c:<?php echo $card['Card']['company_name'];?>">I may  Have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:center" align="center"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:2/c:<?php echo $card['Card']['company_name'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:center" align="center"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:3/c:<?php echo $card['Card']['company_name'];?>">I have a tip about this company.</a></td>
        </tr>
        </table>
        </td>
        <td width="190">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td style="font-size:0px;" align="center"><?php echo $this->Html->image(SITE_URL.'/img/comp_logo.jpg',array('alt'=>'comp_logo','escape'=>false,'border'=>'0'));?></td>
        </tr>
        <tr>
        <td style="text-align:center" align="center"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:1/c:<?php echo $card['Card']['company_name'];?>">I may  Have a contact here.</a></td>
        </tr>
        <tr>
        <td style="text-align:center" align="center"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:2/c:<?php echo $card['Card']['company_name'];?>">I know a similar company.</a></td>
        </tr>
        <tr>
        <td style="text-align:center" align="center"><a href="<?php echo SITE_URL; ?>/info/network_contact_reply/f:<?php echo $data['from_user']['Account']['id']; ?>/a:<?php $data['to_user']['Client']['account_id']; ?>/m:3/c:<?php echo $card['Card']['company_name'];?>">I have a tip about this company.</a></td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        <tr>
        <td bgcolor="#b5b5b5" style="text-align:center; padding:6px 0" align="center">If you know of a specific job opportunity for me I would appreciate you letting me know.</td>
        </tr>
        <tr>
        <td bgcolor="#fff" style="padding:6px 0 6px 15px; width:555px">Thank you again for supporting my job search. Please let me know if I or my network can help you in any way.<br><br>Sincerely<br><?php echo $data['from_user']['Account']['name']; ?></td>
        </tr>
        </table>
        </div>
        </td>
        </tr>
        
        
        <tr>
    <td style='font:11px arial;'>Thanks for being a <a href="<?php echo SITE_URL;?>" > SnagPad.com </a> user! We try to limit emails to things you would find useful. Please <a href="mailto:support@snagpad.com" target="_blank">Add us to your address book</a> to ensure our email makes it to your inbox. If you no longer want to receive email from us you can change your messaging preferences at any time in <a href="<?php echo SITE_URL;?>/clients/settings"> user settings</a>. Have questions? We'd love to hear from you - email us at <a href="mailto:support@snagpad.com"> support@snagpad.com</a>.
    </td>
 </tr>

  <tr>
    <td style="font: 11px Arial,Helvetica,sans-serif; color: rgb(51, 51, 51); padding: 7px 0px 0px;">&copy; Copyright 2012 SnagPad. All rights reserved.</td>
  </tr>
<tr>
    <td style="font: 11px Arial,Helvetica,sans-serif; color: rgb(51, 51, 51);"><a href="<?php echo SITE_URL;?>/info/terms_of_service">Privacy Policy | Terms and Conditions</a></td>
  </tr>

       </table>
    </td>
  </tr>
</table>
