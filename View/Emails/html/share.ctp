<?php ?>

<html>

	<p> Greetings <?php echo $user['first_name'].' '.$user['last_name']; ?></p>
	
	<p>
		Thank you for choosing <?php echo $client['Admin']['company']; ?> . Your coupon is attached. Please print it out and bring it with you on your next visit to <?php echo $client['Admin']['company']; ?>. Please share this deal with all of your friends <a href="<?php echo SITE_URL.'domain/web/'.$client['Admin']['website_url']; ?>"><?php echo SITE_URL.'domain/web/'.$client['Admin']['website_url']; ?></a>
	</p>
	<p>
		Sincerely,
	</p>
	<p>
		<?php echo $client['Admin']['company']; ?>
	</p>
</html>
