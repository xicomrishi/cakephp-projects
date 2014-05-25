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
echo $this->Html->css(array('cake.generic','tables','style_admin','form','jquery-ui-css','validation'));
echo $this->Html->script(array('jquery-1.8.3','jquery.validationEngine','jquery-ui.min','validation-en'));

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
<span style="float: right;"> Welcome Admin<br />
<a href="<?php echo $this->webroot;?>admin/login/logout">Logout</a><br />
</span>
<a href="<?php echo $this->webroot; ?>admin/recharge"><?php echo $this->Html->image('logo.png',array('escape'=>false,'alt'=>'','div'=>false));?></a>

</div>


<div id="menu">
<ul id="navmenu">

    <li><?php
	
	if(strtolower($this->name)=='recharge'){
		echo $this->Html->link('Recharge',array('controller' => 'recharge', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Recharge',array('controller' => 'recharge', 'action' => 'index','admin'=>true));
	}
	?></li>
    
    <li><?php
	
	if(strtolower($this->name)=='config'){
		echo $this->Html->link('Configuration',array('controller' => 'config', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Configuration',array('controller' => 'config', 'action' => 'index','admin'=>true));
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



