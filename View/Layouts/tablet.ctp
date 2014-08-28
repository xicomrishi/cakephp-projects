<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Social Referrals');
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('tablet/reset', 'tablet/bootstrap','tablet/style','tablet/responsive','tablet/font-awesome'));
		echo $this->Html->script(array('html5','jquery-2.0.2', 'bootstrap.min','modernizr.custom.79639'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<script type="text/javascript">
		var SITE_URL = '<?php echo SITE_URL; ?>';		
		$(document).ready(function(){
			var heightwindow = parseInt($(window).height());
			if(heightwindow > 760){
				 $('.footer').css({'position': "absolute"});
			}
			else
			{
				$('.footer').css({'position': "relative"});
			}
			
		});
	</script>
</head>
<body>
	
			<?php echo $this->fetch('content'); ?>
		
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
