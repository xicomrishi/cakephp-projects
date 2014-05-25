<?php //echo $this->Html->script('jquery.validate.min');?>
<div id="contact_success" style="display:none;"></div>
<div id="error" style="display:none;"></div>
<section class="add_contact">
        <form id="AddContactForm" name="AddContactForm" method="post"  action="">
         <section class="contact_left">
         <input type="hidden" name="contactid" value="<?php if(isset($contactid)){ echo $contactid;}?>"/>
         <input type="hidden" id="edit_val" name="edit" value="<?php echo $edit; ?>"/>
         <input type="hidden" name="data[Contact][account_id]" value="<?php echo $account_id; ?>"/>
         <input type="text" id="c_name"  name="data[Contact][contact_name]" value="<?php if(isset($contact['contact_name'])) { echo $contact['contact_name']; }else{ echo 'Contact Name';} ?>" class="required" onblur="if(this.value=='')this.value='Contact Name'" onfocus="if(this.value=='Contact Name')this.value=''">
         <input type="text" name="data[Contact][email]" value="<?php if(isset($contact['email'])) { echo $contact['email']; }else{ echo 'E-mail Address';} ?>" class="required email" onblur="if(this.value=='')this.value='E-mail Address'" onfocus="if(this.value=='E-mail Address')this.value=''">
         <input type="text" name="data[Contact][phone]" value="<?php if(isset($contact['phone'])) { echo $contact['phone']; }else{ echo 'Phone';} ?>" onblur="if(this.value=='')this.value='Phone'" onfocus="if(this.value=='Phone')this.value=''">
         <input type="text" name="" value="<?php if(isset($contact['organization'])) { echo $contact['organization']; }else{ echo 'Organisation';} ?>" onblur="if(this.value=='')this.value='Organisation'" onfocus="if(this.value=='Organisation')this.value=''">
         <input type="text" name="data[Contact][organization]" value="<?php if(isset($contact['title'])) { echo $contact['title']; }else{ echo 'Title';} ?>" onblur="if(this.value=='')this.value='Title'" onfocus="if(this.value=='Title')this.value=''">
         <input type="text" name="data[Contact][referred_by]" value="<?php if(isset($contact['referred_by'])) { echo $contact['referred_by']; }else{ echo 'Reffered by';} ?>" onblur="if(this.value=='')this.value='Reffered by'" onfocus="if(this.value=='Reffered by')this.value=''">
         <?php if($edit=='1') { ?>
         	<h4><strong>ADDED:</strong> <?php echo show_formatted_datetime($contact['date_added']);?></h4>
         <?php } ?>
         </section>
          <section class="contact_right">
          <span class="cmn_row">
          <label>Frequency of Contact</label>
          <select name="data[Contact][frequency_of_contact]">
          <option value="Everyday" <?php if(isset($contact['frequency_of_contact'])){ if($contact['frequency_of_contact']=='Everyday'){ echo 'selected';}}?>>Everyday</option>
          <option value="Weekly" <?php if(isset($contact['frequency_of_contact'])){ if($contact['frequency_of_contact']=='Weekly'){ echo 'selected';}}?>>Weekly</option>
          <option value="Monthly" <?php if(isset($contact['frequency_of_contact'])){ if($contact['frequency_of_contact']=='Monthly'){ echo 'selected';}}?>>Monthly</option>
          <option value="Every six months" <?php if(isset($contact['frequency_of_contact'])){ if($contact['frequency_of_contact']=='Every six months'){ echo 'selected';}}?>>Every six months</option>
          <option value="Yearly" <?php if(isset($contact['frequency_of_contact'])){ if($contact['frequency_of_contact']=='Yearly'){ echo 'selected';}}?>>Yearly</option>
          </select>
          </span>
          <span class="cmn_row">
          <label>Type of Contact</label>
           <select name="data[Contact][type_of_contact]">
                  <option value="Immediate family" <?php if(isset($contact['type_of_contact'])){ if($contact['type_of_contact']=='Immediate family'){ echo 'selected';}}?>>Immediate family</option>
                  <option value="Extended family" <?php if(isset($contact['type_of_contact'])){ if($contact['type_of_contact']=='Extended family'){ echo 'selected';}}?>>Extended family</option>
                  <option value="Friend" <?php if(isset($contact['type_of_contact'])){ if($contact['type_of_contact']=='Friend'){ echo 'selected';}}?>>Friend</option>
                  <option value="Acquaintance" <?php if(isset($contact['type_of_contact'])){ if($contact['type_of_contact']=='Acquaintance'){ echo 'selected';}}?>>Acquaintance</option>
                  <option value="Work contact" <?php if(isset($contact['type_of_contact'])){ if($contact['type_of_contact']=='Work contact'){ echo 'selected';}}?>>Work contact</option>
                  <option value="School contact" <?php if(isset($contact['type_of_contact'])){ if($contact['type_of_contact']=='School contact'){ echo 'selected';}}?>>School contact</option>
                  <option value="Business contact" <?php if(isset($contact['type_of_contact'])){ if($contact['type_of_contact']=='Business contact'){ echo 'selected';}}?>>Business contact</option>
                  <option value="Professional" <?php if(isset($contact['type_of_contact'])){ if($contact['type_of_contact']=='Professional'){ echo 'selected';}}?>>Professional</option>
                  <option value="Association" <?php if(isset($contact['type_of_contact'])){ if($contact['type_of_contact']=='Association'){ echo 'selected';}}?>>Association</option>
                  <option value="Referred contact" <?php if(isset($contact['type_of_contact'])){ if($contact['type_of_contact']=='Referred contact'){ echo 'selected';}}?>>Referred contact</option>
                  <option value="Neighbor" <?php if(isset($contact['type_of_contact'])){ if($contact['type_of_contact']=='Neighbor'){ echo 'selected';}}?>>Neighbor</option>
                  <option value="Other" <?php if(isset($contact['type_of_contact'])){ if($contact['type_of_contact']=='Other'){ echo 'selected';}}?>>Other</option>
          </select>
          </span>
          <span class="cmn_row"><textarea rows="0" cols="0" name="data[Contact][information]" onblur="if(this.value=='')this.value='Information'" onfocus="if(this.value=='Information')this.value=''"><?php if(isset($contact['information'])) { echo $contact['information']; }else{ echo 'Information';} ?></textarea></span>
          <span class="cmn_row"><textarea rows="0" cols="0" name="data[Contact][address]" onblur="if(this.value=='')this.value='Address'" onfocus="if(this.value=='Address')this.value=''"><?php if(isset($contact['address'])) { echo $contact['address']; }else{ echo 'Address';} ?></textarea></span>
           <?php if($edit=='1') { ?>
         	 <h4><strong>modified:</strong><?php echo show_formatted_datetime($contact['date_modified']);?></h4>
         <?php } ?>
          </section>
          <span class="submit_row">
          <input type="submit" value="SAVE" class="save_btn" onclick="return save_contact();"/>
          <!--<a href="javascript://" onclick="save_contact();">SAVE</a>-->
          </span>
         </form>
        </section>
<script language="javascript">
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
				if(edit=='2')
				{	
					post_to='add_new_contact';
				}else{ post_to='edit_this_contact'; }
					$.post("<?php echo SITE_URL; ?>/contacts/"+post_to,$('#AddContactForm').serialize(),function(data){	
					$("#contact_success").html(data);
					$("#contact_success").show();
					document.getElementById('AddContactForm').reset();
					show_add_contact();
					
				});
				
			get_index_contacts();	
			$('#error').hide();
			return false;
			}
			
		});
}

</script>        