<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="margin: 0px; padding: 0px; background:#efefef; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px; line-height:15px;">
<table align="center" bgcolor="#efefef" border="0" cellpadding="0" cellspacing="0" width="600" >
 <tr>
 <td style="background:#086c96;">
 <table border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr>
        <td style="background:#086c96;">
<div style=" border:none;  height: 98px; margin: 0;" ><a href="snagpad.com" style="margin:15px 0 0 15px; float:left"><?php echo $this->Html->image('http://snagpad.com/img/logo.png',array('alt'=>'snagpad.com','escape'=>false,'border'=>'0'));?></a></div></td>
    <?php if(isset($isdaily)||isset($coach_notification) || isset($weeklycontacts)) { ?>
        <td width="380" align="left" style="text-align:right">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
        <td align="right" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:18px; line-height:22px; color:#FFFFFF; font-weight:bold;"><?php if(isset($isdaily)){ echo 'Daily Digest'; }else if(isset($coach_notification)){ echo 'Client Updates';} else{ echo '"Support  the job search of those you know"';} ?>
        </td>
        </tr>
        <?php if(isset($isdaily)||isset($coach_notification)) { ?>
        <tr>
        <td align="right" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:16px; line-height:18px; color:#FFF"><?php echo date('M j, Y');?>
        </td>
        </tr>
        <?php }?>
        </table>
        </td>
        <td width="20" style="font-size:0px"></td>
       <?php }?> 
       
       
 </tr>
 </table>
 </td>
 <tr>
    <td>
    <div style="background:#eaeaea;  border:2px solid #B7B7B7; padding:10px;word-wrap:break-word; table-layout:fixed;font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:14px; line-height:16px; color:#404040">

	<?php echo $content_for_layout;?>  <!--image and right description holder table ends here -->
	<?php if(isset($goto_url)){ ?>
	
	<a href="<?php echo $goto_url; ?>">Yes I want to be added to your job search network</a>
	<?php }?>
   
    </div>
    </td>
  </tr>
  
 <tr>
    <td style="font:11px arial;padding:13px 10px 0;font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px; line-height:16px; color:#404040">Thanks for being a <a href="<?php echo SITE_URL;?>" > SnagPad.com </a> user! We try to limit emails to things you would find useful. If you no longer want to receive email from us, <?php if(isset($coach_notification)) { ?><a href="<?php echo SITE_URL."/Pages/display?file=coach&action=settings&card_id=1";?>" >Click unsubscribe</a><?php }else { ?><a href="<?php echo SITE_URL."/Pages/display?file=clients&action=settings&card_id=1";?>" >Click unsubscribe</a><?php } ?>. Have questions? We'd love to hear from you - email us at <a href="mailto:support@snagpad.com"> support@snagpad.com</a>.
    </td>
 </tr>

  <tr>
    <td style=" padding: 7px 10px 0px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px; line-height:16px; color:#404040">&copy; Copyright 2013 SnagPad. All rights reserved.</td>
  </tr>
<tr>
    <td style="padding: 0px 10px 7px;font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px; line-height:16px; color:#404040"><a href="<?php echo SITE_URL;?>/info/terms_of_service">Privacy Policy | Terms and Conditions</a></td>
  </tr>

</table>

</body></html>