<section class="form_sec">
<?php $cart=$this->Session->read('Cart');?>
<?php if(isset($cart)){?>
<div class="information_box">
	<h3>Your Order Details</h3>          
        <ul>
            <li><strong>Service Type</strong>:&nbsp;<?php echo $cart['Cart']['ReType'];?></li>
		    <li><strong>Number</strong>:&nbsp;<?php echo $cart['Cart']['Number'];?></li>
			<li><strong>Operator</strong>:&nbsp;<?php echo $cart['Cart']['Operator'];?></li>
			<li><strong>Amount</strong>:&nbsp;<?php echo $cart['Cart']['Amount'];?></li>
			<?php if($cart['Cart']['Account']){?>
			<li><strong>Account#/Cycle#/DOB</strong>:&nbsp;<?php echo $cart['Cart']['Account'];?>
			</li>
			<?php }?>
        </ul>
</div>
<?php }?>

<!-- /cart -->

<?php echo $this->Form->create('Customer',array('url'=>'/customers/recharge_auth','novalidate'=>'novalidate'));?>
<fieldset>
		
<ul>
	<li>
	
	<?php echo $this->Session->flash('guest');
	echo $this->Session->flash('auth');
	?>
	<input type="radio" name="data[Customer][action]" value="guest" onclick="showFormRow(this.value);" <?php if($this->Form->value('action')=='' || $this->Form->value('action')=='guest'){?>checked="checked"<?php }?>/>
	<h2>Continue as Guest</h2>
	</li>
    
    
    <li class="guest_row common_row" <?php if($this->Form->value('action')=='guest' || $this->Form->value('action')==''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>><?php  
        
    echo $this->Form->input('guest_email', array(
    'div'=>false, 'type'=>'text','between' =>'<span>','after'=>'</span>',
    'label'=>'Email<strong>*</strong>', 
    ));
    ?></li>
    
    
	<li  class="guest_row common_row" <?php if($this->Form->value('action')=='guest' || $this->Form->value('action')==''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
	<?php 
	echo $this->Form->input('name', array('type'=>'text',
	'div'=>false,'between' =>'<span>','after'=>'</span>',
	'label'=>'Name<strong>*</strong>'));
	?>
	</li>   
     
	
	<li>
	<?php echo $this->Session->flash('login');
	?>	
	
	<input type="radio" name="data[Customer][action]" value="login" onclick="showFormRow(this.value);" <?php if($this->Form->value('action')=='login'){?>checked="checked"<?php }?>/>
	<h2>Log into my Account</h2>
	</li>
	
    <li class="login_row common_row" <?php if($this->Form->value('action')=='login'){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>><?php 
 	
    echo $this->Form->input('email', array(
    'div'=>false, 'type'=>'text','between' =>'<span>','after'=>'</span>',
    'label'=>'Email<strong>*</strong>',
    'name'=>'data[CustomerLogin][email]'));
    ?></li>
    
  	<li class="login_row common_row" <?php if($this->Form->value('action')=='login'){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
  	<?php 
    echo $this->Form->input('password', array('div'=>false,
    'type'=>'password',	'between' =>'<span>','after'=>'</span>',
    'label'=>'Password<strong>*</strong>',
    'name'=>'data[CustomerLogin][password]'));
    ?></li>  
	
	<li class="ext_signup">
	Don't have an account? <a href="<?php echo $this->webroot;?>customers">Register Now</a> for free coupons, recharge offers and more!
	</li>
	
	<li>
	<?php 
	echo $this->Form->input('Proceed',array('label'=>false,'type'=>'submit','div'=>false,'value'=>'Proceed'));
	?>
	</li>	
	
</ul>
</fieldset>
<?php echo $this->Form->end();?>

</section>

<section class="right_sec">
<section class="detail_box">
  <section class="tab_box">
  <section class="home_box">
  <?php if(isset($guest_signup_page)){
	echo $this->Core->render($guest_signup_page['page_content']);
   }?>  	
   </section>
 </section>                      
</section>
</section>

<script type="text/javascript">
function showFormRow(curVal){

	$("li.common_row").hide();
	if(curVal=='login'){
		$("li.login_row").show();
	}else{
		$("li.guest_row").show();
	}
}

</script>
