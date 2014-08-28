<div id="login">
<table width="550" align="center">
	<thead>
		<tr>
			<th colspan="2">Reset Password</th>
		</tr>
	</thead>

	<tr>
		<td class="vmiddle"><img
			src="<?php echo $this->webroot;?>img/forgate-pass.jpg" alt="Control Panel Login" /></td>
   		<td>
		<?php echo $this->Form->create('Login',array('action'=>'reset_password'));?>
	 	<?php echo $this->Form->input('password',array('label'=>'New Password','type'=>'password'));?>
	 	<?php echo $this->Form->input('confirm_password',array('type'=>'password'));?>
	 	<?php echo $this->Form->input('id',array('value'=>$id,'type'=>'hidden'));?>
	 	<?php echo $this->Form->input('uid',array('value'=>$uid,'type'=>'hidden'));?>
		<?php echo $this->Form->end(__('Submit', true));?>
		</td>
	</tr>
	<tfoot>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	</tfoot>
</table>

</div>
