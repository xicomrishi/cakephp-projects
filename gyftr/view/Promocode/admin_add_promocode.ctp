<style>
input[type="radio"] {float: none;}
</style>
<?php echo $this->element('promocode_sidebar'); ?>
<div class="users form">
<?php echo $this->Form->create('Promocode',array('type'=>'file','onsubmit' => 'return submitPromoCode();','name'=>'PromocodeAdminAddPromocodeForm'));?>
	<fieldset>
		<legend><?php echo __('Add New Promo Code'); ?></legend>
	
        <div class="input">
            <label for="PromocodePromoType">Promo Code type: </label>
            <select id="PromocodePromoType" name="data[Promocode][promo_type]" onchange="show_promoinput(this.value);">
            	<option value="1">Basket Amount</option>
                <option value="2">Brand</option>
                <option value="3">Voucher</option>
                <option value="4">Transaction Amount</option>
                <option value="5">Season</option>
                <option value="6">Occasion</option>
                <option value="7">New User</option>
                <option value="8">Gifting Type</option>
                <option value="9">On Payment</option>
                <option value="10">General</option>
            </select>
        </div>
        
        <div class="input Distype_div">
            <label for="PromocodeDiscountType">Promo Code type: </label>
            <input type="radio" id="purevalue_radio" name="data[Promocode][discount_type]" value="PureValue"/> Pure Value
            <input type="radio" name="data[Promocode][discount_type]" value="Percent"/> Percentage
        </div>
        
         <div class="input promo_type_10 promo_div"  style="display:none;">
            <label for="PromocodePromoType">Type: </label>
            <select id="PromocodePromoType" name="data[Promocode][general_promo_type]" onchange="show_genericpromo(this.value);">
            	<option value="1">Generate Multiple codes</option>
                <option value="2">Single Generic code</option>
            </select>
        </div>
        
        <div class="input promo_type_1 promo_div">
            <label for="PromocodeBasketAmount">Basket Amount: </label>
            <input type="text" id="PromocodeBasketAmount" name="data[Promocode][basket_amount]"  class="validate[custom[integer]]">
        </div>
         
         <div class="input promo_type_2 promo_type_10 promo_div" style="display:none;">
            <label for="PromocodeBrandCategory">Category: </label>
            <select id="PromocodeBrandCategory" onchange="get_brands(this.value);">
            	<option value="">Select Category</option>
            	<?php $br_done=array(); foreach($brands as $brand){ 
							if(!in_array($brand['GiftCategory']['id'],$br_done))
								{	$br_done[]=$brand['GiftCategory']['id']; ?>
                	<option value="<?php echo $brand['GiftCategory']['id']; ?>"><?php echo $brand['GiftCategory']['name']; ?></option>
                <?php }} ?>
            </select>
        </div>
        
        <div class="input promo_type_2 promo_type_10 promo_div" style="display:none;">
            <label for="PromocodeBrand">Brand: </label>
            <select id="PromocodeBrand" name="data[Promocode][brand_id]">
            	<option value="">Select Brand</option>
            	<?php foreach($brands as $brand){ ?>
                	<option class="op_cat_<?php echo $brand['GiftBrand']['gift_category_id']; ?> op_cats" value="<?php echo $brand['GiftBrand']['id']; ?>"><?php echo str_replace('_','',$brand['GiftBrand']['name']); ?></option>
                <?php } ?>
            </select>
        </div>
        
        
        <div class="input promo_type_10 promo_div multiple_codes">
            <label for="GenericPromoCodenumber">Enter no. of codes to be generated: </label>
            <input type="text" id="GenericPromoCodenumber" name="data[GenericPromoCode][no_of_codes]"  class="validate[custom[integer]]"/>
        </div>
        
        <div class="input promo_type_10 promo_div">
            <label for="GenericPromoCodeqty">Enter Usable Quantity(no. of times code can be used) (Enter '0' if infinite): </label>
            <input type="text" id="GenericPromoCodeqty" name="data[GenericPromoCode][no_of_times]"  class="validate[custom[integer]]"/>
        </div>
        
         <div class="input promo_type_3 promo_div" style="display:none;">
            <label for="PromocodeProduct">Voucher: </label>
            <select id="PromocodeProduct" name="data[Promocode][product_id]">
           	<option value="">Select Voucher</option>
            <?php foreach($products as $prod){ ?>
                <option value="<?php echo $prod['BrandProduct']['product_guid']; ?>"><?php echo str_replace('_','',$prod['BrandProduct']['voucher_name']); ?></option>
            <?php } ?>
            </select>
        </div>
        <div class="input promo_type_4 promo_div" style="display:none;">
            <label for="PromocodeTransactionAmount">Transaction Amount: </label>
            <input id="PromocodeTransactionAmount" type="text" name="data[Promocode][transaction_amount]"  class="validate[custom[integer]]"> 
        </div>
         <div class="input promo_type_5 promo_div" style="display:none;">
            <label for="PromocodeSeason">Season</label>
            <input id="PromocodeSeason" type="text" name="data[Promocode][season]">
        </div>
        <div class="input promo_type_6 promo_div" style="display:none;">
            <label for="PromocodeOccasion">Occasion: </label>
            <input id="PromocodeOccasion" type="text" name="data[Promocode][occasion]">
        </div>
        <div class="input promo_type_8 promo_div" style="display:none;">
            <label for="PromocodeGitingType">Gifting Type: </label>
            <select id="PromocodeGitingType" name="data[Promocode][gifting_type]">
            	<option value="">Select Gifting</option>
                <option value="Me To Me">Self Gift</option>
                <option value="One To One">One to One Gift</option>
                <option value="Group Gift">Group Gift</option>
            </select>
        </div>
               
        <div class="input">
            <label for="PromocodeValue">Discount Value: </label>
            <input type="text" id="PromocodeValue" name="data[Promocode][value]" class="validate[custom[integer]]">
        </div>
        
         <div class="input">
            <label for="PromocodeStartDate">Start Date: </label>
            <input type="text" id="PromocodeStartDate" class="datepick" name="data[Promocode][start_date]">
        </div>
         <div class="input">
            <label for="PromocodeEndDate">End Date: </label>
            <input type="text" id="PromocodeEndDate" class="datepick" name="data[Promocode][end_date]">
        </div>
        
         <div class="input dates_div">
            <label for="PromocodeValidFor">Valid for (in days): </label>
            <input type="text" id="PromocodeValidFor" name="data[Promocode][valid_for]"  class="validate[custom[integer]]">
        </div>
          <div class="input">
            <label for="PromocodeDescription">Description: </label>
            <textarea  id="PromocodeDescription" name="data[Promocode][description]"></textarea>
        </div>
        
        
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>

