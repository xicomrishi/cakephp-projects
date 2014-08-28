<style>
p{ text-align:justify; color:#3C3C3C;}
.detail_row { padding:10px;}
.detail_row ul{ padding:10px; color:#3C3C3C;}
.comn_box { padding:10px;}
.comn_box h2{ color:#3C3C3C;}
.comn_box span{ color:#3C3C3C;}
</style>
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
<span class="select_dele"><?php echo $content['Cmse']['page_title']; ?></span>

<div class="cms_page_detail">
<?php echo $content['Cmse']['page_content']; ?>



</div>

</div>

</div>
</div>
</div>

<div id="top_row">
<div class="wrapper">
<form id="voucherstatusForm" name="voucherstatusForm" action="" class="status_row" method="post" onsubmit="return check_voucher_status();">
<label>Check your instant gift voucher details</label>
<input type="text" class="input validate[required]" value="" name="voucherid" />
<input type="submit" value="Check Now!" class="check" onclick="return check_voucher_status();">
</form>
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

  