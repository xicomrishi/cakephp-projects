<table width="30%" cellpadding="5" cellspaing="5" border="0" id="login">
		  <tr><td colspan="2" class="text1" style="color:#FFFFFF;"><i>*You will only be required to login at the beginning of each session</i></td></tr>
          <tr><td align="center" colspan="2" height="20"> <div class='msg' id="div_msglogin" ></div></td></tr>
           <tr><td width="25%" class="text1"><strong>EMAIL:</strong></td><td><input name='login_email' type='text'  class="inputbox1 required email" value=''> </td></tr>
           <tr><td  class="text1"><strong>PASSWORD:</strong></td><td><input name='TR_login_password' type='password'  class="inputbox1 required" value=''></td></tr>
           <tr><td align="center" colspan="2"> <input type="submit" value="Login" name="Submit_but" class="m_button"></td>
			</tr>
      	</table>
<script type="text/javascript">
url1="<?php echo SITE_URL;?>/users/login";
var v = $("#_jsbadd").validate({
submitHandler: function(form){
		$.post(url1,$("#_jsbadd").serialize(),function(data){
			if(data!='')
				$('#div_msglogin').html(data);
			else
			{
				$.post("<?php echo SITE_URL;?>/snagplugin/basket",$("#_jsbadd").serialize(),function(data){
				$('#snag_main').html(data);
				});
			}
					
		});

		}
	});

</script>		