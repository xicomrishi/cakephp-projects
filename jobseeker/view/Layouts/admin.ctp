<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php echo $this->Html->charset(); ?>
<title><?php __('CakePHP Demo:'); ?> <?php echo $title_for_layout; ?></title>
<?php
echo $this->Html->meta('icon');
echo $this->Html->css('cake.generic');
echo $this->Html->css('style');
echo $this->Html->css('common');
echo $this->Html->css('form');
echo $this->Html->css('tables');
echo $this->Html->script( array('frontend/jquery','ckeditor/ckeditor'));
echo $scripts_for_layout;
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
$userDetails=$this->Session->read('User');
extract($userDetails['Login']);
?>

<span style="float: right;"> Welcome [<?php echo $first_name.' '.$last_name?>]<br />
<a href="<?php echo $this->webroot;?>admin/users/setting/<?php echo $id;?>">Settings</a><br />
<a href="<?php echo $this->webroot;?>admin/logins/logout">Logout</a>
</span>
<br /><br/>
<h3>
Jobseeker Admin Panel
<!--<img src="<?php echo $this->webroot; ?>img/demo_logo.gif" hieght="120" width="100"/>--></h3>
</div>
<!-- [end]#header -->


<div id="menu">
<ul id="navmenu">
	<li><?php 
	if(strtolower($this->name)=='users' && strtolower($this->action)!='admin_setting'){
		echo $this->Html->link('Users',array('controller' => 'users', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Users',array('controller' => 'users', 'action' => 'index','admin'=>true));
	}
	?></li>
	
	
	<li><?php
	if(strtolower($this->name)=='professionals'){
		echo $this->Html->link('Professionals',array('controller' => 'professionals', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Professionals',array('controller' => 'professionals', 'action' => 'index','admin'=>true));
	}
	?>
    <ul class="nav_submenu submenu">
	
		<li><?php
		if(strtolower($this->name)=='professionals'){
			echo $this->Html->link('Unregistered Email',array('controller' => 'professionals', 'action' => 'unregistered_professionals','admin'=>true),array('class' => 'current'));
		}else{
			echo $this->Html->link('Unregistered Email',array('controller' => 'professionals', 'action' => 'unregistered_professionals','admin'=>true));
		}
		?>
		</li>
        </ul>
    </li>
	  <li><?php 
	if(strtolower($this->name)=='recruiters'){
		echo $this->Html->link('Recruiters',array('controller' => 'recruiters', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Recruiters',array('controller' => 'recruiters', 'action' => 'index','admin'=>true));
	}
	?>
	</li>
	
    <li><?php 
	if(strtolower($this->name)=='email_templates' || strtolower($this->name)=='emailtemplates'){
		echo $this->Html->link('Email Templates',array('controller' => 'email_templates', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Email Templates',array('controller' => 'email_templates', 'action' => 'index','admin'=>true));
	}
	?>
	</li>
     <li><?php
	if(strtolower($this->name)=='cmses'){
		echo $this->Html->link('Cms',array('controller' => 'cms', 'action' => 'index','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Cms',array('controller' => 'cms', 'action' => 'index','admin'=>true));
	}
	?>
	</li>
    <li><?php
	if(strtolower($this->name)=='common'){
		echo $this->Html->link('Setting',array('controller' => 'common', 'action' => 'setting','admin'=>true),array('class' => 'current'));
	}else{
		echo $this->Html->link('Setting',array('controller' => 'common', 'action' => 'setting','admin'=>true));
	}
	?>
	</li>
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



