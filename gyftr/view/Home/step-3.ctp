<div class="breadcrumb">
			<ul>
				<li class="first"><a href="<?php echo SITE_URL; ?>">home</a></li>
				<li><a href="javascript://" onclick="return nextStep('step-2','start');">select gift type</a></li>
                 <?php if($this->Session->read('Gifting.type')!='me_to_me'){ ?>
				<li><a href="javascript://" onclick="return nextStep('one_to_one','<?php echo $this->Session->read('Gifting.type');?>');">Recipient</a></li>
				<?php } ?>
               
				<li class="last">select gift</li>
               
            </ul>
	</div>

 <div class="step_3">
 <?php echo $this->Html->image('step3_img_new.png',array('escape'=>false,'alt'=>''));?>
</div>

<div class="gift_section">
 
<div class="nano">
<div class="gift_type">
<ul class="types">
<?php foreach($gift_cat as $gc){ ?>
<li onclick="show_brands('<?php echo $gc['GiftCategory']['id'];?>','<?php echo $gc['GiftCategory']['name']; ?>');"><span><?php echo $gc['GiftCategory']['name']; ?></span><a href="javascript://"></a></li>
<?php } ?>
<li class="last" onclick="show_brands('000','All Categories');"><span>Select All</span></li>
</ul>
</div>
</div>
<div class="action">
            
            <a href="javascript://"  class="yes" onclick="<?php if(!$this->Session->check('Gifting.total_basket_value')){ ?>goToStep('gift category');<?php }else{  ?>return select_product('0');<?php } ?>">Next</a>
                <a href="javascript://"  class="no" onclick="<?php if($this->Session->read('Gifting.type')!='me_to_me'){ ?>return nextStep('one_to_one','<?php echo $this->Session->read('Gifting.type');?>');<?php }else{  ?>return nextStep('step-2','start');<?php } ?>">Previous</a>
</div>
</div>
<div id="infoMsg" class="category"> 

</div>
<script type="text/javascript">
$(document).ready(function(e) {
    $(".nano").nanoScroller({alwaysVisible:true, contentClass:'gift_type',sliderMaxHeight: 70 });
});
</script>



