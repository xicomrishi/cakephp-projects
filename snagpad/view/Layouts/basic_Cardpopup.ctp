<!--[if IE]><?php echo $this->Html->script('ieh5fix');?><![endif]--> 
<section class="submit_box">
      <?php echo $this->Html->link($this->Html->image('close_img.png', array('alt' => 'Close', 'border' => '0')),'javascript:disablePopup();' , array('escape' => false, 'class' => 'exit')); ?>
  
  <?php echo $this->fetch('content'); ?>
   </section>
   
   