<?php 
		echo $this->Html->css(array('https://fonts.googleapis.com/css?family=Allerta', 'https://code.jquery.com/mobile/latest/jquery.mobile.css',
									'lib/jqm-datebox.min.css', 'https://socialeyes.ws/css/style.css',
									'lib/prettify.css', 'https://necolas.github.io/normalize.css/2.1.3/normalize.css',
									'https://social-referrals.com/css/datebox/jqm-datebox.min.css',
						'https://social-referrals.com/css/datebox/jquery.mobile.simpledialog.min.css',
						'https://social-referrals.com/css/datebox/demos.css',
						'https://social-referrals.com/css/style.css',
									)
							);
?>
<?php 
		echo $this->Html->script(array(
						'custom',
						'https://social-referrals.com/js/datebox/j1.js',
						'https://social-referrals.com/js/datebox/j2.js',
						'https://social-referrals.com/js/datebox/j3.js',
						'https://social-referrals.com/js/datebox/j4.js',
						'https://social-referrals.com/js/datebox/jqm-datebox.mode.slidebox.min.js',
						'lib/jquery.mousewheel.min.js', 
						'lib/jqm-datebox.core.min.js',
						'lib/jqm-datebox.mode.calbox.min.js', 
						'lib/jqm-datebox.mode.datebox.min.js',
						'lib/jqm-datebox.mode.flipbox.min.js',
						'lib/jqm-datebox.mode.durationbox.min.js',						
						'lib/jqm-datebox.mode.durationflipbox.min.js',
						'lib/jqm-datebox.mode.slidebox.min.js',
						'lib/jqm-datebox.mode.customflip.min.js',
						'lib/jqm-datebox.mode.custombox.min.js',
						'lib/jquery.mobile.datebox.i18n.en_US.utf8.js',
						'lib/jquery.mobile.simpledialog.min.js'
					)
			);
?>
	
<!-- Style sheet for lousy incompatible frustrating IE mobile -->
<!--[if IEMobile]>
<link rel="stylesheet" href="/m/css/iemobile.css" media="screen" />
<![endif]-->
<!--Script that scrolls page up to the top -->
<script type="text/javascript">
window.scrollTo(0,1);
</script>


