<?php
$siteDescription = __d('cake_dev', 'myGyFTR');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php echo $this->Html->charset(); ?>
<title> <?php echo $siteDescription ?>: <?php echo $title_for_layout; ?> </title>
<?php
echo $this->Html->meta('icon');
echo $this->Html->css(array('cake.generic','tables','style_admin','form','validation','jquery.fancybox','jquery-ui-css'));
echo $this->Html->script(array('jquery','jquery.validationEngine','validation-en','jquery.fancybox.pack','jquery-ui.min','admin'));

?>

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
$userDetails=$this->Session->read('Admin/User');
extract($userDetails['Login']);
?> <span style="float: right;"> Welcome [<?php echo $first_name.' '.$last_name?>]<br />
<a href="<?php echo $this->webroot;?>admin/login/logout">Logout</a><br />
</span>
<a href="<?php echo SITE_URL; ?>/admin/home"><?php echo $this->Html->image('logo.png',array('escape'=>false,'alt'=>'','div'=>false));?></a>

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
	?></li>


	<li><?php
	if(strtolower($this->name)=='users'){
		echo $this->Html->link('Users',array('controller' => 'users', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Users',array('controller' => 'users', 'action' => 'index','admin'=>true));
	}
	?>
	</li>
	    
    <li><?php
	if(strtolower($this->name)=='products'){
		echo $this->Html->link('Products',array('controller' => 'products', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Products',array('controller' => 'products', 'action' => 'index','admin'=>true));
	}
	?>
	</li>
	
	<li><?php
	if(strtolower($this->name)=='orders'){
		echo $this->Html->link('Orders',array('controller' => 'Orders', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Orders',array('controller' => 'Orders', 'action' => 'index','admin'=>true));
	}
	?></li>
    
    <li><?php
	if(strtolower($this->name)=='points'){
		echo $this->Html->link('Points',array('controller' => 'points', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Points',array('controller' => 'points', 'action' => 'index','admin'=>true));
	}
	?></li>
	
	
	<li><?php
	
	if(strtolower($this->name)=='promocode'){
		echo $this->Html->link('Promo Code',array('controller' => 'promocode', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Promo Code',array('controller' => 'promocode', 'action' => 'index','admin'=>true));
	}
	?></li>
    
	<li><?php
	
	if(strtolower($this->name)=='offers'){
		echo $this->Html->link('Offers',array('controller' => 'offers', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Offers',array('controller' => 'offers', 'action' => 'index','admin'=>true));
	}
	?></li>
	
	
</ul>
</div>
<!--[end]#menu -->


<div style="clear: both"></div>

<div id="middlepart">
<div id="leftcolumn">
<div id="mainbox">

	
<?php echo $this->Session->flash(); ?>
<?php echo $content_for_layout; ?>

</div><!--[end]#mainbox -->


<?php //echo $this->element('sql_dump'); ?>


</div><!--[end]#leftcolumn -->


</div>
<!--[end]#middlepart --></div>
<!--[end]#wrapper -->



	<?php echo $this->Js->writeBuffer();?>
</body>
</html>



