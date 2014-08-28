  
  <?php
	echo $this->Html->script(array('/admin/js/additional-methods.min','fckeditor'));
  ?>

<script type="text/javascript">
	jQuery(document).ready(function (){
		//$('#productOrderPlace')
		jQuery('#frm_addedit').validate({
			rules: {
					"data[Coupon][image]" : {
						extension : "jpe?g|png"
				}
			},
			messages: {
				"data[Coupon][image]" : {
					extension : "Only jpeg, jpg, png files allowed."
				}
			},
			errorClass: "error",
			errorElement: "div"});
	});
</script>

    <div class="row">
		<div class="floatleft mtop10"><h1>Add Coupon</h1></div>
    </div>
    <div class="row mtop15">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                <tr valign="top">
                  <td align="left" class="searchbox">          
                    <div class="floatright top5"><?php echo $this->html->link('<span>Back to Coupons</span>', array('controller' => 'coupons', 'index' => 'manage'), array('class' => 'black_btn', 'escape' => false)) ?></div>
                    
                  </td>
              </tr>
			</table>
	</div>
	<div align="center" class="greybox mtop15">
		<?php echo $this->Form->create('Coupon', array('url' => array('controller'=>'coupons','action'=>'edit'), 'type' => 'file','name' => 'frm_addedit', 'id' => 'frm_addedit', 'inputDefaults' => array('label' => false, 'div' => false, 'error' => false, 'type'=>'text'))) ?>
			<?php 
				echo $this->Form->input('id', array('type'=>'hidden'));
				echo $this->Form->input('client_id', array('type'=>'hidden')); 
				echo $this->Form->input('no_of_share', array('type'=>'hidden', 'value' => 10)); 
				
			?>
			
			<table cellspacing="0" cellpadding="7" border="0" align="center">
				<tr>
					<td valign="middle"><strong class="upper">Deal</strong></td>
					<td><?php echo $this->Form->input('deal_id', array('class' => 'input required ','type' => 'select', 'empty' => 'select','options' => $deals, 'label'=>false,'div'=>false,'required'=>'required')); ?></td>
				</tr>
				
				<tr>
					<td valign="middle"><strong class="upper">Coupon Code:</strong></td>
					<td><?php echo $this->request->data['Coupon']['coupon_code']; ?></td>
 
				</tr>
				
				<tr>
					<td valign="middle"><strong class="upper">Coupon Title:</strong></td>
					<td><?php echo $this->Form->input('title',array('class' => 'input required', 'style' => "width: 450px;",'label' => false, 'error' => false, 'div' => false, 'style'=>'width: 450px;'));
 ?></td>
 
				</tr>
			
				<tr>
					<td valign="middle"><strong class="upper">Image</strong></td>
					<td valign="middle">
						<div>
						<?php echo $this->Form->input('image', array('class' => 'input', 'type' => 'file', 'label'=>false,'div'=>false)); ?>
						<img src="<?php echo $this->webroot.'img/coupons/M_'.$this->request->data['Coupon']['image']; ?>">
						</div>
					</td>
				</tr>
				<tr>
					<td valign="middle"><strong class="upper">Description:</strong></td>
					<td><?php echo $this->Form->input('description', array('class' => 'input ckeditor', 'label'=>false, 'rows' => 10,'div'=>false,'required'=>'required')); ?></td>
				</tr>
				
				<tr>
					<td valign="middle"><strong class="upper">Valid For (in hours)</strong></td>
					<td><?php 
					$options = array();
					for($i=1;$i<49; $i++)
					{
						$options[$i] = $i;
					}
					echo $this->Form->input('valid_for', array('class' => 'input required ','type' => 'select', 'empty' => 'select','options' => $options, 'label'=>false,'div'=>false,'required'=>'required')); ?></td>
				</tr>
				
				<tr>
					<td valign="middle"><strong class="upper">No. of Share's required</strong></td>
					<td><?php 
								$sh = array();
								for($i = 1; $i<11; $i++)
								{
									$sh[$i] = $i;
								}
					echo $this->Form->input('no_of_share', array('class' => 'input required ','type' => 'select', 'empty' => 'select','options' => $sh, 'label'=>false,'div'=>false,'required'=>'required')); ?></td>
				</tr>
				<tr>
					<td valign="middle"><strong class="upper">Status</strong></td>
					<td><?php echo $this->Form->input('status', array('class' => 'input required ','type' => 'select', 'empty' => 'select','options' => array('Active' => 'Active', 'Inactive'=>'Inactive' ), 'label'=>false,'div'=>false,'required'=>'required')); ?></td>
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
