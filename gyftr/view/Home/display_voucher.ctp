<div class="step_3_2">
<?php echo $this->Html->image('step3_img1.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
</div>
<div class="gift_section">
<?php //echo $this->element('breadcrumb');?>
<div class="breadcrumb">
			<ul>
				<li class="first"><a href="<?php echo SITE_URL; ?>">home</a></li>
				<li><a href="javascript://" onclick="return nextStep('step-2','start');">select gift type</a></li>
                <?php if($this->Session->read('Gifting.type')!='me_to_me'){ ?>
				<li><a href="javascript://" onclick="return nextStep('one_to_one','group_gift');">select a friend</a></li>
				<?php } ?>
				<li class="last">select product</li>
            </ul>
	</div>
<div id="infoMsg">
</div>     
<div class="selected_product">
<img src="<?php echo $product['pimage']; ?>" alt="<?php echo $product['pname']; ?>" height="84" width="183"/>
<?php //echo $this->Html->image('Voucher/thumb/'.$voucher['Voucher']['thumb'],array('escape'=>false,'alt'=>'','div'=>false)); ?> </div>


<div class="voucher_detail">
<h3>Voucher Name</h3>
<p><?php echo $product['vname']; ?></p>
<h3>Voucher Type</h3>
<p><?php echo $product['vtype']; ?></p>
<h3>Price</h3>
<p><?php echo $product['price']; ?></p>
<h3><a href="<?php echo SITE_URL; ?>/Terms-Conditions/<?php echo $voucher['Product']['product_id']; ?>" target="_blank">Click Here To Locate Dealer</a></h3>
<div id="about" class="nano">
<div class="terms">
<strong>Terms and Conditions</strong>
<span><?php echo $voucher['Voucherinfo']['terms']; ?></span>
</div>
</div>
</div>
<div class="check">
<input type="checkbox" id="tnc_check" />
<label>I accept terms &amp; conditions.</label>
</div>

            <div class="action">
            
            <a href="javascript://"  class="yes" onclick="return nextStep('step-3','meTome');">Prev</a>
                <a href="javascript://"  class="no" onclick="check_tnc();">Next</a>
            </div>

</div>
<script type="text/javascript">
$(document).ready(function(e) {
     $(".nano").nanoScroller({alwaysVisible:true, contentClass:'terms',sliderMaxHeight: 70 });
});

function check_tnc()
{
	if($('#tnc_check').attr('checked'))
	{
		voucherStep('get_delivery','<?php echo $vouch_id; ?>');	
	}else{
		$('#infoMsg').html('Please accept terms and conditions.');
		$("html, body").animate({ scrollTop: 0 }, 600);
		$('#infoMsg').show();
		setTimeout(function(){ $('#infoMsg').fadeOut(500);},6000);	
	}	
} 

</script>