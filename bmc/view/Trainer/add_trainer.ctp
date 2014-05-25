<section id="login_container" class="personal_detail">
	<div class="login_details personal_detail">	
		<h3 class="title">Trainer Details  <?php if(isset($trainer)){ ?> - Trainer ID - <?php echo $trainer['Trainer']['trainer_id']; } ?></h3>
		<div id="about" class="nano">	
        <section class="signup_form">
         <form id="AddTrainerForm" name="AddTrainerForm" method="post" onsubmit="return save_trainer('<?php if($this->Session->read('User.type')=='Trainer') echo '1'; else echo '0'; ?>');">
         	<input type="hidden" name="data[Trainer][id]" value="<?php if(isset($trainer)){ echo $trainer['Trainer']['id']; }?>"/>            	
               
                <p><label>First Name<span>*</span></label><input class="validate[required]" type="text" name="data[User][first_name]" value="<?php if(isset($trainer)) echo $trainer['User']['first_name']?>"/></p>
               <p><label>Last Name<span>*</span></label><input class="validate[required]" type="text" name="data[User][last_name]" value="<?php if(isset($trainer)) echo $trainer['User']['last_name']?>"/></p>
                 <p><label>Email<span>*</span></label><input class="validate[required,custom[email]]" type="text"  name="data[User][email]" value="<?php if(isset($trainer)) echo $trainer['User']['email']?>" <?php if(isset($trainer)){ ?> readonly="readonly"<?php } ?>/></p>
                 <p><label>Phone No.<span></span></label><input type="text"  name="data[User][phone]" value="<?php if(isset($trainer)) echo $trainer['User']['phone']?>"/></p>
                 <p><label>Address<span></span></label><textarea rows="0" cols="0" name="data[User][address]"><?php if(isset($trainer)) echo $trainer['User']['address']?></textarea></p>
                 
            	<p class="last"><input type="submit" value="<?php if(isset($trainer)) echo 'Update'; else echo 'Save'; ?>"></p>
                
              </form>  
            </section>
            </div>
     </div>
</section>

<script type="text/javascript">
$(document).ready(function(e) {
    $("#AddTrainerForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	 setTimeout(function(){ $(".nano").nanoScroller({alwaysVisible:true, contentClass:'signup_form',sliderMaxHeight: 70 }),500});
});
</script>