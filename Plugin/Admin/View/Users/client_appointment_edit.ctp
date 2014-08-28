<?php 	
	echo $this->Html->css(array('/admin/css/jquery-ui'						
								)
							);
	echo $this->Html->script(array( '/admin/js/jquery-ui','/admin/js/additional-methods.min'));		
?>

<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Edit Appointment'); ?></h1></div>
    <div class="floatright">
        <?php
			echo $this->Html->link('<span>'.__('Back To Manage Appointment').'</span>', array('controller' => 'users','action' => 'client_appointments', $this->data['UserAppointment']['client_id'], 'plugin' => 'admin'),array( 'class'=>'black_btn','escape'=>false));
		?>
	</div>
	<div class="errorMsg">
	<?php
		if (isset($invalidfields)) {
			echo " <p class='top15 gray12'><table>
				<tr><th>Fields</th><th>Error</th><tr>";
			foreach ($invalidfields as $key => $field) {
				echo "<tr><td>" . $key . "</td><td>";
				echo "<ul>";
				foreach ($field as $error) {
					echo "<li>" . $error . "</li>";
				}
				echo "</ul></td></tr>";
			}
			echo "</table>  </p>";
		}
		?>
	</div>
</div>

<div align="center" class="whitebox mtop15">
   <?php 
			echo $this->Form->create('UserAppointment', array(
									'type'=>'file',
									'url'=>array('controller'=>'users', 'action'=>'client_appointment_edit', $this->data['UserAppointment']['id']),
									'class'=>'validate',
									'inputDefaults'=>array('div'=>false, 'label'=>false)									
								)
							);
	?>
	    <table cellspacing="0" cellpadding="7" border="0" align="center">
	
			<?php
				echo $this->Form->input('id',array('type' => 'hidden'));
				echo $this->Form->input('client_id',array('type' => 'hidden'));	
				echo $this->Form->input('user_id',array('type' => 'hidden'));				
			?>
			
			<tr>
				<td align="left"><strong class="upper">Final Appointment Date</strong></td>
				<td align="left">	
					<?php
							echo $this->Form->input('final_date',array(
													'type'=>'select',
													'class' => 'input',
													'onchange' => 'check_selected_date(this.value)',
													'style'=>'width: 450px;',
													'options' => $final_date
										)
									);
					?>
				</td>
			</tr>		
			
			<tr class="others" style="display: none;">
				<td align="left"><strong class="upper">Other Date</strong></td>
				<td align="left">
					<?php 
				echo $this->Form->input('other_date', array('class' => 'input', 'style'=>'width:250px;', 'id'=>'other_date','placeholder'=>'Select Date')); 	
					?>
				</td>
			</tr>
			
			<tr class="others" style="display: none;">
				<td align="left"><strong class="upper">Time</strong></td>
				<td align="left">
					<?php 
					echo $this->Form->input('other_time', array('class' => 'input','type' => 'time', 'style'=>'width:55px;', 'id'=>'other_time')); 
					?>
				</td>
			</tr>
			
				
			
			<tr>
				<td align="left"></td>
				<td align="left">
					<div class="black_btn2">
						<span class="upper"><?php echo $this->Form->submit(__('Submit'));?></span>
					</div>
				</td>
			</tr>
	    </table>
    <?php echo $this->Form->end();?>
</div>
<script type="text/javascript">
	$(document).ready(function (){
		
		$("#other_date").datepicker({
			dateFormat: 'mm-dd-yy'
		});
		
		$('.validate').validate({
			
			ignore: '',
			onkeyup : false,
			rules : {
				"data[UserAppointment][final_date]" : {					
					required : true	
				}
			}
		});
	});
	
function check_selected_date(val)
{
	if(val == "0")
	{
		$('.others').show();
		$('#other_date').addClass('required');
	}else{
		$('#other_date').removeClass('required');
		$('.others').hide();
	}
}	
</script>
