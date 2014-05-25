<style>
.fancybox-close{ right:36px !important;}
</style>
<div id="form_section" class="none" <?php if(isset($popup_login)){ ?>style="padding:0px; width:99.3%; margin:0px"<?php } ?>>
			
            <span class="select_dele">/ /<strong> Login</strong>
            </span>
            <div class="formLoading" style="display:none; text-align:center; margin-top:200px; "><?php echo $this->Html->image('ajax-loader.gif',array('escape'=>false));?></div>
            <form id="loginForm" name="loginForm" method="post" action="" onsubmit="return submit_login_form();" style="width:100% !important">
            	 <fieldset>
                 <div class="left_sect">
            	<input type="hidden" name="fb_login" id="fb_login" value="0"/>
                <input type="hidden" name="user_fb_id" id="user_fb_id"/>
                 <input type="hidden" name="user_first_name" id="user_first_name"/>
                 <input type="hidden" name="user_last_name" id="user_last_name"/>
            	<div id="flash_msg" style="display:none; color:#FF0033;"></div>
                <label>Email</label>
                <span class="text_box">
            		<input type="text" id="user_email" name="email" class="validate[required,custom[email]]"/>
                </span>
                <label>Password</label>
                <span class="text_box">
            		<input type="password"  name="password" class="validate[required]"/>
                </span>
                  <div class="submit" style="float:left; width:100%">
                      <input class="done" type="submit" value="submit" onclick="return submit_login_form();" style="width:auto;">
                      <span class="forget"><a href="javascript://" onclick="forget_pass_lightbox();">Forgot Password?</a></span>
                    </div>
 </div>
                  <div class="right_sect" style="<?php if(isset($popup_login)){ ?>margin:0px;<?php } ?> display:none;">
                  	<a href="javascript://" onclick="myfunc();" class="facebook">Facebook</a>
					<a href="javascript://" onclick="login();" id="loginText" class="gmail">Gmail</a>
                   </div>
                    
         </fieldset>
            </form>
</div>
            
           
       
<script type="text/javascript">
$(document).ready(function(e) {
    $("#loginForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
		
});

function myfunc() {
  FB.login(function(response) {
	$.post('<?php echo SITE_URL; ?>/home/get_fb_details',function(data){
		var arr=JSON.parse(data);		
			$('#user_fb_id').val(arr['id']);
			$('#user_first_name').val(arr['first_name']);
			$('#user_last_name').val(arr['last_name']);
			$('#user_email').val(arr['email']);
			$('#fb_login').val('1');
			loginStep();
		});  
  
	}, {scope:'email,read_mailbox,publish_stream,user_location,offline_access'});
}

function submit_login_form()
{
		var valid = $("#loginForm").validationEngine('validate');
			
			if(valid)
			{	loginStep();
			}else{
				$("#loginForm").validationEngine({scroll:false,focusFirstField : false});
				shakeField();
			}	
		return false;	
}

function forget_pass_lightbox()
{
	$.fancybox.close();
	setTimeout(function(){ 
	$.fancybox.open(
			{
				//'autoDimensions'    : false,
				'autoSize'     :   false,
				'width'             : '500',
				'type'				: 'ajax',
				'height'            : '350',
				'href'          	: site_url+'/users/display_forget_password'
			}
		); 	},1000);	
}

</script>

  <script>
        var OAUTHURL    =   'https://accounts.google.com/o/oauth2/auth?';
        var VALIDURL    =   'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=';
        var SCOPE       =   'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email';
        var CLIENTID    =   '<?php echo Google_ID; ?>';
        var REDIRECT    =   '<?php echo Google_REDIRECT; ?>'
        var LOGOUT      =   'http://accounts.google.com/Logout';
        var TYPE        =   'token';
        var _url        =   OAUTHURL + 'scope=' + SCOPE + '&client_id=' + CLIENTID + '&redirect_uri=' + REDIRECT + '&response_type=' + TYPE;
        var acToken;
        var tokenType;
        var expiresIn;
        var user;
        var loggedIn    =   false;

        function login() {
            var win         =   window.open(_url, "windowname1", 'width=600, height=500'); 

            var pollTimer   =   window.setInterval(function() { 
                console.log(win);
                console.log(win.document);
                console.log(win.document.URL);
                if (win.document.URL.indexOf(REDIRECT) != -1) {
                    window.clearInterval(pollTimer);
                    var url =   win.document.URL;
                    acToken =   gup(url, 'access_token');
                    tokenType = gup(url, 'token_type');
                    expiresIn = gup(url, 'expires_in');
                    win.close();

                    validateToken(acToken);
                }
            }, 500);
        }

        function validateToken(token) {
            $.ajax({
                url: VALIDURL + token,
                data: null,
                success: function(responseText){  
                    getUserInfo();
                    loggedIn = true;
                   
                },  
                dataType: "jsonp"  
            });
        }

        function getUserInfo() {
            $.ajax({
                url: 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' + acToken,
                data: null,
                success: function(resp) {
                    user    =   resp;
                    console.log(user);
					$('#user_first_name').val(user.name);
					$('#user_email').val(user.email);
					$('#fb_login').val('1');
					loginStep();
                
                },
                dataType: "jsonp"
            });
        }

       
        function gup(url, name) {
            name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
            var regexS = "[\\#&]"+name+"=([^&#]*)";
            var regex = new RegExp( regexS );
            var results = regex.exec( url );
            if( results == null )
                return "";
            else
                return results[1];
        }

      
    </script>
        