<?php 
		echo $this->Html->css(array(
									'https://socialeyes.ws/css/bootstrap.css',
									'https://socialeyes.ws/css/bootstrap.min.css',									
									'https://socialeyes.ws/css/bootstrap-responsive.min.css',
									'https://code.jquery.com/mobile/latest/jquery.mobile.css',
									'lib/jqm-datebox.min.css', 
									'lib/jquery.mobile.simpledialog.min.css',
									'lib/demos.css',
									'https://socialeyes.ws/css/style.css'
									)
							);
?>
<?php 
		echo $this->Html->script(array(
						'custom',						
					)
			);
?>

<div class="createAccount">
  <div class="accountWrapper">
    <?php echo $this->Form->create('User', array(
												'url'=>array('controller'=>'websites', 'action'=>'register'),
												'id'=>'register',
												'inputDefaults'=>array(
													'class'=>false, 'div'=>false, 'label'=>false
												)
										)
								); ?>
      <div class="accInner">
        <h1>Create a new account</h1>
                <table width="00%" border="0" cellpadding="2" cellspacing="2" sytle="font-size:16px;color:#fff;">
          <tr>
            <td valign="top"><fieldset>
                <legend style="color:#fff;">Sign-up form</legend>
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="formSec">
                  <tr>
                    <td>
						<div align="left" style="font-size:16px;line-height:28px;color:#ffffff">
						Email*
                    </td>
                  </tr>
                  <tr>
                    <td>
						<?php echo $this->Form->input('email', array('type'=>'text', 'size'=>'55', 'class'=>'text')); ?>						
					</td>
                  </tr>
                  <tr>
                    <td><div align="left" style="font-size:16px;line-height:28px;color:#ffffff">
                      Password*</td>
                  </tr>
                  <tr>
                    <td>
						<?php echo $this->Form->input('password', array('type'=>'password', 'size'=>'30', 'class'=>'text')); ?>						
					</td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap" style="font-size:16px;line-height:28px;color:#ffffff">First name*</td>
                  </tr>
                  <tr>
                    <td>
						<?php echo $this->Form->input('first_name', array('type'=>'text', 'size'=>'30', 'class'=>'text')); ?>	
						
					</td>
                  </tr>
                  <tr>
                    <td><div align="left" style="font-size:16px;line-height:28px;color:#ffffff">Last name</div></td>
                  </tr>
                  <tr>
                    <td>
						<?php echo $this->Form->input('last_name', array('type'=>'text', 'size'=>'30', 'class'=>'text', 'required'=>false)); ?>						
					</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left">
						<?php echo $this->Form->submit('Create new account', array('class'=>'createBtn')); ?>
						
					</td>
                  </tr>
                </table>
              </fieldset></td>
          </tr>
        </table>
      </div>
      <div class="bottomSec">
        <legend style="color:#fff; font-weight: normal;">Already have an account?</legend>
        <a href="?route=users/login" class="signIn">Sign-in</a><br />
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">

	$(document).ready(function(){
		$("#register").validate({
			rules : {
				"data[User][email]" : {
					required : true,
					email : true
				},
				"data[User][password]" : {
					required : true,
					
				},
				"data[User][first_name]" : {
					required : true,					
				}
			}
		});
	});
</script>
