<div class="breadcrumb">
			<ul>
				<li class="first"><a href="<?php echo SITE_URL; ?>">home</a></li>
				<li><a href="javascript://" onclick="return nextStep('step-2','start');">select gift type</a></li>
                 <?php if($this->Session->read('Gifting.type')!='me_to_me'){ ?>
				<li><a href="javascript://" onclick="return nextStep('one_to_one','<?php echo $this->Session->read('Gifting.type');?>');">Recipient</a></li>
				<?php } ?>
				 <?php //if(!$this->Session->check('Gifting.total_basket_value')){ ?>
				<li class="last">select gift</li>
                <?php //}else{ ?>
               <!-- <li>select product</li>
                <li class="last"><a href="javascript://" onclick="return select_product('0');">BASKET</a></li> -->
                <?php //} ?>
            </ul>
	</div>



<div class="gift_section brand">
<div class="categories_list"> 
<h3><?php echo $cat_name; ?></h3>
<div class="categories_box"><span>Change Category</span><a href="#"></a>
<ul class="categories">
<?php foreach($gift_cat as $gc){ ?>
<li><a href="javascript://" onclick="show_brands('<?php echo $gc['GiftCategory']['id'].'_'.$gc['GiftCategory']['name']; ?>','0');"><?php echo $gc['GiftCategory']['name']; ?></a></li>
<?php } ?>
<li><a href="javascript://" onclick="show_brands('000','All Categories');">Select All</a></li>
</ul>
</div>

<div class="selected_brand" style="display:none;">
</div>

<div id="about" class="nano">
<ul id="cat_brand" class="products">
<?php 
$alreadygb=array();
foreach($gift_brand as $gb){  
if(!in_array($gb['GiftBrand']['name'],$alreadygb)){
?>
<li class="brands_images" id="gb_<?php echo $gb['GiftBrand']['id']; ?>"><a href="javascript://" onclick="show_vouchers('<?php echo $gb['GiftBrand']['id']; ?>','<?php echo $gb['GiftBrand']['name']; ?>','<?php echo $gb['GiftBrand']['gift_category_id']; ?>','<?php echo $gb['GiftBrand']['thumb']; ?>');"><img src="<?php echo $this->webroot.'files/BrandImage/'.$gb['GiftBrand']['gift_category_id'].'/'.$gb['GiftBrand']['thumb']; ?>" alt="<?php echo $gb['GiftBrand']['name']; ?>" title="<?php echo str_replace("_","'",$gb['GiftBrand']['name']); ?>">
</a></li>

<?php
$alreadygb[]=$gb['GiftBrand']['name'];
 }} ?>
</ul>
</div>
</div>
</div>


<div class="right_section step_3 brand">
 <?php echo $this->Html->image('step3_img_new1.jpg',array('escape'=>false,'alt'=>''));?>
</div>
<div class="action">
            
            <a href="javascript://"  class="yes" onclick="<?php if(!$this->Session->check('Gifting.total_basket_value')){  ?>goToStep('brand/product'); <?php }else{ ?>return select_product('0');<?php } ?>">Next</a>
                <a href="javascript://"  class="no" onclick="return nextStep('step-3','<?php echo $this->Session->read('Gifting.type');?>');">Previous</a>
</div>

<div id="infoMsg"> 

</div>
<script type="text/javascript">
$(document).ready(function(e) {
    setTimeout(function(){ $(".nano").nanoScroller({alwaysVisible:true, contentClass:'products',sliderMaxHeight: 70 });},1500);
});

function show_vouchers(id,name,cat_id,thumb)
{
	$.post(site_url+'/home/get_brand_products/'+id+'/'+name+'/'+cat_id,function(data){	
		//$('.gift_range').hide("slide", { direction: "left" },1000);
		$('.selected_brand').html('<img src="<?php echo $this->webroot.'files/BrandImage/'; ?>'+cat_id+'<?php echo  '/'; ?>'+thumb+'" alt="'+name+'" title="'+name+'"><span class="select_arr"></span>');	
		$('.brands_images').show();
		$('#gb_'+id).hide();
		
		$('.selected_brand').show(200);	
		$('.right_section').removeClass('step_3 brand');
		$('.right_section').addClass('brand_description');
		$('.right_section').html(data);
		$(".nano").nanoScroller({alwaysVisible:true, contentClass:'products',sliderMaxHeight: 70 });
		//$('.gift_range').show("slide", { direction: "right" },1000);		
	});		
}
</script>