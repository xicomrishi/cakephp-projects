<style>
.addlinkDiv a{ font-size:19px; float:right; }
</style>
<?php echo $this->element('promocode_sidebar'); ?>

<div class="promocodes index">
	<div class="addlinkDiv">
	 <?php echo $this->Html->link(__('Add New Promo code >>'), array('action' => 'add_promocode','admin'=>true ));  ?>
     </div>
	<h2><?php echo __('Promo Codes of type: '.$promo_name); ?></h2>
   
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th align="left"><?php echo $this->Paginator->sort('id','ID');?></th>
			<th><?php echo $this->Paginator->sort('discount_type');?></th>
			<th><?php echo $this->Paginator->sort('value');?></th>
            <?php if($promo_type==10){ ?>
            	<th><?php echo 'Brand';?></th>
            <?php } ?>
		<?php if($promo_type==1) $pg='basket_amount'; if($promo_type==2) $pg='brand_id'; if($promo_type==3) $pg='product_id'; if($promo_type==4) $pg='transaction_amount'; if($promo_type==5) $pg='season'; if($promo_type==6) $pg='occasion'; if($promo_type==8) $pg='Gifting Type'; if($promo_type==9) $pg='On Payment'; 
		if($promo_type!=7&&$promo_type!=9&&$promo_type!=10){ ?>  		 		      
            <th><?php echo $this->Paginator->sort($pg);?></th>
         <?php } ?>
            <th><?php echo $this->Paginator->sort('start_date');?></th>
            <?php if($promo_type!=10){ ?>
				<th><?php echo $this->Paginator->sort('end_date');?></th>
                
            <?php } ?>
            <th><?php if($promo_type==10) echo $this->Paginator->sort('end_date','Valid Till'); else echo $this->Paginator->sort('valid_for','Valid for(in days)'); ?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
    <?php
	
	$i = 0;
	foreach ($promo as $pr):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
   <tr <?php echo $class;?>>
		<td><?php echo $pr['Promocode']['id']; ?></td>
		<td><?php echo $pr['Promocode']['discount_type']; ?></td>
		<td><?php echo $pr['Promocode']['value']; ?></td>
          <?php if($promo_type==10){ ?>
            	<td><?php echo $pr['GiftBrand']['name'];?></td>
            <?php } ?>
        
        <?php if($promo_type==1) $pgs=$pr['Promocode']['basket_amount']; if($promo_type==2) $pgs=$pr['GiftBrand']['name']; if($promo_type==3) $pgs=$pr['BrandProduct']['voucher_name']; if($promo_type==4) $pgs=$pr['Promocode']['transaction_amount']; if($promo_type==5) $pgs=$pr['Promocode']['season']; if($promo_type==6) $pgs=$pr['Promocode']['occasion']; if($promo_type==8) $pgs=$pr['Promocode']['gifting_type'];
		if($promo_type!=7&&$promo_type!=9&&$promo_type!=10){ ?>  
		<td><?php echo $pgs; ?></td>
        <?php } ?>
        <td><?php echo show_formatted_date($pr['Promocode']['start_date']); ?></td>
        <?php if($promo_type!=10){ ?>
			<td><?php echo show_formatted_date($pr['Promocode']['end_date']); ?></td>
        <?php } ?>
        <td><?php if($pr['Promocode']['promo_type']==10) echo show_formatted_date($pr['Promocode']['end_date']); else echo $pr['Promocode']['valid_for']; ?></td>
				
		<td class="actions">
		<?php 
		if($promo_type!=10)
		{
			if($pr['Promocode']['status']=='Active')	
				echo $this->Html->link(__('Deactivate', true), array('action' => 'status_promocode', $pr['Promocode']['id'],'Inactive')); 
			else 
			    echo $this->Html->link(__('Activate', true), array('action' => 'status_promocode', $pr['Promocode']['id'],'Active'));	
		}
			echo $this->Html->link(__('Delete'), array('controller'=>'promocode','action' => 'delete_promocode', $pr['Promocode']['id']), null, sprintf(__('Are you sure you want to delete this Promo Code?', true), $pr['Promocode']['id']));
			
			if($promo_type==10)
			{
				echo $this->Html->link(__('View Promo Code(s)', true), array('action' => 'generated_promo_code', $pr['Promocode']['id'],'admin'=>true));	
			}
				
				?>
			<?php  ?>
			
		</td>
		</tr>				
<?php endforeach; ?>
	</table>
    <div class="paging">
     <?php echo $this->Paginator->prev('<< ' . __('previous', true), null, null, array('class'=>'disabled'));?>
	 <?php echo $this->Paginator->numbers(array('separator'=>'','currentTag'=>'','tag'=>'span','rel'=>'next'));?>
 	 <?php echo $this->Paginator->next(__('next', true) . ' >>', null, null, array('class' => 'disabled'));?>
   </div>
</div>