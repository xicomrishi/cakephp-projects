<div id="error" class="errmassge1"></div> 
<section class="top_sec">
<?php
$url = "http://www.youtube.com/v/".$video_url;?>
<div align="center">
<object id="MediaPlayer"   >
				<param autoplay="1" showinfo="1" value="<?php echo $url;?>?fs=1&amp;hl=en_US&amp;rel=0" name="movie">
				
				<param value="true" name="allowFullScreen">				
				<param value="1" name="autoplay">				
				<param value="0" name="showinfo">				
				<param value="always" name="allowscriptaccess">				
				<embed height="470" width="790" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" src="<?php echo $url;?>?fs=1&amp;hl=en_US&amp;rel=0&amp;autoplay=1&amp;showinfo=0&amp;allowFullScreen=false" wmode="transparent">
				</embed>
			</object>
     </div>
</section>