<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php echo $this->Html->charset(); ?>
<title><?php echo $title_for_layout; ?></title>
<?php
echo $this->Html->meta('icon');
echo $this->Html->meta(array('name' => 'robots', 'content' => 'noindex, nofollow'));

echo $this->Html->css(array('cake.generic','style','form','tables','jquery-te/jquery-te-1.4.0','jquery-ui-1.8.21.custom'));
echo $this->Html->script(array('jquery.min','jquery-te/jquery-te-1.4.0.min','jquery-ui-1.8.21.custom.min','common'));
echo $scripts_for_layout;
?>
<script type="text/javascript">
jQuery(function(){
	if(jQuery('textarea').hasClass('text-editor')){
		jQuery('.text-editor').jqte();
	}
});
</script>
</head>


<body>
<div id="wrapper">

<div id="header">
<noscript>
<div class="notice"><span>This is a Warning Notice!</span>
<p>You will need to enable JavaScript on your browser.</p>
</div>
</noscript>

<?php 
if($loggedIn){	
?>
<span style="float: right;"> Welcome [<?php echo $loggedUser['name'];?>]<br />
<small style="color:red">Last Login: <?php if(!empty($loggedUser['last_login_date'])){echo date('d/m/Y H:i:s a',strtotime($loggedUser['last_login_date']));}?></small>
<br/>
<a href="<?php echo $this->webroot;?>admin/logins/logout">Logout</a>
</span>
<?php }?>

<h3><a href="<?php echo $this->webroot;?>">
<img src="<?php echo $this->webroot;?>img/frontend/logo.png" alt="logo"/></a>
</h3>
</div>
<!-- [end]#header -->


<div id="menu">
<ul id="navmenu">

	<li><?php
	if(strtolower($this->name)=='home'){
		echo $this->Html->link('Dashboard',array('controller' => 'home', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Dashboard',array('controller' => 'home', 'action' => 'index','admin'=>true));
	}
	?>
	</li>

	<li><?php
	$action='index';
	if($loggedUser['user_role_id']>1){
		$action='profile';
	}
	if(strtolower($this->name)=='users'){
		echo $this->Html->link('Admin Users',array('controller' => 'users', 'action' => $action,'admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Admin Users',array('controller' => 'users', 'action' => $action,'admin'=>true));
	}
	?>
	</li>
	
    <li><?php
	if(strtolower($this->name)=='contents'){
		echo $this->Html->link('Content Management',array('controller' => 'contents', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Content Management',array('controller' => 'contents', 'action' => 'index','admin'=>true));
	}
	?>
	</li>
    <li><?php
  
	if(strtolower($this->name)=='emailtemplates'){
		echo $this->Html->link('Newsletter',array('controller' => 'email_templates', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Newsletter',array('controller' => 'email_templates', 'action' => 'index','admin'=>true));
	}
	?>
	
		<ul class="nav_submenu submenu">
			<li><?php
				echo $this->Html->link('Email Templates',array('controller' => 'email_templates', 'action' => 'index','admin'=>true));
			?></li>
			
		</ul>
	</li>
	
	<li><?php
  
	if(strtolower($this->name)=='customers'){
		echo $this->Html->link('Customers',array('controller' => 'customers', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Customers',array('controller' => 'customers', 'action' => 'index','admin'=>true));
	}
	?>
	</li>
	
	
	
	<li><?php  
	if(strtolower($this->name)=='recharges'||strtolower($this->name)=='wallet'){
		echo $this->Html->link('Transactions',array('controller' => 'recharges', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Transactions',array('controller' => 'recharges', 'action' => 'index','admin'=>true));
	}
	?>
    	<ul class="nav_submenu submenu">
			<li><?php
				echo $this->Html->link('Recharge Transaction',array('controller' => 'recharges', 'action' => 'index','admin'=>true));
			?></li>
			<li><?php
				echo $this->Html->link('Wallet Transaction',array('controller' => 'wallet', 'action' => 'index','admin'=>true));
			?></li>
		</ul>
	</li>
	
	
	<li><?php  
	if(strtolower($this->name)=='coupons'){
		echo $this->Html->link('Coupon Management',array('controller' => 'coupons', 'action' => 'list_coupon','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Coupon Management',array('controller' => 'coupons', 'action' => 'list_coupon','admin'=>true));
	}
	?>
		<ul class="nav_submenu submenu">
			<li><?php
				echo $this->Html->link('Coupons',array('controller' => 'coupons', 'action' => 'list_coupon','admin'=>true));
			?></li>
			<li><?php
				echo $this->Html->link('Service Types / Category',array('controller' => 'coupons', 'action' => 'list_service_type','admin'=>true));
			?></li>
		</ul>
	</li>
	
	<!-- settings -->
	
	<li><?php  
	if(strtolower($this->name)=='settings'){
		echo $this->Html->link('Settings',array('controller' => 'settings', 'action' => 'settings','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Settings',array('controller' => 'settings', 'action' => 'settings','admin'=>true));
	}
	?>
		<ul class="nav_submenu submenu">
			<li><?php
				echo $this->Html->link('Service Charges',array('controller' => 'settings', 'action' => 'service_charge','admin'=>true));
			?></li>
			
		</ul>
	</li>
	
	<!-- /settings -->
	
	
	
</ul>
</div>
<!--[end]#menu -->


<div style="clear: both"></div>

<div id="middlepart">
<div id="leftcolumn">
<div id="mainbox">
<?php echo $this->Session->flash(); ?>
<?php echo $content_for_layout; ?>

</div>
<!--[end]#mainbox --></div>
<!--[end]#leftcolumn -->
</div>
<!--[end]#middlepart --></div>
<!--[end]#wrapper -->


<div id="footer">
<p class="copyright">&copy; Copyright <?php echo date("Y"); ?> All rights reserved <br /></p>
</div>

</body>
</html>



