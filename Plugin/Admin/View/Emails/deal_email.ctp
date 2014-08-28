<script type="text/javascript">
	jQuery(document).ready(function (){
		//$('#productOrderPlace')
		jQuery('#frm_addedit').validate({
			errorClass: "error-message",
			errorElement: "div"});
	});
</script>

  <?php echo $this->Html->script(array('fckeditor'), array('inline' => false));?>

    <div class="row">
		<div class="floatleft mtop10"><h1>Deal Email</h1>
		<h4 style="padding-top:15px">The deal email is sent to the user when the user shares your deal along with the coupon. This email is sent to the user when the deal is shared.</h4>
		</div>
    </div>
    
	<div align="center" class="greybox mtop15">
		<?php echo $this->Form->create('AdminClientDealEmail', array('id' => 'frm_addedit', 'inputDefaults' => array('label' => false, 'div' => false, 'error' => false, 'type'=>'text'))) ?>
			<?php 
				echo $this->Form->input('id', array('type'=>'hidden'));
				echo $this->Form->input('client_id', array('type'=>'hidden'));

			?>
			
			<table cellspacing="0" cellpadding="7" border="0" align="center">
				<?php echo $this->Form->input('Admin.id', array('type'=>'hidden')); ?>
				<tr>
					<td valign="middle"><strong class="upper">Subject:</strong></td>
					<td><?php echo $this->Form->input('subject', array('class' => 'input required', 'style' => "width: 450px;",'label'=>false,'div'=>false,'required'=>'required')); ?></td>
				</tr>
				<tr>
					<td valign="middle"><strong class="upper">From Name</strong></td>
					<td><?php echo $this->Form->input('from_name', array('class' => 'input required', 'style' => "width: 450px;",'label'=>false,'div'=>false,'required'=>'required')); ?></td>
				</tr>
				<tr>
					<td valign="middle"><strong class="upper">From Email:</strong></td>
					<td><?php echo $this->Form->input('from_email', array('class' => 'input required ', 'style' => "width: 450px;",'label'=>false,'div'=>false,'required'=>'required')); ?></td>
				</tr>
				<tr>
					<td valign="middle"><strong class="upper">Reply To:</strong></td>
					<td><?php echo $this->Form->input('reply_to', array('class' => 'input required ', 'style' => "width: 450px;",'label'=>false,'div'=>false,'required'=>'required')); ?></td>
				</tr>
				<tr>
					<td valign="middle"><strong class="upper">Content:</strong></td>
					<td>
						<?php echo $this->Form->input('content', array('class' => 'input ckeditor', 'style' => "width: 450px;", 'rows' => '10','label'=>false,'div'=>false)); ?>
						 
					</td>
					<td>
					<strong>Key use in template:</strong>
					<?php 
						$keysforemail = $this->Common->getDealEmailVariable();
						foreach($keysforemail as $key) 
						{
							echo '<p>'.$key.'</p>';
						}
					?>
					</td>
				</tr>	
				<tr>
                	<td>&nbsp;</td>
					<td>
						<div class="floatleft">
							<input type="submit" class="submit_btn" value="">
						</div>
						<div class="floatleft" id="domain_loader" style="padding-left:5px;"></div>
					</td>
				</tr>
			</table>
		<?php echo $this->Form->end()?>
	</div>
