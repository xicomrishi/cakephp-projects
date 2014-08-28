<section class="detail_box">
<?php if(isset($Content) && !empty($Content)){?>
<section class="common_box">

	<?php if(isset($Content['Content']['page_title']) && !empty($Content['Content']['page_title'])){
		echo "<h2>{$Content['Content']['page_title']}</h2>";
	}?>
	
	
	<?php if(isset($Content['Content']['page_sub_title']) && !empty($Content['Content']['page_sub_title'])){
		echo "<h3>{$Content['Content']['page_sub_title']}</h3>";
	}?>
	
	<?php if(isset($Content['Content']['page_content'])){
		echo $this->Core->render($Content['Content']['page_content']);
	}?>
</section><!-- /home -->
<?php }else{?>
<section class="sorry_box" style="min-height:300px">
	<img src="<?php echo $this->webroot;?>img/frontend/sorry_img.png">
	<section class="msg_box">
	<h3>ERROR: 404, Sorry! Page not found.</h3>
	</section>
</section>
<?php }?>
</section><!-- /details -->

