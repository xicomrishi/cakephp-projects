<?php 
	if(isset($message) && $message != '')
	{
		echo '<div class="row"><div class="flash flash_error">
			'.$message.'
		</div></div>';
	}
?>