<style>
input[type="radio"] {float: none;}
</style>
<div class="offers form">
<?php echo $this->Form->create('Offer',array('type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Offer'); ?></legend>
        
         <div class="input">
            <label for="PromocodePromoType">Offer on: </label>
            <select id="PromocodePromoType" name="data[Offer][offer_type]" onchange="show_offerinput(this.value);">
            	<option value="1">Brand</option>
                <option value="2">Product</option>                
            </select>
        </div>
         <div class="input">
            <label for="Offer Title">Offer Title: </label>
            <input type="text"  name="data[Offer][title]"  class="validate[required]">
        </div>
        <div class="input">
            <label for="OfferDiscountType">Discount type: </label>
            <input type="radio"  name="data[Offer][discount_type]" value="PureValue"/> Pure Value
            <input type="radio" name="data[Offer][discount_type]" value="Percent"/> Percentage
        </div>
        
            <div class="input promo_div promo_type_2 promo_type_1" >
            <label for="PromocodeBrandCategory">Category: </label>
            <select id="PromocodeBrandCategory" onchange="get_brands(this.value);">
            	<option value="">Select Category</option>
            	<?php foreach($giftcat as $gcat){ ?>						 
                	<option value="<?php echo $gcat['GiftCategory']['id']; ?>"><?php echo $gcat['GiftCategory']['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        
         <div class="input promo_div promo_type_2 promo_type_1">
            <label for="OfferGiftBrandId">Brand: </label>
            <select id="OfferGiftBrandId" name="data[Offer][gift_brand_id]" onchange="get_br_vouchers(this.value,this.options[this.selectedIndex].title);">
            	<option value="">Select Brand</option>
            	<?php foreach($allbrands as $abr){ ?>
                	<option title="<?php echo $abr['GiftBrand']['gift_category_id']; ?>" class="op_cat_<?php echo $abr['GiftBrand']['gift_category_id']; ?> op_cats" value="<?php echo $abr['GiftBrand']['id']; ?>"><?php echo str_replace('_','',$abr['GiftBrand']['name']); ?></option>
                <?php } ?>
            </select>
        </div>
         <div class="input promo_div promo_type_2" style="display:none;">
            <label for="OfferProduct">Voucher: </label>
            <select id="OfferProduct" name="data[Offer][brand_product_id]">
           	<option value="">Select Voucher</option>
            <?php foreach($allproducts as $apr){ ?>
                <option class="op_brand_<?php echo $apr['BrandProduct']['gift_category_id']; ?>_<?php echo $apr['BrandProduct']['gift_brand_id']; ?> op_brand" value="<?php echo $apr['BrandProduct']['id']; ?>"><?php echo str_replace('_','',$apr['BrandProduct']['voucher_name']); ?></option>
            <?php } ?>
            </select>
        </div>
        
          <div class="input">
            <label for="OfferValue">Value: </label>
            <input type="text" id="OfferValue" name="data[Offer][value]" class="validate[required,custom[integer,min[1]]]">
        </div>
        
         <div class="input">
            <label for="OfferStartDate">Start Date: </label>
            <input type="text" id="OfferStartDate" class="datepick" name="data[Offer][start_date]">
        </div>
         <div class="input">
            <label for="OfferEndDate">End Date: </label>
            <input type="text" id="OfferEndDate" class="datepick" name="data[Offer][end_date]">
        </div>
        <div class="input">
            <label for="OfferImage">Image: </label>
            <input type="file" id="OfferImage" name="data[Offer][image]" class="validate[required]">
        </div>
        
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Offers'), array('action' => 'index')); ?></li>
	</ul>
</div>

<script type="text/javascript">
$(document).ready(function(e) {
  $("#OfferAdminAddForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	var to_day=new Date();
    $( ".datepick" ).datepicker({
		defaultDate: "+1d",
		 minDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate(), 0, 0),
		changeMonth: true,
		changeYear: true,
		dateFormat:"yy-mm-dd",
		//numberOfMonths: 3,
		onClose: function( selectedDate ) {
		$( "#OfferEndDate" ).datepicker( "option", "minDate", selectedDate );
		}
	});
		$( ".datepick" ).datepicker({
		//defaultDate: "+1w",
		changeMonth: true,	
		changeYear: true,
		dateFormat:"yy-mm-dd",	
		//numberOfMonths: 3,
		onClose: function( selectedDate ) {
		$( "#OfferStartDate" ).datepicker( "option", "maxDate", selectedDate );
		}
	});	
	
	
});

function show_offerinput(val)
{
	$('.promo_div').hide();	
	$('.promo_type_'+val).show();
	
}

function get_brands(cat_id)
{
	$('#OfferGiftBrandId').val('');
	$('.op_cats').hide();
	$('.op_cat_'+cat_id).show();
		
}

function get_br_vouchers(br_id,cat_id)
{
	//alert(cat_id);
	var type=$('#PromocodePromoType').val();	
	if(type=='2')
	{	
		$('#OfferProduct').val('');	
		$('.op_brand').hide();
		$('.op_brand_'+cat_id+'_'+br_id).show();	
	}	
}
</script>
