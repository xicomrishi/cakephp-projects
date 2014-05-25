<div id="form_section" style="margin:0 0 5px 0; padding:0 1%;">
<span class="select_dele">/ / Edit <strong> Details</strong></span>
<form id="editStatusPage" name="editStatusPage" method="post" action="" onSubmit="return update_status_page();">
<input type="hidden" name="order_id" value="<?php echo $order['Order']['id']; ?>"/>
<div class="comn_box recipient">
            <div class="main_heading"><span>About the <strong>Recipient</strong></span> </div>
            <div class="detail_row">
            <label>Name:</label>
            <span class="detail"><input type="text"  name="to_name" value="<?php echo $order['Order']['to_name']; ?>" class="validate[required]"/></span>
            </div>
            <div class="detail_row">
            <label>Delivery e-mail id:</label>
            <span class="detail"><input type="text"  name="to_email" value="<?php echo $order['Order']['to_email'];  ?>" class="validate[required,custom[email]]"/></span>
            </div>
            <div class="detail_row last">
            <label>Delivery Mobile No.:</label>
            <span class="detail"><input type="text"  name="to_phone" maxlength="10" value="<?php echo $order['Order']['to_phone']; ?>" class="validate[required,custom[integer],minSize[10],maxSize[10]]"/></span>
            </div>
            </div>
         <input type="submit" class="done" value="submit" onClick="return update_status_page();"/>   
</form>


</div>
<script type="text/javascript">
$(document).ready(function(e) {
     $("#editStatusPage").validationEngine({promptPosition: "topLeft",scroll:false,focusFirstField : false});
});
</script>