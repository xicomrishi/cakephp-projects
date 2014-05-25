<?php echo $this->Html->css(array('brandfonts')); ?>
<div id="form_section">
		
            <span class="select_dele">/ / Voucher <strong>Details</strong>
            </span>
            <?php if(!isset($not_found)){ ?>
            <form action="#" style="width:98%;margin:2% 4% 0 0">
                       
            <div class="comn_box gift">
            <div class="detail_row">
            <label>Voucher Number:</label>
            <span class="detail"><?php echo $data->VoucherNumber; ?></span>
            </div>        
            <div class="detail_row">
            <label>Type of Voucher:</label>
            <span class="detail"><?php echo $data->VoucherType; ?></span>
            </div>
             <div class="detail_row">
            <label>Brand Name:</label>
            <span class="detail"><?php echo $brand['GiftBrand']['name']; ?></span>
            </div>
            <div class="detail_row">
            <label><?php if(strtoupper($data->VoucherType)=='VALUE VOUCHER') echo 'Value: '; else echo 'Product Name: '; ?></label>
              <span class="detail"><?php if(strtoupper($data->VoucherType)=='VALUE VOUCHER') echo $data->Value; else echo $data->ProductName; ?></span>
            </div>
			 <div class="detail_row">
            <label><?php echo 'Valid Status: '; ?></label>
              <span class="detail"><?php echo $data->Status; ?></span>
            </div>
            <?php if(strtoupper($data->Status)=='VALID'){ ?>
            <div class="detail_row">
            <label>Valid Till: </label>
              <span class="detail"><?php echo $data->DurationEndDate; ?></span>
            </div>
            <?php }elseif(strtoupper($data->Status)=='CONSUMED'){ ?>
            <div class="detail_row">
            <label>Consumed Date: </label>
              <span class="detail"><?php echo $data->LastConsumedDate; ?></span>
            </div>
            <div class="detail_row">
            <label>Consumed at Shop: </label>
              <span class="detail"><?php echo $data->LastConsumedShopname; ?></span>
            </div>
			<?php }elseif(strtoupper($data->Status)=='EXPIRED'){ ?>
            <div class="detail_row">
            <label>Valid Till: </label>
              <span class="detail"><?php echo $data->DurationEndDate; ?></span>
            </div>
            <?php } ?>       
            </div>
                       </form>
            <!--<form id="dealer_locateForm" name="dealer_locateForm" method="post" action="" style="width:35%; padding:0 0 0 5%; margin:2% 0 0 0; border-left:2px solid #F87400; min-height:200px">

<label>Outlet Locater</label>

<select id="dealer_city_val" name="dealer_city" style="width:65%">
<?php foreach($cities as $city){ if(!empty($city)){ ?>
<option value="<?php echo $city; ?>"><?php echo $city; ?></option>
<?php }} ?>
</select>

<input type="submit" value="Locate" onclick="return show_this_tnc('<?php echo $data->ProductName; ?>','<?php echo $data->VoucherType; ?>','<?php echo $data->Value; ?>','1');" style="width:30%"/> 
<div class="term_cond">Click to view <a href="javascript://" onclick="show_this_tnc('<?php echo $data->ProductName; ?>','<?php echo $data->VoucherType; ?>','<?php echo $data->Value; ?>','2');">Terms &amp; Conditions</a></div>


</form>-->
            
            <?php }else{ ?>
            <div class="detail_row" style="width:100%; height:200px;">
            <div class="records" style="margin-top:100px; text-align:center;">No Records Found!</div>
           
            </div>
            <?php } ?>

            
       </div>
       
<script type="text/javascript">
function show_this_tnc(pname,vtype,value,num)
{
	var loc=null;
	if(num=='1')
	{
		loc=$('#dealer_city_val').val();	
	}
	showLoading('#banner');
	$.post(site_url+'/products/get_terms_for_voucher',{pname:pname,vtype:vtype,value:value,loc:loc},function(data){
			$('#banner').html(data);
		});
	return false;		
}

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
       