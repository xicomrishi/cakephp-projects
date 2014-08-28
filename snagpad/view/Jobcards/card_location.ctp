<div class="nano">
  
  <form id="cardDetailForm" name="cardDetailForm" method="post" action="">
  <fieldset>
  
  <section class="form_section">
  <section class="form_box">
  <section class="form_row"><label>Country</label><b class="click_country" id="country|<?php echo $card['Card']['id'];?>"><?php if(!empty($card['Card']['country'])) { echo $card['Card']['country']; }else{ echo 'NA'; } ?></b></section>
  <section class="form_row"><label>State</label><b class="click" id="state|<?php echo $card['Card']['id'];?>"><?php if(!empty($card['Card']['state'])) { echo $card['Card']['state']; }else{ echo 'NA'; } ?></b></section>
  <section class="form_row"><label>City</label><b class="click" id="city|<?php echo $card['Card']['id'];?>"><?php if(!empty($card['Card']['city'])) { echo $card['Card']['city']; }else{ echo 'NA'; } ?></b></section>
  
  </section>
  
  <section class="form_box">
 
  </section>
  </section>
  </fieldset>
  </form>
  </div>
<script type="text/javascript">
$(document).ready(function(){
 
 $('.click_country').editable("<?php echo SITE_URL; ?>/jobcards/update_card_country", { 
     loadurl   : "<?php echo SITE_URL; ?>/jobcards/country_list",
   	 cssclass : 'editable',
	 indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
	 type   : 'select',
	 event		:	"click",
     tooltip   : "Click to edit...",
      style  	: "inherit",
	  onblur 	: 'submit'

 });
 
   $('.click').editable("<?php echo SITE_URL; ?>/jobcards/update_card", { 
    cssclass : 'editable',
	indicator : '<?php echo $this->Html->image('loading.gif',array('alt'=>'loading...'));?>',
	 event		:	"click",
     tooltip   : "Click to edit...",
      style  	: "inherit",
	  onblur 	: 'submit'
 });
 
});
</script>  