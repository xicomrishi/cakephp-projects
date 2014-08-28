<?php echo $this->Html->script('jquery.validate'); ?>

<script type="text/javascript">
 $(document).ready(function(){
	 
	 $("#submit").click(function(){
		//$("#formLoader").show();
	});
	 $("#require_email").validate({	
		errorClass: "twitter_form_errors",
		rules : {
			"data[User][email]" : {
				required : true,
				email : true
			}
		},
		invalidHandler: function (event, validator) {
			$("#formLoader").hide();
        }		
	});
});
</script>
<?php $bg = !empty($user_data['Admin']['bg_color'])?$user_data['Admin']['bg_color']:''; ?>
<?php $fore_color = !empty($user_data['Admin']['color'])?$user_data['Admin']['color']:''; ?>

<div class="login-wrap" <?php if(!empty($bg)){ ?>style="background-color:#<?php echo $bg; ?> !important; background:none;"<?php } ?>>
	<div class="pattern" style="background: url('<?php echo $this->webroot.'img/textures/texture_'.$user_data['Admin']['bg_texture'].'.png'; ?>') repeat 0 0!important;">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            	<?php echo $this->Form->create('User', array('id'=>'require_email', 'class'=>'login-form', 'inputDefaults'=>array('div'=>false, 'label'=>false))); ?>
		  
                <div class="middle-popup">
                    <h1>Get Your Deal!</h1>
                    <h2>Please enter your email address
                        to get started.</h2>
                     <?php echo $this->Html->image('loader.gif', array('id'=>'formLoader', 'style'=>'margin-top:25px; display:none;' )); ?>
						   
                    <div class="input-email">
                    	<?php echo $this->Form->input('email', array('type'=>'text', 'placeholder'=>'Enter your email','required'=>false)); ?>
				
                        
                    </div>
                    <div class="buttons-wrap">
                    	<?php echo $this->Form->submit('Submit', array('class'=>'submit-btn button', 'div'=>false, 'id'=>'submit')); ?>
                       <?php echo $this->Html->link('Exit', array('controller'=>'domain', 'action'=>'check_auth', 'tab'), array('class'=>'exit-btn button')); ?>
                        
                    </div>
                </div>
            	<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
    </div>
</div>
        
        
<style>
.twitter_form_errors{ color:#FC0202;}
</style>