</div>

<script type="text/javascript">
$(document).ready(function(e) {
  $("#PromocodeAdminAddPromocodeForm").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
	var to_day=new Date();
    $( "#PromocodeStartDate" ).datepicker({
		defaultDate: "+1d",
		 minDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate(), 0, 0),
		changeMonth: true,
		changeYear: true,
		dateFormat:"yy-mm-dd",
		//numberOfMonths: 3,
		onClose: function( selectedDate ) {
		$( "#PromocodeEndDate" ).datepicker( "option", "minDate", selectedDate );
		}
	});
		$( "#PromocodeEndDate" ).datepicker({
		//defaultDate: "+1w",
		changeMonth: true,	
		changeYear: true,
		dateFormat:"yy-mm-dd",	
		//numberOfMonths: 3,
		onClose: function( selectedDate ) {
		$( "#PromocodeStartDate" ).datepicker( "option", "maxDate", selectedDate );
		}
	});	
	
	
});

function show_promoinput(val)
{
	$('.promo_div').hide();	
	$('.promo_type_'+val).show();
	if(val=='10')
	{
		$('.dates_div').hide();	
	}else{
		$('.dates_div').show();
	}
	
	/*if(val=='7')
	{
		$('#purevalue_radio').attr('checked','checked');
		$('.Distype_div').hide();	
	}else{
		$('.Distype_div').show();	
	}*/	
}

function submitPromoCode()
{
	 var valid = $("#PromocodeAdminAddPromocodeForm").validationEngine('validate');
	if(valid){
		document.forms['PromocodeAdminAddPromocodeForm'].submit();
	}else{
		$("#PromocodeAdminAddPromocodeForm").validationEngine({scroll:false,focusFirstField : false});	
	}
	return false;
}

function get_brands(cat_id)
{
	$('.op_cats').hide();
	$('.op_cat_'+cat_id).show();	
}

function show_genericpromo(val)
{
	if(val=='1')
	{
		$('.multiple_codes').show();
		$('.single_generic_code').hide();	
	}else{
		$('.multiple_codes').hide();
		$('.single_generic_code').show();	
	}	
}

</script>
