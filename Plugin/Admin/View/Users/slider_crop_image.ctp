<?php
	
	echo $this->Html->css(array('jcrop/jquery.Jcrop'));
	echo $this->Html->script(array('jcrop/js/jquery.Jcrop'));		
?>
<script>
	$(document).ready(function(){
	 var jcrop_api;
		
		$('#target').Jcrop({
			  onChange:   showCoords,
			  onSelect:   showCoords,
			  onRelease:  clearCoords,
			 // minSize: [370,150],
			  aspectRatio: 740/300
	
			},function(){
			  jcrop_api = this;
			});
	
	

		$('#coords').on('change','input',function(e){
		  var x1 = $('#x1').val(),
			  x2 = $('#x2').val(),
			  y1 = $('#y1').val(),
			  y2 = $('#y2').val();
		  jcrop_api.setSelect([x1,y1,x2,y2]);
		});
	});
	
  function showCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function clearCoords()
  {
    $('#coords input').val('');
  };
 
</script>
<div class="users row">
	
	
    <div>
		<?php echo $this->Html->image(SLIDERURL.$slider_Data['AdminClientSlider']['image'], array('id'=>'target'));?>
    </div>
    
    <?php echo $this->Form->create('Slider', array('id'=>'cropImage')); ?>
		<div id="coordinate_input">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
		</div>
		<input type="hidden" id="source_file" name="source_file" value="<?php echo $slider_Data['AdminClientSlider']['image'];?>"/>	
		<input type="hidden" id="user_id" name="user_id" value="<?php echo $slider_Data['AdminClientSlider']['user_id'];?>"/>		
		<input id="crop_save" name="save" type="submit" value="Save" class="blueBtn" />
	<?php echo $this->Form->end(); ?>
</div>

