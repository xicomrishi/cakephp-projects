<header>
<h1 class="logo">
<a href="<?php echo $this->webroot;?>">
<img src="<?php echo $this->webroot;?>img/frontend/logo.png" alt="logo"></a></h1>
<ul class="login_section">	
	<?php 
		$guest=$this->Session->read('GuestCustomer');
	
		if($loggedIn){?>
			<li class="active"><a href="<?php echo $this->webroot;?>customers/profile">Welcome <?php echo $loggedUser['name']?></a></li>	
			<li><a href="<?php echo $this->webroot;?>customers/logout">Logout</a></li>			
		
		<?php }elseif(!empty($guest)){?>
			<li  class="active"><a href="javascript:void(0)">Welcome <?php echo $guest['name'];?>&nbsp;(Guest)</a></li>
			<li><a href="<?php echo $this->webroot;?>customers">login / register</a></li>	
		<?php }else{?>
			<li class="active"><a href="<?php echo $this->webroot;?>customers">login / register</a></li>	
	<?php }?>
</ul>
</header>
