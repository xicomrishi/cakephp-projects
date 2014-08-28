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
echo $this->Html->css(array('cake.generic','tables','style_admin','form','validation','jquery.fancybox'));
echo $this->Html->script(array('jquery','validation2','validation-en','jquery.fancybox.pack'));

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
	
	<!--<li><?php
	if(strtolower($this->name)=='cmses'){
		echo $this->Html->link('Cms',array('controller' => 'cmses', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Cms',array('controller' => 'cmses', 'action' => 'index','admin'=>true));
	}
	?></li>
	
	
	<li><?php
	
	if(strtolower($this->name)=='email_templates' || strtolower($this->name)=='emailtemplates'){
		echo $this->Html->link('Email Templates',array('controller' => 'email_templates', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Email Templates',array('controller' => 'email_templates', 'action' => 'index','admin'=>true));
	}
	?></li>-->
	
	
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

<div id="rightcolumn">
<div class="notes">
<h3>You are in "<?php echo $this->name;?>" Section</h3>
</div>
</div>

</div>
<!--[end]#middlepart --></div>
<!--[end]#wrapper -->


<div id="footer">
<p class="copyright">&copy; Copyright <?php echo date("Y"); ?> All
rights reserved <br />
</p>
</div>
	<?php echo $this->Js->writeBuffer();?>
</body>
</html>



