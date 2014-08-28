<div class="breadcrumb">
			<ul>
				<li class="first"><a href="<?php echo SITE_URL; ?>">home</a></li>
				<li class="last">select gift type</li>                
            </ul>
	</div>
<div class="process">

<a href="javascript://" class="box third stepbox_3" onclick="return nextStep('step-3','meTome');" style="padding-right: 5px;">
<span class="spbox_3"><strong style="text-transform:none;">Self Gift</strong></span>
</a>
<a href="javascript://" class="box stepbox_1" onclick="return nextStep('one_to_one','group_gift');">
<span class="spbox_1"><strong style="text-transform:none;">Group Gift</strong></span>
</a>
<a href="javascript://" class="box second stepbox_2" onclick="return nextStep('one_to_one','one_to_one');">
<span class="spbox_2"><strong style="text-transform:none;">One to One Gift</strong></span>
</a>
</div>
<div class="step_2">
<?php echo $this->Html->image('step2_img.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
</div>
<div class="process_detail">

<div class="inner_detail stepbox_3 spbox_3" onclick="return nextStep('step-3','meTome');">
<h3>Self Gift</h3>
<p><strong>You pay, You Receive</strong><span>Select this option if you are buying the gift voucher for yourself</span>
</div>
<div class="inner_detail stepbox_1 spbox_1" onclick="return nextStep('one_to_one','group_gift');">
<h3>Group Gift</h3>
<p><strong>Multiple Contributors, One Receiver</strong><span>Select this option if you want  multiple people to contribute<br>towards the gift</span>
</div>
<div class="inner_detail stepbox_2 spbox_2" onclick="return nextStep('one_to_one','one_to_one');">
<h3>One to One Gift</h3>
<p><strong>Single Contributor, Single Receiver</strong><span>Select this option if
you are the only one contributing to the gift</span>
</div>
</div>
<div class="action">
<a class="continue"  href="<?php echo SITE_URL; ?>">Previous</a>
</div>

<script type="text/javascript">
$('.stepbox_1').hover(function(){
		$('.spbox_1').addClass('select');
	},function(){
		$('.spbox_1').removeClass('select');
	});
$('.stepbox_2').hover(function(){
		$('.spbox_2').addClass('select');
	},function(){
		$('.spbox_2').removeClass('select');
	});
$('.stepbox_3').hover(function(){
		$('.spbox_3').addClass('select');
	},function(){
		$('.spbox_3').removeClass('select');
	});		
</script>