<?php
	echo $this->Html->css('jquery.fancybox');
	echo $this->Html->script(array('fancybox/source/jquery.fancybox'));		
?>
<h1>User Website Slider</h1>
<div class="row mtop15">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr valign="top">
		  <td align="left" class="searchbox">			
			<div class="floatright top5">
				<?php echo $this->Html->link('<span>Add New Image</span>', array('controller' => 'users', 'action' => 'slider_image_add',$user_id, 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false));  ?>
				<?php if($this->Session->read('Auth.User.id') == 1) { ?>
					<?php echo $this->Html->link('<span>Manage users</span>', array('controller' => 'users', 'action' => 'index', 'plugin' => 'admin'), array('class' => 'black_btn', 'escape' => false)); ?>
				<?php } ?>
			</div>
		  </td>
	  </tr>
	</table>
</div>

	<div class="row mtop30">
		<?php echo $this->Form->create(array('url' => '/admin/users/slide', 'type' => 'post'));  ?>
			<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="listing">
				  <tr>
					<th width="4%" align="center">S No.</th>
					<th width="38%" align="left"><?php echo $this->Paginator->sort('Image'); ?></th>
					<th width="30%" align="left"><?php echo  $this->Paginator->sort('Text'); ?></th>
					<th width="30%" align="left"> Actions </th>
					
					<th width="5%" align="center"><input type="checkbox" onclick="checkall(this.form)" value="check_all" id="check_all" name="check_all"></th>
			  </tr>
			  <?php if(!empty($records)) { $i=1; ?>
				  <?php	 foreach($records as $record) { ?>
					 <tr>
						<td align="center"><?php echo  $i; $i++;?></td>
						<td align="left">
							<span class="blue">
								
								<?php 
										if(!empty($record['AdminClientSlider']['image']) && file_exists(SLIDER.LARGESLIDER.$record['AdminClientSlider']['image']))
										{
											
												echo $this->Html->image(SLIDERURL.LARGESLIDER.$record['AdminClientSlider']['image'], array('width'=>200, 'height'=>100));
										
											
										}
										else {
											echo $this->Html->image('no_image_available_small.png');
										}
								?>
							</span>
						</td>
						<td align="left">
							<?php echo $this->Text->truncate(strip_tags($record['AdminClientSlider']['text']), 100, array( 'html'=>false)); ?>
						</td>
						<td align="left">
							<?php echo $this->Html->link($this->Html->image('/admin/images/edit_icon.gif'), array('controller' => 'users', 'action' => 'slider_image_edit', $record['AdminClientSlider']['id']), array('escape' => false, 'title' => 'Edit Slider')); ?>
							<a href="javascript://" onclick="open_slider('<?php echo $this->webroot.'admin/users/slider_crop_image/'.$record['AdminClientSlider']['id']; ?>');">View and Crop</a>
							<?php //echo $this->Html->link('View and Crop', array('controller'=>'users', 'action'=>'slider_crop_image', $record['AdminClientSlider']['id']), array('rel'=>'popup')); ?>
							<?php echo $this->Html->link($this->Html->image('delete_icon.gif'), array('controller'=>'users', 'action'=>'slider_delete', $record['AdminClientSlider']['id']), array('escape' => false, 'title' => 'Delete Slider'), "Are you sure you wish to delete the Slider?"); ?>
						</td>
						<td valign="middle" align="center">
							<input type="checkbox" value="<?php echo $record['AdminClientSlider']['id']; ?>" name="ids[]">
						</td>
					  </tr>
				 <?php } ?>
				<tr align="right">
					<td colspan="7" align="left" class="bordernone">
						<div class="floatleft mtop7">
							<div class="pagination">
								<?php echo $this->Paginator->prev(); ?><?php echo $this->Paginator->numbers(); ?><?php echo $this->Paginator->next(); ?>
							</div>
						</div>
					<?php /*
						<div class="floatright">
							<div class="floatleft">
							<select name="option"  class="select">
								<option value="">Select Option</option>
								<option value="delete">Delete</option>
							</select>
						</div>
						<div class="floatleft mleft10">
							<div class="black_btn2">
								<span class="upper">
									<input type="submit" value="SUBMIT" name="">
								</span>
							</div>
						</div>
						*/ ?>
						</div>                 
					</td>
				</tr>
				<?php } else { ?>
					<tr>
						<td colspan="5">
							No record found
						</td>
					</tr>
				<?php } ?>
			</table>
		</form>
	</div>

<script type="text/javascript">
	function open_slider(url)
	{
		$.fancybox.open({
			'type' : 'ajax',
			'href' : url,
	});
	}
</script>