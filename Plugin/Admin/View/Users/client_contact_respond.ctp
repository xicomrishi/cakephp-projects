  
  <?php
	echo $this->Html->script(array('/admin/js/additional-methods.min','fckeditor'));
  ?>

<script type="text/javascript">
	jQuery(document).ready(function (){
		//$('#productOrderPlace')
		jQuery('#frm_addedit').validate({			
			errorClass: "error",
			errorElement: "div"});
	});
</script>

    <div class="row">
		<div class="floatleft mtop10"><h1>Respond to Contact Request</h1></div>
    </div>
    <div class="row mtop15">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                <tr valign="top">
                  <td align="left" class="searchbox">          
                    <div class="floatright top5"><?php echo $this->html->link('<span>Back to Contact Requests</span>', array('controller' => 'users', 'action' => 'client_contact_requests', $this->Session->read('Auth.User.id')), array('class' => 'black_btn', 'escape' => false)) ?></div>
                    
                  </td>
              </tr>
			</table>
	</div>
	<div align="center" class="greybox mtop15">
		<?php echo $this->Form->create('UserAppointment', array('name' => 'frm_addedit', 'id' => 'frm_addedit', 'inputDefaults' => array('label' => false, 'div' => false, 'error' => false, 'type'=>'text'))) ?>
			<?php 
				echo $this->Form->input('request_id', array('type'=>'hidden', 'value' => $request['UserAppointment']['id'])); 
				echo $this->Form->input('client_id', array('type'=>'hidden', 'value' => $request['UserAppointment']['client_id'])); 	 
			?>
			
			<table cellspacing="0" cellpadding="7" border="0" align="center">
				
				
				<tr>
					<td valign="middle"><strong class="upper">User Name:</strong></td>
					<td><?php echo $this->Form->input('name',array('class' => 'input required', 'value' => $request['UserAppointment']['name'],'style' => "width: 450px;",'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
 ?></td>
				</tr>
		
				
				<tr>
					<td valign="middle"><strong class="upper">User Email:</strong></td>
					<td><?php echo $this->Form->input('email',array('class' => 'input required email', 'value' => $request['UserAppointment']['email'],'style' => "width: 450px;",'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
 ?></td>
				</tr>
				
				<tr>
					<td valign="middle"><strong class="upper">Subject:</strong></td>
					<td><?php echo $this->Form->input('subject',array('class' => 'input required', 'value' => 'Re: '.$request['UserAppointment']['subject'],'style' => "width: 450px;",'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
 ?></td>
				</tr>
		
		
				<tr>
					<td valign="middle"><strong class="upper">Message:</strong></td>
					<td><?php 
					
					echo $this->Form->input('message', array('class' => 'input ckeditor', 'label'=>false, 'rows' => 10,'div'=>false,'required'=>'required')); ?></td>
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
