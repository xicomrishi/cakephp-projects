<?php
	echo $this->Html->script(array('jquery.validate'), array('inline' => false));
?>
<div class="users row">
    <div class="floatleft mtop10"><h1><?php echo __('Admin Add Cms'); ?></h1></div>
    <div class="floatright">
        <?php
	echo $this->Html->link('<span>'.__('Back To Manage Cms').'</span>', array('controller' => 'cms','action' => 'index','plugin' => 'admin'),array( 'class'=>'black_btn','escape'=>false));?>
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
    <?php echo $this->Form->create('Cms', array('class' => 'validate'));?>
    <table cellspacing="0" cellpadding="7" border="0" align="center">

		<?php
		echo $this->Form->input('id',array('type' => 'hidden'));
		?>
		<tr>
			<td align="left"><strong class="upper">Page Name</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('page_name',array('class' => 'input required', 'label' => false,  'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>
		
		<tr>
			<td align="left"><strong class="upper">Url Key</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('url_key',array('class' => 'input required', 'label' => false,  'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>
		
		<tr>
			<td align="left"><strong class="upper">Meta Title</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('meta_title',array('class' => 'input required', 'label' => false, 'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>	
	
		<tr>
			<td align="left"><strong class="upper">Meta Description</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('meta_description',array('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>
		
		<tr>
			<td align="left"><strong class="upper">Meta keywords</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('meta_keywords',array('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>
		<tr>
			<td align="left"><strong class="upper">Content</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('content',array('class' => 'input required ckeditor', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
			?>
			</td>
		</tr>
		
		<tr>
			<td align="left"><strong class="upper">Status</strong></td>
			<td align="left">	<?php
			echo $this->Form->input('status',array('class' => 'input required', 'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;', 'options' => array('active' => 'Active', 'inactive' => 'Inactive')));
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
