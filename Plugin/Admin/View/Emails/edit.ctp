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
		<div class="floatleft mtop10"><h1>Email Template</h1></div>
    </div>
    <div class="row mtop15">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                <tr valign="top">
                  <td align="left" class="searchbox">          
                    <div class="floatright top5"><?php echo $this->html->link('<span>Back to Email Templates</span>', array('controller' => 'emails', 'action' => 'manage'), array('class' => 'black_btn', 'escape' => false)) ?></div>
                    
                  </td>
              </tr>
			</table>
	</div>
	<div align="center" class="greybox mtop15">
		<?php echo $this->Form->create('EmailTemplate', array('url' => array('controller'=>'emails','action'=>'edit'), 'name' => 'frm_addedit', 'id' => 'frm_addedit', 'inputDefaults' => array('label' => false, 'div' => false, 'error' => false, 'type'=>'text'))) ?>
			<?php echo $this->Form->input('id', array('type'=>'hidden'));

 ?>
			
			<table cellspacing="0" cellpadding="7" border="0" align="center">
				<tr>
					<td valign="middle"><strong class="upper">Template Name:</strong></td>
					<td><?php echo $this->Form->input('email_identifier',array('class' => 'input', 'default' => $this->request->data['EmailTemplate']['email_identifier'],  'label' => false, 'error' => false, 'div' => false,  'style'=>'width: 450px;'));
 ?>
				</td>
				</tr>
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
						$keysforemail = $this->Common->getEmailVariable();
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
							<input type="submit" class="submit_btn" value="Submit">
						</div>
						<div class="floatleft" id="domain_loader" style="padding-left:5px;"></div>
					</td>
				</tr>
			</table>
		<?php echo $this->Form->end()?>
	</div>
