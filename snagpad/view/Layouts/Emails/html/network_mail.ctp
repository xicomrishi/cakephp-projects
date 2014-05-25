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
<body style="margin: 0px; padding: 0px;">
<table align="center" bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" width="600" >
 <tr>
    <td>
<div style="background: url('http://snagpad.com/img/header_bg_repeat.png') repeat-x 0 0; border:none;  height: 98px; margin: 0;  padding:15px 0 0 0;  width: 600px;" ><a href="snagpad.com" style="margin:0 0 0 15px"><?php echo $this->Html->image('http://snagpad.com/img/logo.png',array('alt'=>'snagpad.com','escape'=>false,'border'=>'0'));?></a></div></td>
 </tr>
  
 <tr>
    <td style="padding: 15px 15px 7px;">
    <div style="background:#FFFFFF;  border:2px solid #B7B7B7; padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px;word-wrap:break-word; table-layout:fixed">

	<?php echo $content_for_layout;?>  <!--image and right description holder table ends here -->
	<?php if(isset($goto_url)){ ?>
	
	<a href="<?php echo $goto_url; ?>">Yes I want to be added to your job search network</a>
	<?php }?>
   
    </div>
    </td>
  </tr>
  
 <tr>
    <td style='font:11px arial;padding:0 15px;'>Thanks for being a <a href="<?php echo SITE_URL;?>" > SnagPad.com </a> user! We try to limit emails to things you would find useful. Please <a href="mailto:support@snagpad.com" target="_blank">Add us to your address book</a> to ensure our email makes it to your inbox. If you no longer want to receive email from us you can change your messaging preferences at any time in <a href="<?php echo SITE_URL;?>/clients/settings"> user settings</a>. Have questions? We'd love to hear from you - email us at <a href="mailto:support@snagpad.com"> support@snagpad.com</a>.
    </td>
 </tr>

  <tr>
    <td style="font: 11px Arial,Helvetica,sans-serif; color: rgb(51, 51, 51); padding: 7px 15px 0px;">&copy; Copyright 2012 SnagPad. All rights reserved.</td>
  </tr>
<tr>
    <td style="font: 11px Arial,Helvetica,sans-serif; color: rgb(51, 51, 51);  padding: 0pt 15px 7px;"><a href="<?php echo SITE_URL;?>/info/terms_of_service">Privacy Policy | Terms and Conditions</a></td>
  </tr>

</table>

</body></html>