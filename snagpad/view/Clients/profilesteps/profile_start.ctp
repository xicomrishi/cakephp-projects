<?php //echo $this->Html->script('cufon');?>

<section class="head_row">
  <p class="full">Increase your chances of landing the interview.  Before you apply, strategize by following these steps:</p>
  </section>
  <section class="pop_up_detail border pad0">
  <ul class="step_row">
  <li><div class="box"><h3 style="color:#06F">1</h3><p>Snag job postings and turn them into Job Cards™ </p><a title="<?php echo $tip['0']['Profiletooltip']['value']; ?>" ><?php echo $this->Html->image('ico_information.png',array('escape'=>false,'alt'=>'info'));?></a></div></li>
  <li><?php echo $this->Html->image('step_row_arrow.jpg',array('escape'=>false)); ?></li>
  <li><div class="box"><h3>2</h3><p>Follow strategies to increase your odds of getting an interview </p><a title="<?php echo $tip['1']['Profiletooltip']['value']; ?>" ><?php echo $this->Html->image('ico_information.png',array('escape'=>false,'alt'=>'info'));?></a></div></li>
  <li><?php echo $this->Html->image('step_row_arrow.jpg',array('escape'=>false)); ?></li>
  <li><div class="box"><h3>3</h3><p>Apply to the job </p><a title="<?php echo $tip['2']['Profiletooltip']['value']; ?>" ><?php echo $this->Html->image('ico_information.png',array('escape'=>false,'alt'=>'info'));?></a></div></li>
  <li><?php echo $this->Html->image('step_row_arrow.jpg',array('escape'=>false)); ?></li>
  <li><div class="box"><h3>4</h3><p>Manage job opportunities on your Pad </p><a title="<?php echo $tip['3']['Profiletooltip']['value']; ?>" ><?php echo $this->Html->image('ico_information.png',array('escape'=>false,'alt'=>'info'));?></a></div></li>
  </ul>
  </section>
  <span class="step_btn"><a href="javascript://" onclick="load_profile();">Setup your SnagPad now!</a></span>
  
<script language="javascript">

    //$('.box a').tooltip();


function load_profile()
{
	//alert(1);
	disablePopup();
	loadPopup('<?php echo SITE_URL;?>/clients/profile_start_step1');	
}

</script>  