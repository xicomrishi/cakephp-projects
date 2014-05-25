<?php //echo $this->Html->script('jquery.validate.min');?>
<section class="tabing_container">
<section class="top_sec" style="width:772px; background:none; padding:30px 0 0 14px">
<div id="contact_success" style="display:none;"></div>
<div id="error" style="display:none;"></div>
<section class="add_contact">
        <form id="AddContactForm" name="AddContactForm" method="post"  action="">
         <section class="contact_left">
         <input type="hidden" id="cardid" name="cardid" value="<?php echo $card_id?>"/>
         <input type="hidden" name="contactid" value="<?php if(isset($contactid)){ echo $contactid;}?>"/>
         
         <input type="hidden" name="data[Contact][account_id]" value="<?php echo $account_id; ?>"/>
         <input type="text" id="c_name" name="data[Contact][contact_name]" value="<?php echo 'Contact Name'; ?>" class="required" onblur="if(this.value=='')this.value='Contact Name'" onfocus="if(this.value=='Contact Name')this.value=''">
         <input type="text" name="data[Contact][email]" value="<?php echo 'E-mail Address'; ?>" class="required email" onblur="if(this.value=='')this.value='E-mail Address'" onfocus="if(this.value=='E-mail Address')this.value=''">
         <input type="text" name="data[Contact][phone]" value="<?php echo 'Phone'; ?>" onblur="if(this.value=='')this.value='Phone'" onfocus="if(this.value=='Phone')this.value=''">
         <input type="text" name="data[Contact][organization]" value="<?php echo 'Organization'; ?>" onblur="if(this.value=='')this.value='Organization'" onfocus="if(this.value=='Organization')this.value=''">
         <input type="text" name="data[Contact][title]" value="<?php echo 'Title'; ?>" onblur="if(this.value=='')this.value='Title'" onfocus="if(this.value=='Title')this.value=''">
         <input type="text" name="data[Contact][referred_by]" value="<?php echo 'Referred by'; ?>" onblur="if(this.value=='')this.value='Referred by'" onfocus="if(this.value=='Referred by')this.value=''">
        
         </section>
          <section class="contact_right" style="width:499px;">
          <span class="cmn_row">
          <label style="width:297px;">Frequency of Contact</label>
          <select name="data[Contact][frequency_of_contact]">
          <option value="Everyday">Everyday</option>
          <option value="Weekly">Weekly</option>
          <option value="Monthly">Monthly</option>
          <option value="Every six months">Every six months</option>
          <option value="Yearly">Yearly</option>
          </select>
          </span>
          <span class="cmn_row">
          <label style="width:297px;">Type of Contact</label>
           <select name="data[Contact][type_of_contact]">
                  <option value="Immediate family">Immediate family</option>
                  <option value="Extended family">Extended family</option>
                  <option value="Friend">Friend</option>
                  <option value="Acquaintance">Acquaintance</option>
                  <option value="Work contact">Work contact</option>
                  <option value="School contact">School contact</option>
                  <option value="Business contact">Business contact</option>
                  <option value="Professional">Professional</option>
                  <option value="Association">Association</option>
                  <option value="Referred contact">Referred contact</option>
                  <option value="Neighbor">Neighbor</option>
                  <option value="Other">Other</option>
          </select>
          </span>
          <span class="cmn_row"><textarea rows="0" cols="0" name="data[Contact][information]" onblur="if(this.value=='')this.value='Information'" onfocus="if(this.value=='Information')this.value=''" style="float:right; width:395px;"><?php echo 'Information'; ?></textarea></span>
          <span class="cmn_row"><textarea rows="0" cols="0" name="data[Contact][address]" onblur="if(this.value=='')this.value='Address'" onfocus="if(this.value=='Address')this.value=''" style="float:right; width:395px;"><?php echo 'Address'; ?></textarea></span>
          
          </section>
          <span class="submit_row">
          <input type="submit" value="SAVE" onclick="return save_contact();"/>
          <!--<a href="javascript://" onclick="save_contact();">SAVE</a>-->
          </span>
         </form>
        </section>
         </section>
          </section>
<script language="javascript">
$(document).ready(function(e) {
     $("html, body").animate({ scrollTop: 0 }, 600);
	
});
$('#error').hide();
function save_contact()
{
	
	$("#AddContactForm").validate({
			submitHandler: function(form) { 
			var c_name=$('#c_name').val();
				//alert(c_name);
				if(c_name=='Contact Name')
				{
					$('#error').html('Please enter contact name.');
					$('#error').show();
					return false;
				}
				var post_to=null;
				var edit=$('#edit_val').val();
					$.post("<?php echo SITE_URL; ?>/jobcards/save_contact",$('#AddContactForm').serialize(),function(data){	
					if(data=='Error')
					{
						$("#contact_success").html('A contact with this email ID already exist.');
						$("#contact_success").show();
					}else{
						
						var card_id=$('#cardid').val();
						show_card_contact(data,card_id);
						disablePopup();
						$("html, body").animate({ scrollTop: $('.row_'+card_id).offset().top - 80}, 100);	
						}
					
					
					
					
				});
			
			
				
			$('#error').hide();	
			return false;
			}
			
		});
}

</script>        