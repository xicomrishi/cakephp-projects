<section class="pop_up">
      <?php echo $this->Html->link($this->Html->image('close_img.png', array('alt' => 'Close', 'border' => '0')),'javascript:disablePopup();' , array('escape' => false, 'class' => 'exit')); ?>

  <span class="title"><?php echo $popTitle;?></span>
  <span class="pop_up_logo"><?php echo $this->Html->image('pop_up_logo.jpg',array('escape'=>false,'alt'=>''));?></span>
  <?php echo $this->fetch('content'); ?>
   </section>
   
   