<?php $bg = !empty($admin['Admin']['bg_color'])?$admin['Admin']['bg_color']:''; ?>
<?php $font_color = !empty($admin['Admin']['font_color'])?$admin['Admin']['font_color']:'fff'; ?>

<?php echo $this->Html->script(array('hello','jquery.oauthpopup')); ?>

<style>
div.col-sm-12 h2, h1{ color: #<?php echo $font_color; ?>;}
</style>
 <div class="user-login" style="background: url('<?php echo $this->webroot.'img/textures/texture_'.$admin['Admin']['bg_texture'].'.png'; ?>') repeat-x <?php echo '#'.$bg; ?>; ">
 	<div style="">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            	<?php 
				if( !empty($admin['Admin']['login_page_text_1']) ) 
							$Ltext = $admin['Admin']['login_page_text_1']; 
						else $Ltext = 'Enter to save!'; 
				?>	
					
					
				<?php if($deal['AdminClientDeal']['type'] == 1)
					{
				?>		
						<h2><?php echo $Ltext; ?></h2>
						<h1>
							
							<?php 
									echo $deal['AdminClientDeal']['price']. '% off '.$deal['AdminClientDeal']['product'];
							?>
						</h1>
				<?php } else if($deal['AdminClientDeal']['type'] == 2) { ?>
						<h2><?php echo $Ltext; ?></h2>
						<h1>
							
							<?php 
									echo '$'.$deal['AdminClientDeal']['price'].' off '.$deal['AdminClientDeal']['product'];
							?>
						</h1>
				<?php } else if($deal['AdminClientDeal']['type'] == 3) { ?>
						<h2><?php echo $Ltext; ?></h2>
						<h1>
							
							<?php 
									echo 'Buy One Get One Free '.$deal['AdminClientDeal']['product'];
							?>
						</h1>
				<?php } else { ?>
						<h2><?php echo $Ltext; ?></h2>
						<h1>
							
							<?php 
									echo $deal['AdminClientDeal']['product'];
							?>
						</h1>
				<?php } ?>
                
            </div>                
        </div>
    </div>
    </div>
</div>

<div class="container">
	 
    <div class="row">
        <div class="col-sm-12">  
            <ul class="login-buttons">
                <li>
                    <a href="javascript://<?php //echo $this->webroot.'domain/login/facebook/tab' ?>" onclick="connect_fb();" class="fb-login" ><strong class="fb-icon2"><i class="icons"></i></strong><span>Login with Facebook</span></a>
                </li>
                <li>
                    <a href="javascript://<?php //echo $this->webroot.'domain/login/twitter/tab' ?>" onclick="connect_tw();" class="twr-login" ><strong class="twr-icon2"><i class="icons"></i></strong><span>Login with Twitter</span></a>
                </li>
            </ul>
        </div>                
    </div> 
</div>
<div id="fb-root"></div>
<script type="text/javascript">
window.fbAsyncInit = function() {

    FB.init({
      appId  : '<?php echo FB_APP_ID; ?>',
      status : false, // check login status
      cookie : false, // enable cookies to allow the server to access the session
      xfbml  : true,  // parse XFBML
	  version    : 'v2.1' // use version 2.1
	 
    });
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
     
   
   function connect_fb()
   {   	
   	 FB.getLoginStatus(function(resp) {
   	 	if(resp.status == 'connected')
   	 	{
   	 		FB.logout(function(response) {
		      
		       FB.login(function(rp) {
						
						if(rp.status == 'connected')
						{
							window.location='<?php echo SITE_URL.'domain/facebook_callback/'; ?>'+rp.authResponse.accessToken+'/tab';
						}
					}, {scope:'publish_actions,read_friendlists,email,user_likes'}
				);
		    });	
   	 	}else{
   	 		FB.login(function(response) {
					if(response.status == 'connected')
					{
						window.location='<?php echo SITE_URL.'domain/facebook_callback/'; ?>'+response.authResponse.accessToken+'/tab';
					}
				}, {scope:'publish_actions,read_friendlists,email,user_likes'}
			); 
   	 	}   	 	
   	 	
   	 });		
      
	}

hello.init({
	twitter : '<?php echo LoginApi::TWITTER_CONSUMER_KEY; ?>'		
});

var wl = hello( "twitter" ).getAuthResponse();
console.log(wl);
	 
 function connect_tw()
 {
 	hello( "twitter" ).login();
 }	
 
 $(document).ready(function(){
    $('.twr-login1').click(function(){
        $.oauthpopup({
            path: '<?php echo $this->webroot.'tablets/get_tw_url/tab'; ?>',
            callback: function(){
                window.location.reload();
            }
        });
    });
});
</script>  