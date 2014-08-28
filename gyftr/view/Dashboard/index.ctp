<div id="form_section">
		<?php //echo $this->element('breadcrumb');?>
		<div class="breadcrumb">
			<ul>
				<li class="first"><a href="<?php echo SITE_URL; ?>">Dashboard</a></li>
				
			</ul>
			</div>
            <span class="select_dele"><strong>All Gifts</strong>
            </span>
            <form action="">
			<?php 
			if(!empty($data)){
			foreach($data as $dat){ ?> 
            <div class="comn_box gift">
            <div class="main_heading"><span><strong>Recipient: </strong><?php echo $dat['order']['Order']['to_name']; ?></span>
            	<a class="edit" href="javascript://" onclick="view_order_details('<?php echo $dat['order']['Order']['id']; ?>');">View</a>
            </div>
            <div class="detail_row">
            <label>Gift created on:</label>
            <span class="detail"><?php echo show_formatted_datetime($dat['order']['Order']['created']); ?></span>
            </div>        
            <div class="detail_row">
            <label>Price:</label>
            <span class="detail"><?php echo $dat['order']['Order']['total_amount']; ?></span>
            </div>
            <div class="detail_row last">
            <label>Occasion: </label>
          	 <span class="detail"><?php echo $dat['order']['Order']['occasion']; ?></span>
            </div>
             <div class="detail_row last">
            <label>Gift Status: </label>
          	 <span class="detail"><?php if($dat['order']['Order']['status']==0){ echo 'In Progress'; }else if($dat['order']['Order']['status']==1){ echo 'Delivered'; }else if($dat['order']['Order']['status']==3){ echo 'Expired'; }else{ echo 'Pending'; }?></span>
            </div>
            </div>
           
             <?php }}else{ ?>
             <div class="detail_row" style="width:100%; height:200px;">
            <div  style="margin-top:100px; text-align:center;">No Records Found!</div>
           
            </div>
            <?php } ?>
        
        
            </form>
             <div class="bottom">
            	<span class="left_img">
               	 <?php echo $this->Html->image('form_left_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
                <span class="right_img">
                <?php echo $this->Html->image('form_right_bg.png',array('escape'=>false,'alt'=>'','div'=>false)); ?>
                </span>
            </div>
     </div>        
           
       
       