<div class="createAccount">
	<div class="profileInner">
		<?php echo $this->Form->create('data1', array('id'=>'profile'));
			if(isset($loggedUser))
			{
				$loggedInUser = $loggedUser;
			} ?>
			<div class="main_form" id="form_1">
				<table width="100%" align="left" style="">
				<tr>
					<td width="auto" valign="top">
						<label for="first_name" style="font-size:16px;color:#ffffff"><br>
							First Name *
						</label>
					</td>
				</tr>
				<tr>
					<td width="auto" valign="top"><input type="text" name="data[User][first_name]" aria-required="true" maxlength="50" value='<?php echo $loggedInUser['User']['first_name']; ?>' class="text"></td>
				</tr>
				<tr>
					<td  valign="top"><label for="last_name" style="font-size:16px;line-height:28px;color:#ffffff">Last Name *</label></td>
				</tr>
				<tr>
					<td valign="top"><input type="text" name="data[User][last_name]" maxlength="50" aria-required="true" value='<?php echo $loggedInUser['User']['last_name']; ?>' class="text"></td>
				</tr>
				<tr>
					<td  valign="top"><label for="email" style="font-size:16px;line-height:28px;color:#ffffff">Email Address *</label></td>
				</tr>
				<tr>
					<td  valign="top"><input type="text" name="data[User][email]" maxlength="50" aria-required="true" size="40" value='<?php echo $loggedInUser['User']['email']; ?>' class="text"></td>
				</tr>
				<tr>
					<td  valign="top"><label for="telephone"  style="font-size:16px;line-height:28px;color:#ffffff">Telephone Number*</label></td>
				</tr>
				<tr>
					<td  valign="top"><input  type="text" name="data[User][mobile]" aria-required="true" value='<?php echo $loggedInUser['User']['mobile']; ?>' maxlength="30" size="40" class="text"></td>
				</tr>
				<tr>
					<td valign="top"><label for="comments" style="font-size:16px;line-height:28px;color:#ffffff">Comments</label></td>
				</tr>
				<tr>
					<td  valign="top"><textarea type="text" name="data[UserAppointment][comment]" cols="31" rows="5" class="text area" aria-required="true" style="height:86px;width:100%;" ><?php 
					if(isset($loggedInUser['UserAppointment']['comment']))
					{echo $loggedInUser['UserAppointment']['comment'];} ?></textarea></td>
				</tr>
				</table>
				<table width="100%" cellspacing="0" align="left"  style="padding-right:15px; padding-left:15px">
					<tr>
						<td width="30%" style="font-size:16px;line-height:28px;color:#ffffff">1st Choice:</td>
						<td valign="top" width="70%" >
							<div data-role="fieldcontain" style=" margin-bottom:-10px" class="dateSec">
								<input name="data[UserAppointment][first_choice]" id="mydate" type="date" data-role="datebox" data-options='{ "afterToday":"true","mode": "slidebox", "overrideDateFormat":"%m-%d-%Y %I:%M %p", "overrideTimeFormat":12, "overrideSlideFieldOrder":["y","m","d","h","i"]}' >
							</div>
						</td>
					</tr>
					<tr>
						<td width="30%" style="font-size:16px;line-height:28px;color:#ffffff">2nd Choice:</td>
						<td valign="top"> 
							<div data-role="fieldcontain" style=" margin-bottom:-10px" class="dateSec">
								<input name="data[UserAppointment][second_choice]" id="mydate" type="date" data-role="datebox" data-options='{ "afterToday":"true","mode": "slidebox", "overrideDateFormat":"%m-%d-%Y %I:%M %p", "overrideTimeFormat":12, "overrideSlideFieldOrder":["y","m","d","h","i"]}' >
							</div>
						</td>
					</tr>
					<tr>
						<td width="30%" style="font-size:16px;line-height:28px;color:#ffffff">3rd Choice:</td>
						<td valign="top">
							<div data-role="fieldcontain" style=" margin-bottom:-10px" class="dateSec">
								<input name="data[UserAppointment][third_choice]" id="mydate" type="date" data-role="datebox" data-options='{ "afterToday":"true","mode": "slidebox", "overrideDateFormat":"%m-%d-%Y %I:%M %p", "overrideTimeFormat":12, "overrideSlideFieldOrder":["y","m","d","h","i"]}' >
							</div>
						</td>
					</tr>
				</table><?php //%Y-%m-%dT%I:%M%p ?>
				<table width="100%" cellspacing="0" align="left" cellpadding="10">
					<tr>
						<?php if(isset($error_message))
							{ ?>
						<td height="26"  style="font-size:16px;line-height:28px;color:#FC0202">Please choose different date and a time for each</td>
						<?php } else { ?>
						<td height="26"  style="font-size:16px;line-height:28px;color:#ffffff">Please choose a date and a time for each. Thank You!</td>
						<?php } ?>
					</tr>
					<tr>
						<td height="26"  style="text-align:center" class="profileBtn">
							<input type="submit" value="Request an Appointment">
						</td>
					</tr>
				</table>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	function updateLocation()
	{
		window.location.href = SITE_URL+'domain/check_auth/tab';
	}
	$("#profile").validate({
		rules : {
			"data[User][first_name]" : {
				required : true,
				
			},
			"data[User][last_name]" : {
				required : true,
				
			},
			"data[User][email]" : {
				required : true,
				email : true
				
			},
			"data[User][mobile]" : {
				required : true,
				digits : true,
				minlength : 10,
				maxlength :12				
			},
			"data[UserAppointment][first_choice]" : {
				required : true,
					
			}
		}
	});
</script>
