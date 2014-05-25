<style>
.success_msg{ color: #009900;}
</style>
<div class="tab_details">
<div class="success_msg">Congratulations!<br>
	<?php if($data['Recharge']['recharge_type']=='4'){ ?>
    	Bill Payment done successfully. Following are details:<br>
        Mobile Number: <?php echo $data['Recharge']['number']; ?><br>
        Operator: <?php echo $operator['Operator']['name']; ?><br>
        Amount: INR <?php echo $data['Recharge']['amount']; ?>
        
    <?php }else if($data['Recharge']['recharge_type']=='5'){ ?>
    
    	Bill Payment done successfully. Following are details:<br>
        Account Number: <?php echo $data['Recharge']['number']; ?><br>
        Service Provider: <?php echo $operator['Operator']['name']; ?><br>
        Amount: INR <?php echo $data['Recharge']['amount']; ?>
        
     <?php }else if($data['Recharge']['recharge_type']=='6'){ ?>
     
    	Bill Payment done successfully. Following are details:<br>
        Phone Number: <?php echo $data['Recharge']['number']; ?><br>
        Operator: <?php echo $operator['Operator']['name']; ?><br>
        Amount: INR <?php echo $data['Recharge']['amount']; ?>
        
     <?php }else if($data['Recharge']['recharge_type']=='7'){ ?>
     
    	Bill Payment done successfully. Following are details:<br>
        Consumer Number: <?php echo $data['Recharge']['number']; ?><br>
        Service Provider: <?php echo $operator['Operator']['name']; ?><br>
        Amount: INR <?php echo $data['Recharge']['amount']; ?>
        
     <?php }else if($data['Recharge']['recharge_type']=='8'){ ?>
     
    	Bill Payment done successfully. Following are details:<br>
        Policy Number: <?php echo $data['Recharge']['number']; ?><br>
        Service Provider: <?php echo $operator['Operator']['name']; ?><br>
        Amount: INR <?php echo $data['Recharge']['amount']; ?>
     
    <?php }else{ ?>    
		Recharge of INR <?php echo $data['Recharge']['amount']; ?> done successfully on this number: <?php echo $data['Recharge']['number']; ?>    
    <?php } ?>
</div>
</div>
