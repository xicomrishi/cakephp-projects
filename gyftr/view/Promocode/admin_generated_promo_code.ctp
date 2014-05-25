<style>
.addlinkDiv a{ font-size:19px; float:right; }
</style>
<?php echo $this->element('promocode_sidebar'); ?>

<div class="promocodes index">
	<div class="addlinkDiv">
	 <?php echo $this->Html->link(__('Add New Promo code >>'), array('action' => 'add_promocode','admin'=>true ));  ?>
     </div>
     
	<h2><?php if(isset($brand)){ 
	if($promo['Promocode']['discount_type']=='PureValue') $dis=' Rs. '.$promo['Promocode']['value']; else $dis=$promo['Promocode']['value'].'%';
	echo 'Promo Code for '.$brand['GiftBrand']['name'].' - '.$dis.' off'; } ?></h2>
    <?php if(!empty($codes)){ ?>
    <div class="addlinkDiv">
    	<?php echo $this->Html->link(__('Export to Excel'), array('action' => 'export_promo_codes',$promo['Promocode']['id'],'admin'=>true ));  ?>
    </div>
    <?php } ?>
    <table cellpadding="0" cellspacing="0">
    <tr>
    	<td>S.No.</td>	
    	<td>Promo Code</td>
        <td>Valid Till</td>
        
    </tr>
	<?php if(!empty($codes)){ $i=1;
				 foreach($codes as $cd){ ?>
   				 <tr>
                 	<td><?php echo $i; ?></td>
                 	<td><?php echo $cd['GenericPromoCode']['promo_code']; ?></td>
                    <td><?php echo show_formatted_datetime($cd['GenericPromoCode']['end_date']); ?></td>
   				 </tr>
    <?php $i++; }} ?>             
    </table>
   
	
    
</div>