<?php if($this->Session->check('Gifting')){ ?>
<div class="breadcrumb">
<ul>
<li class="first"><a href="<?php echo SITE_URL; ?>">HOME</a></li>
<?php if($this->Session->check('Gifting.start')){ ?>
<li><a href="javascript://" onclick="return nextStep('step-2','1');">SELECT GIFT TYPE</a></li>
<?php } ?>
<?php if($this->Session->check('Gifting.type')){ ?>
<li class="<?php if($this->Session->read('current_step')=='select_product'){ echo 'last'; } ?>">SELECT PRODUCT</li>
<?php } ?>
<?php if($this->Session->check('Gifting.select_product')){ ?>
<li class="<?php if($this->Session->read('current_step')=='delivery'){ echo 'last'; }  ?>">Delivery</li>
<?php } ?>
</ul>
</div>
<?php } ?>