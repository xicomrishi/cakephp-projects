   
            <form action="">
			<?php if(!empty($data)){
				foreach($data as $dat){ ?> 
            <div class="comn_box gift">
            <div class="main_heading"><span><strong>Recipient: </strong><?php echo $dat['order']['Order']['to_name']; ?></span>
            	<a class="edit" href="javascript://" onclick="view_order_details('<?php echo $dat['order']['Order']['id']; ?>');">View</a>
            </div>
            <div class="detail_row">
            <label>Gift created by:</label>
            <span class="detail"><?php echo $dat['order']['Order']['from_name']; ?></span>
            </div>
            
            <div class="detail_row">
            <label>Gift created on:</label>
            <span class="detail"><?php echo show_formatted_datetime($dat['order']['Order']['created']); ?></span>
            </div>        
            <div class="detail_row">
            <label>Price:</label>
            <span class="detail"><?php echo $dat['order']['Order']['total_amount']; ?></span>
            </div>
            <div class="detail_row">
            <label>Occasion: </label>
          	 <span class="detail"><?php echo $dat['order']['Order']['occasion']; ?></span>
            </div>
             <div class="detail_row">
            <label>Gift Status: </label>
          	 <span class="detail"><?php if($dat['order']['Order']['status']==0){ echo 'In Progress'; }else if($dat['order']['Order']['status']==1){ echo 'Delivered'; }else if($dat['order']['Order']['status']==3){ echo 'Expired'; }else{ echo 'Pending'; }?></span>
            </div>
             <div class="detail_row last">
            <label>Your Contribution: </label>
          	 <span class="detail"><?php echo 'INR '.$dat['order']['Order']['contri']; ?></span>
            </div>
            
            </div>
           
            <?php }}else{ ?>
             <div class="detail_row" style="width:100%; height:200px;">
            <div class="status">No Records Found!</div>
           
            </div>
            <?php } ?>
        
        
            </form>