
  <section class="social_singin_row">
    <?php echo $this->Html->link($this->Html->image('facebook_btn.png', array('alt' => 'Facebook Login', 'border' => '0')), 'javascript:myfunc();', array('escape' => false, 'class' => 'facebook_btn')); ?>
  <?php echo $this->Html->link($this->Html->image('linkedin_btn.png', array('alt' => 'Linkedin Login', 'border' => '0')), array('controller'=>'linkedin','action'=>'auth'), array('escape' => false, 'class' => 'linkedin_btn')); ?>
  </section>
  