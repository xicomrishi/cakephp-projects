<?php echo $this->Html->css('jquery.tooltip');
 echo $this->Html->script(array('jquery.tooltip.pack')); ?>

 <!--[if IE]><?php echo $this->Html->script('ieh5fix');?></script><![endif]--> 
<section class="pop_up final_box">
      <?php echo $this->Html->link($this->Html->image('close_img.png', array('alt' => 'Close', 'border' => '0')),'javascript:disablePopup();' , array('escape' => false, 'class' => 'exit')); ?>
  
  <?php echo $this->fetch('content'); ?>
   </section>
   
   