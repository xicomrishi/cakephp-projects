<section class="form_sec customer_signin">

<div id="sign_in">
<?php echo $this->Form->create('CustomerLogin',array('url'=>'/customers/index'));?>
<fieldset>
<h2>Returning user login below!</h2>
<?php echo $this->Session->flash('login');
echo $this->Session->flash('auth');
?>			
<ul>
	 	<li><?php  
    	echo $this->Form->input('email', array(
    	'div'=>false, 'type'=>'text','between' =>'<span>','after'=>'</span>',
    	'label'=>'Email<strong>*</strong>'));
    	?></li>
    	
	  	 <li>
	  	<?php 
    	echo $this->Form->input('password', array('div'=>false,
    	'type'=>'password',	'between' =>'<span>','after'=>'</span>',
    	'label'=>'Password<strong>*</strong>'));
    	?></li>  
	
	<li>
	<?php 
	echo $this->Form->input('action', array('type'=>'hidden','value'=>'login'));
	echo $this->Form->input('Login Now!',array('label'=>false,'type'=>'submit','div'=>false,'value'=>'Login Now!'));
	?>
	</li>
	
	<li>
	<a href="javascript:void(0);" onclick="javascript:$('#sign_in').hide();$('#forgot_pass').show();">Forgot Password?</a></span>
    </li>
	
</ul>
</fieldset>
<?php echo $this->Form->end();?>
</div>


<div id="forgot_pass" style="display:none;">
	<div id="commentStatus"></div>
	<?php echo $this->Form->create('Customer',array('action'=>'forgot_password', 'default' => false));?>
	
	<fieldset>
 	<ul>
 	<li><?php  
    echo $this->Form->input('email', array(
    'div'=>false, 'type'=>'text','between' =>'<span>','after'=>'</span>',
    'label'=>'Email<strong>*</strong>'));
    ?></li>
   
    <li>
 	<?php echo $this->Js->submit('Submit',
 	array('url'=>'/customers/forgot_password',
 	'update' => '#commentStatus',
 	'before' => $this->Js->get('#loader')->effect('show', array('buffer' => false)),
	'complete' => $this->Js->get('#loader')->effect('hide', array('buffer' => false))
 	));
	?>
	</li>
	 </ul>
	</fieldset>
	<?php echo $this->Form->end();
	echo $this->Html->image('ajax-loader-5.gif', array('id'=>'loader','style="display:none"'));
	echo $this->Js->writeBuffer();
	?>
	<br/>
	<a href="javascript:void(0);" onclick="javascript:$('#forgot_pass').hide();$('#sign_in').show();">Click here to login</a></span>
	
</div>

</section>

<section class="right_sec customer_register">
<section class="form_sec">
<!-- customer registration form -->
<?php echo $this->Form->create('Customer',array('url'=>'/customers/index'));?>
<fieldset>
<h2>Get FREE recharge coupons. Register below!</h2>
<?php echo $this->Session->flash('register'); ?>			
<ul>
	 	<li><?php  
    	echo $this->Form->input('email', array(
    	'div'=>false, 'type'=>'text','between' =>'<span>','after'=>'</span>',
    	'label'=>'Email<strong>*</strong>'));
    	?></li>
    	
	  	 <li>
	  	<?php 
    	echo $this->Form->input('password', array('div'=>false,
    	'type'=>'password',	'between' =>'<span>','after'=>'</span>',
    	'label'=>'Password<strong>*</strong>'));
    	?></li>
    
		<li>
		<?php 
		echo $this->Form->input('confirm_password', array('type'=>'password',
		'div'=>false,'between' =>'<span>','after'=>'</span>',
		'label'=>'Confirm Password<strong>*</strong>'));
		?>
		</li>
		
		<li>
		<?php 
		echo $this->Form->input('name', array('type'=>'text',
		'div'=>false,'between' =>'<span>','after'=>'</span>',
		'label'=>'Name<strong>*</strong>'));
		?>
		</li>
		
	<li>
	<?php 
	echo $this->Form->input('action', array('type'=>'hidden','value'=>'register'));
	echo $this->Form->input('Register Now!',array('label'=>false,'type'=>'submit','div'=>false,'value'=>'Register Now!'));
	?>
	</li>
	
</ul>
</fieldset>
<?php echo $this->Form->end();?>
<!-- /customer registration form -->
</section>
</section>
