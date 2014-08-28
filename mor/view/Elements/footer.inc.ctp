<footer>
<section class="top_footer">
<div class="wrapper"><section class="left_sec">
<?php if(isset($footer_top_content)){
	echo  $this->Core->render($footer_top_content['page_content']);
}?>
</section> <img
	src="<?php echo $this->webroot;?>img/frontend/payment_icon.png"></div>
</section>
<section class="bottom_footer">
<div class="wrapper">
<?php if(isset($footer_bottom_content)){
	echo $this->Core->render($footer_bottom_content['page_content']);
}?>
</div>
</section>
</footer>
