<section class="form_sec">
<div class="ajax_loader" style="display:none; vertical-align: text-top;">
<img src="<?php echo $this->webroot;?>img/ajax-loader-5.gif"/>&nbsp;Processing...</div>
<div id="recharge_form">
<?php if(isset($RechargeForm)){
	echo $RechargeForm;
}?>
</div>
</section><!-- /form section -->

<section class="right_sec simple">
<section class="simple_box">
<a class="more_content" href="#home_page_more_content">
<img src="<?php echo $this->webroot;?>img/frontend/plus_icon.png">
</a>

<?php if(isset($home_page_content)){
	echo $this->Core->render($home_page_content['page_content']);
}?>

<div style="display:none">
<div id="home_page_more_content" class="fancy_box_content">
<?php if(isset($home_page_more_content)){
	echo $this->Core->render($home_page_more_content['page_content']);
}?>
</div>
</div>

</section>
</section>
<script type="text/javascript">
jQuery(function(){
	jQuery(".more_content").fancybox({
			scrolling : 'no',
			padding : 5,
		    margin : 100			
	}); 		
	
});

</script>