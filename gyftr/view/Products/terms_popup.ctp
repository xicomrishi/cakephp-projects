<div id="form_section">
<span class="select_dele">/ / TnC &amp; Outlet Locator - <strong><?php echo str_replace("_","'",$product['BrandProduct']['product_name']); ?></strong><a href="javascript://" class="edit" onclick="go_to_buy();">Buy Now</a></span>


<div class="tabbing">
			<ul>
				<li class="<?php if(!isset($is_loc)){ ?>active<?php } ?>" id="tnc_id"><a href="javascript://" onclick="show_div('terms_conditions_div','outlet_locator_div','tnc_id');">Terms &amp; Conditions</a></li>
				<li class="<?php if(isset($is_loc)){ ?>active<?php } ?>" id="outlet_id"><a href="javascript://" onclick="show_div('outlet_locator_div','terms_conditions_div','outlet_id');">Outlet Locator</a></li>
			</ul>
</div>

<div class="cms_page_detail">
	<div id="outlet_locator_div" <?php if(!isset($is_loc)){ ?> style="display:none; min-height:200px;"<?php } ?>>
	<form id="dealer_locateForm" name="dealer_locateForm" method="post" action="" onsubmit="return search_dealer();">
		<input type="hidden" name="product_id" value="<?php echo $product['BrandProduct']['id']; ?>"/>
		<label>Outlet Locater</label>
		<?php if(!empty($cities)){ ?>
			<select name="dealer_city">
			<?php foreach($cities as $city){ if(!empty($city)){ ?>
				<option value="<?php echo $city; ?>" <?php if(isset($is_loc)){ if($is_loc==$city){ echo 'selected'; }}?>><?php echo $city; ?></option>
			<?php }} ?>
			</select>

		<input type="submit" value="Locate"/> 
		<?php }else{ ?>
		<span>No Outlet's Found!</span>
		<?php } ?>
	</form>
    
        
            <div class="deler_info"  style="display:none;"></div>
        
	</div>

	<div id="terms_conditions_div" <?php if(isset($is_loc)){ ?> style="display:none;"<?php } ?>>
    	<h3>Terms &amp; Conditions</h3>
		<div id="about" class="nano" style="width:100%">
			<div class="detail">
				<?php if(!empty($product['BrandProduct']['product_tnc'])) echo "<p>".nl2br($product['BrandProduct']['product_tnc'])."</p>"; else echo '<p style="text-align:center;">No Terms &amp; Conditions found</p>';?>
			</div>
		</div>
	</div>
</div>

<div class="bottom">
            	<span class="left_img">
               	 <?php echo $this->Html->image('form_left_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
                <span class="right_img">
                <?php echo $this->Html->image('form_right_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
            </div>

</div>
<script type="text/javascript">
$(document).ready(function(e) {
   
	<?php if(isset($is_loc)){ ?>
		search_dealer();
	<?php } ?>
	 $(".nano").nanoScroller({alwaysVisible:true, contentClass:'detail',sliderMaxHeight: 70 });
});

function search_dealer()
{
	$.post('<?php echo SITE_URL; ?>/products/get_dealers',$('#dealer_locateForm').serialize(),function(data){
			$('.deler_info').html(data);
			$('.deler_info').show();
			$(".nano").nanoScroller({alwaysVisible:true, contentClass:'detail',sliderMaxHeight: 70 });
			
		});	
	return false;	
}
</script>