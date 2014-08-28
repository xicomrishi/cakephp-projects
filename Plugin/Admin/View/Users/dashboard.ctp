<?php 
	echo $this->Html->css(array('jquery.fancybox'));
	echo $this->Html->script(array('fancybox/source/jquery.fancybox'));
?>

  <!--Container Start from Here-->
 <div id="container">
    <h1>Dashboard</h1>   
    <div align="center" class="whitebox mtop15">
	<?php echo $this->Session->flash(); ?>
        <table cellspacing="0" cellpadding="5" border="0" align="center" style="margin-top:70px;">
          <tr>
            <td valign="top" align="left"><?php echo $this->Html->image("/admin/images/dashboard-graphic.png"); ?></td>
            <td valign="top" align="left">
              <span class="size26">Welcome to <?php echo SITE_NAME; ?> </span><br /><br />
              <span class="size14">Please use the navigation links at the top to access different<br />
              sections.</span></td>
          </tr>
        </table>
    </div>
    
    <div id="text_message" style="display: none; text-align: center; font-size: 14px; margin-top: 120px;">
    	
    	<strong>You need to login with facebook and give app required permissions</strong> <br><br>
    	<span><a href="<?php echo $this->webroot.'admin/users/get_page_access_token'; ?>" style="text-decoration: underline;">Click here</a> to login with facebook.
    	</span>
    </div>

<script type="text/javascript">
	$(document).ready(function(e){
		<?php if(isset($redirect_fb_page_token)){ ?>
			
			$.fancybox.open({
	 			'autoSize'		 : false,
	 			'autoDimensions' : false,
				'width' 	     : '350',
				'type'			 : 'inline',
				'height'		 : '350',
	 			'href'			 :  '#text_message'
	 			<?php if(!$this->Session->check('is_subadmin_user')){ ?>
	 			,'closeBtn' : false, 
	 			keys : {
					close : null
				},
				closeClick : false, // prevents closing when clicking INSIDE fancybox
				helpers : {
					overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
				}
				<?php } ?>
	 	});
	 	
		<?php } ?>	
	});
	
</script>    
    
