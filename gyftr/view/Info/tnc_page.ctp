<div id="social_row">
<button class="social_bar btn-navbar" type="button">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<ul id="social_icon">

<li><a href="https://www.facebook.com/mygyftr" target="_blank" ><?php echo $this->Html->image('fb_icon.png',array('alt'=>'fb','escape'=>false,'div'=>false));?></a></li>
<!--<li style="padding-right:4px;"><a href="#" ><?php echo $this->Html->image('tw_icon.png',array('alt'=>'','escape'=>false,'div'=>false));?></a></li>-->
</ul>
<ul class="login_sec">
<li><a href="<?php echo SITE_URL; ?>">Register</a></li>
<li><a href="<?php echo SITE_URL; ?>" class="color">Login</a></li>
</ul>
</div>

<div id="header">
<div class="wrapper">
<a class="logo" href="<?php echo SITE_URL; ?>"><?php echo $this->Html->image('logo.jpg',array('alt'=>'mygyftr','escape'=>false,'div'=>false));?></a>
</div>
</div>

<div id="banner_container" class="">
<div class="wrapper">
<div id="banner">
<div id="form_section">
<span class="select_dele">/ / TnC <?php if($brand!='Domino_s Pizza Online'){ ?>&amp; Outlet Locator<?php } ?> - <strong><?php echo str_replace("_","'",$product['BrandProduct']['product_name']); ?></strong><a href="javascript://" class="edit" onclick="go_to_buy();">Buy Now</a></span>

<?php if($brand!='Domino_s Pizza Online'){ ?>
<div class="tabbing">
			<ul>
            
				<li class="active" id="tnc_id"><a href="javascript://" onclick="show_div('terms_conditions_div','outlet_locator_div','tnc_id');">Terms &amp; Conditions</a></li>
                
				<li class="" id="outlet_id"><a href="javascript://" onclick="show_div('outlet_locator_div','terms_conditions_div','outlet_id');">Outlet Locator</a></li>
			</ul>
</div>
<?php } ?>

<div class="cms_page_detail">
	<div id="outlet_locator_div" style="display:none; min-height:200px;">
	<form id="dealer_locateForm" name="dealer_locateForm" method="post" action="" onsubmit="return search_dealer();">
		<input type="hidden" name="product_id" value="<?php echo $product['BrandProduct']['id']; ?>"/>
		<label>Outlet Locater</label>
		<?php if(!empty($cities)){ ?>
			<select name="dealer_city">
			<?php foreach($cities as $city){ if(!empty($city)){ ?>
				<option value="<?php echo $city; ?>"><?php echo $city; ?></option>
			<?php }} ?>
			</select>

		<input type="submit" value="Locate" onclick="return search_dealer();"/> 
		<?php }else{ ?>
		<span>No Dealers Found!</span>
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

<div class="bottom">
            	<span class="left_img">
               	 <?php echo $this->Html->image('form_left_bg.png',array('escape'=>false,'alt'=>'Group Gifting','div'=>false)); ?>
                </span>
                <span class="right_img">
                <?php echo $this->Html->image('form_right_bg.png',array('escape'=>false,'alt'=>'Instant Gifting','div'=>false)); ?>
                </span>
            </div>

</div>

</div>
</div>
</div>
</div>

<div id="top_row" style="display:none;">
<div class="wrapper">

</div>
</div>
<?php echo $this->element('bottom_content_home'); ?>

<script type="text/javascript">
$(document).ready(function(e) {
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

  