  <form id="cardDetailForm" name="cardDetailForm" method="post" action="">
  <fieldset>
  <input type="hidden" id="cardid" value="<?php echo $card['Card']['id'];?>"/>
  <section class="form_section">
  <section class="form_box"  style="width:908px; margin:0px  !important; padding:0 0 0 40px">
   <?php if($this->Session->read('usertype')=='3'){?> 

  <div class="add_contact"><a href="javascript://" onclick="loadPopup('<?php echo SITE_URL; ?>/jobcards/show_add_contact');">Add new contact</a></div>
  <div class="select_con">
  <label>Select existing contact</label>
  <select id="select_contacts" name="contact_id" onchange="show_card_contact(this.value,'<?php  echo $card['Card']['id'];?>');">
  	<option id="val_0" value="">Select</option>
	<?php foreach($all_contacts as $cont) { 
		if(!in_array($cont['Contact']['id'],$a_cont_arr_id)) {
	?>
    	<option id="val_<?php echo $cont['Contact']['id'];?>" value="<?php echo $cont['Contact']['id']; ?>"><?php echo $cont['Contact']['email'];?></option>
    <?php }} ?>
  </select>
  </div>
  <?php }?>
 <div id="info_contact">
        <div class="title_row">
        <span class="column1">TITLE</span>
        <span class="column2 text_indent">E-MAIL</span>
        <span class="column3">ADDED</span>
        <span class="column4">MODIFIED</span></div>
         <div class="nano">
        <div class="show_card_contact" style="height:106px; overflow:hidden;">
       
         <?php foreach($a_cont as $cont) { ?>
        <div class="comon_row">
       
        <span class="column1 colour1 bold"><small><?php echo $cont['Contact']['contact_name'];?></small></span>
        <span class="column2 colour2"><a href="mailto:<?php echo $cont['Contact']['email'];?>"><?php echo $cont['Contact']['email'];?></a></span>
        <span class="column3 colour3"><?php echo show_formatted_datetime($cont['Contact']['date_added']); ?></span>
        <span class="column4 colour3"><?php echo show_formatted_datetime($cont['Contact']['date_modified']); ?></span>
        
        </div>
        <?php } ?>
        </div>
        </div>
 </div>
  
 
 
  </section>
  
  <section class="form_box">
 
  </section>
  </section>
  </fieldset>
  </form>
 
<script type="text/javascript">
$(document).ready(function(e) {
   $('.nano').nanoScroller({alwaysVisible: true, contentClass: 'show_card_contact'});
});
function show_card_contact(contact_id,cardid)
{
	//alert(contact_id);
	$.post('<?php echo SITE_URL;?>/jobcards/show_card_contact_info',{cont_id:contact_id,card_id:cardid},function(data){
		
		$('.show_card_contact').append(data);
		$('#val_'+contact_id).remove();
		 $('.nano').nanoScroller({alwaysVisible: true, contentClass: 'show_card_contact'});
	});
}


</script>  