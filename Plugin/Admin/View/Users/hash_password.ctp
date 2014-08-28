 <?php echo $this->Session->flash('auth'); ?>
 <?php echo $this->Form->create(); ?>
 <?php echo $this->Form->input('password'); ?>
 <?php echo $this->Form->submit('Submit'); ?>
 <?php echo $this->Form->end(); ?>
