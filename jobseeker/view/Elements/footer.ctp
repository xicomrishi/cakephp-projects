
<footer>
<div class="wrapper"> 
  <section class="footer_box1">
  <ul>
  <li><a href="<?php echo $this->webroot;?>cms/page/terms_of_service" >Terms of Service</a></li>
  <li class="last"><a href="<?php echo $this->webroot;?>cms/page/privacy_policy" >Privacy Policy</a></li>
  </ul>
  </section>
 <ul class="social_icon">
  <li><a href="#" ><img src="<?php echo $this->webroot;?>images/facebook1.png" alt="" title="Facebook"/></a></li>
  <li><a href="#" ><img src="<?php echo $this->webroot;?>images/twitter1.png" alt="" title="Twitter"/></a></li>
  <li><a href="#" ><img src="<?php echo $this->webroot;?>images/google+1.png" alt="" title="Google+"/></a></li>
  </ul>
  <section class="footer_box3">
  <p>
  <?php 
$footerText= $this->requestAction('common/getFooter');

  if($footerText){
	  		echo $footerText;
  }else{ ?>
  2013 &copy; JOB LISTING. All Rights Reserved. 
  <?php }?>
  </p>
  </section>  
</div>  
</footer>