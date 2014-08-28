<div id="login">

<div id="sign_in">
<table width="550" align="center" class="login_board" border="1">
	<thead>
		<tr>
			<th colspan="2">Admin Panel Login</th>
		</tr>
	</thead>

	<tr>
		<td class="vmiddle"><img
			src="<?php echo $this->webroot;?>img/loginkey.jpg"  alt="Control Panel Login" /></td>
   		<td>
        <span class="error1"><?php if(isset($invalid))echo $invalid;?></span>
		<?php echo $this->Form->create('Login',array('action'=>'verify_login'));?>
	 	<?php echo $this->Form->input('email');?>
		<?php echo $this->Form->input('password',array('type'=>'password'));?>
		<?php echo $this->Form->end(__('Submit', true));?>
		<?php $this->validationErrors['Login']='';?>
         </td>
	</tr>
	<tfoot>
    <tr><td colspan="2"> <span class="forgot">
			<a href="javascript:void(0);" onclick="javascript:$('#sign_in').hide();$('#forgate_pass').show();">Forgot Password?</a></span>
      </td></tr>
	</tfoot>
</table>
</div>

<div id="forgate_pass" style="display:none;">

<table width="550" align="center" border="1">
	
	<thead>
		<tr>
			<th colspan="2">Forgot Password?</th>
		</tr>
	</thead>
	<tr>
	<td class="vmiddle">
		
		<img src="<?php echo $this->webroot;?>img/lock.png" alt="Control Panel Login" />
		</td>
		<td>
		<div id="commentStatus"></div>
		<?php echo $this->Form->create('Login',array('action'=>'forgate_password', 'default' => false));?>
	 	<?php echo $this->Form->input('email');?>
	 	<?php echo $this->Js->submit('Submit',
	 	array('url'=>'/admin/logins/forgate_password',
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
        <td colspan="2"> <span class="forgot">
			<a href="javascript:void(0);" onclick="javascript:$('#forgate_pass').hide();$('#sign_in').show();">Click here to login</a></span>
		</td>
		</tr>
	</tfoot>
	
</table>
</div>
</div>
