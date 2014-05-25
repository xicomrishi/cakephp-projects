<div class="wrapper">
<section id="content">

<div class="row">

<div class="span12">
<h1>Change Password:</h1>
</div>

<div class="contact_us">
<section class="contact_left" style="min-height:320px"> 
<?php echo $this->Form->create('Professional',array('url'=>"/professionals/professional_settings",'id'=>'recruiter_settings','novalidate','autocomplete'=>'off'));?>

<fieldset>
<?php echo $this->Session->flash();?>

<div class="comn_row">
<div class="input_row">
<label>New Password<span>*</span></label> <?php echo $this->Form->input('password',array('type'=>'password','label'=>false,'required'=>'required','placeholder'=>'New Password','class'=>'new_password validate[required]','data-errormessage-value-missing'=>'Please enter new password.','value'=>$this->Form->value('password')));?>
</div>
</div>

<div class="comn_row">
<div class="input_row">
<label>Confirm Password<span>*</span></label> <?php echo $this->Form->input('confirm_password',array('type'=>'password','label'=>false,'required'=>'required',
                  'placeholder'=>'Confirm Password','class'=>'confirm_password validate[required]','data-errormessage-value-missing'=>'Please enter confirm password.','value'=>$this->Form->value('confirm_password')));?>
</div>
</div>

<div class="comn_row">
 <?php echo $this->Form->input('Update',array('label'=>false,'type'=>'submit','class'=>'submit_btn submit'));?>
</div>
</fieldset>
<?php echo $this->Form->end();?>
</section>
</div>