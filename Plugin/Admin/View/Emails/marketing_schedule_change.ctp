<?php	
	echo $this->Html->css(array(
								'/admin/css/jquery-ui',
								'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/ui-lightness/jquery-ui.css',
								'developer',
							)
						);
	echo $this->Html->script(array(
									'/admin/js/additional-methods.min', '/admin/js/jquery-ui', '/admin/js/ckeditor/ckeditor'								
								)
							);			
?>


</script>
    <div class="overlay"></div>
    <div class="row">
		<div class="floatleft mtop10"><h1>Send Marketing Email</h1></div>
    </div>
    <div class="row mtop15">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
			<tr valign="top">
			  <td align="left" class="searchbox">	
				<div class="floatleft">
					
				</div>		
				<div class="floatright top5">
					<?php echo $this->Html->link('<span>BACK</span>', array('controller' => 'emails', 'action' => 'marketing_schedule_email', 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false)); ?>
				</div>
			  </td>
		  </tr>
		</table>
	</div> 
	
	<div align="center" class="greybox mtop15">
		<?php echo $this->Form->create('AdminClientMarketingEmail', array('url' => array('controller'=>'emails','action'=>'marketing_schedule_change'), 'class' => 'aa', 'id' => 'marketing_email', 'inputDefaults' => array('label' => false, 'div' => false, 'error' => false, 'type'=>'text'))) ?>
			<?php 						
				echo $this->Form->input('id', array('type'=>'hidden', ));
			?>
			
			<table cellspacing="0" cellpadding="7" border="0" align="center">
				
				<tr>					
					<td valign="middle">	
					   <tr>
						   <td valign="middle" width="150"><strong class="upper">Schedule Date:</strong></td>
						   <td>			
								<?php echo $this->Form->input('schedule_date', array('type'=>'text', 'class' => 'input required datepicker scheduleField',  'style' => "width: 91%;",'label'=>false,'div'=>false,'required'=>'required', 'readonly'=>true,'id'=>'updateDate')); ?>									
							</td>	
						</tr>
						<tr>
						   <td valign="middle"><strong class="upper">Schedule Time:</strong></td>
						   <td>
								<?php for($i = 1;$i<=12;$i++) { $time[$i] = $i.':00'; } ?>		
								<?php echo $this->Form->input('schedule_time', array('type'=>'select', 'options'=>$time, 'class' => 'input required scheduleField', 'style' => "width: 50%;",'label'=>false,'div'=>false,'required'=>'required', 'id'=>'updateTime')); ?>
								<?php $time = array('AM'=>'AM', 'PM'=>'PM') ; ?>
								<?php echo $this->Form->input('schedule_time_type', array('type'=>'select', 'options'=>$time, 'class' => 'input required scheduleField', 'label'=>false,'div'=>false,'required'=>'required', 'id'=>'')); ?>
							
							</td>
						</tr>
						<tr>
						   <td valign="middle" width="150"><strong class="upper">Repeat Monthly:</strong></td>
						   <td>			
								<?php echo $this->Form->checkbox('is_repeat', array('class' => 'input scheduleField', 'style' => "width: 91%;",'label'=>false,'div'=>false)); ?>
							</td>	
						</tr>
					</td>
				</tr>
				
				<tr>
                	<td>&nbsp;</td>
					<td valign="middle" align="left">
						<div class="black_btn2">
							<span class="upper"><input type="submit" value="Save"  class="action" id="schedule"></span>
						</div>									
					</td>
				</tr>
				
			</table>			
		<?php echo $this->Form->end()?>
	</div>

<script type="text/javascript">
	$(document).ready(function (){		
	
		$(".datepicker").datepicker({
			dateFormat: 'yy-mm-dd',
			minDate : 0
		});
						
		$("#marketing_email").validate();
	});
</script>
<style>
.loadUser
{
	height: 125px;
    overflow-y: scroll;
}
.multipleUsers
{
	width:100%;
	float:left;
}
#fanc
{
	width:500px;
}
</style>
