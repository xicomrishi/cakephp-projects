<style>
.pop_up_detail form .row .sing_in{width:150px;}
</style>
<section class="tabing_container">		
	<section class="cms_page_detail">
        <div class="cart">
            <div class="left_sec" style="width:95%;">
            <h3>My Cart</h3> 
           	 <p></p> 
           <div class="error"><?php echo $this->Session->flash(); ?></div>
      
           <?php if(isset($data)){ 
		 
		  ?>
           <div class="row heading">
           <div class="col1"><h4>Description</h4></div>
           <div class="col2"><h4>Price</h4></div>  
           <div class="col3"><h4>Unit</h4></div>  
          </div>
          <div class="row">
           <div class="col1"><?php // echo "<p>".$data['Subscription']['title']."</p>";
			 echo $data['Subscription']['description'];?>
             <p>*Prices shown are in U.S. dollars.</p></div>
           <div class="col2"><?php echo "<p>$ ".$data['Subscription']['amount']."</p>";?></div>           
          <div class="col3" ><p>1</p></div> 
          </div>
        
         <div class="pop_up_detail" style="float:left;width:60%;">   
             <div class="row"><div id="error_login" class="error"></div> </div>
       <?php if($data['Subscription']['subscription_type']!='0'){ $formAction=SITE_URL.'/info/payments';$submitClass="submit";}else{$formAction=SITE_URL.'/info/trailAccount';$submitClass="sing_in";}?>      
    <form class="paypal" action="<?php echo $formAction;?>" method="post"  name="paypal_form" id="paypal_form">  
     <?php  if($data['Subscription']['pay_by']=='0'){?> 
        <input type="hidden" name="cmd" value="_xclick-subscriptions" />   
        <input type="hidden" name="src" value="1" />
        <input type="hidden" name="sra" value="2">       	     
        <input type="hidden" name="a3" value="<?php echo $data['Subscription']['amount'];?>" / >
        <input type="hidden" name="p3" value="1" / >
        <input type="hidden" name="t3" value="<?php if($data['Subscription']['subscription_type']==1) echo "M "; else echo "Y";?>" / >
    <?php  } else {?>
    	<input type="hidden" name="cmd" value="_xclick" /> 
        <input type="hidden" name="amount" value="<?php echo $data['Subscription']['amount'];?>" / >
        
      <?php  } ?>
      	<input type="hidden" name="no_shipping" value="1" /> 
         <input type="hidden" name="no_note" value="1" />
         <input type="hidden" name="lc" value="US" />
         <input type="hidden" name="currency_code" value="USD" />
        <input type="hidden" name="usertype" value="<?php  echo $data['Subscription']['subscription_for'];?>" />
        <input type="hidden" name="item_number" value="<?php echo $data['Subscription']['item_number'];?>" />
        <input type="hidden" name="item_name" value="<?php echo $data['Subscription']['title'];?>" / >
        <input type="hidden" name="account_id" id="account_id" value="<?php if(isset($client)) echo $client['account_id'];?>" / >  
        <?php if($data['Subscription']['subscription_type']=='0'){ ?>
        	<input type="hidden" name="user_trail" value="1" />
        <?php }?>
		<?php if(isset($client)) 
			{ $tempname = preg_replace('/\s+/', ' ', $client['name']);    //To replace multiple spaces with single space
				$name=explode(' ', $tempname); 
			} 
		?>
    <div class="row">
     	<label>First Name</label>
   		<input type="text" name="first_name" id="first_name" value="<?php if(isset($name)) echo $name[0]; ?>"  class="input required" <?php if(isset($name)) echo "readonly"; ?> />
    </div>
    <div class="row">
      	<label>Last Name</label>
    	<input type="text" name="last_name" id="last_name" value="<?php if(isset($name)) echo $name[1]; ?>"  class="input required" <?php if(isset($name[1]) && !empty($name[1])) echo "readonly"; ?>/>
    </div>
    <div class="row">
     	<label>E-mail</label>
    	<input type="text" name="email" id="email" value="<?php if(isset($client)) echo $client['email']; ?>"  class="input email required" <?php if(isset($client)) echo "readonly"; ?>/>
    </div>
    <div class="row">    
    	<input type="submit"  value="Create Trial Account" class="<?php echo $submitClass; ?>" />       
    </div>
</form>
<?php } ?>
           </div> 
        </div>       
	</section>     
</section> 
<script language="javascript">
$(document).ready(function(e) {	
	$('#paypal_form').validate({		
		submitHandler: function(form) {
			$('#error_login').hide();		
			$.post("<?php echo SITE_URL;?>/info/checkaccount",$('#paypal_form').serialize(),function(data){
				
				if(data!='' && !$.isNumeric(data))
				{					
					$('#error_login').html(data);	
					$('#error_login').show();	
					return false;
				}
				else
				{	if(data!='' && $.isNumeric(data)) $('#account_id').val(data);
					document.getElementById("paypal_form").submit();				
					return true;
				}
				});
		}		
	});
}); 
</script>