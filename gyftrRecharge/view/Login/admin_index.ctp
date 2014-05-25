<div id="login">

<div id="sign_in">
<table width="550" align="center">
	<thead>
		<tr>
			<th colspan="2">Admin Panel Login</th>
		</tr>
	</thead>

	<tr>
		<td class="vmiddle"><?php echo $this->Html->image('loginkey.jpg',array('escape'=>false,'div'=>false,'alt'=>'Control Panel Login')); ?></td>
   		<td>
        <form id="LoginVerifyLoginForm" method="post" action="<?php echo $this->webroot; ?>admin/login/verify_login">
           
            <div class="input text">
            <label for="LoginUserName">User Name</label>
            <input name="data[Login][user_name]" class="validate[required]" maxlength="255" type="text" id="LoginUserName"/>
            </div>		
            
            <div class="input password">
            <label for="LoginPassword">Password</label>
            <input name="data[Login][password]" class="validate[required]" type="password" id="LoginPassword"/>
            </div>		
            <div class="submit">
            <input  type="submit" value="Submit"/>
            </div>
          </form>	
	
		</td>
	</tr>
	
</table>
</div>


</div>
 <script>
		$(document).ready(function(){
			$("#LoginVerifyLoginForm").validationEngine({promptPosition: "topLeft"});
		});
</script>