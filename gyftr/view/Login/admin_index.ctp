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
        <form id="LoginVerifyLoginForm" method="post" action="<?php echo SITE_URL; ?>/admin/login/verify_login">
           
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
	<tfoot>
		<tr>
			<td colspan="2"><span class="forgot">
			<a href="javascript:void(0);" onclick="javascript:$('#sign_in').hide();$('#forgate_pass').show();">Forgot
			Password?</a></span></td>
		</tr>
	</tfoot>
</table>
</div>

<div id="forgate_pass" style="display:none;">
<div id="commentStatus"></div>
<table width="550" align="center">
	
	<tr>
	<td class="vmiddle"><img src="<?php echo $this->webroot;?>img/forgate-pass.jpg" alt="Control Panel Login" /></td>
		<td>
               
		<?php echo $this->Form->create('Login',array('url'=>array('controller'=>'login','action'=>'forgate_password'),'type'=>'post', 'default' => false));?>
	 	<?php echo $this->Form->input('user_name');?>
	 	<?php echo $this->Js->submit('Submit',
	 	array('url'=>'/admin/login/forgate_password',
	 	'update' => '#commentStatus',
	 	'before' => $this->Js->get('#loader')->effect('show', array('buffer' => false)),
		'complete' => $this->Js->get('#loader')->effect('hide', array('buffer' => false))
	 	));
		?>
		<?php echo $this->Form->end();
		echo $this->Html->image('ajax-loader.gif', array('id'=>'loader','style="display:none"'));
		echo $this->Js->writeBuffer();
		?>
		</td>
	</tr>
	
	<tfoot>
		<tr>
			<td colspan="2"><span class="forgot">
			<a href="javascript:void(0);" onclick="javascript:$('#forgate_pass').hide();$('#sign_in').show();">Click here to login</a></span></td>
		</tr>
	</tfoot>
	
</table>
</div>
</div>
 <script>
		$(document).ready(function(){
			$("#LoginVerifyLoginForm").validationEngine({promptPosition: "topLeft"});
		});
</script>