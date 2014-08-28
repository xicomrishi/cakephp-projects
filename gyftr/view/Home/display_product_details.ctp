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

<div id="form_section">
	<span class="select_dele">/ / Voucher <strong>Details</strong></span>
	<div class="cms_page_detail" style="margin-bottom:45px;">
		<div class="left_detail">
			<div class="row"><strong>Voucher Type:</strong><span><?php echo $product['BrandProduct']['voucher_type']; ?></span></div>
			<div class="row"><strong>Brand:</strong><span><?php echo $product['BrandProduct']['product_name']; ?></span></div>
			<?php if($product['BrandProduct']['voucher_type']=='VALUE VOUCHER'){ ?>
				<div class="row"><strong>Value:</strong><span><?php echo $product['BrandProduct']['price']; ?></span></div>
                <?php if(isset($discounted_value)){ ?>
                <div class="row"><strong>Value after discount:</strong><span><?php echo $discounted_value; ?></span></div>
                <?php } ?>
			<?php } ?>
			<div class="row"><strong>Voucher:</strong><span><?php echo str_replace("_","'",$product['BrandProduct']['voucher_name']); ?></span></div>
			<div class="row"><strong>Voucher expiry:</strong><span><?php echo $product['BrandProduct']['voucher_expiry']; ?></span></div>
		</div>

		<div class="right_detail"><img src="<?php echo $this->webroot.'files/BrandImage/'.$brand['GiftBrand']['gift_category_id'].'/Product/'.$product['BrandProduct']['product_thumb']; ?>" alt="<?php echo $product['BrandProduct']['voucher_name']; ?>" title="<?php echo $product['BrandProduct']['voucher_name']; ?>" /></div>

<div class="tabbing">
			<ul>
				<li class="active" id="tnc_id"><a href="javascript://" onclick="show_div('terms_conditions_div','outlet_locator_div','tnc_id');">Terms &amp; Conditions</a></li>
				<li class="" id="outlet_id"><a href="javascript://" onclick="show_div('outlet_locator_div','terms_conditions_div','outlet_id');">Outlet Locator</a></li>
			</ul>
</div>

<div class="cms_page_detail">
	<div id="outlet_locator_div" style="display:none; min-height:200px;">
        <form id="dealer_locateForm" name="dealer_locateForm" method="post" action="" onsubmit="return search_dealer();">
            <input type="hidden" name="product_id" value="<?php echo $product['BrandProduct']['id']; ?>"/>
            <label>Outlet Locator</label>
            <?php if(!empty($shops)){ ?>
                <select id="dealer_city" name="dealer_city">
                    <?php foreach($cities as $city){ if(!empty($city)){ ?>
                    <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                    <?php }} ?>
                </select>
                
                <input type="submit" value="Locate" onclick="return search_dealer();"/> 
            <?php }else{ ?>
            	<span>No Outlet's Found!</span>
            <?php } ?>
        </form>
        
     
            <div class="deler_info" style="display:none;"></div>
        
	</div>

	<div id="terms_conditions_div">
    	<h3>Terms &amp; Conditions</h3>
		<div id="about" class="nano" style="width:100%">
			<div class="detail">
				<?php if(!empty($product['BrandProduct']['product_tnc'])) echo "<p>".nl2br($product['BrandProduct']['product_tnc'])."</p>"; else echo '<p style="text-align:center;">No Terms &amp; Conditions found</p>';?>
			</div>
		</div>
	</div>
</div>        
        

<div id="voucherinfoMsg" style="display:none; color:#f00; font-size:12px;">Please accept terms &amp; conditions.</div>
<input type="checkbox" id="check_terms"/>
<label style="color:#3C3C3C; font-size:12px;">I accept the terms &amp; conditions and authorize MyGyFTR (Vouchagram India Pvt. Ltd.) to send me email and sms alerts regarding the gift.</label>
</div>
</div>




<div class="action">
            
            <a href="javascript://"  class="yes" onclick="select_product('<?php echo $product['BrandProduct']['id']; ?>','<?php if(isset($discounted_value)) echo $discounted_value; else echo $product['BrandProduct']['price']; ?>');">Next</a>
            <a href="javascript://"  class="no" onclick="<?php if(isset($basket_empty)) { ?>return nextStep('step-3','<?php echo $this->Session->read('Gifting.type');?>');<?php }else{ echo 'back_to_show_vouchers();'; } ?>">Previous</a>
</div>

<div id="infoMsg"> 
<?php echo $this->Html->image('validate_left_img.png',array('escape'=>false)); ?>
<div class="text">Please accept terms &amp; conditions.</div>
<?php echo $this->Html->image('validate_right_img.png',array('escape'=>false)); ?>
</div>

<script type="text/javascript">
$(document).ready(function(e) {
    $(".nano").nanoScroller({alwaysVisible:true, contentClass:'detail',sliderMaxHeight: 70 });
});

function search_dealer()
{
	var dealer_city=$('#dealer_city').val();
	if(dealer_city!=null)
	{
	$.post('<?php echo SITE_URL; ?>/products/get_dealers',$('#dealer_locateForm').serialize(),function(data){
			$('.deler_info').html(data);
			$('.deler_info').show();
			$(".nano").nanoScroller({alwaysVisible:true, contentClass:'detail',sliderMaxHeight: 70 });
			
		});	
	}
	return false;	
}
function back_to_show_vouchers()
{
	return nextStep('step-3','<?php echo $this->Session->read('Gifting.type');?>');	
}

</script>