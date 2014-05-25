<div class="nano">
  
  <form id="cardDetailForm" name="cardDetailForm" method="post" action="">
  <fieldset>
  <input type="hidden" id="cardid" value="<?php echo $card['Card']['id'];?>"/>
  <section class="form_section">
  <section class="form_box"  style="width:908px; margin:0px  !important; padding:0 0 0 40px">
  <div class="add_contact"><a href="javascript://" onclick="loadPopup('<?php echo SITE_URL; ?>/jobcards/show_add_contact');">Add new contact</a></div>
  
  <div class="select_con">
  <label>Select existing contact</label>
  <select name="contact_id" onchange="show_card_contact(this.value,'<?php  echo $card['Card']['id'];?>');">
  	<option value="">----------</option>
	<?php foreach($all_contacts as $cont) { ?>
    	<option value="<?php echo $cont['Contact']['id']; ?>"><?php echo $cont['Contact']['email'];?></option>
    <?php } ?>
  </select>
  </div>
 <div id="info_contact">
        <div class="title_row">
        <span class="column1">TILE</span>
        <span class="column2 text_indent">E-MAIL</span>
        <span class="column3">ADDED</span>
        <span class="column4">MODIFIED</span></div>
        
        <div class="comon_row">
        <span class="column1 colour1 bold"><small>John Doe</small></span>
        <span class="column2 colour2"><a href="mailto:john.doe@gmail.com">john.doe@gmail.com</a></span>
        <span class="column3 colour3">August 14, 2012<br>05:02 AM</span>
        <span class="column4 colour3">August 22, 2012<br>10:02 PM</span></div>
 </div>
  
 
 
  </section>
  
  <section class="form_box">
 
  </section>
  </section>
  </fieldset>
  </form>
  </div>
<script type="text/javascript">

function show_card_contact(contact_id,cardid)
{
	
	$.post('<?php echo SITE_URL;?>/jobcards/show_card_contact_info',{cont_id:contact_id,card_id:cardid},function(data){
		
		$('#info_contact').html(data);
		});
}


</script>  