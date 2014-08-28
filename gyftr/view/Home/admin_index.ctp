<div class="logins dashboard notes">
	<?php 
	  $userDetails=$this->Session->read('Admin/User');
	  extract($userDetails['Login']);
	?>
	<h3>Welcome <?php echo $first_name.' '.$last_name;?></h3>
</div>
