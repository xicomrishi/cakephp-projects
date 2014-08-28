<?php
	echo $this->Html->script(array('jquery.validate'), array('inline' => false));
?>
<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Settings'); ?></h1></div>
   
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
    
    <?php echo $this->Form->create('', array('url' => array('controller'=>'Settings','action'=>'site_setting'), 'type' => 'file', 'class' => 'validate', 'name' => 'frm_addedit', 'id' => 'frm_addedit', 'inputDefaults' => array('label' => false, 'div' => false, 'error' => false, 'type'=>'text'))) ?>
    <table cellspacing="0" cellpadding="7" border="0" align="center">

		<?php
		echo $this->Form->input('id',array('type' => 'hidden'));
		?>
		<tr>
			<td align="left"><strong class="upper">From Email</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('from_email',array('class' => 'input required', 'label' => false,  'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Reply To</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('replay_to',array('class' => 'input required', 'label' => false,  'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">From Name</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('from_name',array('class' => 'input required', 'label' => false,  'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Domain</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('domain',array('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Default Site Meta Title</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('meta_title',array('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>
		
		<tr>
			<td align="left"><strong class="upper">Default Site Meta keywords</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('meta_keywords',array('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Default Site Meta Description</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('meta_description',array('class' => 'input required', 'label' => false,  'rows' => '10','error' => false, 'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Logout Image</strong></td>
			<td align="left">	
			<?php
					
					if(isset($this->data['Settings']['image']) && !empty($this->data['Settings']['image']))
					 $cl_required = '';
					else
						 $cl_required = 'required';
					echo $this->Form->input('image',array('type'=>'file', 'class' => 'input '.$cl_required, 'label' => false,'error' => false, 'div' => false, 'style'=>'width: 450px;'));
					
					if(!empty($this->data['Settings']['image']) && file_exists(SETTINGS.$this->data['Settings']['image']))
					{
						echo $this->Html->image(SETTINGSURL.$this->data['Settings']['image'], array('width'=>100, 'height'=>100));
					}
					else
					{
						echo $this->Html->image('no_image_available_small.png', array('width'=>100, 'height'=>100));
					}
			?>
			</td>
		</tr>
		
		
		
		<tr>
			<td align="left"></td>
			<td align="left"><div class="black_btn2"><span class="upper"><?php echo $this->Form->end(__('Submit'));?></span></div></td>
		</tr>
    </table>
    
</div>
<script>
	$(document).ready(function (){
		$('.validate').validate();
	});
</script>
