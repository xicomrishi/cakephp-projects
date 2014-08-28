<section class="submit_left <?php if(($this->Session->read('usertype')==3 && $note_type==1 ) || ($this->Session->read('usertype')==2 && $note_type==0) ||($this->Session->read('usertype')==1 && $note_type==0)){  echo 'full';} ?>">
<h4>Notes</h4>
<div class="nano" style="width:100% !important">
<div class="strategy_pop_up" style="width:100% !important">
 
<div class="all_notes <?php if(($this->Session->read('usertype')==3 && $note_type==1 ) || ($this->Session->read('usertype')==2 && $note_type==0)||($this->Session->read('usertype')==1 && $note_type==0) ){  echo 'full';} ?>">

</div>
</div>
</div>
  </section>
  
  
  <section class="submit_right">
     <form id="notes_textareaForm" name="notes_textareaForm" method="post" action="">
  	 <input type="hidden" id="notes_card_id" name="card_id" value="<?php echo $card_id;?>"/>
      <input type="hidden" id="card_column" name="card_column" value="<?php echo $card_column;?>"/>
      <input type="hidden" name="note_type" value="<?php echo $note_type;?>" id="note_type" />
      <?php if(($this->Session->read('usertype')==3 && $note_type==0 ) || ($this->Session->read('usertype')==2 && $note_type==1)){?>
  

     <textarea id="notes_jobseeker" name="note_text"></textarea>
      <a href="javascript://" onclick="submit_note();" class="save_btn2">SAVE</a>
 
   
   
 
        <?php } ?> 
         </form>             <?php if(!$this->Session->check('Coach')){ ?> <p class="coach_not_linked" style="position:absolute; top:85px; width:100%; text-align:center; font-size:18px; line-height:20px; color:#757575;  font-family:'onduititc'; font-weight:normal"></p> <?php } ?>
  </section>     
<script type="text/javascript">
$(document).ready(function(e) {
	var cardid=$('#notes_card_id').val();
	var col=$('#card_column').val();
	
    get_notes(cardid,col);
	$('.nano').nanoScroller({alwaysVisible: false, contentClass: 'strategy_pop_up'});
});

function get_notes(card_id,col)
{
	//alert(col);
	$.post('<?php echo SITE_URL;?>/jobcards/get_notes/',{card_id:card_id,column_status:col,note_type:<?php echo $note_type;?>},function(data){
			$('.all_notes').html(data);
		});	
}

function submit_note()
{	var cardid=$('#notes_card_id').val();
var col=$('#card_column').val();
	var text=$('#notes_jobseeker').val();
	if(text==''){
		}else{
	$.post('<?php echo SITE_URL;?>/jobcards/save_notes',$('#notes_textareaForm').serialize(),function(data){
			  get_notes(cardid,col);
			  
		});	
		setTimeout(function(){ $('.nano').nanoScroller({alwaysVisible: false, contentClass: 'strategy_pop_up'});},2000);
	document.getElementById('notes_textareaForm').reset();
		}
}


</script>